<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Order extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('my_account_model');
        $this->load->model('products_model');
        $this->load->model('order_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->load->library('user_agent'); 
    }
    public function getOrderDetails(){
    	$data = $this->order_model->getOrderDetails();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getOrderStatus(){
        $data = $this->order_model->getOrderStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function showAll(){
        $row_no= $this->input->get('page_no');
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->order_model->getOrdersCount();

        // Get records
        $products = $this->order_model->getAllOrdersData($row_per_page, $row_no);

        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/orders/_get_all');
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $all_count;
        $config['per_page'] = $row_per_page;

        // Pagination with bootstrap
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page_no';
        $config['full_tag_open'] = '<ul class="pagination btn-xs">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item ">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $config['next_link'] = 'Next'; // change > to 'Next' link
        $config['prev_link'] = 'Previous'; // change < to 'Previous' link

        // Initialize
        $this->pagination->initialize($config);

        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $products;
        $data['row'] = $row_no;
        $data['count'] = $all_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    public function getOrderDetailsAdmin(){
        $data = $this->order_model->getOrderDetailsAdmin();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function updateOrderStatus(){
        $status = $this->input->post('status');
        $order_id = $this->input->post('order_id');

        if (!isset($this->session->user_id)) {
            $response['status'] = 'failed';
            $response['message'] = "Action not allowed!";
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
            return false;
        }


        if (empty($status) && $status == '') {
            $response['status'] = 'failed';
            $response['message'] = "Please select an Order Status!";
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
            return false;
        }

        if ($status == 'shipped') {
            $courier = $this->input->post('courier');
            $tracking_number = $this->input->post('tracking_number');
            $checkShipData = $this->db->WHERE('order_id',$order_id)->GET('shipping_courier_tbl')->row_array();

            if(isset($checkShipData)){
                $ship_data = array(
                    'courier'=>$courier,
                    'tracking_number'=>$tracking_number,
                );  
                $this->db->WHERE('order_id', $order_id)->UPDATE('shipping_courier_tbl', $ship_data);
                $dataStat = array(
                    'status'=>$status,
                    'updated_at'=>date('Y-m-d H:i:s')
                );
                $this->db->WHERE('order_id', $order_id)->UPDATE('order_tbl', $dataStat);

                $activity = ucwords($status);
                $this->order_model->shipmentTracking($order_id, $activity); /* insert shipment track details*/

                $logs = array('order_id'=>$order_id, 'activity'=>'Order Status updated to '.ucwords($status).' by '.$this->session->username );
                $this->order_model->insertOrderEventLogs($logs);
            }
            else{
                $ship_data = array(
                    'order_id'=>$order_id,
                    'courier'=>$courier,
                    'tracking_number'=>$tracking_number,
                );
                $this->db->INSERT('shipping_courier_tbl', $ship_data);
                $data = array(
                    'status'=>$status,
                    'updated_at'=>date('Y-m-d H:i:s')
                );
                $this->db->WHERE('order_id', $order_id)->UPDATE('order_tbl', $data);

                $activity = ucwords($status);
                $this->order_model->shipmentTracking($order_id, $activity); /* insert shipment track details*/

                $logs = array('order_id'=>$order_id, 'activity'=>'Order Status updated to '.ucwords($status).' by '.$this->session->username );
                $this->order_model->insertOrderEventLogs($logs);
            }
            $this->order_model->sendOrderShippedEmailNotification($order_id, $courier, $tracking_number);
            $response['status'] = 'success';
            $response['message'] = 'Order Status updated to '.$status.'!';

        }
        else if ($status == 'delivered') {
            $checkOrderData = $this->db->WHERE('order_id', $order_id)->GET('order_tbl')->row_array();

            if ($checkOrderData['status'] == 'delivered') {
                $response['status'] = 'failed';
                $response['message'] = 'Order Status is already Delivered and complete!';
                $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
                return false;
            }
            else{
                $dataStat = array(
                    'status'=>$status,
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'completed_at'=>date('Y-m-d H:i:s'),
                );
                $this->db->WHERE('order_id', $order_id)
                    ->UPDATE('order_tbl', $dataStat);
                $response['status'] = 'success';
                $response['message'] = 'Order Status updated to '.$status.' and is now Complete!';

                /* UPDATE PAYMENT TO PAID */ 
                 $this->order_model->changePaymentStatus($order_id);

                /* INSERT UNILEVEL POINTS TO YOURSELF */ 
                 $this->products_model->insertUnilevelAfterShopPurchase($order_id);

                $activity = ucwords($status);
                $this->order_model->shipmentTracking($order_id, $activity); /* insert shipment track details*/

                $logs = array('order_id'=>$order_id, 'activity'=>'Order Status updated to '.ucwords($status).' by '.$this->session->username );
                $this->order_model->insertOrderEventLogs($logs);

                $this->order_model->sendOrderDeliveredEmailNotification($order_id);
            }

        }
        else{
            $dataStat = array(
                'status'=>$status,
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $this->db->WHERE('order_id', $order_id)
                ->UPDATE('order_tbl', $dataStat);
            $response['status'] = 'success';
            $response['message'] = 'Order Status updated to '.$status.'!';

            $activity = ucwords($status);
            $this->order_model->shipmentTracking($order_id, $activity); /* insert shipment track details*/

            $logs = array('order_id'=>$order_id, 'activity'=>'Order Status updated to '.ucwords($status).' by '.$this->session->username );
            $this->order_model->insertOrderEventLogs($logs);
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function showUserOrders(){
        $row_no=$this->input->get('page_no');
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->order_model->getAllOrdersDataCount();

        // Get records
        $products = $this->order_model->getAllUserOrdersData($row_per_page, $row_no);

        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/order/_get_user_orders');
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $all_count;
        $config['per_page'] = $row_per_page;

        // Pagination with bootstrap
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page_no';
        $config['full_tag_open'] = '<ul class="pagination btn-xs">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item ">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $config['next_link'] = 'Next'; // change > to 'Next' link
        $config['prev_link'] = 'Previous'; // change < to 'Previous' link

        // Initialize
        $this->pagination->initialize($config);

        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $products;
        $data['row'] = $row_no;
        $data['count'] = $all_count;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    
}
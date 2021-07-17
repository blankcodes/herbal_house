<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	/*
	* $this->session->temp_user_id is a non-member/disributor, a visitor who added to cart.
	*/ 
	public function checkOrderRefNo($ref_no) {
		return $this->db->WHERE('reference_no', $ref_no)->GET('order_tbl')->num_rows();
	}
	public function getOrderStatus() {
		if(isset($this->session->user_id)){
			return $this->db->SELECT('status')->WHERE('reference_no', $this->input->get('reference_no'))
				->GET('order_tbl')->row_array();
		}
	}
	public function getOrderDetails(){
		$orderData = $this->db->WHERE('reference_no', $this->input->get('ref_no'))
			->GET('order_tbl')->row_array();

		$data['reference_no'] = $orderData['reference_no'];
		$data['payment_method'] = $orderData['payment_method'];
		$data['status'] = $orderData['status'];
		$data['billing_info'] = $this->getBillingInfo($orderData['bi_id']) ;
		$data['shipping_info'] = $this->getShippingInfo($orderData['si_id']);
		$data['order_cart'] = $this->orderedCart($orderData['order_id']);
		$data['order_amount'] = $this->orderedAmount($orderData['order_id'], $orderData['shipping_fee']);
		$data['ship_order_track'] = $this->shipOrderTrack($orderData['order_id']);
		$data['ship_courier'] = $this->shipCourierData($orderData['order_id']);
		$data['order_created'] = date('F d, Y, h:i A', strtotime($orderData['created_at']));
		return $data;
	}
	public function getOrderDetailsAdmin(){
		$orderData = $this->db->WHERE('reference_no', $this->input->get('ref_no'))
			->GET('order_tbl')->row_array();

		$data['order_id'] = $orderData['order_id'];
		$data['reference_no'] = $orderData['reference_no'];
		$data['payment_method'] = $orderData['payment_method'];
		$data['status'] = $orderData['status'];
		$data['billing_info'] = $this->getBillingInfo($orderData['bi_id']) ;
		$data['shipping_info'] = $this->getShippingInfo($orderData['si_id']);
		$data['order_cart'] = $this->orderedCart($orderData['order_id']);
		$data['order_amount'] = $this->orderedAmount($orderData['order_id'], $orderData['shipping_fee']);
		$data['ship_order_track'] = $this->shipOrderTrack($orderData['order_id']);
		$data['ship_courier'] = $this->shipCourierData($orderData['order_id']);
		$data['event_logs'] = $this->eventLogs($orderData['order_id']);
		$data['order_created'] = date('F d, Y, h:i A', strtotime($orderData['created_at']));
		return $data;
	}
	public function getBillingInfo($bi_id) {
		$q = $this->db->WHERE('bi_id', $bi_id)->GET('billing_info_tbl')->row_array();

		$result['full_name'] = $q['fname'].' '.$q['lname'];
		$result['email_address'] = $q['email_address'];
		$result['phone'] = $q['phone_number'];
		$result['address'] = $q['full_address'].', '.$q['city'].' '.$q['state'].', '.$q['zip_code'].', '.$q['country'];
		return $result;
	}
	public function getShippingInfo($si_id) {
		$q = $this->db->WHERE('si_id', $si_id)->GET('shipping_info_tbl')->row_array();

		$result['full_name'] = $q['fname'].' '.$q['lname'];
		$result['email_address'] = $q['email_address'];
		$result['phone'] = $q['phone_number'];
		$result['address'] = $q['full_address'].', '.$q['city'].' '.$q['state'].', '.$q['zip_code'].', '.$q['country'];
		return $result;
	}
	public function orderedCart($order_id) {
		$query = $this->db->SELECT('pt.name, pt.image, st.price, st.qty, pt.url')
			->FROM('sales_tbl as st')
			->JOIN('products_tbl as pt', 'pt.p_id = st.p_id')
			->WHERE('st.order_id', $order_id)
			->GET()->result_array();
		$result = array();
		$grand_total = 0;
		$total_price_per_product = 0;
		foreach ($query as $q) {
			$total_price_per_product = $q['price'] * $q['qty'];
    		$grand_total += $total_price_per_product;
			$arr = array(
				'product_name'=> strlen($q['name']) > 40 ? substr($q['name'], 0, 37).'...' : $q['name'],
				'product_image'=> base_url().$q['image'],
				'price'=> number_format($q['price'], 2),
				'qty'=> $q['qty'],
				'total'=>number_format($total_price_per_product, 2),
				'product_url'=> base_url('product/').$q['url'],
			);
			array_push($result, $arr);
		}
		return $result;
	}
	public function orderedAmount($order_id, $shipping_fee) {
		$query = $this->db->SELECT('price, qty')
			->WHERE('order_id', $order_id)
			->GET('sales_tbl')->result_array();

		$total = 0;
		$grand_total = 0;
		$total_price_per_product = 0;
		foreach ($query as $q) {
			$total_price_per_product = $q['price'] * $q['qty'];
    		$grand_total += $total_price_per_product;
		}
		$total = $grand_total + $shipping_fee;
		$result['grand_total'] = number_format($grand_total, 2);
		$result['shipping'] = number_format($shipping_fee, 2);
		$result['total'] = number_format($total , 2); /* temp total*/
		return $result;
	}
	public function shipOrderTrack($order_id) {
		$query = $this->db->WHERE('order_id', $order_id)->GET('shipment_track_tbl')->result_array();

		$result = array();
		foreach($query as $q){
			$array = array(
				'order_id'=>$q['order_id'],
				'activity'=> $q['activity_log'],
				'date'=> date('m/d/Y h:i A', strtotime($q['created_at'])),
			);
			array_push($result, $array);
		}
		return $result;
	}
	public function shipCourierData($order_id) {
		$query = $this->db->WHERE('order_id', $order_id)->GET('shipping_courier_tbl')->row_array();

		$result['courier'] = $query['courier'];
		$result['tracking_number'] = $query['tracking_number'];
		
		return $result;
	}
	public function getOrdersCount () {
    	if ($this->session->user_type == 'admin') {
    		return $this->db->GET('order_tbl')->num_rows();
		}
    }
    public function getAllOrdersData ($row_per_page, $row_no) {
    	if ($this->session->user_type == 'admin') {
    		$query = $this->db->SELECT('ot.*, pmt.payment_ref_no, pmt.status as payment_status')
	    		->FROM('order_tbl as ot')
	    		->JOIN('payment_tbl as pmt', 'pmt.order_id=ot.order_id', 'left')
				->ORDER_BY('ot.created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				if (isset($q['referrer'])) {
					$referrer = $this->db->SELECT('user_code, username')->WHERE('username', $q['referrer'])->GET('user_tbl')->row_array();
				}
				$userData = $this->db->SELECT('user_code, username')->WHERE('user_id', $q['user_id'])->GET('user_tbl')->row_array();
				$array = array(
					'order_id'=>$q['order_id'],
					'reference_no'=> $q['reference_no'],
					'payment_ref_no'=> $q['payment_ref_no'],
					'payment_status'=> $q['payment_status'],
					'bi_id'=>$q['bi_id'],
					'si_id'=>$q['si_id'],
					'total_revenue'=>number_format($q['total_revenue'], 2),
					'payment_method'=>$q['payment_method'],
					'note'=>$q['note'],
					'referrer'=>($referrer) ? ucwords($referrer['username']) : 'None',
					'referrer_overview'=>($referrer) ? base_url().'user/overview/'.$referrer['user_code'] : '#referrer_overview',
					'member'=>($userData ) ? ucwords($userData['username']) : 'None',
					'member_overview'=>($userData) ? base_url().'user/overview/'.$userData['user_code'] : '#user_overview',
					'status'=>$q['status'],
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
    }
    public function getAllOrdersDataCount () {
    	if (isset($this->session->user_id)) {
    		return $this->db->SELECT('ot.*, pmt.payment_ref_no, pmt.status as payment_status')
	    		->FROM('order_tbl as ot')
	    		->JOIN('payment_tbl as pmt', 'pmt.order_id=ot.order_id', 'left')
				->WHERE('referrer', $this->session->username)
				->GET()->num_rows();
			}
    }

    public function getAllUserOrdersData ($row_per_page, $row_no) {
    	if (isset($this->session->user_id)) {
    		$query = $this->db->SELECT('ot.*, pmt.payment_ref_no, pmt.status as payment_status')
	    		->FROM('order_tbl as ot')
	    		->JOIN('payment_tbl as pmt', 'pmt.order_id=ot.order_id', 'left')
				->ORDER_BY('ot.created_at', 'DESC')
				->WHERE('ot.referrer', $this->session->username)
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'order_id'=>$q['order_id'],
					'reference_no'=> $q['reference_no'],
					'payment_ref_no'=> $q['payment_ref_no'],
					'payment_status'=> $q['payment_status'],
					'bi_id'=>$q['bi_id'],
					'si_id'=>$q['si_id'],
					'total_revenue'=>number_format($q['total_revenue'], 2),
					'payment_method'=>$q['payment_method'],
					'note'=>$q['note'],
					'status'=>$q['status'],
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
    }

    public function updateOrderStatus(){
    	
    }
    public function shipmentTracking($order_id, $activity ) {
    	$data = array(
    		'order_id'=>$order_id,
    		'activity_log'=>$activity,
    		'created_at'=>date('Y-m-d H:i:s'),
    	);
    	$this->db->INSERT('shipment_track_tbl', $data);
    }
    public function insertOrderEventLogs($logs){
		$this->db->INSERT('order_events_tbl', $logs);
	}
	public function eventLogs($order_id) {
		$query = $this->db->WHERE('order_id',$order_id)->ORDER_BY('created_at','desc')->GET('order_events_tbl')->result_array();
		$result = array();

		foreach($query as $q){
			$array = array(
				'activity'=>$q['activity'],
				'date'=>date('m/d/Y h:i:s A', strtotime($q['created_at'])),
			);
			array_push($result, $array);
		}
		return $result;
	}
	public function getSuccessOrdersCount(){
		if (isset($this->session->admin)) {
			return $this->db->WHERE('status','delivered')->OR_WHERE('status','shipped')->GET('order_tbl')->num_rows();
		}
	}
	public function getOrderTodo(){
		if (isset($this->session->admin)) {
			return $this->db->WHERE('status','packed')->OR_WHERE('status','created')->GET('order_tbl')->num_rows();
		}
	}
	public function getYourOrderTodo(){
		if (isset($this->session->user_id)) {
			return $this->db->WHERE('referrer',$this->session->username)->WHERE('status','packed')->OR_WHERE('status','created')->GET('order_tbl')->num_rows();
		}
	}

	public function getOrdersTodayCount(){
		if (isset($this->session->admin)) {
			$today_start = date('Y-m-d 00:00:01');
			$today_end = date('Y-m-d 23:59:59');
			$date_range = array('created_at >'=>$today_start, 'created_at <'=> $today_end);
			return $this->db->WHERE($date_range)->GET('order_tbl')->num_rows();
		}
	}
	public function changePaymentStatus($order_id) {
		$orderArr = array(
			'status'=>'paid',
			'payment_ref_no'=>'COD',
			'updated_at'=> date('Y-m-d H-i:s')
		);
    	$this->db->WHERE('order_id', $order_id)->UPDATE('payment_tbl', $orderArr);
    }
    public function sendOrderShippedEmailNotification($order_id, $courier, $tracking_number) {
		$orderData = $this->getOrderData($order_id);
		
		$config = array (
			'mailtype' => 'html',
			'charset'  => 'utf-8',
			'priority' => '1'
		);
		$total = $orderData['total_amount'] + $orderData['shipping_fee'];
		$order_date = date('F d, Y, h:i A', strtotime($orderData['ordered_date']));
		$data['header_image'] = base_url().'assets/images/herbal-house-logo.png';
		$data['header_image_url'] = base_url().'?utm_source=herbalhouse&utm_medium=order_confirmation&utm_campaign=email';
		$data['name'] = $orderData['fname'].' '.$orderData['lname'];
		$data['email_address'] = $orderData['email_address'];
		$data['reference_no'] = $orderData['reference_no'];
		$data['courier'] = $courier;
		$data['tracking_number'] = $tracking_number;
		$data['order_details'] = base_url('order/').$orderData['reference_no'];

		$this->email->initialize($config);
		$this->email->from('no-reply@herbalhouseph.com', 'Herbal House Philippines');
		$this->email->to($orderData['email_address']);
		$this->email->subject('A shipment from order #'.$orderData['reference_no'].' is on the way!');
		$body = $this->load->view('email/order_shipped_notification', $data, TRUE);
		$this->email->message($body);
		$this->email->send();
	}
	public function sendOrderDeliveredEmailNotification($order_id) {
		$orderData = $this->getOrderData($order_id);
		
		$config = array (
			'mailtype' => 'html',
			'charset'  => 'utf-8',
			'priority' => '1'
		);
		$total = $orderData['total_amount'] + $orderData['shipping_fee'];
		$order_date = date('F d, Y, h:i A', strtotime($orderData['ordered_date']));
		$data['header_image'] = base_url().'assets/images/herbal-house-logo.png';
		$data['header_image_url'] = base_url().'?utm_source=herbalhouse&utm_medium=order_confirmation&utm_campaign=email';
		$data['name'] = $orderData['fname'].' '.$orderData['lname'];
		$data['email_address'] = $orderData['email_address'];
		$data['reference_no'] = $orderData['reference_no'];
		$data['order_details'] = base_url('order/').$orderData['reference_no'];

		$this->email->initialize($config);
		$this->email->from('no-reply@herbalhouseph.com', 'Herbal House Philippines');
		$this->email->to($orderData['email_address']);
		$this->email->subject('A shipment from order #'.$orderData['reference_no'].' is now delivered!');
		$body = $this->load->view('email/order_delivered_notification', $data, TRUE);
		$this->email->message($body);
		$this->email->send();
	}
	public function getOrderData($order_id) {
		$query = $this->db->SELECT('bit.fname, bit.lname, bit.email_address, ot.reference_no, ot.shipping_fee, ot.total_revenue as total_amount, ot.payment_method, ot.created_at as ordered_date')
			->FROM('order_tbl as ot')
			->JOIN('billing_info_tbl as bit','bit.bi_id = ot.bi_id')
			->WHERE('ot.order_id', $order_id)
			->GET()->row_array();
		return $query;
	}
}
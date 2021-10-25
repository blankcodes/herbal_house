<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Ledger extends CI_Controller {
	function __construct (){
        parent::__construct();
        $this->load->model('ledger_model');
        $this->load->model('member_model');
		$this->load->library('user_agent');
		$this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function addNewPackage(){
    	$package = $this->input->post('package');
    	$cost = $this->input->post('cost');
    	$description = $this->input->post('description');
        $direct_points = $this->input->post('direct_points');
    	$indirect_points = $this->input->post('indirect_points');

    	$dataArr = array(
    		'name'=>$package,
    		'cost'=>$cost,
    		'description'=>$description,
    		'status'=>'disabled',
            'direct_points'=>$direct_points,
            'indirect_points'=>$indirect_points,
    		'created_at'=>date('Y-m-d H:i:s')
    	);
    	$checkPackage = $this->db->WHERE('name', $package)->GET('package_tbl')->num_rows();
    	if ($checkPackage > 0) {
    		$response['status'] = 'failed';
    		$response['message'] = $package.' Already Added. Please Try again!';
    	}
    	else{
    		$this->ledger_model->insertNewPackage($dataArr);
    		$response['status'] = 'success';
    		$response['message'] = $package.' Package Added';
    	}
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }

    public function showPackageList($row_no = 0) {
    	// Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->ledger_model->getPackageListCount();

        // Get records
        $products = $this->ledger_model->getPackageList($row_per_page, $row_no);

        // Pagination Configuration
        $config['base_url'] = base_url('member-list/');
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $all_count;
        $config['per_page'] = $row_per_page;

        // Pagination with bootstrap
        $config['use_page_numbers'] = TRUE;
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
    public function getPackageData(){
    	$data = $this->ledger_model->getPackageData();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function updatePackageData(){
    	$package = $this->input->post('package');
    	$cost = $this->input->post('cost');
    	$description = $this->input->post('description');
        $direct_points = $this->input->post('direct_points');
        $indirect_points = $this->input->post('indirect_points');
        // $match_points = $this->input->post('match_points');
        // $unilvl_points = $this->input->post('unilvl_points');
        // $max_points_am = $this->input->post('max_points_am');
        // $max_points_pm = $this->input->post('max_points_pm');
        // $profit_sharing_points = $this->input->post('profit_sharing_points');

    	$dataArr = array(
    		'name'=>$package,
    		'cost'=>$cost,
            'direct_points'=>$direct_points,
            'indirect_points'=>$indirect_points,
            'description'=>$description,
    		'updated_at'=>date('Y-m-d H:i:s')
    	);
    	$this->ledger_model->updatePackageData($dataArr);
    	$response['status'] = 'success';
    	$response['message'] = $package.' Package Updated';

        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function updatePackageStatus(){
    	$dataArr = array(
    		'status'=>$this->input->get('status'),
    		'updated_at'=>date('Y-m-d H:i:s')
    	);
    	$this->ledger_model->updatePackageStatus($dataArr);
    	$response['status'] = 'success';
    	$response['message'] = 'Package Status Updated';
    	
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function getPackageListActivationCodes(){
        $data = $this->ledger_model->getPackageListActivationCodes();        
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getPackageByCode(){
        $data = $this->ledger_model->getPackageByCode();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getWalletBalance(){
        $data = $this->ledger_model->getWalletBalance();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }

    public function getIndirectWalletBalance(){
        $data = $this->ledger_model->getIndirectWalletBalance();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getUnilevelWalletBalance(){
        $data = $this->ledger_model->getUnilevelWalletBalance();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getWalletRecentActivity(){
        $row_no = $this->input->get('page_no');
        
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->ledger_model->getWalletRecentActivityCount();

        // Get records
        $products = $this->ledger_model->getWalletRecentActivity($row_per_page, $row_no);

        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/wallet/_get_recent_activity/');
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
    public function getWalletRecentActivityAdmin(){
        $row_no = $this->input->get('page_no');
        
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->ledger_model->getWalletRecentActivityCountAdmin();

        // Get records
        $products = $this->ledger_model->getWalletRecentActivityAdmin($row_per_page, $row_no);

        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/wallet/_get_wallet_recent_activity/');
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
    public function getrequestWithdraw(){
        $row_no = $this->input->get('page_no');
        
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->ledger_model->getRequestWithdrawAdminCount();

        // Get records
        $products = $this->ledger_model->getRequestWithdrawAdmin($row_per_page, $row_no);

        // Pagination Configuration
        $config['base_url'] = base_url('api/v1/wallet/_withdraw_request');
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
    public function getWithdrawRequestData() {
        $data = $this->ledger_model->getWithdrawRequestData();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function updateWithdrawRequestStatus() {
        $data = $this->ledger_model->updateWithdrawRequestStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getWalletBalanceTransfer() {
        $data = $this->ledger_model->getWalletBalanceTransfer();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function reviewWithdrawRequest() {
        if (isset($this->session->user_id)) {

            $userData = $this->db->SELECT('status')->WHERE('user_id', $this->session->user_id)->GET('user_tbl')->row_array();
            $amount = $this->input->get('amount');
            $check = $this->db->WHERE('user_code', $this->session->user_code)->WHERE('type','main')->GET('wallet_tbl')->row_array();
            
            if ($userData['status'] == 'disabled') {

                $response['status'] = 'failed';
                $response['message'] = 'Withdrawal Request is Disabled!!!';

                $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
                return false;
            }
            
            
            else if(is_float($amount)) {
                $response['status'] = 'failed';
                $response['message'] = 'Amount is not a whole number!';
            }

            else if($amount <= 50) { /* cant be process below the process fee*/ 
                $response['status'] = 'failed';
                $response['message'] = 'Amount lower than the Processing fee.';
            }
            
            else if ($amount > $check['balance']) {
                $response['status'] = 'failed';
                $response['message'] = 'Request amount is greater than what you have!';
            }
            else if ($check['balance'] >= $amount) {
                $total_amnt = $amount - 50;
                $response['total_amount'] = '₱ '.number_format($total_amnt, 2); /* 50 for withdrawal processing fee */
                $response['total'] = $amount; /* 50 for withdrawal processing fee */
                $response['processing_fee'] = '₱ '.number_format(50, 2); /* 50 for withdrawal processing fee */
                $response['status'] = 'success';
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
        }
    }
    public function requestWithdraw(){
        if (isset($this->session->user_id)) {
            $amount = $this->input->post('amount');

            $check = $this->db->WHERE('user_code', $this->session->user_code)->WHERE('type','main')->GET('wallet_tbl')->row_array();
            $userData = $this->db->SELECT('status')->WHERE('user_id', $this->session->user_id)->GET('user_tbl')->row_array();
            if ($userData['status'] == 'disabled') {

                $response['status'] = 'failed';
                $response['message'] = 'Withdrawal Request is Disabled!!!';

                $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
                return false;
            }

            if(is_float($amount)) {
                $response['status'] = 'failed';
                $response['message'] = 'Amount is not a whole number!';
            }
            // else if ($check['balance'] < 1000) { /* MINIMUM AMOUNT TO WITHDRAW*/
            //     $response['status'] = 'failed';
            //     $response['message'] = "You don't have enough balance to withdraw!";
            // }
            else if($amount <= 50) { /* cant be process below the process fee*/ 
                $response['status'] = 'failed';
                $response['message'] = 'Amount lower than the Processing fee.';
            }
            else if ($amount > $check['balance']) {
                $response['status'] = 'failed';
                $response['message'] = 'Request amount is greater than what you have!';
            }
            else if ($check['balance'] >= $amount) {
                $this->ledger_model->requestWitdraw();
                
                $notif_log = array('user_id'=>$this->session->user_id, 'message'=>'Withdrawal Request of ₱'.number_format($amount, 2).'','created_at'=>date('Y-m-d H:i:s')); 
                $this->insertNewNotification($notif_log); /* INSERT new Notification */

                $activity_log = array(
                    'user_id'=>$this->session->user_id, 
                    'message_log'=>'Withdrawal Request of ₱'.number_format($amount,2), 
                    'ip_address'=>$this->input->ip_address(), 
                    'platform'=>$this->agent->platform(), 
                    'browser'=>$this->agent->browser(), 
                    'created_at'=>date('Y-m-d H:i:s')
                ); 
                $this->member_model->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

                $response['status'] = 'success';
                $response['message'] = 'Withdrawal request has been submitted!';
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
        }
    }
    public function tranferWalletBalance() {
        $tranfer_amt = $this->input->post('transfer_amnt');
        $walletBalance = $this->ledger_model->checkWalletBalance();
        $wallet_type = $this->input->post('wallet_type');

        $userData = $this->db->SELECT('status')->WHERE('user_id', $this->session->user_id)->GET('user_tbl')->row_array();
        if ($userData['status'] == 'disabled') {
            $response = array('status'=>'disabled_account');
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
            return false;
        }

        

        if(is_float($tranfer_amt)) {
            $response['status'] = 'failed';
            $response['message'] = 'Amount is not a whole number!';
        }
        else if ($walletBalance['balance'] < 300) { /* MINIMUM AMOUNT TO TRANSFER */
            $response['status'] = 'failed';
            $response['message'] = "You don't have enough balance to transfer!";
        }
        else if ($tranfer_amt < 300) { /* MINIMUM AMOUNT TO TRANSFER */
            $response['status'] = 'failed';
            $response['message'] = "Minimum amount to transfer is ₱ 300.00";
        }
        else if ($tranfer_amt > $walletBalance['balance']) {
            $response['status'] = 'failed';
            $response['message'] = 'Request amount is greater than what you have!';
        }
        else if ($walletBalance['balance'] >= $tranfer_amt) {
            $dateNow = date('d');
            $monthNow = date('m');

            if ($monthNow !== '02' && $wallet_type == 'unilevel_bonus') {
               if ($dateNow == '30' || $dateNow == '31') {
                    $this->transferWalletBalanceConfirm($tranfer_amt, $wallet_type);
                    $response['status'] = 'success';
                    $reponse['message'] = 'Amount transfered successfully!';
               }
               else{
                    $response['status'] = 'failed';
                    $response['message'] = 'You can only transfer your Unilevel Points on the 30th or 31st of the month!';
               }
            }

            else if ($monthNow == '02' && $wallet_type == 'unilevel_bonus') {
               if ($dateNow == '28' || $dateNow == '29') {
                    $this->transferWalletBalanceConfirm($tranfer_amt, $wallet_type);
                    $response['status'] = 'success';
                    $reponse['message'] = 'Amount transfered successfully!';
               }
               else{
                    $response['status'] = 'failed';
                    $response['message'] = 'You can only transfer your Unilevel Points on the 28th or 29th of the month!';
               }
            }

            else if ($wallet_type == 'indirect_referral') {
                if ($dateNow == '15') {
                    $this->transferWalletBalanceConfirm($tranfer_amt, $wallet_type);
                    $response['status'] = 'success';
                    $reponse['message'] = 'Amount transfered successfully!';
                }
                else{
                    $response['status'] = 'failed';
                    $response['message'] = 'You can only transfer your Indirect Referral Points on the 15th of the month!';
               }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));

    }
    public function transferWalletBalanceConfirm($tranfer_amt, $wallet_type){
        $this->ledger_model->transferWalletBalance();
        $activity_log = array(
            'user_id'=>$this->session->user_id, 
            'message_log'=>'Transfered amount of ₱'.number_format($tranfer_amt, 2).' from '.ucwords($wallet_type). ' Wallet to Main Wallet',
            'ip_address'=>$this->input->ip_address(), 
            'platform'=>$this->agent->platform(), 
            'browser'=>$this->agent->browser(), 
            'created_at'=>date('Y-m-d H:i:s')
        ); 
        $this->member_model->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */
    }
    public function updateUserPackage() {
        $data = $this->ledger_model->updateUserPackage();        
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function insertNewNotification ($notif_log) {
        $this->db->INSERT('notification_tbl', $notif_log);
    }
}
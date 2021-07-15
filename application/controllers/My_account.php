<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class My_account extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('my_account_model');
        $this->load->model('member_model');
        $this->load->model('ledger_model');
		$this->load->library('user_agent');
        $this->load->library('form_validation');
        $this->load->library('pagination');
		$this->load->helper('cookie');
    }
	public function getUserStatus() {
		$data = $this->my_account_model->getUserStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function updateUserStatus() {
		$data = $this->my_account_model->updateUserStatus();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function getNotifications() {
		$data = $this->my_account_model->getNotifications();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function getUserOverview() {
		$data['wallet'] = $this->my_account_model->getUserWallet();
		$data['direct_invites'] = $this->my_account_model->getDirectInvites();
		$data['indirect_invites'] = $this->my_account_model->getIndirectIinvites();
		$data['indirect_ref'] = $this->ledger_model->getIndirectWalletBalance();
		$data['unilevel_bonus'] = $this->ledger_model->getUnilevelWalletBalance();
		$data['code_credits'] = $this->member_model->getNewMemberActivationCodeCount();
		$data['orders'] = $this->member_model->getOrderNumbers();
		
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function getUserOverviewAdminSide() {
		if (isset($this->session->admin)) {
			$data['wallet'] = $this->my_account_model->getUserWalletAdmin();
			$data['direct_invites'] = $this->my_account_model->getDirectInvitesAdmin();
			$data['indirect_invites'] = $this->my_account_model->getIndirectIinvitesAdmin();
			$data['indirect_ref'] = $this->ledger_model->getIndirectWalletBalanceAdmin();
			$data['unilevel_bonus'] = $this->ledger_model->getUnilevelWalletBalanceAdmin();
			$data['code_credits'] = $this->member_model->getNewMemberActivationCodeCountAdmin();
			$data['orders'] = $this->member_model->getOrderNumbersAdmin();
		}
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function getMyOrders(){
		$row_no = $this->input->get('page_no');
		// Row per page
    	$row_per_page = 10;

    	// Row position
	    if($row_no != 0){
	      $row_no = ($row_no-1) * $row_per_page;
	    }

	    // All records count
    	$all_count = $this->my_account_model->getMyOrdersCount();

    	// Get records
		$products = $this->my_account_model->getMyOrdersData($row_per_page, $row_no);

   		// Pagination Configuration
	    $config['base_url'] = base_url().'api/v1/order/_get_my_orders';
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
	public function sendMail() {
		$email_address = $this->input->post('email_address');
		$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email',
			array('valid_email' => 'Email address is not valid!!')
		);

		if ($this->form_validation->run() == FALSE) {
			$response['status'] = 'failed';
			$response['message'] = $this->form_validation->error_array();
		}
		else{
			$response['status'] = 'success';
			$response['message'] = 'We have received your message. We will contact you soon!';
			$this->my_account_model->sendContactMail();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
	}
}

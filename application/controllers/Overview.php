<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Overview extends CI_Controller {

	function __construct (){
		parent::__construct();
		$this->load->model('member_model');
		$this->load->model('order_model');
        $this->load->library('form_validation');
        $this->load->library('user_agent'); 
	}
	public function getWebsiteOverview() {
		$data['member_count'] = $this->member_model->getMembersCount();
		$data['order_count'] = $this->order_model->getSuccessOrdersCount();
		$data['total_sales'] = $this->member_model->getTotalSales();


        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
}
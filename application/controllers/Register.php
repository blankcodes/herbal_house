<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Register extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('register_model');
        $this->load->library('form_validation');
        $this->load->library('user_agent'); 
    }
	public function account()
	{
		 $data = $this->register_model->registerAccount();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
}

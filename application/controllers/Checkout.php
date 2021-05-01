<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Checkout extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('checkout_model');
        $this->load->library('form_validation');
        $this->load->library('user_agent'); 
        $this->load->library('email'); 
    }
    public function addBillingInfo(){
    	$data = $this->checkout_model->addBillingInfo();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getBillingInfo(){
        $data = $this->checkout_model->getBillingInfo();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function addShippingInfo(){
        $data = $this->checkout_model->addShippingInfo();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getShippingInfo(){
        $data = $this->checkout_model->getShippingInfo();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function placeOrder(){
        $data = $this->checkout_model->placeOrder();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getPaymentOptions(){
        $data = $this->checkout_model->getPaymentOptions();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Cart extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('cart_model');
        $this->load->library('form_validation');
        $this->load->library('user_agent'); 
    }
    public function addToCart(){
    	$data = $this->cart_model->addToCart();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getCartData() {
    	$data = $this->cart_model->getCartData();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getShoppingCartData() {
        $data = $this->cart_model->getShoppingCartData();
    	if ($data['count'] <= 0 && $data['total'] == "0.00") {
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function deleteCart() {
    	$data = $this->cart_model->deleteCart();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function updateCartQty() {
    	$data = $this->cart_model->updateCartQty();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
}
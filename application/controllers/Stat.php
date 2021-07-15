<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Stat extends CI_Controller {
	function __construct (){
        parent::__construct();
        $this->load->model('stat_model');
    }
    public function getOrderSales(){
        $data = $this->stat_model->getOrderSales();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
}
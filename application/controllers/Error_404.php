<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_404 extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('my_account_model');
		$this->load->library('user_agent');
        $this->load->library('form_validation');
		$this->load->helper('cookie');
    }
	public function index() {
		$data['page'] = '404_page';
		$this->load->view('errors/error_404', $data);
	}
	
}

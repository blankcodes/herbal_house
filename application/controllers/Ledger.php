<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Ledger extends CI_Controller {
	function __construct (){
        parent::__construct();
        $this->load->model('ledger_model');
		$this->load->library('user_agent');
		$this->load->library('pagination');
        $this->load->library('form_validation');
    }

    public function addNewPackage(){
    	$package = $this->input->post('package');
    	$cost = $this->input->post('cost');
    	$description = $this->input->post('description');
        $match_points = $this->input->post('match_points');
    	$direct_points = $this->input->post('direct_points');
        $unilvl_points = $this->input->post('unilvl_points');

    	$dataArr = array(
    		'name'=>$package,
    		'cost'=>$cost,
    		'description'=>$description,
    		'status'=>'disabled',
    		'match_points'=>$match_points,
            'direct_points'=>$direct_points,
            'unilvl_points'=>$unilvl_points,
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
    	$match_points = $this->input->post('match_points');
        $direct_points = $this->input->post('direct_points');
        $unilvl_points = $this->input->post('unilvl_points');

    	$dataArr = array(
    		'name'=>$package,
    		'cost'=>$cost,
    		'match_points'=>$match_points,
            'direct_points'=>$direct_points,
            'unilvl_points'=>$unilvl_points,
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
    public function getWalletRecentActivity($row_no = 0){
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
}
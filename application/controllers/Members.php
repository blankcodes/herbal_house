<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Members extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('member_model');
        $this->load->model('register_model');
        $this->load->library('form_validation');
        $this->load->library('user_agent'); 
        $this->load->library('pagination'); 
    }
    private function hash_password($password){
       return password_hash($password, PASSWORD_BCRYPT);
    }
    public function generateCode(){
    	$data = $this->member_model->generateCode();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function showActivationCodes($row_no = 0){
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->member_model->getActivationCodeCount();

        // Get records
        $products = $this->member_model->getAllActivationCodes($row_per_page, $row_no);

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
    public function deleteCode(){
        $data = $this->member_model->deleteCode();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getUsers(){
        $data = $this->member_model->getUsers();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function sendUserCode(){
        $data = $this->member_model->sendUserCode();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function showMemberActivationCodes($row_no = 0){
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->member_model->getMemberActivationCodeCount();

        // Get records
        $products = $this->member_model->getMemberActivationCodes($row_per_page, $row_no);

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
    public function getNewMemberActivationCodeCount(){
        $data = $this->member_model->getNewMemberActivationCodeCount();
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
    }
    public function getDirectList($row_no = 0){
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->member_model->getDirectListCount();

        // Get records
        $products = $this->member_model->getDirectListByUserCode($row_per_page, $row_no);

        // Pagination Configuration
        $config['base_url'] = base_url('member/direct-invites/');
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
    public function geUserCodeHistory($row_no = 0){
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->member_model->getUserCodeHistoryCount();

        // Get records
        $products = $this->member_model->getUserCodeHistory($row_per_page, $row_no);

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
    public function showAllMemberList($row_no = 0){
        // Row per page
        $row_per_page = 10;

        // Row position
        if($row_no != 0){
          $row_no = ($row_no-1) * $row_per_page;
        }

        // All records count
        $all_count = $this->member_model->getAllMemberListCount();

        // Get records
        $products = $this->member_model->getAllMemberList($row_per_page, $row_no);

        // Pagination Configuration
        $config['base_url'] = base_url('member/direct-invites/');
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
    public function changePassword() {
        $old_pass = $this->input->post('old_pass');
        $new_pass = $this->input->post('new_pass');
        $confirm_pass = $this->input->post('confirm_pass');

        $userData = $this->member_model->checkUserData();

        if (password_verify($old_pass, $userData['password'])) {
            if ($new_pass !== $confirm_pass) {
                $response['status'] = 'fail';
                $response['message'] = "Password does not match!";
            }
            else{
                $data = array('password'=>$this->hash_password($new_pass), 'updated_at'=>date('Y-m-d H:i:s'));
                $this->member_model->updatePassword($data);
                $response['status'] = 'success';
                $response['message'] = 'Password updated successfully!';
            }
            
        }
        else{
            $response['status'] = 'fail';
            $response['message'] = 'Old password is incorrect!';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
    public function updateAccount(){
        $fname = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $email_address = $this->input->post('email_address');
        $mobile_number = $this->input->post('mobile_number');
        $data = array(
            'fname'=>$fname,
            'lname'=>$lname,
            'email_address'=>$email_address,
            'mobile_number'=>$mobile_number,
        );
        // Validation
        $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|is_unique[user_tbl.email_address]',
            array(
                'is_unique' => 'Email Address Already Exist!',
                'valid_email' => 'Please input a valid Email Address!',
                'required' => 'Email Address is Required!'
            )
        );

        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|is_unique[user_tbl.mobile_number]',
            array(
                'is_unique' => 'Mobile Number Already Exist!',
                'required' => 'Mobile Number is Required!'
            )
        );

        if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failed';
            $response['message'] = $this->form_validation->error_array();
        }
        else{
            $this->member_model->updateAccountData($data);
            $response['status'] = 'success';
            $response['message'] = 'Account info successfully updated!';
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
    }
}
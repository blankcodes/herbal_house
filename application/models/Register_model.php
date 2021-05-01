<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {

	private function hash_password($password){
	   return password_hash($password, PASSWORD_BCRYPT);
	}
	public function generateUserCode ($id, $length = 19) {
	    $characters = '0123456789QWERTYUIOPASDFGHJKLZXCVBNM';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $u_code = 'HBH'.$randomString.$id;

	    $check = $this->db->WHERE('user_code', $u_code)->GET('user_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateUserCode($id);
	    }
	    else{
	    	$data = array('user_code' => $u_code);
		    $this->db->WHERE('user_id', $id)
		    	->UPDATE('user_tbl', $data); /* INSERT user user_code used for invites for selling */
	    }
	    
	}
	public function registerAccount (){
		$user['fname'] = $this->input->post('fname');
        $user['lname'] = $this->input->post('lname');
        $user['mobile_number'] = $this->input->post('mobile_number');
        $user['email_address'] = $this->input->post('email_address');
        $user['password'] = $this->input->post('password');

        // Validation
		$this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|is_unique[user_tbl.email_address]',
			array(
				'is_unique' => 'Email Address Already Exist!',
				'valid_email' => 'Please input a valid Email Address!',
				'required' => 'Email Address is Required!'
			)
		);
		$this->form_validation->set_rules('password', 'Password', 'required',
			array('required' => 'Password is Required!')
		);

		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'is_unique[user_tbl .mobile_number]',
			array('is_unique' => 'Mobile Number Already Exist!')
		);

       	if ($this->form_validation->run() == FALSE) {
			$response['status'] = 'failed';
			$response['message'] = $this->form_validation->error_array();
		}
		else{
			$this->insertAccountData($user);
			$response['status'] = 'success';
			$response['message'] = 'Account successfully registered!';
		}
		return $response;
	}
	public function insertAccountData ($user) {
		$checkAdminUser = $this->checkAdminUser();
		$user_type = 'member';
		if ($checkAdminUser <= 0) {
			$user_type = 'admin';
		}
		$data = array(
			'fname'=>$user['fname'],
			'lname'=>$user['lname'],
			'mobile_number'=>$user['mobile_number'],
			'email_address'=>$user['email_address'],
			'password'=>$this->hash_password($user['password']),
			'status'=>'inactive',
			'user_type'=>$user_type,
			'created_at'=>date('Y-m-d H:i:s')
		);
		$this->db->INSERT('user_tbl', $data);
		$id = $this->db->insert_id();

		$this->generateUserCode($id); /* INSERT user unique CODE*/
		
		$notif_log = array('user_id'=>$id, 'message'=>'Welcome to Herbal House!','created_at'=>date('Y-m-d H:i:s')); 
		$this->insertNewNotification($notif_log); /* INSERT new Notification */

		$activity_log = array('user_id'=>$id, 'message_log'=>'Created account','ip_address'=>$this->input->ip_address(), 'platform'=>$this->agent->platform(), 'browser'=>$this->agent->browser(),'created_at'=>date('Y-m-d H:i:s')); 
		$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */
	}
	public function checkAdminUser() {
		return $this->db->GET('user_tbl')->num_rows();
	}
	public function insertNewNotification ($notif_log) {
		$this->db->INSERT('notification_tbl', $notif_log);
	}
	public function insertActivityLog ($activity_log) {
		$this->db->INSERT('activity_logs_tbl', $activity_log);
	}
}
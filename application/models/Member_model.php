<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

	/*
	* $this->session->temp_user_id is a non-member/disributor, a visitor who added to cart.
	*/ 
	private function hash_password($password){
       return password_hash($password, PASSWORD_BCRYPT);
    }
	public function generateCode() {
		$input_num = $this->input->post('number');

		for($x = 0; $x < $input_num; $x++){
			$this->generateActivationCode();
		}

	   	$activity_log = array('user_id'=>$this->session->user_id, 'message_log'=>'Generated '.$input_num.' Member Code', 'ip_address'=>$this->input->ip_address(), 'platform'=>$this->agent->platform(), 'browser'=>$this->agent->browser(),'created_at'=>date('Y-m-d H:i:s')); 
		$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

		$response['status'] = 'success';
		$response['message'] = 'Successfully generated '.$input_num.' activation codes';
		return $response;
	}
	public function deleteUser() {
    	if (isset($this->session->admin) ) {
    		$user_code = $this->input->post('user_code');
    		$userData = $this->db->SELECT('user_type')->WHERE('user_code', $user_code)->GET('user_tbl')->row_array();

    		if ($userData['user_type'] == 'admin') {
    			$response['failed'] = 'failed';
				$response['message'] = 'You cannot Delete an Admin User!';	
    		}
    		else if ($userData['user_code'] == '100001379210') { /* main default user as Herbal House*/
    			$response['failed'] = 'failed';
				$response['message'] = 'You cannot Delete this User!';	
    		}
    		else{
    			$this->db->WHERE('user_code', $this->input->post('user_code'))->DELETE('user_tbl');
	    		$this->db->WHERE('referred_id', $this->input->post('user_code'))->DELETE('unilevel_tbl');

	    		$activity_log = array(
	    			'user_id'=>$this->session->user_id, 
	    			'message_log'=>'Deletes user account User ID:'.$this->input->post('user_code').' User:'.$this->input->post('name'),
	    			'ip_address'=>$this->input->ip_address(), 
	    			'platform'=>$this->agent->platform(), 
	    			'browser'=>$this->agent->browser(),
	    			'created_at'=>date('Y-m-d H:i:s')
	    		); 
				$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

				$response['status'] = 'success';
				$response['message'] = 'User '.$this->input->post('name').' Successfully Deleted!';	
    		}
			return $response;
    	}
    }
    public function disableUser() {
    	if (isset($this->session->admin) ) {
    		$user_code = $this->input->post('user_code');
    		$userData = $this->db->SELECT('user_type, user_code')->WHERE('user_code', $user_code)->GET('user_tbl')->row_array();

    		if ($userData['user_type'] == 'admin') {
    			$response['failed'] = 'failed';
				$response['message'] = 'You cannot Disable an Admin User!';	
    		}
    		else if ($userData['user_code'] == '1000013792101') { /* main default user as Herbal House*/
    			$response['failed'] = 'failed';
				$response['message'] = 'You cannot Disable this User!';	
    		}
    		else{
    			$dataArr = array('status'=>'disabled');
    			$this->db->WHERE('user_code', $user_code)->UPDATE('user_tbl', $dataArr);

	    		$activity_log = array(
	    			'user_id'=>$this->session->user_id, 
	    			'message_log'=>'Disabled Withdrawal. User ID: '.$user_code.' User: '.$this->input->post('name'),
	    			'ip_address'=>$this->input->ip_address(), 
	    			'platform'=>$this->agent->platform(), 
	    			'browser'=>$this->agent->browser(),
	    			'created_at'=>date('Y-m-d H:i:s')
	    		); 
				$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

				$response['status'] = 'success';
				$response['message'] = 'User '.$this->input->post('name').' Successfully Disabled!';	
    		}
			return $response;
    	}
    }
	public function enableUser() {
    	if (isset($this->session->admin) ) {
    		$user_code = $this->input->post('user_code');
    		
    		$dataArr = array('status'=>'active');
    		$this->db->WHERE('user_code', $user_code)->UPDATE('user_tbl', $dataArr);

	    	$activity_log = array(
	    		'user_id'=>$this->session->user_id, 
	    		'message_log'=>'Enabled Withdrawal. User ID: '.$user_code.' User: '.$this->input->post('name'),
	    		'ip_address'=>$this->input->ip_address(), 
	   			'platform'=>$this->agent->platform(), 
	   			'browser'=>$this->agent->browser(),
	   			'created_at'=>date('Y-m-d H:i:s')
	    	); 
			$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

			$response['status'] = 'success';
			$response['message'] = 'User '.$this->input->post('name').' Successfully Activated!';	
			return $response;
    	}
    }
    public function resetPassword() {
    	if (isset($this->session->admin) ) {
    		$user_code = $this->input->post('user_code');
    		$default_pass = '123456';
    		// $userData = $this->db->SELECT('user_type')->WHERE('user_code', $user_code)->GET('user_tbl')->row_array();

    		$dataArr = array(
    			'password'=>$this->hash_password($default_pass)
    		);
    		$this->db->WHERE('user_code', $user_code)
    			->UPDATE('user_tbl', $dataArr);

	    	$activity_log = array(
	    		'user_id'=>$this->session->user_id, 
	    		'message_log'=>'Reset Password. User ID:'.$this->input->post('user_code').' User:'.$this->input->post('name'),
	    		'ip_address'=>$this->input->ip_address(), 
	   			'platform'=>$this->agent->platform(), 
	   			'browser'=>$this->agent->browser(),
	   			'created_at'=>date('Y-m-d H:i:s')
	    	); 
			$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

			$response['status'] = 'success';
			$response['message'] = "User ".$this->input->post('name')."'s Password Reset Successfully!";	
			return $response;
    	}
    }
	public function sendMultipleCodes() {
    	if (isset($this->session->user_id) && isset($this->session->admin)) {
    		$qty = $this->input->get('qty');
			for ($x = 0; $x < $qty; $x++) {
				$this->generateSendMultipleActivationCode();
			}
			$package = $this->db->WHERE('p_id', $this->input->get('package'))->GET('package_tbl')->row_array();
			$activity_log = array(
	    		'user_id'=>$this->session->user_id, 
	    		'message_log'=> 'Transfer of '.$qty.' "'.$package['name'].'" code to User <a target="_blank" href="'.base_url('user/overview/').$this->input->get('user_code').'">'.$this->input->get('user_code').'</a>.',
	    		'ip_address'=>$this->input->ip_address(), 
	    		'platform'=>$this->agent->platform(), 
	    		'browser'=>$this->agent->browser(),
	    		'created_at'=>date('Y-m-d H:i:s')
	    	); 
			$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

			$response['status'] = 'success';
			$response['message'] = 'Successfully Processed!';
			return $response;
    	}
    }
    public function generateSendMultipleActivationCode($length = 15){
		$characters = '0123456789ABCDEF';
	    $charactersLength = strlen($characters);
	    $activation_code = '';
	    for ($i = 0; $i < $length; $i++) {
	        $activation_code .= $characters[rand(0, $charactersLength - 1)];
	    }

	    $check = $this->db->WHERE('code', $activation_code)->GET('activation_code_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateSendMultipleActivationCode();
	    }
	    else{
	    	$package = $this->input->get('package');
		    $data = array(
	    		'code'=>$activation_code,
	    		'p_id'=>$package,
	    		'status'=>'sent'
	    	);
	    	$this->db->INSERT('activation_code_tbl', $data); /* insert member code*/
	    	$this->sendMultipleUserCode($activation_code);
	    }
	}
	public function sendMultipleUserCode($activation_code){
		$package = $this->input->get('package');
		$user_code = $this->input->get('user_code');

		/* check if there's existing code sent to the user_code (user) AND if the user_code(user) is existing */ 
		$checkActCode = $this->db->WHERE('code', $activation_code)->WHERE('status','sent')->GET('activation_code_tbl')->num_rows();
		$checkUserCode = $this->db->WHERE('user_code', $user_code)->WHERE('code', $activation_code)->GET('user_code_tbl')->num_rows();

		if ($checkActCode > 0 && $checkUserCode <= 0) {
			$data = array(
				'p_id'=>$package, 
				'user_code'=>$user_code, 
				'code'=>$activation_code, 
			);
			$this->db->INSERT('user_code_tbl', $data); 
		}
	}
	public function getPackageList() {
		return $this->db->SELECT('p_id, name')->GET('package_tbl')->result_array();
	}
	public function addNewMember() {
		if (isset($this->session->admin)) {

			$user['username'] = $this->input->post('username');
			$user['fname'] = $this->input->post('fname');
	        $user['lname'] = $this->input->post('lname');
	        $user['mobile_number'] = $this->input->post('mobile_number');
	        $user['password'] = $this->input->post('password');
	        $user['user_type'] = $this->input->post('user_type');
	        $user['package'] = $this->input->post('package');


	        if ($user['user_type'] == 'member' && isset($user['package'])) {
				$checkActivationCode = $this->db->WHERE('p_id',$user['package'])->WHERE('status','new')->GET('activation_code_tbl')->num_rows();
				if ($checkActivationCode <= 0) {
					$response['status'] = 'failed';
					$response['message'] = "There's no available activation code. Please generate first and try again.";
					return $response;
					exit();
				}
			}
			else if($user['user_type'] == 'member' && !isset($user['package'])){
				$response['status'] = 'failed';
				$response['message'] = "Package is required!";
				return $response;
				exit();
			}

			$this->form_validation->set_rules('password', 'Password', 'required',
				array('required' => 'Password is Required!')
			);

			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'is_unique[user_tbl.mobile_number]',
				array('is_unique' => 'Mobile Number Already Exist!')
			);

			$this->form_validation->set_rules('username', 'Username', 'is_unique[user_tbl.username]',
				array('is_unique' => 'Username Already Exist!')
			);

			if ($this->form_validation->run() == FALSE) {
				$response['status'] = 'failed';
				$response['message'] = $this->form_validation->error_array();
			}
			else{
				$referred_id = $this->insertNewAccountData($user);
				$response['status'] = 'success';
				$response['message'] = 'User successfully registered!';
			}
		
			return $response;
		}
	}
	public function insertNewAccountData ($user) {
		if (isset($this->session->admin)) {
			$data = array(
				'user_type'=>$user['user_type'],
				'username'=>$user['username'],
				'fname'=>$user['fname'],
				'lname'=>$user['lname'],
				'mobile_number'=>$user['mobile_number'],
				'password'=>$this->hash_password($user['password']),
				'status'=>'inactive',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('user_tbl', $data);
			$id = $this->db->insert_id();

			$user_code = $this->generateUserCode($id); /* INSERT user unique USER_CODE*/
			
			if ($user['user_type'] == 'member') {
				/* GET ACTIVATION CODE WHERE SELECTED PACKAGE ID */ 
				$package = $this->db->SELECT('act.code')
					->FROM('package_tbl as pt')
					->JOIN('activation_code_tbl as act', 'act.p_id=pt.p_id')
					->WHERE('pt.p_id', $user['package'])
					->WHERE('act.status', 'new')
					->GET()->row_array();

				/* INSERT THE CHOSEN CODE FROM ACTIVATION CODE TBL TO USER CODE TBL*/ 
				$dataCodeArr = array(
					'p_id'=>$user['package'],
					'user_code'=> $user_code, 
					'code'=>$package['code'],
					'status'=>'used',
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s'),
				);
				$this->db->INSERT('user_code_tbl', $dataCodeArr);

				/* INSERT THE ACTIVATION CODE TO THE NEW MEMBER*/ 
				$dataMemCodeArr = array('member_code'=>$package['code']);
				$this->db->WHERE('user_code', $user_code)->UPDATE('user_tbl', $dataMemCodeArr);

				/* UPDATE THE ACTIVATION CODE TO USED */ 
				$dataActCodeArr = array('status'=>'used');
				$this->db->WHERE('code', $package['code'])->UPDATE('activation_code_tbl', $dataActCodeArr);
			}
			

			$notif_log = array('user_id'=>$id, 'message'=>'Welcome to Herbal House!','created_at'=>date('Y-m-d H:i:s')); 
			$this->insertNewNotification($notif_log); /* INSERT new Notification */

			$activity_log = array('user_id'=>$id, 'message_log'=>'Created account','ip_address'=>$this->input->ip_address(), 'platform'=>$this->agent->platform(), 'browser'=>$this->agent->browser(),'created_at'=>date('Y-m-d H:i:s')); 
			$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */
		}
	}
	public function generateUserCode ($id, $length = 5) {
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	   $u_code = '10000'.$id.$randomString;

	    $check = $this->db->WHERE('user_code', $u_code)->GET('user_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateUserCode($id);
	    }
	    else{
	    	$data = array('user_code' => $u_code);
		    $this->db->WHERE('user_id', $id)
		    	->UPDATE('user_tbl', $data); /* INSERT user user_code used for invites for selling */
		    return $u_code;
	    }
	}
	public function insertNewNotification ($notif_log) {
		$this->db->INSERT('notification_tbl', $notif_log);
	}
	
	public function generateActivationCode($length = 15){
		$characters = '0123456789ABCDEF';
	    $charactersLength = strlen($characters);
	    $member_code = '';
	    for ($i = 0; $i < $length; $i++) {
	        $member_code .= $characters[rand(0, $charactersLength - 1)];
	    }

	    $check = $this->db->WHERE('code', $member_code)->GET('activation_code_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateActivationCode();
	    }
	    else{
	    	$package = $this->input->post('package');
		    $data = array(
	    		'code'=>$member_code,
	    		'p_id'=>$package
	    	);
	    	$this->db->INSERT('activation_code_tbl', $data); /* insert member code*/
	    }
	}
	public function insertActivityLog ($activity_log) {
		$this->db->INSERT('activity_logs_tbl', $activity_log);
	}
	public function getActivationCodeCount () {
    	if ($this->session->user_type == 'admin') {
    		return $this->db->GET('activation_code_tbl')->num_rows();
		}
    }
    public function getAllActivationCodes ($row_per_page, $row_no) {
    	if ($this->session->user_type == 'admin') {
    		$query = $this->db->SELECT('ac_id, code, act.status, act.created_at, pt.name, pt.cost, act.updated_at')
	    		->FROM('activation_code_tbl as act')
	    		->JOIN('package_tbl as pt', 'pt.p_id = act.p_id')
				->ORDER_BY('act.created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$user = $this->getUserNameUserCode($q['code']);
				$array = array(
					'ac_id'=>$q['ac_id'],
					'code'=>$q['code'],
					'status'=>$q['status'],
					'package_name'=>$q['name'],
					'username'=>$user['username'],
					'user_code'=>$user['user_code'],
					'cost'=>'₱ '.number_format($q['cost'], 2),
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
    }
    public function getUserNameUserCode($code){
    	return $this->db->SELECT('ut.username, ut.user_code')
    		->FROM('user_code_tbl as uct')
    		->JOIN('user_tbl as ut', 'ut.user_code=uct.user_code')
    		->WHERE('uct.code', $code)
    		->GET()->row_array();

    }
    public function deleteCode () {
		$this->db->WHERE('ac_id', $this->input->post('id'))->DELETE('activation_code_tbl');
		$response['status'] = 'success';
		$response['message'] = 'Member Code successfully deleted';
		return $response;
	}
	public function searchMembers() {
		if (isset($this->session->user_id)) {
			$search = $this->input->get('keyword');
			$query = $this->db->SELECT('fname, lname, user_code')
				->WHERE("(fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR username LIKE '%".$search."%' OR user_code LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
				->WHERE('user_type','member')
				->WHERE('status','active')
				->WHERE_NOT_IN('user_code', $this->session->user_code)
				->GET('user_tbl')->result_array();
			$result = array();
			foreach($query as $q){
				$array = array(
					'user_code'=>$q['user_code'],
					'name'=>$q['fname'].' '.$q['lname'],
				);
				array_push($result, $array);
			}

			if (!empty($result)) {
				$data['search'] = $result;
				$data['status'] = 'success';
				return $data;
			}
			else{
				$data['status'] = 'no_record';
				$data['message'] = 'No record found!';
				return $data;
			}
		}
	}
	public function getUsers() {
		if (isset($this->session->user_id)) {
			$search = $this->input->get('keyword');
			$query = $this->db->SELECT('fname, lname, user_code')
				->WHERE("(fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR username LIKE '%".$search."%' OR user_code LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)
				->WHERE('user_type','member')
				->WHERE('status','active')
				->GET('user_tbl')->result_array();
			$result = array();
			foreach($query as $q){
				$array = array(
					'user_code'=>$q['user_code'],
					'name'=>$q['fname'].' '.$q['lname'],
				);
				array_push($result, $array);
			}

			if (!empty($result)) {
				$data['search'] = $result;
				$data['status'] = 'success';
				return $data;
			}
			else{
				$data['status'] = 'no_record';
				$data['message'] = 'No record found!';
				return $data;
			}
		}
	}
	public function searchStockistName() {
		if (isset($this->session->admin)) {
			$search = $this->input->get('keyword');

			$query = $this->db->SELECT('fname, lname, user_code')
				->WHERE('type','stockist')
				->WHERE('user_type','member')
				->WHERE('status','active')
				->WHERE("(fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR username LIKE '%".$search."%' OR user_code LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)

				// ->LIKE('fname', $search)
				// ->OR_LIKE('lname', $search)
				// ->OR_LIKE('username', $search)
				// ->OR_LIKE('user_code', $search)
				// ->OR_LIKE('mobile_number', $search)
				
				->GET('user_tbl')->result_array();
			$result = array();
			foreach($query as $q){
				$array = array(
					'user_code'=>$q['user_code'],
					'name'=>$q['fname'].' '.$q['lname'],
				);
				array_push($result, $array);
			}

			if (!empty($result)) {
				$data['search'] = $result;
				$data['status'] = 'success';
				return $data;
			}
			else{
				$data['status'] = 'no_record';
				$data['message'] = 'No record found!';
				return $data;
			}
		}
	}
	public function sendUserCode(){
		$code = $this->input->get('code');
		$user_code = $this->input->get('user_code');

		/* check if there's existing code sent to the user_code (user) AND if the user_code(user) is existing */ 
		$checkCode = $this->db->WHERE('code', $code)->WHERE('status','sent')->GET('activation_code_tbl')->num_rows();
		$checkUserCode = $this->db->WHERE('user_code', $user_code)->WHERE('code', $code)->GET('user_code_tbl')->num_rows();

		$getUserCode = $this->db->SELECT('act.p_id')
			->FROM('activation_code_tbl as act')
			->JOIN('package_tbl as pt', 'pt.p_id = act.p_id')
			->WHERE('act.code', $code)
			->GET()->row_array();

		if ($checkCode <= 0 && $checkUserCode <= 0) {
			$data = array(
				'p_id'=>$getUserCode['p_id'], 
				'user_code'=>$user_code, 
				'code'=>$code, 
			);
			$this->db->INSERT('user_code_tbl', $data); 

			$mData = array('status'=>'sent');
			$this->db->WHERE('code',$code)->UPDATE('activation_code_tbl',$mData);

			$response['status'] = 'success';
			$response['message'] = 'Code Successfully sent!';
		}
		else{
			$response['status'] = 'failed';
			$response['message'] = 'Something went wrong. Please try again!';
		}
		return $response;
	}
	public function transferUserCode(){
		$code = $this->input->get('code');
		$user_code = $this->input->get('user_code');

		/* check if there's existing code sent to the user_code (user) AND if the user_code(user) is existing */ 
		$checkActivationCode = $this->db->WHERE('code', $code)->WHERE('status','sent')->GET('activation_code_tbl')->num_rows();
		$checkUserCode = $this->db->WHERE('code', $code)->WHERE('status','new')->OR_WHERE('status','transfered')->WHERE('user_code', $this->session->user_code)->GET('user_code_tbl')->num_rows();
		if ($checkUserCode > 0 && $checkActivationCode > 0) {
			$data = array(
				'user_code'=>$user_code, 
				'status'=>'new'
			);
			$this->db->WHERE('code',$code)->UPDATE('user_code_tbl', $data); 

			$response['status'] = 'success';
			$response['message'] = 'Code Successfully Transferred!';
		}
		else{
			$response['status'] = 'failed';
			$response['message'] = 'Something went wrong. Please try again!';
		}
		return $response;
	}
	public function getMemberActivationCodeCount () {
    	return $this->db->WHERE('user_code', $this->session->user_code)
    		->WHERE('status','new')
			->GET('user_code_tbl')->num_rows();
    }
    public function getMemberActivationCodes ($row_per_page, $row_no) {
    	$query = $this->db->SELECT('uc_id, uct.code, pt.name as package_name, uct.created_at as date_purchased')
    		->FROM('user_code_tbl as uct')
    		->JOIN('activation_code_tbl as act', 'act.code = uct.code', 'left')
    		->JOIN('package_tbl as pt', 'pt.p_id = act.p_id', 'left')
			->WHERE('uct.user_code', $this->session->user_code)
			->WHERE('uct.status','new')
			->ORDER_BY('uct.created_at', 'DESC')
			->LIMIT($row_per_page, $row_no)
			->GET()->result_array();
		$result = array();

		foreach($query as $q){
			$array = array(
				'uc_id'=>$q['uc_id'],
				'code'=>$q['code'],
				'package_name'=>$q['package_name'],
				'date_purchased'=>date('m/d/Y h:i A', strtotime($q['date_purchased'])),
			);
			array_push($result, $array);
		}
		return $result;
    }
    public function getNewMemberActivationCodeCount () {
    	$count = $this->db->WHERE('user_code', $this->session->user_code)
    		->WHERE('status','new')
			->GET('user_code_tbl')->num_rows();

		return array('count'=>$count);
    }
     public function getNewMemberActivationCodeCountAdmin () {
    	$count = $this->db->WHERE('user_code', $this->input->get('user_code'))
    		->WHERE('status','new')
			->GET('user_code_tbl')->num_rows();

		return array('count'=>$count);
    }
    public function getOrderNumbers () {
    	$count = $this->db->WHERE('referrer', $this->session->username)
    		->WHERE('status', 'delivered')
			->GET('order_tbl')->num_rows();

		return array('count'=>$count);
    }
    public function getOrderNumbersAdmin () {
    	$userData = $this->db->SELECT('username')->WHERE('user_code', $this->input->get('user_code'))->GET('user_tbl')->row_array();
    	$count = $this->db->WHERE('referrer', $userData['username'])
    		->WHERE('status', 'delivered')
			->GET('order_tbl')->num_rows();

		return array('count'=>$count);
    }
    public function getDirectListByUserCode ($row_per_page, $row_no) {
    	$query = $this->db->SELECT('ut.user_code, ut.fname, ut.lname, ut.mobile_number, ut.created_at, pt.name as package_name')
    		->FROM('user_tbl as ut')
    		->JOIN('user_code_tbl as uct', 'uct.code = ut.member_code')
    		->JOIN('package_tbl as pt', 'pt.p_id = uct.p_id')
			->ORDER_BY('created_at', 'DESC')
			->LIMIT($row_per_page, $row_no)
			->WHERE('sponsor_id', $this->input->get('user_code'))
			->WHERE('user_type', 'member')
			->GET()->result_array();
		$result = array();

		foreach($query as $q){
			$array = array(
				'user_code'=>$q['user_code'],
				'name'=>ucwords($q['fname'].' '.$q['lname']),
				'package_name'=>$q['package_name'],
				'mobile_number'=>$q['mobile_number'],
				'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
			);
			array_push($result, $array);
		}
		return $result;
    }
    public function getDirectListCount () {
    	return $this->db->WHERE('sponsor_id', $this->input->get('user_code'))
			->GET('user_tbl')->num_rows();
    }
    public function getInDirectListByUserCode ($row_per_page, $row_no) {
    	$query = $this->db->SELECT('ut.user_code, ut.fname, ut.lname, ut.created_at')
    		->FROM('unilevel_tbl as unt')
    		->JOIN('user_tbl as ut', 'unt.referred_id = ut.user_code')
			->ORDER_BY('ut.created_at', 'DESC')
			->LIMIT($row_per_page, $row_no)
			->WHERE('unt.user_code', $this->input->get('user_code'))
			->WHERE('level', $this->input->get('level'))
			->WHERE('user_type', 'member')
			->GET()->result_array();
		$result = array();

		foreach($query as $q){
			$array = array(
				'user_code'=>$q['user_code'],
				'name'=>ucwords($q['fname'].' '.$q['lname']),
				'created_at'=>date('F d, Y h:i A', strtotime($q['created_at'])),
			);
			array_push($result, $array);
		}
		return $result;
    }
    public function getInDirectListCount () {
    	return $this->db->SELECT('ut.user_code, ut.fname, ut.lname, ut.created_at')
    		->FROM('unilevel_tbl as unt')
    		->JOIN('user_tbl as ut', 'unt.referred_id = ut.user_code')
			->ORDER_BY('ut.created_at', 'DESC')
			->WHERE('unt.user_code', $this->input->get('user_code'))
			->WHERE('level', $this->input->get('level'))
			->WHERE('user_type', 'member')
			->GET()->num_rows();
    }
    public function getUserCodeHistory ($row_per_page, $row_no) {
    	$query = $this->db->SELECT('uct.code, ut.fname, ut.lname, pt.name as package_name, uct.created_at as date_purchased, uct.updated_at as date_used')
    		->FROM('user_code_tbl as uct')
    		->JOIN('user_tbl as ut', 'ut.member_code = uct.code', 'left')
    		->JOIN('activation_code_tbl as act', 'act.code = uct.code', 'left')
    		->JOIN('package_tbl as pt', 'pt.p_id = act.p_id', 'left')
			->WHERE('ut.sponsor_id', $this->session->user_code)
			->WHERE('uct.status', 'used')
			->ORDER_BY('ut.created_at', 'DESC')
			->LIMIT($row_per_page, $row_no)
			->GET()->result_array();
		$result = array();

		foreach($query as $q){
			$array = array(
				'code'=>$q['code'],
				'package_name'=>$q['package_name'],
				'date_purchased'=>date('m/d/Y h:i A', strtotime($q['date_purchased'])),
				'date_used'=>date('m/d/Y h:i A', strtotime($q['date_used'])),
				'used_by'=>$q['fname'].' '.$q['lname']
			);
			array_push($result, $array);
		}
		return $result;
    }
    public function getUserCodeHistoryCount () {
    	return $this->db->FROM('user_code_tbl as uct')
    		->JOIN('user_tbl as ut', 'ut.member_code = uct.code', 'left')
			->WHERE('ut.sponsor_id', $this->session->user_code)
			->WHERE('uct.status', 'used')
			->GET()->num_rows();
    }
    public function getAllMemberList ($row_per_page, $row_no) {
    	if ($this->session->user_type == 'admin') {
    		$query = $this->db->SELECT('user_id, user_code, username, fname, lname, mobile_number, user_type, status, registration_type, website_invites_status, type, sponsor_id, created_at')
	    		->FROM('user_tbl')
				->ORDER_BY('created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$code_count = $this->db->WHERE('user_code', $q['user_code'])->WHERE('status','new')->GET('user_code_tbl')->num_rows();
				$sponsor = $this->db->SELECT('username, user_code')->WHERE('user_code', $q['sponsor_id'])->GET('user_tbl')->row_array();
				$array = array(
					'user_code'=>$q['user_code'],
					'user_id'=>$q['user_id'],
					'username'=>ucwords($q['username']),
					'code_credits'=>$code_count,
					'name'=>ucwords($q['fname'].' '.$q['lname']),
					'mobile_number'=>$q['mobile_number'],
					'user_type'=>$q['user_type'],
					'invite_status'=>$q['website_invites_status'],
					'status'=>$q['status'],
					'type'=>$q['type'],
					'registration_type'=>$q['registration_type'],
					'sponsor'=>($q['registration_type'] == 'website_invites') ? $sponsor['username'] : '',
					'sponsor_id'=>($q['registration_type'] == 'website_invites') ? $sponsor['user_code'] : '',
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
    }
    public function getSearchedUser($row_per_page, $row_no) {
    	if ($this->session->user_type == 'admin') {
    		$search = $this->input->get('query');
    		$query = $this->db->SELECT('user_id, user_code, username, fname, lname, mobile_number, user_type, status, registration_type, website_invites_status, sponsor_id, created_at, type')
				->ORDER_BY('created_at', 'DESC')
				// ->WHERE("(fname LIKE '%".$keyword."%' OR lname LIKE '%".$keyword."%' OR username LIKE '%".$keyword."%' OR user_code LIKE '%".$keyword."%' OR mobile_number LIKE '%".$keyword."% OR email_address LIKE '%".$keyword."%'')", NULL, FALSE)

				->WHERE("(fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR username LIKE '%".$search."%' OR user_code LIKE '%".$search."%' OR mobile_number LIKE '%".$search."%')", NULL, FALSE)

				->LIMIT($row_per_page, $row_no)
				->GET('user_tbl')->result_array();
			$result = array();

			foreach($query as $q){
				$code_count = $this->db->WHERE('user_code', $q['user_code'])->WHERE('status','new')->GET('user_code_tbl')->num_rows();
				$sponsor = $this->db->SELECT('username, user_code')->WHERE('user_code', $q['sponsor_id'])->GET('user_tbl')->row_array();
				$array = array(
					'user_code'=>$q['user_code'],
					'user_id'=>$q['user_id'],
					'username'=>ucwords($q['username']),
					'code_credits'=>$code_count,
					'name'=>ucwords($q['fname'].' '.$q['lname']),
					'mobile_number'=>$q['mobile_number'],
					'user_type'=>$q['user_type'],
					'invite_status'=>$q['website_invites_status'],
					'status'=>$q['status'],
					'type'=>$q['type'],
					'sponsor'=>($q['registration_type'] == 'website_invites') ? $sponsor['username'] : '',
					'sponsor_id'=>($q['registration_type'] == 'website_invites') ? $sponsor['user_code'] : '',
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
    }
    public function getSearchedUserCount() {
    	if ($this->session->user_type == 'admin') {
    		$keyword = $this->input->get('query');
    		return $this->db
    			->LIKE('user_code', $keyword)
				->OR_LIKE('username', $keyword)
				->OR_LIKE('fname', $keyword)
				->OR_LIKE('lname', $keyword)
				->OR_LIKE('mobile_number', $keyword)
				->OR_LIKE('email_address', $keyword)
				->GET('user_tbl')->num_rows();
    	}
    }
    public function getAllMemberListCount () {
    	if ($this->session->user_type == 'admin') {
    		return $this->db->GET('user_tbl')->num_rows();
    	}
    }
    public function updatePassword($data) {
    	if ($this->session->user_id) {
    		$this->db->WHERE('user_id', $this->session->user_id)
    			->UPDATE('user_tbl', $data);
    	}
    }
    public function checkUserData(){
    	if ($this->session->user_id) {
    		return $this->db->WHERE('user_id', $this->session->user_id)
    			->GET('user_tbl')->row_array();
    	}
    }
    public function updateAccountData($data) {
    	if ($this->session->user_id) {
    		$this->db->WHERE('user_id', $this->session->user_id)
    			->UPDATE('user_tbl', $data);
    	}
    }
    public function getMembersCount() {
    	if (isset($this->session->admin)) {
    		return $this->db->GET('user_tbl')->num_rows();
    	}
    }
    public function getTotalSales() {
        if (isset($this->session->admin)) {
            $query = $this->db->SELECT_SUM('pt.cost')
                ->FROM('package_tbl as pt')
                ->JOIN('activation_code_tbl as act', 'act.p_id=pt.p_id')
                ->WHERE('act.status', 'used')
                ->GET()->row_array();

            return number_format( $query['cost'], 2);
        }
    }
    public function getWithdrawRequest() {
        if (isset($this->session->admin)) {
            $query = $this->db->SELECT_SUM('amount')
                ->WHERE('status', 'pending')
                ->GET('withdraw_request_tbl')->row_array();

            return '₱ '.number_format( $query['amount'], 2);
        }
    }
    public function checkEmail($email_address) {
    	if (isset($this->session->user_id)) {
    		$sameEmail = $this->db->WHERE('email_address', $email_address)
    			->WHERE('user_id', $this->session->user_id)
    			->GET('user_tbl')->num_rows();

    		$emailExisting = $this->db->WHERE('email_address', $email_address)
    			->GET('user_tbl')->num_rows();
    			

    		if ($sameEmail > 0) {
    			return 'no_changes';
    		}
    		else if( $emailExisting > 0){
    			return 'existing';
    		}
    	}
    }
    public function checkUsername($username) {
    	if (isset($this->session->user_id)) {
    		return $this->db->WHERE('username', $username)
    			->GET('user_tbl')->num_rows();
    	}
    }
    public function checkMobNumber($mobile_number) {
    	if (isset($this->session->user_id)) {
    		$sameNumber = $this->db->WHERE('mobile_number', $mobile_number)
    			->WHERE('user_id', $this->session->user_id)
    			->GET('user_tbl')->num_rows();
    		
    		$numberExisting = $this->db->WHERE('mobile_number', $mobile_number)
    			->GET('user_tbl')->num_rows();

    		if ($sameNumber > 0) {
    			return 'no_changes';
    		}
    		else if( $numberExisting > 0){
    			return 'existing';
    		}
    	}
    }
    public function updateProfileImg(){
    	$path = "assets/images/users/"; // upload directory
		$config['upload_path'] = 'assets/images/users/';
        $config['allowed_types'] = 'gif|jpg|png|webp';
        $config['max_size'] = 2000; /* MAX OF 2 MB*/
        $config['max_width'] = 5000; /* MAX OF 5000 PX*/
        $config['max_height'] = 5000; /* MAX OF 5000 PX*/
        $config['encrypt_name'] = true; 
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('profile_image')) {
            $error = array('error' => $this->upload->display_errors());
           	$response['status'] = 'error';
           	$response['message'] = $error;
        }
        else {
            $data = array('image_metadata' => $this->upload->data());
            $path = $path.$data['image_metadata']['file_name'];
            $dataArr = array (
		 		'image'=>$path,
		 	);
     		$this->db->WHERE('user_id', $this->session->user_id)->UPDATE('user_tbl',$dataArr);

            $response['success'] = 'Profile Image Uploaded!';
            $response['full_path'] = base_url().$path;
           	$response['status'] = 'success';
            // $response['message'] = $data;
        }

		return $response;
    }
    public function getUserInfo() {
    	if (isset($this->session->admin) ) {
    		$q = $this->db->SELECT('user_id, user_code, username, email_address, address, fname, lname, mobile_number, user_type, registration_type, website_invites_status, sponsor_id, registration_type, package_used, created_at')
    			->WHERE('user_code', $this->input->get('user_code'))
    			->GET('user_tbl')->row_array();
			$sponsor = $this->db->SELECT('fname, lname, user_code')->WHERE('user_code', $q['sponsor_id'])->GET('user_tbl')->row_array();


    		$data['user_code'] = $q['user_code'];
    		$data['user_id'] = $q['user_id'];
			$data['username'] = ucwords($q['username']);
			$data['name'] = ucwords($q['fname'].' '.$q['lname']);
			$data['email_address'] = $q['email_address'];
			$data['user_type'] = $q['user_type'];
			$data['address'] = $q['address'];
			$data['registration_type']=$q['registration_type'];
			$data['package'] = ($q['registration_type'] == 'website_invites') ? $q['package_used'] : '';
			$data['mobile_number'] = $q['mobile_number'];
			$data['invite_status'] = $q['website_invites_status'];
			$data['sponsor'] = ($q['registration_type'] == 'website_invites') ? $sponsor['fname'].' '.$sponsor['lname'] : '';
			$data['sponsor_id'] = ($q['registration_type'] == 'website_invites') ? $sponsor['user_code'] : '';
			$data['created_at'] = date('m/d/Y h:i A', strtotime($q['created_at']));

			return $data;
    	}
    }
    public function checkUserDataPOST($user_code){
    	if (isset($this->session->admin)) {
    		return $this->db->WHERE('user_code', $user_code)
    			->GET('user_tbl')->row_array();
    	}
    }
    public function getPackageActivationCode($package){
    	if (isset($this->session->admin)) {
    		return $this->db->WHERE('p_id', $package)
    			->WHERE('status', 'new')
    			->GET('activation_code_tbl')->row_array();
    	}
    }
    public function insertPackageCode($packageData, $user_code){
    	$dataActivCode = array(
    		'status'=>'used',
    		'updated_at'=>date('Y-m-d H:i:s'),
    	);
    	$this->db->WHERE('code', $packageData['code'])->UPDATE('activation_code_tbl', $dataActivCode);

    	$dataActivCode = array(
    		'status'=>'used',
    		'code'=>$packageData['code'],
    		'p_id'=>$packageData['p_id'],
    		'user_code'=>$user_code,
    		'created_at'=>date('Y-m-d H:i:s'),
    	);
    	$this->db->INSERT('user_code_tbl', $dataActivCode);

    }
     public function changeWebsiteInvitesStatus($user_code, $code){
    	$dataActivCode = array(
    		'member_code'=>$code,
    		'website_invites_status'=>'active',
    		'updated_at'=>date('Y-m-d H:i:s'),
    	);
    	$this->db->WHERE('user_code', $user_code)->UPDATE('user_tbl', $dataActivCode);


    }
    public function generateAffiliateID($length = 5) {
	    $characters = '0123456789abcdef';
	    $charactersLength = strlen($characters);
	    $random_id = '';
	    for ($i = 0; $i < $length; $i++) {
	        $random_id .= $characters[rand(0, $charactersLength - 1)];
	    }

	    $checkedAffID = $this->db->WHERE('aff_id', $random_id)->GET('user_tbl')->num_rows();
	    if ($checkedAffID > 0) {
	    	$this->generateAffiliateID();
	    }
	    else{
	    	$dataArr = array('aff_id'=>$random_id);
	    	$this->db->WHERE('user_code',$this->session->user_code)->UPDATE('user_tbl', $dataArr);
		    return $random_id;
	    }
	}
	public function getUserAffId(){
		$userData = $this->db->SELECT('user_code, aff_id, website_invites_status')->WHERE('user_code', $this->session->user_code)->GET('user_tbl')->row_array();
        
        if($userData['website_invites_status'] == 'inactive') {
            $data['status'] = 'failed';
            $data['response'] = 'Kindly Activate your account first and Start Earning!';
            $data['aff_link'] = 'None';
        }
        else if(empty( $userData['aff_id']) && $userData['website_invites_status'] == 'active') {
            $aff_id = $this->member_model->generateAffiliateID();
            $data['status'] = 'success';
            $data['response'] = 'Affiliate Link Copied!';
            $data['aff_link'] = base_url('invite/').$aff_id;
        }
        else if (!empty( $userData['aff_id']) && $userData['website_invites_status'] == 'active'){
            $data['status'] = 'success';
            $data['response'] = 'Affiliate Link Copied!';
            $data['aff_link'] = base_url('invite/').$userData['aff_id'];
        }
        return $data;
	}
	public function newStockist() {
		if (isset($this->session->admin)) {
			$user_code = $this->input->post('user_code');

			$dataArr = array(
				'type'=>'stockist',
			);
			$this->db->WHERE('user_code', $user_code)->UPDATE('user_tbl', $dataArr);

			$activity_log = array(
	    		'user_id'=>$this->session->user_id, 
	    		'message_log'=> 'User: '.$this->input->post('name'). ' added as a Stockist.',
	    		'ip_address'=>$this->input->ip_address(), 
	    		'platform'=>$this->agent->platform(), 
	    		'browser'=>$this->agent->browser(),
	    		'created_at'=>date('Y-m-d H:i:s')
	    	); 
			$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

			$data['status'] = 'success';
            $data['message'] =  $this->input->post('name').' is now a Stockist!';
            return $data;
		}
	}
	public function removeStockist() {
		if (isset($this->session->admin)) {
			$user_code = $this->input->post('user_code');

			$dataArr = array(
				'type'=>'default',
			);
			$this->db->WHERE('user_code', $user_code)->UPDATE('user_tbl', $dataArr);

			$activity_log = array(
	    		'user_id'=>$this->session->user_id, 
	    		'message_log'=> 'User: '.$this->input->post('name'). ' was Removed as a Stockist',
	    		'ip_address'=>$this->input->ip_address(), 
	    		'platform'=>$this->agent->platform(), 
	    		'browser'=>$this->agent->browser(),
	    		'created_at'=>date('Y-m-d H:i:s')
	    	); 
			$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */


			$data['status'] = 'success';
            $data['message'] =  $this->input->post('name').' was now removed as a Stockist!';

            return $data;
		}
	}

	public function getStockistList($row_per_page, $row_no){
		if ($this->session->user_type == 'admin') {

    		$query = $this->db->SELECT('fname, lname, user_code') # SUM(pt.srp_price) as total_sales
	    		->WHERE('type', 'stockist')
	    		->FROM('user_tbl as ut')
	    		// ->JOIN('stockist_transactions_tbl as stt','stt.stockist_user_code=ut.user_code')
	    		// ->JOIN('products_tbl as pt','stt.p_id=pt.p_id')
				->ORDER_BY('ut.lname', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$total_stocks = $this->db->SELECT('SUM(qty) as stocks')->WHERE('user_code', $q['user_code'])->GET('stockist_stocks_tbl')->row_array();
				$sold = $this->db->WHERE('stockist_user_code', $q['user_code'])->GET('stockist_transactions_tbl')->num_rows();
				$sales = $this->stockistTotalSales($q['user_code']);

				$array = array(
					'name'=>$q['fname'].' '.$q['lname'],
					'user_code'=>$q['user_code'],
					'sold'=> $sold,
					'total_sales'=>'₱ '.number_format($sales['total_sales'], 2),
					'stocks'=>$total_stocks['stocks'],
				);
				array_push($result, $array);
			}
			return $result;
    	}
	}
	public function getStockistListCount(){
		if ($this->session->user_type == 'admin') {
    		return $this->db->WHERE('type', 'stockist')
				->GET('user_tbl')->num_rows();
    	}
	}
	public function stockistTotalSales($user_code) {
		return $this->db->SELECT('SUM(pt.srp_price) as total_sales')
			->FROM('products_tbl as pt')
			->JOIN('stockist_transactions_tbl as stt', 'stt.p_id=pt.p_id')
			->WHERE('stt.stockist_user_code', $user_code)
			->GET()->row_array();
	}
	public function adminGetUserCodeHistory ($row_per_page, $row_no) {
    	if (isset($this->session->admin)){
    		$query = $this->db->SELECT('uct.code, ut.fname, ut.lname, ut.user_code, pt.name as package_name, uct.created_at as date_purchased, uct.updated_at as date_used')
	    		->FROM('user_code_tbl as uct')
	    		->JOIN('user_tbl as ut', 'ut.member_code = uct.code', 'left')
	    		->JOIN('activation_code_tbl as act', 'act.code = uct.code', 'left')
	    		->JOIN('package_tbl as pt', 'pt.p_id = act.p_id', 'left')
				->WHERE('ut.sponsor_id', $this->input->get('user_code'))
				->WHERE('uct.status', 'used')
				->ORDER_BY('ut.created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'code'=>$q['code'],
					'package_name'=>$q['package_name'],
					'date_purchased'=>date('m/d/Y h:i A', strtotime($q['date_purchased'])),
					'date_used'=>date('m/d/Y h:i A', strtotime($q['date_used'])),
					'used_by'=>$q['fname'].' '.$q['lname'],
					'user_code'=>$q['user_code']
				);
				array_push($result, $array);
			}
			return $result;
    	}
    }
    public function adminGetUserCodeHistoryCount () {
    	if (isset($this->session->admin)){
    		return $this->db->FROM('user_code_tbl as uct')
	    		->JOIN('user_tbl as ut', 'ut.member_code = uct.code', 'left')
				->WHERE('ut.sponsor_id', $this->input->get('user_code'))
				->WHERE('uct.status', 'used')
				->GET()->num_rows();
    	}
    }

}
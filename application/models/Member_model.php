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
				$array = array(
					'ac_id'=>$q['ac_id'],
					'code'=>$q['code'],
					'status'=>$q['status'],
					'package_name'=>$q['name'],
					'cost'=>'₱ '.number_format($q['cost'], 2),
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
    }
    public function deleteCode () {
		$this->db->WHERE('ac_id', $this->input->post('id'))->DELETE('activation_code_tbl');
		$response['status'] = 'success';
		$response['message'] = 'Member Code successfully deleted';
		return $response;
	}
	public function getUsers() {
		if ($this->session->user_type == 'admin') {
			$search = $this->input->get('keyword');
			$query = $this->db->SELECT('fname, lname, user_code, user_type, status')
				->LIKE('fname', $search)
				->OR_LIKE('lname', $search)
				->OR_LIKE('user_code', $search)
				->OR_LIKE('mobile_number', $search)
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
			return $result;
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
	public function getMemberActivationCodeCount () {
    	$userData = $this->db->SELECT('user_code')->WHERE('user_id', $this->session->user_id)->GET('user_tbl')->row_array();

    	return $this->db->WHERE('user_code', $userData['user_code'])
			->GET('user_code_tbl')->num_rows();
    }
    public function getMemberActivationCodes ($row_per_page, $row_no) {
    	$query = $this->db->SELECT('uc_id, uct.code, pt.name as package_name, uct.created_at as date_purchased')
    		->FROM('user_code_tbl as uct')
    		->JOIN('activation_code_tbl as act', 'act.code = uct.code', 'left')
    		->JOIN('package_tbl as pt', 'pt.p_id = act.p_id', 'left')
			->WHERE('user_code', $this->session->user_code)
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
				'name'=>$q['fname'].' '.$q['lname'],
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
    		$query = $this->db->SELECT('user_code, fname, lname, mobile_number, user_type, created_at')
	    		->FROM('user_tbl')
				->ORDER_BY('created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'user_code'=>$q['user_code'],
					'name'=>$q['fname'].' '.$q['lname'],
					'mobile_number'=>$q['mobile_number'],
					'user_type'=>$q['user_type'],
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
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
}
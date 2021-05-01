<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Binary_model extends CI_Model {
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
	public function getBinaryTree() {
		$data = $this->db->SELECT('fname, lname, user_code')
			->WHERE('user_code', $this->input->get('user_code'))
			->GET('user_tbl')->row_array();

		$data['direct'] = $this->getDownlineUsers($data['user_code']);
		return $data;
	}
	public function getDownlineUsers($user_code) {
		$downline = $this->db->SELECT('fname, lname, user_code, sponsor_id, position')
			->WHERE('link_id', $user_code)
			->GET('user_tbl')->result_array();
		$result = array();
		foreach ($downline as $r) {
			$arr =array(
				'fname'=>$r['fname'],
				'lname'=>$r['lname'],
				'user_code'=>$r['user_code'],
				'sponsor_id'=>$r['sponsor_id'],
				'position'=>$r['position'],
				'dLvl2'=>$this->get2ndLvlDownlineUser($r['user_code']),
			);
			array_push($result, $arr);
		}
		return $result;
	}
	public function get2ndLvlDownlineUser($user_code) {
		$query = $this->db->SELECT('fname, lname, user_code, sponsor_id, position')
			->WHERE('link_id', $user_code)
			->GET('user_tbl')->result_array();
		return $query;
	}
	public function getSponsorData($sponsorID) {
		$query = $this->db->WHERE('user_code', $sponsorID)
			->GET('user_tbl')->row_array();
		
		return $query;
	}
	public function getLinkData($linkID) {
		$query = $this->db->WHERE('user_code', $linkID)
			->GET('user_tbl')->row_array();
		
		return $query;
	}
	public function checkSponsorCreditBySponsorID($sponsorID) {
		$query = $this->db->WHERE('user_code', $sponsorID)
			->WHERE('status','new')
			->GET('user_code_tbl')->num_rows();
		
		return $query;
	}
	public function checkSponsorCredit($package_code) {
		$query = $this->db->WHERE('code', $package_code)
			->WHERE('status','new')
			->GET('user_code_tbl')->num_rows();
		
		return $query;
	}
	public function checkLinkID($linkID) {
		$query = $this->db->WHERE('user_code', $linkID)
			->GET('user_tbl')->num_rows();
		
		return $query;
	}
	public function registerUser() {
		$user['sponsorID'] = $this->input->post('sponsorID');
        $user['linkID'] = $this->input->post('linkID');
		$user['username'] = $this->input->post('username');
		$user['fname'] = $this->input->post('fname');
        $user['lname'] = $this->input->post('lname');
        $user['position'] = $this->input->post('position');
        $user['mobile_number'] = $this->input->post('mobile_number');
        $user['password'] = $this->input->post('password');
        $user['package_code'] = $this->input->post('package_code');
        
        $checkSponsor = $this->checkSponsorCredit($user['package_code']);
		$checkLinkID = $this->checkLinkID($user['linkID']);

		if ($checkSponsor <= 0){
			$response['status'] = 'failed';
			$response['message'] = "You don't have enough code credit. Invite users and try again!";
		}

		else if($checkLinkID <= 0) {
			$response['status'] = 'failed';
			$response['message'] = "No Link user detected. Please try again!";
		}

		else if($checkSponsor > 0 && $checkLinkID > 0) {
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
				$referred_id = $this->insertNewAccountData($user, $user['package_code']);
				$this->insertDirectReferralBonus($user['sponsorID'], $referred_id, $user['package_code']);
				$response['status'] = 'success';
				$response['message'] = 'User successfully registered!';
			}
		}
		else{
			$response['status'] = 'failed';
			$response['message'] = 'Something went wrong. Please try again!';
		}
		return $response;
	}

	public function insertNewAccountData ($user, $package_code) {
		$user_type = 'member';
		$data = array(
			'sponsor_id'=>$user['sponsorID'],
			'link_id'=>$user['linkID'],
			'member_code'=>$package_code,
			'position'=>$user['position'],
			'username'=>$user['username'],
			'fname'=>$user['fname'],
			'lname'=>$user['lname'],
			'mobile_number'=>$user['mobile_number'],
			'password'=>$this->hash_password($user['password']),
			'status'=>'inactive',
			'user_type'=>$user_type,
			'created_at'=>date('Y-m-d H:i:s')
		);
		$this->db->INSERT('user_tbl', $data);
		$id = $this->db->insert_id();

		$this->generateUserCode($id); /* INSERT user unique USER_CODE*/
		
		$notif_log = array('user_id'=>$id, 'message'=>'Welcome to Herbal House!','created_at'=>date('Y-m-d H:i:s')); 
		$this->insertNewNotification($notif_log); /* INSERT new Notification */

		$activity_log = array('user_id'=>$id, 'message_log'=>'Created account','ip_address'=>$this->input->ip_address(), 'platform'=>$this->agent->platform(), 'browser'=>$this->agent->browser(),'created_at'=>date('Y-m-d H:i:s')); 
		$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

		/* Update activation code*/
		$newCodeStatus = array('status'=>'used', 'updated_at'=>date('Y-m-d H:i:s'));
		$this->db->WHERE('code', $package_code) 
			->UPDATE('user_code_tbl', $newCodeStatus);

		$this->db->WHERE('code', $package_code) 
			->UPDATE('activation_code_tbl', $newCodeStatus);

		return $id;
	}
	public function insertNewNotification ($notif_log) {
		$this->db->INSERT('notification_tbl', $notif_log);
	}
	public function insertActivityLog ($activity_log) {
		$this->db->INSERT('activity_logs_tbl', $activity_log);
	}
	public function insertDirectReferralBonus ($sponsorID, $referred_id, $package_code) {

		$referred_user = $this->db->SELECT('user_code, member_code')->WHERE('user_id', $referred_id)->GET('user_tbl')->row_array();

		/* Get the points based on what package does the referred user purchased */
		$packageData = $this->db->SELECT('pt.direct_points, pt.match_points, act.code')
			->FROM('package_tbl as pt')
			->JOIN('activation_code_tbl as act','act.p_id = pt.p_id')
			->WHERE('act.code', $package_code)
			->GET()->row_array();

		/* EARNED FOR DIRECT REFERRAL */ 
		$dataArr = array(
			'user_code'=>$sponsorID,
			'amount'=>$packageData['direct_points'],
			'status'=>'direct_referral',
			'created_at'=>date('Y-m-d H:i:s')
		);
		$this->db->INSERT('wallet_tbl',$dataArr);

		/* INSERT UNILEVEL DATA */
		$this->insertUniLvlData($sponsorID, $referred_user['user_code']);

		/* INSERT new ACIVITY LOG */
		$activity_log = array(
			'user_id'=>$this->session->user_id, 
			'message_log'=>'Earned ₱'.number_format($packageData['direct_points'], 2).' from direct referral from user #'.$referred_user['user_code'].'.',
			'ip_address'=>$this->input->ip_address(), 
			'platform'=>$this->agent->platform(), 
			'browser'=>$this->agent->browser(),
			'created_at'=>date('Y-m-d H:i:s')
		); 
		$this->insertActivityLog($activity_log); 

		/* INSERT new Notification */
		$notif_log = array(
			'user_id'=>$this->session->user_id, 
			'message'=>'Congrats! You get ₱'.number_format($packageData['direct_points'], 2).' for direct referral.',
			'created_at'=>date('Y-m-d H:i:s')
		); 
		$this->insertNewNotification($notif_log); 
	}
	public function getPackageCredit () {
    	$query = $this->db->SELECT('pt.name as package_name, uct.uc_id, uct.code, uct.created_at as date_purchased')
    		->FROM('user_code_tbl as uct')
    		->JOIN('package_tbl as pt', 'pt.p_id = uct.p_id')
    		->GROUP_BY('uct.p_id')
			->WHERE('uct.user_code', $this->session->user_code)
			->WHERE('uct.status','new')
			->ORDER_BY('uct.created_at', 'DESC')
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
	public function insertUniLvlData($sponsorID, $referred_user) {
		/* UNI LEVEL FEATURE */ 
		
		// $this->insertUniLvlBonus($referred_user);
		if (isset($this->session->user_id)) {

			/* LEVEL 10*/ 
			$uniLvl10 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 9) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			/* LEVEL 9*/ 
			$uniLvl9 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 8) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			/* LEVEL 8*/ 
			$uniLvl8 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 7) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			/* LEVEL 7*/ 
			$uniLvl7 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 6) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			/* LEVEL 6*/ 
			$uniLvl6 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 5) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			/* LEVEL 5*/ 
			$uniLvl5 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 4) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			/* LEVEL 4*/ 
			$uniLvl4 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 3) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			/* LEVEL 3*/ 
			$uniLvl3 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 2) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			/* LEVEL 2*/ 
			$uniLvl2 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 1) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			/* LEVEL 1*/ 
			$uniLvl1 = $this->db->SELECT('sponsor_id')
				->WHERE('sponsor_id', $sponsorID)
				->WHERE('user_code',  $referred_user)
				->GET('user_tbl')->row_array();


			if (isset($uniLvl10)) {
				$dataUniLvl10 = array(
					'sponsor_id'=>$uniLvl4['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>10,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl10);
			}

			if (isset($uniLvl9)) {
				$dataUniLvl9 = array(
					'sponsor_id'=>$uniLvl4['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>9,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl9);
			}

			if (isset($uniLvl8)) {
				$dataUniLvl8 = array(
					'sponsor_id'=>$uniLvl4['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>8,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl8);
			}

			if (isset($uniLvl7)) {
				$dataUniLvl7 = array(
					'sponsor_id'=>$uniLvl4['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>7,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl7);
			}

			if (isset($uniLvl6)) {
				$dataUniLvl6 = array(
					'sponsor_id'=>$uniLvl4['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>6,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl6);
			}

			if (isset($uniLvl5)) {
				$dataUniLvl5 = array(
					'sponsor_id'=>$uniLvl4['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>5,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl5);
			}

			if (isset($uniLvl4)) {
				$dataUniLvl4 = array(
					'sponsor_id'=>$uniLvl4['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>4,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl4);
			}

			if (isset($uniLvl3)) {
				$dataUniLvl3 = array(
					'sponsor_id'=>$uniLvl3['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>3,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl3);
			}

			if (isset($uniLvl2)) {
				$dataUniLvl2 = array(
					'sponsor_id'=>$uniLvl2['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>2,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl2);
			}

			if (isset($uniLvl1)) {
				$dataUniLvl1 = array(
					'sponsor_id'=>$uniLvl1['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>1,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl1);
			}


		}
	}
	public function insertUniLvlBonus($referred_user) {
		/* EARNED FOR DIRECT REFERRAL */ 
		$dataArr = array(
			'user_code'=>$sponsorID,
			'amount'=>10,
			'status'=>'uni_lvl_bonus',
			'created_at'=>date('Y-m-d H:i:s')
		);
		$this->db->INSERT('wallet_tbl',$dataArr);
	}
	


}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Binary_model extends CI_Model {
	/*
	Sales_match_tbl = all points registered 
	User_sales_match_monitor_tbl = all SUCCESS sales match recorded here
	User_sales_match_tbl = right and left points recored here as monitored

	*/ 
	private function hash_password($password){
	   return password_hash($password, PASSWORD_BCRYPT);
	}
	public function generateUserCode ($id, $length = 13) {
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $u_code = '10000'.$randomString.$id;

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
		$data = $this->db->SELECT('fname, lname, user_code, image')
			->WHERE('user_code', $this->input->get('user_code'))
			->GET('user_tbl')->row_array();
		$data['direct'] = $this->getDownlineUsers($data['user_code']);
		return $data;
	}
	public function getDownlineUsers($user_code) {
		$downline = $this->db->SELECT('fname, lname, user_code, sponsor_id, position, image')
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
				'image' => $r['image'],
				'dLvl2'=>$this->get2ndLvlDownlineUser($r['user_code']),
			);
			array_push($result, $arr);
		}
		return $result;
	}
	public function get2ndLvlDownlineUser($user_code) {
		$query = $this->db->SELECT('fname, lname, user_code, sponsor_id, position, image')
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
		if (isset($this->session->user_id)) {
			$query = $this->db->WHERE('user_code', $linkID)
				->GET('user_tbl')->num_rows();
			return $query;
		}
	}
	public function registerUser() {
		if (isset($this->session->user_id)) {
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

			if(strlen($user['mobile_number']) < 11) {
				$response['status'] = 'failed';
				$response['message'] = "Please enter a correct mobile number!";
			}
			else if ($checkSponsor <= 0){
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
					// $this->insertSalesMatchPoints();
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
	}

	public function insertNewAccountData ($user, $package_code) {
		if (isset($this->session->user_id)) {
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
	}
	public function insertNewNotification ($notif_log) {
		$this->db->INSERT('notification_tbl', $notif_log);
	}
	public function insertActivityLog ($activity_log) {
		if (isset($this->session->user_id)) {
			$this->db->INSERT('activity_logs_tbl', $activity_log);
		}
	}
	public function insertDirectReferralBonus ($sponsorID, $referred_id, $package_code) {
		if (isset($this->session->user_id)) {
			$referred_user = $this->db->SELECT('user_code, member_code')->WHERE('user_id', $referred_id)->GET('user_tbl')->row_array();

			/* Get the points based on what package does the referred user purchased */
			$packageData = $this->db->SELECT('pt.direct_points, pt.match_points, act.code, pt.profit_sharing_points')
				->FROM('package_tbl as pt')
				->JOIN('activation_code_tbl as act','act.p_id = pt.p_id')
				->WHERE('act.code', $package_code)
				->GET()->row_array();

			/* EARNED FOR DIRECT REFERRAL */ 
			$this->insertDirectReferralCashBonus($sponsorID, $packageData);

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
				'message'=>'Congrats! You get ₱'.number_format($packageData['direct_points'], 2).' from direct referral.',
				'created_at'=>date('Y-m-d H:i:s')
			); 
			$this->insertNewNotification($notif_log); 
		}
	}
	public function getPackageCredit () {
		if (isset($this->session->user_id)) {
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
	}
	public function insertUniLvlData($sponsorID, $referred_user) {
		/* UNILEVEL FEATURE FOR ENTRY LEVEL AND REPEAT PURCHASE*/ 
		if (isset($this->session->user_id)) {
			
			/* 1 - 10th is for the entry unilevel detection points */ 
			/* LEVEL 1*/ 
			$uniLvl1 = $this->db->SELECT('sponsor_id, link_id')
				->WHERE('sponsor_id', $sponsorID)
				->WHERE('user_code',  $referred_user)
				->GET('user_tbl')->row_array();
			if (isset($uniLvl1)) {
				$dataUniLvl1 = array(
					'sponsor_id'=>$uniLvl1['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>1,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl1);
				$this->insertUniLvlBonus($uniLvl1['sponsor_id'], $referred_user);
				$this->insertSalesMatch($uniLvl1['sponsor_id'], $referred_user, 1);
			}


			/* LEVEL 2*/ 
			$uniLvl2 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 1) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			$linkData = $this->db->SELECT('link_id')->WHERE('user_code',  $referred_user)->GET('user_tbl')->row_array();
			if (isset($uniLvl2)) {
				$dataUniLvl2 = array(
					'sponsor_id'=>$uniLvl2['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>2,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl2);
				$this->insertUniLvlBonus($uniLvl2['sponsor_id'], $referred_user);
				$this->insertSalesMatch($uniLvl2['sponsor_id'], $referred_user, 2);
			}


			/* LEVEL 3*/ 
			$uniLvl3 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 2) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl3)) {
				$dataUniLvl3 = array(
					'sponsor_id'=>$uniLvl3['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>3,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl3);
				$this->insertUniLvlBonus($uniLvl3['sponsor_id'], $referred_user);
				$this->insertSalesMatch($uniLvl3['sponsor_id'], $referred_user, 3);
			}


			/* LEVEL 4*/ 
			$uniLvl4 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 3) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();

			if (isset($uniLvl4)) {
				$dataUniLvl4 = array(
					'sponsor_id'=>$uniLvl4['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>4,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl4);
				$this->insertUniLvlBonus($uniLvl4['sponsor_id'], $referred_user);
				$this->insertSalesMatch($uniLvl4['link_id'], $referred_user, 4);
			}

			/* LEVEL 5*/ 
			$uniLvl5 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 4) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl5)) {
				$dataUniLvl5 = array(
					'sponsor_id'=>$uniLvl5['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>5,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl5);
				$this->insertUniLvlBonus($uniLvl5['sponsor_id'], $referred_user);
				$this->insertSalesMatch($uniLvl5['link_id'], $referred_user, 5);
			}

			
			/* LEVEL 6*/ 
			$uniLvl6 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 5) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl6)) {
				$dataUniLvl6 = array(
					'sponsor_id'=>$uniLvl6['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>6,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl6);
				$this->insertUniLvlBonus($uniLvl6['sponsor_id'], $referred_user);
				$this->insertSalesMatch($uniLvl6['sponsor_id'], $referred_user, 6);
			}

			/* LEVEL 7*/ 
			$uniLvl7 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 6) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl7)) {
				$dataUniLvl7 = array(
					'sponsor_id'=>$uniLvl7['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>7,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl7);
				$this->insertUniLvlBonus($uniLvl7['sponsor_id'], $referred_user);
				$this->insertSalesMatch($uniLvl7['sponsor_id'], $referred_user, 7);
			}

			/* LEVEL 8*/ 
			$uniLvl8 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 7) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl8)) {
				$dataUniLvl8 = array(
					'sponsor_id'=>$uniLvl8['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>8,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl8);
				$this->insertUniLvlBonus($uniLvl8['sponsor_id'], $referred_user);
				$this->insertSalesMatch($uniLvl8['sponsor_id'], $referred_user, 8);
			}

			/* LEVEL 9*/ 
			$uniLvl9 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 8) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl9)) {
				$dataUniLvl9 = array(
					'sponsor_id'=>$uniLvl9['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>9,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl9);
				$this->insertUniLvlBonus($uniLvl9['sponsor_id'], $referred_user);
				$this->insertSalesMatch($uniLvl9['sponsor_id'], $referred_user, 9);
			}

			/* LEVEL 10*/ 
			$uniLvl10 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 9) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl10)) {
				$dataUniLvl10 = array(
					'sponsor_id'=>$uniLvl10['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>10,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl10);
				$this->insertUniLvlBonus($uniLvl10['sponsor_id'], $referred_user);
				$this->insertSalesMatch($uniLvl10['sponsor_id'], $referred_user, 10);
			}


			/* 1 - 15th is for the Product unilevel detection */ 


			/* LEVEL 11*/ 
			$uniLvl11 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 10) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl11)) {
				$dataUniLvl11 = array(
					'sponsor_id'=>$uniLvl11['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>11,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl11);
				$this->insertSalesMatch($uniLvl11['sponsor_id'], $referred_user, 11);
			}


			/* LEVEL 12*/ 
			$uniLvl12 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 11) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl12)) {
				$dataUniLvl12 = array(
					'sponsor_id'=>$uniLvl12['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>12,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl12);
				$this->insertSalesMatch($uniLvl12['sponsor_id'], $referred_user, 12);
			}


			/* LEVEL 13*/ 
			$uniLvl13 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 12) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl13)) {
				$dataUniLvl13 = array(
					'sponsor_id'=>$uniLvl13['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>13,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl13);
				$this->insertSalesMatch($uniLvl13['sponsor_id'], $referred_user, 123);
			}


			/* LEVEL 14*/ 
			$uniLvl14 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 13) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl14)) {
				$dataUniLvl14 = array(
					'sponsor_id'=>$uniLvl14['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>14,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl14);
				$this->insertSalesMatch($uniLvl14['sponsor_id'], $referred_user, 14);
			}
			
	
			/* LEVEL 15*/ 
			$uniLvl15 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 14) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl15)) {
				$dataUniLvl15 = array(
					'sponsor_id'=>$uniLvl15['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>15,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl15);
				$this->insertSalesMatch($uniLvl15['sponsor_id'], $referred_user, 15);
			}

			/* LEVEL 16*/ 
			$uniLvl16 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 15) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl16)) {
				$dataUniLvl16 = array(
					'sponsor_id'=>$uniLvl16['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>16,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl16);
				$this->insertSalesMatch($uniLvl16['sponsor_id'], $referred_user, 16);
			}

			/* LEVEL 17*/ 
			$uniLvl17 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 16) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl17)) {
				$dataUniLvl17 = array(
					'sponsor_id'=>$uniLvl17['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>17,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl17);
				$this->insertSalesMatch($uniLvl17['sponsor_id'], $referred_user, 17);
			}

			/* LEVEL 18*/ 
			$uniLvl18 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 17) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl18)) {
				$dataUniLvl18 = array(
					'sponsor_id'=>$uniLvl18['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>18,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl18);
				$this->insertSalesMatch($uniLvl18['sponsor_id'], $referred_user, 18);
			}

			/* LEVEL 18*/ 
			$uniLvl18 = $this->db->SELECT('sponsor_id, referred_id, level')
				->WHERE('referred_id', $sponsorID)
				->WHERE('level', 17) /* previous lvl*/
				->GET('unilevel_tbl')->row_array();
			if (isset($uniLvl18)) {
				$dataUniLvl18 = array(
					'sponsor_id'=>$uniLvl18['sponsor_id'],
					'referred_id'=>$referred_user,
					'level'=>18,
				); 
				$this->db->INSERT('unilevel_tbl', $dataUniLvl18);
				$this->insertSalesMatch($uniLvl18['sponsor_id'], $referred_user, 18);
			}
		}
	}

	public function insertSalesMatch($sponsor_id, $referred_user, $level) {
		if (isset($this->session->user_id)) {

			/* get sales match points of the referred user's package */ 
			$packageData = $this->db->SELECT('pt.p_id, pt.match_points, pt.am_maximum_points, pt.pm_maximum_points')
				->FROM('package_tbl as pt')
				->JOIN('user_code_tbl as uct','uct.p_id = pt.p_id')
				->JOIN('user_tbl as ut','ut.member_code = uct.code')
				->WHERE('ut.user_code', $referred_user )
				->GET()->row_array();

			/* IDENTIFY IF ITS AM OR PM */ 
			$dateNow = date('A');
			$am_match_points = 0;
			$pm_match_points = $packageData['match_points'];
			if ($dateNow == 'AM') {
				/* morning */ 
				$am_match_points = $packageData['match_points'];
				$pm_match_points = 0;
			}



			/*  GET USER'S LEVEL POSITION (RIGHT OR LEFT) TO IDENTIFY WHO IS MY LEFT SIDE AND RIGHT SIDE FOR SALES MATCH*/ 
			if ($level == 1) {
				// $checkUserDirect = $this->db->WHERE('sponsor_id', $sponsor_id)->GET('user_tbl')->num_rows();
				// if ($checkUserDirect == 1){
				// 	$checkUser = $this->db->SELECT('position')->WHERE('user_code', $referred_user)->GET('user_tbl')->row_array();
				// }
				// else if ($checkUserDirect > 1) {
				// 	$checkUser = $this->db->SELECT('position')->WHERE('user_code', $referred_user)->GET('user_tbl')->row_array();
				// }

				// $checkUserDirect = $this->db->WHERE('sponsor_id', $sponsor_id)->GET('user_tbl')->num_rows();

				$userDirectLink = $this->db
					->WHERE('sponsor_id', $sponsor_id)
					->WHERE('link_id', $sponsor_id)
					->WHERE('user_code', $referred_user)
					->GET('user_tbl')->row_array();

				$userDirectLinkRefer = $this->db
					->WHERE('sponsor_id', $sponsor_id)
					->WHERE('link_id !=', $sponsor_id)
					->WHERE('user_code', $referred_user)
					->GET('user_tbl')->row_array();


				/* DIRECT REFERRAL WHICH IS LEVEL 1 RIGHT AND LEFT (ONLY 2 MEMBERS CAN BE HERE) */ 
				if(isset($userDirectLink)) {
					$checkUser = $this->db
						->SELECT('position')
						->WHERE('sponsor_id', $sponsor_id)
						->WHERE('link_id', $sponsor_id)
						->WHERE('user_code', $referred_user)
						->GET('user_tbl')->row_array();
				}

				/* DIRECT REFERRAL WHICH CAN BE IN ANY OTHER LEVEL, INVITES WITH DIFFERENT LINK IDs */ 
				else if (isset($userDirectLinkRefer)) {
					$checkUser = $this->db
						->SELECT('position, link_id')
						->WHERE('user_code', $userDirectLinkRefer['link_id'])
						->GET('user_tbl')->row_array();

					/* 
					*INSERT POINTS TO THE LINK ID OF INDIRECT INVITES	
					*/ 
					$this->insertPointsIndirectInvites($sponsor_id, $referred_user, $am_match_points, $pm_match_points, $packageData, $level);
					// $dataArr = array(
					// 	'user_code'=>$sponsor_id,
					// 	'referred_id'=>$referred_user,
					// 	'am_match_points'=>$am_match_points,
					// 	'pm_match_points'=>$pm_match_points,
					// 	'position'=>,
					// 	'level'=>$level,
					// 	'created_at'=>date('Y-m-d H:i:s'),
					// ); 
					// $this->db->INSERT('sales_match_tbl', $dataArr);
				}
			}

			else {
				$level = $level - 1; /* decrement level to get the sponsored id/ upline */
				$checkUser = $this->db->SELECT('ut.position')
					->FROM('user_tbl as ut')
					->JOIN('unilevel_tbl as ult', 'ult.sponsor_id = ut.user_code')
					->WHERE('ult.referred_id', $referred_user)
					->WHERE('ult.level', $level)
					->GET()->row_array();
			}
			
			
			/* START INSERT SALES MATCH ON LEFT OR RIGHT*/ 
			$dataArr = array(
				'user_code'=>$sponsor_id,
				'referred_id'=>$referred_user,
				'am_match_points'=>$am_match_points,
				'pm_match_points'=>$pm_match_points,
				'position'=> $checkUser['position'],
				'level'=>$level,
				'created_at'=>date('Y-m-d H:i:s'),
			); 
			$this->db->INSERT('sales_match_tbl', $dataArr);
			/* END INSERT SALES MATCH ON LEFT OR RIGHT*/ 

			/* INSERT OR UPDATE SALES MATCH POINTS FOR MONITORING AND GETTING BONUS/CASH */ 
			$this->insertUpdateSalesMatchMonitoring($checkUser['position'], $sponsor_id, $am_match_points, $pm_match_points, $packageData);
		}
	}
	public function insertUpdateSalesMatchMonitoring($user_position, $sponsor_id, $am_match_points, $pm_match_points, $packageData){
		$position_col = ($user_position == 'left') ? 'pos_left' : 'pos_right';
		$checkUserSalesMatch = $this->db->WHERE('user_code', $sponsor_id)->GET('user_sales_match_tbl')->row_array();

		$time_points = ($am_match_points !== 0) ? $am_match_points : $pm_match_points;
		$total_points = $time_points + $checkUserSalesMatch[$position_col];
		if (isset($checkUserSalesMatch)) {
			$dataSMArr = array(
				'user_code'=>$sponsor_id,
				$position_col => $total_points ,
				'updated_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->WHERE('user_code', $sponsor_id)->UPDATE('user_sales_match_tbl', $dataSMArr);
		}
		else{
			$dataSMArr = array(
				'user_code'=>$sponsor_id,
				$position_col => $time_points,
				'created_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->INSERT('user_sales_match_tbl', $dataSMArr);
		}

		// if ($level == 1){
		// 	$referred_user_data = $this->db->SELECT('user_id, link_id')->WHERE('user_code', $referred_user)->GET('user_tbl')->row_array();

		// 	$dataSMArr = array(
		// 		'user_code'=>$referred_user_data['link_id'],
		// 		$position_col => $time_points,
		// 		'created_at'=>date('Y-m-d H:i:s'),
		// 	);
		// 	$this->db->INSERT('user_sales_match_tbl', $dataSMArr);
		// }

		/* MATCHING PROCESS OF POINTS RIGHT AND LEFT */
		$this->userSalesMatchPointsReward($sponsor_id, $packageData);
	}
	public function userSalesMatchPointsReward ($sponsor_id, $packageData) {
		$dateNow = date('A');
		if ($dateNow == 'AM') {
			$am_maximum_points = $packageData['am_maximum_points'];
		}
		else if ($dateNow == 'PM'){
			$pm_maximum_points = $packageData['pm_maximum_points'];
		}

		$userSMPoints = $this->db->WHERE('user_code', $sponsor_id)->GET('user_sales_match_tbl')->row_array();


		/* SALES MATCH WILL OCCUR if BOTH RIGHT and LEFT position have points */
		if ($userSMPoints['pos_right'] > 0 && $userSMPoints['pos_left'] > 0) {
			
			if ($userSMPoints['pos_right'] > $userSMPoints['pos_left']) { /* if POS_Right is higher than POS_Left */
				$right_diff = $userSMPoints['pos_right'] - $userSMPoints['pos_left'];
				$left_diff = $userSMPoints['pos_left'] - $userSMPoints['pos_left'];
				$this->updateSalesMatchPoints($sponsor_id, $right_diff, $left_diff);
				$this->insertSaleMatchBonus($sponsor_id, $packageData['match_points']);
			}

			else if($userSMPoints['pos_left'] > $userSMPoints['pos_right']){ /* if POS_Left is higher than POS_Right */
				$left_diff = $userSMPoints['pos_left'] - $userSMPoints['pos_right'];
				$right_diff = $userSMPoints['pos_right'] - $userSMPoints['pos_right'];
				$this->updateSalesMatchPoints($sponsor_id, $right_diff, $left_diff);
				$this->insertSaleMatchBonus($sponsor_id, $packageData['match_points']);
			}
			else if($userSMPoints['pos_right'] == $userSMPoints['pos_left']){ /* if POS_Left and POS_Right are equal */
				$right_diff = $userSMPoints['pos_right'] - $userSMPoints['pos_right'];
				$left_diff = $right_diff;
				$this->updateSalesMatchPoints($sponsor_id, $right_diff, $left_diff);
				$this->insertSaleMatchBonus($sponsor_id, $packageData['match_points']);
			}
			else{

			}
		}
	}
	public function updateSalesMatchPoints($sponsor_id, $right_diff, $left_diff){
		$data_smp = array(
			'pos_right'=>$right_diff,
			'pos_left'=>$left_diff,
			'updated_at'=>date('Y-m-d H:i:s'),
		);
		$this->db->WHERE('user_code', $sponsor_id)->UPDATE('user_sales_match_tbl', $data_smp);
	}
	public function insertSaleMatchBonus($sponsor_id, $match_points){
		/* INSERT NEW SALES MATCH ON THE RECORD */ 

		if (isset($this->session->user_id)) {
			$userData = $this->db->SELECT('user_id')->WHERE('user_code',$sponsor_id)->GET('user_tbl')->row_array();

			/* START INSERT sales match monitor */
			$cSMCount = $this->db->WHERE('user_id', $userData['user_id'])->GET('user_sales_match_monitor_tbl')->num_rows(); /* check sales match count*/

			if (
				$cSMCount == 4 ||  $cSMCount == 9 ||  $cSMCount == 14 || $cSMCount == 19 ||  
				$cSMCount == 24 || $cSMCount == 29 || $cSMCount == 34 ||  $cSMCount == 39 || 
				$cSMCount == 44 || $cSMCount == 49 || $cSMCount == 54 ||  $cSMCount == 59 || 
				$cSMCount == 64 ||  $cSMCount == 69 ||  $cSMCount == 74 ||  $cSMCount == 79 ||
				$cSMCount == 84 ||  $cSMCount == 89 || $cSMCount == 94 ||  $cSMCount == 99 ||
				$cSMCount == 104 ||  $cSMCount == 109 || $cSMCount == 114 || $cSMCount == 119 ||
				$cSMCount == 124 ||  $cSMCount == 129 || $cSMCount == 134 || $cSMCount == 139 ||
				$cSMCount == 144 ||  $cSMCount == 149 || $cSMCount == 154 || $cSMCount == 159 ||
				$cSMCount == 164 ||  $cSMCount == 169 || $cSMCount == 174 || $cSMCount == 179 
			) {
				$status = '5th_pair';
				$this->insertWalletSalesMatch($sponsor_id, $match_points, $status);
			}
			else{
				$status = 'default';
				$this->insertWalletSalesMatch($sponsor_id, $match_points, $status);
			}

			/* INSERT POINTS FOR MONITORING */ 
			$dataArr = array(
				'user_id'=>$userData['user_id'],
				'points'=>$match_points,
				'status'=>$status,
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('user_sales_match_monitor_tbl',$dataArr);
			/* END INSERT sales match monitor */
			
			/* INSERT new Notification */
			$notif_log = array(
				'user_id'=>$userData['user_id'], 
				'message'=>'Congrats! You get ₱'.number_format($match_points, 2).' from Sales Match Bonus!',
				'created_at'=>date('Y-m-d H:i:s')
			); 
			$this->insertNewNotification($notif_log);
		}
	}
	public function insertWalletSalesMatch($sponsor_id, $match_points, $status){
		if (isset($this->session->user_id)) {
			if ($status == '5th_pair') {
				$status = '5th_pair';
				$match_points = 0;
			}
			else{
				$status = 'sales_match';
			}
			$dataArr = array(
				'user_code'=>$sponsor_id,
				'amount'=>$match_points,
				'status'=>$status,
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('wallet_tbl',$dataArr);
		}
	}
	public function insertDirectReferralCashBonus($sponsorID, $packageData){
		if (isset($this->session->user_id)) {
			$dataArr = array(
				'user_code'=>$sponsorID,
				'amount'=>$packageData['direct_points'],
				'status'=>'direct_referral',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('wallet_tbl',$dataArr);

			$this->accumulateProfitSharing($packageData);
		}
	}
	public function accumulateProfitSharing($packageData){
		if (isset($this->session->user_id)) {
			$dataArr = array(
				'type'=>'New Registered Account',
				'amount'=>$packageData['profit_sharing_points'],
				'status'=>'active',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('profit_sharing_tbl',$dataArr);

		}
	}
	public function insertUniLvlBonus($sponsor_id, $referred_user) {
		if (isset($this->session->user_id)) {
			/* GET ENTRY UNILEVEL POINTS BASED ON THE BOUGHT PACKAGE */ 
			$uniLvlData = $this->db->SELECT('ut.user_code, ut.member_code, pt.unilvl_points')
				->FROM('user_tbl as ut')
				->JOIN('user_code_tbl as uct','uct.code = ut.member_code')
				->JOIN('package_tbl as pt', 'pt.p_id= uct.p_id')
				->WHERE('ut.user_code', $referred_user)
				->GET()->row_array();

			if (isset($uniLvlData) && $uniLvlData['unilvl_points'] > 0) {
				/* EARNED FOR ENTRY UNILEVEL */ 
				$dataArr = array(
					'user_code'=>$sponsor_id,
					'amount'=>$uniLvlData['unilvl_points'],
					'status'=>'unilvl_bonus',
					'created_at'=>date('Y-m-d H:i:s')
				);
				$this->db->INSERT('wallet_tbl', $dataArr);
			}
		}
	}




	/* INDIRECT INVITES */ 
	public function insertPointsIndirectInvites($sponsor_id, $referred_user, $am_match_points, $pm_match_points, $packageData, $level) {
		$referredData = $this->db->SELECT('link_id, position')->WHERE('user_code', $referred_user)->GET('user_tbl')->row_array();

		/* level 1*/ 
		if ($level == 1) {
			$getPosition = $this->db
				->SELECT('position')
				->WHERE('sponsor_id', $referredData['link_id'])
				->WHERE('link_id', $referredData['link_id'])
				->WHERE('position', 'right')
				->GET('user_tbl')->num_rows();

			if($getPosition['position'] == 'left') {
				$indirectPositon = 'right';
			}
			else if($getPosition['position'] == 'right'){
				$indirectPositon = 'left';
			}
			else{
				$indirectPositon = $referredData['position'];
			}

			$dataArr = array(
				'user_code'=>$referredData['link_id'],
				'referred_id'=>$referred_user,
				'am_match_points'=>$am_match_points,
				'pm_match_points'=>$pm_match_points,
				'position'=>$indirectPositon,
				'level'=>1,
				'created_at'=>date('Y-m-d H:i:s'),
			); 
			$this->db->INSERT('sales_match_tbl', $dataArr);

			/*********************** insert User Sales Match tbl */ 
			$position_col = ($indirectPositon == 'left') ? 'pos_left' : 'pos_right';
			$checkUserSalesMatch = $this->db->WHERE('user_code', $referredData['link_id'])->GET('user_sales_match_tbl')->row_array();

			$time_points = ($am_match_points !== 0) ? $am_match_points : $pm_match_points;
			$total_points = $time_points + $checkUserSalesMatch[$position_col];

			if (isset($checkUserSalesMatch)) {
				$dataSMArr = array(
					'user_code'=>$referredData['link_id'],
					$position_col => $total_points ,
					'updated_at'=>date('Y-m-d H:i:s'),
				);
				$this->db->WHERE('user_code', $referredData['link_id'])->UPDATE('user_sales_match_tbl', $dataSMArr);
			}
			else{
				$dataSMArr = array(
					'user_code'=>$referredData['link_id'],
					$position_col => $time_points,
					'created_at'=>date('Y-m-d H:i:s'),
				);
				$this->db->INSERT('user_sales_match_tbl', $dataSMArr);
			}

			$this->indirectUserSalesMatchPointsReward ($referredData['link_id'], $packageData);
		}
	}

	public function indirectUserSalesMatchPointsReward ($referred_id, $packageData) {
		$dateNow = date('A');
		if ($dateNow == 'AM') {
			$am_maximum_points = $packageData['am_maximum_points'];
		}
		else if ($dateNow == 'PM'){
			$pm_maximum_points = $packageData['pm_maximum_points'];
		}

		$userSMPoints = $this->db->WHERE('user_code', $referred_id)->GET('user_sales_match_tbl')->row_array();


		/* SALES MATCH WILL OCCUR if BOTH RIGHT and LEFT position have points */
		if ($userSMPoints['pos_right'] > 0 && $userSMPoints['pos_left'] > 0) {
			
			if ($userSMPoints['pos_right'] > $userSMPoints['pos_left']) { /* if POS_Right is higher than POS_Left */
				$right_diff = $userSMPoints['pos_right'] - $userSMPoints['pos_left'];
				$left_diff = $userSMPoints['pos_left'] - $userSMPoints['pos_left'];
				$this->indirectUpdateSalesMatchPoints($referred_id, $right_diff, $left_diff);
				$this->indirectInsertSaleMatchBonus($referred_id, $packageData['match_points']);
			}

			else if($userSMPoints['pos_left'] > $userSMPoints['pos_right']){ /* if POS_Left is higher than POS_Right */
				$left_diff = $userSMPoints['pos_left'] - $userSMPoints['pos_right'];
				$right_diff = $userSMPoints['pos_right'] - $userSMPoints['pos_right'];
				$this->indirectUpdateSalesMatchPoints($referred_id, $right_diff, $left_diff);
				$this->indirectInsertSaleMatchBonus($referred_id, $packageData['match_points']);
			}
			else if($userSMPoints['pos_right'] == $userSMPoints['pos_left']){ /* if POS_Left and POS_Right are equal */
				$right_diff = $userSMPoints['pos_right'] - $userSMPoints['pos_right'];
				$left_diff = $right_diff;
				$this->indirectUpdateSalesMatchPoints($referred_id, $right_diff, $left_diff);
				$this->indirectInsertSaleMatchBonus($referred_id, $packageData['match_points']);
			}
			else{

			}
		}
	}
	public function indirectUpdateSalesMatchPoints($referred_id, $right_diff, $left_diff){
		$data_smp = array(
			'pos_right'=>$right_diff,
			'pos_left'=>$left_diff,
			'updated_at'=>date('Y-m-d H:i:s'),
		);
		$this->db->WHERE('user_code', $referred_id)->UPDATE('user_sales_match_tbl', $data_smp);
	}
	public function indirectInsertSaleMatchBonus($referred_id, $match_points){
		/* INSERT NEW SALES MATCH ON THE RECORD */ 

		if (isset($this->session->user_id)) {
			$userData = $this->db->SELECT('user_id')->WHERE('user_code',$referred_id)->GET('user_tbl')->row_array();

			/* START INSERT sales match monitor */
			$cSMCount = $this->db->WHERE('user_id', $userData['user_id'])->GET('user_sales_match_monitor_tbl')->num_rows(); /* check sales match count*/

			if (
				$cSMCount == 4 ||  $cSMCount == 9 ||  $cSMCount == 14 || $cSMCount == 19 ||  
				$cSMCount == 24 || $cSMCount == 29 || $cSMCount == 34 ||  $cSMCount == 39 || 
				$cSMCount == 44 || $cSMCount == 49 || $cSMCount == 54 ||  $cSMCount == 59 || 
				$cSMCount == 64 ||  $cSMCount == 69 ||  $cSMCount == 74 ||  $cSMCount == 79 ||
				$cSMCount == 84 ||  $cSMCount == 89 || $cSMCount == 94 ||  $cSMCount == 99 ||
				$cSMCount == 104 ||  $cSMCount == 109 || $cSMCount == 114 || $cSMCount == 119 ||
				$cSMCount == 124 ||  $cSMCount == 129 || $cSMCount == 134 || $cSMCount == 139 ||
				$cSMCount == 144 ||  $cSMCount == 149 || $cSMCount == 154 || $cSMCount == 159 ||
				$cSMCount == 164 ||  $cSMCount == 169 || $cSMCount == 174 || $cSMCount == 179 
			) {
				$status = '5th_pair';
				$this->insertWalletSalesMatch($referred_id, $match_points, $status);
			}
			else{
				$status = 'default';
				$this->insertWalletSalesMatch($referred_id, $match_points, $status);
			}

			/* INSERT POINTS FOR MONITORING */ 
			$dataArr = array(
				'user_id'=>$userData['user_id'],
				'points'=>$match_points,
				'status'=>$status,
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('user_sales_match_monitor_tbl',$dataArr);
			/* END INSERT sales match monitor */
			
			/* INSERT new Notification */
			$notif_log = array(
				'user_id'=>$userData['user_id'], 
				'message'=>'Congrats! You get ₱'.number_format($match_points, 2).' from Sales Match Bonus!',
				'created_at'=>date('Y-m-d H:i:s')
			); 
			$this->insertNewNotification($notif_log);
		}
	}

}
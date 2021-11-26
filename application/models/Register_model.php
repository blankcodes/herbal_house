<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {

	private function hash_password($password){
	   return password_hash($password, PASSWORD_BCRYPT);
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
	    }
	}
	public function generateTransactionRefNo ( $length = 12) {
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $ref_no = '1000'.$randomString;

	    $check = $this->db->WHERE('reference_no', $ref_no)->GET('transaction_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateTransactionRefNo();
	    }
	    return $ref_no;
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
	public function registerInviteUser() {
		if (isset($this->session->user_id)) {
			$user['username'] = $this->input->post('username');
			$user['fname'] = $this->input->post('fname');
	        $user['lname'] = $this->input->post('lname');
	        $user['mobile_number'] = $this->input->post('mobile_number');
	        $user['password'] = $this->input->post('password');
	        $user['package_code'] = $this->input->post('package_code');
	        $user['sponsor_id'] = $this->session->user_code;

	        $checkSponsorCredit = $this->checkSponsorCredit($user['package_code']);

			if(strlen($user['mobile_number']) < 11) {
				$response['status'] = 'failed';
				$response['message'] = "Please enter a correct mobile number!";
			}
			
			else if($checkSponsorCredit > 0) {
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

					$this->insertDirectReferralBonus($this->session->user_code, $referred_id, $user['package_code']);
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
				'sponsor_id'=>$user['sponsor_id'],
				'member_code'=>$package_code,
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

			$this->generateUserIDCode($id, $user); /* INSERT user unique USER_CODE*/
			
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
	public function generateUserIDCode ($id, $userData, $length = 5) {
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $u_code = '10000'.$id.$randomString;

	    $check = $this->db->WHERE('user_code', $u_code)->GET('user_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateUserIDCode($id);
	    }
	    else{
	    	$data = array('user_code' => $u_code);
		    $this->db->WHERE('user_id', $id)
		    	->UPDATE('user_tbl', $data); /* INSERT user user_code used for invites for selling */

		    /* INSERT NEW DOWNLINE */ 
		    // $this->insertNewDownline($u_code, $userData);
	    }
	}
	public function checkSponsorCredit($package_code) {
		$query = $this->db->WHERE('code', $package_code)
			->WHERE('status','new')
			->GET('user_code_tbl')->num_rows();
		
		return $query;
	}
	public function insertDirectReferralBonus ($user_code, $referred_id, $package_code) {
		if (isset($this->session->user_id)) {
			$referred_user = $this->db->SELECT('user_code')->WHERE('user_id', $referred_id)->GET('user_tbl')->row_array();
			$sponsor_user = $this->db->SELECT('sponsor_id')->WHERE('user_code', $user_code)->GET('user_tbl')->row_array();

			/* Get the points based on what package does the referred user purchased */
			$packageData = $this->db->SELECT('pt.direct_points, pt.indirect_points')
				->FROM('package_tbl as pt')
				->JOIN('activation_code_tbl as act','act.p_id = pt.p_id')
				->WHERE('act.code', $package_code)
				->GET()->row_array();

			/* EARNED FOR DIRECT REFERRAL */ 
			$this->insertWalletDirectReferral($packageData);


			if (isset($this->session->admin)) {
				$user_code_unilevel = $this->input->post('sponsor_id');
			}
			else{
				$user_code_unilevel = $this->session->user_code;
			}
			$this->insertUnilevel($user_code_unilevel, $referred_user['user_code'], 1);

			/* EARNED FOR INDIRECT REFERRAL */ 
			$this->insertInDirectReferralCashBonus($user_code, $referred_user['user_code'], $packageData);

			/* CHANGING USER STATUS - REGISTERED AS WEBSITE INVITES */ 
			if (isset($this->session->admin) && !empty($this->input->post('user_id')))  {
				/* INSERT new ACIVITY LOG */
				$sponsorUserData = $this->db->WHERE('user_code', $this->input->post('sponsor_id'))->GET('user_tbl')->row_array();
				$activity_log = array(
					'user_id'=>$sponsorUserData['user_id'], 
					'message_log'=>'Earned Direct Referral Bonus ₱'.number_format($packageData['direct_points'], 2).' using Affiliate link ',
					'ip_address'=>$this->input->ip_address(), 
					'platform'=>$this->agent->platform(), 
					'browser'=>$this->agent->browser(),
					'created_at'=>date('Y-m-d H:i:s')
				); 
				$this->insertActivityLog($activity_log); 

				/* INSERT new Notification */
				$notif_log = array(
					'user_id'=>$sponsorUserData['user_id'], 
					'message'=>'Congrats! You get ₱'.number_format($packageData['direct_points'], 2).' using your Affiliate link.',
					'created_at'=>date('Y-m-d H:i:s')
				); 
				$this->insertNewNotification($notif_log);

				return 'success';
			}
			else{
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
	}
	public function insertWalletDirectReferral($packageData){
		if (isset($this->session->user_id)) {
			$ref_no = $this->generateTransactionRefNo();

			if (isset($this->session->admin)) {
				$checkWalletUser = $this->db->WHERE('user_code', $this->input->post('sponsor_id'))
					->WHERE('type','main')
					->GET('wallet_tbl')->row_array();
				if (isset($checkWalletUser)) {
					$dataArr = array(
						'balance'=>$checkWalletUser['balance']+$packageData['direct_points'],
						'updated_at'=>date('Y-m-d H:i:s')
					);
					$this->db->WHERE('user_code', $this->input->post('sponsor_id'))
						->WHERE('type','main')
						->UPDATE('wallet_tbl',$dataArr);	
				}
				else{
					$dataArr = array(
						'user_code'=>$this->input->post('sponsor_id'),
						'balance'=>$packageData['direct_points'],
						'type'=>'main',
						'created_at'=>date('Y-m-d H:i:s')
					);
					$this->db->INSERT('wallet_tbl',$dataArr);	
				}

				/* INSERT WALLET ACTIVITY */ 
				$txDataArr = array(
					'reference_no'=> $ref_no,
					'user_code'=> $this->input->post('sponsor_id'),
					'amount'=> $packageData['direct_points'],
					'activity'=>'Direct Referral Bonus',
					'created_at'=>date('Y-m-d H:i:s'),
				);
				$this->db->INSERT('wallet_activity_tbl', $txDataArr);

				/* INSERT TRANSACTION ACTIVITY */ 
				$txDataArr = array(
					'reference_no'=>$ref_no,
					'activity'=>'Direct Referral Bonus',
					'created_at'=>date('Y-m-d H:i:s')
				);
				$this->db->INSERT('transaction_tbl', $txDataArr);
			}
			else{
				$checkWalletUser = $this->db->WHERE('user_code', $this->session->user_code)
					->WHERE('type','main')
					->GET('wallet_tbl')->row_array();
				if (isset($checkWalletUser)) {
					$dataArr = array(
						'balance'=>$checkWalletUser['balance']+$packageData['direct_points'],
						'updated_at'=>date('Y-m-d H:i:s')
					);
					$this->db->WHERE('user_code', $this->session->user_code)
						->WHERE('type','main')
						->UPDATE('wallet_tbl',$dataArr);	
				}
				else{
					$dataArr = array(
						'user_code'=>$this->session->user_code,
						'balance'=>$packageData['direct_points'],
						'type'=>'main',
						'created_at'=>date('Y-m-d H:i:s')
					);
					$this->db->INSERT('wallet_tbl',$dataArr);	
				}

				/* INSERT WALLET ACTIVITY */ 
				$txDataArr = array(
					'reference_no'=> $ref_no,
					'user_code'=> $this->session->user_code,
					'amount'=> $packageData['direct_points'],
					'activity'=>'Direct Referral Bonus',
					'created_at'=>date('Y-m-d H:i:s'),
				);
				$this->db->INSERT('wallet_activity_tbl', $txDataArr);

				/* INSERT TRANSACTION ACTIVITY */ 
				$txDataArr = array(
					'reference_no'=>$ref_no,
					'activity'=>'Direct Referral Bonus',
					'created_at'=>date('Y-m-d H:i:s')
				);
				$this->db->INSERT('transaction_tbl', $txDataArr);
			}
		}
	}
	public function insertInDirectReferralCashBonus($sponsor_id, $referred_id, $packageData) {
		$gen1stData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $sponsor_id)->GET('user_tbl')->row_array();
		/* 2nd Generation */ 
		if (!empty($gen1stData['sponsor_id'])) {
			$this->insertWalletInDirectReferral($gen1stData['sponsor_id'] , $packageData['indirect_points']);
			$this->insertUnilevel($gen1stData['sponsor_id'], $referred_id, 2);

			// /* 3rd Generation*/
			// $gen2ndData = $this->db->SELECT('sponsor_id')->WHERE('user_code', $sponsor_id)->GET('user_tbl')->row_array();
			// if (!empty($gen2ndData['sponsor_id'])) {
			// 	$this->insertWalletInDirectReferral($gen2ndData['sponsor_id'], $packageData['indirect_points']);
			// }

			$gen2ndData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen1stData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen2ndData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen2ndData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen2ndData['sponsor_id'], $referred_id, 3);
			}

			/* 3rd Generation*/
			$gen3rdData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen2ndData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen3rdData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen3rdData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen3rdData['sponsor_id'], $referred_id, 4);
			}

			/* 4th Generation*/
			$gen4thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen3rdData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen4thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen4thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen4thData['sponsor_id'], $referred_id, 5);

			}
					
			/* 5th Generation*/
			$gen5thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen4thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen5thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen5thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen5thData['sponsor_id'], $referred_id, 6);
			}

			/* 6th Generation*/
			$gen6thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen5thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen6thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen6thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen6thData['sponsor_id'], $referred_id, 7);
			}						
				
			/* 7th Generation*/
			$gen7thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen6thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen7thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen7thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen7thData['sponsor_id'], $referred_id, 8);
			}
									
			/* 8th Generation*/
			$gen8thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen7thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen8thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen8thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen8thData['sponsor_id'], $referred_id, 9);
			}

			/* 9th Generation*/
			$gen9thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen8thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen9thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen9thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen9thData['sponsor_id'], $referred_id, 10);
			}

			/* 10th Generation*/
			$gen10thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen9thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen10thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen10thData['sponsor_id'], $referred_id, 11);
			}

			/* 11th Generation*/
			$gen11thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen10thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen11thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen11thData['sponsor_id'], $referred_id, 12);
			}

			/* 12th Generation*/
			$gen12thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen11thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen12thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen12thData['sponsor_id'], $referred_id, 13);
			}

			/* 13th Generation*/
			$gen13thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen12thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen13thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen13thData['sponsor_id'], $referred_id, 14);
			}

			/* 14th Generation*/
			$gen14thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen13thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen14thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen14thData['sponsor_id'], $referred_id, 15);
			}

			/* 15th Generation*/
			$gen15thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen14thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen15thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen15thData['sponsor_id'], $referred_id, 16);
			}

			/* 16th Generation*/
			$gen16thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen15thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen16thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen16thData['sponsor_id'], $referred_id, 17);
			}

			/* 17th Generation*/
			$gen17thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen16thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen17thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen17thData['sponsor_id'], $referred_id, 18);
			}

			/* 18th Generation*/
			$gen18thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen17thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen18thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen18thData['sponsor_id'], $referred_id, 19);
			}

			/* 19th Generation*/
			$gen19thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen18thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen19thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen19thData['sponsor_id'], $referred_id, 20);
			}

			/* 20th Generation*/
			$gen20thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen19thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen20thData['sponsor_id'])) {
				$this->insertWalletInDirectReferral($gen10thData['sponsor_id'], $packageData['indirect_points']);
				$this->insertUnilevel($gen20thData['sponsor_id'], $referred_id, 21);
			}

			/* 21th Generation*/
			$gen21thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen20thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen21thData['sponsor_id'])) {
				$this->insertUnilevel($gen21thData['sponsor_id'], $referred_id, 22);
			}

			/* 22th Generation*/
			$gen22thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen21thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen22thData['sponsor_id'])) {
				$this->insertUnilevel($gen22thData['sponsor_id'], $referred_id, 23);
			}

			/* 23th Generation*/
			$gen23thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen22thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen23thData['sponsor_id'])) {
				$this->insertUnilevel($gen23thData['sponsor_id'], $referred_id, 24);
			}

			/* 24th Generation*/
			$gen24thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen23thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen24thData['sponsor_id'])) {
				$this->insertUnilevel($gen24thData['sponsor_id'], $referred_id, 25);
			}

			/* 25th Generation*/
			$gen25thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen24thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen25thData['sponsor_id'])) {
				$this->insertUnilevel($gen25thData['sponsor_id'], $referred_id, 26);
			}

			/* 26th Generation*/
			$gen26thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen25thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen26thData['sponsor_id'])) {
				$this->insertUnilevel($gen26thData['sponsor_id'], $referred_id, 27);
			}

			/* 27th Generation*/
			$gen27thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen26thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen27thData['sponsor_id'])) {
				$this->insertUnilevel($gen27thData['sponsor_id'], $referred_id, 28);
			}

			/* 28th Generation*/
			$gen28thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen27thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen28thData['sponsor_id'])) {
				$this->insertUnilevel($gen28thData['sponsor_id'], $referred_id, 29);
			}

			/* 29th Generation*/
			$gen29thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen28thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen29thData['sponsor_id'])) {
				$this->insertUnilevel($gen29thData['sponsor_id'], $referred_id, 30);
			}

			/* 30th Generation*/
			$gen30thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen29thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen30thData['sponsor_id'])) {
				$this->insertUnilevel($gen30thData['sponsor_id'], $referred_id, 31);
			}

			/* 31th Generation*/
			$gen31thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen30thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen31thData['sponsor_id'])) {
				$this->insertUnilevel($gen31thData['sponsor_id'], $referred_id, 32);
			}

			/* 32th Generation*/
			$gen32thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen31thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen32thData['sponsor_id'])) {
				$this->insertUnilevel($gen32thData['sponsor_id'], $referred_id, 33);
			}

			/* 33th Generation*/
			$gen33thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen32thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen33thData['sponsor_id'])) {
				$this->insertUnilevel($gen33thData['sponsor_id'], $referred_id, 34);
			}

			/* 34th Generation*/
			$gen34thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen33thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen34thData['sponsor_id'])) {
				$this->insertUnilevel($gen34thData['sponsor_id'], $referred_id, 35);
			}

			/* 35th Generation*/
			$gen35thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen34thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen35thData['sponsor_id'])) {
				$this->insertUnilevel($gen35thData['sponsor_id'], $referred_id, 36);
			}

			/* 36th Generation*/
			$gen36thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen35thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen36thData['sponsor_id'])) {
				$this->insertUnilevel($gen36thData['sponsor_id'], $referred_id, 37);
			}

			/* 37th Generation*/
			$gen37thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen36thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen37thData['sponsor_id'])) {
				$this->insertUnilevel($gen37thData['sponsor_id'], $referred_id, 38);
			}

			/* 38th Generation*/
			$gen38thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen37thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen38thData['sponsor_id'])) {
				$this->insertUnilevel($gen38thData['sponsor_id'], $referred_id, 39);
			}

			/* 39th Generation*/
			$gen39thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen38thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen39thData['sponsor_id'])) {
				$this->insertUnilevel($gen39thData['sponsor_id'], $referred_id, 40);
			}

			/* 40th Generation*/
			$gen40thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen39thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen40thData['sponsor_id'])) {
				$this->insertUnilevel($gen40thData['sponsor_id'], $referred_id, 41);
			}

			/* 41th Generation*/
			$gen41thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen40thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen41thData['sponsor_id'])) {
				$this->insertUnilevel($gen41thData['sponsor_id'], $referred_id, 42);
			}

			/* 42th Generation*/
			$gen42thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen41thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen42thData['sponsor_id'])) {
				$this->insertUnilevel($gen42thData['sponsor_id'], $referred_id, 43);
			}

			/* 43th Generation*/
			$gen43thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen42thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen43thData['sponsor_id'])) {
				$this->insertUnilevel($gen43thData['sponsor_id'], $referred_id, 44);
			}

			/* 44th Generation*/
			$gen44thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen43thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen44thData['sponsor_id'])) {
				$this->insertUnilevel($gen44thData['sponsor_id'], $referred_id, 45);
			}

			/* 45th Generation*/
			$gen45thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen44thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen45thData['sponsor_id'])) {
				$this->insertUnilevel($gen45thData['sponsor_id'], $referred_id, 46);
			}

			/* 46th Generation*/
			$gen46thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen45thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen46thData['sponsor_id'])) {
				$this->insertUnilevel($gen46thData['sponsor_id'], $referred_id, 47);
			}

			/* 47th Generation*/
			$gen47thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen46thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen47thData['sponsor_id'])) {
				$this->insertUnilevel($gen47thData['sponsor_id'], $referred_id, 48);
			}

			/* 48th Generation*/
			$gen48thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen47thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen48thData['sponsor_id'])) {
				$this->insertUnilevel($gen48thData['sponsor_id'], $referred_id, 49);
			}

			/* 49th Generation*/
			$gen49thData = $this->db->SELECT('user_code, sponsor_id')->WHERE('user_code', $gen47thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen49thData['sponsor_id'])) {
				$this->insertUnilevel($gen49thData['sponsor_id'], $referred_id, 50);   
			}



		} //
	}
	public function insertWalletInDirectReferral($user_id, $indirect_points){
		if (isset($this->session->user_id)) {
			$ref_no = $this->generateTransactionRefNo();
			$checkWalletUser = $this->db->WHERE('user_code', $user_id)
				->WHERE('type','indirect_referral')
				->GET('wallet_tbl')->row_array();

			if (isset($checkWalletUser)) {
				$dataArr = array(
					'balance'=>$checkWalletUser['balance']+$indirect_points,
					'updated_at'=>date('Y-m-d H:i:s')
				);
				$this->db->WHERE('user_code', $user_id)
					->WHERE('type','indirect_referral')
					->UPDATE('wallet_tbl',$dataArr);	
			}
			else{
				$dataArr = array(
					'user_code'=>$user_id,
					'balance'=>$indirect_points,
					'type'=>'indirect_referral',
					'created_at'=>date('Y-m-d H:i:s'),
				);
				$this->db->INSERT('wallet_tbl',$dataArr);	
			}

			/* INSERT WALLET ACTIVITY */ 
			$txDataArr = array(
				'reference_no'=> $ref_no,
				'user_code'=> $user_id,
				'amount'=> $indirect_points,
				'activity'=>'Indirect Referral Bonus',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('wallet_activity_tbl', $txDataArr);

			/* INSERT TRANSACTION ACTIVITY */ 
			$txDataArr = array(
				'reference_no'=>$ref_no,
				'activity'=>'Indirect Referral Bonus',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('transaction_tbl', $txDataArr);

		}
	}
	public function insertUnilevel($user_code, $referred_id, $level){
		if (isset($this->session->user_id)) {
			$dataArr = array(
				'user_code'=>$user_code,
				'referred_id'=>$referred_id,
				'level'=>$level,
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('unilevel_tbl',$dataArr);
		}
	}


	public function insertMainRegistrationNewAccountData ($user) {
		$user_type = 'member';
		$data = array(
			'sponsor_id'=>$user['sponsor_id'],
			'member_code'=>'',
			'website_invites_status'=>'inactive',
			'registration_type'=>'website_invites',
			'package_used'=>$user['package_used'],
			'username'=>$user['username'],
			'fname'=>$user['fname'],
			'lname'=>$user['lname'],
			'mobile_number'=>$user['mobile_number'],
			'email_address'=>$user['email_address'],
			'address'=>$user['address'],
			'password'=>$this->hash_password($user['password']),
			'status'=>'inactive',
			'user_type'=>$user_type,
			'created_at'=>date('Y-m-d H:i:s')
		);
		$this->db->INSERT('user_tbl', $data);
		$id = $this->db->insert_id();

		$this->generateUserIDCode($id, $user); /* INSERT user unique USER_CODE*/
		
		$notif_log = array('user_id'=>$id, 'message'=>'Welcome to Herbal House!','created_at'=>date('Y-m-d H:i:s')); 
		$this->insertNewNotification($notif_log); /* INSERT new Notification */

		$activity_log = array('user_id'=>$id, 'message_log'=>'Created account from Website Registration Page','ip_address'=>$this->input->ip_address(), 'platform'=>$this->agent->platform(), 'browser'=>$this->agent->browser(),'created_at'=>date('Y-m-d H:i:s')); 
		$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

		return $id;
	}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger_model extends CI_Model {
	public function generateWithdrawRequestRefNo ( $length = 6) {
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $ref_no = '100WR'.$randomString;

	    $check = $this->db->WHERE('reference_no', $ref_no)->GET('withdraw_request_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateWithdrawRequestRefNo();
	    }
	    return $ref_no;
	}
	public function generateTxRefNo ( $length = 6) {
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $ref_no = '1000'.$randomString;

	    $check = $this->db->WHERE('reference_no', $ref_no)->GET('transaction_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateTxRefNo();
	    }
	    return $ref_no;
	}
	public function insertNewPackage($data){
		if ($this->session->user_type == 'admin') {
			$this->db->INSERT('package_tbl', $data);
		}
	}
	public function getPackageListCount(){
		if ($this->session->user_type == 'admin') {
			return $this->db->GET('package_tbl')->num_rows();
		}
	}
	public function getPackageList($row_per_page, $row_no){
		if ($this->session->user_type == 'admin') {
				$query = $this->db->ORDER_BY('updated_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET('package_tbl')->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'p_id'=>$q['p_id'],
					'name'=>$q['name'],
					// 'match_points'=>'₱ '.number_format($q['match_points'], 2),
					// 'unilvl_points'=>'₱ '.number_format($q['unilvl_points'], 2),
					'direct_points'=>'₱ '.number_format($q['direct_points'], 2),
					'indirect_points'=>'₱ '.number_format($q['indirect_points'], 2),
					// 'pm_maximum_points'=>$q['pm_maximum_points'],
					// 'am_maximum_points'=>$q['am_maximum_points'],
					// 'profit_sharing_points'=>$q['profit_sharing_points'],
					'status'=>$q['status'],
					'cost'=>'₱ '.number_format($q['cost'], 2),
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
		}
	}
	public function getPackageData(){
		if ($this->session->user_type == 'admin') {
			return $this->db->WHERE('p_id', $this->input->get('p_id'))
				->GET('package_tbl')->row_array();
		}
	}
	public function updatePackageData($dataArr){
		if ($this->session->user_type == 'admin') {
			$this->db->WHERE('p_id', $this->input->post('p_id'))->UPDATE('package_tbl', $dataArr);
		}
	}
	public function updatePackageStatus($dataArr){
		if ($this->session->user_type == 'admin') {
			$this->db->WHERE('p_id', $this->input->get('p_id'))->UPDATE('package_tbl', $dataArr);
		}
	}
	public function updateUserPackage($dataArr){
		if ($this->session->user_type == 'admin') {
			$this->db->WHERE('user_code', $this->input->get('p_id'))->UPDATE('package_tbl', $dataArr);
		}
	}
	public function getPackageListActivationCodes() {
		if ($this->session->user_type == 'admin') {
			$query = $this->db->ORDER_BY('created_at', 'DESC')
				->WHERE('status', 'active')
				->GET('package_tbl')->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'p_id'=>$q['p_id'],
					'name'=>$q['name'],
				);
				array_push($result, $array);
			}
			return $result;
		}
	}
	public function getPackageByCode(){
		if (isset($this->session->user_id)) {
			return $this->db->SELECT('uct.code, uct.status, pt.name as package_name')
				->FROM('user_code_tbl uct')
				->JOIN('package_tbl as pt', 'pt.p_id = uct.p_id')
				->WHERE('code', $this->input->get('code'))
				->WHERE('uct.status','new')
				->GET()->row_array();
		}
	}

	public function getWalletBalance(){
		if (isset($this->session->user_id)) {
			$userData = $this->db->SELECT('status')->WHERE('user_id', $this->session->user_id)->GET('user_tbl')->row_array();
			if ($userData['status'] == 'disabled') {
				$query = $this->db->SELECT('balance')
					->WHERE('user_code',$this->session->user_code)
					->WHERE('type','main')
					->GET('wallet_tbl')->row_array();
				$balance = '₱ '.number_format($query['balance'], 2);
				
				return array('status'=>'disabled_account', 'balance'=>$balance,);
			}
			else{
				$query = $this->db->SELECT('balance')
					->WHERE('user_code',$this->session->user_code)
					->WHERE('type','main')
					->GET('wallet_tbl')->row_array();

				$balance = '₱ '.number_format($query['balance'], 2);
				$status = 'not_allow';
				if ($query['balance'] >= 50) {
					$status = 'allow';
				}
				return array('balance'=>$balance,'status'=>$status);
			}
			
		}

		// if (isset($this->session->user_id)) {
		// 	$query = $this->db->SELECT('balance')
		// 		->WHERE('user_code',$this->session->user_code)
		// 		->WHERE('type','main')
		// 		->GET('wallet_tbl')->row_array();

		// 	$balance = '₱ '.number_format($query['balance'], 2);
		// 	$status = 'not_allow';
		// 	if ($query['balance'] >= 50) {
		// 		$status = 'allow';
		// 	}
		// 	return array('balance'=>$balance,'status'=>$status);
		// }
	}
	public function getIndirectWalletBalance(){
		if (isset($this->session->user_id)) {
			$query = $this->db->SELECT('balance')
				->WHERE('user_code',$this->session->user_code)
				->WHERE('type','indirect_referral')
				->GET('wallet_tbl')->row_array();

			$balance = '₱ '.number_format($query['balance'], 2);
			return array('balance'=>$balance);
		}
	}
	public function getIndirectWalletBalanceAdmin(){
		if (isset($this->session->user_id)) {
			$query = $this->db->SELECT('balance')
				->WHERE('user_code',$this->input->get('user_code'))
				->WHERE('type','indirect_referral')
				->GET('wallet_tbl')->row_array();

			$balance = '₱ '.number_format($query['balance'], 2);
			return array('balance'=>$balance);
		}
	}
	public function getUnilevelWalletBalance(){
		if (isset($this->session->user_id)) {
			$query = $this->db->SELECT('balance')
				->WHERE('user_code',$this->session->user_code)
				->WHERE('type','unilevel_bonus')
				->GET('wallet_tbl')->row_array();

			$balance = '₱ '.number_format($query['balance'], 2);
			return array('balance'=>$balance);
		}
	}
	public function getUnilevelWalletBalanceAdmin(){
		if (isset($this->session->user_id)) {
			$query = $this->db->SELECT('balance')
				->WHERE('user_code',$this->input->get('user_code'))
				->WHERE('type','unilevel_bonus')
				->GET('wallet_tbl')->row_array();

			$balance = '₱ '.number_format($query['balance'], 2);
			return array('balance'=>$balance);
		}
	}
	public function getWalletRecentActivity($row_per_page, $row_no){
		if (isset($this->session->user_id)) {
			$activity = '';

			$query = $this->db->SELECT('created_at, activity, reference_no, amount')
				->ORDER_BY('wa_id', 'DESC')
				->WHERE('user_code',$this->session->user_code)
				->LIMIT($row_per_page, $row_no)
				->GET('wallet_activity_tbl')->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'activity'=>$q['activity'],
					'amount'=>'₱ '.number_format($q['amount'], 2),
					'date'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
		}
	}
	public function getWalletRecentActivityAdmin($row_per_page, $row_no){
		if (isset($this->session->admin)) {
			$activity = '';

			$query = $this->db->SELECT('created_at, activity, reference_no, amount')
				->ORDER_BY('wa_id', 'DESC')
				->WHERE('user_code',$this->input->get('user_code'))
				->LIMIT($row_per_page, $row_no)
				->GET('wallet_activity_tbl')->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'activity'=>$q['activity'],
					'amount'=>'₱ '.number_format($q['amount'], 2),
					'date'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
		}
	}
	public function getWalletRecentActivityCountAdmin(){
		if ($this->session->user_id) {
			return $this->db->WHERE('user_code',$this->input->get('user_code'))
				->GET('wallet_activity_tbl')->num_rows();
		}
	}
	public function getWalletRecentActivityCount(){
		if ($this->session->user_id) {
			return $this->db->WHERE('user_code',$this->session->user_code)
				->GET('wallet_tbl')->num_rows();
		}
	}
	public function requestWitdraw(){
		if (isset($this->session->user_id)) {
			$ref_no = $this->generateWithdrawRequestRefNo();
			$amount = $this->input->post('amount');
			$payment_method = $this->input->post('payment_method');
			$dataArr = array(
				'user_code'=>$this->session->user_code,
				'reference_no'=>$ref_no,
				'status' => 'pending',
				'processing_fee' => 50,
				'amount' => $this->input->post('amount'),
				'acct_name' =>$this->input->post('account_name'),
				'acct_number' =>$this->input->post('account_number'),
				'payment_method' =>$payment_method,
				'created_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->INSERT('withdraw_request_tbl', $dataArr);


			/* INSERT WALLET ACTIVITY */ 
			$txDataArr = array(
				'reference_no'=> $ref_no,
				'user_code'=> $this->session->user_code,
				'amount'=>'-'.$this->input->post('amount'),
				'activity'=>'Withdrawal Request submitted. Status: Pending.',
				'created_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->INSERT('wallet_activity_tbl', $txDataArr);

			/* INSERT TRANSACTION ACTIVITY */ 
			$txDataArr = array(
				'reference_no'=>$ref_no,
				'activity'=>'Withdrawal request',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('transaction_tbl', $txDataArr);

			/* DEDUCT WALLET BALANCE  */ 
			$wallet = $this->db->WHERE('user_code', $this->session->user_code)->WHERE('type','main')->GET('wallet_tbl')->row_array();
			$walletAr = array(
				'balance'=>$wallet['balance'] - $amount,
				'updated_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->WHERE('user_code', $this->session->user_code)->WHERE('type','main')->UPDATE('wallet_tbl', $walletAr);


			/* INSERT NEW NOTIFICATION */
			$notif_log = array('user_id'=>$this->session->user_id, 'message'=>'Withdrawal request submitted '.$ref_no,'created_at'=>date('Y-m-d H:i:s')); 
			$this->insertNewNotification($notif_log); /* INSERT new Notification */

			/* SEND USER NOTIFICATION EMAIL */
			$this->sendWithdrawEmailNotificationToUser($this->session->user_code, $ref_no, $amount, $payment_method);

			/* SEND ADMIN NOTIFICATION EMAIL */
			$this->sendWithdrawEmailNotificationToAdmin($this->session->user_code, $ref_no, $amount, $payment_method);
		}
	}
	
	public function sendWithdrawEmailNotificationToAdmin($user_code, $ref_no, $amount, $payment_method) {
		if (strpos(base_url(), 'localhost') !== false || strpos(base_url(), 'test') !== false) {
			$recv_email = 'bl4nkcode01@gmail.com';
		}
		else{
			$recv_email = 'herbalhouseph@gmail.com';
		}
		
		$userData = $this->db->WHERE('user_code', $user_code)->GET('user_tbl')->row_array();
		$config = array (
			'mailtype' => 'html',
			'charset'  => 'utf-8',
			'priority' => '1'
		);
		$data['header_image'] = base_url().'assets/images/herbal-house-logo.png';
		$data['header_image_url'] = base_url().'?utm_source=herbalhouse&utm_medium=withdraw_request&utm_campaign=email';
		$data['name'] = 'Admin';
		$data['reference_no'] = $ref_no;
		$data['total_amount'] = number_format( $amount, 2);
		$data['payment_method'] = $payment_method;
		$data['date'] = date('F d, y H:i A');

		$this->email->initialize($config);
		$this->email->from('no-reply@herbalhouseph.com', 'Herbal House Philippines');
		$this->email->to($recv_email); /* SEND TO ADMIN EMAIL */
		$this->email->subject('Withdrawal Request!');
		$body = $this->load->view('email/admin_withdraw_notification', $data, TRUE);
		$this->email->message($body);
		$this->email->send();
	}
	public function sendWithdrawEmailNotificationToUser($user_code, $ref_no, $amount, $payment_method) {
		$userData = $this->db->WHERE('user_code',$user_code)->GET('user_tbl')->row_array();

		if (empty($userData['email_address'])) {
			return false;
		}
		else{
			$config = array (
				'mailtype' => 'html',
				'charset'  => 'utf-8',
				'priority' => '1'
			);
			$data['header_image'] = base_url().'assets/images/herbal-house-logo.png';
			$data['header_image_url'] = base_url().'?utm_source=herbalhouse&utm_medium=withdraw_request&utm_campaign=email';
			$data['name'] = $userData['fname'];
			$data['reference_no'] = $ref_no;
			$data['total_amount'] = number_format( $amount, 2);
			$data['payment_method'] = $payment_method;
			$data['date'] = date('F d, y H:i A');

			$this->email->initialize($config);
			$this->email->from('no-reply@herbalhouseph.com', 'Herbal House Philippines');
			$this->email->to($userData['email_address']); /* SEND TO USER EMAIL */
			$this->email->subject('Withdrawal Request Activity!');
			$body = $this->load->view('email/user_withdraw_notification', $data, TRUE);
			$this->email->message($body);
			$this->email->send();
		}
	}
	public function getRequestWithdrawAdmin($row_per_page, $row_no){
		if (isset($this->session->user_id)) {
			$activity = '';

			$query = $this->db
				->ORDER_BY('status', 'ASC')
				->ORDER_BY('created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET('withdraw_request_tbl')->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'wr_id'=>$q['wr_id'],
					'ref_no'=>$q['reference_no'],
					'user_code'=>$q['user_code'],
					'amount'=>'₱ '.number_format($q['amount'], 2),
					'payment_method'=>$q['payment_method'],
					'acct_name'=>$q['acct_name'],
					'acct_number'=>$q['acct_number'],
					'status'=>$q['status'],
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
		}
	}
	public function sendCompleteWithdrawEmailNotificationToUser($user_code, $ref_no, $amount) {
		$userData = $this->db->WHERE('user_code',$user_code)->GET('user_tbl')->row_array();

		if (empty($userData['email_address'])) {
			return false;
		}
		else{
			$config = array (
				'mailtype' => 'html',
				'charset'  => 'utf-8',
				'priority' => '1'
			);
			$data['header_image'] = base_url().'assets/images/herbal-house-logo.png';
			$data['header_image_url'] = base_url().'?utm_source=herbalhouse&utm_medium=withdraw_request&utm_campaign=email';
			$data['name'] = $userData['fname'];
			$data['reference_no'] = $ref_no;
			$data['total_amount'] = number_format($amount, 2);
			$data['date'] = date('F d, y H:i A');

			$this->email->initialize($config);
			$this->email->from('no-reply@herbalhouseph.com', 'Herbal House Philippines');
			$this->email->to($userData['email_address']); /* SEND TO USER EMAIL */
			$this->email->subject('Withdrawal Request Complete!');
			$body = $this->load->view('email/user_withdraw_complete_notification', $data, TRUE);
			$this->email->message($body);
			$this->email->send();
		}
	}
	public function getRequestWithdrawAdminCount(){
		if (isset($this->session->user_id)) {
			return $this->db->ORDER_BY('created_at', 'DESC')
				->GET('withdraw_request_tbl')->num_rows();
		}
	}
	public function getWithdrawRequestData(){
		if (isset($this->session->admin)) {
			$query = $this->db->WHERE('reference_no', $this->input->get('ref_no'))
				->GET('withdraw_request_tbl')->row_array();
			$query['request_amount'] = number_format($query['amount'], 2);
			$query['amount_to_send'] = number_format($query['amount'] - $query['processing_fee'], 2);
			$query['processing_fee'] = number_format($query['processing_fee'], 2);
			return $query;
		}
	}
	public function getWalletBalanceTransfer(){
		if (isset($this->session->user_id)) {
			$query = $this->db->WHERE('type', $this->input->get('type'))
				->WHERE('user_code', $this->session->user_code)
				->GET('wallet_tbl')->row_array();
			return array('balance'=>($query['balance'] !== null) ? $query['balance'] : '0');
		}
	}
	public function checkWalletBalance(){
		if (isset($this->session->user_id)) {
			$query = $this->db->WHERE('type', $this->input->post('wallet_type'))
				->WHERE('user_code', $this->session->user_code)
				->GET('wallet_tbl')->row_array();

			return $query;
		}
	}
	public function updateWithdrawRequestStatus(){
		if (isset($this->session->admin)) {
			$status = $this->input->post('status');
			$ref_no = $this->input->post('ref_no');
			$user_id = $this->input->post('user_id');
			$amount = $this->input->post('amount');

			if (!isset($status) && !isset($ref_no) && !isset($user_id) && !isset($amount)) {
				$response['status'] = 'failed';
	    		$response['message'] ='Something went wrong. Please try again!';
				return $response;
			}
			else{
				$dataArr = array(
					'status'=>$status
				);
				$query = $this->db->WHERE('reference_no', $ref_no)
					->UPDATE('withdraw_request_tbl', $dataArr);

				/* INSERT WALLET ACTIVITY */ 
				$txDataArr = array(
					'reference_no'=> $ref_no,
					'user_code'=> $user_id,
					'amount'=>'-'.$amount,
					'activity'=>'Withdrawal Request. Status: '.ucwords($status),
					'created_at'=>date('Y-m-d H:i:s'),
				);
				$this->db->INSERT('wallet_activity_tbl', $txDataArr);
				$wr_id = $this->db->insert_id();

				// INSERT EVENT LOGS
				$w_event_logs = array(
					'wr_id'=>$wr_id,
					'activity'=>'Withdraw request Status updated to "'.ucwords($status).'" by '. $this->session->admin,
					'created_at'=>date('Y-m-d H:i:s'),
				);
				$this->insertWithdrawEventLogs($w_event_logs);

				if ($status == 'complete') {
					$this->sendCompleteWithdrawEmailNotificationToUser($user_id, $ref_no, $amount);
				}
				// else if( == 'return'){
				// 	$this->sendCompleteWithdrawEmailNotificationToUser($user_id, $ref_no, $amount);
				// }
				$response['status'] = 'success';
	    		$response['message'] ='Request '.$this->input->post('ref_no').' is updated to '.ucwords($this->input->post('status')).'!';
				return $response;
			}
		}
		else{
			$response['status'] = 'failed';
    		$response['message'] ='Action is not allowed!';
			return $response;
		}
	}
	public function insertNewNotification ($notif_log) {
		$this->db->INSERT('notification_tbl', $notif_log);
	}
	public function transferWalletBalance(){
		if (isset($this->session->user_id)) {
			$ref_no = $this->generateTxRefNo();

			$mainWallet = $this->db->WHERE('type', 'main')
				->WHERE('user_code', $this->session->user_code)
				->GET('wallet_tbl')->row_array();

			/* UPDATE MAIN WALLET BALANCE */ 
			$mainWalletArr = array(
				'balance'=>$mainWallet['balance'] + $this->input->post('transfer_amnt'),
				'updated_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->WHERE('user_code', $this->session->user_code)
				->WHERE('type', 'main')
				->UPDATE('wallet_tbl', $mainWalletArr);

			/* UPDATE THE AFFECTED WALLET BALANCE */ 
			$usedWallet = $this->db->WHERE('type', $this->input->post('wallet_type'))
				->WHERE('user_code', $this->session->user_code)
				->GET('wallet_tbl')->row_array();
			
			$usedWalletArr = array(
				'balance'=>$this->input->post('transfer_amnt') - $usedWallet['balance'],
				'updated_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->WHERE('user_code', $this->session->user_code)
				->WHERE('type', $this->input->post('wallet_type'))
				->UPDATE('wallet_tbl', $usedWalletArr);



			/* INSERT WALLET ACTIVITY FOR DEDUCTION */ 
			$txDataArr = array(
				'reference_no'=> $ref_no,
				'user_code'=> $this->session->user_code,
				'amount'=>'-'.$this->input->post('transfer_amnt'),
				'activity'=>'Balance deducted from '.ucwords($this->input->post('wallet_type')),
				'created_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->INSERT('wallet_activity_tbl', $txDataArr);

			/* INSERT WALLET ACTIVITY FOR ADDITIONAL FUNDS*/ 
			$newTxDataArr = array(
				'reference_no'=> $ref_no,
				'user_code'=> $this->session->user_code,
				'amount'=>$this->input->post('transfer_amnt'),
				'activity'=>'Transfered amount from '.ucwords($this->input->post('wallet_type')). ' Wallet to Main Wallet',
				'created_at'=>date('Y-m-d H:i:s'),
			);
			$this->db->INSERT('wallet_activity_tbl', $newTxDataArr);


			/* INSERT TRANSACTION ACTIVITY */ 
			$txDataArr = array(
				'reference_no'=>$ref_no,
				'activity'=>'Transfer amount from'.ucwords($this->input->post('type')).' Wallet to Main wallet',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('transaction_tbl', $txDataArr);

		}
	}
	public function insertWithdrawEventLogs($dataArr) {
		
		$this->db->iNSERT('withdraw_req_event_logs', $dataArr);
	}
	public function getWithdrawRequestTodo(){
		if (isset($this->session->admin)) {
			return $this->db->WHERE('status','pending')->OR_WHERE('status','processing')->GET('withdraw_request_tbl')->num_rows();
		}
	}

}
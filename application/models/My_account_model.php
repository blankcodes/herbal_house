<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_account_model extends CI_Model {

	public function getUserData() {
		if (isset($this->session->user_id)) {
			return $this->db->WHERE('user_id', $this->session->user_id)
				->GET('user_tbl')->row_array();
		}
	}public function getUserDataOpt($user_code) {
		if (isset($this->session->admin)) {
			return $this->db->WHERE('user_code', $user_code)
				->GET('user_tbl')->row_array();
		}
	}
	public function getTotalProfitShare() { /* one time checking */
		if (isset($this->session->user_id)) {
			$query = $this->db->SELECT_SUM('amount')->GET('profit_sharing_tbl')->row_array();
			$amount = number_format($query['amount'], 2);
			return array('amount'=>$amount);
		}
	}
	public function getUserStatus() { /* one time checking */
		if (isset($this->session->user_id)) {
			return $this->db->SELECT('user_code, status')->WHERE('user_id', $this->session->user_id)
			->GET('user_tbl')->row_array();
		}
	}
	public function updateUserStatus() {
		if (isset($this->session->user_id)) {
			$data = array('status'=>'active');
			$this->db->WHERE('user_id', $this->session->user_id)
				->UPDATE('user_tbl', $data);
			return array('status'=>'success');
		}
	}
	public function getNotifications() { /* one time checking */
		$query = $this->db->WHERE('user_id', $this->session->user_id)
			->ORDER_BY('created_at', 'desc')
			->LIMIT(5)
			->GET('notification_tbl')->result_array();

		$result = array ();

		foreach ($query as $q) {
			$arr = array(
				'message'=>$q['message'],
				'status'=>$q['status'],
				'time'=>$this->getTimeAgo(strtotime($q['created_at'])),
			);
			array_push($result, $arr);
		}
		return $result;
	}
	function getTimeAgo( $time ) {
	    $time_difference = time() - $time;

	    if( $time_difference < 1 ) { return 'less than 1 second ago'; }
	    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
	                30 * 24 * 60 * 60       =>  'month',
	                24 * 60 * 60            =>  'day',
	                60 * 60                 =>  'hour',
	                60                      =>  'minute',
	                1                       =>  'second'
	    );

	    foreach( $condition as $secs => $str )
	    {
	        $d = $time_difference / $secs;

	        if( $d >= 1 )
	        {
	            $t = round( $d );
	            return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
	        }
	    }
	}
	public function checkMaintenance() {
		if (isset($this->session->user_id) && $this->session->user_id == 'admin') {
			return $this->db->WHERE('status','active')->GET('maintenance_tbl')->num_rows();
		}
	}
	public function getUserWallet() {
		if (isset($this->session->user_id)) {
			$query = $this->db->SELECT('balance')
				->WHERE('user_code', $this->session->user_code)
				->WHERE('type', 'main')
				->GET('wallet_tbl')->row_array();
			return '₱ '.number_format($query['balance'], 2);

		}
	}
	public function getUserWalletAdmin() {
		if (isset($this->session->user_id)) {
			$query = $this->db->SELECT('balance')
				->WHERE('user_code', $this->input->get('user_code'))
				->WHERE('type', 'main')
				->GET('wallet_tbl')->row_array();
			return '₱ '.number_format($query['balance'], 2);

		}
	}
	public function getDirectInvites() {
		if (isset($this->session->user_id)) {
			$query = $this->db->WHERE('level',1)
				->WHERE('user_code',$this->session->user_code)
				->GET('unilevel_tbl')->num_rows();
			return $query;

		}
	}
	public function getDirectInvitesAdmin() {
		if (isset($this->session->user_id)) {
			$query = $this->db->WHERE('level',1)
				->WHERE('user_code',$this->input->get('user_code'))
				->GET('unilevel_tbl')->num_rows();
			return $query;

		}
	}
	public function getIndirectIinvites() {
		if (isset($this->session->user_id)) {
			$query = $this->db->WHERE('level !=',1)
				->WHERE('user_code',$this->session->user_code)
				->GET('unilevel_tbl')->num_rows();
			return $query;
		}
	}
	public function getIndirectIinvitesAdmin() {
		if (isset($this->session->user_id)) {
			$query = $this->db->WHERE('level !=',1)
				->WHERE('user_code',$this->input->get('user_code'))
				->GET('unilevel_tbl')->num_rows();
			return $query;

		}
	}
	// public function getLeftSidePoints() {
	// 	if (isset($this->session->user_id)) {
	// 		$query = $this->db->SELECT('pos_left')
	// 			->WHERE('user_code ',$this->session->user_code)
	// 			->GET('user_sales_match_tbl')->row_array();
	// 		if (isset($query)) {
	// 			return $query;
	// 		}
	// 		else{
	// 			return '0';
	// 		}
	// 	}
	// }
	// public function getRightSidePoints() {
	// 	if (isset($this->session->user_id)) {
	// 		$query = $this->db->SELECT('pos_right')
	// 			->WHERE('user_code ',$this->session->user_code)
	// 			->GET('user_sales_match_tbl')->row_array();
	// 		if (isset($query)) {
	// 			return $query;
	// 		}
	// 		else{
	// 			return '0';
	// 		}
	// 	}
	// }
	// public function getTotalPair() {
	// 	if (isset($this->session->user_id)) {
	// 		$query = $this->db->WHERE('user_id', $this->session->user_id)
	// 			->GET('user_sales_match_monitor_tbl')->num_rows();
	// 		return $query;
	// 	}
	// }
	// public function getFifthPair() {
	// 	if (isset($this->session->user_id)) {
	// 		$query = $this->db->WHERE('user_id', $this->session->user_id)
	// 			->WHERE('status','5th_pair')
	// 			->GET('user_sales_match_monitor_tbl')->num_rows();
	// 		return $query;
	// 	}
	// }
	public function getMyOrdersCount() {
		if (isset($this->session->user_id)) {
			return $this->db->SELECT('ot.*, pmt.payment_ref_no, pmt.status as payment_status')
	    		->FROM('order_tbl as ot')
	    		->JOIN('payment_tbl as pmt', 'pmt.order_id=ot.order_id', 'left')
				->WHERE('ot.user_id', $this->session->user_id)
				->GET()->num_rows();
		}
	}
	public function getMyOrdersData($row_per_page, $row_no) {
		if (isset($this->session->user_id)) {
   //  		$query = $this->db->SELECT('rpt.*, pt.name')
	  //   		->FROM('repeat_purchase_history_tbl as rpt')
	  //   		->JOIN('products_tbl as pt', 'pt.p_id=rpt.p_id')
			// 	->ORDER_BY('pt.created_at', 'DESC')
			// 	->WHERE('rpt.user_code', $this->session->user_code)
			// 	->LIMIT($row_per_page, $row_no)
			// 	->GET()->result_array();
			// $result = array();

			// foreach($query as $q){
			// 	$array = array(
			// 		'ref_no'=>$q['ref_no'],
			// 		'user_code'=>$q['user_code'],
			// 		'name'=> ( strlen($q['name']) > 19 ) ? substr($q['name'], 0, 16).'...' : $q['name'],
			// 		'status'=>$q['status'],
			// 		'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
			// 	);
			// 	array_push($result, $array);
			// }
			// return $result;

    		$query = $this->db->SELECT('ot.*, pmt.payment_ref_no, pmt.status as payment_status')
	    		->FROM('order_tbl as ot')
	    		->JOIN('payment_tbl as pmt', 'pmt.order_id=ot.order_id', 'left')
				->ORDER_BY('ot.created_at', 'DESC')
				->WHERE('ot.user_id', $this->session->user_id)
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'order_id'=>$q['order_id'],
					'reference_no'=> $q['reference_no'],
					'payment_ref_no'=> $q['payment_ref_no'],
					'payment_status'=> $q['payment_status'],
					'bi_id'=>$q['bi_id'],
					'si_id'=>$q['si_id'],
					'total_revenue'=>number_format($q['total_revenue'], 2),
					'payment_method'=>$q['payment_method'],
					'note'=>$q['note'],
					'status'=>$q['status'],
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
	}

	public function sendContactMail(){
		$config = array (
			'mailtype' => 'html',
			'charset'  => 'utf-8',
			'priority' => '1'
		);
		$data['header_image'] = base_url().'assets/images/herbal-house-logo.png';
		$data['header_image_url'] = base_url().'?utm_source=herbalhouseph&utm_medium=contact&utm_campaign=email';

		$data['name'] = 'Admin';
		$data['email_address'] = $this->input->post('email_address');
		$data['subject'] = $this->input->post('subject');
		$data['sender'] = $this->input->post('fullname');
		$data['message'] = $this->input->post('message');

		$this->email->initialize($config);
		$this->email->from('no-reply@herbalhouseph.com', 'Herbal House Philippines');
		// $this->email->to('bl4nkcode01@gmail.com'); /* SEND TO ADMIN EMAIL */
		$this->email->reply_to($this->input->post('email_address')); /* SEND TO ADMIN EMAIL */
		$this->email->to('herbalhouseph@gmail.com'); /* SEND TO ADMIN EMAIL */
		$this->email->subject('New Message from Herbal House Contact Form');
		$body = $this->load->view('email/new_message', $data, TRUE);
		$this->email->message($body);
		$this->email->send();
	}
	public function passwordCheck($password){
		if (password_verify('123456', $password)) {
			return 'unchange';
		}
	}
}
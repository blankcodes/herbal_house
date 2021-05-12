<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_account_model extends CI_Model {

	public function getUserData() {
		if (isset($this->session->user_id)) {
			return $this->db->WHERE('user_id', $this->session->user_id)
				->GET('user_tbl')->row_array();
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
			->LIMIT(7)
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
			$query = $this->db->SELECT_SUM('amount')
				->WHERE('status !=','withdrawal')
				->WHERE('status !=','unilvl_bonus')
				->WHERE('user_code', $this->session->user_code)
				->GET('wallet_tbl')->row_array();
			return '₱ '.number_format($query['amount'], 2);

		}
	}
	public function getLeftSidePoints() {
		if (isset($this->session->user_id)) {
			$query = $this->db->SELECT('pos_left')
				->WHERE('user_code ',$this->session->user_code)
				->GET('user_sales_match_tbl')->row_array();
			return $query;
		}
	}
	public function getRightSidePoints() {
		if (isset($this->session->user_id)) {
			$query = $this->db->SELECT('pos_right')
				->WHERE('user_code ',$this->session->user_code)
				->GET('user_sales_match_tbl')->row_array();
			return $query;
		}
	}
}
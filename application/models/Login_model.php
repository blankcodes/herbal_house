<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function checkUserData($username) {
		return $this->db->WHERE('username', $username)
			->OR_WHERE('email_address', $username)
			->GET('user_tbl')->row_array();
	}
	public function insertNewRememberLogin($rememberLogin){
        if ($this->agent->is_mobile()) {
            $device = 'mobile_rm_token';
        }
        else{
            $device = 'web_rm_token';
        }
		$data = array($device=>$rememberLogin);
		$this->db->WHERE('user_id', $this->session->user_id)
			->UPDATE('user_tbl', $data);
	}
}
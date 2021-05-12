<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger_model extends CI_Model {
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
				$query = $this->db->ORDER_BY('created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET('package_tbl')->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'p_id'=>$q['p_id'],
					'name'=>$q['name'],
					'match_points'=>'₱ '.number_format($q['match_points'], 2),
					'unilvl_points'=>'₱ '.number_format($q['unilvl_points'], 2),
					'direct_points'=>'₱ '.number_format($q['direct_points'], 2),
					'pm_maximum_points'=>$q['pm_maximum_points'],
					'am_maximum_points'=>$q['am_maximum_points'],
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
			$query = $this->db->SELECT_SUM('amount')
				->WHERE('user_code',$this->session->user_code)
				->WHERE('status !=','withdrawal')
				->WHERE('status !=','unilvl_bonus')
				->GET('wallet_tbl')->row_array();

			$balance = '₱ '.number_format($query['amount'], 2);
			return array('balance'=>$balance);
		}
	}
	public function getWalletRecentActivity($row_per_page, $row_no){
		if ($this->session->user_id) {
			$activity = '';

			$query = $this->db
				->ORDER_BY('created_at', 'DESC')
				->ORDER_BY('status', 'DESC')
				->WHERE('status !=', 'unilvl_bonus')
				->WHERE('user_code',$this->session->user_code)
				->LIMIT($row_per_page, $row_no)
				->GET('wallet_tbl')->result_array();
			$result = array();

			foreach($query as $q){
				if($q['status'] == 'direct_referral'){
					$activity = 'Direct Referral Bonus';
				}
				else if($q['status'] == 'withdrawal'){
					$activity = 'Withdraw';
				}
				else if($q['status'] == 'uni_lvl_bonus'){
					$activity = 'Entry UniLevel Bonus';
				}
				$array = array(
					'activity'=>$activity,
					'amount'=>'₱ '.number_format($q['amount'], 2),
					'date'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
		}
	}
	public function getWalletRecentActivityCount(){
		if ($this->session->user_id) {
			return $this->db->WHERE('user_code',$this->session->user_code)
				->GET('wallet_tbl')->num_rows();
		}
	}
}
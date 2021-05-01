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
					'match_points'=>$q['match_points'],
					'direct_points'=>'₱ '.number_format($q['direct_points'], 2),
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
}
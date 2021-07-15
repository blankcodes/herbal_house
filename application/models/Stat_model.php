<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stat_model extends CI_Model {
	public function getOrderSales(){
		$dateNow = date('Y-m-d H:i:s');
        $yearNow = date('Y');
        $range = '30 day';
        switch ($range) {
            case '30 day':
                $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
                $end_date = date('Y-m-d 23:59:59');
                $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
                $groupBy = 'DATE(created_at)';
            break;
            
            case 'monthly':
                $start_date = $yearNow.'-01-01 '.date('23:59:59');
                $end_date = date('Y-m-d 23:59:59');
                $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
                $groupBy = 'MONTH(created_at)';
            break;

            case 'weekly':
                $start_date = $yearNow.'-01-01 '.date('23:59:59');
                $end_date = date('Y-m-d 23:59:59');
                $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
                $groupBy = 'WEEK(created_at)';
            break;

            case 'daily':
                $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
                $end_date = date('Y-m-d 23:59:59');
                $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
                $groupBy = 'DATE(created_at)';
            break;
            
        }
        $status = array('status'=> '1');
        $query = $this->db->SELECT('DATE(created_at) as date_ordered, SUM(total_revenue) as sales, YEAR(created_at) as date_now')
            ->WHERE('status','delivered')
            ->WHERE($date_range)
            ->GROUP_BY($groupBy)
            ->ORDER_BY('created_at', 'desc')
            ->GET('order_tbl')->result_array();

        $result = array();
        foreach($query as $q){
            $array = array(
                'date'=>date('Y-m-d', strtotime($q['date_ordered'])),
                'sales'=>$q['sales'],
            );
            array_push($result, $array);
        }
        return $result;
	}
}
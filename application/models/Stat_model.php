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

    public function getTotalROI(){
        $dateNow = date('Y-m-d H:i:s');
        $yearNow = date('Y');
        $range = $this->input->get('range');
        $total_sales = '';
        $monthly_sales = '';

        switch ($range) {
            case '3 Month Profit':
                $start_date = date('Y-m-d 00:00:00', strtotime('-90 day', strtotime(date('Y-m-d 00:00:00'))));
                $end_date = date('Y-m-d 23:59:59');
                $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
                $groupBy = 'DATE(created_at)';

                // $total_sales = $this->getTotalSales();
                $this_month_roi = $this->getMonthlyROI();
                $total_investment = $this->getTotalInvetstment();
            break;


            case 'daily':
                $start_date = date('Y-m-d 00:00:00', strtotime('-30 day', strtotime(date('Y-m-d 00:00:00'))));
                $end_date = date('Y-m-d 23:59:59');
                $date_range = array('created_at >'=>$start_date, 'created_at <'=> $end_date);
                $groupBy = 'DATE(created_at)';
            break;
            
        }
        $query = $this->db->SELECT('DATE(created_at) as created_at, SUM(amount) as amount')
            ->WHERE($date_range)
            ->GROUP_BY($groupBy)
            ->ORDER_BY('created_at', 'desc')
            ->GET('investment_points_tbl')->result_array();

        // $query = $this->db->SELECT('DATE(updated_at) as date_ordered, SUM(total_revenue) as sales, YEAR(updated_at) as date_now')
        //     ->WHERE('status','delivered')
        //     ->WHERE($date_range)
        //     ->GROUP_BY($groupBy)
        //     ->ORDER_BY('updated_at', 'desc')
        //     ->GET('order_tbl')->result_array();

        $result = array();
        foreach($query as $q){
            $array = array(
                'date'=>date('Y-m-d', strtotime($q['created_at'])),
                'amount'=>$q['amount'],
            );
            array_push($result, $array);
        }
        $data['roi'] = $result;
        // $data['total_sales'] = '₱ '.number_format($total_sales['total_sales'], 2);
        $data['monthly_sales'] = '₱ '.number_format($this_month_roi['roi']['total_investment'], 2);
        $data['investment'] = '₱ '.number_format($total_investment['total_investment'], 2);
        $data['month_name'] = $this_month_roi['month_name'];
        return $data;
    }
    public function getTotalSales(){
        return $this->db->SELECT('SUM(total_revenue) as total_sales')
            ->WHERE('status','delivered')
            ->GET('order_tbl')->row_array();
    }
    public function getMonthlyROI(){
        $month = date('m');
        $today = date('Y-m-d');
        
        // $data['sales'] = $this->db->SELECT('SUM(total_revenue) as total_sales')
        //     ->WHERE('month(created_at)', $month)
        //     ->WHERE('status','delivered')
        //     ->GET('order_tbl')->row_array();
        // return $data;

        $data['roi'] = $this->db->SELECT('SUM(amount) as total_investment')
            ->WHERE('month(created_at)', $month)
            ->GET('investment_points_tbl')->row_array();

        $data['month_name'] = date('F');

        return $data;
    }
    public function sortMonthlyROI(){
        $month = date($this->input->get('m'));

        // $sales = $this->db->SELECT('SUM(total_revenue) as total_sales')
        //     ->WHERE('month(created_at)', $month)
        //     ->WHERE('status','delivered')
        //     ->GET('order_tbl')->row_array();

        $roi =$this->db->SELECT('SUM(amount) as roi')
            ->WHERE('month(created_at)', $month)
            ->GET('investment_points_tbl')->row_array();


        $data['month_name'] = $this->input->get('F');
        $data['roi'] = '₱ '.number_format($roi['roi'],2);
        return $data;
    }
    public function getROIByDate(){
        $from = date('Y-m-d', strtotime($this->input->get('f'))).' 00:00:00';
        $to = date('Y-m-d', strtotime($this->input->get('t'))).' 23:59:59';
        $date_range = array('created_at >'=>$from, 'created_at <'=> $to);
        $groupBy = 'DATE(created_at)';

        // $query = $this->db->SELECT('DATE(updated_at) as date_ordered, SUM(total_revenue) as sales, YEAR(updated_at) as date_now')
        //     ->WHERE('status','delivered')
        //     ->WHERE($date_range)
        //     ->GROUP_BY($groupBy)
        //     ->ORDER_BY('created_at', 'desc')
        //     ->GET('order_tbl')->result_array();

        $query = $this->db->SELECT('DATE(created_at) as created_at, SUM(amount) as amount')
            ->WHERE($date_range)
            ->GROUP_BY($groupBy)
            ->ORDER_BY('created_at', 'desc')
            ->GET('investment_points_tbl')->result_array();

        $result = array();
        foreach($query as $q){
            $array = array(
                'date'=>date('Y-m-d', strtotime($q['created_at'])),
                'amount'=>$q['amount'],
            );
            array_push($result, $array);
        }
        $data['roi'] = $result;
        return $data;

    }
    public function getProductPurchaseCount(){
       if ($this->session->user_type == 'investor') {
            $from = date('Y-m-d', strtotime($this->input->get('f'))).' 00:00:00';
            $to = date('Y-m-d', strtotime($this->input->get('t'))).' 23:59:59';
            $date_range = array('ipt.created_at >'=>$from, 'ipt.created_at <'=> $to);
            $groupBy = 'DATE(ot.created_at)';

            return $this->db
                ->FROM('investment_points_tbl as ipt')
                ->JOIN('products_tbl as pt', 'pt.p_id = ipt.p_id')
                ->JOIN('product_category_tbl as pct', 'pct.pc_id = pt.pc_id')
                ->WHERE($date_range)
                ->GET()->num_rows();
        }
    }
    public function getProductPurchase($row_per_page, $row_no){
       if ($this->session->user_type == 'investor') {
            $from = date('Y-m-d', strtotime($this->input->get('f'))).' 00:00:00';
            $to = date('Y-m-d', strtotime($this->input->get('t'))).' 23:59:59';
            $date_range = array('ipt.created_at >'=>$from, 'ipt.created_at <'=> $to);
            $groupBy = 'DATE(ot.created_at)';

            $query = $this->db->SELECT('ipt.amount, pt.name as product_name, pt.url as product_url, ipt.created_at as ordered_date,pct.name as category, pct.category_url')
                ->FROM('investment_points_tbl as ipt')
                // ->JOIN('order_tbl as ot', 'ot.order_id = ipt.order_id')
                ->JOIN('products_tbl as pt', 'pt.p_id = ipt.p_id')
                ->JOIN('product_category_tbl as pct', 'pct.pc_id = pt.pc_id')
                // ->WHERE('ot.status','delivered')
                ->WHERE($date_range)
                // ->GROUP_BY($groupBy)
                ->ORDER_BY('ipt.created_at', 'DESC')
                ->LIMIT($row_per_page, $row_no)
                ->GET()->result_array();
            $result = array();

            foreach($query as $q){
                $array = array(
                    'product_name'=>$q['product_name'],
                    'product_url'=>base_url('product/').$q['product_url'],
                    'category_url'=>base_url('product/category/').$q['category_url'],
                    'earned'=>'₱ '.number_format($q['amount'] ,2),
                    'category'=>$q['category'],
                    'ordered_date'=>date('m/d/Y h:i A', strtotime($q['ordered_date'])),
                );
                array_push($result, $array);
            }
            return $result;
        }
    }
    public function getTotalInvetstment(){
        return $this->db->SELECT('SUM(amount) as total_investment')
            ->GET('investment_points_tbl')->row_array();
    }
}
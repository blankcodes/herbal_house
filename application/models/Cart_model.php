<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {

	/*
	* $this->session->temp_user_id is a non-member/disributor, a visitor who added to cart.
	*/ 
	public function addToCart() {
		if (isset($this->session->user_id)) {
			$user_id = $this->session->user_id;
		}
		else if (isset($this->session->temp_user_id)) {
			$user_id = $this->session->temp_user_id;
		}
		else {
			$user_id = $this->userIDGenerator();
		}
		
		$product = $this->db->WHERE('p_pub_id', $this->input->post('product_pub_id'))->GET('products_tbl')->row_array();
		$checkCart = $this->db->WHERE('p_id',$product['p_id'])->WHERE('user_id', $user_id)->GET('cart_tbl')->row_array();

		if (isset($checkCart)) {
			$data = array(
				'qty'=> $this->input->post('qty') + $checkCart['qty'],
				'updated_at'=>date('Y-m-d H:i:s')
			);
			$this->db->WHERE('p_id', $product['p_id'])->UPDATE('cart_tbl', $data);
		}
		else{
			$data = array(
				'p_id'=>$product['p_id'],
				'c_pub_id'=>$this->cartPublicID(),
				'price'=> ($this->session->user_id) ? $product['dc_price'] : $product['srp_price'],
				'user_id'=> $user_id,
				'qty'=> $this->input->post('qty'),
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('cart_tbl', $data);
		}

		$response['status'] = 'success';
		$response['message'] = $product['name'].' added to cart!';
		return $response;
	}
	public function userIDGenerator($length=19) {
   		$characters = '0123456789abcdef';
	    $charactersLength = strlen($characters);
	    $tempUserID = '';
	    for ($i = 0; $i < $length; $i++) {
	        $tempUserID .= $characters[rand(0, $charactersLength - 1)];
	    }
	   
	  	$checkUserID = $this->checkTempUserID($tempUserID);
		if ($checkUserID > 0) {
	   		$this->userIDGenerator();
		}
		else{
        	$userID = $this->session->set_userdata('temp_user_id', $tempUserID);
			return $tempUserID;
		}
    }
    public function cartPublicID($length=19) {
   		$characters = '0123456789abcdef';
	    $charactersLength = strlen($characters);
	    $cart_pub_id = '';
	    for ($i = 0; $i < $length; $i++) {
	        $cart_pub_id .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $cart_pub_id;
    }
    public function checkTempUserID($tempUserID) {
    	return $this->db->WHERE('user_id', $tempUserID)
    		->GET('cart_tbl')->num_rows();
    }
    public function getCartData(){
    	if (isset($this->session->user_id)) {
			$user_id = $this->session->user_id;
		}
		else if (isset($this->session->temp_user_id)) {
			$user_id = $this->session->temp_user_id;
		}
		else {
			$user_id = $this->userIDGenerator();
		}

		$query =  $this->db->SELECT('pt.p_pub_id, pt.image, pt.name, ct.price, ct.qty, pt.url')
			->FROM('products_tbl as pt')
			->JOIN('cart_tbl as ct', 'ct.p_id = pt.p_id', 'left')
			->WHERE('ct.user_id', $user_id)
			->LIMIT(6)
    		->GET()->result_array();

    	$result = array();
    	foreach($query as $q){
			$array = array(
				'p_pub_id'=>$q['p_pub_id'],
				'product_name'=> $q['name'],
				'product_image'=>base_url().$q['image'],
				'price'=>number_format($q['price'] * $q['qty'], 2),
				'qty'=>$q['qty'],
				'product_url'=>base_url('product/').$q['url'],
			);
			array_push($result, $array);
		}
		return $result;
    }
    public function checkShopCart(){
    	if (isset($this->session->user_id)) {
			$user_id = $this->session->user_id;
		}
		else if (isset($this->session->temp_user_id)) {
			$user_id = $this->session->temp_user_id;
		}
		else {
			$user_id = $this->userIDGenerator();
		}

		$query = $this->db->WHERE('user_id', $user_id)->GET('cart_tbl')->result_array();
		return $query;	
    }

    public function getShoppingCartData(){
    	if (isset($this->session->user_id)) {
			$user_id = $this->session->user_id;
		}
		else if (isset($this->session->temp_user_id)) {
			$user_id = $this->session->temp_user_id;
		}
		else {
			$user_id = $this->userIDGenerator();
		}

		$query = $this->db->SELECT('pt.p_pub_id, pt.image, pt.name, pt.url, ct.c_pub_id, ct.price, ct.qty, pt.qty as p_qty')
			->FROM('products_tbl as pt')
			->JOIN('cart_tbl as ct', 'ct.p_id = pt.p_id', 'left')
			->WHERE('ct.user_id', $user_id)
			->GET()->result_array();

		$result = array();
    	$grand_total = 0;
    	$total = 0;
    	foreach($query as $q){
    		$total_price_per_product = $q['price'] * $q['qty'];
    		$grand_total += $total_price_per_product;
			$array = array(
				'c_pub_id'=>$q['c_pub_id'],
				'c_pub_id'=>$q['c_pub_id'],
				'product_name'=> ( strlen($q['name']) > 35 ) ? substr($q['name'], 0, 30).'...' : $q['name'],
				'product_image'=>base_url().$q['image'],
				'price'=>number_format($q['price'], 2),
				'total_price'=>number_format($total_price_per_product, 2),
				'qty'=>$q['qty'],
				'p_qty'=>$q['p_qty'],
				'product_url'=>base_url('product/').$q['url']
			);
			array_push($result, $array);
		}
		$data['grand_total'] = number_format( $grand_total, 2);
		$data['total'] = number_format( $grand_total, 2);
		$data['discount'] = '0';
		$data['shipping_charge'] = '0';
		$data['count'] = $this->db->WHERE('user_id', $user_id)->GET('cart_tbl')->num_rows();
		$data['cart'] = $result;
		return $data;
    }
    public function deleteCart() {
    	$this->db->WHERE('c_pub_id', $this->input->post('c_pub_id'))
    		->DELETE('cart_tbl');
    	$response['status'] = 'success';	
    	$response['message'] = 'Cart Removed!';
    	return $response;	
    }
    public function updateCartQty() {
    	$input_qty = $this->input->post('qty');
    	
		if ($input_qty > 0) {
			$data = array('qty'=> $input_qty);

	    	$this->db->WHERE('c_pub_id', $this->input->post('c_pub_id'))
	    		->UPDATE('cart_tbl', $data);

	    	$response['status'] = 'success';	
	    	$response['message'] = 'Cart quantity updated!';		
	    }
		else{
			$response['status'] = 'failed';	
	    	$response['message'] = 'Quantity should be higher than zero!';
		}
    	return $response;	
    }
    public function checkUserCart() {
    	return $this->db->WHERE('user_id', $this->session->temp_user_id)
    		->GET('cart_tbl')->result_array();
    }
    public function updateUserCartData($p_id) {
    	$checkCartMember = $this->db->WHERE('p_id', $p_id)->WHERE('user_id', $this->session->user_id)->GET('cart_tbl')->row_array();
		$checkCartTempUser = $this->db->WHERE('p_id',$p_id)->WHERE('user_id', $this->session->temp_user_id)->GET('cart_tbl')->row_array();

		if (isset($checkCartTempUser) && isset($checkCartMember)) {
			$data = array(
				'qty'=> $checkCartMember['qty'] + $checkCartTempUser['qty'],
				'updated_at'=>date('Y-m-d H:i:s')
			);
			$this->db->WHERE('p_id', $p_id)->WHERE('user_id', $this->session->user_id)->UPDATE('cart_tbl', $data); /* update the single product from the seesion of current login and non-login user*/
			$this->db->WHERE('p_id', $p_id)->WHERE('user_id', $this->session->temp_user_id)->DELETE('cart_tbl');
		}

    	else {
    		$data = array('user_id'=>$this->session->user_id);

    		$this->db->WHERE('user_id',$this->session->temp_user_id)
    			->UPDATE('cart_tbl', $data);
    	}
    }
    public function checkCartData(){
    	if (isset($this->session->user_id)) {
			$user_id = $this->session->user_id;
		}
		else if (isset($this->session->temp_user_id)) {
			$user_id = $this->session->temp_user_id;
		}
		
		return $this->db->WHERE('user_id', $user_id)
			->GET('cart_tbl')->num_rows();
    }
}
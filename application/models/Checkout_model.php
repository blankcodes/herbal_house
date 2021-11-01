<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout_model extends CI_Model {

	public function addBillingInfo() {
		if (isset($this->session->user_id)) {
			$user_id = $this->session->user_id;
		}
		else if (isset($this->session->temp_user_id)) {
			$user_id = $this->session->temp_user_id;
		}
		else {
			$user_id = $this->userIDGenerator();
		}

		$checkBill = 'false';
		$billOrder = 0;
		$checkBillInfo = $this->checkBillingInfo($user_id);		
		if (isset($checkBillInfo)) {
			$billOrder = $this->checkBillOrder($checkBillInfo['bi_id']);
			$checkBill = 'true';
		}

		$fname = $this->input->post('fname');
		$lname = $this->input->post('lname');
		$email_address = $this->input->post('email_address');
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$zip_code = $this->input->post('zip_code');
		$country = $this->input->post('country');
		$order_notes = $this->input->post('order_notes');
		$ship_same_address = $this->input->post('ship_same_address');


		$dataArr = array(
			'user_id'=>$user_id,
			'fname'=>$fname,
			'lname'=>$lname,
			'email_address'=>$email_address,
			'phone_number'=>$phone,
			'full_address'=>$address,
			'city'=>$city,
			'state'=>$state,
			'zip_code'=>$zip_code,
			'country'=>$country,
			'created_at'=>date('Y-m-d H:i:s'),
		);

		$this->form_validation->set_rules('email_address', 'Email', 'required|valid_email',
			array(
				'valid_email' => 'Please input a valid Email Address!',
				'required' => 'Email Address is Required!'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			$response['status'] = 'failed';
			$response['message'] = $this->form_validation->error_array();
		}

		else if ($checkBill == 'true' && $billOrder > 0) { /* if bill info already used on an order */
			$this->db->INSERT('billing_info_tbl', $dataArr);
			if (isset($ship_same_address)) { /* if checked, copy to shipping bl */
				$this->addUpdateShippingInfo($dataArr, $user_id);
			}
			$response['status'] = 'success';
			$response['message'] = 'Added 1 billing info!';
		}
		else if($checkBill == 'true' && $billOrder == 0) {
			$this->db->WHERE('bi_id', $checkBillInfo['bi_id'])->UPDATE('billing_info_tbl', $dataArr);
			if (isset($ship_same_address)) { /* if checked, copy to shipping bl */
				$this->addUpdateShippingInfo($dataArr, $user_id);
			}
			$response['status'] = 'success';
			$response['message'] = 'Updated billing info!';
		}
		else{
			// $this->db->WHERE('bi_id', $checkBillInfo['bi_id'])->UPDATE('billing_info_tbl', $data);
			$this->db->INSERT('billing_info_tbl', $dataArr);

			if (isset($ship_same_address)) { /* if checked, copy to shipping bl */
				$this->addUpdateShippingInfo($dataArr, $user_id);
			}
			$response['status'] = 'success';
			$response['message'] = 'Added 2 billing info!';
		}
		return $response;
	}
	public function checkBillingInfo($user_id){
		return $this->db->WHERE('user_id', $user_id)
			->ORDER_BY('created_at','desc')
			->GET('billing_info_tbl')->row_array();
	}
	public function checkBillOrder($bi_id){
		return $this->db->WHERE('bi_id', $bi_id)
			->GET('order_tbl')->num_rows();
	}
	public function checkShipOrder($si_id){
		return $this->db->WHERE('si_id', $si_id)
			->GET('order_tbl')->num_rows();
	}
	public function checkShippingInfo($user_id){
		return $this->db->WHERE('user_id', $user_id)
			->ORDER_BY('created_at','desc')
			->GET('shipping_info_tbl')->row_array();
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
    public function checkTempUserID($tempUserID) {
    	return $this->db->WHERE('user_id', $tempUserID)
    		->GET('cart_tbl')->num_rows();
    }
    public function getBillingInfo(){
    	if (isset($this->session->user_id)) {
			$user_id = $this->session->user_id;
		}
		else if (isset($this->session->temp_user_id)) {
			$user_id = $this->session->temp_user_id;
		}
		else {
			$user_id = $this->userIDGenerator();
		}


    	if (isset($user_id)) {
    		return $this->db->ORDER_BY('created_at','desc')->WHERE('user_id', $user_id)->GET('billing_info_tbl')->row_array();
    	}
    	else{
    		$response['status'] = 'failed';
			$response['message'] = 'No record yet!';
    	}
    }
    public function addShippingInfo() {
		if (isset($this->session->user_id)) {
			$user_id = $this->session->user_id;
		}
		else if (isset($this->session->temp_user_id)) {
			$user_id = $this->session->temp_user_id;
		}
		else {
			$user_id = $this->userIDGenerator();
		}

		$fname = $this->input->post('fname');
		$lname = $this->input->post('lname');
		$email_address = $this->input->post('email_address');
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$zip_code = $this->input->post('zip_code');
		$country = $this->input->post('country');
		$order_notes = $this->input->post('order_notes');
		// $ship_same_address = $this->input->post('ship_same_address');


		$checkShip = 'false';
		$shipOrder = 0;
		$checkShipInfo = $this->checkShippingInfo($user_id);		
		if (isset($checkShipInfo)) {
			$shipOrder = $this->checkShipOrder($checkShipInfo['si_id']);
			$checkShip = 'true';
		}
		
		$dataArr = array(
			'user_id'=>$user_id,
			'fname'=>$fname,
			'lname'=>$lname,
			'email_address'=>$email_address,
			'phone_number'=>$phone,
			'full_address'=>$address,
			'city'=>$city,
			'state'=>$state,
			'zip_code'=>$zip_code,
			'country'=>$country,
			'created_at'=>date('Y-m-d H:i:s'),
		);

		$this->form_validation->set_rules('email_address', 'Email', 'required|valid_email',
			array(
				'valid_email' => 'Please input a valid Email Address!',
				'required' => 'Email Address is Required!'
			)
		);

		if ($this->form_validation->run() == FALSE) {
			$response['status'] = 'failed';
			$response['message'] = $this->form_validation->error_array();
		}
		else if ($checkShip == 'true' && $shipOrder > 0) {
			$this->db->INSERT('shipping_info_tbl', $dataArr);
			$response['status'] = 'success';
			$response['message'] = 'Added Shipping info!';
		}
		else if ($checkShip == 'true' && $shipOrder == 0) {
			$this->db->WHERE('si_id', $checkShipInfo['si_id'])->UPDATE('shipping_info_tbl', $dataArr);
			$response['status'] = 'success';
			$response['message'] = 'Updating Shipping info!';
		}
		else{
			$this->db->INSERT('shipping_info_tbl', $dataArr);
			$response['status'] = 'success';
			$response['message'] = 'Added Shipping info!';
		}
		return $response;
	}
    public function getShippingInfo(){
    	if (isset($this->session->user_id)) {
			$user_id = $this->session->user_id;
		}
		else if (isset($this->session->temp_user_id)) {
			$user_id = $this->session->temp_user_id;
		}
		else {
			$user_id = $this->userIDGenerator();
		}


    	if (isset($user_id)) {
    		return $this->db->WHERE('user_id', $user_id)->ORDER_BY('created_at','desc')->GET('shipping_info_tbl')->row_array();
    	}
    	else{
    		$response['status'] = 'failed';
			$response['message'] = 'No record yet!';
    	}
    }
    public function getShippingInfoByID($user_id){
    	return $this->db->SELECT('si_id')->WHERE('user_id',$user_id)->ORDER_BY('created_at', 'desc')->WHERE('status','active')->GET('shipping_info_tbl')->row_array();
    }
    public function getBillingInfoByID($user_id){
    	return $this->db->SELECT('bi_id')->WHERE('user_id', $user_id)->ORDER_BY('created_at', 'desc')->WHERE('status','active')->GET('billing_info_tbl')->row_array();
    }
    public function generateReferenceNo($order_id,  $length = 11) {
	    $characters = '0123456789ABCDEF';
	    $charactersLength = strlen($characters);
	    $reference_no = '';
	    for ($i = 0; $i < $length; $i++) {
	        $reference_no .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $reference_no = 'HO'.$order_id.$reference_no;

	    $check = $this->db->WHERE('reference_no',$reference_no)->GET('order_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateReferenceNo($order_id);
	    }
	    else{
		    $data = array(
	    		'reference_no'=>$reference_no,
	    	);
	    	$this->db->WHERE('order_id', $order_id)->UPDATE('order_tbl', $data); /* insert reference no*/

	    	$logs = array('order_id'=>$order_id, 'activity'=>'Generating new Order reference no. '.$reference_no );
	    	$this->insertOrderEventLogs($logs);
	    }
    	return $reference_no;
	}
	public function getPaymentOptions(){
		$query = $this->db->WHERE('status','active')->GET('payment_method_tbl')->result_array();

		$result = array();
		foreach ($query as $q) {
			$array = array(
				'payment_id'=>$q['pm_id'],
				'payment_method'=>$q['name'],
				'payment_description'=>$q['description'],
				'payment_logo'=>base_url().$q['logo'],
			);
			array_push($result, $array);
		}
		return $result;
	}

	public function placeOrder() {
    	if (isset($this->session->user_id)) {
			$user_id = $this->session->user_id;
		}
		else if (isset($this->session->temp_user_id)) {
			$user_id = $this->session->temp_user_id;
		}
		$checkShipinfo = $this->checkShippingInfo($user_id);
		$checkBillinfo = $this->checkBillingInfo($user_id);
    	$payment_method = $this->input->post('payment_method');

    	$this->form_validation->set_rules('payment_method', 'Payment Method', 'required',
			array(
				'required' => 'Please choose your preferred Payment Method!'
			)
		);

    	if (!isset($checkBillinfo)) { /* check if there's a BILLING INFO saved from client*/
			$response['status'] = 'no_bill_info';
			$response['message'] = 'Billing Info is required!';
			return $response;
			exit();
		}

    	if (!isset($checkShipinfo)) { /* check if there's a SHIPPING INFO saved from client*/
			$response['status'] = 'no_ship_info';
			$response['message'] = 'Shipping Info is required!';
			return $response;
			exit();
		}

		if ($this->form_validation->run() == FALSE) { /* check if there's a PAYMENT METHOD choose by client*/
			$response['status'] = 'failed';
			$response['message'] = $this->form_validation->error_array();
			return $response;
			exit();
		}
		
		if ($payment_method == 'Cash On Delivery') {
			$revenue = $this->getTotalRevenue($user_id);
			if ($revenue['total'] > 0) {
				$reference_no = $this->insertNewOrder($user_id, $checkShipinfo['si_id'], $checkBillinfo['bi_id']);
				$response['status'] = 'success';
				$response['message'] = 'Order has been created!';
				$response['order_url'] = base_url('order/').$reference_no;
			}
			else{
				$response['status'] = 'failed';
				$response['message'] = "Something went wrong. Please refresh the page and try again!";
				$response['order_url'] = '';
				return $response;
			}
			
		}
		else if($payment_method == 'Paypal') {
			$response['status'] = 'failed';
			$response['message'] = "There's something wrong on your Payment option. Kindly choose other Payment method!";
			$response['order_url'] = '';
		}
		return $response;
    }
    public function insertNewOrder($user_id, $si_id, $bi_id) {
    	$referrer = '';
    	$getShipInfo = $this->getShippingInfoByID($user_id);
    	$getBillInfo = $this->getBillingInfoByID($user_id);
    	$order_note = $this->input->post('order_notes');
    	$payment_method = $this->input->post('payment_method');
    	$revenue = $this->getTotalRevenue($user_id);

    	if (isset($this->session->referrer) && isset($this->session->username)) { /* NO REFERRER WILL BE DETECTED IF THE A MEMBER IS LOGGED IN EVEN USING A REFERRER LINK TO PURCHASE*/
    		$referrer = '';
    	}
    	else if(isset($this->session->referrer)){
    		$referrer = $this->session->referrer;
    	}

    	$data = array(
	    	'bi_id'=>$bi_id,
	    	'si_id'=>$si_id,
	    	'user_id'=>$user_id,
	    	'status'=>'created',
	    	'shipping_fee'=> '170', /* fixed shipping fee*/
	    	'total_revenue'=>$revenue['total'],
	    	'note'=>$order_note,
	    	'referrer'=>$referrer,
	    	'payment_method'=>$payment_method,
	    	'created_at'=>date('Y-m-d H:i:s'),
	    );
	    $this->db->INSERT('order_tbl', $data);
	    $order_id = $this->db->insert_id();

	    $reference_no = $this->generateReferenceNo($order_id);  /* insert order ref no */
	    $moveCartToSales = $this->moveCartToSales($user_id, $order_id);  /* move cart items to sales */
	    $this->paymentDetails($order_id, $payment_method ); /* insert payment details*/

	    $activity = 'Order Placed';
	    $this->shipmentTracking($order_id, $activity); /* insert shipment track details*/

	    $notif_log = array('user_id'=>$user_id, 'message'=>'New Order Placed. Order #'.$reference_no,'created_at'=>date('Y-m-d H:i:s')); 
		$this->insertNewNotification($notif_log); /* INSERT new Notification */

		$activity_log = array(
			'user_id'=>$user_id, 
			'message_log'=>'Placed and order with a reference number <a target="_blank" href="'.base_url('order/').$reference_no.'">'.$reference_no.'</a>.',
			'ip_address'=>$this->input->ip_address(), 
			'platform'=>$this->agent->platform(), 
			'browser'=>$this->agent->browser(),
			'created_at'=>date('Y-m-d H:i:s')
		); 
		$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

		$this->sendOrderConfirmationEmail($order_id); /* SEND EMAIL TO THE USER FOR PLACE ORDER ORDER */
		$this->sendOrderEmailNotificationToAdmin($order_id); /* SEND EMAIL TO THE ADMIN FOR NOTIFICATION */

		return $reference_no;
    }
    public function insertActivityLog ($activity_log) {
		$this->db->INSERT('activity_logs_tbl', $activity_log);
	}
    public function moveCartToSales($user_id, $order_id) {
    	$cart = $this->db->WHERE('user_id', $user_id)->GET('cart_tbl')->result_array();

    	foreach ($cart as $ca) {
    		$this->minusQtyFromCartToProduct($ca['p_id'], $ca['qty']);
    		$arr = array(
    			'order_id'=>$order_id,
    			'user_id'=>$user_id,
    			'p_id'=>$ca['p_id'],
    			'price'=>$ca['price'],
    			'qty'=>$ca['qty'],
    			'created_at'=>date('Y-m-d H:i:s'),
    		);
    		$this->db->INSERT('sales_tbl', $arr); /* move cart to sales */
    	}
    	$this->db->WHERE('user_id', $user_id)->DELETE('cart_tbl'); /* remove all cart after moved */

    }
    public function minusQtyFromCartToProduct($p_id, $qty) {
    	$product = $this->db
    		->WHERE('p_id', $p_id)
    		->GET('products_tbl')->row_array();
    	$prod_qty = $product['qty'] - $qty;

    	$data = array('qty'=>$prod_qty);
    	$this->db->WHERE('p_id', $p_id)->UPDATE('products_tbl', $data); /* update qty of the product */
    }
    public function getTotalRevenue($user_id){
    	$query = $this->db->SELECT('price, qty')
			->WHERE('user_id', $user_id)
			->GET('cart_tbl')->result_array();

    	$grand_total = 0;
    	$total = 0;
    	foreach($query as $q){
    		$total_price_per_product = $q['price'] * $q['qty'];
    		$grand_total += $total_price_per_product;
		}
		$data['grand_total'] = $grand_total;
		$data['total'] = $grand_total;

		return $data;
    }
    public function paymentDetails($order_id, $payment_method ) {
    	$payment_ref_no = '';
    	if ($payment_method == 'Cash On Delivery') {
    		$payment_ref_no = '';
    		$status = 'unpaid';
    	}

    	$data = array(
    		'order_id'=>$order_id,
    		'payment_method'=>$payment_method,
    		'payment_ref_no'=>$payment_ref_no,
    		'status'=>$status,
    		'created_at'=>date('Y-m-d H:i:s'),
    	);
    	$this->db->INSERT('payment_tbl', $data);
    }
    public function shipmentTracking($order_id, $activity ) {
    	$data = array(
    		'order_id'=>$order_id,
    		'activity_log'=>$activity,
    		'created_at'=>date('Y-m-d H:i:s'),
    	);
    	$this->db->INSERT('shipment_track_tbl', $data);
    }
    public function insertNewNotification ($notif_log) {
		$this->db->INSERT('notification_tbl', $notif_log);
	}
	public function insertOrderEventLogs($logs){
		$this->db->INSERT('order_events_tbl', $logs);
	}
	public function sendOrderConfirmationEmail($order_id) {
		$orderData = $this->getOrderData($order_id);
		$orderCart = $this->getOrderItemsCart($order_id);
		$orderAmount = $this->orderedAmount($order_id, $orderData['shipping_fee']);
		$billingInfo = $this->getOrderBillingInfo($orderData['bi_id']);
		$shippingInfo = $this->getOrderShippingInfo($orderData['si_id']);
		$config = array (
			'mailtype' => 'html',
			'charset'  => 'utf-8',
			'priority' => '1'
		);
		$data['header_image'] = base_url().'assets/images/herbal-house-logo.png';
        $data['header_image_url'] = base_url().'?utm_source=herbalhouse&utm_medium=order_confirmation&utm_campaign=email';
        $data['name'] = $orderData['fname'].' '.$orderData['lname'];
        $data['email_address'] = $orderData['email_address'];
        $data['payment_method'] = $orderData['payment_method'] ;
        $data['order_details'] = base_url('order/').$orderData['reference_no'];
        $data['ordered_cart'] =  $orderCart;
        $data['orderAmount'] =  $orderAmount;
        $data['billingInfo'] =  $billingInfo;
        $data['shippingInfo'] =  $shippingInfo;
        $data['payment_method'] =  $orderData['payment_method'];

		$this->email->initialize($config);
		$this->email->from('no-reply@herbalhouseph.com', 'Herbal House Philippines');
		$this->email->to($orderData['email_address']);
		$this->email->subject('Thank you for your order');
		$body = $this->load->view('email/order_confirmation', $data, TRUE);
		$this->email->message($body);
		$this->email->send();

		$logs = array('order_id'=>$order_id, 'activity'=>'Order email confirmation sent.');
	    $this->insertOrderEventLogs($logs);
	}
	public function sendOrderEmailNotificationToAdmin($order_id) {
		if (strpos(base_url(), 'localhost') !== false || strpos(base_url(), 'test') !== false) {
			$recv_email = 'bl4nkcode01@gmail.com';
		}
		else{
			$recv_email = 'herbalhouseph@gmail.com';
		}


		$orderData = $this->getOrderData($order_id);
		
		$config = array (
			'mailtype' => 'html',
			'charset'  => 'utf-8',
			'priority' => '1'
		);
		$order_date = date('F d, Y, h:i A', strtotime($orderData['ordered_date']));
		$data['header_image'] = base_url().'assets/images/herbal-house-logo.png';
		$data['header_image_url'] = base_url().'?utm_source=herbalhouse&utm_medium=order_confirmation&utm_campaign=email';
		$data['name'] = 'Admin';
		$data['email_address'] = $orderData['email_address'];
		$data['reference_no'] = $orderData['reference_no'];
		$data['total_amount'] = number_format( $orderData['total_amount'], 2);
		$data['payment_method'] = $orderData['payment_method'] ;
		$data['order_details'] = base_url('order/details/').$orderData['reference_no'];
		$data['ordered_date'] =  $order_date;

		$this->email->initialize($config);
		$this->email->from('no-reply@herbalhouseph.com', 'Herbal House Philippines');
		$this->email->to($recv_email); /* SEND TO ADMIN EMAIL */
		$this->email->subject('New Order Arrived!');
		$body = $this->load->view('email/admin_order_notification', $data, TRUE);
		$this->email->message($body);
		$this->email->send();

		$logs = array('order_id'=>$order_id, 'activity'=>'Email sent to admin for Notification.');
	    $this->insertOrderEventLogs($logs);
	}
	public function getOrderData($order_id) {
		$query = $this->db->SELECT('bit.fname, bit.lname, bit.email_address, ot.si_id, ot.bi_id, ot.reference_no, ot.shipping_fee, ot.total_revenue as total_amount, ot.payment_method, ot.created_at as ordered_date')
			->FROM('order_tbl as ot')
			->JOIN('billing_info_tbl as bit','bit.bi_id = ot.bi_id')
			->WHERE('ot.order_id', $order_id)
			->GET()->row_array();
		return $query;
	}
	public function getOrderItemsCart($order_id) {
		$query = $this->db->SELECT('pt.name, pt.image, st.price, st.qty, pt.url')
			->FROM('sales_tbl as st')
			->JOIN('products_tbl as pt', 'pt.p_id = st.p_id')
			->WHERE('st.order_id', $order_id)
			->GET()->result_array();
		$result = array();
		$grand_total = 0;
		$total_price_per_product = 0;
		foreach ($query as $q) {
			$total_price_per_product = $q['price'] * $q['qty'];
    		$grand_total += $total_price_per_product;
			$arr = array(
				'product_name'=> strlen($q['name']) > 40 ? substr($q['name'], 0, 37).'...' : $q['name'],
				'product_image'=> base_url().$q['image'],
				'price'=> number_format($q['price'], 2),
				'qty'=> $q['qty'],
				'total'=>number_format($total_price_per_product, 2),
				'product_url'=> base_url('product/').$q['url'],
			);
			array_push($result, $arr);
		}
		return $result;
	}
	public function orderedAmount($order_id, $shipping_fee) {
		$query = $this->db->SELECT('price, qty')
			->WHERE('order_id', $order_id)
			->GET('sales_tbl')->result_array();

		$total = 0;
		$sub_total = 0;
		$total_price_per_product = 0;
		foreach ($query as $q) {
			$total_price_per_product = $q['price'] * $q['qty'];
    		$sub_total += $total_price_per_product;
		}
		$total = $sub_total + $shipping_fee;
		$result['sub_total'] = number_format($sub_total, 2);
		$result['shipping_fee'] = number_format($shipping_fee, 2);
		$result['total'] = number_format($total , 2); /* temp total*/
		return $result;
	}
	public function getOrderBillingInfo($bi_id) {
		$q = $this->db->WHERE('bi_id', $bi_id)->ORDER_BY('created_at','desc')->GET('billing_info_tbl')->row_array();

		$result['full_name'] = $q['fname'].' '.$q['lname'];
		$result['email_address'] = $q['email_address'];
		$result['phone'] = $q['phone_number'];
		$result['address'] = $q['full_address'].', '.$q['city'].' '.$q['state'].', '.$q['zip_code'].', '.$q['country'];
		return $result;
	}
	public function getOrderShippingInfo($si_id) {
		$q = $this->db->WHERE('si_id', $si_id)->ORDER_BY('created_at','desc')->GET('shipping_info_tbl')->row_array();

		$result['full_name'] = $q['fname'].' '.$q['lname'];
		$result['email_address'] = $q['email_address'];
		$result['phone'] = $q['phone_number'];
		$result['address'] = $q['full_address'].', '.$q['city'].' '.$q['state'].', '.$q['zip_code'].', '.$q['country'];
		return $result;
	}
	public function addUpdateShippingInfo($data, $user_id){
		$checkShip = 'false';
		$shipOrder = 0;
		$checkShipInfo = $this->checkShippingInfo($user_id);		
		if (isset($checkShipInfo)) {
			$shipOrder = $this->checkShipOrder($checkShipInfo['si_id']);
			$checkShip = 'true';
		}

		if ($checkShip == 'true' && $shipOrder > 0) {
			$this->db->INSERT('shipping_info_tbl', $data);
		}
		else if ($checkShip == 'true' && $shipOrder == 0) {
			$this->db->WHERE('si_id', $checkShipInfo['si_id'])->UPDATE('shipping_info_tbl', $data);
		}
		else{
			$this->db->INSERT('shipping_info_tbl', $data);
		}
	}
}
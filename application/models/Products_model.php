<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

	public function sitemapProducts(){
		return $this->db->SELECT('url')->GET('products_tbl')->result_array();
	}
	public function addProduct(){
	   	$path = "assets/images/products/"; // upload directory
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid image extnsion

		if (isset($_FILES['product_image'])) {
			$img = str_replace(' ', '-', $_FILES['product_image']['name']);
			$tmp = $_FILES['product_image']['tmp_name'];

			// get uploaded file's extension
			$ext = pathinfo($img, PATHINFO_EXTENSION);

			// can upload same image using rand functions
			$final_image = rand(1000,1000000).'-'.$img;

			// check's valid format
			if(in_array($ext, $valid_extensions)) { 
				$path = $path.strtolower($final_image); 

				if(move_uploaded_file($tmp, $path)) {
					$data = array (
						'image'=>$path,
						'name'=>$this->input->post('product_name'),
						'pc_id'=>$this->input->post('product_category'),
						'srp_price'=>$this->input->post('srp_price'),
						'dc_price'=>$this->input->post('dc_price'),
						'qty'=>$this->input->post('qty'),
						'description'=>$this->input->post('description'),
						'p_pub_id'=>$this->productPublicID(),
						'profit_sharing_points'=>$this->input->post('profit_sharing_points'),
						'url'=>str_replace(' ', '-', strtolower(substr($this->input->post('product_name'), 0, 35) )).'-'.$this->productUrlGenerator(),
						'sku'=>$this->skuGenerator(),
					);
    				$this->insertNewProduct($data);
					$response['status'] = 'success';
					$response['message'] = 'New Product Added!';
				}
			}
			else {
				$response['status'] = 'not_img';
				$response['message'] = 'File not an image!';
			}
		}
		else {
			$response['status'] = 'failed';
			$response['message'] = 'Something went wrong!';
		}
		return $response;
    }
    public function updateProduct(){
		if ($this->session->user_type == 'admin') {
			$path = "assets/images/products/"; // upload directory
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid image extnsion
			$p_id = $this->input->post('p_id');
			$product_image = $this->input->post('product_image');

			if ($_FILES['product_image']['size'] !== 0) {
				$img = str_replace(' ', '-', $_FILES['product_image']['name']);
				$tmp = $_FILES['product_image']['tmp_name'];

				// get uploaded file's extension
				$ext = pathinfo($img, PATHINFO_EXTENSION);

				// can upload same image using rand functions
				$final_image = rand(1000,1000000).'-'.$img;

				// check's valid format
				if(in_array($ext, $valid_extensions)) { 
					$path = $path.strtolower($final_image); 

					if(move_uploaded_file($tmp, $path)) {
						$data = array (
							'image'=>$path,
							'name'=>$this->input->post('product_name'),
							'pc_id'=>$this->input->post('product_category'),
							'srp_price'=>$this->input->post('srp_price'),
							'dc_price'=>$this->input->post('dc_price'),
							'qty'=>$this->input->post('qty'),
							'priority'=>$this->input->post('priority'),
							'points'=>$this->input->post('points'),
							'description'=>$this->input->post('description'),
							'profit_sharing_points'=>$this->input->post('profit_sharing_points'),
							'url'=>str_replace(' ', '-', strtolower(substr($this->input->post('product_url'), 0, 45) )),
							'updated_at'=>date('Y-m-d H:i:s'),
						);
	    				$this->updateProductData($data, $p_id);
						$response['status'] = 'success';
						$response['message'] = 'Product Successfully Updated!';
					}
				}
				else {
					$response['status'] = 'not_img';
					$response['message'] = 'File not an image!';
				}
			}

			else {
				$data = array (
					'name'=>$this->input->post('product_name'),
					'pc_id'=>$this->input->post('product_category'),
					'srp_price'=>$this->input->post('srp_price'),
					'dc_price'=>$this->input->post('dc_price'),
					'qty'=>$this->input->post('qty'),
					'description'=>$this->input->post('description'),
					'priority'=>$this->input->post('priority'),
					'points'=>$this->input->post('points'),
					'profit_sharing_points'=>$this->input->post('profit_sharing_points'),
					'url'=>str_replace(' ', '-', strtolower(substr($this->input->post('product_url'), 0, 45) )),
					'updated_at'=>date('Y-m-d H:i:s'),
				);
	    		$this->updateProductData($data, $p_id);
	    		$response['status'] = 'success';
				$response['message'] = 'Product Successfully Updated!';
			}
			return $response;
	    }
	}
    public function updateProductData($data, $p_id) {
    	$this->db->WHERE('p_id', $p_id)
    		->UPDATE('products_tbl', $data);
    }
    public function skuGenerator($length=11) {
   		$characters = '0123456789QWERTYUIOPASDFGHJKLZXCVBNM';
	    $charactersLength = strlen($characters);
	    $sku = '';
	    for ($i = 0; $i < $length; $i++) {
	        $sku .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return 'HP-'.$sku;
    }
    public function productPublicID($length=19) {
   		$characters = '0123456789abcdef';
	    $charactersLength = strlen($characters);
	    $prod_pub_id = '';
	    for ($i = 0; $i < $length; $i++) {
	        $prod_pub_id .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $prod_pub_id;
    }
    public function productUrlGenerator($length=7) {
   		$characters = '0123456789abcdef';
	    $charactersLength = strlen($characters);
	    $url = '';
	    for ($i = 0; $i < $length; $i++) {
	        $url .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $url;
    }
    public function insertNewProduct($data) {
    	$this->db->INSERT('products_tbl', $data);
    }
    public function getProductCount () {
    	if ($this->session->user_type == 'admin') {
    		return $this->db->GET('products_tbl')->num_rows();
    	}
    }
    public function getAllProductData ($row_per_page, $row_no) {
    	if ($this->session->user_type == 'admin') {
    		$query = $this->db->SELECT('pt.*, pct.name as category, pct.category_url')
	    		->FROM('products_tbl as pt')
	    		->JOIN('product_category_tbl as pct', 'pct.pc_id=pt.pc_id')
				->ORDER_BY('pt.created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'p_id'=>$q['p_id'],
					'name'=> ( strlen($q['name']) > 19 ) ? substr($q['name'], 0, 16).'...' : $q['name'],
					'category'=>$q['category'],
					'description'=>$q['description'],
					'srp_price'=>$q['srp_price'],
					'dc_price'=>$q['dc_price'],
					'image'=>$q['image'],
					'qty'=>$q['qty'],
					'points'=>$q['points'] * .1,/* 10% for the unilvl of products purchase*/
					'status'=>$q['status'],
					'sku'=>$q['sku'],
					'url'=>base_url('product/').$q['url'],
					'created_at'=>date('m/d/Y', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
    }
    public function addProductCategory(){
    	$data = array(
    		'name'=>$this->input->post('product_cat_name'),
			'category_url'=>str_replace(' ', '-', strtolower(substr($this->input->post('product_cat_name'), 0, 11))).'-'.$this->productUrlGenerator(),
    		'status'=>'inactive',
    		'created_at'=>date('Y-m-d H:i:s')
    	);
    	$this->db->INSERT('product_category_tbl', $data);
    	return array('status'=>'success');
    }
    public function getProductCategory(){
    	$query = $this->db->SELECT('pc_id, name')
    		->ORDER_BY('name', 'asc')
    		->GET('product_category_tbl')->result_array();
    	return $query ;
    }
    public function deleteProduct(){
    	if ($this->session->user_type == 'admin') {
    		$this->db->WHERE('p_id', $this->input->post('p_id'))
	    		->DELETE('products_tbl');
	    	
	    	$response['status'] = 'success';
			$response['message'] = 'Product Successfully Deleted!';
			return $response;
    	}
    }
    public function getProductDataByID(){
    	if ($this->session->user_type == 'admin') {
    		$q = $this->db->SELECT('pt.*, pct.name as category')
	    		->FROM('products_tbl as pt')
	    		->JOIN('product_category_tbl as pct', 'pct.pc_id=pt.pc_id')
				->ORDER_BY('pt.created_at', 'DESC')
				->WHERE('pt.p_id', $this->input->get('p_id'))
				->GET()->row_array();
			
			$data['p_id'] = $q['p_id'];
			$data['pc_id'] = $q['pc_id'];
			$data['name'] = $q['name'];
			$data['category'] = $q['category'];
			$data['description'] = $q['description'];
			$data['srp_price'] = $q['srp_price'];
			$data['dc_price'] = $q['dc_price'];
			$data['image'] = $q['image'];
			$data['qty'] = $q['qty'];
			$data['status'] = $q['status'];
			$data['priority'] = $q['priority'];
			$data['points'] = $q['points'];
			$data['sku'] = $q['sku'];
			$data['profit_sharing_points'] = $q['profit_sharing_points'];
			$data['url'] = $q['url'];
			$data['created_at'] = date('m/d/Y', strtotime($q['created_at']));

			return $data;
    	}
    }
    public function getProductCategoryCount () {
    	if ($this->session->user_type == 'admin') {
    		return $this->db->GET('product_category_tbl')->num_rows();
    	}
    }
    public function getAllProductCategoryData ($row_per_page, $row_no) {
    	if ($this->session->user_type == 'admin') {
    		$query = $this->db->ORDER_BY('created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET('product_category_tbl')->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'pc_id'=>$q['pc_id'],
					'category'=>$q['name'],
					'status'=>$q['status'],
					'created_at'=>date('m/d/Y', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
    }
    public function deleteCategory(){
    	if ($this->session->user_type == 'admin') {
    		$this->db->WHERE('pc_id', $this->input->post('pc_id'))
	    		->DELETE('product_category_tbl');
	    	
	    	$response['status'] = 'success';
			$response['message'] = 'Product Category Successfully Deleted!';
			return $response;
    	}
    }
    public function updateProductStatus() {
    	$data = array('status'=>$this->input->post('status'));
    	$this->db->WHERE('p_id', $this->input->post('p_id'))
    		->UPDATE('products_tbl', $data);
    	$response['status'] = 'success';
		$response['message'] = 'Product Status Successfully Updated to '.$this->input->post('status').'!';
		return $response;
    }
    public function updateProductCategoryStatus() {
    	$data = array('status'=>$this->input->post('status'));
    	$this->db->WHERE('pc_id', $this->input->post('pc_id'))
    		->UPDATE('product_category_tbl', $data);
    	$response['status'] = 'success';
		$response['message'] = 'Product Category Status Successfully Updated to '.$this->input->post('status').'!';
		return $response;
    }
  	public function getProductDataByURL($product_url) {
    	$q = $this->db->SELECT('pt.*, pct.name as category, pct.category_url')
    		->FROM('products_tbl as pt')
    		->JOIN('product_category_tbl as pct', 'pct.pc_id=pt.pc_id')
			->ORDER_BY('pt.created_at', 'DESC')
			->WHERE('pt.url', $product_url)
			->WHERE('pt.status', 'active')
			->GET()->row_array();
		
		$data['p_id'] = $q['p_id'];
		$data['p_pub_id'] = $q['p_pub_id'];
		$data['pc_id'] = $q['pc_id'];
		$data['name'] = $q['name'];
		$data['category'] = $q['category'];
		$data['description'] = $q['description'];
		$data['price'] = (isset($this->session->user_id))  ? $q['dc_price'] : $q['srp_price'];
		$data['image_url'] =  base_url().$q['image'];
		$data['qty'] = $q['qty'];
		$data['status'] = $q['status'];
		$data['sku'] = $q['sku'];
		$data['product_url'] = base_url('product/').$q['url'];

		return $data;
    }
    public function getShopProductsCount () {
    	return $this->db->WHERE('status','active')->GET('products_tbl')->num_rows();
    }
    public function getShopProducts($row_per_page, $row_no){
    	$query = $this->db->SELECT('pt.*, pct.name as category, pct.category_url')
    		->FROM('products_tbl as pt')
    		->JOIN('product_category_tbl as pct', 'pct.pc_id=pt.pc_id')
			->ORDER_BY('pt.priority', 'ASC')
			->ORDER_BY('pt.name', 'ASC')
			->WHERE('pt.status', 'active')
			->LIMIT($row_per_page, $row_no)
			->GET()->result_array();

		$result = array();
    	foreach($query as $q){
			$array = array(
				'p_pub_id'=>$q['p_pub_id'],
				'product_name'=> $q['name'],
				'category'=>$q['category'],
				'price'=>(isset($this->session->user_id)) ? number_format($q['dc_price'], 2): number_format($q['srp_price'], 2) ,
				'product_image'=>base_url().$q['image'],
				'qty'=>$q['qty'],
				'sku'=>$q['sku'],
				'url'=>base_url('product/').$q['url'],
				'created_at'=>date('m/d/Y', strtotime($q['created_at'])),
			);
			array_push($result, $array);
    	}
    	return $result;
    }
    public function updateProductQuantity(){
    	$data = array('qty'=>$this->input->post('qty'));
    	$this->db->WHERE('p_id', $this->input->post('p_id'))
    		->UPDATE('products_tbl', $data);
    	$response['status'] = 'success';
		$response['message'] = 'Product Quantity Successfully Updated!';
		return $response;
    }
    public function getRecommendedProducts(){
    	if ($this->input->get('nonce') !== $this->session->_rec_product_nonce) {
			$data['status'] = 405;
			$data['response'] = 'Request is not allowed!';
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
		else{
			$query = $this->db->SELECT('pt.name as product_name, pt.p_pub_id, pt.sku, pt.srp_price, pt.dc_price, pt.image, pt.url, pct.name as category')
	    		->FROM('products_tbl as pt')
	    		->JOIN('product_category_tbl as pct','pct.pc_id = pt.pc_id', 'left')
	    		->WHERE('pt.status','active')
	    		->WHERE_NOT_IN('pt.p_pub_id', $this->input->get('p_pub_id'))
	    		->LIMIT(4)
	    		->GET('products_tbl')->result_array();
	    	$result = array();
	    	foreach($query as $q){
				$array = array(
					'p_pub_id'=>$q['p_pub_id'],
					'product_name'=> ( strlen($q['product_name']) > 30 ) ? substr($q['product_name'], 0, 28).'...' : $q['product_name'],
					'category'=>$q['category'],
					'price'=>(isset($this->session->user_id)) ? number_format($q['dc_price'], 2): number_format($q['srp_price'], 2) ,
					'product_image'=>base_url().$q['image'],
					'sku'=>$q['sku'],
					'url'=>base_url('product/').$q['url'],
				);
				array_push($result, $array);
	    	}
	    	return $result;
		}
    }

    public function searchProduct(){
    	$search = $this->input->get('keyword');
    	$query = $this->db->SELECT('pt.name as product_name, pt.srp_price, pt.dc_price, pt.image, pt.url, pct.name as category')
    		->FROM('products_tbl as pt')
    		->JOIN('product_category_tbl as pct','pct.pc_id = pt.pc_id', 'left')
    		->WHERE('pt.status','active')
    		->LIMIT(7)
    		->ORDER_BY('pt.created_at', 'desc')
    		->LIKE('pt.name', $search)
			->OR_LIKE('pct.name', $search)
    		->GET()->result_array();

    	$product = array();
    	foreach($query as $q){
			$array = array(
				'product_name'=> ( strlen($q['product_name']) > 30 ) ? substr($q['product_name'], 0, 28).'...' : $q['product_name'],
				'product_image'=>base_url().$q['image'],
				// 'price'=>(isset($this->session->user_id)) ? number_format($q['dc_price'], 2): number_format($q['srp_price'], 2),
				'product_url'=>base_url('product/').$q['url'],
			);
			array_push($product, $array);
    	}
    	$result['result'] = $product;
    	$result['count'] = $this->searchProductCount();
    	return $result;
    }
    public function searchProductCount(){
    	$search = $this->input->get('keyword');
    	return $this->db->SELECT('pt.name as product_name, pt.srp_price, pt.dc_price, pt.image, pt.url, pct.name as category')
    		->FROM('products_tbl as pt')
    		->JOIN('product_category_tbl as pct','pct.pc_id = pt.pc_id', 'left')
    		->WHERE('pt.status','active')
    		->LIKE('pt.name', $search)
			->OR_LIKE('pct.name', $search)
    		->GET()->num_rows();
    }
     public function getProductList(){
    	return $this->db->SELECT('p_id, name')
			->ORDER_BY('name', 'ASC')
			->WHERE('status', 'active')
			->GET('products_tbl')->result_array();
	}
	public function generateProductCode() {
		$input_num = $this->input->post('number');

		for($x = 0; $x < $input_num; $x++){
			$this->generateBulkProductCodes();
		}

	   	$activity_log = array('user_id'=>$this->session->user_id, 'message_log'=>'Generated '.$input_num.' Product Codes', 'ip_address'=>$this->input->ip_address(), 'platform'=>$this->agent->platform(), 'browser'=>$this->agent->browser(),'created_at'=>date('Y-m-d H:i:s')); 
		$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

		$response['status'] = 'success';
		$response['message'] = 'Successfully generated '.$input_num.' product codes';
		return $response;
	}
	public function generateBulkProductCodes($length = 15){
		$characters = '0123456789ABCDEF';
	    $charactersLength = strlen($characters);
	    $product_code = '';
	    for ($i = 0; $i < $length; $i++) {
	        $product_code .= $characters[rand(0, $charactersLength - 1)];
	    }

	    $check = $this->db->WHERE('product_code', $product_code)->GET('product_code_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateBulkProductCodes();
	    }
	    else{
	    	$product = $this->input->post('product');
		    $data = array(
	    		'product_code'=>$product_code,
	    		'p_id'=>$product
	    	);
	    	$this->db->INSERT('product_code_tbl', $data); /* insert member code*/
	    }
	}
	public function insertActivityLog ($activity_log) {
		$this->db->INSERT('activity_logs_tbl', $activity_log);
	}
	public function getProductCodesCount () {
		if ($this->session->user_type == 'admin') {
    		$query = $this->db->SELECT('pt.*, pct.product_code')
	    		->FROM('products_tbl as pt')
	    		->JOIN('product_code_tbl as pct', 'pct.p_id=pt.p_id')
				->GET()->num_rows();
			
			return $query;
    	}
	}
	public function getProductCodes ($row_per_page, $row_no) {
		if ($this->session->user_type == 'admin') {
    		$query = $this->db->SELECT('pt.*, pct.product_code')
	    		->FROM('products_tbl as pt')
	    		->JOIN('product_code_tbl as pct', 'pct.p_id=pt.p_id')
				->ORDER_BY('pt.created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'p_id'=>$q['p_id'],
					'name'=> ( strlen($q['name']) > 19 ) ? substr($q['name'], 0, 16).'...' : $q['name'],
					'product_code'=>$q['product_code'],
					'created_at'=>date('m/d/Y', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
	}

	public function processWalkinTx () {
		if ($this->session->user_type == 'admin') {
			$qty = $this->input->get('qty');
			$p_id = $this->input->get('p_id');
			$user_code = $this->input->get('user_code');

			for ($x = 0; $x < $qty; $x++) {
				$dataArr = array('status'=>'used');
				$this->db->WHERE('p_id', $p_id)
					->UPDATE('product_code_tbl', $dataArr);

				$this->insertNewProductWalkinTransaction($p_id, $user_code);
				$this->accumulateProfitSharing($p_id);
			}
			$response['status'] = 'success';
			$response['message'] = 'Successfully Processed!';
			return $response;
			// $user_code = $this->input->get('user_code');

			// /* check if there's existing code sent to the user_code (user) AND if the user_code(user) is existing */ 
			// $checkUserCode = $this->db->WHERE('user_code', $user_code)->WHERE('product_code', $code)->WHERE('')->GET('product_code_tbl')->num_rows();

			// $getUserCode = $this->db->SELECT('act.p_id')
			// 	->FROM('activation_code_tbl as act')
			// 	->JOIN('package_tbl as pt', 'pt.p_id = act.p_id')
			// 	->WHERE('act.code', $code)
			// 	->GET()->row_array();

			// if ($checkCode <= 0 && $checkUserCode <= 0) {
			// 	$data = array(
			// 		'p_id'=>$getUserCode['p_id'], 
			// 		'user_code'=>$user_code, 
			// 		'code'=>$code, 
			// 	);
			// 	$this->db->INSERT('user_code_tbl', $data); 

			// 	$mData = array('status'=>'sent');
			// 	$this->db->WHERE('code',$code)->UPDATE('activation_code_tbl',$mData);

			// 	$response['status'] = 'success';
			// 	$response['message'] = 'Code Successfully sent!';
			// }
			// else{
			// 	$response['status'] = 'failed';
			// 	$response['message'] = 'Something went wrong. Please try again!';
			// }
			// return $response;
    	}
	}
	public function accumulateProfitSharing($p_id){
		if (isset($this->session->user_id)) {
			$getProductPoints = $this->db->SELECT('profit_sharing_points')->WHERE('p_id', $p_id)->GET('products_tbl')->row_array();

			$dataArr = array(
				'type'=>'Repeat Purchase',
				'amount'=>$getProductPoints['profit_sharing_points'],
				'status'=>'active',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('profit_sharing_tbl',$dataArr);

		}
	}
	public function insertNewProductWalkinTransaction($p_id, $user_code){
		if (isset($this->session->user_id)) {
			$getProductPoints = $this->db->SELECT('profit_sharing_points')->WHERE('p_id', $p_id)->GET('products_tbl')->row_array();

			$dataArr = array(
				'p_id'=>$p_id,
				'ref_no'=>$this->generateProductPurchaseRefNo(),
				'status'=>'complete',
				'user_code'=>$user_code,
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('repeat_purchase_history_tbl',$dataArr);

		}
	}
	public function generateProductPurchaseRefNo($length = 9){
		$characters = '0123456789ABCDEF';
	    $charactersLength = strlen($characters);
	    $ref_no = '';
	    for ($i = 0; $i < $length; $i++) {
	        $ref_no .= $characters[rand(0, $charactersLength - 1)];
	    }

	    $check = $this->db->WHERE('ref_no', $ref_no)->GET('repeat_purchase_history_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateProductPurchaseRefNo();
	    }
	    else{
	    	return $ref_no;
	    }
	}
	public function productRepeatPurchaseHistoryCount(){
		if (isset($this->session->user_id)) {
			return $this->db->SELECT('rpt.*, pt.name')
	    		->FROM('repeat_purchase_history_tbl as rpt')
	    		->JOIN('products_tbl as pt', 'pt.p_id=rpt.p_id')
				->GET()->num_rows();
		}
	}
	public function productRepeatPurchaseHistory($row_per_page, $row_no){
		if ($this->session->user_type == 'admin') {

    		$query = $this->db->SELECT('rpt.*, pt.name')
	    		->FROM('repeat_purchase_history_tbl as rpt')
	    		->JOIN('products_tbl as pt', 'pt.p_id=rpt.p_id')
				->ORDER_BY('pt.created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'ref_no'=>$q['ref_no'],
					'user_code'=>$q['user_code'],
					'name'=> ( strlen($q['name']) > 19 ) ? substr($q['name'], 0, 16).'...' : $q['name'],
					'status'=>$q['status'],
					'created_at'=>date('m/d/Y', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
	}
}
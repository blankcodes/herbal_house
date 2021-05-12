<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

	
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
}
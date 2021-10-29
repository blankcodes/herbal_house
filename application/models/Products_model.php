<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

	public function generateTransactionRefNo ( $length = 7) {
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $ref_no = '100UNI'.$randomString;

	    $check = $this->db->WHERE('reference_no', $ref_no)->GET('transaction_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateTransactionRefNo();
	    }
	    return $ref_no;
	}
	public function sitemapProducts(){
		return $this->db->SELECT('url')->WHERE('status','active')->GET('products_tbl')->result_array();
	}
	public function sitemapProductCategory(){
		return $this->db->SELECT('category_url as url')->WHERE('status','active')->GET('product_category_tbl')->result_array();
	}
	public function addProduct(){
	   	$path = "assets/images/products/"; // upload directory
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp'); // valid image extnsion

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
						'points'=>$this->input->post('points'),
						'p_pub_id'=>$this->productPublicID(),
						'investment_point'=>$this->input->post('investment_point'),
						// 'profit_sharing_points'=>$this->input->post('profit_sharing_points'),
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
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp'); // valid image extnsion
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
							'investment_point'=>$this->input->post('investment_point'),
							// 'profit_sharing_points'=>$this->input->post('profit_sharing_points'),
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
					'investment_point'=>$this->input->post('investment_point'),
					// 'profit_sharing_points'=>$this->input->post('profit_sharing_points'),
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
					'points'=>$q['points'],/* 10% for the unilvl of products purchase*/
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
    	$path = "assets/images/category/"; // upload directory
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp'); // valid image extnsion

		if (isset($_FILES['product_cat_image'])) {
			$img = str_replace(' ', '-', $_FILES['product_cat_image']['name']);
			$tmp = $_FILES['product_cat_image']['tmp_name'];

			// get uploaded file's extension
			$ext = pathinfo($img, PATHINFO_EXTENSION);

			// can upload same image using rand functions
			$final_image = rand(1000,1000000).'-'.$img;

			// check's valid format
			if(in_array($ext, $valid_extensions)) { 
				$path = $path.strtolower($final_image); 

				if(move_uploaded_file($tmp, $path)) {
					$data = array(
						'image'=>$path,
			    		'name'=>$this->input->post('product_cat_name'),
						'category_url'=>str_replace(' ', '-', strtolower(substr($this->input->post('product_cat_name'), 0, 11))).'-'.$this->productUrlGenerator(),
			    		'status'=>'inactive',
			    		'created_at'=>date('Y-m-d H:i:s')
			    	);
			    	$this->db->INSERT('product_category_tbl', $data);
			    	$response['status'] = 'success';
					$response['message'] = 'New Product Category Added!';
				}
			}
			else {
				$response['status'] = 'not_img';
				$response['message'] = 'File not an image! Try again!';
			}
		}
		else {
			$response['status'] = 'failed';
			$response['message'] = 'Something went wrong! Try again!';
		}
		return $response;
    }
    public function updateProductCategory(){
    	$path = "assets/images/category/"; // upload directory
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'webp'); // valid image extnsion

		if (isset($_FILES['product_cat_image'])) {
			$img = str_replace(' ', '-', $_FILES['product_cat_image']['name']);
			$tmp = $_FILES['product_cat_image']['tmp_name'];

			// get uploaded file's extension
			$ext = pathinfo($img, PATHINFO_EXTENSION);

			// can upload same image using rand functions
			$final_image = rand(1000,1000000).'-'.$img;

			// check's valid format
			if(in_array($ext, $valid_extensions)) { 
				$path = $path.strtolower($final_image); 

				if(move_uploaded_file($tmp, $path)) {
					$data = array(
						'image'=>$path,
			    		'name'=>$this->input->post('product_cat_name'),
						'category_url'=>str_replace(' ', '-', strtolower(substr($this->input->post('product_cat_name'), 0, 11))).'-'.$this->productUrlGenerator(),
			    		'status'=>'inactive',
			    		'created_at'=>date('Y-m-d H:i:s')
			    	);
			    	$this->db->WHERE('pc_id',$this->input->post('pc_id'))->UPDATE('product_category_tbl', $data);
			    	$response['status'] = 'success';
					$response['message'] = ' Product Category Updated!';
				}
			}
			else {
				$response['status'] = 'not_img';
				$response['message'] = 'File not an image! Try again!';
			}
		}
		else {
			$response['status'] = 'failed';
			$response['message'] = 'Something went wrong! Try again!';
		}
		return $response;
    }
    public function getProductCategory(){
    	$query = $this->db->SELECT('pc_id, name')
    		->ORDER_BY('name', 'asc')
    		->GET('product_category_tbl')->result_array();
    	return $query ;
    }
    public function getProductCategoryByID(){
    	$query = $this->db->SELECT('name, pc_id, image')
    		->ORDER_BY('name', 'asc')
    		->WHERE('pc_id',$this->input->get('pc_id'))
    		->GET('product_category_tbl')->row_array();
    	$query['image']=base_url().$query['image'];
    	return $query ;
    }
    public function getProductCategoryHome(){
    	$query = $this->db->SELECT('name, image, category_url')
    		->ORDER_BY('name', 'asc')
    		->WHERE('status','active')
    		->GET('product_category_tbl')->result_array();
    	return $query ;
    }
    public function getProductCategoryHomeCount(){
    	$query = $this->db->SELECT('pc_id, name')
    		->ORDER_BY('name', 'asc')
    		->WHERE('status','active')
    		->GET('product_category_tbl')->num_rows();
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
			$data['investment_point'] = $q['investment_point'];
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
		$data['dc_price'] = $q['dc_price'];
		$data['image_url'] =  base_url().$q['image'];
		$data['qty'] = $q['qty'];
		$data['status'] = $q['status'];
		$data['sku'] = $q['sku'];
		$data['product_url'] = base_url('product/').$q['url'];
		$data['category_url'] = base_url('product/category/').$q['category_url'];

		return $data;
    }
    public function getProductCategoryDataByURL($category_url) {
    	$query = $this->db->WHERE('category_url', $category_url)
			->WHERE('status', 'active')
			->GET('product_category_tbl')->row_array();
		return $query;
    }
    public function getProductsByCategoryDataByURL($category_url) {
    	$productQuery = $this->db->SELECT('pt.*, pct.name as category, pct.category_url')
    		->FROM('products_tbl as pt')
    		->JOIN('product_category_tbl as pct', 'pct.pc_id=pt.pc_id')
			->ORDER_BY('pt.created_at', 'DESC')
			->WHERE('pct.category_url', $category_url)
			->WHERE('pct.status', 'active')
			->WHERE('pt.status', 'active')
			->GET()->result_array();
		
		$result = array();
		foreach($productQuery as $q) {
			$dataArr = array(
				'p_id' => $q['p_id'],
				'p_pub_id' => $q['p_pub_id'],
				'pc_id' => $q['pc_id'],
				'name' => $q['name'],
				'category' => $q['category'],
				'description' => $q['description'],
				'price' => number_format((isset($this->session->user_id))  ? $q['dc_price'] : $q['srp_price'], 2),
				'image_url' =>  base_url().$q['image'],
				'qty' => $q['qty'],
				'status' => $q['status'],
				'sku' => $q['sku'],
				'product_url' => base_url('product/').$q['url'],
			);
			array_push($result, $dataArr);
		}
		return $result;
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
				// 'qty'=>$q['qty'],
				// 'sku'=>$q['sku'],
				'url'=>base_url('product/').$q['url'],
				// 'created_at'=>date('m/d/Y', strtotime($q['created_at'])),
			);
			array_push($result, $array);
    	}
    	return $result;
    }
    public function getShopUserProducts($row_per_page, $row_no){
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
				'url'=>base_url('product/').$q['url'].'?ref='.$this->session->username,
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
    	$limit = 4;
    	if (isset($this->session->referrer)) {
    		$limit = 8;
    	}
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
	    		->LIMIT($limit)
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
	    	$response['products'] = $result;
	    	$response['referrer'] = ($limit > 4) ? 'TRUE' : 'FALSE';
 	    	return $response;
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
    		$query = $this->db->SELECT('pt.*, pct.product_code, pct.status as pc_stat')
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
					'status'=>$q['pc_stat'],
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
			$productCodeCount = $this->db->WHERE('status','new')->WHERE('p_id', $p_id)->GET('product_code_tbl')->num_rows();
			$userData = $this->db->WHERE('user_code', $user_code)->GET('user_tbl')->row_array();

			/* CHECK IF THE CURRENT PRODUCT CODE IS MORE THAN THE REQUEST QTY OF THE PURCHASE*/ 
			
			// if ($productCodeCount > $qty) {
			$this->generateProductCodeShopPurchase($qty, $p_id, 'Walk-in Purchase');
			for ($x = 0; $x < $qty; $x++) {
				$productCode = $this->db->WHERE('status','new')->WHERE('p_id', $p_id)->GET('product_code_tbl')->row_array(); /* GET PRODUCTS CODE THAT IS NOT USED */

				$dataArr = array('status'=>'used');
				$this->db->WHERE('pc_id',$productCode['pc_id'])
						->UPDATE('product_code_tbl', $dataArr);

				$this->insertNewProductWalkinTransaction($p_id, $user_code, $productCode['pc_id']);

				/* INSERT UNILEVEL POINTS TO YOURSELF */ 
				$this->insertUnilevelPointsWallet($p_id, $user_code);


				/* INSERT UNILEVEL POINTS TO INDIRECT REFERRAL */ 
				$this->insertReferralUnilvlPoints($p_id, $userData['sponsor_id']);

				/* INSERT POINTS ALLOCATED FOR INVESTMENT*/ 
				$this->insertInvestmentPoints($p_id, $p_id);

			}
			$response['status'] = 'success';
			$response['message'] = 'Successfully Processed!';
			// }
			// else{
			// 	$response['status'] = 'failed';
			// 	$response['message'] = 'Generate Product Code for this Product first!';
			// }
			return $response;
    	}
	}
	public function insertUnilevelAfterShopPurchase ($order_id) {
		if (isset($this->session->user_id)) {
			$sales = $this->db->WHERE('order_id', $order_id)->GET('sales_tbl')->result_array();

			foreach ($sales as $s) { /* LOOP FOR HOW MANY PRODUCTS IN AN ORDER */
				/* GENERATE NEW PRODUCT CODES */ 
				$this->generateProductCodeShopPurchase($s['qty'], $s['p_id'], 'Shop Purchase');

				$userData = $this->db->WHERE('user_id', $s['user_id'])->GET('user_tbl')->row_array();
				$orderData = $this->db->WHERE('order_id', $order_id)->GET('order_tbl')->row_array();

				for ($x = 0; $x < $s['qty']; $x++) { /* LOOP FOR HOW MANY QTY FOR EVERY PRODUCT PURCHASE */

					/* GET THE NEW GENERATED PRODUCT CODE*/ 
					$productCode = $this->db->WHERE('status','new')->WHERE('p_id', $s['p_id'])->GET('product_code_tbl')->row_array();

					$orderStatArr = array('status'=>'used');
					$this->db->WHERE('pc_id', $productCode['pc_id'])->UPDATE('product_code_tbl', $orderStatArr);

					

					/* BOUGHT WITH A MEMBER ACCOUNT */
					if (!empty($userData) && isset($userData['user_code'])) {
						echo 'y';
						/* INSERT POINTS ALLOCATED FOR INVESTMENT*/ 
						$this->insertInvestmentPoints($order_id, $s['p_id']);

						$this->insertNewShopPurchaseTransaction($s['p_id'], $userData['user_code'], $productCode['pc_id']);

						/* INSERT UNILEVEL POINTS TO YOURSELF */ 
						$this->insertUnilevelPointsWallet($s['p_id'], $userData['user_code']);

						/* INSERT UNILEVEL POINTS TO INDIRECT REFERRAL */ 
						$this->insertReferralUnilvlPoints($s['p_id'], $userData['sponsor_id']);
					}

					/* BOUGHT WITH A NON-MEMBER ACCOUNT BUT REFERRED */
					else if (!empty($userData) && isset($userData['referrer'])) {
						echo 'n';
						/* INSERT POINTS ALLOCATED FOR INVESTMENT*/ 
						$this->insertInvestmentPoints($order_id, $s['p_id']);

						$userReferrer = $this->db->WHERE('username', $orderData['referrer'])->GET('user_tbl')->row_array();

						$this->insertNewShopPurchaseTransaction($s['p_id'], $userReferrer['user_code'], $productCode['pc_id']);

						/* INSERT UNILEVEL POINTS TO YOURSELF */ 
						$this->insertUnilevelPointsWallet($s['p_id'], $userReferrer['user_code']);

						/* INSERT UNILEVEL POINTS TO INDIRECT REFERRAL */ 
						$this->insertReferralUnilvlPoints($s['p_id'], $userReferrer['sponsor_id']);
					}
					else{
						echo 'x';
						/* INSERT POINTS ALLOCATED FOR INVESTMENT*/ 
						$this->insertInvestmentPoints($order_id, $s['p_id']);

						/* INSERT POINT TO SPECIAL TYPE USER SUCH ADMIN/OWNER/MANAGER/INVESTOR*/
						$u_data = $this->db->SELECT('user_code, user_id')->WHERE('type', 'special')->GET('user_tbl')->result_array();

						foreach ($u_data as $u) {
							$this->insertNewShopPurchaseTransaction($s['p_id'], $u['user_code'], $productCode['pc_id']);
						}
					}
				}
			}
    	}
	}
	public function insertNewShopPurchaseTransaction($p_id, $user_code, $pc_id){
		if (isset($this->session->user_id)) {
			$getProdPoints = $this->db->SELECT('points')->WHERE('p_id', $p_id)->GET('products_tbl')->row_array();

			$dataArr = array(
				'p_id'=>$p_id,
				'pc_id'=>$pc_id,
				'status'=>'complete',
				'unilevel_points'=>$getProdPoints['points'], /* total points earnd for product unilevel */
				'user_code'=>$user_code,
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('repeat_purchase_history_tbl',$dataArr);
			$id = $this->db->insert_id();
			$ref_no = $this->generateProductPurchaseRefNo($id);

			/* INSERT TRANSACTION ACTIVITY */ 
			$txDataArr = array(
				'reference_no'=>$ref_no,
				'activity'=>'Repeat Purchase',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('transaction_tbl', $txDataArr);


		}
	}
	public function generateProductCodeShopPurchase($qty, $p_id, $activity) {
		if (isset($this->session->user_id)) {
			for($x = 0; $x < $qty; $x++){
				$this->generateBulkProductCodeShopPurchase($p_id);
			}

		   	$activity_log = array(
		   		'user_id'=>$this->session->user_id, 
		   		'message_log'=>'Generated '.$qty.' Product Codes '.$activity, 
		   		'ip_address'=>$this->input->ip_address(), 
		   		'platform'=>$this->agent->platform(), 
		   		'browser'=>$this->agent->browser(),
		   		'created_at'=>date('Y-m-d H:i:s')
		   	); 
			$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */
		}
	}
	public function generateBulkProductCodeShopPurchase($p_id, $length = 15){
		$characters = '0123456789ABCDEF';
	    $charactersLength = strlen($characters);
	    $product_code = '';
	    for ($i = 0; $i < $length; $i++) {
	        $product_code .= $characters[rand(0, $charactersLength - 1)];
	    }

	    $check = $this->db->WHERE('product_code', $product_code)->GET('product_code_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateBulkProductCodeShopPurchase();
	    }
	    else{
	    	$product = $this->input->post('product');
		    $data = array(
	    		'product_code'=>$product_code,
	    		'p_id'=>$p_id
	    	);
	    	$this->db->INSERT('product_code_tbl', $data); /* insert member code*/
	    }
	}
	public function insertReferralUnilvlPoints( $p_id, $sponsor_id) {
		if (!empty($sponsor_id)) {
			/* 1st gen / level*/ 
			$this->insertUnilevelPointsWallet($p_id, $sponsor_id); 

			$gen2ndData = $this->db->WHERE('user_code', $sponsor_id)->GET('user_tbl')->row_array();
			/* 2nd Generation */ 
			if (!empty($gen2ndData['sponsor_id'])) {
				$this->insertUnilevelPointsWallet($p_id, $gen2ndData['sponsor_id']);
			}

			/* 3rd Generation*/
			$gen3rdData = $this->db->WHERE('user_code', $gen2ndData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen3rdData['sponsor_id'])) {
				$this->insertUnilevelPointsWallet($p_id, $gen3rdData['sponsor_id']);
			}

			/* 4th Generation*/
			$gen4thData = $this->db->WHERE('user_code', $gen3rdData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen4thData['sponsor_id'])) {
				$this->insertUnilevelPointsWallet($p_id, $gen4thData['sponsor_id']);
			}
					
			/* 5th Generation*/
			$gen5thData = $this->db->WHERE('user_code', $gen4thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen5thData['sponsor_id'])) {
				$this->insertUnilevelPointsWallet($p_id, $gen5thData['sponsor_id']);
			}

			/* 6th Generation*/
			$gen6thData = $this->db->WHERE('user_code', $gen5thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen6thData['sponsor_id'])) {
				$this->insertUnilevelPointsWallet($p_id, $gen6thData['sponsor_id']);
			}						
				
			/* 7th Generation*/
			$gen7thData = $this->db->WHERE('user_code', $gen6thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen7thData['sponsor_id'])) {
				$this->insertUnilevelPointsWallet($p_id, $gen7thData['sponsor_id']);
			}
									
			/* 8th Generation*/
			$gen8thData = $this->db->WHERE('user_code', $gen7thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen8thData['sponsor_id'])) {
				$this->insertUnilevelPointsWallet($p_id, $gen8thData['sponsor_id']);
			}

			/* 9th Generation*/
			$gen9thData = $this->db->WHERE('user_code', $gen8thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen9thData['sponsor_id'])) {
				$this->insertUnilevelPointsWallet($p_id, $gen9thData['sponsor_id']);
			}

			/* 10th Generation*/
			$gen10thData = $this->db->WHERE('user_code', $gen9thData['sponsor_id'])->GET('user_tbl')->row_array();
			if (!empty($gen10thData['sponsor_id'])) {
				$this->insertUnilevelPointsWallet($p_id, $gen10thData['sponsor_id']);
			}
		} //
	}
	public function insertUnilevelPointsWallet($p_id, $user_id) {
		if (isset($this->session->user_id)) {
			$ref_no = $this->generateTransactionRefNo();
			$getProdPoints = $this->db->SELECT('points')->WHERE('p_id', $p_id)->GET('products_tbl')->row_array();
			
			$checkWalletUser = $this->db->WHERE('user_code', $user_id)
				->WHERE('type','unilevel_bonus')
				->GET('wallet_tbl')->row_array();

			if (isset($checkWalletUser)) {
				$dataArr = array(
					'balance'=>$checkWalletUser['balance'] + $getProdPoints['points'],
					'updated_at'=>date('Y-m-d H:i:s')
				);
				$this->db->WHERE('user_code', $user_id)
					->WHERE('type','unilevel_bonus')
					->UPDATE('wallet_tbl',$dataArr);	
			}
			else{
				$dataArr = array(
					'user_code'=>$user_id,
					'balance'=>$getProdPoints['points'],
					'type'=>'unilevel_bonus',
					'created_at'=>date('Y-m-d H:i:s'),
				);
				$this->db->INSERT('wallet_tbl',$dataArr);	
			}

			/* INSERT WALLET ACTIVITY */ 
			$txDataArr = array(
				'reference_no'=> $ref_no,
				'user_code'=> $user_id,
				'amount'=> $getProdPoints['points'],
				'activity'=>'Unilevel Points',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('wallet_activity_tbl', $txDataArr);

			/* INSERT TRANSACTION ACTIVITY */ 
			$txDataArr = array(
				'reference_no'=>$ref_no,
				'activity'=>'Unilevel Points',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('transaction_tbl', $txDataArr);

		}
	}
	public function insertNewProductWalkinTransaction($p_id, $user_code, $pc_id){
		if (isset($this->session->user_id)) {
			$getProdPoints = $this->db->SELECT('points')->WHERE('p_id', $p_id)->GET('products_tbl')->row_array();

			$dataArr = array(
				'p_id'=>$p_id,
				'pc_id'=>$pc_id,
				'status'=>'complete',
				'unilevel_points'=>$getProdPoints['points'], /* total points earnd for product unilevel */
				'user_code'=>$user_code,
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('repeat_purchase_history_tbl',$dataArr);
			$id = $this->db->insert_id();
			$ref_no = $this->generateProductPurchaseRefNo($id);

			/* INSERT TRANSACTION ACTIVITY */ 
			$txDataArr = array(
				'reference_no'=>$ref_no,
				'activity'=>'Repeat Purchase',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('transaction_tbl', $txDataArr);


		}
	}

	public function generateProductPurchaseRefNo($ref_id, $length = 6){
		$characters = '0123456789ABCDEF';
	    $charactersLength = strlen($characters);
	    $temp_ref_no = '';
	    for ($i = 0; $i < $length; $i++) {
	        $temp_ref_no .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $ref_num = '100RP'.$ref_id.$temp_ref_no;

	    $check = $this->db->WHERE('ref_no', $ref_num)->GET('repeat_purchase_history_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateProductPurchaseRefNo($ref_id);
	    }
	    else{
	    	$dataArr = array('ref_no'=>$ref_num);
	    	$this->db->WHERE('rph_id', $ref_id)->UPDATE('repeat_purchase_history_tbl', $dataArr);
	    	return $ref_num;
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
				->ORDER_BY('rpt.created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'ref_no'=>$q['ref_no'],
					'user_code'=>$q['user_code'],
					'name'=> ( strlen($q['name']) > 19 ) ? substr($q['name'], 0, 16).'...' : $q['name'],
					'status'=>$q['status'],
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
	}
	public function getProductRepeatPurchaseCount(){
		if (isset($this->session->user_id)) {
			return $this->db->SELECT('rpt.*, pt.name, pt.points')
	    		->FROM('repeat_purchase_history_tbl as rpt')
	    		->JOIN('products_tbl as pt', 'pt.p_id=rpt.p_id')
				->WHERE('rpt.user_code', $this->session->user_code)
				->GET()->num_rows();
		}
	}
	public function getProductRepeatPurchase($row_per_page, $row_no){
		if ($this->session->user_id) {
    		$query = $this->db->SELECT('rpt.*, pt.name, pt.points')
	    		->FROM('repeat_purchase_history_tbl as rpt')
	    		->JOIN('products_tbl as pt', 'pt.p_id=rpt.p_id')
				->WHERE('rpt.user_code', $this->session->user_code)
				->ORDER_BY('rpt.created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'ref_no'=>$q['ref_no'],
					'product'=> ( strlen($q['name']) > 19 ) ? substr($q['name'], 0, 16).'...' : $q['name'],
					'points'=>'₱ '.number_format($q['points'], 2), /* 10% of the points earned for unilevel */
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
	}
	public function getProductRepeatPurchaseOpt($row_per_page, $row_no){
		if ($this->session->user_id) {
    		$query = $this->db->SELECT('rpt.*, pt.name, pt.points')
	    		->FROM('repeat_purchase_history_tbl as rpt')
	    		->JOIN('products_tbl as pt', 'pt.p_id=rpt.p_id')
				->WHERE('rpt.user_code', $this->input->get('user_code'))
				->ORDER_BY('rpt.created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'ref_no'=>$q['ref_no'],
					'product'=> ( strlen($q['name']) > 19 ) ? substr($q['name'], 0, 16).'...' : $q['name'],
					'points'=>'₱ '.number_format($q['points'], 2), /* 10% of the points earned for unilevel */
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
	}
	public function getProductRepeatPurchaseOptCount(){
		if (isset($this->session->user_id)) {
			return $this->db->SELECT('rpt.*, pt.name, pt.points')
	    		->FROM('repeat_purchase_history_tbl as rpt')
	    		->JOIN('products_tbl as pt', 'pt.p_id=rpt.p_id')
				->WHERE('rpt.user_code', $this->input->get('user_code'))
				->GET()->num_rows();
		}
	}
	public function getProductCategoryLimit(){
		return $this->db->SELECT('name, category_url')
			->WHERE('status','active')
			->ORDER_BY('name', 'asc')
			->GET('product_category_tbl')->result_array();
	}
	public function insertInvestmentPoints($order_id, $p_id) {
		if (isset($this->session->user_id)) {
			$p_data = $this->db->SELECT('investment_point')->WHERE('p_id', $p_id)->GET('products_tbl')->row_array();

			$dataArr = array(
				// 'order_id'=>$order_id,
				'p_id'=>$p_id,
				'amount'=>$p_data['investment_point'],
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('investment_points_tbl', $dataArr);
		}
	}
	public function getProductData(){
		if (isset($this->session->admin)) {
			$user_code = $this->input->get('user_code');
			$p_id = $this->input->get('p_id');
			$qty = $this->input->get('qty');
			$check = $this->db->WHERE('user_code', $user_code)->WHERE('p_id', $p_id)->GET('stockist_stocks_tbl')->row_array();

			if ($check > 0) {
				$total_qty = $check['qty'] + $this->input->get('qty');
				$dataArr = array(
					'p_id'=>$p_id,
					'qty'=>$total_qty,
				);
				$this->db->WHERE('p_id', $p_id)->UPDATE('stockist_stocks_tbl', $dataArr);
			}
			else{
				$dataArr = array(
					'p_id'=>$p_id,
					'qty'=>$this->input->get('qty'),
					'user_code'=>$user_code,
				);
				$this->db->INSERT('stockist_stocks_tbl', $dataArr);
			}

			$query = $this->db->SELECT('pt.name, sst.p_id, sst.qty')
				->FROM('stockist_stocks_tbl as sst')
				->JOIN('products_tbl as pt', 'pt.p_id=sst.p_id')
				->WHERE('user_code', $this->input->get('user_code'))
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'p_id'=>$q['qty'],
					'name'=> ( strlen($q['name']) > 30 ) ? substr($q['name'], 0, 27).'...' : $q['name'],
					'qty'=>$q['qty']
				);
				array_push($result, $array);
			}
			return $result;
		}
	}
	public function getStockistProducts($row_per_page, $row_no, $user_code){
		if ($this->session->type == 'stockist' || isset($this->session->admin)) {
			$total_qty = 0;
    		$query = $this->db->SELECT('pt.p_id, pt.name, pt.url, pt.srp_price, pct.name as category, pct.category_url, sst.qty')
	    		->FROM('stockist_stocks_tbl as sst')
	    		->JOIN('products_tbl as pt', 'pt.p_id=sst.p_id')
	    		->JOIN('product_category_tbl as pct', 'pct.pc_id=pt.pc_id')
	    		->WHERE('sst.user_code', $user_code)
				->ORDER_BY('sst.qty', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			$sold_prod = $this->db->WHERE('stockist_user_code', $user_code)
				->WHERE('status','complete')->GET('stockist_transactions_tbl')->num_rows();

			$total_sales = $this->db->SELECT('SUM(pt.srp_price) as sales')
				->FROM('stockist_transactions_tbl as stt')
				->JOIN('products_tbl as pt', 'pt.p_id = stt.p_id')
				->WHERE('stt.stockist_user_code', $user_code)
				->WHERE('stt.status','complete')->GET()->row_array();

			foreach($query as $q){
				$qty = $q['qty'];
				$total_qty += $qty;
				$array = array(
					'p_id'=>$q['p_id'],
					'name'=> ( strlen($q['name']) > 28 ) ? substr($q['name'], 0, 25).'...' : $q['name'],
					'url'=>base_url('product/').$q['url'],
					'category'=>$q['category'],
					'category_url'=>base_url('product/category/').$q['category_url'],
					'srp_price'=>'₱ '. number_format($q['srp_price'], 2),
					'qty'=>$q['qty'],
				);
				array_push($result, $array);
			}

			$data['products'] = $result;
			$data['total_qty'] = $total_qty;
			$data['sold_products'] = $sold_prod;
			$data['total_sales'] = '₱ '. number_format($total_sales['sales'], 2);
			return $data;
    	}
	}
	public function getStockistProductsCount($user_code){
		if ($this->session->type == 'stockist' || isset($this->session->admin)) {
    		$query = $this->db->FROM('stockist_stocks_tbl')
	    		->WHERE('user_code', $user_code)
				->GET()->num_rows();
			return $query;
    	}
	}
	public function confirmStockistPurchase() {
		if (isset($this->session->user_id) && $this->session->type == 'stockist') {
			$type = $this->input->post('type');
			if ($type == 'member_purchase') {
				$user_code = $this->input->post('user_code');
				$userData = $this->db->WHERE('user_code', $user_code)->GET('user_tbl')->row_array();
			}
			else{
				$user_code = '';
			}

			$qty = $this->input->post('qty');
			$p_id = $this->input->post('product');

			/* check stockist product stock */ 
			$productsCount = $this->db->WHERE('p_id', $p_id)->WHERE('user_code', $this->session->user_code)->GET('stockist_stocks_tbl')->row_array();

			/* CHECK IF THE CURRENT PRODUCT CODE IS MORE THAN THE REQUEST QTY OF THE PURCHASE*/ 
			
			
			if ($productsCount['qty'] < $qty) {
				$response['status'] = 'failed';
				$response['message'] = "You don't have enough stocks for this product!";
			}
			else if (is_numeric($qty)) {
				$response['status'] = 'failed';
				$response['message'] = "Quantity should be above zero!";
			}
			else if($productsCount['qty'] == 0) {
				$response['status'] = 'failed';
				$response['message'] = "You have zero stocks for this of product!";
			}
			else if($qty == 0 || $qty === null || $qty < 0) {
				$response['status'] = 'failed';
				$response['message'] = "Something went wrong. Please try again!";
			}
			else if ($productsCount['qty'] >= $qty) {
				$this->generateProductCodeShopPurchase($qty, $p_id, 'From Stockist Purchase');
				$this->insertStockistPuchaseNewActivity($p_id, $type, $user_code, $qty);

				for ($x = 0; $x < $qty; $x++) {
					$productCode = $this->db->WHERE('status','new')->WHERE('p_id', $p_id)->GET('product_code_tbl')->row_array(); /* GET PRODUCTS CODE THAT IS NOT USED (GENERATED EARLIER) */

					/* UPDATE PRODUCT CODE AS USED*/ 
					$dataArr = array('status'=>'used');
					$this->db->WHERE('pc_id',$productCode['pc_id'])
							->UPDATE('product_code_tbl', $dataArr);

					if ($type == 'member_purchase') {
						$this->insertNewProductStockistTransaction($p_id, $user_code, $productCode['pc_id']);
						$this->insertNewStockistTx($p_id, $user_code, $type);

						/* INSERT UNILEVEL POINTS TO YOURSELF */ 
						$this->insertUnilevelPointsWallet($p_id, $user_code);

						/* INSERT UNILEVEL POINTS TO INDIRECT REFERRAL */ 
						$this->insertReferralUnilvlPoints($p_id, $userData['sponsor_id']);
					}
					else{
						$this->insertNewStockistTx($p_id, '', $type);
					}

					/* INSERT POINTS ALLOCATED FOR INVESTMENT*/ 
					$this->insertInvestmentPoints($p_id, $p_id);

				}
				/* subtract qty */ 
				$prodQty = array('qty'=>$productsCount['qty'] - $qty);
				$this->db->WHERE('p_id', $p_id)->UPDATE('stockist_stocks_tbl',$prodQty);

				$response['status'] = 'success';
				$response['message'] = 'Purchase Successfully Processed!';
			}
			return $response;
    	}
    	else{
    		$response = array('status'=>401, 'message'=>'Not Allowed!');
    		return $response;
    	}
	}
	public function insertStockistPuchaseNewActivity($p_id, $type, $user_code, $qty) {
		$user = $this->db->SELECT('username')->WHERE('user_code', $user_code)->GET('user_tbl')->row_array();
		$product = $this->db->SELECT('name')->WHERE('p_id', $p_id)->GET('products_tbl')->row_array();
		if ($type == 'member_purchase') {
			$message = 'User <a target="_blank" href="'.base_url('user/overview/').$user_code.'">'.$user['username'].'</a> purchase '.$qty.' '.$product['name'].' from Stockist.';
		}
		else {
			$message = 'Non-member purchase '.$qty.' '.$product['name'].' from Stockist.';
		}
		$activity_log = array(
			'user_id'=>$this->session->user_id, 
			'message_log'=>$message, 
			'ip_address'=>$this->input->ip_address(), 
			'platform'=>$this->agent->platform(), 
			'browser'=>$this->agent->browser(),
			'created_at'=>date('Y-m-d H:i:s')
		); 
		$this->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

		
	}
	public function insertNewProductStockistTransaction($p_id, $user_code, $pc_id){
		if (isset($this->session->user_id)) {
			$getProdPoints = $this->db->SELECT('points')->WHERE('p_id', $p_id)->GET('products_tbl')->row_array();

			$dataArr = array(
				'p_id'=>$p_id,
				'pc_id'=>$pc_id,
				'status'=>'complete',
				'unilevel_points'=>$getProdPoints['points'], /* total points earnd for product unilevel */
				'user_code'=>$user_code,
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('repeat_purchase_history_tbl',$dataArr);
			$id = $this->db->insert_id();
			$ref_no = $this->generateProductPurchaseRefNo($id);

			/* INSERT TRANSACTION ACTIVITY */ 
			$txDataArr = array(
				'reference_no'=>$ref_no,
				'activity'=>'Repeat Purchase - Stockist Purchase',
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('transaction_tbl', $txDataArr);


		}
	}
	public function insertNewStockistTx($p_id, $user_code, $type){
		if (isset($this->session->user_id)) {
			$dataArr = array(
				'p_id'=>$p_id,
				'status'=>'complete',
				'stockist_user_code'=>$this->session->user_code,
				'buyer_user_code'=>$user_code,
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('stockist_transactions_tbl',$dataArr);
			$st_id = $this->db->insert_id();
			$ref_no = $this->generateStockistTransaction($st_id);


			/* INSERT TRANSACTION ACTIVITY */ 
			if ($type == 'member_purchase') {
				$activity = 'Member Purchase - Stockist Purchase';
			}
			else{
				$activity = 'Non-Member Purchase - Stockist Purchase';
			}
			$txDataArr = array(
				'reference_no'=>$ref_no,
				'activity'=>$activity,
				'created_at'=>date('Y-m-d H:i:s')
			);
			$this->db->INSERT('transaction_tbl', $txDataArr);

		}
	}
	public function generateStockistTransaction($st_id, $length = 9){
		$characters = '0123456789';
	    $charactersLength = strlen($characters);
	    $temp_ref_no = '';
	    for ($i = 0; $i < $length; $i++) {
	        $temp_ref_no .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $ref_num = '1000SP'.$st_id.$temp_ref_no;

	    $check = $this->db->WHERE('reference_id', $ref_num)->GET('stockist_transactions_tbl')->num_rows();
	    if ($check > 0) {
	    	$this->generateStockistTransaction($st_id);
	    }
	    else{
	    	$dataArr = array('reference_id'=>$ref_num);
	    	$this->db->WHERE('st_id', $st_id)->UPDATE('stockist_transactions_tbl', $dataArr);
	    	return $ref_num;
	    }
	}
	public function getStockistProductList(){
		return $this->db->SELECT('pt.p_id, name')
			->FROM('products_tbl as pt')
			->JOIN('stockist_stocks_tbl as sst', 'sst.p_id=pt.p_id')
			->ORDER_BY('name', 'ASC')
			->WHERE('status', 'active')
			->GET()->result_array();
	}
	public function getStockistTxHistory($row_per_page, $row_no, $user_code){
		if ($this->session->type == 'stockist' || isset($this->session->admin)) {
    		$query = $this->db->SELECT('pt.name, pt.url, stt.status, stt.created_at, stt.buyer_user_code, stt.stockist_user_code, stt.reference_id')
	    		->FROM('stockist_transactions_tbl as stt')
	    		->JOIN('products_tbl as pt', 'pt.p_id=stt.p_id')
	    		->WHERE('stockist_user_code', $user_code)
				->ORDER_BY('stt.created_at', 'DESC')
				->LIMIT($row_per_page, $row_no)
				->GET()->result_array();
			$result = array();

			foreach($query as $q){
				$array = array(
					'name'=> ( strlen($q['name']) > 28 ) ? substr($q['name'], 0, 25).'...' : $q['name'],
					'url'=>base_url('product/').$q['url'],
					'reference_id'=>$q['reference_id'],
					'status'=>$q['status'],
					'user_code'=>$q['buyer_user_code'],
					'created_at'=>date('m/d/Y h:i A', strtotime($q['created_at'])),
				);
				array_push($result, $array);
			}
			return $result;
    	}
	}
	public function getStockistTxHistoryCount($user_code){
		if ($this->session->type == 'stockist' || isset($this->session->admin)) {
    		$query = $this->db->WHERE('stockist_user_code', $user_code)
				->GET('stockist_transactions_tbl')->num_rows();
			return $query;
    	}
	}
}
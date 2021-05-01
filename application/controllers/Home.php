<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Home extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('csrf_model');
        $this->load->model('products_model');
        $this->load->model('my_account_model');
        $this->load->model('cart_model');
        $this->load->model('order_model');
        $this->load->model('binary_model');
		$this->load->library('user_agent');
        $this->load->library('form_validation');
		$this->load->helper('cookie');

    }
    public function index(){
    	$checkMaintenance = $this->my_account_model->checkMaintenance();
		if ($checkMaintenance <= 0) {
			$data = $this->csrf_model->getCsrfData();
			$data['page'] = 'index';
	    	$this->load->view('index', $data);
			$this->load->view('footer');
		}
		else{
			$this->load->view('errors/maintenance');
		}
    }
   	public function members(){
    	if (isset($this->session->user_id)) {
			$data['title'] = 'Member List';
			$data['page'] = 'members_page';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('account/members');
			$this->load->view('widget');
			$this->load->view('account/footer');
		}
		else{
			header('location:'.base_url('login'));
		}
    }
    public function maintenance(){
    	if (isset($this->session->user_id)) {
			$data['title'] = 'Maintenance Page';
			$data['page'] = 'maintenance_page';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('account/maintenance');
			$this->load->view('widget');
			$this->load->view('account/footer');
		}
		else{
			header('location:'.base_url('/login?').uri_string());
		}
    }
	public function getCsrfData()
	{	
		$data = $this->csrf_model->getCsrfData();
   		$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));

	}
	public function login() {
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */

       	if (!isset($this->session->user_id )) {
       		$data['login_token'] = base64_encode( openssl_random_pseudo_bytes(64)); /* generated token */
			$data['page'] = 'login';
			$this->load->view('home/login', $data);
			$this->load->view('home/footer');
       	}
       	else{
       		header('location:'.base_url('account'));
       	}
	}
	public function logout(){
		delete_cookie("remember_login");
		$this->session->sess_destroy();	
		header('location:'.base_url('login'));
	}
	public function register (){
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		$data['page'] = 'register';
		$this->load->view('home/register', $data);
		$this->load->view('home/footer');
	}
	/* admin panel start */ 
	public function account (){
		if (isset($this->session->user_id) && $this->session->user_type == 'admin') {
			$data['title'] = 'My Account';
			$data['page'] = 'dashboard';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('account/my_account');
			$this->load->view('widget');
			$this->load->view('account/footer');
		}
		else if(isset($this->session->user_id) && $this->session->user_type == 'member'){
			$data['title'] = 'Dashboard';
			$data['page'] = 'dashboard';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('member/member_account');
			$this->load->view('widget');
			$this->load->view('account/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function products (){
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		if (isset($this->session->user_id) && $this->session->user_type == 'admin') {
			$data['title'] = 'Products';
			$data['page'] = 'admin_products';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('products/navbar');
			$this->load->view('products/products');
			$this->load->view('widget');
			$this->load->view('products/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function ledger (){
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		if (isset($this->session->user_id) && $this->session->user_type == 'admin') {
			$data['title'] = 'Ledger';
			$data['page'] = 'admin_ledger';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('account/ledger');
			$this->load->view('account/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function productsCategory (){
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		if (isset($this->session->user_id) && $this->session->user_type == 'admin') {
			$data['title'] = 'Products Category';
			$data['page'] = 'admin_products_category';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('products/navbar');
			$this->load->view('products/products_category');
			$this->load->view('widget');
			$this->load->view('products/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function orderAdmin (){
		if (isset($this->session->user_id) && $this->session->user_type == 'admin') {
			$data['title'] = 'Orders';
			$data['page'] = 'admin_orders';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('products/navbar');
			$this->load->view('account/orders');
			$this->load->view('widget');
			$this->load->view('products/footer');
		}
		else{
			header('location:'.base_url('/login?').uri_string());
		}
	}
	public function OrderDetailsAdmin($ref_no){
        $checkOrder = $this->order_model->checkOrderRefNo($ref_no);
        if ($checkOrder > 0 && $this->session->user_type == 'admin') {
            $data['reference_no'] = $ref_no;
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'order_details_admin';
            $data['title'] = 'Order Ref #'.$ref_no.'';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('account/order_details');
            $this->load->view('account/footer');
        }
        else{
          	header('location:'.base_url('/login?r=').uri_string());
        }
    }
    public function codeList (){
		if ($this->session->user_type == 'admin') {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'code_list';
            $data['title'] = 'Code List';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('account/code_list');
            $this->load->view('account/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function productsDetails ($product_url){
		$data['product'] = $this->products_model->getProductDataByURL($product_url);
		$data['userData'] = $this->my_account_model->getUserData();
		$data['page'] = 'shop_product';

		if (isset($data['product']['name'])) {
			$this->load->view('shop/header', $data);
			$this->load->view('shop/navbar');
			$this->load->view('shop/product_details');
			$this->load->view('shop/footer');
		}
		else{
			header('location:'.base_url('/login?').uri_string());
		}
	}
	public function memberAdminBinaryByUC ($user_code){
		if ($this->session->user_type == 'admin' && $this->session->user_id) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'member_binary_list_uc';
            $data['title'] = 'Binary Tree';
            $data['user_code'] = $user_code;
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/binary_user_code');
            $this->load->view('member/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	/* admin panel end */ 

	/* members pages start */
	public function memberCodes (){
		if ($this->session->user_type == 'member' && $this->session->user_id) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'member_code_list';
            $data['title'] = 'Code List';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/code_list');
            $this->load->view('member/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function memberBinary (){
		if ($this->session->user_type == 'member' && $this->session->user_id) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'member_binary_list';
            $data['title'] = 'Binary Tree';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/binary');
            $this->load->view('member/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function memberDirectListBinary ($user_code){
		if ($this->session->user_type == 'member' && $this->session->user_id) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'member_binary_list_direct';
            $data['title'] = 'Binary Tree';
            $data['user_code'] = $user_code;
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/binary_direct_user');
            $this->load->view('member/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function directInvites (){
		if ($this->session->user_type == 'member' && $this->session->user_id) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'direct_invites';
            $data['title'] = 'Direct Invites';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/direct_invites');
            $this->load->view('member/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function settings (){
		if ($this->session->user_id) {
            $data['userData'] = $this->my_account_model->getUserData();
			$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
            $data['page'] = 'settings';
            $data['title'] = 'Account Settings';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/settings');
            $this->load->view('member/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function eWallet (){
		if ($this->session->user_id) {
            $data['userData'] = $this->my_account_model->getUserData();
			$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
            $data['page'] = 'payout_page';
            $data['title'] = 'E-wallet';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/ewallet');
            $this->load->view('member/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	/* members pages end */
	public function cart (){
		$data['userData'] = $this->my_account_model->getUserData();
		$data['page'] = 'shopping_cart';
		$data['title'] = 'Shopping Cart';
		$this->load->view('cart/header', $data);
		$this->load->view('cart/navbar');
		$this->load->view('cart/cart');
		$this->load->view('cart/footer');
	}
	public function checkout (){
		$checkCart = $this->cart_model->checkCartData();
		if ($checkCart > 0) {
			$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
			$data['userData'] = $this->my_account_model->getUserData();
			$data['page'] = 'checkout';
			$data['title'] = 'Checkout';
			$this->load->view('checkout/header', $data);
			$this->load->view('checkout/navbar');
			$this->load->view('checkout/checkout');
			$this->load->view('checkout/footer');
		}
		else{
			header('location:'.base_url());
		}
	}
	public function order ($ref_no){
		$checkOrder = $this->order_model->checkOrderRefNo($ref_no);
		if ($checkOrder > 0) {
			$data['reference_no'] = $ref_no;
			$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
			$data['userData'] = $this->my_account_model->getUserData();
			$data['page'] = 'order_details';
			$data['title'] = 'Order Ref #'.$ref_no.'';
			$this->load->view('order/header', $data);
			$this->load->view('order/navbar');
			$this->load->view('order/order_details');
			$this->load->view('order/footer');
		}
		else{
			$data['page'] = '404_page';
			$this->load->view('errors/error_404', $data);
		}
	}
	public function about (){
		$data['userData'] = $this->my_account_model->getUserData();
		$data['page'] = 'about_page';
		$data['title'] = 'About Us';
		$this->load->view('cart/header', $data);
		$this->load->view('shop/navbar');
		$this->load->view('home/about');
		$this->load->view('cart/footer');
	}
	
}

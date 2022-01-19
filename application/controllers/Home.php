<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Home extends CI_Controller {

	function __construct (){
        parent::__construct();

        $this->load->model('csrf_model');
        $this->load->model('site_settings_model');
        $this->load->model('products_model');
        $this->load->model('my_account_model');
        $this->load->model('cart_model');
        $this->load->model('order_model');
        $this->load->model('register_model');
        $this->load->model('member_model');
        $this->load->model('login_model');
        $this->load->model('stat_model');
		$this->load->library('user_agent');
        $this->load->library('form_validation');
		$this->load->helper('cookie');
    }
    public function index(){
    	$data['siteSetting'] = $this->site_settings_model->siteSettings();
    	$checkMaintenance = $this->my_account_model->checkMaintenance();
		if ($data['siteSetting']['system_maintenance'] == 'disabled') {
			$data['userData'] = $this->my_account_model->getUserData();
			
			// unset($_SESSION['_product_nonce']);
			$data['nonce'] = $this->csrf_model->productNonce();
			$this->session->set_userdata('_product_nonce', $data['nonce']['hash']);

			$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
			$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
			$data['csrf'] = $this->csrf_model->getCsrfData();
			$data['carouselBanner'] = $this->stat_model->getCarouselResource();
			$data['page'] = 'index';
	    	$this->load->view('index', $data);
			$this->load->view('footer');
		}
		else{
			$this->load->view('errors/maintenance', $data);
		}
    }
    public function affiliateRegister($affID) {
    	$userData = $this->db->SELECT('username')->WHERE('aff_id', $affID)->GET('user_tbl')->row_array();
    	if (isset($userData)) {
   			header('location:'.base_url('account/signup?ref=').$userData['username'].'?utm_souce=herbalhouse&utm_campaign=affiliate_program&utm_medium=affiliates');
    	}
   	}
   	public function registerNewUser() {
   		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'disabled') {
			$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
			$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
			
			$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
			$data['userData'] = $this->my_account_model->getUserData();
		    $data['page'] = 'register_new_account';
		    $data['title'] = 'Register Account';
		    $this->load->view('home/register_new_user', $data);
		    $this->load->view('footer');
		}
		else{
			$this->load->view('errors/maintenance', $data);
		}
   	}
	public function getCsrfData() {	
		$data = $this->csrf_model->getCsrfData();
   		$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function login() {

		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
			$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->session->set_userdata('user_id', $userData['user_id']);
                $this->session->set_userdata('user_type', $userData['user_type']);
                $this->session->set_userdata('user_code', $userData['user_code']);
              	$this->session->set_userdata('username', $userData['username']);

                if ($userData['user_type'] == 'admin') {
                    $this->session->set_userdata('admin', $userData['username']);
                }
                else if ($userData['user_type'] == 'investor') {
                    $this->session->set_userdata('investor', $userData['username']);
                }
       			header('location:'.base_url('account?r=').uri_string());
    		}
    		else{
                unset($_COOKIE['remember_login']); 
                delete_cookie("remember_login");

    			header('location:'.base_url('login'));
    		}
		}
		else if (isset($this->session->user_id )) {
       		header('Location:'.base_url('account'));
       	}
       	else if (!isset($this->session->user_id )) {
       		delete_cookie("remember_login");
       		unset($_COOKIE['remember_login']);

       		$data['login_token'] = base64_encode( openssl_random_pseudo_bytes(64)); /* generated token */
			$data['page'] = 'login';
			$this->load->view('home/login', $data);
			$this->load->view('home/footer');
       	}
       	else{
       		delete_cookie("remember_login");
       		unset($_COOKIE['remember_login']);
			$this->session->sess_destroy();	
			header('location:'.base_url('login'));
       	}
	}
	public function logout(){
		delete_cookie("remember_login");
		$this->session->sess_destroy();	
		header('location:'.base_url('login'));
	}
	public function register (){
		header('location:'.base_url('login'));
		// $data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		// $data['page'] = 'register';
		// $this->load->view('home/register', $data);
		// $this->load->view('home/footer');
	}
	/* admin panel start */ 
	public function account (){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['siteSetting'] = $this->site_settings_model->siteSettings();

		if (isset($this->session->user_id) && isset($this->session->admin)) {
			$data['title'] = 'My Account';
			$data['page'] = 'admin_dashboard';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('account/my_account');
			$this->load->view('widget');
			$this->load->view('account/footer');
		}
		else if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		}

		else if (isset($this->session->user_id) && isset($this->session->investor)) {
			$data['title'] = "Investor's Account";
			$data['page'] = 'investor_dashboard';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('account/investor/investor_dashboard');
			$this->load->view('account/investor/footer');
		}
		else if(isset($this->session->user_id) && $this->session->user_type == 'member'){
			$data['title'] = 'Dashboard';
			$data['page'] = 'dashboard';
			$data['userData'] = $this->my_account_model->getUserData();
			$data['password_check'] = $this->my_account_model->passwordCheck($data['userData']['password']);
			$data['order_check'] = $this->order_model->getYourOrderTodo($data['userData']['password']);
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('member/member_account');
			$this->load->view('widget');
			$this->load->view('account/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function productCodeList (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		if (isset($this->session->admin)) {
			$data['title'] = 'Product Code List';
			$data['page'] = 'product_code_list';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('products/navbar');
			$this->load->view('products/product_code_list');
			$this->load->view('products/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function members(){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
    	if (isset($this->session->admin)) {
			$data['package'] = $this->member_model->getPackageList();
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
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('login'));
		}
    }
    public function maintenance(){
    	$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
    	if (isset($this->session->admin)) {
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
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?').uri_string());
		}
    }
    public function webSettings(){
    	$data['siteSetting'] = $this->site_settings_model->siteSettings();
    	$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
    	if (isset($this->session->admin)) {
			$data['title'] = 'Website Settings';
            $data['siteSetting'] = $this->site_settings_model->siteSettings();
			$data['page'] = 'website_settings';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('account/web_settings');
			$this->load->view('widget');
			$this->load->view('account/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?').uri_string());
		}
    }
	public function products (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
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
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function ledger (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
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
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function productsCategory (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
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
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function walkinBuyers (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		if (isset($this->session->user_id) && $this->session->user_type == 'admin') {
			$data['title'] = 'Walk-in Buyers';
			$data['page'] = 'admin_walkin_buyers';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('account/walkin_buyers');
			$this->load->view('account/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function adminStockist (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		if (isset($this->session->user_id) && $this->session->user_type == 'admin') {
			$data['title'] = 'Stockist Users';
			$data['page'] = 'stockist_admin';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('account/stockist');
			$this->load->view('account/footer');
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function orderAdmin (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
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
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?').uri_string());
		}
	}
	public function activityLogs (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		if ($this->session->user_id == 1 && isset($this->session->admin )) {
			$data['title'] = 'Activity Logs';
			$data['page'] = 'activity_logs';
			$data['userData'] = $this->my_account_model->getUserData();
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('account/navbar');
			$this->load->view('account/activity_logs');
			$this->load->view('account/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function OrderDetailsAdmin($ref_no){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
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
    public function OrderDetailsUser($ref_no){
    	$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
        $checkOrder = $this->order_model->checkOrderRefNo($ref_no);
        if ($checkOrder > 0 && isset($this->session->user_id)) {
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
        else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
        else{
          	header('location:'.base_url('/login?r=').uri_string());
        }
    }
    public function codeList (){
    	$data['siteSetting'] = $this->site_settings_model->siteSettings();
    	$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
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
	 public function withdrawRequest (){
	 	$data['siteSetting'] = $this->site_settings_model->siteSettings();
	 	$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
		if ($this->session->user_type == 'admin') {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'withdraw_request';
            $data['title'] = 'Withdrawal Requests';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('account/withdraw_request');
            $this->load->view('account/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function productsDetails ($product_url){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
			$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['product'] = $this->products_model->getProductDataByURL($product_url);
		$data['userData'] = $this->my_account_model->getUserData();
		$data['page'] = 'shop_product';
		$data['nonce'] = $this->csrf_model->productNonce(); /* get CSRF data */
		$this->session->set_userdata('_rec_product_nonce', $data['nonce']['hash']);

		if (isset($data['product']['name'])) {
			$this->load->view('shop/header', $data);
			$this->load->view('shop/navbar');
			$this->load->view('shop/product_details');
			$this->load->view('shop/footer');
		}
		else{
			$this->error404();
		}
	}
	public function productCategory ($category_url){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
			$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['category'] = $this->products_model->getProductCategoryDataByURL($category_url);
		$data['products'] = $this->products_model->getProductsByCategoryDataByURL($category_url);
		$data['userData'] = $this->my_account_model->getUserData();
		$data['page'] = 'product_category';
		$data['nonce'] = $this->csrf_model->productNonce(); /* get CSRF data */
		$this->session->set_userdata('_rec_product_nonce', $data['nonce']['hash']);

		if (isset($data['category']['name'])) {
			$this->load->view('shop/p_cat_header', $data);
			$this->load->view('shop/navbar');
			$this->load->view('shop/product_category');
			$this->load->view('shop/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			$this->error404();
		}
	}
	public function userProductsDetails ($product_url){
		$data['product'] = $this->products_model->getProductDataByURL($product_url);
		$data['userData'] = $this->my_account_model->getUserData();
		$data['page'] = 'shop_product';
		$data['nonce'] = $this->csrf_model->productNonce(); /* get CSRF data */
		$this->session->set_userdata('_rec_product_nonce', $data['nonce']['hash']);

		if (isset($data['product']['name'])) {
			$this->load->view('shop/header', $data);
			$this->load->view('shop/navbar');
			$this->load->view('shop/product_details');
			$this->load->view('shop/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?').uri_string());
		}
	}
	public function memberAdminBinaryByUC ($user_code){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		if ($this->session->user_type == 'admin' && isset($this->session->user_id)) {
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
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function userOverview ($user_code){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		if ($this->session->user_type == 'admin' && isset($this->session->user_id)) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['userDataOpt'] = $this->my_account_model->getUserDataOpt($user_code);
            $data['page'] = 'user_overview';
            $data['title'] = 'User Oveview of '.$data['userDataOpt']['fname'].' '.$data['userDataOpt']['lname'];
            $data['user_code'] = $user_code;
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('account/user_overview');
            $this->load->view('account/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	/* admin panel end */ 

	/* members pages start */
	public function registerDirectPage(){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
        $data['packageCredit'] = $this->register_model->getPackageCredit();
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		} 
		else if ($this->session->user_type == 'member' && isset($this->session->user_id)) {
			if (!empty($data['packageCredit'])) {
	            $data['userData'] = $this->my_account_model->getUserData();
	            $data['page'] = 'register_invite';
	            $data['title'] = 'Register Invite';
	            $this->load->view('account/header', $data);
				$this->load->view('account/leftside-menu');
	            $this->load->view('account/navbar');
	            $this->load->view('member/register_invite');
	            $this->load->view('member/footer');
			}
			else{
				header('location: '.base_url().'member/invites-list');
			}
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function memberCodes (){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		} 
		else if ($this->session->user_type == 'member' && isset($this->session->user_id)) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'member_code_list';
            $data['title'] = 'Code List';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/code_list');
            $this->load->view('member/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	// public function memberBinary (){
	// 	$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
	// 	$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
	// 	if ($this->session->user_type == 'member' && isset($this->session->user_id)) {
 //            $data['userData'] = $this->my_account_model->getUserData();
 //            $data['page'] = 'member_binary_list';
 //            $data['title'] = 'Binary Tree';
 //            $this->load->view('account/header', $data);
	// 		$this->load->view('account/leftside-menu');
 //            $this->load->view('account/navbar');
 //            $this->load->view('member/binary');
 //            $this->load->view('member/footer');
	// 	}
	// 	else if(isset($_COOKIE['remember_login'])) {
 //    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
 //    		if (isset($userData)) {
 //    			$this->loginViaCookieRememberLogin($userData);
 //    		}
 //    		else{
 //    			$this->logoutUnset();
 //    		}
	// 	}
	// 	else{
	// 		header('location:'.base_url('/login?r=').uri_string());
	// 	}
	// }
	// public function memberDirectListBinary ($user_code){
	// 	$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
	// 	$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
	// 	if ($this->session->user_type == 'member' && isset($this->session->user_id)) {
 //            $data['userData'] = $this->my_account_model->getUserData();
 //            $data['page'] = 'member_binary_list_direct';
 //            $data['title'] = 'Binary Tree';
 //            $data['user_code'] = $user_code;
 //            $this->load->view('account/header', $data);
	// 		$this->load->view('account/leftside-menu');
 //            $this->load->view('account/navbar');
 //            $this->load->view('member/binary_direct_user');
 //            $this->load->view('member/footer');
	// 	}
	// 	else if(isset($_COOKIE['remember_login'])) {
 //    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
 //    		if (isset($userData)) {
 //    			$this->loginViaCookieRememberLogin($userData);
 //    		}
 //    		else{
 //    			$this->logoutUnset();
 //    		}
	// 	}
	// 	else{
	// 		header('location:'.base_url('/login?r=').uri_string());
	// 	}
	// }
	public function directInvites (){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		} 
		else if ($this->session->user_type == 'member' && isset($this->session->user_id)) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'direct_invites';
            $data['title'] = 'Invites List';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/direct_invites');
            $this->load->view('member/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}

	// public function profitSharing (){
	// 	$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
	// 	$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
	// 	if ($this->session->user_type == 'member' && isset($this->session->user_id)) {
 //            $data['userData'] = $this->my_account_model->getUserData();
 //            $data['page'] = 'profit_sharing';
 //            $data['title'] = 'Profit Sharing Board';
 //            $this->load->view('account/header', $data);
	// 		$this->load->view('account/leftside-menu');
 //            $this->load->view('account/navbar');
 //            $this->load->view('member/profit_sharing');
 //            $this->load->view('member/footer');
	// 	}
	// 	else if(isset($_COOKIE['remember_login'])) {
 //    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
 //    		if (isset($userData)) {
 //    			$this->loginViaCookieRememberLogin($userData);
 //    		}
 //    		else{
 //    			$this->logoutUnset();
 //    		}
	// 	}
	// 	else{
	// 		header('location:'.base_url('/login?r=').uri_string());
	// 	}
	// }
	public function memberProducts (){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		} 
		else if ($this->session->user_type == 'member' && isset($this->session->user_id)) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['nonce'] = $this->csrf_model->productNonce(); /* get CSRF data */
			$this->session->set_userdata('_product_nonce', $data['nonce']['hash']);
            $data['page'] = 'member_products';
            $data['title'] = 'Products';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/member_products');
            $this->load->view('member/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function customerOrders (){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		} 
		else if ($this->session->user_type == 'member' && isset($this->session->user_id)) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'customer_orders';
            $data['title'] = 'Customer Orders';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/customer_orders');
            $this->load->view('member/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function myOrders (){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		} 
		else if ($this->session->user_type == 'member' && isset($this->session->user_id)) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['page'] = 'my_orders';
            $data['title'] = 'My Orders';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/my_orders');
            $this->load->view('member/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function settings (){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if (isset($this->session->user_id) && isset($this->session->admin)) {
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
		else if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		} 

		else if (isset($this->session->user_id)) {
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
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function eWallet (){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		} 
		else if (isset($this->session->user_id)) {
            $data['userData'] = $this->my_account_model->getUserData();
            $data['siteSetting'] = $this->site_settings_model->siteSettings();
			$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
            $data['page'] = 'wallet';
            $data['title'] = 'Wallet';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/ewallet');
            $this->load->view('member/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function accountMembership (){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		} 
		else if (isset($this->session->user_id)) {
			$data['affData'] = $this->member_model->getUserAffId();
            $data['userData'] = $this->my_account_model->getUserData();
			$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
            $data['page'] = 'membership';
            $data['title'] = 'Membership';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/membership');
            $this->load->view('member/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function stockist (){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
        $data['userData'] = $this->my_account_model->getUserData();

		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'enabled') {
			$this->load->view('errors/maintenance', $data);
		} 
		else if (isset($this->session->user_id) && $data['userData']['type'] == 'stockist') {
			$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
            $data['page'] = 'stockist';
            $data['title'] = 'Stockist Account';
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('member/stockist');
            $this->load->view('member/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	public function adminViewStockist ($user_code){
		$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
		$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
        $data['userData'] = $this->my_account_model->getUserData();
		$data['userDataOpt'] = $this->my_account_model->getUserDataOpt($user_code);

		if (isset($this->session->admin) && $data['userDataOpt']['type'] == 'stockist') {
			$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
            $data['page'] = 'stockist_overview';
            $data['user_code'] = $user_code;
            $data['title'] = 'Stockist Overview '.ucwords($data['userDataOpt']['fname'].' '.$data['userDataOpt']['lname']);
            $this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
            $this->load->view('account/navbar');
            $this->load->view('account/stockist_overview');
            $this->load->view('member/footer');
		}
		else if(isset($_COOKIE['remember_login'])) {
    		$userData = $this->login_model->checkCookie($_COOKIE['remember_login']); //check if cookie token is the same on server
    		
    		if (isset($userData)) {
    			$this->loginViaCookieRememberLogin($userData);
    		}
    		else{
    			$this->logoutUnset();
    		}
		}
		else{
			header('location:'.base_url('/login?r=').uri_string());
		}
	}
	/* members pages end */
	public function cart (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'disabled') {
			$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
			$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
			$data['userData'] = $this->my_account_model->getUserData();
			$data['page'] = 'shopping_cart';
			$data['title'] = 'Shopping Cart';
			$this->load->view('cart/header', $data);
			$this->load->view('cart/navbar');
			$this->load->view('cart/cart');
			$this->load->view('cart/footer');
		}
		else{
			$this->load->view('errors/maintenance', $data);
		}
	}
	public function checkout (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'disabled') {
			$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
			$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
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
				header('location:'.base_url('#shop_now'));
			}
		}
		else{
			$this->load->view('errors/maintenance', $data);
		}

		
	}
	public function order ($ref_no){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'disabled') {
			$checkOrder = $this->order_model->checkOrderRefNo($ref_no);
			if ($checkOrder > 0) {
				$data['reference_no'] = $ref_no;
				$data['csrf'] = $this->csrf_model->getCsrfData(); /* get CSRF data */
				$data['userData'] = $this->my_account_model->getUserData();
				$data['page'] = 'order_details';
				$data['title'] = 'Thank you! / Order Ref. #'.$ref_no.'';
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
		else{
			$this->load->view('errors/maintenance', $data);
		}

		
	}
	public function about (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'disabled') {
			$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
			$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
			$data['userData'] = $this->my_account_model->getUserData();
			$data['page'] = 'about_page';
			$data['title'] = 'About Us';
			$this->load->view('home/about', $data);
			$this->load->view('cart/footer');
		}
		else{
			$this->load->view('errors/maintenance', $data);
		}
	}
	public function aboutInfo (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'disabled') {
			$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
			$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
			$data['userData'] = $this->my_account_model->getUserData();
			$data['page'] = 'about_page';
			$data['title'] = 'About Us';
			$this->load->view('account/header', $data);
			$this->load->view('account/leftside-menu');
			$this->load->view('products/navbar');
			$this->load->view('account/about');
			$this->load->view('products/footer');

		}
		else{
			$this->load->view('errors/maintenance', $data);
		}

		
	}
	public function membership (){
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'disabled') {
			$data['analyticSrc'] = '<script async src="https://www.googletagmanager.com/gtag/js?id=G-VDGGJR2S0C"></script>';
			$data['analyticData'] = "<script> window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-VDGGJR2S0C');</script>";
			$data['userData'] = $this->my_account_model->getUserData();
			$data['page'] = 'membership';
			$data['title'] = 'Membership';
			// $this->load->view('cart/header', $data);
			// $this->load->view('home/navbar');
			$this->load->view('home/membership', $data);
			$this->load->view('cart/footer');
		}
		else{
			$this->load->view('errors/maintenance', $data);
		}
	}
	public function error404() {
		$data['siteSetting'] = $this->site_settings_model->siteSettings();
		if ($data['siteSetting']['system_maintenance'] == 'disabled') {
			$data['page'] = '404_page';
			$this->load->view('errors/error_404', $data);
		}
		else{
			$this->load->view('errors/maintenance', $data);
		}
	}
	public function loginViaCookieRememberLogin($userData){
		$this->session->set_userdata('user_id', $userData['user_id']);
        $this->session->set_userdata('user_type', $userData['user_type']);
        $this->session->set_userdata('user_code', $userData['user_code']);
       	$this->session->set_userdata('username', $userData['username']);
        $this->session->set_userdata('type', $userData['type']);
        $this->session->set_userdata($userData['type'], $userData['type']);

        if ($userData['user_type'] == 'admin') {
            $this->session->set_userdata('admin', $userData['username']);
        }
        else if ($userData['user_type'] == 'investor') {
            $this->session->set_userdata('investor', $userData['username']);
        }
        header('location:'.base_url().uri_string());
	}
	public function logoutUnset(){
		unset($_COOKIE['remember_login']); 
        delete_cookie("remember_login");
        header('location:'.base_url('login'));
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');

class Login extends CI_Controller {

	function __construct (){
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('register_model');
        $this->load->model('cart_model');
        $this->load->library('form_validation');
        $this->load->library('user_agent'); 
    }
	public function account()
	{	
		$username = $this->input->post('username');
        $password = $this->input->post('password');
        $remember_login = $this->input->post('remember_login');
        $last_url = $this->input->post('last_url');
        
        if (isset($remember_login) ) {
            $cookie_name = 'remember_login';
            $cookie_value = $remember_login;
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 30 days
        }
        else{
            $remember_login = '';
        }

        $checkUser = $this->login_model->checkUserData($username);
        if (isset($checkUser)) {
            if (password_verify($password, $checkUser['password'])) {
                $this->session->set_userdata('user_id', $checkUser['user_id']);
                $this->session->set_userdata('user_type', $checkUser['user_type']);
                $this->session->set_userdata('user_code', $checkUser['user_code']);
                $this->session->set_userdata('username', $checkUser['username']);
                $this->session->set_userdata('type', $checkUser['type']);
              	$this->session->set_userdata($checkUser['type'], $checkUser['type']);

                if ($checkUser['user_type'] == 'admin') {
                    $this->session->set_userdata('admin', $checkUser['username']);
                }
                else if ($checkUser['user_type'] == 'investor') {
                    $this->session->set_userdata('investor', $checkUser['username']);
                }
                if (isset($this->session->temp_user_id)) {
                    $checkUserCart = $this->cart_model->checkUserCart();
                    if (isset($checkUserCart)) {
                        /* update temp user id to the current login user */ 
                        foreach ($checkUserCart as $cuc) {
                            $this->cart_model->updateUserCartData($cuc['p_id']);
                        }
                    }
                }

                $this->login_model->insertNewRememberLogin($remember_login);
                
                $activity_log = array(
                    'user_id'=>$checkUser['user_id'], 
                    'message_log'=>'Login', 
                    'ip_address'=>$this->input->ip_address(), 
                    'platform'=>$this->agent->platform(), 
                    'browser'=>$this->agent->browser(), 
                    'created_at'=>date('Y-m-d H:i:s')
                ); 
                $this->register_model->insertActivityLog($activity_log); /* INSERT new ACIVITY LOG */

                $response['status'] = 'success';
                $response['message'] = 'Logging in! Please wait...';
                if ($last_url != '') {
                    $response['url'] = base_url().$last_url;
                }
                else{
                    $response['url'] = base_url().'account';
                }
            }
            else{
                $response['status'] = 'wrong_password';
                $response['message'] = 'Wrong password! Double check your credentials!';
            }
        }
        else{
            $response['status'] = 'no_user_found';
            $response['message'] = 'No user found! Try again!';
        }
   		$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$response)));
	}
}

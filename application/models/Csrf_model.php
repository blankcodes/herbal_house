<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csrf_model extends CI_Model {

	public function getCsrfData() {
		$data = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        return $data;
	}
	public function productNonce() {
		$data = array(
            'name' => 'product_nonce',
            'hash' => $this->generateNonce()
        );
        return $data;
	}
    public function generateNonce ($length = 16) {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $nonce = '';
        for ($i = 0; $i < $length; $i++) {
            $nonce .= $characters[rand(0, $charactersLength - 1)];
        }
        return $nonce;
    }
}
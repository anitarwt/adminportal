<?php

/**
 * @package    portal.ilmuberbagi.or.id / 2016
 * @author     Sabbana
 * @copyright  Divisi IT IBF
 * @version    1.0
 */
 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	var $data = array();
	
	function __construct(){
		parent::__construct();
		$this->load->model("Mdl_login","model");
	}
	
	public function index(){
		$datapost = array(
			'username' => $this->security->xss_clean($this->input->post('username')),
			'password' => $this->security->xss_clean($this->input->post('password')),
		);
		$user = $this->model->get_user($datapost['username'], $datapost['password']);
		$priv = array();
		if(!empty($user)){
			$priv = $this->model->get_user_privilage($user[0]['member_id']);
			# create session
			$create_session = array(
				'id'			=> $user[0]['member_id'],
				'ibf_token_string'	=> 'IBF'.md5($user[0]['member_id']),
				'email'			=> $user[0]['member_email'],
				'username'		=> $datapost['username'],
				'name'			=> $user[0]['member_name'],
				'avatar'		=> $user[0]['member_image_profile'],
				'year'			=> $user[0]['member_reg_year'],
				'type'			=> $user[0]['member_type'],
				'ibf_code'		=> $user[0]['member_ibf_code'],
				'privilage'		=> $priv[0],
			);
			$this->session->set_userdata($create_session);
			redirect('dashboard');
		}else{
			print_r($this->session->all_userdata());
			$msg = '<div class="alert alert-warning alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> ditolak!</h4>Username dan atau password yang Anda masukkan tidak valid.</div>';
			$this->session->set_flashdata('invalid', $msg);
			redirect('login');
		}
		
	}
	
	private function director($app){
		switch($app){
			case 'portal': 
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}

}
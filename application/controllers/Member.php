<?php

class Member extends CI_Controller{

	var $data = array();

	public function __construct(){
		parent::__construct();
		if($this->session->userdata('ibf_token_string') == '') redirect('login');
		$this->load->model('Mdl_member','member');
	}
	
	public function index(){
		$this->data['title'] = 'IBF Members';
		$this->data['page'] = 'page/member';
		$this->data['members'] = $this->member->get_member();
		$this->data['count_member'] = $this->member->count_member();
		$this->load->view('template', $this->data);
	}
	
	public function edit($code){
		$this->data['member'] = $this->member->get_member($code);
		$this->data['page'] = 'page/member_form';
		$this->data['title'] = 'IBF Member : '.$this->data['member'][0]['member_name'];
		$this->data['types'] = $this->member->get_member_types();
		$this->data['region'] = $this->member->get_regions();
		$this->load->view('template', $this->data);
	}
	
	public function detail($code){
		$this->load->model('Mdl_article','article');
		$this->data['page'] = 'page/member_detail';
		$this->data['articles'] = $this->article->get_article_by_member($this->lib_general->get_id_from_code($code));
		$this->data['member'] = $this->member->get_member($code);
		$this->data['title'] = 'IBF Member : '.$this->data['member'][0]['member_name'];
		$this->load->view('template', $this->data);
	}

	# module wilayah
	# ==============================================
	public function region($region = ""){
		$this->data['title'] = 'IBF Region';
		$this->data['page'] = 'page/region';
		$this->data['region'] = $this->member->get_region();
		if($region !== ""){
			$this->data['page'] = 'page/member';
			$this->data['members'] = $this->member->get_region($region);
		}
		$this->load->view('template', $this->data);
	}
	
	/**
	 * save new region
	 * @ param array data
	 * @ return boolean
	 * redirect
	 */
	public function sv_region(){
		$data = array(
			'region_name' => $this->security->xss_clean($this->input->post('region_name'))
		);
		$act = $this->member->create_region($data);
		if($act) $this->session->set_flashdata('success','Wilayah baru telah berhasil disimpan.');
		else $this->session->set_flashdata('error','Terjadi kesalahan saat menyimpan data.');
		redirect('member/region');
	}
	
	/**
	 * update region
	 * @ param id & array data
	 * @ return boolean
	 * redirect
	 */
	 public function upd_region(){
		$id = $this->input->post('region_id');
		$data = array(
			'region_name' => $this->security->xss_clean($this->input->post('region_name'))
		);
		$act = $this->member->update_region($id, $data);
		if($act) $this->session->set_flashdata('success','Data telah berhasil diupdate.');
		else $this->session->set_flashdata('error','Terjadi kesalahan saat mengupdate data.');
		redirect('member/region');
	}
	
	# modules member type
	# ========================================
	
	public function type($type = ""){
		$this->data['title'] = 'IBF Member Types';
		$this->data['page'] = 'page/member_type';
		$this->data['types'] = $this->member->get_member_type();
		if($type !== ""){
			$this->data['page'] = 'page/member';
			$this->data['members'] = $this->member->get_member_type($type);
		}
		$this->load->view('template', $this->data);		
	}
	
	/**
	 * save member type
	 * @ param array data
	 * @ return boolean
	 * redirect
	 */
	public function sv_type(){
		$data = array(
			'member_type' => $this->security->xss_clean($this->input->post('member_type')),
			'type_description' => $this->security->xss_clean($this->input->post('type_description'))
		);
		$act = $this->member->create_member_type($data);
		if($act) $this->session->set_flashdata('success','Status Anggota baru telah berhasil disimpan.');
		else $this->session->set_flashdata('error','Terjadi kesalahan saat menyimpan data.');
		redirect('member/type');
	}
	
	/**
	 * update member type
	 * @ param id & array data
	 * @ return boolean
	 * redirect
	 */
	public function upd_type(){
		$id = $this->input->post('type_id');
		$data = array(
			'member_type' => $this->security->xss_clean($this->input->post('region_name')),
			'type_description' => $this->security->xss_clean($this->input->post('type_description'))
		);
		$act = $this->member->update_type($id, $data);
		if($act) $this->session->set_flashdata('success','Data telah berhasil diupdate.');
		else $this->session->set_flashdata('error','Terjadi kesalahan saat mengupdate data.');
		redirect('member/type');
	}
	
	# modules privilage
	# =============================================
	public function privilage(){
		$this->data['title'] = 'IBF Members';
		$this->data['page'] = 'page/privilage';
		$this->data['apps'] = $this->member->get_apps();
		$this->data['members'] = $this->member->get_user_privilage();
		$this->load->view('template', $this->data);
	}

	public function changepassword(){
		$this->data['title'] = 'Change Password';
		$this->data['page'] = 'page/password_change';
		$this->load->view('template', $this->data);
	}
	
	# proc updating data 
	# ============================
	public function proc_change_password(){
		$this->load->library('form_validation');
		$id = $this->security->xss_clean($this->input->post('member_id'));
		$pass = $this->security->xss_clean($this->input->post('member_password'));
		$repass = $this->security->xss_clean($this->input->post('member_repassword'));
		$this->form_validation->set_rules('member_password','Password','required|trim');
		$this->form_validation->set_rules('member_repassword','Ulangi Password','required|trim|match[member_password]');
		if($this->form_validation->run() == 'FALSE'){
			$msg = validation_errors();
			$this->session->set_flashdata('alert', $msg);
		}else{
			$data = array('member_password' => md5($pass));
			$change = $this->member->update($id, $data);
			if($change)
				$this->session->set_flashdata('success','Password Anda berhasil diupdate.');
			else
				$this->session->set_flashdata('alert','Terjadi kesalahan saat mengupdate password!');
		}
		redirect('member/changepassword');
	}
	
	public function proc_update(){
		
		$id = $this->security->xss_clean($this->input->post('member_id'));
		
		$name = $this->security->xss_clean($this->input->post('member_name'));
		$place = $this->security->xss_clean($this->input->post('member_birthplace'));
		$birthdate = str_replace('/','-', $this->security->xss_clean($this->input->post('member_birthdate')));
		$education = $this->security->xss_clean($this->input->post('member_education'));
		$gender = $this->input->post('member_gender');
		$job = $this->security->xss_clean($this->input->post('member_job'));
		$year = $this->security->xss_clean($this->input->post('member_reg_year'));
		$skills = $this->security->xss_clean($this->input->post('member_skills'));
		$description = $this->security->xss_clean($this->input->post('member_description'));
		$region = $this->input->post('member_region');
		$type = $this->input->post('member_type');
		$phone = $this->security->xss_clean($this->input->post('member_phone'));
		$email = $this->security->xss_clean($this->input->post('member_email'));
		$address = $this->security->xss_clean($this->input->post('member_address'));
		$fb = $this->security->xss_clean($this->input->post('member_fb'));
		$tw = $this->security->xss_clean($this->input->post('member_twitter'));
		$website = $this->security->xss_clean($this->input->post('member_website'));
		$motivation = $this->security->xss_clean($this->input->post('member_reason'));
		
		$data = array(
			'member_name'	=> $name,
			'member_email'	=> $email,
		);
		
		$detailuser = array(
			'member_birthplace'	=> $place,
			'member_birth_date'	=> date('Y-m-d', strtotime($birthdate)),
			'member_education'	=> $education,
			'member_gender'	=> $gender,
			'member_job'	=> $job,
			'member_skills'	=> $skills,
			'member_description'	=> $description,
			'member_region'	=> $region,
			'member_type'	=> json_encode($type),
			'member_phone'	=> $phone,
			'member_address'	=> $address,
			'member_facebook'	=> $fb,
			'member_twitter'	=> $tw,
			'member_reg_year'	=> $year,
			'member_blog'	=> $website,
			'member_motivation'	=> $motivation,
			'member_date_update'	=> date('Y-m-d H:i:s'),
		);
		
		$act = $this->member->update($id, $data);
		if($act){
			$upd = $this->member->update_data_user($id, $detailuser);
			if($upd){
				$this->member->update_wilayah_count($detailuser['member_region']);
				$this->session->set_flashdata('success','Data profil berhasil diperbaharui.');
			}
		}else
			$this->session->set_flashdata('error','Terjadi masalah saat menyimpan data, Silakan cek data yang Anda masukkan!');
			
		redirect('member');
	}
	
	public function change_member_status(){
		$id = $this->input->post('member_id');
		$name = $this->input->post('member_name');
		$data = array(
			'member_status' => $this->input->post('member_status') == 1 ? 0 : 1,
		);
		$status = $data['member_status'] == 1 ? 'diaktifkan.':'diblokir.';
		$act = $this->member->update($id, $data);
		if($act)
			$this->session->set_flashdata('success','Member '.$name.' telah '.$status);
		else $this->session->set_flashdata('error','Terjadi masalah saat mengupdate data.');
		redirect('member');
	}
	
	public function change_privilage(){
		$app_id = $this->input->post('app_id');
		$uid = $this->input->post('member_id');
		$priv = $this->input->post('priv');
		$data = array(
			'app_'.$app_id	=> $priv
		);
		$act = $this->member->set_privilage($uid, $data);
		if($act)
			$this->session->set_flashdata('success','Setting Privilage berhasil disimpan');
		else
			$this->session->set_flashdata('error','Setting Privilage gagal disimpan');
		
		redirect('member/privilage');
	}

}
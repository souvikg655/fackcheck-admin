<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(['form', 'url']);
		$this->load->model('user_model');
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function users()
	{
		$res = $this->user_model->fetch_users();

		$data= array();
		$data['data'] = $res;

		$this->load->view('user', $data);
	}

	public function homes()
	{
		$res = $this->user_model->fetch_homes();

		$data= array();
		$data['data'] = $res;

		$this->load->view('homes', $data);
	}

	public function admin_login(){
		$data['email'] = $this->input->post('email');
		$data['password'] = $this->input->post('password');

		if($data['email'] == "admin@admin.com" && $data['password'] == "123456"){
			$responce['status'] = true;
		}else{
			$responce['status'] = false;
		}
		echo (json_encode($responce));
	}

	public function user_reject()
	{
		$data['message'] = $this->input->post('message');
		$data['user_id'] = $this->input->post('user_id');
		$data['type'] = $this->input->post('type');

		$res = $this->user_model->user_reject($data);

		if($res == 1){
			$responce['status'] = true;
			$responce['message'] = "Successful";
		}else{
			$responce['status'] = false;
			$responce['message'] = "Failed";
		}
	
	echo (json_encode($responce));
	}

	public function user_accept()
	{
		$data['user_id'] = $this->input->post('user_id');
		$data['type'] = $this->input->post('type');

		$res = $this->user_model->user_accept($data);

		if($res == 1){
			$responce['status'] = true;
			$responce['message'] = "Accepted";
		}else{
			$responce['status'] = false;
			$responce['message'] = "Failed";
		}
	
	print_r($responce['message']);
	}

	

	
}

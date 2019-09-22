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

	public function add_proparty()
	{
		$proparty = $this->user_model->fetch_proparty();
		$area = $this->user_model->fetch_area();

		$proparty_value= array();
		$proparty_value['proparty_value'] = $proparty;
		$proparty_value['area'] = $area;

		$this->load->view('add_proparty', $proparty_value);
	}

	public function users()
	{
		$res = $this->user_model->fetch_users();

		$data= array();
		$data['data'] = $res;

		$this->load->view('user', $data);
	}

	public function add_propertys(){
		$data['property'] = $this->input->post('property');
		$data['status'] = 1;

		$res = $this->user_model->add_propertys($data);

	echo (json_encode($res));
	}

	public function add_area(){
		$data['area'] = $this->input->post('area');
		$data['status'] = 1;

		$res = $this->user_model->add_area($data);

	echo (json_encode($res));
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
			$response['status'] = true;
		}else{
			$response['status'] = false;
		}
	echo (json_encode($response));
	}

	public function user_reject()
	{
		$data['message'] = $this->input->post('message');
		$data['user_id'] = $this->input->post('user_id');
		$data['type'] = $this->input->post('type');

		$res = $this->user_model->user_reject($data);

		if($res == 1){
			$response['status'] = true;
			$response['message'] = "Successful";
		}else{
			$response['status'] = false;
			$response['message'] = "Failed";
		}
	
	echo (json_encode($response));
	}

	public function user_accept()
	{
		$data['user_id'] = $this->input->post('user_id');
		$data['type'] = $this->input->post('type');

		$res = $this->user_model->user_accept($data);

		if($res == 1){
			$response['status'] = true;
			$response['message'] = "Accepted";
		}else{
			$response['status'] = false;
			$response['message'] = "Failed";
		}
	
	print_r($response['message']);
	}

	public function fetch_proparty_by_id(){
		$proparty_id = $this->input->post('proparty_id');

		$res = $this->user_model->fetch_proparty_by_id($proparty_id);

	echo (json_encode($res));
	}

	public function fetch_area_by_id(){
		$area_id = $this->input->post('area_id');

		$res = $this->user_model->fetch_area_by_id($area_id);

	echo (json_encode($res));
	}

	public function edit_proparty_by_id(){
		$proparty_id = $this->input->post('proparty_id');
		$proparty_edit_value = $this->input->post('proparty_edit_value');

		$data['id'] = $proparty_id;
		$data['value'] = $proparty_edit_value;

		$res = $this->user_model->edit_proparty_by_id($data);
		if($res == 1){
			$response['status'] = true;
			$response['message'] = "Edit Successfull";
		}else{
			$response['status'] = false;
			$response['message'] = "Edit Failed";
		}
	echo (json_encode($response));
	}

	public function edit_area_by_id(){
		$area_id = $this->input->post('area_id');
		$area_edit_value = $this->input->post('area_edit_value');

		$data['id'] = $area_id;
		$data['value'] = $area_edit_value;

		$res = $this->user_model->edit_area_by_id($data);
		if($res == 1){
			$response['status'] = true;
			$response['message'] = "Edit Successfull";
		}else{
			$response['status'] = false;
			$response['message'] = "Edit Failed";
		}
	echo (json_encode($response));
	}

	public function delete_proparty_by_id(){
		$proparty_id = $this->input->post('proparty_id');
		$res = $this->user_model->delete_proparty_by_id($proparty_id);
		if($res == 1){
			$response['status'] = true;
			$response['message'] = "Delete Successfull";
		}else{
			$response['status'] = false;
			$response['message'] = "Delete Failed";
		}

	echo (json_encode($response));
	}

	public function delete_area_by_id(){
		$area_id = $this->input->post('area_id');
		$res = $this->user_model->delete_area_by_id($area_id);
		if($res == 1){
			$response['status'] = true;
			$response['message'] = "Delete Successfull";
		}else{
			$response['status'] = false;
			$response['message'] = "Delete Failed";
		}

	echo (json_encode($response));
	}	
	

	
}

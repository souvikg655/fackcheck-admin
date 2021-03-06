<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homes extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(['form', 'url']);
		$this->load->model('home_model');
		$this->load->model('user_model');
	}

	public function userHomes()
	{
		$user_id = $this->input->post('user_id');

		$res = $this->user_model->fetch_user_homes($user_id);

		$data= array();
		$data['data'] = $res;
		$this->load->view('user_homes', $data);
	}

	public function home_reject()
	{
		$data['message'] = $this->input->post('message');
		$data['home_id'] = $this->input->post('home_id');
		$data['type'] = $this->input->post('type');

		$res = $this->home_model->home_reject($data);

		if($res == 1){
			$responce['status'] = true;
			$responce['message'] = "Successful";
		}else{
			$responce['status'] = false;
			$responce['message'] = "Failed";
		}
	echo (json_encode($responce));
	}

	public function home_accept()
	{
		$data['home_id'] = $this->input->post('home_id');
		$data['realtor_id'] = $this->input->post('realtor_id');
		$data['type'] = $this->input->post('type');

		$res = $this->home_model->home_accept($data);

		if($res == 1){
			$responce['status'] = true;
			$responce['message'] = "Successful";
		}else{
			$responce['status'] = false;
			$responce['message'] = "Failed";
		}
	
	echo (json_encode($responce));
	}

	
}

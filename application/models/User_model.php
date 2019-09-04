<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_model {
	
	public function fetch_users()
	{
		$this -> db -> select('*');
		$this -> db -> from('users');
		$query = $this -> db -> get();

		return $query->result();
	}

	public function fetch_homes()
	{
		$this->db->select('homes.*, users.name')
		->from('homes')
		->join('users', 'homes.realtor_id = users.id');
		$result = $this->db->get()->result();
		return $result;
	}

	public function fetch_user_homes($user_id)
	{
		$this->db->select('homes.*, users.name')
		->from('homes')
		->join('users', 'homes.realtor_id = users.id');
		$this->db->where('realtor_id', $user_id);
		$result = $this->db->get()->result();
		return $result;
		//print_r($result);
	}

	public function user_reject($data)
	{
		$user_id = $data['user_id'];
		$value = [
			'approval' => $data['type'],
			'reject_status' => $data['message'],
			'status' => "0"
		];
		$this->db->where('id', $user_id);
		$this->db->update('users', $value);
		return true;
	}

	public function user_accept($data)
	{
		$user_id = $data['user_id'];
		$data = [
			'approval' => $data['type'],
			'status' => "1",
			'reject_status' => ""
		];

		$this->db->where('id', $user_id);
		$this->db->update('users', $data);	
		return true;
	}

}
?>
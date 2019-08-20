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
		$this -> db -> select('*');
		$this -> db -> from('homes');
		$query = $this -> db -> get();

		return $query->result();
	}

	public function user_reject($data)
	{
		$user_id = $data['user_id'];
		$value = [
		 	'approval' => $data['type'],
			'reject_status' => $data['message']
		];
		$this->db->where('id', $user_id);
		$this->db->update('users', $value);
	return true;
	}

	public function user_accept($data)
	{
		$user_id = $data['user_id'];
		$data = [
		 	'approval' => $data['type']
		];

		$this->db->where('id', $user_id);
		$this->db->update('users', $data);	
	return true;
	}

}
?>
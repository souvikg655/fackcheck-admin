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

	public function add_propertys($data){
		$value = array(
			'name' => $data['property'] ,
			'status' => $data['status'],
		);
		$flag = $this->db->insert('property',$value);
	
	return $flag==1?true:flase;
	}

	public function fetch_proparty()
	{
		$this -> db -> select('*');
		$this -> db -> from('property');
		$this->db->where('status', 1);
		$query = $this -> db -> get();

	return $query->result();
	}

	public function add_area($data){
		$value = array(
			'value' => $data['area'] ,
			'status' => $data['status'],
		);
		$flag = $this->db->insert('area',$value);
	
	return $flag==1?true:flase;
	}

	public function fetch_area()
	{
		$this -> db -> select('*');
		$this -> db -> from('area');
		$this->db->where('status', 1);
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

	public function fetch_proparty_by_id($proparty_id){
		$this -> db -> select('*');
		$this -> db -> from('property');
		$this->  db -> where('id', $proparty_id);
		$query = $this -> db -> get();

	return $query->result();
	}

	public function fetch_area_by_id($area_id){
		$this -> db -> select('*');
		$this -> db -> from('area');
		$this->  db -> where('id', $area_id);
		$query = $this -> db -> get();

	return $query->result();
	}

	public function edit_proparty_by_id($data){
		$value = [
			'name' => $data['value'],
		];

		$this->db->where('id', $data['id']);
		$this->db->update('property', $value);	
	return true;
	}

	public function edit_area_by_id($data){
		$value = [
			'value' => $data['value'],
		];

		$this->db->where('id', $data['id']);
		$this->db->update('area', $value);	
	return true;
	}

	public function delete_proparty_by_id($proparty_id){
		$value = [
			'status' => '0',
		];

		$this->db->where('id', $proparty_id);
		$this->db->update('property', $value);	
	return true;
	}

	public function delete_area_by_id($area_id){
		$value = [
			'status' => '0',
		];

		$this->db->where('id', $area_id);
		$this->db->update('area', $value);	
	return true;
	}

}
?>
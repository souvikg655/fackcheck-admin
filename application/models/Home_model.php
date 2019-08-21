<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_model {

	public function home_reject($data)
	{
		$home_id = $data['home_id'];
		$value = [
		 	'status' => $data['type'],
			'reject_status' => $data['message']
		];

		$this->db->where('id', $home_id);
		$this->db->update('homes', $value);
	return true;
	}

	public function home_accept($data)
	{
		// Fetch user point and add 5 points when approved
		$realtor_id = $data['realtor_id'];
		$this -> db -> select('*');
		$this -> db -> from('users');
		$this->db->where('id', $realtor_id);
		$query = $this -> db -> get();
		$res = $query->result();
		$pre_points = $res[0]->points;
		$new_point = $pre_points+5;


		//Update point here
		$point_update = [
			'points' => $new_point
		];
		$this->db->where('id', $realtor_id);
		$this->db->update('users', $point_update);

		// Update apporoval status
		$home_id = $data['home_id'];
		$val = [
		 	'status' => $data['type']
		];

		$this->db->where('id', $home_id);
		$this->db->update('homes', $val);
	return true;
	}

}
?>
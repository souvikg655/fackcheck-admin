<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_model {

	public function home_reject($data)
	{
		$home_id = $data['home_id'];
		$data = [
		 	'status' => $data['type'],
			'reject_status' => $data['message']
		];

		$this->db->where('id', $home_id);
		$this->db->update('homes', $data);
	return true;
	}

	public function home_accept($data)
	{
		$home_id = $data['home_id'];
		$data = [
		 	'status' => $data['type']
		];

		$this->db->where('id', $home_id);
		$this->db->update('homes', $data);
	return true;
	}

}
?>
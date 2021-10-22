<?php
Class User_Model extends CI_Model {
	public function login($username, $password) {
		$condition	= "username="."'".$username."'". " AND "."password="."'".$password."'";
		$select		= array('username', 'password');
		$this->db->select($select);
		$this->db->from('tb_siswa');
		$this->db->where($condition);
		$login 		= $this->db->get();
		
		if($login->num_rows() > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	public function valid($username) {
		$condition	= "username="."'".$username."'";
		$select		= array('username');
		$this->db->select($select);
		$this->db->from('view_vote');
		$this->db->where($condition);
		$login 		= $this->db->get();
		
		if($login->num_rows() > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	public function datamodel() {
		$load	= $this->db->query("SELECT * FROM tb_pilihan ORDER BY no ASC");
		return $load->result_Array();
	}
	public function vote($nisn, $username) {
		$data			= array(
			'nisn'		=> $nisn,
			'username'	=> $username
		);
		$this->db->insert('tb_pilih', $data);
	}
	public function hadir($username) {
		$update = $this->db->query("UPDATE tb_siswa SET hadir='Hadir' WHERE username='$username'");
		return $update;
	}
}
?>
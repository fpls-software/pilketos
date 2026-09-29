<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model
{
	public function login($username, $password)
	{
		$user = $this->db->get_where('tb_siswa', array('username' => $username))->row_array();
		if (!$user) {
			return FALSE;
		}

		$stored = (string) $user['password'];
		$verified = password_verify($password, $stored)
			|| hash_equals($stored, $password)
			|| (strlen($stored) === 32 && hash_equals($stored, md5($password)));

		if (!$verified) {
			return FALSE;
		}

		if (password_needs_rehash($stored, PASSWORD_DEFAULT)
			|| hash_equals($stored, $password)
			|| strlen($stored) === 32) {
			$this->db->where('username', $username)->update('tb_siswa', array(
				'password' => password_hash($password, PASSWORD_DEFAULT)
			));
		}

		return TRUE;
	}

	public function candidates()
	{
		return $this->db->order_by('no', 'ASC')->get('tb_pilihan')->result_array();
	}

	public function election()
	{
		return $this->db->get_where('tb_datapilketos', array('id' => 1))->row_array();
	}

	public function has_voted($username)
	{
		return $this->db->where('username', $username)->count_all_results('tb_pilih') > 0;
	}

	public function must_change_password($username)
	{
		$user = $this->db->select('wajib_ganti_password')
			->get_where('tb_siswa', array('username' => $username))
			->row_array();
		return $user && (int) $user['wajib_ganti_password'] === 1;
	}

	public function change_password($username, $current, $new_password)
	{
		if (!$this->login($username, $current) || strlen($new_password) < 12
			|| hash_equals($current, $new_password)) {
			return FALSE;
		}
		return $this->db->where('username', $username)->update('tb_siswa', array(
			'password' => password_hash($new_password, PASSWORD_DEFAULT),
			'wajib_ganti_password' => 0
		));
	}

	public function vote($nisn, $username)
	{
		$this->load->model('Election_Model');
		return $this->Election_Model->cast_vote($nisn, $username);
	}
}

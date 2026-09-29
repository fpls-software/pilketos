<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Election_Model extends CI_Model
{
	public function election()
	{
		return $this->db->get_where('tb_datapilketos', array('id' => 1))->row_array();
	}

	public function school()
	{
		return $this->db->get('tb_identitassekolah')->row_array();
	}

	public function candidates()
	{
		return $this->db->order_by('no', 'ASC')
			->order_by('nama', 'ASC')
			->get('tb_pilihan')
			->result_array();
	}

	public function candidate($nisn)
	{
		return $this->db->get_where('tb_pilihan', array('nisn' => $nisn))->row_array();
	}

	public function candidate_number_exists($number, $except_nisn = NULL)
	{
		$this->db->where('no', $number);
		if ($except_nisn !== NULL) {
			$this->db->where('nisn !=', $except_nisn);
		}
		return $this->db->count_all_results('tb_pilihan') > 0;
	}

	public function has_voted($username)
	{
		return $this->db->where('username', $username)->count_all_results('tb_pilih') > 0;
	}

	public function results()
	{
		return $this->db->select('tb_pilihan.nisn, tb_pilihan.no, tb_pilihan.nama, tb_pilihan.photo, COUNT(tb_pilih.id_pilih) AS jumlah')
			->from('tb_pilihan')
			->join('tb_pilih', 'tb_pilih.nisn = tb_pilihan.nisn', 'left')
			->group_by(array('tb_pilihan.nisn', 'tb_pilihan.no', 'tb_pilihan.nama', 'tb_pilihan.photo'))
			->order_by('tb_pilihan.no', 'ASC')
			->get()
			->result_array();
	}

	public function vote_count()
	{
		return $this->db->count_all('tb_pilih');
	}

	public function voter_count()
	{
		return $this->db->count_all('tb_siswa');
	}

	public function save_election($data)
	{
		if ($this->db->where('id', 1)->update('tb_datapilketos', $data)) {
			return TRUE;
		}

		if (!$this->election()) {
			$data['id'] = 1;
			$data['tapel'] = isset($data['tapel']) ? $data['tapel'] : '';
			$data['tgl'] = isset($data['tgl']) ? $data['tgl'] : '2000-01-01';
			return $this->db->insert('tb_datapilketos', $data);
		}

		return FALSE;
	}

	public function add_candidate($data)
	{
		$this->db->trans_begin();
		$this->db->query('SELECT id FROM tb_datapilketos WHERE id = 1 FOR UPDATE');
		if ($this->vote_count() > 0 || $this->candidate_number_exists($data['no'])) {
			$this->db->trans_rollback();
			return FALSE;
		}
		$saved = $this->db->insert('tb_pilihan', $data);
		if (!$saved || $this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		}
		$this->db->trans_commit();
		return $this->db->trans_status();
	}

	public function update_candidate($nisn, $data)
	{
		unset($data['nisn']);
		$this->db->trans_begin();
		$this->db->query('SELECT id FROM tb_datapilketos WHERE id = 1 FOR UPDATE');
		if ($this->vote_count() > 0 || $this->candidate_number_exists($data['no'], $nisn)) {
			$this->db->trans_rollback();
			return FALSE;
		}
		$saved = $this->db->where('nisn', $nisn)->update('tb_pilihan', $data);
		if (!$saved || $this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		}
		$this->db->trans_commit();
		return $this->db->trans_status();
	}

	public function delete_candidate($nisn)
	{
		$this->db->trans_begin();
		$this->db->query('SELECT id FROM tb_datapilketos WHERE id = 1 FOR UPDATE');
		if ($this->vote_count() > 0) {
			$this->db->trans_rollback();
			return FALSE;
		}
		$votes = $this->db->where('nisn', $nisn)->count_all_results('tb_pilih');
		if ($votes > 0) {
			$this->db->trans_rollback();
			return FALSE;
		}
		$this->db->where('nisn', $nisn)->delete('tb_pilihan');
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		}
		$this->db->trans_commit();
		return $this->db->trans_status();
	}

	public function cast_vote($nisn, $username)
	{
		$this->db->trans_begin();
		$election = $this->db->query(
			'SELECT status, mulai, selesai FROM tb_datapilketos WHERE id = 1 FOR UPDATE'
		)->row_array();
		if (!$election || $election['status'] !== 'open') {
			$this->db->trans_rollback();
			return 'closed';
		}

		$now = time();
		if ((!empty($election['mulai']) && strtotime($election['mulai']) > $now)
			|| (!empty($election['selesai']) && strtotime($election['selesai']) < $now)) {
			$this->db->trans_rollback();
			return 'closed';
		}

		if (!$this->db->get_where('tb_siswa', array('username' => $username))->row_array()) {
			$this->db->trans_rollback();
			return 'invalid_voter';
		}
		if (!$this->candidate($nisn)) {
			$this->db->trans_rollback();
			return 'invalid_candidate';
		}
		if ($this->has_voted($username)) {
			$this->db->trans_rollback();
			return 'already_voted';
		}

		$this->db->insert('tb_pilih', array(
			'nisn' => $nisn,
			'username' => $username
		));
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return $this->has_voted($username) ? 'already_voted' : 'error';
		}

		$this->db->where('username', $username)->update('tb_siswa', array('hadir' => 'Hadir'));
		$this->db->trans_commit();
		return $this->db->trans_status() ? 'success' : 'error';
	}
}

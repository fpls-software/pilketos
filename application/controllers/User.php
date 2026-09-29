<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model(array('User_Model', 'Election_Model'));
	}

	public function login()
	{
		if ($this->session->userdata('role') === 'voter') {
			redirect('user/index');
		}
		$this->load->view('user/login');
	}

	public function loginvalidation()
	{
		if (strtoupper($this->input->method(TRUE)) !== 'POST') {
			show_error('This action requires a POST request.', 405);
		}
		$username = trim((string) $this->input->post('username', TRUE));
		$password = (string) $this->input->post('password');
		if ($username === '' || strlen($username) > 32
			|| !$this->User_Model->login($username, $password)) {
			$this->session->set_flashdata('failed', 'Username atau password salah.');
			redirect('user/login');
		}

		$this->session->sess_regenerate(TRUE);
		$this->session->set_userdata(array(
			'username' => $username,
			'role' => 'voter',
			'wajib_ganti_password' => $this->User_Model->must_change_password($username)
		));
		redirect('user/index');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('user/login');
	}

	public function index()
	{
		if ($this->session->userdata('role') !== 'voter') {
			redirect('user/login');
		}
		$election = $this->Election_Model->election();
		$username = $this->session->userdata('username');
		$this->load->view('public/election', array(
			'election' => $election,
			'school' => $this->Election_Model->school(),
			'candidates' => $this->Election_Model->candidates(),
			'results' => $this->Election_Model->results(),
			'votes' => $this->Election_Model->vote_count(),
			'is_voter' => TRUE,
			'has_voted' => $this->Election_Model->has_voted($username),
			'require_password_change' => $this->User_Model->must_change_password($username),
			'can_vote' => $election
				&& $election['status'] === 'open'
				&& (empty($election['mulai']) || strtotime($election['mulai']) <= time())
				&& (empty($election['selesai']) || strtotime($election['selesai']) >= time())
		));
	}

	public function vote()
	{
		if (strtoupper($this->input->method(TRUE)) !== 'POST') {
			show_error('This action requires a POST request.', 405);
		}
		if ($this->session->userdata('role') !== 'voter') {
			redirect('user/login');
		}
		if ($this->User_Model->must_change_password($this->session->userdata('username'))) {
			redirect('user/change_password');
		}

		$nisn = trim((string) $this->input->post('nisn', TRUE));
		$result = $this->User_Model->vote($nisn, $this->session->userdata('username'));
		$messages = array(
			'success' => array('success', 'Suaramu berhasil dicatat. Terima kasih telah berpartisipasi.'),
			'already_voted' => array('error', 'Akun ini sudah memberikan suara.'),
			'closed' => array('error', 'Pemungutan suara tidak sedang dibuka.'),
			'invalid_candidate' => array('error', 'Kandidat yang dipilih tidak ditemukan.'),
			'invalid_voter' => array('error', 'Akun pemilih tidak lagi aktif.'),
			'error' => array('error', 'Suara gagal disimpan. Silakan coba kembali atau hubungi panitia.')
		);
		$message = isset($messages[$result]) ? $messages[$result] : $messages['error'];
		$this->session->set_flashdata($message[0], $message[1]);
		redirect('user/index');
	}

	public function viewlogout()
	{
		redirect('user/index');
	}

	public function change_password()
	{
		if ($this->session->userdata('role') !== 'voter') {
			redirect('user/login');
		}
		$this->load->view('user/change_password', array(
			'required' => $this->User_Model->must_change_password($this->session->userdata('username'))
		));
	}

	public function update_password()
	{
		if (strtoupper($this->input->method(TRUE)) !== 'POST') {
			show_error('This action requires a POST request.', 405);
		}
		if ($this->session->userdata('role') !== 'voter') {
			redirect('user/login');
		}
		$current = (string) $this->input->post('current_password');
		$new_password = (string) $this->input->post('new_password');
		$confirmed = (string) $this->input->post('confirm_password');
		if (strlen($new_password) < 12 || !hash_equals($new_password, $confirmed)) {
			$this->session->set_flashdata('error', 'Gunakan password baru minimal 12 karakter dan pastikan konfirmasi sama.');
			redirect('user/change_password');
		}
		$updated = $this->User_Model->change_password(
			$this->session->userdata('username'),
			$current,
			$new_password
		);
		if (!$updated) {
			$this->session->set_flashdata('error', 'Password saat ini tidak sesuai atau password baru tidak valid.');
			redirect('user/change_password');
		}
		$this->session->set_userdata('wajib_ganti_password', FALSE);
		$this->session->set_flashdata('success', 'Password berhasil diperbarui.');
		redirect('user/index');
	}
}

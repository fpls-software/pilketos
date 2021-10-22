<?php 
Class User extends CI_Controller {
	public function __construct() 
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('form','url'));
		$this->load->library(array('session'));
		$this->load->model(array('User_Model'));
	}
	public function login() {
		if($this->session->userdata('username'))
		{
			redirect('user/index');
		}
		$this->load->view('user/head');
		$this->load->view('user/login');
		$this->load->view('user/footer');
	}
	public function loginvalidation() {
		$username				= $this->input->post('username', TRUE);
		$password				= $this->input->post('password', TRUE);
		$result					= $this->User_Model->login($username, $password);
		$valid					= $this->User_Model->valid($username);
		if($valid == true) {
			$this->session->set_flashdata('block', 'Anda Sudah Pernah Melakukan Voting, Akun Anda Sekarang Dinonaktifkan, Jika anda merasa belum pernah Melakukan Voting Sebelumnya, Silahkan hubungi pengurus Untuk Mengaktifkan Akun anda');
			redirect('user/login');
		}
		else {
			if($result == true) {
				$this->session->set_userdata(array(
					'username'	=> $username
				));
				redirect('user/index');
			}
			else
			{
				$this->session->set_flashdata('failed', 'Username atau Password Salah');
				redirect('user/login');
			}
		}
	}
	public function logout()
	{
		$this->session->unset_userdata('username');
		redirect('user/login');
	}
	public function index() {
		if(! $this->session->userdata('username'))
		{
			redirect('user/login');
		}
		$user				= $_SESSION['username'];
		$data['username']	= $user;
		$data['datacalon']	= $this->User_Model->datamodel();
		$this->load->view('user/head');
		$this->load->view('user/navbar');
		$this->load->view('user/index', $data);
		$this->load->view('user/footer');
	}
	public function vote() {
		$nisn		= $this->input->post('nisn');
		$username	= $this->input->post('username');
		$vote		= $this->User_Model->vote($nisn, $username);
		$hadir		= $this->User_Model->hadir($username);
		if($vote = true) {
			redirect('user/viewlogout');
		}
	}
	public function viewlogout() {
		$this->load->view('user/head');
		$this->load->view('user/navbar');
		$this->load->view('user/viewlogout');
		$this->load->view('user/footer');
	}
}
?>
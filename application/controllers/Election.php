<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Election extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url', 'form'));
		$this->load->model('Election_Model');
		$this->load->library('session');
	}

	public function index()
	{
		$election = $this->Election_Model->election();
		$username = $this->session->userdata('role') === 'voter'
			? $this->session->userdata('username')
			: NULL;
		$data = array(
			'election' => $election,
			'school' => $this->Election_Model->school(),
			'candidates' => $this->Election_Model->candidates(),
			'results' => $this->Election_Model->results(),
			'votes' => $this->Election_Model->vote_count(),
			'is_voter' => $username !== NULL,
			'has_voted' => $username !== NULL && $this->Election_Model->has_voted($username),
			'can_vote' => $election
				&& $election['status'] === 'open'
				&& (empty($election['mulai']) || strtotime($election['mulai']) <= time())
				&& (empty($election['selesai']) || strtotime($election['selesai']) >= time())
		);

		$this->load->view('public/election', $data);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->input->is_cli_request()) {
			show_error('This command can only be run from the command line.', 403);
		}
		$this->load->library('migration');
	}

	public function current()
	{
		if ($this->migration->current() === FALSE) {
			show_error($this->migration->error_string(), 500);
		}
		echo "Database migrations completed.\n";
	}
}

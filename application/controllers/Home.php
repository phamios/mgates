<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->helper('slug');
		// $this->output->cache(2);
	}


	public function index()
	{
		$this->load->view('home');
	}
}

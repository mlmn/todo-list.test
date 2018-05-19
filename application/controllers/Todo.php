<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('logined') != true) {
			redirect('/user/login');
		} else {
			$this->user = $this->users->getUserByUsername($this->session->userdata('username'));
		}
	}

	public function index()	{

		$this->load->view('header');
		$this->load->view('hello_logout');

		$this->load->view('my_lists');
		$this->load->view('footer');
	}
}

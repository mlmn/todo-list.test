<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function register() {
		$this->form_validation->set_error_delimiters('<div class="registration-error">', '</div><hr>');
		$this->form_validation->set_rules(
			'login', 'Логин',
			'required|min_length[3]|max_length[12]|is_unique[users.username]|callback_userDataCheck',
			array(
				'required'      			=> 'Поле %s обязательно.',
				'is_unique'     			=> 'Этот логин уже занят.',
				'min_length'    			=> 'Длина логина от 3 до 12 символов.',
				'max_length'    			=> 'Длина логина от 3 до 12 символов.',
				'userDataCheck'				=> 'Допустимые символы логина: A-Z a-z 0-9 _',
			)
		);
		$this->form_validation->set_rules(
			'password', 'Пароль',
			'required|min_length[6]|max_length[20]|callback_userDataCheck',
			array(
				'required'      	=> 'Поле %s обязательно.',			
				'min_length'    	=> 'Длина пароля от 6 до 20 символов.',
				'max_length'    	=> 'Длина пароля от 6 до 20 символов.',
				'userDataCheck'		=> 'Допустимые символы пароля: A-Z a-z 0-9 _',
			)
		);

		if ($this->form_validation->run() == true) {
			$this->users->addUser($this->input->post());
			redirect('/todo/');	
		}

		$this->load->view('header');
		$this->load->view('registration');
		$this->load->view('footer');
	}

	public function login() {
		$this->form_validation->set_error_delimiters('<div class="login-error">', '</div>');
		$this->form_validation->set_rules('login', 'login', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');

		if ($this->form_validation->run() == true) {

			$userData['login'] = $this->input->post('login');
			$userData['password'] = $this->input->post('password');
			if ($this->user = $this->users->checkUser($userData)) {
				$this->session->set_userdata('logined', true);
				$this->session->set_userdata('username', $userData['login']);
				redirect('/todo/');
			} else {
				$this->loginError = true;
			}
		}
		$this->load->view('header');
		$this->load->view('login_register');
		$this->load->view('welcome');
		$this->load->view('footer');
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('/todo/');
	}


	public function userDataCheck($str) {
		if(preg_match('/^[\w]+$/', $str)) {
			return true;
		} else {
			return false;
		}
	}

}


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
			'required|min_length[3]|max_length[12]|is_unique[users.username]|regex_match[/^[\w]+$/]',
			array(
				'required'      			=> 'Поле %s обязательно.',
				'is_unique'     			=> 'Этот логин уже занят.',
				'min_length'    			=> 'Длина логина от 3 до 12 символов.',
				'max_length'    			=> 'Длина логина от 3 до 12 символов.',
				'regex_match'				=> 'Допустимые символы логина: A-Z a-z 0-9 _',
			)
		);
		$this->form_validation->set_rules(
			'password', 'Пароль',
			'required|min_length[6]|max_length[20]|regex_match[/^[\w]+$/]',
			array(
				'required'      	=> 'Поле %s обязательно.',			
				'min_length'    	=> 'Длина пароля от 6 до 20 символов.',
				'max_length'    	=> 'Длина пароля от 6 до 20 символов.',
				'regex_match'		=> 'Допустимые символы пароля: A-Z a-z 0-9 _',
			)
		);

		if ($this->form_validation->run() == true) {
			$inputData = $this->input->post();
			$userData['username'] = $inputData['login'];
			$userData['hash'] = $this->common->hashPass($inputData['password']);
			//cd($inputData);
			$this->common->addItem('users', $userData);
			redirect('/todo/');	
		}

		$this->load->view('header');
		$this->load->view('registration');
		$this->load->view('footer');
	}

	public function login() {
		$this->form_validation->set_error_delimiters('<div class="login-error">', '</div>');
		$this->form_validation->set_rules('login', 'login', 'required|regex_match[/^[\w]+$/]');
		$this->form_validation->set_rules('password', 'password', 'required');

		if ($this->form_validation->run() == true) {

			$userData['username'] = $this->input->post('login');
			$userData['hash'] = $this->common->hashPass($this->input->post('password'));

			if ($this->user = $this->common->getItem('users', $userData)) {
				$this->session->set_userdata('logined', true);
				$this->session->set_userdata('user', $this->user);
				redirect('/todo/');
			} else {
				$this->loginError = true;
			}
		}
		$this->load->view('header');
		$this->load->view('loginNav');
		$this->load->view('welcome');
		$this->load->view('footer');
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('/todo/');
	}


}


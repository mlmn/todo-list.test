<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->output->enable_profiler(TRUE);
		if ($this->session->userdata('logined') != true) {
			redirect('/user/login');
		} else {
			$this->user = $this->common->getItem('users', ['username' => $this->session->userdata('username')]);
		}
	}

	public function index()	{

		$this->form_validation->set_error_delimiters('<div class="list-error">', '</div><hr>');
		$this->form_validation->set_rules(
			'newList', 'Название списка',
			'required|min_length[3]|max_length[120]|regex_match[/^[\w\s\.а-яёА-ЯЁ]+$/u]',
			array(
				'required'      			=> 'Поле %s обязательно.',
				'min_length'    			=> 'Длина названия от 3 до 120 символов.',
				'max_length'    			=> 'Длина названия от 3 до 120 символов.',
				'regex_match'				=> 'Недопустимые символы в названии',
			)
		);


		if ($this->form_validation->run() == true) {
			$listData['list_name'] = $this->input->post('newList');
			$listData['user_id'] = $this->user['id'];
			$this->common->addItem('lists', $listData);
		}


		$viewData['lists'] = $this->common->getItems('lists', ['user_id' => $this->user['id'], 'del' => 0]);

		$this->load->view('header');
		$this->load->view('logoutNav');
		$this->load->view('myLists', $viewData);
		$this->load->view('footer');
	}

	public function list(int $id) {
		$viewData['list'] = $this->common->getItems('list_items', ['list_id' => $id]);
		cd($viewData);
	}

	public function deleteList(int $id) {
		if ($listToDelete = $this->common->getItem('lists', ['id' => $id, 'user_id' => $this->user['id']])) {
			$this->common->updateItem('lists', ['id' => $id], ['del' => 1]);			
		}
		redirect('/');
	}

}

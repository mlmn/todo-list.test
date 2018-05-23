<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		if ($this->session->userdata('logined') != true) {
			redirect('/user/login');
		} else {
			$this->user = $this->session->userdata('user');
			//cd($this->user);
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
			$newListId = $this->common->addItem('lists', $listData);
			redirect('/todo/list/' . $newListId);
		}


		$viewData['lists'] = $this->common->getItems('lists', ['user_id' => $this->user['id'], 'del' => 0]);

		$this->load->view('header');
		$this->load->view('logoutNav');
		$this->load->view('myLists', $viewData);
		$this->load->view('footer');
	}

	public function list($id) {
		$viewData['list'] =  $this->common->getItem('lists', ['id' => (int)$id]);
		if ($viewData['list']['user_id'] != $this->user['id']) {
			redirect('/todo');
			//пока так не пускаю в чужие списки
		}
		//cd($viewData['list']);

		if ($post = $this->input->post()) {
			//cd($post);
			if ($post['requestType'] == "newItem") {
				//если хотим добавить новый элемент в список
				//cd($post);
				if (!empty($post['itemText'])) {
					//если новый элемент списка в запросе не пустой
					$insertData = ['list_id' => $post['listId'], 'text' => $post['itemText']];
					$this->common->addItem('items', $insertData);
				}

			} elseif ($post['requestType'] == "updateItem") {
				//редактирование существующего элемента списка
				if (!empty($post['itemText'])) {
					//если новый элемент списка в запросе не пустой
					$selectors = ['list_id' => $post['listId'], 'id' => $post['itemId']];
					$updadeData = ['text' => $post['itemText']];
					$this->common->updateItem('items', $selectors, $updadeData);
				}
			} elseif ($post['requestType'] == "addImage") {
				//добавление или замена картинки к элементу списка

			} elseif ($post['requestType'] == "deleteIimage") {
				//удаление картинки

			}


			$items = $this->common->getItems('items', ['list_id' => (int)$id]);
			//cd($listItems);	
			$responce = [
				'sucsess' => true, 
				'items' => $items,
			];

			$json = json_encode($responce);
			echo($json);
			exit;

		}

		$this->load->view('header');
		$this->load->view('logoutNav');
		$this->load->view('listItems', $viewData);
		$this->load->view('footer');
	}

	public function deleteList($id) {
		if ($listToDelete = $this->common->getItem('lists', ['id' => (int)$id, 'user_id' => $this->user['id']])) {
			$this->common->updateItem('lists', ['id' => $id], ['del' => 1]);			
		}
		redirect('/');
	}



}

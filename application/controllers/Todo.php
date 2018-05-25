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
		}
	}

	public function test() {
		$id = 27;
		$items = $this->common->getFullItems($id);
		cd($items);
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
		$this->load->view('header');
		$this->load->view('logoutNav');
		$this->load->view('listItems', $viewData);
		$this->load->view('footer');
	}

	public function ajax() {
		if ($post = $this->input->post()) {
			if (!empty($post['itemText'])) {
				if ($post['requestType'] == "newItem") {
					//если хотим добавить новый элемент в список
					$insertData = ['list_id' => $post['listId'], 'text' => $post['itemText']];
					$this->common->addItem('items', $insertData);

				} elseif ($post['requestType'] == "updateItem") {
					//редактирование существующего элемента списка
					$updadeData = [];

					//работа с тeгами
					if(!empty($post['itemTags'])) {
						$newTags = explode(" ", $post['itemTags']);						
						//решаем вопрос дублирования тагов ценой 1 доп запроса в базу
						$existingTagsToItems = $this->common->getItems('tags_to_items', ['item_id' => $post['itemId']]);
						$func = function(array $tagToItem) {
							return $tagToItem['tag_id'];
						};
						$eixstingTags = array_map($func, $existingTagsToItems);

						foreach($newTags as $tagName) {
							if(!empty($tagName)) {
								$tagId = $this->common->addTag($tagName);
								if(!in_array($tagId, $eixstingTags)) {
									$insertData = ['item_id' => $post['itemId'], 'tag_id' => $tagId];
									$this->common->addItem('tags_to_items', $insertData);
								}

							}
						}
					}					
					//работа с тегами

					//аплоад файла начало
					$config['file_name']            = md5(mt_rand(1000, 100000)); 
					$config['upload_path']          = './uploads/';
					$config['allowed_types']        = 'gif|jpg|png';
					$this->load->library('upload', $config);
					if ($this->upload->do_upload('fileUpload')) {
						$data = $this->upload->data();
						$updadeData['image_name'] = $data['raw_name'];
						$updadeData['image_ext'] = $data['file_ext'];				
					}
					//аплоад файла конец
					if (!empty($post['itemText'])) {
						$updadeData['text'] = $post['itemText'];
					}

					$selectors = ['list_id' => $post['listId'], 'id' => $post['itemId']];

					$this->common->updateItem('items', $selectors, $updadeData);
				} 
			}



			$items = $this->common->getFullItems($post['listId']);
			//cd($listItems);	
			$responce = [
				'sucsess' => true, 
				'items' => $items,
			];

			$json = json_encode($responce);
			echo($json);
			exit;

		}
	}

	public function deleteList($id) {
		if ($listToDelete = $this->common->getItem('lists', ['id' => (int)$id, 'user_id' => $this->user['id']])) {
			$this->common->updateItem('lists', ['id' => $id], ['del' => 1]);			
		}
		redirect('/');
	}



}

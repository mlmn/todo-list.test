<?

class Common extends CI_Model {

	public function getItem(string $table, array $selectors) {
		$this->db->select('*');
		$this->db->from($table);
		foreach ($selectors as $column => $match) {
			$this->db->where($column, $this->db->escape_str($match));
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return false;
		}
	}

	public function getItems(string $table, array $selectors) {
		$this->db->select('*');
		$this->db->from($table);
		foreach ($selectors as $column => $match) {
			$this->db->where($column, $this->db->escape_str($match));
		}
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}
	}

	public function addItem(string $table, array $data) {
		$insertData=[];
		foreach ($data as $col => $value) {
			$insertData[$col] = $this->db->escape_str($value);
		}
		$this->db->insert($table, $insertData);
		return $this->db->insert_id();
	}

	public function addItems(string $table, array $data) {

	}

	public function updateItem(string $table, array $selectors, array $data) {
		$updateData=[];
		foreach ($data as $col => $value) {
			$updateData[$col] = $this->db->escape_str($value);
		}
		foreach ($selectors as $column => $match) {
			$this->db->where($column, $this->db->escape_str($match));
		}
		$this->db->update($table, $updateData);
		//cd($this->db->last_query());
	}


	public function getFullItemsDepr1(int $listId) {
		$sql =  "

				SELECT `itm`.*, GROUP_CONCAT(tag.tag_name) AS item_tags
				FROM (
					SELECT `items`.*, `img`.`image_name`, `img`.`image_ext`
					FROM `items`
					LEFT JOIN `images` `img` ON `img`.`item_id` = `items`.`id`
				) `itm` 

				LEFT JOIN `tags_to_items` `ttm` ON `itm`.`id` = `ttm`.`item_id`
				LEFT JOIN `tags` `tag` ON `ttm`.`tag_id` = `tag`.`id`
				WHERE `itm`.`list_id` = " . $this->db->escape($listId) .
				" GROUP BY `itm`.`id`
				";
				//cd($sql);
				//сдался, нет времени, картинки лежали в отдельной таблице, джойнить вместе с GROUP_BY нельзя, не осилил обойти подзапросом.

		$query = $this->db->query($sql);
		//cd($this->db->last_query());
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}
	}
	public function getFullItemsDepr2(int $listId) {
		$this->db->select('itm.*, img.image_name, img.image_ext');
		$this->db->from('items itm');
		$this->db->join('images img', 'img.item_id = itm.id', 'left');		
		$this->db->where('itm.list_id', $this->db->escape_str($listId));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}
	}
	public function getFullItems(int $listId) {
		$this->db->select('itm.*, GROUP_CONCAT(tag.tag_name) AS item_tags');
		$this->db->from('items itm');
		$this->db->join('tags_to_items ttm', 'itm.id = ttm.item_id', 'left');
		$this->db->join('tags tag', 'ttm.tag_id = tag.id', 'left');
		$this->db->group_by('itm.id');
		$this->db->where('itm.list_id', $this->db->escape_str($listId));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}
	}


	public function addTagDepr(string $tag) {
		//пока не работает как надо
		$sql = $this->db->insert_string('tags', ['tag_name' => $tag]) . ' ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id), `tag_name`='. "'" . $tag. "';";
		$this->db->query($sql);
		return $this->db->insert_id();
	}

	public function addTag(string $tagName) {
		if ($tag = $this->getItem('tags', ['tag_name' => $tagName])) {
			//если тег уже есть - вернуть id
			return $tag['id'];
		} else {
			//если еще нету, то добавить его и вернуть id
			$tagId = $this->addItem('tags', ['tag_name' => $tagName]);
			return $tagId;
		}
	}


	public function hashPass(string $password) {
		return hash('sha256', $password);		
	}

}
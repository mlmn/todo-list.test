<?

class Lists extends CI_Model {
	public function newList(string $insertData) {
		$insertData['list_name'] = $this->db->escape_str($insertData['list_name']);
		$this->db->insert('lists', $insertData);
	}

}

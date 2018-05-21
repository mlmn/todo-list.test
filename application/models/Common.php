<?

class Common extends CI_Model {

	public function getItem(string $table, array $selectors) {
		$this->db->select('*');
		$this->db->from($table);
		foreach ($selectors as $column => $match) {
			$this->db->where($column, $this->db->escape_str($match));
		}
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
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
			return false;
		}
	}

	public function addItem(string $table, array $data) {
		$insertData=[];
		foreach ($data as $col => $value) {
			$insertData[$col] = $this->db->escape_str($value);
		}
		$this->db->insert($table, $insertData);
	}

	public function updateItem(string $table, array $selectors, array $data) {
		foreach ($data as $col => $value) {
			$updateData[$col] = $this->db->escape_str($value);
		}
		foreach ($selectors as $column => $match) {
			$this->db->where($column, $this->db->escape_str($match));
		}
		$this->db->update($table, $updateData);
	}

	public function hashPass(string $password) {
		return hash('sha256', $password);		
	}
}
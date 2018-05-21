<?

class Common extends CI_Model {

	public function getItem($table, array $selectors) {
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

	public function getItems($table, array $selectors) {
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

	public function addItem($table, $data) {
		$insertData=[];
		foreach ($data as $col => $value) {
			$insertData[$col] = $this->db->escape_str($value);
		}
		$this->db->insert($table, $insertData);
	}

	public function hashPass($password) {
		return hash('sha256', $password);		
	}
}
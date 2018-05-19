<?

class Users extends CI_Model {

	public function addUser(array $userData) {
		$insertData['username'] = $this->db->escape_str($userData['login']);
		$insertData['hash'] = $this->hashPass($userData['password']);
		$this->db->insert('users', $insertData);
	}

	public function checkUser($userData) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('username', $userData['login']);
		$this->db->where('hash', $this->hashPass($userData['password']));
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$result = $query->result_array();
			return reset($result);
		} else {
			return false;
		}
	}

	public function getUserByUsername($username) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('username', $username);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$result = $query->result_array();
			return reset($result);
		} else {
			return false;
		}
	}

	public function hashPass($password) {
		return hash('sha256', $password);		
	}

}

<?php defined('SYSPATH') OR die('No direct access allowed.');

class Logs_Model extends Model {

	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}
	
	public function add($data){
		$sql = $this->db
				->insert("users", $data);
		return $sql->insert_id();
	}

	public function add_address($data){
		$sql = $this->db
				->insert("user_address", $data);
		return $sql->insert_id();
	}
	
	public function edit($user_id, $data){
		$sql = $this->db
				->where("user_id", $user_id)
				->update("users", $data);
	}
	
	public function delete($user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->delete("users");
	}
	
	public function get_one($user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->get("users");
		return $sql->current();
	}
	
	public function get_all(){
		$sql = $this->db
				->orderby("lastname", "ASC")
				->get("users");
		return $sql;
	}
	
	public function check_username($username){
		$sql = $this->db
				->where("email", $username)
				->get("users");
		return $sql;
	}

	public function get_password($username){
		$sql = $this->db
				->where("email", $username)
				->get("users");
		return $sql;
	}
	
	public function process_login($username, $password){
		$sql = $this->db
				->where("email", $username)
				->where("password", $password)
				->get("users");
		return $sql;
	}
	
}

?>
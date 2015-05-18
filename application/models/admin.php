<?php defined('SYSPATH') OR die('No direct access allowed.');

class Admin_Model extends Model {

	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}
	
	public function add($data){
		$sql = $this->db
				->insert("admin", $data);
		return $sql->insert_id();
	}
	
	public function edit($admin_id, $data){
		$sql = $this->db
				->where("id", $admin_id)
				->update("admin", $data);
	}
	
	public function delete($admin_id){
		$sql = $this->db
				->where("id", $admin_id)
				->delete("admin");
	}
	
	public function get_one($admin_id){
		$sql = $this->db
				->where("id", $admin_id)
				->get("admin");
		return $sql->current();
	}
	
	public function get_all(){
		$sql = $this->db
				->orderby("lastname", "ASC")
				->get("admin");
		return $sql;
	}
	
	public function check_username($username){
		$sql = $this->db
				->where("username", $username)
				->get("admin");
		return $sql;
	}

	public function get_password($username){
		$sql = $this->db
				->where("username", $username)
				->get("admin");
		return $sql;
	}
	
	public function process_login($username, $password){
		$sql = $this->db
				->where("username", $username)
				->where("password", $password)
				->get("admin");
		return $sql;
	}
	
}

?>
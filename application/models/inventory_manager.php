<?php defined('SYSPATH') OR die('No direct access allowed.');

class Inventory_Manager_Model extends Model {

	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}
	
	// public function add($data){
	// 	$sql = $this->db
	// 			->insert("admin", $data);
	// 	return $sql->insert_id();
	// }
	
	public function edit($admin_id, $data){
		$sql = $this->db
				->where("id", $admin_id)
				->update("inventory_manager", $data);
	}
	
	// public function delete($admin_id){
	// 	$sql = $this->db
	// 			->where("id", $admin_id)
	// 			->delete("admin");
	// }
	
	public function get_one($id){
		$sql = $this->db
				->where("id", $id)
				->get("inventory_manager");
		return $sql->current();
	}
	
	// public function get_all(){
	// 	$sql = $this->db
	// 			->orderby("lastname", "ASC")
	// 			->get("admin");
	// 	return $sql;
	// }
	
	public function check_username($username){
		$sql = $this->db
				->where("username", $username)
				->get("inventory_manager");
		return $sql;
	}

	public function get_password($username){
		$sql = $this->db
				->where("username", $username)
				->get("inventory_manager");
		return $sql;
	}
	
	public function process_login($username, $password){
		$sql = $this->db
				->where("username", $username)
				->where("password", $password)
				->get("inventory_manager");
		return $sql;
	}
	
}

?>
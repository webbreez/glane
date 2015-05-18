<?php defined('SYSPATH') OR die('No direct access allowed.');

class Purchases_Model extends Model {

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
	
	public function edit($id, $data){
		$sql = $this->db
				->where("id", $id)
				->update("purchases", $data);
	}
	
	// public function delete($admin_id){
	// 	$sql = $this->db
	// 			->where("id", $admin_id)
	// 			->delete("admin");
	// }
	
	public function get_one($id){
		$sql = $this->db
				->where("id", $id)
				->get("purchases");
		return $sql->current();
	}
	
	// public function get_all(){
	// 	$sql = $this->db
	// 			->orderby("lastname", "ASC")
	// 			->get("admin");
	// 	return $sql;
	// }
	
}

?>
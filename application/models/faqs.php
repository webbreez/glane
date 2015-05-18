<?php defined('SYSPATH') OR die('No direct access allowed.');

class Faqs_Model extends Model {

	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}
	
	public function add($data){
		$sql = $this->db
				->insert("faqs", $data);
		return $sql->insert_id();
	}
	
	public function edit($id, $data){
		$sql = $this->db
				->where("id", $id)
				->update("faqs", $data);
	}
	
	public function delete($id){
		$sql = $this->db
				->where("id", $id)
				->delete("faqs");
	}
	
	public function get_one($id){
		$sql = $this->db
				->where("id", $id)
				->get("faqs");
		return $sql->current();
	}

	public function get_all(){
		$sql = $this->db
				->get("faqs");
		return $sql;
	}
}

?>
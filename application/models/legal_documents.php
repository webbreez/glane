<?php defined('SYSPATH') OR die('No direct access allowed.');

class Legal_Documents_Model extends Model {

	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}
	
	public function add($data){
		$sql = $this->db
				->insert("legal_documents", $data);
		return $sql->insert_id();
	}
	
	public function edit($id, $data){
		$sql = $this->db
				->where("legal_document_id", $id)
				->update("legal_documents", $data);
	}
	
	public function delete($id, $user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->where("legal_document_id", $id)
				->delete("legal_documents");
	}
	
	public function get_one($id, $user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->where("legal_document_id", $id)
				->get("legal_documents");
		return $sql->current();
	}

	public function get_member_doc($id){
		$sql = $this->db
				->where("legal_document_id", $id)
				->get("legal_documents");
		return $sql->current();
	}
	
	public function get_all($user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->orderby("date_created", "ASC")
				->get("legal_documents");
		return $sql;
	}
}

?>
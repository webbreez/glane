<?php defined('SYSPATH') OR die('No direct access allowed.');

class Users_Model extends Model {

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

	public function add_business_profile($data){
		$sql = $this->db
				->insert("user_business_profile", $data);
		return $sql->insert_id();
	}

	public function add_logs($data){
		$sql = $this->db
				->insert("user_logs", $data);
		return $sql->insert_id();
	}
	
	public function edit($user_id, $data){
		$sql = $this->db
				->where("user_id", $user_id)
				->update("users", $data);
	}

	public function edit_address($id, $data){
		$sql = $this->db
				->where("user_address_id", $id)
				->update("user_address", $data);
	}

	public function update_primary_address($user_id, $type, $data){
		$sql = $this->db
				->where("user_id", $user_id)
				//->where("user_address_type", $type)
				->update("user_address", $data);
	}
	
	public function delete($user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->delete("users");
	}

	public function delete_address($id){
		$sql = $this->db
				->where("user_address_id", $id)
				->delete("user_address");
	}
	
	public function get_one($user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->get("users");
		return $sql->current();
	}

	public function get_one_by_uniqid($uniqid){
		$sql = $this->db
				->where("uniqid", $uniqid)
				->get("users");
		return $sql;
	}

	public function get_address($id){
		$sql = $this->db
				->where("user_address_id", $id)
				->get("user_address");
		return $sql->current();
	}

	public function get_shipping_address($user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->get("user_address");
		return $sql;
	}

	public function get_primary_address($user_id){
		$sql = $this->db
				->where("user_address_primary", "Yes")
				->where("user_id", $user_id)
				->get("user_address");
		return $sql;
	}
	
	public function get_all(){
		$sql = $this->db
				->orderby("lastname", "ASC")
				->get("users");
		return $sql;
	}

	public function get_all_address($user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->get("user_address");
		return $sql;
	}
	
	public function check_username($username){
		$sql = $this->db
				->where("email", $username)
				->where("deleted", "N")
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
<?php defined('SYSPATH') OR die('No direct access allowed.');

class States_Model extends Model {

	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}
	
	public function get_all(){
		$sql = $this->db
				->orderby("state", "ASC")
				->get("states");
		return $sql;
	}
}

?>
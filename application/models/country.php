<?php defined('SYSPATH') OR die('No direct access allowed.');

class Country_Model extends Model {

	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}
	
	public function get_all(){
		$sql = $this->db
				->orderby("country_name", "ASC")
				->get("countries");
		return $sql;
	}
}

?>
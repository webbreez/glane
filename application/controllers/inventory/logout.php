<?php defined('SYSPATH') OR die('No direct access allowed.');

class Logout_Controller extends Template_Controller {

	public $template = 'outside_tpl';
	
	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}
	
	public function index(){
		$this->session->delete('manager_id');
		$this->session->delete('manager_name');
		url::redirect("inventory/index");
	}
}

?>
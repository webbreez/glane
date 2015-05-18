<?php defined('SYSPATH') OR die('No direct access allowed.');

class Logout_Controller extends Template_Controller {

	public $template = 'outside_tpl';
	
	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}
	
	public function index(){
		$this->session->delete('user_id');
		$this->session->delete('firstname');
		$this->session->delete('lastname');
		url::redirect("index/products");
	}
}

?>
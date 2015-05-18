<?php defined('SYSPATH') OR die('No direct access allowed.');

class Home_Controller extends Template_Controller {

	public $template = 'inventory_tpl';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();		
		//checking if user is logged in
		if(!$this->session->get('manager_id')){
			url::redirect("iventory/index");
		}
		//till here
	}

	public function index(){
		$this->template->content = new View("inventory/home/index");
	}
	
}
?>
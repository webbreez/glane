<?php defined('SYSPATH') OR die('No direct access allowed.');

class Inventory_Controller extends Template_Controller {

	public $template = 'inventory_login_tpl';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();
	}

	public function index(){
		url::redirect("inventory/index");
	}
	
}
?>
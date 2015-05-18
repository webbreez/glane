<?php defined('SYSPATH') OR die('No direct access allowed.');

class Access_Controller extends Template_Controller {

	public $template = 'admin_tpl';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();		
		//checking if user is logged in
		if(!$this->session->get('admin_id')){
			url::redirect("admin/index");
		}
		//till here
	}

	public function denied(){
		$this->template->content = new View("admin/access/denied");
	}

}
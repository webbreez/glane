<?php defined('SYSPATH') OR die('No direct access allowed.');

class Admin_Controller extends Template_Controller {

	public $template = 'admin_tpl';
	
	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
		$this->template->links = new View("admin/links/index");
		//checking if admin is logged in
		if(!$this->session->get('admin_id')){
			url::redirect("admin/index");
		}
		//till here
	}
	
	public function index(){
		$this->template->content = new View("admin/index");
		
		$admin_Model = new admin_Model;
		$admin = $admin_Model->get_one(1);
		$this->template->content->admin = $admin ;
		
		if($_POST)
		{
			$data = array(
				"username" => $this->input->post("username"),
				"password" => password_helper::encode5t($this->input->post("password"))
			);
			$admin_Model = new admin_Model;
			$admin = $admin_Model->edit(1, $data);
			url::redirect('admin/index/updated');
		}
	}
	
}
?>
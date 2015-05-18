<?php defined('SYSPATH') OR die('No direct access allowed.');

class Index_Controller extends Template_Controller {

	public $template = 'inventory_login_tpl';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();
	}

	public function index(){
		$this->template->content = new View("inventory/index");
		
		if ($_POST){
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$admin_model = new Inventory_Manager_Model;
			$admin = $admin_model->process_login($username, $password);
			$row_count = count($admin);
			if($row_count > 0){
				foreach($admin as $aa){
					$admin_id = $aa->admin_id;
					$admin_name = $aa->firstname.' '.$aa->lastname;
				}

				$this->session->set('admin_id', $admin_id);
				$this->session->set('admin_name', $admin_name);
				url::redirect("inventory/home/index");
			}else{
				url::redirect("inventory/error/index");
			}
		}
	}

	public function check(){

		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$username = $this->input->post("username");
			$password = base64_encode($this->input->post("password"));

			//get the enctrypted password
			$admin_model = new Inventory_Manager_Model;
			$check = $admin_model->process_login($username, $password);
			$count = count($check);
			if($count != 0)
			{
				$row = $check->current();

				$this->session->set('manager_id', $row->id);
				$this->session->set('manager_name', $row->firstname.' '.$row->lastname);
				echo json_encode(TRUE);
			}else{
				echo json_encode(FALSE);
			}
		}
	}
	
}
?>
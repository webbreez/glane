<?php defined('SYSPATH') OR die('No direct access allowed.');

class Settings_Controller extends Template_Controller {

	public $template = 'inventory_tpl';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();		
		//checking if user is logged in
		if(!$this->session->get('manager_id')){
			url::redirect("inventory/index");
		}
		//till here
	}

	public function index(){
		$this->template->content = new View("inventory/settings/index");

		$admin_id = $this->session->get('manager_id');

		$admin_model = new Inventory_Manager_Model;
		$admin = $admin_model->get_one($admin_id);
		$this->template->content->admin = $admin;
	}

	public function save()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$admin_id = $this->session->get('manager_id');

			$admin_model = new Inventory_Manager_Model;
			$admin = $admin_model->get_one($admin_id);

			$password = $admin->password;
			$current_password = base64_encode($this->input->post('passw'));
			$new_passw = base64_encode($this->input->post('new_passw'));
			$confirm_passw = base64_encode($this->input->post('confirm_passw'));

			if($password != $current_password)
			{
				echo json_encode(array("msg"=>"Your password is incorrect."));
				exit;
			}elseif($new_passw != $confirm_passw)
			{
				echo json_encode(array("msg"=>"Your new password did not match."));
				exit;
			}else{
				$password = base64_encode($this->input->post('new_passw'));
				$firstname = $this->input->post('firstname');
				$lastname = $this->input->post('lastname');

				$data = array(
					"firstname" => $firstname,
					"lastname" => $lastname,
					"password" => $password
				);
				$admin_model->edit($admin_id, $data);

				echo json_encode(array("msg"=>"Profile Updated."));
				exit;
			}
		}
	}
	
}
?>
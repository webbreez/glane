<?php defined('SYSPATH') OR die('No direct access allowed.');

class Register_Controller extends Template_Controller {

	public $template = 'admin_tpl';
	
	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
		//checking if admin is logged in
		if(!$this->session->get('admin_id')){
			url::redirect("admin/index");
		}
		//till here
	}
	
	public function add(){
		$this->template->content = new View("admin/register/add");
	}

	public function check(){

		if (request::is_ajax()){
			$this->auto_render = FALSE;
			$user_model = new User_Model;

			//check if username already exists
			$username = $this->input->post("email");
			$check_username = $user_model->check_username($username);
			$count_username = count($check_username);
			if($count_username != 0)
			{
				$result = array("success"=>"N", "message"=>"Username already in use.");
				echo json_encode($result);
				exit;
			}

			$this->encrypt = new Encrypt;
			$encrypted_password = $this->encrypt->encode($this->input->post("password"));
			$firstname = $this->input->post("firstname");
			$lastname = $this->input->post("lastname");

			$data = array(
				"email" => $username,
				"password" => $encrypted_password,
				"firstname" => $firstname,
				"lastname" => $lastname
			);
			$user_model->add($data);
			$result = array("success"=>"Y", "message"=>"Done...");
			echo json_encode($result);
			exit;
		}

	}
	
}
?>
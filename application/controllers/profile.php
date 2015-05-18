<?php defined('SYSPATH') OR die('No direct access allowed.');

class Profile_Controller extends Template_Controller {

	public $template = 'inside_tpl2';

	public function __construct()
	{
		parent::__construct();

		$this->session = Session::instance();	

		//checking if user is logged in
		if(!$this->session->get('user_id')){
			url::redirect("index");
		}

		$products_model = new products_Model;
		$category_1 = $products_model->get_category_1();

		$this->template->category_1 = $category_1;	

		$featured_products = $products_model->get_featured_products();
		$this->template->featured_products = $featured_products;
	}

	public function index(){
		$this->template->content = new View("profile/index");

		$user_id = $this->session->get('user_id');

		$users_model = new users_Model;
		$user = $users_model->get_one($user_id);
		$this->template->content->user = $user;
	}

	public function check_username()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$email = $this->input->post("email");
			$current_email = $this->input->post("current_email");

			$users_model = new users_Model;

			if($email != $current_email)
			{
				$check_username = $users_model->check_username($email);
				$count = count($check_username);
				if($count == 0)
				{
					$row = $check_username->current();
					$user_id = $row->user_id;
					$password = base64_encode($this->input->post("passw"));
					$firstname = $this->input->post("firstname");
					$lastname = $this->input->post("lastname");

					$this->session->set('firstname', $firstname);
					$this->session->set('lastname', $lastname);

					$data = array(
						"email" => $email,
						"password" => $password,
						"firstname" => $firstname,
						"lastname" => $lastname
					);
					$users_model->edit($user_id, $data);
					echo json_encode(array("success"=>"Y"));
				}else{
					echo json_encode(array("success"=>"N"));
				}
			}else{
				$check_username = $users_model->check_username($email);
				$count = count($check_username);
				if($count != 0)
				{
					$row = $check_username->current();
					$user_id = $row->user_id;
					$password = base64_encode($this->input->post("passw"));
					$firstname = $this->input->post("firstname");
					$lastname = $this->input->post("lastname");

					$this->session->set('firstname', $firstname);
					$this->session->set('lastname', $lastname);

					$data = array(
						"password" => $password,
						"firstname" => $firstname,
						"lastname" => $lastname
					);
					$users_model->edit($user_id, $data);
					echo json_encode(array("success"=>"Y"));
				}else{
					echo json_encode(array("success"=>"N"));
				}
			}
		}
	}
}
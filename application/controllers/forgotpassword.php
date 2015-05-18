<?php defined('SYSPATH') OR die('No direct access allowed.');

class Forgotpassword_Controller extends Template_Controller {

	public $template = 'index_tpl2';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();

		$products_model = new products_Model;
		$category_1 = $products_model->get_category_1();

		$this->template->category_1 = $category_1;

		$featured_products = $products_model->get_featured_products();
		$this->template->featured_products = $featured_products;
	}

	public function index(){
		$this->template->content = new View("login/forgotpassword");
	}

	public function forgotpassword(){
		$this->template->content = new View("login/forgotpassword");

		if($_POST)
		{

		}
	}

	public function check(){

		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$username = $this->input->post("username");
			$password = base64_encode($this->input->post("password"));

			//get the enctrypted password
			$users_model = new Users_Model;
			$user = $users_model->process_login($username, $password);
			$count = count($user);

			if($count != 0)
			{
				$row = $user->current();
				$this->session->set('user_id', $row->user_id);
				$this->session->set('firstname', $row->firstname);
				$this->session->set('lastname', $row->lastname);
				echo json_encode(TRUE);
			}else{
				echo json_encode(FALSE);
			}
		}
	}

	public function check_forgotpassword(){

		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$email = $this->input->post("email");

			//get the enctrypted password
			$users_model = new Users_Model;
			$user = $users_model->check_username($email);
			$count = count($user);

			if($count != 0)
			{
				$row = $user->current();
				$password = base64_decode($row->password);

				$to = $email;
				$from = "webmaster@logiclane.com";
				$subject = 'Your LogicLane Password';
				$message = "Your LogicLane password is $password";
				email::send($to, $from, $subject, nl2br($message), TRUE);

				echo json_encode(TRUE);
			}else{
				echo json_encode(FALSE);
			}
		}
	}
	
}
?>
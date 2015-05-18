<?php defined('SYSPATH') OR die('No direct access allowed.');

class Members_Controller extends Template_Controller {

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

	public function index(){
		$this->template->content = new View("admin/members/index");
	}

	public function add(){
		$this->template->content = new View("admin/members/add");
	}

	public function pending(){
		$this->template->content = new View("admin/members/pending");
	}

	public function approve($id){
		$this->template->content = new View("admin/members/approve");

		$users_model = new users_Model;
		$member = $users_model->get_one($id);

		$this->template->content->member = $member;

		if($_POST)
		{
			$type = $this->input->post("type");
			$email = $this->input->post("email");
			$firstname = $this->input->post("firstname");
			$lastname = $this->input->post("lastname");
			$message = $this->input->post("message");

			$data = array(
				"type" => $type,
				"user_status" => "1"
			);

			$users_model->edit($id, $data);

			//send email

			$to = $email;
			$from = "webmaster@logiclane.com";
			$subject = 'Your Application has been approved';
			email::send($to, $from, $subject, nl2br($message), TRUE);

			url::redirect("admin/members/pending");
		}
	}

	public function decline($id){
		$this->template->content = new View("admin/members/decline");

		$users_model = new users_Model;
		$member = $users_model->get_one($id);

		$this->template->content->member = $member;

		if($_POST)
		{
			$email = $this->input->post("email");
			$firstname = $this->input->post("firstname");
			$lastname = $this->input->post("lastname");
			$message = $this->input->post("message");

			$data = array(
				"user_status" => "0"
			);

			$users_model->edit($id, $data);

			//send email

			$to = $email;
			$from = "webmaster@logiclane.com";
			$subject = 'Your Application has been declined';
			email::send($to, $from, $subject, nl2br($message), TRUE);

			url::redirect("admin/members/pending");
		}
	}

	public function edit($id){
		$this->template->content = new View("admin/members/edit");

		if($this->session->get('edit_member') == "N")
		{
			url::redirect("admin/access/denied");
			exit;
		}

		$users_model = new users_Model;
		$member = $users_model->get_one($id);

		$this->template->content->member = $member;

		if($_POST)
		{
			$firstname = $this->input->post("firstname");
			$lastname = $this->input->post("lastname");
			$password = base64_encode($this->input->post("password"));
			$user_status = $this->input->post("user_status");
			$type = $this->input->post("type");

			$data = array(
				"firstname" => $firstname,
				"lastname" => $lastname,
				"password" => $password,
				"type" => $type
			);

			$users_model->edit($id, $data);
			url::redirect("admin/members/index");
		}
	}

	public function delete()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			if($this->session->get('delete_member') == "N")
			{
				url::redirect("admin/access/denied");
				exit;
			}

			$this->session = Session::instance();
			$id = $this->input->post("id", null, true);
			$users_model = new users_Model;
			$data = array("deleted"=>"Y");
			$users_model->edit($id, $data);	
		}	
	}

}
?>
<?php defined('SYSPATH') OR die('No direct access allowed.');

class Admins_Controller extends Template_Controller {

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
		$this->template->content = new View("admin/admins/index");

		if($this->session->get('super_admin') == "Y")
		{

			$admin_id = $this->session->get('admin_id');

			$admin_model = new admin_Model;
			$admin = $admin_model->get_one($admin_id);
			$this->template->content->admin = $admin;
		}else{
			url::redirect("admin/home");
		}
	}

	public function add(){
		$this->template->content = new View("admin/admins/add");

		if($this->session->get('super_admin') == "Y")
		{
			$admin_id = $this->session->get('admin_id');

			$admin_model = new admin_Model;
			$admin = $admin_model->get_one($admin_id);
			$this->template->content->admin = $admin;
		}else{
			url::redirect("admin/home");
		}
	}

	public function save()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$admin_id = $this->session->get('admin_id');

			$admin_model = new admin_Model;

			$username = $this->input->post("username");
			$check = $admin_model->check_username($username);
			$count = count($check);
			if($count >= 1)
			{
				echo json_encode(array("success"=>"N"));
				exit;
			}else{
				$password = base64_encode($this->input->post('passw'));
				$firstname = $this->input->post('firstname');
				$lastname = $this->input->post('lastname');
				$edit_member = $this->input->post('edit_member');
				$delete_member = $this->input->post('delete_member');
				$edit_product = $this->input->post('edit_product');
				$delete_product = $this->input->post('delete_product');
				$download_legal_docs = $this->input->post('download_legal_docs');
				$approve_legal_docs = $this->input->post('approve_legal_docs');
				$decline_legal_docs = $this->input->post('decline_legal_docs');

				$data = array(
					"firstname" => $firstname,
					"lastname" => $lastname,
					"password" => $password,
					"username" => $username,
					"edit_member" => $edit_member,
					"delete_member" => $delete_member,
					"edit_product" => $edit_product,
					"delete_product" => $delete_product,
					"download_legal_docs" => $download_legal_docs,
					"approve_legal_docs" => $approve_legal_docs,
					"decline_legal_docs" => $decline_legal_docs
				);
				$admin_model->add($data);

				echo json_encode(array("success"=>"Y"));
				exit;
			}
		}
	}

	public function edit($admin_id){
		$this->template->content = new View("admin/admins/edit");

		if($this->session->get('super_admin') == "Y")
		{
			$admin_model = new admin_Model;
			$admin = $admin_model->get_one($admin_id);
			$this->template->content->admin = $admin;
		}else{
			url::redirect("admin/home");
		}
	}

	public function edit_save()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$admin_id = $this->input->post('admin_id');

			$admin_model = new admin_Model;

			$username = $this->input->post("username");
			$orig_username = $this->input->post("orig_username");
			if($username == $orig_username)
			{
				$password = base64_encode($this->input->post('passw'));
				$firstname = $this->input->post('firstname');
				$lastname = $this->input->post('lastname');
				$edit_member = $this->input->post('edit_member');
				$delete_member = $this->input->post('delete_member');
				$edit_product = $this->input->post('edit_product');
				$delete_product = $this->input->post('delete_product');
				$download_legal_docs = $this->input->post('download_legal_docs');
				$approve_legal_docs = $this->input->post('approve_legal_docs');
				$decline_legal_docs = $this->input->post('decline_legal_docs');

				$data = array(
					"firstname" => $firstname,
					"lastname" => $lastname,
					"password" => $password,
					"edit_member" => $edit_member,
					"delete_member" => $delete_member,
					"edit_product" => $edit_product,
					"delete_product" => $delete_product,
					"download_legal_docs" => $download_legal_docs,
					"approve_legal_docs" => $approve_legal_docs,
					"decline_legal_docs" => $decline_legal_docs
				);
				$admin_model->edit($admin_id, $data);

				echo json_encode(array("success"=>"Y"));
				exit;
			}else{
				$check = $admin_model->check_username($username);
				$count = count($check);
				if($count >= 1)
				{
					echo json_encode(array("success"=>"N"));
					exit;
				}else{
					$password = base64_encode($this->input->post('passw'));
					$firstname = $this->input->post('firstname');
					$lastname = $this->input->post('lastname');
					$edit_member = $this->input->post('edit_member');
					$delete_member = $this->input->post('delete_member');
					$edit_product = $this->input->post('edit_product');
					$delete_product = $this->input->post('delete_product');
					$download_legal_docs = $this->input->post('download_legal_docs');
					$approve_legal_docs = $this->input->post('approve_legal_docs');
					$decline_legal_docs = $this->input->post('decline_legal_docs');

					$data = array(
						"firstname" => $firstname,
						"lastname" => $lastname,
						"password" => $password,
						"username" => $username,
						"edit_member" => $edit_member,
						"delete_member" => $delete_member,
						"edit_product" => $edit_product,
						"delete_product" => $delete_product,
						"download_legal_docs" => $download_legal_docs,
						"approve_legal_docs" => $approve_legal_docs,
						"decline_legal_docs" => $decline_legal_docs
					);
					$admin_model->edit($admin_id, $data);

					echo json_encode(array("success"=>"Y"));
					exit;
				}
			}
		}
	}

	public function delete()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;
			$this->session = Session::instance();
			$id = $this->input->post("id", null, true);
			$admin_model = new admin_Model;
			$admin_model->delete($id);	
		}	
	}
	
}
?>
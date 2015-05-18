<?php defined('SYSPATH') OR die('No direct access allowed.');

class Index_Controller extends Template_Controller {

	public $template = 'outside_tpl';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();
	}

	public function index(){
		$this->template->content = new View("admin/index");
		
		if ($_POST){
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$admin_model = new Admin_Model;
			$admin = $admin_model->process_login($username, $password);
			$row_count = count($admin);
			if($row_count > 0){
				foreach($admin as $aa){
					$admin_id = $aa->admin_id;
					$admin_name = $aa->firstname.' '.$aa->lastname;
				}

				$this->session->set('admin_id', $admin_id);
				$this->session->set('admin_name', $admin_name);
				url::redirect("admin/home/index");
			}else{
				url::redirect("admin/error/index");
			}
		}
	}

	public function check(){

		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$username = $this->input->post("username");
			$password = base64_encode($this->input->post("password"));

			//get the enctrypted password
			$admin_model = new Admin_Model;
			$check = $admin_model->process_login($username, $password);
			$count = count($check);
			if($count != 0)
			{
				$row = $check->current();

				if($row->id == 1){
					$this->session->set('super_admin', "Y");
				}else{
					$this->session->set('super_admin', "N");
				}

				$this->session->set('admin_id', $row->id);
				$this->session->set('edit_member', $row->edit_member);
				$this->session->set('delete_member', $row->delete_member);
				$this->session->set('edit_product', $row->edit_product);
				$this->session->set('delete_product', $row->delete_product);
				$this->session->set('download_legal_docs', $row->download_legal_docs);
				$this->session->set('approve_legal_docs', $row->approve_legal_docs);
				$this->session->set('decline_legal_docs', $row->decline_legal_docs);
				$this->session->set('admin_name', $row->firstname.' '.$row->lastname);
				echo json_encode(TRUE);
			}else{
				echo json_encode(FALSE);
			}
		}
	}
	
}
?>
<?php defined('SYSPATH') OR die('No direct access allowed.');

class Faqs_Controller extends Template_Controller {

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
		$this->template->content = new View("admin/faqs/index");
	}

	public function add(){
		$this->template->content = new View("admin/faqs/add");

		if($_POST)
		{
			$faqs_model = new faqs_Model;

			$title = $this->input->post("title");
			$content = $this->input->post("content");

			$data = array(
				"title" => $title,
				"content"=> $content
			);

			$faqs_model->add($data);
			url::redirect("admin/faqs/index");
		}
	}

	public function edit($id){
		$this->template->content = new View("admin/faqs/edit");

		$faqs_model = new faqs_Model;

		$faqs = $faqs_model->get_one($id);
		$this->template->content->faqs = $faqs;

		if($_POST)
		{
			$title = $this->input->post("title");
			$content = $this->input->post("content");

			$data = array(
				"title" => $title,
				"content"=> $content
			);

			$faqs_model->edit($id, $data);
			url::redirect("admin/faqs/index");
		}
	}

	public function delete()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;
			$id = $this->input->post("id", null, true);
			$faqs_model = new faqs_Model;
			$faqs_model->delete($id);	
		}	
	}
	
}
?>
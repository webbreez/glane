<?php defined('SYSPATH') OR die('No direct access allowed.');

class Page_Controller extends Template_Controller {

	public $template = 'admin_tpl';
	
	public function __construct()
	{		
		set_time_limit(0);
		parent::__construct();
				
		$this->session = Session::instance();		
		//checking if user is logged in
		if(!$this->session->get('admin_id')){
			url::redirect("admin/index");
		}
		//till here
	}
	
	// public function index(){
	// 	$this->template->content = new View("admin/page/index");
		
	// 	$pages_model = new pages_Model;
	// 	$id = $this->uri->segment(2);
	// 	$page_title = $this->uri->segment(3);

	// 	$content_1 = $pages_model->get_one($id);

	// 	$this->template->content->content= $content;
	// 	$this->template->content->page_title= $page_title;

	// 	if($_POST)
	// 	{
	// 		$content = $this->input->post("content");

	// 		$data = array("content"=>$content);
	// 		$pages_model->edit($id, $data);
			
	// 		url::redirect("admin/page/index");
	// 	}
		
	// }

	public function edit(){
		$this->template->content = new View("admin/page/edit");
		
		$pages_model = new pages_Model;
		$id = $this->uri->segment(4);
		$page_title = $this->uri->segment(5);

		$content = $pages_model->get_one($id);

		$this->template->content->content= $content;
		$this->template->content->page_title= $page_title;

		if($_POST)
		{
			$title = $this->input->post("title");
			$content = $this->input->post("content");

			$data = array(
				"title" => $title,
				"content"=> $content
			);

			$pages_model->edit($id, $data);
			
			url::redirect("admin/page/edit/$id");
		}
		
	}

	// public function delete($id)
	// {

	// 	$pages_model = new pages_Model;
	// 	$pages_model->delete($id);
		
	// 	url::redirect("admin/home");
	// }
	
	public function ck_upload_file()
	{
		$this->auto_render = FALSE;

		$upload = $_FILES['upload'];
		$file_name = $upload['name'];
		$files = Validation::factory($_FILES)
			->add_rules('upload', 'upload::valid', 'upload::type[gif,jpg,png,bmp,jpeg,JPG]', 'upload::size[2M]');

		if ($files->validate())
		{
			$file_uploaded_path = upload::save($upload, $file_name, DOCROOT.'assets/uploads');
			$file_upload_url = url::base().'assets/uploads/'.$file_name;
			//$filename = upload::save('upload');
			//$file_uploaded_path = "uploads";
			$msg = "Your file has been uploaded.";

			$func_num = $_GET['CKEditorFuncNum'] ;
			$output = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$func_num.', "'.$file_upload_url.'","'.$msg.'");</script>';
		} else {
			$msg = "Error uploading file.  Please try again.";
		}

		echo $output;
	}
}
?>
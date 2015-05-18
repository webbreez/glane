<?php defined('SYSPATH') OR die('No direct access allowed.');

class Legal_Documents_Controller extends Template_Controller {

	public $template = 'inside_tpl';

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
		//till here	
	}

	public function index(){
		$this->template->content = new View("legal_documents/index");
	}

	public function add(){
		$this->template->content = new View("legal_documents/add");

		if($_POST)
		{
			$title = $this->input->post("title");

			// for uploaded file
			// $_FILES = Validation::factory($_FILES)
			// 	->add_rules('template_filename', 'upload::valid', 'upload::type[doc,docx]', 'upload::size[10M]');

			$template_filename = upload::save('upload');
			$filename_array = explode("/", $template_filename);
			$filename = end($filename_array);
			$file_ext_array = explode(".", $filename);
			$file_ext = end($file_ext_array);

			if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
			{
				$_POST['user_id'] = $this->session->get('user_id');
				$_POST['date_created'] = time();
				$_POST['status'] = "P";

				$new_filename = uniqid().".".strtolower($file_ext);
				$_POST['filename'] = $new_filename;
				$legal_documents_model = new legal_documents_Model;
				$legal_documents_model->add($_POST);

				rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
			}
			url::redirect("legal_documents");
		}
	}

	public function delete()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;
			$this->session = Session::instance();
			$user_id = $this->session->get('user_id');
			$id = $this->input->post("id", null, true);
			$legal_documents_model = new legal_documents_Model;
			$legal_documents_model->delete($id, $user_id);	
		}	
	}

	public function download($id)
	{
		$this->auto_render = false;
		//get document
		$this->session = Session::instance();
		$user_id = $this->session->get('user_id');
		$legal_documents_model = new legal_documents_Model;
		$document = $legal_documents_model->get_one($id, $user_id);
		$document_name = $document->filename;

		download::force(DOCROOT."assets/upload/$document_name");
	}
}
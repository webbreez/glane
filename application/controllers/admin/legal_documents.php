<?php defined('SYSPATH') OR die('No direct access allowed.');

class Legal_Documents_Controller extends Template_Controller {

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

	public function view($member_id){
		$this->template->content = new View("admin/legal_documents/view");

		$users_model = new users_Model;
		$member = $users_model->get_one($member_id);
		$this->template->content->member = $member;
	}

	public function approve($id, $member_id){
		$legal_documents_model = new legal_documents_Model;

		if($this->session->get('approve_legal_docs') == "N")
		{
			url::redirect("admin/access/denied");
			exit;
		}

		$data = array(
			"status" => "A"
		);
		$legal_documents_model->edit($id, $data);

		url::redirect("admin/legal_documents/view/$member_id");
	}

	public function decline($id, $member_id){
		$legal_documents_model = new legal_documents_Model;

		if($this->session->get('decline_legal_docs') == "N")
		{
			url::redirect("admin/access/denied");
			exit;
		}

		$data = array(
			"status" => "D"
		);
		$legal_documents_model->edit($id, $data);

		url::redirect("admin/legal_documents/view/$member_id");
	}

	public function download($id)
	{
		$this->auto_render = false;
		//get document
		$this->session = Session::instance();

		if($this->session->get('download_legal_docs') == "N")
		{
			url::redirect("admin/access/denied");
			exit;
		}
		$legal_documents_model = new legal_documents_Model;
		$document = $legal_documents_model->get_member_doc($id);
		$document_name = $document->filename;

		download::force(DOCROOT."assets/upload/$document_name");
	}
	
}
?>
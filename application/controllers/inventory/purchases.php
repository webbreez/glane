<?php defined('SYSPATH') OR die('No direct access allowed.');

class Purchases_Controller extends Template_Controller {

	public $template = 'inventory_tpl';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();		
		//checking if user is logged in
		if(!$this->session->get('manager_id')){
			url::redirect("inventory/index");
		}
		//till here
	}

	public function index(){
		$this->template->content = new View("inventory/purchases/index");
	}

	public function edit(){

		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$id = $this->input->post("id");
			$status = $this->input->post("status");

			$data["payment_status"] = $status;

			$purchases_model = new Purchases_Model;
			$purchases_model->edit($id, $data);
		}

	}
}
?>
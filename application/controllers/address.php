<?php defined('SYSPATH') OR die('No direct access allowed.');

class Address_Controller extends Template_Controller {

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
		//till here	
	}

	public function index(){
		$this->template->content = new View("address/index");
	}

	public function add(){
		$this->template->content = new View("address/add");

		if($_POST)
		{
			$address_1 = $this->input->post("address_1");
			$address_2 = $this->input->post("address_2");
			$city = $this->input->post("city");
			$state = $this->input->post("state");
			$zip = $this->input->post("zip");
			$type = $this->input->post("type");

			$data = array(
				"user_id" => $this->session->get("user_id"),
				"user_address_1" => $address_1,
				"user_address_2" => $address_2,
				"user_address_city" => $city,
				"user_address_state" => $state,
				"user_address_zip" => $zip,
				"user_address_type" => $type
			);

			$users_model = new users_Model;
			$users_model->add_address($data);
			url::redirect("address");
		}
	}

	public function edit($id){
		$this->template->content = new View("address/edit");

		$users_model = new users_Model;
		$address = $users_model->get_address($id);	
		$this->template->content->address = $address;

		if($_POST)
		{
			$address_1 = $this->input->post("address_1");
			$address_2 = $this->input->post("address_2");
			$city = $this->input->post("city");
			$state = $this->input->post("state");
			$zip = $this->input->post("zip");
			$type = $this->input->post("type");
			$primary = $this->input->post("primary");

			//update first the old primary address
			if($primary == "Yes")
			{
				$user_id = $this->session->get("user_id");
				$u_data = array("user_address_primary"=> "No");
				$users_model->update_primary_address($user_id, $type, $u_data);
			}

			$data = array(
				"user_address_1" => $address_1,
				"user_address_2" => $address_2,
				"user_address_city" => $city,
				"user_address_state" => $state,
				"user_address_zip" => $zip,
				"user_address_type" => $type,
				"user_address_primary" => $primary
			);
			$users_model->edit_address($id, $data);
			url::redirect("address");
		}
	}

	public function delete()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;
			$this->session = Session::instance();
			$id = $this->input->post("id", null, true);
			$users_model = new users_Model;
			$users_model->delete_address($id);	
		}	
	}
}
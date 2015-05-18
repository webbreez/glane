<?php defined('SYSPATH') OR die('No direct access allowed.');

class My_Sales_Controller extends Template_Controller {

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
		$this->template->content = new View("my_sales/index");
	}

	public function view($uniq_id){
		$this->template->content = new View("my_sales/view");

		$users_model = new users_Model;
		$shipping = $users_model->get_shipping_address($this->session->get("user_id"));
		$this->template->content->shipping = $shipping;

		$products_model = new products_Model;
		$cart = $products_model->get_cart_by_uniq_id($uniq_id);
		$this->template->content->cart = $cart;
	}
}
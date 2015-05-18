<?php defined('SYSPATH') OR die('No direct access allowed.');

class My_Basket_Controller extends Template_Controller {

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
		$this->template->content = new View("my_basket/index");
	}

	public function buy_now($my_basket_id)
	{
		$this->template->content = new View("my_basket/buy_now");

		$products_model = new products_Model;
		$my_basket = $products_model->get_one_my_basket($my_basket_id);
		$id = $my_basket->product_id;
		$my_basket_qty = $my_basket->qty;
		$my_basket_price = $my_basket->price;
		$this->template->content->my_basket_qty = $my_basket_qty;
		$this->template->content->my_basket_price = $my_basket_price;
		
		$product = $products_model->get_one_product($id);
		$this->template->content->product = $product;

		$user_id = $this->session->get('user_id');
		$users_model = new users_Model;

		$user = $users_model->get_one($user_id);
		$this->template->content->user = $user;

		$user_address = $users_model->get_primary_address($user_id);
		if(count($user_address) == 0)
		{
			$user_address = new stdClass;
			$user_address->user_address_1 = "";
			$user_address->user_address_2 = "";
			$user_address->user_address_city = "";
			$user_address->user_address_state = "";
			$user_address->user_address_zip = "";
		}else{
			$user_address = $user_address->current();
		}
		$this->template->content->user_address = $user_address;

		$owner_id = $product->user_id;
		$owner_address = $users_model->get_primary_address($owner_id);
		if(count($owner_address) == 0)
		{
			$owner_address = new stdClass;
			$owner_address->user_address_1 = "";
			$owner_address->user_address_2 = "";
			$owner_address->user_address_city = "";
			$owner_address->user_address_state = "";
			$owner_address->user_address_zip = "";
		}else{
			$owner_address = $owner_address->current();
		}
		$this->template->content->owner_address = $owner_address;
	}
}
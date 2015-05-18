<?php defined('SYSPATH') OR die('No direct access allowed.');

class Orders_Controller extends Template_Controller {

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
		$this->template->content = new View("admin/orders/index");

		$order_id = $this->input->get("order_id");
		$email = $this->input->get("email");
		$firstname = $this->input->get("firstname");
		$lastname = $this->input->get("lastname");
		$date_from = $this->input->get("date_from") ? strtotime($this->input->get("date_from"). "00:00:00") : '';
		$date_to = $this->input->get("date_to") ? strtotime($this->input->get("date_to"). "23:59:59") : '';

		if($order_id || $email || $firstname || $lastname || $date_from || $date_to)
		{
			$products_model = new products_Model;
			$orders = $products_model->search_orders($order_id, $email, $firstname, $lastname, $date_from, $date_to);
			$count_orders = count($orders);
			$this->template->content->orders = $orders;
			$this->template->content->count_orders = $count_orders;
		}else{
			$this->template->content->count_orders = -1;
		}

	}

	public function view($uniq_id, $user_id){
		$this->template->content = new View("admin/orders/view");

		$users_model = new users_Model;
		$shipping = $users_model->get_shipping_address($user_id);
		$this->template->content->shipping = $shipping;

		$products_model = new products_Model;
		$cart = $products_model->get_cart_by_uniq_id($uniq_id);
		$this->template->content->cart = $cart;
	}
	
}
?>
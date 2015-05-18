<?php defined('SYSPATH') OR die('No direct access allowed.');

class Home_Controller extends Template_Controller {

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
		$this->template->content = new View("home/index");
		$user_id = $this->session->get('user_id');
		$products_model = new products_Model;

		// $products = $products_model->get_products($user_id);
		// $this->template->content->products = $products;

		$notifications = $products_model->get_products_notifications($user_id);
		$this->template->content->notifications = $notifications;
	}

	public function get_product_picture($product_id)
	{

		$products_model = new products_Model;
		$picture = $products_model->get_pictures_by_product_id($product_id);
		$count = count($picture);
		if($count != 0)
		{
			$picture = $picture->current();
			$filename = $picture->product_images_filename;	
		}else{
			$filename = "";
		}
		
		return $filename;	
	}
	
}
?>
<?php defined('SYSPATH') OR die('No direct access allowed.');

class Faqs_Controller extends Template_Controller {

	public $template = 'index_tpl';

	public function __construct()
	{
		parent::__construct();

		$this->session = Session::instance();	

		$products_model = new products_Model;
		$category_1 = $products_model->get_category_1();

		$this->template->category_1 = $category_1;	

		$featured_products = $products_model->get_featured_products();
		$this->template->featured_products = $featured_products;
	}

	public function index(){
		$this->template->content = new View("faqs/index");

		$faqs_model = new faqs_Model;
		$faqs = $faqs_model->get_all();
		$this->template->content->faqs = $faqs;
	}

	public function view($id){
		$this->template->content = new View("faqs/view");

		$faqs_model = new faqs_Model;
		$faq = $faqs_model->get_one($id);
		$this->template->content->faq = $faq;
	}
}
?>
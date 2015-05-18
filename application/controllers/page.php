<?php defined('SYSPATH') OR die('No direct access allowed.');

class Page_Controller extends Template_Controller {

	public $template = 'index_tpl2';
	
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

	public function view(){
		$this->template->content = new View("page/view");
		
		$pages_model = new pages_Model;
		$id = $this->uri->segment(3);

		$content = $pages_model->get_one($id);

		$this->template->content->content= $content;
	}
}
?>
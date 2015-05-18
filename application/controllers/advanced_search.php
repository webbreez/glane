<?php defined('SYSPATH') OR die('No direct access allowed.');

class Advanced_Search_Controller extends Template_Controller {

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
		$this->template->content = new View("advanced_search/index");

		$products_model = new products_Model;

		$brands = $products_model->get_all_brands();
		$this->template->content->brands = $brands;

		$category_1 = $products_model->get_category_1();

		$this->template->content->category_1 = $category_1;

		$category_1_id = $this->input->get("category_1");
		if($category_1_id)
		{
			$category_2 = $products_model->get_categories($category_1_id, 'category_1');
			$this->template->content->category_2 = $category_2;
		}

		$category_2_id = $this->input->get("category_2");
		if($category_2_id)
		{
			$category_3 = $products_model->get_categories($category_2_id, 'category_2');
			$this->template->content->category_3 = $category_3;
		}

		$category_3_id = $this->input->get("category_3");
		if($category_3_id)
		{
			$category_4 = $products_model->get_categories($category_3_id, 'category_3');
			$this->template->content->category_4 = $category_4;
		}

		$category_4_id = $this->input->get("category_4");

		$search_keyword = $this->input->get("search_keyword");
		$brand = $this->input->get("brand");
		$expiration_date = $this->input->get("expiration_date");

		$products = $products_model->advanced_search_products($search_keyword, $brand, $category_1_id, $category_2_id, $category_3_id, $category_4_id, $expiration_date);
		$this->template->content->products = $products;

		$products_count = count($products);
		$this->template->content->products_count = $products_count;
	}
}
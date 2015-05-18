<?php defined('SYSPATH') OR die('No direct access allowed.');

class Product_Category_Controller extends Template_Controller {

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
		//till here		
	}

	public function view($category_level, $category_id){
		$this->template->content = new View("product_listing/index");

		$products_model = new products_Model;
		$products = $products_model->get_products_by_category($category_level, $category_id);

		$products_count = count($products);
		$items_per_page = 20;

		$this->pagination = new Pagination(array(
    		'base_url'    =>  "/product_category/view/", // base_url will default to current uri
		    'uri_segment'    => 6, // pass a string as uri_segment to trigger former 'label' functionality
		    'total_items'    => $products_count, // use db count query here of course
		    'items_per_page' => $items_per_page, // it may be handy to set defaults for stuff like this in config/pagination.php
		    'style'          => 'classic', // pick one from: classic (default), digg, extended, punbb, or add your own!
		    'auto_hide'      => true,
		    'sql_offset'     => $this->uri->segment(6)
		));
		$products = $products_model->get_products_by_category_limit($category_level, $category_id, $this->pagination->items_per_page, $this->pagination->sql_offset);
		$this->template->content->products = $products;

		if($this->uri->segment(6) != 1 && $this->uri->segment(6))
		{
			$this->template->content->count_1 = $this->pagination->sql_offset + 1;
			$this->template->content->count_2 =  $this->pagination->sql_offset + count($products);
			$this->template->content->products_count = $products_count;
		}else{
			if($products_count <= $items_per_page)
			{
				$items_per_page = $products_count;
			}
			$this->template->content->count_1 = 1;
			$this->template->content->count_2 = $items_per_page;
			$this->template->content->products_count = $products_count;
		}

		//get the previously visited products
		$ip_address = productsvisit_helper::get_ip_address();
		$visited_products = $products_model->get_products_related_by_categories($ip_address, $this->session->get("user_id"));
		$this->template->content->visited_products = $visited_products;
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
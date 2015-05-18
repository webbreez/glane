<?php defined('SYSPATH') OR die('No direct access allowed.');

class Index_Controller extends Template_Controller {

	public $template = 'index_tpl';

	public function __construct()
	{
		parent::__construct();

		$this->session = Session::instance();	

		if(!isset($_COOKIE["cart_cookie"]))
		{
			setcookie("cart_cookie", uniqid());
		}

		$products_model = new products_Model;
		$category_1 = $products_model->get_category_1();

		$this->template->category_1 = $category_1;	

		$featured_products = $products_model->get_featured_products();
		$this->template->featured_products = $featured_products;
	}

	public function index(){
		$this->template = View::factory('home_tpl');
	}

	public function index2(){
		$this->template->content = new View("product_listing/index");

		url::redirect("index.html");
		exit;

		$products_model = new products_Model;
		$ip_address = productsvisit_helper::get_ip_address();

		//check first if the user already has a data on products_visit table
		$check_products_visit = $products_model->get_products_visit($ip_address, $this->session->get("user_id"));
		$cpv_count = count($check_products_visit);

		if($cpv_count > 0)
		{
			$ctr = 1;
			$orderby = "ORDER BY ";
			foreach($check_products_visit as $cpv)
			{
				if($cpv_count == $ctr)
				{
					$orderby .= "category_1 = ".$cpv->main_category.' DESC ';
				}else{
					$orderby .= "category_1 = ".$cpv->main_category.' DESC, ';
				}
				
				$ctr++;
			}
		}else{
			$orderby = "";
		}

		$products = $products_model->get_products_for_listings($orderby);
		
		$this->template->content->products = $products;

		$products_count = count($products);
		$this->template->content->products_count = $products_count;

		//get the previously visited products
		$visited_products = $products_model->get_products_related_by_categories($ip_address, $this->session->get("user_id"));
		$this->template->content->visited_products = $visited_products;
	}

	public function products(){
		$this->template->content = new View("product_listing/index");
		
		$products_model = new products_Model;
		$ip_address = productsvisit_helper::get_ip_address();

		//check first if the user already has a data on products_visit table
		$check_products_visit = $products_model->get_products_visit($ip_address, $this->session->get("user_id"));
		$cpv_count = count($check_products_visit);

		if($cpv_count > 0)
		{
			$ctr = 1;
			$orderby = "ORDER BY ";
			foreach($check_products_visit as $cpv)
			{
				if($cpv_count == $ctr)
				{
					$orderby .= "category_1 = ".$cpv->main_category.' DESC ';
				}else{
					$orderby .= "category_1 = ".$cpv->main_category.' DESC, ';
				}
				
				$ctr++;
			}
		}else{
			$orderby = "";
		}

		$products = $products_model->get_products_for_listings($orderby);
		$products_count = count($products);

		$items_per_page = 20;

		$this->pagination = new Pagination(array(
    		'base_url'    =>  "/index/products/", // base_url will default to current uri
		    'uri_segment'    => 3, // pass a string as uri_segment to trigger former 'label' functionality
		    'total_items'    => $products_count, // use db count query here of course
		    'items_per_page' => $items_per_page, // it may be handy to set defaults for stuff like this in config/pagination.php
		    'style'          => 'classic', // pick one from: classic (default), digg, extended, punbb, or add your own!
		    'auto_hide'      => true,
		    'sql_offset'     => $this->uri->segment(3)
		));
		$products = $products_model->get_products_for_listings_limit($this->pagination->items_per_page, $this->pagination->sql_offset);
		$this->template->content->products = $products;

		if($this->uri->segment(3) != 1 && $this->uri->segment(3))
		{
			$this->template->content->count_1 = $this->pagination->sql_offset + 1;
			$this->template->content->count_2 =  $this->pagination->sql_offset + count($products);
			$this->template->content->products_count = $products_count;
		}else{
			$this->template->content->count_1 = 1;
			$this->template->content->count_2 = $items_per_page;
			$this->template->content->products_count = $products_count;
		}

		//get the previously visited products
		$visited_products = $products_model->get_products_related_by_categories($ip_address, $this->session->get("user_id"));
		$this->template->content->visited_products = $visited_products;
	}

	public function similar_address($product_pickup_address)
	{
		$products_model = new products_Model;
		$category_1 = $products_model->get_category_1();

		$this->template->category_1 = $category_1;	

		$featured_products = $products_model->get_featured_products();
		$this->template->featured_products = $featured_products;

		$this->template->content = new View("product_listing/index");
		
		$products_model = new products_Model;
		$ip_address = productsvisit_helper::get_ip_address();

		//check first if the user already has a data on products_visit table
		$check_products_visit = $products_model->get_products_visit($ip_address, $this->session->get("user_id"));
		$cpv_count = count($check_products_visit);

		if($cpv_count > 0)
		{
			$ctr = 1;
			$orderby = "ORDER BY ";
			foreach($check_products_visit as $cpv)
			{
				if($cpv_count == $ctr)
				{
					$orderby .= "category_1 = ".$cpv->main_category.' DESC ';
				}else{
					$orderby .= "category_1 = ".$cpv->main_category.' DESC, ';
				}
				
				$ctr++;
			}
		}else{
			$orderby = "";
		}

		$products = $products_model->get_products_for_listings_combined_shipping($orderby, $product_pickup_address);
		
		$this->template->content->products = $products;

		$products_count = count($products);
		$this->template->content->products_count = $products_count;

		//get the previously visited products
		$visited_products = $products_model->get_products_related_by_categories($ip_address, $this->session->get("user_id"));
		$this->template->content->visited_products = $visited_products;
	}

	public function search(){
		$this->template->content = new View("product_listing/index");

		$search = $this->input->post('search');
		$search_category = $this->input->post('search_category');

		$products_model = new products_Model;
		$products = $products_model->search_products($search, $search_category);

		$products_count = count($products);

		$items_per_page = 20;

		$this->pagination = new Pagination(array(
    		'base_url'    =>  "/index/products/", // base_url will default to current uri
		    'uri_segment'    => 3, // pass a string as uri_segment to trigger former 'label' functionality
		    'total_items'    => $products_count, // use db count query here of course
		    'items_per_page' => $items_per_page, // it may be handy to set defaults for stuff like this in config/pagination.php
		    'style'          => 'classic', // pick one from: classic (default), digg, extended, punbb, or add your own!
		    'auto_hide'      => true,
		    'sql_offset'     => $this->uri->segment(3)
		));
		$products = $products_model->search_products_limit($search, $search_category, $this->pagination->items_per_page, $this->pagination->sql_offset);

		$this->template->content->products = $products;

		if($this->uri->segment(3) != 1 && $this->uri->segment(3))
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

	public function find_products()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$products_model = new products_Model;

			$term = $this->input->get("term");

			$query = $products_model->find_products($term);
			$data = array();
			foreach($query as $q)
			{
				$data[] = $q->product_name;
			}

			$query = $products_model->get_brands($term);
			$data = array();
			foreach($query as $q)
			{
				$data[] = $q->brand_name;
			}

			$query = $products_model->find_category_1($term);
			foreach($query as $q)
			{
				$data[] = $q->category_1_name;
			}

			$query = $products_model->find_category_2($term);
			foreach($query as $q)
			{
				$data[] = $q->category_2_name;
			}

			$query = $products_model->find_category_3($term);
			foreach($query as $q)
			{
				$data[] = $q->category_3_name;
			}

			$query = $products_model->find_category_4($term);
			foreach($query as $q)
			{
				$data[] = $q->category_4_name;
			}

			asort($data);

			echo json_encode($data);
		}
	}
}
?>
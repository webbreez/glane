<?php defined('SYSPATH') OR die('No direct access allowed.');

class Product_Listing_Controller extends Template_Controller {

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

	public function index(){
		$this->template->content = new View("product_listing/index");

		$products_model = new products_Model;
		$products = $products_model->get_products_for_listings();
		$this->template->content->products = $products;
	}

	public function details($id){
		$this->template->content = new View("items/details");

		$products_model = new products_Model;
		$product = $products_model->get_one_product($id);
		$this->template->content->product = $product;

		//check qty
		$qty = $product->qty;
		if($qty <= 0)
		{
			url::redirect("index/products");
		}

		$related_products = $products_model->products_related_by_categories($id, $product->category_1);
		$this->template->content->related_products = $related_products;

		$category_1_id = $product->category_1;
		$category_2_id = $product->category_2;
		$category_3_id= $product->category_3;
		$category_4_id = $product->category_4;
		
		if($category_1_id)
		{
		$category_1_query = $products_model->get_one_category_1($category_1_id);
		$category_1 = $category_1_query->category_1_name;
		$this->template->content->category_1 = $category_1;
		}else{
		$this->template->content->category_1 = "";
		}
		
		if($category_2_id)
		{
		$category_2_query = $products_model->get_one_category_2($category_2_id);
		$category_2 = $category_2_query->category_2_name;
		$this->template->content->category_2 = $category_2;
		}else{
		$this->template->content->category_2 = "";
		}

        if($category_3_id)
		{
		$category_3_query = $products_model->get_one_category_3($category_3_id);
		$category_3 = $category_3_query->category_3_name;
		$this->template->content->category_3 = $category_3;
		}else{
		$this->template->content->category_3 = "";
		}
	
		if($category_4_id)
		{
		$category_4_query = $products_model->get_one_category_4($category_4_id);
		$category_4 = $category_4_query->category_4_name;
		$this->template->content->category_4 = $category_4;
		}else{
		$this->template->content->category_4 = "";
		}

		//get pictures
		$pictures = $products_model->get_pictures($id);
		$this->template->content->pictures = $pictures;
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

	public function get_product_category_name()
	{
		// $products_model = new products_Model;
		// $category = $products_model->get_product_category_name($table, $category_id);
		// $count = count($category);
		// if($count != 0)
		// {
		// 	$row = $category->current();
		// 	if($table == "category_1")
		// 	{
		// 		return $row->category_1_name;
		// 	}elseif($table == "category_2")
		// 	{
		// 		return $row->category_2_name;
		// 	}elseif($table == "category_3")
		// 	{
		// 		return $row->category_3_name;
		// 	}else{
		// 		return $row->category_4_name;
		// 	}
		// }else{
		// 	return "";
		// }
		return "test";
	}
}
<?php defined('SYSPATH') OR die('No direct access allowed.');

class Products_Controller extends Template_Controller {

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

	public function view($member_id){
		$this->template->content = new View("admin/products/view");

		$users_model = new users_Model;
		$member = $users_model->get_one($member_id);
		$this->template->content->member = $member;
	}

	public function edit($product_id, $member_id){
		$this->template->content = new View("admin/products/edit");

		if($this->session->get('edit_product') == "N")
		{
			url::redirect("admin/access/denied");
			exit;
		}

		$products_model = new products_Model;
		$product = $products_model->get_one_product($product_id);

		$category_1 = $products_model->get_category_1();

		$product_category_1 = $product->category_1;
		$list_product_category_2 = $products_model->get_categories($product_category_1, "category_1");
		$this->template->content->list_product_category_2 = $list_product_category_2;

		$product_category_2 = $product->category_2;
		$list_product_category_3 = $products_model->get_categories($product_category_2, "category_2");
		$this->template->content->list_product_category_3 = $list_product_category_3;

		$product_category_3 = $product->category_3;
		$list_product_category_4 = $products_model->get_categories($product_category_3, "category_3");
		$this->template->content->list_product_category_4 = $list_product_category_4;

		$this->template->content->product = $product;
		$this->template->content->category_1 = $category_1;

		if($_POST)
		{
			$product_name = $this->input->post('product_name');
			$description = $this->input->post('description');
			$category_1 = $this->input->post('category_1');
			$category_2 = $this->input->post('category_2');
			$category_3 = $this->input->post('category_3');
			$category_4 = $this->input->post('category_4');
			$qty = $this->input->post('qty');
			$price = $this->input->post('price');
			$featured = $this->input->post('featured');

			$date = strtotime("+7 day");
			$time_duration = date('Y-m-d', $date);

			$data = array(
				"product_name" => $product_name,
				"product_description" => $description,
				"category_1" => $category_1,
				"category_2" => $category_2,
				"category_3" => $category_3,
				"category_4" => $category_4,
				"qty" => $qty,
				"price" => $price,
				"time_duration" => $time_duration,
				"featured" => $featured
			);

			$featured = $this->input->post('featured');

			if($featured == "Yes")
			{
				$filename = upload::save('banner');
				$filename_array = explode("/", $filename);
				$filename = end($filename_array);
				$file_ext_array = explode(".", $filename);
				$file_ext = end($file_ext_array);

				if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png')
				{
					$new_filename = uniqid().".".strtolower($file_ext);

					$data['banner'] = $new_filename;

					rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
				}
			}


			$products_model->edit_by_admin($product_id, $data);

			url::redirect("admin/products/view/$member_id");
		}
	}

	public function delete()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			if($this->session->get('delete_product') == "N")
			{
				url::redirect("admin/access/denied");
				exit;
			}

			$this->session = Session::instance();
			$user_id = $this->input->post("user_id", null, true);
			$id = $this->input->post("id", null, true);
			$products_model = new products_Model;
			$products_model->delete($id, $user_id);	
		}	
	}
	
}
?>
<?php defined('SYSPATH') OR die('No direct access allowed.');

class Products_Controller extends Template_Controller {

	public $template = 'inside_tpl';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();		
		//checking if user is logged in
		if(!$this->session->get('user_id')){
			url::redirect("index");
		}

		if($this->session->get('user_type') == "buyer"){
			url::redirect("home");
		}

		if($this->session->get('user_status') == 2){
			url::redirect("home");
		}

		$products_model = new products_Model;
		$category_1 = $products_model->get_category_1();

		$this->template->category_1 = $category_1;
		//till here		
	}

	public function index(){
		$this->template->content = new View("products/index");
	}

	public function upload(){
		$this->template->content = new View("products/upload");

		if($_POST)
		{
			$products_model = new products_Model;

			include 'phpexcel/Classes/PHPExcel/IOFactory.php';
			$_FILES = Validation::factory($_FILES);

			$excel_filename = upload::save('excel');
			$filename_array = explode("/", $excel_filename);
			$filename = end($filename_array);

			$inputFileName = $excel_filename;
			$inputFileType = 'Excel2007';
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setLoadAllSheets();
			$objPHPExcel = $objReader->load($inputFileName);

			$loadedSheetNames = $objPHPExcel->getSheetNames();

			foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
				//echo $sheetIndex,' -> ',$loadedSheetName,'<br />';
				$sheetData = $objPHPExcel->getSheet($sheetIndex)->toArray(null,true,true,true);
				$ctr = 0;
				foreach($sheetData as $data)
				{
					if($ctr >= 1)
					{
						$product_name = !empty($data['A']) ? trim($data['A']) : '';
						$product_description = !empty($data['B']) ? trim($data['B']) : '';
						$brand = !empty($data['C']) ? trim($data['C']) : '';
						$category_1 = !empty($data['D']) ? trim($data['D']) : '';
						$category_2 = !empty($data['E']) ? trim($data['E']) : '';
						$category_3 = !empty($data['F']) ? trim($data['F']) : '';
						$category_4 = !empty($data['G']) ? trim($data['G']) : '';
						$qty = !empty($data['H']) ? trim($data['H']) : '';
						$price = !empty($data['I']) ? trim($data['I']) : '';
						$expiration_date = !empty($data['J']) ? trim($data['J']) : '';
						$expiration_date_array = explode("-", $expiration_date);
						$e_date = "20".$expiration_date_array[2]."-".$expiration_date_array[0]."-".$expiration_date_array[1]." 23:59:59";

						//get category ids
						$query_category_1 = $products_model->get_category_by_name("category_1", "category_1_name", $category_1);
						$query_category_1_count = count($query_category_1);
						if($query_category_1_count == 1)
						{
							$row_1 = $query_category_1->current();
							$product_category_1 = $row_1->category_1_id;
						}else{
							$product_category_1 = 0;
						}

						//category 2
						$query_category_2 = $products_model->get_category_by_name("category_2", "category_2_name", $category_2);
						$query_category_2_count = count($query_category_2);
						if($query_category_2_count == 1)
						{
							$row_2 = $query_category_2->current();
							$product_category_2 = $row_2->category_2_id;
						}else{
							$product_category_2 = 0;
						}

						//category 3
						$query_category_3 = $products_model->get_category_by_name("category_3", "category_3_name", $category_3);
						$query_category_3_count = count($query_category_3);
						if($query_category_3_count == 1)
						{
							$row_3 = $query_category_3->current();
							$product_category_3 = $row_3->category_3_id;
						}else{
							$product_category_3 = 0;
						}

						//category 4
						$query_category_4 = $products_model->get_category_by_name("category_4", "category_4_name", $category_4);
						$query_category_4_count = count($query_category_4);
						if($query_category_4_count == 1)
						{
							$row_4 = $query_category_4->current();
							$product_category_4 = $row_4->category_4_id;
						}else{
							$product_category_4 = 0;
						}

						$data = array(
							"user_id" => $this->session->get('user_id'),
							"product_name" => $product_name,
							"product_description" => $product_description,
							"brand" => $brand,
							"category_1" => $product_category_1,
							"category_2" => $product_category_2,
							"category_3" => $product_category_3,
							"category_4" => $product_category_4,
							"qty" => $qty,
							"price" => $price,
							"expiration_date" => $e_date
						);
						$products_model->add($data);
					}
					$ctr++;
				}
			}
			url::redirect("products");
		}
	}

	public function category($category_id){
		$this->template->content = new View("product_listing/index");

		$products = $products_model->get_product_by_category($category_id);
		$this->template->content->products = $products;
	}

	public function add(){
		$this->template->content = new View("products/add");

		$user_id = $this->session->get('user_id');

		$products_model = new products_Model;
		$category_1 = $products_model->get_category_1();

		$this->template->content->category_1 = $category_1;

		//get address
		$users_model = new users_Model;
		$addresses = $users_model->get_all_address($user_id);
		$this->template->content->addresses = $addresses;

		//countries
		$country_model = new country_Model;
		$countries = $country_model->get_all();
		$this->template->content->countries = $countries;

		if($_POST)
		{
			$user_id = $this->session->get('user_id');
			$product_name = $this->input->post('product_name');
			$description = $this->input->post('description');
			$department = $this->input->post('department') ? $this->input->post('department') : '';
			$category_1 = $this->input->post('category_1') ? $this->input->post('category_1') : '';
			$category_2 = $this->input->post('category_2') ? $this->input->post('category_2') : '';
			$category_3 = $this->input->post('category_3') ? $this->input->post('category_3') : '';
			$category_4 = $this->input->post('category_4') ? $this->input->post('category_4') : '';
			$qty = $this->input->post('qty');
			$qty_type = $this->input->post('qty_type');
			$number_of_unit = $this->input->post('number_of_unit') ? $this->input->post('number_of_unit') : '';

			$number_of_unit_per_pallet = $this->input->post('number_of_unit_per_pallet') ? $this->input->post('number_of_unit_per_pallet') : '';
			$case_per_pallet = $this->input->post('case_per_pallet') ? $this->input->post('case_per_pallet') : '';
			$unit_per_case_per_pallet = $this->input->post('unit_per_case_per_pallet') ? $this->input->post('unit_per_case_per_pallet') : '';

			$number_of_unit_per_case = $this->input->post('number_of_unit_per_case') ? $this->input->post('number_of_unit_per_case') : '';
			$unit_per_case = $this->input->post('unit_per_case') ? $this->input->post('unit_per_case') : '';

			$price = $this->input->post('price');
			if($this->input->post('expiration_date'))
			{
				$expiration_date_array = explode("/", $this->input->post('expiration_date'));
				$expiration_date = $expiration_date_array[2]."-".$expiration_date_array[0]."-".$expiration_date_array[1]." "."23:59:59";
			}else{
				$expiration_date = "";
			}

			$brand = $this->input->post('brand');
			//check if brand already exists on the brands table, if not, then add it
			$check_brand = $products_model->check_brand($brand);
			$check_brand_count = count($check_brand);
			if($check_brand_count == 0)
			{
				$brand_data = array("brand_name"=>$brand);
				$products_model->add_brand($brand_data);
			}


			$date = strtotime("+7 day");
			$time_duration = date('Y-m-d', $date);

			//for category searching
			if($category_1)
			{
				$cat_1_search = $products_model->get_one_category_1($category_1);
				$cat_1_search_name = $cat_1_search->category_1_name;
			}else{
				$cat_1_search_name = "";
			}

			if($category_2)
			{
				$cat_2_search = $products_model->get_one_category_2($category_2);
				$cat_2_search_name = $cat_2_search->category_2_name;
			}else{
				$cat_2_search_name = "";
			}

			if($category_3)
			{
				$cat_3_search = $products_model->get_one_category_3($category_3);
				$cat_3_search_name = $cat_3_search->category_3_name;
			}else{
				$cat_3_search_name = "";
			}

			if($category_4)
			{
				$cat_4_search = $products_model->get_one_category_4($category_4);
				$cat_4_search_name = $cat_4_search->category_4_name;
			}else{
				$cat_4_search_name = "";
			}

			$category_searching = $cat_1_search_name.' '.$cat_2_search_name.' '.$cat_3_search_name.' '.$cat_4_search_name;

			$height = $this->input->post('height');
			$length = $this->input->post('length');
			$width = $this->input->post('width');
			$weight = $this->input->post('weight');
			$percentage_discount = $this->input->post('percentage_discount');
			$product_pickup_address = $this->input->post('product_pickup_address');
			$minimum_purchase = $this->input->post('minimum_purchase');
			$product_type = $this->input->post('product_type');
			$make_an_offer = $this->input->post('make_an_offer');
			$take_all_price = $this->input->post('take_all_price');

			$number_of_cases_per_pallet = $this->input->post('number_of_cases_per_pallet') ? $this->input->post('number_of_cases_per_pallet') : '';
			$pack_per_case = $this->input->post('pack_per_case') ? $this->input->post('pack_per_case') : '';
			$pack_per_case_size = $this->input->post('pack_per_case_size') ? $this->input->post('pack_per_case_size') : '';

			$shipping_fee_included = $this->input->post('shipping_fee_included') ? $this->input->post('shipping_fee_included') : 'No';
			$country_of_origin = $this->input->post('country_of_origin');
			$short_dated = $this->input->post('short_dated') ? $this->input->post('short_dated') : 'No';
			$on_sale = $this->input->post('on_sale') ? $this->input->post('on_sale') : 'No';
			$sale_price = $this->input->post('sale_price');
			$make_an_offer_minimum_amount = $this->input->post('make_an_offer_minimum_amount');
			$make_an_offer_minimum_qty = $this->input->post('make_an_offer_minimum_qty');
			$make_an_offer_auto_accept_amount = $this->input->post('make_an_offer_auto_accept_amount');
			$make_an_offer_auto_accept_qty = $this->input->post('make_an_offer_auto_accept_qty');

			$data = array(
				"user_id" => $user_id,
				"product_name" => $product_name,
				"product_description" => $description,
				"brand" => $brand,
				"department" => $department,
				"category_1" => $category_1,
				"category_2" => $category_2,
				"category_3" => $category_3,
				"category_4" => $category_4,
				"category_searching" => $category_searching,
				"qty" => $qty,
				"qty_type" => $qty_type,
				"number_of_unit" => $number_of_unit,
				"number_of_unit_per_pallet" => $number_of_unit_per_pallet,
				"case_per_pallet" => $case_per_pallet,
				"unit_per_case_per_pallet" => $unit_per_case_per_pallet,
				"number_of_unit_per_case" => $number_of_unit_per_case,
				"unit_per_case" => $unit_per_case,
				"price" => $price,
				"time_duration" => $time_duration,
				"expiration_date" => $expiration_date,
				"height" => $height,
				"length" => $length,
				"width" => $width,
				"weight" => $weight,
				"percentage_discount" => $percentage_discount,
				"product_pickup_address" => $product_pickup_address,
				"minimum_purchase" => $minimum_purchase,
				"product_type" => $product_type,
				"make_an_offer" => $make_an_offer,
				"number_of_cases_per_pallet" => $number_of_cases_per_pallet,
				"pack_per_case" => $pack_per_case,
				"pack_per_case_size" => $pack_per_case_size,
				"take_all_price" => $take_all_price,
				"shipping_fee_included" => $shipping_fee_included,
				"country_of_origin" => $country_of_origin,
				"short_dated" => $short_dated,
				"on_sale" => $on_sale,
				"sale_price" => $sale_price,
				"make_an_offer_minimum_amount" => $make_an_offer_minimum_amount,
				"make_an_offer_minimum_qty" => $make_an_offer_minimum_qty,
				"make_an_offer_auto_accept_amount" => $make_an_offer_auto_accept_amount,
				"make_an_offer_auto_accept_qty" => $make_an_offer_auto_accept_qty
			);
			$product_id = $products_model->add($data);

			$filename = upload::save('picture');
			$filename_array = explode("/", $filename);
			$filename = end($filename_array);
			$file_ext_array = explode(".", $filename);
			$file_ext = end($file_ext_array);

			if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png')
			{
				$new_filename = uniqid().".".strtolower($file_ext);

				$pic_data = array(
					"user_id" => $user_id,
					"product_id" => $product_id,
					"product_images_filename" => $new_filename
				);
				$products_model->add_picture($pic_data);

				rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
			}

			//add logs
			$users_model = new users_Model;
			$user_logs = array(
				"user_id" => $user_id,
				"date_created" => time(),
				"log_details" => 9
			);
			$users_model->add_logs($user_logs);

			url::redirect("products");
		}
	}

	public function edit($id){
		$this->template->content = new View("products/edit");

		$user_id = $this->session->get('user_id');

		$products_model = new products_Model;

		$my_product = $products_model->get_my_product($id, $user_id);
		$count = count($my_product);
		if($count == 0)
		{
			url::redirect("products");
		}else{
			$product = $my_product->current();
		}

		$category_1 = $products_model->get_category_1();


		$this->template->content->product = $product;
		$this->template->content->category_1 = $category_1;

		$product_category_1 = $product->category_1;
		$list_product_category_2 = $products_model->get_categories($product_category_1, "category_1");
		$this->template->content->list_product_category_2 = $list_product_category_2;

		$product_category_2 = $product->category_2;
		$list_product_category_3 = $products_model->get_categories($product_category_2, "category_2");
		$this->template->content->list_product_category_3 = $list_product_category_3;

		$product_category_3 = $product->category_3;
		$list_product_category_4 = $products_model->get_categories($product_category_3, "category_3");
		$this->template->content->list_product_category_4 = $list_product_category_4;

		//get address
		$users_model = new users_Model;
		$addresses = $users_model->get_all_address($user_id);
		$this->template->content->addresses = $addresses;

		//countries
		$country_model = new country_Model;
		$countries = $country_model->get_all();
		$this->template->content->countries = $countries;

		if($_POST)
		{
			$user_id = $this->session->get('user_id');
			$product_name = $this->input->post('product_name');
			$description = $this->input->post('description');
			$department = $this->input->post('department') ? $this->input->post('department') : '';
			$category_1 = $this->input->post('category_1') ? $this->input->post('category_1') : '';
			$category_2 = $this->input->post('category_2') ? $this->input->post('category_2') : '';
			$category_3 = $this->input->post('category_3') ? $this->input->post('category_3') : '';
			$category_4 = $this->input->post('category_4') ? $this->input->post('category_4') : '';
			$qty = $this->input->post('qty');
			$qty_type = $this->input->post('qty_type');
			$number_of_unit = $this->input->post('number_of_unit') ? $this->input->post('number_of_unit') : '';

			$number_of_unit_per_pallet = $this->input->post('number_of_unit_per_pallet') ? $this->input->post('number_of_unit_per_pallet') : '';
			$case_per_pallet = $this->input->post('case_per_pallet') ? $this->input->post('case_per_pallet') : '';
			$unit_per_case_per_pallet = $this->input->post('unit_per_case_per_pallet') ? $this->input->post('unit_per_case_per_pallet') : '';

			$number_of_unit_per_case = $this->input->post('number_of_unit_per_case') ? $this->input->post('number_of_unit_per_case') : '';
			$unit_per_case = $this->input->post('unit_per_case') ? $this->input->post('unit_per_case') : '';

			$price = $this->input->post('price');
			$brand = $this->input->post('brand');

			$height = $this->input->post('height');
			$length = $this->input->post('length');
			$width = $this->input->post('width');
			$weight = $this->input->post('weight');
			$percentage_discount = $this->input->post('percentage_discount');
			$product_pickup_address = $this->input->post('product_pickup_address');
			$minimum_purchase = $this->input->post('minimum_purchase');
			$product_type = $this->input->post('product_type');
			$make_an_offer = $this->input->post('make_an_offer');
			$take_all_price = $this->input->post('take_all_price');
			$number_of_cases_per_pallet = $this->input->post('number_of_cases_per_pallet') ? $this->input->post('number_of_cases_per_pallet') : '';
			$pack_per_case = $this->input->post('pack_per_case') ? $this->input->post('pack_per_case') : '';
			$pack_per_case_size = $this->input->post('pack_per_case_size') ? $this->input->post('pack_per_case_size') : '';
			$shipping_fee_included = $this->input->post('shipping_fee_included') ? $this->input->post('shipping_fee_included') : 'No';
			$country_of_origin = $this->input->post('country_of_origin');
			$short_dated = $this->input->post('short_dated') ? $this->input->post('short_dated') : 'No';
			$on_sale = $this->input->post('on_sale') ? $this->input->post('on_sale') : 'No';
			$sale_price = $this->input->post('sale_price');
			$make_an_offer_minimum_amount = $this->input->post('make_an_offer_minimum_amount');
			$make_an_offer_minimum_qty = $this->input->post('make_an_offer_minimum_qty');
			$make_an_offer_auto_accept_amount = $this->input->post('make_an_offer_auto_accept_amount');
			$make_an_offer_auto_accept_qty = $this->input->post('make_an_offer_auto_accept_qty');

			//check if brand already exists on the brands table, if not, then add it
			$check_brand = $products_model->check_brand($brand);
			$check_brand_count = count($check_brand);
			if($check_brand_count == 0)
			{
				$brand_data = array("brand_name"=>$brand);
				$products_model->add_brand($brand_data);
			}

			$date = strtotime("+7 day");
			$time_duration = date('Y-m-d', $date);

			if($this->input->post('expiration_date'))
			{
				$expiration_date_array = explode("/", $this->input->post('expiration_date'));
				$expiration_date = $expiration_date_array[2]."-".$expiration_date_array[0]."-".$expiration_date_array[1]." "."23:59:59";
			}else{
				$expiration_date = "";
			}

			//for category searching
			// $cat_1_search = $products_model->get_one_category_1($category_1);
			// $cat_1_search_name = $cat_1_search->category_1_name;

			// $cat_2_search = $products_model->get_one_category_2($category_2);
			// $cat_2_search_name = $cat_2_search->category_2_name;

			// $cat_3_search = $products_model->get_one_category_3($category_3);
			// $cat_3_search_name = $cat_3_search->category_3_name;

			// $cat_4_search = $products_model->get_one_category_4($category_4);
			// $cat_4_search_name = $cat_4_search->category_4_name;

			if($category_1)
			{
				$cat_1_search = $products_model->get_one_category_1($category_1);
				$cat_1_search_name = $cat_1_search->category_1_name;
			}else{
				$cat_1_search_name = "";
			}

			if($category_2)
			{
				$cat_2_search = $products_model->get_one_category_2($category_2);
				$cat_2_search_name = $cat_2_search->category_2_name;
			}else{
				$cat_2_search_name = "";
			}

			if($category_3)
			{
				$cat_3_search = $products_model->get_one_category_3($category_3);
				$cat_3_search_name = $cat_3_search->category_3_name;
			}else{
				$cat_3_search_name = "";
			}

			if($category_4)
			{
				$cat_4_search = $products_model->get_one_category_4($category_4);
				$cat_4_search_name = $cat_4_search->category_4_name;
			}else{
				$cat_4_search_name = "";
			}

			$category_searching = $cat_1_search_name.' '.$cat_2_search_name.' '.$cat_3_search_name.' '.$cat_4_search_name;

			$data = array(
				"user_id" => $user_id,
				"product_name" => $product_name,
				"product_description" => $description,
				"brand" => $brand,
				"department" => $department,
				"category_1" => $category_1,
				"category_2" => $category_2,
				"category_3" => $category_3,
				"category_4" => $category_4,
				"category_searching" => $category_searching,
				"qty" => $qty,
				"qty_type" => $qty_type,
				"number_of_unit" => $number_of_unit,
				"number_of_unit_per_pallet" => $number_of_unit_per_pallet,
				"case_per_pallet" => $case_per_pallet,
				"unit_per_case_per_pallet" => $unit_per_case_per_pallet,
				"number_of_unit_per_case" => $number_of_unit_per_case,
				"unit_per_case" => $unit_per_case,
				"price" => $price,
				"time_duration" => $time_duration,
				"expiration_date" => $expiration_date,
				"height" => $height,
				"length" => $length,
				"width" => $width,
				"weight" => $weight,
				"percentage_discount" => $percentage_discount,
				"product_pickup_address" => $product_pickup_address,
				"minimum_purchase" => $minimum_purchase,
				"product_type" => $product_type,
				"make_an_offer" => $make_an_offer,
				"take_all_price" => $take_all_price,
				"number_of_cases_per_pallet" => $number_of_cases_per_pallet,
				"pack_per_case" => $pack_per_case,
				"pack_per_case_size" => $pack_per_case_size,
				"shipping_fee_included" => $shipping_fee_included,
				"country_of_origin" => $country_of_origin,
				"short_dated" => $short_dated,
				"on_sale" => $on_sale,
				"sale_price" => $sale_price,
				"make_an_offer_minimum_amount" => $make_an_offer_minimum_amount,
				"make_an_offer_minimum_qty" => $make_an_offer_minimum_qty,
				"make_an_offer_auto_accept_amount" => $make_an_offer_auto_accept_amount,
				"make_an_offer_auto_accept_qty" => $make_an_offer_auto_accept_qty
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


			$products_model->edit($id, $user_id, $data);

			//add logs
			$users_model = new users_Model;
			$user_logs = array(
				"user_id" => $user_id,
				"date_created" => time(),
				"log_details" => 10
			);
			$users_model->add_logs($user_logs);

			url::redirect("products");
		}
	}

	public function related_products($id){
		$this->template->content = new View("products/related_products");

		$user_id = $this->session->get('user_id');

		$products_model = new products_Model;

		$product = $products_model->get_one($id);
		$this->template->content->product = $product;

		$products = $products_model->get_user_products($user_id);
		$this->template->content->products = $products;

		$related_products = $products_model->get_related_products($id);
		$this->template->content->related_products = $related_products;
		$rp_ids = array();
		foreach($related_products as $rps)
		{
			$rp_ids[$rps->product_id] = $rps->product_id;
		}
		$this->template->content->rp_ids = $rp_ids;
	}

	public function add_related_product()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;
			$id = $this->input->post('id');
			$main_product_id = $this->input->post('main_product_id');

			$products_model = new products_Model;
			$products_model->add_related_product($main_product_id, $id);
		}
	}

	public function get_categories()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$id = $this->input->post('id');
 			$type = $this->input->post('type');

 			$products_model = new products_Model;
			$categories = $products_model->get_categories($id, $type);

			$ctr = 0;
			$data = array();

			if($type == "category_1")
			{
				foreach($categories as $row)
				{
					$data[$ctr] = array("key" => $row->category_2_id, "val" => $row->category_2_name);
					$ctr++;
				}
			}elseif($type == "category_2")
			{
				foreach($categories as $row)
				{
					$data[$ctr] = array("key" => $row->category_3_id, "val" => $row->category_3_name);
					$ctr++;
				}
			}elseif($type == "category_3")
  			{
  				foreach($categories as $row)
				{
					$data[$ctr] = array("key" => $row->category_4_id, "val" => $row->category_4_name);
					$ctr++;
				}
  			}

  			echo json_encode($data);
  			exit;
		}
	}

	public function offers($id)
	{
		$this->template->content = new View("products/offers");

		$user_id = $this->session->get('user_id');

		$products_model = new products_Model;
		$product = $products_model->get_one($id);
		$owner_id = $product->user_id;
		$this->template->content->owner_id = $owner_id;

		$offers = $products_model->get_offers($id);

		$this->template->content->product = $product;
		$this->template->content->offers = $offers;
	}

	public function accept_offer()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$user_id = $this->session->get('user_id');
			$offer_id = $this->input->post('id');

			$products_model = new products_Model;
			$users_model = new users_Model;

			$offer_data = array(
				"approved" => "Y",
				"date_approved" => date("Y-m-d H:i:s", time())
			);
			$products_model->update_offer($offer_id, $offer_data);

			$offer = $products_model->get_one_offer($offer_id);
			$offered_by_user_id = $offer->offered_by_user_id;
  			$product_id = $offer->product_id;

  			$product = $products_model->get_one_product($product_id);
  			$product_name = $product->product_name;

  			//add to my_basket table
  			$basket_data = array(
  				"user_id" => $offered_by_user_id,
  				"product_id" => $product_id,
  				"offer_id" => $offer_id,
  				"qty" => $offer->qty,
  				"price" => $offer->amount
  			);
  			$basket_id = $products_model->add_my_basket($basket_data);

  			$user = $users_model->get_one($offered_by_user_id);
  			$email = $user->email;

  			$to = $email;
			$from = "webmaster@logiclane.com";
			$subject = 'Your Offer has been approved.';
			$message = "
				Hi,

			  	Your offer on $product_name has been approved.
			  	Please click the link http://logiclane.com/my_basket/buy_now/$basket_id to make a payment.

			  	Thank you.
			";
			email::send($to, $from, $subject, nl2br($message), TRUE);
		}
	}

	public function retract_offer()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$user_id = $this->session->get('user_id');
			$offer_id = $this->input->post('id');

			$products_model = new products_Model;

			$offer_data = array(
				"retracted" => "Y"
			);
			$products_model->update_offer($offer_id, $offer_data);
		}
	}

	public function decline_offer()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$user_id = $this->session->get('user_id');
			$offer_id = $this->input->post('id');

			$products_model = new products_Model;

			$offer_data = array(
				"approved" => "N"
			);
			$products_model->update_offer($offer_id, $offer_data);
		}
	}


	public function pictures($id)
	{
		$this->template->content = new View("products/pictures");

		$user_id = $this->session->get('user_id');

		$products_model = new products_Model;
		$pictures = $products_model->get_pictures($id);

		$this->template->content->pictures = $pictures;

		if($_POST)
		{
			$filename = upload::save('picture');
			$filename_array = explode("/", $filename);
			$filename = end($filename_array);
			$file_ext_array = explode(".", $filename);
			$file_ext = end($file_ext_array);

			if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png')
			{
				$_POST['user_id'] = $this->session->get('user_id');
				$_POST['product_id'] = $id;

				$new_filename = uniqid().".".strtolower($file_ext);
				$_POST['product_images_filename'] = $new_filename;
				$products_model = new products_Model;
				$products_model->add_picture($_POST);

				rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
			}

			url::redirect("products/pictures/$id");
		}
	}

	public function delete()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;
			$this->session = Session::instance();
			$user_id = $this->session->get('user_id');
			$id = $this->input->post("id", null, true);
			$products_model = new products_Model;
			$products_model->delete($id, $user_id);	
		}	
	}

	public function delete_picture()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;
			$this->session = Session::instance();
			$user_id = $this->session->get('user_id');
			$id = $this->input->post("id", null, true);
			$filename = $this->input->post("filename", null, true);
			$products_model = new products_Model;
			$products_model->delete_picture($id, $user_id);	

			@unlink(DOCROOT."assets/upload/".$filename);
		}	
	}

	public function get_brands()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$products_model = new products_Model;

			$brand = $this->input->get("term");
			$query = $products_model->get_brands($brand);
			$data = array();
			foreach($query as $q)
			{
				$data[] = $q->brand_name;
			}

			echo json_encode($data);
		}
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

	public function offer_by_name($user_id)
	{
		$this->auto_render = FALSE;
		$users_model = new users_Model;
		$user = $users_model->get_one($user_id);	
		$offer_name = $user->firstname.' '.$user->lastname;
		return $offer_name;
	}

	public function get_shipping_info()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$buyer_items = $this->input->post("buyer_items");
			$product_id = $this->input->post("product_id");

			//get product info
			$products_model = new products_Model;
			$product = $products_model->get_one_product($product_id);

			$product_qty = $product->qty;

			$data = array();
			if($buyer_items > $product_qty)
			{
				$data['success'] = "N";
				$data['error_msg'] = "The number of products you want to buy is not available.";
			}else{
				$data['success'] = "Y";

				if($product->percentage_discount)
				{
					$percentage = "No";
					$percentage_discount_main = explode("\n", trim($product->percentage_discount));
					foreach($percentage_discount_main as $pdm)
					{
						$percentage_discount_array = explode(" ", $pdm);
						$percentage_discount_items_array = explode("-", $percentage_discount_array[0]);
						$percentage_discount_items_from = $percentage_discount_items_array[0];
						$percentage_discount_items_to = $percentage_discount_items_array[1];
						$discount = substr($percentage_discount_array[1], 0, 2);
						//echo $percentage_discount_items_from.'=='.$percentage_discount_items_to."==".$discount."<br />";
						if($buyer_items >= $percentage_discount_items_from && $buyer_items <= $percentage_discount_items_to){
							$product_price = $product->price * $buyer_items;
							$discounted_amount = ($product_price * $discount) / 100;
							$amount = $product_price - $discounted_amount;
							$data['amount'] = "$".number_format($amount, 2);
							$data['discounted_amount_label'] = "Y";
							$percentage = "Yes";
						}
					}
					//meaning it didn't get into the range for the discount
					if($percentage == "No")
					{
						$final_price = $product->price * $buyer_items;
						$data['amount'] = "$".number_format($final_price, 2);
						$data['discounted_amount_label'] = "N";
					}

				}else{
					$final_price = $product->price * $buyer_items;
					$data['amount'] = "$".number_format($final_price, 2);
					$data['discounted_amount_label'] = "N";
				}
			}

			echo json_encode($data);
		}
	}
}
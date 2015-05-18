<?php defined('SYSPATH') OR die('No direct access allowed.');

class Items_Controller extends Template_Controller {

	public $template = 'inside_tpl';

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
		//till here
	}

	public function add_to_cart($product_id)
	{
		$products_model = new products_Model;
		$data = array(
			"product_id" => $product_id,
			"qty" => 1,
			"cart_cookie" => $_COOKIE['cart_cookie']
		);
		$products_model->add_to_cart($data);
		url::redirect("items/cart");
	}

	public function cart()
	{
		$this->template->content = new View("items/cart");
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

	public function index(){
		$this->template->content = new View("items/index");
		$user_id = $this->session->get('user_id');

		$products_model = new products_Model;
		$products = $products_model->get_products($user_id);
		$this->template->content->products = $products;
	}

	public function watching(){
		$this->template->content = new View("items/watching");
		$user_id = $this->session->get('user_id');

		$products_model = new products_Model;
		$products = $products_model->get_products_with_my_offers($user_id);
		$this->template->content->products = $products;
	}

	public function details($id){
		$this->template->content = new View("items/details");

		$products_model = new products_Model;
		$product = $products_model->get_one_product($id);
		$this->template->content->product = $product;

		$category_1_id = $product->category_1;
		$category_2_id = $product->category_2;
		$category_3_id= $product->category_3;
		$category_4_id = $product->category_4;

		$category_1_query = $products_model->get_one_category_1($category_1_id);
		$category_1 = $category_1_query->category_1_name;
		$this->template->content->category_1 = $category_1;

		$category_2_query = $products_model->get_one_category_2($category_2_id);
		$category_2 = $category_2_query->category_2_name;
		$this->template->content->category_2 = $category_2;

		$category_3_query = $products_model->get_one_category_3($category_3_id);
		$category_3 = $category_3_query->category_3_name;
		$this->template->content->category_3 = $category_3;

		$category_4_query = $products_model->get_one_category_4($category_4_id);
		$category_4 = $category_4_query->category_4_name;
		$this->template->content->category_4 = $category_4;

		//get pictures
		$pictures = $products_model->get_pictures($id);
		$this->template->content->pictures = $pictures;
	}

	public function make_an_offer($id){
		$this->template = View::factory('popup_tpl');
		$this->template->content = new View("items/make_an_offer");

		$products_model = new products_Model;
		$product = $products_model->get_one_product($id);
		$this->template->content->product = $product;

		$this->template->content->product_id = $id;

		if($_POST)
		{

			$user_id = $this->session->get('user_id');
			$product_id = $this->input->post("product_id");
			$amount = $this->input->post("amount");
			$qty = $this->input->post("qty");
			if($this->input->post("shipdate"))
			{
				// $shipdate_array = explode("/", $this->input->post("shipdate"));
				// $shipdate = $shipdate_array[2]."-".$shipdate_array[0]."-".$shipdate_array[1]." "."00:00:00";
				$shipdate = $this->input->post("shipdate");
			}else{
				$shipdate = "";
			}
			$shipdate = "";
			$note = "";

			$products_model = new products_Model;

			$data = array(
				"offered_by_user_id" => $user_id,
				"product_id" => $product_id,
				"amount" => $amount,
				"qty" => $qty,
				"shipdate" => $shipdate,
				"note" => $note
			);
			$offer_id = $products_model->add_offer($data);

			$product_info = $products_model->get_one_product($product_id);
			$product_owner_id = $product_info->user_id;
			$product_name = $product_info->product_name;
			$minimum_offer_amount = $product_info->make_an_offer_minimum_amount;
			$minimum_offer_qty = $product_info->make_an_offer_minimum_qty;
			$make_an_offer_auto_accept_amount = $product_info->make_an_offer_auto_accept_amount;
			$make_an_offer_auto_accept_qty = $product_info->make_an_offer_auto_accept_qty;
			$product_current_qty = $product_info->qty;

			//check if the offer is ok with auto accept values
			if($qty <= $product_current_qty AND $amount >= $make_an_offer_auto_accept_amount AND $qty >= $make_an_offer_auto_accept_qty)
			{
				$user_id = $this->session->get('user_id');

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
	  			// $basket_data = array(
	  			// 	"user_id" => $offered_by_user_id,
	  			// 	"product_id" => $product_id,
	  			// 	"offer_id" => $offer_id,
	  			// 	"qty" => $offer->qty,
	  			// 	"price" => $offer->amount
	  			// );
	  			// $basket_id = $products_model->add_my_basket($basket_data);

	  			//update the product
	  			$new_product_qty = $product_current_qty - $qty;
	  			$update_data = array("qty" => $new_product_qty);
	  			$products_model->edit_product_qty($product_id, $update_data);

	  			$user = $users_model->get_one($offered_by_user_id);
	  			$email = $user->email;
	  			$offer_by = $user->firstname.' '.$user->lastname;

	  			//Please click the link http://logiclane.com/my_basket/buy_now/$basket_id to make a payment.

	  			//send to buyer
	  			$to = $email;
				$from = "webmaster@logiclane.com";
				$subject = 'Your Offer has been approved.';
				$message = "
					Hi,

				  	Your offer on $product_name has been approved.
				  	You will received an email notification about your order.

				  	Thank you.
				";
				email::send($to, $from, $subject, nl2br($message), TRUE);

				//send to seller
				$owner_info = $users_model->get_one($product_owner_id);
				$email = $owner_info->email;
				$owner_name = $owner_info->firstname.' '.$owner_info->lastname;
				$to = $email;
				$from = "webmaster@logiclane.com";
				$subject = 'The Offer on your product has been approved.';
				$message = "
					Hi $owner_name,

				  	The offer on $product_name by $offer_by has been approved.

				  	Thank you.
				";
				email::send($to, $from, $subject, nl2br($message), TRUE);
			}


			//add logs
			$users_model = new users_Model;
			$user_logs = array(
				"user_id" => $user_id,
				"date_created" => time(),
				"log_details" => 13
			);
			$users_model->add_logs($user_logs);

			$user_name = $this->session->get("firstname").' '.$this->session->get("lastname");

			$rejected = "No";
			if($amount >= $minimum_offer_amount AND $qty >= $minimum_offer_qty)
			{
				//send email notification seller
				$owner_info = $users_model->get_one($product_owner_id);
				$email = $owner_info->email;
				$owner_name = $owner_info->firstname.' '.$owner_info->lastname;

				$to = $email;
				$from = "webmaster@logiclane.com";
				$subject = 'There was on offer on your product';
				$message = $user_name.' make an offer on your product'. $product_name;
				email::send($to, $from, $subject, nl2br($message), TRUE);

				//send email notification buyer
				$user = $users_model->get_one($user_id);
	  			$email = $user->email;
	  			$to = $email;
				$from = "webmaster@logiclane.com";
				$subject = 'Your Offer has been sent.';
				$message = "
					Hi,

				  	Your offer on $product_name has been sent.
				  	You will received an email notification about your order.

				  	Thank you.
				";
				email::send($to, $from, $subject, nl2br($message), TRUE);
			}else{
				$rejected = "Yes";
			}

			//check if how many offers this client made for this particular product, if greater than 3, send email to admin
			$offers = $products_model->get_offers($id);
			$count = count($offers);
			if($count > 3)
			{
				$admin_model = new admin_Model;
				$admins = $admin_model->get_all();
				foreach($admins as $admin)
				{
					$admin_email = $admin->email;
					if($admin_email)
					{
						$to = $admin_email;
						$from = "webmaster@logiclane.com";
						$subject = 'There was on offer on product '. $product_name;
						$message = $user_name.' make an offer on product'. $product_name;
						email::send($to, $from, $subject, nl2br($message), TRUE);	
					}
				}
			}

			if($rejected == "Yes")
			{
				url::redirect("popup/close_alert/rejected");
			}else{
				url::redirect("popup/close_msg/offer");
			}
		}
	}

	public function make_counter_offer($id, $offered_by_user_id){
		$this->template = View::factory('popup_tpl');
		$this->template->content = new View("items/make_counter_offer");

		$this->template->content->product_id = $id;
		$this->template->content->offered_by_user_id = $offered_by_user_id;

		if($_POST)
		{
			$user_id = $this->session->get('user_id');
			$product_id = $this->input->post("product_id");
			$offered_by_user_id = $this->input->post("offered_by_user_id");
			$amount = $this->input->post("amount");
			$qty = $this->input->post("qty");
			// $shipdate_array = explode("/", $this->input->post("shipdate"));
			// $shipdate = $shipdate_array[2]."-".$shipdate_array[0]."-".$shipdate_array[1]." "."00:00:00";
			if($this->input->post("shipdate"))
			{
				// $shipdate_array = explode("/", $this->input->post("shipdate"));
				// $shipdate = $shipdate_array[2]."-".$shipdate_array[0]."-".$shipdate_array[1]." "."00:00:00";
				$shipdate = $this->input->post("shipdate");
			}else{
				$shipdate = "";
			}
			$shipdate = "";
			$note = "";

			$products_model = new products_Model;

			$data = array(
				"offered_by_user_id" => $offered_by_user_id,
				"offered_by_owner_id" => $user_id,
				"product_id" => $product_id,
				"amount" => $amount,
				"qty" => $qty,
				"shipdate" => $shipdate,
				"note" => $note
			);
			$products_model->add_offer($data);

			$product_info = $products_model->get_one_product($product_id);
			$product_owner_id = $product_info->user_id;
			$product_name = $product_info->product_name;

			//add logs
			$users_model = new users_Model;
			$user_logs = array(
				"user_id" => $user_id,
				"date_created" => time(),
				"log_details" => 13
			);
			$users_model->add_logs($user_logs);

			//send email notification
			$owner_info = $users_model->get_one($product_owner_id);
			$email = $owner_info->email;
			$owner_name = $owner_info->firstname.' '.$owner_info->lastname;

			$user_name = $this->session->get("firstname").' '.$this->session->get("lastname");

			$to = $email;
			$from = "webmaster@logiclane.com";
			$subject = 'There was on offer on your product';
			$message = $user_name.' make an offer on your product'. $product_name;
			email::send($to, $from, $subject, nl2br($message), TRUE);

			url::redirect("popup/close_msg/counter_offer");
		}
	}

	public function buy_it_now($id)
	{
		$this->template->content = new View("items/buy_it_now");

		$products_model = new products_Model;
		$product = $products_model->get_one_product($id);
		$this->template->content->product = $product;

		$user_id = $this->session->get('user_id');
		$users_model = new users_Model;

		$user = $users_model->get_one($user_id);
		$this->template->content->user = $user;

		$user_address = $users_model->get_primary_address($user_id);
		if(count($user_address) == 0)
		{
			$user_address = new stdClass;
			$user_address->user_address_1 = "";
			$user_address->user_address_2 = "";
			$user_address->user_address_city = "";
			$user_address->user_address_state = "";
			$user_address->user_address_zip = "";
		}else{
			$user_address = $user_address->current();
		}
		$this->template->content->user_address = $user_address;

		$owner_id = $product->user_id;
		$owner_address = $users_model->get_primary_address($owner_id);
		if(count($owner_address) == 0)
		{
			$owner_address = new stdClass;
			$owner_address->user_address_1 = "";
			$owner_address->user_address_2 = "";
			$owner_address->user_address_city = "";
			$owner_address->user_address_state = "";
			$owner_address->user_address_zip = "";
		}else{
			$owner_address = $owner_address->current();
		}
		$this->template->content->owner_address = $owner_address;
	}
}
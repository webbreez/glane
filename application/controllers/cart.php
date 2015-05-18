<?php defined('SYSPATH') OR die('No direct access allowed.');

class Cart_Controller extends Template_Controller {

	public $template = 'inside_tpl';

	public function __construct()
	{
		parent::__construct();

		$this->session = Session::instance();		

		$products_model = new products_Model;
		$category_1 = $products_model->get_category_1();

		$this->template->category_1 = $category_1;
		//till here
	}

	public function take_all($product_id, $qty)
	{
		$ip_address = productsvisit_helper::get_ip_address();

		$products_model = new products_Model;
		$check_cart = $products_model->check_cart($product_id, $this->session->get("user_id"), $ip_address);
		$check_cart_count = count($check_cart);
		if($check_cart_count == 0)
		{
			$data = array(
				"product_id" => $product_id,
				"qty" => $qty,
				"visitor_ip" => $ip_address,
				"user_id" => $this->session->get("user_id")
			);
			$products_model->add_to_cart($data);

		}else{
			$row = $check_cart->current();
			$cart_item_id = $row->cart_item_id;

			$data = array(
				"qty" => $qty
			);
			$products_model->edit_cart($cart_item_id, $data);
		}
		
		url::redirect("cart/index");
	}

	public function checkout_offer($offer_id)
	{
		$ip_address = productsvisit_helper::get_ip_address();
		$products_model = new products_Model;
		$check_offer = $products_model->check_offer($offer_id, $this->session->get("user_id"));
		$count = count($check_offer);
		if($count == 0)
		{
			url::redirect("index/products");
		}else{
			//check if the offer has already been checkout before
			$offer = $check_offer->current();
			$product_id = $offer->product_id;
			$check_offer_on_cart = $products_model->check_offer_on_cart($offer_id, $this->session->get("user_id"), $product_id);
			$count_check_offer_on_cart = count($check_offer_on_cart);
			if($count_check_offer_on_cart == 0)
			{
				$data = array(
					"product_id" => $offer->product_id,
					"visitor_ip" => $ip_address,
					"user_id" => $this->session->get("user_id"),
					"offer" => "Yes",
					"offer_id" => $offer_id,
					"offer_qty" => $offer->qty,
					"offer_price" => $offer->amount,
					"offer_total_price" => $offer->amount,
					"price" => 0
				);
				$products_model->add_to_cart($data);
			}
			url::redirect("cart/offer_shipping_address/$offer_id/$product_id");
		}
	}

	public function add_to_cart($product_id, $qty = 1)
	{
		$ip_address = productsvisit_helper::get_ip_address();

		//check first if the item as already added to the cart
		$products_model = new products_Model;
		$check_cart = $products_model->check_cart($product_id, $this->session->get("user_id"), $ip_address);
		$check_cart_count = count($check_cart);
		if($check_cart_count == 0)
		{
			$data = array(
				"product_id" => $product_id,
				"qty" => $qty,
				"visitor_ip" => $ip_address,
				"user_id" => $this->session->get("user_id")
			);
			$products_model->add_to_cart($data);

		}else{
			$row = $check_cart->current();
			$cart_item_id = $row->cart_item_id;
			$old_qty = $row->qty;
			$new_qty = $old_qty + $qty;

			$data = array(
				"qty" => $new_qty
			);
			$products_model->edit_cart($cart_item_id, $data);
		}
		
		url::redirect("cart/index");
	}

	public function add_to_combined_shipping($product_id, $qty = 1)
	{
		$ip_address = productsvisit_helper::get_ip_address();
		$products_model = new products_Model;
		//get shipping address of the product
		$shipping_address = $products_model->get_one($product_id);
		$product_pickup_address = $shipping_address->product_pickup_address;

		//check first if the item as already added to the cart
		$check_cart = $products_model->check_cart_combined_shipping($product_pickup_address, $product_id, $this->session->get("user_id"), $ip_address);
		$check_cart_count = count($check_cart);
		if($check_cart_count == 0)
		{
			$data = array(
				"product_id" => $product_id,
				"qty" => $qty,
				"visitor_ip" => $ip_address,
				"user_id" => $this->session->get("user_id"),
				"combined_shipping" => "Yes",
				"combined_shipping_seller_address_id" => $product_pickup_address
			);
			$products_model->add_to_cart($data);

		}else{
			$row = $check_cart->current();
			$cart_item_id = $row->cart_item_id;
			$old_qty = $row->qty;
			$new_qty = $old_qty + $qty;

			$data = array(
				"qty" => $new_qty
			);
			$products_model->edit_cart($cart_item_id, $data);
		}
		
		//url::redirect("cart/index");
		url::redirect("combined_shipping/index");
	}

	public function duplicate($product_id)
	{
		$ip_address = productsvisit_helper::get_ip_address();

		$products_model = new products_Model;
		$data = array(
			"product_id" => $product_id,
			"qty" => 1,
			"visitor_ip" => $ip_address,
			"user_id" => $this->session->get("user_id")
		);
		$products_model->add_to_cart($data);

		url::redirect("cart/index");
	}

	public function check_cart_qty()
	{
		$error_msg = "";
		$ip_address = productsvisit_helper::get_ip_address();

		$products_model = new products_Model;
		$cart = $products_model->cart($this->session->get("user_id"), $ip_address);
		foreach($cart as $c)
		{
			$product_id = $c->product_id;
			$check_cart_qty = $products_model->check_cart_qty($product_id, $this->session->get("user_id"), $ip_address);
			$pqty = 0;
			foreach($check_cart_qty as $ccq)
			{
				$ccq_qty = $ccq->qty;
				$pqty = $pqty + $ccq_qty;
			}

			$item = $products_model->get_one($product_id);
			$item_qty = $item->qty;
			$item_name = $item->product_name;
			if($pqty > $item_qty AND $c->offer == "No")
			{
				$error_msg = $item_qty." items left for ".$item_name.". Please update your cart.";
			}
		}

		return $error_msg;
	}

	public function index()
	{
		$this->template->content = new View("cart/index");

		$ip_address = productsvisit_helper::get_ip_address();

		//check cart items quantity
		$check_cart_qty = $this->check_cart_qty();
		if($check_cart_qty)
		{
			$this->template->content->check_cart_qty = $check_cart_qty;
		}else{
			$this->template->content->check_cart_qty = "";
		}

		//checking if there is a take all product with different shipping address
		$products_model = new products_Model;
		$cart = $products_model->cart($this->session->get("user_id"), $ip_address);
		$this->template->content->cart = $cart;
	}

	public function check_cart_take_all($product_id, $actual_product_qty)
	{
		$result = "No";
		$ip_address = productsvisit_helper::get_ip_address();
		$products_model = new products_Model;

		$take_all_products = $products_model->cart_take_all($this->session->get("user_id"), $ip_address, $product_id);
		$count = count($take_all_products);
		if($count > 1)
		{
			$take_all_products_group_by = $products_model->cart_take_all_group_by($this->session->get("user_id"), $ip_address, $product_id);
			$row = $take_all_products_group_by->current();
			$total_qty = $row->p_total_qty;
			if($actual_product_qty == $total_qty)
			{
				$result = "Yes";
			}
		}
		return $result;
	}

	public function check_cart_take_all_2($product_id, $actual_product_qty, $uniq_id)
	{
		$result = "No";
		$ip_address = productsvisit_helper::get_ip_address();
		$products_model = new products_Model;

		$take_all_products = $products_model->cart_take_all_2($this->session->get("user_id"), $ip_address, $product_id, $uniq_id);
		$count = count($take_all_products);

		if($count > 1)
		{
			$take_all_products_group_by = $products_model->cart_take_all_group_by_2($this->session->get("user_id"), $ip_address, $product_id, $uniq_id);
			$row = $take_all_products_group_by->current();
			$total_qty = $row->p_total_qty;
			if($actual_product_qty == $total_qty)
			{
				$result = "Yes";
			}
		}
		return $result;
	}

	public function update_cart_product_price($cart_item_id, $price, $total_price, $price_desc, $take_all_qty)
	{
		$products_model = new products_Model;
		$cart = $products_model->edit_cart($cart_item_id, array("price"=>$price, "total_price"=>$total_price, "price_desc"=>$price_desc, "take_all_qty"=>$take_all_qty));
	}

	public function update_qty()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$id = $this->input->post("id");
			$qty = $this->input->post("qty");

			if($qty == 0)
			{
				$products_model = new products_Model;
				$products_model->delete_cart_item($id);
				echo json_encode(array("error"=>"N", "error_msg"=>"", "remove"=>"Y", "id"=>$id));
				exit;
			}else{
				//check if how many more stocks left for this particular product
				$products_model = new products_Model;
				$get_cart_product_id = $products_model->get_one_cart($id);
				$cart_product_id = $get_cart_product_id->product_id;
				$check_stocks = $products_model->get_one($cart_product_id);
				$product_stocks = $check_stocks->qty;
				if($product_stocks < $qty)
				{
					echo json_encode(array("error"=>"Y", "error_msg"=>"Only $product_stocks items left.", "id"=>$id));
					exit;
				}

				$data = array(
					"qty" => $qty
				);
				
				$products_model->edit_cart($id, $data);

				$c = $products_model->get_one_cart($id);
				$percentage_discount = $c->percentage_discount;

				$discounted_amount = 0;
				$discount_label = "";

				if($percentage_discount)
				{
					$percentage_discount_main = explode("\n", trim($percentage_discount));
					foreach($percentage_discount_main as $pdm)
					{
						$percentage_discount_array = explode(" ", $pdm);
						$percentage_discount_items_array = explode("-", $percentage_discount_array[0]);
						$percentage_discount_items_from = $percentage_discount_items_array[0];
						$percentage_discount_items_to = $percentage_discount_items_array[1];
						if($qty >= $percentage_discount_items_from && $qty <= $percentage_discount_items_to){
							$discount = substr($percentage_discount_array[1], 0, 2);
							$discount_label = "(".$discount." % discount)";
							$product_price = $c->price * $qty;
							$da = ($product_price * $discount) / 100;
							$amount = $product_price - $da;
							$discounted_amount = number_format($amount, 2);
						}
					}
					
					if($discounted_amount != 0)
					{
						$final_amount = $discounted_amount;
					}else{
						$price = $c->price * $qty;
						$final_amount = number_format($price, 2);
					}
				}else{
					$price = $c->price * $qty;
					$final_amount = number_format($price, 2);
				}

				echo json_encode(array("error"=>"N", "error_msg"=>"", "remove"=>"N", "amount" => $final_amount, "discount"=> $discount_label));
				exit;
			}	
		}
	}

	public function shipping_address()
	{
		if(!$this->session->get('user_id')){
			url::redirect("index/products");
		}

		$check_cart_qty = $this->check_cart_qty();

		if($check_cart_qty)
		{
			url::redirect("cart/index");
		}

		$this->template->content = new View("cart/shipping_address");

		$users_model = new users_Model;
		$shipping = $users_model->get_shipping_address($this->session->get("user_id"));
		$this->template->content->shipping = $shipping;

		//get the total
		$ip_address = productsvisit_helper::get_ip_address();
		$products_model = new products_Model;
		$cart = $products_model->cart($this->session->get("user_id"), $ip_address);
		$this->template->content->cart = $cart;
		$user_type = $this->session->get('user_type');
		$total = 0;
		$total_qty = 0;
		$ctr = 0;
		foreach($cart as $c)
		{
			//check if the product of tagged as charity
			$cart_item_id = $c->cart_item_id;
			$product_type = $c->product_type;
			if($product_type == "charity" AND $user_type != "charity")
			{
				$products_model->delete_cart_item($cart_item_id);
			}
			//till here
			$price = $c->price;
			$qty = $c->qty;
			$initial_price = $qty * $price;
			$total = $total + $initial_price;
			$total_qty  = $total_qty + $qty;
			$ctr++;
			//check if there is a minimum set on a particular product
			$product_id = $c->product_id;
			$product = $products_model->get_one($product_id);
			$minimum_purchase = $product->minimum_purchase;
			$actual_qty = $product->qty;
			if($actual_qty <= $qty)
			{
				if($minimum_purchase != 0 AND $qty > $actual_qty)
				{
					url::redirect("cart/index");
				}
			}else{
				if($minimum_purchase != 0 AND $qty < $minimum_purchase)
				{
					url::redirect("cart/index");
				}
			}
		}

		if($ctr == 0)
		{
			url::redirect("index/products");
		}

		$cart = $products_model->cart($this->session->get("user_id"), $ip_address);
		$this->template->content->cart = $cart;
		
		$this->template->content->total = $total;
		$this->template->content->total_qty = $total_qty;
	}

	public function offer_shipping_address($offer_id, $product_id)
	{
		if(!$this->session->get('user_id')){
			url::redirect("index/products");
		}

		$products_model = new products_Model;
		$check_offer_on_cart = $products_model->check_offer_on_cart($offer_id, $this->session->get("user_id"), $product_id);
		$count = count($check_offer_on_cart);
		if($count == 0)
		{
			url::redirect("index/products");
		}

		$this->template->content = new View("cart/offer_shipping_address");

		$users_model = new users_Model;
		$shipping = $users_model->get_shipping_address($this->session->get("user_id"));
		$this->template->content->shipping = $shipping;

		$ip_address = productsvisit_helper::get_ip_address();
		$cart = $products_model->cart_offer($this->session->get("user_id"), $ip_address, $product_id);
		$this->template->content->cart = $cart;
		$this->template->content->offer_id = $offer_id;
	}

	public function get_shipping_address($id, $qty, $cart_item_id)
	{
		$this->template = View::factory('popup_tpl');
		$this->template->content = new View("cart/shipping_info");

		//$id = $this->input->post("id");
		// $qty = $this->input->post("qty");
		// $total = $this->input->post("total");

		$users_model = new users_Model;
		$address = $users_model->get_address($id);	

		//get the shipping courier
		$shipping_info = "";
		$shipping_cost = 0;

		$product_qty = $qty;

        $product_weight = 100;
        $product_length = 200;
        $product_width = 100;

        $shipping_data = array(
            "senderCity" => $address->user_address_city,
            "senderState" => $address->user_address_state,
            "senderZip" => $address->user_address_zip,
            "senderCountryCode" => "US",
            "receiverCity" => $address->user_address_city,
            "receiverState" => $address->user_address_state,
            "receiverZip" => $address->user_address_zip,
            "receiverCountryCode" => "US",
            "piecesOfLineItem" => $product_qty,
            "handlingUnitHeight" => $product_weight,
            "handlingUnitLength" => $product_length,
            "handlingUnitWidth" => $product_width,
            "lineItemWeight" => $product_weight
        );

        $shipping = wwex_helper::freightShipmentQuoteResult($shipping_data);
        $success = $shipping->quoteSpeedFreightShipmentReturn->responseStatusCode;

        if($success == 1)
        {
        	$ctr = 0;
            foreach($shipping->quoteSpeedFreightShipmentReturn->freightShipmentQuoteResults->freightShipmentQuoteResult as $freightShipmentQuoteResult)
            {
                if($ctr == 0)
                {
                    $shipping_cost = $freightShipmentQuoteResult->totalPrice;
                    $checked = "checked=checked";
                }else{
                	$checked = "";
                }

                $total_price = base64_encode($freightShipmentQuoteResult->totalPrice);

            	$shipping_info .= "
                <table border=\"0\">
                <tr>
                    <td>
                    	<input type=\"radio\" class=\"required\" class=\"shipment_details\" name=\"shipment_details\" value=\"$freightShipmentQuoteResult->shipmentQuoteId|$freightShipmentQuoteResult->carrierSCAC|$freightShipmentQuoteResult->carrierName|$total_price|$freightShipmentQuoteResult->transitDays|$freightShipmentQuoteResult->guaranteedService|$freightShipmentQuoteResult->highCostDeliveryShipment|$freightShipmentQuoteResult->interline|$freightShipmentQuoteResult->nmfcRequired|$freightShipmentQuoteResult->carrierNotifications\" $checked>&nbsp;&nbsp;&nbsp;Shipment Quote Id: $freightShipmentQuoteResult->shipmentQuoteId
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carrier SCAC: $freightShipmentQuoteResult->carrierSCAC</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carrier Name: $freightShipmentQuoteResult->carrierName</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Price: $freightShipmentQuoteResult->totalPrice</b></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Transit Days: $freightShipmentQuoteResult->transitDays</b></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guaranteed Service: $freightShipmentQuoteResult->guaranteedService</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;High Cost Delivery Shipment: $freightShipmentQuoteResult->highCostDeliveryShipment</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Interline: $freightShipmentQuoteResult->interline</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nmfc Required: $freightShipmentQuoteResult->nmfcRequired</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carrier Notifications: $freightShipmentQuoteResult->carrierNotifications</td>
                </tr>
                <tr>
                	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" value=\"Submit\" class=\"submit\"></td>
                </tr>
                </table>
                <br /><br />
                ";
                $ctr++;
            } 

            // $shipping_info .= "
            // <table border=\"1\" style=\"float:left;\">
            	
            //   </table>
            // ";
        }else{
        	if(count($shipping->quoteSpeedFreightShipmentReturn->errorDescriptions->freightShipmentErrorDescription) == 1)
            {
                $shipping_info = $shipping->quoteSpeedFreightShipmentReturn->errorDescriptions->freightShipmentErrorDescription->errorDescription.'<br />';
            }else{
                foreach($shipping->quoteSpeedFreightShipmentReturn->errorDescriptions->freightShipmentErrorDescription as $errorDescription)
                {
                    $shipping_info .= $errorDescription->errorDescription.'<br />';
                }
            }
        }

        $this->template->content->shipping_info = $shipping_info;
        $this->template->content->id = $id;
        $this->template->content->cart_id = $cart_item_id;
	}

	public function get_shipping_address2()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$id = $this->input->post("id");
			$qty = $this->input->post("qty");
			$total = $this->input->post("total");

			$users_model = new users_Model;
			$address = $users_model->get_address($id);	

			//get the shipping courier
			$shipping_info = "";
			$shipping_cost = 0;

			$product_qty = $qty;

            $product_weight = 100;
            $product_length = 200;
            $product_width = 100;

            $shipping_data = array(
                "senderCity" => $address->user_address_city,
                "senderState" => $address->user_address_state,
                "senderZip" => $address->user_address_zip,
                "senderCountryCode" => "US",
                "receiverCity" => $address->user_address_city,
                "receiverState" => $address->user_address_state,
                "receiverZip" => $address->user_address_zip,
                "receiverCountryCode" => "US",
                "piecesOfLineItem" => $product_qty,
                "handlingUnitHeight" => $product_weight,
                "handlingUnitLength" => $product_length,
                "handlingUnitWidth" => $product_width,
                "lineItemWeight" => $product_weight
            );

            $shipping = wwex_helper::freightShipmentQuoteResult($shipping_data);
            $success = $shipping->quoteSpeedFreightShipmentReturn->responseStatusCode;

            if($success == 1)
            {
            	$ctr = 0;
                foreach($shipping->quoteSpeedFreightShipmentReturn->freightShipmentQuoteResults->freightShipmentQuoteResult as $freightShipmentQuoteResult)
                {
                    if($ctr == 0)
                    {
                        $shipping_cost = $freightShipmentQuoteResult->totalPrice;
                        $checked = "checked=checked";
                    }else{
                    	$checked = "";
                    }

                	$shipping_info .= "
	                <table border=\"0\">
	                <tr>
	                    <td><input type=\"radio\" class=\"required\" class=\"shipment_details\" name=\"shipment_details\" value=\"$freightShipmentQuoteResult->shipmentQuoteId|$freightShipmentQuoteResult->totalPrice\" $checked>&nbsp;Shipment Quote Id: $freightShipmentQuoteResult->shipmentQuoteId</td>
	                </tr>
	                <tr>
	                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carrier SCAC: $freightShipmentQuoteResult->carrierSCAC</td>
	                </tr>
	                <tr>
	                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carrier Name: $freightShipmentQuoteResult->carrierName</td>
	                </tr>
	                <tr>
	                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Price: $freightShipmentQuoteResult->totalPrice</b></td>
	                </tr>
	                <tr>
	                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Transit Days: $freightShipmentQuoteResult->transitDays</b></td>
	                </tr>
	                <tr>
	                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guaranteed Service: $freightShipmentQuoteResult->guaranteedService</td>
	                </tr>
	                <tr>
	                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;High Cost Delivery Shipment: $freightShipmentQuoteResult->highCostDeliveryShipment</td>
	                </tr>
	                <tr>
	                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Interline: $freightShipmentQuoteResult->interline</td>
	                </tr>
	                <tr>
	                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nmfc Required: $freightShipmentQuoteResult->nmfcRequired</td>
	                </tr>
	                <tr>
	                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carrier Notifications: $freightShipmentQuoteResult->carrierNotifications</td>
	                </tr>
	                </table>
	                <br /><br />
	                ";
                    $ctr++;
                } 
            }else{
            	if(count($shipping->quoteSpeedFreightShipmentReturn->errorDescriptions->freightShipmentErrorDescription) == 1)
                {
                    $shipping_info = $shipping->quoteSpeedFreightShipmentReturn->errorDescriptions->freightShipmentErrorDescription->errorDescription.'<br />';
                }else{
                    foreach($shipping->quoteSpeedFreightShipmentReturn->errorDescriptions->freightShipmentErrorDescription as $errorDescription)
                    {
                        $shipping_info .= $errorDescription->errorDescription.'<br />';
                    }
                }
            }


			$data = array(
				"address_1" => $address->user_address_1,
				"address_2" => $address->user_address_2,
				"city" => $address->user_address_city,
				"state" => $address->user_address_state,
				"zip" => $address->user_address_zip,
				"shipping_info" => $shipping_info
			);

			echo json_encode($data);
		}
	}

	public function update_cart_shipping_address()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$shipping_address_id = $this->input->post("shipping_address_id");
			$cart_id = $this->input->post("cart_id");

			$products_model = new products_Model;
			$cart = $products_model->edit_cart($cart_id, array("shipping_address_id"=>$shipping_address_id));
		}
	}

	public function save_cart_shipping_address()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			// $id = $this->input->post("id");
			// $total = $this->input->post("total");
			// $shipment_details = explode("|", $this->input->post("shipment_details"));
			// $shipment_quote_id = $shipment_details[0];
			// $shipment_total_price = $shipment_details[1];

			$uniq_id = uniqid();
			// $data = array(
			// 	"shipping_id" => $id,
			// 	"uniq_id" => $uniq_id,
			// 	"shipment_quote_id" => $shipment_quote_id,
			// 	"shipment_total_price" => $shipment_total_price,
			// 	"cart_total" => $total
			// );

			// $products_model = new products_Model;
			// $products_model->save_cart_shipping_address($data);

			$ip_address = productsvisit_helper::get_ip_address();

			$products_model = new products_Model;

			$shipping_error = "";
			$cart = $products_model->cart($this->session->get("user_id"), $ip_address);
			foreach($cart as $c)
			{
				$shipping_address_id = $c->shipping_address_id;
				if(!$shipping_address_id)
				{
					$shipping_error .= ($shipping_error ? ", " : " ") .$c->product_name;
				}
			}

			if($shipping_error)
			{
				$se = "You didn't set yet a shipping address for $shipping_error.";
				echo json_encode(array("error"=>"Y","error_msg"=> $se, "uniq_id"=>$uniq_id));
			}else{

				//update the cart_items table
				$ip_address = productsvisit_helper::get_ip_address();
				$user_id = $this->session->get("user_id");

				$products_model->edit_cart_uniqid($user_id, $ip_address, $uniq_id);

				echo json_encode(array("error"=>"N","uniq_id"=>$uniq_id,"error_msg"=>""));
			}
		}
	}

	public function save_cart_shipping_address_offer()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			// $id = $this->input->post("id");
			// $total = $this->input->post("total");
			// $shipment_details = explode("|", $this->input->post("shipment_details"));
			// $shipment_quote_id = $shipment_details[0];
			// $shipment_total_price = $shipment_details[1];

			$uniq_id = uniqid();
			// $data = array(
			// 	"shipping_id" => $id,
			// 	"uniq_id" => $uniq_id,
			// 	"shipment_quote_id" => $shipment_quote_id,
			// 	"shipment_total_price" => $shipment_total_price,
			// 	"cart_total" => $total
			// );

			// $products_model = new products_Model;
			// $products_model->save_cart_shipping_address($data);

			$ip_address = productsvisit_helper::get_ip_address();

			$products_model = new products_Model;
			$product_id = $this->input->post("product_id");
			$shipping_error = "";
			$cart = $products_model->cart_offer($this->session->get("user_id"), $ip_address, $product_id);
			foreach($cart as $c)
			{
				$shipping_address_id = $c->shipping_address_id;
				if(!$shipping_address_id)
				{
					$shipping_error .= ($shipping_error ? ", " : " ") .$c->product_name;
				}
			}

			if($shipping_error)
			{
				$se = "You didn't set yet a shipping address for $shipping_error.";
				echo json_encode(array("error"=>"Y","error_msg"=> $se, "uniq_id"=>$uniq_id));
			}else{

				//update the cart_items table
				$ip_address = productsvisit_helper::get_ip_address();
				$user_id = $this->session->get("user_id");

				$products_model->edit_cart_uniqid($user_id, $ip_address, $uniq_id);

				echo json_encode(array("error"=>"N","uniq_id"=>$uniq_id,"error_msg"=>""));
			}
		}
	}

	public function check_minimum_purchase()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$ip_address = productsvisit_helper::get_ip_address();

			$products_model = new products_Model;

			$minimum_error = "";
			$cart = $products_model->cart($this->session->get("user_id"), $ip_address);
			foreach($cart as $c)
			{
				$qty = $c->qty;
				$product_id = $c->product_id;
				//check if there is a minimum set on a particular product
				$product = $products_model->get_one($product_id);
				$minimum_purchase = $product->minimum_purchase;
				$actual_qty = $product->qty;
				if($minimum_purchase != 0 AND $qty < $minimum_purchase)
				{
					if($actual_qty <= $minimum_purchase)
					{
						if($actual_qty < $qty)
						{
							$product_name = $product->product_name;
							$minimum_error .= "The minimum order for ".$product_name ." is ".$actual_qty."\n";
						}
					}else{
						$product_name = $product->product_name;
						$minimum_error .= "The minimum order for ".$product_name ." is ".$minimum_purchase."\n";
					}
				}
			}

			if($minimum_error)
			{
				echo json_encode(array("error"=>"Y","error_msg"=>$minimum_error));
			}else{
				echo json_encode(array("error"=>"N","error_msg"=>""));
			}
		}
	}

	public function save_shipment_details()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$id = $this->input->post("id");
			$cart_id = $this->input->post("cart_id");
			$shipment_quote_id = $this->input->post("a");
			$carrier_scab = $this->input->post("b");
			$carrier_name = $this->input->post("c");
			$total_price = base64_decode($this->input->post("d"));
			$transit_days = $this->input->post("e");
			$guaranteed_service = $this->input->post("f");
			$high_cost_delivery_shipment = $this->input->post("g");
			$interline = $this->input->post("h");
			$nmfc_required = $this->input->post("i");
			$carrier_notifications = $this->input->post("j");

			$data = array(
				"shipping_address_id" => $id,
				"shipment_quote_id" => $shipment_quote_id,
				"carrier_scab" => $carrier_scab,
				"carrier_name" => $carrier_name,
				"shipping_fee" => $total_price,
				"transit_days" => $transit_days,
				"guaranteed_service" => $guaranteed_service,
				"high_cost_delivery_shipment" => $high_cost_delivery_shipment,
				"interline" => $interline,
				"nmfc_required" => $nmfc_required,
				"carrier_notifications" => $carrier_notifications,
				"user_id" => $this->session->get("user_id")
			);

			$products_model = new products_Model;
			$products_model->edit_cart($cart_id, $data);

		}
	}

	public function credit_card()
	{
		if(!$this->session->get('user_id')){
			url::redirect("index/products");
		}

		$check_cart_qty = $this->check_cart_qty();
		if($check_cart_qty)
		{
			url::redirect("cart/index");
		}

		$ip_address = productsvisit_helper::get_ip_address();

		$products_model = new products_Model;

		$cart = $products_model->cart($this->session->get("user_id"), $ip_address);
		foreach($cart as $c)
		{
			$qty = $c->qty;
			$product_id = $c->product_id;
			//check if there is a minimum set on a particular product
			$product = $products_model->get_one($product_id);
			$minimum_purchase = $product->minimum_purchase;
			$actual_qty = $product->qty;
			if($actual_qty <= $qty)
			{
				if($minimum_purchase != 0 AND $qty > $actual_qty)
				{
					url::redirect("cart/index");
				}
			}else{
				if($minimum_purchase != 0 AND $qty < $minimum_purchase)
				{
					url::redirect("cart/index");
				}
			}
		}

		$this->template->content = new View("cart/credit_card");
	}

	public function credit_card_offer()
	{
		if(!$this->session->get('user_id')){
			url::redirect("index/products");
		}

		$this->template->content = new View("cart/credit_card_offer");
	}

	public function proceed_to_payment()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$uniqid = $this->input->post("uniqid");

			$products_model = new products_Model;
			$cart_items = $products_model->get_cart_items_by_uniqid($uniqid);

			$total = 0;
			foreach($cart_items as $c)
			{
				$qty = $c->qty;
				$product_id = $c->product_id;
				//get product price
				$product = $products_model->get_one($product_id);
				$price = $product->price;

				$tp = $price * $qty;
				$total = $total + $tp;
			}

			echo json_encode(array("total"=>$total, "uniqid"=>$uniqid));
		}
	}

	public function proceed_to_payment_offer()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$uniqid = $this->input->post("uniqid");
			$offer_id = $this->input->post("offer_id");

			$products_model = new products_Model;
			//update offer, tagged it as done
			$update_offer = $products_model->update_offer($offer_id, array("checkout"=>"Yes"));
			
			$cart_items = $products_model->get_cart_items_by_uniqid($uniqid);

			$total = 0;
			foreach($cart_items as $c)
			{
				$total = $total + $c->offer_total_price;
			}

			echo json_encode(array("total"=>$total, "uniqid"=>$uniqid));
		}
	}

	public function order_processed($total, $uniqid)
	{
		$this->template->content = new View("cart/order_processed");

		$users_model = new users_Model;
		$shipping = $users_model->get_shipping_address($this->session->get("user_id"));
		$this->template->content->shipping = $shipping;

		$products_model = new products_Model;
		$cart = $products_model->get_cart_by_uniq_id($uniqid);
		$this->template->content->cart = $cart;

		if($this->session->get("user_id"))
		{
			$products_model = new products_Model;

			$data = array("done"=>"Yes", "date_added" => time());

			//$products_model->edit_cart_details($uniqid, $data);

			$products = $products_model->get_cart_by_uniq_id($uniqid);
			foreach($products as $p)
			{
				$qty = $p->qty;
				$p_id = $p->product_id;

				//update the actual qty of the product
				$actual_product = $products_model->get_one($p_id);
				$current_qty = $actual_product->qty;
				$new_qty = $current_qty - $qty;
				$new_data = array("qty"=>$new_qty);
				$done = $p->done;
				if($done == "No")
				{
					$products_model->edit_product_qty($p_id, $new_data);
				}
			}
			$products_model->edit_cart_by_uniqid($uniqid, $data);
		}else{
			url::redirect("index/products");
		}
	}

	public function order_processed_offer($total, $uniqid)
	{
		$this->template->content = new View("cart/order_processed_offer");

		$users_model = new users_Model;
		$shipping = $users_model->get_shipping_address($this->session->get("user_id"));
		$this->template->content->shipping = $shipping;

		$products_model = new products_Model;
		$cart = $products_model->get_cart_by_uniq_id($uniqid);
		$this->template->content->cart = $cart;

		if($this->session->get("user_id"))
		{
			$products_model = new products_Model;

			$data = array("done"=>"Yes", "date_added" => time());

			//$products_model->edit_cart_details($uniqid, $data);

			$products = $products_model->get_cart_by_uniq_id($uniqid);
			foreach($products as $p)
			{
				$qty = $p->qty;
				$p_id = $p->product_id;

				//update the actual qty of the product
				$actual_product = $products_model->get_one($p_id);
				$current_qty = $actual_product->qty;
				$new_qty = $current_qty - $qty;
				$new_data = array("qty"=>$new_qty);
				$done = $p->done;
				if($done == "No")
				{
					$products_model->edit_product_qty($p_id, $new_data);
				}
			}
			$products_model->edit_cart_by_uniqid($uniqid, $data);
		}else{
			url::redirect("index/products");
		}
	}
}
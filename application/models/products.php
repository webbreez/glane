<?php defined('SYSPATH') OR die('No direct access allowed.');

class Products_Model extends Model {

	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}
	
	public function add($data){
		$sql = $this->db
				->insert("products", $data);
		return $sql->insert_id();
	}

	public function add_brand($data){
		$sql = $this->db
				->insert("brands", $data);
		return $sql->insert_id();
	}

	public function add_picture($data){
		$sql = $this->db
				->insert("products_images", $data);
		return $sql->insert_id();
	}

	public function add_offer($data){
		$sql = $this->db
				->insert("offers", $data);
		return $sql->insert_id();
	}

	public function search_orders($order_id, $email, $firstname, $lastname, $date_from, $date_to){

		$cond = "done = 'Yes'";

		if($order_id)
		{
			$cond .= " AND uniq_id = '{$order_id}'";
		}

		$join_users = " JOIN users ON users.user_id = cart_items.user_id";

		// if($email || $firstname || $lastname)
		// {
		// 	$join_users = " JOIN users ON users.user_id = cart_items.user_id";
		// }else{
		// 	$join_users = "";
		// }

		if($email)
		{
			$cond .= " AND users.email = '{$email}'";
		}

		if($firstname)
		{
			$cond .= " AND users.firstname = '{$firstname}'";
		}

		if($lastname)
		{
			$cond .= " AND users.lastname = '{$lastname}'";
		}

		if($date_from)
		{
			$cond .= " AND cart_items.date_added >= '{$date_from}'";
		}

		if($date_to)
		{
			$cond .= " AND cart_items.date_added <= '{$date_to}'";
		}

		$query = "
			SELECT 
				cart_items.uniq_id,
				users.firstname,
				users.lastname,
				cart_items.status,
				cart_items.date_added,
				users.user_id
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			{$join_users}
			WHERE
				{$cond}
			GROUP BY
				cart_items.uniq_id
			ORDER BY
				cart_item_id DESC
		";
		//echo $query;
		//exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function check_cart($product_id, $user_id, $visitor_ip){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				cart_items.product_id = '{$product_id}'
				AND done = 'No'
				AND (cart_items.user_id = '{$user_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')
				AND combined_shipping = 'No'
				AND offer = 'No'
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function check_cart_combined_shipping($product_pickup_address, $product_id, $user_id, $visitor_ip){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				cart_items.product_id = '{$product_id}'
				AND done = 'No'
				AND (cart_items.user_id = '{$user_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')
				AND combined_shipping = 'Yes'
				AND combined_shipping_seller_address_id = '{$product_pickup_address}'
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function cart($user_id, $visitor_ip){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				cart_items.shipping_address_id,
				cart_items.shipping_fee,
				products.product_type,
				products.take_all_price,
				products.qty as actual_product_qty,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included,
				cart_items.offer
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				done = 'No'
				AND (cart_items.user_id = '{$user_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')
				AND products.qty > 0
				AND offer = 'No'
				AND combined_shipping = 'No'
			ORDER BY
				products.product_pickup_address ASC,
				cart_items.product_id ASC
		";
		//cart_item_id DESC
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function combined_shipping_cart($combined_shipping_seller_address_id, $user_id, $visitor_ip){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				cart_items.shipping_address_id,
				cart_items.shipping_fee,
				products.product_type,
				products.take_all_price,
				products.qty as actual_product_qty,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included,
				cart_items.offer
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				done = 'No'
				AND (cart_items.user_id = '{$user_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')
				AND products.qty > 0
				AND offer = 'No'
				AND combined_shipping = 'Yes'
				AND combined_shipping_seller_address_id = '{$combined_shipping_seller_address_id}'
			ORDER BY
				cart_items.product_id ASC
		";
		//cart_item_id DESC
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function cart_take_all($user_id, $visitor_ip, $product_id){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				cart_items.shipping_address_id,
				cart_items.shipping_fee,
				products.product_type,
				products.take_all_price,
				products.qty as actual_product_qty,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included,
				cart_items.offer
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				done = 'No'
				AND (cart_items.user_id = '{$user_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')
				AND products.qty > 0
				AND offer = 'No'
				AND cart_items.product_id = '{$product_id}'
				AND combined_shipping = 'No'
			ORDER BY
				cart_item_id DESC
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function cart_take_all_2($user_id, $visitor_ip, $product_id, $uniq_id){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				cart_items.shipping_address_id,
				cart_items.shipping_fee,
				products.product_type,
				products.take_all_price,
				products.qty as actual_product_qty,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included,
				cart_items.offer
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				done = 'Yes'
				AND offer = 'No'
				AND cart_items.product_id = '{$product_id}'
				AND cart_items.uniq_id = '{$uniq_id}'
				AND combined_shipping = 'No'
			ORDER BY
				cart_item_id DESC
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function cart_take_all_group_by($user_id, $visitor_ip, $product_id){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				cart_items.shipping_address_id,
				cart_items.shipping_fee,
				products.product_type,
				products.take_all_price,
				products.qty as actual_product_qty,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included,
				cart_items.offer,
				SUM(cart_items.qty) as p_total_qty
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				done = 'No'
				AND (cart_items.user_id = '{$user_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')
				AND products.qty > 0
				AND offer = 'No'
				AND cart_items.product_id = '{$product_id}'
				AND combined_shipping = 'No'
			GROUP BY
				cart_items.product_id
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function cart_take_all_group_by_2($user_id, $visitor_ip, $product_id, $uniq_id){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				cart_items.shipping_address_id,
				cart_items.shipping_fee,
				products.product_type,
				products.take_all_price,
				products.qty as actual_product_qty,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included,
				cart_items.offer,
				SUM(cart_items.qty) as p_total_qty
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				done = 'Yes'
				AND offer = 'No'
				AND cart_items.product_id = '{$product_id}'
				AND uniq_id = '{$uniq_id}'
				AND combined_shipping = 'No'
			GROUP BY
				cart_items.product_id
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function cart_offer($user_id, $visitor_ip, $product_id){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				cart_items.shipping_address_id,
				cart_items.shipping_fee,
				products.product_type,
				products.take_all_price,
				products.qty as actual_product_qty,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included,
				cart_items.offer,
				cart_items.offer_qty,
				cart_items.offer_total_price
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				done = 'No'
				AND (cart_items.user_id = '{$user_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')
				AND products.product_id = '{$product_id}'
				AND combined_shipping = 'No'
			ORDER BY
				cart_item_id DESC
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function check_cart_qty($product_id, $user_id, $visitor_ip){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				cart_items.shipping_address_id,
				cart_items.shipping_fee,
				products.product_type,
				products.take_all_price,
				products.qty as actual_product_qty,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				done = 'No'
				AND (cart_items.user_id = '{$user_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')
				AND products.qty > 0
				AND cart_items.product_id = {$product_id}
				AND combined_shipping = 'No'
				AND offer = 'No'
			ORDER BY
				cart_item_id DESC
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function combined_shipping_check_cart_qty($product_id, $user_id, $visitor_ip){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				cart_items.shipping_address_id,
				cart_items.shipping_fee,
				products.product_type,
				products.take_all_price,
				products.qty as actual_product_qty,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				done = 'No'
				AND (cart_items.user_id = '{$user_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')
				AND products.qty > 0
				AND cart_items.product_id = {$product_id}
				AND combined_shipping = 'Yes'
			ORDER BY
				cart_item_id DESC
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_cart_by_uniq_id($uniq_id){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				cart_items.shipping_address_id,
				cart_items.shipping_fee,
				products.take_all_price,
				products.qty as actual_product_qty,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included,
				cart_items.price as cart_price,
				cart_items.total_price as cart_total_price,
				cart_items.offer,
				cart_items.offer_total_price,
				cart_items.offer_qty,
				cart_items.done,
				cart_items.take_all_qty,
				cart_items.uniq_id
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				uniq_id = '{$uniq_id}'
			ORDER BY
				cart_items.product_id ASC
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_cart_items_by_uniqid($uniqid){
		$query = "
			SELECT 
				*
			FROM 
				cart_items 
			WHERE
				uniq_id = '{$uniqid}'
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function edit_cart_uniqid($user_id, $visitor_ip, $uniq_id){
		$query = "
			UPDATE
				cart_items 
			SET
				uniq_id = '{$uniq_id}'
			WHERE
				done = 'No'
				AND (cart_items.user_id = '{$user_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function add_to_cart($data){
		$sql = $this->db
				->insert("cart_items", $data);
		return $sql->insert_id();
	}

	public function save_cart_shipping_address($data){
		$sql = $this->db
				->insert("cart_details", $data);
		return $sql->insert_id();
	}

	public function add_my_basket($data){
		$sql = $this->db
				->insert("my_basket", $data);
		return $sql->insert_id();
	}

	public function add_related_product($main_product_id, $id){

		//check first if it is already added on the table
		$sql = $this->db
				->where("main_product_id",  $main_product_id)
				->where("product_id",  $id)
				->get("related_products");
		$result = $sql;
		$count = count($result);

		if($count == 0){
			$data = array("main_product_id"=>$main_product_id, "product_id"=>$id);

			$sql = $this->db
					->insert("related_products", $data);
			$sql->insert_id();
		}else{
			$sql = $this->db
				->where("main_product_id", $main_product_id)
				->where("product_id", $id)
				->delete("related_products");
		}
	}
	
	public function edit($id, $user_id, $data){
		$sql = $this->db
				->where("product_id", $id)
				->where("user_id", $user_id)
				->update("products", $data);
	}

	public function edit_product_qty($id, $data){
		$sql = $this->db
				->where("product_id", $id)
				->update("products", $data);
	}

	public function edit_cart($id, $data){
		$sql = $this->db
				->where("cart_item_id", $id)
				->update("cart_items", $data);
	}

	public function edit_cart_by_uniqid($uniqid, $data){
		$sql = $this->db
				->where("uniq_id", $uniqid)
				->update("cart_items", $data);
	}

	public function edit_cart_details($uniqid, $data){
		$sql = $this->db
				->where("uniq_id", $uniqid)
				->update("cart_details", $data);
	}

	public function edit_by_admin($id, $data){
		$sql = $this->db
				->where("product_id", $id)
				->update("products", $data);
	}

	public function update_offer($id, $data){
		$sql = $this->db
				->where("offer_id", $id)
				->update("offers", $data);
	}
	
	public function delete($id, $user_id){
		$sql = $this->db
				->where("product_id", $id)
				->where("user_id", $user_id)
				->delete("products");
	}

	public function delete_picture($id, $user_id){
		$sql = $this->db
				->where("product_images_id", $id)
				->where("user_id", $user_id)
				->delete("products_images");
	}

	public function delete_cart_item($id){
		$sql = $this->db
				->where("cart_item_id", $id)
				->delete("cart_items");
	}

	public function get_products($user_id){
		$sql = $this->db
				->where("user_id != $user_id")
				->get("products");
		return $sql;
	}

	public function get_user_products($user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->get("products");
		return $sql;
	}

	public function get_related_products($main_product_id){
		$sql = $this->db
				->where("main_product_id", $main_product_id)
				->join("products", "products.product_id", "related_products.product_id")
				->get("related_products");
		return $sql;
	}

	public function get_related_products_limit_4($main_product_id){
		$sql = $this->db
				->where("main_product_id", $main_product_id)
				->join("products", "products.product_id", "related_products.product_id")
				->limit(4)
				->get("related_products");
		return $sql;
	}

	public function get_featured_products(){
		$sql = $this->db
				->where("featured", "Yes")
				->where("qty != 0")
				->get("products");
		return $sql;
	}

	public function get_products_visit($ip_address, $user_id){
		$sql = $this->db
				->where("visitor_ip", $ip_address)
				->orwhere("user_id", $user_id)
				->groupby("main_category")
				->get("products_visit");
		return $sql;
	}

	public function get_products_related_by_categories($ip_address, $user_id){

		//OR products_visit.user_id = '{$user_id}'

		$user_type = $this->session->get("user_type");
		//$cond = "WHERE user_id != '{$user_id}'";
		if($user_type == "charity")
		{
			$cond = " AND product_type = 'charity'";
		}else{
			$cond = " AND product_type != 'charity'";
		}
		
		$query = "
			SELECT 
				products.* 
			FROM 
				products 
			JOIN
				products_visit
					ON
					(products_visit.product_id = products.product_id)
			WHERE
				products_visit.visitor_ip = '{$ip_address}'
				AND qty > 0
				{$cond}
			GROUP BY
				products.product_id
			LIMIT 8
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function products_related_by_categories($product_id, $category_1){

		//OR products_visit.user_id = '{$user_id}'

		$user_type = $this->session->get("user_type");
		//$cond = "WHERE user_id != '{$user_id}'";
		if($user_type == "charity")
		{
			$cond = " AND product_type = 'charity'";
		}else{
			$cond = " AND product_type != 'charity'";
		}
		
		$query = "
			SELECT 
				products.* 
			FROM 
				products 
			WHERE
				product_id != '{$product_id}'
				AND category_1 = '{$category_1}'
				AND qty > 0
				{$cond}
			LIMIT 2
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_products_for_listings($orderby){

		// $sql = $this->db
		// 		->get("products");
		// return $sql;

		if($this->session->get("user_id"))
		{
			$user_id = $this->session->get("user_id");
			$user_type = $this->session->get("user_type");
			//$cond = "WHERE user_id != '{$user_id}'";
			if($user_type == "charity")
			{
				$cond ="WHERE qty > 0 AND product_type = 'charity'";
			}else{
				$cond ="WHERE qty > 0 AND product_type != 'charity'";
			}
		}else{
			$cond ="WHERE qty > 0 AND product_type != 'charity'";
		}

		$query = "
			SELECT * FROM products {$cond} {$orderby}
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_products_for_listings_limit($limit, $offset){

		// $sql = $this->db
		// 		->get("products");
		// return $sql;

		if($this->session->get("user_id"))
		{
			$user_id = $this->session->get("user_id");
			$user_type = $this->session->get("user_type");
			//$cond = "WHERE user_id != '{$user_id}'";
			if($user_type == "charity")
			{
				$cond ="WHERE qty > 0 AND product_type = 'charity'";
			}else{
				$cond ="WHERE qty > 0 AND product_type != 'charity'";
			}
		}else{
			$cond ="WHERE qty > 0 AND product_type != 'charity'";
		}

		$query = "
			SELECT * FROM products {$cond} LIMIT {$offset}, {$limit}
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_products_for_listings_combined_shipping($orderby, $product_pickup_address){

		// $sql = $this->db
		// 		->get("products");
		// return $sql;

		if($this->session->get("user_id"))
		{
			$user_id = $this->session->get("user_id");
			$user_type = $this->session->get("user_type");
			//$cond = "WHERE user_id != '{$user_id}'";
			if($user_type == "charity")
			{
				$cond ="WHERE qty > 0 AND product_type = 'charity' AND product_pickup_address = '{$product_pickup_address}";
			}else{
				$cond ="WHERE qty > 0 AND product_type != 'charity' AND product_pickup_address = '{$product_pickup_address}";
			}
		}else{
			$cond ="WHERE qty > 0 AND product_type != 'charity' AND product_pickup_address = '{$product_pickup_address}";
		}

		$query = "
			SELECT * FROM products {$cond} {$orderby}'
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_all_brands(){
		$query = "
			SELECT * FROM brands ORDER BY brand_name ASC
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_brands($brand){
		$brand = addslashes($brand);
		$query = "
			SELECT * FROM brands WHERE brand_name LIKE '{$brand}%' ORDER BY brand_name ASC
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function find_products($term){
		$query = "
			SELECT * FROM products WHERE product_name LIKE '{$term}%' ORDER BY product_name ASC
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function find_category_1($term){
		$query = "
			SELECT * FROM category_1 WHERE category_1_name LIKE '{$term}%' ORDER BY category_1_name ASC
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function find_category_2($term){
		$query = "
			SELECT * FROM category_2 WHERE category_2_name LIKE '{$term}%' ORDER BY category_2_name ASC
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function find_category_3($term){
		$query = "
			SELECT * FROM category_3 WHERE category_3_name LIKE '{$term}%' ORDER BY category_3_name ASC
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function find_category_4($term){
		$query = "
			SELECT * FROM category_4 WHERE category_4_name LIKE '{$term}%' ORDER BY category_4_name ASC
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function check_brand($brand){
		$brand = addslashes($brand);
		$query = "
			SELECT * FROM brands WHERE brand_name = '{$brand}'
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_products_by_category($category_level, $category_id){

		if($category_level == 1)
		{
			$level = "category_1";
		}elseif($category_level == 2)
		{
			$level = "category_2";
		}elseif($category_level == 3){
			$level = "category_3";
		}else{
			$level = "category_4";
		}

		$sql = $this->db
				->where($level, $category_id)
				->get("products");
		return $sql;
	}

	public function get_products_by_category_limit($category_level, $category_id, $limit, $offset){

		if($category_level == 1)
		{
			$level = "category_1";
		}elseif($category_level == 2)
		{
			$level = "category_2";
		}elseif($category_level == 3){
			$level = "category_3";
		}else{
			$level = "category_4";
		}

		// $sql = $this->db
		// 		->where($level, $category_id)
		// 		->get("products");
		// return $sql;

		$query = "
			SELECT * FROM products WHERE $level = $category_id LIMIT {$offset}, {$limit}
		";
		$sql = $this->db->query($query);
		return $sql;
	}

	public function get_product_category_name($table, $category_id){

		if($table == "category_1")
		{
			$cond = "category_1_id = '{$category_id}'";
		}elseif($table == "category_2"){
			$cond = "category_2_id = '{$category_id}'";
		}elseif($table == "category_3"){
			$cond = "category_3_id = '{$category_id}'";
		}else{
			$cond = "category_4_id = '{$category_id}'";
		}

		$query = "
			SELECT * FROM {$table} WHERE {$cond}
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}

	public function search_products($search="", $category=""){


		if($category == 30)
		{
			$date_1 = date('Y-m-d 00:00:00', time());
			$date_2 = date('Y-m-d 23:59:59', time() + (86400 * 30));

			$cond_1 = "(product_name LIKE '%{$search}%' OR product_description LIKE '%{$search}%' OR brand LIKE '%{$search}%' OR category_searching LIKE '%{$search}%')";
			$cond_2 = "AND (expiration_date >= '{$date_1}' AND expiration_date <= '{$date_2}')";
		}elseif($category == 60){
			// $date_1 = date('Y-m-d 00:00:00', time() + (86400 * 31));
			// $date_2 = date('Y-m-d 23:59:59', time() + (86400 * 60));

			$date_1 = date('Y-m-d 00:00:00', time());
			$date_2 = date('Y-m-d 23:59:59', time() + (86400 * 59));

			$cond_1 = "(product_name LIKE '%{$search}%' OR product_description LIKE '%{$search}%' OR brand LIKE '%{$search}%' OR category_searching LIKE '%{$search}%')";
			$cond_2 = "AND (expiration_date >= '{$date_1}' AND expiration_date <= '{$date_2}')";
		}elseif($category == 90){
			$date_1 = date('Y-m-d 00:00:00', time() + (86400 * 61));
			$date_2 = date('Y-m-d 23:59:59', time() + (86400 * 90));

			$cond_1 = "(product_name LIKE '%{$search}%' OR product_description LIKE '%{$search}%' OR brand LIKE '%{$search}%' OR category_searching LIKE '%{$search}%')";
			$cond_2 = "AND (expiration_date >= '{$date_1}' AND expiration_date <= '{$date_2}')";
		}elseif($category == "expired"){
			$date_1 = date('Y-m-d 23:59:59', time());

			$cond_1 = "(product_name LIKE '%{$search}%' OR product_description LIKE '%{$search}%' OR brand LIKE '%{$search}%' OR category_searching LIKE '%{$search}%')";
			$cond_2 = "AND expiration_date <= '{$date_1}'";
		}else{
			$cond_1 = "product_name LIKE '%{$search}%' OR product_description LIKE '%{$search}%' OR brand LIKE '%{$search}%' OR category_searching LIKE '%{$search}%'";
			$cond_2 = "";
		}

		if($this->session->get("user_id"))
		{
			$user_id = $this->session->get("user_id");
			$user_type = $this->session->get("user_type");
			//$cond = "WHERE user_id != '{$user_id}'";
			if($user_type == "charity")
			{
				$cond0 ="qty > 0 AND product_type = 'charity'";
			}else{
				$cond0 ="qty > 0 AND product_type != 'charity'";
			}
		}else{
			$cond0 ="qty > 0 AND product_type != 'charity'";
		}

		$query = "
			SELECT * FROM products WHERE {$cond0} AND ({$cond_1} {$cond_2})
		";
		//echo $query;
		//exit;
		$sql = $this->db->query($query);
		return $sql;

		// $sql = $this->db
		// 		->like("product_name", $search)
		// 		->orlike("product_description", $search)
		// 		->get("products");
		// return $sql;
	}

	public function search_products_limit($search="", $category="", $limit, $offset){


		if($category == 30)
		{
			$date_1 = date('Y-m-d 00:00:00', time());
			$date_2 = date('Y-m-d 23:59:59', time() + (86400 * 30));

			$cond_1 = "(product_name LIKE '%{$search}%' OR product_description LIKE '%{$search}%' OR brand LIKE '%{$search}%' OR category_searching LIKE '%{$search}%')";
			$cond_2 = "AND (expiration_date >= '{$date_1}' AND expiration_date <= '{$date_2}')";
		}elseif($category == 60){
			// $date_1 = date('Y-m-d 00:00:00', time() + (86400 * 31));
			// $date_2 = date('Y-m-d 23:59:59', time() + (86400 * 60));

			$date_1 = date('Y-m-d 00:00:00', time());
			$date_2 = date('Y-m-d 23:59:59', time() + (86400 * 59));

			$cond_1 = "(product_name LIKE '%{$search}%' OR product_description LIKE '%{$search}%' OR brand LIKE '%{$search}%' OR category_searching LIKE '%{$search}%')";
			$cond_2 = "AND (expiration_date >= '{$date_1}' AND expiration_date <= '{$date_2}')";
		}elseif($category == 90){
			$date_1 = date('Y-m-d 00:00:00', time() + (86400 * 61));
			$date_2 = date('Y-m-d 23:59:59', time() + (86400 * 90));

			$cond_1 = "(product_name LIKE '%{$search}%' OR product_description LIKE '%{$search}%' OR brand LIKE '%{$search}%' OR category_searching LIKE '%{$search}%')";
			$cond_2 = "AND (expiration_date >= '{$date_1}' AND expiration_date <= '{$date_2}')";
		}elseif($category == "expired"){
			$date_1 = date('Y-m-d 23:59:59', time());

			$cond_1 = "(product_name LIKE '%{$search}%' OR product_description LIKE '%{$search}%' OR brand LIKE '%{$search}%' OR category_searching LIKE '%{$search}%')";
			$cond_2 = "AND expiration_date <= '{$date_1}'";
		}else{
			$cond_1 = "product_name LIKE '%{$search}%' OR product_description LIKE '%{$search}%' OR brand LIKE '%{$search}%' OR category_searching LIKE '%{$search}%'";
			$cond_2 = "";
		}

		if($this->session->get("user_id"))
		{
			$user_id = $this->session->get("user_id");
			$user_type = $this->session->get("user_type");
			//$cond = "WHERE user_id != '{$user_id}'";
			if($user_type == "charity")
			{
				$cond0 ="qty > 0 AND product_type = 'charity'";
			}else{
				$cond0 ="qty > 0 AND product_type != 'charity'";
			}
		}else{
			$cond0 ="qty > 0 AND product_type != 'charity'";
		}

		$query = "
			SELECT * FROM products WHERE {$cond0} AND ({$cond_1} {$cond_2}) LIMIT {$offset}, {$limit}
		";
		//echo $query;
		//exit;
		$sql = $this->db->query($query);
		return $sql;

		// $sql = $this->db
		// 		->like("product_name", $search)
		// 		->orlike("product_description", $search)
		// 		->get("products");
		// return $sql;
	}

	public function advanced_search_products($keyword="", $brand="", $category_1="", $category_2="", $category_3="", $category_4="", $expiration_date=""){

		$brand_cond = "";
		$category_1_cond = "";
		$category_2_cond = "";
		$category_3_cond = "";
		$category_4_cond = "";

		$keyword_cond = "(product_name LIKE '%{$keyword}%' OR product_description LIKE '%{$keyword}%') ";

		if($brand)
		{
			$brand_cond = "AND brand LIKE '%{$brand}%' ";
		}

		if($category_1)
		{
			$category_1_cond = "AND category_1 = $category_1 ";
		}

		if($category_2 && $category_2 != "undefined")
		{
			$category_2_cond = "AND category_2 = $category_2 ";
		}

		if($category_3 && $category_3 != "undefined")
		{
			$category_3_cond = "AND category_3 = $category_3 ";
		}

		if($category_4 && $category_4 != "undefined")
		{
			$category_4_cond = "AND category_4 = $category_4 ";
		}


		if($expiration_date == 30)
		{
			$date_1 = date('Y-m-d 00:00:00', time());
			$date_2 = date('Y-m-d 23:59:59', time() + (86400 * 30));
			
			$cond_1 = $keyword_cond."AND (expiration_date >= '{$date_1}' AND expiration_date <= '{$date_2}')";
			$cond_2 = $brand_cond.$category_1_cond.$category_2_cond.$category_3_cond.$category_4_cond;
		}elseif($expiration_date == 60){
			// $date_1 = date('Y-m-d 00:00:00', time() + (86400 * 31));
			// $date_2 = date('Y-m-d 23:59:59', time() + (86400 * 60));

			$date_1 = date('Y-m-d 00:00:00', time());
			$date_2 = date('Y-m-d 23:59:59', time() + (86400 * 59));

			$cond_1 = $keyword_cond."AND (expiration_date >= '{$date_1}' AND expiration_date <= '{$date_2}')";
			$cond_2 = $brand_cond.$category_1_cond.$category_2_cond.$category_3_cond.$category_4_cond;
		}elseif($expiration_date == 90){
			$date_1 = date('Y-m-d 00:00:00', time() + (86400 * 61));
			$date_2 = date('Y-m-d 23:59:59', time() + (86400 * 90));

			$cond_1 = $keyword_cond."AND (expiration_date >= '{$date_1}' AND expiration_date <= '{$date_2}')";
			$cond_2 = $brand_cond.$category_1_cond.$category_2_cond.$category_3_cond.$category_4_cond;
		}elseif($expiration_date == "expired"){
			$date_1 = date('Y-m-d 23:59:59', time());

			$cond_1 = $keyword_cond."AND expiration_date <= '{$date_1}'";
			$cond_2 = $brand_cond.$category_1_cond.$category_2_cond.$category_3_cond.$category_4_cond;
		}else{
			$cond_1 = $keyword_cond.$brand_cond.$category_1_cond.$category_2_cond.$category_3_cond.$category_4_cond;
			$cond_2 = " AND qty > 0";
		}

		if($this->session->get("user_id"))
		{
			$user_id = $this->session->get("user_id");
			$user_type = $this->session->get("user_type");
			//$cond = "WHERE user_id != '{$user_id}'";
			if($user_type == "charity")
			{
				$cond0 ="qty > 0 AND product_type = 'charity'";
			}else{
				$cond0 ="qty > 0 AND product_type != 'charity'";
			}
		}else{
			$cond0 ="qty > 0 AND product_type != 'charity'";
		}

		$query = "
			SELECT * FROM products WHERE {$cond0} AND ({$cond_1} {$cond_2})
		";
		//echo $query;
		//exit;
		$sql = $this->db->query($query);
		return $sql;
	}
	
	public function get_my_product($id, $user_id){
		$sql = $this->db
				->where("product_id", $id)
				->where("user_id", $user_id)
				->get("products");
		return $sql;
	}

	public function get_one($id){
		$sql = $this->db
				->where("product_id", $id)
				->get("products");
		return $sql->current();
	}

	public function get_one_cart($id){
		$query = "
			SELECT 
				cart_items.product_id,
				cart_items.cart_item_id,
				cart_items.product_id as ci_pid,
				cart_items.qty,
				products.product_name,
				products.price,
				products.percentage_discount,
				products.on_sale,
				products.sale_price,
				products.shipping_fee_included
			FROM 
				cart_items 
			JOIN
				products
					ON
					products.product_id = cart_items.product_id
			WHERE
				cart_item_id = '{$id}'
		";
		$sql = $this->db->query($query);
		return $sql->current();
	}

	public function get_one_my_basket($id){
		$sql = $this->db
				->where("my_basket_id", $id)
				->get("my_basket");
		return $sql->current();
	}

	public function get_one_product($id){
		$sql = $this->db
				->where("product_id", $id)
				->get("products");
		return $sql->current();
	}


	public function get_one_offer($id){
		$sql = $this->db
				->where("offer_id", $id)
				->get("offers");
		return $sql->current();
	}

	public function check_offer_on_cart($offer_id, $user_id, $product_id){
		$sql = $this->db
				->where("offer_id", $offer_id)
				->where("user_id", $user_id)
				->where("product_id", $product_id)
				->where("done", "No")
				->get("cart_items");
		return $sql;
	}

	public function check_offer($offer_id, $user_id){
		$sql = $this->db
				->where("offer_id", $offer_id)
				->where("offered_by_user_id", $user_id)
				->get("offers");
		return $sql;
	}

	public function get_offers($id){
		$sql = $this->db
				->where("product_id", $id)
				->where("retracted", "N")
				->join("users", "users.user_id", "offers.offered_by_user_id")
				->orderby("offer_id", "ASC")
				->get("offers");
		return $sql;
	}

	public function get_products_with_my_offers($user_id){
		$sql = $this->db
				->where("offered_by_user_id", $user_id)
				->join("products", "products.product_id", "offers.product_id")
				->groupby("products.product_id")
				->get("offers");
		return $sql;
	}

	public function get_products_notifications($user_id){
		$sql = $this->db
				->where("user_id", $user_id)
				->where("offers.amount >= products.make_an_offer_minimum_amount")
				->where("offers.qty >= products.make_an_offer_minimum_qty")
				->orwhere("offered_by_user_id", $user_id)
				->join("offers", "offers.product_id", "products.product_id")
				->groupby("products.product_id")
				->orderby("offers.date_added")
				->get("products");
				//echo $this->db->last_query();
		return $sql;
	}

	public function get_category_by_name($table, $field, $search)
	{
		$sql = $this->db
				->where($field, $search)
				->where("is_active", "1")
				->get($table);
		return $sql;
	}

	public function get_category_1()
	{
		$sql = $this->db
				->where("is_active", "1")
				->get("category_1");
		return $sql;
	}

	public function get_one_category_1($id)
	{
		$sql = $this->db
				->where("category_1_id", $id)
				->get("category_1");
		return $sql->current();
	}

	public function get_category_2()
	{
		$sql = $this->db
				->where("is_active", "1")
				->get("category_2");
		return $sql;
	}

	public function get_one_category_2($id)
	{
		$sql = $this->db
				->where("category_2_id", $id)
				->get("category_2");
		return $sql->current();
	}

	public function get_category_3()
	{
		$sql = $this->db
				->where("is_active", "1")
				->get("category_3");
		return $sql;
	}

	public function get_one_category_3($id)
	{
		$sql = $this->db
				->where("category_3_id", $id)
				->get("category_3");
		return $sql->current();
	}

	public function get_category_4()
	{
		$sql = $this->db
				->where("is_active", "1")
				->get("category_4");
		return $sql;
	}

	public function get_one_category_4($id)
	{
		$sql = $this->db
				->where("category_4_id", $id)
				->get("category_4");
		return $sql->current();
	}

	public function get_pictures($product_id)
	{
		$sql = $this->db
				->where("product_id", $product_id)
				->get("products_images");
		return $sql;
	}

	public function get_pictures_by_product_id($product_id)
	{
		$sql = $this->db
				->where("product_id", $product_id)
				->limit(1)
				->get("products_images");
		return $sql;
	}

	public function get_categories($id, $type)
	{

		if($type == "category_1")
		{
			$table = "category_2";
			$cond = "category_1_id = '{$id}'";
		}elseif($type == "category_2")
		{
			$table = "category_3";
			$cond = "category_2_id = '{$id}'";
		}elseif($type == "category_3")
		{
			$table = "category_4";
			$cond = "category_3_id = '{$id}'";
		}

		$cond .= "AND is_active = '1'";

		$query = "
			SELECT * FROM {$table} WHERE {$cond}
		";

		$sql = $this->db->query($query);
		return $sql;
	}
}

?>
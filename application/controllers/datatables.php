<?php defined('SYSPATH') OR die('No direct access allowed.');

class Datatables_Controller extends Controller {

	public function __construct()
	{
		parent::__construct();

		$this->session = Session::instance();
	}

	public function list_data($page, $param="")
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;
			
			$primary_id = "primary_id";
			$member_id = $this->session->get("user_id");
			
			switch ($page){
				case "legal_documents":
					$sTable = "legal_documents";
					$sIndexColumn = "legal_document_id";
					$aColumns = array("title", "date_created", "type", "status", $sIndexColumn);
					$aSearchColumns = array("title");
					//$sTableCond = "WHERE documents.done ='Yes'"; //conditions
					// $sTableJoin = "
					// 	JOIN
					// 		client
					// 		ON
					// 			client.client_id = documents.client_id
					// 	JOIN
					// 		user
					// 		ON
					// 			user.user_id = documents.last_modified_by
					// ";

					$sTableCond = "WHERE user_id ='{$member_id}'"; //conditions
					$sTableJoin = "";

					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"download\\\">DOWNLOAD</a><br />
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"delete\\\">DELETE</a>
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "products":
					$sTable = "products";
					$sIndexColumn = "product_id";
					$aColumns = array("product_name", "featured", "qty", "price", $sIndexColumn);
					$aSearchColumns = array("product_name", "featured", "qty", "price");
					$sTableCond = "WHERE user_id ='{$member_id}'"; //conditions
					$sTableJoin = "";

					//<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"viewrow\\\">VIEW</a><br />

					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"edit\\\">EDIT</a><br />
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"delete\\\">DELETE</a><br />
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"pictures\\\">PICTURES</a><br />
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"offers\\\">OFFERS</a><br />
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"related_products\\\">RELATED PRODUCTS</a>
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "address":
					$sTable = "user_address";
					$sIndexColumn = "user_address_id";
					$aColumns = array("user_address_1", "user_address_2", "user_address_city", "user_address_state", "user_address_type", "user_address_primary", $sIndexColumn);
					$aSearchColumns = array("user_address_1", "user_address_2", "user_address_city", "user_address_state", "user_address_type");
					$sTableCond = "WHERE user_id ='{$member_id}'"; //conditions
					$sTableJoin = "";

					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"editrow\\\">EDIT</a><br />
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"deleterow\\\">DELETE</a>
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "clients":
					$sTable = "client";
					$sIndexColumn = "client_id";
					$aColumns = array("client_firstname", "client_lastname", "email", "address_1", "address_1", "city", "state", "zip", $sIndexColumn);
					$aSearchColumns = array("client_firstname", "client_lastname", "email", "address_1", "address_1", "city", "state", "zip");
					$sTableCond = ""; //conditions
					$sTableJoin = "";

					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"edit\\\">EDIT</a><br />
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"deleterow\\\">DELETE</a>
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "my_basket":
					$sTable = "my_basket";
					$sIndexColumn = "my_basket_id";
					$aColumns = array("products.product_name as p_name", "my_basket.qty as p_qty", "my_basket.price as p_price", $sIndexColumn);
					$aSearchColumns = array("products.product_name");
					$sTableCond = "WHERE my_basket.user_id ='{$member_id}'"; //conditions
					$sTableJoin = "JOIN products ON products.product_id=my_basket.product_id";

					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"buy_now\\\">BUY NOW</a>
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "my_orders":
					$sTable = "cart_items";
					$sIndexColumn = "uniq_id";
					$aColumns = array("cart_items.uniq_id as uniqid", "status", "date_added",  $sIndexColumn);
					$aSearchColumns = array("cart_items.uniq_id");
					$sTableCond = "WHERE cart_items.user_id ='{$member_id}' AND done='Yes'"; //conditions
					$sTableJoin = "";

					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"view\\\">VIEW</a>
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = " GROUP BY cart_items.uniq_id";
					break;

				case "my_sales":
					$sTable = "cart_items";
					$sIndexColumn = "uniq_id";
					$aColumns = array("cart_items.uniq_id as uniqid", "product_name", "cart_items.qty as cart_items_qty", "cart_items.price as cart_items_price", "total_price", "status", "cart_items.date_added as date_added",  $sIndexColumn);
					$aSearchColumns = array("cart_items.uniq_id", "product_name");
					$sTableCond = "WHERE products.user_id ='{$member_id}' AND cart_items.done='Yes'"; //conditions
					$sTableJoin = " JOIN products ON products.product_id = cart_items.product_id";

					//<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"view\\\">VIEW</a>
					$sButtons = ""; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "combined_shipping":
					$visitor_ip = productsvisit_helper::get_ip_address();

					$sTable = "cart_items";
					$sIndexColumn = "combined_shipping_seller_address_id";
					$aColumns = array("CONCAT_WS(' ', firstname, lastname) as seller", "CONCAT_WS(' ', user_address_1, user_address_2) as address", "user_address_city", "user_address_state", "user_address_zip",  $sIndexColumn);
					$aSearchColumns = array("user_address_1", "user_address_2", "user_address_city", "user_address_state", "user_address_zip");
					
					$sTableJoin = " JOIN products ON products.product_id = cart_items.product_id";
					$sTableJoin .= " JOIN user_address ON user_address.user_address_id = cart_items.combined_shipping_seller_address_id";
					$sTableJoin .= " JOIN users ON users.user_id = user_address.user_id";

					$sTableCond = "WHERE cart_items.done='No' AND offer = 'No' AND combined_shipping = 'Yes' AND (cart_items.user_id = '{$member_id}' AND cart_items.visitor_ip = '{$visitor_ip}' OR cart_items.user_id = '0' AND cart_items.visitor_ip = '{$visitor_ip}')"; //conditions

					$sButtons = "<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"view\\\">VIEW</a>"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "GROUP BY cart_items.combined_shipping_seller_address_id";
					break;
			}
			
			echo datatables_helper::get_data($sTable, $sIndexColumn, $aColumns, $sTableJoin, $aSearchColumns, $sTableCond, $sButtons, $sCheckbox, $sAddCond, $sGroupBy);
		}
	}
	
}
?>
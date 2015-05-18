<?php defined('SYSPATH') OR die('No direct access allowed.');

class Datatables_Controller extends Controller {

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

	public function list_data($page, $param="")
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;
			
			$primary_id = "primary_id";
			
			switch ($page){
				case "users":
					$sTable = "users";
					$sIndexColumn = "user_id";
					$aColumns = array("CONCAT_WS(' ', firstname, lastname) as client_name", "email", "user_status", $sIndexColumn);
					$aSearchColumns = array("firstname", "lastname");
					$sTableCond = "WHERE deleted='N' AND user_status != 2"; //conditions
					$sTableJoin = "";
					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"edit\\\">EDIT</a>
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"delete\\\">DELETE</a>
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"products\\\">PRODUCTS</a>
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"docs\\\">LEGAL DOCS</a>
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "pending_users":
					$sTable = "users";
					$sIndexColumn = "user_id";
					$aColumns = array("CONCAT_WS(' ', firstname, lastname) as client_name", "email", "type", $sIndexColumn);
					$aSearchColumns = array("firstname", "lastname");
					$sTableCond = "WHERE deleted='N' AND user_status = 2"; //conditions
					$sTableJoin = "";
					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"approve\\\">APPROVE</a>
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"decline\\\">DECLINE</a>
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"docs\\\">LEGAL DOCS</a>
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "admins":
					$sTable = "admin";
					$sIndexColumn = "id";
					$aColumns = array("firstname", "lastname", $sIndexColumn);
					$aSearchColumns = array("firstname", "lastname");
					$sTableCond = "WHERE id !='1'"; //conditions
					$sTableJoin = "";
					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"edit\\\">EDIT</a>
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"delete\\\">DELETE</a>
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "legal_documents":
					$sTable = "legal_documents";
					$sIndexColumn = "legal_document_id";
					$aColumns = array("title", "date_created", "status", $sIndexColumn);
					$aSearchColumns = array("title");
					$sTableCond = "WHERE user_id=$param"; //conditions
					$sTableJoin = "";
					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"download\\\">DOWNLOAD</a><br />
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"approve\\\">APPROVE</a>
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"decline\\\">DECLINE</a>
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
					$sTableCond = "WHERE user_id ='{$param}'"; //conditions
					$sTableJoin = "";

					//<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"viewrow\\\">VIEW</a><br />

					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"edit\\\">EDIT</a><br />
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"delete\\\">DELETE</a><br />
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "address":
					$sTable = "user_address";
					$sIndexColumn = "user_address_id";
					$aColumns = array("user_address_1", "user_address_2", "user_address_city", "user_address_state", "user_address_zip", $sIndexColumn);
					$aSearchColumns = array("user_address_1", "user_address_2", "user_address_city", "user_address_state", "user_address_zip");
					$sTableCond = "WHERE user_id ='{$param}'"; //conditions
					$sTableJoin = "";

					//<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"viewrow\\\">VIEW</a><br />

					$sButtons = "
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;

				case "faqs":
					$sTable = "faqs";
					$sIndexColumn = "id";
					$aColumns = array("title", $sIndexColumn);
					$aSearchColumns = array("title");
					$sTableCond = ""; //conditions
					$sTableJoin = "";

					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"edit\\\">EDIT</a>
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"delete\\\">DELETE</a>
					"; 
					$sCheckbox = FALSE;
					$sAddCond = "";
					$sGroupBy = "";
					break;
			}
			
			echo datatables_helper::get_data($sTable, $sIndexColumn, $aColumns, $sTableJoin, $aSearchColumns, $sTableCond, $sButtons, $sCheckbox, $sAddCond, $sGroupBy);
		}
	}
}
?>
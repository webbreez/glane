<?php defined('SYSPATH') OR die('No direct access allowed.');

class Datatables_Controller extends Controller {

	public function __construct()
	{
		parent::__construct();

		$this->session = Session::instance();
		//checking if user is logged in
		if(!$this->session->get('manager_id')){
			url::redirect("inventory/index");
		}
		//till here
	}

	public function list_data($page, $param="")
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;
			
			$primary_id = "primary_id";
			
			switch ($page){
				case "purchases":
					$sTable = "purchases";
					$sIndexColumn = "id";
					$aColumns = array("CONCAT_WS(' ', payer_fname, payer_lname) as payer", "invoice", "product_name", "payment_status", $sIndexColumn);
					$aSearchColumns = array("firstname", "lastname");
					$sTableCond = ""; //conditions
					$sTableJoin = "";
					$sButtons = "
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"paid\\\">PAID</a> |
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"shipped\\\">SHIPPED</a> |
						<a href=\\\"javascript:void(0)\\\" id=\\\"$$primary_id\\\" class=\\\"received\\\">RECEIVED</a>
					"; 
					break;
			}
			
			echo datatables_helper::get_data($sTable, $sIndexColumn, $aColumns, $sTableJoin, $aSearchColumns, $sTableCond, $sButtons);
		}
	}
}
?>
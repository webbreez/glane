<?php defined('SYSPATH') OR die('No direct access allowed.');

class Cron_Controller extends Template_Controller {

	public $template = 'index_tpl2';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();		
	}

	public function check_legal_docs(){

		$users_model = new users_Model;
		$users = $users_model->get_all();

		$legal_documents_model = new Legal_Documents_Model;

		$email_msg = "";
		foreach($users as $u)
		{
			$user_id = $u->user_id;
			$user_type = $u->type;
			$name = $u->firstname.' '.$u->lastname;
			$user_email = $u->email;

			//check legal docs table
			if($user_type == "charity")
			{
				$ctr = 0;
				$legal_docs_types = array(
					"IRS",
					"State of Incorporation or State of Organization",
					"Certificate of Incorporation or Certificate of Organization",
					"Documentation Regarding Charitable Status"
				);
				$arr_1 = FALSE;
				$arr_2 = FALSE;
				$arr_3 = FALSE;
				$arr_4 = FALSE;

				$legal_docs = $legal_documents_model->get_all($user_id);
				foreach($legal_docs as $legal_doc)
				{
					if($legal_doc->type == "IRS")
					{
						$arr_1 = TRUE;
					}
					if($legal_doc->type == "State of Incorporation or State of Organization")
					{
						$arr_2 = TRUE;
					}
					/*
					if($legal_doc->type == "Certificate of Incorporation or Certificate of Organization")
					{
						$arr_3 = TRUE;
					}
					if($legal_doc->type == "Documentation Regarding Charitable Status")
					{
						$arr_4 = TRUE;
					}
					*/
				}

				//if($arr_1 == TRUE AND $arr_2 == TRUE AND $arr_3 == TRUE AND $arr_4 == TRUE)
				if($arr_1 == TRUE AND $arr_2 == TRUE)
				{

				}else{
					$email_msg .= "
						Name: $name <br />
						Email : $user_email <br />
					";

					if($arr_1 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for Internal Revenue Service W-9 Form <br />
						";
					}
					if($arr_2 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for State of Incorporation OR State of Organization <br />
						";
					}
					/*
					if($arr_3 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for Certificate of Incorporation or Certificate of Organization <br />
						";
					}
					if($arr_4 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for Documentation Regarding Charitable Status <br />
						";
					}
					*/
					$email_msg .= "<br />";
				}

			}elseif($user_type == "buyer")
			{
				$legal_docs_types = array(
					"IRS",
					"State of Incorporation or State of Organization",
					"Certificate of Incorporation or Certificate of Organization"
				);

				$arr_1 = FALSE;
				$arr_2 = FALSE;
				$arr_3 = FALSE;
				$legal_docs = $legal_documents_model->get_all($user_id);
				foreach($legal_docs as $legal_doc)
				{
					if($legal_doc->type == "IRS")
					{
						$arr_1 = TRUE;
					}
					if($legal_doc->type == "State of Incorporation or State of Organization")
					{
						$arr_2 = TRUE;
					}
					/*
					if($legal_doc->type == "Certificate of Incorporation or Certificate of Organization")
					{
						$arr_3 = TRUE;
					}
					*/
				}

				//if($arr_1 == TRUE AND $arr_2 == TRUE AND $arr_3 == TRUE)
				if($arr_1 == TRUE AND $arr_2 == TRUE)
				{
				}else{
					$email_msg .= "
						Name: $name <br />
						Email : $user_email <br />
					";

					if($arr_1 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for Internal Revenue Service W-9 Form <br />
						";
					}
					if($arr_2 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for State of Incorporation OR State of Organization <br />
						";
					}
					/*
					if($arr_3 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for Certificate of Incorporation or Certificate of Organization <br />
						";
					}
					*/
					$email_msg .= "<br />";
				}

			}else{
				$legal_docs_types = array(
					"IRS",
					"State of Incorporation or State of Organization",
					"Certificate of Incorporation or Certificate of Organization",
					"Documentation Authorizing Sales of Goods"
				);

				$arr_1 = FALSE;
				$arr_2 = FALSE;
				$arr_3 = FALSE;
				$arr_4 = FALSE;
				$legal_docs = $legal_documents_model->get_all($user_id);
				foreach($legal_docs as $legal_doc)
				{
					if($legal_doc->type == "IRS")
					{
						$arr_1 = TRUE;
					}
					if($legal_doc->type == "State of Incorporation or State of Organization")
					{
						$arr_2 = TRUE;
					}
					/*
					if($legal_doc->type == "Certificate of Incorporation or Certificate of Organization")
					{
						$arr_3 = TRUE;
					}
					if($legal_doc->type == "Documentation Authorizing Sales of Goods")
					{
						$arr_4 = TRUE;
					}
					*/
				}

				//if($arr_1 == TRUE AND $arr_2 == TRUE AND $arr_3 == TRUE AND $arr_4 == TRUE)
				if($arr_1 == TRUE AND $arr_2 == TRUE)
				{

				}else{
					$email_msg .= "
						Name: $name <br />
						Email : $user_email <br />
					";

					if($arr_1 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for Internal Revenue Service W-9 Form <br />
						";
					}
					if($arr_2 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for State of Incorporation OR State of Organization <br />
						";
					}
					/*
					if($arr_3 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for Certificate of Incorporation or Certificate of Organization <br />
						";
					}
					if($arr_4 == FALSE)
					{
						$email_msg .= "
							Did not upload yet the docoments for Documentation Authorizing Sales of Goods <br />
						";
					}
					*/
					$email_msg .= "<br />";
				}
			}
		}

		//email to the admin
		$admin_model = new admin_Model;
		$admin = $admin_model->get_one(1);
		$admin_email = $admin->email;

		$to = $admin_email;
		$from = "webmaster@logiclane.com";
		$subject = 'LogicLane Legal Documents Reminders';
		$message = $email_msg;
		email::send($to, $from, $subject, nl2br($message), TRUE);
		exit;
	}
}
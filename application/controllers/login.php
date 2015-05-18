<?php defined('SYSPATH') OR die('No direct access allowed.');

class Login_Controller extends Template_Controller {

	public $template = 'outside_tpl';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();

		if(!isset($_COOKIE["cart_cookie"]))
		{
			setcookie("cart_cookie", uniqid());
		}
	}

	public function index(){
		$this->template->content = new View("login/index");
		if($this->uri->segment(3) == "cart")
		{
			$redirect = "cart/shipping_address";
		}else{
			$redirect = "index/products";
		}
		$this->template->content->redirect = $redirect;
	}

	public function forgotpassword(){
		$this->template->content = new View("login/forgotpassword");

		if($_POST)
		{

		}
	}

	public function check(){

		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$username = $this->input->post("username");
			$password = base64_encode($this->input->post("password"));

			//get the enctrypted password
			$users_model = new Users_Model;
			$user = $users_model->process_login($username, $password);
			$count = count($user);

			if($count != 0)
			{
				$row = $user->current();
				$this->session->set('user_id', $row->user_id);
				$this->session->set('firstname', $row->firstname);
				$this->session->set('lastname', $row->lastname);
				$this->session->set('user_type', $row->type);
				$this->session->set('user_status', $row->user_status);

				//check if there are some legal docs that needs to upload
				$legal_documents_model = new Legal_Documents_Model;
				$legal_docs = $legal_documents_model->get_all($row->user_id);
				$legal_docs_count = count($legal_docs);
				if($legal_docs_count == 0)
				{
					echo json_encode(array("success"=>TRUE, "redirect"=>"login/upload_legal_docs"));
				}else{

					if($row->type == "charity")
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
							if($legal_doc->type == "Certificate of Incorporation or Certificate of Organization")
							{
								$arr_3 = TRUE;
							}
							if($legal_doc->type == "Documentation Regarding Charitable Status")
							{
								$arr_4 = TRUE;
							}
						}

						if($arr_1 == TRUE AND $arr_2 == TRUE AND $arr_3 == TRUE AND $arr_4 == TRUE)
						{
							echo json_encode(array("success"=>TRUE, "redirect"=>TRUE));
						}else{
							echo json_encode(array("success"=>TRUE, "redirect"=>"login/upload_legal_docs"));
						}

					}elseif($row->type == "buyer")
					{
						$legal_docs_types = array(
							"IRS",
							"State of Incorporation or State of Organization",
							"Certificate of Incorporation or Certificate of Organization"
						);

						$arr_1 = FALSE;
						$arr_2 = FALSE;
						$arr_3 = FALSE;
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
							if($legal_doc->type == "Certificate of Incorporation or Certificate of Organization")
							{
								$arr_3 = TRUE;
							}
						}

						if($arr_1 == TRUE AND $arr_2 == TRUE AND $arr_3 == TRUE)
						{
							echo json_encode(array("success"=>TRUE, "redirect"=>TRUE));
						}else{
							echo json_encode(array("success"=>TRUE, "redirect"=>"login/upload_legal_docs"));
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
							if($legal_doc->type == "Certificate of Incorporation or Certificate of Organization")
							{
								$arr_3 = TRUE;
							}
							if($legal_doc->type == "Documentation Authorizing Sales of Goods")
							{
								$arr_4 = TRUE;
							}
						}

						if($arr_1 == TRUE AND $arr_2 == TRUE AND $arr_3 == TRUE AND $arr_4 == TRUE)
						{
							echo json_encode(array("success"=>TRUE, "redirect"=>TRUE));
						}else{
							echo json_encode(array("success"=>TRUE, "redirect"=>"login/upload_legal_docs"));
						}
					}
				}
			}else{
				echo json_encode(array("success"=>FALSE));
			}
		}
	}

	public function check_forgotpassword(){

		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$email = $this->input->post("email");

			//get the enctrypted password
			$users_model = new Users_Model;
			$user = $users_model->check_username($email);
			$count = count($user);

			if($count != 0)
			{
				$row = $user->current();
				$user_id = $row->user_id;
				$uniqid = base64_encode(uniqid());

				$data = array(
					"password" => $uniqid
				);
				$users_model->edit($user_id, $data);

				$to = $email;
				$from = "webmaster@logiclane.com";
				$subject = 'Your LogicLane Password';
				$decoded_password = base64_decode($uniqid);
				$message = "Your LogicLane password is $decoded_password, you can change that on the Edit Profile page.";
				email::send($to, $from, $subject, nl2br($message), TRUE);

				echo json_encode(TRUE);
			}else{
				echo json_encode(FALSE);
			}
		}
	}
	
}
?>
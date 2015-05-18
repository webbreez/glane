<?php defined('SYSPATH') OR die('No direct access allowed.');

class Register_Controller extends Template_Controller {

	public $template = 'index_tpl2';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();		

		$products_model = new products_Model;
		$category_1 = $products_model->get_category_1();

		$this->template->category_1 = $category_1;	

		$featured_products = $products_model->get_featured_products();
		$this->template->featured_products = $featured_products;
	}

	public function index(){
		$this->template->content = new View("register/index");

		$states_model = new states_Model;
		$states = $states_model->get_all();
		$this->template->content->states = $states;
	}

	public function successful(){
		$this->template->content = new View("register/successful");
	}

	public function activate($uniqid){
		$this->auto_render = FALSE;

		$users_model = new users_Model;

		$member = $users_model->get_one_by_uniqid($uniqid);
		$count = count($member);

		if($count != 0)
		{	
			$row = $member->current();
			$user_id = $row->user_id;

			$this->session->set('user_id', $row->user_id);
			$this->session->set('firstname', $row->firstname);
			$this->session->set('lastname', $row->lastname);
			$this->session->set('user_type', $row->type);
			$this->session->set('user_status', $row->user_status);

			$data = array(
				"user_status" => 1
			);

			$users_model->edit($user_id, $data);
			
			url::redirect("home");

		}else{
			url::redirect("index/products");
		}
	}

	public function check_username()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$email = $this->input->post("email");
			
			$users_model = new users_Model;

			$check_username = $users_model->check_username($email);
			$count = count($check_username);
			if($count == 0)
			{
				//add to the database
				$password = base64_encode($this->input->post("passw"));
				$firstname = $this->input->post("firstname");
				$lastname = $this->input->post("lastname");
				$address_1 = $this->input->post("address_1");
				$address_2 = $this->input->post("address_2");
				$city = $this->input->post("city");
				$state = $this->input->post("state");
				$zip = $this->input->post("zip");
				$type = $this->input->post("type");

				$uniqid = uniqid();

				$user_data = array(
					"email" => $email,
					"password" => $password,
					"firstname" => $firstname,
					"lastname" => $lastname,
					"uniqid" => $uniqid,
					"type" => $type
				);
				$user_id = $users_model->add($user_data);

				//user address
				$address_data = array(
					"user_id" => $user_id,
					"user_address_1" => $address_1,
					"user_address_2" => $address_2,
					"user_address_city" => $city,
					"user_address_state" => $state,
					"user_address_zip" => $zip,
					"user_address_status" => '1'
				);
				$users_model->add_address($address_data);

				//add logs
				$user_logs = array(
					"user_id" => $user_id,
					"date_created" => time(),
					"log_details" => 1
				);
				$users_model->add_logs($user_logs);

				//send email
				$to = $email;
				$from = "webmaster@logiclane.com";
				$subject = 'LogicLane Activation Email';
				$message = "Please click here http://www.logiclane.com/register/activate/$uniqid to activate your account";
				email::send($to, $from, $subject, nl2br($message), TRUE);

				$encoded_user_id = base64_encode($user_id);
				echo json_encode(array("success"=>"Y", "uid"=>$encoded_user_id));
			}else{
				echo json_encode(array("success"=>"N"));
			}
		}
	}

	public function step_2($user_id)
	{
		$this->template->content = new View("register/step_2");

		$this->template->content->uid = $user_id;
	}

	public function save_step_2()
	{
		if (request::is_ajax()){
			$this->auto_render = FALSE;

			$users_model = new users_Model;

			$user_id = base64_decode($this->input->post("uid"));

			$data = array(
			"user_id" => $user_id,
			"business_name" => $this->input->post("business_name"),
			"business_description" => $this->input->post("business_description"),
			"entity_type" => $this->input->post("entity_type"),
			"entity_category" => $this->input->post("entity_category"),
			"entity_privileges" => "",
			"year_established" => $this->input->post("year_established"),
			"number_of_entity" => $this->input->post("number_of_entity"),
			"number_of_employees" => $this->input->post("number_of_employees"),
			"number_of_direct_customers" => $this->input->post("number_of_direct_customers"),
			"ref_business_name" => $this->input->post("ref_business_name"),
			"ref_business_name" => $this->input->post("ref_contact_name"),
			"ref_contact_address" => $this->input->post("ref_contact_address"),
			"ref_contact_email_address" => $this->input->post("ref_contact_email_address"),
			"ref_contact_phone_number" => $this->input->post("ref_contact_phone_number"),
			"ref_lenght_of_business_relationship" => $this->input->post("ref_lenght_of_business_relationship"),
			"ref_entiry_ein" => $this->input->post("ref_entiry_ein")
			);
			
			$users_model->add_business_profile($data);
			echo json_encode(array("success"=>"Y","uid"=>base64_encode($user_id)));
		}
	}

	public function step_3($user_id)
	{
		$this->template->content = new View("register/step_3");

		//get user type
		$id = base64_decode($user_id);
		$users_model = new users_Model;
		$check_user = $users_model->get_one($id);
		$user_type = $check_user->type;

		$this->template->content->uid = $user_id;
		$this->template->content->user_type = $user_type;

		$states_model = new states_Model;
		$states = $states_model->get_all();
		$this->template->content->states = $states;

		if($_POST)
		{
			foreach( $_FILES[ 'irs_w9form' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
			{
				$target_path = DOCROOT."assets/upload/";

				$filename = $target_path . basename($_FILES["irs_w9form"]['name'][$irs_index]); 
				move_uploaded_file($irs_tmp_name, $filename);

				$filename_array = explode("/", $filename);
				$filename = end($filename_array);
				$file_ext_array = explode(".", $filename);
				$file_ext = end($file_ext_array);
				if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
				{
					$data['user_id'] = base64_decode($user_id);
					$data['date_created'] = time();
					$data['status'] = "P";
					$data['type'] = "IRS";
					$data['title'] = $filename;

					$new_filename = uniqid().".".strtolower($file_ext);
					$data['filename'] = $new_filename;
					$legal_documents_model = new legal_documents_Model;
					$legal_documents_model->add($data);

					rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
				}else{
					@unlink(DOCROOT."assets/upload/".$filename);
				}
			}

			if($this->input->post("state_of_incorporation"))
			{
				$data['user_id'] = base64_decode($user_id);
				$data['date_created'] = time();
				$data['status'] = "P";
				$data['type'] = "State of Incorporation or State of Organization";
				$data['title'] = $this->input->post("state_of_incorporation");

				//$new_filename = uniqid().".".strtolower($file_ext);
				$data['filename'] = $this->input->post("state_of_incorporation");
				$legal_documents_model = new legal_documents_Model;
				$legal_documents_model->add($data);
			}
			/*
			foreach( $_FILES[ 'state_of_incorporation' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
			{
				$target_path = DOCROOT."assets/upload/";

				$filename = $target_path . basename($_FILES["state_of_incorporation"]['name'][$irs_index]); 
				move_uploaded_file($irs_tmp_name, $filename);

				$filename_array = explode("/", $filename);
				$filename = end($filename_array);
				$file_ext_array = explode(".", $filename);
				$file_ext = end($file_ext_array);
				if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
				{
					$data['user_id'] = base64_decode($user_id);
					$data['date_created'] = time();
					$data['status'] = "P";
					$data['type'] = "State of Incorporation or State of Organization";
					$data['title'] = $filename;

					$new_filename = uniqid().".".strtolower($file_ext);
					$data['filename'] = $new_filename;
					$legal_documents_model = new legal_documents_Model;
					$legal_documents_model->add($data);

					rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
				}else{
					@unlink(DOCROOT."assets/upload/".$filename);
				}
			}
			*/
			/*
			foreach( $_FILES[ 'certificate_of_incorporation' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
			{
				$target_path = DOCROOT."assets/upload/";

				$filename = $target_path . basename($_FILES["certificate_of_incorporation"]['name'][$irs_index]); 
				move_uploaded_file($irs_tmp_name, $filename);

				$filename_array = explode("/", $filename);
				$filename = end($filename_array);
				$file_ext_array = explode(".", $filename);
				$file_ext = end($file_ext_array);
				if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
				{
					$data['user_id'] = base64_decode($user_id);
					$data['date_created'] = time();
					$data['status'] = "P";
					$data['type'] = "Certificate of Incorporation or Certificate of Organization";
					$data['title'] = $filename;

					$new_filename = uniqid().".".strtolower($file_ext);
					$data['filename'] = $new_filename;
					$legal_documents_model = new legal_documents_Model;
					$legal_documents_model->add($data);

					rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
				}else{
					@unlink(DOCROOT."assets/upload/".$filename);
				}
			}

			foreach( $_FILES[ 'current_business_license' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
			{
				$target_path = DOCROOT."assets/upload/";

				$filename = $target_path . basename($_FILES["current_business_license"]['name'][$irs_index]); 
				move_uploaded_file($irs_tmp_name, $filename);

				$filename_array = explode("/", $filename);
				$filename = end($filename_array);
				$file_ext_array = explode(".", $filename);
				$file_ext = end($file_ext_array);
				if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
				{
					$data['user_id'] = base64_decode($user_id);
					$data['date_created'] = time();
					$data['status'] = "P";
					$data['type'] = "Current Business License";
					$data['title'] = $filename;

					$new_filename = uniqid().".".strtolower($file_ext);
					$data['filename'] = $new_filename;
					$legal_documents_model = new legal_documents_Model;
					$legal_documents_model->add($data);

					rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
				}else{
					@unlink(DOCROOT."assets/upload/".$filename);
				}
			}
			*/
			if(isset($_FILES[ 'documentation_authorizing_sales_of_goods' ]))
			{
				foreach( $_FILES[ 'documentation_authorizing_sales_of_goods' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
				{
					$target_path = DOCROOT."assets/upload/";

					$filename = $target_path . basename($_FILES["documentation_authorizing_sales_of_goods"]['name'][$irs_index]); 
					move_uploaded_file($irs_tmp_name, $filename);

					$filename_array = explode("/", $filename);
					$filename = end($filename_array);
					$file_ext_array = explode(".", $filename);
					$file_ext = end($file_ext_array);
					if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
					{
						$data['user_id'] = base64_decode($user_id);
						$data['date_created'] = time();
						$data['status'] = "P";
						$data['type'] = "Documentation Authorizing Sales of Goods";
						$data['title'] = $filename;

						$new_filename = uniqid().".".strtolower($file_ext);
						$data['filename'] = $new_filename;
						$legal_documents_model = new legal_documents_Model;
						$legal_documents_model->add($data);

						rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
					}else{
						@unlink(DOCROOT."assets/upload/".$filename);
					}
				}
			}

			if(isset($_FILES[ 'documentation_regarding_charitable_status' ]))
			{
				foreach( $_FILES[ 'documentation_regarding_charitable_status' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
				{
					$target_path = DOCROOT."assets/upload/";

					$filename = $target_path . basename($_FILES["documentation_regarding_charitable_status"]['name'][$irs_index]); 
					move_uploaded_file($irs_tmp_name, $filename);

					$filename_array = explode("/", $filename);
					$filename = end($filename_array);
					$file_ext_array = explode(".", $filename);
					$file_ext = end($file_ext_array);
					if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
					{
						$data['user_id'] = base64_decode($user_id);
						$data['date_created'] = time();
						$data['status'] = "P";
						$data['type'] = "Documentation Regarding Charitable Status";
						$data['title'] = $filename;

						$new_filename = uniqid().".".strtolower($file_ext);
						$data['filename'] = $new_filename;
						$legal_documents_model = new legal_documents_Model;
						$legal_documents_model->add($data);

						rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
					}else{
						@unlink(DOCROOT."assets/upload/".$filename);
					}
				}
			}
			/*
			if($_FILES[ 'additional_documentation' ])
			{
				foreach( $_FILES[ 'additional_documentation' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
				{
					$target_path = DOCROOT."assets/upload/";

					$filename = $target_path . basename($_FILES["additional_documentation"]['name'][$irs_index]); 
					move_uploaded_file($irs_tmp_name, $filename);

					$filename_array = explode("/", $filename);
					$filename = end($filename_array);
					$file_ext_array = explode(".", $filename);
					$file_ext = end($file_ext_array);
					if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
					{
						$data['user_id'] = base64_decode($user_id);
						$data['date_created'] = time();
						$data['status'] = "P";
						$data['type'] = "Additional Documentation";
						$data['title'] = $filename;

						$new_filename = uniqid().".".strtolower($file_ext);
						$data['filename'] = $new_filename;
						$legal_documents_model = new legal_documents_Model;
						$legal_documents_model->add($data);

						rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
					}else{
						@unlink(DOCROOT."assets/upload/".$filename);
					}
				}
			}
			*/
			$additional_comments = $this->input->post("additional_comments");
			if($additional_comments)
			{
				$data['user_id'] = base64_decode($user_id);
				$data['date_created'] = time();
				$data['status'] = "P";
				$data['type'] = "Additional Comments";
				$data['title'] = "Additional Comments";

				$data['additional_comments'] = $additional_comments;
				$legal_documents_model = new legal_documents_Model;
				$legal_documents_model->add($data);

			}
			
			url::redirect("register/successful");
		}
	}

	public function upload_legal_docs()
	{
		$this->template->content = new View("register/upload_legal_docs");

		$user_status = $this->session->get('user_status');
		if($user_status == "1")
		{
			url::redirect("index/products");
		}

		//get user type
		$user_id = $this->session->get('user_id');
		$users_model = new users_Model;
		$check_user = $users_model->get_one($user_id);
		$user_type = $check_user->type;

		$this->template->content->uid = $user_id;
		$this->template->content->user_type = $user_type;

		$states_model = new states_Model;
		$states = $states_model->get_all();
		$this->template->content->states = $states;

		if($_POST)
		{
			$user_id = $this->session->get('user_id');

			foreach( $_FILES[ 'irs_w9form' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
			{
				$target_path = DOCROOT."assets/upload/";

				$filename = $target_path . basename($_FILES["irs_w9form"]['name'][$irs_index]); 
				move_uploaded_file($irs_tmp_name, $filename);

				$filename_array = explode("/", $filename);
				$filename = end($filename_array);
				$file_ext_array = explode(".", $filename);
				$file_ext = end($file_ext_array);
				if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
				{
					$data['user_id'] = $user_id;
					$data['date_created'] = time();
					$data['status'] = "P";
					$data['type'] = "IRS";
					$data['title'] = $filename;

					$new_filename = uniqid().".".strtolower($file_ext);
					$data['filename'] = $new_filename;
					$legal_documents_model = new legal_documents_Model;
					$legal_documents_model->add($data);

					rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
				}else{
					@unlink(DOCROOT."assets/upload/".$filename);
				}
			}

			if($this->input->post("state_of_incorporation"))
			{
				$data['user_id'] = base64_decode($user_id);
				$data['date_created'] = time();
				$data['status'] = "P";
				$data['type'] = "State of Incorporation or State of Organization";
				$data['title'] = $this->input->post("state_of_incorporation");

				//$new_filename = uniqid().".".strtolower($file_ext);
				$data['filename'] = $this->input->post("state_of_incorporation");
				$legal_documents_model = new legal_documents_Model;
				$legal_documents_model->add($data);
			}

			/*
			foreach( $_FILES[ 'state_of_incorporation' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
			{
				$target_path = DOCROOT."assets/upload/";

				$filename = $target_path . basename($_FILES["state_of_incorporation"]['name'][$irs_index]); 
				move_uploaded_file($irs_tmp_name, $filename);

				$filename_array = explode("/", $filename);
				$filename = end($filename_array);
				$file_ext_array = explode(".", $filename);
				$file_ext = end($file_ext_array);
				if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
				{
					$data['user_id'] = $user_id;
					$data['date_created'] = time();
					$data['status'] = "P";
					$data['type'] = "State of Incorporation or State of Organization";
					$data['title'] = $filename;

					$new_filename = uniqid().".".strtolower($file_ext);
					$data['filename'] = $new_filename;
					$legal_documents_model = new legal_documents_Model;
					$legal_documents_model->add($data);

					rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
				}else{
					@unlink(DOCROOT."assets/upload/".$filename);
				}
			}
			*/
			/*
			foreach( $_FILES[ 'certificate_of_incorporation' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
			{
				$target_path = DOCROOT."assets/upload/";

				$filename = $target_path . basename($_FILES["certificate_of_incorporation"]['name'][$irs_index]); 
				move_uploaded_file($irs_tmp_name, $filename);

				$filename_array = explode("/", $filename);
				$filename = end($filename_array);
				$file_ext_array = explode(".", $filename);
				$file_ext = end($file_ext_array);
				if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
				{
					$data['user_id'] = $user_id;
					$data['date_created'] = time();
					$data['status'] = "P";
					$data['type'] = "Certificate of Incorporation or Certificate of Organization";
					$data['title'] = $filename;

					$new_filename = uniqid().".".strtolower($file_ext);
					$data['filename'] = $new_filename;
					$legal_documents_model = new legal_documents_Model;
					$legal_documents_model->add($data);

					rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
				}else{
					@unlink(DOCROOT."assets/upload/".$filename);
				}
			}

			foreach( $_FILES[ 'current_business_license' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
			{
				$target_path = DOCROOT."assets/upload/";

				$filename = $target_path . basename($_FILES["current_business_license"]['name'][$irs_index]); 
				move_uploaded_file($irs_tmp_name, $filename);

				$filename_array = explode("/", $filename);
				$filename = end($filename_array);
				$file_ext_array = explode(".", $filename);
				$file_ext = end($file_ext_array);
				if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
				{
					$data['user_id'] = $user_id;
					$data['date_created'] = time();
					$data['status'] = "P";
					$data['type'] = "Current Business License";
					$data['title'] = $filename;

					$new_filename = uniqid().".".strtolower($file_ext);
					$data['filename'] = $new_filename;
					$legal_documents_model = new legal_documents_Model;
					$legal_documents_model->add($data);

					rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
				}else{
					@unlink(DOCROOT."assets/upload/".$filename);
				}
			}
			*/
			if(isset($_FILES[ 'documentation_authorizing_sales_of_goods' ]))
			{
				foreach( $_FILES[ 'documentation_authorizing_sales_of_goods' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
				{
					$target_path = DOCROOT."assets/upload/";

					$filename = $target_path . basename($_FILES["documentation_authorizing_sales_of_goods"]['name'][$irs_index]); 
					move_uploaded_file($irs_tmp_name, $filename);

					$filename_array = explode("/", $filename);
					$filename = end($filename_array);
					$file_ext_array = explode(".", $filename);
					$file_ext = end($file_ext_array);
					if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
					{
						$data['user_id'] = $user_id;
						$data['date_created'] = time();
						$data['status'] = "P";
						$data['type'] = "Documentation Authorizing Sales of Goods";
						$data['title'] = $filename;

						$new_filename = uniqid().".".strtolower($file_ext);
						$data['filename'] = $new_filename;
						$legal_documents_model = new legal_documents_Model;
						$legal_documents_model->add($data);

						rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
					}else{
						@unlink(DOCROOT."assets/upload/".$filename);
					}
				}
			}

			if(isset($_FILES[ 'documentation_regarding_charitable_status' ]))
			{
				foreach( $_FILES[ 'documentation_regarding_charitable_status' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
				{
					$target_path = DOCROOT."assets/upload/";

					$filename = $target_path . basename($_FILES["documentation_regarding_charitable_status"]['name'][$irs_index]); 
					move_uploaded_file($irs_tmp_name, $filename);

					$filename_array = explode("/", $filename);
					$filename = end($filename_array);
					$file_ext_array = explode(".", $filename);
					$file_ext = end($file_ext_array);
					if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
					{
						$data['user_id'] = $user_id;
						$data['date_created'] = time();
						$data['status'] = "P";
						$data['type'] = "Documentation Regarding Charitable Status";
						$data['title'] = $filename;

						$new_filename = uniqid().".".strtolower($file_ext);
						$data['filename'] = $new_filename;
						$legal_documents_model = new legal_documents_Model;
						$legal_documents_model->add($data);

						rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
					}else{
						@unlink(DOCROOT."assets/upload/".$filename);
					}
				}
			}
			/*
			if($_FILES[ 'additional_documentation' ])
			{
				foreach( $_FILES[ 'additional_documentation' ][ 'tmp_name' ] as $irs_index => $irs_tmp_name )
				{
					$target_path = DOCROOT."assets/upload/";

					$filename = $target_path . basename($_FILES["additional_documentation"]['name'][$irs_index]); 
					move_uploaded_file($irs_tmp_name, $filename);

					$filename_array = explode("/", $filename);
					$filename = end($filename_array);
					$file_ext_array = explode(".", $filename);
					$file_ext = end($file_ext_array);
					if(strtolower($file_ext) == 'jpg' || strtolower($file_ext) == 'jpeg' || strtolower($file_ext) == 'gif' || strtolower($file_ext) == 'png' || strtolower($file_ext) == 'pdf')
					{
						$data['user_id'] = $user_id;
						$data['date_created'] = time();
						$data['status'] = "P";
						$data['type'] = "Additional Documentation";
						$data['title'] = $filename;

						$new_filename = uniqid().".".strtolower($file_ext);
						$data['filename'] = $new_filename;
						$legal_documents_model = new legal_documents_Model;
						$legal_documents_model->add($data);

						rename(DOCROOT."assets/upload/".$filename, DOCROOT."assets/upload/".$new_filename);
					}else{
						@unlink(DOCROOT."assets/upload/".$filename);
					}
				}
			}
			*/
			$additional_comments = $this->input->post("additional_comments");
			if($additional_comments)
			{
				$data['user_id'] = $user_id;
				$data['date_created'] = time();
				$data['status'] = "P";
				$data['type'] = "Additional Comments";
				$data['title'] = "Additional Comments";

				$data['additional_comments'] = $additional_comments;
				$legal_documents_model = new legal_documents_Model;
				$legal_documents_model->add($data);

			}
			url::redirect("index/products");
		}
	}


}
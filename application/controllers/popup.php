<?php defined('SYSPATH') OR die('No direct access allowed.');

class Popup_Controller extends Template_Controller {

	public $template = 'popup_tpl';

	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();		
	}

	public function close(){
		$this->template->content = new View("popup/close");
	}

	public function close_msg($type){
		$this->template->content = new View("popup/close_msg");

		if($type == "offer")
		{
			$msg = "Your offer was submitted,<br /> the seller will get back to you<br /> as soon as possible.";
		}elseif($type == "counter_offer")
		{
			$msg = "Your counter offer was submitted,<br /> We will get back to you<br /> as soon as possible.";
		}

		$this->template->content->msg = $msg;
	}

	public function close_alert($type){
		$this->template->content = new View("popup/close_alert");

		if($type == "rejected")
		{
			$msg = "Your offer was rejected.";
		}
		$this->template->content->msg = $msg;
	}

	public function reload(){
		$this->template->content = new View("popup/reload");
	}
	
}
?>
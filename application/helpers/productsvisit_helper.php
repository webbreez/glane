<?php defined('SYSPATH') OR die('No direct access allowed.');

class productsvisit_helper_Core {

	public function save_data($user_id, $product_id, $main_category)
	{
		$this->db = new Database;

		// $ipaddress = '';
	 //   	if (getenv('HTTP_CLIENT_IP'))
	 //        $ipaddress = getenv('HTTP_CLIENT_IP');
	 //    else if(getenv('HTTP_X_FORWARDED_FOR'))
	 //        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	 //    else if(getenv('HTTP_X_FORWARDED'))
	 //        $ipaddress = getenv('HTTP_X_FORWARDED');
	 //    else if(getenv('HTTP_FORWARDED_FOR'))
	 //        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	 //    else if(getenv('HTTP_FORWARDED'))
	 //       $ipaddress = getenv('HTTP_FORWARDED');
	 //    else if(getenv('REMOTE_ADDR'))
	 //        $ipaddress = getenv('REMOTE_ADDR');
	 //    else
	 //        $ipaddress = 'UNKNOWN';

	    $ipaddress = productsvisit_helper::get_ip_address();
		
		$query = "
			INSERT INTO
				products_visit
			(
				user_id,
				product_id,
				visitor_ip,
				main_category
			)
			VALUES
			(
				'{$user_id}',
				'{$product_id}',
				'{$ipaddress}',
				'{$main_category}'
			)
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
	}

	public function get_ip_address()
	{
		$ipaddress = '';
	   	if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';

	    return $ipaddress;

	}
}
<?php defined('SYSPATH') OR die('No direct access allowed.');

class productpicture_helper_Core {

	public function get_product_picture($product_id)
	{
		$this->db = new Database;

		$query = "
			SELECT * FROM products_images WHERE product_id = '{$product_id}'
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);

		$count = count($sql);
		if($count != 0)
		{
			$row = $sql->current();
			$filename = $row->product_images_filename;	
			return $filename;
		}else{
			return "";
		}
	}
}
?>
<?php defined('SYSPATH') OR die('No direct access allowed.');

class relatedproducts_helper_Core {

	public function get_related_products($main_product_id)
	{
		$this->db = new Database;

		$query = "
			SELECT 
				* 
			FROM 
				products
			JOIN
				related_products
				ON
					related_products.product_id = products.product_id
			WHERE 
				main_product_id = '{$main_product_id}'
			ORDER BY
				RAND ()
			LIMIT
				4
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);
		return $sql;
	}
}
?>
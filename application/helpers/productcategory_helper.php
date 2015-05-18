<?php defined('SYSPATH') OR die('No direct access allowed.');

class productcategory_helper_Core {

	public function get_category_name($table, $category_id)
	{
		$this->db = new Database;

		if($table == "category_1")
		{
			$cond = "category_1_id = '{$category_id}'";
		}elseif($table == "category_2"){
			$cond = "category_2_id = '{$category_id}'";
		}elseif($table == "category_3"){
			$cond = "category_3_id = '{$category_id}'";
		}else{
			$cond = "category_4_id = '{$category_id}'";
		}

		$query = "
			SELECT * FROM {$table} WHERE {$cond}
		";
		// echo $query;
		// exit;
		$sql = $this->db->query($query);

		$count = count($sql);
		if($count != 0)
		{
			$row = $sql->current();
			if($table == "category_1")
			{
				return $row->category_1_name;
			}elseif($table == "category_2")
			{
				return $row->category_2_name;
			}elseif($table == "category_3")
			{
				return $row->category_3_name;
			}else{
				return $row->category_4_name;
			}
		}else{
			return "";
		}

	}
}
?>
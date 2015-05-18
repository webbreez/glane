<?php defined('SYSPATH') OR die('No direct access allowed.');

class pages_Model extends Model {

	public function __construct()
	{		
		parent::__construct();
				
		$this->session = Session::instance();		
	}

	public function add($data){
		$sql = $this->db
				->insert("pages", $data);
	}
	
	public function edit($id, $data){
		$sql = $this->db
				->where("id", $id)
				->update("pages", $data);
	}
	
	public function get_one($id){
		$sql = $this->db
				->where("id", $id)
				->get("pages");
		return $sql->current();
	}

	public function search($search){
		$sql = $this->db
				->like("content", $search)
				->get("pages");
		return $sql;
	}

	public function delete($id){
		$sql = $this->db
				->where("id", $id)
				->delete("pages");
	}

	public function blurb($bl){
		$count = 1;
		$blurb = $bl;
		while ($this->count_blurb($bl) > 0){
			$count++;
			$bl = $blurb. "$count";
		}
		
		return $bl;
	}

	private function count_blurb($blurb){
		$sql = $this->db
				->where("url", $blurb)
				->count_records("sub_pages");
		return $sql;
	}

}

?>
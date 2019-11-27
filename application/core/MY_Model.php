<?php
/* Generic CRUD  */

class MY_Model extends CI_Model {		
	protected $table_name = ''; // table name
	protected $primary_key = 'id'; // primary key
	protected $primary_key_filter = 'toint'; // filter key
	protected $order_by = ''; // order by caluse
	protected $timestemp = False; // current sava time

	/* Constructor  */
	function __construct(){
		parent::__construct();
	}

	/* Get Record  */
	public function get($id = Null , $single = False){
		if($id != Null){
			$this->db->where($this->primary_key,$id);
		    $method = 'row';
		}
		elseif ($single == True){
			$method = 'row';
		}
		else{
			$method = 'result';
		}
		if(!count($this->order_by)){	
			$this->db->order_by($this->order_by);
		}
		return  $this->db->get($this->table_name)->$method();
	}
	/* Get Record By Where Caluse  */
	public function get_by($where,$single = FALSE){
		$this->db->where($where);
	 	return $this->get(Null, $single); 
	}
	/* Get Record By Query  */	
	public function get_by_query($query){
		$result = $this->db->query($query);
		if ($result->num_rows() > 0){
			return $result->result();
		}
		else{
			return null;
		}
	}

	/* Save the Data  */
	public function save($data , $id = Null){
		if($this->timestemp == True){
			$now = date('Y-m-d H:i:s');
			!$id || $data['created'] = $now;
			$data['modefied'] = $now;
		}
		if($id === Null){
			!isset($data[$this->primary_key]) || $data[$this->primary_key] = NULL;
			$this->db->set($data);
			$this->db->insert($this->table_name);
			$id = $this->db->insert_id();
		} 
		else {
			$this->db->set($data);
			$this->db->where($this->primary_key,$id);
			$this->db->update($this->table_name);	
		}
		return  $id;
	}

	/* Remove data */
	public function delete($id){
		$this->db->where($this->primary_key,$id);
		$this->db->delete($this->table_name);
	}
}
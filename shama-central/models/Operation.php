<?php 
 /**
 *  Operation Model
 *  This model can be used for any purpose
 */
 class Operation extends MY_Model
 {
 	
 		public $table_name = ''; // table name
  	public $primary_key = 'id'; // primary key
  	public $order_by = 'desc'; // primary key
  	// Save value
	public function Create($array,$id = NULL){
		return $this->operation->save($array,$id);	
	}
	// Get values by query 
	public function GetRowsByQyery($query){
		return $this->operation->get_by_query($query);
	}
	// Get value by where clause
	public function GetByWhere($array,$single = FALSE){
		return $this->operation->get_by($array,$single);
	}
	// Remove value from table
	public function Remove($id){
		 $this->operation->delete($id);
	}
	// Get rows (single,multiple)
	public function GetRows($id = NULL , $single = FALSE){
		return $this->operation->get($id ,$single);	
	}
 }


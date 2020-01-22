<?php
class City_model extends CI_Model {
 
public function __construct() {
 $this -> load -> database();
 
}
 
function get_cities($country = null){

  $data= $this->db->query("select * from sections where id = ".$country);
  echo $data;
  return $data;


}
}
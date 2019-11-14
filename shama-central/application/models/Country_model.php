<?php
class Country_model extends CI_Model {
 
public function __construct() {
 $this -> load -> database();
 
}
 
public function get_countries() {
 $this -> db -> select('id,grade');
 $query = $this -> db -> get('classes');
 
$countries = array();
 
if ($query -> result()) {
 foreach ($query->result() as $country) {
 $countries[$country -> id] = $country ->grade;
 }
 return $countries;
 } else {
 return FALSE;
 }
 }
 
}
?>
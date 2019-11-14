<?php
class State_city_model extends CI_Model {
      
    /**
     * This funtion will return me the result of all the states.
     * This has to be unique because the states will be repeating.
     */
    function get_unique_states() {
        $query = $this->db->query("SELECT * FROM classes");
          
        if ($query->num_rows > 0) {
            return $query->result();

        }
    }


      
    /**
     * This function will take the state as argument
     * and then return the cities which fall under that particular state.
     */
    function get_cities_from_state($state) {
        $query = $this->db->query("SELECT  * FROM sections WHERE class_id = {$state}");
          
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }

function setvalue()
{
    $asset=3;
 $this->db->select('isdone');
    $this->db->from('quize');
    $q=$this->db->where('id',$asset);
    
 
    $data=$q->result();
    
    if($q==false || $q==0)
    {
        $this->db->query("Update quize set isdone=true") ;
    }
    else{
        
        $this->db->query("Update quize set isdone=false") ;   

}

        

}


}
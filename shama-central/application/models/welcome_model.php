<?php 
class Welcome_model extends CI_Model
    {
        public function insertCSV($data)
            {
                $this->db->insert('subject', $data);
                return $this->db->insert_id();
            }
    }
?>
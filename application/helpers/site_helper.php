<?php

function getDuration($start_time,$end_time)
{
    $to_time =strtotime($start_time);
    $from_time = strtotime($end_time);
    $duration =  round(abs($to_time - $from_time) / 60,2). "";
    return $duration;
}

function getName($table,$filedName,$id)
{
    $ci=& get_instance();
    $ci->load->database(); 

    $sql ="SELECT ".$filedName." FROM $table
          WHERE id =".$id; 

    $query = $ci->db->query($sql);
    $row = $query->row();
    return $row->$filedName;
}

function getUserName($user_id=null)
{
    $ci=& get_instance();
    $ci->load->database(); 

    $sql ="SELECT screenname FROM invantage_users
          WHERE id =".$user_id; 

    $query = $ci->db->query($sql);
    if(count($query)){
        $row = $query->row();
        return $row->screenname;
    }
    return "";
}

?>
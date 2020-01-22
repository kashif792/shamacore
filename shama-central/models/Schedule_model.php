<?php

class Schedule_Model extends CI_Model
{
	public function getScheduleData()
	{
		 //$query = $this->db->query("SELECT sch.id, cls.grade , sect.section_name, sbj.subject_name, invnusr.screenname, sch.start_time, sch.end_time FROM schedule sch, classes cls, sections sect, subjects sbj, invantageuser invnusr WHERE sch.class_id = cls.id AND sect.id = sch.section_id AND sbj.id = sch.subject_id AND sch.teacher_uid = invnusr.id");


if( $this->session->userdata('type')=='p'){
	 		
	 	$query = $this->db->query("SELECT sch.id, cls.grade , sect.section_name, sbj.subject_name, invnusr.screenname, sch.start_time, sch.end_time FROM schedule sch, classes cls, sections sect, subjects sbj, invantageuser invnusr WHERE sch.class_id = cls.id AND sect.id = sch.section_id AND sbj.id = sch.subject_id AND sch.teacher_uid = invnusr.id");


	   }
	   else if ($this->session->userdata('type')=='t') {
	   

	   // $query = $this->db->query("SELECT sc.id, subject_name,grade,section_name,username,start_time,end_time FROM schedule sc  INNER JOIN classes cl ON  sc.class_id=cl.id INNER JOIN invantageuser inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections  sct ON sc.section_id=sct.id where sc.teacher_uid=".$this->session->userdata('id'));
//$query = $this->db->query("SELECT sch.id, cls.grade , sect.section_name, sbj.subject_name, invnusr.screenname, sch.start_time, sch.end_time FROM schedule sch, classes cls, sections sect, subjects sbj, invantageuser invnusr WHERE sch.class_id = cls.id AND sect.id = sch.section_id AND sbj.id = sch.subject_id AND sch.teacher_uid =" .$this->session->userdata('id'));
                 $query = $this->db->query(" SELECT sch.id, cl.grade , sec.section_name, sbj.subject_name, invnusr.screenname, sch.start_time, sch.end_time FROM schedule sch inner join classes cl ON sch.class_id=cl.id 
inner join sections sec on sch.section_id=sec.id
inner join subjects sbj on sch.subject_id=sbj.id
inner join invantageuser invnusr on sch.teacher_uid=invnusr.id 

WHERE sch.teacher_uid=".$this->session->userdata('id'));
	   }





		return $query->result();
	}
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Rest_Controller.php';

/**
 * Schedules Widget API
 *
 */
class Widget_Schedule_Controller extends My_Rest_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Karachi");
        //$this->load->model('user');
        //$this->load->model('operation');
    }

    /**
     * Return schedule including hard coded assembly and break timings for KG and Other classes
     */
    function data_get()
    {

        try {

            
            
            
            $user_id = $this->input->get('user_id');
            $school_id = $this->input->get('school_id');
            $schedule = array();
            $class_array = array();
            $kindergarten_section = array();
            $rest_section = array();
            // Assembly time fetch from database
            //$school_id = $request->school_id;
            $active_session = $this->get_active_session($school_id);
            $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
            
            //print_r($user_id);

            if (! empty($user_id) && ! empty($school_id)) {

                $role_id = FALSE;
                if ($role = $this->get_user_role($user_id)) {
                    $role_id = $role->role_id;
                }
                $active_session = $this->get_active_session($school_id);
                $active_semester = $this->get_active_semester_dates_by_session($active_session->id);

                if ($role_id == 3 && count($active_session) && count($active_semester)) {

                    $result = $this->operation->GetByQuery("SELECT sc.*, cl.grade, sct.section_name as section, sub.subject_name as subject, screenname as teacher,start_time,end_time FROM schedule sc INNER JOIN classes cl ON  sc.class_id=cl.id INNER JOIN invantage_users inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections sct ON sc.section_id=sct.id WHERE cl.school_id =" . $school_id . " AND sc.session_id = " . $active_session->id . " AND sc.semester_id = " . $active_semester->semester_id . " ORDER by sc.id DESC");
                } else if ($role_id == 4 && count($active_session) && count($active_semester)) {


                    $result = $this->operation->GetByQuery("SELECT sc.*, cl.grade, sct.section_name as section, sub.subject_name as subject, screenname as teacher,start_time,end_time FROM schedule sc  INNER JOIN classes cl ON  sc.class_id=cl.id INNER JOIN invantage_users inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections  sct ON sc.section_id=sct.id WHERE sc.teacher_uid=" . $user_id . " AND cl.school_id =" . $school_id . " AND sc.session_id = " . $active_session->id . " AND sc.semester_id = " . $active_semester->semester_id);
                }
            }


            $this->operation->table_name = 'assembly';
            $is_assembly_found = $this->operation->GetByWhere(array('school_id' => $school_id));
            if(count($is_assembly_found))
            {
                $ass_start_time = $is_assembly_found[0]->start_time;
                $ass_end_time = $is_assembly_found[0]->end_time;
            }
            else
            {
                $ass_start_time = ASSEMBLY_START;
                $ass_end_time = ASSEMBLY_END;
            }
            // Break time fetch from database
            $today = strtolower(date("l"));
            $this->operation->table_name = 'break';
            $date = date('Y-m-d');
        
            $currentday = strtolower(date('D', strtotime($date)));
            //$currentday = 'fri';
            $is_break_found = $this->operation->GetByWhere(array('school_id' => $school_id));
            if(count($is_break_found))
            {
                if($today=="monday")
                {
                    $break_start_time = $is_break_found[0]->monday_start_time;
                    $break_end_time  = $is_break_found[0]->monday_end_time;
                }
                else if($today=="tuesday")
                {
                    $break_start_time = $is_break_found[0]->tuesday_start_time;
                    $break_end_time  = $is_break_found[0]->tuesday_end_time;
                }
                else if($today=="wednesday")
                {
                    $break_start_time = $is_break_found[0]->wednesday_start_time;
                    $break_end_time  = $is_break_found[0]->wednesday_end_time;
                }
                else if($today=="thursday")
                {
                    $break_start_time = $is_break_found[0]->thursday_start_time;
                    $break_end_time  = $is_break_found[0]->thursday_end_time;
                }
                else
                {
                    $break_start_time = $is_break_found[0]->friday_start_time;
                    $break_end_time  = $is_break_found[0]->friday_end_time;
                }

            }
            else
                {
                    $break_start_time = BREAK_START;
                    $break_end_time  = BREAK_END;
                }
               
            if ($role_id == 3 && count($active_session) && count($active_semester))
            {
                // get current day data
               
                $query = $this->operation->GetByQuery("SELECT sch.* FROM schedule sch  Where sch.semester_id = " . $active_semester->semester_id . " AND sch.session_id =" . $active_session->id . " Order by sch.id");
                
                if (count($query))
                {
                    $is_yellow_section_found = false;
                    foreach ($query as $key => $value)
                    {
                        // add assembly to each class
                        $day_status =  $currentday.'_status';
                        if($value->$day_status=='Active')
                        {

                            $grade = parent::getClass($value->class_id);
                            //$section = parent::getSectionList($value->section_id,$school_id);
                            $section = parent::getSectionList($value->section_id,$school_id);
                            $subject = parent::GetSubject($value->subject_id);
                            $teacher = parent::GetUserById($value->teacher_uid);
                            $is_class_found = in_array($grade, $class_array);
                            // get day name
                            $s_time =  $currentday.'_start_time';
                            $e_time =  $currentday.'_end_time';
                            $d_start_time = $value->$s_time;
                            $d_end_time = $value->$e_time;
                            //echo $value->subject_id;
                            //exit;
                            if ($is_class_found == false && date('H:i', strtotime($d_start_time)) >= date('H:i', DateTime::createFromFormat('H:i', $ass_start_time)))
                            {
                                array_push($class_array, $grade);
                                $schedule[] = array('grade' => $grade, 'section' => $section[0]->section_name, 'subject' => "Assembly", 'teacher' => "Assembly", 'start_time' => $ass_start_time, 'end_time' => $ass_end_time,);
                            }
                            $is_kin_class_found = in_array($section[0]->id, $kindergarten_section);
                            // break to kindergarten
                            if ($is_kin_class_found == false && $grade == 'Kindergarten' && date('H:i', strtotime($d_start_time)) >= date('H:i', DateTime::createFromFormat('H:i', $break_start_time)))
                            {
                                array_push($kindergarten_section, $section[0]->id);
                                $schedule[] = array('grade' => $grade, 'section' => $section[0]->section_name, 'subject' => "Break", 'teacher' => "Break", 'start_time' => $break_start_time, 'end_time' => $break_end_time,);
                                $kindergarten_break = true;
                            }
                            $is_rest_class_found = in_array($grade, $rest_section);
                            // break to rest school
                            if ($is_rest_class_found == false && $grade != 'Kindergarten' && date('H:i', strtotime($d_start_time)) >= date('H:i', DateTime::createFromFormat('H:i', $break_start_time)))
                            {
                                array_push($rest_section, $grade);
                                $schedule[] = array('grade' => $grade, 'section' => $section[0]->section_name, 'subject' => "Break", 'teacher' => "Break", 'start_time' => $break_start_time, 'end_time' => $break_end_time,);
                            }
                            //$schedule[] = array('grade' => $grade, 'section_name' => $section[0]->section_name, 'subject_name' => $subject[0]->subject_name, 'screenname' => $teacher[0]->screenname, 'start_time' => date('H:i', $value->start_time), 'end_time' => date('H:i', $value->end_time),);
                            $schedule[] = array('grade' => $grade, 'section' => $section[0]->section_name, 'subject' => $subject[0]->subject_name, 'teacher' => $teacher[0]->screenname, 'start_time' => date('H:i', strtotime($d_start_time)), 'end_time' => date('H:i', strtotime($d_end_time)),);
                        }
                    }
                }
            }
            else if ($role_id == 4 && count($active_session) && count($active_semester))
            {
                $query = $this->operation->GetByQuery("SELECT * FROM schedule  Where semester_id = " . $active_semester->semester_id . "  AND session_id =" . $active_session->id . " AND teacher_uid=" . $user_id);
                if (count($query))
                {
                    $is_yellow_section_found = false;
                    foreach ($query as $key => $value)
                    {
                        // add assembly to each class
                        $day_status =  $currentday.'_status';
                        if($value->$day_status=='Active')
                        {

                            $grade = parent::getClass($value->class_id);
                            //$section = parent::getSectionList($value->section_id,$school_id);
                            $section = parent::getSectionList($value->section_id,$school_id);
                            $subject = parent::GetSubject($value->subject_id);
                            $teacher = parent::GetUserById($value->teacher_uid);
                            $is_class_found = in_array($grade, $class_array);
                            // get day name
                            $s_time =  $currentday.'_start_time';
                            $e_time =  $currentday.'_end_time';
                            $d_start_time = $value->$s_time;
                            $d_end_time = $value->$e_time;
                            //echo $value->subject_id;
                            //exit;
                            if ($is_class_found == false && date('H:i', strtotime($d_start_time)) >= date('H:i', DateTime::createFromFormat('H:i', $ass_start_time)))
                            {
                                array_push($class_array, $grade);
                                $schedule[] = array('grade' => $grade, 'section' => $section[0]->section_name, 'subject' => "Assembly", 'teacher' => "Assembly", 'start_time' => $ass_start_time, 'end_time' => $ass_end_time,);
                            }
                            $is_kin_class_found = in_array($section[0]->id, $kindergarten_section);
                            // break to kindergarten
                            if ($is_kin_class_found == false && $grade == 'Kindergarten' && date('H:i', strtotime($d_start_time)) >= date('H:i', DateTime::createFromFormat('H:i', $break_start_time)))
                            {
                                array_push($kindergarten_section, $section[0]->id);
                                $schedule[] = array('grade' => $grade, 'section' => $section[0]->section_name, 'subject' => "Break", 'teacher' => "Break", 'start_time' => $break_start_time, 'end_time' => $break_end_time,);
                                $kindergarten_break = true;
                            }
                            $is_rest_class_found = in_array($grade, $rest_section);
                            // break to rest school
                            if ($is_rest_class_found == false && $grade != 'Kindergarten' && date('H:i', strtotime($d_start_time)) >= date('H:i', DateTime::createFromFormat('H:i', $break_start_time)))
                            {
                                array_push($rest_section, $grade);
                                $schedule[] = array('grade' => $grade, 'section' => $section[0]->section_name, 'subject' => "Break", 'teacher' => "Break", 'start_time' => $break_start_time, 'end_time' => $break_end_time,);
                            }
                            //$schedule[] = array('grade' => $grade, 'section_name' => $section[0]->section_name, 'subject_name' => $subject[0]->subject_name, 'screenname' => $teacher[0]->screenname, 'start_time' => date('H:i', $value->start_time), 'end_time' => date('H:i', $value->end_time),);
                            $schedule[] = array('grade' => $grade, 'section' => $section[0]->section_name, 'subject' => $subject[0]->subject_name, 'teacher' => $teacher[0]->screenname, 'start_time' => date('H:i', strtotime($d_start_time)), 'end_time' => date('H:i', strtotime($d_end_time)),);
                        }
                    }
                }
            }
            $this->set_response($schedule,REST_Controller::HTTP_OK);
            //echo json_encode($schedule);
        } catch (Exception $e) {}
    }
}

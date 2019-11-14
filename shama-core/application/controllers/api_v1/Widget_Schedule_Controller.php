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

            $schedule = array();
            $class_array = array();
            $kindergarten_section = array();
            $rest_section = array();

            $user_id = $this->input->get('user_id');
            $school_id = $this->input->get('school_id');

            $result = array();
            if (! empty($user_id) && ! empty($school_id)) {

                $role_id = FALSE;
                if ($role = $this->get_user_role($user_id)) {
                    $role_id = $role->role_id;
                }

                $active_session = $this->get_active_session($school_id);
                $active_semester = $this->get_active_semester_dates_by_session($active_session->id);

                if ($role_id == 3 && count($active_session) && count($active_semester)) {

                    $result = $this->operation->GetByQuery("SELECT sc.id, cl.grade, sct.section_name as section, sub.subject_name as subject, screenname as teacher,start_time,end_time FROM schedule sc INNER JOIN classes cl ON  sc.class_id=cl.id INNER JOIN invantage_users inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections sct ON sc.section_id=sct.id WHERE cl.school_id =" . $school_id . " AND sc.session_id = " . $active_session->id . " AND sc.semester_id = " . $active_semester->semester_id . " ORDER by sc.id DESC");
                } else if ($role_id == 4 && count($active_session) && count($active_semester)) {

                    $result = $this->operation->GetByQuery("SELECT sc.id, cl.grade, sct.section_name as section, sub.subject_name as subject, screenname as teacher,start_time,end_time FROM schedule sc  INNER JOIN classes cl ON  sc.class_id=cl.id INNER JOIN invantage_users inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections  sct ON sc.section_id=sct.id WHERE sc.teacher_uid=" . $user_id . " AND cl.school_id =" . $school_id . " AND sc.session_id = " . $active_session->id . " AND sc.semester_id = " . $active_semester->semester_id);
                }
            }

            if (count($result)) {
                $assStart = date('H:i',DateTime::createFromFormat('H:i', "08:00")->getTimestamp());
                $assEnd = date('H:i',DateTime::createFromFormat('H:i', "08:20")->getTimestamp());
                $breakStart = date('H:i',DateTime::createFromFormat('H:i', "10:11")->getTimestamp());
                $breakEnd = date('H:i',DateTime::createFromFormat('H:i', "10:45")->getTimestamp());
                
                foreach ($result as $value) {                    
                    $start_time = date('H:i', $value->start_time);
                    $end_time = date('H:i', $value->end_time);
                    
                    // add assembly to each class
                    $is_class_found = in_array($value->grade, $class_array);

                    if ($is_class_found == false && $start_time >= $assStart) {
                        array_push($class_array, $value->grade);
                        $schedule[] = array(
                            'grade' => $value->grade,
                            'section' => $value->section,
                            'subject' => "Assembly",
                            'teacher' => "Assembly",
                            'start_time' => $assStart,
                            'end_time' => $assEnd,
                        );
                    }

                    $is_kin_class_found = in_array($value->section, $kindergarten_section);
                    // break to kindergarten
                    if ($is_kin_class_found == false && $value->grade == 'Kindergarten' && $start_time >= $breakStart) {
                        array_push($kindergarten_section, $value->section);
                        $schedule[] = array(
                            'grade' => $value->grade,
                            'section' => $value->section,
                            'subject' => "Break",
                            'teacher' => "Break",
                            'start_time' => $breakStart,
                            'end_time' => $breakEnd,
                        );
                    }

                    $is_rest_class_found = in_array($value->grade, $rest_section);

                    // break to rest school
                    if ($is_rest_class_found == false && $value->grade != 'Kindergarten' && $start_time >= $breakStart) {
                        array_push($rest_section, $value->grade);
                        $schedule[] = array(
                            'grade' => $value->grade,
                            'section' => $value->section,
                            'subject' => "Break",
                            'teacher' => "Break",
                            'start_time' => $breakStart,
                            'end_time' => $breakEnd,
                        );
                    }

                    $schedule[] = array(
                        'grade' => $value->grade,
                        'section' => $value->section,
                        'subject' => $value->subject,
                        'teacher' => $value->teacher,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                    );
                }
            }

            $this->set_response($schedule,REST_Controller::HTTP_OK);
        } catch (Exception $e) {}
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Rest_Controller.php';

/**
 * CORE REST API
 *
 * This class responsible for connecting,sending and receiving data to outside clients
 */
class LMSApi extends MY_Rest_Controller
{
    
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        date_default_timezone_set("Asia/Karachi");
    }
    
    function content_post()
    {
        $result = array();
        
        $result['message'] = false;
        $result['fileexist'] = false;
        
        $class_name = $this->input->post('class_name');
        $subject_name = $this->input->post('subject_name');
        
        $cid = $this->input->post('id');
        $ctype = $this->input->post('contenttype');
        
        if (isset($_FILES) == 1) {
            
            foreach ($_FILES as $value) {
                
                if ($ctype == 'thumb') {
                    $valid_formats = array(
                        "jpg",
                        "png",
                        "jpeg"
                    );
                } else {
                    $valid_formats = array(
                        "jpg",
                        "mp4",
                        "doc",
                        "xls",
                        "3gp",
                        "pdf",
                        "png",
                        "gif",
                        "bmp",
                        "jpeg",
                        "docx",
                        "xlsx"
                    );
                }
                
                if (strlen($value['name'])) {
                    
                    list ($txt, $ext) = explode(".", $value['name']);
                    
                    if (in_array(strtolower($ext), $valid_formats)) {
                        
                        // 500 MB
                        if ($value["size"] < 500000000) {
                            
                            $filename = trim(basename($value['name']));
                            $filename = str_replace(" ", "_", trim($filename));
                            $txt = str_replace(" ", "_", trim($txt));
                            
                            $base_url_path = UPLOAD_PATH . "content/" . $class_name . "/" . $subject_name . "/" . $filename;
                            
                            $result['fileexist'] = false;
                            
                            if ($ctype == 'thumb') {
                                $content = array(
                                    'thumb' => $filename
                                );
                            } else {
                                $content = array(
                                    'content' => $filename
                                );
                            }
                            
                            if (is_uploaded_file($value['tmp_name'])) {
                                
                                if (move_uploaded_file($value['tmp_name'], $base_url_path)) {
                                    
                                    $this->operation->table_name = 'default_lesson_plan';
                                    $res = $this->operation->Create($content, $cid);
                                    
                                    if($res){
                                        $result['message'] = true;
                                    }
                                }
                            } else {
                                $result['fileexist'] = true;
                            }
                        }
                    }
                }
            }
        } else {
            
            $result['message'] = false;
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function teachers_get()
    {
        $school_id = $this->input->get('school_id');
        
        $result = array();
        if (! empty($school_id)) {
            try {
                if ($school_id) {
                    $is_teacher_found = $this->operation->GetByQuery('
                        SELECT inv.*
                        FROM invantage_users inv
                        INNER JOIN user_locations ul ON ul.user_id = inv.id
                        WHERE inv.type = "t" AND ul.school_id = ' . $school_id);
                }
                
                if (count($is_teacher_found)) {
                    foreach ($is_teacher_found as $key => $value) {
                        
                        $result[] = array(
                            'id' => $value->id,
                            'user_name' => $value->username,
                            // 'password' => $value->password,
                            'screen_name' => $value->screenname,
                            
                            'first_name' => ($this->get_user_meta($value->id, 'teacher_firstname') != false ? $this->get_user_meta($value->id, 'teacher_firstname') : ''),
                            
                            'last_name' => ($this->get_user_meta($value->id, 'teacher_lastname') != false ? $this->get_user_meta($value->id, 'teacher_lastname') : ''),
                            'phone' => ($this->get_user_meta($value->id, 'teacher_phone') != false ? $this->get_user_meta($value->id, 'teacher_phone') : ''),
                            
                            'email' => $value->email,
                            'campus' => "",
                            'profile_image' => $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE),
                            'school_info' => $this->get_school($school_id)
                        );
                    }
                }
            } catch (Exception $e) {}
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function teacher_get()
    {
        $id = $this->input->get('id');
        
        $result = array();
        $result['message'] = FALSE;
        
        if (! empty($id)) {
            try {
                if ($id) {
                    $is_teacher_found = $this->operation->GetByQuery('
                        SELECT inv.*, ul.school_id as school_id
                        FROM invantage_users inv
                        INNER JOIN user_locations ul ON ul.user_id = inv.id
                        WHERE inv.type = "t" AND inv.id = ' . $id);
                    
                    if (count($is_teacher_found)) {
                        foreach ($is_teacher_found as $key => $value) {
                            
                            $result = array(
                                'id' => $value->id,
                                'user_name' => $value->username,
                                // 'password' => $value->password,
                                'screen_name' => $value->screenname,
                                'first_name' => ($this->get_user_meta($value->id, 'teacher_firstname') != false ? $this->get_user_meta($value->id, 'teacher_firstname') : ''),
                                'last_name' => ($this->get_user_meta($value->id, 'teacher_lastname') != false ? $this->get_user_meta($value->id, 'teacher_lastname') : ''),
                                'phone' => ($this->get_user_meta($value->id, 'teacher_phone') != false ? $this->get_user_meta($value->id, 'teacher_phone') : ''),
                                'email' => $value->email,
                                'campus' => "",
                                'profile_image' => $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE),
                                'master_teacher' => $value->is_master_teacher,
                                'school_info' => $this->get_school($value->school_id)
                            );
                            
                            $result['religion'] = ($this->get_user_meta($value->id, 'teacher_religion') != false ? $this->get_user_meta($value->id, 'teacher_religion') : '');
                            
                            $result['gender'] = ($this->get_user_meta($value->id, 'teacher_gender') != false ? $this->get_user_meta($value->id, 'teacher_gender') : 'Male');
                            
                            $result['nic'] = ($this->get_user_meta($value->id, 'teacher_nic') != false ? $this->get_user_meta($value->id, 'teacher_nic') : '');
                            
                            $result['primary_address'] = ($this->get_user_meta($value->id, 'teacher_primary_address') != false ? $this->get_user_meta($value->id, 'teacher_primary_address') : '');
                            
                            $result['secondary_address'] = ($this->get_user_meta($value->id, 'teacher_secondry_adress') != false ? $this->get_user_meta($value->id, 'teacher_secondry_adress') : '');
                            
                            $result['city'] = ($this->get_user_meta($value->id, 'teacher_city') != false ? $this->get_user_meta($value->id, 'teacher_city') : '');
                            
                            $result['province'] = ($this->get_user_meta($value->id, 'teacher_province') != false ? $this->get_user_meta($value->id, 'teacher_province') : '');
                            
                            $result['zip_code'] = ($this->get_user_meta($value->id, 'teacher_zipcode') != false ? $this->get_user_meta($value->id, 'teacher_zipcode') : '');
                            
                            $result['message'] = TRUE;
                        }
                    }
                }
            } catch (Exception $e) {}
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function teacher_delete()
    {
        $id = $this->input->get('id');
        
        $result = array();
        $result['message'] = FALSE;
        
        if (! empty($id)) {
            $removeStudent = $this->db->query("DELETE FROM invantage_users WHERE id = " . $id);
            $removeStudent = $this->db->query("DELETE FROM user_meta WHERE user_id = " . $id);
            
            if (count($removeStudent)) {
                $result['message'] = TRUE;
            }
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function teacher_post()
    {
        $request = $this->parse_params();
        
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $nic = trim($request->nic);
        $email = trim($request->email);
        $phone = trim($request->phone);
        $school_id = trim($request->school_id);

        $result = array();
        $result['message'] = false;
        
        if (! empty($first_name) && ! empty($last_name) && ! empty($nic) && ! empty($email) && ! empty($phone)) {
            
            $id = $request->id;
            $gender = $request->gender;
            
            $p_home = trim($request->p_home);
            $s_home = trim($request->s_home);
            $province = trim($request->province);
            $city = trim($request->city);
            $zip = trim($request->zip_code);
            $is_master = $request->is_master;
            
            $password = null;
            if (isset($request->password) && isset($request->repeat_password)) {
                $password = trim($request->password);
                $repeat_password = trim($request->repeat_password);
            }
            
            if (! empty($id)) {
                $this->operation->table_name = 'invantage_users';
                
                $teacher_id = $this->user->TeacherInfo($id, $school_id, ucwords($first_name), ucwords($last_name), $gender, $nic, $email, $phone, $password, $p_home, $s_home, $province, $city, $zip, $is_master);
                //} else if (! empty($password) && $password == $repeat_password) {
            }else{
                // insert
                // $password = "1234";

                $teacher_id = $this->user->TeacherInfo(NULL, $school_id, ucwords($first_name), ucwords($last_name), $gender, $nic, $email, $phone, $password, $p_home, $s_home, $province, $city, $zip, $is_master, $school_id);
            }
            
            if ($teacher_id) {
                $result['last_id'] = $teacher_id;
                $result['message'] = true;
            }
        } else {
            $result['message'] = "Missing arguments";
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function profile_get()
    {
        $params = $this->parse_params();
        
        $user_id = $params['id'];
        
        if (empty($user_id)) {
            $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            exit();
        }
        
        $result = $this->get_user_profile($user_id);
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function profile_image_post()
    {
        $id = $this->input->post('id');
        $base64_string = $this->input->post('image_64');
        
        $result['message'] = false;
        
        if (! empty($id) && count($_FILES) > 0) {
            // Save in database
            
            $valid_formats = array(
                "jpg",
                "png",
                "jpeg",
                "JPG",
                "JPEG",
                "PNG"
            );
            
            foreach ($_FILES as $key => $value) {
                
                if (strlen($value['name'])) {
                    
                    list ($txt, $ext) = explode(".", $value['name']);
                    
                    if (in_array(strtolower($ext), $valid_formats) && $value["size"] < 5000000) {
                        
                        if (is_uploaded_file($value['tmp_name'])) {
                            
                            $filename = time() . trim(basename($value['name']));
                            
                            $img_upload_path = UPLOAD_PATH . UPLOAD_CAT_PROFILE . '/' . $filename;
                            
                            
                            if (move_uploaded_file($value['tmp_name'], $img_upload_path)) {
                                
                                $teacher = array(
                                    'profile_image' => $filename
                                );
                                
                                $this->operation->table_name = 'invantage_users';
                                
                                $saved = $this->operation->Create($teacher, $id);
                                
                                if ($saved) {
                                    $result['message'] = true;
                                }
                            }
                        }
                    }
                }
            }
        } else if (! empty($id) && ! empty($base64_string) && strstr($base64_string, "data:image")) {
            
            $filename = time() . md5(time() . uniqid()) . ".jpg";
            
            $img_upload_path = UPLOAD_PATH . UPLOAD_CAT_PROFILE . '/' . $filename;
            
            $base64_string_img = explode(',', $base64_string)[1];
            
            if (! empty($base64_string)) {
                
                $decoded = base64_decode($base64_string_img);
                
                if(file_put_contents($img_upload_path, $decoded)){
                    
                    $teacher = array(
                        'profile_image' => $filename
                    );
                    
                    $this->operation->table_name = 'invantage_users';
                    
                    $saved = $this->operation->Create($teacher, $id);
                    
                    if($saved){
                        
                        $result['message'] = true;
                    }
                }
            } else {
                print_r("base64 image not found");
            }
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    /**
     * Save user profile.
     */
    function profile_post()
    {
        $params = $this->parse_params();
        
        $result = array();
        
        
        $user_id = $params->user_id;
        $id = $params->id;
        $fname = $params->first_name;
        $lname = $params->last_name;
        $email = $params->email;
        $phone = $params->phone;
        $gender = $params->gender;
        
        $city = $params->city;
        $zip_code = $params->zip_code;
        $p_address = $params->p_address;
        $s_address = $params->s_address;
        $province = $params->province;
        $religion = $params->religion;
        
        if (empty($user_id) || empty($id) || empty($fname) || empty($lname) || empty($email) || empty($phone) || empty($gender)) {
            
            $result['message'] = false;
        } else {
            
            $phone = preg_replace('/\D/', '', $phone);
            
            $account = array(
                'email' => htmlspecialchars($email, ENT_QUOTES)
            );
            $this->user->table_name = 'invantage_users';
            
            $this->user->Create($account, $id);
            
            $roles = $this->get_user_role($id);
            
            $this->user->table_name = 'user_meta';
            $this->user->primary_key = 'user_id';
            if ($roles->role_id == 3) {
                $this->user->update_meta($id, 'principal_firstname', ucwords(htmlspecialchars(trim($fname), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'principal_lastname', ucwords(htmlspecialchars(trim($lname), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'principal_gender', ucwords(htmlspecialchars(trim($gender), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'principal_phone', htmlspecialchars(trim($phone), ENT_QUOTES));
                
                $this->user->update_meta($id, 'principal_primary_address', ucwords(htmlspecialchars(trim($p_address), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'principal_secondry_adress', ucwords(htmlspecialchars(trim($s_address), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'principal_province', ucwords(htmlspecialchars(trim($province), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'principal_city', ucwords(htmlspecialchars(trim($city), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'principal_zipcode', ucwords(htmlspecialchars(trim($zip_code), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'principal_religion', ucwords(htmlspecialchars(trim($religion), ENT_QUOTES)));
                
                $result['message'] = TRUE;
            } else if ($roles->role_id == 4) {
                $this->user->update_meta($id, 'teacher_firstname', ucwords(htmlspecialchars(trim($fname), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'teacher_lastname', ucwords(htmlspecialchars(trim($lname), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'teacher_gender', ucwords(htmlspecialchars(trim($gender), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'teacher_phone', htmlspecialchars(trim($phone), ENT_QUOTES));
                
                $this->user->update_meta($id, 'teacher_primary_address', ucwords(htmlspecialchars(trim($p_address), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'teacher_secondry_adress', ucwords(htmlspecialchars(trim($s_address), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'teacher_province', ucwords(htmlspecialchars(trim($province), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'teacher_city', ucwords(htmlspecialchars(trim($city), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'teacher_zipcode', ucwords(htmlspecialchars(trim($zip_code), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'teacher_religion', ucwords(htmlspecialchars(trim($religion), ENT_QUOTES)));
                
                $result['message'] = TRUE;
            } else if ($roles->role_id == 1) {
                
                $this->user->update_meta($id, 'admin_firstname', ucwords(htmlspecialchars(trim($fname), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'admin_lastname', ucwords(htmlspecialchars(trim($lname), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'admin_gender', ucwords(htmlspecialchars(trim($gender), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'admin_phone', htmlspecialchars(trim($phone), ENT_QUOTES));
                
                $this->user->update_meta($id, 'admin_primary_address', ucwords(htmlspecialchars(trim($p_address), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'admin_secondry_adress', ucwords(htmlspecialchars(trim($s_address), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'admin_province', ucwords(htmlspecialchars(trim($province), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'admin_city', ucwords(htmlspecialchars(trim($city), ENT_QUOTES)));
                
                $this->user->update_meta($id, 'admin_zipcode', htmlspecialchars(trim($zip_code), ENT_QUOTES));
                
                $this->user->update_meta($id, 'admin_religion', ucwords(htmlspecialchars(trim($religion), ENT_QUOTES)));
                
                $result['message'] = TRUE;
            }
        }
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    // endregion
    public function schedules_get()
    {

        $user_id = $this->input->get('user_id');
        $school_id = $this->input->get('school_id');
        $currentday = $this->input->get('select_day');
        if($currentday=='')
        {
            $date = date('Y-m-d');
            $currentday = strtolower(date('D', strtotime($date)));
        }
        

        $request = json_decode(file_get_contents('php://input'));
        $inputday = $this->security->xss_clean(trim($request->inputday));
        if($inputday)
        {
            $currentday = $inputday;
        }
        $listarray =array();
        $data_array =array();
        $d_start_time = array();
        $d_end_time = array();
        
        //$active_session = parent::GetUserActiveSession();
        //$active_semester = parent::GetCurrentSemesterData($active_session[0]->id);
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
        $role_id = FALSE;
            if ($role = $this->get_user_role($user_id)) {
                $role_id = $role->role_id;
            }  
        if($role_id == 3 && count($active_session) && count($active_semester))
        {

            $datameta=$this->data['timetable_list'] = $this->operation->GetByQuery("SELECT sc.*,sc.id,sub.id as subid,subject_name,grade,section_name,screenname,start_time,end_time FROM schedule sc INNER JOIN classes cl ON  sc.class_id=cl.id INNER JOIN invantage_users inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections  sct ON sc.section_id=sct.id WHERE cl.school_id =".$school_id." AND sub.session_id = ".$active_session->id." AND sub.semester_id = ".$active_semester->semester_id." ORDER by sc.id desc");
            if(count($datameta))
            {
                foreach ($datameta as $key => $value) 
                {

                    $subcod=$this->operation->GetByQuery("select subject_code from subjects where id= ".$value->subid);
                    $value->subject_name=$value->subject_name." (".$subcod[0]->subject_code.")";
                    $value->subject_name;
                    // Create Day wise start and end time
                    $s_time =  $currentday.'_start_time';
                    $e_time =  $currentday.'_end_time';
                    if($value->$s_time=="00:00:00")
                    {
                        $value->start_time = "";
                    }
                    else
                    {
                        $value->start_time = date('H:i',strtotime($value->$s_time));
                    }
                    if($value->$e_time=="00:00:00")
                    {
                        $value->end_time = "";
                    }
                    else
                    {
                        $value->end_time = date('H:i',strtotime($value->$e_time));
                    }
                    
                }
            }
            
       }
       else if( $roles[0]['role_id'] == 4 && count($active_session) && count($active_semester))
       {
            $this->data['timetable_list'] = $this->operation->GetByQuery("SELECT sc.id, subject_name,grade,section_name,username,start_time,end_time FROM schedule sc  INNER JOIN classes cl ON  sc.class_id=cl.id INNER JOIN invantage_user inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections  sct ON sc.section_id=sct.id where sc.teacher_uid=".$this->session->userdata('id')." AND cl.school_id =".$locations[0]['school_id']." AND sub.session_id = ".$active_session[0]->id." AND sub.semsterid = ".$active_semester[0]->semester_id);
            
                
       }
       $data_array = array('select_day'=>$currentday);
       
        foreach ($this->data['timetable_list'] as $key => $element) {
            
            if ($element->start_time=="") {
                
                unset($this->data['timetable_list'][$key]);
            }
        }
        $this->data['timetable_list']= array_values($this->data['timetable_list']); 
        $result[] = array(
                        'listarray'=>$this->data['timetable_list'],
                        
                        'data_array'=>$data_array
                    );

        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function schedule_get()
    {
        $id = $this->input->get('id');
        
        $schedulararray = array();
        
        if (! empty($id)) {
            $this->operation->table_name = 'schedule';
            $schedulalist = $this->operation->GetByWhere(array(
                'id' => $id
            ));
            
            if (count($schedulalist)) {
                
                foreach ($schedulalist as $key => $value) {
                    
                    $schedulararray = array(
                        'class_id' => $value->class_id,
                        'section_id' => $value->section_id,
                        'subject_id' => $value->subject_id,
                        'teacher_id' => $value->teacher_uid,
                        'mon_status' => $value->mon_status,
                        'mon_start_time' => date('H:i',strtotime($value->mon_start_time)),
                        'mon_end_time' => date('H:i',strtotime($value->mon_end_time)),
                        'tue_status' => $value->tue_status,
                        'tue_start_time' => date('H:i',strtotime($value->tue_start_time)),
                        'tue_end_time' => date('H:i',strtotime($value->tue_end_time)),
                        'wed_status' => $value->wed_status,
                        'wed_start_time' => date('H:i',strtotime($value->wed_start_time)),
                        'wed_end_time' => date('H:i',strtotime($value->wed_end_time)),
                        'thu_status' => $value->thu_status,
                        'thu_start_time' => date('H:i',strtotime($value->thu_start_time)),
                        'thu_end_time' => date('H:i',strtotime($value->thu_end_time)),
                        'fri_status' => $value->fri_status,
                        'fri_start_time' => date('H:i',strtotime($value->fri_start_time)),
                        'fri_end_time' => date('H:i',strtotime($value->fri_end_time)),
                        'sat_status' => $value->sat_status,
                        'sat_start_time' => date('H:i',strtotime($value->sat_start_time)),
                        'sat_end_time' => date('H:i',strtotime($value->sat_end_time)),
                        'sun_status' => $value->sun_status,
                        'sun_start_time' => date('H:i',strtotime($value->sun_start_time)),
                        'sun_end_time' => date('H:i',strtotime($value->sun_end_time))

                        
                    );
                }
            }
        }
        
        $this->set_response($schedulararray, REST_Controller::HTTP_OK);
    }
    
    public function schedule_post()
    {
        $request = $this->parse_params();
        
        $id = $request->id;
        $subject_id = $request->subject_id;
        $class_id = $request->class_id;
        $school_id = $request->school_id;
        $section_id = $request->section_id;
        $teacher_id = $request->teacher_id;
        // $start_time = $request->start_time;
        // $end_time = $request->end_time;

        $result = array();
        $result['message'] = false;

        if (! empty($class_id) && ! empty($section_id) && ! empty($subject_id) && ! empty($teacher_id)  && ! empty($school_id)) {
            
            $active_session = $this->get_active_session($school_id);

            $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
            
            // Day wise timing
            if($request->mon_status=='Active')
                {
                    $mon_status = "Active";
                    $mon_start_time = $request->mon_start_time!='' ? $request->mon_start_time :"00:00:00";
                    $mon_end_time = $request->mon_end_time!='' ? $request->mon_end_time :"00:00:00";
                }
                else
                {
                    $mon_status = "Inactive";
                    $mon_start_time = "00:00:00";
                    $mon_end_time ="00:00:00";
                }
                if($request->tue_status=='Active')
                {
                    $tue_status = "Active";
                    $tue_start_time = $request->tue_start_time!='' ? $request->tue_start_time :"00:00:00";
                    $tue_end_time = $request->tue_end_time!='' ? $request->tue_end_time :"00:00:00";
                }
                else
                {
                    $tue_status = "Inactive";
                    $tue_start_time = "00:00:00";
                    $tue_end_time ="00:00:00";
                }
                if($request->wed_status=='Active')
                {
                    $wed_status = "Active";
                    $wed_start_time = $request->wed_start_time!='' ? $request->wed_start_time :"00:00:00";
                    $wed_end_time = $request->wed_end_time!='' ? $request->wed_end_time :"00:00:00";
                }
                else
                {
                    $wed_status = "Inactive";
                    $wed_start_time = "00:00:00";
                    $wed_end_time ="00:00:00";
                }
                if($request->thu_status=='Active')
                {
                    $thu_status = "Active";
                    $thu_start_time = $request->thu_start_time!='' ? $request->thu_start_time :"00:00:00";
                    $thu_end_time = $request->thu_end_time!='' ? $request->thu_end_time :"00:00:00";
                }
                else
                {
                    $thu_status = "Inactive";
                    $thu_start_time = "00:00:00";
                    $thu_end_time ="00:00:00";
                }
                if($request->fri_status=='Active')
                {
                    $fri_status = "Active";
                    $fri_start_time = $request->fri_start_time!='' ? $request->fri_start_time :"00:00:00";
                    $fri_end_time = $request->fri_end_time!='' ? $request->fri_end_time :"00:00:00";
                }
                else
                {
                    $fri_status = "Inactive";
                    $fri_start_time = "00:00:00";
                    $fri_end_time ="00:00:00";
                }
                if($request->sat_status=='Active')
                {
                    $sat_status = "Active";
                    $sat_start_time = $request->sat_start_time!='' ? $request->sat_start_time :"00:00:00";
                    $sat_end_time = $request->sat_end_time!='' ? $request->sat_end_time :"00:00:00";
                }
                else
                {
                    $sat_status = "Inactive";
                    $sat_start_time = "00:00:00";
                    $sat_end_time ="00:00:00";
                }
                if($request->sun_status=='Active')
                {
                    $sun_status = "Active";
                    $sun_start_time = $request->sun_start_time!='' ? $request->sun_start_time :"00:00:00";
                    $sun_end_time = $request->sun_end_time!='' ? $request->sun_end_time :"00:00:00";
                }
                else
                {
                    $sun_status = "Inactive";
                    $sun_start_time = "00:00:00";
                    $sun_end_time ="00:00:00";
                }
            // End here
            if ($id) {
                $subject_schedual_check = true;
                
                // $schedule = array(
                //     'last_update' => date('Y-m-d'),
                //     'subject_id' => $subject_id,
                //     'class_id' => $class_id,
                //     'section_id' => $section_id,
                //     'teacher_uid' => $teacher_id,
                //     'start_time' => strtotime($start_time),
                //     'end_time' => strtotime($end_time),
                //     'semester_id' => $active_semester->semester_id,
                //     'session_id' => $active_session->id
                // );
                $schedule =  array(
                            'last_update'=> date('Y-m-d'),
                            'subject_id'=>$subject_id,
                            'class_id'=>$class_id,
                            'section_id'=>$section_id,
                            'teacher_uid'=>$teacher_id,
                            //'start_time'=>strtotime($this->input->post('inputFrom')),
                            //'end_time'=>strtotime($this->input->post('inputTo')),
                            'mon_status'=>$mon_status,
                            'mon_start_time'=>date('H:i',strtotime($mon_start_time)),
                            'mon_end_time'=>date('H:i',strtotime($mon_end_time)),
                            'tue_status'=>$tue_status,
                            'tue_start_time'=>date('H:i',strtotime($tue_start_time)),
                            'tue_end_time'=>date('H:i',strtotime($tue_end_time)),
                            'wed_status'=>$wed_status,
                            'wed_start_time'=>date('H:i',strtotime($wed_start_time)),
                            'wed_end_time'=>date('H:i',strtotime($wed_end_time)),
                            'thu_status'=>$thu_status,
                            'thu_start_time'=>date('H:i',strtotime($thu_start_time)),
                            'thu_end_time'=>date('H:i',strtotime($thu_end_time)),
                            'fri_status'=>$fri_status,
                            'fri_start_time'=>date('H:i',strtotime($fri_start_time)),
                            'fri_end_time'=>date('H:i',strtotime($fri_end_time)),
                            'sat_status'=>$sat_status,
                            'sat_start_time'=>date('H:i',strtotime($sat_start_time)),
                            'sat_end_time'=>date('H:i',strtotime($sat_end_time)),
                            'sun_status'=>$sun_status,
                            'sun_start_time'=>date('H:i',strtotime($sun_start_time)),
                            'sun_end_time'=>date('H:i',strtotime($sun_end_time)),
                            
                            'semester_id'=>$active_semester->semester_id,
                            'session_id'=>$active_session->id,
                        );
                $this->operation->table_name = 'schedule';
                $this->operation->primary_key = 'id';
                if ($subject_schedual_check == true) {
                    $id = $this->operation->Create($schedule, $id);
                    if (count($id)) {
                        $result['message'] = true;
                    }
                }
            } else {
                $subject_schedual_check = true;
                
                $schedule =  array(
                            'last_update'=> date('Y-m-d'),
                            'subject_id'=>$subject_id,
                            'class_id'=>$class_id,
                            'section_id'=>$section_id,
                            'teacher_uid'=>$teacher_id,
                            //'start_time'=>strtotime($this->input->post('inputFrom')),
                            //'end_time'=>strtotime($this->input->post('inputTo')),
                            'mon_status'=>$mon_status,
                            'mon_start_time'=>date('H:i',strtotime($mon_start_time)),
                            'mon_end_time'=>date('H:i',strtotime($mon_end_time)),
                            'tue_status'=>$tue_status,
                            'tue_start_time'=>date('H:i',strtotime($tue_start_time)),
                            'tue_end_time'=>date('H:i',strtotime($tue_end_time)),
                            'wed_status'=>$wed_status,
                            'wed_start_time'=>date('H:i',strtotime($wed_start_time)),
                            'wed_end_time'=>date('H:i',strtotime($wed_end_time)),
                            'thu_status'=>$thu_status,
                            'thu_start_time'=>date('H:i',strtotime($thu_start_time)),
                            'thu_end_time'=>date('H:i',strtotime($thu_end_time)),
                            'fri_status'=>$fri_status,
                            'fri_start_time'=>date('H:i',strtotime($fri_start_time)),
                            'fri_end_time'=>date('H:i',strtotime($fri_end_time)),
                            'sat_status'=>$sat_status,
                            'sat_start_time'=>date('H:i',strtotime($sat_start_time)),
                            'sat_end_time'=>date('H:i',strtotime($sat_end_time)),
                            'sun_status'=>$sun_status,
                            'sun_start_time'=>date('H:i',strtotime($sun_start_time)),
                            'sun_end_time'=>date('H:i',strtotime($sun_end_time)),
                            
                            'semester_id'=>$active_semester->semester_id,
                            'session_id'=>$active_session->id,
                        );
                
                $this->operation->table_name = 'schedule';
                $this->operation->primary_key = 'id';
                $id = $this->operation->Create($schedule);
                
                if (count($id)) {
                    
                    $result['message'] = true;
                }
            }
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function schedule_delete()
    {
        $id = $this->input->get('id');
        
        $result['message'] = false;
        if (! empty($id)) {
            $removeSubject = $this->db->query("DELETE FROM schedule WHERE id =" . $id);
            if (count($removeSubject)) {
                $result['message'] = true;
            }
        }
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    function getTimetablepdf_get()
    {
        try
        {

            $roles = $this->input->get('role_id');
            $school_id = $this->input->get('school_id');
            
            $this->operation->table_name = 'sessions';
            $active_session = $this->operation->GetByWhere(array('status' => "a", 'school_id' =>  $school_id));
            
            $active_semester = parent::GetCurrentSemesterData($active_session[0]->id);
            $request = json_decode(file_get_contents('php://input'));
            $grade_id = $this->input->get('grade_id');
            $this->operation->table_name = 'classes';
            $is_class = $this->operation->GetByWhere(array('grade' => $grade_id,'school_id' => $school_id));
            //print($is_class[0]->id);
            //exit;
            $schedule = array();
            $class_array = array();
            $kindergarten_section = array();
            $rest_section = array();
            $result = array();
            $data_array = array();
            $day_array = array();
            $subject_array = array('day');
            $mon_array = array('day' => "Monday|" );
            $tue_array = array('day' => "Tuesday|" );
            $wed_array = array('day' => "Wednesday|" );
            $thu_array = array('day' => "Thursday|" );
            $fri_array = array('day' => "Friday|" );
            $sat_array = array('day' => "Saturday|" );
            $sun_array = array('day' => "Sunday|" );
            // Assembly time fetch from database
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
        
            //$currentday = strtolower(date('D', strtotime($date)));
            
            $is_break_found = $this->operation->GetByWhere(array('school_id' => $school_id));
            if(count($is_break_found))
            {
                    $mon_break = date('H:i', strtotime($is_break_found[0]->monday_start_time)).' - '.date('H:i', strtotime($is_break_found[0]->monday_end_time));
                    $tue_break = date('H:i', strtotime($is_break_found[0]->tuesday_start_time)).' - '.date('H:i', strtotime($is_break_found[0]->tuesday_end_time));
                    $wed_break = date('H:i', strtotime($is_break_found[0]->wednesday_start_time)).' - '.date('H:i', strtotime($is_break_found[0]->wednesday_end_time));
                    $thu_break = date('H:i', strtotime($is_break_found[0]->thursday_start_time)).' - '.date('H:i', strtotime($is_break_found[0]->thursday_end_time));
                    $fri_break = date('H:i', strtotime($is_break_found[0]->friday_start_time)).' - '.date('H:i', strtotime($is_break_found[0]->friday_end_time));
            }
            else
                {
                    $break_start_time = BREAK_START;
                    $break_end_time  = BREAK_END;
                }
               
                
                $query = $this->operation->GetByQuery("SELECT sch.* FROM schedule sch  Where class_id =".$is_class[0]->id." AND sch.semester_id = " . $active_semester[0]->semester_id . " AND sch.session_id =" . $active_session[0]->id . " Order by sch.id,sch.start_time");
                
                if (count($query))
                {
                    $is_yellow_section_found = false;
                    foreach ($query as $key => $value)
                    {
                        
                        $grade = parent::getClass($value->class_id);
                        $section = parent::getSectionList($value->section_id,$school_id);
                        $subject = parent::GetSubject($value->subject_id);
                        $teacher = parent::GetUserById($value->teacher_uid);
                        $is_class_found = in_array($grade, $class_array);
                        
                            $mon_status = "Active";
                            $subject_array[] = $value->subject_id;

                            $mon_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->mon_start_time)).' - '.date('H:i', strtotime($value->mon_end_time)).')';
                            $tue_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->tue_start_time)).' - '.date('H:i', strtotime($value->tue_end_time)).')';
                            $wed_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->wed_start_time)).' - '.date('H:i', strtotime($value->wed_end_time)).')';
                            $thu_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->thu_start_time)).' - '.date('H:i', strtotime($value->thu_end_time)).')';
                            $fri_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->fri_start_time)).' - '.date('H:i', strtotime($value->fri_end_time)).')';
                            $sat_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->sat_start_time)).' - '.date('H:i', strtotime($value->sat_end_time)).')';
                            $sun_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->sun_start_time)).' - '.date('H:i', strtotime($value->sun_end_time)).')';
                            
                    }
                    $schedule = array($mon_array,$tue_array,$wed_array,$thu_array,$fri_array,$sat_array,$sun_array);
                    //$schedule['day_array'] = array('mon'=>'Monday','tue'=>'Tuesday','wed'=>'Wednesday','thu'=>'Thursday','fri'=>'Friday','sat'=>'Saturday','sun'=>'Sunday');

                }
            $data_array = array('grade_name'=>$is_class[0]->grade);
            $result[] = array(
                        'details'=>$schedule,
                        'colums'=>$subject_array,
                        
                        'data_array'=>$data_array
                    );
            $this->set_response($result, REST_Controller::HTTP_OK);
            //echo json_encode($result);
            //echo json_encode($schedule);
        }
        catch(Exception $e)
        {
        }
    }
    
    // region Principal
    function school_wizard_status_get()
    {
        $this->operation->table_name = 'wizard';
        
        $this->set_response($this->operation->GetByWhere(array(
            'school_id' => $this->input->get('school_id'),
            'status' => 'y'
        )), REST_Controller::HTTP_OK);
    }
    
    // endregion
    
    // ----------------------------------------------------------------------
    function class_time_table_get()
    {
        $class_id = $this->input->get('class_id', true);
        $section_id = $this->input->get('section_id', true);
        
        $result = array();
        if (! empty($class_id) && ! empty($section_id)) {
            $is_result_found = $this->operation->GetByQuery('SELECT sb.subject_name,inv.screenname,s.start_time,s.end_time FROM schedule s INNER JOIN subjects sb ON sb.id = s.subject_id INNER JOIN invantage_users inv ON inv.id = s.teacher_uid  WHERE s.class_id =' . $class_id . ' AND s.section_id = ' . $section_id);
            
            if (count($is_result_found)) {
                foreach ($is_result_found as $key => $value) {
                    $result[] = array(
                        'subject' => $value->subject_name,
                        'teacher' => $value->screenname,
                        'starttime' => date('H:i', $value->start_time),
                        'endtime' => date('H:i', $value->end_time)
                    );
                }
            }
        }
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    /**
     * Class report table
     */
    function class_report_get()
    {
        $class_id = $this->input->get('class_id', true);
        $section_id = $this->input->get('section_id', true);
        $semester_id = $this->input->get('semester_id', true);
        $session_id = $this->input->get('session_id', true);
        $school_id = $this->input->get('school_id', true);
        
        $error_array = array();
        if (! is_int($class_id) || ! is_int($section_id) || ! is_int($semester_id) || ! is_int($session_id)) {
            array_push($error_array, "Date is empty");
        }
        
        if (count($error_array)) {
            $this->set_response([], REST_Controller::HTTP_OK);
            exit();
        }
        
        $result = array();
        
        $progress = $this->operation->GetByQuery('SELECT * FROM `student_semesters` WHERE class_id = ' . $class_id . " AND section_id = " . $section_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . "  AND status = 'r'");
        
        if (count($progress)) {
            $subjectlist = $this->get_subjects($class_id);
            foreach ($progress as $key => $value) {
                
                $evalution_array = array();
                
                $quiz_array = $this->calculate_student_quiz_marks($value->student_id, $class_id, $section_id, $semester_id, $session_id, $school_id);
                
                $mid_array = $this->calculate_student_term_marks($value->student_id, $class_id, $section_id, $semester_id, $session_id, 1, $school_id);
                
                $final_array = $this->calculate_student_term_marks($value->student_id, $class_id, $section_id, $semester_id, $session_id, 2, $school_id);
                
                $total_marks = $quiz_array[0] + $mid_array[0] + $final_array[0];
                $obtain_marks = $quiz_array[1] + $mid_array[1] + $final_array[1];
                
                $evalution_array[] = array(
                    'quiz' => $quiz_array[0],
                    'mid' => $mid_array[0],
                    'final' => $final_array[0],
                    'assignment' => 0,
                    'practical' => 0,
                    'attendance' => 0,
                    'oral' => 0,
                    'behavior' => 0,
                    'total_percent' => (float) (($total_marks / 100) * 100),
                    'grade' => $this->get_grade((float) (($total_marks / 100) * 100), $session_id),
                    'obtain_marks' => $obtain_marks,
                    'total_marks' => count($subjectlist) * 100
                );
                $result[] = array(
                    'student_id' => $value->student_id,
                    'screenname' => $this->get_user_meta($value->student_id, 'sfullname'),
                    'evalution' => $evalution_array
                );
            }
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    /**
     * Calculate student wise report by subject
     *
     * @param
     *            class_id int
     * @param
     *            section_id int
     * @param
     *            semester_id int
     * @param
     *            session_id int
     * @param
     *            student_id int
     *
     */
    function student_report_get()
    {
        $class_id = $this->input->get('class_id', true);
        $section_id = $this->input->get('section_id', true);
        $semester_id = $this->input->get('semester_id', true);
        $session_id = $this->input->get('session_id', true);
        $school_id = $this->input->get('school_id', true);
        $student_id = $this->input->get('student_id', true);
        
        $error_array = array();
        if (! is_int((int) $class_id) || ! is_int((int) $section_id) || ! is_int((int) $session_id) || ! is_int((int) $student_id)) {
            array_push($error_array, "Invalid data");
        }
        
        if (count($error_array)) {
            $this->set_response([], REST_Controller::HTTP_OK);
            exit();
        }
        
        $studentresult = array();
        if (count($error_array) == false) {
            $iteration = 0;
            if ($semester_id == 'b') {
                $iteration = 1;
            } else {
                
                $this->operation->table_name = 'semester';
                $is_semester_dates_found = $this->operation->GetByWhere(array(
                    'id' => $semester_id
                ));
            }
            
            $subjectlist = $this->get_subjects($class_id);
            
            if (count($subjectlist)) {
                $semesterlist = $this->get_default_semesters();
                $student_obtain_marks = 0;
                $semester_name = "";
                for ($i = 0; $i <= $iteration; $i ++) {
                    
                    $result = array();
                    if ($semester_id == 'b') {
                        $semester_id = $this->get_semester_by_name($semesterlist[$i]);
                        $semester_id = $semester_id[0]->id;
                        $semester_name = $semester_id[0]->semester_name;
                    } else {
                        $semester_name = $is_semester_dates_found[0]->semester_name;
                    }
                    
                    foreach ($subjectlist as $key => $value) {
                        $sum_subject = array();
                        $student_quiz = array();
                        
                        $quizlist = $this->operation->GetByQuery('SELECT q.id,q.quiz_term FROM `quiz` q where subject_id =' . $value->id . ' AND class_id = ' . $class_id . ' and section_id = ' . $section_id . ' AND semester_id = ' . $semester_id . ' AND session_id = ' . $session_id . '  order by quiz_term');
                        
                        if (count($quizlist)) :
                        $find_quiz_marks = array();
                        foreach ($quizlist as $key => $qvalue) {
                            array_push($find_quiz_marks, (int) $this->calculate_subject_wise_student_quiz((int) $student_id, (int) $qvalue->id));
                        }
                        $quiz_evaluation_points = $this->get_evaluation_by_type('qui', $session_id);
                        
                        array_push($sum_subject, (((array_sum($find_quiz_marks) / 100) * $quiz_evaluation_points)));
                        endif;
                        
                        $student_quiz[0] = (array_sum($sum_subject) / count($subjectlist));
                        $student_quiz[1] = (array_sum($sum_subject));
                        
                        $evalution_array = array();
                        
                        $mid = $this->operation->GetByQuery('SELECT * FROM term_exam_result  WHERE subject_id = ' . $value->id . ' AND student_id= ' . $student_id . " AND termid = 1");
                        $final = $this->operation->GetByQuery('SELECT * FROM term_exam_result  WHERE subject_id = ' . $value->id . ' AND student_id= ' . $student_id . " AND termid = 2");
                        
                        if (count($final)) {
                            $total_marks = $student_quiz[0] + $mid[0]->marks + $final[0]->marks;
                            $obtain_marks = $student_quiz[1] + $mid[0]->marks + $final[0]->marks;
                            $student_obtain_marks += $total_marks;
                            
                            $evalution_array[] = array(
                                'quiz' => $student_quiz[0],
                                'mid' => (count($mid) ? $mid[0]->marks : 0),
                                'final' => (count($final) ? $final[0]->marks : 0),
                                'assignment' => 0,
                                'practical' => 0,
                                'attendance' => 0,
                                'oral' => 0,
                                'behavior' => 0,
                                'total_percent' => (double) (($total_marks / 100) * 100),
                                'grade' => $this->get_grade((double) (($total_marks / 100) * 100), $session_id),
                                'obtain_marks' => $obtain_marks,
                                'total_marks' => count($subjectlist) * 100
                            );
                        }
                        
                        $result[] = array(
                            'serail' => $value->id,
                            'subject' => $value->subject_name,
                            'evalution' => $evalution_array
                        );
                    }
                    $studentresult[] = array(
                        'result' => $result,
                        'semester' => $semester_name,
                        'obtain_marks' => round($student_obtain_marks, 2),
                        'total_marks' => round(((count($subjectlist) * 100) * ($i + 1)), 2),
                        'percent' => round((float) (($student_obtain_marks / ((count($subjectlist) * 100))) * 100), 2),
                        'grade' => $this->get_grade((float) (($student_obtain_marks / ((count($subjectlist) * 100))) * 100), $session_id)
                    );
                }
            }
        }
        $this->set_response($studentresult, REST_Controller::HTTP_OK);
    }
    
    // region Holidays
    
    /**
     * Get holiday types
     *
     * @access private
     */
    function holiday_types_get()
    {
        $school_id = $this->input->get('school_id');
        
        $result = array();
        
        if (empty($school_id)) {
            $this->set_response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            return;
        }
        
        $this->operation->table_name = 'holiday_type';
        
        $holidaytypelist = $this->operation->GetByWhere(array(
            'school_id' => $school_id
        ));
        
        if (count($holidaytypelist)) {
            foreach ($holidaytypelist as $value) {
                $result[] = array(
                    'id' => $value->id,
                    'title' => $value->title
                );
            }
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    /**
     * Save holiday type module
     *
     * @access private
     */
    function holiday_type_post()
    {
        $request = $this->parse_params();
        $serial = $this->security->xss_clean(trim($request->id));
        $title = $this->security->xss_clean(trim($request->title));
        $user_id = $this->security->xss_clean(trim($request->user_id));
        $school_id = $this->security->xss_clean(trim($request->school_id));
        
        $error_array = array();
        if (strlen($title) < 3) {
            array_push($error_array, "Type must be 3 character");
        }
        
        if (count($error_array)) {
            $this->set_response([], REST_Controller::HTTP_OK);
            exit();
        }
        
        $result = array();
        $result['message'] = false;
        
        if (count($error_array) == false) {
            $this->operation->table_name = 'holiday_type';
            if ($serial) {
                $holidaytype = array(
                    'title' => ucfirst($title),
                    'slug' => $this->slug_generator($title),
                    'user_id' => $user_id,
                    'last_edited' => date('Y-m-d')
                );
                $id = $this->operation->Create($holidaytype, $serial);
                if (count($id)) {
                    $result['message'] = true;
                }
            } else {
                $holidaytype = array(
                    'title' => ucfirst($title),
                    'slug' => $this->slug_generator($title),
                    'user_id' => $user_id,
                    'school_id' => $school_id,
                    'date' => date('Y-m-d'),
                    'last_edited' => date('Y-m-d')
                );
                $id = $this->operation->Create($holidaytype);
                if (count($id)) {
                    $result['message'] = true;
                }
            }
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    /**
     * Remove holiday type
     *
     * @access private
     */
    function holiday_type_delete()
    {
        $id = $this->input->get('id');
        
        $sresult = array();
        $sresult['message'] = false;
        if (! empty($id)) {
            $this->operation->table_name = 'holiday_type';
            $this->operation->Remove($id);
            $sresult['message'] = true;
        }
        $this->set_response($sresult, REST_Controller::HTTP_OK);
    }
    
    /**
     * Remove holiday
     *
     * @access private
     */
    function holiday_delete()
    {
        $request = $this->parse_params();
        
        $slug = $this->security->xss_clean(trim($request['slug']));
        
        $result = array();
        $result['message'] = false;
        
        if (! empty($slug)) {
            $this->operation->table_name = 'holiday';
            $is_holiday_found = $this->operation->GetByWhere(array(
                'slug' => $slug
            ));
            if (count($is_holiday_found)) {
                $this->operation->Remove($is_holiday_found[0]->id);
                
                // Update Semester Lesson Dates
                $this->update_lesson_set_dates($is_holiday_found[0]->school_id);
                
                $result['message'] = true;
            }
        }
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    /**
     * Save holiday
     *
     * @access private
     */
    function holiday_post()
    {
        $request = $this->parse_params();
        $serial = $this->security->xss_clean(trim($request->serial));
        $title = $this->security->xss_clean(trim($request->title));
        $apply = $this->security->xss_clean(trim($request->apply));
        $description = $this->security->xss_clean(trim($request->description));
        $start_date = $this->security->xss_clean(trim($request->start_date));
        $end_date = $this->security->xss_clean(trim($request->end_date));
        $start_time = $this->security->xss_clean(trim($request->start_date));
        $end_time = $this->security->xss_clean(trim($request->end_date));
        $is_all_day = $this->security->xss_clean(trim($request->is_all_day));
        $type_id = $this->security->xss_clean(trim($request->type_id));
        $user_id = $this->security->xss_clean(trim($request->user_id));
        $school_id = $this->security->xss_clean(trim($request->school_id));
        
        $error_array = array();
        if (strlen($title) < 3) {
            array_push($error_array, "Type must be 3 character");
        }
        
        if (count($error_array)) {
            $this->set_response([], REST_Controller::HTTP_OK);
            exit();
        }
        
        $result = array();
        
        if (count($error_array) == false) {
            
            $this->operation->table_name = 'holiday';
            
            if ($serial) {
                $holiday = array(
                    'start_date' => date('c', strtotime($start_date)),
                    'end_date' => date('c', strtotime($end_date)),
                    'title' => ucfirst($title),
                    'apply' => $apply,
                    'user_id' => $user_id,
                    'description' => ucfirst($description),
                    'slug' => $this->slug_generator($description),
                    'event_id' => ($is_all_day == false ? $type_id : ''),
                    'last_edited' => date('Y-m-d'),
                    'all_day' => ($is_all_day ? 'y' : 'n'),
                    'start_time' => ($is_all_day == false ? date('H:i', strtotime($start_time)) : ''),
                    'end_time' => ($is_all_day == false ? date('H:i', strtotime($end_time)) : '')
                );
                $id = $this->operation->Create($holiday, $serial);
                if (count($id)) {
                    $result['message'] = true;
                }
            } else {
                
                $holiday = array(
                    'start_date' => date('c', strtotime($start_date)),
                    'end_date' => date('c', strtotime($end_date)),
                    'title' => ucfirst($title),
                    'apply' => $apply,
                    'description' => ucfirst($description),
                    'slug' => $this->slug_generator($description),
                    'user_id' => $user_id,
                    'school_id' => $school_id,
                    'event_id' => ($is_all_day == false ? $type_id : ''),
                    'created' => date('Y-m-d'),
                    'last_edited' => date('Y-m-d'),
                    'all_day' => ($is_all_day ? 'y' : 'n'),
                    'start_time' => ($is_all_day == false ? date('H:i', strtotime($start_time)) : ''),
                    'end_time' => ($is_all_day == false ? date('H:i', strtotime($end_time)) : '')
                );
                
                $id = $this->operation->Create($holiday);
                
                if (count($id)) {
                    
                    // Update Semester Lesson Dates
                    $this->update_lesson_set_dates($school_id);
                    
                    $result['message'] = true;
                }
            }
        }
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    /**
     * Get holiday module
     *
     * @access private
     */
    function holidays_get()
    {
        $school_id = $this->input->get('school_id');
        
        $result = array();
        
        if (empty($school_id)) {
            $this->set_response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            return;
        }
        
        $this->operation->table_name = 'holiday';
        $holidaytypelist = $this->operation->GetByWhere(array(
            'school_id' => $school_id
        ));
        
        if (count($holidaytypelist)) {
            foreach ($holidaytypelist as $value) {
                $this->operation->table_name = 'holiday_type';
                $event = $this->operation->GetByWhere(array(
                    'id' => $value->event_id
                ));
                
                $result[] = array(
                    'serial' => $value->id,
                    'title' => $value->title,
                    'description' => $value->description,
                    'allDay' => (bool) ($value->all_day == 'y' ? true : false),
                    'start' => ($value->all_day == 'y' ? $value->start_date : date('c', strtotime($value->start_date . $value->start_time))),
                    'end' => ($value->all_day == 'y' ? $value->end_date : date('c', strtotime($value->end_date . $value->end_time))),
                    'apply' => $value->apply,
                    'event' => $event,
                    'slug' => $value->slug,
                    'color' => ($value->all_day == 'y' ? '#109d57' : $this->get_random_color())
                );
            }
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    // endregion
    
    /**
     * Get grade list
     */
    function grades_get()
    {
        $session_id = $this->input->get('session_id');
        
        if (! empty($session_id)) {
            $this->operation->table_name = 'semester_dates';
            
            $active_semester = $this->operation->GetByWhere(array(
                'session_id' => $session_id,
                'status' => 'a'
            ));
            
            $this->operation->table_name = 'grades';
            
            $resultlist = $this->operation->GetByWhere(array(
                'status' => 'a',
                'semester_date_id' => $active_semester[0]->id
            ));
            
            $result = array();
            
            if (count($resultlist)) {
                $resultlist = unserialize($resultlist[0]->option_value);
                foreach ($resultlist as $value) {
                    $result[] = array(
                        'id' => $value['id'],
                        'title' => $value['title'],
                        'lower_limit' => $value['lower_limit'],
                        'upper_limit' => $value['upper_limit']
                    );
                }
            }
        }
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    /**
     * Save grades
     */
    function grade_post()
    {
        $request = $this->parse_params();
        $serail = $this->security->xss_clean(trim($request->id));
        $title = $this->security->xss_clean(trim($request->title));
        $lower_limit = $this->security->xss_clean(trim($request->lower_limit));
        $upper_limit = $this->security->xss_clean(trim($request->upper_limit));
        $school_id = $this->security->xss_clean(trim($request->school_id));
        
        $error_array = array();
        if (strlen($title) < 0) {
            array_push($error_array, "Type must be 3 character");
        }
        
        if (count($error_array)) {
            $this->set_response([], REST_Controller::HTTP_OK);
            exit();
        }
        
        $result['message'] = false;
        
        $this->operation->table_name = 'semester_dates';
        $resultlist = $this->operation->GetByWhere(array(
            'school_id' => $school_id,
            'status' => 'a'
        ));
        
        $this->operation->table_name = 'grades';
        if (count($error_array) == false && count($resultlist)) {
            
            $grade_row = $this->operation->GetByWhere(array(
                'semester_date_id' => $resultlist[0]->id,
                'status' => 'a'
            ));
            if (count($grade_row)) {
                if (! empty($serail)) {
                    $resultlist = unserialize($grade_row[0]->option_value);
                    foreach ($resultlist as $key => $value) {
                        if ((int) $resultlist[$key]['id'] == (int) $serail) {
                            $resultlist[$key]['title'] = $title;
                            $resultlist[$key]['lower_limit'] = (int) $lower_limit;
                            $resultlist[$key]['upper_limit'] = (int) $upper_limit;
                        }
                    }
                    
                    $grades = array(
                        'option_value' => serialize($resultlist)
                    );
                    $id = $this->operation->Create($grades, $grade_row[0]->id);
                    if (count($id)) {
                        $result['message'] = true;
                    }
                } else {
                    $resultlist = unserialize($grade_row[0]->option_value);
                    
                    $temp = array(
                        'id' => count($resultlist) + 1,
                        'title' => $title,
                        'lower_limit' => (int) $lower_limit,
                        'upper_limit' => (int) $upper_limit
                    );
                    array_push($resultlist, $temp);
                    $grades = array(
                        'option_value' => serialize($resultlist)
                    );
                    $id = $this->operation->Create($grades, $grade_row[0]->id);
                    if (count($id)) {
                        $result['message'] = true;
                    }
                }
            } else {
                $grades = array(
                    'semester_date_id' => $resultlist[0]->id,
                    'status' => 'i',
                    'option_value' => serialize($this->get_default_grades())
                );
                $id = $this->operation->Create($grades);
                if (count($id)) {
                    $result['message'] = true;
                }
            }
        }
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function grade_delete()
    {
        try {
            $serial = $this->input->get('id', true);
            $school_id = $this->input->get('school_id', true);
            
            $error_array = array();
            if (strlen($serial) < 0) {
                array_push($error_array, "Type must be 3 character");
            }
            
            if (count($error_array)) {
                $this->set_response([], REST_Controller::HTTP_OK);
                exit();
            }
            
            $result['message'] = false;
            if (! empty($serial) && ! empty($school_id)) {
                $this->operation->table_name = 'semester_dates';
                
                $result_list = $this->operation->GetByWhere(array(
                    'school_id' => $school_id,
                    'status' => 'a'
                ));
                
                $this->operation->table_name = 'grades';
                if (count($error_array) == false && count($result_list)) {
                    
                    $grade_row = $this->operation->GetByWhere(array(
                        'semester_date_id' => $result_list[0]->id,
                        'status' => 'a'
                    ));
                    if (count($grade_row)) {
                        if (! empty($serial)) {
                            $result_list = unserialize($grade_row[0]->option_value);
                            foreach ($result_list as $key => $value) {
                                if ((int) $result_list[$key]['id'] == (int) $serial) {
                                    unset($result_list[$key]);
                                }
                            }
                            
                            $grades = array(
                                'option_value' => serialize($result_list)
                            );
                            $id = $this->operation->Create($grades, $grade_row[0]->id);
                            if (count($id)) {
                                $result['message'] = true;
                            }
                        }
                    }
                }
            }
            $this->set_response($result, REST_Controller::HTTP_OK);
        } catch (Exception $e) {}
    }
    
    function options_get()
    {
        $this->operation->table_name = 'options';
        $is_email_found = $this->operation->GetRows();
        $result = array();
        if (count($is_email_found)) {
            foreach ($is_email_found as $value) {
                $result[] = array(
                    'id' => $value->id,
                    'key' => $value->option_name,
                    'value' => $value->option_value
                );
            }
        }
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function options_post()
    {
        $request = $this->parse_params();
        
        $email = $this->security->xss_clean(trim($request->email));
        
        $sresult['message'] = false;
        
        if (! is_null($email)) {
            
            $this->operation->table_name = 'options';
            $is_email_found = $this->operation->GetByWhere(array(
                'option_name' => 'refrence_email'
            ));
            if (count($is_email_found) == 1) {
                $option = array(
                    'option_name' => 'refrence_email',
                    'option_value' => $email
                );
                $id = $this->operation->Create($option, $is_email_found[0]->id);
            } else {
                $option = array(
                    'option_name' => 'refrence_email',
                    'option_value' => $email
                );
                $id = $this->operation->Create($option);
            }
            
            if (count($id)) {
                $sresult['message'] = true;
            }
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
    }
    
    function locations_get()
    {
        $this->operation->table_name = 'location';
        $citylist = $this->operation->GetRows();
        $result = array();
        if (count($citylist)) {
            foreach ($citylist as $value) {
                $result[] = array(
                    'id' => $value->id,
                    'name' => $value->location
                );
            }
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function location_get()
    {
        $location_id = $this->input->get('id');
        
        if (! is_null($location_id)) {
            $this->operation->table_name = 'location';
            $resultlist = $this->operation->GetByWhere(array(
                'id' => $location_id
            ));
            if (count($resultlist)) {
                $result = array();
                foreach ($resultlist as $value) {
                    $result[] = array(
                        'id' => $value->id,
                        'name' => $value->location
                    );
                }
            }
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function location_post()
    {
        $request = $this->parse_params();
        
        $location = $this->security->xss_clean(trim($request->location));
        $location_id = $this->security->xss_clean(trim($request->location_id));
        
        $sresult['message'] = false;
        $this->operation->table_name = 'location';
        if (! empty($location)) {
            if (! is_null($location_id) && ! empty($location_id)) {
                $locationarray = array(
                    'location' => ucfirst($location),
                    'unique_code' => strtoupper(substr($location, 0, 2)) . "_SCHOOL"
                );
                
                $id = $this->operation->Create($locationarray, $location_id);
                if (count($id)) {
                    $sresult['message'] = true;
                }
            } else {
                $locationarray = array(
                    'location' => ucfirst($location),
                    'date' => date('Y-m-d'),
                    'unique_code' => strtoupper(substr($location, 0, 2)) . "_SCHOOL"
                );
                
                $id = $this->operation->Create($locationarray);
                if (count($id)) {
                    $sresult['message'] = true;
                }
            }
        }
        $this->set_response($sresult, REST_Controller::HTTP_OK);
    }
    
    function location_delete()
    {
        $location_id = $this->input->get('location_id');
        
        $sresult['message'] = false;
        if (! empty($location_id)) {
            $this->operation->table_name = 'location';
            $this->operation->Remove($location_id);
            $sresult['message'] = true;
        }
        $this->set_response($sresult, REST_Controller::HTTP_OK);
    }
    
    function schools_get()
    {
        $this->operation->table_name = 'schools';
        $schoollist = $this->operation->GetRows();
        $schoolarray = array();
        if (count($schoollist)) {
            foreach ($schoollist as $value) {
                $city = $this->get_location($value->cityid);
                $schoolarray[] = array(
                    'id' => $value->id,
                    'name' => $value->name,
                    'city_name' => $city->location
                );
            }
        }
        
        $this->set_response($schoolarray, REST_Controller::HTTP_OK);
    }
    
    function school_get()
    {
        $school_id = $this->input->get('school_id');
        
        $schoolarray = array();
        if (! is_null($school_id)) {
            $this->operation->table_name = 'schools';
            $resultlist = $this->operation->GetByWhere(array(
                'id' => $school_id
            ));
            if (count($resultlist)) {
                $schoolarray = array();
                foreach ($resultlist as $value) {
                    $city = $this->get_location($value->cityid);
                    $schoolarray[] = array(
                        'id' => $value->id,
                        'name' => $value->name,
                        'city_name' => $city->location,
                        'city_id' => $city->id
                    );
                }
            }
        }
        
        $this->set_response($schoolarray, REST_Controller::HTTP_OK);
    }
    
    function school_post()
    {
        $request = $this->parse_params();
        $school_name = $this->security->xss_clean(trim($request->school_name));
        $location_id = $this->security->xss_clean(trim($request->location_id));
        $school_id = $this->security->xss_clean(trim($request->school_id));
        
        $sresult = array();
        $sresult['message'] = false;
        $this->operation->table_name = 'schools';
        if (! is_null($school_name) && ! is_null($location_id)) {
            if (! is_null($school_id) && ! empty($school_id)) {
                $schoolarray = array(
                    'name' => ucfirst($school_name),
                    'shortname' => substr(ucfirst($school_name), 0, 2),
                    'cityid' => $location_id
                );
                
                $id = $this->operation->Create($schoolarray, $school_id);
                if (count($id)) {
                    $sresult['message'] = true;
                }
            } else {
                $schoolarray = array(
                    'name' => ucfirst($school_name),
                    'shortname' => substr(ucfirst($school_name), 0, 2),
                    'cityid' => $location_id
                );
                
                $id = $this->operation->Create($schoolarray);
                if (count($id)) {
                    $this->operation->table_name = 'wizard';
                    $wizard = array(
                        'school_id' => $id,
                        'user_type' => 3,
                        'created' => date('Y-m-d'),
                        'edited' => date('Y-m-d'),
                        'status' => 'y'
                    );
                    $id = $this->operation->Create($wizard);
                    $sresult['message'] = true;
                }
            }
        }
        $this->set_response($sresult, REST_Controller::HTTP_OK);
    }
    
    function school_delete()
    {
        $sresult = array();
        $sresult['message'] = false;
        
        $school_id = $this->input->get('school_id');
        if (! empty($school_id)) {
            $this->operation->table_name = 'schools';
            $this->operation->Remove($school_id);
            $sresult['message'] = true;
        }
        $this->set_response($sresult, REST_Controller::HTTP_OK);
    }
    
    // region Semester
    // function semesters_get()
    // {
    //     $this->operation->table_name = 'semester';
    //     $semesterlist = $this->operation->GetRows();
        
    //     $semesterarray = array();
    //     if (count($semesterlist)) {
    //         foreach ($semesterlist as $value) {
    //             $semesterarray[] = array(
    //                 'id' => $value->id,
    //                 'name' => $value->semester_name,
    //                 'status' => $value->status
    //             );
    //         }
    //     }
    //     $this->set_response($semesterarray, REST_Controller::HTTP_OK);
    // }
    
    function semester_get()
    {
        $semester_id = $this->input->get('semester_id');
        
        $semesterarray = array();
        if (! is_null($semester_id)) {
            $this->operation->table_name = 'semester';
            $resultlist = $this->operation->GetByWhere(array(
                'id' => $semester_id
            ));
            if (count($resultlist)) {
                $value = $resultlist[0];
                //foreach ($resultlist as $value) {
                $semesterarray = array(
                    'id' => $value->id,
                    'name' => $value->semester_name,
                    'status' => $value->status
                );
                //}
            }
        }
        
        $this->set_response($semesterarray, REST_Controller::HTTP_OK);
    }
    
    function active_semester_post()
    {
        $request = $this->parse_params();
        $semester_id = $this->security->xss_clean(trim($request->semester_id));
        
        $sresult['message'] = false;
        
        if ($semester_id != 0 && is_numeric($semester_id)) {
            $this->db->query("UPDATE semester SET status = 'i'");
            $this->operation->table_name = 'semester';
            $semester_data = array(
                'modified' => date('Y-m-d'),
                'status' => 'a'
            );
            
            $id = $this->operation->Create($semester_data, $semester_id);
            
            if (count($id)) {
                $sresult['message'] = true;
            }
        }
        $this->set_response($sresult, REST_Controller::HTTP_OK);
    }
    
    /**
     * Modify active semester dates
     */
    function active_semester_dates_post()
    {
        $request = $this->parse_params();
        
        $serail = $this->security->xss_clean(trim($request->id));
        $school_id = trim($request->school_id);
        
        
        $error_array = array();
        if (empty($serail)) {
            array_push($error_array,"Date is empty");
        }
             
        if(count($error_array))
        {
            echo json_encode($error_array);
            exit();
        }

        $this->operation->table_name = 'semester_dates';
        $new_sem_dates = $this->operation->GetByWhere(array('id'=>$serail));
        $result['message'] = false;
        if(count($error_array) == false)
        {
            if($new_sem_dates)
            {

                $this->operation->table_name = 'semester_dates';
                $current_active_sem_dates = $this->operation->GetByWhere(array('school_id'=>$school_id,'status'=>'a'));

                $this->db->query("Update semester_dates set status = 'i' where school_id = ".$school_id);
                
                $semester_datail = array(
                    'status'=>'a',
                );
                $id = $this->operation->Create($semester_datail,$serail);
                
                if(count($id))
                {
                    $this->change_evaluation_semester((int) $current_active_sem_dates[0]->id,$id);
                    $this->change_grades_semester((int)$current_active_sem_dates[0]->id,$id);
                    $result['message'] = true;
                }
            }
        }

        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    /**
     * Get semester dates detail
     *
     * @access private
     */
    function semester_dates_get()
    {
        $school_id = $this->input->get('school_id');
        
        $this->operation->table_name = 'semester_dates';
       
        $semester_datail_list = $this->operation->GetByWhere(array('school_id'=> $school_id));
        $result = array();
        $status = "";
        $this->operation->table_name = 'sessions';
        $active_session_check = $this->operation->GetByWhere(array('status' => "a", 'school_id' =>  $school_id));
        $active_session_enddate = date('Y-m-d',strtotime($active_session_check[0]->dateto));
        
        if(count($semester_datail_list))
        {
            foreach ($semester_datail_list as $key => $value) {
               
                $current_active_session = $this->get_session($value->session_id);
                $current_active_semester = $this->get_semester($value->semester_id);
                
                $end_date_session = date('Y-m-d',strtotime($current_active_session[0]->dateto));
                
                if($active_session_enddate==$end_date_session)
                {
                    $status ="Active";
                }
                else
                {
                    $status ="Inactive";
                }
                $result[] = array(
                    'id'=>$value->id,
                    'start_date'=>date('M d, Y',strtotime($value->start_date)),
                    'end_date'=>date('M d, Y',strtotime($value->end_date)),
                    'session_id'=>$value->session_id,
                    'semester'=>$value->semester_id,
                    'status'=>$value->status,
                    'session_value'=>date('M d, Y',strtotime($current_active_session[0]->datefrom)).' - '.date('M d, Y',strtotime($current_active_session[0]->dateto)),
                    'session_status' =>$status,
                    'semester_value'=>$current_active_semester[0]->semester_name
                );
            }
        }

        $this->set_response($result, REST_Controller::HTTP_OK);
    }

    
    /**
     * Save semester dates
     */
    function semester_date_post()
    {
        $request = json_decode( file_get_contents('php://input'));

        $school_id = $this->security->xss_clean(trim($request->school_id));
        $serail = $this->security->xss_clean(trim($request->id));
        $semester = $this->security->xss_clean(trim($request->semester_id));
        $start_date = $this->security->xss_clean(trim($request->start_date));
        $end_date = $this->security->xss_clean(trim($request->end_date));

        $sresult['message'] = false;
        $check_valid['check_validation'] = true;
        $check_session_valid['check_session_valid'] = false;
        $error_array = array();
        if (empty($start_date) || empty($end_date)) {
            array_push($error_array,"Date is empty");
        }
        
        $post_start_date = date('Y-m-d', strtotime($start_date));
        
        $this->operation->table_name = 'sessions';
        $current_active_session = $this->operation->GetByWhere(array('school_id'=>$school_id,'status'=>'a'));
        $this->operation->table_name = 'semester_dates';
        $current_activeted_semester = $this->operation->GetByWhere(array('school_id'=>$school_id,'status'=>'a'));
        
        
        // Check already exists session,semester ans school
        $this->operation->table_name = 'semester_dates';
        
        $active_semester = $this->operation->GetByWhere(array('session_id' => $current_active_session[0]->id, 'school_id' => $current_active_session[0]->school_id, 'semester_id' => $semester));
        
        if($serail)
        {
            $semester_datail = array(
                'start_date'=>date('Y-m-d',strtotime($start_date)),
                'end_date'=>date('Y-m-d',strtotime($end_date)),
                'last_edited'=>date('Y-m-d'),
                'semester_id'=>$semester,
            );
            $id = $this->operation->Create($semester_datail,$serail);
            if(count($id))
            {
                $sresult['message'] = true;
            }
        }
        else
        {
            $inputstartdate = date('Y-m-d', strtotime($start_date));
            $inputenddate = date('Y-m-d', strtotime($end_date));  
            $record_check = $this->operation->GetByQuery("SELECT * FROM semester_dates WHERE  school_id =  ".$school_id);
            if(count($record_check))
            {
                foreach ($record_check as $key => $value)
                {
                    $start_date = date('Y-m-d', strtotime($value->start_date));
                    $end_date = date('Y-m-d', strtotime($value->end_date));
                    $record_datefrom = $this->operation->GetByQuery("SELECT * FROM semester_dates WHERE '".$inputstartdate."'>='".$start_date."' AND '".$inputstartdate."'<='".$end_date."' AND id =  ".$value->id);
                    if(count($record_datefrom))
                    {
                        
                        $sresult['exists'] = 'Exists';
                        $check_valid['check_validation'] = false;
                    }
                    $record_dateto = $this->operation->GetByQuery("SELECT * FROM semester_dates WHERE '".$inputenddate."'>='".$start_date."' AND '".$inputenddate."'<='".$end_date."' AND id =  ".$value->id);
                    if(count($record_dateto))
                    {
                       
                        $sresult['exists'] = 'Exists';
                        $check_valid['check_validation'] = false;
                    }
                }
                
                    
                    if($check_valid['check_validation'])
                    {
                        $record_check = $this->operation->GetByQuery("SELECT * FROM sessions WHERE  school_id =  ".$school_id);
                        if(count($record_check))
                        {
                            foreach ($record_check as $key => $value)
                            {
                                $start_date = date('Y-m-d', strtotime($value->datefrom));
                                $end_date = date('Y-m-d', strtotime($value->dateto));
                                $record_datefrom = $this->operation->GetByQuery("SELECT * FROM sessions WHERE '".$inputstartdate."'>='".$start_date."' AND '".$inputstartdate."'<='".$end_date."' AND id =  ".$value->id);
                                if(count($record_datefrom))
                                {
                                    $sessionid = $value->id;
                                    $sessiondatefrom = $value->datefrom;
                                    $sessiondateto = $value->dateto;
                                    $check_session_valid['check_session_valid'] = true;
                                }
                                $record_dateto = $this->operation->GetByQuery("SELECT * FROM sessions WHERE '".$inputenddate."'>='".$start_date."' AND '".$inputenddate."'<='".$end_date."' AND id =  ".$value->id);
                                if(count($record_dateto))
                                {
                                    $sessionid = $value->id;
                                    $sessiondatefrom = $value->datefrom;
                                    $sessiondateto = $value->dateto;
                                    $check_session_valid['check_session_valid'] = true;
                                }
                            }
                        }
                        // Check session dates
                        if($sessionid)
                        {
                            $record_datefrom_check = $this->operation->GetByQuery("SELECT * FROM sessions WHERE '".$inputstartdate."'>='".$sessiondatefrom."' AND '".$inputenddate."'<='".$sessiondateto."' AND id =  ".$sessionid);
                            if(count($record_datefrom_check))
                            {
                                $semester_datail = array(
                                'session_id'=>$sessionid,
                                'semester_id'=>$semester,
                                'start_date'=>date('Y-m-d',strtotime($inputstartdate)),
                                'end_date'=>date('Y-m-d',strtotime($inputenddate)),
                                'school_id'=>$school_id,
                                'created'=>date('Y-m-d'),
                                'last_edited'=>date('Y-m-d'),
                                );
                                $id = $this->operation->Create($semester_datail);
                                if(count($id))
                                {
                                    $sresult['message'] = true;
                                }
                                
                            }
                            else
                            {
                                $sresult['session_date_error'] = 'SessionDateError';
                            }
                        }
                        
                        
                    }
                
            }
            else
            {
                $sresult['session_date_error'] = 'SessionDateError';
            }
        }
        $this->set_response($sresult, REST_Controller::HTTP_OK);
    }
    
    // engregion
    
    // region course
    function course_lessons_get()
    {
        $subject_id = $this->input->get('subject_id');
        // $section_id = $this->input->get('section_id');
        $class_id = $this->input->get('class_id');
        $session_id = $this->input->get('session_id');
        $semester_id = $this->input->get('semester_id');
        
        $lessonlist = array();
        
        if (! is_null($subject_id) && ! is_null($class_id) && ! is_null($session_id) && ! is_null($semester_id)) {
            $query = $this->operation->GetByQuery('SELECT s.*,sd.date as read_date FROM semester_lesson_plan s inner join lesson_set_dates as sd on s.set_id = sd.set_id
                WHERE s.subject_id = ' . $subject_id . ' AND s.session_id = ' . $session_id . ' AND s.semester_id = ' . $semester_id . '
                 AND s.class_id = ' . $class_id . ' GROUP by s.id  ORDER BY s.preference ASC');
            
            if (count($query)) {
                foreach ($query as $key => $value) {
                    $lessonlist[] = array(
                        'id' => $value->id,
                        'unit' => $value->concept,
                        'name' => $value->topic,
                        'date' => (! is_null($value->read_date) ? date('d-M-Y', strtotime($value->read_date)) : ''),
                        'type' => ucfirst($value->type)
                    );
                }
            }
        }
        
        $this->response($lessonlist, REST_Controller::HTTP_OK);
    }
    
    function course_get()
    {
        $subject_id = $this->input->get('subject_id');
        $section_id = $this->input->get('section_id');
        $class_id = $this->input->get('class_id');
        $session_id = $this->input->get('session_id');
        $semester_id = $this->input->get('semester_id');
        
        $lessondetailarray = array();
        /*
         * if (! is_null($subject_id) && ! is_null($section_id) && ! is_null($class_id) && ! is_null($session_id) && ! is_null($semester_id)) {
         *
         * $progress = $this->operation->GetByQuery('SELECT * FROM `student_semesters` INNER JOIN invantage_users as inv on inv.id=student_id WHERE class_id = ' . $class_id . " AND section_id = " . $section_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " AND status = 'r' AND user_active_status=1");
         *
         * $latestReadDate = $this->operation->GetByQuery('SELECT s.read_date FROM `semester_lesson_plan` s INNER JOIN lesson_progress p WHERE p.lessonid=s.id AND p.status = "read" AND class_id = ' . $class_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " ORDER BY s.preference DESC");
         * if (count($latestReadDate)) {
         * $latestReadDate = $latestReadDate[0]->read_date;
         * } else {
         * $latestReadDate = '';
         * }
         * $datetime1 = null;
         * try {
         * if (! empty($latestReadDate))
         * $datetime1 = new DateTime($latestReadDate);
         * } catch (Exception $e) {}
         *
         * if (count($progress)) {
         * $studentprogress = $this->operation->GetByQuery('SELECT s.id as semid,s.read_date FROM `semester_lesson_plan` s WHERE subject_id = ' . $subject_id . ' AND semester_id = ' . $semester_id . ' AND section_id = ' . $section_id . ' ORDER BY s.read_date ASC');
         *
         * if (count($studentprogress)) {
         * foreach ($progress as $key => $value) {
         * $sparray = array();
         * foreach ($studentprogress as $key => $spvalue) {
         * $ar = $this->get_student_progress($spvalue->semid, $value->student_id);
         * $show = false;
         * if ($datetime1 != null) {
         * $datetime2 = new DateTime($spvalue->read_date);
         * $show = $datetime1 >= $datetime2;
         * }
         * $ar['show'] = $show ? 1 : 0;
         * $sparray[] = $ar;
         * }
         *
         * $lessondetailarray[] = array(
         * 'read_date' => $latestReadDate,
         * 'student_id' => $value->student_id,
         * 'screen_name' => $this->get_student_name($value->student_id),
         * 'student_plan' => $sparray
         * );
         * }
         * }
         * }
         * }
         */
        /* New code */
        if (!is_null($this->input->get('subject_id')) && !is_null($this->input->get('section_id')))
        {
            $student = array();

            //$progress = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` INNER JOIN invantageuser as inv on inv.id=studentid WHERE classid = ' . $this->input->get('inputclassid') . " AND sectionid = " . $this->input->get('inputsection') . " AND semesterid = " . $this->input->get('inputsemester') . " AND sessionid = " . $this->input->get('inputsession'));
            $progress = $this->operation->GetByQuery('SELECT student_id FROM `student_semesters` INNER JOIN invantage_users as inv on inv.id=student_id WHERE class_id = ' . $this->input->get('class_id') . " AND section_id = " . $this->input->get('section_id') . " AND semester_id = " . $this->input->get('semester_id') . " AND session_id = " . $this->input->get('session_id'));
            $latestReadDate = $this->operation->GetByQuery('SELECT p.finished FROM `semester_lesson_plan` s INNER JOIN lesson_progress p on p.lesson_id=s.id WHERE p.finished > 0 AND s.class_id = ' . $this->input->get('class_id') . " AND  semester_id = " . $this->input->get('semester_id') . "   ORDER BY p.finished DESC");
            
            //echo 'SELECT s.read_date FROM `semester_lesson_plan` s INNER JOIN lessonprogress p WHERE p.lessonid=s.id AND p.status = "read" AND classid = ' . $this->input->get('inputclassid') . " AND sectionid = " . $this->input->get('inputsection') . " AND semsterid = " . $this->input->get('inputsemester') . " AND sessionid = " . $this->input->get('inputsession') . "  ORDER BY s.read_date DESC";
            if (count($latestReadDate))
            {
                $latestReadDate = $latestReadDate[0]->finished;
            }
            else
            {
                $latestReadDate = '';
            }
            //print_r($latestReadDate);
            $datetime1 = null;
            //echo $latestReadDate;
            try
            {
                if (!empty($latestReadDate)) 
                    {

                        //$datetime1 = new DateTime($latestReadDate);
                        $datetime1 = date("Y-m-d",strtotime($latestReadDate));
                    }
            }
            catch(Exception $e)
            {
            }
            $lesson_array = array();
            if (count($progress))
            {
                
                $studentprogress = $this->operation->GetByQuery('SELECT s.id as semid ,sd.date as read_date FROM `semester_lesson_plan` s inner join lesson_set_dates as sd on s.set_id = sd.set_id WHERE s.subject_id = ' . $this->input->get('subject_id') . ' AND s.semester_id = ' . $this->input->get('semester_id') . ' AND s.session_id = ' . $this->input->get('session_id') . ' group by semid order by sd.date asc');
                if (count($studentprogress))
                {
                    foreach ($progress as $key => $value)
                    {

                        $sparray = array();
                        foreach ($studentprogress as $key => $spvalue)
                        {
                            $ar = $this->GetStudentProgress($spvalue->semid, $value->student_id);
                            $show = false;
                            //echo $datetime1;

                            if ($datetime1 != null)
                            {
                                $datetime2 = date("Y-m-d",strtotime($spvalue->read_date));
                                $show = strtotime($datetime1) >= strtotime($datetime2);
                            }
                            $ar['show'] = $show ? 1 : 0;
                            //$ar['show'] = 1;
                            $sparray[] = $ar;
                        }
                        $lessondetailarray[] = array( 'studentid' => $value->student_id, 'screenname' => $this->GetStudentName($value->student_id), 'student_plan' => $sparray);
                        //print_r($lessondetailarray);
                        //echo $spvalue->semid.'<br>';
                       // array_push($lesson_array, $spvalue->semid);
                        //exit;
                    }
                }
            }
        }

         $this->response($lessondetailarray, REST_Controller::HTTP_OK);
    }
    
    // endregion
    
    // region Subjects
    function default_subjects_get()
    {
        $params = $this->parse_params();
        
        if(isset($params['grade_slug'])){
            $this->response($this->get_default_subjects($params['grade_slug']), REST_Controller::HTTP_OK);
        }else{
            $this->response($this->get_default_subjects(), REST_Controller::HTTP_OK);
        }
    }
    
    function subjects_get()
    {
        $school_id = $this->input->get('school_id');
        
        if (empty($school_id)) {
            $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            return;
        }
        
        $user_id = $this->input->get('user_id');
        $role_id = FALSE;
        if ($role = $this->get_user_role($user_id)) {
            $role_id = $role->role_id;
        }
        $active_session = $this->get_active_session($school_id);
        $session_id = $active_session->id;
        if ($role_id == 4) {
            $subjectslist = $this->operation->GetByQuery("SELECT s.* FROM subjects s INNER JOIN schedule sch ON sch.subject_id=s.id WHERE sch.teacher_uid=" . $this->db->escape($user_id));
        } else {
            $subjectslist = $this->operation->GetByQuery("SELECT s.* FROM subjects s INNER JOIN `classes` c ON s.class_id=c.id AND s.session_id= ".$session_id." WHERE c.school_id=" . $this->db->escape($school_id));
        }
        
        $subjects = array();
        if (count($subjectslist)) {
            foreach ($subjectslist as $value) {
                $subjects[] = array(
                    'id' => $value->id,
                    'name' => $value->subject_name,
                    'class_id' => $value->class_id,
                    'class_name' => $this->get_class_name($value->class_id)
                );
            }
        }
        
        $this->response($subjects, REST_Controller::HTTP_OK);
    }
    
    function subjects_by_class_get()
    {

        $class_id = $this->input->get('class_id');
        
        $user_id = $this->input->get('user_id');
        $session_id = $this->input->get('session_id');
        $role_id = FALSE;
        if ($role = $this->get_user_role($user_id)) {
            $role_id = $role->role_id;
        }
        
        if (! empty($class_id)) {
            if ($role_id == 4) {
                $subjectslist = $this->operation->GetByQuery("SELECT s.* FROM subjects s INNER JOIN schedule sch ON sch.subject_id=s.id WHERE sch.teacher_uid=" . $this->db->escape($user_id) . " AND s.session_id = ".$session_id." AND s.class_id=" . $this->db->escape($class_id));
            } else {

                $subjectslist = $this->get_subjects($class_id,$session_id);
            }
            
            $subjects = array();
            if (count($subjectslist)) {
                foreach ($subjectslist as $value) {
                    $subjects[] = array(
                        'id' => $value->id,
                        'name' => $value->subject_name,
                        'class_id' => $value->class_id,
                        'class_name' => $this->get_class_name($value->class_id)
                    );
                }
            }
        }
        
        $this->response($subjects, REST_Controller::HTTP_OK);
    }
    
    function subject_get()
    {
        $id = $this->input->get('subject_id');

        $subjects = array();
        if ($id) {
            $is_selected_subject = $this->get_subject($id);
            
            if (count($is_selected_subject)) {
                
                $subjects = array(
                    'id' => $is_selected_subject->id,
                    'name' => $is_selected_subject->subject_name,
                    'code' => $is_selected_subject->subject_code,
                    'class_id' => $is_selected_subject->class_id,
                    'class_name' => $this->get_class_name($is_selected_subject->class_id),
                    'semester_id' => $is_selected_subject->semester_id,
                    'image' => $is_selected_subject->subject_image
                );
            }
        }
        
        $this->response($subjects, REST_Controller::HTTP_OK);
    }
    
    public function subject_post()
    {
        

        $params = $this->parse_params();
        
        $result = array();
        
        $serial = $params->serial;

        // $session_id = $this->input->post('session_id');
        
        // $is_image_edit = $this->input->post('is_image_edit');
        
        $name = $params->name;
        
        $code = $params->code;
        
        $class_id = $params->class_id;
        $semester_id = $params->semester_id;
        $session_id = $params->session_id;
        // $semester_id = $this->input->post('semester_id');
        
        if (empty($name) || empty($class_id)) {
            $this->response($result, REST_Controller::HTTP_NOT_ACCEPTABLE);
            return;
        }
        // get semester id and session id
        
        // end
        $subjectfile = '';
        $is_subject_found = array();
        
        if ($serial) {
            $is_subject_found = $this->get_subject($serial);
        }
        
        if (isset($_FILES) == 1) {
            // Save in database
            foreach ($_FILES as $value) {
                $filename = time() . trim(basename($value['name']));
                $base_url_path = UPLOAD_PATH . "subject_image/" . $filename;
                $subjectfile = $base_url_path;
            }
        } else if (count($is_subject_found)) {
            $subjectfile = $is_subject_found->subject_image;
        }
        
        if (count($is_subject_found)) {
            
            $subject = array(
                'subject_name' => $name,
                'subject_code' => $code,
                'class_id' => $class_id,
                'semester_id' => $semester_id,
                'session_id' => $session_id,
                'last_update' => date("Y-m-d H:i")
            );
            
            $this->operation->table_name = 'subjects';
            
            $id = $this->operation->Create($subject, $serial);
        } else {
            $subject = array(
                'subject_name' => $name,
                'subject_code' => $code,
                'class_id' => $class_id,
                'semester_id' => $semester_id,
                'session_id' => $session_id,
                'last_update' => date("Y-m-d H:i")
            );
            
            $this->operation->table_name = 'subjects';
            $id = $this->operation->Create($subject);
        }
        
        // Upload the image
        if (count($id)) {
            
            if (isset($_FILES) == 1) {
                // Save in database
                foreach ($_FILES as $value) {
                    $filename = time() . trim(basename($value['name']));
                    $subjectfile = UPLOAD_PATH . "subject_image/" . $filename;
                    if (is_uploaded_file($value['tmp_name'])) {
                        if (move_uploaded_file($value['tmp_name'], $subjectfile)) {
                            
                            $subject = array(
                                'subject_image' => (! is_null($subjectfile) ? $subjectfile : '')
                            );
                            
                            $this->operation->table_name = 'subjects';
                            $this->operation->Create($subject, $id);
                        }
                    }
                }
            }
            $result['message'] = true;
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    // endregion
    
    // region Sections
    function default_sections_get()
    {
        $this->response($this->get_default_sections(), REST_Controller::HTTP_OK);
    }
    
    function sections_by_class_post()
    {
        $request = $this->parse_params();
        
        $class_id = $this->security->xss_clean(trim($request->class_id));
        $sections = $request->sections;
        $school_id = $this->security->xss_clean(trim($request->school_id));
        
        $sresult = array();
        $sresult['message'] = false;

        if (! is_null($class_id) && ! is_null($school_id)) {
            foreach ($sections as $value) {
                $this->operation->table_name = 'sections';
                
                $is_section_found = $this->operation->GetByWhere(array(
                    'section_name' => $value->name,
                    'school_id' => $school_id
                ));
                
                $this->operation->table_name = 'assign_sections';
                
                $is_section_found_in_assi_table = $this->operation->GetByWhere(array(
                    'class_id' => $class_id,
                    'section_id' => $is_section_found[0]->id
                ));
                
                if (count($is_section_found_in_assi_table) == 0) {
                    
                    $studentresult = array(
                        'class_id' => $class_id,
                        'section_id' => $is_section_found[0]->id,
                        'status' => ($value->status == 1 ? 'a' : 'i')
                    );
                    $id = $this->operation->Create($studentresult);
                } else {
                    
                    $studentresult = array(
                        'status' => ($value->status == 1 ? 'a' : 'i')
                    );
                    $this->operation->table_name = 'assign_sections';
                    $id = $this->operation->Create($studentresult, $is_section_found_in_assi_table[0]->id);
                }
            }
            
            if (count($id)) {
                $sresult['message'] = true;
            }
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
    }
    
    /**
     *
     * @param
     *            class_id
     * @param
     *            role_id
     * @param
     *            user_id
     */
    function sections_by_class_get()
    {
        $sections = array();
        $class_id = $this->input->get('class_id');
        $user_id = $this->input->get('user_id');
        
        if (! empty($class_id)) {
            
            $role_id = FALSE;
            if ($role = $this->get_user_role($user_id)) {
                $role_id = $role->role_id;
            }
            
            if ($role_id == 4) {
                $is_student_found = $this->operation->GetByQuery("SELECT s.*,ass.id as sid  FROM schedule sc INNER JOIN sections s On s.id = sc.section_id INNER JOIN assign_sections ass on ass.section_id = s.id   where sc.teacher_uid = " . $user_id . " AND ass.status = 'a' AND sc.class_id = " . $class_id . " GROUP BY s.id");
            } else {
                $is_student_found = $this->operation->GetByQuery("SELECT  s.*,ass.id as sid FROM sections s INNER JOIN assign_sections ass on ass.section_id = s.id  where ass.status = 'a' AND ass.class_id = " . $class_id);
            }
            
            if (count($is_student_found)) {
                foreach ($is_student_found as $key => $value) {
                    $sections[] = array(
                        'id' => $value->id,
                        'name' => $value->section_name
                    );
                }
            }
        }
        $this->response($sections, REST_Controller::HTTP_OK);
    }
    
    function sections_assigned_by_class_get()
    {
        $sectionarray = array();
        $class_id = $this->input->get('class_id');
        
        if (! empty($class_id)) {
            
            $section_by_class = $this->operation->GetByQuery("SELECT assi.*,s.section_name, s.id  FROM assign_sections assi INNER JOIN sections s ON s.id = assi.section_id WHERE assi.status = 'a' AND assi.class_id  =" . $class_id);
            if (count($section_by_class)) {
                foreach ($section_by_class as $key => $value) {
                    $sectionarray[] = array(
                        'id' => $value->id,
                        'status' => $value->status,
                        'selected' => ($value->status == 'a' ? true : false),
                        'name' => $value->section_name
                    );
                }
            }
        }
        $this->response($sectionarray, REST_Controller::HTTP_OK);
    }
    
    function sections_get()
    {
        $sectionarray = array();
        
        $school_id = $this->input->get('school_id');
        
        if (! empty($school_id)) {
            
            $this->operation->table_name = 'sections';
            
            $sectionlist = $this->operation->GetByQuery("SELECT s.* FROM sections s WHERE school_id=" . $school_id);
            
            if (count($sectionlist)) {
                foreach ($sectionlist as $value) {
                    $sectionarray[] = array(
                        'id' => $value->id,
                        'name' => $value->section_name
                    );
                }
            }
        }
        $this->response($sectionarray, REST_Controller::HTTP_OK);
    }
    
    function section_get()
    {
        $sectionarray = array();
        
        $section_id = $this->input->get('section_id');
        $user_id = $this->input->get('user_id');
        
        if (! empty($section_id)) {
            
            $this->operation->table_name = 'sections';
            
            $sectionlist = $this->operation->GetByQuery("SELECT s.* FROM sections s  WHERE  s.id =" . $section_id);
            
            if (count($sectionlist)) {
                $value = $sectionlist[0];
                
                //foreach ($sectionlist as $key => $value) {
                $sectionarray = array(
                    'id' => $value->id,
                    'name' => $value->section_name
                );
                //}
            }
        }
        $this->response($sectionarray, REST_Controller::HTTP_OK);
    }
    
    function section_post()
    {
        $request = $this->parse_params();
        
        $section_name = $this->security->xss_clean(trim($request->section_name));
        $section_id = $this->security->xss_clean(trim($request->section_id));
        $class_id = $this->security->xss_clean(trim($request->class_id));
        $school_id = $this->security->xss_clean(trim($request->school_id));
        
        $sresult['message'] = false;
        if (! is_null($section_name) && ! empty($section_name)) {
            $this->operation->table_name = 'sections';
            if (! empty($section_id)) {
                $sessionarray = array(
                    'section_name' => $section_name,
                    'last_update' => date('Y-m-d')
                );
                
                $id = $this->operation->Create($sessionarray, $section_id);
                if (count($id) && ! empty($class_id)) {
                    $this->operation->table_name = 'assign_sections';
                    $sessionarray = array(
                        'class_id' => $class_id
                    );
                    $this->operation->primary_key = 'section_id';
                    $id = $this->operation->Create($sessionarray, $section_id);
                }
            } else if (! empty($school_id)) {
                $sessionarray = array(
                    'section_name' => $section_name,
                    'last_update' => date('Y-m-d'),
                    'school_id' => $school_id
                );
                $id = $this->operation->Create($sessionarray);
            }
            
            if (count($id)) {
                $sresult['message'] = true;
            }
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
    }
    
    function section_delete()
    {
        $section_id = $this->input->get('section_id');
        $sresult['message'] = false;
        if (! empty($section_id)) {
            $this->operation->table_name = 'sections';
            $this->operation->Remove($section_id);
            $sresult['message'] = true;
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
    }

    function semester_date_delete()
    {

        
        $postdata = file_get_contents("php://input");
            
        $request = json_decode($postdata);
        
        $id =  $request->id;

        $sresult['message'] = false;
        if (! empty($id)) {
            $this->operation->table_name = 'semester_dates';
            $this->operation->Remove($id);
            $sresult['message'] = true;
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
    }
    
    // endregion
    function check_user_by_email_get()
    {
        $value = $this->input->get('value');
        $id = $this->input->get('id');
        
        $result = array();
        $result['message'] = false;
        if (! empty($value)) {
            $result['message'] = $this->record_exists('email', $value, $id);
        }
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function check_user_by_nic_get()
    {
        $value = $this->input->get('value');
        $id = $this->input->get('id');
        
        $result = array();
        $result['message'] = false;
        if (! empty($value)) {
            $result['message'] = $this->record_exists('nic', $value, $id);
        }
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    // region class
    function default_classes_get()
    {
        $this->response($this->get_default_classes(), REST_Controller::HTTP_OK);
    }
    
    function classes_with_details_get()
    {
        $school_id = $this->input->get('school_id');
        
        $this->operation->table_name = "classes";
        if (empty($school_id)) {
            $query = $this->operation->GetRows();
        } else {
            $query = $this->operation->GetByWhere(array(
                'school_id' => $school_id
            ));
        }
        $classarray = array();
        
        if (count($query)) {
            foreach ($query as $key => $value) {
                
                $school = $this->get_school($value->school_id);
                
                $sectionlist = array();
                $is_section_found = $this->operation->GetByQuery("SELECT s.id as section_id,s.section_name,assi.status FROM assign_sections assi INNER JOIN sections s ON s.id = assi.section_id  WHERE  assi.class_id =" . $value->id);
                if (count($is_section_found)) {
                    foreach ($is_section_found as $key => $svalue) {
                        $sectionlist[] = array(
                            'id' => $svalue->section_id,
                            'name' => $svalue->section_name,
                            'status' => $svalue->status
                        );
                    }
                }
                $classarray[] = array(
                    'id' => $value->id,
                    'name' => $value->grade,
                    'status' => $value->status,
                    'school' => $school->name,
                    'city' => $school->location,
                    'sections' => $sectionlist
                );
            }
        }
        $this->response($classarray, REST_Controller::HTTP_OK);
    }
    
    function classes_get()
    {
        $school_id = $this->input->get('school_id');
        
        $user_id = $this->input->get('user_id');
        $role_id = FALSE;
        if ($role = $this->get_user_role($user_id)) {
            $role_id = $role->role_id;
        }

        $this->operation->table_name = "classes";
        if (empty($school_id)) {
            if ($role_id == 4) {
                
                $query = $this->operation->GetByQuery("SELECT c.* FROM classes c INNER JOIN schedule sch ON sch.class_id=c.id WHERE sch.teacher_uid=$user_id");
            } else {
                
                //$query = $this->operation->GetRows();
                $query = $this->operation->GetByWhere(array(
                    'school_id' => $school_id
                ));
            }
        } else {
            if ($role_id == 4) {
                
                $query = $this->operation->GetByQuery("SELECT c.*,sc.section_name FROM classes c INNER JOIN schedule sch ON sch.class_id=c.id inner join sections as sc on sc.id = sch.section_id WHERE sch.teacher_uid=$user_id AND c.school_id=$school_id GROUP BY id");
            } else {

                $query = $this->operation->GetByWhere(array(
                    'school_id' => $school_id
                ));
            }
        }
        $result = array();
        
        if (count($query)) {
            foreach ($query as $value) {
                $result[] = array(
                    'id' => $value->id,
                    'last_update' => $value->last_update,
                    'name' => $value->grade,
                    'section_name' => $value->section_name,
                );
            }
        }
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function class_get()
    {
        $id = $this->input->get('class_id');
        
        if (! empty($id)) {
            $this->operation->table_name = "classes";
            
            $query = $this->operation->GetByWhere(array(
                'id' => $id
            ));
        }
        
        $result = array();
        
        if (count($query)) {
            $result = $query[0];
        }
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function class_post()
    {
        $request = $this->parse_params();
        
        $class_name = trim($request->class_name);
        $class_id = trim($request->class_id);
        $school_id = trim($request->school_id);
        
        $sresult['message'] = false;
        if (! is_null($class_name) && ! is_null($class_id)) {
            $this->operation->table_name = 'classes';
            if (! empty($class_id) && ! empty($class_name)) {
                $sessionarray = array(
                    'grade' => $class_name,
                    'last_update' => date('Y-m-d')
                );
                
                $id = $this->operation->Create($sessionarray, $class_id);
                if (count($id)) {
                    $sresult['message'] = true;
                }
            } else if (! empty($school_id) && ! empty($class_name)) {
                $sessionarray = array(
                    'grade' => $class_name,
                    'last_update' => date('Y-m-d'),
                    'school_id' => $school_id
                );
                $id = $this->operation->Create($sessionarray);
                if (count($id)) {
                    $sresult['message'] = true;
                }
            }
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
    }
    
    function class_delete()
    {
        $section_id = $this->input->get('class_id');
        $sresult['message'] = false;
        if (! empty($section_id)) {
            $this->operation->table_name = 'classes';
            $this->operation->Remove($section_id);
            $sresult['message'] = true;
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
    }
    
    // region Lessons
    function lessons_get()
    {
        $class_id = $this->input->get('class_id');
        $subject_id = $this->input->get('subject_id');
        $session_id = $this->input->get('session_id');
        
        $lessons = array();
        
        if (! empty($class_id) && ! empty($subject_id) && ! empty($session_id)) {
            
            $this->operation->table_name = 'semester_dates';
            $active_semester = $this->operation->GetByWhere(array(
                'session_id' => $session_id,
                'status' => 'a'
            ));
            
            $is_lesson_found = $this->operation->GetByQuery("SELECT * FROM default_lesson_plan
                WHERE subject_id= " . $subject_id . " AND class_id=" . $class_id . " AND semester_id=" . $active_semester[0]->semester_id . " AND session_id=" . $session_id);
            // echo $this->db->last_query();
            
            if (count($is_lesson_found)) {
                foreach ($is_lesson_found as $key => $value) {
                    $lessons[] = array(
                        'id' => $value->id,
                        'concept' => $value->concept,
                        'topic' => $value->topic,
                        'lesson' => $value->lesson
                    );
                }
            }
        }
        
        // echo json_encode($lessons);
        $this->set_response($lessons, REST_Controller::HTTP_OK);
    }
    
    function students_get()
    {
        try {
            
            $class_id = $this->input->get('class_id');
            $semester_id = $this->input->get('semester_id');
            $section_id = $this->input->get('section_id');
            
            $students_list = array();
            
            if (! empty($class_id) && ! empty($section_id) && ! empty($semester_id)) {
                $this->operation->table_name = 'student_semesters';
                $is_student_found = $this->operation->GetByQuery("SELECT ss.*, inv.screenname, inv.username FROM student_semesters ss INNER JOIN invantage_users inv ON inv.id=ss.student_id WHERE ss.semester_id = " . $semester_id . " AND ss.class_id =" . $class_id . " AND ss.section_id = " . $section_id . "  AND ss.status = 'r'");
                
                if (count($is_student_found)) {
                    foreach ($is_student_found as $value) {
                        $fname = $this->get_user_meta($value->student_id, 'sfullname');
                        $lname = $this->get_user_meta($value->student_id, 'slastname');
                        $student = $this->get_student($value->student_id);
                        
                        $profile_image = "";
                        if($student){
                            $profile_image = $this->get_uploaded_file_url($student->profile_image, UPLOAD_CAT_PROFILE);
                        }
                        
                        $classlist = $this->operation->GetByQuery("SELECT s.*, c.grade, se.section_name, sem.semester_name FROM student_semesters s  INNER JOIN semester sem on sem.id = s.semester_id INNER JOIN classes c on c.id = s.class_id INNER JOIN sections se on se.id = s.section_id   WHERE s.status = 'r' and s.student_id = " . $value->student_id);
                        $class_id = $semester_id = $semester_name = $section_id = $class_name = $section_name = '';
                        
                        if (count($classlist)) {
                            $class_id = $classlist[0]->class_id;
                            $class_name = $classlist[0]->grade;
                            $section_id = $classlist[0]->section_id;
                            $section_name = $classlist[0]->section_name;
                            $semester_id = $classlist[0]->semester_id;
                            $semester_name = $classlist[0]->semester_name;
                        }
                        
                        $students_list[] = array(
                            'id' => $value->student_id,
                            'roll_number' => $value->username,
                            'screen_name' => $value->screenname,
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'father_name' => $this->get_user_meta($value->student_id, 'father_name'),
                            'profile_image' => $profile_image,
                            'dob' => $this->get_user_meta($value->student_id, 'sdob'),
                            'phone' => ($this->get_user_meta($value->student_id, 'sphone') != false ? $this->get_user_meta($value->student_id, 'sphone') : ''),
                            'req_financial_assistance' => ($this->get_user_meta($value->student_id, 'financial_assistance') === TRUE),
                            'mode' => ($this->get_user_meta($value->student_id, 'mode')),
                            'class_id' => $class_id,
                            'class_name' => $class_name,
                            'semester_id' => $semester_id,
                            'semester_name' => $semester_name,
                            'section_id' => $section_id,
                            'section_name' => $section_name
                        );
                    }
                }
            }
            if (count($students_list)) {
                $this->response($students_list, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'no record found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no record found' . $e
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    function students_by_class_and_section_get()
    {
        $class_id = $this->input->get('class_id', true);
        $section_id = $this->input->get('section_id', true);
        $session_id = $this->input->get('session_id', true);
        $semester_id = $this->input->get('semester_id', true);
        $school_id = $this->input->get('school_id', true);
        $result = array();
        if(!$session_id)
        {
            $active_session = $this->get_active_session($school_id);
            $active_semester = $this->get_active_semester_dates_by_session($active_session->id);

            $session_id = $active_session->id;
            $semester_id = $active_semester->semester_id;

        }

        if (! empty($class_id) && ! empty($section_id)) {
            $is_result_found = $this->operation->GetByQuery('SELECT inv.username,inv.screenname,inv.profile_image,inv.id as uid FROM student_semesters s  INNER JOIN invantage_users inv ON inv.id = s.student_id  WHERE s.status = "r" AND s.class_id =' . $class_id . ' AND s.section_id = ' . $section_id. ' AND s.session_id = '.$session_id.' AND s.semester_id ='.$semester_id);
            
            if (count($is_result_found)) {
                foreach ($is_result_found as $value) {
                    
                    $result[] = array(
                        'id' => $value->uid,
                        'name' => $this->GetStudentName($value->uid),
                        'rollnumber' => $value->username,
                        //'name' => $value->screenname,
                        'profile_image' => $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE),
                        'fathername' => ($this->get_user_meta($value->uid, 'father_name') != false ? $this->get_user_meta($value->uid, 'father_name') : ''),
                        'phone' => ($this->get_user_meta($value->uid, 'sphone') != false ? $this->get_user_meta($value->uid, 'sphone') : '')
                    );
                }
            }
        }
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function students_by_school_get()
    {
        try {
            
            $school_id = $this->input->get('school_id');
            $role_id = $this->input->get('role_id');
            $user_id = $this->input->get('user_id');
            
            $students_list = array();
            
            if (! empty($role_id) && $role_id == 4 && ! empty($user_id)) {
                $is_student_found = $this->operation->GetByQuery("SELECT inv.*,cl.grade,sc.section_name FROM student_semesters ss INNER join classes cl ON ss.class_id=cl.id INNER join sections sc on ss.section_id=sc.id INNER join invantage_users inv on  inv.id = ss.student_id INNER JOIN schedule sch ON ss.class_id=sch.class_id  WHERE ss.status = 'r' AND sch.teacher_uid=" . $user_id . " AND sc.id = sch.section_id GROUP BY inv.id");
            } else if (! empty($school_id)) {
                $is_student_found = $this->operation->GetByQuery("SELECT inv.*,cl.grade,sc.section_name FROM invantage_users inv INNER join user_locations ul on ul.user_id = inv.id INNER join student_semesters ss on inv.id = ss.student_id INNER join classes cl ON ss.class_id=cl.id INNER JOIN sections sc ON ss.section_id=sc.id WHERE ss.status = 'r' AND ul.school_id = " . $school_id . " GROUP BY inv.id");
            }
            
            if (count($is_student_found)) {
                foreach ($is_student_found as $value) {
                    $fname = $this->get_user_meta($value->id, 'sfullname');
                    $lname = $this->get_user_meta($value->id, 'slastname');
                    $student = $this->get_student($value->id);
                    
                    $profile_image = "";
                    if($student){
                        $profile_image = $this->get_uploaded_file_url($student->profile_image, UPLOAD_CAT_PROFILE);
                    }
                    
                    $classlist = $this->operation->GetByQuery("SELECT s.*, c.grade, se.section_name, sem.semester_name FROM student_semesters s  INNER JOIN semester sem on sem.id = s.semester_id INNER JOIN classes c on c.id = s.class_id INNER JOIN sections se on se.id = s.section_id   WHERE s.status = 'r' and s.student_id = " . $value->id);
                    $class_id = $semester_id = $semester_name = $section_id = $class_name = $section_name = '';
                    
                    if (count($classlist)) {
                        $class_id = $classlist[0]->class_id;
                        $class_name = $classlist[0]->grade;
                        $section_id = $classlist[0]->section_id;
                        $section_name = $classlist[0]->section_name;
                        $semester_id = $classlist[0]->semester_id;
                        $semester_name = $classlist[0]->semester_name;
                    }
                    
                    $students_list[] = array(
                        'id' => $value->id,
                        'roll_number' => $value->username,
                        'screen_name' => $value->screenname,
                        'first_name' => $fname,
                        'last_name' => $lname,
                        'profile_image' => $profile_image,
                        'father_name' => $this->get_user_meta($value->id, 'father_name'),
                        'dob' => $this->get_user_meta($value->id, 'sdob'),
                        'phone' => ($this->get_user_meta($value->id, 'sphone') != false ? $this->get_user_meta($value->id, 'sphone') : ''),
                        'req_financial_assistance' => ($this->get_user_meta($value->id, 'financial_assistance') != '' ? $this->get_user_meta($value->id, 'financial_assistance') : 'No'),
                        'mode' => ($this->get_user_meta($value->id, 'mode')),
                        'class_id' => $class_id,
                        'class_name' => $class_name,
                        'semester_id' => $semester_id,
                        'semester_name' => $semester_name,
                        'section_id' => $section_id,
                        'section_name' => $section_name
                    );
                }
            }
            
            $this->response($students_list, REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no class found',
                'error' => $e
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    function student_get()
    {
        $class_id = $this->input->get('class_id');
        $semester_id = $this->input->get('semester_id');
        $section_id = $this->input->get('section_id');
        $student_id = $this->input->get('id');
        
        $result = array();
        if (! empty($class_id) && ! empty($section_id) && ! empty($semester_id) && ! empty($student_id)) {
            $this->operation->table_name = 'student_semesters';
            $student_data = $this->operation->GetByQuery("SELECT ss.*, inuser.* FROM student_semesters ss INNER JOIN invantage_users inuser ON inuser.id=ss.student_id WHERE ss.semester_id = " . $semester_id . " AND ss.class_id =" . $class_id . " AND ss.section_id = " . $section_id . "  AND ss.status = 'r' AND ss.student_id <>" . $student_id);
        } else if (! empty($student_id)) {
            
            $student_data = $this->operation->GetByQuery("SELECT inuser.*,s.class_id AS cid,s.section_id AS sid,sec.section_name AS section_name,cl.grade AS grade FROM invantage_users inuser INNER JOIN student_semesters s ON s.student_id = inuser.id INNER JOIN classes cl ON s.class_id=cl.id INNER JOIN sections sec ON s.section_id=sec.id
            WHERE inuser.type = 's' AND inuser.id= " . $student_id);
        }
        
        if (count($student_data)) {
            $value = $student_data[0];
            
            $fname = $this->get_user_meta($student_id, 'sfullname');
            $lname = $this->get_user_meta($student_id, 'slastname');
            $student = $this->get_student($student_id);
            
            $profile_image ="";
            
            if($student){
                $profile_image = $this->get_uploaded_file_url($student->profile_image, UPLOAD_CAT_PROFILE);
            }
            
            $classlist = $this->operation->GetByQuery("SELECT s.*, c.grade, se.section_name, sem.semester_name FROM student_semesters s  INNER JOIN semester sem on sem.id = s.semester_id INNER JOIN classes c on c.id = s.class_id INNER JOIN sections se on se.id = s.section_id   WHERE s.status = 'r' and s.student_id = " . $student_id);
            $class_id = $semester_id = $semester_name = $section_id = $class_name = $section_name = '';
            
            if (count($classlist)) {
                $class_id = $classlist[0]->class_id;
                $class_name = $classlist[0]->grade;
                $section_id = $classlist[0]->section_id;
                $section_name = $classlist[0]->section_name;
                $semester_id = $classlist[0]->semester_id;
                $semester_name = $classlist[0]->semester_name;
            }
            
            $result = array(
                'id' => $student_id,
                'roll_number' => $value->username,
                'screen_name' => $value->screenname,
                'first_name' => $fname,
                'last_name' => $lname,
                'profile_image' => $profile_image,
                'father_name' => $this->get_user_meta($student_id, 'father_name'),
                'dob' => $this->get_user_meta($student_id, 'sdob'),
                'phone' => ($this->get_user_meta($student_id, 'sphone') != false ? $this->get_user_meta($student_id, 'sphone') : ''),
                'req_financial_assistance' => ($this->get_user_meta($student_id, 'financial_assistance')),
                'mode' => ($this->get_user_meta($student_id, 'mode')),
                'class_id' => $class_id,
                'class_name' => $class_name,
                'semester_id' => $semester_id,
                'semester_name' => $semester_name,
                'section_id' => $section_id,
                'section_name' => $section_name
            );
            
            $result['sign'] = ($this->get_user_meta($student_id, 'student_signature') != false ? $this->get_user_meta($student_id, 'student_signature') : '');
            
            $result['sign_date'] = ($this->get_user_meta($student_id, 'student_submate_date') != false ? $this->get_user_meta($student_id, 'student_submate_date') : '');
            
            $result['street'] = ($this->get_user_meta($student_id, 'saddress') != false ? $this->get_user_meta($student_id, 'saddress') : '');
            
            $result['unit'] = ($this->get_user_meta($student_id, 'shunit') != false ? $this->get_user_meta($student_id, 'shunit') : '');
            
            $result['province'] = ($this->get_user_meta($student_id, 'sprovice') != false ? $this->get_user_meta($student_id, 'sprovice') : '');
            
            $result['city'] = ($this->get_user_meta($student_id, 'scity') != false ? $this->get_user_meta($student_id, 'scity') : '');
            
            $result['postal_code'] = ($this->get_user_meta($student_id, 'spcode') != false ? $this->get_user_meta($student_id, 'spcode') : '');
            
            $result['phone'] = ($this->get_user_meta($student_id, 'sphone') != false ? $this->get_user_meta($student_id, 'sphone') : '');
            
            $result['email'] = ($this->get_user_meta($student_id, 'semail') != false ? $this->get_user_meta($student_id, 'semail') : '');
            
            $result['dob'] = ($this->get_user_meta($student_id, 'sdob') != false ? $this->get_user_meta($student_id, 'sdob') : '');
            
            $result['enroll_date'] = ($this->get_user_meta($student_id, 'sdateav') != false ? $this->get_user_meta($student_id, 'sdateav') : '');
            
            $result['nic'] = ($this->get_user_meta($student_id, 'snic') != false ? $this->get_user_meta($student_id, 'snic') : '');
            
            $result['mother_lang'] = ($this->get_user_meta($student_id, 'smthrlng') != false ? $this->get_user_meta($student_id, 'smthrlng') : '');
            
            $result['add_lang'] = ($this->get_user_meta($student_id, 'saddlang') != false ? $this->get_user_meta($student_id, 'saddlang') : '');
            
            $result['father_name'] = ($this->get_user_meta($student_id, 'father_name') != false ? $this->get_user_meta($student_id, 'father_name') : '');
            
            $result['father_nic'] = ($this->get_user_meta($student_id, 'father_nic') != false ? $this->get_user_meta($student_id, 'father_nic') : '');
            
            $result['father_profession'] = ($this->get_user_meta($student_id, 'father_profession') != false ? $this->get_user_meta($student_id, 'father_profession') : '');
            
            $result['father_years'] = ($this->get_user_meta($student_id, 'father_years') != false ? $this->get_user_meta($student_id, 'father_years') : '');
            
            $result['father_company'] = ($this->get_user_meta($student_id, 'father_company') != false ? $this->get_user_meta($student_id, 'father_company') : '');
            
            $result['father_comapny_years'] = ($this->get_user_meta($student_id, 'father_comapny_years') != false ? $this->get_user_meta($student_id, 'father_comapny_years') : '');
            
            $result['father_company_income'] = ($this->get_user_meta($student_id, 'monthly_income') != false ? $this->get_user_meta($student_id, 'monthly_income') : '');
            
            $result['father_company_address'] = ($this->get_user_meta($student_id, 'father_work_address') != false ? $this->get_user_meta($student_id, 'father_work_address') : '');
            
            $result['father_monthly_income'] = ($this->get_user_meta($student_id, 'father_monthly_income_2') != false ? $this->get_user_meta($student_id, 'father_monthly_income_2') : '');
            
            $result['req_financial_assistance'] = $this->get_user_meta($student_id, 'financial_assistance');
            
            $result['special_circumstances'] = ($this->get_user_meta($student_id, 'circumstances') != false ? $this->get_user_meta($student_id, 'circumstances') : '');
            
            $result['school1_name'] = ($this->get_user_meta($student_id, 'previous_school_1') != false ? $this->get_user_meta($student_id, 'previous_school_1') : '');
            
            $result['school1_address'] = ($this->get_user_meta($student_id, 'school_history_address_1') != false ? $this->get_user_meta($student_id, 'school_history_address_1') : '');
            
            $result['school1_from'] = ($this->get_user_meta($student_id, 'from_1') != false ? $this->get_user_meta($student_id, 'from_1') : '');
            
            $result['school1_to'] = ($this->get_user_meta($student_id, 'to_1') != false ? $this->get_user_meta($student_id, 'to_1') : '');
            
            $result['school2_name'] = ($this->get_user_meta($student_id, 'previous_school_2') != false ? $this->get_user_meta($student_id, 'previous_school_2') : '');
            
            $result['school2_address'] = ($this->get_user_meta($student_id, 'school_history_address_2') != false ? $this->get_user_meta($student_id, 'school_history_address_2') : '');
            
            $result['school2_from'] = ($this->get_user_meta($student_id, 'from_2') != false ? $this->get_user_meta($student_id, 'from_2') : '');
            
            $result['school2_to'] = ($this->get_user_meta($student_id, 'to_2') != false ? $this->get_user_meta($student_id, 'to_2') : '');
            
            $result['school3_name'] = ($this->get_user_meta($student_id, 'previous_school_3') != false ? $this->get_user_meta($student_id, 'previous_school_3') : '');
            
            $result['school3_address'] = ($this->get_user_meta($student_id, 'school_history_address_3') != false ? $this->get_user_meta($student_id, 'school_history_address_3') : '');
            
            $result['school3_from'] = ($this->get_user_meta($student_id, 'from_3') != false ? $this->get_user_meta($student_id, 'from_3') : '');
            
            $result['school3_to'] = ($this->get_user_meta($student_id, 'to_3') != false ? $this->get_user_meta($student_id, 'to_3') : '');
            
            $result['ref1_name'] = ($this->get_user_meta($student_id, 'student_reference_fullname') != false ? $this->get_user_meta($student_id, 'student_reference_fullname') : '');
            
            $result['ref1_relationship'] = ($this->get_user_meta($student_id, 'student_reference_relationship') != false ? $this->get_user_meta($student_id, 'student_reference_relationship') : '');
            
            $result['ref1_company'] = ($this->get_user_meta($student_id, 'student_refernce_company') != false ? $this->get_user_meta($student_id, 'student_refernce_company') : '');
            
            $result['ref1_phone'] = ($this->get_user_meta($student_id, 'student_reference_phone') != false ? $this->get_user_meta($student_id, 'student_reference_phone') : '');
            
            $result['ref1_adress'] = ($this->get_user_meta($student_id, 'student_reference_adress') != false ? $this->get_user_meta($student_id, 'student_reference_adress') : '');
            
            $result['ref2_name'] = ($this->get_user_meta($student_id, 'student_reference_fullname2') != false ? $this->get_user_meta($student_id, 'student_reference_fullname2') : '');
            
            $result['ref2_relationship'] = ($this->get_user_meta($student_id, 'student_reference_relationship2') != false ? $this->get_user_meta($student_id, 'student_reference_relationship2') : '');
            
            $result['ref2_company'] = ($this->get_user_meta($student_id, 'student_refernce_company2') != false ? $this->get_user_meta($student_id, 'student_refernce_company2') : '');
            
            $result['ref2_phone'] = ($this->get_user_meta($student_id, 'student_reference_phone2') != false ? $this->get_user_meta($student_id, 'student_reference_phone2') : '');
            
            $result['ref2_address'] = ($this->get_user_meta($student_id, 'student_reference_adress2') != false ? $this->get_user_meta($student_id, 'student_reference_adress2') : '');
            
            $result['ref3_name'] = ($this->get_user_meta($student_id, 'student_reference_fullname3') != false ? $this->get_user_meta($student_id, 'student_reference_fullname3') : '');
            
            $result['ref3_relationship'] = ($this->get_user_meta($student_id, 'student_reference_relationship3') != false ? $this->get_user_meta($student_id, 'student_reference_relationship3') : '');
            
            $result['ref3_company'] = ($this->get_user_meta($student_id, 'student_refernce_company3') != false ? $this->get_user_meta($student_id, 'student_refernce_company3') : '');
            
            $result['ref3_phone'] = ($this->get_user_meta($student_id, 'student_reference_phone3') != false ? $this->get_user_meta($student_id, 'student_reference_phone3') : '');
            
            $result['ref3_address'] = ($this->get_user_meta($student_id, 'student_reference_adress3') != false ? $this->get_user_meta($student_id, 'student_reference_adress3') : '');
            
            $result['message'] = true;
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function student_delete()
    {
        $id = $this->input->get('id', true);
        $result = array();
        $result['message'] = false;
        if (! empty($id)) {
            
            $removeStudent = $this->db->query("DELETE FROM invantage_users WHERE id = " . $id);
            
            $removeStudent = $this->db->query("DELETE FROM user_meta WHERE user_id = " . $id);
            
            if ($removeStudent == TRUE) {
                
                $result['message'] = true;
            }
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function student_post()
    {
        $request = $this->parse_params();
        
        // required fields
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $street = $request->street;
        $unit = $request->unit;
        $city = $request->city;
        $phone = $request->phone;
        $nic = $request->nic;
        $class_id = $request->class_id;
        $school_id = $request->school_id;
        
        $result = array();
        $result['message'] = FALSE;
        
        if (! empty($first_name) && ! empty($last_name) && ! empty($street) && ! empty($unit) && ! empty($city) && ! empty($class_id) && ! empty($school_id)) {
            $id = $request->id;
            $section_id = $request->section_id;
            $semester_id = $request->semester_id;
            
            $province = $request->province;
            
            $postal_code = $request->postal_code;
            $dob = $request->dob;
            $enroll_date = $request->enroll_date;
            
            $mother_lang = $request->mother_lang;
            $add_lang = $request->add_lang;
            
            $father_name = $request->father_name;
            $father_nic = $request->father_nic;
            $father_profession = $request->father_profession;
            $father_years = $request->father_years;
            $father_company_name = $request->father_company_name;
            $father_company_years = $request->father_company_years;
            $father_company_income = $request->father_company_income;
            $father_work_address = $request->father_work_address;
            $father_monthly_income = $request->father_monthly_income;
            $req_financial_assistance = $request->req_financial_assistance == TRUE ? 1 : 0;
            $mode = strtolower(trim($request->mode));
            $special_circumstances = $request->special_circumstances;
            
            $school1_name = $request->school1_name;
            $school1_address = $request->school1_address;
            $school1_from = $request->school1_from;
            $school1_to = $request->school1_to;
            $school2_name = $request->school2_name;
            $school2_address = $request->school2_address;
            $school2_from = $request->school2_from;
            $school2_to = $request->school2_to;
            $school3_name = $request->school3_name;
            $school3_address = $request->school3_address;
            $school3_from = $request->school3_from;
            $school3_to = $request->school3_to;
            
            $ref1_name = $request->ref1_name;
            $ref1_address = $request->ref1_address;
            $ref1_company = $request->ref1_company;
            $ref1_phone = $request->ref1_phone;
            $ref1_relation = $request->ref1_relation;
            $ref2_name = $request->ref2_name;
            $ref2_address = $request->ref2_address;
            $ref2_company = $request->ref2_company;
            $ref2_phone = $request->ref2_phone;
            $ref2_relation = $request->ref2_relation;
            $ref3_name = $request->ref3_name;
            $ref3_address = $request->ref3_address;
            $ref3_company = $request->ref3_company;
            $ref3_phone = $request->ref3_phone;
            $ref3_relation = $request->ref3_relation;
            
            $sign = $request->sign;
            $date = $request->sign_date;
            
            if ($id == NULL || empty($id)) {
                $id = NULL;
            }
            
            $password = "";
            if (isset($request->password) && isset($request->repeat_password)) {
                $password = trim($request->password);
            }
            
            $this->operation->table_name = 'invantage_users';
            
            $user_id = $this->user->StudentInfo($id, $school_id, $first_name, $last_name, $street, $unit, $city, $province, $postal_code, $phone, $dob, $enroll_date, $nic, $mother_lang, $add_lang, $section_id, $class_id, $father_name, $father_nic, $father_profession, $father_years, $father_company_name, $father_company_years, $father_company_income, $father_work_address, $father_monthly_income, $req_financial_assistance, $special_circumstances, $school1_name, $school1_address, $school1_from, $school1_to, $school2_name, $school2_address, $school2_from, $school2_to, $school3_name, $school3_address, $school3_from, $school3_to, $ref1_name, $ref1_relation, $ref1_company, $ref1_phone, $ref1_address, $ref2_name, $ref2_relation, $ref2_company, $ref2_phone, $ref2_address, $ref3_name, $ref3_relation, $ref3_company, $ref3_phone, $ref3_address, $semester_id, $sign, $date, $mode, $password);
            
            if ($user_id) {
                
                $result['last_id'] = $user_id;
                $result['message'] = TRUE;
            }
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function student_promote_post()
    {
        $request = $this->parse_params();
        $data = $this->security->xss_clean(trim($request));
        $oldclass = $this->security->xss_clean(trim($request->old_class_id));
        $oldsection = $this->security->xss_clean(trim($request->old_section_id));
        $oldsemester = $this->security->xss_clean(trim($request->old_semester_id));
        $oldsession = $this->security->xss_clean(trim($request->old_session_id));
        $newclass = $this->security->xss_clean(trim($request->new_class_id));
        $newsection = $this->security->xss_clean(trim($request->new_section_id));
        $newsemester = $this->security->xss_clean(trim($request->new_semester_id));
        $newsessionid = $this->security->xss_clean(trim($request->new_session_id));
        
        $sresult = array();
        $sresult['message'] = false;
        
        if (! is_null($oldclass) && ! is_null($oldsection) && ! is_null($oldsemester) && ! is_null($newclass) && ! is_null($newsection) && ! is_null($newsemester) && ! is_null($newsessionid)) {
            
            $this->operation->table_name = 'semester_dates';
            $active_semester = $this->operation->GetByWhere(array(
                'session_id' => $oldsession,
                'semester_id' => $oldsemester
            ));
            
            $this->operation->table_name = 'student_semesters';
            
            // foreach ($request as $value) {
            foreach ($data as $svalue) {
                
                $resultlist = $this->operation->GetByWhere(array(
                    'class_id' => $oldclass,
                    'section_id' => $oldsection,
                    'semester_id' => $active_semester[0]->semester_id,
                    'student_id' => $svalue->id,
                    'status' => 'r',
                    'session_id' => $oldsession
                ));
                if (count($resultlist)) {
                    $studentresult = array(
                        'status' => 'u'
                    );
                    $this->operation->table_name = 'student_semesters';
                    
                    $id = $this->operation->Create($studentresult, $resultlist[0]->id);
                    
                    $this->operation->table_name = 'semester_dates';
                    $active_semester = $this->operation->GetByWhere(array(
                        'session_id' => $newsessionid,
                        'semester_id' => $newsemester
                    ));
                    $studentresult = array(
                        'class_id' => $newclass,
                        'section_id' => $newsection,
                        'semester_id' => $active_semester[0]->semester_id,
                        'student_id' => $svalue->id,
                        'status' => 'r',
                        'session_id' => $newsessionid
                    );
                    $this->operation->table_name = 'student_semesters';
                    
                    $id = $this->operation->Create($studentresult);
                    
                    if (count($id)) {
                        $sresult['message'] = true;
                    }
                }
            }
            // }
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
    }
    
    /**
     * Get evaualtion formula
     *
     * @access private
     */
    function evaluation_formula_get()
    {
        $session_id = $this->input->get('session_id');
        
        $this->operation->table_name = 'semester_dates';
        
        $active_semester = $this->operation->GetByWhere(array(
            'session_id' => $session_id,
            'status' => 'a'
        ));
        
        $this->operation->table_name = 'evaluation';
        
        $is_eva_found = $this->operation->GetByWhere(array(
            'status' => 'a',
            'semester_date_id' => $active_semester[0]->id
        ));
        
        $formula = array();
        if (count($is_eva_found)) {
            
            $eva_list = unserialize($is_eva_found[0]->option_value);
            
            foreach ($eva_list as $value) {
                
                $formula[] = array(
                    'slug' => $value['slug'],
                    'percent' => (int) $value['value'],
                    'title' => $value['title']
                );
            }
        }
        $this->response($formula, REST_Controller::HTTP_OK);
    }
    
    /**
     * Save evaualtion formula
     *
     * @access private
     */
    public function evaluation_formula_post()
    {
        $request = $this->parse_params();
        
        $evaualtionobj = $request->data;
        $session_id = $request->session_id;
        
        $formula = array();
        $result = array();
        $result['message'] = false;
        
        $check_extentions = array(
            'ass',
            'qui',
            'mid',
            'fin',
            'pra',
            'att',
            'orl',
            'beh'
        );
        if (count($evaualtionobj)) {
            foreach ($evaualtionobj as $key => $value) {
                if (in_array($this->security->xss_clean(html_escape($value->slug)), $check_extentions)) {
                    $formula[] = array(
                        'slug' => $this->security->xss_clean(html_escape($value->slug)),
                        'value' => $this->security->xss_clean(html_escape($value->percent)),
                        'title' => $this->security->xss_clean(html_escape($value->title))
                    );
                }
            }
            
            $option = array(
                'option_value' => serialize($formula)
            );
            
            $this->operation->table_name = 'semester_dates';
            
            $active_semester = $this->operation->GetByWhere(array(
                'session_id' => $session_id,
                'status' => 'a'
            ));
            
            $this->operation->table_name = 'evaluation';
            
            $is_eva_found = $this->operation->GetByWhere(array(
                'status' => 'a',
                'semester_date_id' => $active_semester[0]->id
            ));
            
            $id = $this->operation->Create($option, $is_eva_found[0]->id);
            
            if (count($id)) {
                $result['message'] = true;
            }
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    function evaluation_header_get()
    {
        $subject_id = $this->input->get('subject_id');
        $class_id = $this->input->get('class_id');
        $section_id = $this->input->get('section_id');
        //$semester_id = $this->input->get('semester_id');
        //$session_id = $this->input->get('session_id');
        $user_id = $this->input->get('user_id');
        $school_id  =$this->input->get('school_id');
        $quizlist = array();
        
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);

        $session_id = $active_session->id;
        $semester_id = $active_semester->semester_id;


        if (! empty($subject_id) && ! empty($semester_id) && ! empty($class_id) && ! empty($section_id) && ! empty($session_id)) {
        
          
             $role_id = FALSE;
            if ($role = $this->get_user_role($user_id)) {
                $role_id = $role->role_id;
            }

            if ($role_id == 4)
            {
                $query = $this->operation->GetByQuery("SELECT q.* FROM quiz q INNER JOIN semester s ON s.id = q.semester_id INNER JOIN sessions se ON se.id = q.session_id Where q.subject_id = " . $this->input->get('subject_id') . " AND q.class_id = " . $this->input->get('class_id') . " AND q.section_id = " . $this->input->get('section_id') . " AND q.tacher_uid = " . $user_id . " AND q.semester_id = " . $semester_id . " AND q.session_id = " . $session_id . "  order by q.quiz_term asc");
            }
            else
            {
                $query = $this->operation->GetByQuery("SELECT q.* FROM quiz q INNER JOIN semester s ON s.id = q.semester_id INNER JOIN sessions se ON se.id = q.session_id Where q.subject_id = " . $this->input->get('subject_id') . " AND q.class_id = " . $this->input->get('class_id') . " AND q.section_id = " . $this->input->get('section_id') . " AND q.semester_id = " . $semester_id . " AND q.session_id = " . $session_id . "  order by q.quiz_term asc");
            }
            if (count($query))
            {
                foreach ($query as $key => $value)
                {
                    $quizlist[] = array('id' => $value->id, 'name' => $value->qname, 'term_status' => $value->quiz_term, 'class' => $value->class_id, 'section' => $value->section_id, 'subject' => $value->subject_id, 'semesterid' => $value->semester_id, 'sessionid' => $value->session_id);
                }
            }
        }
        $this->response($quizlist, REST_Controller::HTTP_OK);
    }
    
    function quiz_evaluations_get()
    {
        $subject_id = $this->input->get('subject_id');
        $class_id = $this->input->get('class_id');
        $section_id = $this->input->get('section_id');
        //$semester_id = $this->input->get('semester_id');
        //$session_id = $this->input->get('session_id');
        //$student_id = $this->input->get('student_id');
        $user_id = $this->input->get('user_id');

        $school_id  =$this->input->get('school_id');
        $quizlist = array();
        
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);

        $session_id = $active_session->id;
        $semester_id = $active_semester->semester_id;
        
        $quizarray = array();
        $quizdetailarray = array();

        if (! empty($subject_id) && ! empty($semester_id) && ! empty($class_id) && ! empty($section_id) && ! empty($session_id))
        {
            //$quizlist = $this->GetQuizeListBySubject($this->input->get('subjectlist'), $this->input->get('inputsession'), $this->input->get('inputsemester'), $this->input->get('inputclassid'), $this->input->get('inputsectionid'));
            if ($this->input->get('studentid'))
            {
                $studentlist = $this->operation->GetByQuery('SELECT * FROM `student_semesters` where class_id = ' . $this->input->get('inputclassid') . " AND sectionid = " . $this->input->get('inputsectionid') . " AND semesterid = " . $this->input->get('inputsemester') . " AND  sessionid = " . $this->input->get('inputsession') . " AND studentid = " . $this->input->get('studentid') . " AND status = 'r'");
            }
            else
            {

                $this->operation->table_name = 'semester_dates';
                $semester_status = $this->operation->GetByWhere(array('session_id' => $session_id, 'semester_id' => $semester_id));
                $sem_status = 'u';

                if ($semester_status[0]->status == 'a')
                {
                    $sem_status = 'r';
                }
                //$studentlist = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` where classid = ' . $this->input->get('inputclassid') . " AND sectionid = " . $this->input->get('inputsectionid') . " AND semesterid = " . $this->input->get('inputsemester') . " AND  sessionid = " . $this->input->get('inputsession') . " AND status = '" . $sem_status . "'");
                $studentlist = $this->operation->GetByQuery('SELECT s.* FROM `student_semesters` as s INNER JOIN  invantage_users AS i ON s.student_id = i.id where s.class_id = ' . $class_id . " AND s.section_id = " . $section_id . " AND s.semester_id = " . $semester_id . " AND s.session_id = " . $session_id . " AND s.status = '" . $sem_status . "' ORDER BY i.screenname ASC ");
            }
            if (count($studentlist))
            {

                foreach ($studentlist as $key => $value)
                {
                    $studentprogress = $this->operation->GetByQuery('SELECT q.id,q.quiz_term FROM `quiz` q where subject_id =' . $subject_id . " AND class_id = " . $class_id . " and section_id = " . $section_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . "  order by quiz_term");
                    if (count($studentprogress))
                    {
                        $quizdetailarray = array();

                        foreach ($studentprogress as $key => $spvalue)
                        {

                           
                            //$studentmidresult = $this->operation->GetRowsByQyery('SELECT * FROM `quizzes_marks`  where student_id = '.$value->studentid.' AND subject_id =' . $this->input->get('subjectlist') . " AND class_id = " . $this->input->get('inputclassid') . " and section_id = " . $this->input->get('inputsectionid') . " AND semester_id = " . $this->input->get('inputsemester') . " AND session_id = " . $this->input->get('inputsession') . " AND quiz_id = ".$spvalue->id." "); 
                            $studentmidresult = $this->operation->GetByQuery('SELECT * FROM `quizzes_marks`  where student_id = '.$value->student_id.' AND subject_id =' . $subject_id . " AND class_id = " . $class_id . " and section_id = " . $section_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " AND quiz_id = ".$spvalue->id." "); 
                            if(count($studentmidresult))
                            {

                                foreach ($studentmidresult as $key => $rval)
                                {
                                    $marks = $rval->marks;
                                }
                                $quizdetailarray[] = array('correntanswer' => 0, 'total_question' => 0, 'quiz_id' => $spvalue->id, 'term_status' => $spvalue->quiz_term, 'totalpercent' => $marks);
                            
                            }
                            else
                            {
                                $quizdetailarray[] = array('correntanswer' => 0, 'total_question' => 0, 'quiz_id' => $spvalue->id, 'term_status' => $spvalue->quiz_term, 'totalpercent' => 0);
                            }
                            
                        }
                    }
                 
                    $termlist = $this->operation->GetByQuery('SELECT * FROM term_exam_result  where subject_id = ' . $subject_id . ' AND student_id= ' . $value->student_id . " AND session_id = " . $session_id . " AND semester_id = " . $semester_id . " order by termid asc");
                    $student_result = array();
                    if (count($termlist) == 2)
                    {
                        foreach ($termlist as $key => $tvalue)
                        {
                            $studenmark = '';
                            $marks = is_null($tvalue->marks) ? 0 : $tvalue->marks;
                            $student_result[] = array('marks' => $marks);
                        }
                    }
                    if (count($termlist) == 1)
                    {
                        if ($termlist[0]->termid == 1)
                        {
                            $studenmark = '';
                            $marks = is_null($termlist[0]->marks) ? 0 : $termlist[0]->marks;
                            $student_result[] = array('marks' => $marks,);
                            $student_result[] = array('marks' => 0,);
                        }
                        if ($termlist[0]->termid == 2)
                        {
                            $studenmark = '';
                            $marks = is_null($termlist[0]->marks) ? 0 : $termlist[0]->marks;
                            $student_result[] = array('marks' => 0,);
                            $student_result[] = array('marks' => $marks,);
                        }
                    }
                    if (count($termlist) == 0)
                    {
                        $student_result[] = array('marks' => 0);
                        $student_result[] = array('marks' => 0);
                    }
                    
                    $quizarray[] = array('student_id' => $value->student_id, 'screenname' => $this->GetStudentName($value->student_id), 'score' => $quizdetailarray, 'term_result' => $student_result);
                     //print_r($quizarray);
                }
            }

            else
            {
                
                if($user_id)
                {
                    $is_subject_found = $this->operation->GetByQuery('SELECT * FROM `schedule` where subject_id = ' . $subject_id . " AND class_id = " . $class_id . " AND section_id = " . $section_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " AND teacher_uid =" . $user_id);
                }
                else
                {
                    $is_subject_found = $this->operation->GetByQuery('SELECT * FROM `schedule` where subject_id = ' . $subject_id . " AND class_id = " . $class_id . " AND section_id = " . $section_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id);
                }
                if (count($is_subject_found))
                {
                    foreach ($is_subject_found as $key => $value)
                    {
                        $studentlist = $this->operation->GetByQuery('SELECT * FROM `student_semesters` where class_id = ' . $class_id . " AND section_id = " . $section_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " AND status = 'r'");
                        if (count($studentlist))
                        {
                            foreach ($studentlist as $key => $value)
                            {
                                $termlist = $this->operation->GetByQuery('SELECT * FROM term_exam_result  where subject_id = ' . $subject_id . " AND class_id = " . $class_id . " AND section_id = " . $section_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " AND student_id= " . $value->student_id . " order by termid asc");
                                $student_result = array();
                                if (count($termlist) == 2)
                                {
                                    foreach ($termlist as $key => $tvalue)
                                    {
                                        $studenmark = '';
                                        $marks = is_null($tvalue->marks) ? 0 : $tvalue->marks;
                                        $student_result[] = array('marks' => $marks);
                                    }
                                }
                                if (count($termlist) == 1)
                                {
                                    if ($termlist[0]->termid == 1)
                                    {
                                        $studenmark = '';
                                        $marks = is_null($termlist[0]->marks) ? 0 : $termlist[0]->marks;
                                        $student_result[] = array('marks' => $marks);
                                        $student_result[] = array('marks' => 0);
                                    }
                                    if ($termlist[0]->termid == 2)
                                    {
                                        $studenmark = '';
                                        $marks = is_null($termlist[0]->marks) ? 0 : $termlist[0]->marks;
                                        $student_result[] = array('marks' => 0);
                                        $student_result[] = array('marks' => $marks);
                                    }
                                }
                                if (count($termlist) == 0)
                                {
                                    $student_result[] = array('marks' => 0);
                                    $student_result[] = array('marks' => 0);
                                }
                                $quizarray[] = array('studentid' => $value->student_id, 'student' => $this->GetStudentName($value->student_id),'screenname' => $this->GetStudentName($value->student_id), 'term_result' => $student_result, 'score' => [],);
                            }
                        }
                    }
                }
            }
        }
        
        
       
        
        
        $this->response($quizarray, REST_Controller::HTTP_OK);
    }

    function GetStudentName($studentid)
    {
        return parent::getUserMeta($studentid, 'sfullname') . " " . parent::getUserMeta($studentid, 'slastname');
    }
    function quiz_evaluation_details_get()
    {
        $quiz_id = $this->input->get('quizid');
        $student_id = $this->input->get('student_id');
        
        $quizdetailarray = array();
        if (! is_null($student_id) && ! is_null($quiz_id)) {
            $quiz_questions = $this->operation->GetByQuery('SELECT * FROM quiz_questions  WHERE quizeid = ' . $quiz_id . ' ORDER BY id ASC');
            if (count($quiz_questions)) {
                foreach ($quiz_questions as $key => $value) {
                    $optionarray = array();
                    
                    $quiz_options = $this->operation->GetByQuery('SELECT qo.*,qp.questionid FROM quiz_options qp INNER JOIN qoptions qo On qo.id = qp.qoption_id   WHERE qp.questionid = ' . $value->id . ' ORDER BY id ASC');
                    if (count($quiz_options)) {
                        $correct_index = 1;
                        $i = 1;
                        foreach ($quiz_options as $key => $ovalue) {
                            $is_correct_answer_matched = $this->operation->GetByQuery('SELECT * FROM correct_option  WHERE question_id =' . $ovalue->questionid);
                            $option_value = '';
                            if ($value->type == 't') {
                                
                                $option_value = $ovalue->option_value;
                            } else {
                                $thumbname = explode('.', $ovalue->option_value);
                                $option_value = base_url() . 'upload/option_images/' . $thumbname[0] . '_thumb.' . $thumbname[1];
                            }
                            
                            if ($is_correct_answer_matched[0]->correct_id == $ovalue->id) {
                                $correct_index = 1;
                            } else {
                                $correct_index = 0;
                            }
                            
                            $optionarray[] = array(
                                'optionid' => $ovalue->id,
                                'optionitem' => $option_value,
                                'iscorrect' => ($correct_index == 1 ? 1 : 0)
                            );
                        }
                    }
                    $selectedoption = $this->get_quiz_option($student_id, $quiz_id, $value->id);
                    $thumbname = '';
                    if (! is_null($value->img_src)) {
                        $thumbname = explode('.', $value->img_src);
                    }
                    $quizdetailarray[] = array(
                        'question' => $value->question,
                        'qtype' => $value->type,
                        'thumbnail_src' => (count($thumbname) == 2 ? base_url() . 'upload/quiz_images/' . $thumbname[0] . '_thumb.' . $thumbname[1] : ''),
                        'options' => $optionarray,
                        'selectedoption' => (int) $selectedoption[0]->optionid
                    );
                }
            }
        }
        $this->response($quizdetailarray, REST_Controller::HTTP_OK);
    }
    
    // region Session
    function session_get()
    {
        $session_id = $this->input->get('session_id');
        
        $sessionarray = array();
        $this->operation->table_name = 'sessions';
        
        if (! empty($session_id)) {
            $sessionlist = $this->operation->GetByWhere(array(
                'id' => $session_id
            ));
            if (count($sessionlist)) {
                $value = $sessionlist[0];
                //foreach ($sessionlist as $value) {
                $sessionarray = array(
                    'id' => $value->id,
                    'from' => date('m/d/Y', strtotime($value->datefrom)),
                    'to' => date('m/d/Y', strtotime($value->dateto)),
                    'status' => $value->status
                );
                //}
            }
        }
        $this->response($sessionarray, REST_Controller::HTTP_OK);
    }
    
    function sessions_get()
    {
        $this->operation->table_name = 'sessions';
        $school_id = $this->input->get('school_id');
        $sessionarray = array();
        if ($this->input->get('inputsessionid'))
        {
            $sessionlist = $this->operation->GetByWhere(array('id' => $this->input->get('inputsessionid')));
            if (count($sessionlist))
            {
                foreach ($sessionlist as $key => $value)
                {
                    $sessionarray = array('id' => $value->id, 'name' => date('m/d/Y', strtotime($value->datefrom)), 'to' => date('m/d/Y', strtotime($value->dateto)), 'status' => $value->status,);
                }
            }
        }
        else
        {
           
            $sessionlist = $this->operation->GetByWhere(array('school_id' => $school_id));
            $current_date = date('Y-m-d');
            $active_status = 'Active';
            if (count($sessionlist))
            {
                foreach ($sessionlist as $key => $value)
                {
                    if(date('Y-m-d', strtotime($value->dateto))<$current_date)
                    {
                        $active_status = "Inactive";
                    }
                    else
                    {
                        $active_status = "Active";
                    }
                    $sessionarray[] = array('id' => $value->id, 'name' => date('M d, Y', strtotime($value->datefrom)) . ' - ' . date('M d, Y', strtotime($value->dateto)), 'from' => date('m/d/Y', strtotime($value->datefrom)), 'to' => date('m/d/Y', strtotime($value->dateto)), 'status' => $value->status,'show' =>$active_status,);
                }
            }
        }

        $this->response($sessionarray, REST_Controller::HTTP_OK);
    }
    
    function session_post()
    {
        
        $request = $this->parse_params();
        
        $inputstartdate = $request->start_date;
        $inputenddate = $request->end_date;
        $inputsessionid = $request->session_id;
        $school_id = $request->school_id;
        
        $sresult = array();
        $sresult['message'] = false;
        $check_valid['check_validation'] = true;
        $current_date = date('Y-m-d');

        if (!is_null($inputstartdate) && !is_null($inputenddate))
        {
            
            // Check start date
            if (!is_null($inputsessionid) && !empty($inputsessionid))
            {
                $sessionarray = array('datefrom' => date('Y-m-d', strtotime($inputstartdate)), 'dateto' => date('Y-m-d', strtotime($inputenddate)), 'datetime' => date('Y-m-d'), 'school_id' => $school_id);
                $id = $this->operation->Create($sessionarray, $inputsessionid);
                if (count($id))
                {
                    $sresult['message'] = true;
                }
            }
            else
            {
                // Check Past date
                
                $start_date = date('Y-m-d', strtotime($inputstartdate));
                $end_date = date('Y-m-d', strtotime($inputenddate));

                if($start_date<$current_date && $end_date<$current_date)
                {
                    $sresult['date_not_match'] = 'DateNotMatch';

                }
                else
                {
                    $inputstartdate = date('Y-m-d', strtotime($inputstartdate));
                    $inputenddate = date('Y-m-d', strtotime($inputenddate));  
                    $record_check = $this->operation->GetByQuery("SELECT * FROM sessions WHERE  school_id =" . $school_id);
                    
                    if(count($record_check))
                    {
                        
                        foreach ($record_check as $key => $value)
                        {
                            $start_date = date('Y-m-d', strtotime($value->datefrom));
                            $end_date = date('Y-m-d', strtotime($value->dateto));
                            $record_datefrom = $this->operation->GetByQuery("SELECT * FROM sessions WHERE '".$inputstartdate."'>='".$start_date."' AND '".$inputstartdate."'<='".$end_date."' AND id =  ".$value->id);
                            if(count($record_datefrom))
                            {

                                $sresult['exists'] = 'Exists';
                                $check_valid['check_validation'] = false;
                            }
                            $record_dateto = $this->operation->GetByQuery("SELECT * FROM sessions WHERE '".$inputenddate."'>='".$start_date."' AND '".$inputenddate."'<='".$end_date."' AND id =  ".$value->id);
                            if(count($record_dateto))
                            {
                                $sresult['exists'] = 'Exists';
                                $check_valid['check_validation'] = false;
                            }
                        }
                        if($check_valid['check_validation'])
                        {
                            $this->operation->table_name = 'sessions';
                            $sessionarray = array('datefrom' => date('Y-m-d', strtotime($inputstartdate)), 'dateto' => date('Y-m-d', strtotime($inputenddate)), 'datetime' => date('Y-m-d'), 'status' => 'i', 'school_id' => $school_id);
                            $id = $this->operation->Create($sessionarray);
                            if (count($id))
                            {
                                $sresult['message'] = true;
                            }
                        }
                    }
                }
                
            }
            
        }

        $this->response($sresult, REST_Controller::HTTP_OK);
    }
    
    function session_delete()
    {
        $sresult = array();
        
        $postdata = file_get_contents("php://input");
            
        $request = json_decode($postdata);
        
        $session_id =  $request->session_id;
        $sresult['message'] = false;
        
         
        if (! empty($session_id)) {
            $this->operation->table_name = 'sessions';
            $this->operation->Remove($session_id);
            $sresult['message'] = true;
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
    }
   
    function subjectRemove_get()
    {
        $sresult = array();
        $sresult['message'] = false;
        $subject_id = $this->input->get('id');
        if (! empty($subject_id)) {
            $this->operation->table_name = 'subjects';
            $this->operation->Remove($subject_id);
            $sresult['message'] = true;
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
    }
    function active_session_get()
    {
        $res = FALSE;
        
        $school_id = $this->input->get('school_id');
        
        if (! empty($school_id)) {
            $res = $this->operation->GetByQuery("SELECT  * FROM sessions WHERE status = 'a' AND school_id =" . $school_id);
        }
        
        $this->response($res, REST_Controller::HTTP_OK);
    }
    
    /**
     * Activate session
     */
    function active_session_post()
    {
        $request = $this->parse_params();
        
        $session_id = $this->security->xss_clean(trim($request->session_id));
        
        $sresult['message'] = false;
        
        if ($session_id != 0 && is_numeric($session_id)) {
            $this->db->query("UPDATE sessions SET status = 'i'");
            
            $this->operation->table_name = 'sessions';
            $session_data = array(
                'datetime' => date('Y-m-d'),
                'status' => 'a'
            );
            
            $id = $this->operation->Create($session_data, $session_id);
            
            if (count($id)) {
                $sresult['message'] = true;
            }
        }
        $this->set_response($sresult, REST_Controller::HTTP_OK);
    }
    
    // engregion
    
    // region Lesson sets
    private function update_lesson_set_dates($school_id)
    {
        $updated = FALSE;
        $active_session = $this->get_active_session($school_id);
        if ($active_session) {
            $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
            if ($active_semester) {
                $this->operation->table_name = 'classes';
                $classes = $this->operation->GetByWhere(array(
                    'school_id' => $school_id
                ));
                if (count($classes)) {
                    foreach ($classes as $class) {
                        if ($this->init_lesson_set_dates($class->id, $active_semester->semester_id, $active_session->id, $user_id)) {
                            $updated = TRUE;
                        }
                    }
                }
            }
        }
        return $updated;
    }
    
    function init_lesson_set_dates($class_id, $semester_id, $session_id, $user_id)
    {
        $updated = false;
        
        $this->operation->table_name = 'classes';
        $class_details = $this->operation->GetByWhere(array(
            'id' => $class_id
        ), true);
        
        if (count($class_details)) {
            $current_semesterdate = $this->get_active_semester_dates($class_details->school_id);
        }
        
        $is_lesson_sets_found = $this->operation->GetByQuery("SELECT sem.set_id, sem.unique_code FROM semester_lesson_plan sem WHERE sem.active=1 AND sem.class_id = " . $class_id . ' AND sem.semester_id =' . $semester_id . ' AND sem.session_id =' . $session_id . ' GROUP BY sem.set_id ORDER BY sem.preference ASC');
        
        if (count($current_semesterdate) && count($is_lesson_sets_found)) {
            
            $holidays = $this->get_holidays($class_details->school_id); // find holidays dates
            $start_date = date('Y-m-d', strtotime($current_semesterdate[0]->start_date)); // find semester start date
            $end_date = date('Y-m-d', strtotime($current_semesterdate[0]->end_date)); // find semester end date
            
            if (strtotime($start_date) <= strtotime($end_date)) {
                $interim_ls_date = $start_date;
                $id = 0;
                foreach ($is_lesson_sets_found as $set) {
                    
                    $temp_date = $this->get_next_working_date($holidays, $interim_ls_date);
                    
                    if ($temp_date) {
                        
                        $this->operation->table_name = TABLE_LESSON_SET_DATES;
                        $is_date_found = $this->operation->GetByWhere(array(
                            'set_id' => $set->set_id,
                            'unique_code' => $set->unique_code
                        ));
                        
                        $this->operation->table_name = TABLE_LESSON_SET_DATES;
                        
                        if (count($is_date_found)) {
                            
                            $newdata = array(
                                'date' => $temp_date,
                                'updated' => date("Y-m-d H:i:s"),
                                'user_id' => $user_id
                            );
                            
                            $id = $this->operation->Create($newdata, $is_date_found[0]->id);
                        } else {
                            $newdata = array(
                                'date' => $temp_date,
                                'set_id' => $set->set_id,
                                'class_id' => $class_id,
                                'semester_id' => $semester_id,
                                'session_id' => $session_id,
                                'unique_code' => $set->unique_code,
                                'updated' => date("Y-m-d H:i:s"),
                                'created' => date("Y-m-d H:i:s"),
                                'active' => 1,
                                'user_id' => $user_id
                            );
                            
                            $id = $this->operation->Create($newdata);
                        }
                        
                        if ($id) {
                            $updated = true;
                        }
                    }
                    
                    $interim_ls_date = date("Y-m-d", strtotime("+1 day", strtotime($temp_date)));
                }
            }
        }
        return $updated;
    }
    
    function lesson_dates_get()
    {
        $user_id = $this->input->get('user_id');
        
        $class_id = $this->input->get('class_id');
        
        $semester_id = $this->input->get('semester_id');
        
        $session_id = $this->input->get('session_id');
        
        $result = array();
        
        if (! is_null($class_id) && ! is_null($semester_id) && ! is_null($session_id)) {
            
            $is_lesson_found = $this->operation->GetByQuery("SELECT ld.*, sem.preference FROM " . TABLE_LESSON_SET_DATES . " ld INNER JOIN semester_lesson_plan sem ON ld.set_id=sem.set_id WHERE ld.active=1 AND sem.active=1 AND ld.class_id = " . $class_id . ' AND ld.semester_id =' . $semester_id . ' AND ld.session_id =' . $session_id . ' GROUP BY ld.set_id ORDER BY ld.date, sem.preference ASC');
            
            if (! count($is_lesson_found)) {
                // Generate it
                
                if ($this->init_lesson_set_dates($class_id, $semester_id, $session_id, $user_id)) {
                    
                    $is_lesson_found = $this->operation->GetByQuery("SELECT ld.*, sem.preference FROM " . TABLE_LESSON_SET_DATES . " ld INNER JOIN semester_lesson_plan sem ON ld.set_id=sem.set_id WHERE ld.active=1 AND sem.active=1 AND ld.class_id = " . $class_id . ' AND ld.semester_id =' . $semester_id . ' AND ld.session_id =' . $session_id . ' GROUP BY ld.set_id ORDER BY ld.date, sem.preference ASC');
                }
            }
            
            if (count($is_lesson_found)) {
                
                foreach ($is_lesson_found as $set) {
                    $lessons = array();
                    if ($set->set_id) {
                        
                        $lessons = $this->operation->GetByQuery("SELECT sem.topic,sem.concept,sem.subject_id,sem.type,sem.preference,sub.subject_name FROM semester_lesson_plan sem INNER JOIN " . TABLE_LESSON_SET_DATES . " ld  ON ld.set_id=sem.set_id INNER JOIN subjects sub ON sem.subject_id=sub.id WHERE sem.class_id = " . $class_id . ' AND sem.set_id =' . $set->set_id . ' AND sem.semester_id =' . $semester_id . ' AND sem.session_id =' . $session_id . ' ORDER BY sem.preference ASC');
                    }
                    
                    $lessonarray = array(
                        'id' => $set->id,
                        'date' => $set->date,
                        'set_id' => $set->set_id,
                        'set_lessons' => $lessons,
                        'preference' => $set->preference
                    );
                    $result[] = $lessonarray;
                }
            }
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    public function lesson_dates_post()
    {
        try {
            
            $request = $this->parse_params();
            
            //$data = json_decode(stripslashes($this->input->post('data')));
            $class_id = $request->class_id;
            $semester_id = $request->semester_id;
            $session_id = $request->session_id;
            $user_id = $request->user_id;
            $data = $request->data;
            
            /*
             * $request = $this->parse_params();
             *
             *
             * $data = $request->data;
             * $class_id = $request->class_id;
             * $semester_id = $request->semester_id;
             * $session_id = $request->session_id;
             * $user_id = $request->user_id;
             */
            
            if (empty($class_id) || empty($semester_id) || empty($session_id) || empty($user_id)) {
                $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
                return;
            }
            
            $result = array();
            $result['message'] = FALSE;
            $i_id = 0;
            $i_date = 1;
            
            foreach ($data as $value) {
                
                if (intval($value[$i_id]) && ! empty($value[$i_date])) {
                    $newrec = array(
                        'user_id' => $user_id,
                        'date' => date('Y-m-d', strtotime($value[$i_date])),
                        'updated' => date("Y-m-d H:i")
                    );
                    
                    $this->operation->table_name = TABLE_LESSON_SET_DATES;
                    $id = $this->operation->Create($newrec, $value[$i_id]);
                    if ($id) {
                        $result['message'] = TRUE;
                    }
                }
            }
            
            $this->response($result, REST_Controller::HTTP_OK);
        } catch (Exception $e) {}
    }
    
    public function export_lesson_dates_get()
    {
        $class_id = $this->input->get('class_id');
        // $subject_id = $this->input->get('subject_id');
        $semester_id = $this->input->get('semester_id');
        $session_id = $this->input->get('session_id');
        
        if (empty($class_id) || empty($semester_id) || empty($session_id)) {
            
            $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            exit();
        }
        
        $result = array();
        
        require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php');
        
        require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
        
        $objectPHPExcel = new PHPExcel();
        
        if (! is_null($class_id) && ! is_null($semester_id) && ! is_null($session_id)) {
            
            $is_lesson_found = $this->operation->GetByQuery("SELECT ld.*, sem.preference FROM " . TABLE_LESSON_SET_DATES . " ld INNER JOIN semester_lesson_plan sem ON ld.set_id=sem.set_id WHERE ld.active=1 AND sem.active=1 AND sem.class_id = " . $class_id . ' AND sem.semester_id =' . $semester_id . ' AND sem.session_id =' . $session_id . ' GROUP BY sem.set_id ORDER BY ld.date, sem.preference ASC');
            
            if (! count($is_lesson_found)) {
                // Generate it
                
                if ($this->init_lesson_set_dates($class_id, $semester_id, $session_id, $user_id)) {
                    
                    $is_lesson_found = $this->operation->GetByQuery("SELECT ld.*, sem.preference FROM " . TABLE_LESSON_SET_DATES . " ld INNER JOIN semester_lesson_plan sem ON ld.set_id=sem.set_id WHERE ld.active=1 AND sem.active=1 AND sem.class_id = " . $class_id . ' AND sem.semester_id =' . $semester_id . ' AND sem.session_id =' . $session_id . ' GROUP BY sem.set_id ORDER BY ld.date, sem.preference ASC');
                }
            }
            
            if (count($is_lesson_found)) {
                
                ob_end_clean();
                ob_start();
                
                $class = $this->operation->GetByQuery("SELECT * FROM classes WHERE id=" . $class_id);
                
                $objectPHPExcel->getProperties()->setCreator("");
                $objectPHPExcel->getProperties()->setLastModifiedBy("");
                $objectPHPExcel->getProperties()->setTitle("");
                $objectPHPExcel->getProperties()->setSubject("");
                $objectPHPExcel->getProperties()->setDescription("");
                $objectPHPExcel->setActiveSheetIndex(0);
                $objectPHPExcel->getActiveSheet()->SetCellValue('A1', $class[0]->grade);
                $objectPHPExcel->getActiveSheet()->SetCellValue('B1', 'Semester lesson plan ');
                
                $objectPHPExcel->getActiveSheet()->SetCellValue('A2', 'Date');
                $objectPHPExcel->getActiveSheet()->SetCellValue('B2', 'Set Id');
                $objectPHPExcel->getActiveSheet()->SetCellValue('C2', 'Set Lessons');
                $objectPHPExcel->getActiveSheet()->SetCellValue('D2', 'Order');
                
                $rows = 3;
                
                foreach ($is_lesson_found as $set) {
                    $setDesc = '';
                    
                    if ($set->set_id) {
                        $lessons = $this->operation->GetByQuery("SELECT sem.topic,sem.preference,sub.subject_name FROM semester_lesson_plan sem INNER JOIN " . TABLE_LESSON_SET_DATES . " ld  ON ld.set_id=sem.set_id INNER JOIN subjects sub ON sem.subject_id=sub.id WHERE sem.class_id = " . $class_id . ' AND sem.set_id =' . $set->set_id . ' AND sem.semester_id =' . $semester_id . ' AND sem.session_id =' . $session_id . ' ORDER BY sem.preference ASC');
                        
                        foreach ($lessons as $lesson) {
                            if ($setDesc != '') {
                                $setDesc .= ', ';
                            }
                            $setDesc .= $lesson->topic . ' (' . $lesson->subject_name . ')';
                        }
                    }
                    
                    $objectPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $set->date);
                    $objectPHPExcel->getActiveSheet()->SetCellValue('B' . $rows, $set->set_id);
                    $objectPHPExcel->getActiveSheet()->SetCellValue('C' . $rows, $setDesc);
                    $objectPHPExcel->getActiveSheet()->SetCellValue('D' . $rows, $set->preference);
                    $rows ++;
                }
            }
        }
        
        $filename = 'task exported on' . " ." . 'csv';
        $objectPHPExcel->getActiveSheet()->setTitle("Lesson Set Date Plan");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        
        // If you're serving to IE over SSL, then the following may be needed
        
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();
        $response = array(
            'op' => 'ok',
            'class' => $class[0]->grade,
            'date' => date('M-d-Y'),
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );
        
        $this->response($response, REST_Controller::HTTP_OK);
        exit();
    }
    
    function lesson_sets_get()
    {
        $user_id = $this->input->get('user_id');
        
        // $school_id = $this->input->get('school_id');
        
        $class_id = $this->input->get('class_id');
        
        $semester_id = $this->input->get('semester_id');
        
        $session_id = $this->input->get('session_id');
        
        $result = array();
        $set_array = array();
        
        if (! is_null($class_id) && ! is_null($semester_id) && ! is_null($session_id)) {
            
            $is_lesson_found = $this->operation->GetByQuery("SELECT sem.*, sub.subject_name FROM semester_lesson_plan sem  INNER JOIN subjects sub ON sub.id=sem.subject_id WHERE sem.active=1 AND sem.class_id = " . $class_id . ' AND sem.semester_id =' . $semester_id . ' AND sem.session_id =' . $session_id . ' ORDER BY sem.preference ASC');
            
            if (count($is_lesson_found)) {
                
                $lessonarray = array();
                
                foreach ($is_lesson_found as $lesson) {
                    //if ($lesson->id > 0 && $lesson->set_id > 0) {
                    // Removed set_id condition to include new lessons which are added after sync of default lesson plan
                    if ($lesson->id > 0) {
                        $lessonarray = array(
                            'id' => $lesson->id,
                            'unique_code' => $lesson->unique_code,
                            'subject_id' => $lesson->subject_id,
                            'subject_name' => $lesson->subject_name,
                            'topic' => $lesson->topic,
                            'content' => $lesson->content,
                            'type' => $lesson->type,
                            'set_id' => $lesson->set_id,
                            'preference' => $lesson->preference
                        );
                        $set_array[$lesson->set_id][] = $lessonarray;
                    }
                }
                
                if (count($set_array)) {
                    foreach ($set_array as $set) {
                        foreach ($set as $set_lesson) {
                            $result[] = $set_lesson;
                        }
                    }
                }
            }
        }
        
        $this->response($result, REST_Controller::HTTP_OK);
    }
    
    public function lesson_sets_post()
    {
        
        $request = $this->parse_params();
        $user_id = $this->security->xss_clean(trim($request->user_id));
        // $class_id = $this->security->xss_clean(trim($request->class_id));
        // $semester_id = $this->security->xss_clean(trim($request->semester_id));
        // $session_id = $this->security->xss_clean(trim($request->session_id));
        $schedulardata = $request->data;
        
        $sresult = array();
        $sresult['message'] = false;
        
        $this->operation->table_name = 'semester_lesson_plan';
        
        if (count($schedulardata)) {
            
            foreach ($schedulardata as $value) {
                $lesson_set = $this->operation->GetByQuery("SELECT id FROM semester_lesson_plan WHERE id=" . $this->db->escape($value->lesson_id));
                
                if (count($lesson_set)) {
                    
                    $data = array(
                        'user_id' => $user_id,
                        'set_id' => $value->new_set_id,
                        'preference' => $value->preference,
                        'updated' => date('Y-m-d H:i:s')
                    );
                    
                    $this->operation->Create($data, $value->lesson_id);
                    
                    $sresult['message'] = true;
                }
            }
        }
        
        $this->response($sresult, REST_Controller::HTTP_OK);
    }
    
    // endregion
    
    // region devices
    public function device_status_get()
    {
        $data = $this->operation->GetByQuery("SELECT ts.*,inv.screenname, c.grade  FROM tablet_status ts
                INNER JOIN invantage_users inv on inv.username=ts.current_student_id INNER JOIN  classes c on ts.school_id=c.school_id group by ts.mac_address");
        
        $data_array = array();
        if (count($data)) {
            foreach ($data as $value) {
                
                $data_array[] = array(
                    'id' => $value->id,
                    'device_Name' => $value->device_name,
                    'mac_Address' => $value->mac_address,
                    'last_connected' => $value->last_connected,
                    'student_Name' => $value->screenname,
                    'grade' => $value->grade,
                    'blocked' => $value->blocked
                );
            }
        }
        $this->set_response($data_array, REST_Controller::HTTP_OK);
    }
    
    /**
     * Get Block user module
     *
     * @access private
     */
    function block_device_post()
    {
        $data = $this->parse_params();
        
        $result = array();
        $result['message'] = false;
        
        $isblock = trim($data->blocked);
        $id = trim($data->id);
        
        $blocker = array(
            'blocked' => ($isblock == false ? 0 : 1)
        );
        
        $this->operation->table_name = 'tablet_status';
        $id = $this->operation->Create($blocker, $id);
        
        if (count($id)) {
            $result['message'] = true;
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    // endregion
    
    // region Principal Wizard
    
    function default_student_grades_get(){
        
        $result = array();
        $params = $this->parse_params();
        
        $result = $this->get_default_grades();
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    
    function default_kg_subject_get(){
        
        $result = array();
        $params = $this->parse_params();
        
        $this->set_response($this->get_default_subjects('kindergarten'), REST_Controller::HTTP_OK);
    }
    
    function default_semesters_get(){
        
        $result = array();
        $params = $this->parse_params();
        
        $result = $this->get_default_semesters();
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function school_wizard_post()
    {
        try {
            /*
             $result['message'] = false;
             
             $this->form_validation->set_rules('session_start', 'Validate date', 'required');
             
             $this->form_validation->set_rules('session_end', 'Validate date', 'required');
             
             $this->form_validation->set_rules('semester_start', 'Validate date', 'required');
             
             $this->form_validation->set_rules('semester_end', 'Validate date', 'required');
             
             if ($this->form_validation->run() == FALSE) {
             
             $result['message'] = $this->form_validation->run();
             } else
             */
             {
                 
                 $session_start = $this->input->post('session_start');
                 
                 $session_end = $this->input->post('session_end');
                 
                 $semester_start = $this->input->post('semester_start');
                 
                 $semester_end = $this->input->post('semester_end');
                 
                 $current_semester = $this->input->post('current_semester');
                 
                 $class_list = json_decode($this->input->post('grade'));
                 
                 $section_list = json_decode($this->input->post('section_list'));
                 
                 $default_kindergarten_subject = json_decode($this->input->post('default_kindergarten_subject'));
                 
                 $default_subjects = json_decode($this->input->post('default_subjects'));
                 
                 $subjects = array();
                 
                 if (count($default_kindergarten_subject)) {
                     
                     foreach ($default_kindergarten_subject as $key => $value) {
                         $subjects[] = array(
                             'title' => $value->title,
                             'class' => 1
                         );
                     }
                 }
                 
                 if (count($default_subjects)) {
                     
                     foreach ($default_subjects as $key => $value) {
                         
                         $subjects[] = array(
                             
                             'title' => $value->title,
                             
                             'class' => 2
                         );
                     }
                 }
                 
                 //include_once (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
                 
                 if (count($class_list) && count($section_list)) {
                     
                     $semesterlist = array(
                         'Fall',
                         'Spring'
                     );
                     
                     foreach ($semesterlist as $key => $value) {
                         
                         $this->SaveSemester($value); // save semester
                     }
                     
                     $is_session_added = $this->SaveSession($session_start, $session_end); // save session
                     
                     if (is_int($is_session_added)) {
                         
                         $active_semeter_array = $this->FindActiveSemesterId($current_semester); // find active semester id
                         
                         if (count($active_semeter_array)) {
                             
                             // save dates of current semester
                             
                             $active_semeter = $this->SaveSemesterDate($semester_start, $semester_end, $is_session_added, $active_semeter_array[0]->id);
                             
                             $this->SaveSection($section_list);
                             
                             if (count($active_semeter)) {
                                 
                                 foreach ($class_list as $key => $value) {
                                     
                                     if ($value->title) {
                                         
                                         $class_id = $this->SaveGrade($value->title); // save grade
                                         
                                         foreach ($value->default_sections_in_grade as $key => $secvalue) {
                                             
                                             if ($secvalue->status) {
                                                 
                                                 $section_id = $this->getSectionList(null, $secvalue->title);
                                                 
                                                 if (count($section_id)) {
                                                     
                                                     $is_section_assigned = $this->assign_section($class_id, $section_id[0]->id);
                                                 } // end section list
                                             } // end is section allowed
                                         } // end default section
                                     } //
                                 } // end class list
                                 
                                 if (count($subjects)) {
                                     
                                     $this->operation->table_name = 'semester_dates';
                                     
                                     $is_active_semester = $this->operation->GetByWhere(array(
                                         
                                         'school_id' => $this->school_info->id,
                                         
                                         'status' => 'a'
                                     ));
                                     
                                     $this->operation->table_name = 'classes';
                                     
                                     $is_class_found = $this->operation->GetByWhere(array(
                                         
                                         'school_id' => $this->school_info->id
                                     ));
                                     
                                     if (count($is_class_found)) {
                                         
                                         foreach ($is_class_found as $key => $value) {
                                             
                                             foreach ($subjects as $key => $svalue) {
                                                 
                                                 if ($svalue['class'] == 1 && $value->grade == 'Kindergarten') {
                                                     
                                                     $is_subject_created = $this->SaveDefaultSubjects($svalue['title'], $value->id, $active_semeter_array[0]->id, $value->grade, $is_session_added);
                                                     
                                                     if (is_int($is_subject_created)) {
                                                         
                                                         $class_slug = $this->get_class_slug($value->grade);
                                                         
                                                         if (count($_FILES[$class_slug . "_" . $svalue['title']]) && $_FILES[$class_slug . "_" . $svalue['title']]['name'] != null) {
                                                             
                                                             $valid_formats = array(
                                                                 "xlsx",
                                                                 "xls"
                                                             );
                                                             
                                                             if (strlen($_FILES[$class_slug . "_" . $svalue['title']]['name'])) {
                                                                 
                                                                 list ($txt, $ext) = explode(".", strtolower($_FILES[$class_slug . "_" . $svalue['title']]['name']));
                                                                 
                                                                 if (in_array(strtolower($ext), $valid_formats)) {
                                                                     
                                                                     if ($_FILES[$class_slug . "_" . $svalue['title']]['name'] < 5000000) {
                                                                         
                                                                         $path_name = UPLOAD_PATH . 'default_lesson_plan/' . ucfirst(str_replace(" ", "_", trim(strtolower($value->grade)))) . "/" . ucfirst(str_replace(" ", "_", trim(strtolower($svalue['title']))));
                                                                         
                                                                         $file = time() . trim(basename($_FILES[$class_slug . "_" . $svalue['title']]['name']));
                                                                         
                                                                         $filename = $path_name . $file;
                                                                         
                                                                         if (is_uploaded_file($_FILES[$class_slug . "_" . $svalue['title']]['name'])) {
                                                                             
                                                                             if (move_uploaded_file($_FILES[$class_slug . "_" . $svalue['title']]['tmp_name'], $filename)) {
                                                                                 
                                                                                 chmod($filename, 0777);
                                                                                 
                                                                                 // $excel_obj = $this->CreateExcelObject($filename);
                                                                                 
                                                                                 $this->Readfile($filename, $value->id, 6, $is_subject_created, $is_active_semester[0]->id, $is_session_added);
                                                                             }
                                                                         }
                                                                     }
                                                                 }
                                                             }
                                                         } // end file upload
                                                         
                                                         else {
                                                             
                                                             foreach ($semesterlist as $key => $semvalue) {
                                                                 
                                                                 $default_file = $this->GetDefaultLessonPlanFile($value->grade, $svalue['title'], $semvalue);
                                                                 
                                                                 $new_path = UPLOAD_PATH . 'default_lesson_plan/' . $semvalue . "/" . ucfirst(str_replace(" ", "_", trim(strtolower($value->grade)))) . "/" . ucfirst(str_replace(" ", "_", trim(strtolower($svalue['title']))));
                                                                 
                                                                 if (file_exists($default_file)) {
                                                                     
                                                                     // create excel object
                                                                     
                                                                     $this->Readfile($default_file, $value->id, 6, $is_subject_created, $is_active_semester[0]->id, $is_session_added);
                                                                     
                                                                     rename($default_file, $new_path);
                                                                 }
                                                             }
                                                         } // end read default lesson plan
                                                     } // is subject created
                                                 } // add kidergarten subjects
                                                 
                                                 else if ($svalue['class'] == 2 && $value->grade != 'Kindergarten') {
                                                     
                                                     $is_subject_created = $this->SaveDefaultSubjects($svalue['title'], $value->id, $active_semeter_array[0]->id, $value->grade, $is_session_added);
                                                     
                                                     if (is_int($is_subject_created)) {
                                                         
                                                         $class_slug = $this->get_class_slug($value->grade);
                                                         
                                                         if (count($_FILES[$class_slug . "_" . $svalue['title']]) && $_FILES[$class_slug . "_" . $svalue['title']]['name'] != null) {
                                                             
                                                             $valid_formats = array(
                                                                 "xlsx",
                                                                 "xls"
                                                             );
                                                             
                                                             if (strlen($_FILES[$class_slug . "_" . $svalue['title']]['name'])) {
                                                                 
                                                                 list ($txt, $ext) = explode(".", strtolower($_FILES[$class_slug . "_" . $svalue['title']]['name']));
                                                                 
                                                                 if (in_array(strtolower($ext), $valid_formats)) {
                                                                     
                                                                     if ($_FILES[$class_slug . "_" . $svalue['title']]['name'] < 5000000) {
                                                                         
                                                                         $path_name = UPLOAD_PATH . 'default_lesson_plan/' . ucfirst(str_replace(" ", "_", trim(strtolower($value->grade)))) . "/" . ucfirst(str_replace(" ", "_", trim(strtolower($svalue['title']))));
                                                                         
                                                                         $file = time() . trim(basename($_FILES[$class_slug . "_" . $svalue['title']]['name']));
                                                                         
                                                                         $filename = $path_name . $file;
                                                                         
                                                                         if (is_uploaded_file($_FILES[$class_slug . "_" . $svalue['title']]['name'])) {
                                                                             
                                                                             if (move_uploaded_file($_FILES[$class_slug . "_" . $svalue['title']]['tmp_name'], $filename)) {
                                                                                 
                                                                                 chmod($filename, 0777);
                                                                                 
                                                                                 $this->Readfile($filename, $value->id, 6, $is_subject_created, $is_active_semester[0]->id, $is_session_added);
                                                                             }
                                                                         }
                                                                     }
                                                                 }
                                                             }
                                                         } else {
                                                             
                                                             // read local excel file
                                                             
                                                             foreach ($semesterlist as $key => $semvalue) {
                                                                 
                                                                 $default_file = $this->GetDefaultLessonPlanFile($value->grade, $svalue['title'], $semvalue);
                                                                 
                                                                 $new_path = UPLOAD_PATH . 'default_lesson_plan/' . $semvalue . "/" . ucfirst(str_replace(" ", "_", trim(strtolower($value->grade)))) . "/" . ucfirst(str_replace(" ", "_", trim(strtolower($svalue['title']))));
                                                                 
                                                                 if (file_exists($default_file)) {
                                                                     
                                                                     // create excel object
                                                                     
                                                                     $this->Readfile($default_file, $value->id, 6, $is_subject_created, $is_active_semester[0]->id, $is_session_added);
                                                                     
                                                                     rename($default_file, $new_path);
                                                                 }
                                                             }
                                                         }
                                                     }
                                                 } // end for other classes
                                             } // end subject list
                                         }
                                         
                                         $this->operation->table_name = 'wizard';
                                         
                                         $is_wizard_found = $this->operation->GetByWhere(array(
                                             
                                             'school_id' => $this->school_info->id,
                                             
                                             'status' => 'y'
                                         ));
                                         
                                         if (count($is_wizard_found)) {
                                             
                                             $update_wizard = array(
                                                 
                                                 'status' => 'n',
                                                 
                                                 'edited' => date('Y-m-d')
                                             );
                                             
                                             $this->operation->Create($update_wizard, $is_wizard_found[0]->id);
                                             
                                             $this->operation->table_name = 'grades';
                                             
                                             $option = array(
                                                 
                                                 'semester_date_id' => $is_active_semester[0]->id,
                                                 
                                                 'option_value' => serialize($this->get_default_grades()),
                                                 
                                                 'status' => 'a'
                                             );
                                             
                                             $id = $this->operation->Create($option);
                                             
                                             $this->operation->table_name = 'evaluation';
                                             
                                             $option = array(
                                                 
                                                 'semester_date_id' => $is_active_semester[0]->id,
                                                 
                                                 'option_value' => serialize($this->get_default_evaluation_types()),
                                                 
                                                 'status' => 'a'
                                             );
                                             
                                             $id = $this->operation->Create($option);
                                         }
                                         
                                         $result['message'] = true;
                                     }
                                 } // end if subject found
                             } // end semester dates
                         } // end active semester
                     }
                 } // end if empty class and section
             }
             
             $this->response($result, REST_Controller::HTTP_OK);
        } catch (Exception $e) {print_r($e);}
    }
    
    function principal_get()
    {
        $result = array();
        $params = $this->parse_params();
        
        $user_id = $params['user_id'];
        $id = $params['id'];
        
        if (empty($user_id) || empty($id)) {
            $this->set_response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            exit();
        }
        
        $result = $this->get_user_profile($id);
        
        $school = array();
        $is_school_found = $this->operation->GetByQuery("SELECT l.*,l.id as locationid,s.* FROM user_locations ul INNER JOIN schools s ON s.id = ul.school_id INNER JOIN location l ON l.id = s.cityid WHERE ul.user_id=" . $id);
        if (count($is_school_found)) {
            $school = $is_school_found[0];
        }
        
        $result['school'] = $school;
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    
    function principal_post()
    {
        $result = array();
        $request = $this->parse_params();
        
        $first_name = trim($request->first_name);
        $last_name = trim($request->last_name);
        $nic = trim($request->nic);
        $email = trim($request->email);
        $phone = trim($request->phone);
        
        $school_id = $request->school_id;
        $p_address = $request->p_address;
        $school_id = $request->location_id;
        $zip_code = $request->zip_code;
        $city = $request->city;
        $user_id = $request->user_id;
        $id = $request->id;
        
        if (empty($user_id) || empty($email) || empty($first_name) || empty($last_name)
            || empty($nic) || empty($p_address) || empty($school_id) || empty($zip_code) || empty($phone) || empty($city)
            ) {
                $result['message'] = "Missing arguments";
                $this->set_response($result, REST_Controller::HTTP_NOT_ACCEPTABLE);
                exit();
            }
            
            $result['message'] = false;
            
            $gender = $request->gender;
            
            $p_address = trim($request->p_address);
            $s_address = trim($request->s_address);
            $province = trim($request->province);
            
            $password = null;
            if (isset($request->password) && isset($request->repeat_password)) {
                $password = trim($request->password);
                $repeat_password = trim($request->repeat_password);
            }
            
            if (! empty($id)) {
                
                $teacher_id = $this->user->PrincipalInfo($id, ucwords($first_name), ucwords($last_name), $gender, $nic, $email, $phone, $password, $p_address, $s_address, $province, $city, $zip_code, $school_id);
                
            } else if (! empty($password) && $password == $repeat_password) {
                // insert
                
                $teacher_id = $this->user->PrincipalInfo(null, ucwords($first_name), ucwords($last_name), $gender, $nic, $email, $phone, $password, $p_address, $s_address, $province, $city, $zip_code, $school_id);
            }
            
            if ($teacher_id) {
                $result['last_id'] = $teacher_id;
                $result['message'] = true;
            }
            
            
            $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function principal_delete()
    {
        $result = array();
        $params = $this->parse_params();
        
        $user_id = $params['user_id'];
        $id = $params['id'];
        
        if (empty($user_id) || empty($id)) {
            $this->set_response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            exit();
        }
        
        $result['message'] = false;
        
        $removeStudent = $this->db->query("DELETE FROM invantage_users WHERE id = " . $id);
        $removeStudent = $this->db->query("DELETE FROM user_meta WHERE user_id = " . $id);
        
        if ($removeStudent == TRUE) {
            
            $result['message'] = true;
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    function principals_get()
    {
        $result = array();
        $params = $this->parse_params();
        
        $user_id = $params['user_id'];
        
        if (empty($user_id)) {
            $this->set_response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            exit();
        }
        
        $teacherlists = $this->operation->GetByQuery("SELECT inuser.* FROM invantage_users inuser  INNER JOIN user_roles ur ON ur.user_id =inuser.id WHERE ur.role_id = 3 ");
        if (count($teacherlists)) {
            
            foreach ($teacherlists as $value) {
                
                $school = array();
                $is_school_found = $this->operation->GetByQuery("SELECT l.*,l.id as locationid,s.* FROM user_locations ul INNER JOIN schools s ON s.id = ul.school_id INNER JOIN location l ON l.id = s.cityid WHERE ul.user_id=" . $value->id);
                if (count($is_school_found)) {
                    $school = $is_school_found[0];
                }
                
                $result[] = array(
                    
                    'id' => $value->id,
                    
                    'first_name' => ($this->get_user_meta($value->id, 'principal_firstname') != false ? $this->get_user_meta($value->id, 'principal_firstname') : ''),
                    
                    'last_name' => ($this->get_user_meta($value->id, 'principal_lastname') != false ? $this->get_user_meta($value->id, 'principal_lastname') : ''),
                    
                    'email' => $value->email,
                    
                    'school' => $school
                );
            }
        }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    
    // endregion
    function getClassInfoByName($className)
    {
        $is_class_found = $this->operation->GetByQuery("Select c.* from classes c where c.grade = '" . $className . "'");
        if (count($is_class_found)) {
            return $is_class_found[0]->id;
        } else {
            return false;
        }
    }
    
    private function getClassName($class_id)
    {
        $is_class_found = $this->operation->GetByQuery("Select c.* from classes c where c.id =" . $class_id);
        // var_dump($class_id);
        if (count($is_class_found)) {
            return $is_class_found[0]->grade;
        } else {
            return false;
        }
    }
    
    // endregion
    function getSchedule($subject_id, $class_id, $section_id)
    {
        $currentday = strtolower(date('D'));
        $s_time =  $currentday.'_start_time';
        $e_time =  $currentday.'_end_time';
        $is_schedule_found = $this->operation->GetByQuery("Select s.* from schedule s where s.subject_id = " . $subject_id . " AND s.class_id = " . $class_id . " AND s.section_id = " . $section_id);
        if (count($is_schedule_found)) {
            return array(
                    'start_time'=>strtotime($is_schedule_found[0]->$s_time),
                    'end_time'=>strtotime($is_schedule_found[0]->$e_time),
                    'last_update'=>$is_schedule_found[0]->last_update
            );
        } else {
            return false;
        }
    }
    
    function TypeChecking($type, $content)
    {
        $image_array = array(
            "jpg",
            "png",
            "gif",
            "bmp",
            "jpeg"
        );
        $video_array = array(
            "mp4",
            "flv",
            "avi"
        );
        $document_array = array(
            'doc',
            'pdf',
            'xls',
            'xlsx',
            'docx',
            "ppt",
            "pptx"
        );
        $app_array = array(
            'doc',
            'pdf',
            'xls',
            'xlsx',
            'docx'
        );
        $type_matched = false;
        switch ($type) {
            case 'Game':
                if (filter_var($content, FILTER_VALIDATE_URL)) {
                    $type_matched = true;
                }
                break;
                
            case 'Image':
                if (in_array(strtolower(pathinfo($content, PATHINFO_EXTENSION)), $image_array)) {
                    $type_matched = true;
                }
                break;
                
            case 'Video':
                if (in_array(strtolower(pathinfo($content, PATHINFO_EXTENSION)), $video_array)) {
                    $type_matched = true;
                }
                break;
                
            case 'Document':
                if (in_array(strtolower(pathinfo($content, PATHINFO_EXTENSION)), $document_array)) {
                    $type_matched = true;
                }
                break;
                
            case 'Application':
                if (in_array(strtolower(pathinfo($content, PATHINFO_EXTENSION)), $app_array)) {
                    $type_matched = true;
                }
                break;
        }
        
        return $type_matched;
    }
    
    /**
     * Get lesson read statud
     *
     * @param [int] $lessonid
     * @param [int] $student_id
     */
    function CheckisReadedLesson($lessonid, $student_id)
    {
        $this->operation->table_name = "lesson_progress";
        
        return $this->operation->GetByWhere(array(
            'student_id' => $student_id,
            'lessonid' => $lessonid,
            'status' => 'read',
            'type' => 't'
        ));
    }
    
    function GetStudentLastReadId($student_id, $type = null)
    {
        if (is_null($type)) {
            return $this->operation->GetByQuery("SELECT * from lesson_progress where student_id=" . $student_id . " Order by last_updated desc limit 1");
        } else {
            return $this->operation->GetByQuery("SELECT * from lesson_progress where student_id=" . $student_id . " AND type ='" . $type . "' Order by last_updated desc limit 1");
        }
    }
    
    function GetAllLessonBySubject($class_id, $section_id, $subject_id, $sessoid, $semester_id)
    {
        return $this->operation->GetByQuery("SELECT * from semester_lesson_plan where class_id = " . $class_id . " AND section_id =" . $section_id . " AND subject_id=" . $subject_id . " AND content != '' AND session_id = " . $sessoid . " AND semester_id =" . $semester_id . " Order By preference");
    }
    
    function GetProgressBySubject($class_id, $section_id, $subject_id)
    {
        $not_readed_lessons = array();
        try {
            
            $is_lesson_found = $this->operation->GetByQuery("SELECT * from semester_lesson_plan where subject_id=" . $subject_id . " AND class_id = " . $class_id . "  AND read_date <> '' And content <> '' Order By read_date");
            if (count($is_lesson_found)) {
                $progress_list = $this->operation->GetByQuery("SELECT * from class_group where  class_id = " . $class_id . " AND section_id =" . $section_id . " AND status = 'r'");
                
                if (count($progress_list)) {
                    foreach ($is_lesson_found as $key => $value) {
                        
                        if ($this->in_multiarray($value->id, $progress_list) == false) {
                            $not_readed_lessons[] = array(
                                'id' => $value->id
                            );
                        }
                    }
                } else {
                    $not_readed_lessons[] = array(
                        'id' => $is_lesson_found[0]->id
                    );
                }
            }
            
            return $not_readed_lessons;
        } catch (Exception $e) {}
    }
    
    function GetProgressByStudent($class_id, $section_id, $subject_id, $student_id, $type = null)
    {
        try {
            $not_readed_lessons = array();
            $is_lesson_found = $this->operation->GetByQuery("SELECT * from semester_lesson_plan where subject_id=" . $subject_id . " AND class_id = " . $class_id . " AND section_id =" . $section_id . " AND read_date <> '' And content <> '' AND read_date <= '" . date('Y-m-d') . "'  Order By read_date");
            
            if (count($is_lesson_found)) {
                if (! is_null()) {
                    $progress_list = $this->operation->GetByQuery("SELECT * from lesson_progress where  student_id = " . $student_id . " AND status = 'read' AND type = 't'");
                } else {
                    $progress_list = $this->operation->GetByQuery("SELECT * from lesson_progress where  student_id = " . $student_id . " AND status = 'read'");
                }
                
                if (count($progress_list)) {
                    foreach ($is_lesson_found as $key => $value) {
                        
                        if ($this->in_multiarray($value->id, $progress_list) == false) {
                            $not_readed_lessons[] = array(
                                'id' => $value->id
                            );
                        }
                    }
                } else {
                    $not_readed_lessons[] = array(
                        'id' => $is_lesson_found[0]->id
                    );
                }
            }
            return $not_readed_lessons;
        } catch (Exception $e) {}
    }
    
    function in_multiarray($elem, $array)
    {
        try {
            foreach ($array as $key => $value) {
                if ($value->lessonid == $elem) {
                    return true;
                }
            }
            return false;
        } catch (Exception $e) {
            return true;
        }
    }
    
    /*
    //Lesson progress based on student plan
    function lesson_progress_post()
    {
        $result['message'] = false;
        
        try {
            $lesson_type = 'r';
            
            $postdata = file_get_contents("php://input");
            
            $request = json_decode($postdata);
            $progress_array = $request->lesson_progress;
            
            if (! empty($request->type)) {
                $lesson_type = $request->type;
            }
            
            if (count($progress_array)) {
                
                foreach ($progress_array as $key => $value) {
                    $is_student_found = $this->operation->GetByQuery("SELECT * FROM invantage_users WHERE username= '" . $value->roll_no . "'");
                    
                    if (count($is_student_found)) {
                        
                        $this->operation->table_name = 'lesson_progress';
                        
                        $is_lesson_read = $this->operation->GetByQuery("SELECT * FROM lesson_progress WHERE unique_code = '" . $value->unique_code . "' AND student_id =" . $is_student_found[0]->id);
                        $is_lesson_found = $this->operation->GetByQuery("SELECT * FROM student_lesson_plan WHERE lesson_code = '" . $value->unique_code . "' AND student_id=" . $is_student_found[0]->id);
                        
                        if(count($is_lesson_found)){
                            
                            $read_count = $value->read_count>0?$value->read_count:0;
                            
                            $open_count = $value->open_count>0?$value->open_count:0;
                            
                            if (count($is_lesson_read) == 0) {
                                // Create progress
                                
                                $lesson_progress = array(
                                    'student_id' => $is_student_found[0]->id,
                                    'lesson_id' => $is_lesson_found[0]->id,
                                    'unique_code' => $is_lesson_found[0]->lesson_code,
                                    'status' => ($read_count > 0 ? 'read' : 'unread'),
                                    'count' => $read_count,
                                    'open_count' => $open_count,
                                    'last_updated' => date('Y-m-d H:i:s'),
                                    'type' => $lesson_type
                                );
                                
                                $is_value_saved = $this->operation->Create($lesson_progress);
                                
                            } else{
                                // Update progress
                                $read_count = $is_lesson_read[0]->count + $read_count;
                                $open_count = $is_lesson_read[0]->open_count + $open_count;
                                
                                $student_progress = array(
                                    'status' => ($read_count > 0 ? 'read' : 'unread'),
                                    'count' => $read_count,
                                    'open_count' => $open_count,
                                    'last_updated' => date('Y-m-d H:i:s')
                                );
                                
                                $is_value_saved = $this->operation->Create($student_progress, $is_lesson_read[0]->id);
                                
                            }
                            
                        }
                        
                        if (count($is_value_saved)) {
                            $result['message'] = true;
                        }
                    }
                }
            } else {
                
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'input parms not completed'
                ], REST_Controller::HTTP_NOT_FOUND);
                
            }
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        
        if ($result['message'] == true) {
            $this->response($result, 201);
        } else {
            $this->response(array(
                'message' => 'false'
            ), 400);
        }
    }
    */
    
    //Lesson progress based on semester plan
    function lesson_progress_post()
    {
        $result['message'] = false;
        
        try {
            $lesson_type = 'r';
            
            $postdata = file_get_contents("php://input");
            
            $request = json_decode($postdata);
            $progress_array = $request->lesson_progress;
            
            if (! empty($request->type)) {
                $lesson_type = $request->type;
            }
            
            if (count($progress_array)) {
                
                foreach ($progress_array as $key => $value) {
                    $is_student_found = $this->operation->GetByQuery("SELECT * FROM invantage_users WHERE username= '" . $value->roll_no . "'");

                    if (count($is_student_found)) {
                        
                        $this->operation->table_name = 'lesson_progress';
                        
                        $is_lesson_read = $this->operation->GetByQuery("SELECT * FROM lesson_progress WHERE unique_code = '" . $value->unique_code . "' AND student_id =" . $is_student_found[0]->id);
                        $is_lesson_found = $this->operation->GetByQuery("SELECT * FROM semester_lesson_plan WHERE unique_code = '" . $value->unique_code . "'");
                        
                        if(count($is_lesson_found)){
                            
                            $finish_count = $value->read_count>0?$value->read_count:0;
                            $open_count = $value->open_count>0?$value->open_count:0;
                            $score = $value->score>0?$value->score:0;
                            $total_score = $value->total_score>0?$value->total_score:0;
                            $last_opened = isset($value->last_opened)?$value->last_opened:'';
                            $started = isset($value->started)?$value->started:'';
                            $finished = isset($value->finished)?$value->finished:'';
                            
                            if (count($is_lesson_read) == 0) {
                                // Create progress
                                
                                $lesson_progress = array(
                                    'student_id' => $is_student_found[0]->id,
                                    'lesson_id' => $is_lesson_found[0]->id,
                                    'unique_code' => $is_lesson_found[0]->unique_code,
                                    'finish_count' => $finish_count,
                                    'open_count' => $open_count,
                                    'type' => $lesson_type,
                                    'last_updated' => date('Y-m-d H:i:s')
                                );

                                if(isset($value->started)){
                                    $lesson_progress['started'] = $value->started;
                                }
                                if(isset($value->finished)){
                                    $lesson_progress['finished'] = $value->finished;
                                }

                                if(!empty($value->started) && !empty($value->finished)){
                                    $t1 = strtotime($value->started);
                                    $t2 = strtotime($value->finished);
                                    if($t2>$t1){
                                        $lesson_progress['duration'] = $t2 - $t1;
                                    }
                                }

                                if(isset($value->score)){
                                    $lesson_progress['score'] = $value->score;
                                }
                                if(isset($value->total_score)){
                                    $lesson_progress['total_score'] = $value->total_score;
                                }
                                if(isset($value->last_opened)){
                                    $lesson_progress['last_opened'] = $value->last_opened;
                                }
                                
                                $is_value_saved = $this->operation->Create($lesson_progress);
                                
                            } else{
                                // Update progress
                                $finish_count = $is_lesson_read[0]->finish_count + $finish_count;
                                $open_count = $is_lesson_read[0]->open_count + $open_count;
                                
                                $lesson_progress = array(
                                    'finish_count' => $finish_count,
                                    'open_count' => $open_count,
                                    'type' => $lesson_type,
                                    'last_updated' => date('Y-m-d H:i:s')
                                );

                                if(isset($value->started)){
                                    $lesson_progress['started'] = $value->started;
                                }
                                if(isset($value->finished)){
                                    $lesson_progress['finished'] = $value->finished;
                                }

                                if( $is_lesson_read[0]->duration <= 0){
                                    $t1 = strtotime($is_lesson_read[0]->started);
                                    $t2 = strtotime($value->finished);
                                    if($t2>$t1){
                                        $lesson_progress['duration'] = $t2 - $t1;
                                    }
                                }

                                if(isset($value->score)){
                                    $lesson_progress['score'] = $value->score;
                                }
                                if(isset($value->total_score)){
                                    $lesson_progress['total_score'] = $value->total_score;
                                }
                                if(isset($value->last_opened)){
                                    $lesson_progress['last_opened'] = $value->last_opened;
                                }
                                
                                $is_value_saved = $this->operation->Create($lesson_progress, $is_lesson_read[0]->id);
                                
                            }
                            
                        }
                        
                        if (count($is_value_saved)) {
                            $result['message'] = true;
                        }
                    }
                }
            } else {
                
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'input parms not completed'
                ], REST_Controller::HTTP_NOT_FOUND);
                
            }
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        
        if ($result['message'] == true) {
            $this->response($result, 201);
        } else {
            $this->response(array(
                'message' => 'false'
            ), 400);
        }
    }
    

    function user_activity_post()
    {
        $result['message'] = false;
        
        try {
            $params = $this->parse_params();
            
            if(count($params->user_activity) <=0){
                $this->set_response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
                return;
            }

            foreach ($params->user_activity as $key => $activity) {
             
                $user_id = $activity->user_id;
                $unique_code = $activity->unique_code;
                $started = $activity->started;
                $finished = $activity->finished;
                $duration = $activity->duration;
                $version = $activity->version;
                $man = $activity->man;    // manufacturer
                $model = $activity->model;
                $platform = $activity->platform;
                $last_updated = $activity->last_updated;

                $app_type = 'web';  // default
                if (! empty($activity->app_type)) {
                    $app_type = $activity->app_type;
                }
                
                if( empty($user_id) || empty($last_updated) || empty($started) ){
                    $this->set_response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
                    return;
                }

                $user_activity = array(
                    'user_id' => $user_id,
                    'man' => $man,
                    'model' => $model,
                    'platform' => $platform,
                    'app_type' => $app_type,
                    'version' => $version,
                    'last_updated' => date('Y-m-d H:i:s')
                );

                if(!empty($started)){
                    $user_activity['started'] = $started;
                }

                if(!empty($finished)){
                    $user_activity['finished'] = $finished;
                    if(!empty($started)){
                        $t1 = strtotime($started);
                        $t2 = strtotime($finished);
                        if($t2>$t1){
                            $user_activity['duration'] = $t2 - $t1;
                        }
                    }
                }

                $is_progress_found = array();
                if (!empty($unique_code)) {
                        
                    $is_progress_found = $this->operation->GetByQuery("SELECT * FROM user_activity WHERE unique_code = '" . $unique_code . "' AND user_id = " . $user_id);
                }
                            
                $this->operation->table_name = "user_activity";
                if(count($is_progress_found)){
                    // Update
                    $is_value_saved = $this->operation->Create($user_activity, $is_progress_found[0]->id);

                }else{
                    // Add 
                    if (!empty($unique_code)) {
                        $user_activity['unique_code'] = $unique_code;
                    } else {
                        $user_activity['unique_code'] = uniqid();
                    }
                    $is_value_saved = $this->operation->Create($user_activity);
                }
            }            
                        
            if (count($is_value_saved)) {
                $result['message'] = true;
            }
                    
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        
        if ($result['message'] == true) {
            $this->response($result, 201);
        } else {
            $this->response(array(
                'message' => 'false'
            ), 400);
        }
    }
    

    function GetDefaultLessonPlan_get()
    {
        $this->operation->table_name = "default_lesson_plan";
        $query = $this->operation->GetRows();
        $result = array();
        if (count($query)) {
            foreach ($query as $key => $value) {
                $result[] = array(
                    'id' => $value->id,
                    'name' => $value->concept,
                    'uploaded_url' => $value->content,
                    'notes' => $value->topic,
                    'date' => $value->date,
                    'type' => $value->type,
                    'last_update' => $value->last_update
                );
            }
        }
        echo json_encode($result);
    }
    
    
    
    function SetQuizProgress_post()
    {
        try {
            $result['message'] = false;
            $progress_array = json_decode($this->input->post('quiz_progress'));
            
            if (count($progress_array)) {
                foreach ($progress_array as $key => $value) {
                    $is_student_found = $this->operation->GetByQuery("SELECT * from invantage_users where username = '" . $value->student_roll_no . "'");
                    if (count($is_student_found)) {
                        $this->operation->table_name = 'quiz_evaluation';
                        foreach ($value->result_evaluation as $key => $rvalue) {
                            
                            $query = $this->operation->GetByWhere(array(
                                'student_id' => $is_student_found[0]->id,
                                'quizid' => $value->quiz_id,
                                'questionid' => $rvalue->question_id
                            ));
                            $is_quiz_found = $this->operation->GetByQuery("SELECT * from quiz where id = " . $value->quiz_id);
                            
                            if (count($query) == false && count($is_quiz_found)) {
                                $student_progress = array(
                                    'student_id' => $is_student_found[0]->id,
                                    'quizid' => $value->quiz_id,
                                    'questionid' => $rvalue->question_id,
                                    'optionid' => $rvalue->selected_option_id
                                );
                                $is_value_saved = $this->operation->Create($student_progress);
                                if (count($is_value_saved)) {
                                    $result['message'] = true;
                                }
                            } else {
                                $result['message'] = true;
                            }
                        }
                    }
                }
            }
            if ($result['message'] == true) {
                $this->response($result, REST_Controller::HTTP_OK);
            } else {
                $this->response($result, REST_Controller::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Invalid input'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    function GetVersion_get()
    {
        $this->operation->table_name = "versions";
        $query = $this->operation->GetByWhere(array(
            'status' => 'a'
        ));
        $result = array();
        if (count($query)) {
            foreach ($query as $key => $value) {
                $result[] = array(
                    'id' => $value->id,
                    'version' => $value->version,
                    'app_url' => $value->app_url
                );
            }
        }
        echo json_encode($result);
    }
    
    function GetLMSMode_post()
    {
        $data = $this->operation->GetByQuery('SELECT * from releaseshedulle');
        $LMSMode = $array();
        if (! count($data)) {
            foreach ($data as $key => $value) {
                $LMSMode = array(
                    'lmsmode' => $value->t_status
                );
            }
        }
        echo json_encode($LMSMode);
    }
    
    function GetLocations_get()
    {
        if (! empty($this->get('location')) && ! is_null($this->get('location'))) {
            $is_location_found = $this->operation->GetByQuery('SELECT s.id as school_id,s.name,l.id as cityid, l.location FROM schools s INNER JOIN location l ON l.id = s.cityid WHERE l.id= ' . $this->get("location"));
        } else {
            $is_location_found = $this->operation->GetByQuery('SELECT s.id as school_id,s.name,l.id as cityid, l.location FROM schools s INNER JOIN location l ON l.id = s.cityid ORDER BY l.location');
        }
        
        $result = array();
        if (count($is_location_found)) {
            foreach ($is_location_found as $key => $value) {
                $result[] = array(
                    'cityid' => $value->cityid,
                    'city' => $value->location,
                    'school_id' => $value->school_id,
                    'school' => $value->name
                );
            }
        }
        echo json_encode($result);
    }
    
    /**
     * Get class info by school teacher
     *
     * @param
     *            int school_id
     *
     * @return array
     */
    function GetSchoolClassInfo_get()
    {
        if ($this->session->userdata('id') || $this->session->userdata('uroles') == 'g') {
            if ($this->session->userdata('uroles') == 'g') {
                $this->operation->table_name = "location";
                $first_location = $this->operation->GetByWhere(array(
                    'location' => "Lahore"
                ));
                
                $this->operation->table_name = "classes";
                $query = $this->operation->GetByWhere(array(
                    'school_id' => 1
                ));
            } else {
                $this->operation->table_name = "classes";
                $location = $this->session->userdata('locations');
                $query = $this->operation->GetByWhere(array(
                    'school_id' => $location[0]['school_id']
                ));
            }
            $result = array();
            if (count($query)) {
                foreach ($query as $key => $value) {
                    $is_section_found = $this->operation->GetByQuery("SELECT asi.id as asisecid,s.* FROM assign_sections asi INNER JOIN sections s ON s.id = asi.section_id WHERE asi.class_id =" . $value->id);
                    $sectionarray = array();
                    if (count($is_section_found)) {
                        foreach ($is_section_found as $key => $svalue) {
                            $sectionarray[] = array(
                                'id' => $svalue->id,
                                'section_name' => $svalue->section_name,
                                'last_update' => $svalue->last_update
                            );
                        }
                    }
                    $result[] = array(
                        'id' => $value->id,
                        'last_update' => $value->last_update,
                        'grade' => $value->grade,
                        'section' => $sectionarray
                    );
                }
            }
            
            if (count($result)) {
                $this->response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'no class found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }
    
    /**
     * Get student list
     *
     * @param
     *            int class_id
     * @param
     *            int section_id
     *
     * @return array
     */
    public function GetStudentListByRestAPI_post()
    {
        try {
            
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $class_id = $this->security->xss_clean(html_escape($request->class_id));
            $section_id = $this->security->xss_clean(html_escape($request->section_id));
            $locations = $this->session->userdata('locations');
            $this->operation->table_name = 'sessions';
            $active_session = $this->operation->GetByWhere(array(
                'school_id' => $locations[0]['school_id'],
                'status' => 'a'
            ));
            
            $this->operation->table_name = 'semester_dates';
            $active_semester = $this->operation->GetByWhere(array(
                'session_id' => $active_session[0]->id,
                'status' => 'a'
            ));
            $query = $this->operation->GetByQuery("SELECT inv.* FROM invantage_users inv inner join student_semesters ss on inv.id=ss.student_id where ss.class_id=" . $class_id . " and ss.section_id= " . $section_id . " AND ss.semester_id = " . $active_semester[0]->semester_id . " AND ss.session_id = " . $active_session[0]->id . " and ss.status='r' and inv.type='s'");
            $result = array();
            
            if (count($query)) {
                foreach ($query as $key => $value) {
                    $classInfo = $this->get_user_meta($value->id, 'sgrade');
                    
                    $this->operation->primary_key = 'id';
                    $this->operation->table_name = 'sections';
                    $sectioninfo = $this->operation->GetByWhere(array(
                        'id' => $classInfo
                    ));
                    
                    $classinfodetail = $this->operation->GetByQuery('SELECT ss.class_id,c.grade,ss.section_id,ss.semester_id,s.section_name FROM student_semesters ss INNER JOIN classes c on c.id = ss.class_id INNER JOIN sections s on s.id = ss.section_id  where ss.status = "r" AND ss.student_id = ' . $value->id);
                    
                    if (count($classinfodetail)) {
                        $result[] = array(
                            'id' => $value->id,
                            'roll_no' => $value->username,
                            'student_name' => $this->get_user_meta($value->id, 'sfullname') . " " . $this->get_user_meta($value->id, 'slastname'),
                            'password' => $value->password,
                            'class' => $classinfodetail[0]->grade,
                            'class_id' => $classinfodetail[0]->class_id,
                            'section_id' => $classinfodetail[0]->section_id,
                            'section' => section_name,
                            'campus' => null,
                            'profile_image' => $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE)
                        );
                    }
                }
            }
            $this->response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no class found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    function SearchStudentReocrd($student_id, $lessonid)
    {
        return $this->operation->GetByQuery("Select * from lesson_progress where student_id=" . $student_id . " AND lessonid = " . $lessonid . " AND status = 'read'");
    }
    
    function SearchClassGroupReocrd($class_id, $section_id, $lessonid)
    {
        return $this->operation->GetByQuery("Select * from class_group where  class_id = " . $class_id . " AND section_id =" . $section_id . " AND lessonid = " . $lessonid);
    }
    
    function GetLessonSubject($subject_id)
    {
        return $this->operation->GetByQuery("Select * from subjects  where id = " . $subject_id);
    }
    
    /**
     * Get today lesson list
     *
     * @param
     *            int class_id
     * @param
     *            int section_id
     *
     * @return array
     */
    public function GetTodayLessons_post()
    {
        try {
            
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $class_id = $this->security->xss_clean(html_escape($request->class_id));
            $section_id = $this->security->xss_clean(html_escape($request->section_id));
            $status = $this->security->xss_clean(html_escape($request->status));
            $subject = $this->security->xss_clean(html_escape($request->subject));
            $result = array();
            
            // find current period
            if ($this->post('subject')) {
                
                // Students check
                $studentlist = $this->post('studentlist');
                
                if (count($studentlist) == 1) {
                    $last_id = $this->GetProgressByStudent($class_id, $section_id, $subject, $studentlist[0]['id']);
                    
                    if (count($last_id)) {
                        
                        $is_student_lessons_not_readed = $this->operation->GetByQuery("Select * from semester_lesson_plan where subject_id=" . $subject . " AND class_id = " . $class_id . " AND section_id =" . $section_id . " AND id >= " . $last_id[0]['id'] . " AND read_date <='" . date('Y-m-d') . "' And content <> '' order by read_date,preference Asc");
                    }
                    
                    if (count($is_student_lessons_not_readed)) {
                        
                        $enabled_lesson_id = $last_id[0]['id'];
                        foreach ($is_student_lessons_not_readed as $key => $lvalue) {
                            if ($lvalue->type && date('Y-m-d', strtotime($lvalue->read_date)) > date('Y-m-d', strtotime('1970-01-01'))) {
                                if ($this->TypeChecking($lvalue->type, $lvalue->content) == true) {
                                    $is_lesson_found = $this->SearchStudentReocrd($studentlist[0]['id'], $lvalue->id);
                                    
                                    $subject = $this->GetLessonSubject($lvalue->subject_id);
                                    
                                    $is_readed = false;
                                    $is_diabled = true;
                                    $is_blinking = false;
                                    
                                    if (count($is_lesson_found)) {
                                        $is_readed = true;
                                        $is_blinking = false;
                                        $is_diabled = false;
                                    }
                                    
                                    $is_diabled = (($lvalue->id == $enabled_lesson_id || $is_readed) ? false : true);
                                    $subject = $this->GetLessonSubject($lvalue->subject_id);
                                    
                                    $result[] = array(
                                        'id' => $lvalue->id,
                                        'content' => $lvalue->content,
                                        'name' => $lvalue->concept,
                                        'type' => $lvalue->type,
                                        'read_date' => $lvalue->read_date,
                                        'subject' => trim($subject[0]->subject_name),
                                        'lesson_readed' => $is_readed,
                                        'bliking' => $is_blinking,
                                        'disabled' => $is_diabled
                                    );
                                }
                            }
                        }
                        $this->response([
                            'status' => true,
                            'message' => 'lessons found',
                            'result' => $result
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->set_response([
                            'status' => FALSE,
                            'message' => 'lessons not found'
                        ], REST_Controller::HTTP_OK);
                    }
                } else {
                    
                    $last_id = $this->GetProgressBySubject($this->post('class_id'), $this->post('section_id'), $this->post('subject'));
                    if (count($last_id)) {
                        $is_student_lessons_not_readed = $this->operation->GetByQuery("Select * from semester_lesson_plan where subject_id=" . $subject . " AND class_id = " . $class_id . " AND section_id =" . $section_id . " AND id >= " . $last_id[0]['id'] . " AND read_date <= '" . date('Y-m-d') . "' And content <> '' order by read_date,preference Asc");
                        $enabled_lesson_id = $last_id[0]['id'];
                    }
                    
                    if (count($is_student_lessons_not_readed)) {
                        foreach ($is_student_lessons_not_readed as $key => $lvalue) {
                            if ($lvalue->type && date('Y-m-d', strtotime($lvalue->read_date)) > date('Y-m-d', strtotime('1970-01-01'))) {
                                if ($this->TypeChecking($lvalue->type, $lvalue->content) == true) {
                                    $is_lesson_found = $this->SearchClassGroupReocrd($class_id, $section_id, $lvalue->id);
                                    $is_readed = false;
                                    $is_diabled = true;
                                    $is_blinking = false;
                                    
                                    if (count($is_lesson_found)) {
                                        $is_readed = true;
                                        $is_blinking = false;
                                        $is_diabled = false;
                                    }
                                    
                                    $is_diabled = (($lvalue->id == $enabled_lesson_id || $is_readed) ? false : true);
                                    $subject = $this->GetLessonSubject($lvalue->subject_id);
                                    
                                    $result[] = array(
                                        'id' => $lvalue->id,
                                        'content' => $lvalue->content,
                                        'name' => $lvalue->concept,
                                        'type' => $lvalue->type,
                                        'read_date' => $lvalue->read_date,
                                        'subject' => trim($subject[0]->subject_name),
                                        'lesson_readed' => $is_readed,
                                        'bliking' => $is_blinking,
                                        'disabled' => $is_diabled
                                    );
                                }
                            }
                        }
                        $this->response([
                            'status' => true,
                            'message' => 'lessons found',
                            'result' => $result
                        ], REST_Controller::HTTP_OK);
                    } else {
                        $this->set_response([
                            'status' => FALSE,
                            'message' => 'lessons not found'
                        ], REST_Controller::HTTP_OK);
                    }
                }
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'break',
                    'nextperiod' => 'break'
                ], REST_Controller::HTTP_OK);
            }
            
            // $school_off=$this->operation->GetByQuery("
            // SELECT s.end_time FROM schedule s
            // where s.class_id=".$class_id." and s.section_id= ".$section_id);
            // asort($school_off);
            // $hours = array();
            // foreach ($school_off as $key => $value) {
            // $hours[] = array(
            // 'hour'=>date('H:i',$value->end_time),
            // 'start_time'=>date('H:i',$value->start_time)
            // );
            // }
            // rsort($hours);
            
            // // if no result found means school is off
            // if(date('H:i') > date('H:i',strtotime($hours[0]['hour'])) || date('D') == 'Sat' || date('D') == 'Sun')
            // {
            // $this->set_response([
            // 'status' => FALSE,
            // 'message' => 'timefree'
            // ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            
            // }
            // else if(date('H:i') < date('H:i',strtotime($hours[count($hours) - 1]['start_time'])))
            // {
            // $this->set_response([
            // 'status' => FALSE,
            // 'message' => 'daynotstarted'
            // ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            // }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no class found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    // endregion
    
    /**
     * Get grade schedule list
     *
     * @return array
     */
    function GetPeriodSchedule_post()
    {
        try {
            date_default_timezone_set("Asia/Karachi");
            if ($this->post('class_id') && $this->post('section_id')) {
                $school_off = $this->operation->GetByQuery("
                        SELECT s.* FROM schedule s
                        where s.class_id=" . $this->post('class_id') . " and s.section_id= " . $this->post('section_id') . " order by s.start_time");
                
                if (count($school_off)) {
                    $result = array();
                    $have_any_period_found = false;
                    foreach ($school_off as $key => $value) {
                        $currentperiod = false;
                        $subjectname = trim($this->GetSubjectName($value->subject_id));
                        $start_time = date('Y-m-d H:i', $value->start_time);
                        $end_time = date('Y-m-d H:i', $value->end_time);
                        
                        if (date('H:i') >= date('H:i', strtotime($start_time)) && date('H:i') <= date('H:i', strtotime($end_time))) {
                            $currentperiod = true;
                            $have_any_period_found = true;
                        }
                        
                        $subjectname = $this->GetSubjectName($value->subject_id);
                        $result[] = array(
                            'id' => $value->id,
                            'subject_id' => $value->subject_id,
                            'start_time' => date('Y-m-d H:i', $value->start_time),
                            'end_time' => date('Y-m-d H:i', $value->end_time),
                            'currentperiod' => $currentperiod,
                            'subject' => trim(ucfirst($subjectname[0]->subject_name))
                        );
                    }
                    
                    if ($have_any_period_found == true) {
                        $this->response([
                            'status' => true,
                            'message' => 'lessons found',
                            'result' => $result
                        ], REST_Controller::HTTP_OK);
                    } else {
                        asort($school_off);
                        $hours = array();
                        foreach ($school_off as $key => $value) {
                            $subjectname = $this->GetSubjectName($value->subject_id);
                            $hours[] = array(
                                'hour' => date('H:i', $value->end_time),
                                'start_time' => date('H:i', $value->start_time),
                                'subject_id' => $value->subject_id,
                                'subject' => trim(ucfirst($subjectname[0]->subject_name))
                            );
                        }
                        rsort($hours);
                        
                        if (date('H:i') >= $hours[0]['hour']) {
                            $this->response([
                                'status' => false,
                                'message' => 'dasyisoff'
                            ], REST_Controller::HTTP_OK);
                        } else {
                            asort($school_off);
                            $hours = array();
                            foreach ($school_off as $key => $value) {
                                $subjectname = $this->GetSubjectName($value->subject_id);
                                $hours[] = array(
                                    'hour' => date('H:i', $value->end_time),
                                    'start_time' => date('H:i', $value->start_time),
                                    'subject_id' => $value->subject_id,
                                    'subject' => trim(ucfirst($subjectname[0]->subject_name))
                                );
                            }
                            asort($hours);
                            
                            $result = array();
                            $have_any_period_found = false;
                            foreach ($hours as $key => $value) {
                                if ($value['start_time'] > date('H:i') && $have_any_period_found == false) {
                                    $have_any_period_found = true;
                                    $subjectname = $this->GetSubjectName($value['subject_id']);
                                    $result[] = array(
                                        'subject_id' => $value['subject_id'],
                                        'start_time' => date('Y-m-d H:i', strtotime($value['start_time'])),
                                        'end_time' => date('Y-m-d H:i', strtotime($value['hour'])),
                                        'subject' => trim(ucfirst($subjectname[0]->subject_name))
                                    );
                                }
                            }
                            
                            $this->response([
                                'status' => false,
                                'message' => 'break',
                                'result' => $result
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                } else {
                    
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'no timetable'
                    ], REST_Controller::HTTP_OK);
                }
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no timetable'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    function GetCurrentServerTime_get()
    {
        $this->response([
            'status' => true,
            'result' => date('Y-m-d H:i')
        ], REST_Controller::HTTP_OK);
    }
    
    /**
     * Save lesson read status of class group
     */
    public function SetClassLessonReadStatus_post()
    {
        try {
            
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $class_id = $this->security->xss_clean(html_escape($request->class_id));
            $section_id = $this->security->xss_clean(html_escape($request->section_id));
            $lesson_code = $this->security->xss_clean(html_escape($request->lesson_code));
            
            if (count($request->studentlist)) {
                $studentlist = array();
                foreach ($request->studentlist as $key => $value) {
                    $student = $this->object_2_array($value);
                    $is_student_found = $this->operation->GetByQuery("SELECT id FROM invantage_users WHERE username = '" . $student['roll_no'] . "'");
                    if (count($is_student_found)) {
                        if ($student['id'] && $is_student_found[0]->id) {
                            $student['id'] = $is_student_found[0]->id;
                            $studentlist[] = $student;
                        }
                    }
                }
            }
            
            $result = array();
            
            if ($class_id && $section_id && $lesson_code) {
                $this->operation->table_name = 'class_group';
                $groupinfo = $this->operation->GetByWhere(array(
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'unique_code'=> $lesson_code
                ));
                $defaultcount = 1;
                if (count($groupinfo)) {
                    $defaultcount = $groupinfo[0]->count + 1;
                    $lesson_progress = array(
                        'count' => $defaultcount,
                        'readed' => date('Y-m-d h:i:s'),
                        'readed_device' => 'w'
                    );
                    
                    $is_value_saved = $this->operation->Create($lesson_progress, $groupinfo[0]->id);
                } else {
                    
                    $lesson_progress = array(
                        'class_id' => $class_id,
                        'section_id' => $section_id,
                        'unique_code'=> $lesson_code,
                        'count' => $defaultcount,
                        'status' => 'r',
                        'readed' => date('Y-m-d h:i:s'),
                        'readed_device' => 'w'
                    );
                    $is_value_saved = $this->operation->Create($lesson_progress);
                }
                
                if (count($is_value_saved)) {
                    if (count($studentlist)) {
                        if (count($studentlist) && ! empty($studentlist[0]['id']))
                            $data = $studentlist;
                            
                            foreach ($data as $key => $value) {
                                $is_lesson_found = $this->operation->GetByQuery("SELECT * FROM lesson_progress WHERE student_id = " . $value['id'] . " AND unique_code ='" . $lesson_code."'");
                                if (count($is_lesson_found) == 0) {
                                    $this->operation->table_name = 'student_lesson_plan';
                                    $studentLessonPlanTable = $this->operation->GetByWhere(array(
                                        'student_id'=> $value['id'],
                                        'lesson_code'=> $lesson_code
                                    ));
                                    
                                    if(count($studentLessonPlanTable))
                                    {
                                        $student_progress = array(
                                            'student_id' => $value['id'],
                                            'lesson_id' => $studentLessonPlanTable[0]->id,
                                            'unique_code' => $lesson_code,
                                            'status' => 'read',
                                            'count' => 1,
                                            'last_updated' => date('Y-m-d h:i:s')
                                        );
                                        
                                        $this->operation->table_name = 'lesson_progress';
                                        $is_value_saved = $this->operation->Create($student_progress);
                                    }
                                    
                                } else {
                                    $defaultcount = $is_lesson_found[0]->count + 1;
                                    
                                    $student_progress = array(
                                        'status' => 'read',
                                        'count' => $defaultcount,
                                        'last_updated' => date('Y-m-d h:i:s')
                                    );
                                    $this->operation->table_name = 'lesson_progress';
                                    $is_value_saved = $this->operation->Create($student_progress, $is_lesson_found[0]->id);
                                }
                            }
                    }
                    $this->response([
                        'status' => true,
                        'message' => 'lessons read'
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'no class found'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no class found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    function GenerateRandomActivity($class_id)
    {
        return $this->operation->GetByQuery("
            SELECT a.* FROM activities a
            LEFT JOIN (SELECT activity_id from activity_class WHERE class_id = " . $class_id . ") d  ON d.activity_id = a.id
            WHERE a.status = 'a'");
    }
    
    function CheckIsValidActivity($student_id, $activity_id)
    {
        return $this->operation->GetByQuery("
            SELECT DISTINCT hour(ap.viewed_datetime) as allowedhours FROM activity_progress ap
            WHERE ap.student_id = " . $student_id . " AND ap.activity_id =" . $activity_id);
    }
    
    function CheckAllViewed($student_id)
    {
        return $this->operation->GetByQuery("
        SELECT DISTINCT ap.activity_id FROM activity_progress ap
        WHERE ap.student_id = " . $student_id);
    }
    
    function GetLastActivity($student_id)
    {
        return $this->operation->GetByQuery("
        SELECT * FROM activity_progress ap
        WHERE ap.student_id = " . $student_id . " AND date(ap.viewed_datetime) = date(NOW())");
    }
    
    function GetRandom_Pick($activity_list)
    {
        return array_rand($activity_list, 1);
    }
    
    function IsActivityPlayed($student_id, $activity_list, $key, $class_id)
    {
        if (count($activity_list)) {
            $is_valid_activity = $this->operation->GetByQuery("
                SELECT * FROM activity_progress ap
                WHERE ap.student_id = " . $student_id . " AND activity_id = " . $activity_list[$key]->id);
            
            if (count($is_valid_activity) == false) {
                
                return $activity_list[$key];
            } else if (count($is_valid_activity) == true) {
                
                $viewed_counting = $this->CheckIsValidActivity($student_id, $activity_list[$key]->id);
                
                if ($activity_list[$key]->repeat == 0 || $activity_list[$key]->repeat == '' && count($viewed_counting) == false) {
                    return $activity_list[$key];
                } else if ($viewed_counting[$key]->allowedhours < $activity_list[$key]->repeat && count($viewed_counting) == true) {
                    return $activity_list[$key];
                } else if ($viewd_counting[$key]->allowedhours == $activity_list[$key]->repeat && count($viewed_counting) == true) {
                    unset($activity_list[$key]);
                    $key = $this->GetRandom_Pick($activity_list);
                    return $this->IsActivityPlayed($student_id, $activity_list, $key);
                }
            }
        } else {
            $activity_list = $this->GenerateRandomActivity($class_id);
            $key = $this->GetRandom_Pick($activity_list);
            return $this->IsActivityPlayed($student_id, $activity_list, $key);
        }
    }
    
    function CheckColumnHasCurrentDate($activity_list)
    {
        if (count($activity_list)) {
            foreach ($activity_list as $key => $value) {
                if ($value->view_date == date('Y-m-d')) {
                    return $key;
                }
            }
            return false;
        }
    }
    
    /**
     * Get activity list
     */
    public function GetActivityList_post()
    {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            
            $class_id = $this->security->xss_clean(html_escape($request->class_id));
            $section_id = $this->security->xss_clean(html_escape($request->section_id));
            $student_id = $this->security->xss_clean(html_escape($request->student_id));
            $lastactivity = $this->security->xss_clean(html_escape($request->lastactivity));
            
            $result = array();
            $temp_array = array();
            $is_activity_played_today = $this->GetLastActivity($student_id);
            if (count($is_activity_played_today)) {
                $this->operation->table_name = "activities";
                $temp_array = $this->operation->GetByWhere(array(
                    'id' => $is_activity_played_today[0]->activity_id
                ));
                $temp_array = $temp_array[0];
            } else {
                $activity_list = $this->GenerateRandomActivity($class_id);
                $key = $this->GetRandom_Pick($activity_list);
                if ($this->CheckColumnHasCurrentDate($activity_list) != false) {
                    $new_key = $this->CheckColumnHasCurrentDate($activity_list);
                    $temp_array = $activity_list[$new_key];
                } else {
                    $temp_array = $this->IsActivityPlayed($student_id, $activity_list, $key, $class_id);
                }
            }
            
            if (count($temp_array)) {
                $viewed_counting = $this->CheckIsValidActivity($student_id, $temp_array->id);
                $this->operation->table_name = "activity_files";
                $links = $this->operation->GetByWhere(array(
                    'activity_id' => $temp_array->id
                ));
                $result[] = array(
                    'id' => $temp_array->id,
                    'title' => $temp_array->title,
                    'links' => $links,
                    'count' => (count($viewed_counting) ? count($viewed_counting) / $temp_array->repeat : 1)
                );
            }
            
            if (count($result)) {
                $this->response([
                    'status' => true,
                    'message' => $result
                ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'no cartoon found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no cartoon found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    /**
     * GetCurrentLoggedinuserdetail
     */
    public function GetStudentDetail_post()
    {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $result = array();
            if ($this->post('student_id')) {
                $this->operation->table_name = "invantage_users";
                $student = $this->operation->GetByWhere(array(
                    'id' => $this->post('student_id')
                ));
                if (count($student)) {
                    $studentclass = $this->operation->GetByQuery("Select * from student_semesters   where student_id =" . $student[0]->id . " AND status = 'r'");
                    
                    $user_locations = $this->operation->GetByQuery("Select ur.school_id,s.* from user_locations ur INNER JOIN schools s ON s.id = ur.school_id where ur.user_id =" . $student[0]->id);
                    
                    $this->operation->table_name = "classes";
                    $class = $this->operation->GetByWhere(array(
                        'id' => $studentclass[0]->class_id
                    ));
                    
                    $this->operation->table_name = "sections";
                    $section = $this->operation->GetByWhere(array(
                        'id' => $studentclass[0]->section_id
                    ));
                    
                    $result[] = array(
                        'id' => $student[0]->id,
                        'name' => $student[0]->screenname,
                        'roll_no' => $student[0]->username,
                        'profile_image' => $this->get_uploaded_file_url($student[0]->profile_image, UPLOAD_CAT_PROFILE),
                        'classserail' => $studentclass[0]->class_id,
                        'sectionserail' => $studentclass[0]->section_id,
                        'semesterserail' => $studentclass[0]->semester_id,
                        'session' => $studentclass[0]->session_id,
                        'class' => $class[0]->grade,
                        'section' => $section[0]->section_name
                    );
                }
                
                if (count($result)) {
                    $this->response([
                        'status' => true,
                        'message' => $result
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'no class found'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no class found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    /**
     * GetStudentSubjectLesson
     */
    public function GetStudentSubjectLesson_post()
    {
        try {
            $result = array();
            $lessondetail = null;
            $total_lessons = 0;
            $current_lesson = 1;
            $is_subject_counted = false;
            if ($this->post('student_id') && $this->post('class_id') && $this->post('section_id')) {
                $this->operation->table_name = 'subjects';
                $subject_list = $this->operation->GetByWhere(array(
                    'class_id' => $this->post('class_id'),
                    'semester_id' => $this->post('semester'),
                    'session_id' => $this->post('session')
                ));
                if (count($subject_list)) {
                    foreach ($subject_list as $key => $value) {
                        
                        $semester_lesson_plan = $this->GetAllLessonBySubject($this->post('class_id'), $this->post('section_id'), $value->id, $this->post('session'), $this->post('semester'));
                        
                        if (count($semester_lesson_plan) > 0) {
                            $total_lessons = count($semester_lesson_plan);
                            foreach ($semester_lesson_plan as $key => $svalue) {
                                
                                if (count($this->CheckisReadedLesson($svalue->id, $this->post('student_id'))) == false && $is_subject_counted == false) {
                                    $lessondetail = $semester_lesson_plan[$key];
                                    $is_subject_counted = true;
                                    $current_lesson = $key + 1;
                                } else if (count($this->CheckisReadedLesson($svalue->id, $this->post('student_id'))) == true) {
                                    $current_lesson += 1;
                                }
                            }
                        }
                        
                        $is_subject_counted = false;
                        if (count($semester_lesson_plan) > 0 && count($lessondetail)) {
                            $result[] = array(
                                'subject_id' => $value->id,
                                'subject' => $value->subject_name,
                                'id' => $lessondetail->id,
                                'name' => $lessondetail->topic,
                                'content' => $lessondetail->content,
                                'notes' => $lessondetail->concept,
                                'current_lesson' => $current_lesson,
                                'total_lessons' => $total_lessons,
                                'read_date' => date('M d, Y'),
                                'type' => $lessondetail->type,
                                'last_update' => date('M d, Y'),
                                'preference' => 0,
                                'lesson_readed' => false,
                                'bliking' => false,
                                'disabled' => false
                            );
                        }
                    }
                }
                
                if (count($result)) {
                    $this->response([
                        'status' => true,
                        'message' => $result
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'no class found'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no class found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    /**
     * Get tags
     */
    public function GetTags_get()
    {
        try {
            $result = array();
            $this->operation->table_name = 'remarks_tags';
            $tags = $this->operation->GetRows();
            if (count($tags)) {
                foreach ($tags as $key => $value) {
                    $result[] = array(
                        'text' => $value->tag
                    );
                }
            }
            
            if (count($result)) {
                $this->response([
                    'status' => true,
                    'message' => $result
                ], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'no class found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no class found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    public function SaveActivityProgress_post()
    {
        try {
            if ($this->post('student_id') && $this->post('activityid')) {
                $this->operation->table_name = 'activity_progress';
                $classes = array(
                    'student_id' => $this->post('student_id'),
                    'activity_id' => $this->post('activityid'),
                    'viewed_datetime' => date('Y-m-d h:i:s'),
                    'activity_iteration' => $this->post('activity_iteration')
                );
                $is_row_saved = $this->operation->Create($classes);
                
                if (count($is_row_saved)) {
                    $this->response([
                        'status' => true,
                        'message' => true
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'no class found'
                    ], REST_Controller::HTTP_NOT_FOUND);
                }
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no class found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    /**
     * Authenticate web-app
     *
     * @input string username
     * @input string password
     *
     * @return json
     */
    function Authenticate_API_Login_post()
    {
        try {
            $loginStaus = false;
            $userObj = array();
            $request = $this->Get_Inputs_For_Angular_Web_APP();
            $this->Cross_Origin_Enable();
            
            // print_r($request);
            
            if(!empty(trim($request->username)) && !empty(trim($request->password)))
            {
                // is valid username && password
                if(!empty(trim($request->username)) && (!is_null(trim($request->password)) && !empty(trim($request->password))))
                {
                    $isUserFound = $this->user->AuthenticateLoginUserByAPI(trim($request->username),trim($request->password));
                    
                    //print_r($isUserFound);
                    
                    if(count($isUserFound))
                    {
                        $loginStaus = true;
                        $userObj = $isUserFound;
                    }
                }
            }
            $this->response([$userObj], REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE
            ], REST_Controller::HTTP_OK);
        }
    }
    
    /**
     * Get grade list. This api used for angular purpose
     *
     * @input int schoolid
     *
     * @return json
     */
    function Get_Grade_Section_List_For_Angular_get()
    {
        try {
            $this->Cross_Origin_Enable();
            if ($this->get('schoolid')) {
                $this->operation->table_name = "classes";
                $query = $this->operation->GetByWhere(array(
                    'school_id' => $this->get('schoolid')
                ));
                $result = array();
                
                if (count($query)) {
                    foreach ($query as $key => $value) {
                        $is_section_found = $this->operation->GetByQuery("SELECT asi.id as asisecid,s.* FROM assign_sections asi INNER JOIN sections s ON s.id = asi.section_id WHERE asi.class_id =" . $value->id);
                        $sectionarray = array();
                        if (count($is_section_found)) {
                            foreach ($is_section_found as $key => $svalue) {
                                $sectionarray[] = array(
                                    'id' => $svalue->id,
                                    'section_name' => $svalue->section_name,
                                    'last_update' => $svalue->last_update
                                );
                            }
                        }
                        $result[] = array(
                            'id' => $value->id,
                            'last_update' => $value->last_update,
                            'grade' => $value->grade,
                            'section' => $sectionarray
                        );
                    }
                }
                
                $this->response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no class found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    /**
     * Get student list. This api used for angular purpose
     *
     * @input int classid
     * @input int sectionid
     * @input int locationid
     * @return json
     */
    function Get_Student_List_By_Class_get()
    {
        try {
            $this->Cross_Origin_Enable();
            
            $result = array();
            if($this->get('classid') && $this->get('sectionid') && $this->get('school_id'))
            {
                $classid =  $request->classid;
                $sectionid = $request->sectionid;
                $school_id = $request->school_id;
                $this->operation->table_name = 'sessions';
                $active_session = $this->operation->GetByWhere(array(
                    'school_id' => $this->get('school_id'),
                    'status' => 'a'
                ));
                
                $this->operation->table_name = 'semester_dates';
                $active_semester = $this->operation->GetByWhere(array(
                    'session_id' => $active_session[0]->id,
                    'status' => 'a'
                ));
                
                $query = $this->operation->GetByQuery("SELECT inv.* FROM invantage_users inv inner join student_semesters ss on inv.id=ss.student_id where ss.class_id=" . $this->get('classid') . " and ss.section_id= " . $this->get('sectionid')  . " and ss.semester_id = " . $active_semester[0]->semester_id . " AND ss.session_id = " . $active_session[0]->id . " AND  ss.status='r' and inv.type='s'");
                if (count($query)) {
                    foreach ($query as $key => $value) {
                        $classInfo = $this->get_user_meta($value->id, 'sgrade');
                        
                        $this->operation->primary_key = 'id';
                        $this->operation->table_name = 'sections';
                        $sectioninfo = $this->operation->GetByWhere(array(
                            'id' => $classInfo
                        ));
                        
                        $classinfodetail = $this->operation->GetByQuery('SELECT ss.class_id,c.grade,ss.section_id,ss.semester_id,s.section_name FROM student_semesters ss INNER JOIN classes c on c.id = ss.class_id INNER JOIN sections s on s.id = ss.section_id  where ss.status = "r" and ss.semester_id = ' . $active_semester[0]->semester_id . ' AND ss.session_id = ' . $active_session[0]->id . ' AND ss.student_id = ' . $value->id);
                        
                        // $profile_image_parts = explode('/', $value->profile_image, 2);
                        // if (! empty($value->profile_image) && $profile_image_parts[0] == '.') {
                        //     // relative path link
                        //     $profile_image = base_url()  . $profile_image_parts[1];
                        // }
                        
                        if (count($classinfodetail)) {
                            $result[] = array(
                                'id' => $value->id,
                                'roll_no' => $value->username,
                                'student_name' => $this->get_user_meta($value->id, 'sfullname') . " " . $this->get_user_meta($value->id, 'slastname'),
                                'password' => $value->password,
                                'class' => $classinfodetail[0]->grade,
                                'class_id' => $classinfodetail[0]->classid,
                                'section_id' => $classinfodetail[0]->sectionid,
                                'section' => $classinfodetail[0]->section_name,
                                'campus' => null,
                                'profile_image' => $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE)
                            );
                        }
                    }
                }
            }
            
            $this->response($result, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'No student found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    
    /**
     * Get subject list. This api used for angular purpose
     *
     * @input int classid
     * @input int sectionid
     * @return json
     */
    function Get_Subject_List_For_Angular_Web_APP_post()
    {
        try {
            $request = $this->Get_Inputs_For_Angular_Web_APP();
            $this->Cross_Origin_Enable();
            $subjectList = array();
            $status = false;
            
            if (!empty(trim($request->class_id))) {
                $class_id = trim($request->class_id);
                $this->operation->table_name = "assignsections";
                $query = $this->operation->GetByWhere(array(
                    'classid' => $class_id,
                    'status' => 'a'
                ));
                
                $section_id = $query[0]->sectionid;
                $this->operation->table_name = "subjects";
                $query = $this->operation->GetByWhere(array(
                    'class_id' => $class_id
                ));
                
                $result = array();
                if (count($query)) {
                    foreach ($query as $key => $value) {
                        
                        $schedule = $this->GetSubjectSchedule($value->id, $class_id, $section_id);
                        $status = true;
                        $subjectList[] = array(
                            'subject_id' => $value->id,
                            'subject_code' => $value->subject_code,
                            'subject_name' => trim($value->subject_name),
                            'subject_image' => $value->subject_image,
                            'start_time' => ($schedule != false ? date('Y-m-d H:i', $schedule['start_time']) : date('Y-m-d')),
                            'end_time' => ($schedule != false ? date('Y-m-d H:i', $schedule['end_time']) : date('Y-m-d')),
                            'last_update' => $value->last_update,
                            'schedule_last_update' => $schedule['last_update']
                        );
                    }
                }
            }
            $this->response( $subjectList
                , REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no subject found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    function Get_Inputs_For_Angular_Web_APP()
    {
        $postdata = file_get_contents("php://input");
        return json_decode($postdata);
    }
    
    function Cross_Origin_Enable()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET,POST OPTIONS");
    }
    
    /**
     * Get student semester info. This api used for angular purpose
     *
     * @input int student_id
     * @return json
     */
    function Get_Student_Semester_Info_For_Angular_Web_APP_post()
    {
        try {
            $request = $this->Get_Inputs_For_Angular_Web_APP();
            $this->Cross_Origin_Enable();
            $class_info = array();
            $section_info = array();
            $semester_info = array();
            $session_info = array();
            $status = false;
            
            if (!empty(trim($request->student_id))) {
                $this->operation->table_name = "student_semesters";
                $query = $this->operation->GetByWhere(array(
                    'student_id' => trim($request->student_id),
                    'status' => 'r'
                ));
                
                $result = array();
                if (count($query)) {
                    $this->operation->table_name = "classes";
                    $class_info = $this->operation->GetByWhere(array(
                        'id' => trim($query[0]->class_id),
                        'status' => 'a'
                    ));
                    
                    $this->operation->table_name = "sections";
                    $section_info = $this->operation->GetByWhere(array(
                        'id' => trim($query[0]->section_id),
                    ));
                    
                    $this->operation->table_name = "semester";
                    $semester_info = $this->operation->GetByWhere(array(
                        'id' => trim($query[0]->semester_id),
                    ));
                    
                    $this->operation->table_name = "sessions";
                    $session_info = $this->operation->GetByWhere(array(
                        'id' => trim($query[0]->session_id),
                    ));
                    $status = true;
                }
            }
            
            $this->response([
                'class' => $class_info,
                'section' => $section_info,
                'semester' => $semester_info,
                'session' => $session_info,
            ], REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no subject found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    function Get_Time_Base_Lessons_After_School($grade_lesson_plan_lessons,$class_id,$session_id, $semester_id,$school_id,$student_id,$section_id)
    {
        $lessons = array();
        $last_id = $this->GetLastReadedLesson($class_id,$section_id,$student_id,'r');
        $enabled_lesson_id = $last_id[0]['id'];
        $allow_lessons_types = $this->Allow_Lesson_types();
        foreach ($grade_lesson_plan_lessons as $key => $value) {
            // $this->operation->table_name = "semester_lesson_plan";
            // $this->operation->primary_key = 'id';
            // $this->operation->order_by = 'asc';
            // $is_lesson_found = $this->operation->GetByWhere(array(
            //     'concept' => $value->concept,
            // ));
            $is_lesson_found = $this->operation->GetByQuery("SELECT * from  semester_lesson_plan where concept = '".$value->concept."' Order by id asc");
            if(count($is_lesson_found))
            {
                $i = 1;
                foreach ($is_lesson_found as $key => $semester_lesson_plan_value) {
                    if(!empty($semester_lesson_plan_value->content) && !empty($semester_lesson_plan_value->lesson) && !empty($semester_lesson_plan_value->topic) && !empty($semester_lesson_plan_value->concept) && in_array($semester_lesson_plan_value->type,$allow_lessons_types)){
                        $total_lessons++;
                        $this->operation->table_name = "subjects";
                        $subject = $this->operation->GetByWhere(array(
                            'id' => trim($semester_lesson_plan_value->subjectid),
                        ));
                        $this->operation->table_name = "classes";
                        $grade = $this->operation->GetByWhere(array(
                            'id' => trim($semester_lesson_plan_value->classid),
                        ));
                        $lesson_image ="http://myaone.sg/images/no-image-lesson.jpg";
                        $file_path = IMAGE_LINK_PATH."content/".$grade[0]->grade."/".$subject[0]->subject_name."/".pathinfo($semester_lesson_plan_value->content, PATHINFO_FILENAME).".png";
                        if( @getimagesize($file_path))
                        {
                            $lesson_image = IMAGE_LINK_PATH."content/".$grade[0]->grade."/".$subject[0]->subject_name."/".pathinfo($semester_lesson_plan_value->content, PATHINFO_FILENAME).".png";
                            /*
                             $lesson_image = $value->profile_image;
                             $profile_image_parts = explode('/', $profile_image, 2);
                             if (! empty($profile_image) && $profile_image_parts[0] == '.') {
                             // relative path link
                             $profile_image = base_url() . DIRECTORY_SEPARATOR . $profile_image_parts[1];
                             }*/
                        }
                        
                        $lessons[] = array(
                            'id'=>$semester_lesson_plan_value->id,
                            'date'=>date('Y-m-d',strtotime($semester_lesson_plan_value->created)),
                            'concept'=>$semester_lesson_plan_value->concept,
                            'content'=>$semester_lesson_plan_value->content,
                            'lesson'=>$semester_lesson_plan_value->lesson,
                            'topic'=>$semester_lesson_plan_value->topic,
                            'type'=>$semester_lesson_plan_value->type,
                            'subject'=>$subject[0]->subject_name,
                            'unit'=>"XXX",
                            'image'=>$lesson_image,
                            'lessons_readed'=>true,
                            'bliking'=>  false ,
                            'enable'=>true,
                        );
                    }
                }
            }
        }
        return $lessons;
    }
    
    function Get_Time_Base_Lessons_In_School($grade_lesson_plan_lessons,$class_id,$session_id, $semester_id,$school_id,$student_id,$section_id,$subject_id)
    {
        $lessons = array();
        $last_id = $this->GetLastReadedLesson($class_id,$section_id,$subject_id,null);
        $enabled_lesson_id = $last_id[0]['id'];
        $allow_lessons_types = $this->Allow_Lesson_types();
        foreach ($grade_lesson_plan_lessons as $key => $value) {
            // $this->operation->table_name = "semester_lesson_plan";
            // $this->operation->primary_key = 'id';
            // $this->operation->order_by = 'asc';
            // $is_lesson_found = $this->operation->GetByWhere(array(
            //     'concept' => $value->concept,
            // ));
            $is_lesson_found = $this->operation->GetByQuery("SELECT * from  semester_lesson_plan where concept = '".$value->concept."' Order by id asc");
            if(count($is_lesson_found))
            {
                $i = 1;
                
                foreach ($is_lesson_found as $key => $semester_lesson_plan_value) {
                    if(!empty($semester_lesson_plan_value->content) && !empty($semester_lesson_plan_value->lesson) && !empty($semester_lesson_plan_value->topic) && !empty($semester_lesson_plan_value->concept) && in_array($semester_lesson_plan_value->type,$allow_lessons_types)){
                        $this->operation->table_name = "subjects";
                        $subject = $this->operation->GetByWhere(array(
                            'id' => trim($semester_lesson_plan_value->subjectid),
                        ));
                        $this->operation->table_name = "classes";
                        $grade = $this->operation->GetByWhere(array(
                            'id' => trim($semester_lesson_plan_value->classid),
                        ));
                        $lesson_image ="http://myaone.sg/images/no-image-lesson.jpg";
                        $file_path = IMAGE_LINK_PATH."content/".$grade[0]->grade."/".$subject[0]->subject_name."/".pathinfo($semester_lesson_plan_value->content, PATHINFO_FILENAME).".png";
                        if( @getimagesize($file_path))
                        {
                            $lesson_image = IMAGE_LINK_PATH."content/".$grade[0]->grade."/".$subject[0]->subject_name."/".pathinfo($semester_lesson_plan_value->content, PATHINFO_FILENAME).".png";
                        }
                        
                        $is_readed = false;
                        if(count($this->CheckisReadedLesson($semester_lesson_plan_value->id,$student_id, 't')))
                        {
                            $is_readed = true;
                        }
                        
                        $is_blinking = ($semester_lesson_plan_value->id == $enabled_lesson_id ? true : false );
                        if($is_blinking)
                        {
                            $is_blinking = true;
                        }
                        $i++;
                        
                        $lessons[] = array(
                            'id'=>$semester_lesson_plan_value->id,
                            'date'=>date('Y-m-d',strtotime($semester_lesson_plan_value->created)),
                            'concept'=>$semester_lesson_plan_value->concept,
                            'content'=>$semester_lesson_plan_value->content,
                            'lesson'=>$semester_lesson_plan_value->lesson,
                            'topic'=>$semester_lesson_plan_value->topic,
                            'type'=>$semester_lesson_plan_value->type,
                            'subject'=>$subject[0]->subject_name,
                            'unit'=>"XXX",
                            'image'=>$lesson_image,
                            'lessons_readed'=>$is_readed,
                            'bliking'=> $is_blinking ,
                            'enable'=>(($is_readed == true || $is_blinking == true) ? true:false),
                            
                        );
                    }
                }
            }
        }
        return $lessons;
    }
    
    function Get_Time_Free_Lessons($grade_lesson_plan_lessons,$class_id,$session_id, $semester_id,$school_id,$student_id, $section_id )
    {
        $lessons = array();
        $last_id = $this->GetLastReadedLesson($class_id,$section_id,$student_id,'t');
        $enabled_lesson_id = $last_id[0]['id'];
        $allow_lessons_types = $this->Allow_Lesson_types();
        $is_next_blinking = true;
        foreach ($grade_lesson_plan_lessons as $key => $value) {
            // $this->operation->table_name = "semester_lesson_plan";
            // $this->operation->primary_key = 'id';
            // $this->operation->order_by = 'asc';
            // $is_lesson_found = $this->operation->GetByWhere(array(
            //     'concept' => $value->concept,
            // ));
            $is_lesson_found = $this->operation->GetByQuery("SELECT * from  semester_lesson_plan where concept = '".$value->concept."' Order by id asc");
            if(count($is_lesson_found))
            {
                $i = 1;
                foreach ($is_lesson_found as $key => $semester_lesson_plan_value) {
                    if(!empty($semester_lesson_plan_value->content) && !empty($semester_lesson_plan_value->concept) && !empty($semester_lesson_plan_value->topic) && !empty($semester_lesson_plan_value->lesson) && in_array($semester_lesson_plan_value->type,$allow_lessons_types)){
                        $total_lessons++;
                        $this->operation->table_name = "subjects";
                        $subject = $this->operation->GetByWhere(array(
                            'id' => trim($semester_lesson_plan_value->subjectid),
                        ));
                        
                        $this->operation->table_name = "classes";
                        $grade = $this->operation->GetByWhere(array(
                            'id' => trim($semester_lesson_plan_value->classid),
                        ));
                        
                        // $lesson_image ="http://myaone.sg/images/no-image-lesson.jpg";
                        
                        $file_path = IMAGE_LINK_PATH."content/".$grade[0]->grade."/".$subject[0]->subject_name."/".pathinfo($semester_lesson_plan_value->content, PATHINFO_FILENAME).".png";
                        $lesson_image = "";
                        if( @getimagesize($file_path))
                        {
                            $lesson_image = IMAGE_LINK_PATH."content/".$grade[0]->grade."/".$subject[0]->subject_name."/".pathinfo($semester_lesson_plan_value->content, PATHINFO_FILENAME).".png";
                        }
                        
                        $is_readed = false;
                        if(count($this->CheckisReadedLesson($semester_lesson_plan_value->id,$student_id, 't')))
                        {
                            $is_readed = true;
                        }
                        
                        $is_progress_found = $this->operation->GetByQuery("SELECT * from  lessonprogress where studentid = ".$student_id." AND lessonid = ".$semester_lesson_plan_value->id);
                        
                        $is_blinking = false;
                        if(count($is_progress_found) == 0 && $is_next_blinking)
                        {
                            $initial_slide = $i;
                            $total_readed_lessons = $i;
                            $is_next_blinking = false;
                            $is_blinking = true;
                        }
                        $i++;
                        
                        $lessons[] = array(
                            'id'=>$semester_lesson_plan_value->id,
                            'date'=>date('Y-m-d',strtotime($semester_lesson_plan_value->created)),
                            'concept'=>$semester_lesson_plan_value->concept,
                            'content'=>$semester_lesson_plan_value->content,
                            'lesson'=>$semester_lesson_plan_value->lesson,
                            'topic'=>$semester_lesson_plan_value->topic,
                            'type'=>$semester_lesson_plan_value->type,
                            'subject'=>$subject[0]->subject_name,
                            'unit'=>"XXX",
                            'image'=>$lesson_image,
                            'lessons_readed'=>$is_readed,
                            'bliking'=> $is_blinking ,
                            'enable'=>(($is_readed == true || $is_blinking == true) ? true:false),
                        );
                    }
                }
            }
        }
        
        return $lessons;
    }
    
    
    /**
     * Get student lessons. This api used for angular purpose
     *
     * @input int classid
     * @input int sectionid
     * @input int semesterid
     * @input int subjectid
     * @input int schoolid
     * @return json
     */
    function Get_Student_Lessons_get()
    {
        try {
            
            $this->Cross_Origin_Enable();
            
            $class_id = $this->get('classid');
            $semester_id = $this->get('semesterid');
            $session_id = $this->get('sessionid');
            $school_id = $this->get('schoolid');
            $mode = $this->get('mode');
            $subject_id = $this->get('subject_id');
            $student_id = $this->get('studentid');
            $section_id = $this->get('sectionid');
            
            $lessons = array();
            $total_lessons = 0;
            $total_readed_lessons = 0;
            $initial_slide = 1;
            $status = false;
            $message_status_code = 0;
            if (!empty($class_id) && !empty($semester_id) && !empty($session_id)
                && !empty($school_id) ) {
                    // this mode is on when student is in class
                    if($mode == 'p')
                    {
                        // schedule base
                        if(!empty($subject_id))
                        {
                            $query = $this->operation->GetByQuery("SELECT * from  grade_lesson_plan where classid = ".$class_id." AND semesterid = ".$semester_id." AND sessionid = ".$session_id." AND schoolid = ".$school_id." AND subjectid = ".$subject_id." Order by seq asc");
                        }
                    }
                    else if($mode == 'o'){
                        // get student readed lessons
                        $query = $this->operation->GetByQuery("SELECT g.* from lessonprogress l INNER JOIN semester_lesson_plan s On s.id = l.lessonid INNER JOIN grade_lesson_plan g On g.concept = s.concept WHERE l.studentid = ".$student_id." order by seq asc");
                        
                    }
                    else{
                        // time-free base
                        $query = $this->operation->GetByQuery("SELECT * from  grade_lesson_plan where class_id = ".$class_id." AND semester_id = ".$semester_id." AND session_id = ".$session_id."  Order by seq asc");
                    }
                    
                    print_r($query);
                    $result = array();
                    if (count($query)) {
                        
                        // regular school with clas
                        switch ($mode) {
                            case 'p':
                                // by class
                                $total_lessons = count($query);
                                $lessons =   $this->Get_Time_Base_Lessons_In_School($query,$class_id,$session_id, $semester_id,$school_id,$student_id,$section_id,$subject_id);
                                $total_lessons = $this->operation->GetByQuery("SELECT count(s.id) as total_lessons FROM grade_lesson_plan g INNER JOIN semester_lesson_plan s On s.concept = g.concept WHERE s.content <> '' AND s.classid = ".$class_id." AND s.sectionid = ".$section_id." AND s.subjectid=".$subject_id);
                                $total_lessons = (int) $total_lessons[0]->total_lessons;
                                $total_readed_lessons = $this->operation->GetByQuery("SELECT count(l.id) as total_readed_lessons from lesson_progress l INNER JOIN semester_lesson_plan s On s.id = l.lessonid WHERE l.studentid = ".$student_id."  AND l.type = 'r' AND s.classid = ".$class_id." AND s.sectionid = ".$section_id." AND s.subjectid=".$subject_id);
                                $total_readed_lessons =(int) $total_readed_lessons[0]->total_readed_lessons;
                                break;
                            case 'o':
                                // by single student after school
                                $lessons =  $this->Get_Time_Base_Lessons_After_School($query,$class_id,$session_id, $semester_id,$school_id,$student_id,$section_id);
                                $total_lessons = $this->operation->GetByQuery("SELECT count(s.id) as total_lessons FROM grade_lesson_plan g INNER JOIN semester_lesson_plan s On s.concept = g.concept WHERE s.content <> '' AND  s.classid = ".$class_id." AND s.sectionid = ".$section_id);
                                $total_lessons = (int) $total_lessons[0]->total_lessons;
                                $total_readed_lessons = $this->operation->GetByQuery("SELECT count(l.id) as total_readed_lessons from lesson_progress l INNER JOIN semester_lesson_plan s On s.id = l.lessonid WHERE l.studentid = ".$student_id);
                                $total_readed_lessons =(int) $total_readed_lessons[0]->total_readed_lessons;
                                
                                break;
                            case 't':
                                // by single student in time-free mode
                                $total_lessons = $this->operation->GetByQuery("SELECT count(s.id) as total_lessons FROM grade_lesson_plan g INNER JOIN semester_lesson_plan s On s.concept = g.concept WHERE s.content <> '' AND  s.class_id = ".$class_id." AND s.section_id = ".$section_id);
                                print_r($this->db->last_query());
                                $total_lessons = (int) $total_lessons[0]->total_lessons;
                                $total_readed_lessons = $this->operation->GetByQuery("SELECT count(l.id) as total_readed_lessons from lesson_progress l INNER JOIN semester_lesson_plan s On s.id = l.lesson_id WHERE l.student_id = ".$student_id."  AND l.type = 't'");
                                $total_readed_lessons =(int) $total_readed_lessons[0]->total_readed_lessons;
                                $lessons = $this->Get_Time_Free_Lessons($query,$class_id,$session_id, $semester_id,$school_id,$student_id, $section_id );
                                break;
                        }
                    }
                    else{
                        $message_status_code = 1;
                    }
                }
                $this->response([
                    'lessons'=>$lessons,
                    'total_lessons'=>$total_lessons,
                    'current_readed_lesson_no'=>$total_readed_lessons,
                    'initial_slide'=>$initial_slide,
                    'total_lesson_read_percentage'=>(int)(($total_readed_lessons*100)/$total_lessons),
                    "message_code"=> $message_status_code
                ], REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no subject found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    /**
     * Suggested lessons for teacher use this for future
     *
     * @input int class_id
     * @input int section_id
     * @input int subject_id
     * @input int school_id
     * @return json
     */
    // function Get_suggested_Lessons_For_Teacher_get()
    // {
    //     try {
    //         $this->Cross_Origin_Enable();
    
    //         $lessons = array();
    //         $total_lessons = 0;
    //         $total_readed_lessons = 0;
    
    //         $status = false;
    //         $initial_slide = 1;
    //         $message_status_code =0;
    //         $current_read_lesson_no = 0;
    //         if ($this->get('class_id') && $this->get('subject_id') && $this->get('section_id') && $this->get('school_id') ) {
    
    //             $this->operation->table_name = 'sessions';
    //             $active_session = $this->operation->GetByWhere(array('school_id'=>$this->get('school_id'),'status'=>'a'));
    
    //             $this->operation->table_name = 'semester_dates';
    //             $active_semester = $this->operation->GetByWhere(array('session_id'=>$active_session[0]->id,'status'=>'a'));
    
    //             $this->operation->table_name = "lesson_set_dates";
    //             $classLessonsSets = $this->operation->GetByQuery("SELECT * from  lesson_set_dates where class_id = ".$this->get('class_id')." AND semester_id = ".$active_semester[0]->semester_id." AND session_id = ".$active_session[0]->id." AND active = 1 Order by set_id");
    
    //             // allow lesson types
    //             $allow_lessons_types = $this->Allow_Lesson_types();
    
    //             $lessonsList = array();
    //             if (count($classLessonsSets)) {
    //                 $message_status_code = 0;
    //                 // find current read lesson set
    //                 $lastLessonReadbyClass = $this->GetLessonsReadByClass( trim($this->get('class_id')) , trim($this->get('section_id')) );
    
    //                 $lessonToRead = 0;
    
    //                 // if only lesson read by class
    //                 if( count($lastLessonReadbyClass) )
    //                 {
    //                     // find current lesson set
    //                     $findLessonSetNumber = $this->operation->GetByQuery("SELECT * from  semester_lesson_plan WHERE subject_id = ".." AND unique_code ='".$lastLessonReadbyClass[0]->unique_code."'");
    //                     echo $this->db->last_query();
    //                     if( count( $findLessonSetNumber ) )
    //                     {
    //                         // find user has finished lessons of current lesson set
    //                         $valid_types = implode(', ', array_values($allow_lessons_types));
    //                         $findAllLessonsInSet = $this->operation->GetByQuery("SELECT * from  semester_lesson_plan WHERE subject_id = ". trim( $this->get( 'subject_id' ) ) ." AND set_id =".$findLessonSetNumber[0]->set_id." AND class_id =". trim($this->get('class_id'))  ." AND semester_id = ". $active_semester[0]->semester_id ." AND session_id = ". $active_session[0]->id ." AND active = 1 AND content != '' AND concept != '' AND topic !='' AND lesson != '' AND type IN('Video','Game','Document')  ORDER BY preference ASC");
    
    //                         // set has any lessons then find any lesson to read from it
    //                         if( count( findAllLessonsInSet ) )
    //                         {
    //                             //$setFirstIndexToBeUnread = $findAllLessonsInSet[0]->set_id;
    //                             foreach ($findAllLessonsInSet as $key => $value)
    //                             {
    //                                 $isLessonAlreadyRead = $this->operation->GetByQuery("SELECT * from  class_group WHERE class_id =".trim($this->get('class_id'))." AND section_id = ".trim($this->get('section_id'))." AND unique_code ='". $value->unique_code."'" );
    //                                 if( count( $isLessonAlreadyRead ) == 0 && $lessonToRead == 0)
    //                                 {
    //                                     $lessonToRead = $value->id;
    //                                 }
    //                             }
    
    //                             if($lessonToRead == 0)
    //                             {
    //                                 $findNextSetId = $this->operation->GetByQuery("SELECT * from  lesson_set_dates WHERE set_id > ". $findAllLessonsInSet[0]->set_id." AND  class_id = ".$this->get('class_id')." AND semester_id = ".$active_semester[0]->semester_id." AND session_id = ".$active_session[0]->id." AND active = 1 ORDER BY set_id");
    //                                 if( count( $findNextSetId ) )
    //                                 {
    //                                     $isLessonFound = $this->operation->GetByQuery("SELECT * from  semester_lesson_plan WHERE subject_id = ". trim( $this->get( 'subject_id' ) ) ." AND set_id =".$findNextSetId[0]->set_id." AND class_id =". trim($this->get('class_id'))  ." AND semester_id = ". $active_semester[0]->semester_id ." AND session_id = ". $active_session[0]->id ." AND active = 1 AND content != '' AND concept != '' AND topic !='' AND lesson != '' AND type IN('Video','Game','Document')  ORDER BY preference ASC");
    //                                     if( Count( $isLessonFound ) )
    //                                     {
    //                                         $lessonToRead = $isLessonFound[0]->id;
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    
    //                 $i = 0 ;
    //                 foreach ($classLessonsSets as $key => $value) {
    
    //                     // get subject lessons set
    //                     $findSetLessons = $this->operation->GetByQuery("SELECT * from  semester_lesson_plan where subject_id = ". trim( $this->get( 'subject_id' ) ) ." AND class_id = ".$this->get('class_id')." AND semester_id = ".$active_semester[0]->semester_id." AND session_id = ".$active_session[0]->id." AND set_id = ".$value->set_id." AND active = 1 Order by preference asc");
    //                     // any lessons found in set
    //                     if( count( $findSetLessons ) )
    //                     {
    //                         foreach ($findSetLessons as $key => $lesson) {
    //                             if(!empty($lesson->content) && !empty($lesson->concept) && !empty($lesson->topic) && !empty($lesson->lesson) && in_array($lesson->type,$allow_lessons_types)){
    
    //                                 $this->operation->table_name = "subjects";
    //                                 $subject = $this->operation->GetByWhere(array(
    //                                     'id' => trim( $this->get( 'subject_id' ) ),
    //                                 ));
    
    //                                 $this->operation->table_name = "classes";
    //                                 $grade = $this->operation->GetByWhere(array(
    //                                     'id' => trim($this->get('class_id')),
    //                                 ));
    
    //                                 $lesson_image ="http://myaone.sg/images/no-image-lesson.jpg";
    
    //                                 $file_path = IMAGE_LINK_PATH."content/".$grade[0]->grade."/".$subject[0]->subject_name."/".pathinfo($lesson->content, PATHINFO_FILENAME).".png";
    //                                 $image_exist = false;
    //                                 if( @getimagesize($file_path))
    //                                 {
    //                                     $lesson_image = IMAGE_LINK_PATH."content/".$grade[0]->grade."/".$subject[0]->subject_name."/".pathinfo($lesson->content, PATHINFO_FILENAME).".png";
    //                                      $image_exist = true;
    //                                 }
    
    //                                 if( $lessonToRead == 0 )
    //                                 {
    //                                     $is_blinking = ($i == 0 ? true : false);
    //                                 }
    //                                 else{
    //                                     $is_blinking = ($lesson->id == $lessonToRead ? true : false);
    //                                 }
    
    //                                 $is_readed = false;
    //                                 $isLessonAlreadyRead = $this->operation->GetByQuery("SELECT * from  class_group WHERE class_id =".trim($this->get('class_id'))." AND section_id = ".trim($this->get('section_id'))." AND unique_code ='". $lesson->unique_code."'" );
    
    //                                 if( count( $isLessonAlreadyRead ) )
    //                                 {
    //                                     $is_readed = true;
    //                                 }
    //                                 $i++;
    
    //                                 $isLessonRead = true;
    //                                 $lessonsList[] = array(
    //                                     'id'=>$lesson->id,
    //                                     'date'=>date('Y-m-d',strtotime($lesson->created)),
    //                                     'concept'=>$lesson->concept,
    //                                     'content'=>$lesson->content,
    //                                     'lesson'=>$lesson->lesson,
    //                                     'topic'=>$lesson->topic,
    //                                     'type'=>$lesson->type,
    //                                     'subject'=>$subject[0]->subject_name,
    //                                     'unit'=>"XXX",
    //                                     'image'=>$lesson_image,
    //                                     'lessons_readed'=>$is_readed,
    //                                     'bliking'=> $is_blinking ,
    //                                     'enable'=>true,
    //                                     'ext'=>"png",
    //                                     'image_exist'=>$image_exist,
    //                                     'unique_code'=>$lesson->unique_code
    //                                 );
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //             else{
    //                 $message_status_code = 1;
    //             }
    //         }
    //         $this->response([
    //             'lessons'=>$lessonsList,
    //             'total_lessons'=>$total_lessons,
    //             'current_readed_lesson_no'=>$current_read_lesson_no,
    //             'initial_slide'=>(int) $initial_slide,
    //             "message_code"=> $message_status_code,
    //             'total_lesson_read_percentage'=>(int)((($total_lessons - $total_readed_lessons == 0 ? $total_lessons : $total_readed_lessons) *100)/$total_lessons)
    //         ], REST_Controller::HTTP_OK);
    //     } catch (Exception $e) {
    //         $this->set_response([
    //             'status' => FALSE,
    //             'message' => 'no subject found'
    //         ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
    //     }
    // }
    
    /**
     * Lessons for teacher
     *
     * @input int class_id
     * @input int section_id
     * @input int subject_id
     * @input int school_id
     * @return json
     */
    function Get_Teacher_Lessons_get()
    {
        try {
            $this->Cross_Origin_Enable();
            
            $lessons = array();
            $total_lessons = 0;
            $total_readed_lessons = 0;
            
            $status = false;
            $initial_slide = 1;
            $message_status_code =0;
            $current_read_lesson_no = 0;
            if ($this->get('class_id') && $this->get('subject_id') && $this->get('section_id') && $this->get('school_id') ) {
                
                $this->operation->table_name = 'sessions';
                $active_session = $this->operation->GetByWhere(array('school_id'=>$this->get('school_id'),'status'=>'a'));
                
                $this->operation->table_name = 'semester_dates';
                $active_semester = $this->operation->GetByWhere(array('session_id'=>$active_session[0]->id,'status'=>'a'));
                
                // allow lesson types
                $allow_lessons_types = $this->Allow_Lesson_types();
                
                $lessonsList = array();
                
                $message_status_code = 0;
                
                $lessonToRead = 0;
                
                $i = 0 ;
                // get subject lessons set
                $findSetLessons = $this->operation->GetByQuery("SELECT * from  semester_lesson_plan where subject_id = ". trim( $this->get( 'subject_id' ) ) ." AND class_id = ".$this->get('class_id')." AND semester_id = ".$active_semester[0]->semester_id." AND session_id = ".$active_session[0]->id." AND active = 1 Order by preference asc");
                $is_blinking = true;
                // any lessons found in set
                if( count( $findSetLessons ) )
                {
                    
                    foreach ($findSetLessons as $key => $lesson) {
                        if(!empty($lesson->content) && !empty($lesson->concept) && !empty($lesson->topic) && !empty($lesson->lesson) && in_array($lesson->type,$allow_lessons_types)){
                            $this->operation->table_name = "subjects";
                            $subject = $this->operation->GetByWhere(array(
                                'id' => trim( $this->get( 'subject_id' ) ),
                            ));
                            
                            $this->operation->table_name = "classes";
                            $grade = $this->operation->GetByWhere(array(
                                'id' => trim($this->get('class_id')),
                            ));
                            
                            $lesson_image ="http://myaone.sg/images/no-image-lesson.jpg";
                            
                            $file_path = base_url()."upload/content/".$grade[0]->grade."/".$subject[0]->subject_name."/".pathinfo($lesson->content, PATHINFO_FILENAME).".png";
                            $image_exist = false;
                            if (@getimagesize($file_path))
                            {
                                $lesson_image = "content/".$grade[0]->grade."/".$subject[0]->subject_name."/".pathinfo($lesson->content, PATHINFO_FILENAME).".png";
                                $image_exist = true;
                            }
                            
                            $isLessonBliking = false;
                            $checkLessonStatus = $this->operation->GetByQuery("SELECT * from  class_group where class_id = ". $this->get('class_id') ." AND section_id = ".$this->get('section_id')." AND status = 'r' AND unique_code = '".$lesson->unique_code."'");
                            if( $is_blinking &&  count($checkLessonStatus) == 0)
                            {
                                $is_blinking = false;
                                $isLessonBliking = true;
                            }
                            
                            $is_readed = false;
                            if( count($checkLessonStatus) )
                            {
                                $is_readed = true;
                            }
                            $i++;
                            
                            $isLessonRead = true;
                            $lessonsList[] = array(
                                'id'=>$lesson->id,
                                'date'=>date('Y-m-d',strtotime($lesson->created)),
                                'concept'=>$lesson->concept,
                                'content'=>$lesson->content,
                                'lesson'=>$lesson->lesson,
                                'topic'=>$lesson->topic,
                                'type'=>$lesson->type,
                                'subject'=>$subject[0]->subject_name,
                                'unit'=>"XXX",
                                'image'=>$this->get_uploaded_file_url($lesson_image, UPLOAD_CAT_CONTENT),
                                'lessons_readed'=>$is_readed,
                                'bliking'=> $isLessonBliking ,
                                'enable'=>true,
                                'ext'=>"png",
                                'image_exist'=>$image_exist,
                                'unique_code'=>$lesson->unique_code
                            );
                        }
                    }
                }
                else{
                    $message_status_code = 1;
                }
            }
            $this->response([
                'lessons'=>$lessonsList,
                'total_lessons'=>0,
                'current_readed_lesson_no'=>0,
                'initial_slide'=>0,
                "message_code"=> $message_status_code,
                'total_lesson_read_percentage'=>0
            ], REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no subject found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    
    /**
     * Get lessons record read by class using new lesson sets concepts.
     *
     * @input int class_id
     * @input int section_id
     * @return json
     */
    
    function GetLessonsReadByClass($class_id , $section_id){
        try{
            return $this->operation->GetByQuery("SELECT * from  class_group where class_id = ".$class_id." AND section_id = ".$section_id."  Order by id desc");
        }
        catch (Exception $e) {}
    }
    
    /**
     * Save lesson status. This api used for angular purpose
     *
     * @input int studentid
     * @input int lessonid
     * @return json
     */
    function Save_Lesson_Progress_post()
    {
        $result['message'] = false;
        try {
            $request = $this->Get_Inputs_For_Angular_Web_APP();
            $this->Cross_Origin_Enable();
            $status = false;
            if (!empty(trim($request->studentid)) && !empty(trim($request->lessonid)) && !empty(trim($request->mode))) {
                $this->operation->table_name = 'lessonprogress';
                $lesson_progress = array(
                    'studentid' => trim($request->studentid),
                    'lessonid' => trim($request->lessonid),
                    'status' => 'read',
                    'count' =>1,
                    'last_updated' => date('Y-m-d h:i:s'),
                    'type' => trim($request->mode)
                );
                $is_value_saved = $this->operation->Create($lesson_progress);
                echo $this->db->last_query();
                $status = true;
            }
            $this->response([
                'status'=>$status
            ], REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
    }
    
    function GetLastReadedLesson($classid, $sectionid,$studentid,$type = null)
    {
        try {
            $not_readed_lessons = array();
            $is_lesson_found = $this->operation->GetByQuery("SELECT * from semester_lesson_plan where  classid = " . $classid . " AND sectionid =" . $sectionid . " AND read_date <> '' And content <> '' And topic <> '' And lesson <> ''  Order By id asc");
            if (count($is_lesson_found)) {
                if (!is_null($type)) {
                    $progress_list = $this->operation->GetByQuery("SELECT * from lessonprogress where  studentid = " . $studentid . " AND status = 'read' AND type = 't'");
                } else {
                    $progress_list = $this->operation->GetByQuery("SELECT * from lessonprogress where  studentid = " . $studentid . " AND status = 'read'");
                }
                
                if (count($progress_list)) {
                    foreach ($is_lesson_found as $key => $value) {
                        
                        if ($this->in_multiarray($value->id, $progress_list) == false) {
                            $not_readed_lessons[] = array(
                                'id' => $value->id
                            );
                        }
                    }
                } else {
                    $not_readed_lessons[] = array(
                        'id' => $is_lesson_found[0]->id
                    );
                }
            }
            return $not_readed_lessons;
        } catch (Exception $e) {}
    }
    
    
    /**
     * Get location period list. This api used for angular purpose
     *
     * @input int studentid
     * @input int lessonid
     * @return json
     */
    function Get_School_Schedule_For_Student_get()
    {
        try {
            date_default_timezone_set("Asia/Karachi");
            $this->Cross_Origin_Enable();
            
            $request = $this->Get_Inputs_For_Angular_Web_APP();
            $class_id = $this->get('classid');
            $section_id = $this->get('sectionid');
            if (!empty($class_id) && !empty($section_id)) {
                $school_off = $this->operation->GetByQuery("
                        SELECT s.* FROM schedule s
                        where s.class_id=" . $class_id . " and s.section_id= " . $section_id . " order by s.start_time");
                if (count($school_off)) {
                    $result = array();
                    $have_any_period_found = false;
                    foreach ($school_off as $key => $value) {
                        $currentperiod = false;
                        $subjectname = trim(parent::GetSubjectName($value->subject_id));
                        $start_time = date('Y-m-d H:i', $value->start_time);
                        $end_time = date('Y-m-d H:i', $value->end_time);
                        
                        if (date('H:i') >= date('H:i', strtotime($start_time)) && date('H:i') <= date('H:i', strtotime($end_time))) {
                            $currentperiod = true;
                            $have_any_period_found = true;
                        }
                        
                        $subjectname = parent::GetSubjectName($value->subject_id);
                        $result[] = array(
                            'id' => $value->id,
                            'subject_id' => $value->subject_id,
                            'start_time' => date('Y-m-d H:i', $value->start_time),
                            'end_time' => date('Y-m-d H:i', $value->end_time),
                            'currentperiod' => $currentperiod,
                            'subject' => trim(ucfirst($subjectname[0]->subject_name))
                        );
                    }
                    
                    if ($have_any_period_found == true) {
                        $this->response([
                            'status' => true,
                            'message' => 'lessons found',
                            'result' => $result
                        ], REST_Controller::HTTP_OK);
                    } else {
                        asort($school_off);
                        $hours = array();
                        foreach ($school_off as $key => $value) {
                            $subjectname = parent::GetSubjectName($value->subject_id);
                            $hours[] = array(
                                'hour' => date('H:i', $value->end_time),
                                'start_time' => date('H:i', $value->start_time),
                                'subject_id' => $value->subject_id,
                                'subject' => trim(ucfirst($subjectname[0]->subject_name))
                            );
                        }
                        rsort($hours);
                        
                        if (date('H:i') >= $hours[0]['hour']) {
                            $this->response([
                                'status' => false,
                                'message' => 'dasyisoff'
                            ], REST_Controller::HTTP_OK);
                        } else {
                            asort($school_off);
                            $hours = array();
                            foreach ($school_off as $key => $value) {
                                $subjectname = parent::GetSubjectName($value->subject_id);
                                $hours[] = array(
                                    'hour' => date('H:i', $value->end_time),
                                    'start_time' => date('H:i', $value->start_time),
                                    'subject_id' => $value->subject_id,
                                    'subject' => trim(ucfirst($subjectname[0]->subject_name))
                                );
                            }
                            asort($hours);
                            
                            $result = array();
                            $have_any_period_found = false;
                            foreach ($hours as $key => $value) {
                                if ($value['start_time'] > date('H:i') && $have_any_period_found == false) {
                                    $have_any_period_found = true;
                                    $subjectname = parent::GetSubjectName($value['subject_id']);
                                    $result[] = array(
                                        'subject_id' => $value['subject_id'],
                                        'start_time' => date('Y-m-d H:i', strtotime($value['start_time'])),
                                        'end_time' => date('Y-m-d H:i', strtotime($value['hour'])),
                                        'subject' => trim(ucfirst($subjectname[0]->subject_name))
                                    );
                                }
                            }
                            
                            $this->response([
                                'status' => false,
                                'message' => 'break',
                                'result' => $result
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                } else {
                    
                    $this->set_response([
                        'status' => FALSE,
                        'message' => 'no timetable'
                    ], REST_Controller::HTTP_OK);
                }
            }else{
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'input invalid'
                ], REST_Controller::HTTP_OK);
            }
        } catch (Exception $e) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'no timetable'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    
    function Get_Total_Lessons_Read_By_Class($class_id,$section_id,$mode = 'r')
    {
        $this->operation->table_name = "class_group";
        $query = $this->operation->GetByWhere(
            array(
                'class_id'=>trim($class_id),
                'section_id'=>trim($section_id),
                'status'=>$mode
            )
            );
        return count($query);
    }
    
    function Allow_Lesson_types()
    {
        return array('Video','Game','Document','Image');
    }
    
    /**
     * Get active semester in school
     *
     * @input int school_id
     *
     * @return json
     */
    function Get_Active_Semester_In_School_get()
    {
        try {
            $semester = array();
            
            if($this->get('school_id'))
            {
                // check school location exist
                $isValidLocation = $this->operation->GetByQuery("SELECT * from schools where id =".$this->get('school_id'));
                
                if(count($isValidLocation))
                {
                    // find active semester in school
                    $isValidLoactiveSemesterDatescation = $this->operation->GetByQuery("SELECT * from semester_dates where status = 'a' AND school_id =".$this->get('school_id'));
                    
                    // if any dates exist
                    if( count($isValidLoactiveSemesterDatescation) )
                    {
                        // return active semester
                        $isSemesterFound = $this->operation->GetByQuery("SELECT * from semester where id =".$isValidLoactiveSemesterDatescation[0]->semester_id);
                        
                        if( count( $isSemesterFound) )
                        {
                            $semester = array(
                                'name'=>$isSemesterFound[0]->semester_name
                            );
                            
                            $this->set_response([
                                'status' => TRUE,
                                'semester' => $semester
                            ], REST_Controller::HTTP_OK);
                        }
                        else{
                            $this->set_response([
                                'status' => FALSE,
                                'semester' => $semester
                            ], REST_Controller::HTTP_OK);
                        }
                    }
                    else{
                        $this->set_response([
                            'status' => FALSE,
                            'semester' => $semester
                        ], REST_Controller::HTTP_OK);
                    }
                }
            }
            else{
                $this->set_response([
                    'status' => FALSE,
                    'semester' => $semester
                ], REST_Controller::HTTP_OK);
            }
            
        } catch (\Throwable $th) {
            $this->set_response([
                'status' => FALSE,
                'semester' => $semester
            ], REST_Controller::HTTP_OK);
        }
    }
    
    
    /**
     * Get active session in school
     *
     * @input int school_id
     *
     * @return json
     */
    function Get_Active_Session_In_School_get()
    {
        try {
            $session = array();
            
            if($this->get('school_id'))
            {
                // check school location exist
                $isValidLocation = $this->operation->GetByQuery("SELECT * from schools where id =".$this->get('school_id'));
                
                if(count($isValidLocation))
                {
                    // return active session
                    $isSessionFound = $this->operation->GetByQuery("SELECT * from sessions where status = 'a' AND school_id =".$this->get('school_id'));
                    
                    if( count( $isSessionFound) )
                    {
                        $session = array(
                            'from'=>$isSessionFound[0]->datefrom,
                            'to'=>$isSessionFound[0]->dateto,
                            'id'=>$isSessionFound[0]->id,
                        );
                        
                        $this->set_response([
                            'status' => TRUE,
                            'session' => $session
                        ], REST_Controller::HTTP_OK);
                    }
                    else{
                        $this->set_response([
                            'status' => FALSE,
                            'session' => $session
                        ], REST_Controller::HTTP_OK);
                    }
                }
            }
            else{
                $this->set_response([
                    'status' => FALSE,
                    'session' => $session
                ], REST_Controller::HTTP_OK);
            }
            
        } catch (\Throwable $th) {
            $this->set_response([
                'status' => FALSE,
                'session' => $semester
            ], REST_Controller::HTTP_OK);
        }
    }
    
    /**
     * Reset user student progress
     *
     * @input int sessionId
     * @input int classId
     * @input int semesterId
     * @input int studentId
     *
     * @return json
     */
    function Reset_Student_Progress_post()
    {
        try {
            if($this->post('sessionId') && $this->post('classId') && $this->post('semesterId')
                && $this->post('studentId'))
            {
                // check valid student
                $isValidStudent = $this->operation->GetByQuery("SELECT * from student_lesson_plan where session_id =".$this->post('sessionId')."
                  AND  semester_id = ". $this->post('semesterId') . " AND class_id =".$this->post('classId')." AND student_id =".$this->post('studentId'));
                
                if(count($isValidStudent))
                {
                    foreach ($isValidStudent as $key => $value) {
                        $this->db->query("DELETE FROM lesson_progress WHERE student_id = ".$this->post('studentId')." AND unique_code = '" . $value->lesson_code."'");
                    }
                    
                    $this->set_response([
                        'status' => TRUE,
                    ], REST_Controller::HTTP_OK);
                }
            }
            else{
                $this->set_response([
                    'status' => FALSE,
                ], REST_Controller::HTTP_OK);
            }
        } catch (\Throwable $th) {
            $this->set_response([
                'status' => FALSE,
            ], REST_Controller::HTTP_OK);
        }
    }
    // Shama v2.0
    function assembly_get()
    {
        
        //echo $this->input->post("schoolid");
       $school_id = $this->input->get('school_id');
        
        
        $assemblydata = array();

            

            
            $query = $this->operation->GetByQuery('Select * from assembly where school_id ='.$school_id);

            if(count($query))

            {

                foreach ($query as $key => $value) {

                    $assemblydata[] = array(

                        'id'=>$value->id,

                        'start_time'=>date("H:i",strtotime($value->start_time)),
                        'end_time'=>date("H:i",strtotime($value->end_time)),

                    );

                }

            }

        

        //echo json_encode($assemblydata);
        $this->response($assemblydata, REST_Controller::HTTP_OK);
    }
    function assembly_update_get()
    {
        $school_id = $this->input->get('school_id');
        
        
        $assemblydata = array();

            

            
            $query = $this->operation->GetByQuery('Select * from assembly where school_id ='.$school_id);

            if(count($query))

            {

                foreach ($query as $key => $value) {

                    $assemblydata[] = array(

                        'id'=>$value->id,

                        'start_time'=>date("H:i",strtotime($value->start_time)),
                        'end_time'=>date("H:i",strtotime($value->end_time)),

                    );

                }

            }

        

        //echo json_encode($assemblydata);
        $this->response($assemblydata, REST_Controller::HTTP_OK);
    }
    function assembly_post()
    {
        
        $request = json_decode( file_get_contents('php://input'));
        
        $inputstarttime = $this->security->xss_clean(trim($request->starttime));
        $inputendtime = $this->security->xss_clean(trim($request->endtime));
        $sresult['message'] = false;
        $school_id = $this->security->xss_clean(trim($request->school_id));
        //$locations = $this->session->userdata('locations');
        if (!is_null($inputstarttime) && !is_null($inputendtime))
        {
            // Date Conditions
            $date1 = date('H:i:s', strtotime($inputstarttime));
            $date2 = date('H:i:s', strtotime($inputendtime));

            if(strtotime($date1) < strtotime($date2)){
                $query = $this->operation->GetByQuery('Select * from assembly where school_id ='.$school_id);
                if($query)
                {

                    $data = array('start_time' => date('H:i:s', strtotime($inputstarttime)), 'end_time' => date('H:i:s', strtotime($inputendtime)), 'updated_at' => date('Y-m-d H:i'));
                    $this->db->where('school_id',$school_id);
                    $this->db->update('assembly',$data);
                    $sresult['message'] = true;
                }
                else
                {
                    $this->operation->table_name = 'assembly';
                    $data = array('start_time' => date('H:i:s', strtotime($inputstarttime)), 'end_time' => date('H:i:s', strtotime($inputendtime)), 'created_at' => date('Y-m-d H:i'), 'school_id' => $school_id);
                    $id = $this->operation->Create($data);
                    if (count($id))
                    {
                        $sresult['message'] = true;
                    }
                }
            }
            else
            {
                $sresult['message'] = false;
            }
        }
        $this->response($sresult, REST_Controller::HTTP_OK);
        //echo json_encode($sresult);
    }
    
    function break_get()
    {
        
        //echo $this->input->post("schoolid");
        $school_id = $this->input->get('school_id');
        $assemblydata = array();

        
            
           
            
            $query = $this->operation->GetByQuery('Select * from break where school_id ='.$school_id);

            if(count($query))

            {

                foreach ($query as $key => $value) {

                    $breakdata[] = array(

                        'id'=>$value->id,
                        'monday_start_time'=>date("H:i",strtotime($value->monday_start_time)),
                        'monday_end_time'=>date("H:i",strtotime($value->monday_end_time)),
                        'tuesday_start_time'=>date("H:i",strtotime($value->tuesday_start_time)),
                        'tuesday_end_time'=>date("H:i",strtotime($value->tuesday_end_time)),
                        'wednesday_start_time'=>date("H:i",strtotime($value->wednesday_start_time)),
                        'wednesday_end_time'=>date("H:i",strtotime($value->wednesday_end_time)),
                        'thursday_start_time'=>date("H:i",strtotime($value->thursday_start_time)),
                        'thursday_end_time'=>date("H:i",strtotime($value->thursday_end_time)),
                        'friday_start_time'=>date("H:i",strtotime($value->friday_start_time)),
                        'friday_end_time'=>date("H:i",strtotime($value->friday_end_time)),
                    );

                }

            }

        
        $this->response($breakdata, REST_Controller::HTTP_OK);
        //echo json_encode($breakdata);
    }
    function breakupdate_get()
    {
        $school_id = $this->input->get('school_id');
        
        
        $assemblydata = array();

            

            
            $query = $this->operation->GetByQuery('Select * from break where school_id ='.$school_id);

            if(count($query))

            {

                foreach ($query as $key => $value) {

                    $breakdata[] = array(

                        'id'=>$value->id,
                        'monday_start_time'=>date("H:i",strtotime($value->monday_start_time)),
                        'monday_end_time'=>date("H:i",strtotime($value->monday_end_time)),
                        'tuesday_start_time'=>date("H:i",strtotime($value->tuesday_start_time)),
                        'tuesday_end_time'=>date("H:i",strtotime($value->tuesday_end_time)),
                        'wednesday_start_time'=>date("H:i",strtotime($value->wednesday_start_time)),
                        'wednesday_end_time'=>date("H:i",strtotime($value->wednesday_end_time)),
                        'thursday_start_time'=>date("H:i",strtotime($value->thursday_start_time)),
                        'thursday_end_time'=>date("H:i",strtotime($value->thursday_end_time)),
                        'friday_start_time'=>date("H:i",strtotime($value->friday_start_time)),
                        'friday_end_time'=>date("H:i",strtotime($value->friday_end_time)),
                    );

                }

            }

        

        //echo json_encode($assemblydata);

        $this->response($breakdata, REST_Controller::HTTP_OK);
    }
    function break_post()
    {
        
        $request = json_decode( file_get_contents('php://input'));

        $monstarttime = $this->security->xss_clean(trim($request->monday_start_time));
        $monendtime = $this->security->xss_clean(trim($request->monday_end_time));
        $tusstarttime = $this->security->xss_clean(trim($request->tuesday_start_time));
        $tusendtime = $this->security->xss_clean(trim($request->tuesday_end_time));
        $wedstarttime = $this->security->xss_clean(trim($request->wednesday_start_time));
        $wedendtime = $this->security->xss_clean(trim($request->wednesday_end_time));
        $thrstarttime = $this->security->xss_clean(trim($request->thursday_start_time));
        $threndtime = $this->security->xss_clean(trim($request->thursday_end_time));
        $fristarttime = $this->security->xss_clean(trim($request->friday_start_time));
        $friendtime = $this->security->xss_clean(trim($request->friday_end_time));
        $school_id = $this->security->xss_clean(trim($request->school_id));
        $sresult['message'] = false;
        
        if (!is_null($monstarttime) && !is_null($monendtime))
        {
            // Date Conditions
                $query = $this->operation->GetByQuery('Select * from break where school_id ='.$school_id);
                if($query)
                {
                    $data = array('monday_start_time' => date('H:i:s', strtotime($monstarttime)), 'monday_end_time' => date('H:i:s', strtotime($monendtime)), 
                                'tuesday_start_time' => date('H:i:s', strtotime($tusstarttime)), 'tuesday_end_time' => date('H:i:s', strtotime($tusendtime)),
                                'wednesday_start_time' => date('H:i:s', strtotime($wedstarttime)), 'wednesday_end_time' => date('H:i:s', strtotime($wedendtime)),
                                'thursday_start_time' => date('H:i:s', strtotime($thrstarttime)), 'thursday_end_time' => date('H:i:s', strtotime($threndtime)),
                                'friday_start_time' => date('H:i:s', strtotime($fristarttime)), 'friday_end_time' => date('H:i:s', strtotime($friendtime)),
                                'updated_at' => date('Y-m-d H:i'), 'school_id' => $school_id
                                );
                    $this->db->where('school_id',$school_id);
                    $this->db->update('break',$data);
                    $sresult['message'] = true;
                }
                else
                {
                    $this->operation->table_name = 'break';
                    $data = array('monday_start_time' => date('H:i:s', strtotime($monstarttime)), 'monday_end_time' => date('H:i:s', strtotime($monendtime)), 
                                'tuesday_start_time' => date('H:i:s', strtotime($tusstarttime)), 'tuesday_end_time' => date('H:i:s', strtotime($tusendtime)),
                                'wednesday_start_time' => date('H:i:s', strtotime($wedstarttime)), 'wednesday_end_time' => date('H:i:s', strtotime($wedendtime)),
                                'thursday_start_time' => date('H:i:s', strtotime($thrstarttime)), 'thursday_end_time' => date('H:i:s', strtotime($threndtime)),
                                'friday_start_time' => date('H:i:s', strtotime($fristarttime)), 'friday_end_time' => date('H:i:s', strtotime($friendtime)),
                                'created_at' => date('Y-m-d H:i'), 'school_id' => $school_id
                                );

                    $id = $this->operation->Create($data);
                    if (count($id))
                    {
                        $sresult['message'] = true;
                    }
                }
        }
            
        $this->response($sresult, REST_Controller::HTTP_OK);
        //echo json_encode($sresult);
    }
    // Time Table

    function show_schedule_list_post()
    {
        date_default_timezone_set("Asia/Karachi");
        
        $date = date('Y-m-d');
        
        $currentday = strtolower(date('D', strtotime($date)));
        $request = json_decode(file_get_contents('php://input'));
        $inputday = $this->security->xss_clean(trim($request->inputday));
        if($inputday)
        {
            $currentday = $inputday;
        }
        $listarray =array();
        $data_array =array();
        $d_start_time = array();
        $d_end_time = array();
        $locations = $this->session->userdata('locations');
        $roles = $this->session->userdata('roles');
        $active_session = parent::GetUserActiveSession();
        $active_semester = parent::GetCurrentSemesterData($active_session[0]->id);
        if( $roles[0]['role_id'] == 3 && count($active_session) && count($active_semester))
        {

            $datameta=$this->data['timetable_list'] = $this->operation->GetRowsByQyery("SELECT sc.*,sc.id,sub.id as subid,subject_name,grade,section_name,screenname,start_time,end_time FROM schedule sc INNER JOIN classes cl ON  sc.class_id=cl.id INNER JOIN invantage_users inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections  sct ON sc.section_id=sct.id WHERE cl.school_id =".$locations[0]['school_id']." AND sub.session_id = ".$active_session[0]->id." AND sub.semsterid = ".$active_semester[0]->semester_id." ORDER by sc.id desc");
            if(count($datameta))
            {
                foreach ($datameta as $key => $value) 
                {
                    $subcod=$this->operation->GetRowsByQyery("select subject_code from subjects where id= ".$value->subid);
                    $value->subject_name=$value->subject_name." (".$subcod[0]->subject_code.")";
                    $value->subject_name;
                    // Create Day wise start and end time
                    $s_time =  $currentday.'_start_time';
                    $e_time =  $currentday.'_end_time';
                    if($value->$s_time=="00:00:00")
                    {
                        $value->start_time = "";
                    }
                    else
                    {
                        $value->start_time = date('H:i',strtotime($value->$s_time));
                    }
                    if($value->$e_time=="00:00:00")
                    {
                        $value->end_time = "";
                    }
                    else
                    {
                        $value->end_time = date('H:i',strtotime($value->$e_time));
                    }
                    
                }
            }
            
       }
       else if( $roles[0]['role_id'] == 4 && count($active_session) && count($active_semester))
       {
            $this->data['timetable_list'] = $this->operation->GetRowsByQyery("SELECT sc.id, subject_name,grade,section_name,username,start_time,end_time FROM schedule sc  INNER JOIN classes cl ON  sc.class_id=cl.id INNER JOIN invantage_users inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections  sct ON sc.section_id=sct.id where sc.teacher_uid=".$this->session->userdata('id')." AND cl.school_id =".$locations[0]['school_id']." AND sub.session_id = ".$active_session[0]->id." AND sub.semsterid = ".$active_semester[0]->semester_id);
            
                
       }
       $data_array = array('select_day'=>$currentday);
       
        foreach ($this->data['timetable_list'] as $key => $element) {
            
            if ($element->start_time=="") {
                
                unset($this->data['timetable_list'][$key]);
            }
        }
        $this->data['timetable_list']= array_values($this->data['timetable_list']); 
        $result[] = array(
                        'listarray'=>$this->data['timetable_list'],
                        
                        'data_array'=>$data_array
                    );

        echo json_encode($result);
        //echo json_encode($this->data['timetable_list']);
    
    }
    function getTimetable()
    {
        try
        {

            $roles = $this->session->userdata('roles');
            $locations = $this->session->userdata('locations');
            $active_session = parent::GetUserActiveSession();
            $active_semester = parent::GetCurrentSemesterData($active_session[0]->id);
            $request = json_decode(file_get_contents('php://input'));
            $grade_id = $this->input->get('grade_id');
            $this->operation->table_name = 'classes';
            $is_class = $this->operation->GetByWhere(array('grade' => $grade_id,'school_id' => $locations[0]['school_id']));
            //print($is_class[0]->id);
            //exit;
            $schedule = array();
            $class_array = array();
            $kindergarten_section = array();
            $rest_section = array();
            $result = array();
            $data_array = array();
            $day_array = array();
            $subject_array = array('day');
            $mon_array = array('day' => "Monday|" );
            $tue_array = array('day' => "Tuesday|" );
            $wed_array = array('day' => "Wednesday|" );
            $thu_array = array('day' => "Thursday|" );
            $fri_array = array('day' => "Friday|" );
            $sat_array = array('day' => "Saturday|" );
            $sun_array = array('day' => "Sunday|" );
            // Assembly time fetch from database
            $this->operation->table_name = 'assembly';
            $is_assembly_found = $this->operation->GetByWhere(array('school_id' => $locations[0]['school_id']));
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
        
            //$currentday = strtolower(date('D', strtotime($date)));
            
            $is_break_found = $this->operation->GetByWhere(array('school_id' => $locations[0]['school_id']));
            if(count($is_break_found))
            {
                    $mon_break = date('H:i', strtotime($is_break_found[0]->monday_start_time)).' - '.date('H:i', strtotime($is_break_found[0]->monday_end_time));
                    $tue_break = date('H:i', strtotime($is_break_found[0]->tuesday_start_time)).' - '.date('H:i', strtotime($is_break_found[0]->tuesday_end_time));
                    $wed_break = date('H:i', strtotime($is_break_found[0]->wednesday_start_time)).' - '.date('H:i', strtotime($is_break_found[0]->wednesday_end_time));
                    $thu_break = date('H:i', strtotime($is_break_found[0]->thursday_start_time)).' - '.date('H:i', strtotime($is_break_found[0]->thursday_end_time));
                    $fri_break = date('H:i', strtotime($is_break_found[0]->friday_start_time)).' - '.date('H:i', strtotime($is_break_found[0]->friday_end_time));
            }
            else
                {
                    $break_start_time = BREAK_START;
                    $break_end_time  = BREAK_END;
                }
               
                
                $query = $this->operation->GetByWhere("SELECT sch.* FROM schedule sch  Where class_id =".$is_class[0]->id." AND sch.semsterid = " . $active_semester[0]->semester_id . " AND sch.sessionid =" . $active_session[0]->id . " Order by sch.id,sch.start_time");
                
                if (count($query))
                {
                    $is_yellow_section_found = false;
                    foreach ($query as $key => $value)
                    {
                        
                        $grade = parent::getClass($value->class_id);
                        $section = parent::getSectionList($value->section_id);
                        $subject = parent::GetSubject($value->subject_id);
                        $teacher = parent::GetUserById($value->teacher_uid);
                        $is_class_found = in_array($grade, $class_array);
                        
                            $mon_status = "Active";
                            $subject_array[] = $value->subject_id;

                            $mon_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->mon_start_time)).' - '.date('H:i', strtotime($value->mon_end_time)).')';
                            $tue_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->tue_start_time)).' - '.date('H:i', strtotime($value->tue_end_time)).')';
                            $wed_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->wed_start_time)).' - '.date('H:i', strtotime($value->wed_end_time)).')';
                            $thu_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->thu_start_time)).' - '.date('H:i', strtotime($value->thu_end_time)).')';
                            $fri_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->fri_start_time)).' - '.date('H:i', strtotime($value->fri_end_time)).')';
                            $sat_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->sat_start_time)).' - '.date('H:i', strtotime($value->sat_end_time)).')';
                            $sun_array[$value->subject_id] =  $subject[0]->subject_name.'| ('.date('H:i', strtotime($value->sun_start_time)).' - '.date('H:i', strtotime($value->sun_end_time)).')';
                            
                    }
                    $schedule = array($mon_array,$tue_array,$wed_array,$thu_array,$fri_array,$sat_array,$sun_array);
                    //$schedule['day_array'] = array('mon'=>'Monday','tue'=>'Tuesday','wed'=>'Wednesday','thu'=>'Thursday','fri'=>'Friday','sat'=>'Saturday','sun'=>'Sunday');

                }
            $data_array = array('grade_name'=>$is_class[0]->grade);
            $result[] = array(
                        'details'=>$schedule,
                        'colums'=>$subject_array,
                        
                        'data_array'=>$data_array
                    );

            echo json_encode($result);
            //echo json_encode($schedule);
        }
        catch(Exception $e)
        {
        }
    }
    function getDayList_get()
    {
        $listarray = array();
        $listarray[] = array("mon"=>"Monday","tue"=>"Tuesday","wed"=>"Wednesday","thu"=>"Thursday","fri"=>"Friday","sat"=>"Saturday","sun"=>"Sunday");
        $this->response($listarray, REST_Controller::HTTP_OK);
        //echo json_encode($listarray);
    }
    // Datesheet

    function Session_Detail_get()
    {
        $this->operation->table_name = 'sessions';
        $sessionarray = array();
        $this->operation->order_by = 'desc';
        $school_id = $this->input->get('school_id');
        $sessionlist = $this->operation->GetByWhere(array('school_id' => $school_id));
        if (count($sessionlist))
        {
            foreach ($sessionlist as $key => $value)
            {
                $sessionarray[] = array('id' => $value->id, 'name' => date('M d, Y', strtotime($value->datefrom)) . ' - ' . date('M d, Y', strtotime($value->dateto)), 'status' => $value->status);
            }
        }
        $this->response($sessionarray, REST_Controller::HTTP_OK);
        //echo json_encode($sessionarray);
    }
    function semesters_get()
    {
        $this->operation->table_name = 'semester';
        $semesterlist = $this->operation->GetRows();
        $school_id = $this->input->get('school_id');
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);

        $semesterarray = array();
        if (count($semesterlist))
        {
            foreach ($semesterlist as $key => $value)
            {
                $semesterarray[] = array('id' => $value->id, 'name' => $value->semester_name,
                
                'status' => ($value->id == $active_semester->semester_id ? 'a' : 'i'), 'active_semster' => ($value->id == $active_semester->semester_id ? 'a' : 'i'));
            }
        }
        if (!is_null($this->input->get('inputsemesterid')))
        {
            $resultlist = $this->operation->GetByWhere(array('id' => $this->input->get('inputsemesterid'),));
            if (count($resultlist))
            {
                $semesterarray = array();
                foreach ($resultlist as $key => $value)
                {
                    $semesterarray[] = array('id' => $value->id, 'name' => $value->semester_name, 'status' => $value->status,);
                }
            }
        }
        $this->response($semesterarray, REST_Controller::HTTP_OK);
        
    }
    
    function datesheet_post()
    {
    
    
        

        $result['message'] = false;
        $request = $this->parse_params();
        $id = $request->id;
        
        $class_id = $request->select_class;
        $school_id = $request->school_id;
        $end_date = $request->enddate;
        $start_date = $request->startdate;
        $notes = $request->notes;
        $exam_type = $request->exam_type;
        $starttime = $request->starttime;
        $endtime = $request->endtime;
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
        $session_id = $active_session->id;

            if($id)
            {
                $subject_schedual_check = true;
                $data =  array(
                            'class_id'=>$class_id,
                            'session_id'=>$active_session->id,
                            'school_id'=>$school_id,
                            'semester_id'=>$active_semester->semester_id,
                            'start_time'=>date('H:i',strtotime($starttime)),
                            'end_time'=>date('H:i',strtotime($endtime)),
                            'notes'=>$notes,
                            'exam_type'=>$exam_type,
                            'start_date'=> date('Y-m-d',strtotime($start_date)),
                            'end_date'=> date('Y-m-d',strtotime($end_date)),
                            'updated_at'=> date('Y-m-d H:i'),
                        );
                $this->operation->table_name = 'datesheets';
                //$id = $this->operation->Create($data);
                //$id = $this->operation->Create($data,$this->input->post('serial'));
                $this->db->where('id',$id);
                $this->db->update('datesheets',$data);
                if(count($id))
                {
                    $result['message'] = true;
                    $result['lastid'] = $id;
                }
            }
            else
            {

                $subject_schedual_check = true;
                // Check Validation
                $this->operation->table_name = 'datesheets';
                $is_datesheet = $this->operation->GetByWhere(array('class_id' => $class_id,'session_id' => $active_session->id,'semester_id' => $active_semester->semester_id,'exam_type' => $exam_type,'school_id' => $school_id));
                
                if(count($is_datesheet)>0)
                {
                    $result['message'] = "false";
                    
                }
                else
                {

                    $data2 =  array(
                                'class_id'=>$class_id,
                                'session_id'=>$active_session->id,
                                'school_id'=>$school_id,
                                'semester_id'=>$active_semester->semester_id,
                                'start_time'=>date('H:i',strtotime($starttime)),
                                'end_time'=>date('H:i',strtotime($endtime)),
                                'notes'=>$notes,
                                'exam_type'=>$exam_type,
                                'start_date'=> date('Y-m-d',strtotime($start_date)),
                                'end_date'=> date('Y-m-d',strtotime($end_date)),
                                'created_at'=> date('Y-m-d H:i'),
                            );

                    // $this->operation->table_name = 'datesheets';
                    // $id = $this->operation->Create($data2);
                    $this->db->insert('datesheets',$data2);
                    
                    $id = $this->db->insert_id();
                    if(count($id))
                    {
                        $result['message'] = "true";
                        $result['lastid'] = $id;
                    }
                }
            }
         
        $this->set_response($result, REST_Controller::HTTP_OK);
        //echo json_encode($result);
    }
    function datesheet_get()
    {
        $id = $this->input->get('serial');
        
        $schedulararray = array();
        
        
            $this->operation->table_name = 'datesheets';
            $schedulalist = $this->operation->GetByWhere(array(
                'id' => $id
            ));
            //print_r($schedulalist);
            if (count($schedulalist)) {
                
                foreach ($schedulalist as $key => $value) {
                    
                    $result = array(
                        'class_id' => $value->class_id,
                        'exam_type' => $value->exam_type,
                        'start_date' => date('d F, Y',strtotime($value->start_date)),
                        'end_date' => date('d F, Y',strtotime($value->end_date)),
                        
                        'start_time' => date('H:i',strtotime($value->start_time)),
                        'end_time' => date('H:i',strtotime($value->end_time)),
                        'notes' => $value->notes,
                        
                        
                    );
                }
            }
        
        $this->set_response($result, REST_Controller::HTTP_OK);
    }
    function datesheets_get()
    {
        $listarray = array();
        $data_array = array();
        
        $request = json_decode(file_get_contents('php://input'));
        $school_id = $this->input->get('school_id');
        ///$inputclassid =  $this->input->get('inputclassid');
        $inputsessionid =  $this->input->get('inputsessionid');
        $inputsemesterid = $this->input->get('inputsemesterid');
        //$inputtype = $this->security->xss_clean(trim($request->inputtype));
        // get active session
        $this->operation->table_name = 'sessions';
        $active_session = $this->operation->GetByWhere(array('school_id'=>$school_id,'status'=>'a'));

        if (!is_null($inputsessionid) && !is_null($inputsemesterid))
        {
            $datesheelist = $this->operation->GetByQuery("SELECT
                            d.id
                            ,d.start_time
                            ,d.end_time
                            ,d.start_date
                            ,d.end_date
                            ,classes.grade
                            , semester.semester_name
                            , d.exam_type
                            , sessions.datefrom
                            , sessions.dateto
                            FROM
                            datesheets as d
                            INNER JOIN classes 
                                ON (d.class_id = classes.id)
                            INNER JOIN semester 
                                ON (semester.id = d.semester_id)
                            
                            INNER JOIN sessions 
                                ON (d.session_id = sessions.id)
                            WHERE
                            d.session_id  = ".$inputsessionid." AND
                            d.semester_id  = ".$inputsemesterid." AND
                            
                            d.school_id =".$school_id." ORDER BY d.created_at desc");
            if (count($datesheelist))
            {   

                foreach ($datesheelist as $key => $value)
                {
                    // Hide Edit and delete option
                    $icon_hide =true;
                    if($inputsessionid==$active_session[0]->id)
                    {
                        $icon_hide = false;
                    }
                    // End here

                    $listarray[] =array('id' => $value->id,'hide' =>$icon_hide ,'start_date'=>date('M d, Y',strtotime($value->start_date)),'end_date'=>date('M d, Y',strtotime($value->end_date)),'start_time'=>date('H:i',strtotime($value->start_time)),'end_time'=>date('H:i',strtotime($value->end_time)),'grade'=>$value->grade,'type'=>$value->exam_type,'semester_name'=>$value->semester_name,'subject_name'=>$value->subject_name,'subject_name'=>$value->subject_name,'exam_date'=>date("M d, Y",strtotime($value->exam_date)),'exam_day'=>date("l",strtotime($value->exam_date)),'action'=>'');
                }

            }
             
            
            // get session date
            $this->operation->table_name = 'sessions';

            $is_session = $this->operation->GetByWhere(array('id'=>$inputsessionid));
            $session_dates =date("Y",strtotime($is_session[0]->datefrom)).' - '.date("Y",strtotime($is_session[0]->dateto));
            
            
            // get semester dates
            $this->operation->table_name = 'semester_dates';

            $semester_date_q = $this->operation->GetByWhere(array('semester_id'=>$inputsemesterid,'session_id'=>$inputsessionid));
            
            $semester_dates =date("M d, Y",strtotime($semester_date_q[0]->start_date)).' - '.date("M d, Y",strtotime($semester_date_q[0]->end_date));
            // get semester name
            $this->operation->table_name = 'semester';

            $semester_name_q = $this->operation->GetByWhere(array('id'=>$inputsemesterid));
            //get school name
            $this->operation->table_name = 'schools';

            $school_name_q = $this->operation->GetByWhere(array('id'=>$school_id));
            
            

            $data_array = array('type'=>$inputtype,'grade'=>$is_class[0]->grade,'session_dates'=>$session_dates,'semester_dates'=>$semester_dates,'semester_name' =>$semester_name_q[0]->semester_name,'school_name'=>$school_name_q[0]->name);
            
             $result[] = array(
                        'listarray'=>$listarray,
                        
                        'data_array'=>$data_array
                    );

            //echo json_encode($result);
            $this->response($result, REST_Controller::HTTP_OK);
        }
        
    }
    function paper_post()
    {
       
        $result['message'] = false;
        //$this->uri->segment(2)
        $request = $this->parse_params();
        
        $school_id = $request->school_id;
        
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
        
            if($request->detail_id)
            {

                $data =  array(
                            'start_time'=>date('H:i',strtotime($request->inputFrom)),
                            'end_time'=>date('H:i',strtotime($request->inputTo)),
                            'exam_date'=>date('Y-m-d',strtotime($request->exam_date)),
                            'subject_id'=>$request->subject_id,
                            'updated_at'=> date('Y-m-d H:i'),
                        );
                $this->operation->table_name = 'datesheet_details';
                $id = $this->operation->Create($data,$request->detail_id);
            }
            else
            {
                 
                
                $data =  array(
                            'datesheet_id'=>$request->datesheet_id,
                            'start_time'=>date('H:i',strtotime($request->inputFrom)),
                            'end_time'=>date('H:i',strtotime($request->inputTo)),
                            'exam_date'=>date('Y-m-d',strtotime($request->exam_date)),
                            'subject_id'=>$request->subject_id,
                            'created_at'=> date('Y-m-d H:i'),
                        );
                $this->operation->table_name = 'datesheet_details';
                $id = $this->operation->Create($data);
            }
                
                if(count($id))
                {
                    $result['message'] = true;
                }
        
        echo json_encode($result);
    }
    function getDatesheetUpdate()
    {

        if(!($this->session->userdata('id'))){

                parent::redirectUrl('signin');

            }

        $locations = $this->session->userdata('locations');

            $roles = $this->session->userdata('roles');

            $result = array();

            if($this->uri->segment(2) AND $this->uri->segment(2) != "page" ){

                $schedule_single = $this->operation->GetRowsByQyery("Select * from datesheets where id= ".$this->uri->segment(2));
                if(Count($schedule_single))
                {
                    $this->data['schedule_single'] = $schedule_single;

                    $result['class_id'] = $schedule_single[0]->class_id;

                    $result['semester_id'] = $schedule_single[0]->semester_id;

                    $result['type'] = $schedule_single[0]->exam_type;
                    $result['start_time'] = date('H:i',strtotime($schedule_single[0]->start_time));

                    $result['end_time'] = date('H:i',strtotime($schedule_single[0]->end_time));

                    $result['start_date'] = date('Y-m-d',strtotime($schedule_single[0]->start_date));
                    $result['end_date'] = date('Y-m-d',strtotime($schedule_single[0]->end_date));

                }

                $this->data['result'] = $result;

        }

        $this->operation->table_name = "subjects";

        $subjectslist = $this->operation->GetRows();

        $subjects = array();

        if(count($subjectslist))

        {

            foreach ($subjectslist as $key => $value) {



                $subjects[] = array(

                    'subid'=>$value->id,

                    'name'=> $value->subject_name." (".$value->subject_code." )",

                    'class'=>parent::getClass($value->class_id),

                );

            }

        }

        // get Detail sheet data
                  
        //$this->operation->table_name = "datesheet_details";
        //$datesheet_list = $this->operation->GetByWhere(array('datesheet_id'=>$this->uri->segment(2)));
        
        $datesheet_list = $this->operation->GetRowsByQyery("Select * from datesheet_details where datesheet_id= ".$this->uri->segment(2)." ORDER BY exam_date");

        $details = array();

        if(count($datesheet_list))

        {

            foreach ($datesheet_list as $key => $value) {



                $details[] = array(

                    'detail_id'=>$value->id,
                    'datesheet_id'=>$value->datesheet_id,
                    'exam_date'=>date('M d, Y',strtotime($value->exam_date)),
                    'exam_day'=>date('l',strtotime($value->exam_date)),
                    'start_time'=>date('H:i',strtotime($value->start_time)),
                    'end_time'=>date('H:i',strtotime($value->end_time)),
                    'subject_name'=>getName('subjects','subject_name',$value->subject_id),
                );

            }

        }

//print_r($details);

        $classlist = $this->operation->GetRowsByQyery("SELECT  * FROM classes c where school_id=".$locations[0]['school_id']);
        
        $this->data['classlist'] = $classlist;



        $this->data['subjects'] = $subjects;

        $this->data['details'] = $details;

        $this->load->view('principal/datesheet/edit_datesheet', $this->data);
        
    }
    function papers_get()
    {
        
        $details = array();
        $request = $this->parse_params();
        
        $serial = $this->input->get('datesheet_id');
        $datesheet_list = $this->operation->GetByQuery("Select * from datesheet_details where datesheet_id= ".$serial." ORDER BY exam_date");

        $details = array();
        $data_array = array();
        if(count($datesheet_list))

        {

            foreach ($datesheet_list as $key => $value) {



                $details[] = array(

                    'detail_id'=>$value->id,
                    'datesheet_id'=>$value->datesheet_id,
                    'exam_date'=>date('M d, Y',strtotime($value->exam_date)),
                    'exam_day'=>date('l',strtotime($value->exam_date)),
                    'start_time'=>date('H:i',strtotime($value->start_time)),
                    'end_time'=>date('H:i',strtotime($value->end_time)),
                    'subject_name'=>getName('subjects','subject_name',$value->subject_id),
                );

            }

        }
        // Datesheet information
        $datesheet_single = $this->operation->GetByQuery("Select * from datesheets where id= ".$serial);
        if(Count($datesheet_single))
        {
            

            $class_id= $datesheet_single[0]->class_id;

            $semester_id = $datesheet_single[0]->semester_id;

            $session_id = $datesheet_single[0]->session_id;
            if($datesheet_single[0]->notes)
            {
                $notes = $datesheet_single[0]->notes;
                $notes_text = "Notes:";
            }
            

            $type = $datesheet_single[0]->exam_type;
            $start_time = date('H:i',strtotime($datesheet_single[0]->start_time));

            $end_time = date('H:i',strtotime($datesheet_single[0]->end_time));

        }

        // Get class Name
            $this->operation->table_name = 'classes';

            $is_class = $this->operation->GetByWhere(array('id'=>$class_id));
            
            
            // get session date
            $this->operation->table_name = 'sessions';

            $is_session = $this->operation->GetByWhere(array('id'=>$session_id));
            $session_dates =date("Y",strtotime($is_session[0]->datefrom)).' - '.date("Y",strtotime($is_session[0]->dateto));
            $session_dates_file_name =date("Y",strtotime($is_session[0]->datefrom)).'-'.date("Y",strtotime($is_session[0]->dateto));
            // get semester dates
            $this->operation->table_name = 'semester_dates';

            $semester_date_q = $this->operation->GetByWhere(array('semester_id'=>$semester_id,'session_id'=>$session_id));
            
            $semester_dates =date("M d, Y",strtotime($semester_date_q[0]->start_date)).' - '.date("M d, Y",strtotime($semester_date_q[0]->end_date));
            // get semester name
            $this->operation->table_name = 'semester';

            $semester_name_q = $this->operation->GetByWhere(array('id'=>$semester_id));
            //get school name
            //$this->operation->table_name = 'schools';

            //$school_name_q = $this->operation->GetByWhere(array('id'=>$locations[0]['school_id']));
            // Create file name
            //$file_name = $session_dates_file_name.'-'.$semester_name_q[0]->semester_name.'-'.$type.'-'.$is_class[0]->grade; 
            $file_name = $type.'-Term-Datesheet'.'-'.$semester_name_q[0]->semester_name.'-'.$session_dates_file_name.'-'.str_replace(' ','-',$is_class[0]->grade); 
            $data_array = array('type'=>$type,'notes_text'=>$notes_text,'notes'=>$notes,'grade'=>$is_class[0]->grade,'session_dates'=>$session_dates,'semester_dates'=>$semester_dates,'semester_name' =>$semester_name_q[0]->semester_name,'school_name'=>$school_name_q[0]->name,'file_name'=>$file_name);
            
             
        // End here
        
        $result[] = array(
                        'details'=>$details,
                        
                        'data_array'=>$data_array
                    );
        $this->response($result, REST_Controller::HTTP_OK);
        
    }
    function DatesheetUpdate ()
    {
        
        
        $locations = $this->session->userdata('locations');
        $request = json_decode(file_get_contents('php://input'));

        $serial = $this->input->get('datesheetinfo');
        $listarray = array();
        $data_array = array();
        $datesheelist = $this->operation->GetRowsByQyery("Select * from datesheets where id= ".$serial);
        if (count($datesheelist))
            {   

                foreach ($datesheelist as $key => $value)
                {

                    $listarray[] =array('id' => $value->id,'notes' => $value->notes,'start_time'=>date('H:i',strtotime($value->start_time)),'end_time'=>date('H:i',strtotime($value->end_time)),'class_id'=>$value->class_id,'type'=>$value->exam_type,'semester_id'=>$value->semester_id,'session_id'=>$value->session_id);
                }

            }
        
        echo json_encode($listarray);
    }
    
    function class_list_get()
    {
        $this->operation->table_name = 'classes';
        $classarray = array();
        $school_id = $this->input->get('school_id');
        $user_id = $this->input->get('user_id');
        if(empty($user_id))
            if ($this->input->get('inputclassid'))
            {
                $classlist = $this->operation->GetByWhere(array('id' => $this->input->get('inputclassid')));
            }
            else
            {
                $classlist = $this->operation->GetByQuery("Select c.* from classes c  where  c.school_id =" . $school_id);
            }
        else
        {
            
            if ($this->input->get('inputclassid'))
            {
                $classlist = $this->operation->GetByWhere(array('id' => $this->input->get('inputclassid')));
            }
            else
            {
                $classlist = $this->operation->GetByQuery("Select c.* from classes c INNER JOIN schedule sc On sc.class_id = c.id where  sc.teacher_uid =" . $user_id . ' group by c.id');
            }
        }

        if (count($classlist))
        {
            foreach ($classlist as $key => $value)
            {
                //$school = parent::GetSchoolDetail($school_id);
                $sectionlist = array();
                $is_section_found = $this->operation->GetByQuery("Select s.id as sectionid,s.section_name,assi.status from assign_sections assi INNER JOIN sections s ON s.id = assi.section_id  where  assi.class_id =" . $value->id);
                if (count($is_section_found))
                {
                    foreach ($is_section_found as $key => $svalue)
                    {
                        $sectionlist[] = array('sectionid' => $svalue->sectionid, 'section_name' => $svalue->section_name, 'status' => $svalue->status,);
                    }
                }
                $classarray[] = array('id' => $value->id, 'name' => $value->grade, 'status' => $value->status, 'sections' => $sectionlist);
            }
        }
        $this->response($classarray, REST_Controller::HTTP_OK);
        //echo json_encode($classarray);
    }
    function paper_get()
    {
        //$request = $this->parse_params();

        $serial = $this->input->get('id');
        $detail_id = $this->input->get('detail_id');
        
        
        $listarray = array();
        $datesheelist = $this->operation->GetByQuery("Select * from datesheet_details where id= ".$detail_id);
        if (count($datesheelist))
            {   

                foreach ($datesheelist as $key => $value)
                {

                    $listarray[] =array('id' => $value->id,'subject_id' => $value->subject_id,'start_time'=>date('H:i',strtotime($value->start_time)),'end_time'=>date('H:i',strtotime($value->end_time)),'exam_date'=>date('d F, Y',strtotime($value->exam_date)));
                }

            }
        $this->response($listarray, REST_Controller::HTTP_OK);
       
    }
    function selected_subject_get()

    {
        $selected_subject = array();

        if ($this->input->get('class_id') != null && is_numeric($this->input->get('class_id'))) 
        {
            $is_student_found = $this->operation->GetByQuery("Select s.* from subjects s  where s.class_id = ".$this->input->get('class_id')."  ");
            if(count($is_student_found)){

                foreach ($is_student_found as $key => $value) {

                    $sections[] = array(

                        'id'=>$value->id,

                        'name'=>$value->subject_name.' ( '.$value->subject_code.' )',
                        'title'=>$value->subject_name

                    );

                }

            }
            
        }

        echo json_encode($sections);
    }
    function Subject_List_By_Class_get()

    {

        $sections = array();

        
        
        $request = $this->parse_params();
        
        $school_id = $this->input->get('school_id');
        $class_id = $this->input->get('class_id');
        //$school_id = $_POST['school_id'];
        //$class_id = $_POST['class_id'];
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);

        if(!empty($class_id))

        {

            $is_student_found = $this->operation->GetByQuery("Select s.* from subjects s  where S.class_id = ".$class_id."  AND s.session_id = ".$active_session->id." AND s.semester_id = ".$active_semester->semester_id);



            if(count($is_student_found)){

                foreach ($is_student_found as $key => $value) {

                    $sections[] = array(

                        'id'=>$value->id,

                        'name'=>$value->subject_name.' ( '.$value->subject_code.' )',
                        'title'=>$value->subject_name

                    );

                }

            }

        }

       

       


        $this->response($sections, REST_Controller::HTTP_OK);
        

    }
    
    function GetSubjectListByClassWeekly_post()
    {
        $sections = array();
        $request = $this->parse_params();
        $school_id = $request->school_id;
        $class_id = $request->class_id;
        //$school_id = $_POST['school_id'];
        //$class_id = $_POST['class_id'];
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
        if(!empty($class_id))
        {
            $is_student_found = $this->operation->GetByQuery("Select s.*,sc.*  from subjects s inner join schedule as sc on sc.subject_id = s.id  where S.class_id = ".$class_id."  AND s.session_id = ".$active_session->id." AND s.semester_id = ".$active_semester->semester_id);
            
            if(count($is_student_found)){
                foreach ($is_student_found as $key => $value) {
                    $sections[] = array(
                        'id'=>$value->id,
                        'name'=>$value->subject_name.' ( '.$value->subject_code.' )',
                        'mon_status' =>$value->mon_status,
                        'mon_start_time' => $value->mon_start_time,
                        'mon_end_time' => $value->mon_end_time,
                        'tue_status' =>$value->tue_status,
                        'tue_start_time' => $value->tue_start_time,
                        'tue_end_time' => $value->tue_end_time,
                        'wed_status' =>$value->wed_status,
                        'wed_start_time' => $value->wed_start_time,
                        'wed_end_time' => $value->wed_end_time,
                        'thu_status' =>$value->thu_status,
                        'thu_start_time' => $value->thu_start_time,
                        'thu_end_time' => $value->thu_end_time,
                        'fri_status' =>$value->fri_status,
                        'fri_start_time' => $value->fri_start_time,
                        'fri_end_time' => $value->fri_end_time,
                        'sat_status' =>$value->sat_status,
                        'sat_start_time' => $value->sat_start_time,
                        'sat_end_time' => $value->sat_end_time,
                        'sun_status' =>$value->sun_status,
                        'sun_start_time' => $value->sun_start_time,
                        'sun_end_time' => $value->sun_end_time,
                        'title'=>$value->subject_name
                    );
                }
            }
        }
        $this->response($sections, REST_Controller::HTTP_OK);
    }

    //function removeDetailDatesheet_get()
    function paper_delete()
    {
        
        $result['message'] = false;

        $removeStudent = $this->db->query("Delete from datesheet_details where id = ".$this->input->get('id'));
        


            if($removeStudent == TRUE):

                $result['message'] = true;

            endif;

            echo json_encode($result);
    }
    function datesheets_delete()
    {
    

    $result['message'] = false;

    $removeStudent = $this->db->query("Delete from datesheets where id = ".$this->input->get('id'));
    


        if($removeStudent == TRUE):

            $result['message'] = true;

        endif;

        echo json_encode($result);
    }
    function quiz_delete()
    {
    

    $result['message'] = false;

    $removeStudent = $this->db->query("Delete from quiz where id = ".$this->input->get('id'));
    


        if($removeStudent == TRUE):

            $result['message'] = true;

        endif;

        echo json_encode($result);
    }
    function quiz_get()
    {

         $q = $this->operation->GetByQuery("SELECT * FROM quiz WHERE id = ".$this->input->get('inputrowid')." ");
        

       //$this->data['classlist'] = $classlist;
       echo json_encode($q);
    }
    // Quiz
    function class_list_teacher_get()
    {
        $user_id = $this->input->get('user_id');
        $school_id = $this->input->get('school_id');
        $role_id = FALSE;
            if ($role = $this->get_user_role($user_id)) {
                $role_id = $role->role_id;
            } 

        if($role_id == 4)
        {
            $classlist = $this->operation->GetByQuery("SELECT c.id as id,c.grade FROM schedule sch INNER JOIN classes c on c.id = sch.class_id  WHERE sch.teacher_uid = ".$this->input->get('user_id')." GROUP by c.id ORDER by c.id asc");
        }
        else
        {

            $classlist = $this->operation->GetByQuery("SELECT c.id as id,c.grade FROM schedule sch INNER JOIN classes c on c.id = sch.class_id where school_id = ".$school_id."  GROUP by c.id ORDER by c.id asc");
        }


       //$this->data['classlist'] = $classlist;
       echo json_encode($classlist);
    }

    function sections_byclass_post()
    {
        $sections = array();
        $request = $this->parse_params();
        $request = $this->parse_params();
        $school_id = $request->school_id;
        $class_id = $request->class_id;
        $user_id = $request->user_id;
        if(!empty($class_id))
        {
                if($user_id)
                {
                    $is_section_found = $this->operation->GetByQuery("SELECT s.*,ass.id as sid  FROM schedule sc INNER JOIN sections s On s.id = sc.section_id INNER JOIN assign_sections ass on ass.section_id = s.id   where sc.teacher_uid = ".$user_id." AND ass.status = 'a' AND sc.class_id = ".$class_id." Group BY s.id");
                }
                else
                {
                    $is_section_found = $this->operation->GetByQuery("SELECT s.*,ass.id as sid  FROM schedule sc INNER JOIN sections s On s.id = sc.section_id INNER JOIN assign_sections ass on ass.section_id = s.id   where  ass.status = 'a' AND sc.class_id = ".$class_id." Group BY s.id");
                }

            }

            if(count($is_section_found)){

                foreach ($is_section_found as $key => $value) {

                    $sections[] = array(

                        'id'=>$value->id,

                        'name'=>$value->section_name,

                    );

                }

            }

       
        //echo json_encode($sections);
        $this->response($sections, REST_Controller::HTTP_OK);


    }
    public function quiz_post()

    {

    

    $postdata = file_get_contents("php://input");

    $request = json_decode($postdata);

    $inputquizname =$this->security->xss_clean(html_escape($request->inputquizname));

    $inputclass =$this->security->xss_clean(html_escape($request->inputclass));

    $inputsection =$this->security->xss_clean(html_escape($request->inputsection));

    $inputsubject =$this->security->xss_clean(html_escape($request->inputsubject));

    $serialinput =$this->security->xss_clean(html_escape($request->serial));

    $input_term_type =$this->security->xss_clean(html_escape($request->input_term_type));

    $inputquizdate =$this->security->xss_clean(html_escape($request->inputquizdate));

    $result['message'] = $serialinput;
    $user_id = $request->user_id;
    //$serialinput = $request->serial;
      

        if(!is_null($serialinput) && !empty($serialinput))
    
                {

                    $quize_array = array(

                    'qname'=>$inputquizname,

                    'class_id'=>$inputclass,

                    'section_id'=>$inputsection,

                    'subject_id'=>$inputsubject,

                    'quiz_term'=>$input_term_type,

                    'quiz_date'=>date('Y-m-d',strtotime($inputquizdate)),

                    'isdone'=>0,

                    'last_update'=>date("Y-m-d H:i"),

                    'datetime'=>date("Y-m-d H:i"),

                    'tacher_uid'=>$user_id,
                    
                    'unique_code'=>''

                );

                $this->operation->table_name = 'quiz';

                $id = $this->operation->Create($quize_array,$serialinput);
                //$this->db->where('id',$serialinput);
                //$this->db->update('quiz',$quize_array);
                //$id = $serialinput
                
                if(count($id)){

                        $result['lastid'] = $id;

                        $result['message'] = true;

                    }



                }



        else if((is_null($serialinput) == true ||  empty($serialinput)) &&!empty($inputquizname) && !empty($inputclass) && !empty($inputsection) && !empty($inputsubject) && !empty($input_term_type) && !empty($inputquizdate))

                    {


                        $school_id = $request->school_id;
                    $active_session = $this->get_active_session($school_id);
                    $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
    


                    $quize_array = array(

                        'qname'=>$inputquizname,

                        'class_id'=>$inputclass,

                        'section_id'=>$inputsection,

                        'subject_id'=>$inputsubject,

                        'quiz_term'=>$input_term_type,

                        'quiz_date'=>date('Y-m-d',strtotime($inputquizdate)),

                        'isdone'=>0,

                        'last_update'=>date("Y-m-d H:i"),

                        'datetime'=>date("Y-m-d H:i"),

                        'tacher_uid'=>$user_id,
                        'semester_id'=>$active_semester->semester_id,
                        'session_id'=>$active_session->id,
                        'school_id'=>$school_id,
                        'unique_code'=>''

                    );


                    
                    $this->operation->table_name = 'quiz';

                    //$id = $this->operation->Create($quize_array);
                    $this->db->insert('quiz',$quize_array);
                    $id = $this->db->insert_id();
                    if(count($id)){

                        $result['lastid'] = $id;

                        $result['message'] = true;

                    }

                }







    echo json_encode($result);

}
    function question_post()
    {
        
        
        
            $this->load->library('image_lib');
            if ($this->input->post('questionid'))
            {
                $title_image_name = '';
                $filename_thumb = '';
                $title_image_uploaded = false;
                if (isset($_FILES['title_image']))
                {
                    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
                    if (strlen($_FILES['title_image']['name']))
                    {
                        list($txt, $ext) = explode(".", strtolower($_FILES['title_image']['name']));
                        if (in_array(strtolower($ext), $valid_formats))
                        {
                            if ($_FILES['title_image']["size"] < 5000000)
                            {
                                $title_image_name = time() . $_FILES['title_image']['name'];
                                if (is_uploaded_file($_FILES['title_image']['tmp_name']))
                                {
                                    $path = UPLOAD_PATH . 'quiz_images/';
                                    $filename = $path . $title_image_name;
                                    if (move_uploaded_file($_FILES['title_image']['tmp_name'], $filename))
                                    {
                                        $title_image_uploaded = true;
                                        chmod($filename, 0777);
                                        $config = array('image_library' => 'gd2', 'source_image' => $filename, 'new_image' => $filename, 'create_thumb' => true, 'maintain_ratio' => true, 'quality' => 100, 'width' => 350, 'height' => 350);
                                        $this->image_lib->initialize($config);
                                        $this->image_lib->resize();
                                        $thumbname = explode('.', $title_image_name);
                                        $quize_array = array('img_src' => $title_image_name, 'thumbnail_src' => $thumbname[0] . '_thumb.' . $thumbname[1],);
                                        $this->operation->table_name = 'quiz_questions';
                                        $update_query = $this->operation->Create($quize_array, $this->input->post('questionid'));
                                    }
                                }
                            }
                        }
                    }
                }
                $quize_array = array('question' => $this->input->post('title'), 'last_update' => date("Y-m-d H:i"), 'type' => ($this->input->post('q_type') == 1 ? 't' : 'i'),);
                $this->operation->table_name = 'quiz_questions';
                $qid = $this->operation->Create($quize_array, $this->input->post('questionid'));
                if ($this->input->post('q_type') == 1)
                {
                    $option_name = array('inputoption_one', 'inputoption_two', 'inputoption_three', 'inputoption_four');
                    $optionlist = $this->operation->GetByQuery("SELECT o.* FROM qoptions o INNER JOIN quiz_options qo ON o.id = qo.qoption_id where qo.questionid =" . $this->input->post('questionid') . " order by id asc");
                    for ($i = 0;$i <= count($optionlist) - 1;$i++)
                    {
                        $cur_iter = $i + 1;
                        $option_array = array('option_value' => $this->input->post($option_name[$i]), 'edited' => date("Y-m-d H:i"),);
                        $this->operation->table_name = 'qoptions';
                        $qoid = $this->operation->Create($option_array, $optionlist[$i]->id);
                        $this->operation->table_name = "correct_option";
                        $correct_option_is_found = $this->operation->GetByWhere(array('question_id' => $this->input->post('questionid')));
                        if ($this->input->post('inputoption_true') == $cur_iter && count($correct_option_is_found))
                        {
                            $correct_option = array('correct_id' => $qoid, 'question_id' => $qid,);
                            $this->operation->table_name = 'correct_option';
                            $correct_id = $this->operation->Create($correct_option, $correct_option_is_found[0]->id);
                        }
                    }
                }
                $optionlist = $this->operation->GetByQuery("SELECT o.* FROM qoptions o INNER JOIN quiz_options qo ON o.id = qo.qoption_id where qo.questionid =" . $this->input->post('questionid') . " order by id asc");
                for ($i = 0;$i <= count($optionlist) - 1;$i++)
                {
                    $cur_iter = $i + 1;
                    $this->operation->table_name = "correct_option";
                    $correct_option_is_found = $this->operation->GetByWhere(array('question_id' => $this->input->post('questionid')));
                    if ($this->input->post('inputoption_true') == $cur_iter)
                    {
                        $correct_option = array('correct_id' => $optionlist[$i]->id,);
                        $this->operation->table_name = 'correct_option';
                        $correct_id = $this->operation->Create($correct_option, $correct_option_is_found[0]->id);
                    }
                }
                if ($this->input->post('q_type') == 2)
                {
                    $optionlist = $this->operation->GetByQuery("SELECT o.* FROM qoptions o INNER JOIN quiz_options qo ON o.id = qo.qoption_id where qo.questionid =" . $this->input->post('questionid') . " order by id asc");
                    $option_imag_name = array('option_image_1', 'option_image_2', 'option_image_3', 'option_image_4');
                    for ($i = 0;$i < 4;$i++)
                    {
                        if (isset($_FILES[$option_imag_name[$i]]))
                        {
                            $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
                            if (strlen($_FILES[$option_imag_name[$i]]['name']))
                            {
                                list($txt, $ext) = explode(".", strtolower($_FILES[$option_imag_name[$i]]['name']));
                                if (in_array(strtolower($ext), $valid_formats))
                                {
                                    if ($_FILES[$option_imag_name[$i]]["size"] < 5000000)
                                    {
                                        $title_image_name = time() . $_FILES[$option_imag_name[$i]]['name'];;
                                        $biger_thumbnail = time() . trim(basename($txt . "bigger_thumb." . $ext));
                                        if (is_uploaded_file($_FILES[$option_imag_name[$i]]['tmp_name']))
                                        {
                                            $path = UPLOAD_PATH . 'option_images/';
                                            $filename = $path . $title_image_name;
                                            if (move_uploaded_file($_FILES[$option_imag_name[$i]]['tmp_name'], $filename))
                                            {
                                                $title_image_uploaded = true;
                                                chmod($filename, 0777);
                                                $config = array('image_library' => 'gd2', 'source_image' => $filename, 'new_image' => $filename, 'create_thumb' => true, 'maintain_ratio' => true, 'quality' => 100, 'width' => 350, 'height' => 350);
                                                $this->image_lib->initialize($config);
                                                $this->image_lib->resize();
                                                $cur_iter = $i + 1;
                                                $option_array = array('option_value' => $title_image_name, 'created' => date("Y-m-d H:i"), 'edited' => date("Y-m-d H:i"), 'thumbnail_src' => $biger_thumbnail,);
                                                $this->operation->table_name = 'qoptions';
                                                $qoid = $this->operation->Create($option_array, $optionlist[$i]->id);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $result['message'] = true;
            }
            else if ($this->input->post('quiz_id'))
            {
                // add question
                $title_image_name = '';
                $filename_thumb = '';
                $title_image_uploaded = false;
                if (isset($_FILES['title_image']))
                {
                    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
                    if (strlen($_FILES['title_image']['name']))
                    {
                        list($txt, $ext) = explode(".", strtolower($_FILES['title_image']['name']));
                        if (in_array(strtolower($ext), $valid_formats))
                        {
                            if ($_FILES['title_image']["size"] < 5000000)
                            {
                                $title_image_name = time() . $_FILES['title_image']['name'];
                                if (is_uploaded_file($_FILES['title_image']['tmp_name']))
                                {
                                    $path = UPLOAD_PATH . 'quiz_images/';
                                    $filename = $path . $title_image_name;
                                    if (move_uploaded_file($_FILES['title_image']['tmp_name'], $filename))
                                    {
                                        $title_image_uploaded = true;
                                        chmod($filename, 0777);
                                        $config = array('image_library' => 'gd2', 'source_image' => $filename, 'new_image' => $filename, 'create_thumb' => true, 'maintain_ratio' => true, 'quality' => 100, 'width' => 350, 'height' => 350);
                                        $this->image_lib->initialize($config);
                                        $this->image_lib->resize();
                                    }
                                }
                            }
                        }
                    }
                }
                $thumbname = explode('.', $title_image_name);
                $quize_array = array('quiz_id' => $this->input->post('quiz_id'), 'question' => $this->input->post('title'), 'last_update' => date("Y-m-d H:i"), 'img_src' => $title_image_name, 'thumbnail_src' => $thumbname[0] . '_thumb.' . $thumbname[1], 'type' => ($this->input->post('q_type') == 1 ? 't' : 'i'),);
                $this->operation->table_name = 'quiz_questions';
                $qid = $this->operation->Create($quize_array);
                if ($this->input->post('q_type') == 1)
                {
                    $option_name = array('inputoption_one', 'inputoption_two', 'inputoption_three', 'inputoption_four');
                    for ($i = 0;$i < 4;$i++)
                    {
                        $cur_iter = $i + 1;
                        $option_array = array('option_value' => $this->input->post($option_name[$i]), 'created' => date("Y-m-d H:i"), 'edited' => date("Y-m-d H:i"),);
                        $this->operation->table_name = 'qoptions';
                        $qoid = $this->operation->Create($option_array);
                        $qoption_array = array('questionid' => $qid, 'qoption_id' => $qoid, 'last_update' => date("Y-m-d H:i"), 'created' => date("Y-m-d H:i"),);
                        $this->operation->table_name = 'quiz_options';
                        $q_option_id = $this->operation->Create($qoption_array);
                        if ($this->input->post('inputoption_true') == $cur_iter)
                        {
                            $correct_option = array('correct_id' => $qoid, 'question_id' => $qid,);
                            $this->operation->table_name = 'correct_option';
                            $correct_id = $this->operation->Create($correct_option);
                        }
                    }
                }
                if ($this->input->post('q_type') == 2)
                {
                    $option_imag_name = array('option_image_1', 'option_image_2', 'option_image_3', 'option_image_4');
                    for ($i = 0;$i < 4;$i++)
                    {
                        if (isset($_FILES[$option_imag_name[$i]]))
                        {
                            $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
                            if (strlen($_FILES[$option_imag_name[$i]]['name']))
                            {
                                list($txt, $ext) = explode(".", strtolower($_FILES[$option_imag_name[$i]]['name']));
                                if (in_array(strtolower($ext), $valid_formats))
                                {
                                    if ($_FILES[$option_imag_name[$i]]["size"] < 5000000)
                                    {
                                        $title_image_name = time() . $_FILES[$option_imag_name[$i]]['name'];;
                                        $biger_thumbnail = time() . trim(basename($txt . "bigger_thumb." . $ext));
                                        if (is_uploaded_file($_FILES[$option_imag_name[$i]]['tmp_name']))
                                        {
                                            $path = UPLOAD_PATH . 'option_images/';
                                            $filename = $path . $title_image_name;
                                            if (move_uploaded_file($_FILES[$option_imag_name[$i]]['tmp_name'], $filename))
                                            {
                                                $title_image_uploaded = true;
                                                chmod($filename, 0777);
                                                $config = array('image_library' => 'gd2', 'source_image' => $filename, 'new_image' => $filename, 'create_thumb' => true, 'maintain_ratio' => true, 'quality' => 100, 'width' => 350, 'height' => 350);
                                                $this->image_lib->initialize($config);
                                                $this->image_lib->resize();
                                                $cur_iter = $i + 1;
                                                $option_array = array('option_value' => $title_image_name, 'created' => date("Y-m-d H:i"), 'edited' => date("Y-m-d H:i"), 'thumbnail_src' => $biger_thumbnail,);
                                                $this->operation->table_name = 'qoptions';
                                                $qoid = $this->operation->Create($option_array);
                                                $qoption_array = array('questionid' => $qid, 'qoption_id' => $qoid, 'last_update' => date("Y-m-d H:i"), 'created' => date("Y-m-d H:i"),);
                                                $this->operation->table_name = 'quiz_options';
                                                $q_option_id = $this->operation->Create($qoption_array);
                                                if ($this->input->post('inputoption_true') == $cur_iter)
                                                {
                                                    $correct_option = array('correct_id' => $qoid, 'question_id' => $qid,);
                                                    $this->operation->table_name = 'correct_option';
                                                    $correct_id = $this->operation->Create($correct_option);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $result['message'] = true;
            }
        
        echo json_encode($result);
    }
    function questions_get()
    {
        
        
        if(!is_null($this->input->get('id')) && is_numeric($this->input->get('id')))
        {
            $questionlist = $this->operation->GetByQuery("SELECT * FROM  quiz_questions where quiz_id = ".$this->input->get('id')."  order by id desc");
            
        }
        else
        {
            exit();
            // $questionlist = $this->operation->GetRowsByQyery("SELECT * FROM quizequestions  order by id desc");
        }

        $qlist = array();
        if(count($questionlist)){
            foreach ($questionlist as $key => $value) {
                $optionlist = $this->operation->GetByQuery("SELECT o.* FROM qoptions o INNER JOIN quiz_options qo ON o.id = qo.qoption_id where qo.questionid =".$value->id);
                $temp = array();
                $this->operation->table_name = "correct_option";
                $correct_index = 1;
                $correct_option = $this->operation->GetByWhere(array('question_id'=>$value->id));
                if(count($optionlist)){
                    $i = 1 ;
                    foreach ($optionlist as $key => $ovalue) {
                        $temp1 = array();
                        if($value->type == 't')
                        {

                            $temp1['option'] = $ovalue->option_value;
                            $temp1['image_src'] = '';
                        }
                        else{
                            $thumbname = explode('.', $ovalue->option_value);
                            $temp1['option'] = base_url().'upload/option_images/'.$thumbname[0].'_thumb.'.$thumbname[1];
                            $temp1['image_src'] = base_url().'upload/option_images/'.$ovalue->option_value;
                        }

                        if($correct_option[0]->correct_id == $ovalue->id)
                        {
                            $correct_index = $i;
                        }
                        else{
                            $i++;
                        }
                        array_push($temp, $temp1);
                    }
                }

                $thumbname = '';
                if(!is_null($value->img_src)){
                    $thumbname = explode('.', $value->img_src);
                }


                $qlist[]  = array(
                    'id'=>$value->id,
                    'quiz_id'=>$value->quiz_id,
                    'thumbnail_src'=>(count($thumbname) == 2 ? base_url().'upload/quiz_images/'.$thumbname[0].'_thumb.'.$thumbname[1] : ''),
                    'image_src'=>($value->img_src != '' ? base_url().'upload/quiz_images/'.$value->img_src : ''),
                    'question'=>$value->question,
                    'options'=>$temp,
                    'quiz_type'=>$value->type,
                    'correct'=>$correct_index,
                );
            }
        }


        //echo json_encode($qlist);
        $this->response($qlist, REST_Controller::HTTP_OK);
    }
    function question_get()
    {

       
        $response = array();

        if(!is_null($this->input->get('qid')) && is_numeric($this->input->get('qid')))
        {

            $is_question_found = $this->operation->GetByQuery("SELECT * FROM quiz_questions where id =".$this->input->get('qid'));



            if(count($is_question_found))

            {

                $is_question_option_found = $this->operation->GetByQuery("SELECT o.* FROM qoptions o INNER JOIN quiz_options qo ON o.id = qo.qoption_id where qo.questionid = ".$this->input->get('qid'));

                if(count($is_question_option_found))

                {

                    $options = array();
                    $this->operation->table_name = "correct_option";
                    $correct_index = 1;
                    $correct_option = $this->operation->GetByWhere(array('question_id'=>$this->input->get('qid')));
                    $i = 1 ;
                    foreach ($is_question_option_found as $key => $value) {

                        $option = '';
                        if($is_question_found[0]->type == 't')
                        {

                            $option = $value->option_value;
                        }
                        else{
                            $thumbname = explode('.', $value->option_value);
                            $option = base_url().'upload/option_images/'.$thumbname[0].'_thumb.'.$thumbname[1];
                        }


                        $options[] = array(

                            'optionid'=>$value->id,

                            'option'=>$option,



                        );

                        if($correct_option[0]->correct_id == $value->id)
                        {
                            $correct_index = $i;
                        }
                        else{
                            $i++;
                        }

                    }

                    $thumbname = '';
                    if(!is_null($is_question_found[0]->img_src)){
                        $thumbname = explode('.', $is_question_found[0]->img_src);
                    }


                    $response[] = array(

                        'question'=>$is_question_found[0]->question,
                        'thumbnail_src'=>(count($thumbname) == 2 ? base_url().'upload/quiz_images/'.$thumbname[0].'_thumb.'.$thumbname[1] : ''),
                        'questionid'=>$is_question_found[0]->id,
                        'options'=>$options,
                        'correct'=>$correct_index,
                        'type'=>($is_question_found[0]->type == 't' ? 1 : 2),

                    );

                }

            }

        }

        echo json_encode($response);

    }
    function question_delete()

            {



        $result['message'] = false;



        $removeSubject = $this->db->query("Delete from quiz_questions where id =".trim($_GET['id']));







        if($removeSubject == TRUE):



            $result['message'] = true;



        endif;



        echo json_encode($result);



    }
    public function quizzes_get()
    {
        

            $quiz_list = $this->operation->GetByQuery("SELECT q.id,grade,section_name,subject_name,qname,isdone,q.quiz_date from quiz q INNER JOIN classes c on q.class_id=c.id INNER JOIN sections sc on q.section_id=sc.id INNER JOIN subjects sb on q.subject_id=sb.id  Where    q.tacher_uid=".$this->input->get('user_id')." group by q.id");
       $result[] = array(
                        'listarray'=>$quiz_list,
                        
                        
                    );
       $this->response($result, REST_Controller::HTTP_OK);
    }
    function student_quiz_marks_get()
    {
        
        $resultarray = array();

        if (!is_null($this->input->get('subject_id')) && !is_null($this->input->get('class_id')) && !is_null($this->input->get('section_id')) && !is_null($this->input->get('semester_id')) && !is_null($this->input->get('session_id')))
        {
            $school_id = $this->input->get('school_id');
            $active_session = $this->get_active_session($school_id);
            $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
            
            $resultlist = $this->operation->GetByQuery('SELECT s.* FROM `student_semesters` as s INNER JOIN  invantage_users AS i ON s.student_id = i.id where s.class_id = ' . $this->input->get('class_id') . " AND s.section_id = " . $this->input->get('section_id') . " AND s.semester_id = " . $active_semester->semester_id . " AND s.session_id = " . $active_session->id . " ORDER BY i.screenname ASC ");
            if (count($resultlist))
            {

                foreach ($resultlist as $key => $value)
                {
                    // get Quizes 

                    // $roles = $this->session->userdata('roles');
                    // if ($roles[0]['role_id'] == 4)
                    // {
                    //     $query = $this->operation->GetByQuery("SELECT q.* FROM quiz q INNER JOIN semester s ON s.id = q.semster_id INNER JOIN sessions se ON se.id = q.session_id Where q.subjec_tid = " . $this->input->get('subject_id') . " AND q.class_id = " . $this->input->get('class_id') . " AND q.section_id = " . $this->input->get('section_id') . " AND q.tacher_uid = " . $this->session->userdata('id') . " AND q.semester_id = " . $this->input->get('semester_id') . " AND q.session_id = " . $this->input->get('session_id') . "  AND q.quiz_term = '".$this->input->get('quiz_type')."'  order by q.quiz_date asc");
                    // }
                    // else
                    // {

                        $query = $this->operation->GetByQuery("SELECT q.* FROM quiz q INNER JOIN semester s ON s.id = q.semester_id INNER JOIN sessions se ON se.id = q.session_id Where q.subject_id = " . $this->input->get('subject_id') . " AND q.class_id = " . $this->input->get('class_id') . " AND q.section_id = " . $this->input->get('section_id') . " AND q.semester_id = " . $active_semester->semester_id . " AND q.session_id = " . $active_session->id . " AND q.quiz_term = '".$this->input->get('quiz_type')."' order by q.quiz_date asc");
                    //}
                    
                    if(count($query)==0)
                    {
                        $resultarray[] = "";
                        exit;
                    }
                    $marksarray = array();
                    $quizidarray = array();
                    //$quizidarray = array('quizid' => 0);
                    if (count($query))
                    {
                        foreach ($query as $key => $value1)
                        {
                            $termlist = $this->operation->GetByQuery('SELECT * FROM quizzes_marks  where quiz_id = '.$value1->id.' AND student_id = ' . $value->student_id . "  AND subject_id = " . $this->input->get('subject_id'));
                            if (count($termlist))
                            {
                                foreach ($termlist as $key => $tvalue)
                                {
                                    $marksarray[] = array('studentmarks' => $tvalue->marks);
                                }
                            }
                            else
                            {
                                $marksarray[] = array('studentmarks' => 0);
                            }
                            $quizidarray[] = array('quizid' => $value1->id);
                        }
                    }
                    else
                    {
                        $marksarray = array(array('studentmarks' => 0));
                        
                    }

                    $resultarray[] = array('id' => $value->id, 'quiz_id' => $quizidarray ,'marks' => $marksarray, 'student_id' => $value->student_id, 'name' => parent::getUserMeta($value->student_id, 'sfullname') . " (" . parent::getUserMeta($value->student_id, 'roll_number') . ")",);
                }
            }
          
        }
        $this->response($resultarray, REST_Controller::HTTP_OK);
        //echo json_encode($resultarray);
    }
    function student_marks_get()
    {
        $resultarray = array();
        $school_id = $this->input->get('school_id');
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
        
        if (!is_null($this->input->get('subject_id')) && !is_null($this->input->get('class_id')) && !is_null($this->input->get('section_id')) && !is_null($this->input->get('term_id')) && !is_null($this->input->get('semesterid')) && !is_null($this->input->get('sessionid')))
        {
            //$resultlist = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` where classid = ' . $this->input->get('class_id') . " AND sectionid = " . $this->input->get('section_id') . " AND semesterid = " . $this->input->get('semesterid') . " AND sessionid = " . $this->input->get('sessionid') . " AND status = 'r'");
            $resultlist = $this->operation->GetByQuery('SELECT s.* FROM `student_semesters` as s INNER JOIN  invantage_users AS i ON s.student_id = i.id where s.class_id = ' . $this->input->get('class_id') . " AND s.section_id = " . $this->input->get('section_id') . " AND s.semester_id = " . $active_semester->semester_id . " AND s.session_id = " . $active_session->id . " ORDER BY i.screenname ASC ");
            if (count($resultlist))
            {
                foreach ($resultlist as $key => $value)
                {
                    $termlist = $this->operation->GetByQuery('SELECT * FROM term_exam_result  where student_id = ' . $value->student_id . "  AND subject_id = " . $this->input->get('subject_id') ." order by termid");
                    $marksarray = array();
                    if (count($termlist))
                    {

                        if (count($termlist) == 2)
                        {

                            foreach ($termlist as $key => $tvalue)
                            {
                                
                                    $marksarray[] = array('studentmarks' => $tvalue->marks);
                                
                                    
                            }
                        }
                        else
                        {
                            foreach ($termlist as $key => $tvalue)
                            {
                                $temp = array('studentmarks' => $tvalue->marks);
                                $marksarray = array($temp, array('studentmarks' => 0));
                            }
                        }
                    }
                    else
                    {
                        $marksarray = array(array('studentmarks' => 0), array('studentmarks' => 0));
                    }
                    $resultarray[] = array('id' => $value->id, 'marks' => $marksarray, 'studentid' => $value->student_id, 'name' => parent::getUserMeta($value->student_id, 'sfullname') . " (" . parent::getUserMeta($value->student_id, 'roll_number') . ")",);
                }
            }
            else
            {
                $this->operation->table_name = 'student_semesters';
                $resultlist = $this->operation->GetByWhere(array('classid' => $this->input->get('class_id'), 'section_id' => $this->input->get('section_id'), 'semester_id' => $active_semester->semster_id, 'session_id' => $active_session->id,));
                if (count($resultlist))
                {
                    foreach ($resultlist as $key => $value)
                    {
                        $resultarray[] = array('id' => 0, 'studentid' => $value->student_id, 'marks' => array(array('studentmarks' => 0), array('studentmarks' => 0)), 'name' => parent::getUserMeta($value->student_id, 'sfullname') . " (" . parent::getUserMeta($value->student_id, 'roll_number') . ")",);
                    }
                }
            }
        }
        echo json_encode($resultarray);
    }
    function student_marks_post()
    {
        $request = json_decode(file_get_contents('php://input'));

        $cellvalue = $this->security->xss_clean(trim($request->cellvalue));
        $cellcolumn = $this->security->xss_clean(trim($request->cellcolumn));
        $cellid = $this->security->xss_clean(trim($request->cellid));
        $classid = $this->security->xss_clean(trim($request->classid));
        $section_id = $this->security->xss_clean(trim($request->sectionid));
        $subject_id = $this->security->xss_clean(trim($request->subjectid));
        $student_id = $this->security->xss_clean(trim($request->studentid));
        $termid = $this->security->xss_clean(trim($request->termid));
        $semesterid = $this->security->xss_clean(trim($request->semesterid));
        $sessionid = $this->security->xss_clean(trim($request->sessionid));
        $sresult['message'] = false;
        
        $school_id = $this->security->xss_clean(trim($request->school_id));
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
        
        if (!is_null($cellvalue) && !is_null($cellcolumn) && !is_null($cellid))
        {
            $this->operation->table_name = 'term_exam_result';
            $resultlist = $this->operation->GetByWhere(array('class_id' => $classid, 'section_id' => $section_id, 'subject_id' => $subject_id, 'student_id' => $student_id, 'termid' => ($cellcolumn == 'm' ? 1 : 2), 'semester_id' => $active_semester->semester_id, 'session_id' => $active_session->id,));
            if (count($resultlist))
            {
                $studentresult = array('class_id' => $classid, 'section_id' => $section_id, 'subject_id' => $subject_id, 'student_id' => $student_id, 'termid' => ($cellcolumn == 'm' ? 1 : 2), 'marks' => $cellvalue, 'semester_id' => $active_semester->semester_id, 'session_id' => $active_session->id,);
                $this->db->where('id',$resultlist[0]->id);
                $this->db->update('term_exam_result',$studentresult);
                $result['message'] = true;
            }
            else
            {
                

                $studentresult = array('class_id' => $classid, 'section_id' =>$section_id, 'subject_id' => $subject_id, 'student_id' => $student_id, 'termid' => ($cellcolumn == 'm' ? 1 : 2), 'marks' => $cellvalue, 'semester_id' => $active_semester->semester_id, 'session_id' => $active_session->id, 'locationid' =>$school_id,);
                $this->db->insert('term_exam_result',$studentresult);
                $id = $this->db->insert_id();
            }
        }
        echo json_encode($result);
    }
    function student_quiz_marks_post()
    {

        $request = json_decode(file_get_contents('php://input'));
        $cellvalue = $this->security->xss_clean(trim($request->cellvalue));
        $cellcolumn = $this->security->xss_clean(trim($request->cellcolumn));
        $cellid = $this->security->xss_clean(trim($request->cellid));
        $classid = $this->security->xss_clean(trim($request->classid));
        $sectionid = $this->security->xss_clean(trim($request->sectionid));
        $subjectid = $this->security->xss_clean(trim($request->subjectid));
        $studentid = $this->security->xss_clean(trim($request->studentid));
        $quizid = $this->security->xss_clean(trim($request->quizid));
        $semesterid = $this->security->xss_clean(trim($request->semesterid));
        $sessionid = $this->security->xss_clean(trim($request->sessionid));
        $sresult['message'] = false;
        $school_id = $this->security->xss_clean(trim($request->school_id));
        $active_session = $this->get_active_session($school_id);
        $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
        

        
        if (!is_null($cellvalue) && !is_null($cellcolumn) && !is_null($cellid))
        {
            $this->operation->table_name = 'quizzes_marks';
            $resultlist = $this->operation->GetByWhere(array('class_id' => $classid, 'section_id' => $sectionid, 'subject_id' => $subjectid, 'student_id' => $studentid, 'quiz_id' => $quizid, 'semester_id' => $active_semester->semester_id, 'session_id' => $active_session->id,));
            if (count($resultlist))
            {
                $studentresult = array('class_id' => $classid, 'section_id' => $sectionid, 'subject_id' => $subjectid, 'student_id' => $studentid, 'quiz_id' => $quizid, 'marks' => $cellvalue, 'semester_id' => $active_semester->semester_id, 'session_id' => $active_session->id,);
                //$id = $this->operation->Create($studentresult, $resultlist[0]->id);
                //$result['message'] = true;
                $this->db->where('id',$resultlist[0]->id);
                $this->db->update('quizzes_marks',$studentresult);
                $result['message'] = true;
            }
            else
            {
                
                $studentresult = array('class_id' => $classid, 'section_id' => $sectionid, 'subject_id' => $subjectid, 'student_id' => $studentid, 'quiz_id' => $quizid, 'marks' => $cellvalue, 'semester_id' => $active_semester->semester_id, 'session_id' => $active_session->id, 'school_id' => $school_id,'created_at' => date('Y-m-d H:i:s'));
                //$id = $this->operation->Create($studentresult);
                $this->db->insert('quizzes_marks',$studentresult);
                $id = $this->db->insert_id();
                $result['message'] = true;
            }
        }
        echo json_encode($result);
    }
    function student_by_class_get()
    {

        $studentarray = array();
        if (!is_null($this->input->get('inputclassid')) && !is_null($this->input->get('inputsectionid')) && !is_null($this->input->get('inputsemesterid')) && !is_null($this->input->get('inputsessionid')))
        {
            
            if ($this->input->get('inputsemesterid') == 'b')
            {
                $studentlist = $this->operation->GetByQuery("Select ss.student_id,iv.screenname,um.meta_value,iv.profile_image from student_semesters ss  INNER JOIN invantage_users iv on iv.id = ss.student_id INNER JOIN user_meta um on um.user_id = ss.student_id   where ss.class_id = " . $this->input->get('inputclassid') . " AND ss.section_id =" . $this->input->get('inputsectionid') . " AND ss.session_id = " . $this->input->get('inputsessionid') . " AND um.meta_key = 'roll_number'");
            }
            else
            {
                $studentlist = $this->operation->GetByQuery("Select ss.student_id,iv.screenname,um.meta_value,iv.profile_image from student_semesters ss  INNER JOIN invantage_users iv on iv.id = ss.student_id INNER JOIN user_meta um on um.user_id = ss.student_id   where ss.class_id = " . $this->input->get('inputclassid') . " AND ss.section_id =" . $this->input->get('inputsectionid') . " AND ss.semester_id = " . $this->input->get('inputsemesterid') . " AND ss.session_id = " . $this->input->get('inputsessionid') . " AND um.meta_key = 'roll_number'");
            }
            if (count($studentlist))
            {
                foreach ($studentlist as $key => $value)
                {
                    $studentarray[] = array('id' => $value->student_id, 'name' => $this->GetStudentName($value->student_id) . " (" . $value->meta_value . ")", 'rollnumber' => $value->meta_value, 'fathername' => parent::getUserMeta($value->student_id, 'father_name'), 'profile' => $value->profile_image, 'sdob' => parent::getUserMeta($value->student_id, 'sdob'));
                }
            }
        }
        echo json_encode($studentarray);
    }
    function mid_student_report_by_subject_wize_post()
    {
        $request = json_decode( file_get_contents('php://input'));
        $inputclassid = $this->security->xss_clean(trim($request->inputclassid));
        $inputsectionid = $this->security->xss_clean(trim($request->inputsectionid));
        $inputsemesterid = $this->security->xss_clean(trim($request->inputsemesterid));
        //$inputsemesterid = 1;
        $inputsessionid = $this->security->xss_clean(trim($request->inputsessionid));
        $student_id = $this->security->xss_clean(trim($request->inputstudentid));
        $school_id = $this->security->xss_clean(trim($request->school_id));
        $error_array = array();
        if (!is_int((int) $inputclassid) || !is_int((int) $inputsectionid)  || !is_int((int) $inputsessionid) || !is_int((int) $studentid) ) {
            array_push($error_array,"Invalid data");
        }
             
        if(count($error_array))
        {
            echo json_encode($error_array);
            exit();
        }

        $studentresult = array();
        if(count($error_array) == false)
        {
            $iteration = 0;
            if($inputsemesterid == 'b')
            {
                $iteration = 1;
            }
            else{
              
                
                $this->operation->table_name = 'semester';
                $is_semester_dates_found = $this->operation->GetByWhere(array('id'=>$inputsemesterid));
                
            }
            $subjectlist = parent::GetSubjectsByClass($inputclassid,(int)$inputsemesterid,$inputsessionid,$school_id);
             //$subjectlist = parent::GetSubjectsByClass($inputclassid,$inputsemesterid);
             //print_r($subjectlist);
        //exit;
             
            if(count($subjectlist))
            {   
                $semesterlist = array('Fall','Spring');
                $student_obtain_marks = 0;
                $semester_name = "Fall";
                for ($i=0; $i <= $iteration ; $i++) { 
                    
                   $result = array();
                   if($inputsemesterid == 'b')
                    {
                        $inputsemesterid = parent::GetSemesterByName($semesterlist[$i]);
                        $inputsemesterid = $inputsemesterid[0]->id;
                        $semester_name =  $inputsemesterid[0]->semester_name;
                    }
                    else{
                        if($is_semester_dates_found[0]->semester_name == 'Fall')
                        {
                            $semester_name = "Fall";
                        }
                        else{
                            $semester_name = "Spring";
                        }
                    }
                    $countread = 0;
                    $total_lesson = 0;
                    foreach ($subjectlist as $key => $value) {
                        $sum_subject = array();
                        $student_quiz = array();
                        
                        

                        $student_quiz[0] = (array_sum($sum_subject)/count($subjectlist));
                        $student_quiz[1] = (array_sum($sum_subject)); 

                        // Get Attendance made
                        //$studentprogress = $this->operation->GetByQuery('SELECT s.id as semid,s.read_date FROM `semester_lesson_plan` s WHERE subject_id = ' . $value->id . ' AND semester_id = ' . $inputsemesterid . ' AND section_id = ' . $inputsectionid . ' order by s.read_date asc');
                        $studentprogress = $this->operation->GetByQuery('SELECT sd.date as read_date,s.id as semid FROM `semester_lesson_plan` s inner join lesson_set_dates as sd on s.set_id = sd.set_id WHERE s.subject_id = ' . $value->id . ' AND s.semester_id = ' . $inputsemesterid . '  order by sd.date asc');
                        //$studentprogress = $this->operation->GetByQuery('SELECT sd.date as read_date,s.id as semid FROM `semester_lesson_plan` s inner join lesson_set_dates as sd on s.set_id = sd.set_id WHERE s.subject_id = ' . $this->input->get('subject_id') . ' AND s.semester_id = ' . $this->input->get('semester_id') . ' AND s.session_id = ' . $this->input->get('session_id') . ' order by sd.date asc');
                        if (count($studentprogress))
                            {
                                $sparray = array();
                                
                                foreach ($studentprogress as $key => $spvalue)
                                {
                                    $ar = $this->GetStudentProgress($spvalue->semid, $student_id);
                                    $show = false;
                                    if ($datetime1 != null)
                                    {
                                        $datetime2 = new DateTime($spvalue->read_date);
                                        $show = $datetime1 >= $datetime2;
                                    }
                                    $ar['show'] = $show ? 1 : 0;
                                    //
                                    if($ar['status']=='read')
                                    {
                                        $countread++;
                                    }
                                    
                                    $sparray[] = $ar;
                                }
                                $total_lesson += count($sparray);
                            }
                            
                        // ENd here
                      
                        $evalution_array = array();
    
                        
                        $mid = $this->operation->GetByQuery('SELECT * FROM term_exam_result  where subject_id = '.$value->id.' AND student_id= '.$student_id." order by termid");
                       
                        $total_marks = $mid[0]->marks;
                        $obtain_marks = $mid[0]->marks;
                        $student_obtain_marks += $total_marks;
                        $all_total_marks += MID_TOTAL_MARKS;
                        
                        $evalution_array[] = array(
                            
                            'mid'=>(count($mid) ? $mid[0]->marks : 0),
                            'grade'=>(parent::GetGradeBySemesterDates((double)(($obtain_marks/MID_TOTAL_MARKS)*100),$inputsessionid,$inputsemesterid)) ,
                            'obtain_marks'=> $obtain_marks == NULL ? 0:$obtain_marks,
                            'total_marks'=>MID_TOTAL_MARKS,
                        );    
                        $result[] = array(
                            'serail'=>$value->id,
                            'subject'=>$value->subject_name,
                            'evalution'=>$evalution_array,
                          
                        );
                    }
                    if($student_obtain_marks==0)
                    {
                        $total_obtain_mid_marks = 0;
                    }
                    else
                    {
                        $total_obtain_mid_marks = round($student_obtain_marks,2);
                    }
                    // Get Session Date and Semester Dates
                    //exit;
                    $session_date_q = $this->operation->GetByQuery("SELECT * FROM sessions  where id = ".$inputsessionid);
                    $session_dates =date("Y",strtotime($session_date_q[0]->datefrom)).' - '.date("Y",strtotime($session_date_q[0]->dateto));
                    $semester_date_q = $this->operation->GetByQuery("SELECT * FROM semester_dates  where semester_id = ".$inputsemesterid. " AND session_id =".$inputsessionid);
                    $semester_dates =date("M d, Y",strtotime($semester_date_q[0]->start_date)).' - '.date("M d, Y",strtotime($semester_date_q[0]->end_date));
                    // Calculation Attendence 
                    $total_attendence = 0;
                    if($total_lesson){
                        $total_attendence = ($countread/$total_lesson)*100;
                    }
                   
                     
                    // ENd Here
                    $studentresult[] = array(
                        'result'=>$result,
                        'semester'=>$semester_name,
                        'session_dates'=>$session_dates,
                        'semester_dates'=>$semester_dates,
                        'count_attendence'=>$countread,
                        'total_attendence'=>round($total_attendence,2),
                        'total_lesson'=>(int)($total_lesson),
                        'obtain_marks'=> $total_obtain_mid_marks == NULL ? 0:$total_obtain_mid_marks,
                        'total_marks'=>round($all_total_marks,2),
                        'percent'=>round((float)(($student_obtain_marks/((count($all_total_marks)*100)))*100),2),
                        'grade'=>parent::GetGradeBySemesterDates((float)(($student_obtain_marks/$all_total_marks)*100),$inputsessionid,$inputsemesterid),
                    ); 
                }
            }
        }
        
        echo json_encode($studentresult);
    }
    function GetStudentProgress($lessonid, $studentid)
    {
        $studentprogress = $this->operation->GetByQuery('SELECT * FROM `lesson_progress` where lesson_id =' . $lessonid . " AND student_id=" . $studentid);
        $sparray = array();
        if (count($studentprogress))
        {

            foreach ($studentprogress as $key => $spvalue)
            {

                if($spvalue->finish_count>0)
                {

                    $sparray = array('lessonid' => $spvalue->lesson_id, 'status' => "read", 'last_updated' => $spvalue->last_updated,);
                }
                else
                {
                    $sparray = array('lessonid' => $spvalue->lesson_id, 'status' => "unread", 'last_updated' => $spvalue->last_updated,);
                }
            }
        }
         else
        {
            $sparray = array('lessonid' => $lessonid, 'status' => 'unread',);
        }
        // else
        // {
            
        // }
       // echo count($sparray);
        return $sparray;
    }
    function final_student_report_by_subject_wize_post()
    {
        $request = json_decode( file_get_contents('php://input'));
        $inputclassid = $this->security->xss_clean(trim($request->inputclassid));
        $inputsectionid = $this->security->xss_clean(trim($request->inputsectionid));
        $inputsemesterid = $this->security->xss_clean(trim($request->inputsemesterid));
        //$inputsemesterid = 1;
        $inputsessionid = $this->security->xss_clean(trim($request->inputsessionid));
        $studentid = $this->security->xss_clean(trim($request->inputstudentid));
        $school_id = $this->security->xss_clean(trim($request->school_id));
        $error_array = array();
        
        
        if (!is_int((int) $inputclassid) || !is_int((int) $inputsectionid)  || !is_int((int) $inputsessionid) || !is_int((int) $studentid) ) {
            array_push($error_array,"Invalid data");
        }
             
        if(count($error_array))
        {
            echo json_encode($error_array);
            exit();
        }

        $studentresult = array();
        if(count($error_array) == false)
        {
            $iteration = 0;
            if($inputsemesterid == 'b')
            {
                $iteration = 1;
            }
            else{
              
                
                $this->operation->table_name = 'semester';
                $is_semester_dates_found = $this->operation->GetByWhere(array('id'=>$inputsemesterid));
                
            }
            $subjectlist = parent::GetSubjectsByClass($inputclassid,(int)$inputsemesterid,$inputsessionid,$school_id);
            
        //exit;
             
            if(count($subjectlist))
            {   
                $semesterlist = array('Fall','Spring');
                $student_obtain_marks = 0;
                $semester_name = "Fall";
                $session_total_marks = 0;
                $final_count_subject_total_marks = 0;
                $final_result = "FAIL";
                for ($i=0; $i <= $iteration ; $i++) { 
                    
                   $result = array();
                   if($inputsemesterid == 'b')
                    {
                        $inputsemesterid = parent::GetSemesterByName($semesterlist[$i]);
                        $inputsemesterid = $inputsemesterid[0]->id;
                        $semester_name =  $inputsemesterid[0]->semester_name;
                    }
                    else{
                        if($is_semester_dates_found[0]->semester_name == 'Fall')
                        {
                            $semester_name = "Fall";
                        }
                        else{
                            $semester_name = "Spring";
                        }
                    }
            
                    foreach ($subjectlist as $key => $value) {
                        

                        $evalution_array = array();
                        
                        
                        $mid = $this->operation->GetByQuery('SELECT * FROM term_exam_result  where subject_id = '.$value->id.' AND student_id= '.$studentid." AND termid = 1");
                        $final = $this->operation->GetByQuery('SELECT * FROM term_exam_result  where subject_id = '.$value->id.' AND student_id= '.$studentid." AND termid = 2");
                        // Get Total Sessional Marks
                        $sessional_marks = $this->operation->GetByQuery('SELECT sum(q.marks) as total_sessional FROM quizzes_marks as q INNER JOIN quiz as qi ON qi.id = q.quiz_id WHERE q.subject_id = '.$value->id.' AND q.student_id= '.$studentid.' AND q.section_id = '.$inputsectionid.' AND q.semester_id = '.$inputsemesterid.' AND q.session_id = '.$inputsessionid);
                        // Get Total Quizes of subject
                        $total_subject_sessional_marks = $this->operation->GetByQuery('SELECT count(*) AS total_quize  FROM quiz q INNER JOIN semester s ON s.id = q.semester_id INNER JOIN sessions se ON se.id = q.session_id WHERE q.subject_id = '.$value->id.'  AND q.class_id = '.$inputclassid.' AND q.section_id = '.$inputsectionid.' AND q.semester_id = '.$inputsemesterid.' AND q.session_id = '.$inputsessionid);
                        
                        // End here
                        $mid_total_marks = $mid[0]->marks;
                        $obtain_marks = $mid[0]->marks;
                        $student_mid_obtain_marks += $mid_total_marks;
                        $fin_total_marks += $final[0]->marks;
                        $all_total_marks += MID_TOTAL_MARKS;
                        $final_total_marks += FINAL_TOTAL_MARKS;

                        // Calculate Total Sessional Marks
                        $total_quize_marks = $total_subject_sessional_marks[0]->total_quize*QUIZ_TOTAL_MARKS;
                        $subject_sessional_marks = ($sessional_marks[0]->total_sessional/$total_quize_marks)*SISSIONAL_MARKS;
                        $session_total_marks += (int)(round($subject_sessional_marks));
                        $final_subject_total_marks = MID_TOTAL_MARKS+FINAL_TOTAL_MARKS+SISSIONAL_MARKS;
                        $final_count_subject_total_marks += MID_TOTAL_MARKS+FINAL_TOTAL_MARKS+SISSIONAL_MARKS;
                         // Calculate Obtain Marks
                        $student_obtain_subject_marks = (int)$mid[0]->marks+(int)$final[0]->marks+(int)$subject_sessional_marks;
                        $student_total_obtain_subject_marks += (int)$student_obtain_subject_marks;
                        // Pass AND Fail Condition
                        if($value->subject_name=='English')
                        {
                            if(parent::GetGradeBySemesterDates((double)(($student_obtain_subject_marks/$final_subject_total_marks)*100),$inputsessionid,$inputsemesterid)!="F")
                            {
                                $final_result = "PASS";
                            }
                        }
                        if($value->subject_name=='Math')
                        {
                            if(parent::GetGradeBySemesterDates((double)(($student_obtain_subject_marks/$final_subject_total_marks)*100),$inputsessionid,$inputsemesterid)!="F")
                            {
                                $final_result = "PASS";
                            }
                        }
                        if($value->subject_name=='Science')
                        {
                            if(parent::GetGradeBySemesterDates((double)(($student_obtain_subject_marks/$final_subject_total_marks)*100),$inputsessionid,$inputsemesterid)!="F")
                            {
                                $final_result = "PASS";
                            }
                        }
                        // End here
                        // Get Attendance made
                        //$studentprogress = $this->operation->GetByQuery('SELECT s.id as semid,s.read_date FROM `semester_lesson_plan` s WHERE subject_id = ' . $value->id . ' AND semester_id = ' . $inputsemesterid . ' AND section_id = ' . $inputsectionid . ' order by s.read_date asc');
                        $studentprogress = $this->operation->GetByQuery('SELECT sd.date as read_date,s.id as semid FROM `semester_lesson_plan` s inner join lesson_set_dates as sd on s.set_id = sd.set_id WHERE s.subject_id = ' . $value->id . ' AND s.semester_id = ' . $inputsemesterid . '  order by sd.date asc');
                        if (count($studentprogress))
                            {
                                $sparray = array();
                                
                                foreach ($studentprogress as $key => $spvalue)
                                {
                                    $ar = $this->GetStudentProgress($spvalue->semid, $studentid);
                                    $show = false;
                                    if ($datetime1 != null)
                                    {
                                        $datetime2 = new DateTime($spvalue->read_date);
                                        $show = $datetime1 >= $datetime2;
                                    }
                                    $ar['show'] = $show ? 1 : 0;
                                    //
                                    if($ar['status']=='read')
                                    {
                                        $countread++;
                                    }
                                    
                                    $sparray[] = $ar;
                                }
                                $total_lesson += count($sparray);
                            }
                            
                            
                        // ENd here 
                        $evalution_array[] = array(
                            
                            'mid'=>(count($mid) ? $mid[0]->marks : 0),
                            'final'=>(count($final) ? $final[0]->marks : 0),
                            'sessional_marks'=>(int)($subject_sessional_marks),
                            'student_obtain_subject_marks'=>$student_obtain_subject_marks,
                            
                            'grade'=>parent::GetGradeBySemesterDates((double)(($student_obtain_subject_marks/$final_subject_total_marks)*100),$inputsessionid,$inputsemesterid),
                            'obtain_marks'=>$obtain_marks,
                            'total_marks'=>MID_TOTAL_MARKS,
                            'final_subject_total_marks' => (int)($final_subject_total_marks),
                        );    
                        $result[] = array(
                            'serail'=>$value->id,
                            'subject'=>$value->subject_name,
                            'evalution'=>$evalution_array,
                          
                        );
                    }
                    
                    // Get Session Date and Semester Dates
                    
                    $session_date_q = $this->operation->GetByQuery("SELECT * FROM sessions  where id = ".$inputsessionid);
                    $session_dates =date("Y",strtotime($session_date_q[0]->datefrom)).' - '.date("Y",strtotime($session_date_q[0]->dateto));
                    $semester_date_q = $this->operation->GetByQuery("SELECT * FROM semester_dates  where semester_id = ".$inputsemesterid. " AND session_id =".$inputsessionid);
                    $semester_dates =date("M d, Y",strtotime($semester_date_q[0]->start_date)).' - '.date("M d, Y",strtotime($semester_date_q[0]->end_date));
                    // Calculation Attendence 
                    
                    $total_attendence = 0;
                    if($total_lesson){
                        $total_attendence = ($countread/$total_lesson)*100;
                    }

                    
                    // ENd Here
                    $studentresult[] = array(
                        'result'=>$result,
                        'semester'=>$semester_name,
                        'obtain_marks'=> round($student_mid_obtain_marks,2),
                        'total_marks'=>round($all_total_marks,2),
                        'session_total_marks'=>round($session_total_marks,2),
                        'final_total_marks'=>round($fin_total_marks,2),
                        'final_count_subject_total_marks'=>round($final_count_subject_total_marks,2),
                        'student_total_obtain_subject_marks'=>round($student_total_obtain_subject_marks,2),
                        //'percent'=>round((float)(($student_obtain_marks/((count($all_total_marks)*100)))*100),2),
                        'total_mid_marks'=>(int)MID_TOTAL_MARKS,
                        'total_final_marks'=>(int)FINAL_TOTAL_MARKS,
                        'total_sessional_marks'=>(int)SISSIONAL_MARKS,
                        //'grade'=>parent::GetGrade((float)(($student_total_obtain_subject_marks/$final_count_subject_total_marks)*100),$inputsessionid),
                        'grade'=>$final_result,
                        'session_dates'=>$session_dates,
                        'semester_dates'=>$semester_dates,
                        'total_attendence'=>round($total_attendence,2),
                        'total_lesson'=>(int)($total_lesson),
                        'count_attendence'=>$countread == NULL ? 0 :$countread,
                    ); 
                }
            }
        }
        echo json_encode($studentresult);
    }
    public function semester_lesson_progress_post()
    {
        $debug = '';
        $result['message'] = false;
        try
        {
            
            $data = json_decode(stripslashes($_POST['data']));
            
            foreach($data as $key => $lesson_read)
            {
                $parts = explode('_', $lesson_read);
                $type = $parts[0];
                $lessonid = $parts[1];
                $studentid = $parts[2];
                //echo $lesson_read;
                //if ($lessonid > 0 && $studentid > 0 && $type == "prog")
                
                if ($lessonid > 0 && $studentid > 0)
                {
                    
                    $is_student_found = $this->operation->GetByQuery("Select * from invantage_users where id= '" . $studentid . "'");
                    if (count($is_student_found))
                    {

                        $this->operation->table_name = 'lesson_progress';
                        $data_lesson_read = $this->operation->GetByQuery("Select * from lesson_progress where lesson_id = " . $lessonid . " AND student_id =" . $studentid);
                        $is_lesson_found = $this->operation->GetByQuery("Select * from semester_lesson_plan where id = " . $lessonid);
                        
                        if (count($data_lesson_read) == 0 && count($is_lesson_found))
                        {
                            if($lesson_read=='read')
                            {
                                $status_leason = '0'; 
                            }
                            else
                            {
                                $status_leason = '1'; 
                            }
                            $lesson_progress = array(
                                'student_id' => $studentid,
                                'lesson_id' => $lessonid,
                                'finish_count' => ($status_leason) ,
                                'finished' => date('Y-m-d h:i:s') ,
                                'open_count' => 1,
                                'last_updated' => date('Y-m-d h:i:s')
                            );
                            $this->operation->table_name = 'lesson_progress';
                            $is_value_saved = $this->operation->Create($lesson_progress);


                        }
                        else
                        {

                            //echo "else";
                            
                            $lesson_read = $data_lesson_read[0]->finish_count;
                            
                            if($lesson_read>0)
                            {
                                $status_leason = 0; 
                                $data_lesson_count = 0;
                                $read_date = date('Y-m-d h:i:s',strtotime("0000-00-00 00:00:00"));
                            }
                            else
                            {
                                $status_leason = 1;
                                $data_lesson_count= $data_lesson_read[0]->count+1;
                                $read_date = date('Y-m-d h:i:s');
                            }
                            
                            $student_progress = array(
                                
                                'open_count' => $data_lesson_count ,
                                'finish_count' => $status_leason ,
                                'finished' =>  $read_date,
                                'last_updated' => date('Y-m-d h:i:s') ,
                            );
                            $is_value_saved = $this->operation->Create($student_progress, $data_lesson_read[0]->id);

                             //$debug .= "," . $this->db->last_query();
                            //echo $this->db->last_query();
                        }

                        if (count($is_value_saved))
                        {
                            $result['message'] = true;
                        }
                    }
                }
            }
        }

        catch(Exception $e)
        {
        }

        // $result['debug'] = $debug;

        echo $result['message'];
    }
    function class_section_list_by_teacher_get()
    {
        $user_id = $this->input->get('user_id');
        $this->data['grade_list']=$this->operation->GetByQuery("select cl.id, cl.grade,sc.section_name from schedule s inner join classes cl on cl.id = s.class_id inner join sections sc on sc.id = s.section_id  where s.teacher_uid = ".$user_id." group by cl.id");
        $result[] = array(
                        'listarray'=>$this->data['grade_list'],
                        
                    );
        $this->response($result, REST_Controller::HTTP_OK);

    }
    function announcements_get()
    {

        //$request = json_decode(file_get_contents('php://input'));
        $school_id = $this->input->get('school_id');
        $listarray =array();
        
        $userlist = $this->operation->GetByQuery("SELECT * FROM  announcements WHERE school_id = ".$school_id." ORDER by id desc");
        $listarray = array();
        if (count($userlist))
        {   
            
            foreach ($userlist as $key => $value)
            {
                
                $listarray[] =array('id'=>$value->id,'title'=>$value->title,'message'=>$value->message,'target_type'=>$value->target_type,'created_at'=>date('Y-m-d H:i',strtotime($value->created_at)),'status'=>$value->status);
            
            }
        }

        // $datameta=$this->data['timetable_list'] = $this->operation->GetRowsByQyery("SELECT * FROM  announcements ORDER by id desc");
        
        $result[] = array(
                        'listarray'=>$listarray
                    );
        $this->response($result, REST_Controller::HTTP_OK);
        //echo json_encode($result);
    }
    
    public function announcement_post()
    {

        $result['message'] = false;
        
            if($this->input->post('serial')){
                $data =  array(
                            'title'=>$this->input->post('title'),
                            'message'=>$this->input->post('paigam'),
                            'target_type'=>$this->input->post('target'),
                            'reference'=>$this->input->post('reference'),
                            'individual_no'=>$this->input->post('individual_no'),
                            'status'=>'draft',
                            'all_class'=>$this->input->post('checkall'),
                            'class_id'=>$this->input->post('grade'),
                            'updated_at'=> date('Y-m-d H:i'),
                        );
                $this->operation->table_name = 'announcements';
                $announcement_id = $this->operation->Create($data,$this->input->post('serial'));
            }
            
            else{

                
                // Insert into Annoucement Table
                $data =  array(
                            'title'=>$this->input->post('title'),
                            'message'=>$this->input->post('paigam'),
                            'target_type'=>$this->input->post('target'),
                            'reference'=>$this->input->post('reference'),
                            'individual_no'=>$this->input->post('individual_no'),
                            'status'=>'draft',
                            'all_class'=>$this->input->post('checkall'),
                            'class_id'=>$this->input->post('grade'),
                            'school_id'=>$this->input->post('school_id'),
                            'created_at'=> date('Y-m-d H:i'),
                        );
                $this->operation->table_name = 'announcements';
                $announcement_id = $this->operation->Create($data);
            }
            $result['lastid'] = $announcement_id;
            $result['message'] = true;
            $this->response($result, REST_Controller::HTTP_OK);
            //echo json_encode($result);
    }
    public function send_Announcement_post()
    {

                $exist=true;
                //$locations = $this->session->userdata('locations');
                $data =  array(
                            'title'=>$this->input->post('title'),
                            'message'=>$this->input->post('paigam'),
                            'target_type'=>$this->input->post('target'),
                            'reference'=>$this->input->post('reference'),
                            'status'=>'Sending',
                            'active'=>1,
                        );
                $this->operation->table_name = 'announcements';
                $announcement_id = $this->operation->Create($data,$this->input->post('serial'));
                $announcementcount = $this->operation->GetByQuery("SELECT * FROM announcement_details WHERE announcement_id= ".$this->input->post('serial'));
                if (count($announcementcount)>0)
                {
                    $exist=false;
                }

                if($exist)
                {

                    $announcement_record = $this->operation->GetByQuery("SELECT * FROM announcements WHERE id= ".$this->input->post('serial'));
                    // Check already exists

                    // End here.
                    $school_id = $this->input->post('school_id');
                    $active_session = $this->get_active_session($school_id);
                    $active_semester = $this->get_active_semester_dates_by_session($active_session->id);
        
                    if($announcement_record[0]->target_type=='Individual')
                    {
                        $data =  array(
                                        'announcement_id'=>$this->input->post('serial'),
                                        'phone_number'=>str_replace("-", "", $this->input->post('individual_no')),
                                        'target_type'=>"Individual",
                                        'status'=>'pending',
                                        'created_at'=> date('Y-m-d H:i'),
                                    );
                            $this->operation->table_name = 'announcement_details';
                            $announcement_id = $this->operation->Create($data);
                    }
                    else if($announcement_record[0]->target_type=='School')
                    {
                        // All Student from school
                        // Get Principal
                        $prilist = $this->operation->GetByQuery("SELECT * FROM invantage_users WHERE location= ".$school_id." AND type = 'p' ");
                        if (count($prilist))
                        {   
                            foreach ($prilist as $key => $value)
                            {
                                $phone = parent::getUserMeta($value->id,'principal_phone');
                                $data =  array(
                                            'announcement_id'=>$this->input->post('serial'),
                                            'phone_number'=>str_replace("-", "",$phone),
                                            'target_type'=>'Principal',
                                            'user_id' =>$value->id,
                                            'status'=>'pending',
                                            'created_at'=> date('Y-m-d H:i'),
                                        );
                                $this->operation->table_name = 'announcement_details';
                                $announcement_id = $this->operation->Create($data);
                            }
                        }

                        $stdlist = $this->operation->GetByQuery("SELECT *,um.meta_value as phone  FROM `student_semesters` INNER JOIN user_meta um ON um.user_id = student_id AND um.meta_key='sphone' AND um.meta_key <> '' WHERE `semester_id` = ".$active_semester->semester_id." AND `session_id` = ".$active_session->id);
                        if (count($stdlist))
                        {   
                            foreach ($stdlist as $key => $value)
                            {
                            $data =  array(
                                            'announcement_id'=>$this->input->post('serial'),
                                            'phone_number'=>str_replace("-", "",$value->phone),
                                            'target_type'=>'Student',
                                            'user_id' =>$value->student_id,
                                            'status'=>'pending',
                                            'created_at'=> date('Y-m-d H:i'),
                                        );
                                $this->operation->table_name = 'announcement_details';
                                $announcement_id = $this->operation->Create($data);
                            }
                        }
                        // Get All Staff from School
                        $stafflist = $this->operation->GetByQuery("SELECT teacher_uid,um.meta_value as phone FROM schedule sc INNER JOIN classes cl ON sc.class_id=cl.id INNER JOIN invantage_users inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections sct ON sc.section_id=sct.id INNER JOIN user_meta um ON um.user_id = teacher_uid  WHERE cl.school_id =".$school_id." AND um.meta_key='teacher_phone' AND sub.session_id = ".$active_session->id." AND sub.semester_id = ".$active_semester->semester_id." GROUP BY teacher_uid ORDER by sc.id desc");
                        if (count($stafflist))
                        {   
                            foreach ($stafflist as $key => $value)
                            {
                                
                            $data =  array(
                                            'announcement_id'=>$this->input->post('serial'),
                                            'phone_number'=>str_replace("-", "",$value->phone),
                                            'target_type'=>'Staff',
                                            'user_id' =>$value->teacher_uid,
                                            'status'=>'pending',
                                            'created_at'=> date('Y-m-d H:i'),
                                        );
                                $this->operation->table_name = 'announcement_details';
                                $announcement_id = $this->operation->Create($data);
                            }
                        }
                        //print_r($listarray);
                    }
                    else if($announcement_record[0]->target_type=='Student')
                    {

                        if($this->input->post('checkall'))
                        {
                            //$userlist = $this->operation->GetRowsByQyery("Select * from invantageuser where type = 's' AND school_id= ".$locations[0]['school_id']);
                            
                            $userlist = $this->operation->GetByQuery("SELECT *,um.meta_value as phone  FROM `student_semesters` INNER JOIN user_meta um ON um.user_id = student_id AND um.meta_key='sphone' AND um.meta_key <> '' WHERE `semester_id` = ".$active_semester->semester_id." AND `session_id` = ".$active_session->id);
                            
                            if (count($userlist))
                                {   
                                    foreach ($userlist as $key => $value)
                                    {
                                        //$listarray[] =array('phone'=>parent::getUserMeta($value->id,'sphone'),'type'=>$value->type);
                                    
                                    $data =  array(
                                                    'announcement_id'=>$this->input->post('serial'),
                                                    'phone_number'=>str_replace("-", "",$value->phone),
                                                    'target_type'=>'Student',
                                                    'user_id' =>$value->student_id,
                                                    'status'=>'pending',
                                                    'created_at'=> date('Y-m-d H:i'),
                                                );
                                        $this->operation->table_name = 'announcement_details';
                                        $announcement_id = $this->operation->Create($data);
                                    }
                                }
                        }
                        else
                        {
                            $userlist = $this->operation->GetByQuery("SELECT * FROM `student_semesters` WHERE class_id in(".$this->input->post('grade').") and status = 'r' ");
                            if (count($userlist))
                                {   
                                    foreach ($userlist as $key => $value)
                                    {
                                        //$listarray[] =array('phone'=>parent::getUserMeta($value->studentid,'sphone'));
                                        
                                        $data =  array(
                                                    'announcement_id'=>$this->input->post('serial'),
                                                    'phone_number'=>str_replace("-", "",parent::getUserMeta($value->student_id,'sphone')),
                                                    'target_type'=>'Student',
                                                    'user_id' =>$value->student_id,
                                                    'status'=>'pending',
                                                    'created_at'=> date('Y-m-d H:i'),
                                                );
                                        $this->operation->table_name = 'announcement_details';
                                        $announcement_id = $this->operation->Create($data);
                                    }
                                }
                        }
                        //print_r($listarray);
                    }
                    else if($announcement_record[0]->target_type=='Staff')
                    {
                        
                        if($this->input->post('checkall'))
                        {
                            
                            $stafflist = $this->operation->GetByQuery("SELECT teacher_uid,um.meta_value as phone FROM schedule sc INNER JOIN classes cl ON sc.class_id=cl.id INNER JOIN invantage_users inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections sct ON sc.section_id=sct.id INNER JOIN user_meta um ON um.user_id = teacher_uid  WHERE cl.school_id =".$school_id." AND um.meta_key='teacher_phone' AND sub.session_id = ".$active_session->id." AND sub.semester_id = ".$active_semester->semester_id." GROUP BY teacher_uid ORDER by sc.id desc");
                            if (count($stafflist))
                                {   
                                    foreach ($stafflist as $key => $value)
                                    {
                                        //$listarray[] =array('phone'=>parent::getUserMeta($value->id,'teacher_phone'),'type'=>$value->type);
                                        $data =  array(
                                            'announcement_id'=>$this->input->post('serial'),
                                            'phone_number'=>str_replace("-", "",$value->phone),
                                            'target_type'=>'Staff',
                                            'user_id' =>$value->teacher_uid,
                                            'status'=>'pending',
                                            'created_at'=> date('Y-m-d H:i'),
                                        );
                                        $this->operation->table_name = 'announcement_details';
                                        $announcement_id = $this->operation->Create($data);
                                    }
                                }
                        }
                        else
                        {

                            $stafflist = $this->operation->GetByQuery("SELECT teacher_uid,um.meta_value as phone FROM schedule sc INNER JOIN classes cl ON sc.class_id=cl.id INNER JOIN invantage_users inv ON sc.teacher_uid=inv.id INNER JOIN subjects sub ON sc.subject_id=sub.id INNER JOIN sections sct ON sc.section_id=sct.id INNER JOIN user_meta um ON um.user_id = teacher_uid  WHERE cl.school_id =".$school_id." AND um.meta_key='teacher_phone' AND sub.session_id = ".$active_session->id." AND sub.semester_id = ".$active_semester->semester_id." AND sc.class_id in(".$this->input->post('grade').") GROUP BY teacher_uid ORDER by sc.id desc");
                            if (count($stafflist))
                                {   
                                    foreach ($stafflist as $key => $value)
                                    {

                                        $data =  array(
                                            'announcement_id'=>$this->input->post('serial'),
                                            'phone_number'=>str_replace("-", "",$value->phone),
                                            'target_type'=>'Staff',
                                            'user_id' =>$value->teacher_uid,
                                            'status'=>'pending',
                                            'created_at'=> date('Y-m-d H:i'),
                                        );
                                        $this->operation->table_name = 'announcement_details';
                                        $announcement_id = $this->operation->Create($data);
                                    }
                                }
                        }
                        //print_r($listarray);
                    }
                }



                $url = SHAMA_CORE_API_PATH."send_Message/".$this->input->post('serial');
                
                $params = 1;
                foreach ($params as $key => &$val) {
                  if (is_array($val)) $val = implode(',', $val);
                    $post_params[] = $key.'='.urlencode($val);
                }
                $post_string = implode('&', $post_params);

                $parts=parse_url($url);

                $fp = fsockopen($parts['host'],
                    isset($parts['port'])?$parts['port']:80,
                    $errno, $errstr, 30);

                $out = "POST ".$parts['path']." HTTP/1.1\r\n";
                $out.= "Host: ".$parts['host']."\r\n";
                $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
                $out.= "Content-Length: ".strlen($post_string)."\r\n";
                $out.= "Connection: Close\r\n\r\n";
                if (isset($post_string)) $out.= $post_string;

                fwrite($fp, $out);
                fclose($fp);
                
                $result['message'] = true;
                $this->response($result, REST_Controller::HTTP_OK);
                //echo json_encode($result);
                
    }
    public function stop_Announcement_post()
    {
        $data =  array(
                        'active'=>0,
                        'status'=>"Cancelled",
                        );
                $this->operation->table_name = 'announcements';
                $announcement_id = $this->operation->Create($data,$this->input->post('serial'));
        
        $updateData = array(
                'status' => 'Cancelled'
            );

            $this->db->where('announcement_id', $id);
            $this->db->where('status', "Pending");
            $this->db->update('announcement_details', $updateData);
        $result['message'] = true;
        $this->response($result, REST_Controller::HTTP_OK);
        //echo json_encode($result);
    }
    public function send_Message_post($id = NULL)
    {
            //Update announcement_details set status = "Pending" where announcement_id = 191 and status = "Cancelled"
            // Check already cancelled 
        $endp = $this->operation->GetByQuery("Select id,phone_number from announcement_details where status ='Cancelled'  AND announcement_id= ".$id);
        if(count($endp)>0)
        {
            $updateData = array(
                'status' => 'Pending'
            );

            $this->db->where('announcement_id', $id);
            $this->db->where('status', "Cancelled");
            $this->db->update('announcement_details', $updateData);
        }

            $userlist = $this->operation->GetByQuery("Select id,phone_number from announcement_details where status !='Sent' AND announcement_id= ".$id);
                    if (count($userlist))
                    {   
                        foreach ($userlist as $key => $value)
                        {
                            $annoucementstatus = $this->operation->GetByQuery("Select active,message from announcements where id= ".$id);
                            if($annoucementstatus[0]->active==1)
                            {
                                // Sms API write here
                                $string =  strlen($value->phone_number);
                                if($string==11)
                                {
                                    $mobile = substr($value->phone_number, 1);
                                    $mobile = SMS_PREFIX.$mobile;
                                }
                                else
                                {
                                    $mobile = $value->phone_number;
                                }

                                $post = "type=unicode&sender=".urlencode(SMS_SENDER)."&mobile=".urlencode($mobile)."&message=".urlencode($annoucementstatus[0]->message)."";
                                $url = "https://sendpk.com/api/sms.php?username=".SMS_USERNAME."&password=".SMS_PASSWORD;
                                $ch = curl_init();
                                $timeout = 30; // set to zero for no timeout
                                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
                                curl_setopt($ch, CURLOPT_URL,$url);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
                                curl_setopt($ch, CURLOPT_FRESH_CONNECT,1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                                curl_setopt($ch, CURLOPT_FORBID_REUSE,1);
                                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

                                //if(ENVIRONMENT == 'development'){
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                //}

                                //$result = curl_exec($ch); 
                                // if($result === FALSE){
                                //     echo "Failed to send SMS.";
                                //     trigger_error(curl_error($ch));
                                // }else{
                                //     echo "SMS Sent!</br></br>Response:</br>";
                                    
                                //     print_r($result);
                                // }
                                curl_close($ch);
                                // End here 
                                // Update status
                                $data =  array(
                                'status'=>'Sent',
                                'sent_time'=> date('Y-m-d H:i:s'),
                                );
                                $this->operation->table_name = 'announcement_details';
                                $this->operation->Create($data,$value->id);
                            sleep(3);
                            }
                            else
                            {
                                $data =  array(
                                'status'=>'Cancelled',
                                
                                );
                                $this->operation->table_name = 'announcement_details';
                                $this->operation->Create($data,$value->id);

                            }
                        
                        }
                    }
        // Check for status pending
        $endp = $this->operation->GetByQuery("Select id,phone_number from announcement_details where (status ='Pending' OR status ='Cancelled')  AND announcement_id= ".$id);
        if(count($endp)==0)
        {
            $data =  array(
                'status'=>'Sent',
                
                );
                $this->operation->table_name = 'announcements';
                $this->operation->Create($data,$id);
        }
                
    }
    


    
    public function announcement_detail_list_post()
    {
        //$id = $this->input->post('serial');
        $request = json_decode(file_get_contents('php://input'));
        $id = $this->security->xss_clean(trim($request->serial));
        
        //$annoucementrow = $this->operation->GetRowsByQyery("SELECT * FROM announcements WHERE id =".$id);
        $userlist = $this->operation->GetByQuery("SELECT * FROM announcement_details WHERE announcement_id =".$id);
        $listarray = array();

        if (count($userlist))
        {   

                    
            $i = 1;
            foreach ($userlist as $key => $value)
            {

                if($value->target_type!='Individual')
                {
                    
                    $listarray[] =array('id'=>$i,'phone_number'=>$value->phone_number,'created_at'=>date('Y-m-d H:i',strtotime($value->created_at)),'user_id'=>getUserName($value->user_id),'target_type'=>$value->target_type,'status'=>$value->status);
                }
                else
                {
                    $data_array  = "Stop";
                
                    $listarray[] =array('id'=>$i,'phone_number'=>$value->phone_number,'created_at'=>date('Y-m-d H:i',strtotime($value->created_at)),'user_id'=>"",'target_type'=>$value->target_type,'status'=>$value->status);
                }
                $i++;
                
            }
        }

        // Check end process
        $endp = $this->operation->GetByQuery("Select id,phone_number from announcement_details where (status ='Pending' OR status ='Cancelled')  AND announcement_id= ".$id);
        if(count($endp)==0)
        {
            $data_array  = "Stop";
            //
            $ann_status = $this->operation->GetByQuery("SELECT * FROM announcements WHERE id =".$id);
            if($ann_status[0]->status!='Draft')
            {
                $data =  array(
                        'status'=>"Sent",
                        'updated_at'=> date('Y-m-d H:i:s'),
                        );
                $this->operation->table_name = 'announcements';
                $announcement_id = $this->operation->Create($data,$id);
            }
            
        
        }
        // For Stop listing
        $stopquery = $this->operation->GetByQuery("Select id,phone_number from announcement_details where status ='Cancelled'  AND announcement_id= ".$id);
        if($stopquery>0)
        {
            $data_array  = "Cancelled";
        }
        $result[] = array(
                        'listarray'=>$listarray,
                        
                        'data_array'=>$data_array
                    );
        $this->response($result, REST_Controller::HTTP_OK);
       // echo json_encode($result);
        //echo json_encode($this->data['timetable_list']);
    }
    public function stop_announcement_detail_list_post()
    {
        
        
        $request = json_decode(file_get_contents('php://input'));
        $id = $this->security->xss_clean(trim($request->serial));
        $userlist = $this->operation->GetByQuery("SELECT * FROM announcement_details WHERE announcement_id =".$id);
        $listarray = array();
        if (count($userlist))
        {   
            //$i = 1;
            // foreach ($userlist as $key => $value)
            // {

            //  $listarray[] =array('id'=>$i,'phone_number'=>$value->phone_number,'created_at'=>date('Y-m-d H:i',strtotime($value->created_at)),'user_id'=>$value->user_id,'target_type'=>$value->target_type,'status'=>$value->status);
            //  $i++;
            // }
        }
        $result[] = array(
                        'listarray'=>$listarray,
                        
                        'data_array'=>$data_array
                    );
        sleep(3);
        $this->response($result, REST_Controller::HTTP_OK);
        
        //echo json_encode($this->data['timetable_list']);
    }
    public function getAnnoucementList_get()
    {

        
        
        $listarray =array();
        
        $userlist = $this->operation->GetByQuery("SELECT * FROM  announcements ORDER by id desc");
        $listarray = array();
        if (count($userlist))
        {   
            
            foreach ($userlist as $key => $value)
            {
                
                $listarray[] =array('id'=>$value->id,'title'=>$value->title,'message'=>$value->message,'target_type'=>$value->target_type,'created_at'=>date('Y-m-d H:i',strtotime($value->created_at)),'status'=>$value->status);
            
            }
        }


        // $datameta=$this->data['timetable_list'] = $this->operation->GetRowsByQyery("SELECT * FROM  announcements ORDER by id desc");
        
        $result[] = array(
                        'listarray'=>$listarray
                    );
        $this->response($result, REST_Controller::HTTP_OK);
        //echo json_encode($result);
    }
    public function viewAnnouncement($id=null)
    {
        
        
        //$this->data['annoucement'] = $this->operation->GetRowsByQyery("SELECT  * from announcements where id = ".$id);
        $data['title'] = "Announcement View";
        $this->load->view('principal/announcement/view_announcement',$this->data);
    }

    public function announcement_get()
    {
        //$request = json_decode(file_get_contents('php://input'));
        //$id = $this->security->xss_clean(trim($request->serial));
        //$school_id = $this->security->xss_clean(trim($request->school_id));
        $id = $this->input->get('serial');
        $school_id = $this->input->get('school_id');
        $ann_recorde = $this->operation->GetByQuery("SELECT * FROM  announcements where id=".$id);
        //$listarray = array();
        if($ann_recorde[0]->target_type=="Individual")
        {
            //$ann_d_recorde = $this->operation->GetRowsByQyery("SELECT * FROM  announcement_details where announcement_id=".$id);
            $listarray =array('id'=>$ann_recorde[0]->id,'title'=>$ann_recorde[0]->title,'message'=>$ann_recorde[0]->message,'target_type'=>$ann_recorde[0]->target_type,'status'=>$ann_recorde[0]->status,'reference'=>$ann_recorde[0]->reference,'recepient_no'=>$ann_recorde[0]->individual_no);
        }
        else
        {
            $classlist = $this->operation->GetByQuery("Select c.* from classes c  where  c.school_id =".$school_id);
            $listarray =array('id'=>$ann_recorde[0]->id,'title'=>$ann_recorde[0]->title,'message'=>$ann_recorde[0]->message,'target_type'=>$ann_recorde[0]->target_type,'status'=>$ann_recorde[0]->status,'all_class'=>$ann_recorde[0]->all_class,'class_id'=>$ann_recorde[0]->class_id);
        }
            
            
        $result[] = array(
                        'listarray'=>$listarray,
                        'classlist'=>$classlist
                    );
        $this->response($result, REST_Controller::HTTP_OK);
        //echo json_encode($result);
    }
}

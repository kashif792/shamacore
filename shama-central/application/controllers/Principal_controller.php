<?php

class Principal_controller extends MY_Controller

{

    /**
     *
     * @var array
     *
     */
    var $data = array();

    private $userlocationid = null;

    function __construct()
    {
        parent::__construct();
    }


    function NewLogin()

    {
        $this->load->view('principal/signin');

    }

    /* For adding data into system through forms */
    public function add_class_form()
    {
        $this->load->view('principal/add_class');
    }

    public function add_student_form()
    {
        $id = '';
        if ($this->uri->segment(2) and $this->uri->segment(2) != "page") {

            $id = $this->uri->segment(2);
        }
        
        $this->data['student_id'] = $id;

        $this->load->view('principal/add_student', $this->data);
    }

    /**
     *
     * Invantage Teacher Form
     *
     *
     *
     * @access private
     *        
     * @return return status
     *        
     */
    public function add_teacher_form()
    {
        $this->load->view('principal/add_teacher');
    }

    /**
     *
     * Invantage save Teacher
     *
     *
     *
     * @access private
     *        
     * @return return status
     *        
     */
    public function add_section_form()
    {
        $this->load->view('principal/add_section');
    }

    public function add_subject_form()
    {

        $this->load->view('principal/add_subject');

    }

    public function assign_class_form()
    {
        $this->load->view('principal/assign_class_to_teacher');
    }

    /* */

    /*
     *
     *
     *
     * ---------------------------------------------------------
     *
     *
     *
     * Show All admin list after adding data through form
     *
     *
     *
     * ---------------------------------------------------------
     *
     *
     *
     */

    /**
     *
     * Load form
     *
     *
     *
     * @access private
     *        
     */
    function show_parent_list()

    {
        if (! ($this->session->userdata('id'))) {

            parent::redirectUrl('signin');
        }

        $this->load->view('principal/show_parent_list', $this->data);
    }

    /**
     *
     * @access private
     *        
     */
    function show_teachers_list()

    {
        $this->load->view('principal/show_teacher_list');
    }


    /**
     * @access private
     */
    function show_stds_list()

    {
        
        $this->load->view('principal/show_student_list');

    }

    public function show_subject_list()
    {
        $this->load->view('principal/show_sub_list');
    }

    public function show_section_list()
    {

        $this->load->view('principal/section_list');
    }

    public function add_exam_timetable_form()
    {
        $result = array('mon_status'=>"Active",'tue_status'=>"Active",'wed_status'=>"Active",'thu_status'=>"Active",'fri_status'=>"Active",'sat_status'=>"Inactive",'sun_status'=>"Inactive",'mon_start_time'=>"00:00:00",'mon_end_time'=>"00:00:00",'tue_start_time'=>"00:00:00",'tue_end_time'=>"00:00:00",'wed_start_time'=>"00:00:00",'wed_end_time'=>"00:00:00",'thu_start_time'=>"00:00:00",'thu_end_time'=>"00:00:00",'fri_start_time'=>"00:00:00",'fri_end_time'=>"00:00:00",'sat_start_time'=>"00:00:00",'sat_end_time'=>"00:00:00",'sun_start_time'=>"00:00:00",'sun_end_time'=>"00:00:00");
        $this->data['result'] = $result;

        $this->load->view('principal/exam_timetable',$this->data);

    }


    public function show_exam_timetable()
    {
        $this->data['logo'] = parent::ImageConvertorToBase64(base_url()."images/logo_nr_school.png");
        $this->load->view('principal/exam_timetble_list',$this->data);
    }

    

    public function show_quizz_list()
    {
        // if (! ($this->session->userdata('id'))) {

        //     parent::redirectUrl('signin');
        // }

        // $locations = $this->session->userdata('locations');

        // $roles = $this->session->userdata('roles');

        // if ($roles[0]['role_id'] == 3) {

        //     $this->data['quiz_list'] = $this->operation->GetRowsByQyery("SELECT q.id,grade,section_name,subject_name,qname,isdone,q.quiz_date from quize q INNER JOIN classes c on q.classid=c.id INNER JOIN subjects sb on q.subjectid=sb.id INNER JOIN user_locations ul ON ul.user_id = c.school_id Where  ul.school_id =" . $locations[0]['school_id']);
        // } 
        // else if ($roles[0]['role_id'] == 4) 
        // {

        //     $this->data['quiz_list'] = $this->operation->GetRowsByQyery("SELECT q.id,grade,subject_name,qname,isdone,q.quiz_date from quize q INNER JOIN classes c on q.classid=c.id INNER JOIN subjects sb on q.subjectid=sb.id  Where    q.tacher_uid=" . $this->session->userdata('id') . " group by q.id");
        // }

        $this->load->view('teacher/show_quizz_list', $this->data);
    }

    function removeQuiz()
    {
        $result['message'] = false;

        $removeSubject = $this->db->query("DELETE FROM quize WHERE id =" . trim($_GET['id']));

        if ($removeSubject == TRUE) :

            $result['message'] = true;

		endif;

        echo json_encode($result);
    }

    public function edit_quiz_view_form()

    {
        
        
        $this->load->view('teacher/addquizz');
    }

    public function update_quiz_info()
    {
        if (! ($this->session->userdata('id'))) {

            parent::redirectUrl('signin');
        }

        $result['message'] = false;
        $locations = $this->session->userdata('locations');

        $roles = $this->session->userdata('roles');

        $active_session = parent::GetUserActiveSession();
        $this->operation->table_name = 'semester_dates';
        $active_semester = $this->operation->GetByWhere(array(
            'session_id' => $active_session[0]->id,
            'status' => 'a'
        ));

        $this->operation->table_name = "subjects";

        $subjectslist = $this->operation->GetRows();

        if ($roles[0]['role_id'] == 3) {

            $classlist = $this->operation->GetRowsByQyery("SELECT  * FROM classes c where school_id =" . $locations[0]['school_id']);
        } else if ($roles[0]['role_id'] == 4 or $this->session->userdata('is_master_teacher') == '1') {

            $classlist = $this->operation->GetRowsByQyery("SELECT c.id,c.grade FROM schedule sch INNER JOIN classes c on c.id = sch.class_id  WHERE sch.teacher_uid = " . $this->session->userdata('id') . " GROUP by c.id ORDER by c.id asc");
        }

        foreach ($classlist as $key => $class) {
            foreach ($subjectslist as $key => $subject) {
                $is_quiz_lesson = $this->operation->GetRowsByQyery("SELECT * FROM defaultlessonplan WHERE classid = " . $class->id . " AND subjectid = " . $subject->id . " AND type = 'Quiz' ORDER BY day ASC");
                if (count($is_quiz_lesson)) {
                    foreach ($is_quiz_lesson as $key => $lesson) {
                        $is_quiz_exist = $this->operation->GetRowsByQyery("SELECT id FROM quize WHERE school_id =" . $locations[0]['school_id'] . " AND uniquecode = '" . $lesson->uniquecode . "'");
                        if (count($is_quiz_exist)) {
                            // Update
                            $quiz_array = array(

                                'qname' => $inputquizname,
                                'last_update' => date("Y-m-d H:i"),
                                'tacher_uid' => $this->session->userdata('id')
                            );

                            $this->operation->table_name = 'quize';

                            $id = $this->operation->Create($quiz_array, $is_quiz_exist[0]->id);

                            if (count($id))
                                $result['message'] = true;
                        } else {
                            // Add

                            $quiz_array = array(

                                'uniquecode' => $lesson->uniquecode,
                                'qname' => $lesson->topic,

                                'classid' => $lesson->classid,

                                'subjectid' => $lesson->subjectid,

                                'isdone' => 0,

                                'last_update' => date("Y-m-d H:i"),

                                'datetime' => date("Y-m-d H:i"),

                                'tacher_uid' => $this->session->userdata('id'),
                                'semesterid' => $active_semester[0]->semester_id,
                                'sessionid' => $active_session[0]->id,
                                'school_id' => $locations[0]['school_id']
                            );

                            $this->operation->table_name = 'quize';

                            $id = $this->operation->Create($quiz_array);

                            if (count($id))
                                $result['message'] = true;
                        }
                    } // end foreach lesson
                } // enf if lesson exists
            } // end foreach subject
        } // end foreach class

        // $this->show_quizz_list();
        echo json_encode($result);
    }

    public function save_quize_info()

    {
        if (! ($this->session->userdata('id'))) {

            parent::redirectUrl('signin');
        }

        $postdata = file_get_contents("php://input");

        $request = json_decode($postdata);

        $inputquizname = $this->security->xss_clean(html_escape($request->inputquizname));

        $inputsections = $this->security->xss_clean(html_escape($request->inputsections));

        $serialinput = $this->security->xss_clean(html_escape($request->serial));

        $input_term_type = $this->security->xss_clean(html_escape($request->input_term_type));

        $result['message'] = $serialinput;
        $locations = $this->session->userdata('locations');

        $active_session = parent::GetUserActiveSession();
        $this->operation->table_name = 'semester_dates';
        $active_semester = $this->operation->GetByWhere(array(
            'session_id' => $active_session[0]->id,
            'status' => 'a'
        ));

        if (! is_null($serialinput) && ! empty($serialinput)) 
        {

            $quize_array = array(

                'qname' => $inputquizname,

                'quiz_term' => $input_term_type,

                // 'quiz_date'=>date('Y-m-d',strtotime($inputquizdate)),

                'isdone' => 0,

                'last_update' => date("Y-m-d H:i"),

                'tacher_uid' => $this->session->userdata('id'),
                'semesterid' => $active_semester[0]->semester_id,
                'school_id' => $locations[0]['school_id']
            );

            $this->operation->table_name = 'quize';

            $id = $this->operation->Create($quize_array, $serialinput);

            if (count($id)) {

                $removeSections = $this->db->query("DELETE FROM quiz_section WHERE quiz_id = " . $id);

                foreach ($inputsections as $key => $sectionid) {

                    $this->operation->table_name = 'quiz_section';
                    $section_array = array(
                        'quiz_id' => $id,
                        'section_id' => $sectionid
                    );
                    $this->operation->Create($section_array);
                }

                $result['lastid'] = $id;

                $result['message'] = true;
            }
        }

        /*
         *
         * else if((is_null($serialinput) == true || empty($serialinput)) &&!empty($inputquizname) && !empty($inputclass) && !empty($inputsection) && !empty($inputsubject) && !empty($input_term_type) && !empty($inputquizdate))
         *
         * {
         *
         *
         *
         *
         *
         * $quize_array = array(
         *
         * 'qname'=>$inputquizname,
         *
         * //'classid'=>$inputclass,
         *
         * 'sectionid'=>$inputsection,
         *
         * //'subjectid'=>$inputsubject,
         *
         * 'quiz_term'=>$input_term_type,
         *
         * 'quiz_date'=>date('Y-m-d',strtotime($inputquizdate)),
         *
         * 'isdone'=>0,
         *
         * 'last_update'=>date("Y-m-d H:i"),
         *
         * 'datetime'=>date("Y-m-d H:i"),
         *
         * 'tacher_uid'=>$this->session->userdata('id'),
         * 'semesterid'=>$active_semester[0]->semester_id,
         * 'sessionid'=>$active_session[0]->id,
         * 'school_id'=>$locations[0]['school_id'],
         * 'uniquecode'=>''
         *
         * );
         *
         *
         *
         * $this->operation->table_name = 'quize';
         *
         * $id = $this->operation->Create($quize_array);
         *
         * if(count($id)){
         *
         * $result['lastid'] = $id;
         *
         * $result['message'] = true;
         *
         * }
         *
         * }
         */

        echo json_encode($result);
    }

    public function add_Principal_form()
    {
/*
        if ($this->uri->segment(2) and $this->uri->segment(2) != "page") {

            $this->data['teacher_single'] = $this->operation->GetRowsByQyery("Select * from invantageuser where id= " . $this->uri->segment(2));

            $result['teacher_firstname'] = (parent::getUserMeta($this->uri->segment(2), 'principal_firstname') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_firstname') : '');

            $result['teacher_lastname'] = (parent::getUserMeta($this->uri->segment(2), 'principal_lastname') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_lastname') : '');

            $result['gender'] = (parent::getUserMeta($this->uri->segment(2), 'principal_gender') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_gender') : 'Male');

            $result['nic'] = (parent::getUserMeta($this->uri->segment(2), 'principal_nic') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_nic') : '');

            $result['teacher_religion'] = (parent::getUserMeta($this->uri->segment(2), 'principal_religion') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_religion') : '');

            $result['email'] = (parent::getUserMeta($this->uri->segment(2), 'email') != false ? parent::getUserMeta($this->uri->segment(2), 'email') : '');

            $result['teacher_phone'] = (parent::getUserMeta($this->uri->segment(2), 'principal_phone') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_phone') : '');

            $result['teacher_primary_address'] = (parent::getUserMeta($this->uri->segment(2), 'principal_primary_address') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_primary_address') : '');

            $result['secondary_address'] = (parent::getUserMeta($this->uri->segment(2), 'principal_secondry_adress') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_secondry_adress') : '');

            $result['province'] = (parent::getUserMeta($this->uri->segment(2), 'principal_province') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_province') : '');

            $result['teacher_city'] = (parent::getUserMeta($this->uri->segment(2), 'principal_city') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_city') : '');

            $result['teacher_zipcode'] = (parent::getUserMeta($this->uri->segment(2), 'principal_zipcode') != false ? parent::getUserMeta($this->uri->segment(2), 'principal_zipcode') : '');

            $result['location'] = (parent::getUserMeta($this->uri->segment(2), 'location') != false ? parent::getUserMeta($this->uri->segment(2), 'location') : '');

            $this->data['result'] = $result;
        }

        // $this->data['schools'] = $this->operation->GetRowsByQyery("SELECT * FROM `schools`");
*/
        $this->load->view('principal/add_principal');
    }

    /**
     *
     * Invantage user
     *
     *
     *
     * @access private
     *        
     * @return status
     *
     */

    /* saaaaaaaaaave LMS teacher START */
    function saveInvantagePrincpal()

    {
        if (! ($this->session->userdata('id'))) {

            parent::redirectUrl('signin');
        }

        $result['message'] = false;

        $this->form_validation->set_rules('inputFirstName', 'Valid First Name Required', 'trim|min_length[3]');

        $this->form_validation->set_rules('inputLastName', 'Valid Last Name Required', 'trim|min_length[3]');

        if ($this->form_validation->run() == FALSE) {

            $result['message'] = false;
        } 
        else {

            $image_file = '';

            if ($this->input->post('serial') && ! isset($_FILES['image'])) {
                $is_user_found = $this->operation->GetRowsByQyery("SELECT profile_image from invantageuser  where id=" . $this->input->post('serial'));

                if (count($is_user_found)) {
                    $image_file = $is_user_found[0]->profile_image;
                }
            }
            if (isset($_FILES['image'])) {
                // Save in database
                foreach ($_FILES as $key => $value) {
                    $filename = time() . trim(basename($value['name']));
                    $base_url_path = IMAGE_LINK_PATH . "profile/" . $filename;
                    $path = UPLOAD_PATH . "profile/";
                    $filename = $path . $filename;
                    if (is_uploaded_file($value['tmp_name'])) {
                        if (move_uploaded_file($value['tmp_name'], $filename)) {
                            $image_file = $base_url_path;
                        }
                    }
                }
            }

            if ($this->input->post('serial') != null) {

                $this->operation->table_name = 'invantageuser';

                $teacherId = $this->user->PricpalInfo($this->input->post('serial'), ucwords(htmlentities(stripslashes($this->input->post('inputFirstName')))), 
                htmlentities(stripslashes($this->input->post('inputLastName'))), 
                $this->input->post('input_t_gender'), 
                trim($this->input->post('inputTeacher_Nic')), 

                    // trim($this->input->post('inputReligion')),

                    trim($this->input->post('input_teacher_email')), 
                    trim($this->input->post('input_pr_phone')), 
                    trim($this->input->post('inputNewPassword')), 
                    htmlentities(stripslashes($this->input->post('pr_home'))), 
                    htmlentities(stripslashes($this->input->post('sc_home'))), 
                    trim($this->input->post('inputProvice')), 
                    trim($this->input->post('input_city')), 
                    trim($this->input->post('input_zipcode')), 
                    trim($this->input->post('inputLocation')), $image_file
                );

                $result['message'] = true;
            } 
            else {

                if (trim($this->input->post('inputNewPassword')) == trim($this->input->post('inputRetypeNewPassword'))) {

                    // insert

                    $teacherId = $this->user->PricpalInfo(null, ucwords($this->input->post('inputFirstName')), 
                    $this->input->post('inputLastName'), 
                    $this->input->post('input_t_gender'), 
                    trim($this->input->post('inputTeacher_Nic')), 

                        // trim($this->input->post('inputReligion')),

                        trim($this->input->post('input_teacher_email')), 
                        trim($this->input->post('input_pr_phone')), 
                        trim($this->input->post('inputNewPassword')), 
                        trim($this->input->post('pr_home')), 
                        trim($this->input->post('sc_home')), 
                        trim($this->input->post('inputProvice')), 
                        trim($this->input->post('input_city')), 
                        trim($this->input->post('input_zipcode')), 
                        trim($this->input->post('inputLocation')), $image_file
                    );

                    $result['lastid'] = $teacherId;

                    $result['message'] = true;
                }
            }
        }

        echo json_encode($result);
    }

    function uploadPrincpalimg()
    {
        $result['message'] = false;

        if (isset($_FILES) == 1) {

            // Save in database

            foreach ($_FILES as $key => $value) {

                $valid_formats = array(
                    "jpg",
                    "png",
                    "gif",
                    "bmp",
                    "jpeg",
                    "JPG",
                    "PNG",
                    "GIF",
                    "BMP",
                    "doc",
                    "DOC",
                    "PDF",
                    "pdf",
                    "DOCX",
                    "docx",
                    "xls",
                    "XLS",
                    "XLSX",
                    "xlsx"
                );

                if (strlen($value['name'])) {

                    list ($txt, $ext) = explode(".", $value['name']);

                    if (in_array(strtolower($ext), $valid_formats)) {

                        if ($value["size"] < 5000000) {

                            $filename = time() . trim(basename($value['name']));

                            $base_url_path = base_url() . "upload/profile/" . $filename;

                            $teacher = array(

                                'profile_image' => $base_url_path
                            );

                            $this->operation->table_name = 'invantageuser';

                            $id = $this->operation->Create($teacher, $_POST['teacherId']);

                            if ($id) {

                                if (is_uploaded_file($value['tmp_name'])) {

                                    $path = $_SERVER['DOCUMENT_ROOT'] . "/shama/upload/profile/";

                                    $filename = $path . $filename;

                                    if (move_uploaded_file($value['tmp_name'], $filename)) {

                                        $result['message'] = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        echo json_encode($result);
    }

    /**
     *
     * Load form
     *
     *
     *
     * @access private
     *        
     */
    function show_prinicpal_list()

    {
/*
        $teacherlist = array();

        $teacherlists = $this->operation->GetRowsByQyery("Select inuser.* from invantageuser inuser  INNER JOIN user_roles ur ON ur.user_id =inuser.id where ur.role_id = 3 ");
        if (count($teacherlists)) {

            foreach ($teacherlists as $key => $value) {
                $school = parent::GetUserSchool($value->id);

                $teacherlist[] = array(

                    'principal_id' => $value->id,

                    'principal_firstname' => (parent::getUserMeta($value->id, 'principal_firstname') != false ? parent::getUserMeta($value->id, 'principal_firstname') : ''),

                    'principal_lastname' => (parent::getUserMeta($value->id, 'principal_lastname') != false ? parent::getUserMeta($value->id, 'principal_lastname') : ''),

                    'email' => $value->email,
                    'school' => $school[0]->name . " - " . $school[0]->location
                );
            }
        }

        $this->data['teacherlist'] = (object) $teacherlist;

        $this->data['roles_right'] = $this->operation->GetRowsByQyery("SELECT user_roles.user_id, user_roles.role_id, user_roles.id, role_rights. * FROM (`user_roles`) INNER JOIN  `role_rights` ON  `role_rights`.`role_id` =  `user_roles`.`role_id` WHERE role_rights.description LIKE  '%_Form' AND  `user_roles`.user_id =" . $this->session->userdata('id'));
*/
        $this->load->view('principal/show_prinicpal_list');
    }

    function Repeat()

    {
        $result['message'] = false;

        if (! empty(trim($this->input->get('id'))) && ! is_null($this->input->get('id'))) :

            $lesson = $this->operation->GetRowsByQyery("SELECT * from lessons  where id=" . $this->input->get('id'));

            if (count($lesson)) {

                foreach ($lesson as $key => $value) 
                {

                    $Repeatlesson = array(

                        'teacher_id' => $value->teacher_id,

                        'title' => $value->title,

                        'description' => $value->description,

                        'upload_url' => $value->upload_url,

                        'created' => date("Y-m-d H:i"),

                        'uploadname' => $value->uploadname,

                        'lesson_type' => $value->lesson_type,

                        'last_update' => date("Y-m-d H:i"),

                        'appvideo_url' => $value->appvideo_url
                    );

                    $this->operation->table_name = 'lessons';

                    $lid = $this->operation->Create($Repeatlesson);

                    $result = array(
                        'id' => $lid,
                        'title' => $value->title,
                        'date' => date("Y-m-d H:i")
                    );

                    $lessonRead = $this->operation->GetRowsByQyery("SELECT * from lesson_read  where lesson_id=" . $this->input->get('id'));

                    if (count($lessonRead)) 
                    {

                        foreach ($lessonRead as $key => $value) {

                            $lessonRead_data = array(

                                'lesson_id' => $lid,

                                'sectionid' => $value->sectionid,

                                'status' => $value->status,

                                'created' => date("Y-m-d H:i"),

                                'subjectid' => $value->subjectid,

                                'classid' => $value->classid,

                                'date' => date("Y-m-d H:i")
                            );

                            $this->operation->table_name = 'lesson_read';

                            $this->operation->Create($lessonRead_data);
                        }
                    }
                }
            }

			endif;

        echo json_encode($result);
    }

    /* Parrrrrrrrrrrreeeeeeeeeentttttttttts Recordssssssssssss start */
    public function add_Parent_form()
    {
        if (! ($this->session->userdata('id'))) {

            parent::redirectUrl('signin');
        }

        if ($this->uri->segment(2) and $this->uri->segment(2) != "page") {

            $this->data['teacher_single'] = $this->operation->GetRowsByQyery("Select * from invantageuser where id= " . $this->uri->segment(2));

            $result['teacher_firstname'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_firstname') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_firstname') : '');

            $result['teacher_lastname'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_lastname') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_lastname') : '');

            $result['gender'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_gender') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_gender') : 'Male');

            $result['nic'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_nic') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_nic') : '');

            $result['teacher_religion'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_religion') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_religion') : '');

            $result['email'] = (parent::getUserMeta($this->uri->segment(2), 'email') != false ? parent::getUserMeta($this->uri->segment(2), 'email') : '');

            $result['teacher_phone'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_phone') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_phone') : '');

            $result['teacher_primary_address'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_primary_address') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_primary_address') : '');

            $result['secondary_address'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_secondry_adress') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_secondry_adress') : '');

            $result['province'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_province') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_province') : '');

            $result['teacher_city'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_city') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_city') : '');

            $result['teacher_zipcode'] = (parent::getUserMeta($this->uri->segment(2), 'teacher_zipcode') != false ? parent::getUserMeta($this->uri->segment(2), 'teacher_zipcode') : '');

            $result['location'] = (parent::getUserMeta($this->uri->segment(2), 'location') != false ? parent::getUserMeta($this->uri->segment(2), 'location') : '');

            $this->data['result'] = $result;
        }

        // $this->data['schools'] = $this->operation->GetRowsByQyery("SELECT * FROM `schools`");

        $this->load->view('principal/add_parent', $this->data);
    }

    /**
     *
     * Invantage user
     *
     *
     *
     * @access private
     *        
     * @return return status
     *        
     */

    /* saaaaaaaaaave LMS teacher START */
    function saveInvantageParents()

    {
        if (! ($this->session->userdata('id'))) {

            parent::redirectUrl('signin');
        }

        $result['message'] = false;

        $this->form_validation->set_rules('inputFirstName', 'Valid First Name Required', 'trim|required|min_length[3]');

        $this->form_validation->set_rules('inputLastName', 'Valid Last Name Required', 'trim|required|min_length[3]');

        if ($this->form_validation->run() == FALSE) {

            $result['message'] = false;
        } 
        else {

            if ($this->input->post('serial')) {

                $this->operation->table_name = 'invantageuser';

                $teacherId = $this->user->ParentsInfo($this->input->post('serial'), ucwords($this->input->post('inputFirstName')), 
                $this->input->post('inputLastName'), 
                $this->input->post('input_t_gender'), 
                trim($this->input->post('inputTeacher_Nic')), 
                trim($this->input->post('inputReligion')), 
                trim($this->input->post('input_teacher_email')), 
                trim($this->input->post('input_pr_phone')), 
                trim($this->input->post('inputNewPassword')), 
                trim($this->input->post('pr_home')), 
                trim($this->input->post('sc_home')), 
                trim($this->input->post('inputProvice')), 
                trim($this->input->post('input_city')), 
                trim($this->input->post('input_zipcode')), 
                trim($this->input->post('inputLocation'))
                );

                $result['message'] = true;
            } 
            else {

                if (trim($this->input->post('inputNewPassword')) == trim($this->input->post('inputRetypeNewPassword'))) {

                    // insert

                    $teacherId = $this->user->ParentsInfo(null, ucwords($this->input->post('inputFirstName')), 
                    $this->input->post('inputLastName'), 
                    $this->input->post('input_t_gender'), 
                    trim($this->input->post('inputTeacher_Nic')), 
                    trim($this->input->post('inputReligion')), 
                    trim($this->input->post('input_teacher_email')), 
                    trim($this->input->post('input_pr_phone')), 
                    trim($this->input->post('inputNewPassword')), 
                    trim($this->input->post('pr_home')), 
                    trim($this->input->post('sc_home')), 
                    trim($this->input->post('inputProvice')), 
                    trim($this->input->post('input_city')), 
                    trim($this->input->post('input_zipcode')), 
                    trim($this->input->post('inputLocation'))
                    );

                    $result['lastid'] = $teacherId;

                    $result['message'] = true;
                }
            }
        }

        echo json_encode($result);
    }

    function uploadParentimg()
    {
        $result['message'] = false;

        if (isset($_FILES) == 1) {

            // Save in database

            foreach ($_FILES as $key => $value) {

                $valid_formats = array(
                    "jpg",
                    "png",
                    "gif",
                    "bmp",
                    "jpeg",
                    "JPG",
                    "PNG",
                    "GIF",
                    "BMP",
                    "doc",
                    "DOC",
                    "PDF",
                    "pdf",
                    "DOCX",
                    "docx",
                    "xls",
                    "XLS",
                    "XLSX",
                    "xlsx"
                );

                if (strlen($value['name'])) {

                    list ($txt, $ext) = explode(".", $value['name']);

                    if (in_array(strtolower($ext), $valid_formats)) {

                        if ($value["size"] < 5000000) {

                            $filename = time() . trim(basename($value['name']));

                            $teacher = array(

                                'profile_image' => $filename
                            );

                            $this->operation->table_name = 'invantageuser';

                            $id = $this->operation->Create($teacher, $_POST['teacherId']);

                            if ($id) {

                                if (is_uploaded_file($value['tmp_name'])) {

                                    $path = $_SERVER['DOCUMENT_ROOT'] . "/lmsdev/v1/upload/profile/";

                                    $filename = $path . $filename;

                                    if (move_uploaded_file($value['tmp_name'], $filename)) {

                                        $result['message'] = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        echo json_encode($result);
    }

    /**
     *
     * Load form
     *
     *
     *
     * @access private
     *        
     */
    function show_parents_list()

    {
        if (! ($this->session->userdata('id'))) {

            parent::redirectUrl('signin');
        }

        $this->session->unset_userdata('laststudentimgid');

        $teacherlist = array();

        $teacherlists = $this->operation->GetRowsByQyery("Select inuser.* from invantageuser inuser  where inuser.type = 'pr'");

        if (count($teacherlists)) {

            foreach ($teacherlists as $key => $value) {

                $teacherlist[] = array(

                    'teacher_id' => $value->id,

                    'teacher_firstname' => (parent::getUserMeta($value->id, 'teacher_firstname') != false ? parent::getUserMeta($value->id, 'teacher_firstname') : ''),

                    'teacher_lastname' => (parent::getUserMeta($value->id, 'teacher_lastname') != false ? parent::getUserMeta($value->id, 'teacher_lastname') : ''),
                    'teacher_phone' => (parent::getUserMeta($value->id, 'teacher_phone') != false ? parent::getUserMeta($value->id, 'teacher_phone') : ''),

                    'email' => $value->email
                );
            }
        }

        $this->data['teacherlist'] = (object) $teacherlist;

        // $this->data['roles_right'] = $this->operation->GetRowsByQyery("SELECT user_roles.user_id, user_roles.role_id, user_roles.id, role_rights. * FROM (`user_roles`) INNER JOIN `role_rights` ON `role_rights`.`role_id` = `user_roles`.`role_id` WHERE role_rights.description LIKE '%_Form' AND `user_roles`.user_id =". $this->session->userdata('id'));

        $this->load->view('principal/show_parent_list', $this->data);
    }

    /**
     *
     * Remove Teachers
     *
     *
     *
     * @access private
     *        
     * @return array return json array message if user deleted
     *        
     */
    function removeParent()
    {
        $result['message'] = false;

        $removeParent = $this->db->query("Delete from invantageuser where id = " . $this->input->get('id'));

        if ($removeParent == TRUE) :

            $result['message'] = true;

					endif;

        echo json_encode($result);
    }

    /* Parrrrrrrrrrrreeeeeeeeeentttttttttts Recordssssssssssss end */

    /**
     *
     * Load form
     *
     *
     *
     * @access private
     *        
     */
    function lesson_plan_form()

    {

        $this->load->view('teacher/lesson_plan_form');

    }


    function PromoteStudents()

    {
        $this->load->view('principal/promotestudent');
    }

    function GetQuestionById()
    {
        if (! ($this->session->userdata('id'))) {

            parent::redirectUrl('signin');
        }

        $response = array();

        if (! is_null($this->input->get('qid')) && is_numeric($this->input->get('qid'))) {

            $is_question_found = $this->operation->GetRowsByQyery("SELECT * FROM quizequestions where id =" . $this->input->get('qid'));

            if (count($is_question_found)) 
            {

                $is_question_option_found = $this->operation->GetRowsByQyery("SELECT o.* FROM qoptions o INNER JOIN quizeoptions qo ON o.id = qo.qoption_id where qo.questionid = " . $this->input->get('qid'));

                if (count($is_question_option_found)) 
                {

                    $options = array();
                    $this->operation->table_name = "correct_option";
                    $correct_index = 1;
                    $correct_option = $this->operation->GetByWhere(array(
                        'question_id' => $this->input->get('qid')
                    ));
                    $i = 1;
                    foreach ($is_question_option_found as $key => $value) {

                        $option = '';
                        if ($is_question_found[0]->type == 't') {

                            $option = $value->option_value;
                        } else {
                            $thumbname = explode('.', $value->option_value);
                            $option = base_url() . 'upload/option_images/' . $thumbname[0] . '_thumb.' . $thumbname[1];
                        }

                        $options[] = array(

                            'optionid' => $value->id,

                            'option' => $option
                        );

                        if ($correct_option[0]->correct_id == $value->id) {
                            $correct_index = $i;
                        } else {
                            $i ++;
                        }
                    }

                    $thumbname = '';
                    if (! is_null($is_question_found[0]->img_src)) {
                        $thumbname = explode('.', $is_question_found[0]->img_src);
                    }

                    $response[] = array(

                        'question' => $is_question_found[0]->question,
                        'thumbnail_src' => (count($thumbname) == 2 ? base_url() . 'upload/quiz_images/' . $thumbname[0] . '_thumb.' . $thumbname[1] : ''),
                        'questionid' => $is_question_found[0]->id,
                        'options' => $options,
                        'correct' => $correct_index,
                        'type' => ($is_question_found[0]->type == 't' ? 1 : 2)
                    );
                }
            }
        }

        echo json_encode($response);
    }

    // function GetSelectedSubject()

    // {
    //     $selected_subject = array();

    //     if ($this->input->get('inputrowid') != null && is_numeric($this->input->get('inputrowid'))) 
    //     {

    //         $is_selected_subject = $this->operation->GetRowsByQyery('SELECT s.* FROM subjects s INNER join quize q on q.subjectid = s.id  where q.id =' . $this->input->get('inputrowid'));

    //         if (count($is_selected_subject)) 
    //         {

    //             $selected_subject[] = array(

    //                 'id' => $is_selected_subject[0]->id,

    //                 'name' => $is_selected_subject[0]->subject_name,
    //                 'name' => $is_selected_subject[0]->subject_name,
    //                 'class' => $is_selected_subject[0]->class_id,
    //                 'semester' => $is_selected_subject[0]->semesterid,
    //                 'iamge' => $is_selected_subject[0]->subject_image
    //             );
    //         }
    //     }

    //     echo json_encode($selected_subject);
    // }

    function GetQuestionList()
    {
        if (! $this->session->userdata('id')) {
            parent::redirectUrl('signin');
        }

        if (! is_null($this->input->get('id')) && is_numeric($this->input->get('id'))) {
            $questionlist = $this->operation->GetRowsByQyery("SELECT * FROM quizequestions where quizeid = " . $this->input->get('id') . "  order by id desc");
        } else {
            exit();
            // $questionlist = $this->operation->GetRowsByQyery("SELECT * FROM quizequestions order by id desc");
        }

        $qlist = array();
        if (count($questionlist)) {
            foreach ($questionlist as $key => $value) {
                $optionlist = $this->operation->GetRowsByQyery("SELECT o.* FROM qoptions o INNER JOIN quizeoptions qo ON o.id = qo.qoption_id where qo.questionid =" . $value->id);
                $temp = array();
                $this->operation->table_name = "correct_option";
                $correct_index = 1;
                $correct_option = $this->operation->GetByWhere(array(
                    'question_id' => $value->id
                ));
                if (count($optionlist)) {
                    $i = 1;
                    foreach ($optionlist as $key => $ovalue) {
                        $temp1 = array();
                        if ($value->type == 't') {

                            $temp1['option'] = $ovalue->option_value;
                            $temp1['image_src'] = '';
                        } else {
                            $thumbname = explode('.', $ovalue->option_value);
                            $temp1['option'] = base_url() . 'upload/option_images/' . $thumbname[0] . '_thumb.' . $thumbname[1];
                            $temp1['image_src'] = base_url() . 'upload/option_images/' . $ovalue->option_value;
                        }

                        if ($correct_option[0]->correct_id == $ovalue->id) {
                            $correct_index = $i;
                        } else {
                            $i ++;
                        }
                        array_push($temp, $temp1);
                    }
                }

                $thumbname = '';
                if (! is_null($value->img_src)) {
                    $thumbname = explode('.', $value->img_src);
                }

                $qlist[] = array(
                    'id' => $value->id,
                    'quizeid' => $value->quizeid,
                    'thumbnail_src' => (count($thumbname) == 2 ? base_url() . 'upload/quiz_images/' . $thumbname[0] . '_thumb.' . $thumbname[1] : ''),
                    'image_src' => ($value->img_src != '' ? base_url() . 'upload/quiz_images/' . $value->img_src : ''),
                    'question' => $value->question,
                    'options' => $temp,
                    'quiz_type' => $value->type,
                    'correct' => $correct_index
                );
            }
        }

        echo json_encode($qlist);
    }

    public function LoadShedulleType()
    {
        $data = $this->operation->GetRowsByQyery('Select * from releaseshedulle');
        $ShedulleTypearray = array();
        $result['message'] = false;
        $result['data'] = null;
        if (count($data)) {

            foreach ($data as $key => $value) {
                $ShedulleTypearray = array(
                    't_status' => $value->t_status,
                    's_status' => $value->s_status
                );
            }

            $result['message'] = true;
            $result['data'] = $ShedulleTypearray;
        }
        echo json_encode($ShedulleTypearray);
    }

    public function ShedulleType()
    {
        $request = json_decode(file_get_contents('php://input'));
        $inputTimetable = $this->security->xss_clean(trim($request->inputTimetable));
        $inputschedullar = $this->security->xss_clean(trim($request->inputchedullar));

        $ShedulleTypearray = array();
        $result['message'] = true;
        $result['Timetable'] = false;

        $result['schedullar'] = false;
        $is_data_found = $this->operation->GetRowsByQyery('Select * from releaseshedulle');

        if (! count($is_data_found)) {
            $ShedulleTypearray = array(
                't_status' => $inputTimetable,
                's_status' => $inputschedullar,
                'uniquecode' => uniqid()
            );

            $this->operation->table_name = "releaseshedulle";
            $id = $this->operation->Create($ShedulleTypearray);
            $result['message'] = true;
        } 
        else if (count($is_data_found)) {
            $ShedulleTypearray = array(
                't_status' => $inputTimetable,
                's_status' => $inputschedullar
            );
            $this->operation->table_name = "releaseshedulle";
            $this->operation->Create($ShedulleTypearray, $is_data_found[0]->id);
            $result['message'] = true;
        }

        echo json_encode($ShedulleTypearray);
    }

    function GetPrincipalById()
    {
        if (! is_null($this->input->get('principal'))) {
            $is_data_found = $this->operation->GetRowsByQyery('Select * from invantageuser where id =' . $this->input->get('principal'));
            $is_principal = array();
            if (count($is_data_found)) {
                foreach ($is_data_found as $key => $value) {
                    $user_locations = $this->operation->GetRowsByQyery('Select * from user_locations where user_id =' . $this->input->get('principal'));
                    $locationarray = array();

                    if (count($user_locations)) {
                        foreach ($user_locations as $key => $lvalue) {
                            $schoolid = $lvalue->school_id;
                            $school = parent::GetSchoolDetail($lvalue->school_id);
                            $locationarray[] = array(
                                'school' => $school->name,
                                'location' => $school->location
                            );
                        }
                    }

                    $is_principal = array(
                        'firstname' => (parent::getUserMeta($this->input->get('principal'), 'principal_firstname') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_firstname') : ''),
                        'lastname' => (parent::getUserMeta($this->input->get('principal'), 'principal_lastname') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_lastname') : ''),
                        'gender' => (parent::getUserMeta($this->input->get('principal'), 'principal_gender') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_gender') : ''),
                        'gendertype' => (parent::getUserMeta($this->input->get('principal'), 'principal_gender') != (int) 1 ? 'Male' : 'Female'),
                        'nic' => (parent::getUserMeta($this->input->get('principal'), 'principal_nic') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_nic') : ''),
                        'religion' => (parent::getUserMeta($this->input->get('principal'), 'principal_religion') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_religion') : ''),
                        'email' => $value->email,
                        'phone' => (parent::getUserMeta($this->input->get('principal'), 'principal_phone') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_phone') : ''),
                        'primary_home_address' => (parent::getUserMeta($this->input->get('principal'), 'principal_primary_address') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_primary_address') : ''),
                        'primary_secondary_address' => (parent::getUserMeta($this->input->get('principal'), 'principal_secondry_adress') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_secondry_adress') : ''),
                        'state' => (parent::getUserMeta($this->input->get('principal'), 'principal_province') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_province') : ''),
                        'city' => (parent::getUserMeta($this->input->get('principal'), 'principal_city') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_city') : ''),
                        'zipcode' => (parent::getUserMeta($this->input->get('principal'), 'principal_zipcode') != false ? parent::getUserMeta($this->input->get('principal'), 'principal_zipcode') : ''),
                        'school' => $locationarray,
                        'schoolid' => $schoolid,
                        'schoolname' => $school->name,
                        'image' => $value->profile_image
                    );
                }
            }
        }
        echo json_encode($is_principal);
    }
    function getDatesheetList()
    {
        
        
        $this->data['logo'] = parent::ImageConvertorToBase64(base_url()."images/logo_nr_school.png");
        $this->load->view('principal/datesheet/show_datesheet_list',$this->data);
    }
    function AddDatesheet()
    {
        
        $this->load->view('principal/datesheet/add_datesheet');
    }
    function getDatesheetUpdate()
    {
        $this->load->view('principal/datesheet/edit_datesheet');
    }
    function getAnnouncementList()
    {

        $this->load->view('principal/announcement/show_announcement_list');
    }
    function addAnnouncement()
    {

        $this->load->view('principal/announcement/add_announcement');
    }
    function viewAnnouncement()
    {

        $this->load->view('principal/announcement/view_announcement');
    }
}


<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Rest_Controller.php';

/**
 * Login API
 */
class Lesson_Plan_Controller extends My_Rest_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Karachi");
    }

    // region default lesson plan

    /**
     * Get default lesson plan
     *
     * @class_id int
     * @subject_id int
     * @semester_id int
     *
     */
    public function default_lesson_plan_get()
    {
        $class_id = $this->input->get('class_id');
        $subject_id = $this->input->get('subject_id');
        $semester_id = $this->input->get('semester_id');

        $lesson = $this->operation->GetByQuery("SELECT d.* from default_lesson_plan d
            WHERE d.class_id=" . $class_id . " and d.subject_id=" . $subject_id . " AND d.semester_id = " . $semester_id . " ORDER BY day ASC");

        $data = array();
        if (count($lesson)) {

            foreach ($lesson as $key => $value) {
                if (! is_null($value->topic) && ! is_null($value->day) && ! is_null($value->concept)) {

                    $data[] = array(
                        'day' => $value->day,

                        'concept' => ucfirst($value->concept),

                        'topic' => ucfirst($value->topic),

                        'lesson' => $value->lesson,

                        'content' => $value->content,

                        'thumb' => $value->thumb,

                        'type' => $value->type,

                        'id' => $value->id
                    );
                }
            }

            usort($data, function ($a, $b) {
                $day1 = $a['day'];
                $day2 = $b['day'];

                // Handle Day like 'Day 1'
                if (strstr($day1, ' ')) {
                    $day1 = explode(" ", $day1)[1];
                }

                if (strstr($day2, ' ')) {
                    $day2 = explode(" ", $day2)[1];
                }

                return $day1 > $day2;
            });
        }

        $this->set_response($data, REST_Controller::HTTP_OK);
    }

    /**
     * Save default lesson plan
     *
     * @class_id int
     * @subject_id int
     * @semester_id int
     *
     */
    public function default_lesson_plan_post()
    {
        $data = json_decode($this->input->post('data'));

        $class_id = $this->input->post('class_id');

        // $section_id = $this->input->post('section_id');

        $subject_id = $this->input->post('subject_id');

        $semester_id = $this->input->post('semester_id');

        foreach ($data as $value) {
            try {

                $day = trim(strtolower($value[0]), 'day ');

                $concept = $value[1];

                $topic = $value[2];

                $lesson = $value[3];

                $type = $value[4];

                $content = $value[5];

                $thumb = $value[7];

                $inputId = $value[9];

                if ($inputId == null) {
                    $newrec = array(

                        'day' => $day,

                        'concept' => $concept,

                        'topic' => $topic,

                        'lesson' => $lesson,

                        'type' => $type,

                        'content' => $content,

                        'thumb' => $thumb,

                        'class_id' => $class_id,

                        'subject_id' => $subject_id,

                        'unique_code' => uniqid(),

                        'semester_id' => $semester_id,

                        'last_update' => date("Y-m-d H:i:s")
                    );

                    $result = $newrec;

                    $this->operation->table_name = 'default_lesson_plan';

                    $id = $this->operation->Create($newrec);
                } else {
                    $newrec = array(

                        'day' => $day,

                        'concept' => $concept,

                        'topic' => $topic,

                        'lesson' => $lesson,

                        'type' => $type,

                        'content' => $content,

                        'thumb' => $thumb,

                        'class_id' => $class_id,

                        'subject_id' => $subject_id,

                        'semester_id' => $semester_id,

                        'last_update' => date("Y-m-d H:i:s")
                    );

                    $this->operation->table_name = 'default_lesson_plan';

                    $id = $this->operation->Create($newrec, $inputId);
                }
                if ($id) {
                    $result['message'] = true;
                }
            } catch (Exception $ex) {
                echo $ex;
            }
        }

        $this->set_response($result, REST_Controller::HTTP_OK);
    }

    public function default_lesson_plan_delete()
    {
        $params = $this->parse_params();

        $class_id = $params['class_id'];
        $semester_id = $params['semester_id'];
        $subject_id = $params['subject_id'];

        if (! empty($class_id) && ! empty($semester_id) && ! empty($subject_id)) {
            $check = $this->db->query("DELETE FROM default_lesson_plan WHERE class_id=" . $class_id . " AND subject_id=" . $subject_id . " AND semester_id =" . $semester_id);
        }

        // TODO $check=$this->db->query("delete from semester_lesson_plan where class_id=".$class_id." and subject_id=".$subject_id." and semester_id =".$semester_id);

        $this->response($check, REST_Controller::HTTP_OK);
    }

    /**
     * Import default lesson plan
     */
    public function import_default_lesson_plan_post()
    {
        $result = array();

        $result['message'] = FALSE;

        $class_id = $this->input->post('class_id');

        $semester_id = $this->input->post('semester_id');

        $session_id = $this->input->post('session_id');

        $subject_id = $this->input->post('subject_id');

        if (isset($_FILES) == 1 && ! empty($class_id) && ! empty($subject_id) && ! empty($semester_id) && ! empty($session_id)) {

            // Save in database

            foreach ($_FILES as $value) {

                $valid_formats = array(
                    "csv",
                    "xls",
                    "xlsx"
                );

                if (strlen($value['name'])) {

                    list ($txt, $ext) = explode(".", $value['name']);

                    if (in_array(strtolower($ext), $valid_formats)) {

                        if (is_uploaded_file($value['tmp_name'])) {

                            $path = UPLOAD_PATH;

                            $file = time() . trim(basename($value['name']));

                            $filename = $path . $file;
                            if (move_uploaded_file($value['tmp_name'], $filename)) {
                                if ($ext == 'xls' || $ext == 'xlsx') {

                                    $excel_data = $this->get_excel_data($filename);

                                    $count = 1;
                                    $this->operation->table_name = 'default_lesson_plan';
                                    foreach ($excel_data as $rowData) {
                                        // Skip first header lines
                                        if ($count > 2) {
                                            $data = array(

                                                'day' => trim(strtolower($rowData[0][0]), 'day '),

                                                'concept' => trim($rowData[0][1]),

                                                'topic' => trim($rowData[0][2]),

                                                'lesson' => trim($rowData[0][3]),

                                                'type' => trim($rowData[0][4]),

                                                'content' => trim($rowData[0][5]),

                                                'thumb' => trim($rowData[0][6]),

                                                'class_id' => $class_id,

                                                'subject_id' => $subject_id,

                                                'date' => date("Y-m-d H:i"),

                                                'last_update' => date("Y-m-d H:i"),

                                                'unique_code' => uniqid(),

                                                'semester_id' => $semester_id,

                                                'session_id' => $session_id
                                            );
                                            if (! empty($data['concept']) && ! empty($data['topic'])) {
                                                $id = $this->operation->Create($data);
                                            }
                                        }
                                        $count ++;
                                    }
                                } else {

                                    $file = fopen($filename, "r");

                                    $i = 0;

                                    $this->operation->table_name = 'default_lesson_plan';
                                            
                                    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {

                                        if ($i > 1) {

                                            $data = array(

                                                'day' => trim($emapData[0]),

                                                'concept' => trim($emapData[1]),

                                                'topic' => trim($emapData[2]),

                                                'lesson' => trim($emapData[3]),

                                                'type' => trim($emapData[4]),

                                                'content' => trim($emapData[5]),

                                                'class_id' => $class_id,

                                                'subject_id' => $subject_id,

                                                'date' => date("Y-m-d H:i"),

                                                'last_update' => date("Y-m-d H:i:s"),

                                                'unique_code' => uniqid(),

                                                'semester_id' => $semester_id,

                                                'session_id' => $session_id
                                            );

                                            if (! empty(trim($emapData[6]))) {
                                                $data['thumb'] = trim($emapData[6]);
                                            }

                                            $id = $this->operation->Create($data);
                                        }

                                        $i ++;
                                    }

                                    fclose($file);
                                }
                            }

                            if ($id)
                                $result['message'] = TRUE;
                        }
                    }
                }
            }
        }

        $this->set_response($result, REST_Controller::HTTP_OK);
    }

    public function export_default_lesson_plan_get()
    {
        ob_end_clean();

        ob_start();

        $class_id = $this->input->get('class_id');

        $subject_id = $this->input->get('subject_id');

        $semester_id = $this->input->get('semester_id');

        try {
            if ($class_id != '' && $subject_id != '' && $semester_id != '') {
                $single = $this->operation->GetByQuery("SELECT * FROM default_lesson_plan WHERE class_id=" . $class_id . " AND subject_id=" . $subject_id . " AND semester_id=" . $semester_id);
                $classname = $this->operation->GetByQuery("SELECT grade FROM classes WHERE id=" . $class_id);

                $subjectname = $this->operation->GetByQuery("SELECT subject_name FROM subjects WHERE id=" . $subject_id);
            }
        } catch (Exception $e) {}

        require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php');

        require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        $objectPHPExcel = new PHPExcel();

        $objectPHPExcel->getProperties()->setCreator("");

        $objectPHPExcel->getProperties()->setLastModifiedBy("");

        $objectPHPExcel->getProperties()->setTitle("");

        $objectPHPExcel->getProperties()->setSubject("");

        $objectPHPExcel->getProperties()->setDescription("");

        $objectPHPExcel->setActiveSheetIndex(0);
        if (count($classname)) {
            $objectPHPExcel->getActiveSheet()->SetCellValue('A1', $classname[0]->grade);
        }
        if (count($classname)) {
            $objectPHPExcel->getActiveSheet()->SetCellValue('B1', $subjectname[0]->subject_name);
        }

        $objectPHPExcel->getActiveSheet()->SetCellValue('A2', 'Day');

        $objectPHPExcel->getActiveSheet()->SetCellValue('B2', 'Concept');

        $objectPHPExcel->getActiveSheet()->SetCellValue('C2', 'Topic');

        $objectPHPExcel->getActiveSheet()->SetCellValue('D2', 'lesson');

        $objectPHPExcel->getActiveSheet()->SetCellValue('E2', 'Type');

        $objectPHPExcel->getActiveSheet()->SetCellValue('F2', 'Content');

        $objectPHPExcel->getActiveSheet()->SetCellValue('G2', 'Thumbnail');

        $rows = 3;

        if (count($single)) {
            foreach ($single as $value) {

                $objectPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $value->day);

                $objectPHPExcel->getActiveSheet()->SetCellValue('B' . $rows, $value->concept);

                $objectPHPExcel->getActiveSheet()->SetCellValue('C' . $rows, $value->topic);

                $objectPHPExcel->getActiveSheet()->SetCellValue('D' . $rows, $value->lesson);

                $objectPHPExcel->getActiveSheet()->SetCellValue('E' . $rows, $value->type);

                $objectPHPExcel->getActiveSheet()->SetCellValue('F' . $rows, $value->content);

                $objectPHPExcel->getActiveSheet()->SetCellValue('G' . $rows, $value->thumb);

                $rows ++;
            }
        }

        $filename = 'default_lesson_plan';

        $objectPHPExcel->getActiveSheet()->setTitle("Project Overview");

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename=default_lesson_plan_' . date('m-d-Y') . ".csv");
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1

        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');

        $objWriter->save('php://output');

        $xlsData = ob_get_contents();

        ob_end_clean();

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        header("Content-Transfer-Encoding: binary ");

        $response = array(

            'op' => 'ok',
            'class' => $classname,
            'date' => date('m-d-Y'),

            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );

        $this->set_response($response, REST_Controller::HTTP_OK);
    }

    // endregion default lesson plan

    // region semester lesson plan
    public function semester_lesson_delete()
    {
        $params = $this->parse_params();

        $iid = $params['id'];
        
        if ($iid != "") {

            $this->db->query("UPDATE semester_lesson_plan SET active=0 WHERE id=" . $this->db->escape($iid));
            $result = true;
        }

        $this->set_response($result, REST_Controller::HTTP_OK);
    }

    public function semester_lesson_plan_get()
    {
        $class_id = $this->input->get('class_id');
        $subject_id = $this->input->get('subject_id');
        $session_id = $this->input->get('session_id');
        $semester_id = $this->input->get('semester_id');
        $user_id = $this->input->get('user_id');

        if (empty($class_id) || empty($semester_id) || empty($session_id) || empty($user_id)) {
            $this->set_response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            return;
        }

        try {

            
            $lesson_count = $this->operation->GetByQuery("SELECT count(id) as lc FROM semester_lesson_plan WHERE active=1 AND class_id=" . $class_id . " and semester_id =" . $semester_id . " AND session_id =" . $session_id . " ORDER BY preference ASC");
     

            $data = array();
            $semester_plan_updated = false;

            if (count($lesson_count) > 0 && $lesson_count[0]->lc == 0) {
                // Generate semester lessons when no lesson is available

                // TODO arrange subjects in a specific order
                $class_subjects = $this->operation->GetByQuery("SELECT s.* FROM subjects s INNER JOIN classes c ON c.id = s.class_id WHERE s.class_id = " . $class_id . " ORDER BY s.subject_name ASC");

                $max_row = $this->operation->GetByQuery("SELECT day FROM `default_lesson_plan`  WHERE class_id = " . $class_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " ORDER BY day DESC LIMIT 1");

                if (count($class_subjects) && count($max_row)) {

                    $max_days = $max_row[0]->day;
                    $std_plan_settings = array();
                    $set_index = array();
                    $position = 1;

                    $this->operation->table_name = TABLE_STUDENT_SEMESTERS;
                    $class_students = $this->operation->GetByWhere(array(
                        'class_id' => $class_id,
                        'status' => 'r'
                    ));
                    $std_count = count($class_students);

                    for ($i = 1; $i <= $max_days; $i ++) {

                        foreach ($class_subjects as $subject) {

                            if (isset($set_index[$subject->id])) {
                                $set_index[$subject->id] += 1;
                            } else {
                                $set_index[$subject->id] = 1;
                            }

                            if (!isset($std_plan_settings[$subject->id])) {

                                $this->operation->table_name = TABLE_STUDENT_LESSON_PLAN_SETTINGS;

                                $recs = $this->operation->GetByWhere(array(
                                        'subject_id' => $subject->id,
                                    ));

                                $rec_updated = false;
                                foreach ($recs as $rec) {
                                    $std_plan_settings[$subject->id][$rec->student_id] = $rec->lesson_plan_updated; 
                                    $rec_updated = true;
                                }
                                if(!$rec_updated){
                                    $std_plan_settings[$subject->id] = array();
                                }
                            }

                            $this->operation->table_name = "default_lesson_plan";
                            $lessons = $this->operation->GetByWhere(array(
                                'day' => $i,
                                'subject_id' => $subject->id,
                                'class_id' => $class_id
                            ));

                            foreach ($lessons as $lesson) {

                                    $newdata = array(
                                        'set_id' => $set_index[$subject->id],
                                        'user_id' => $user_id,
                                        'active' => 1,
                                        'concept' => $lesson->concept,
                                        'topic' => $lesson->topic,
                                        'lesson' => $lesson->lesson,
                                        'type' => $lesson->type,
                                        'content' => $lesson->content,
                                        'unique_code' => $lesson->unique_code,
                                        'class_id' => $lesson->class_id,
                                        'subject_id' => $lesson->subject_id,
                                        'semester_id' => $semester_id,
                                        'session_id' => $session_id,
                                        'created' => date('Y-m-d H:i:s'),
                                        'updated' => date('Y-m-d H:i:s'),
                                        'preference' => $position
                                    );

                                    $this->operation->table_name = 'semester_lesson_plan';
                                    $id = $this->operation->Create($newdata);

                                    if ($id > 0) {
                                        $position ++;
                                        $semester_plan_updated = TRUE;
                                    }

                            }

                            // mark student lesson plan to get updated

                            if(count($lessons) > 0 && $std_count > 0){

                                $this->operation->table_name = TABLE_STUDENT_LESSON_PLAN_SETTINGS;

                                foreach ($class_students as $student) {

                                    if(!isset($std_plan_settings[$subject->id][$student->student_id]) || 
                                        $std_plan_settings[$subject->id][$student->student_id]!=1){

                                        $rec_exists = $this->operation->GetByWhere(array(
                                            'subject_id' => $subject->id,
                                            'student_id' => $student->student_id
                                        ));

                                        $updated_subjects = $this->operation->Create(array(
                                        'student_id' => $student->student_id,
                                        'subject_id' => $subject->id,
                                        'lesson_plan_updated' => 1,
                                        'created' => date('Y-m-d H:i:s'),
                                        'user_id' => $user_id
                                        ), count($rec_exists)>0?$rec_exists[0]->id:null);
                                        $std_plan_settings[$subject->id][$student->student_id]=1;
                                    }

                                }
                            }
                        }
                    }

                }

            }

            if (empty($subject_id)) {
                $semester_lessons = $this->operation->GetByQuery("SELECT * FROM semester_lesson_plan WHERE active=1 AND class_id=" . $class_id . " and semester_id =" . $semester_id . " AND session_id =" . $session_id . " ORDER BY preference ASC");
            } else {
                $semester_lessons = $this->operation->GetByQuery("SELECT * FROM semester_lesson_plan WHERE active=1 AND class_id=" . $class_id . " and semester_id =" . $semester_id . " AND session_id =" . $session_id . " and subject_id=" . $subject_id . " ORDER BY preference ASC");
            }

            if (count($semester_lessons)) {
                foreach ($semester_lessons as $value) {
                    $data[] = array(
                        'id' => $value->id,
                        'set_id' => $value->set_id,
                        'topic' => $value->topic,
                        'content' => $value->content,
                        'concept' => $value->concept,
                        'lesson' => $value->lesson,
                        'type' => $value->type,
                        'preference' => $value->preference
                    );
                }
            }

        } catch (Exception $e) {}

        $this->set_response($data, REST_Controller::HTTP_OK);
    }

    public function semester_lesson_plan_post()
    {
        try {
            $data = json_decode(stripslashes($this->input->post('data')));
            $class_id = $this->input->post('class_id');
            $subject_id = $this->input->post('subject_id');
            $semester_id = $this->input->post('semester_id');
            $session_id = $this->input->post('session_id');
            $user_id = $this->input->post('user_id');

            // $lesson = $this->operation->GetByQuery("SELECT * FROM semester_lesson_plan WHERE class_id=" . $class_id . " AND subject_id=" . $subject_id . " AND semester_id=" . $semester_id);
            $id = 0;

            if (empty($class_id) || empty($subject_id) || empty($semester_id) || empty($session_id) || empty($user_id)) {
                $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
                return;
            }

            $result = array();

            $i_date = 0;
            $i_concept = 1;
            $i_topic = 2;
            $i_lesson = 3;
            $i_type = 4;
            $i_content = 5;
            $i_pref = 6;
            $i_id = 7;

            foreach ($data as $value) {
                // $read_date = $value[$i_date];
                $concept = trim($value[$i_concept]);
                $topic = trim($value[$i_topic]);
                $lesson = trim($value[$i_lesson]);
                $type = trim($value[$i_type]);
                $content = trim($value[$i_content]);
                // $preference = $value[$i_pref];
                $lid = (int) $value[$i_id];
                if ($lid<=0) {
                //TODO: Semester lessons can't be changed. Delete All semster lessons to generate them again.
                    $newrec = array(
                        'user_id' => $user_id,
                        'concept' => $concept,
                        'topic' => $topic,
                        'lesson' => $lesson,
                        'type' => $type,
                        'content' => $content,
                        'class_id' => $class_id,
                        'subject_id' => $subject_id,
                        'active' => 1,
                        'unique_code' => uniqid(),
                        'updated' => date("Y-m-d H:i"),
                        'created' => date("Y-m-d H:i"),
                        'session_id' => $session_id,
                        'semester_id' => $semester_id
                    );
                    $this->operation->table_name = 'semester_lesson_plan';
                    $id = $this->operation->Create($newrec);
                } else {
                    $newrec = array(
                        'user_id' => $user_id,
                        'concept' => $concept,
                        'topic' => $topic,
                        'lesson' => $lesson,
                        'type' => $type,
                        'content' => $content,
                        'updated' => date("Y-m-d H:i")
                    );
                    $this->operation->table_name = 'semester_lesson_plan';
                    $id = $this->operation->Create($newrec, $lid);
                }

                if (count($id)) {
                    $result['message'] = true;
                }
            }

            if($result['message']){

                // mark student lesson plan to get updated

                $std_plan_settings = array();
                
                $this->operation->table_name = TABLE_STUDENT_SEMESTERS;
                $class_students = $this->operation->GetByWhere(array(
                    'class_id' => $class_id,
                    'status' => 'r'
                ));
                $std_count = count($class_students);

                if($std_count>0){

                    $this->operation->table_name = TABLE_STUDENT_LESSON_PLAN_SETTINGS;
                    
                    foreach ($class_students as $student) {

                        if(!isset($std_plan_settings[$student->student_id]) || 
                            $std_plan_settings[$student->student_id]!=1){

                            $rec_exists = $this->operation->GetByWhere(array(
                                'subject_id' => $subject_id,
                                'student_id' => $student->student_id
                            ));

                            $updated_subjects = $this->operation->Create(array(
                            'student_id' => $student->student_id,
                            'subject_id' => $subject_id,
                            'lesson_plan_updated' => 1,
                            'created' => date('Y-m-d H:i:s'),
                            'user_id' => $user_id
                            ), count($rec_exists)>0?$rec_exists[0]->id:null);
                            $std_plan_settings[$student->student_id]=1;
                        }
                    }
                }
            }

            $this->response($result, REST_Controller::HTTP_OK);
        } catch (Exception $e) {}
    }

    public function export_semester_lesson_plan_get()
    {
        $class_id = $this->input->get('class_id');
        // $section_id = $this->input->get('section_id');
        $subject_id = $this->input->get('subject_id');
        $semester_id = $this->input->get('semester_id');
        $session_id = $this->input->get('session_id');

        if (empty($subject_id) || empty($class_id) || empty($semester_id) || empty($session_id)) {

            $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            exit();
        }

        ob_end_clean();
        ob_start();
        $single = $this->operation->GetByQuery("SELECT * FROM semester_lesson_plan WHERE active=1 AND class_id=" . $class_id . " AND subject_id=" . $subject_id . " AND semester_id =" . $semester_id . " AND session_id =" . $session_id);
        $classname = $this->operation->GetByQuery("SELECT grade FROM classes WHERE id=" . $class_id);
        $subjectname = $this->operation->GetByQuery("SELECT subject_name FROM subjects WHERE id=" . $subject_id);
        require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php');

        require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        $objectPHPExcel = new PHPExcel();
        $objectPHPExcel->getProperties()->setCreator("");
        $objectPHPExcel->getProperties()->setLastModifiedBy("");
        $objectPHPExcel->getProperties()->setTitle("");
        $objectPHPExcel->getProperties()->setSubject("");
        $objectPHPExcel->getProperties()->setDescription("");
        $objectPHPExcel->setActiveSheetIndex(0);
        $objectPHPExcel->getActiveSheet()->SetCellValue('A1', $classname[0]->grade);
        $objectPHPExcel->getActiveSheet()->SetCellValue('C1', $subjectname[0]->subject_name);
        $objectPHPExcel->getActiveSheet()->SetCellValue('D1', 'Semester lesson plan ');
        
        $objectPHPExcel->getActiveSheet()->SetCellValue('A2', 'Concept');
        $objectPHPExcel->getActiveSheet()->SetCellValue('B2', 'Topic');
        $objectPHPExcel->getActiveSheet()->SetCellValue('C2', 'Lesson');
        $objectPHPExcel->getActiveSheet()->SetCellValue('D2', 'Type');
        $objectPHPExcel->getActiveSheet()->SetCellValue('E2', 'Content');
        $rows = 3;
        foreach ($single as $value) {
            $objectPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $value->concept);
            $objectPHPExcel->getActiveSheet()->SetCellValue('B' . $rows, $value->topic);
            $objectPHPExcel->getActiveSheet()->SetCellValue('C' . $rows, $value->lesson);
            $objectPHPExcel->getActiveSheet()->SetCellValue('D' . $rows, $value->type);
            $objectPHPExcel->getActiveSheet()->SetCellValue('E' . $rows, $value->content);
            $rows ++;
        }

        $filename = 'task exported on' . " ." . 'csv';
        $objectPHPExcel->getActiveSheet()->setTitle("Project Overview");
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
            'class' => $classname,
            'subject' => $subjectname,
            'date' => date('M-d-Y'),
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );

        $this->response($response, REST_Controller::HTTP_OK);
        exit();
    }

    public function sync_semester_lesson_plan_post()
    {
        $result = false;

        $class_id = $this->input->post('class_id');
        $subject_id = $this->input->post('subject_id');
        // $section_id = $this->input->post('section_id');
        $semester_id = $this->input->post('semester_id');
        $session_id = $this->input->post('session_id');
        $user_id = $this->input->post('user_id');

        if (empty($class_id) || empty($subject_id) || empty($semester_id) || empty($session_id) || empty($user_id)){
            $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            return;
        }

        $lesson = $this->operation->GetByQuery("SELECT * FROM default_lesson_plan WHERE class_id=" . $class_id . " AND subject_id=" . $subject_id . " AND semester_id =" . $semester_id);

        if (count($lesson)) {

            foreach ($lesson as $value) {

                $isPresent = $this->operation->GetByQuery("SELECT * FROM semester_lesson_plan WHERE unique_code= '" . $value->unique_code . "'");

                $this->operation->table_name = 'semester_lesson_plan';
                $this->operation->primary_key = 'id';

                if (! count($isPresent)) {

                    $newdata = array(
                        'concept' => $value->concept,
                        'content' => $value->content,
                        'topic' => $value->topic,
                        'type' => $value->type,
                        'lesson' => $value->lesson,
                        'unique_code' => $value->unique_code,
                        'class_id' => $class_id,
                        'subject_id' => $subject_id,
                        'semester_id' => $semester_id,
                        'session_id' => $session_id,
                        'active' => 1,
                        'created' => date("Y-m-d H:i"),
                        'updated' => date("Y-m-d H:i")
                    );
                    $id = $this->operation->Create($newdata);
                } else {

                    $data = array(
                        'concept' => $value->concept,
                        'content' => $value->content,
                        'topic' => $value->topic,
                        'type' => $value->type,
                        'lesson' => $value->lesson,
                        'updated' => date("Y-m-d H:i")
                    );

                    $id = $this->operation->Create($data, $isPresent[0]->id);
                }
                if ($id) {
                    $result = true;
                }
            }

            if($result){

                // mark student lesson plan to get updated

                $std_plan_settings = array();
                
                $this->operation->table_name = TABLE_STUDENT_SEMESTERS;
                $class_students = $this->operation->GetByWhere(array(
                    'class_id' => $class_id,
                    'status' => 'r'
                ));
                $std_count = count($class_students);

                if($std_count>0){

                    $this->operation->table_name = TABLE_STUDENT_LESSON_PLAN_SETTINGS;
                    
                    foreach ($class_students as $student) {

                        if(!isset($std_plan_settings[$student->student_id]) || 
                            $std_plan_settings[$student->student_id]!=1){

                            $rec_exists = $this->operation->GetByWhere(array(
                                'subject_id' => $subject_id,
                                'student_id' => $student->student_id
                            ));

                            $updated_subjects = $this->operation->Create(array(
                            'student_id' => $student->student_id,
                            'subject_id' => $subject_id,
                            'lesson_plan_updated' => 1,
                            'created' => date('Y-m-d H:i:s'),
                            'user_id' => $user_id
                            ), count($rec_exists)>0?$rec_exists[0]->id:null);
                            $std_plan_settings[$student->student_id]=1;
                        }
                    }
                }
            }
        }

        $this->set_response($result, REST_Controller::HTTP_OK);
    }

    public function semester_lesson_plan_delete()
    {
        $class_id = $this->input->get('class_id');
        $session_id = $this->input->get('session_id');
        $semester_id = $this->input->get('semester_id');
        $subject_id = $this->input->get('subject_id');

        if (empty($subject_id) || empty($class_id) || empty($semester_id) || empty($session_id)) {

            $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            exit();
        }

        $result = $this->db->query("UPDATE semester_lesson_plan SET active=0 WHERE class_id=" . $class_id . " AND subject_id=" . $subject_id . " AND semester_id =" . $semester_id . " AND session_id =" . $session_id);

        $this->set_response($result, REST_Controller::HTTP_OK);
    }

    // endregion semester lesson plan

    // region grade lesson plan
    public function grade_lesson_plan_get()
    {
        $class_id = $this->input->get('class_id');
        $semester_id = $this->input->get('semester_id');
        $session_id = $this->input->get('session_id');
        $school_id = $this->input->get('school_id');

        $subjectslist = $this->get_subjects($class_id);

        $DefaultUnits = array();
        $maxCount = 0;
        $minDays = - 1;
        $maxDays = 0;
        $subjectNames = array();
        foreach ($subjectslist as $subject) {
            // $DefaultUnits[$subject->id] = $this->operation->GetByQuery("SELECT * FROM default_lesson_plan WHERE class_id=" . $class_id . " AND semester_id =" . $semester_id . " AND session_id =" . $session_id . " AND subject_id=" . $subject->id . " GROUP BY concept ORDER BY day ASC");
            $DefaultUnits[$subject->id] = $this->operation->GetByQuery("SELECT * FROM semester_lesson_plan WHERE class_id=" . $class_id . " AND semester_id =" . $semester_id . " AND session_id =" . $session_id . " AND subject_id=" . $subject->id . " GROUP BY concept ORDER BY read_date ASC");

            $lessonCount = count($DefaultUnits[$subject->id]);

            $startDay = 0;
            if ($lessonCount > 0)
                $startDay = $DefaultUnits[$subject->id][0]->day;

            $lastDay = 0;
            if ($lessonCount > 0)
                $lastDay = $DefaultUnits[$subject->id][$lessonCount - 1]->day;

            if ($minDays == - 1)
                $minDays = $startDay;
            if ($minDays > $startDay) {
                $minDays = $startDay;
            }

            if ($maxDays < $lastDay) {
                $maxDays = $lastDay;
            }

            if ($maxCount < $lessonCount) {
                $maxCount = $lessonCount;
            }

            $subjectNames[$subject->id] = $subject->subject_name;
        }

        $Gradelessonfromdb = $this->operation->GetByQuery("SELECT count(id) as count FROM grade_lesson_plan WHERE class_id=" . $class_id . " AND semester_id =" . $semester_id . " AND session_id =" . $session_id . " AND school_id =" . $school_id . " ORDER BY seq ASC");

        $seq = 1000;
        $data = array();
        $semester_plan_updated = false;

        if ($Gradelessonfromdb[0]->count < 1 && $maxCount > 0) {
            // Load data from default lesson plan

            $di = $minDays;
            do {
                // for each day
                $li = 0;
                do {
                    // for each lesson
                    foreach ($subjectslist as $key => $subject) {

                        if (count($DefaultUnits[$subject->id][$li]) && $DefaultUnits[$subject->id][$li]->day == $di) {

                            $unit = $DefaultUnits[$subject->id][$li];

                            $newdata = array(
                                'concept' => ucfirst($unit->concept),
                                'unique_code' => $unit->unique_code,
                                'class_id' => $class_id,
                                'subject_id' => $subject->id,
                                'semester_id' => $semester_id,
                                'session_id' => $session_id,
                                'school_id' => $school_id,
                                'seq' => $seq ++,
                                'last_update' => date("Y-m-d H:i"),
                                'created' => date("Y-m-d H:i")
                            );

                            $this->operation->table_name = 'grade_lesson_plan';
                            // print_r($newdata);
                            $id = $this->operation->Create($newdata);

                            $semester_plan_updated = true;
                        }
                    }
                } while ($li ++ < $maxCount);
            } while ($di ++ <= $maxDays);
        } else {
            /*
             * print_r('minDays ' . $minDays .' , maxDays ' . $maxDays .' , maxCount ' . $maxCount);
             * print_r("Skip updating grade plan. ". $this->db->last_query());
             */
        }

        if (count($Gradelessonfromdb) || $semester_plan_updated == true) {
            $units = $this->operation->GetByQuery("SELECT d.* FROM grade_lesson_plan d WHERE d.class_id=" . $class_id . " AND d.semester_id = " . $semester_id . " AND d.session_id = " . $session_id . " AND d.school_id =" . $school_id . " ORDER BY d.seq ASC");
            if (count($units)) {
                foreach ($units as $key => $value) {
                    if ($value->concept == null || $value->concept == '') {} else {
                        $prereq_id = '';
                        $prereq_concept = '';
                        $prereq_subject = '';

                        if ($value->prereq_id != null && $value->prereq_id > 0) {

                            $pr = $this->operation->GetByQuery("SELECT d.* FROM grade_lesson_plan d WHERE d.id=" . $value->prereq_id);
                            if (count($pr)) {
                                $prereq_id = $pr[0]->id;
                                $prereq_concept = $pr[0]->concept;
                                $prereq_subject = $subjectNames[$pr[0]->subject_id];
                            }
                        }

                        $data[] = array(
                            'id' => $value->id,
                            'concept' => $value->concept,
                            'subject' => $subjectNames[$value->subject_id],
                            'subject_id' => $value->subject_id,
                            'prereq_id' => $prereq_id,
                            'prereq_concept' => $prereq_concept,
                            'prereq_subject' => $prereq_subject
                        );
                    }
                }
            }
        }

        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function grade_lesson_plan_post()
    {
        try {

            $data = json_decode($this->input->post('data'));
            $class_id = $this->input->post('class_id');
            $semester_id = $this->input->post('semester_id');
            $session_id = $this->input->post('session_id');
            $school_id = $this->input->post('school_id');

            $result = array();
            $subjectNameIds = array();
            $is_subjects = $this->operation->GetByQuery("SELECT s.* FROM subjects s WHERE s.class_id = " . $class_id . " AND s.session_id = " . $session_id . " AND s.semester_id = " . $semester_id);

            if (count($is_subjects)) {
                foreach ($is_subjects as $key => $value) {
                    $subjectNameIds[$value->subject_name] = array(
                        'id' => $value->id,
                        'subject' => $value->subject_name
                    );
                }
            }

            $loop = 0;
            $seqChanged = false;
            $rowIdMap = array();

            $result['message'] = false;

            foreach ($data as $key => $value) {
                $concept = trim($value[0]);
                $subject = trim($value[1]);
                $subject_id = null;
                if (! empty($subject))
                    $subject_id = $subjectNameIds[$subject]['id'];

                $unitid = $value[5];
                $prid = $value[6];

                if (! is_numeric($subject_id)) {
                    continue;
                }

                if (is_null($unitid) && ! is_numeric($unitid)) { // Add new unit
                                                                 // Assign seq
                    $seq = 0;

                    // Get max seq
                    $seqMax = 1000;
                    $this->operation->table_name = 'grade_lesson_plan';
                    $res = $this->operation->GetByQuery("SELECT d.seq FROM grade_lesson_plan d WHERE d.class_id=" . $class_id . " AND d.semester_id = " . $semester_id . " AND d.session_id = " . $session_id . " AND d.school_id =" . $school_id . " ORDER BY d.seq DESC");

                    if (count($res))
                        $seqMax = $res[0]->seq + 1;

                    $prvUnit = null;
                    $iloop = $loop - 1;
                    while ($iloop >= 0) {
                        if (is_numeric($data[$iloop][5])) {
                            $prvUnit = $data[$iloop];
                            break;
                        }
                        $iloop --;
                    }

                    $nextUnit = null;
                    $iloop = $loop + 1;
                    while ($iloop < count($data)) {
                        if (is_numeric($data[$iloop][5])) {
                            $nextUnit = $data[$iloop];
                            break;
                        }
                        $iloop ++;
                    }

                    if ($loop == 0) { // new entry at start
                        if ($nextUnit != null) {
                            $this->operation->table_name = 'grade_lesson_plan';
                            $res = $this->operation->GetByQuery("SELECT seq FROM grade_lesson_plan WHERE id=" . $nextUnit[5]);
                            if (count($res)) {
                                $seq = $res[0]->seq - 1;
                                $this->db->query("UPDATE grade_lesson_plan SET seq=seq+1 WHERE class_id=" . $class_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " AND school_id =" . $school_id . " AND seq>" . $res[0]->seq);
                            }
                        }
                    } else if ($loop == count($data) - 1) { // new entry at end
                        if ($prvUnit != null) {
                            $this->operation->table_name = 'grade_lesson_plan';
                            $res = $this->operation->GetByQuery("SELECT seq FROM grade_lesson_plan WHERE id=" . $prvUnit[5]);
                            if (count($res)) {
                                $seq = $res[0]->seq + 1;
                                $this->db->query("UPDATE grade_lesson_plan SET seq=seq+1 WHERE class_id=" . $class_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " AND school_id =" . $school_id . " AND seq>" . $res[0]->seq);
                            }
                        }
                    } else if ($loop > 0 && $loop < (count($data) - 1)) { // new entry after start and before end
                        if ($prvUnit != null) {
                            $this->operation->table_name = 'grade_lesson_plan';
                            $res = $this->operation->GetByQuery("SELECT seq FROM grade_lesson_plan WHERE id=" . $prvUnit[5]);
                            if (count($res)) {
                                $seq = $res[0]->seq + 1;
                                $this->db->query("UPDATE grade_lesson_plan SET seq=seq+1 WHERE class_id=" . $class_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " AND school_id =" . $school_id . " AND seq>" . $res[0]->seq);
                            }
                        } else if ($nextUnit != null) {
                            $this->operation->table_name = 'grade_lesson_plan';
                            $res = $this->operation->GetByQuery("SELECT seq FROM grade_lesson_plan WHERE id=" . $nextUnit[5]);
                            if (count($res)) {
                                $seq = $res[0]->seq - 1;
                                $this->db->query("UPDATE grade_lesson_plan SET seq=seq+1 WHERE class_id=" . $class_id . " AND semester_id = " . $semester_id . " AND session_id = " . $session_id . " AND school_id =" . $school_id . " AND seq>" . $res[0]->seq);
                            }
                        }
                    }

                    if ($seq == 0) {
                        $seq = $seqMax + 1;
                    }

                    $newdata = array(
                        'concept' => ucfirst($concept),
                        'unique_code' => uniqid(),
                        'class_id' => $class_id,
                        'subject_id' => $subject_id,
                        'semester_id' => $semester_id,
                        'session_id' => $session_id,
                        'school_id' => $school_id,
                        'seq' => $seq,
                        'last_update' => date("Y-m-d H:i"),
                        'created' => date("Y-m-d H:i")
                    );

                    $idSeqMap = array();

                    $this->operation->table_name = 'grade_lesson_plan';
                    $id = $this->operation->Create($newdata);

                    $data[$key][4] = 'data-row-id ="' . $loop . '"';
                    $data[$key][5] = $id;
                    // print_r($newdata);
                } else {
                    // Update unit seq if changed
                    $useq = null;
                    $row = null;

                    if (! empty($value[4]))
                        $row = $this->is_between('data-row-id ="', '"', $value[4]);

                    if (! $seqChanged && is_numeric($row) && $loop != $row) {
                        $seqChanged = true;
                    }
                    if ($seqChanged) {
                        if (count($idSeqMap) == 0) {
                            $idSeqMap = array();
                            foreach ($data as $keyi => $valuei) {
                                if (is_numeric($valuei[5])) {
                                    $this->operation->table_name = 'grade_lesson_plan';
                                    $res = $this->operation->GetByQuery("SELECT seq FROM grade_lesson_plan WHERE id=" . $valuei[5]);
                                    if (count($res))
                                        $idSeqMap[$valuei[5]] = $res[0]->seq;
                                }
                            }
                        }
                        if (count($rowIdMap) == 0) {
                            $rowIdMap = array();
                            foreach ($data as $keyi => $valuei) {
                                if (is_numeric($valuei[5])) {
                                    $rowi = $this->is_between('data-row-id ="', '"', $valuei[4]);
                                    if (is_numeric($rowi))
                                        $rowIdMap[$rowi] = $valuei[5];
                                }
                            }
                        }

                        $uid = $rowIdMap[$loop];
                        $useq = $idSeqMap[$uid];
                    }

                    // Update unit
                    $newdata = array(
                        'concept' => $concept,
                        'subject_id' => $subject_id,
                        'prereq_id' => is_numeric($prid) ? $prid : null,
                        'last_update' => date("Y-m-d H:i")
                    );

                    if (is_numeric($useq)) {
                        $newdata['seq'] = $useq;
                    }

                    $this->operation->table_name = 'grade_lesson_plan';
                    $id = $this->operation->Create($newdata, $unitid);
                    // print_r($newdata);
                }

                if ($id) {
                    $result['message'] = true;
                }
                $loop ++;
            }

            $this->response($result, REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function grade_lesson_delete()
    {
        $id = $this->input->get('data');
        $result = false;
        foreach ($id as $value) {
            if ($value != "") {
                $this->db->query("DELETE FROM grade_lesson_plan WHERE id=" . $value);
                // echo $this->db->last_query();
            }

            $result = true;
        }

        $this->response($result, REST_Controller::HTTP_OK);
    }

    public function export_grade_lesson_plan_get()
    {
        $class_id = $this->input->get('class_id');
        $semester_id = $this->input->get('semester_id');
        $session_id = $this->input->get('session_id');

        ob_end_clean();
        ob_start();

        $single = $this->operation->GetByQuery("SELECT * FROM grade_lesson_plan WHERE class_id=" . $class_id . " AND session_id=" . $session_id . " AND semester_id =" . $semester_id);

        $classname = $this->operation->GetByQuery("SELECT grade FROM classes WHERE id=" . $class_id);

        require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php');

        require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        $objectPHPExcel = new PHPExcel();
        $objectPHPExcel->getProperties()->setCreator("");
        $objectPHPExcel->getProperties()->setLastModifiedBy("");
        $objectPHPExcel->getProperties()->setTitle("");
        $objectPHPExcel->getProperties()->setSubject("");
        $objectPHPExcel->getProperties()->setDescription("");
        $objectPHPExcel->setActiveSheetIndex(0);
        $objectPHPExcel->getActiveSheet()->SetCellValue('A1', 'Grade lesson plan ');
        $objectPHPExcel->getActiveSheet()->SetCellValue('B1', $classname[0]->grade);

        $objectPHPExcel->getActiveSheet()->SetCellValue('A2', 'Unit');
        $objectPHPExcel->getActiveSheet()->SetCellValue('B2', 'Subject');
        $objectPHPExcel->getActiveSheet()->SetCellValue('C2', 'Prereq Unit');
        $objectPHPExcel->getActiveSheet()->SetCellValue('D2', 'Subject');

        $rows = 3;
        foreach ($single as $value) {
            $subject = '';
            $is_subject = $this->get_subject($value->subject_id);
            if ($is_subject) {
                $subject = $is_subject->subject_name;
            }

            $prereq_concept = $prereq_subject = '';
            if ($value->prereq_id) {
                $prereq = $this->operation->GetByQuery("SELECT * FROM grade_lesson_plan WHERE id=" . $value->prereq_id);
                if (count($prereq)) {
                    $prereq_concept = $prereq[0]->concept;
                    $is_prereq_subject = $this->get_subject($prereq[0]->subject_id);
                    if ($is_prereq_subject) {
                        $prereq_subject = $is_prereq_subject->subject_name;
                    }
                }
            }

            $objectPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $value->concept);
            $objectPHPExcel->getActiveSheet()->SetCellValue('B' . $rows, $subject);
            $objectPHPExcel->getActiveSheet()->SetCellValue('C' . $rows, $prereq_concept);
            $objectPHPExcel->getActiveSheet()->SetCellValue('D' . $rows, $prereq_subject);

            $rows ++;
        }

        $filename = 'grade plan' . " ." . 'csv';
        $objectPHPExcel->getActiveSheet()->setTitle("Project Overview");
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
            'class' => $classname,
            'semester' => $semester_id,
            'date' => date('M-d-Y'),
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );
        $this->response($response, REST_Controller::HTTP_OK);
        exit();
    }

    public function sync_grade_lesson_plan_post()
    {
        $class_id = $this->input->post('class_id');
        $semester_id = $this->input->post('semester_id');
        $session_id = $this->input->post('session_id');
        $school_id = $this->input->post('school_id');

        $lesson = $this->operation->GetByQuery("SELECT * FROM default_lesson_plan WHERE class_id=" . $class_id . " AND semester_id =" . $semester_id . " GROUP BY concept ORDER BY day ASC");

        if (count($lesson)) {
            foreach ($lesson as $value) {
                $isPresent = $this->operation->GetByQuery("SELECT * FROM grade_lesson_plan WHERE unique_code= '" . $value->unique_code . "'" . " AND class_id= " . $class_id . " AND semester_id =" . $semester_id . " AND session_id =" . $session_id);

                if (! count($isPresent)) {

                    // Assign seq
                    $seq = 0;
                    $this->operation->table_name = 'grade_lesson_plan';
                    $res = $this->operation->GetByQuery("SELECT d.seq FROM grade_lesson_plan d WHERE d.class_id=" . $class_id . " AND d.semester_id = " . $semester_id . " AND d.session_id = " . $session_id . " AND d.school_id =" . $school_id . " ORDER BY d.seq DESC");

                    if (count($res))
                        $seq = $res[0]->seq + 1;

                    $newdata = array(
                        'concept' => $value->concept,
                        'subject_id' => $value->subject_id,
                        'class_id' => $class_id,
                        'seq' => $seq,
                        'last_update' => date("Y-m-d H:i"),
                        'created' => date("Y-m-d H:i"),
                        'unique_code' => $value->unique_code,
                        'semester_id' => $semester_id,
                        'school_id' => $school_id,
                        'session_id' => $session_id
                    );

                    $this->operation->table_name = 'grade_lesson_plan';
                    $this->operation->primary_key = 'id';
                    $id = $this->operation->Create($newdata);
                } else {

                    $newdata = array(
                        'concept' => $value->concept,
                        'subject_id' => $value->subject_id,
                        'last_update' => date("Y-m-d H:i")
                    );

                    $this->operation->table_name = 'grade_lesson_plan';
                    $this->operation->Create($newdata, $isPresent[0]->id);
                }
            }
        }
        $result = array();
        $result['message'] = true;
        $this->set_response($result, REST_Controller::HTTP_OK);
    }

    // endregion grade lesson plan

    // region student lesson plan SLP
    private function sync_student_lessons($student_id, $subject_id, $class_id, $semester_id, $session_id)
    {
        $result = FALSE;

        if (empty($class_id) || empty($student_id) || empty($semester_id) || empty($session_id) || empty($subject_id)) {

            return $result;
        }

        $this->operation->table_name = TABLE_SEMESTER_LESSON_PLAN;
        $lessons = $this->operation->GetByWhere(array(
            'subject_id' => $subject_id,
            'class_id' => $class_id,
            'semester_id' => $semester_id,
            'session_id' => $session_id
        ));

        if (count($lessons)) {

            foreach ($lessons as $lesson) {

                $this->operation->table_name = TABLE_STUDENT_LESSON_PLAN;
                $isPresent = $this->operation->GetByWhere(array(
                    'lesson_code' => $lesson->unique_code,
                    'student_id' => $student_id,
                    'subject_id' => $subject_id,
                    'class_id' => $class_id,
                    'semester_id' => $semester_id,
                    'session_id' => $session_id
                ));

                $this->operation->table_name = TABLE_STUDENT_LESSON_PLAN;
                $this->operation->primary_key = 'id';

                if (! count($isPresent)) {

                    $newdata = array(
                        'set_id' => $lesson->set_id,
                        'concept' => $lesson->concept,
                        'content' => $lesson->content,
                        'topic' => $lesson->topic,
                        'type' => $lesson->type,
                        'lesson' => $lesson->lesson,
                        'preference' => $lesson->preference,
                        'lesson_code' => $lesson->unique_code,
                        'student_id' => $student_id,
                        'class_id' => $class_id,
                        'subject_id' => $subject_id,
                        'semester_id' => $semester_id,
                        'session_id' => $session_id,
                        'active' => 1,
                        'created' => date("Y-m-d H:i"),
                        'updated' => date("Y-m-d H:i")
                    );
                    $id = $this->operation->Create($newdata);
                } else {

                    $data = array(
                        'set_id' => $lesson->set_id,
                        'concept' => $lesson->concept,
                        'content' => $lesson->content,
                        'topic' => $lesson->topic,
                        'type' => $lesson->type,
                        'lesson' => $lesson->lesson,
                        'preference' => $lesson->preference,
                        'updated' => date("Y-m-d H:i")
                    );

                    $id = $this->operation->Create($data, $isPresent[0]->id);
                }
                if ($id) {
                    $result = TRUE;
                }
            }
        }
        return $result;
    }

    // Lesson plan per student
    public function student_lesson_plan_get()
    {
        $class_id = $this->input->get('class_id');
        $session_id = $this->input->get('session_id');
        $semester_id = $this->input->get('semester_id');
        $student_id = $this->input->get('student_id');
        $user_id = $this->input->get('user_id');

        if (empty($class_id) || empty($student_id) || empty($semester_id) || empty($session_id) || empty($user_id)) {
            $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            return;
        }

        // Check if semester lesson plan is updated
        $std_count = $this->operation->GetByQuery("SELECT COUNT(id) as count FROM ". TABLE_STUDENT_LESSON_PLAN_SETTINGS ." WHERE student_id = " . $student_id);

        if (count($std_count) && $std_count[0]->count > 0) {

            $this->operation->table_name = TABLE_STUDENT_LESSON_PLAN_SETTINGS;
            $std_plan_settings = $this->operation->GetByWhere(array(
                'student_id' => $student_id,
                'lesson_plan_updated' => 1
            ));
            if (count($std_plan_settings)) {
                // Semester lessons were udpated for these subjects
                foreach ($std_plan_settings as $std_plan_setting) {
                    if ($this->sync_student_lessons($student_id, $std_plan_setting->subject_id, $class_id, $semester_id, $session_id)) {

                        $this->operation->table_name = TABLE_STUDENT_LESSON_PLAN_SETTINGS;
                        $this->operation->Create(array(
                            'updated' => date("Y-m-d H:i"),
                            'lesson_plan_updated' => 0,
                            'user_id' => $user_id
                        ), $std_plan_setting->id);
                    }
                }
            }

        }else{

            // Student is added after plan was updated.
            $class_subjects = $this->operation->GetByQuery("SELECT s.* FROM subjects s INNER JOIN classes c ON c.id = s.class_id WHERE s.active = 1 AND s.class_id = " . $class_id . " ORDER BY s.subject_name ASC");
            if (count($class_subjects)) {
                foreach ($class_subjects as $subject) {
                    if ($this->sync_student_lessons($student_id, $subject->id, $class_id, $semester_id, $session_id)) {

                        $this->operation->table_name = TABLE_STUDENT_LESSON_PLAN_SETTINGS;
                        $this->operation->Create(array(
                            'created' => date("Y-m-d H:i"),
                            'updated' => date("Y-m-d H:i"),
                            'student_id' => $student_id,
                            'subject_id' => $subject->id,
                            'lesson_plan_updated' => 0,
                            'user_id' => $user_id
                        ));
                    }
                }
            }
            
        }

        //$semester_lessons = $this->operation->GetByQuery("SELECT slp.*, lp.count as read_count, lp.last_updated as count_updated FROM " . TABLE_STUDENT_LESSON_PLAN . " slp LEFT JOIN lesson_progress lp ON lp.unique_code = slp.lesson_code WHERE slp.active=1 AND slp.class_id=" . $class_id . " and slp.student_id =" . $student_id . " and slp.semester_id =" . $semester_id . " AND slp.session_id =" . $session_id . " ORDER BY slp.preference ASC");

        $semester_lessons = $this->operation->GetByQuery("SELECT slp.*, lp.finish_count, lp.last_updated, lp.started, lp.finished, lp.score, lp.total_score, lp.last_opened FROM " . TABLE_STUDENT_LESSON_PLAN . " slp LEFT JOIN lesson_progress lp ON lp.unique_code = slp.lesson_code AND lp.student_id = slp.student_id WHERE slp.active=1 AND slp.class_id=" . $class_id . " and slp.student_id =" . $student_id . " and slp.semester_id =" . $semester_id . " AND slp.session_id =" . $session_id . " ORDER BY slp.preference ASC");
        
        $data = array();

        if (count($semester_lessons)) {
            foreach ($semester_lessons as $value) {
                $data[] = array(
                    'id' => $value->id,
                    'unique_code' => $value->lesson_code,
                    'set_id' => $value->set_id,
                    'subject_id' => $value->subject_id,
                    'topic' => $value->topic,
                    'content' => $value->content,
                    'concept' => $value->concept,
                    'lesson' => $value->lesson,
                    'type' => $value->type,
                    'read_count' => $value->finish_count,
                    'open_count' => $value->open_count,
                    'started' => $value->started,
                    'finished' => $value->finished,
                    'score' => $value->score,
                    'total_score' => $value->total_score,
                    'last_opened' => $value->last_opened,
                    'last_updated' => $value->last_updated,
                    'preference' => $value->preference
                );
            }
        }

        $this->set_response($data, REST_Controller::HTTP_OK);
    }


    // Lesson plan per grade/class
    public function device_lesson_plan_get()
    {
        $student_id = $this->input->get('student_id');
        $grade_slug = $this->input->get('grade_slug');
        $school_id = $this->input->get('school_id');
        $user_id = $this->input->get('user_id');

        $class_id = 0;
        $session_id = 0;
        $semester_id = 0;

        if(empty($student_id) || empty($grade_slug)){
            $data['message'] = "Required params are missing";
            $data['result'] = FALSE;
            $this->set_response($data, REST_Controller::HTTP_OK);
            return;
        }


        if(!isset($school_id) || empty($school_id)){
            $school_id = 1; // Set default school Id
        }

        $class_array = parent::get_default_classes();
        foreach ($class_array as $class_info) {
            if($class_info['slug'] == $grade_slug){
                $class_id = $class_info['id'];
                break;
            }
        } 

        if($class_id == 0){
            $data['message'] = "Invalid grade slug.";
            $data['loggedin'] = FALSE;
            $this->set_response($data, REST_Controller::HTTP_OK);
            return;
        }

        $ss = $this->operation->GetByQuery('SELECT * FROM `student_semesters` WHERE student_id = ' . $student_id  . "  AND status = 'r'");
        
        if(count($ss)){
            $semester_id = $ss[0]->semester_id;
            $session_id = $ss[0]->session_id;
        }

        if(empty($user_id)){
            $user_id = $student_id;
        }

        if (empty($class_id) || empty($student_id) || empty($semester_id) || empty($session_id) || empty($user_id)) {
            $data['message'] = "Student details were not found";
            $data['result'] = FALSE;
            $this->response($data, REST_Controller::HTTP_NOT_ACCEPTABLE);
            return;
        }

        $semester_lessons = $this->operation->GetByQuery("SELECT slp.*, lp.finish_count, lp.last_updated, lp.started, lp.finished, lp.score, lp.total_score, lp.last_opened FROM " . TABLE_SEMESTER_LESSON_PLAN . " slp LEFT JOIN lesson_progress lp ON lp.unique_code = slp.unique_code"  . " AND lp.student_id =" . $student_id . " WHERE slp.active=1 AND slp.class_id=" . $class_id . " AND slp.semester_id =" . $semester_id . " AND slp.session_id =" . $session_id . " ORDER BY slp.preference ASC");

        $data = array();

        if (count($semester_lessons)) {
            foreach ($semester_lessons as $value) {
                $data[] = array(
                    'id' => $value->id,
                    'unique_code' => $value->unique_code,
                    'set_id' => $value->set_id,
                    'subject_id' => $value->subject_id,
                    'topic' => $value->topic,
                    'content' => $value->content,
                    'concept' => $value->concept,
                    'lesson' => $value->lesson,
                    'type' => $value->type,
                    'read_count' => $value->finish_count,
                    'open_count' => $value->open_count,
                    'started' => $value->started,
                    'finished' => $value->finished,
                    'score' => $value->score,
                    'total_score' => $value->total_score,
                    'last_opened' => $value->last_opened,
                    'last_updated' => $value->last_updated,
                    'preference' => $value->preference
                );
            }
        }

        $this->set_response($data, REST_Controller::HTTP_OK);
    }

    public function export_student_lesson_plan_get()
    {
        $class_id = $this->input->get('class_id');
        $student_id = $this->input->get('student_id');
        $subject_id = $this->input->get('subject_id');
        $semester_id = $this->input->get('semester_id');
        $session_id = $this->input->get('session_id');

        if (empty($student_id) || empty($class_id) || empty($semester_id) || empty($session_id)) {

            $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            exit();
        }

        ob_end_clean();
        ob_start();
        if (empty($subject_id)) {
            $single = $this->operation->GetByQuery("SELECT slp.*, sub.subject_name FROM " . TABLE_STUDENT_LESSON_PLAN . " slp INNER JOIN subjects sub ON sub.id=slp.subject_id WHERE slp.active=1 AND slp.class_id=" . $class_id . " AND slp.semester_id =" . $semester_id . " AND slp.session_id =" . $session_id . " AND slp.student_id =" . $student_id . " ORDER BY slp.preference ASC");
        } else {
            $single = $this->operation->GetByQuery("SELECT slp.*, sub.subject_name FROM " . TABLE_STUDENT_LESSON_PLAN . " slp INNER JOIN subjects sub ON sub.id=slp.subject_id WHERE slp.active=1 AND slp.class_id=" . $class_id . " AND slp.semester_id =" . $semester_id . " AND slp.session_id =" . $session_id . " AND slp.student_id =" . $student_id . " AND slp.subject_id =" . $subject_id . " ORDER BY slp.preference ASC");
        }

        $user = $this->operation->GetByQuery("SELECT user_name FROM " . TABLE_INVANTAGE_USERS . " WHERE id=" . $student_id);
        $class = $this->operation->GetByQuery("SELECT name FROM classes WHERE id=" . $class_id);

        if (! empty($subject_id)) {
            $subject = $this->operation->GetByQuery("SELECT subject_name FROM subjects WHERE id=" . $subject_id);
        }

        require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel.php');

        require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        $objectPHPExcel = new PHPExcel();

        $objectPHPExcel->getProperties()->setCreator("");
        $objectPHPExcel->getProperties()->setLastModifiedBy("");
        $objectPHPExcel->getProperties()->setTitle("");
        $objectPHPExcel->getProperties()->setSubject("");
        $objectPHPExcel->getProperties()->setDescription("");

        $objectPHPExcel->setActiveSheetIndex(0);

        $objectPHPExcel->getActiveSheet()->SetCellValue('A1', $user[0]->user_name);
        $objectPHPExcel->getActiveSheet()->SetCellValue('B1', $class[0]->name);

        if (count($subject)) {
            $objectPHPExcel->getActiveSheet()->SetCellValue('C1', $subject[0]->subject_name);
        }

        $objectPHPExcel->getActiveSheet()->SetCellValue('D1', "Lesson Pan");

        $objectPHPExcel->getActiveSheet()->SetCellValue('A2', 'Set Id');
        $objectPHPExcel->getActiveSheet()->SetCellValue('B2', 'Subject');
        $objectPHPExcel->getActiveSheet()->SetCellValue('B2', 'Concept');
        $objectPHPExcel->getActiveSheet()->SetCellValue('C2', 'Topic');
        $objectPHPExcel->getActiveSheet()->SetCellValue('D2', 'Lesson');
        $objectPHPExcel->getActiveSheet()->SetCellValue('E2', 'Type');
        $objectPHPExcel->getActiveSheet()->SetCellValue('F2', 'Content');
        $rows = 3;
        foreach ($single as $value) {
            $objectPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $value->set_id);
            $objectPHPExcel->getActiveSheet()->SetCellValue('A' . $rows, $value->subject_name);
            $objectPHPExcel->getActiveSheet()->SetCellValue('B' . $rows, $value->concept);
            $objectPHPExcel->getActiveSheet()->SetCellValue('C' . $rows, $value->topic);
            $objectPHPExcel->getActiveSheet()->SetCellValue('D' . $rows, $value->lesson);
            $objectPHPExcel->getActiveSheet()->SetCellValue('E' . $rows, $value->type);
            $objectPHPExcel->getActiveSheet()->SetCellValue('F' . $rows, $value->content);
            $rows ++;
        }

        $filename = 'Student Lesson Plan - ' . $user[0]->user_name . '.csv';
        $objectPHPExcel->getActiveSheet()->setTitle("Project Overview");
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
            'student_id' => $student_id,
            'user_name' => $user[0]->user_name,
            'class_name' => $class[0]->name,
            'date' => date('M-d-Y'),
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );

        if (count($subject)) {
            $response[subject_name] = $subject[0]->subject_name;
        }

        $this->response($response, REST_Controller::HTTP_OK);
        exit();
    }

    public function student_lesson_plan_delete()
    {
        $class_id = $this->input->get('class_id');
        $session_id = $this->input->get('session_id');
        $semester_id = $this->input->get('semester_id');
        $subject_id = $this->input->get('subject_id');

        if (empty($subject_id) || empty($class_id) || empty($semester_id) || empty($session_id)) {

            $this->response([], REST_Controller::HTTP_NOT_ACCEPTABLE);
            exit();
        }

        $result = $this->db->query("UPDATE semester_lesson_plan SET active=0 WHERE class_id=" . $class_id . " AND subject_id=" . $subject_id . " AND semester_id =" . $semester_id . " AND session_id =" . $session_id);

        $this->set_response($result, REST_Controller::HTTP_OK);
    }

    // endregion student lesson plan

    /**
     * Student progress for principal and teacher in SHAMA-Central
     *
     * This function is used for student progress
     *
     * This function return custom response type to user
     * 
     * Type number => Description
     * 0 => means no code executed validation valid on inputs
     * 1 => no student found
     * 2 => no lessons dates found
     * 
     * @version    V1
     * @since      This function available v1
     */ 

    function Get_Grade_Lesson_Plan_Progress_get()
    {
        try {
            $lesson = array();
            $table_header = array(); // set name
            $student_list = array(); // student array
            $student_lesson_progress = array(); // progress of each set by student
            if($this->get('classId') && $this->get('sectionId') && $this->get('semesterId')  && $this->get('sessionId') )
            {
                $class_id = $this->get('classId');
                $session_id = $this->get('sessionId');
                $semester_id = $this->get('semesterId');
                
                // if any student found in school 
                $anyStudentFound = $this->operation->GetByQuery("SELECT * FROM student_semesters WHERE status='r' AND session_id=" . $session_id . " and semester_id =" . $semester_id . "  ORDER BY student_id ASC");
                if( count( $anyStudentFound ) )
                {
                    // find any lessons set available
                    $anyLessonDateFound = $this->operation->GetByQuery("SELECT DISTINCT set_id FROM semester_lesson_plan WHERE active=1 AND session_id=" . $session_id . " and semester_id =" . $semester_id . " AND class_id = ".$class_id."  ORDER BY preference ASC");
                    if( count($anyLessonDateFound) )
                    {
                        $setCount = 0;
                        foreach ($anyLessonDateFound as $key => $ls) {
                            $setCount ++;
                            $lesson_string = "";
                            $anyLessonFoundInSet = $this->operation->GetByQuery("SELECT topic FROM semester_lesson_plan WHERE active=1 AND set_id = ".$ls->set_id." AND session_id=" . $session_id . " and semester_id =" . $semester_id . " AND class_id = ".$class_id." AND content != ''  ORDER BY preference ASC");
                            if( Count($anyLessonFoundInSet))
                            {
                                foreach ($anyLessonFoundInSet as $key => $topicValue) {

                                    if(!empty($lesson_string)){
                                        $lesson_string .= ", ";
                                    }
                                    $lesson_string .= $topicValue->topic;
                                }
                            }
                            
                            $table_header[] =  array(
                                'set_name'=>"Set #". $setCount,
                                'lessons'=>$lesson_string
                            );
                            
                            
                            foreach ($anyStudentFound as $key => $studentArray) {
                                /*
                                $setAnyLessonFound = $this->operation->GetByQuery("SELECT id,lesson_code FROM student_lesson_plan WHERE active=1 AND set_id = ".$ls->set_id." AND student_id=" . $studentArray->student_id." AND session_id=" . $session_id . " and semester_id =" . $semester_id . " AND class_id = ".$class_id." AND content != ''  ORDER BY preference ASC");
                                */

                                $setAnyLessonFound = $this->operation->GetByQuery("SELECT id,unique_code FROM semester_lesson_plan WHERE active=1 AND set_id = ".$ls->set_id . " AND session_id=" . $session_id . " AND semester_id =" . $semester_id . " AND class_id = ".$class_id." AND content != ''  ORDER BY preference ASC");

                                $setProgress = false;

                                if( count( $setAnyLessonFound ) )
                                {
                                    $setProgress = $this->Has_Student_Read_Whole_Lesson_Set($setAnyLessonFound , $studentArray->student_id);
                                }
                                
                                $student_lesson_progress[$studentArray->student_id][] = array('status'=>$setProgress);
                            }
                            
                        }
                        
                        foreach ($anyStudentFound as $key => $studentArray) {
                            $student_list[] = array(
                                "roll_number"=> parent::get_user_meta($studentArray->student_id,'roll_number'),
                                "first_name"=> parent::get_user_meta($studentArray->student_id,'sfullname'),
                                "last_name"=> parent::get_user_meta($studentArray->student_id,'slastname'),
                                "student_id"=> $studentArray->student_id,
                                "student_lesson_progress"=>$student_lesson_progress[$studentArray->student_id]
                            );
                        }

                    }
                     else{
                        $this->set_response(array('lessons'=>$lesson,'status'=>true,'custom_code'=>2), REST_Controller::HTTP_OK);
                    }
                }
                else{
                    $this->set_response(array('lessons'=>$lesson,'table_header'=>$table_header,'student_list'=>$student_list,'status'=>true,'custom_code'=>1), REST_Controller::HTTP_OK);
                }
                
                $this->set_response(array('lessons'=>$lesson,'table_header'=>$table_header,'student_list'=>$student_list,'status'=>false,'custom_code'=>0), REST_Controller::HTTP_OK);
            }
            else{
                $this->set_response(array('lessons'=>$lesson,'table_header'=>$table_header,'student_list'=>$student_list,'status'=>false,'custom_code'=>0), REST_Controller::HTTP_OK);
            }
        } catch (\Throwable $th) {
            //throw $th;
            print_r($th);
            $this->set_response(array('lessons'=>[],'status'=>false), REST_Controller::HTTP_OK);
        }
    }

    /**
     * This function will tell the student has read whole lesson set or not
     *
     * This is utility function
     *
     * This function return bool response
     * 
     * @version    V1
     * @since      This function available v1
     */ 
    function Has_Student_Read_Whole_Lesson_Set($lessonSet , $studentId)
    {
        $setProgress = true;
        if( count( $lessonSet ) )
        {
            foreach ($lessonSet as $key => $lesson) {

                // $isLessonReadByStudent = $this->operation->GetByQuery("SELECT * FROM lesson_progress WHERE student_id=" . $studentId." AND unique_code = '".$lesson->lesson_code."'");
                
                $isLessonReadByStudent = $this->operation->GetByQuery("SELECT * FROM lesson_progress WHERE student_id=" . $studentId." AND unique_code = '".$lesson->unique_code."'");

                if( count($isLessonReadByStudent) == 0 || $isLessonReadByStudent[0]->finish_count<=0)
                {
                    $setProgress = false;
                }
            }
        }
        else{
            $setProgress = false;
        }

        return $setProgress;
    }
}

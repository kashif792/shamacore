<?php

class Reports extends MY_Controller
{

    /**
     * @var array
     */
    var $data = array();
    private $school_id = null;
    private $usercity = null;
    private $campus = null;
    private $semester_date_id  = null;

    function __construct(){
        parent::__construct();        
    }

    /**
     * Class report
     */
    public function ClassReportView()
    {
        $this->load->view("reports/class_report",$this->data);
    }

    /**
     * Class report table
     */
    function ClassReportData()
    {
        $request = json_decode( file_get_contents('php://input'));
        $inputclassid = $this->security->xss_clean(trim($request->inputclassid));
        $inputsectionid = $this->security->xss_clean(trim($request->inputsectionid));
        $inputsemesterid = $this->security->xss_clean(trim($request->inputsemesterid));
        $inputsessionid = $this->security->xss_clean(trim($request->inputsessionid));
      
        $error_array = array();
        if (!is_int((int) $inputclassid) || !is_int((int) $inputsectionid) || !is_int((int) $inputsemesterid) || !is_int((int) $inputsessionid) ) {
            array_push($error_array,"Date is empty");
        }
             
        if(count($error_array))
        {
            echo json_encode($error_array);
            exit();
        }

        $result = array();
        if(count($error_array) == false)
        {

            $student = array();
           
                $progress = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` where classid = '.$inputclassid." AND sectionid = ".$inputsectionid." AND semesterid = ".$inputsemesterid." AND sessionid = ".$inputsessionid."  AND status = 'r'");                

            if(count($progress))
            {
                $subjectlist = parent::GetSubjectsByClass($inputclassid,$inputsemesterid);
                foreach ($progress as $key => $value) {
                    $this->operation->table_name = 'evaluation';

                    $is_eva_found = $this->operation->GetByWhere(array('status'=>'a','semester_date_id'=>$this->semester_date_id));
                    $evalution_array = array();
                    
                    $quiz_array = $this->CalculateStudentQuizMarks($value->studentid,$inputclassid,$inputsectionid,$inputsemesterid,$inputsessionid);
                    
                    $mid_array = $this->CalculateStudentTermMarks($value->studentid,$inputclassid,$inputsectionid,$inputsemesterid,$inputsessionid,1);
                    
                    $final_array = $this->CalculateStudentTermMarks($value->studentid,$inputclassid,$inputsectionid,$inputsemesterid,$inputsessionid,2);
                    
                    $total_marks = $quiz_array[0] + $mid_array[0] + $final_array[0];
                    $obtain_marks = $quiz_array[1] + $mid_array[1] + $final_array[1];
                    

                    $evalution_array[] = array(
                        'quiz'=>$quiz_array[0],
                        'mid'=>$mid_array[0],
                        'final'=>$final_array[0],
                        'assignment'=>0,
                        'practical'=>0,
                        'attendance'=>0,
                        'oral'=>0,
                        'behavior'=>0,
                        'total_percent'=>(float)(($total_marks/100)*100),
                        'grade'=>parent::GetGrade((float)(($total_marks/100)*100),$inputsessionid),
                        'obtain_marks'=>$obtain_marks,
                        'total_marks'=>count($subjectlist)*100,
                    );    
                    $result[] = array(
                        'studentid'=>$value->studentid,
                        'screenname'=>parent::getUserMeta($value->studentid,'sfullname'),
                        'evalution'=>$evalution_array
                    );

                }
            }
        }
        echo json_encode($result);
    }

    
    /**
     * Calculate student quiz marks
     *
     * @param studentid  int
     * @param classid    int
     * @param sectionid  int
     * @param semesterid int
     * @param sessionid  int
     * 
     */    
    function CalculateStudentQuizMarks($studentid,$classid,$sectionid,$semesterid,$sessionid)
    {
        $subjectlist = parent::GetSubjectsByClass($classid,$semesterid);
        $student_quiz = array();
        if(count($subjectlist))
        {   
            $sum_subject = array();
            foreach ($subjectlist as $key => $value) {
                $quizlist = $this->operation->GetRowsByQyery('SELECT q.id,q.quiz_term FROM `quize` q where subjectid ='.$value->id.' AND classid = '.$classid.' and sectionid = '.$sectionid.' AND semesterid = '.$semesterid.' AND sessionid = '.$sessionid.'  order by quiz_term');
                if(count($quizlist)):
                    $find_quiz_marks = array();
                    foreach ($quizlist as $key => $qvalue) {
                        array_push($find_quiz_marks,(int) $this->CalculateSubjectWizeStudentQuiz((int) $studentid, (int) $qvalue->id));
                    }
                    $quiz_evaluation_points = parent::GetEvaluationByType('qui',$sessionid);

                    array_push($sum_subject,(((array_sum($find_quiz_marks)/100)*$quiz_evaluation_points))); 
                endif;  
            }
           
            $student_quiz[0] = (array_sum($sum_subject)/count($subjectlist));
            $student_quiz[1] = (array_sum($sum_subject));
        }
        return $student_quiz;
    }

    /**
     * Calculate subject wise quiz marks 
     *
     * @param studentid  int
     * @param quizid    int
     * 
     */    
    function CalculateSubjectWizeStudentQuiz($studentid,$quizid)
    {
        $quizdetailarray = 0;

        if(is_int($studentid) && is_int($quizid))
        {
            
            $questionlist = $this->operation->GetRowsByQyery('SELECT qz.quizid,qz.questionid as quesid,qo.qoption_id  FROM quiz_evaluation qz INNER JOIN quizeoptions qo ON qo.qoption_id = qz.optionid Where qz.studentid ='.$studentid." AND qz.quizid=".$quizid);
           
            if(count($questionlist))
            {
                $total_count= 0;
                foreach ($questionlist as $key => $value) {

                    $is_correct_answer_matched = $this->operation->GetRowsByQyery('SELECT * FROM correct_option  Where question_id ='.$value->quesid);
              
                    if($is_correct_answer_matched[0]->correct_id == $value->qoption_id)
                    {
                        $total_count++;
                    }
                }
                $quizdetailarray = (($total_count/count($questionlist))* 100);
            }else{
                $quizdetailarray = 0;
            }
        }
        
        return $quizdetailarray;
    }


    /**
     * Calculate student term marks
     *
     * @param studentid  int
     * @param classid    int
     * @param sectionid  int
     * @param semesterid int
     * @param sessionid  int
     * @param termid  int
     * 
     */
    function CalculateStudentTermMarks($studentid,$classid,$sectionid,$semesterid,$sessionid,$termid)
    {
        $student_result = array();
        $subjectlist = parent::GetSubjectsByClass($classid,$semesterid);
        if(count($subjectlist))
        {   
            $subject_result = array();
            foreach ($subjectlist as $key => $value) {
                if(is_int($semesterid))
                {
                    $termlist = $this->operation->GetRowsByQyery('SELECT * FROM temr_exam_result  where classid = '.$classid.' AND sectionid = '.$sectionid.' AND semesterid = '.$semesterid.' AND sessionid = '.$sessionid.' AND subjectid = '.$value->id.' AND studentid= '.$studentid." order by termid asc");
                }
                else{
                    $termlist = $this->operation->GetRowsByQyery('SELECT * FROM temr_exam_result  where classid = '.$classid.' AND sectionid = '.$sectionid.' AND sessionid = '.$sessionid.' AND subjectid = '.$value->id.' AND studentid= '.$studentid." order by termid asc");
                }
                
                if(count($termlist))
                {
                    foreach ($termlist as $key => $tvalue) {
                        if($tvalue->termid == $termid)
                        {
                            array_push($subject_result,$tvalue->marks);
                        }
                    }
                }
            }
           $student_result[0] = (array_sum($subject_result)/ count($subjectlist));
           $student_result[1] = (array_sum($subject_result));
        }
       
        return  $student_result;
    }

    /**
     * Calculate student wise report by subject
     *
     * @param classid    int
     * @param sectionid  int
     * @param semesterid int
     * @param sessionid  int
     * @param studentid  int
     * 
     */
    function StudentReportBySubjectwize()
    {
        $request = json_decode( file_get_contents('php://input'));
        $inputclassid = $this->security->xss_clean(trim($request->inputclassid));
        $inputsectionid = $this->security->xss_clean(trim($request->inputsectionid));
        $inputsemesterid = $this->security->xss_clean(trim($request->inputsemesterid));
        $inputsessionid = $this->security->xss_clean(trim($request->inputsessionid));
        $studentid = $this->security->xss_clean(trim($request->student));
      
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
            
             $subjectlist = parent::GetSubjectsByClass($inputclassid,$inputsemesterid);
             
             
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
            
                    foreach ($subjectlist as $key => $value) {
                        $sum_subject = array();
                        $student_quiz = array();
                        
                        $quizlist = $this->operation->GetRowsByQyery('SELECT q.id,q.quiz_term FROM `quize` q where subjectid ='.$value->id.' AND classid = '.$inputclassid.' and sectionid = '.$inputsectionid.' AND semesterid = '.$inputsemesterid.' AND sessionid = '.$inputsessionid.'  order by quiz_term');       
                        
                        if(count($quizlist)):
                            $find_quiz_marks = array();
                            foreach ($quizlist as $key => $qvalue) {
                                array_push($find_quiz_marks,(int) $this->CalculateSubjectWizeStudentQuiz((int) $studentid, (int) $qvalue->id));
                            }
                            $quiz_evaluation_points = parent::GetEvaluationByType('qui',$sessionid);

                            array_push($sum_subject,(((array_sum($find_quiz_marks)/100)*$quiz_evaluation_points))); 
                        endif;

                        $student_quiz[0] = (array_sum($sum_subject)/count($subjectlist));
                        $student_quiz[1] = (array_sum($sum_subject)); 

                      
                        $evalution_array = array();
    
                        
                        $mid = $this->operation->GetRowsByQyery('SELECT * FROM temr_exam_result  where subjectid = '.$value->id.' AND studentid= '.$studentid." AND termid = 1");
                        $final = $this->operation->GetRowsByQyery('SELECT * FROM temr_exam_result  where subjectid = '.$value->id.' AND studentid= '.$studentid." AND termid = 2");

                        $total_marks = $student_quiz[0] + $mid[0]->marks + $final[0]->marks;
                        $obtain_marks = $student_quiz[1] + $mid[0]->marks + $final[0]->marks;
                        $student_obtain_marks += $total_marks;
                        
                        $evalution_array[] = array(
                            'quiz'=>$student_quiz[0],
                            'mid'=>(count($mid) ? $mid[0]->marks : 0),
                            'final'=>(count($final) ? $final[0]->marks : 0),
                            'assignment'=>0,
                            'practical'=>0,
                            'attendance'=>0,
                            'oral'=>0,
                            'behavior'=>0,
                            'total_percent'=>(double)(($total_marks/100)*100),
                            'grade'=>parent::GetGrade((double)(($total_marks/100)*100),$inputsessionid),
                            'obtain_marks'=>$obtain_marks,
                            'total_marks'=>count($subjectlist)*100,
                        );    
                        $result[] = array(
                            'serail'=>$value->id,
                            'subject'=>$value->subject_name,
                            'evalution'=>$evalution_array,
                          
                        );
                    }  
                    $studentresult[] = array(
                        'result'=>$result,
                        'semester'=>$semester_name,
                        'obtain_marks'=> round($student_obtain_marks,2),
                        'total_marks'=>round(((count($subjectlist)*100)*($i+1)),2),
                        'percent'=>round((float)(($student_obtain_marks/((count($subjectlist)*100)))*100),2),
                        'grade'=>parent::GetGrade((float)(($student_obtain_marks/((count($subjectlist)*100)))*100),$inputsessionid),
                    ); 
                }
            }
        }
        echo json_encode($studentresult);
    }
    
    /**
     * Student report
     */
    public function StudentReport()
    {
        $this->data['logo'] = parent::ImageConvertorToBase64(base_url()."images/small_nrlogo.png");
        
        $this->load->view("reports/student_report",$this->data);
    }

    /**
     * Student image
     *
     * @param studentid
     *
     * @return string
     */
    function GetStudentImageByBase64()
    {
        $request = json_decode( file_get_contents('php://input'));
     
        $studentid = $this->security->xss_clean(trim($request->student->id));
        $error_array = array();
        if (!is_int((int) $studentid) ) {
            array_push($error_array,"Invalid data");
        }
             
        if(count($error_array))
        {
            echo json_encode($error_array);
            exit();
        }

        if(count($error_array) == false)
        {
            $result['image'] = parent::ImageConvertorToBase64($request->student->profile_image);
            if($result['image']){
                $result['message'] = true;
            }
            
        }
        echo json_encode($result);
    }

    /**
     * Student report
     *
     * @param locationid
     * @param sessionid
     * @param gradeid
     * @param sectionid
     * @param semesterid
     *
     * @return array json
     */
    function StudentReportData()
    {   
        $request = json_decode( file_get_contents('php://input'));
        $serail = $this->security->xss_clean(trim($request->student));
        $inputclassid = $this->security->xss_clean(trim($request->inputclassid));
        $inputsectionid = $this->security->xss_clean(trim($request->inputsectionid));
        $inputsemesterid = $this->security->xss_clean(trim($request->inputsemesterid));
        $inputsessionid = $this->security->xss_clean(trim($request->inputsessionid));
      
        $error_array = array();
        if (count($serail) == false) {
            array_push($error_array,"Type must be 3 character");
        }
             
        if(count($error_array))
        {
            echo json_encode($error_array);
            exit();
        }
        $subjects = array();
        if(count($error_array) == false)
        {
            /**
             *  Get subjects list by checking first in schedule table and then check in subjects  
             */
            $this->operation->table_name = 'schedule';

            $resultlist = $this->operation->GetByWhere(array(
                'class_id'=>$inputclassid,
                'section_id'=>$inputsectionid,
                'semesterid'=>$inputsemesterid,
                'sessionid'=>$inputsessionid
            ));
            $max_quiz = $this->FindMaxQuiz($inputclassid,$inputsectionid,$inputsessionid);
            $max_quiz =  max($max_quiz);
            $max_quiz =  (int) $max_quiz->maximumquizes;
            
            if(count($resultlist))
            {
                foreach ($resultlist as $key => $value) {
                    $subject_name = parent::GetSubject($value->subject_id);
                    $quiz_array = array();
                    $quiz_list = $this->GetSubjectQuizList($inputclassid,$inputsectionid,$inputsemesterid,$inputsessionid,$value->subject_id);
                    if(count($quiz_list))
                    {
                        foreach ($quiz_list as $key => $value) {
                            $quiz_array[] = array(
                                'avg'=> 0
                            );
                        }

                        while (count($quiz_array) <= $max_quiz -1 ) {
                            $quiz_array[] = array(
                                'avg'=> 0
                            );
                        }
                    }else{
                        while (count($quiz_array) <= $max_quiz -1 ) {
                            $quiz_array[] = array(
                                'avg'=> 0
                            );
                        }
                    }

                    $subjects[] = array(
                        'subject'=>$subject_name[0]->subject_name." (".$subject_name[0]->subject_code.")",
                        'quiz'=>$quiz_array,
                        'max_quiz'=>$max_quiz,
                        'mid_term'=>0,
                        'final_term'=>0,
                        'final'=>0
                    );
                }
            }

        }
        echo json_encode($subjects);    
    } 

    /**
     * Find maximum number of quiz in semester
     */
    function FindMaxQuiz($classid,$sectionid,$sessionid)
    {
        $this->operation->table_name = 'schedule';
        return $this->operation->GetRowsByQyery("SELECT count(subjectid) as maximumquizes FROM quize WHERE classid = ".$classid." AND sectionid = ".$sectionid." AND sessionid = ".$sessionid." GROUP BY subjectid");
    }


    /**
     * Find quiz list
     */
    function GetSubjectQuizList($classid,$sectionid,$semesterid,$sessionid,$subjectid)
    {
        $this->operation->table_name = 'quize';
        return $this->operation->GetByWhere(array(
            'classid'=>$classid,
            'sectionid'=>$sectionid,
            'semesterid'=>$semesterid,
            'sessionid'=>$sessionid,
            'subjectid'=>$subjectid
        ));
    }

    /**
     * Find single quiz avg of specific subject
     */
    function GetSubjectSpecificAvg()
    {}

    /**
     * Get subject list of progress report in principal side
     */
    function GetSubjectListForProgressReport()
    {
        $request = json_decode( file_get_contents('php://input'));
        $inputclassid = $this->security->xss_clean(trim($request->inputclassid));
        $inputsectionid = $this->security->xss_clean(trim($request->inputsectionid));
        $inputsemesterid = $this->security->xss_clean(trim($request->inputsemesterid));
        $inputsessionid = $this->security->xss_clean(trim($request->inputsessionid));

        $this->operation->table_name = 'schedule';

        $resultlist = $this->operation->GetByWhere(array(
            'class_id'=>$inputclassid,
            'section_id'=>$inputsectionid,
            'semesterid'=>$inputsemesterid,
            'sessionid'=>$inputsessionid
        ));

     
        $result = array();

        if(count($resultlist))
        {
            foreach ($resultlist as $key => $value) {
                $subject_name = parent::GetSubject($value->subject_id);
                $result[] = array(
                    'sbid'=>$value->subject_id,
                    'subject_name'=>$subject_name[0]->subject_name,
                    'first_subject'=>($key  == 0 ? 'in':'')
                );
            }
        }
        echo json_encode($result);
    }

    /**
     * Save grades
     */
    function SaveGrades()
    {
        $request = json_decode( file_get_contents('php://input'));
        $serail = $this->security->xss_clean(trim($request->id));
        $title = $this->security->xss_clean(trim($request->title));
        $lower_limit = $this->security->xss_clean(trim($request->lower_limit));
        $upper_limit = $this->security->xss_clean(trim($request->upper_limit));
        
        $error_array = array();
        if (strlen($title) < 0) {
            array_push($error_array,"Type must be 3 character");
        }
             
        if(count($error_array))
        {
            echo json_encode($error_array);
            exit();
        }
        $result['message'] = false;
         $this->operation->table_name = 'semester_dates';
         $locations = $this->session->userdata('locations');
        $resultlist = $this->operation->GetByWhere(array(
            'school_id'=>$locations[0]['school_id'],
            'status'=>'a'
        ));

        $this->operation->table_name = 'grades';
        if(count($error_array) == false && count($resultlist))
        {
           
            $grade_row = $this->operation->GetByWhere(array(
                'semester_date_id'=>$resultlist[0]->id,
                'status'=>'a'
            ));
            if(count($grade_row))
            {
                if(!empty($serail))
                {
                    $resultlist = unserialize($grade_row[0]->option_value);
                    foreach ($resultlist as $key => $value) {
                        if((int) $resultlist[$key]['id'] == (int) $serail){
                            $resultlist[$key]['title'] = $title;
                            $resultlist[$key]['lower_limit'] = (int) $lower_limit;
                            $resultlist[$key]['upper_limit'] = (int) $upper_limit ;
                        }
                    }
                    
                    $grades = array(
                        'option_value'=>serialize($resultlist),
                    );
                    $id = $this->operation->Create($grades,$grade_row[0]->id);
                    if(count($id))
                    {
                        $result['message'] = true;
                    }
                }
                else{
                    $resultlist = unserialize($grade_row[0]->option_value);
                
                    $temp = array(
                        'id'=>count($resultlist)+1,
                        'title'=>$title,
                        'lower_limit'=>(int)$lower_limit,
                        'upper_limit'=>(int)$upper_limit
                    );
                    array_push($resultlist,$temp);
                    $grades = array(
                        'option_value'=>serialize($resultlist),
                    );
                    $id = $this->operation->Create($grades,$grade_row[0]->id);
                    if(count($id))
                    {
                        $result['message'] = true;
                    }
                }
            }
            else{
                $grades = array(
                    'semester_date_id'=>$resultlist[0]->id,
                    'status'=>'i',
                    'option_value'=>serialize(parent::DefaultGradesList()),
                );
                $id = $this->operation->Create($grades);
                if(count($id))
                    {
                        $result['message'] = true;
                    }
            }
        }
        echo json_encode($result);
    }

    function RemoveGrade()
    {
        try{
             $request = json_decode( file_get_contents('php://input'));
            $serail = $this->security->xss_clean(trim($request->id));
        
            $error_array = array();
            if (strlen($serail) < 0) {
                array_push($error_array,"Type must be 3 character");
            }
             
            if(count($error_array))
            {
                echo json_encode($error_array);
                exit();
            }
            $result['message'] = false;
            $this->operation->table_name = 'semester_dates';
            $locations = $this->session->userdata('locations');
            $resultlist = $this->operation->GetByWhere(array(
                'school_id'=>$locations[0]['school_id'],
                'status'=>'a'
            ));

            $this->operation->table_name = 'grades';
            if(count($error_array) == false && count($resultlist))
            {
               
                $grade_row = $this->operation->GetByWhere(array(
                    'semester_date_id'=>$resultlist[0]->id,
                    'status'=>'a'
                ));
                if(count($grade_row))
                {
                    if(!empty($serail))
                    {
                        $resultlist = unserialize($grade_row[0]->option_value);
                        foreach ($resultlist as $key => $value) {
                            if((int) $resultlist[$key]['id'] == (int) $serail){
                                unset($resultlist[$key]);
                            }
                        }
                        
                        $grades = array(
                            'option_value'=>serialize($resultlist),
                        );
                        $id = $this->operation->Create($grades,$grade_row[0]->id);
                        if(count($id))
                        {
                            $result['message'] = true;
                        }
                    }
                }
            }
            echo json_encode($result);
        }
        catch(Exception $e){}
    }
    /**
     * Get grade list
     */
    function GetGradeList()
    {
     
     

        	$active_session = parent::GetUserActiveSession();

		$this->operation->table_name = 'semester_dates';

            $active_semester = $this->operation->GetByWhere(array('session_id'=>$active_session[0]->id,'status'=>'a'));
            
        $this->operation->table_name = 'grades';

        $resultlist = $this->operation->GetByWhere(array('status'=>'a','semester_date_id'=>$active_semester[0]->id));
        
        $result = array();

        if(count($resultlist))
        {
            $resultlist = unserialize($resultlist[0]->option_value);
            foreach ($resultlist as $key => $value) {
                $result[] = array(
                    'id'=>$value['id'],
                    'title'=>$value['title'],
                    'lower_limit'=>$value['lower_limit'],
                    'upper_limit'=>$value['upper_limit']
                );
            }
        }
        echo json_encode($result);
    }
    
    /**
     * Class report
     */
    function ClassReport()
    {
        $request = json_decode( file_get_contents('php://input'));
        $inputclassid = $this->security->xss_clean(trim($request->inputclassid));
        $inputsectionid = $this->security->xss_clean(trim($request->inputsectionid));
        $inputsemesterid = $this->security->xss_clean(trim($request->inputsemesterid));
        $inputsessionid = $this->security->xss_clean(trim($request->inputsessionid));
        $inputsubjectid = $this->security->xss_clean(trim($request->inputsubjectid));
      
        $error_array = array();
        if (!is_int((int) $inputclassid) || !is_int((int) $inputsectionid) || !is_int((int) $inputsemesterid) 
            || !is_int((int) $inputsessionid) || !is_int((int) $inputsubjectid)) {
            array_push($error_array,"Invalid inputs");
        }
             
        if(count($error_array))
        {
            echo json_encode($error_array);
            exit();
        }

        $result = array();
        if(count($error_array) == false)
        {

            $student = array();
            $semester  =parent::GetSemesterBySession($inputsessionid,$inputsemesterid);
            if(count($semester))
            {
                $progress = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` where classid = '.$inputclassid." AND sectionid = ".$inputsectionid." AND semesterid = ".$semester[0]->semester_id." AND sessionid = ".$inputsessionid."  AND status = 'r'");
                if(count($progress))
                {
                    $subjectlist = parent::GetSubjectsByClass($inputclassid,$inputsemesterid);
                    foreach ($progress as $key => $value) {
                        $this->operation->table_name = 'evaluation';

                        $is_eva_found = $this->operation->GetByWhere(array('status'=>'a','semester_date_id'=>$this->semester_date_id));
                        $evalution_array = array();
                        
                        $quiz_array = $this->CalculateStudentQuizMarks($value->studentid,$inputclassid,$inputsectionid,$inputsemesterid,$inputsessionid);
                        
                        $mid_array = $this->CalculateStudentTermMarks($value->studentid,$inputclassid,$inputsectionid,$inputsemesterid,$inputsessionid,1);
                        
                        $final_array = $this->CalculateStudentTermMarks($value->studentid,$inputclassid,$inputsectionid,$inputsemesterid,$inputsessionid,2);
                        
                        $total_marks = $quiz_array[0] + $mid_array[0] + $final_array[0];
                        $obtain_marks = $quiz_array[1] + $mid_array[1] + $final_array[1];
                        

                        $evalution_array[] = array(
                            'quiz'=>$quiz_array[0],
                            'mid'=>$mid_array[0],
                            'final'=>$final_array[0],
                            'assignment'=>0,
                            'practical'=>0,
                            'attendance'=>0,
                            'oral'=>0,
                            'behavior'=>0,
                            'total_percent'=>(float)(($total_marks/100)*100),
                            'grade'=>parent::GetGrade((float)(($total_marks/100)*100),$inputsessionid),
                            'obtain_marks'=>$obtain_marks,
                            'total_marks'=>count($subjectlist)*100,
                        );    
                        $result[] = array(
                            'studentid'=>$value->studentid,
                            'screenname'=>parent::getUserMeta($value->studentid,'sfullname'),
                            'evalution'=>$evalution_array
                        );

                    }
                }
            }
        }
        echo json_encode($result);
    }

    function GetClassSubjectList()
    {
        try{
            $request = json_decode( file_get_contents('php://input'));
            $inputclassid = $this->security->xss_clean(trim($request->inputclassid));
            $inputsemesterid = $this->security->xss_clean(trim($request->inputsemesterid));
            $inputsessionid = $this->security->xss_clean(trim($request->inputsessionid));
            
            $error_array = array();
            if (!is_int((int) $inputclassid)  || !is_int((int) $inputsemesterid)) {
                array_push($error_array,"Invalid inputs");
            }
                 
            if(count($error_array))
            {
                echo json_encode($error_array);
                exit();
            }

            $result = array();
            if(count($error_array) == false)
            {
                $semester  =parent::GetSemesterBySession($inputsessionid,$inputsemesterid);
                if(count($semester))
                {
                    $this->operation->table_name = 'subjects';
                    $subject_list = $this->operation->GetByWhere(array(
                        'class_id'=>$inputclassid,
                        'semesterid'=>$inputsemesterid,
                        "session_id"=>$inputsessionid
                    ));

                    if(count($subject_list))
                    {
                        foreach ($subject_list as $key => $value) {
                            $result[] = array(
                                'id'=>$value->id,
                                'name'=>$value->subject_name,
                            );
                        }
                    }
                }
            }
             echo json_encode($result);
        }
        catch(Exception $e)
        {}
       
    }

    function Principal_Subject_List()
    {
        try{
            $request = json_decode( file_get_contents('php://input'));
            $inputclassid = $this->security->xss_clean(trim($request->inputclassid));
            $inputsemesterid = $this->security->xss_clean(trim($request->inputsemesterid));
            $inputsessionid = $this->security->xss_clean(trim($request->inputsessionid));
            
            $error_array = array();
            if (!is_int((int) $inputclassid)  || !is_int((int) $inputsemesterid)) {
                array_push($error_array,"Invalid inputs");
            }
                 
            if(count($error_array))
            {
                echo json_encode($error_array);
                exit();
            }

            $result = array();
            if(count($error_array) == false)
            {
                $subjectlist = parent::GetSubjectsByClass($inputclassid,(int)$inputsemesterid);
                
                if(count($subjectlist))
                {
                    foreach ($subjectlist as $key => $value) {
                        $result[] = array(
                            'sbid'=>$value->id,
                            'subject_name'=>$value->subject_name,
                            'first_subject'=>($key == 0 ? 'in': 'other')
                        );
                    }
                }
            }
            echo json_encode($result);
        }
        catch(Exception $e){}
    }
}

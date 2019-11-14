<?php
  /**
   *  Task controller
   *
   */
class TaskController extends MY_Controller {

    /**
     * @var array
     */
    var $data = array();

    function __construct(){

        parent::__construct();



        $this->load->model('User');

        $this->load->model('Operation');

        

        if(!($this->session->userdata('id')))

        {

            parent::redirectUrl('signin');

        }

    }



    function Index()

    {
        $roles = $this->session->userdata('roles');
        $locations = $this->session->userdata('locations');

        if( $roles[0]['role_id'] == 3) {

            $classlist = $this->operation->GetRowsByQyery("SELECT  * FROM classes c where school_id =".$locations[0]['school_id']);

        }else if ($roles[0]['role_id'] == 4 OR $this->session->userdata('is_master_teacher') == '1') {

            $classlist = $this->operation->GetRowsByQyery("SELECT c.id as classid,c.grade FROM schedule sch 
                INNER JOIN classes c ON c.id = sch.class_id  
                WHERE sch.teacher_uid = ".$this->session->userdata('id')." GROUP by c.id ORDER by c.id asc");
        }

        $this->data['classlist'] = $classlist;
        $this->load->view('task/task_list',$this->data);
    }


    /**
    *   Add/Update a task
    *
    */
    public function add_task_form(){

        if(!($this->session->userdata('id'))){

            parent::redirectUrl('signin');
            return;
        }

        $this->data = array();

        if($this->uri->segment(2) AND $this->uri->segment(2) != "page" ){
            $activity_id = $this->uri->segment(2);

            try{

                $this->operation->table_name = 'activities';
                $query = $this->operation->GetByWhere(array(
                        'id'=>$activity_id,
                    ));

                if(count($query)){

                    $this->data['type'] = $classlist;

                }
            }catch(Exception e){

            }
        }

        $this->load->view('task/task_form',$this->data);

    }

    /**
    *   Get a task
    *
    */
    public function getTask(){

        if(!($this->session->userdata('id'))){

            parent::redirectUrl('signin');
            return;
        }

        $roles = $this->session->userdata('roles');

        if($this->uri->segment(2) AND $this->uri->segment(2) != "page" ){
            $activity_id = $this->uri->segment(2);

            try{

                $this->operation->table_name = 'activities';
                $query = $this->operation->GetByWhere(array(
                        'id'=>$activity_id,
                    ));

                if(count($query)){

                    // Get classes
                    $this->operation->table_name = 'activity_class';

                    $class_list = $this->operation->GetByWhere(array(

                        'activity_id'=>$activity_id,

                    ));

                    $class_display = array();
                    $class_str = '';
                    if(count($class_list))
                    {
                        foreach ($class_list as $key => $cvalue) {
                            $cname = parent::getClass($cvalue->class_id);
                            $class_display[] = array(

                                'name'=> $cname;

                            );

                            if(empty($class_str)){
                                $class_str =  $cname;
                            }else{
                                $class_str .=  ", " . $cname;    
                            }
                            
                        }
                    }


                    // Get sections
                    $this->operation->table_name = 'activity_section';
                    $section_list = $this->operation->GetByWhere(array(
                        'activity_id'=>$activity_id,
                    ));

                    $section_display = array();
                    $section_str = '';
                    if(count($section_list))
                    {
                        foreach ($section_list as $key => $cvalue) {
                            $sname = parent::getSectionList($cvalue->section_id);
                            $section_display[] = array(

                                'name'=>$sname

                            );

                            if(empty($section_str)){
                                $section_str =  $sname;
                            }else{
                                $section_str .=  ", " . $sname;    
                            }
                        }
                    }

                    // Get subjects
                    $subject_list_temp= array();

                    $this->operation->table_name = 'activity_subject';
                    $subject_list_temp = $this->operation->GetByWhere(array(
                        'activity_id'=>$activity_id,
                    ));

                    $subject_display = array();

                    $subject_list = array();
                    $subject_str = '';

                    if(count($subject_list_temp))
                    {
                        foreach ($subject_list_temp as $key => $suvalue) {

                            $subject_name = parent::GetSubject($suvalue->subject_id);

                            $this->operation->table_name = 'classes';
                            $class_name = $this->operation->GetByWhere(array('id'=>$subject_name[0]->class_id));

                            $subject_list[] = array(

                                'classid'=>$subject_name[0]->class_id,

                                'classname'=>$class_name[0]->grade,

                                'subjectid'=>$suvalue->subject_id,

                                'subject'=>$suvalue->subject,

                            );

                            //$subject_name = parent::GetSubject($suvalue->subject_id);

                            $subject_display[] = array(

                                'name'=>$subject_name[0]->subject_name,

                                'class'=>parent::getClass($subject_name[0]->class_id)

                            );

                            if(empty($subject_str)){
                                $subject_str =  $subject_name[0]->subject_name;
                            }else{
                                $subject_str .=  ", " . $subject_name[0]->subject_name;
                            }
                        }
                    }

                    
                    // Get semester
                    $this->operation->table_name = 'activity_semester';
                    $semester_list = $this->operation->GetByWhere(array(
                        'activity_id'=>$activity_id,
                    ));


                    $semester_display = array();

                    if(count($semester_list))
                    {
                        foreach ($semester_list as $key => $sevalue) {

                            $semester_name = parent::GetSemeterDetail($sevalue->semester_id);

                            $semester_display[] = array(

                                'name'=>$semester_name[0]->semester_name

                            );
                        }
                    }


                    // Get students

                    $std_list =array();

                    $std_list_tmp =array();

                    $this->operation->table_name = 'activity_student';
                    $std_list_tmp = $this->operation->GetByWhere(array(

                        'activity_id'=>$activity_id,

                    ));

                    if(count($std_list_tmp))
                    {
                        foreach ($std_list_tmp as $key => $svalue) {

                            if(!is_null($svalue->id)){
                                $classlist = $this->operation->GetRowsByQyery("SELECT c.grade,se.section_name FROM student_semesters s  
                                    INNER JOIN classes c ON c.id = s.classid 
                                    INNER JOIN sections se ON se.id = s.sectionid   
                                    WHERE s.status = 'r' AND s.studentid = ".$svalue->id);
                                $classname = '';
                                if(count($classlist))
                                {
                                    $classname = $classlist[0]->grade.' ('.$classlist[0]->section_name.' )';
                                }
                                $std_list[] = array(
                                    'student_id'=> $svalue->id,
                                    
                                    'student_name'=> (parent::getUserMeta($svalue->id,'sfullname') != false ? parent::getUserMeta($svalue->id,'sfullname') : ''),
                                    
                                    'slastname'=> (parent::getUserMeta($svalue->id,'slastname') != false ? parent::getUserMeta($svalue->id,'slastname') : ''),
                                    
                                    'roll_number'=> (parent::getUserMeta($svalue->id,'roll_number') != false ? parent::getUserMeta($svalue->id,'roll_number') : ''),

                                    'class'=> $classname
                                );
                            }
                        }
                    }


                    $result = array(

                        'id'=>$value->publicslug,

                        'title'=>$value->title,

                        'language'=>$value->language,

                        'from_date'=>((!is_null($value->from_date) && $value->from_date != '1969-12-31') ? date('m/d/Y',strtotime($value->from_date)) : ''),

                        'due_date'=>((!is_null($value->due_date) && $value->due_date != '1969-12-31') ? date('m/d/Y',strtotime($value->due_date)) : ''),

                        'status_key'=>$value->status,

                        'status'=>($value->status == 'a' ? 'Active':'Inactive'),

                        'graded_key'=>$value->graded,

                        'graded'=>($value->graded == 'y' ? 'Yes':'No'),

                        'published_key'=>$value->published,

                        'published'=>($value->published == 'y' ? 'Yes':'No'),

                        'marks'=>(int) $value->marks,

                        'type_key'=>$value->type,

                        'type'=>($value->type == 'e' ? 'External':'Internal'),

                        'created'=>date('M d, Y',strtotime($value->created)),

                        'edited'=>date('M d, Y',strtotime($value->edited)),

                        'class_array'=>$class_list,

                        'class_display'=>$class_display,

                        'section_array'=>$section_list,

                        'section_display'=>$section_display,

                        'subject_array'=>$subject_list,

                        'subject_display'=>$subject_display,

                        'semester_array'=>$semester_list,

                        'semester_display'=>$semester_display,

                        'student_array'=>$std_list
                    );
                }

                echo json_encode($result);

            }catch(Exception e){

            }
        }

    }

    /**

     * Get list of all tasks

     *

     * @access private

     */

    function getTasks() {

        if(!($this->session->userdata('id'))){
            parent::redirectUrl('signin');
            return;
        }   

        $studentlist = array();
        $locations = $this->session->userdata('locations');

        $roles = $this->session->userdata('roles');
        // role_id = 4 for teacher
        
        try{

            $query = $this->operation->GetRowsByQyery("SELECT * FROM activities"); 

            $result = array();

            if(count($query))

            {
                $all_classes = array();
                $all_sections = array();
                $all_subjects = array();
                $all_types = array();

                foreach ($query as $key => $value) {
                    $activity_id = $value->id;

                    // Get classes
                    $this->operation->table_name = 'activity_class';

                    $class_list = $this->operation->GetByWhere(array(

                        'activity_id'=>$activity_id,

                    ));

                    $class_display = array();
                    $class_str = '';
                    if(count($class_list))
                    {
                        foreach ($class_list as $key => $cvalue) {
                            $cname = parent::getClass($cvalue->class_id);
                            $class_display[] = array(

                                'name'=> $cname;

                            );

                            if(empty($class_str)){
                                $class_str =  $cname;
                            }else{
                                $class_str .=  ", " . $cname;    
                            }
                            
                        }
                    }


                    // Get sections
                    $this->operation->table_name = 'activity_section';
                    $section_list = $this->operation->GetByWhere(array(
                        'activity_id'=>$activity_id,
                    ));

                    $section_display = array();
                    $section_str = '';
                    if(count($section_list))
                    {
                        foreach ($section_list as $key => $cvalue) {
                            $sname = parent::getSectionList($cvalue->section_id);
                            $section_display[] = array(

                                'name'=>$sname

                            );

                            if(empty($section_str)){
                                $section_str =  $sname;
                            }else{
                                $section_str .=  ", " . $sname;    
                            }
                        }
                    }

                    // Get subjects
                    $subject_list_temp= array();

                    $this->operation->table_name = 'activity_subject';
                    $subject_list_temp = $this->operation->GetByWhere(array(
                        'activity_id'=>$activity_id,
                    ));

                    $subject_display = array();

                    $subject_list = array();
                    $subject_str = '';

                    if(count($subject_list_temp))
                    {
                        foreach ($subject_list_temp as $key => $suvalue) {

                            $subject_name = parent::GetSubject($suvalue->subject_id);

                            $this->operation->table_name = 'classes';
                            $class_name = $this->operation->GetByWhere(array('id'=>$subject_name[0]->class_id));

                            $subject_list[] = array(

                                'classid'=>$subject_name[0]->class_id,

                                'classname'=>$class_name[0]->grade,

                                'subjectid'=>$suvalue->subject_id,

                                'subject'=>$suvalue->subject,

                            );

                            //$subject_name = parent::GetSubject($suvalue->subject_id);

                            $subject_display[] = array(

                                'name'=>$subject_name[0]->subject_name,

                                'class'=>parent::getClass($subject_name[0]->class_id)

                            );

                            if(empty($subject_str)){
                                $subject_str =  $subject_name[0]->subject_name;
                            }else{
                                $subject_str .=  ", " . $subject_name[0]->subject_name;
                            }
                        }
                    }

                    
                    // Get semester
                    $this->operation->table_name = 'activity_semester';
                    $semester_list = $this->operation->GetByWhere(array(
                        'activity_id'=>$activity_id,
                    ));


                    $semester_display = array();

                    if(count($semester_list))
                    {
                        foreach ($semester_list as $key => $sevalue) {

                            $semester_name = parent::GetSemeterDetail($sevalue->semester_id);

                            $semester_display[] = array(

                                'name'=>$semester_name[0]->semester_name

                            );
                        }
                    }


                    // Get students

                    $std_list =array();

                    $std_list_tmp =array();

                    $this->operation->table_name = 'activity_student';
                    $std_list_tmp = $this->operation->GetByWhere(array(

                        'activity_id'=>$activity_id,

                    ));

                    if(count($std_list_tmp))
                    {
                        foreach ($std_list_tmp as $key => $svalue) {

                            if(!is_null($svalue->id)){
                                $classlist = $this->operation->GetRowsByQyery("SELECT c.grade,se.section_name FROM student_semesters s  
                                    INNER JOIN classes c ON c.id = s.classid 
                                    INNER JOIN sections se ON se.id = s.sectionid   
                                    WHERE s.status = 'r' AND s.studentid = ".$svalue->id);
                                $classname = '';
                                if(count($classlist))
                                {
                                    $classname = $classlist[0]->grade.' ('.$classlist[0]->section_name.' )';
                                }
                                $std_list[] = array(
                                    'student_id'=> $svalue->id,
                                    
                                    'student_name'=> (parent::getUserMeta($svalue->id,'sfullname') != false ? parent::getUserMeta($svalue->id,'sfullname') : ''),
                                    
                                    'slastname'=> (parent::getUserMeta($svalue->id,'slastname') != false ? parent::getUserMeta($svalue->id,'slastname') : ''),
                                    
                                    'roll_number'=> (parent::getUserMeta($svalue->id,'roll_number') != false ? parent::getUserMeta($svalue->id,'roll_number') : ''),

                                    'class'=> $classname
                                );
                            }
                        }
                    }


                    $result[] = array(

                        'id'=>$value->publicslug,

                        'title'=>$value->title,

                        'language'=>$value->language,

                        'from_date'=>((!is_null($value->from_date) && $value->from_date != '1969-12-31') ? date('m/d/Y',strtotime($value->from_date)) : ''),

                        'due_date'=>((!is_null($value->due_date) && $value->due_date != '1969-12-31') ? date('m/d/Y',strtotime($value->due_date)) : ''),

                        'status_key'=>$value->status,

                        'status'=>($value->status == 'a' ? 'Active':'Inactive'),

                        'graded_key'=>$value->graded,

                        'graded'=>($value->graded == 'y' ? 'Yes':'No'),

                        'published_key'=>$value->published,

                        'published'=>($value->published == 'y' ? 'Yes':'No'),

                        'marks'=>(int) $value->marks,

                        'type_key'=>$value->type,

                        'type'=>($value->type == 'e' ? 'External':'Internal'),

                        'created'=>date('M d, Y',strtotime($value->created)),

                        'edited'=>date('M d, Y',strtotime($value->edited)),

                        'class_array'=>$class_list,

                        'class_display'=>$class_display,

                        'section_array'=>$section_list,

                        'section_display'=>$section_display,

                        'subject_array'=>$subject_list,

                        'subject_display'=>$subject_display,

                        'semester_array'=>$semester_list,

                        'semester_display'=>$semester_display,

                        'student_array'=>$std_list,

                    );

                }

            }

            echo json_encode($result);

        }       

        catch(Exception $e){

        }
    }



   function Upload_File($file,$name)

   {

        $link = null;

        $valid_formats = array("mp4","3gpp","png","jpg","gif");

                 

        if(strlen($file[$name]['name']))

        {

            list($txt, $ext) = explode(".", strtolower($file[$name]['name']));

            

            if(in_array(strtolower($ext),$valid_formats)){



                if ($file[$name]["size"] < 50000000) {

                    $title_image_name = time().$file[$name]['name'];



                    if(is_uploaded_file($file[$name]['tmp_name'])){

                      

                        //The name of the directory that we need to create.

                        $directoryName = UPLOAD_PATH.'content/activity/';

                         

                        //Check if the directory already exists.

                        if(!is_dir($directoryName)){

                            //Directory does not exist, so lets create it.

                            mkdir($directoryName, 0755, true);

                        }                               

                        $path = $directoryName; 

                        $file = time().trim(basename($file[$name]['name']));

                        $filename = $directoryName.$file;

                        if(move_uploaded_file($_FILES[$name]['tmp_name'],$filename)){

                            $link = IMAGE_LINK_PATH."content/activity/".$file;

                           

                        }

                    }

                }

            }

        }

        return $link;

    }



    

}




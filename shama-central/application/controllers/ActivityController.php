<?php



  /**

   *  Cartoon controller

   *

   */



class ActivityController extends MY_Controller

{



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

        if( $roles[0]['role_id'] == 3)
        {



        $classlist = $this->operation->GetRowsByQyery("SELECT  * FROM classes c where school_id =".$locations[0]['school_id']);

        }
         else if ($roles[0]['role_id'] == 4 OR $this->session->userdata('is_master_teacher') == '1') {

            $classlist = $this->operation->GetRowsByQyery("SELECT c.id as classid,c.grade FROM schedule sch INNER JOIN classes c on c.id = sch.class_id  WHERE sch.teacher_uid = ".$this->session->userdata('id')." GROUP by c.id ORDER by c.id asc");
        }
        $this->data['classlist'] = $classlist;
        $this->load->view('activity/activity',$this->data);

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



    // function CheckLinkExist($)

    // {

    //     $this->operation->table_name = 'activity_files';

    // }



    function Save()

    {

        $result['message'] = false;

        try{

            $serail = $this->input->post('serail');

            $title = $this->input->post('title');

            $date = $this->input->post('view_date');

            $status = $this->input->post('status');

            $source = $this->input->post('source_type');

            $marks = $this->input->post('marks');

            $repeat = $this->input->post('repeat');

            $age = $this->input->post('age');

            $language = $this->input->post('language');

            $videolink = $this->input->post('link');

            $type = $this->input->post('type');

            $grades = json_decode($this->input->post('grades'));

            $subjects = json_decode($this->input->post('subjects'));

            $semester = json_decode($this->input->post('semester'));

            $tags = json_decode($this->input->post('tags'));

            

            $error_array = array();

            if (strlen($title) < 3 &&  !empty($status)) {

                array_push($error_array,"Validation error");

            }

                 

            if(count($error_array))

            {

                exit();

            }



            if(!is_null($serail) && !empty($serail))

            {

                $this->operation->table_name = 'activities';

            

                $is_valid_activity = $this->operation->GetByWhere(array(

                    'publicslug'=>strtolower($serail),

                ));



                if(count($is_valid_activity))

                {

                    $cartoon = array(

                        'title'=>ucfirst($title),

                        'language'=>(!empty($language) ? $language : ''),

                        'age_limit'=>(!empty($age) ? $age : 5),

                        'repeat'=>(!empty($repeat) ? $repeat : 0),

                        'source_type'=>$source,

                        'edited'=>date('Y-m-d'),

                        'view_date'=>(!is_null($date) ? date('Y-m-d',strtotime($date)) : ' '),

                        'status'=>$status,

                        'user_id'=>$this->session->userdata('id'),

                    );

                    $this->operation->primary_key = 'id';

                    $aid = $this->operation->Create($cartoon,$is_valid_activity[0]->id);

                    

                    $this->operation->table_name = 'activity_files';

                    $activity_serail = $this->operation->GetByWhere(array(

                        'activity_id'=>$aid,

                        'file_row'=>1

                    ));



                    if(count($_FILES['file_one']) && $_FILES['file_one']['name'] != null)

                    {

                        $activity_files = array(

                            'activity_id'=>$aid,

                            'link'=>$this->Upload_File($_FILES,file_one),

                            'type'=>$this->input->post('file_one_type'),

                            'file_name'=>$_FILES['file_one']['name'],

                            'file_row'=>1,
                            'source'=>$this->input->post('file_one_source')
                        );

                        if(count($activity_serail))

                        {

                            $file_one = $this->operation->Create($activity_files,$activity_serail[0]->id);

                        }

                        else{

                            $file_one = $this->operation->Create($activity_files);

                        }

                       

                    }



                    $this->operation->table_name = 'activity_files';

                    $activity_serail = $this->operation->GetByWhere(array(

                        'activity_id'=>$aid,

                        'file_row'=>2

                    ));



                    if(count($_FILES['file_two']) && $_FILES['file_two']['name'] != null)

                    {

                        

                        $activity_files = array(

                            'activity_id'=>$aid,

                            'link'=>$this->Upload_File($_FILES,file_two),

                            'type'=>$this->input->post('file_two_type'),

                            'file_name'=>$_FILES['file_two']['name'],

                            'file_row'=>2,
                            'source'=>$this->input->post('file_two_source')

                        );

                        if(count($activity_serail))

                        {

                            $file_one = $this->operation->Create($activity_files,$activity_serail[0]->id);

                        }

                        else{

                            $file_one = $this->operation->Create($activity_files);

                        }

                    }



                    $this->operation->table_name = 'activity_files';

                    $activity_serail = $this->operation->GetByWhere(array(

                        'activity_id'=>$aid,

                        'file_row'=>3

                    ));

                    

                    if(count($_FILES['file_three']) && $_FILES['file_three']['name'] != null)

                    {

                    

                        $activity_files = array(

                            'activity_id'=>$aid,

                            'link'=>$this->Upload_File($_FILES,file_three),

                            'type'=>$this->input->post('file_three_type'),

                            'file_name'=>$_FILES['file_three']['name'],

                            'file_row'=>3,
                            'source'=>$this->input->post('file_three_source')

                        );

                        if(count($activity_serail))

                        {

                            $file_one = $this->operation->Create($activity_files,$activity_serail[0]->id);

                        }

                        else{

                            $file_one = $this->operation->Create($activity_files);

                        }

                    }



                    $this->operation->table_name = 'activity_files';

                    $activity_serail = $this->operation->GetByWhere(array(

                        'activity_id'=>$aid,

                        'file_row'=>4

                    ));



                    if($this->input->post('first_link') && $this->input->post('link_one_type'))

                    {

                        $activity_files = array(

                            'activity_id'=>$aid,

                            'link'=>$this->input->post('first_link'),

                            'type'=>$this->input->post('link_one_type'),

                            'file_row'=>4,
                            'source'=>$this->input->post('link_one_source')

                        );

                        if(count($activity_serail))

                        {

                            $file_one = $this->operation->Create($activity_files,$activity_serail[0]->id);

                        }

                        else{

                            $file_one = $this->operation->Create($activity_files);

                        }

                    }



                    $this->operation->table_name = 'activity_files';

                    $activity_serail = $this->operation->GetByWhere(array(

                        'activity_id'=>$aid,

                        'file_row'=>5

                    ));



                    if($this->input->post('second_link') && $this->input->post('link_two_type'))

                    {

                        $activity_files = array(

                            'activity_id'=>$aid,

                            'link'=>$this->input->post('second_link'),

                            'type'=>$this->input->post('link_two_type'),

                            'file_row'=>5,
                            'source'=>$this->input->post('link_two_source')



                        );

                        if(count($activity_serail))

                        {

                            $file_one = $this->operation->Create($activity_files,$activity_serail[0]->id);

                        }

                        else{

                            $file_one = $this->operation->Create($activity_files);

                        }

                    }



                    $this->operation->table_name = 'activity_files';

                    $activity_serail = $this->operation->GetByWhere(array(

                        'activity_id'=>$aid,

                        'file_row'=>6

                    ));



                     if($this->input->post('third_link') && $this->input->post('link_three_type'))

                    {

                        $activity_files = array(

                            'activity_id'=>$aid,

                            'link'=>$this->input->post('third_link'),

                            'type'=>$this->input->post('link_three_type'),

                            'file_row'=>6,
                            'source'=>$this->input->post('link_three_source')

                        );

                         if(count($activity_serail))

                        {

                            $file_one = $this->operation->Create($activity_files,$activity_serail[0]->id);

                        }

                        else{

                            $file_one = $this->operation->Create($activity_files);

                        }

                    }



                    $this->operation->table_name = 'activity_class';

                    

                    $this->db->query("Delete from activity_class where activity_id = ".$aid);

                    if(count($grades))

                    {

                        foreach ($grades as $key => $value) {



                            $classes = array(

                                'activity_id'=>$aid,

                                'class_id'=>$value->id,

                               

                            );

                            $class_id = $this->operation->Create($classes);

                        }

                    }



                    $this->operation->table_name = 'activity_subject';

                    

                    $this->db->query("Delete from activity_subject where activity_id = ".$aid);

                    if(count($subjects))

                    {

                        foreach ($subjects as $key => $value) {

                            $selected_subjects = array(

                                'subject_id'=>$value->subjectid,

                                'subject'=>$value->subject,

                                'activity_id'=>$aid,

                            );

                            $subject_id = $this->operation->Create($selected_subjects);

                        }

                    }



                    $this->operation->table_name = 'activity_semester';



                    $this->db->query("Delete from activity_semester where activity_id = ".$aid);

                    if(count($semester))

                    {

                        foreach ($semester as $key => $value) {

                            $selected_semesters = array(

                                'semester_id'=>$value->id,

                                'activity_id'=>$aid,

                            );

                            $semester_id = $this->operation->Create($selected_semesters);

                        }

                    }



                    if(count($tags))

                    {

                        $this->db->query("Delete from activity_tag where activity_id = ".$aid);

                        foreach ($tags as $key => $value) {

                            $this->operation->table_name = 'remarks_tags';

                            $is_tag_found = $this->operation->GetByWhere(array(

                                'tag'=>$value->text,

                            ));

                            if(count($is_tag_found) == false)

                            {

                                $selected_tags= array(

                                    'tag'=>$value->text,

                                );

                                $remark_id = $this->operation->Create($selected_tags);

                               

                                $this->operation->table_name = 'activity_tag';



                                

                                if(count($remark_id))

                                {

                                    $save_tags= array(

                                        'activity_id'=>$aid,

                                        'remark_id'=>$remark_id,

                                    );

                                    $tag_id = $this->operation->Create($save_tags);

                                }

                            }

                            else{

                                $this->operation->table_name = 'activity_tag';

                                if(count($is_tag_found))

                                {

                                    $save_tags= array(

                                        'activity_id'=>$aid,

                                        'remark_id'=>$is_tag_found[0]->id,

                                    );

                                    $tag_id = $this->operation->Create($save_tags);

                                }

                            }

                        }

                    }

                }

                

                if(count($aid))

                {

                    $result['message'] = true;

                }

            }

            else{

                $this->operation->table_name = 'activities';

                $auto_number = parent::generateRandomString();

                $cartoon = array(

                    'title'=>ucfirst($title),

                    'language'=>(!empty($language) ? $language : ''),

                    'age_limit'=>$age,

                    'repeat'=>$repeat,

                    'source_type'=>$source,

                    'created'=>date('Y-m-d'),

                    'edited'=>date('Y-m-d'),

                    'publicslug'=>md5($auto_number),

                    'hiddenslug'=>$auto_number,

                    'status'=>$status,

                    'view_date'=>(!is_null($date) ? date('Y-m-d',strtotime($date)) : ' '),

                    'user_id'=>$this->session->userdata('id'),

                );

                $id = $this->operation->Create($cartoon);



                $this->operation->table_name = 'activity_files';

                if(count($_FILES['file_one']) && $_FILES['file_one']['name'] != null)

                {

                    $activity_files = array(

                        'activity_id'=>$id,

                        'link'=>$this->Upload_File($_FILES,file_one),

                        'type'=>$this->input->post('file_one_type'),

                        'file_name'=>$_FILES['file_one']['name'],

                        'file_row'=>1,

                        'source'=>$this->input->post('file_one_source')

                    );

                    $file_one = $this->operation->Create($activity_files);

                }



              

                if(count($_FILES['file_two']) && $_FILES['file_two']['name'] != null)

                {

                    

                    $activity_files = array(

                        'activity_id'=>$id,

                        'link'=>$this->Upload_File($_FILES,file_two),

                        'type'=>$this->input->post('file_two_type'),

                        'file_name'=>$_FILES['file_two']['name'],

                        'file_row'=>2,
                        'source'=>$this->input->post('file_two_source')

                    );

                    $file_two = $this->operation->Create($activity_files);

                }



                

                if(count($_FILES['file_three']) && $_FILES['file_three']['name'] != null)

                {

                

                    $activity_files = array(

                        'activity_id'=>$id,

                        'link'=>$this->Upload_File($_FILES,file_three),

                        'type'=>$this->input->post('file_three_type'),

                        'file_name'=>$_FILES['file_three']['name'],

                        'file_row'=>3,

                        'source'=>$this->input->post('file_three_source')

                    );

                    $file_three = $this->operation->Create($activity_files);
                    
                }

               

                if($this->input->post('first_link') && $this->input->post('link_one_type'))

                {

                    $activity_files = array(

                        'activity_id'=>$id,

                        'link'=>$this->input->post('first_link'),

                        'type'=>$this->input->post('link_one_type'),

                        'file_row'=>4,

                        'source'=>$this->input->post('link_one_source')

                    );

                    $file_three = $this->operation->Create($activity_files);

                }



                if($this->input->post('second_link') && $this->input->post('link_two_type'))

                {

                    $activity_files = array(

                        'activity_id'=>$id,

                        'link'=>$this->input->post('second_link'),

                        'type'=>$this->input->post('link_two_type'),

                        'file_row'=>5,

                        'source'=>$this->input->post('link_two_source')

                    );

                    $file_three = $this->operation->Create($activity_files);

                }



                 if($this->input->post('third_link') && $this->input->post('link_three_type'))

                {

                    $activity_files = array(

                        'activity_id'=>$id,

                        'link'=>$this->input->post('third_link'),

                        'type'=>$this->input->post('link_three_type'),

                        'file_row'=>6,

                        'source'=>$this->input->post('link_three_source')

                    );

                    $file_three = $this->operation->Create($activity_files);

                }



                $this->operation->table_name = 'activity_class';

                if(count($grades))

                {

                    foreach ($grades as $key => $value) {

                        $classes = array(

                            'class_id'=>$value->id,

                            'activity_id'=>$id,

                        );

                        $class_id = $this->operation->Create($classes);

                    }

                }



                $this->operation->table_name = 'activity_subject';

                if(count($subjects))

                {

                    foreach ($subjects as $key => $value) {

                        $selected_subjects = array(

                            'subject_id'=>$value->subjectid,

                            'subject'=>$value->subject,

                            'activity_id'=>$id,

                        );

                        $subject_id = $this->operation->Create($selected_subjects);

                    }

                }



                $this->operation->table_name = 'activity_semester';

                if(count($semester))

                {

                    foreach ($semester as $key => $value) {

                        $selected_semesters = array(

                            'semester_id'=>$value->id,

                            'activity_id'=>$id,

                        );

                        $semester_id = $this->operation->Create($selected_semesters);

                    }

                }



                if(count($tags))

                {

                    foreach ($tags as $key => $value) {

                        $this->operation->table_name = 'remarks_tags';

                        $is_tag_found = $this->operation->GetByWhere(array(

                            'tag'=>strtolower($value->text),

                        ));

                        if(count($is_tag_found) == false)

                        {

                            $selected_tags= array(

                                'tag'=>$value->text,

                            );

                            $remark_id = $this->operation->Create($selected_tags);

                            $this->operation->table_name = 'activity_tag';

                            if(count($remark_id))

                            {

                                $save_tags= array(

                                    'activity_id'=>$id,

                                    'remark_id'=>$remark_id,

                                );

                                $tag_id = $this->operation->Create($save_tags);

                            }

                        }

                        else{

                            $this->operation->table_name = 'activity_tag';

                            if(count($is_tag_found))

                            {

                                $save_tags= array(

                                    'activity_id'=>$id,

                                    'remark_id'=>$is_tag_found[0]->id,

                                );

                                $tag_id = $this->operation->Create($save_tags);

                            }

                        }

                    }

                }

                

                if(count($id))

                {

                    $result['message'] = true;

                }

            }

            echo json_encode($result);

        }

        catch(Exception $e){

            echo json_encode($result);

        }

    }



     /**

     * Get activity list

     */

    public function GetActivityList()

    {

        try{

            $query = $this->operation->GetRowsByQyery("SELECT * FROM activities"); 

            $result = array();

            if(count($query))

            {

                foreach ($query as $key => $value) {

                    $this->operation->table_name = 'activity_class';

                    $class_list = $this->operation->GetByWhere(array(

                        'activity_id'=>$value->id,

                    ));



                    $class_display = array();

                    if(count($class_list))

                    {

                        foreach ($class_list as $key => $cvalue) {

                            $class_display[] = array(

                                'name'=>parent::getClass($cvalue->class_id)

                            );

                        }

                    }



                    $this->operation->table_name = 'activity_subject';

                    $subject_list_temp= array();

                    $subject_list_temp = $this->operation->GetByWhere(array(

                        'activity_id'=>$value->id,

                    ));

                    $subject_display = array();

                    $subject_list = array();

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

                            $subject_name = parent::GetSubject($suvalue->subject_id);

                            $subject_display[] = array(

                                'name'=>$subject_name[0]->subject_name,

                                'class'=>parent::getClass($subject_name[0]->class_id)

                            );

                        }

                    }

                    



                    $this->operation->table_name = 'activity_semester';

                    $semester_list = $this->operation->GetByWhere(array(

                        'activity_id'=>$value->id,

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



                    $this->operation->table_name = 'activity_tag';

                    $tag_list =array();

                    $tags =array();

                    $tag_list = $this->operation->GetByWhere(array(

                        'activity_id'=>$value->id,

                    ));



                    if(count($tag_list))

                    {

                        foreach ($tag_list as $key => $tvalue) {

                            $single_tag = parent::GetActivityTags($tvalue->remark_id);

                            $tags[] = array(

                                'text'=>$single_tag[0]->tag

                            );

                        }

                    }

                     

                     $this->operation->table_name = "activity_files";

                    $links = $this->operation->GetByWhere(array('activity_id'=>$value->id));

                    $result[] = array(

                        'id'=>$value->publicslug,

                        'title'=>$value->title,

                        'language'=>$value->language,

                        'links'=>$links,

                        'view_date'=>((!is_null($value->view_date) && $value->view_date != '1969-12-31') ? date('m/d/Y',strtotime($value->view_date)) : ''),

                        'status_key'=>$value->status,

                        'status'=>($value->status == 'a' ? 'Active':'Inactive'),

                        'graded_key'=>$value->graded,

                        'graded'=>($value->graded == 'y' ? 'Yes':'No'),

                        'marks'=>(int) $value->marks,

                        'age'=>(int)$value->age_limit,

                        'language'=>$value->language,

                        'repeat'=>(int)$value->repeat,

                        'source_type_key'=>$value->source_type,

                        'source_type'=>($value->source_type == 'e' ? 'External':'Internal'),

                        'apply_on_slp_key'=>$value->apply_on_slp,

                        'apply_on_slp'=>($value->apply_on_slp == 'y' ? 'Yes':'No'),

                        'created'=>date('M d, Y',strtotime($value->created)),

                        'edited'=>date('M d, Y',strtotime($value->edited)),

                        'class_array'=>$class_list,

                        'class_display'=>$class_display,

                        'subject_array'=>$subject_list,

                        'subject_display'=>$subject_display,

                        'semester_array'=>$semester_list,

                        'semester_display'=>$semester_display,

                        'tags'=>$tags,

                    );

                }

            }

            echo json_encode($result);

        }       

        catch(Exception $e){

        }

    }



    function RemoveActivity()

    {

        $request = json_decode( file_get_contents('php://input'));

        $serail = $this->security->xss_clean(trim($request->serail));

        $result['message'] = false;

        if(!is_null($serail))

        {

            $this->operation->table_name = 'activities';

                    

            $is_valid_activity = $this->operation->GetByWhere(array(

                'publicslug'=>$serail,

            ));



            if(count($is_valid_activity) && md5($is_valid_activity[0]->hiddenslug) == $serail)

            {

                $this->operation->primary_key = 'id';

                $this->operation->Remove($is_valid_activity[0]->id);

                $result['message'] = true;

            }

        }



        echo json_encode($result);

    }



    function RemoveLink()

    {

        $request = json_decode( file_get_contents('php://input'));

        $serail = $this->security->xss_clean(trim($request->serail));

        $result['message'] = false;

        if(!is_null($serail))

        {

            $this->operation->table_name = 'activity_files';

            $this->operation->primary_key = 'id';

            $this->operation->Remove($serail);

            $result['message'] = true;

        }



        echo json_encode($result);

    }

    

}




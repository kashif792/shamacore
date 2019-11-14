<?php

/**
 * Invantage Controller
 *
 * This class responsible for inventage.
 */
class Widget_Schedule_Controller extends MY_Controller
{
	/**
 	 * @var array
 	 */
	var $data = array();

	function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Karachi");
	}
	
	/**
	 *	Return schedule including hard coded assembly and break timings for KG and Other classes
	 */
	function get_data()
	{
	    try{
	        

				$data = array(
	                    'user_id'=>$this->session->userdata('id'),
	                    'school_id'=>$this->session->userdata('default_school_id')
	            );


	        echo json_encode($data);
	        /*
	        $schedule = array();
	        $class_array = array();
	        $kindergarten_section = array();
	        $rest_section = array();
	        
	        $query = $this->shama_api('GET', SAPI_SCHEDULES,
	                ['query'=>[
	                    'user_id'=>$this->session->userdata('id'),
	                    'school_id'=>$this->session->userdata('default_school_id')
	            ]]);
	            if(count($query))
	            {
	                foreach ($query as $value) {
	                    
	                    // add assembly to each class
	                    $is_class_found = in_array($value->grade,$class_array);
	                    
	                    if($is_class_found == false && date('H:i',$value->start_time) >= date('H:i',DateTime::createFromFormat('H:i', "8:00")))
	                    {
	                        array_push($class_array, $value->grade);
	                        $schedule[] = array(
	                            'grade'=>$value->grade,
	                            'section'=>$value->section,
	                            'subject'=>"Assembly",
	                            'teacher'=>"Assembly",
	                            'start_time'=>"8:00",
	                            'end_time'=>"8:20",
	                        );
	                    }
	                    
	                    
	                    $is_kin_class_found = in_array($value->section,$kindergarten_section);
	                    // break to kindergarten
	                    if($is_kin_class_found == false && $value->grade == 'Kindergarten' && date('H:i',$value->start_time) >=date( 'H:i' ,DateTime::createFromFormat('H:i', "10:11")))
	                    {
	                        array_push($kindergarten_section, $value->section);
	                        $schedule[] = array(
	                            'grade'=>$value->grade,
	                            'section'=>$value->section,
	                            'subject'=>"Break",
	                            'teacher'=>"Break",
	                            'start_time'=>"10:11",
	                            'end_time'=>"10:45",
	                        );
	                    }
	                    
	                    $is_rest_class_found = in_array($value->grade,$rest_section);
	                    
	                    // break to rest school
	                    if($is_rest_class_found == false && $value->grade != 'Kindergarten' && date('H:i',$value->start_time) >= date( 'H:i' ,DateTime::createFromFormat('H:i', "10:11")))
	                    {
	                        array_push($rest_section, $value->grade);
	                        $schedule[] = array(
	                            'grade'=>$value->grade,
	                            'section'=>$value->section,
	                            'subject'=>"Break",
	                            'teacher'=>"Break",
	                            'start_time'=>"10:11",
	                            'end_time'=>"10:45",
	                        );
	                    }
	                    
	                    $schedule[] = array(
	                        'grade'=>$value->grade,
	                        'section'=>$value->section,
	                        'subject'=>$value->subject,
	                        'teacher'=>$value->teacher,
	                        'start_time'=>$value->start_time,
	                        'end_time'=>$value->end_time,
	                    );
	                }
	            }
	        
	        echo json_encode($schedule);*/
	    }
	    catch(Exception $e){}
	}
}

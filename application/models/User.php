<?php

 /**
 *  User  Model
 */
 class User extends MY_Model{
 	public $table_name = 'invantage_users'; // table name
  	public $primary_key = 'id'; // primary key
	private $id ;
	
	function  __construct(){
	    parent::__construct();
	    //$this->load->library('session');
	}
	
	public function Create($array,$id = NULL){
		return $this->user->save($array,$id);
	}
	public function GetByQuery($query){
		return $this->user->get_by_query($query);
	}
	public function GetByWhere($array , $single = FALSE){
		return $this->user->get_by($array , $single);
	}
	public function Remove($id){
		return $this->user->delete($id);
	}
	public function GetRows($id = NULL , $single = FALSE){
		return $this->user->get($id ,$single);
	}
	
	/** 
	 * Authenticate teacher login using API
	 * 
	 * @param string $email
	 * @param string $password
	 * 
	 * @return array $userobj 
	 */

	public function AuthenticateLoginUserByAPI($email,$password){
		
		$password = md5($password);
		$this->user->table_name ="invantage_users";
		$user = $this->user->get_by_query("Select * from ".$this->user->table_name." where (username = '".$email."' OR email ='". $email."')  AND password = '".$password."' limit 1");
		$userobj = array();
		if(count($user) > 0):
			$user_roles = $this->user->get_by_query("Select ur.role_id,r.type from user_roles ur INNER JOIN roles r ON r.id = ur.role_id  where user_id =".$user[0]->id);
			$user_locations = $this->user->get_by_query("Select ur.school_id,s.* from user_locations ur INNER JOIN schools s ON s.id = ur.school_id where ur.user_id =".$user[0]->id);
			$temp_roles = array();
			foreach ($user_roles as $key => $rvalue) {
				$temp_roles[] = array(
					'role_id'=>$rvalue->role_id,
					'type'=>$rvalue->type
				);
			}
			$temp_user_locations = array();
			foreach ($user_locations as $key => $lvalue) {
				$temp_user_locations[] = array(
					'school_id'=>$lvalue->school_id,
					'shortname'=>$lvalue->shortname,
					'schoolname'=>$lvalue->name
				);
			}
			
			$userobj = array(
				'id'=>$user[0]->id,
				'name'=>$user[0]->screenname,
				'email'=>$user[0]->email,
				'is_master_teacher'=>$user[0]->is_master_teacher,
				'roles'=>$temp_roles,
				'schools'=>$temp_user_locations,
				'profile_image'=>$user[0]->profile_image,
				'type'=>$user[0]->type
			);
		endif;

		return $userobj;
	}
	

	public function StudentLogin($username,$password){
		
		// $password = md5($password);
		$password=$password;			
	
		$this->user->table_name ="invantage_users";
		$user = $this->user->get_by_query("Select * from ".$this->user->table_name." where username ='". $username."'  AND password = '".$password."' limit 1");

		$check = false;
		if(count($user) > 0):
			foreach ($user	as $key=>$value):
				$studentclass = $this->user->get_by_query("Select * from student_semesters   where studentid =".$value->id." AND status = 'r'");

                $user_locations = $this->user->get_by_query("Select ur.school_id,s.* from user_locations ur INNER JOIN schools s ON s.id = ur.school_id where ur.user_id =".$value->id);
				$temp_roles = array();
				

				$temp_user_locations = array();
				foreach ($user_locations as $key => $lvalue) {
					$temp_user_locations[] = array(
						'school_id'=>$lvalue->school_id,
						'shortname'=>$lvalue->shortname,
						'schoolname'=>$lvalue->name
					);
				}

				$data['id'] = $value->id;
				$data['name'] = $value->screenname;
				$data['class'] = $studentclass[0]->classid;
				$data['section'] = $studentclass[0]->sectionid;
				$data['semester'] = $studentclass[0]->semesterid;
				$data['email'] = $value->email;
				$data['username'] = $value->username;
				$data['locations'] = $temp_user_locations;
				$data['profile_image'] = $value->profile_image;
			endforeach;
			$data['loggedin'] = TRUE;
			$check = true;
			$this->session->set_userdata($data);

		endif;
		return $check;
	}

	
	public function logout(){
		if($this->session->sess_destroy())
		{
			$_SESSION = array();
			// Expire their cookie files
			if(isset($_COOKIE['id']) && isset($_COOKIE['useremail']) && isset($_COOKIE['pass'])){
				setcookie("id", '', strtotime( '-5 days' ), '/');
			    setcookie("user", '', strtotime( '-5 days' ), '/');
				setcookie("pass", '', strtotime( '-5 days' ), '/');
				return true;
			}
			

		}

		
		// Destroy the session variables
		//session_destroy();
	}
	public function loggedin(){
		return (bool) $this->session->userdata('loggedin');
	}

	public function hash($string){
		// config_item('encryption_key')
		return hash('sha512',$string.config_item('encryption_key'));
	}

	
    /*
    * Get dublicate email
    */
    public function getDuplicate($nic){
    	$this->user->table_name ="invantage_users";
    	$user = $this->user->get_by_query("Select nic from ".$this->user->table_name." where nic = '".$nic."'");
    	$check = FALSE;
    	if(count($user) == true):
    		$check = TRUE;
    	endif;
    	return $check;
    }
  

    /*
     * Show message to user
     */
    function getLastStudentId(){
		$this->user->table_name ="user_meta";
    	$user = $this->user->get_by_query("Select inuser.*,um.meta_value from invantage_users inuser INNER JOIN user_meta um ON um.user_id =inuser.id where inuser.type = 's' AND um.meta_key = 'roll_number'  order by inuser.id desc limit 1");

    	if(count($user)){
    		return $user[0]->meta_value;
    	}
    	else{
    		return false;
    	}
    }



   	/**
     * Student signup
     */
  public function StudentInfo($id, $school_id, $sname, $slastname,$saddress ,$shunit ,$scity ,$sprovice ,$spcode ,$sphone ,$sdob ,$sdateav ,$snic,$smthrlng,$saddlang ,$sgrade ,$sgrade1 ,$sfname ,$sfnic ,$sfpro ,$sfyear ,$sfcompany ,$sfcyears ,$sfmincome ,$sfwaddress ,$sfmincome2 ,$srassitance ,$scir ,$spreviousshool,$spradress,$sfrom,$sto,$spreviousshool2,$spradress2,$sfrom2,$sto2,$spreviousshool3,$spradress3,$sfrom3,$sto3,$srfulname,$srrelationship,$srcmpny,$srphone,$sradress,$srfulname2,$srrelationship2,$srcmpny2,$srphone2,$sradress2,$srfulname3,$srrelationship3,$srcmpny3,$srphone3,$sradress3,$semester,$ssignature,$ssubmitdate,$mode,$password) {
  	
  	try{

		if($id != null)
		{

			$this->user->table_name ="invantage_users";
			$this->user->primary_key = 'id';
			//$is_user_already_exist = $this->finduseimage($id);
			$userarray = array(
				'screenname'=>$sname,
				'nic'=>trim($snic)
			);

			if(!empty($password)){
				$userarray['password']=md5($password);
			}

			$is_user_created = $this->user->save($userarray,$id);

			$this->user->table_name = 'user_locations';
			$this->user->primary_key = 'user_id';
			
			$user_locations = array(
				'school_id'=>$school_id
			);

			$user_locations = $this->user->save($user_locations,$is_user_created);

			$this->user->table_name = 'user_meta';
			 $this->update_meta($is_user_created,'sfullname',$sname);
			  $this->update_meta($is_user_created,'slastname',$slastname);

			 $this->update_meta($is_user_created,'saddress',$saddress);
			 $this->update_meta($is_user_created,'shunit',$shunit);
			 $this->update_meta($is_user_created,'scity',$scity);
			$this->update_meta($is_user_created,'sprovice',$sprovice);
			$this->update_meta($is_user_created,'spcode',$spcode);
			$this->update_meta($is_user_created,'sphone',$sphone);
	
			$this->update_meta($is_user_created,'sdob',$sdob);
			
			$this->update_meta($is_user_created,'sdateav',$sdateav);
			$this->update_meta($is_user_created,'snic',$snic);
			$this->update_meta($is_user_created,'smthrlng',$smthrlng);
			$this->update_meta($is_user_created,'saddlang',$saddlang);
			$this->update_meta($is_user_created,'sgrade',$sgrade);
			$this->update_meta($is_user_created,'father_name',$sfname);
			$this->update_meta($is_user_created,'father_nic',$sfnic);
			$this->update_meta($is_user_created,'father_profession',$sfpro);
			$this->update_meta($is_user_created,'father_years',$sfyear);
			$this->update_meta($is_user_created,'father_company',$sfcompany);
			$this->update_meta($is_user_created,'father_comapny_years',$sfcyears);
			$this->update_meta($is_user_created,'monthly_income',$sfmincome);
			$this->update_meta($is_user_created,'father_work_address',$sfwaddress);
			$this->update_meta($is_user_created,'father_monthly_income_2',$sfmincome2);
			$this->update_meta($is_user_created,'financial_assistance',$srassitance);
			$this->update_meta($is_user_created,'mode',$mode);
			$this->update_meta($is_user_created,'circumstances',$scir);
			$this->update_meta($is_user_created,'previous_school_1',$spreviousshool);
			$this->update_meta($is_user_created,'school_history_address_1',$spradress);
			$this->update_meta($is_user_created,'from_1',$sfrom);
			$this->update_meta($is_user_created,'to_1',$sto);
			$this->update_meta($is_user_created,'previous_school_2',$spreviousshool2);
			$this->update_meta($is_user_created,'school_history_address_2',$spradress2);
			$this->update_meta($is_user_created,'from_2',$sfrom2);
			$this->update_meta($is_user_created,'to_2',$sto2);
			$this->update_meta($is_user_created,'previous_school_3',$spreviousshool3);
			$this->update_meta($is_user_created,'school_history_address_3',$spradress3);
			$this->update_meta($is_user_created,'from_3',$sfrom3);
			$this->update_meta($is_user_created,'to_3',$sto3);
			$this->update_meta($is_user_created,'student_reference_fullname',$srfulname);
			$this->update_meta($is_user_created,'student_reference_relationship',$srrelationship);
			$this->update_meta($is_user_created,'student_refernce_company',$srcmpny);
			$this->update_meta($is_user_created,'student_reference_phone',$srphone);
			$this->update_meta($is_user_created,'student_reference_adress',$sradress);
			$this->update_meta($is_user_created,'student_reference_fullname2',$srfulname2);
			$this->update_meta($is_user_created,'student_reference_relationship2',$srrelationship2);
			$this->update_meta($is_user_created,'student_refernce_company2',$srcmpny2);
			$this->update_meta($is_user_created,'student_reference_phone2',$srphone2);
			$this->update_meta($is_user_created,'student_reference_adress2',$sradress2);
			$this->update_meta($is_user_created,'student_reference_fullname3',$srfulname3);
			$this->update_meta($is_user_created,'student_reference_relationship3',$srrelationship3);
			$this->update_meta($is_user_created,'student_refernce_company3',$srcmpny3);
			$this->update_meta($is_user_created,'student_reference_phone3',$srphone3);
			$this->update_meta($is_user_created,'student_reference_adress3',$sradress3);
			$this->update_meta($is_user_created,'student_signature',$ssignature);
			$this->update_meta($is_user_created,'student_submate_date',$ssubmitdate);
			

			$this->operation->table_name ="sessions";
			$active_session = $this->operation->GetByWhere(array('status'=>'a','school_id'=>$school_id));

			$this->operation->table_name ="student_semesters";
			$is_student_found = $this->operation->GetByWhere(array('student_id'=>$is_user_created));
			if(count($is_student_found)){
				$studentarray = array(
					'student_id'=>$is_user_created,
					'semester_id'=>$semester,
					'class_id'=>$sgrade1,
					'section_id'=>$sgrade,
					'status'=>'r',
					'session_id'=>$active_session[0]->id,
				);
				$is_student_created = $this->operation->Create($studentarray,$is_student_found[0]->id);
			}


			return $is_user_created;
		}

		else if($id == null){
			//$temppassword = $this->randomPassword();
			$registrationid = $this->getLastStudentId();
			$regid = '';

			if($registrationid == false)
			{
				$regid = $locations[0]['shortname']."-001";
			}
			else{
				$registrationid = end(explode('-', $registrationid));
				$registrationid++;
				$roll = str_pad($registrationid, 3, "0", STR_PAD_LEFT);
				$regid = $locations[0]['shortname'].'-'.$roll;
			}

			$this->user->table_name ="invantage_users";
			$userarray = array(
				'username'=>$regid,
				'screenname'=>$sname,
				'email'=>'',
				'password'=>md5($regid),
				'registerdate'=>date("Y-m-d H:i:s"),
				'last_update'=>date("Y-m-d H:i:s"),
				'user_status'=>'a',
				'type'=>'s',
				'nic'=>trim($snic),
				'slug'=>time(),
				'profile_image'=>( '' ),
			);

			$is_user_created = $this->user->save($userarray);
			
			$this->user->table_name = 'user_roles';
			$user_role = array(
				'role_id'=>5,
				'user_id'=>$is_user_created,
			);

			$role_created = $this->user->save($user_role);

			$this->user->table_name = 'user_locations';
			

			$user_locations = array(
				'school_id'=>$school_id,
				'user_id'=>$is_user_created
			);

			$user_locations = $this->user->save($user_locations);


			$this->user->table_name ="sessions";
			$active_session = $this->user->GetByWhere(array('status'=>'a','school_id'=>$school_id));

			  

		    $this->user->table_name = 'semester_dates';
		    $active_semester = $this->user->GetByWhere(array('session_id'=>$active_session[0]->id,'status'=>'a'));



			$this->user->table_name ="student_semesters";
	
			$studentarray = array(
				'student_id'=>$is_user_created,
				'semester_id'=>$active_semester[0]->semester_id,
				'class_id'=>$sgrade,
				'section_id'=>$sgrade1,
				'status'=>'r',
				'session_id'=>$active_session[0]->id,
			);
			$is_student_created = $this->user->save($studentarray);


			$this->user->table_name="studentsession";



			if ($is_user_created) {
				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'roll_number',
					'meta_value'=>$regid,
				);
				$this->user->table_name = 'user_meta';
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'sfullname',
					'meta_value'=>$sname,
				);
				$this->user->table_name = 'user_meta';
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'slastname',
					'meta_value'=>$slastname,
				);
				$this->user->table_name = 'user_meta';
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'saddress',
					'meta_value'=>$saddress,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'shunit',
					'meta_value'=>$shunit,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'scity',
					'meta_value'=>$scity,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'sprovice',
					'meta_value'=>$sprovice,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'spcode',
					'meta_value'=>$spcode,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'sphone',
					'meta_value'=>$sphone,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'semail',
					'meta_value'=>$semail,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'sdateav',
					'meta_value'=>$sdateav,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'snic',
					'meta_value'=>$snic,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'saddlang',
					'meta_value'=>$saddlang,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'sgrade',
					'meta_value'=>$sgrade,
				);

				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'father_name',
					'meta_value'=>$sfname,
				);
				$this->user->save($userarray);


				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'father_nic',
					'meta_value'=>$sfnic,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'father_profession',
					'meta_value'=>$sfpro,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'father_years',
					'meta_value'=>$sfyear,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'father_company',
					'meta_value'=>$sfcompany,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'father_comapny_years',
					'meta_value'=>$sfcyears,
				);
				$this->user->save($userarray);

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'monthly_income',
					'meta_value'=>$sfmincome,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'father_work_address',
					'meta_value'=>$sfwaddress,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'father_monthly_income_2',
					'meta_value'=>$sfmincome2,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'financial_assistance',
					'meta_value'=>$srassitance,
				);
				$this->user->save($userarray);
				
				$userarray = array(
				    'user_id'=>$is_user_created,
				    'meta_key'=>'mode',
				    'meta_value'=>$mode,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'circumstances',
					'meta_value'=>$scir,
				);
				$this->user->save($userarray);


				/* Student education form
				 */

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'previous_school_1',
					'meta_value'=>$spreviousshool,
				);
				$this->user->save($userarray);

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'school_history_address_1',
					'meta_value'=>$spradress,
				);
				$this->user->save($userarray);

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'from_1',
					'meta_value'=>$sfrom,
				);
				$this->user->save($userarray);

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'to_1',
					'meta_value'=>$sto,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'previous_school_2',
					'meta_value'=>$spreviousshool2,
				);
				$this->user->save($userarray);

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'school_history_address_2',
					'meta_value'=>$spradress2,
				);
				$this->user->save($userarray);

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'from_2',
					'meta_value'=>$sfrom2,
				);
				$this->user->save($userarray);

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'to_2',
					'meta_value'=>$sto2,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'previous_school_3',
					'meta_value'=>$spreviousshool3,
				);
				$this->user->save($userarray);

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'school_history_address_3',
					'meta_value'=>$spradress3,
				);
				$this->user->save($userarray);

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'from_3',
					'meta_value'=>$sfrom3,
				);
				$this->user->save($userarray);

					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'to_3',
					'meta_value'=>$sto3,
				);
				$this->user->save($userarray);


				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_fullname',
					'meta_value'=>$srfulname,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_relationship',
					'meta_value'=>$srrelationship,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_refernce_company',
					'meta_value'=>$srcmpny,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_phone',
					'meta_value'=>$srphone,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_adress',
					'meta_value'=>$sradress,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_fullname2',
					'meta_value'=>$srfulname2,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_relationship2',
					'meta_value'=>$srrelationship2,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_refernce_company2',
					'meta_value'=>$srcmpny2,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_phone2',
					'meta_value'=>$srphone2,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_adress2',
					'meta_value'=>$sradress2,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_fullname3',
					'meta_value'=>$srfulname3,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_relationship3',
					'meta_value'=>$srrelationship3,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_refernce_company3',
					'meta_value'=>$srcmpny3,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_phone3',
					'meta_value'=>$srphone3,
				);
				$this->user->save($userarray);


					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_reference_adress3',
					'meta_value'=>$sradress3,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_signature',
					'meta_value'=>$ssignature,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'student_submate_date',
					'meta_value'=>$ssubmitdate,
				);
				$this->user->save($userarray);
				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'sdob',
					'meta_value'=>$sdob,
				);
				$this->user->save($userarray);
					$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'$smthrlng',
					'meta_value'=>$smthrlng,
				);
				$this->user->save($userarray);


				return $is_user_created;
			}
		}
		else{
			return false;
		}

	}
	catch(Exception $e)
	{
		return $e->getMessage();
	}
	
}

	function randomPassword() {
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 5; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}


   	/**
     * Device based signup
     */
  public function DeviceInfo($id, $install_id, $man, $model, $school_id, $semester_id, $class_id, $mode,$password)
  {
  	try{
		
		$is_user_created = false;
		$screen_name = '';

		$man = ucfirst($man);

		// Trim Manufacturer from Model
		$parts = explode(' ', $model);
		if(count($parts)>1 && strtolower($man) == strtolower($parts[0])){
		    $model = trim(substr($model, strlen($man)));
		}

		if(!empty($install_id)){
			if(strlen($install_id)>8){
				$screen_name = $man . ' ' . substr($install_id, 0, 8);
			}else{
				$screen_name = $man . ' ' . $install_id;
			}
		}else{
			$screen_name = $man . ' ' . $model;
		}
		
		if($id != null)
		{



			$this->user->table_name ="invantage_users";
			$this->user->primary_key = 'id';
			$userarray = array(
				'screenname'=>$screen_name,
			);

			if(!empty($password)){
				$userarray['password'] = $password;
			}

			$is_user_created = $this->user->save($userarray,$id);

			$this->user->table_name = 'user_locations';
			$this->user->primary_key = 'user_id';
			
			$user_locations = array(
				'school_id'=>$school_id
			);

			$user_locations = $this->user->save($user_locations,$is_user_created);

			$this->user->table_name = 'user_meta';
			$this->update_meta($is_user_created,'sfullname',$man);
			$this->update_meta($is_user_created,'slastname',$model);
			
			$this->operation->table_name ="sessions";
			$active_session = $this->operation->GetByWhere(array('status'=>'a','school_id'=>$school_id));

			$this->operation->table_name ="student_semesters";
			$is_student_found = $this->operation->GetByWhere(array('student_id'=>$is_user_created));

			if(count($is_student_found)){
				$studentarray = array(
					'student_id'=>$is_user_created,
					'semester_id'=>$semester_id,
					'class_id'=>$class_id,
					'section_id'=>1,
					'status'=>'r',
					'session_id'=>$active_session[0]->id,
				);
				$is_student_created = $this->operation->Create($studentarray,$is_student_found[0]->id);
			}
		}

		else if(empty($id)){

			$this->user->table_name ="invantage_users";
			$userarray = array(
				'username'=>$install_id,
				'screenname'=>$screen_name,
				'email'=>date("Y-m-d H:i:s"),
				'password'=>$password,
				'registerdate'=>date("Y-m-d H:i:s"),
				'last_update'=>date("Y-m-d H:i:s"),
				'user_status'=>'a',
				'type'=>'s',
				'nic'=>'',
				'slug'=>time(),
				'profile_image'=>'',
			);

			$is_user_created = $this->user->save($userarray);
			
			$this->user->table_name = 'user_roles';
			$user_role = array(
				'role_id'=>5,
				'user_id'=>$is_user_created,
			);

			$role_created = $this->user->save($user_role);

			$this->user->table_name = 'user_locations';
			

			$user_locations = array(
				'school_id'=>$school_id,
				'user_id'=>$is_user_created
			);

			$user_locations = $this->user->save($user_locations);


			$this->user->table_name ="sessions";
			$active_session = $this->user->GetByWhere(array('status'=>'a','school_id'=>$school_id));

			  

		    $this->user->table_name = 'semester_dates';
		    $active_semester = $this->user->GetByWhere(array('session_id'=>$active_session[0]->id,'status'=>'a'));



			$this->user->table_name ="student_semesters";
	
			$studentarray = array(
				'student_id'=>$is_user_created,
				'semester_id'=>$active_semester[0]->semester_id,
				'class_id'=>$class_id,
				'section_id'=>1,
				'status'=>'r',
				'session_id'=>$active_session[0]->id,
			);
			$is_student_created = $this->user->save($studentarray);

			if ($is_user_created) {

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'sfullname',
					'meta_value'=>$man,
				);
				$this->user->table_name = 'user_meta';
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'slastname',
					'meta_value'=>$model,
				);
				$this->user->table_name = 'user_meta';
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'roll_number',
					'meta_value'=>$install_id,
				);
				$this->user->table_name = 'user_meta';
				$this->user->save($userarray);
			}
		}
		
		return $is_user_created;

		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}


/*
            Teacher signup form start

*/

               /*
    * Get dublicate TEACHER  NIC#
    */
  /*
     * Show message to teacher
     */
    function getLastTeacherId(){
		$this->user->table_name ="user_meta";
    	$user = $this->user->get_by_query("Select inuser.*,um.meta_value from invantage_users inuser INNER JOIN user_meta um ON um.user_id =inuser.id where inuser.type = 's' AND um.meta_key = 'roll_number'  order by inuser.id desc limit 1");

    	if(count($user)){
    		return $user[0]->meta_value;
    	}
    	else{
    		return false;
    	}
    }



    public function getDublicateNIC($nic){
    	$this->user->table_name ="invantage_users";
    	$user = $this->user->get_by_query("Select nic from ".$this->user->table_name." where nic = '".$nic."'");
    	$check = FALSE;
    	if(count($user) == true):
    		$check = TRUE;
    	endif;
    	return $check;
    }

    function update_meta($user_id,$meta_key,$meta_value)
    {
        $this->user->table_name = 'user_meta';
        $this->user->primary_key = "id";
        
        $result = $this->user->get_by_query("SELECT id FROM user_meta WHERE meta_key='{$meta_key}' AND user_id={$user_id}");
        
        if(count($result)){
            
            $userarray = array(
                
                'meta_key'=>$meta_key,
                'meta_value'=>$meta_value,
                'user_id'=> $user_id,
            );
            $this->user->save($userarray, $result[0]->id);
            
        }else{
            
            $userarray = array(
                
                'meta_key'=>$meta_key,
                'meta_value'=>$meta_value,
                'user_id'=>$user_id
            );
            
            $this->user->save($userarray);
        }
        
    	
    }

    function finduseimage($id)
    {
    	$this->user->table_name ="invantage_users";
    	return $this->user->get_by_query("Select profile_image from ".$this->user->table_name." where id = ".$id);

    }

  	public function TeacherInfo($id, $school_id, $tfname, $tsname, $tgndr, $tnic, $temail, $tphone, $tnpswrd, $tprhmadrss, $tsechmadress, $tprovince, $tcity, $tzipcode, $tMaster){

  	    
		if($id != null)
		{

			$this->user->table_name ="invantage_users";
			$this->user->primary_key = 'id';
			//$is_user_already_exist = $this->finduseimage($id);

			$userarray = array(
				'screenname'=>$tfname." ".$tsname,
				'nic'=>trim($tnic),
				'email'=>$temail,
				'location'=>$school_id,
				'is_master_teacher'=>($tMaster == 1 ? 1:0),
				//'profile_image'=> UPLOAD_PATH.'profile/'.$is_user_already_exist[0]->profile_image )

			);
			
			if(null!=$tnpswrd && !empty($tnpswrd)){
			    
			    $userarray['password']=md5($tnpswrd);
			    
			}
		
			$is_user_created = $this->user->save($userarray,$id);
		
			$this->user->table_name = 'user_locations';
			$this->user->primary_key = 'user_id';
			$user_locations = array(
				'school_id'=>$school_id,
			);

			$user_locations = $this->user->save($user_locations,$is_user_created);

			$this->user->table_name = 'user_meta';
			$this->update_meta($is_user_created,'teacher_firstname',$tfname);
			$this->update_meta($is_user_created,'teacher_lastname',$tsname);
			$this->update_meta($is_user_created,'teacher_gender',$tgndr);
			$this->update_meta($is_user_created,'teacher_nic',$tnic);
			$this->update_meta($is_user_created,'email',$temail);
			$this->update_meta($is_user_created,'teacher_phone',$tphone);
			$this->update_meta($is_user_created,'teacher_primary_address',$tprhmadrss);
			$this->update_meta($is_user_created,'teacher_secondry_adress',$tsechmadress);
			$this->update_meta($is_user_created,'teacher_province',$tprovince);
			$this->update_meta($is_user_created,'teacher_city',$tcity);
			$this->update_meta($is_user_created,'teacher_zipcode',$tzipcode);
			$this->update_meta($is_user_created,'location',$school_id);
			return $is_user_created;

		}

		if($id == null && $this->getDuplicate($tnic) != true){
			$username = explode('@', $temail);

			$this->user->table_name ="invantage_users";
			

			$userarray = array(
				'username'=>$username[0],
				'screenname'=>$tfname." ".$tsname,
				'email'=>$temail,
				'location'=>$school_id,
				'is_master_teacher'=>($tMaster == 1 ? 1:0),
				'password'=>md5($tnpswrd),
				'registerdate'=>date("Y-m-d H:i:s"),
				'last_update'=>date("Y-m-d H:i"),
				'user_status'=>'a',
				'type'=>'t',
				'nic'=>trim($tnic),
				'slug'=>time(),
				//'profile_image'=>($this->session->userdata('laststudentimgid') != '' ? UPLOAD_PATH.'profile/'.$this->session->userdata('laststudentimgid') : '' )

			);

			$is_user_created = $this->user->save($userarray);
        
			$this->user->table_name = 'user_roles';
			$user_role = array(
				'role_id'=>4,
				'user_id'=>$is_user_created,
			);

			$role_created = $this->user->save($user_role);

			$this->user->table_name = 'user_locations';
			$user_locations = array(
				'school_id'=>$school_id,
				'user_id'=>$is_user_created,
			);

			$user_locations = $this->user->save($user_locations);

			if ($is_user_created) {

				$this->user->table_name = 'user_meta';

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_firstname',
					'meta_value'=>$tfname,
				);

				$this->user->save($userarray);


				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_lastname',
					'meta_value'=>$tsname,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_gender',
					'meta_value'=>$tgndr,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_nic',
					'meta_value'=>$tnic,
				);
				$this->user->save($userarray);
				
				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_phone',
					'meta_value'=>$tphone,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_password',
					'meta_value'=>$tnpswrd,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_primary_address',
					'meta_value'=>$tprhmadrss,
				);
				$this->user->save($userarray);


				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_secondry_adress',
					'meta_value'=>$tsechmadress,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_province',
					'meta_value'=>$tprovince,
				);
				$this->user->save($userarray);
				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_city',
					'meta_value'=>$tcity,
				);
				$this->user->save($userarray);



				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_zipcode',
					'meta_value'=>$tzipcode,
				);
				$this->user->save($userarray);



				return $is_user_created;
			}
		}
		else{
			return false;
		}
	}

  	public function PricpalInfo($id = null,$tfname = null,$tsname = null,$tgndr=null,$tnic=null,$temail=null,$tphone=null,$tnpswrd=null,$tprhmadrss=null,$tsechmadress=null,$tprovince=null,$tcity=null,$tzipcode=null,$tLocation=null,$image){
		$value = FALSE;
		$today = date("Y-m-d");
		$year = date("Y");

		if($id != null)
		{
			$this->user->table_name ="invantage_users";
			$this->user->primary_key = 'id';
			$userarray = array(
				'screenname'=>$tfname." ".$tsname,
				'nic'=>trim($tnic),
				'location'=>$tLocation,
				'email'=>$temail,
				'profile_image'=>$image

			);

			$is_user_created = $this->user->save($userarray,$id);

			$this->user->table_name = 'user_locations';
			$this->user->primary_key = 'user_id';
			$user_locations = array(
				'school_id'=>$tLocation,
			);

			$user_locations = $this->user->save($user_locations,$is_user_created);

			$this->user->table_name = 'user_meta';
			$this->update_meta($id,'principal_firstname',htmlentities(stripslashes(($tfname))));
			$this->update_meta($id,'principal_lastname',htmlentities(stripslashes(($tsname))));
			$this->update_meta($id,'principal_gender',$tgndr);
			$this->update_meta($id,'principal_nic',$tnic);
			$this->update_meta($id,'principal_religion',$religion);
			$this->update_meta($id,'principal_phone',$tphone);
			$this->update_meta($id,'principal_primary_address',htmlentities(stripslashes(($tprhmadrss))));
			$this->update_meta($id,'principal_secondry_adress',htmlentities(stripslashes(($tsechmadress))));
			$this->update_meta($id,'principal_province',$tprovince);
			$this->update_meta($id,'principal_city',htmlentities(stripslashes(($tcity))));
			$this->update_meta($id,'principal_zipcode',$tzipcode);
			$this->update_meta($id,'location',$tLocation);

			return $is_user_created;


		}

		if($this->getDuplicate($tnic) != true){
			$username = explode('@', $temail);

			$this->user->table_name ="invantage_users";
			$userarray = array(
				'username'=>$username[0],
				'screenname'=>$tfname." ".$tsname,
				'email'=>$temail,
				'location'=>$tLocation,
				'password'=>md5($tnpswrd),
				'registerdate'=>date("Y-m-d H:i:s"),
				'last_update'=>date("Y-m-d H:i"),
				'user_status'=>'a',
				'type'=>'p',
				'nic'=>trim($tnic),
				'profile_image'=>$image

			);

			$is_user_created = $this->user->save($userarray);

			$this->user->table_name = 'user_roles';
			$user_role = array(
				'role_id'=>3,
				'user_id'=>$is_user_created,
			);

			$role_created = $this->user->save($user_role);

			$this->user->table_name = 'user_locations';
			$user_locations = array(
				'school_id'=>$tLocation,
				'user_id'=>$is_user_created,
			);

			$user_locations = $this->user->save($user_locations);

			if ($is_user_created) {

				$this->user->table_name = 'user_meta';

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_firstname',
					'meta_value'=>$tfname,
				);

				$this->user->save($userarray);


				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_lastname',
					'meta_value'=>$tsname,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_gender',
					'meta_value'=>$tgndr,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_nic',
					'meta_value'=>$tnic,
				);
				$this->user->save($userarray);
								$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_religion',
					'meta_value'=>$religion,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_phone',
					'meta_value'=>$tphone,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_password',
					'meta_value'=>$tnpswrd,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_primary_address',
					'meta_value'=>$tprhmadrss,
				);
				$this->user->save($userarray);


				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_secondry_adress',
					'meta_value'=>$tsechmadress,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_province',
					'meta_value'=>$tprovince,
				);
				$this->user->save($userarray);
				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_city',
					'meta_value'=>$tcity,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'principal_zipcode',
					'meta_value'=>$tzipcode,
				);
				$this->user->save($userarray);



				return $is_user_created;
			}
		}
		else{
			return false;
		}
	}

  	public function ParentsInfo($id = null,$tfname = null,$tsname = null,$tgndr=null,$tnic=null,$religion=null,$temail=null,$tphone=null,$tnpswrd=null,$tprhmadrss=null,$tsechmadress=null,$tprovince=null,$tcity=null,$tzipcode=null,$tLocation=null){
		$value = FALSE;
		$today = date("Y-m-d");
		$year = date("Y");

		if($id != null)
		{
			$this->user->table_name ="invantage_users";
			$this->user->primary_key = 'id';
			$userarray = array(
				'screenname'=>$tfname." ".$tsname,
				'nic'=>trim($tnic),
				'location'=>$tLocation,
				'email'=>$temail,
				'profile_image'=>($this->session->userdata('laststudentimgid') != '' ? $this->session->userdata('laststudentimgid') : '' )

			);

			$is_user_created = $this->user->save($userarray,$id);

			$this->user->table_name = 'user_meta';
			$this->update_meta($is_user_created,'teacher_firstname',$tfname);
			$this->update_meta($is_user_created,'teacher_lastname',$tsname);
			$this->update_meta($is_user_created,'teacher_gender',$tgndr);
			$this->update_meta($is_user_created,'teacher_nic',$tnic);
			$this->update_meta($is_user_created,'teacher_religion',$religion);
			$this->update_meta($is_user_created,'email',$temail);
			$this->update_meta($is_user_created,'teacher_phone',$tphone);
			$this->update_meta($is_user_created,'teacher_primary_address',$tprhmadrss);
			$this->update_meta($is_user_created,'teacher_secondry_adress',$tsechmadress);
			$this->update_meta($is_user_created,'teacher_province',$tprovince);
			$this->update_meta($is_user_created,'teacher_city',$tcity);
			$this->update_meta($is_user_created,'teacher_zipcode',$tzipcode);
			$this->update_meta($is_user_created,'location',$tLocation);

			return $is_user_created;


		}

		if($this->getDuplicate($tnic) != true){
			$username = explode('@', $temail);

			$this->user->table_name ="invantage_users";
			$userarray = array(
				'username'=>$username[0],
				'screenname'=>$tfname." ".$tsname,
				'email'=>$temail,
				'location'=>$tLocation,
				'password'=>md5($tnpswrd),
				'registerdate'=>date("Y-m-d H:i:s"),
				'last_update'=>date("Y-m-d H:i"),
				'user_status'=>'a',
				'type'=>'pr',
				'nic'=>trim($tnic),
				'profile_image'=>($this->session->userdata('laststudentimgid') != '' ? $this->session->userdata('laststudentimgid') : '' )

			);

			$is_user_created = $this->user->save($userarray);
			if ($is_user_created) {

				$this->user->table_name = 'user_meta';

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_firstname',
					'meta_value'=>$tfname,
				);

				$this->user->save($userarray);


				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_lastname',
					'meta_value'=>$tsname,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_gender',
					'meta_value'=>$tgndr,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_nic',
					'meta_value'=>$tnic,
				);
				$this->user->save($userarray);
								$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_religion',
					'meta_value'=>$religion,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_phone',
					'meta_value'=>$tphone,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_password',
					'meta_value'=>$tnpswrd,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_primary_address',
					'meta_value'=>$tprhmadrss,
				);
				$this->user->save($userarray);


				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_secondry_adress',
					'meta_value'=>$tsechmadress,
				);
				$this->user->save($userarray);

				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_province',
					'meta_value'=>$tprovince,
				);
				$this->user->save($userarray);
				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_city',
					'meta_value'=>$tcity,
				);
				$this->user->save($userarray);



				$userarray = array(
					'user_id'=>$is_user_created,
					'meta_key'=>'teacher_zipcode',
					'meta_value'=>$tzipcode,
				);
				$this->user->save($userarray);



				return $is_user_created;
			}
		}
		else{
			return false;
		}
	}

	public function getLessonStatus($id,$value)
	{
		return $status=$this->db->query("Update lesson_read set status='".$value."' WHERE lesson_id={$id} ");

	}

	public function insertCSV($data)
            {
                $this->db->insert('defaultlessonplan', $data);

                return $this->db->insert_id();
            }


 }

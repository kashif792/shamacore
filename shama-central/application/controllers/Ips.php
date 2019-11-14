<?php

/**
 * Invantage Controller
 *
 * This class responsible for inventage.
 */
class Ips extends MY_Controller
{
	/**
 	 * @var array
 	 */
	var $data = array();

	function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Karachi");

	}

	function isUserLoginOrNot(){
		return true;
	/*
		if($this->uri->segment(1) != 'signin'){
			if(!($this->session->userdata('id'))){
				parent::redirectUrl('signin');
			}
		}

        $this->data['session_id'] = $this->session->userdata('default_session_id');
        $this->data['school_id'] = $this->session->userdata('default_school_id');
        $this->data['user_id'] = $this->session->userdata('id');
		*/
	}


	// ----------------------------------------------------------------------

	/**
	 *
	 * IPS section
	 * Modules list
	 *  1: index() This function load dashboard view.
	 *	2: saveNewUser() This function save user.
	 *	3: unautohrizeaccess() This function redirect the user on 404 page.
	 *	4: profile() This function load setting view.
	 *	5: settings() This function save user profile info.
	 *	6: searchitem() This function used to search reports.
	 *	7: saveStore() This function used to save stores.
  	 *  9: signin() This function load login view.
	 *	10: authenticate() This function authenticate user.
	 *	11: passChange() This function load change password view.
	 *	12: forgotPassword() This function used for forgot password.
	 *	13: signout() This function singout the user.
	 */

	/**
	 * Load controll dashboard
	 *
	 * @access private
	 * @load view
	 */
	function controllindex(){

		$this->load->view('ci/controll',$this->data);

	}

/**
	 * Load settings
	 *
	 * @access private
	 * @load Parent view
	 */
	function saveParent()
	{
		if(!($this->session->userdata('id'))){

				parent::redirectUrl('signin');

			}

		if($this->uri->segment(2) AND $this->uri->segment(2) != "page" ){
			$getUserInfo = $this->operation->GetRowsByQyery("Select * from users where row_slug= ".$this->uri->segment(2));
			$this->data['getUserInfo'] = $getUserInfo;
			$user_rights = $this->operation->GetRowsByQyery("SELECT * FROM roles INNER JOIN user_roles ON user_roles.role_id = roles.id WHERE user_roles.user_id =".$getUserInfo[0]->uid);
			$i = 1;
			$ur = array();
			foreach ($user_rights as $key => $value) {
				$ur[] = $value->role_id;
			}
			$this->data['user_rights'] = $ur;

			$this->operation->table_name = 'store_users';
			$requestedUser = $this->operation->GetByWhere(array('user_id'=>$getUserInfo[0]->uid));
			$this->data['userStore'] = $requestedUser;
		}
		$this->data['roles'] = $this->operation->GetRowsByQyery("SELECT * FROM roles WHERE id != 7 ");
		$this->load->view('principal/add_parent',$this->data);
	}


/**
	 * Load settings
	 *
	 * @access private
	 * @load Teacher view
	 */
	function saveTeacher()
	{
		Ips::isUserLoginOrNot();
		if($this->uri->segment(2) AND $this->uri->segment(2) != "page" ){
			$getUserInfo = $this->operation->GetRowsByQyery("Select * from users where row_slug= ".$this->uri->segment(2));
			$this->data['getUserInfo'] = $getUserInfo;
			$user_rights = $this->operation->GetRowsByQyery("SELECT * FROM roles INNER JOIN user_roles ON user_roles.role_id = roles.id WHERE user_roles.user_id =".$getUserInfo[0]->uid);
			$i = 1;
			$ur = array();
			foreach ($user_rights as $key => $value) {
				$ur[] = $value->role_id;
			}
			$this->data['user_rights'] = $ur;

			$this->operation->table_name = 'store_users';
			$requestedUser = $this->operation->GetByWhere(array('user_id'=>$getUserInfo[0]->uid));
			$this->data['userStore'] = $requestedUser;
		}
		$this->data['roles'] = $this->operation->GetRowsByQyery("SELECT * FROM roles WHERE id != 7 ");
		$this->load->view('principal/add_teacher',$this->data);
	}

	/**
	 * Unauthorized access
	 *
	 * @access private
	 */
	function unautohrizeaccess()
	{
		$this->load->view('unfound/unfound',$this->data);
	}

	/**
	 * load profile
	 *
	 * @access private
	 * @load view
	 */
	function  profile()
	{
		$this->load->view('settings/profile');
	}

	function  profile2()
	{
		Ips::isUserLoginOrNot();
		// $this->operation->table_name = 'users';
		// $this->data['getUserInfo'] = $this->operation->GetByWhere(array('uid'=>$this->session->userdata('id')));
		// $this->data['users'] = $this->operation->GetRowsByQyery('SELECT u.uid,u.name,u.first_name,u.last_name,u.email,r.type,u.row_slug,ur.user_id,u.account,GROUP_CONCAT(r.type SEPARATOR " / ") AS roletype  from users u Inner join user_roles ur on ur.user_id = u.uid Inner join roles r on r.id = ur.role_id group by u.uid,ur.user_id order by u.uid desc ');
		// $this->data['roles_right'] = $this->operation->GetRowsByQyery("SELECT user_roles.user_id, user_roles.role_id, user_roles.id, role_rights. * FROM (`user_roles`) INNER JOIN  `role_rights` ON  `role_rights`.`role_id` =  `user_roles`.`role_id` WHERE role_rights.description LIKE  '%_settings' AND  `user_roles`.user_id =". $this->session->userdata('id'));
		$roles = $this->session->userdata('roles');

		if ($roles[0]['role_id'] ==4) {
			$is_teacher_found = $this->operation->GetRowsByQyery("Select inuser.* from invantageuser inuser where inuser.type = 't'  AND id = ".$this->session->userdata('id'));
			if(count($is_teacher_found)){
				$result['message'] = true;
				foreach ($is_teacher_found as $key => $value) {
					$this->data['teacher_id'] = $value->id;
					$this->data['teacher_firstname'] = (parent::getUserMeta($value->id,'teacher_firstname') != false ? parent::getUserMeta($value->id,'teacher_firstname') : '');

					$this->data['teacher_lastname'] = (parent::getUserMeta($value->id,'teacher_lastname') != false ? parent::getUserMeta($value->id,'teacher_lastname') : '');
					$this->data['email_get'] = $value->email;
					$this->data['profile_link'] = $value->profile_image;
				//	$this->data['location'] = $value->location;
					$this->data['teacher_religion'] = (parent::getUserMeta($value->id,'teacher_religion') != false ? parent::getUserMeta($value->id,'teacher_religion') : '');

					$this->data['gender'] = (parent::getUserMeta($value->id,'teacher_gender') != false ? parent::getUserMeta($value->id,'teacher_gender') : 'Male');
					$this->data['nic'] = (parent::getUserMeta($value->id,'teacher_nic') != false ? parent::getUserMeta($value->id,'teacher_nic') : '');
					$this->data['phone'] = (parent::getUserMeta($value->id,'teacher_phone') != false ? parent::getUserMeta($value->id,'teacher_phone') : '');
					$this->data['primary_address'] = (parent::getUserMeta($value->id,'teacher_primary_address') != false ? parent::getUserMeta($value->id,'teacher_primary_address') : '');
					$this->data['secondary_address'] = (parent::getUserMeta($value->id,'teacher_secondry_adress') != false ? parent::getUserMeta($value->id,'teacher_secondry_adress') : '');
					$this->data['city'] = (parent::getUserMeta($value->id,'teacher_city') != false ? parent::getUserMeta($value->id,'teacher_city') : '');
					$this->data['province'] = (parent::getUserMeta($value->id,'teacher_province') != false ? parent::getUserMeta($value->id,'teacher_province') : '');
					$this->data['teacher_zipcode'] = (parent::getUserMeta($value->id,'teacher_zipcode') != false ? parent::getUserMeta($value->id,'teacher_zipcode') : '');
					$this->data['email'] = (parent::getUserMeta($value->id,'email') != false ? parent::getUserMeta($value->id,'email') : '');

				}
			}
		}

		if ($roles[0]['role_id'] ==3) {
			$is_teacher_found = $this->operation->GetRowsByQyery("Select inuser.* from invantageuser inuser where inuser.type = 'p'  AND id = ".$this->session->userdata('id'));

			if(count($is_teacher_found)){
				$result['message'] = true;
				foreach ($is_teacher_found as $key => $value) {
						$this->data['teacher_id'] = $value->id;
					$this->data['teacher_firstname'] = (parent::getUserMeta($value->id,'principal_firstname') != false ? parent::getUserMeta($value->id,'principal_firstname') : '');

					$this->data['teacher_lastname'] = (parent::getUserMeta($value->id,'principal_lastname') != false ? parent::getUserMeta($value->id,'principal_lastname') : '');
					$this->data['email_get'] = $value->email;
					$this->data['profile_link'] = $value->profile_image;
					$this->data['teacher_religion'] = (parent::getUserMeta($value->id,'teacher_religion') != false ? parent::getUserMeta($value->id,'teacher_religion') : '');

					$this->data['gender'] = (parent::getUserMeta($value->id,'principal_gender') != false ? parent::getUserMeta($value->id,'principal_gender') : 'Male');
					$this->data['nic'] = (parent::getUserMeta($value->id,'teacher_nic') != false ? parent::getUserMeta($value->id,'teacher_nic') : '');
					$this->data['phone'] = (parent::getUserMeta($value->id,'principal_phone') != false ? parent::getUserMeta($value->id,'principal_phone') : '');
					$this->data['primary_address'] = (parent::getUserMeta($value->id,'principal_primary_address') != false ? parent::getUserMeta($value->id,'principal_primary_address') : '');
					$this->data['secondary_address'] = (parent::getUserMeta($value->id,'principal_secondry_adress') != false ? parent::getUserMeta($value->id,'principal_secondry_adress') : '');
					$this->data['city'] = (parent::getUserMeta($value->id,'principal_city') != false ? parent::getUserMeta($value->id,'principal_city') : '');
					$this->data['province'] = (parent::getUserMeta($value->id,'principal_province') != false ? parent::getUserMeta($value->id,'principal_province') : '');
					$this->data['teacher_zipcode'] = (parent::getUserMeta($value->id,'principal_zipcode') != false ? parent::getUserMeta($value->id,'principal_zipcode') : '');
					$this->data['email'] = (parent::getUserMeta($value->id,'principal_email') != false ? parent::getUserMeta($value->id,'principal_email') : '');

				}
			}
		}
		if ($roles[0]['role_id'] ==1) {
			$is_teacher_found = $this->operation->GetRowsByQyery("Select inuser.* from invantageuser inuser where  id = ".$this->session->userdata('id'));

			if(count($is_teacher_found)){
				$result['message'] = true;
				foreach ($is_teacher_found as $key => $value) {
						$this->data['teacher_id'] = $value->id;
					$this->data['teacher_firstname'] = (parent::getUserMeta($value->id,'admin_firstname') != false ? parent::getUserMeta($value->id,'admin_firstname') : '');

					$this->data['teacher_lastname'] = (parent::getUserMeta($value->id,'admin_lastname') != false ? parent::getUserMeta($value->id,'admin_lastname') : '');
					$this->data['email_get'] = $value->email;
					$this->data['profile_link'] = $value->profile_image;
					$this->data['teacher_religion'] = (parent::getUserMeta($value->id,'teacher_religion') != false ? parent::getUserMeta($value->id,'teacher_religion') : '');

					$this->data['gender'] = (parent::getUserMeta($value->id,'admin_gender') != false ? parent::getUserMeta($value->id,'admin_gender') : 'Male');
					$this->data['nic'] = (parent::getUserMeta($value->id,'teacher_nic') != false ? parent::getUserMeta($value->id,'teacher_nic') : '');
					$this->data['phone'] = (parent::getUserMeta($value->id,'admin_phone') != false ? parent::getUserMeta($value->id,'admin_phone') : '');
					$this->data['primary_address'] = (parent::getUserMeta($value->id,'admin_home_primary') != false ? parent::getUserMeta($value->id,'admin_home_primary') : '');
					$this->data['secondary_address'] = (parent::getUserMeta($value->id,'admin_home_secondary') != false ? parent::getUserMeta($value->id,'admin_home_secondary') : '');
					$this->data['city'] = (parent::getUserMeta($value->id,'admin_home_city') != false ? parent::getUserMeta($value->id,'admin_home_city') : '');
					$this->data['province'] = (parent::getUserMeta($value->id,'admin_home_state') != false ? parent::getUserMeta($value->id,'admin_home_state') : '');
					$this->data['teacher_zipcode'] = (parent::getUserMeta($value->id,'admin_home_zipcode') != false ? parent::getUserMeta($value->id,'admin_home_zipcode') : '');
					$this->data['email'] = (parent::getUserMeta($value->id,'principal_email') != false ? parent::getUserMeta($value->id,'principal_email') : '');

				}
			}
		}

		$this->load->view('settings/profile',$this->data);
	}

	/**
	 * load settings
	 *
	 * @access private
	 * @load view
	 */
	function settings()
	{
		$this->load->view('settings/savesettings',$this->data);
	}


	/**
	 * Save user profile
	 *
	 * @access private
	 */
	function saveProfileInfo()
	{

		$this->form_validation->set_rules('inputFirstName', 'Valid First Name Required', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('inputLastName', 'Valid Last Name Required', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('inputEmail', 'Valid Email Required', 'trim|required|valid_email');
		$this->form_validation->set_rules('input_city', 'Valid City Name Required', 'trim|min_length[3]');
		$this->form_validation->set_rules('input_zipcode', 'Valid Postalcode Required', 'trim|min_length[1]');
		$this->form_validation->set_rules('input_pr_phone', 'Valid Phone Number Required', 'trim|min_length[6]');
		$this->form_validation->set_rules('input_t_gender', 'Valid Phone Number Required', 'trim|required');
		$this->form_validation->set_rules('pr_home', 'Valid Phone Number Required', 'trim|required');
		$this->form_validation->set_rules('sc_home', 'Valid Phone Number Required', 'trim');
		$this->form_validation->set_rules('inputProvice', 'Valid Phone Number Required', 'trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$result['message'] = false;
		}
		else{
			$phone = preg_replace('/\D/', '', $this->input->post('input_pr_phone'));

			$account = array(
					'email'=>htmlspecialchars($this->input->post('inputEmail'),ENT_QUOTES),
				);
			$this->user->table_name = 'invantageuser';

			$id = $this->user->Create($account,$this->session->userdata('id'));

			$roles = $this->session->userdata('roles');


			$this->user->table_name = 'user_meta';
			$this->user->primary_key = 'user_id';
			if ($roles[0]['role_id'] ==3) {
				$this->user->update_meta($this->session->userdata('id'),'principal_firstname',ucwords(htmlspecialchars(trim($this->input->post('inputFirstName')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'principal_lastname',ucwords(htmlspecialchars(trim($this->input->post('inputLastName')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'principal_gender',ucwords(htmlspecialchars(trim($this->input->post('input_t_gender')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'principal_phone',ucwords(htmlspecialchars(trim($this->input->post('input_pr_phone')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'principal_primary_address',ucwords(htmlspecialchars(trim($this->input->post('pr_home')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'principal_secondry_adress',ucwords(htmlspecialchars(trim($this->input->post('sc_home')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'principal_province',ucwords(htmlspecialchars(trim($this->input->post('inputProvice')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'principal_city',ucwords(htmlspecialchars(trim($this->input->post('input_city')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'principal_zipcode',ucwords(htmlspecialchars(trim($this->input->post('input_zipcode')),ENT_QUOTES)));

			$data['name'] = ucwords(htmlspecialchars(trim($this->input->post('inputFirstName')),ENT_QUOTES)).' '.ucwords(htmlspecialchars(trim($this->input->post('inputLastName')),ENT_QUOTES));
			$data['email'] = htmlspecialchars($this->input->post('inputEmail'));
			$this->session->set_userdata($data);

			}
			if ($roles[0]['role_id'] == 4) {
				$this->user->update_meta($this->session->userdata('id'),'teacher_firstname',ucwords(htmlspecialchars(trim($this->input->post('inputFirstName')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'teacher_lastname',ucwords(htmlspecialchars(trim($this->input->post('inputLastName')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'teacher_gender',ucwords(htmlspecialchars(trim($this->input->post('input_t_gender')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'teacher_nic',ucwords(htmlspecialchars(trim($this->input->post('inputTeacher_Nic')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'teacher_religion',ucwords(htmlspecialchars(trim($this->input->post('inputReligion')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'teacher_phone',ucwords(htmlspecialchars(trim($this->input->post('input_pr_phone')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'teacher_primary_address',ucwords(htmlspecialchars(trim($this->input->post('pr_home')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'teacher_secondry_adress',ucwords(htmlspecialchars(trim($this->input->post('sc_home')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'teacher_province',ucwords(htmlspecialchars(trim($this->input->post('inputProvice')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'teacher_city',ucwords(htmlspecialchars(trim($this->input->post('input_city')),ENT_QUOTES)));

			$this->user->update_meta($this->session->userdata('id'),'teacher_zipcode',ucwords(htmlspecialchars(trim($this->input->post('input_zipcode')),ENT_QUOTES)));
			
				$data['name'] = ucwords(htmlspecialchars(trim($this->input->post('inputFirstName')),ENT_QUOTES)).' '.ucwords(htmlspecialchars(trim($this->input->post('inputLastName')),ENT_QUOTES));
				$data['email'] = htmlspecialchars($this->input->post('inputEmail'));
				$this->session->set_userdata($data);
			}

			
			if(count($_FILES['profile_image']) && $_FILES['profile_image']['name'] != null)
			{
				$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
				if(strlen($_FILES['profile_image']['name']))
				{
					list($txt, $ext) = explode(".", strtolower($_FILES['profile_image']['name']));
					if(in_array(strtolower($ext),$valid_formats)){
						if ($_FILES['profile_image']["size"] < 5000000) {
							$title_image_name = time().$_FILES['profile_image']['name'];

								if(is_uploaded_file($_FILES['profile_image']['tmp_name'])){
									
		            				$path = UPLOAD_PATH."profile/"; 
									$file = time().trim(basename($_FILES['profile_image']['name']));
									$filename = $path.$file;
	 								$profileimage = array(
										'profile_image'=>base_url().'upload/profile/'.$file,
									);

									$this->operation->table_name = 'invantageuser';
									$this->operation->primary_key = 'id';
									$id = $this->operation->Create($profileimage,$this->session->userdata('id'));		
					 				if($id){
										if(is_uploaded_file($_FILES['profile_image']['tmp_name'])){     
											$biger_thumbnail = time().trim(basename($txt."_thumb.".$ext));
											$bigger_thumb_file = $path.$biger_thumbnail;
								 			if(move_uploaded_file($_FILES['profile_image']['tmp_name'],$filename)){
								 				chmod($filename, 0777);
												$this->load->library('image_lib');
												$data['profile_image'] = base_url().'upload/profile/'.$file;
												$this->session->set_userdata($data);
											    $config = array(
												    'image_library'    	=> 'gd2',
												    'source_image'      => $filename,
												    'new_image'         => $filename,
												    'create_thumb'    	=> true,
												    'maintain_ratio'    => true,
												    'quality' 			=> 100,
												    'width'             => 100,
												    'height'            => 100
											    );
										     	$this->image_lib->initialize($config);
										    	$this->image_lib->resize();
 
											    $config = array(
												    'image_library'    	=> 'gd2',
												    'source_image'      => $bigger_thumb_file,
												    'new_image'         => $bigger_thumb_file,
												    'create_thumb'    	=> true,
												    'maintain_ratio'    => true,
												    'quality' 			=> 100,
												    'width'             => 100,
												    'height'            => 100
											    );
											    //here is the second thumbnail, notice the call for the initialize() function again
											    $this->image_lib->initialize($config);
											    $this->image_lib->resize();
								 		
										 		$result['message'] = true;	
										 		$result['imagelink'] = base_url().'upload/profile/'.$biger_thumbnail;	
										 		$result['bigerlink'] = base_url().'upload/profile/'.$file;	
								 				
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

	/**
	 * Search module
	 *
	 * @access private
	 */
	function searchitem(){
		$result['message'] = false;
		if($this->session->userdata('userRole') == 1 || $this->session->userdata('userRole') == 2 || $this->session->userdata('userRole') == 3){
			$searchList = $this->operation->GetRowsByQyery("SELECT * FROM  report where report_name Like '%".$this->input->get('search')."%'");
		}

		if(count($searchList) > 0){
			$i = 1;
			foreach ($searchList as $key => $value) {
				if($this->session->userdata('userRole') == 3 ){
					if($value->report_name == 'Daily Sales Report' || $value->report_name == 'Cashier Report' ){
						$result['message'] = true;
						$result['sname'][$i] = $value->report_name;
						$result['link'][$i] = $value->link;
						$i++;
					}
				}
				else{
					$result['message'] = true;
					$result['sname'][$i] = $value->report_name;
					$result['link'][$i] = $value->link;
					$i++;
				}
			}
		}
		echo json_encode($result);
	}

	// ----------------------------------------------------------------------

	/**
	 *
	 * User authentication section
	 */

	/**
	 * Load sign in
	 *
	 * @access private
	 * @load view
	 */
	function signin(){

		parent::redirectUrl('login');
		
	}


	/**
	 * Authenticate user
	 *
	 * @access private
	 */
	function authenticate(){
		$result['message'] = false;
		$this->form_validation->set_rules('email', 'Email Required', 'trim|required');
		$this->form_validation->set_rules('password', 'Password required', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$result['message'] = false;
		}
		else{
			$val = $this->user->login($this->input->post('email'),$this->input->post('password'));
			if($val == 1){
				if($this->user->passwordChangeWarningMessage() == true){
					$result['message'] = "changePassword";
				}
				else{
					$roles = $this->session->userdata('roles');
					// if($roles[0]['role_id'] == 4){
					// 	$result['rurl'] = "teacherdashboard";
					// }
					// else if($roles[0]['role_id'] == 1){
					// 	$result['rurl'] = "admindashboard";
					// }
					// else{

					// 	$result['rurl'] = "controlldashboard";
					// }
					$result['message'] = true;
				}
				$user_log = array(
									'uid'=>$this->session->userdata('id'),
									'start_time'=>date('Y-m-d h:i:s'),
									'log_detail'=>'user_login'
								);
				$this->operation->table_name = 'user_log';
				$log_result = $this->operation->Create($user_log);
				$data['user_log_id'] = $log_result;
				$this->session->set_userdata($data);
			}
			else if($val  == "aul"){
				$result['message'] = "ul";
			}
			else if($val  == " "){
				$result['message'] = false;
			}
		}
		echo json_encode($result);
	}

	/**
	 * Password change after 90 days
	 *
	 * @access private
	 */
	function passChange(){
		$data['attempt'] = 1;
		$this->session->set_userdata($data);
		$this->load->view('user/pass_change');
	}

	/**
	 * Forgot password
	 *
	 * @access private
	 */
	function forgotPassword(){
		$result['message'] = false;
		$this->form_validation->set_rules('forgotInput', 'Email Required', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$result['message'] = false;
		}
		else{
			$val = $this->user->GetByWhere(array('email'=>$this->input->post('forgotInput')));
			if(count($val) == 1){
				$this->load->helper('string');
		    	$number = random_string('alnum', 16);
		    	$number .= ",".strtotime("now");
				$result  = $this->user->GetByWhere(array('email'=>$this->input->post('forgotInput')));
		 		// send email
		 		if(count($result) == 1):
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$message = "Hello";
					$message .= "<br> We received a request to reset the password associated with this e-mail address ".$this->input->post('forgotInput').". If you made this request, please use the link below to create a new password at FTC-Insight<br>";
					$message .= "Please use this key to reset password ".$number;
					$message .= "<br> <a href='http://cameras.ftccentral.com/RetypeSetPassword' title='Forgot Password'>Reset FTC-Insight Password</a><br>";
					$message .= "If you received this e-mail in error just ignore this message. No further actions are required from you.<br>";
					$message .= "<br>Note: this e-mail was sent automatically, please, do not reply to it.<br>";
					$message .="<br>Best Regards,<br>";
					$message .="The Family Thrift Center";
					$this->db->query("Update users set status = 'r', forgot_key = '".$number."' where email = '".$this->input->post('forgotInput')."'");
					$mail_sent = @mail($this->input->post('forgotInput'), "Password Reset", $message, $headers);
					$result['message'] = TRUE;
				endif;
		 	}
			else if(count($val) == 0){
				$result['message'] = false;
			}
		}
		echo json_encode($result);
	}

	/**
	 * Logout controller
	 *
	 * @access private
	 */
	function signout(){
		$this->session->sess_destroy();
		/*
		if($this->session->userdata('id')){
			$user_log = array(
								'end_time'=>date('Y-m-d h:i:s'),
							);
			$this->operation->table_name = 'user_log';
			$this->operation->primary_key = 'id';
			$log_result = $this->operation->Create($user_log,$this->session->userdata('user_log_id'));

		}
		$this->user->logout();
		*/
		parent::redirectUrl('signin');
	}

	function GetProgressReport()
	{
		$query = $this->operation->GetRowsByQyery('SELECT s.*,c.id as classid,c.grade as classname, sm.semester_id as semester_id FROM schedule s
				INNER JOIN classes c ON c.id = s.class_id
				INNER JOIN sessions se ON se.id = s.sessionid
				INNER JOIN semester_dates sm ON sm.session_id = se.id
				Where s.teacher_uid = '.$this->session->userdata("id")." AND sm.status = 'a' AND se.status = 'a' GROUP by class_id");

		$result = array();
		$active_session = parent::GetUserActiveSession();
		$active_semester = parent::GetCurrentSemesterData($active_session[0]->id);

		if(count($query))      
		{
			$classdetail = array();
			$i = 1;
			$singlecss = 1;
			$subcss = 1;
			foreach ($query as $key => $value) {

				$sectionslist = $this->operation->GetRowsByQyery('SELECT sec.section_name, sec.id as sectionid,s.class_id FROM schedule s
				INNER JOIN sections sec ON sec.id = s.section_id
				Where s.teacher_uid = '.$this->session->userdata("id")." AND s.class_id = ".$value->classid." GROUP by s.section_id");

				$sectionarray = array();
				if(count($sectionslist))
				{

					foreach ($sectionslist as $key => $svalue) {

						$subjectlist = $this->operation->GetRowsByQyery('SELECT subj.id as subjid , subj.subject_name  FROM schedule s INNER JOIN subjects subj ON subj.id = s.subject_id Where s.teacher_uid = '.$this->session->userdata("id").' AND s.class_id = '.$value->classid.' and s.section_id = '.$svalue->sectionid." AND subj.session_id = ".$active_session[0]->id." AND subj.semesterid = ".$active_semester[0]->semester_id);
						$subjectarray = array();
						if(count($subjectlist))
						{

							foreach ($subjectlist as $key => $sbvalue) {

								$subjectarray[] = array(
									'sbid'=>$sbvalue->subjid,
									'subject_name'=>$sbvalue->subject_name,
									'cssclass'=>($singlecss == 1 ? 'in':'other'),
									'cssclassiter'=>$singlecss,
								);
								$singlecss++;
							}
						}
						$sectionarray[] = array(
							'sid'=>$svalue->sectionid,
							'section_name'=>$svalue->section_name,
							'subjectlist'=>$subjectarray,
							'cssclass'=>($subcss == 1 ? 'in':'other'),
						);
						$subcss++;
					}
				}

				$result[] = array(
					'sessionid'=>$value->sessionid,
					'semesterid'=>$value->semester_id,
					'classid'=>$value->classid,
					'classname'=>$value->classname,
					'sectionlist'=>$sectionarray,
					'cssclass'=>($i == 1 ? 'in':'other'),
					'collapsed'=>($i == 1 ? 'collapsed':'other'),
				);
				$i++;
			}

		}
		echo json_encode($result);
	}



	function GetCourseLesson()
	{
		$lessonlist= array();
		if(!is_null($this->input->get('subjectlist')) && !is_null($this->input->get('inputsection'))
			&& !is_null($this->input->get('inputsemester')) && !is_null($this->input->get('inputsession')) ){
		$query = $this->operation->GetRowsByQyery('SELECT s.* FROM semester_lesson_plan s
				Where s.subjectid = '.$this->input->get('subjectlist').' AND s.semesterid = '.$this->input->get('inputsemester').'
				 AND s.classid = '.$this->input->get('inputclassid').'  AND s.sectionid = '.$this->input->get('inputsection').'  order by s.read_date asc');

			$lessonheader = array();
			$lessondetail = array();
			if(count($query))
			{
				foreach ($query as $key => $value) {
					$lessonlist[] = array(
						'id'=>$value->id,
						'name'=>$value->concept,
						'topic'=>$value->topic,
						'date'=>(!is_null($value->read_date) ? date('d-M-Y',strtotime($value->read_date)):''),
						'type'=>ucfirst($value->type),
					);

				}
			}
		}
		echo json_encode($lessonlist);
	}
	
	function GetCourseDetail()
	{
		$lessondetailarray = array();

		if(!is_null($this->input->get('subjectlist')) && !is_null($this->input->get('inputsection'))){

			$student = array();
//			$progress = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` where classid = '.$this->input->get('inputclassid')." AND sectionid = ".$this->input->get('inputsection')." AND semesterid = ".$this->input->get('inputsemester')." AND sessionid = ".$this->input->get('inputsession')."  AND status = 'r'");

			$progress = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` INNER JOIN invantageuser as inv on inv.id=studentid WHERE classid = '.$this->input->get('inputclassid')." AND sectionid = ".$this->input->get('inputsection')." AND semesterid = ".$this->input->get('inputsemester')." AND sessionid = ".$this->input->get('inputsession')." AND user_active_status=1");

            
            $latestReadDate = $this->operation->GetRowsByQyery('SELECT s.read_date FROM `semester_lesson_plan` s INNER JOIN lessonprogress p WHERE p.lessonid=s.id AND p.status = "read" AND classid = ' . $this->input->get('inputclassid')." AND sectionid = ".$this->input->get('inputsection')." AND semesterid = ".$this->input->get('inputsemester')." AND sessionid = ".$this->input->get('inputsession')."  ORDER BY s.read_date DESC");
			if(count($latestReadDate))
			{
				$latestReadDate = $latestReadDate[0]->read_date;
			}else{
				$latestReadDate = '';
			}
			$datetime1 = null;
			try {
			    if(!empty($latestReadDate))
				$datetime1 = new DateTime($latestReadDate);
			} catch (Exception $e) {
				
			}

			if(count($progress))
			{
				$studentprogress = $this->operation->GetRowsByQyery('SELECT s.id as semid,s.read_date FROM `semester_lesson_plan` s WHERE subjectid = '.$this->input->get('subjectlist').' AND semesterid = '.$this->input->get('inputsemester').' AND sectionid = '.$this->input->get('inputsection').' order by s.read_date asc');
				
				if(count($studentprogress))
				{
					foreach ($progress as $key => $value) {
						$sparray = array();
						foreach ($studentprogress as $key => $spvalue) {
							 $ar = $this->GetStudentProgress($spvalue->semid,$value->studentid);
							 $show = false;
							 if($datetime1!=null){
							 	$datetime2 = new DateTime($spvalue->read_date);
							 	$show = $datetime1>=$datetime2;
							}
							$ar['show'] = $show?1:0;
							 $sparray[] = $ar;
						}
                 
						$lessondetailarray[] = array(
						    'latestreaddate'=>$latestReadDate,
							'studentid'=>$value->studentid,
							'screenname'=>$this->GetStudentName($value->studentid),
							'studentplan'=>$sparray
						);
					}
				}
			}
		}
		echo json_encode($lessondetailarray);
	}

	function GetStudentName($studentid)
	{
		return parent::getUserMeta($studentid,'sfullname')." ".parent::getUserMeta($studentid,'sFdb->name');
	}

	function GetStudentProgress($lessonid,$studentid)
	{

		$studentprogress = $this->operation->GetRowsByQyery('SELECT * FROM `lessonprogress` where lessonid ='.$lessonid." AND studentid=".$studentid);

		$sparray = array();
		if(count($studentprogress))
		{
			foreach ($studentprogress as $key => $spvalue) {
				$sparray = array(
					'lessonid'=>$spvalue->lessonid,
					'status'=>$spvalue->status,
					'last_updated'=>$spvalue->last_updated,
				);
			}
		}
		else{
			$sparray = array(
				'lessonid'=>$lessonid,
				'status'=>'unread',
			);
		}
		return $sparray;
	}

	function GetEvulationHeader()
	{

		$quizlist= array();
		if(!is_null($this->input->get('subjectlist')) && !is_null($this->input->get('inputsemester')) && !is_null($this->input->get('inputsession'))) {
			$roles = $this->session->userdata('roles');
	        if ($roles[0]['role_id'] ==4)
			{
				$query = $this->operation->GetRowsByQyery("SELECT q.* FROM quize q INNER JOIN semester s ON s.id = q.semesterid INNER JOIN sessions se ON se.id = q.sessionid Where q.subjectid = ".$this->input->get('subjectlist')." AND q.classid = ".$this->input->get('inputclassid')." AND q.sectionid = ".$this->input->get('inputsectionid')." AND s.status = 'a' AND se.status = 'a' AND q.tacher_uid = ".$this->session->userdata('id')." AND q.semesterid = ".$this->input->get('inputsemester')." AND q.sessionid = ".$this->input->get('inputsession')."  order by q.quiz_term asc");
			}
			else{
				$query = $this->operation->GetRowsByQyery("SELECT q.* FROM quize q INNER JOIN semester s ON s.id = q.semesterid INNER JOIN sessions se ON se.id = q.sessionid Where q.subjectid = ".$this->input->get('subjectlist')." AND q.classid = ".$this->input->get('inputclassid')." AND q.sectionid = ".$this->input->get('inputsectionid')." AND s.status = 'a' AND se.status = 'a'  AND q.semesterid = ".$this->input->get('inputsemester')." AND q.sessionid = ".$this->input->get('inputsession')."  order by q.quiz_term asc");
			}
			/*
			$query = $this->operation->GetRowsByQyery("SELECT q.id, q.qname, q.classid, q.subjectid, q.isdone, qs.section_id as sectionid FROM quiz_section as qs INNER JOIN quize as q WHERE q.id=qs.quiz_id AND q.classid=" . $this->input->post('class_id') . " AND q.subjectid=" . $this->input->post('subject_id') . " AND qs.section_id=" . $this->input->post('section_id'));*/

			if(count($query))
			{
				foreach ($query as $key => $value) {
					$quizlist[] = array(
						'id'=>$value->id,
						'name'=>$value->qname,
						'term_status'=>$value->quiz_term,
						'class'=>$value->classid,
						'section'=>$value->sectionid,
						'subject'=>$value->subjectid,
						'semesterid'=>$value->semesterid,
						'sessionid'=>$value->sessionid
					);

				}
			}
		}
		echo json_encode($quizlist);
	}

	function GetQuizeListBySubject($subjectid,$sessionid,$semesterid,$classid,$sectionid)
	{
		return $this->operation->GetRowsByQyery('SELECT id,classid,sectionid,tacher_uid FROM `quize` WHERE subjectid = '.$subjectid." AND classid = ".$classid." AND sectionid = ".$sectionid." AND semesterid = ".$semesterid." AND sessionid = ".$sessionid." AND tacher_uid = ".$this->session->userdata('id')." group by subjectid");
	}

	function GetQuizDetail()
	{
		$quizarray = array();
		
		if(!is_null($this->input->get('subjectlist')) && !is_null($this->input->get('inputsemester')) && !is_null($this->input->get('inputsession'))
			&& !is_null($this->input->get('inputclassid')) && !is_null($this->input->get('inputsectionid'))){
			$quizlist = $this->GetQuizeListBySubject($this->input->get('subjectlist'),$this->input->get('inputsession'),
									$this->input->get('inputsemester'),$this->input->get('inputclassid'),
									$this->input->get('inputsectionid'));
			if($this->input->get('studentid'))
			{
				$studentlist = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` where classid = '.$this->input->get('inputclassid')." AND sectionid = ".$this->input->get('inputsectionid')." AND semesterid = ".$this->input->get('inputsemester')." AND  sessionid = ".$this->input->get('inputsession')." AND studentid = ".$this->input->get('studentid')." AND status = 'r'");
			}
			else{
				$studentlist = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` where classid = '.$this->input->get('inputclassid')." AND sectionid = ".$this->input->get('inputsectionid')." AND semesterid = ".$this->input->get('inputsemester')." AND  sessionid = ".$this->input->get('inputsession')." AND status = 'r'");				
			}
			
            
			if(count($studentlist))
			{
				foreach ($studentlist as $key => $value) {
					$studentprogress = $this->operation->GetRowsByQyery('SELECT q.id,q.quiz_term FROM `quize` q where subjectid ='.$this->input->get('subjectlist')." AND classid = ".$this->input->get('inputclassid')." and sectionid = ".$this->input->get('inputsectionid')." AND semesterid = ".$this->input->get('inputsemester')." AND sessionid = ".$this->input->get('inputsession')."  order by quiz_term");
					 if(count($studentprogress))
					 {
						$quizdetailarray = array();
						foreach ($studentprogress as $key => $spvalue) {

							$correctlist = $this->operation->GetRowsByQyery('SELECT qz.quizid,qz.questionid as quesid,qo.qoption_id  FROM quiz_evaluation qz INNER JOIN quizeoptions qo ON qo.qoption_id = qz.optionid Where qz.studentid ='.$value->studentid." AND qz.quizid=".$spvalue->id);
							$quizid = 0;

							if(count($correctlist))
							{
								$total_count= 0;

								foreach ($correctlist as $key => $rvalue) {
									$quizid = $rvalue->quizid;
									$is_correct_answer_matched = $this->operation->GetRowsByQyery('SELECT * FROM correct_option  Where question_id ='.$rvalue->quesid);

									if($is_correct_answer_matched[0]->correct_id == $rvalue->qoption_id)
									{
										$total_count++;
									}
								}

							 	$quiz_evaluation_points = parent::GetEvaluationByType('qui',$this->input->get('inputsession'));
							 	$quiz_result = ($total_count / count($correctlist)) * 100;
								$quizdetailarray[] = array(
									'quizid'=>$quizid,
									'correntanswer'=>$total_count,
									'total_question'=>count($correctlist),
									'term_status'=>$spvalue->quiz_term,
									'totalpercent'=> $quiz_result
								);
							}else{
								$quizdetailarray[] = array(
									'correntanswer'=>0,
									'total_question'=>0,
									'quizid'=>$quizid,
									'term_status'=>$spvalue->quiz_term,
									'totalpercent'=>0
								);
							}
						}
					}
					
                    $termlist = $this->operation->GetRowsByQyery('SELECT * FROM temr_exam_result  where subjectid = '.$this->input->get('subjectlist').' AND studentid= '.$value->studentid." AND sessionid = ".$this->input->get('inputsession')." AND semesterid = ".$this->input->get('inputsemester')." order by termid asc");
                 	$student_result = array();
					if(count($termlist)==2)
					{
						foreach ($termlist as $key => $tvalue) {
							$studenmark = '';
							$marks = is_null($tvalue->marks) ? 0 : $tvalue->marks;
						
							$student_result[] = array(
								'marks'=>$marks
							);
						}
					}
					
                   
                    
					if(count($termlist)==1)
					{
						if($termlist[0]->termid == 1)
						{
							$studenmark = '';
							$marks = is_null($termlist[0]->marks) ? 0 : $termlist[0]->marks;
						
							$student_result[] = array(
								'marks'=>$marks,
					
							);
							
							$student_result[] = array(
								'marks'=>0,
				
							);
						}

						if($termlist[0]->termid == 2)
						{
							$studenmark = '';
							$marks = is_null($termlist[0]->marks) ? 0 : $termlist[0]->marks;
						

							$student_result[] = array(
								'marks'=>0,
			
							);

							$student_result[] = array(
								'marks'=>$marks,
		
							);
						}

					}

					if(count($termlist)==0)
					{
						$student_result[] = array(
								'marks'=>0
							);

							$student_result[] = array(
								'marks'=>0
							);

					}

					$quizarray[] = array(
						 'studentid'=>$value->studentid,
						 'screenname'=>$this->GetStudentName($value->studentid),
						 'score'=>$quizdetailarray,
						 'term_result'=>$student_result

					);
				}
			}
			else
			{
				$is_subject_found = $this->operation->GetRowsByQyery('SELECT * FROM `schedule` where subject_id = '.$this->input->get('subjectlist')." AND class_id = ".$this->input->get('inputclassid')." AND section_id = ".$this->input->get('inputsectionid')." AND semesterid = ".$this->input->get('inputsemester')." AND sessionid = ".$this->input->get('inputsession')." AND teacher_uid =".$this->session->userdata('id'));
                
				if(count($is_subject_found)){
					foreach ($is_subject_found as $key => $value) {
						$studentlist = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` where classid = '.$this->input->get('inputclassid')." AND sectionid = ".$this->input->get('inputsectionid')." AND semesterid = ".$this->input->get('inputsemester')." AND sessionid = ".$this->input->get('inputsession')." AND status = 'r'");
						if(count($studentlist))
						{
							foreach ($studentlist as $key => $value) {

								$termlist = $this->operation->GetRowsByQyery('SELECT * FROM temr_exam_result  where subjectid = '.$this->input->get('subjectlist')." AND classid = ".$this->input->get('inputclassid')." AND sectionid = ".$this->input->get('inputsectionid')." AND semesterid = ".$this->input->get('inputsemester')." AND sessionid = ".$this->input->get('inputsession')." AND studentid= ".$value->studentid." order by termid asc");
								$student_result = array();
								if(count($termlist)==2)
								{
									foreach ($termlist as $key => $tvalue) {
										$studenmark = '';
										$marks = is_null($tvalue->marks) ? 0 : $tvalue->marks;
									
										$student_result[] = array(
											'marks'=>$marks
										);
									}
								}
                              	if(count($termlist)==1)
								{
									if($termlist[0]->termid == 1)
									{
										$studenmark = '';
										$marks = is_null($termlist[0]->marks) ? 0 : $termlist[0]->marks;
									

										$student_result[] = array(
											'marks'=>$marks
										);

										$student_result[] = array(
											'marks'=>0
										);
									}

									if($termlist[0]->termid == 2)
									{
										$studenmark = '';
										$marks = is_null($termlist[0]->marks) ? 0 : $termlist[0]->marks;
									
										$student_result[] = array(
											'marks'=>0
										);

										$student_result[] = array(
											'marks'=>$marks
										);
									}

								}

								if(count($termlist)==0)
								{
									$student_result[] = array(
										'marks'=>0
									);

									$student_result[] = array(
										'marks'=>0
									);

								}

								$quizarray[] = array(
								 	'studentid'=>$value->studentid,
								 	'screenname'=>$this->GetStudentName($value->studentid),
								 	'term_result'=>$student_result,
								 	'score'=>[],
								);
							}
						}
					}
				}
			}
		}
		echo json_encode($quizarray);
	}

	function GetTotalQuestion($quizid)
	{
		return $this->operation->GetRowsByQyery('SELECT count(id) FROM `quizequestions` where quizeid = '.$quizid);
	}

	function GetLessonPlan()
	{
		$planarray = array();
		if(!is_null($this->input->get('subjectlist'))){
			$planlist = $this->operation->GetRowsByQyery('SELECT * FROM semester_lesson_plan slp  where subjectid = '.$this->input->get('subjectlist').' GROUP BY read_date');
			if(count($planlist))
			{
				foreach ($planlist as $key => $value) {
					$currentdate = date('Y-m-d');
					$read_date = date('Y-m-d',strtotime($value->read_date));
					$status = 'unreadlesson';
					if($currentdate > $read_date)
					{
						$status = 'read';
					}

					$planarray[] = array(
						'id'=>$value->id,
						'name'=>$value->name,
						'date'=>(is_null($value->read_date) ? 'No date':$value->read_date),
						'status'=>$status
					);
				}
			}
		}

		echo json_encode($planarray);
	}

	function GetResultHeader()
	{
		$termheader = array();
		if(!is_null($this->input->get('subjectlist'))){
			$query = $this->operation->GetRowsByQyery('SELECT * FROM temr_exam_result  where subjectid = '.$this->input->get('subjectlist')." group By termid order by id asc");

			if(count($query))
			{
				$termlistarray = array('1st Term','2nd Term','Final Term');
				foreach ($query as $key => $value) {
					$termheader[] = array(
						'name'=>$termlistarray[$value->termid - 1],
					);

				}
			}
		}
		echo json_encode($termheader);
	}

	function GetResultList()
	{
		$resultarray = array();
		if(!is_null($this->input->get('subjectlist')) && !is_null($this->input->get('semesterid')) && !is_null($this->input->get('sessionid'))){
			$resultlist = $this->GetSubjectResultList($this->input->get('subjectlist'));
			$planlist = $this->operation->GetRowsByQyery('SELECT * FROM semester_lesson_plan slp  where subjectid = '.$this->input->get('subjectlist').' AND semesterid = '.$this->input->get('semesterid').' AND sessionid = '.$this->input->get('sessionid').' GROUP BY read_date');
			
			if(count($resultlist))
			{
				foreach ($resultlist as $key => $value) {
						$studentlist = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` where classid = '.$value->class_id." AND sectionid = ".$value->section_id." AND status = 'r'");

					if(count($studentlist))
					{
						foreach ($studentlist as $key => $svalue) {
							$termlist = $this->operation->GetRowsByQyery('SELECT * FROM temr_exam_result  where subjectid = '.$this->input->get('subjectlist').' AND studentid= '.$svalue->id.' AND semesterid = '.$this->input->get('semesterid').' AND sessionid = '.$this->input->get('sessionid').' group by termid');
							$termarray = array();
							if(count($termlist))
							{
								foreach ($termlist as $key => $tvalue) {
									$studenmark = '';
									$marks = is_null($tvalue->marks) ? 0 : $tvalue->marks;
									if($marks <= 50){
										$studenmark = 'D';
									}
									if($marks >= 60){
										$studenmark = 'D+';
									}
									if($marks >= 70){
										$studenmark = 'B+';
									}
									if($marks >= 85){
										$studenmark = 'A+';
									}
									$termarray[] = array(
										'marks'=>$studenmark,
									);
								}
							}
							$resultarray[] = array(
								'studentid'=>$svalue->id,
								'screenname'=>$this->GetStudentName($svalue->id),
								'result'=>$termarray,
							);
						}
					}
				}

			}
		}
		echo json_encode($resultarray);
	}

	function GetSubjectResultList($subjectid)
	{
		return $this->operation->GetRowsByQyery('SELECT * FROM temr_exam_result  where subjectid = '.$this->input->get('subjectlist').' group by subjectid');
	}

	function GetStudentQuizDetail()
	{
		$quizdetailarray = array();
		if(!is_null($this->input->get('studentid')) && !is_null($this->input->get('quizid'))){
			$quizequestions = $this->operation->GetRowsByQyery('SELECT * FROM quizequestions  where quizeid = '.$this->input->get('quizid').' order by id asc');
			if(count($quizequestions))
			{
				foreach ($quizequestions as $key => $value) {
					$optionarray = array();

					$quizeoptions = $this->operation->GetRowsByQyery('SELECT qo.*,qp.questionid FROM quizeoptions qp INNER JOIN qoptions qo On qo.id = qp.qoption_id   where qp.questionid = '.$value->id.' order by id asc');
					if(count($quizeoptions))
					{
						$correct_index = 1;
						$i = 1 ;
						foreach ($quizeoptions as $key => $ovalue) {
							$is_correct_answer_matched = $this->operation->GetRowsByQyery('SELECT * FROM correct_option  Where question_id ='.$ovalue->questionid);
							$option_value = '';
							if($value->type == 't')
							{

								$option_value = $ovalue->option_value;

							}
							else{
								$thumbname = explode('.', $ovalue->option_value);
								$option_value = base_url().'upload/option_images/'.$thumbname[0].'_thumb.'.$thumbname[1];
							}

							if($is_correct_answer_matched[0]->correct_id == $ovalue->id)
							{
								$correct_index = 1;
							}
							else{
								$correct_index = 0;
							}

							$optionarray[] = array(
								'optionid'=>$ovalue->id,
								'optionitem'=>$option_value,
								'iscorrect'=> ($correct_index == 1 ? 1 : 0),
							);
						}
					}
					$selectedoption = $this->GetStudentQuizOption($this->input->get('studentid'),$this->input->get('quizid'),$value->id);
					$thumbname = '';
					if(!is_null($value->img_src)){
						$thumbname = explode('.', $value->img_src);
					}
					$quizdetailarray[] = array(
						'question'=>$value->question,
						'qtype'=>$value->type,
						'thumbnail_src'=>(count($thumbname) == 2 ? base_url().'upload/quiz_images/'.$thumbname[0].'_thumb.'.$thumbname[1] : ''),
						'options'=>$optionarray,
						'selectedoption'=>(int) $selectedoption[0]->optionid
					);
				}
			}
		}
		echo json_encode($quizdetailarray);
	}

	function GetStudentQuizOption($studentid,$quizid,$questionid)
	{
		return $this->operation->GetRowsByQyery('SELECT * FROM quiz_evaluation  where  	studentid = '.$studentid.' AND quizid = '.$quizid.' AND questionid = '.$questionid.' limit 1');
	}


	public function CheckUserEmailValidation()
	{
		
		$email = $this->input->get('inputEmail');
		//$nic = $this->input->get('inputTeacher_Nic');
		$inputserial = $this->input->get('inputserial');

		$result['message']=false;
		
		// if user is trying to edit the form
		if($inputserial)
		{
	    	if($inputserial != null)
			{
				$is_user_editing_nic =$this->operation->GetRowsByQyery("Select * from invantageuser where  email= '".$email."' AND id =".$inputserial);	
			}
			
			if($inputserial === null )
			{
		 		$is_nic_found=$this->operation->GetRowsByQyery("Select * from invantageuser where  email= '".$email."'");	
			}

			if(count($is_user_editing_nic) == 0)
			{
				$is_nic_found=$this->operation->GetRowsByQyery("Select * from invantageuser where  email= '".$email."'");
			}
			
		}
		else{
			
			$result['message']=true;
		}
        
    	if(count($is_nic_found))
		{
			$result['message'] = true;
		}
		
		if(count($is_user_editing_nic))
		{
			$result['message'] = false;
		}
		
		
		if(!$inputserial)
		{
			if($email)
			{
				$is_record_found = $this->operation->GetRowsByQyery("Select * from invantageuser where  email= '".$email."'");
				if(count($is_record_found))
				{
					$result['message']=true;
				}
				else{
					$result['message']=false;
				}
			}
		}
		
		echo json_encode($result);
	}

	public function TeacherNicDuplicationCheck()
	{
		
		$nic = $this->input->get('inputTeacher_Nic');
		$inputserial = $this->input->get('inputserial');
		$result['message'] = false;
		
		if($nic != null)
		{
			if($inputserial != null)
			{
				$is_user_editing_nic =$this->operation->GetRowsByQyery("Select * from invantageuser where  nic= '".$nic."' AND id =".$inputserial);	
			}
			
			if($inputserial === null )
			{
		 		$is_nic_found=$this->operation->GetRowsByQyery("Select * from invantageuser where  nic= '".$nic."'");	
			}

			if(count($is_user_editing_nic) == 0)
			{
				$is_nic_found=$this->operation->GetRowsByQyery("Select * from invantageuser where  nic= '".$nic."'");
			}
		}
		else{
			
			$result['message']=true;
		}

		
		if(count($is_nic_found))
		{
			$result['message'] = true;
		}
		
		if(count($is_user_editing_nic))
		{
			$result['message'] = false;
		}

		echo json_encode($result);
		
	}

	function CheckSchedule()
	{
		$result['message'] = false;

		if($this->input->get('schclassid') && $this->input->get('sectionid') && $this->input->get('subjectid')){
			$this->operation->table_name = 'schedule';
			$is_schedule_found = $this->operation->GetByWhere(array(
							'class_id'=>$this->input->get('schclassid'),
							'section_id'=>$this->input->get('sectionid'),
							'subject_id'=>$this->input->get('subjectid'),
						));

			if(count($is_schedule_found))
			{
				$result['message'] = true;
			}
		}
		echo json_encode($result);
	}

	function CheckTeacherSchedule()
	{
		$result['message'] = false;

		if($this->input->get('teacherid') && $this->input->get('starttime') && $this->input->get('endtime')){
			$this->operation->table_name = 'schedule';

			$is_schedule_found = $this->operation->GetRowsByQyery('SELECT * FROM schedule where teacher_uid ='.$this->input->get('teacherid').' AND start_time >= '.strtotime($this->input->get('starttime')).' AND end_time <= '.strtotime($this->input->get('endtime')));
			

			if(count($is_schedule_found))
			{
				if($this->input->get('serial') == $is_schedule_found[0]->id && $this->input->get('subject') != $is_schedule_found[0]->subject_id )
				{
					$result['message'] = false;
				}
				else{
					$result['message'] = true;
				}


			}


		}
		echo json_encode($result);
	}

	// function GetTeaherAllAlocatedHours()
	// {
	// 	$result['message'] = false;

	// 	if($this->input->get('teacherid')){
	// 		$this->operation->table_name = 'schedule';

	// 		$is_schedule_found = $this->operation->GetRowsByQyery('SELECT * FROM schedule where teacher_uid ='.$this->input->get('teacherid'));
	// 		$disabled_hours = array();
	// 		if(count($is_schedule_found))
	// 		{
	// 			foreach ($is_schedule_found as $key => $value) {
	// 				$disabled_hours[] = array(
	// 					'hour'=>date('H',$value->)
	// 				);
	// 			}
	// 		}
	// 	}
	// 	echo json_encode($result);
	// }

	function GetSubjectResult()
	{
		$resultarray = array();
		if(!is_null($this->input->get('subject_id')) && !is_null($this->input->get('class_id'))
				&& !is_null($this->input->get('section_id')) && !is_null($this->input->get('term_id'))
				&& !is_null($this->input->get('semesterid')) && !is_null($this->input->get('sessionid'))){
			$resultlist = $this->operation->GetRowsByQyery('SELECT * FROM `student_semesters` where classid = '.$this->input->get('class_id')." AND sectionid = ".$this->input->get('section_id')." AND semesterid = ".$this->input->get('semesterid')." AND sessionid = ".$this->input->get('sessionid')." AND status = 'r'");
		
			if(count($resultlist))
			{
				foreach ($resultlist as $key => $value) {
					$termlist = $this->operation->GetRowsByQyery('SELECT * FROM temr_exam_result  where studentid = '.$value->studentid."  AND subjectid = ".$this->input->get('subject_id'));

					$marksarray = array();
					if(count($termlist))
					{
						if(count($termlist) == 2){
							foreach ($termlist as $key => $tvalue) {
								$marksarray[] = array(
									'studentmarks'=>$tvalue->marks
								);
							}
						}else{
							foreach ($termlist as $key => $tvalue) {
								$temp = array(
									'studentmarks'=>$tvalue->marks
								);
								$marksarray = array(
									$temp,
									array('studentmarks'=>0)
								);
							}
						}

					}
					else{
						$marksarray = array(array('studentmarks'=>0),array('studentmarks'=>0));
					}
					$resultarray[] = array(
						'id'=>$value->id,
						'marks'=>$marksarray,
						'studentid'=>$value->studentid,
						'name'=>parent::getUserMeta($value->studentid,'sfullname')." (".parent::getUserMeta($value->studentid,'roll_number').")",
					);

				}
			}else{
				$this->operation->table_name = 'student_semesters';
				$resultlist = $this->operation->GetByWhere(array(
							'classid'=>$this->input->get('class_id'),
							'sectionid'=>$this->input->get('section_id'),
							'semesterid'=>$this->input->get('semesterid'),
							'sessionid'=>$this->input->get('sessionid'),
						));
				if(count($resultlist))
				{
					foreach ($resultlist as $key => $value) {
						$resultarray[] = array(
							'id'=>0,
							'studentid'=>$value->studentid,
							'marks'=>array(array('studentmarks'=>0),array('studentmarks'=>0)),
							'name'=>parent::getUserMeta($value->studentid,'sfullname')." (".parent::getUserMeta($value->studentid,'roll_number').")",
						);
					}
				}
			}
		}
		echo json_encode($resultarray);
	}

	function SetStudentMarks()
	{
		$request = json_decode( file_get_contents('php://input'));
		$cellvalue = $this->security->xss_clean(trim($request->cellvalue));
		$cellcolumn = $this->security->xss_clean(trim($request->cellcolumn));
		$cellid = $this->security->xss_clean(trim($request->cellid));
		$classid = $this->security->xss_clean(trim($request->classid));
		$sectionid = $this->security->xss_clean(trim($request->sectionid));
		$subjectid = $this->security->xss_clean(trim($request->subjectid));
		$studentid = $this->security->xss_clean(trim($request->studentid));
		$termid = $this->security->xss_clean(trim($request->termid));
		$semesterid = $this->security->xss_clean(trim($request->semesterid));
		$sessionid = $this->security->xss_clean(trim($request->sessionid));
		$sresult['message'] = false;
		 $locations = $this->session->userdata('locations');
		if(!is_null($cellvalue) && !is_null($cellcolumn) && !is_null($cellid)){
			$this->operation->table_name = 'temr_exam_result';
			$resultlist = $this->operation->GetByWhere(array(
							'classid'=>$classid,
							'sectionid'=>$sectionid,
							'subjectid'=>$subjectid,
							'studentid'=>$studentid,
							'termid'=>($cellcolumn == 'm' ? 1 : 2),
							'semesterid'=>$semesterid,
							'sessionid'=>$sessionid,

						));
		
			if(count($resultlist)){
				$studentresult = array(
						'classid'=>$classid,
						'sectionid'=>$sectionid,
						'subjectid'=>$subjectid,
						'studentid'=>$studentid,
						'termid'=>($cellcolumn == 'm' ? 1 : 2),
						'marks'=>$cellvalue,
						'semesterid'=>$semesterid,
						'sessionid'=>$sessionid,
				);

				$id = $this->operation->Create($studentresult,$resultlist[0]->id);
				
				$result['message'] = true;
			}
			else{
				$studentresult = array(
						'classid'=>$classid,
						'sectionid'=>$sectionid,
						'subjectid'=>$subjectid,
						'studentid'=>$studentid,
						'termid'=>($cellcolumn == 'm' ? 1 : 2),
						'marks'=>$cellvalue,
						'semesterid'=>$semesterid,
						'sessionid'=>$sessionid,
						'locationid'=>$locations[0]['school_id'],
				);

				$id = $this->operation->Create($studentresult);
				$result['message'] = true;
			}
		}
		
	
		echo json_encode($result);
	}

	function GetClassList()
	{
		$this->operation->table_name = 'classes';

		$classarray = array();
		$locations = $this->session->userdata('locations');
		$roles = $this->session->userdata('roles');
		if($roles[0]['role_id'] == 3 || $this->session->userdata('is_master_teacher') == 1)
		{
			
			if($this->input->get('inputclassid')){
				$classlist = $this->operation->GetByWhere(array('id'=>$this->input->get('inputclassid')));
			}
			else{
				$classlist = $this->operation->GetRowsByQyery("Select c.* from classes c  where  c.school_id =".$locations[0]['school_id']);
			}
		}

	 if($roles[0]['role_id'] == 4)
		{
			if($this->input->get('inputclassid')){
				$classlist = $this->operation->GetByWhere(array('id'=>$this->input->get('inputclassid')));
			}
			else{

				$classlist = $this->operation->GetRowsByQyery("Select c.* from classes c INNER JOIN schedule sc On sc.class_id = c.id where  sc.teacher_uid =".$this->session->userdata('id').' group by c.id');
			}
		}

		if(count($classlist))
		{
			foreach ($classlist as $key => $value) {
				$school = parent::GetSchoolDetail($value->school_id);
				$sectionlist = array();
				$is_section_found = $this->operation->GetRowsByQyery("Select s.id as sectionid,s.section_name,assi.status from assignsections assi INNER JOIN sections s ON s.id = assi.sectionid  where  assi.classid =".$value->id);			
				if(count($is_section_found))
				{
					foreach ($is_section_found as $key => $svalue) {
						$sectionlist[] = array(
							'sectionid'=>$svalue->sectionid,
							'section_name'=>$svalue->section_name,
							'status'=>$svalue->status,
						);
					}
				}
				$classarray[] = array(
					'id'=>$value->id,
					'name'=>$value->grade,
					'status'=>$value->status,
					'school'=>$school->name,
					'city'=>$school->location,
					'sections'=>$sectionlist
				);
			}
		}

		echo json_encode($classarray);
	}

	function GetClassesList()
	{
		$this->operation->table_name = 'classes';

		$classarray = array();
		$locations = $this->session->userdata('locations');
		$roles = $this->session->userdata('roles');
		$classlist = $this->operation->GetRowsByQyery("Select c.* from classes c  where  c.school_id =".$locations[0]['school_id']);


		if(count($classlist))
		{
			foreach ($classlist as $key => $value) {
				$school = parent::GetSchoolDetail($value->school_id);
				$classarray[] = array(
					'id'=>$value->id,
					'name'=>$value->grade,
					'status'=>$value->status,
				);
			}
		}

		echo json_encode($classarray);
	}

	function GetStudentByClass()
	{
		$studentarray = array();
		if(!is_null($this->input->get('inputclassid')) && !is_null($this->input->get('inputsectionid'))
			&& !is_null($this->input->get('inputsemesterid')) && !is_null($this->input->get('inputsessionid'))){
			if($this->input->get('inputsemesterid')== 'b')
			{
				$studentlist = $this->operation->GetRowsByQyery("Select ss.studentid,iv.screenname,um.meta_value,iv.profile_image from student_semesters ss  INNER JOIN invantageuser iv on iv.id = ss.studentid INNER JOIN user_meta um on um.user_id = ss.studentid   where ss.classid = ".$this->input->get('inputclassid')." AND ss.sectionid =".$this->input->get('inputsectionid')." AND ss.sessionid = ".$this->input->get('inputsessionid')." AND um.meta_key = 'roll_number' AND ss.status = 'r'");
			}
			else
			{
				$studentlist = $this->operation->GetRowsByQyery("Select ss.studentid,iv.screenname,um.meta_value,iv.profile_image from student_semesters ss  INNER JOIN invantageuser iv on iv.id = ss.studentid INNER JOIN user_meta um on um.user_id = ss.studentid   where ss.classid = ".$this->input->get('inputclassid')." AND ss.sectionid =".$this->input->get('inputsectionid')." AND ss.semesterid = ".$this->input->get('inputsemesterid')." AND ss.sessionid = ".$this->input->get('inputsessionid')." AND um.meta_key = 'roll_number' AND ss.status = 'r'");
			}
		
			if(count($studentlist)){
				foreach ($studentlist as $key => $value) {
					$studentarray[] =array(
						'id'=>$value->studentid,
						'name'=>$this->GetStudentName($value->studentid)." (".$value->meta_value.")",
						'rollnumber'=>$value->meta_value,
						'fathername'=>parent::getUserMeta($value->studentid,'father_name'),
						'profile'=>$value->profile_image,
						'sdob'=>parent::getUserMeta($value->studentid,'sdob')

					);
				}
			}
		}
		echo json_encode($studentarray);
	}

	
	
	function GetSemesterData()
	{
		$this->operation->table_name = 'semester';
		$semesterlist = $this->operation->GetRows();

		$semesterarray = array();
		if(count($semesterlist))
		{
			foreach ($semesterlist as $key => $value) {
				$semesterarray[] = array(
					'id'=>$value->id,
					'name'=>$value->semester_name,
					'status'=>$value->status,
				);
			}
		}

		if(!is_null($this->input->get('inputsemesterid')))
		{
			$resultlist = $this->operation->GetByWhere(array(
						'id'=>$this->input->get('inputsemesterid'),
					));
			if(count($resultlist))
			{
				$semesterarray = array();
				foreach ($resultlist as $key => $value) {
					$semesterarray[] = array(
						'id'=>$value->id,
						'name'=>$value->semester_name,
						'status'=>$value->status,
					);
				}
			}
		}

		echo json_encode($semesterarray);
	}

function SavePromotedStudent()
	{
		$request = json_decode( file_get_contents('php://input'));
		$data = $this->security->xss_clean(trim($request));
		$oldclass = $this->security->xss_clean(trim($request->oldclass));
		$oldsection = $this->security->xss_clean(trim($request->oldsection));
		$oldsemester = $this->security->xss_clean(trim($request->oldsemester));
		$newclass = $this->security->xss_clean(trim($request->newclass));
		$newsection = $this->security->xss_clean(trim($request->newsection));
		$newsemester = $this->security->xss_clean(trim($request->newsemester));
		$newsessionid = $this->security->xss_clean(trim($request->newsessionid));
		$oldsession = $this->security->xss_clean(trim($request->oldsession));
		$sresult['message'] = false;

		if(!is_null($oldclass) && !is_null($oldsection) && !is_null($oldsemester) && !is_null($newclass)
			&& !is_null($newsection) && !is_null($newsemester) && !is_null($newsessionid)
			)
		{

			$this->operation->table_name = 'semester_dates';
            $active_semester = $this->operation->GetByWhere(array('session_id'=>$oldsession,'semester_id'=>$oldsemester));

			$this->operation->table_name = 'student_semesters';

			foreach ($request as $key => $value) {
				foreach ($value as $key => $svalue) {

					$resultlist = $this->operation->GetByWhere(array(
						'classid'=>$oldclass,
						'sectionid'=>$oldsection,
						'semesterid'=>$active_semester[0]->semester_id,
						'studentid'=>$svalue->id,
						'status'=>'r',
						'sessionid'=>$oldsession
					));
					if(count($resultlist)){
						$studentresult = array(
							'status'=>'u',
						);
						$this->operation->table_name = 'student_semesters';

						$id = $this->operation->Create($studentresult,$resultlist[0]->id);

						$this->operation->table_name = 'semester_dates';
            			$active_semester = $this->operation->GetByWhere(array('session_id'=>$newsessionid,'semester_id'=>$newsemester));
						$studentresult = array(
							'classid'=>$newclass,
							'sectionid'=>$newsection,
							'semesterid'=>$active_semester[0]->semester_id,
							'studentid'=>$svalue->id,
							'status'=>'r',
							'sessionid'=>$newsessionid
						);
						$this->operation->table_name = 'student_semesters';

						$id = $this->operation->Create($studentresult);

						if(count($id))
						{
							$sresult['message'] = true;
						}
					}
				}
			}
		}
		echo json_encode($sresult);
	}

	function GetSessionList()
	{
		$this->operation->table_name = 'sessions';

		$sessionarray = array();
		if($this->input->get('inputsessionid')){
			$sessionlist = $this->operation->GetByWhere(array('id'=>$this->input->get('inputsessionid')));
			if(count($sessionlist))
			{
				foreach ($sessionlist as $key => $value) {
					$sessionarray = array(
						'id'=>$value->id,
						'from'=>date('m/d/Y',strtotime($value->datefrom)),
						'to'=>date('m/d/Y',strtotime($value->dateto)),
						'status'=>$value->status,
					);
				}
			}
		}else{
			$locations = $this->session->userdata('locations');
			$sessionlist = $this->operation->GetByWhere(array('school_id'=>$locations[0]['school_id']));

			if(count($sessionlist))
			{
				foreach ($sessionlist as $key => $value) {
					$sessionarray[] = array(
						'id'=>$value->id,
						'from'=>date('m/d/Y',strtotime($value->datefrom)),
						'to'=>date('m/d/Y',strtotime($value->dateto)),
						'status'=>$value->status,
					);
				}
			}
		}
		echo json_encode($sessionarray);
	}

	function GetSessionDetail()
	{
		$this->operation->table_name = 'sessions';

		$sessionarray = array();
		$this->operation->order_by = 'desc';
		$locations = $this->session->userdata('locations');
		$sessionlist = $this->operation->GetByWhere(array('school_id'=>$locations[0]['school_id']));

		if(count($sessionlist))
		{
			foreach ($sessionlist as $key => $value) {
				$sessionarray[] = array(
					'id'=>$value->id,
					'name'=>date('M d, Y',strtotime($value->datefrom)).' - '.date('M d, Y',strtotime($value->dateto)),
				);
			}
		}
		echo json_encode($sessionarray);
	}

	function SaveSession()
	{
		$request = json_decode( file_get_contents('php://input'));
		$inputstartdate = $this->security->xss_clean(trim($request->inputstartdate));
		$inputenddate = $this->security->xss_clean(trim($request->inputenddate));
		$inputsessionid = $this->security->xss_clean(trim($request->inputsessionid));

		$sresult['message'] = false;
		$locations = $this->session->userdata('locations');
		if(!is_null($inputstartdate) && !is_null($inputenddate))
		{
			$this->operation->table_name = 'sessions';
			if(!is_null($inputsessionid) && !empty($inputsessionid)){
				$sessionarray = array(
					'datefrom'=>date('Y-m-d',strtotime($inputstartdate)),
					'dateto'=>date('Y-m-d',strtotime($inputenddate)),
					'datetime'=>date('Y-m-d'),
					'school_id'=>$locations[0]['school_id']
				);

				$id = $this->operation->Create($sessionarray,$inputsessionid);
				if(count($id))
				{
					$sresult['message'] = true;
				}
			}
			else{

				$sessionarray = array(
					'datefrom'=>date('Y-m-d',strtotime($inputstartdate)),
					'dateto'=>date('Y-m-d',strtotime($inputenddate)),
					'datetime'=>date('Y-m-d'),
					'status'=>'i',
					'school_id'=>$locations[0]['school_id']
				);

				$id = $this->operation->Create($sessionarray);
				if(count($id))
				{
					$sresult['message'] = true;

				}
			}

		}
		echo json_encode($sresult);
	}

	function RemoveSession()
	{
		$sresult['message'] = false;
		if($this->input->get('inputsessionid'))
		{
			$this->operation->table_name = 'sessions';
			$this->operation->Remove($this->input->get('inputsessionid'));
			$sresult['message'] = true;
		}
		echo json_encode($sresult);
	}

	function RemoveSemesterDate()
	{
		$sresult['message'] = false;
		$request = json_decode( file_get_contents('php://input'));
		$id = $this->security->xss_clean(trim($request->id));
		if($id)
		{
			$this->operation->table_name = 'semester_dates';
			$this->operation->Remove($id);
			$sresult['message'] = true;
		}
		echo json_encode($sresult);
	}

	function RemoveSection()
	{
		$sresult['message'] = false;
		if($this->input->get('inputsectionid'))
		{
			$this->operation->table_name = 'sections';
			$this->operation->Remove($this->input->get('inputsectionid'));
			$sresult['message'] = true;
		}
		echo json_encode($sresult);
	}

	function RemoveClass()
	{
		$sresult['message'] = false;
		if($this->input->get('inputclassid'))
		{
			$this->operation->table_name = 'classes';
			$this->operation->Remove($this->input->get('inputclassid'));
			$sresult['message'] = true;
		}
		echo json_encode($sresult);
	}



	function GetScheduleSection()
	{
		$this->operation->table_name = 'sections';

		$sessionarray = array();
		if(!is_null($this->input->get('inputsectionid'))){
			$sessionlist = $this->operation->GetByWhere(array('id'=>$this->input->get('inputsectionid')));
			if(count($sessionlist))
			{
				foreach ($sessionlist as $key => $value) {
					$sessionarray[] = array(
						'id'=>$value->id,
						'name'=>$value->section_name,
					);
				}
			}
		}

		echo json_encode($sessionarray);
	}

	function GetScheduleSubject()
	{
		$this->operation->table_name = 'subjects';

		$sessionarray = array();
		if(!is_null($this->input->get('inputsubjectid'))){
			$sessionlist = $this->operation->GetByWhere(array('id'=>$this->input->get('inputsubjectid')));
			if(count($sessionlist))
			{
				foreach ($sessionlist as $key => $value) {
					$sessionarray[] = array(
						'id'=>$value->id,
						'name'=>$value->subject_name,
					);
				}
			}
		}

		echo json_encode($sessionarray);
	}

	function GetSection()
	{
		$this->operation->table_name = 'sections';

		$sectionarray = array();

		$locations = $this->session->userdata('locations');
		$roles = $this->session->userdata('roles');
		if($roles[0]['role_id'] == 3)
		{
			if($this->input->get('inputsectionid')){
				$sectionlist = $this->operation->GetRowsByQyery("Select s.* from sections s  where  s.id =".$this->input->get('inputsectionid'));
				//$sectionlist = $this->operation->GetRowsByQyery("Select s.*,asi.classid, '' as classname from sections s INNER JOIN assignsections asi ON asi.sectionid = s.id  where  s.id =".$this->input->get('inputsectionid'));
			}
			else{
				$sectionlist = $this->operation->GetRowsByQyery("Select s.* from sections s where school_id=".$locations[0]['school_id']);
				// $sectionlist = $this->operation->GetRowsByQyery("Select s.*,asi.classid,c.grade as classname from sections s INNER JOIN assignsections asi ON asi.sectionid = s.id INNER JOIN classes c ON c.id = asi.classid where  c.school_id =".$locations[0]['school_id']);
			}
		}


		if(count($sectionlist))
		{
			foreach ($sectionlist as $key => $value) {
				$sectionarray[] = array(
					'id'=>$value->id,
					'name'=>$value->section_name,
					'class'=>$value->classid,
					'classname'=>$value->classname,
				);
			}
		}
		echo json_encode($sectionarray);
	}

	// function SaveSection()
	// {
	// 	$request = json_decode( file_get_contents('php://input'));
	// 	$inputsectionname = $this->security->xss_clean(trim($request->inputsectionname));
	// 	$inputsectionid = $this->security->xss_clean(trim($request->inputsectionid));

	// 	$sresult['message'] = false;

	// 	if(!is_null($inputsectionname))
	// 	{
	// 		$this->operation->table_name = 'sections';
	// 		if(!is_null($inputsectionid) && !empty($inputsectionid)){
	// 			$sessionarray = array(
	// 				'datefrom'=>$inputstartdate,
	// 				'dateto'=>$inputenddate,
	// 				'datetime'=>date('Y-m-d'),
	// 			);

	// 			$id = $this->operation->Create($sessionarray,$inputsessionid);
	// 			if(count($id))
	// 			{
	// 				$sresult['message'] = true;
	// 			}
	// 		}
	// 		else{
	// 			$sessionarray = array(
	// 				'section_name'=>$inputstartdate,
	// 				'dateto'=>$inputenddate,
	// 				'datetime'=>date('Y-m-d'),
	// 			);

	// 			$id = $this->operation->Create($sessionarray);
	// 			if(count($id))
	// 			{
	// 				$sresult['message'] = true;

	// 			}
	// 		}

	// 	}
	// 	echo json_encode($sresult);
	// }

	function SaveSection()
	{
		$request = json_decode( file_get_contents('php://input'));
		$inputsectionname = $this->security->xss_clean(trim($request->inputsectionname));
		$inputsectionid = $this->security->xss_clean(trim($request->inputsectionid));
		$inputclassid = $this->security->xss_clean(trim($request->inputclassid));

		$sresult['message'] = false;
		$locations = $this->session->userdata('locations');
		if(!is_null($inputsectionname) && !is_null($inputclassid))
		{
			$this->operation->table_name = 'sections';
			if(!is_null($inputsectionid) && !empty($inputsectionid)){
				$sessionarray = array(
					'section_name'=>$inputsectionname,
					'last_update'=>date('Y-m-d'),
				);

				$id = $this->operation->Create($sessionarray,$inputsectionid);
				if(count($id))
				{
					$this->operation->table_name = 'assignsections';
					$sessionarray = array(
						'classid'=>$inputclassid,
					);
					$this->operation->primary_key = 'sectionid';
					$id = $this->operation->Create($sessionarray,$inputsectionid);

					$sresult['message'] = true;
				}
			}
			else{
				$sessionarray = array(
					'section_name'=>$inputsectionname,
					'last_update'=>date('Y-m-d'),
					'school_id'=>$locations[0]['school_id']
				);
				$id = $this->operation->Create($sessionarray);
				if(count($id))
				{
					// $this->operation->table_name = 'assignsections';
					// $sessionarray = array(
					// 	'classid'=>$inputclassid,
					// 	'sectionid'=>$id,
					// 	'status'=>'a',
					// );

					// $id = $this->operation->Create($sessionarray);
					$sresult['message'] = true;

				}
			}

		}
		echo json_encode($sresult);
	}

	function Semester()
	{
		Ips::isUserLoginOrNot();
		$this->load->view('principal/semester',$this->data);
	}

	function SaveSemester()
	{
	 $countSemester=$this->operation->GetRowsByQyery("Select * from semester");
		$request = json_decode( file_get_contents('php://input'));
		$data = $this->security->xss_clean(trim($request));
		$inputsemestername = $this->security->xss_clean(trim($request->inputsemestername));
		$inputsemesterid = $this->security->xss_clean(trim($request->inputsemesterid));

		$sresult['message'] = false;

		if(count($countSemester)<2 &&!is_null($inputsemestername) && $inputsemesterid == 0 && is_numeric($inputsemesterid))
		{
			$this->operation->table_name = 'semester';
			$studentresult = array(
				'semester_name'=>$inputsemestername,
				'created'=>date('Y-m-d'),
				'modified'=>date('Y-m-d'),
				'status'=>'i',
			);

			$id = $this->operation->Create($studentresult);

			if(count($id))
			{
				$sresult['message'] = true;
			}
		}
		else if(count($countSemester)>=1 && $inputsemesterid == 0)
		{
			$sresult['greater'] ='Greater';
		}

		if(!is_null($inputsemestername) && !is_null($inputsemesterid) && is_numeric($inputsemesterid))
		{
			$this->operation->table_name = 'semester';
			$studentresult = array(
				'semester_name'=>$inputsemestername,
				'modified'=>date('Y-m-d'),
				'status'=>'i',
			);

			$id = $this->operation->Create($studentresult,$inputsemesterid);

			if(count($id))
			{
				$sresult['message'] = true;
			}
		}

		echo json_encode($sresult);
	}

	function ChangeSemesterStatus()
	{
		$request = json_decode( file_get_contents('php://input'));
		$data = $this->security->xss_clean(trim($request));
		$inputsetcurrentsemester = $this->security->xss_clean(trim($request->inputsetcurrentsemester));

		$sresult['message'] = false;

		if($inputsetcurrentsemester != 0 && is_numeric($inputsetcurrentsemester))
		{
			$this->db->query("Update semester set status = 'i'");
			$this->operation->table_name = 'semester';
			$studentresult = array(
				'modified'=>date('Y-m-d'),
				'status'=>'a',
			);

			$id = $this->operation->Create($studentresult,$inputsetcurrentsemester);

			if(count($id))
			{
				$sresult['message'] = true;
			}
		}
		echo json_encode($sresult);
	}

	function RemoveSemester()
	{
		$sresult['message'] = false;
		if($this->input->get('inputsemesterid'))
		{
			$this->operation->table_name = 'semester';
			$this->operation->primary_key = 'id';
			$this->operation->Remove($this->input->get('inputsemesterid'));
			$sresult['message'] = true;
		}
		echo json_encode($sresult);
	}

	function sendlmsapi()
	{
		 // $curl = curl_init();
		 // $lesson_progress = array(
		 // 	'student_roll_no'=>'Lhr-01-2017-001',
		 // 	'lesson_id'=>'1216',
		 // 	'lesson_read'=>1,
		 // 	'lesson_count'=>1,
		 // );

   //          curl_setopt($curl, CURLOPT_URL, 'http://192.168.1.2/invantage/wc/learninginvantage/v1/lmsapi/SetLessonProgress/format/json');
   //                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
   //          curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array('lesson_progress'=>$lesson_progress)));
   //          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   //          curl_setopt($curl, CURLOPT_TIMEOUT, 10);
   //          curl_setopt ($curl,CURLOPT_VERBOSE,false);
   //          curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
   //          curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
   //          $curlData = curl_exec($curl);

   //          if(curl_errno($curl))
   //          {
   //              print_r(curl_error($curl));
   //          }
   //          else{
   //              print_r( json_decode($curlData));
   //          }
   //          curl_close($curl);

	}

	function LoadVersion()
	{

		$this->load->view('version/versions',$this->data);
	}

	function SaveVersion()
	{

		$result['message'] = false;
		$newid = 0;
		$this->operation->table_name = 'versions';
		if(!is_null($this->input->post('inputversion')))
		{
			$this->db->query("Update versions set status = 'i'");

			if(!is_null($this->input->post('inputversionid'))  && $this->input->post('inputversionid') > 0){

				$version_info = array(
					'version'=>$this->input->post('inputversion'),
					'description'=>$this->input->post('inputdescription'),
				);

				$id = $this->operation->Create($version_info,$this->input->post('inputversionid'));
				if(count($id))
				{
					$newid = $id;
					$result['message'] = true;
				}
			}
			else{
				$version_info = array(
					'version'=>$this->input->post('inputversion'),
					'description'=>$this->input->post('inputdescription'),
					'status'=>'a',
					'file_name'=>'',
					'app_url'=>''
				);


				$id = $this->operation->Create($version_info);

				if(count($id))
				{
					$newid = $id;
				}
			}

		}

		if(isset($_FILES) == 1){
			// Save in database
			foreach ($_FILES as $key => $value) {
				$valid_formats = array("apk","png");
		        if(strlen($value['name'])){
		            list($txt, $ext) = explode(".", $value['name']);
		            if(in_array(strtolower($ext),$valid_formats)){
		            	if ($value["size"] < 30000000) {
	 						if(is_uploaded_file($value['tmp_name'])){
	 							$path = $_SERVER['DOCUMENT_ROOT']."/invantage/wc/learninginvantage/v1/upload/appfolder/";
	 							$filename = $path.basename($value['name']);
	 							if(move_uploaded_file($value['tmp_name'],$filename)){
							 		chmod($filename, 0777);
							 		$version_info = array(
										'file_name'=>basename($value['name']),
										'app_url'=>$filename
									);

									$this->operation->table_name = 'versions';
									$id = $this->operation->Create($version_info,$newid);
									if(count($id))
									{
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

	function GetVesionList()
	{
		$this->operation->table_name = 'versions';

		$versionarray = array();
		if($this->input->get('inputversionid')){
			$versioninfo = $this->operation->GetByWhere(array('id'=>$this->input->get('inputversionid')));
			if(count($versioninfo))
			{
				foreach ($versioninfo as $key => $value) {
					$versionarray[] = array(
						'id'=>$value->id,
						'version'=>$value->version,
						'description'=>$value->description,
						'status'=>$value->status,
					);
				}
			}
		}else{
			$versioninfo = $this->operation->GetRows();

			if(count($versioninfo))
			{
				foreach ($versioninfo as $key => $value) {
					$versionarray[] = array(
						'id'=>$value->id,
						'version'=>$value->version,
						'description'=>$value->description,
						'status'=>$value->status,
					);
				}
			}
		}

		echo json_encode($versionarray);
	}

	function ChangeVersionStatus()
	{
		$request = json_decode( file_get_contents('php://input'));
		$data = $this->security->xss_clean(trim($request));
		$inputsetcurrentversion = $this->security->xss_clean(trim($request->inputsetcurrentversion));

		$sresult['message'] = false;

		if($inputsetcurrentversion != 0 && is_numeric($inputsetcurrentversion))
		{
			$this->db->query("Update versions set status = 'i'");
			$this->operation->table_name = 'versions';
			$versioninfo = array(
				'status'=>'a',
			);

			$id = $this->operation->Create($versioninfo,$inputsetcurrentversion);

			if(count($id))
			{
				$sresult['message'] = true;
			}
		}
		echo json_encode($sresult);
	}


	function RemoveVersion()
	{

		$sresult['message'] = false;
		if($this->input->get('inputversionid'))
		{
			$this->operation->table_name = 'versions';
			$this->operation->primary_key = 'id';
			$this->operation->Remove($this->input->get('inputversionid'));
			$sresult['message'] = true;
		}
		echo json_encode($sresult);
	}

	function SaveAssignSection()
	{
		$request = json_decode( file_get_contents('php://input'));
		$inputclassid = $this->security->xss_clean(trim($request->inputclassid));
		$inputsection = $this->security->xss_clean(trim($request->inputsection));

		$sresult['message'] = false;

		if(!is_null($inputclassid)  && !is_null($inputsection))
		{
			foreach ($request->inputsection as $key => $value) {
				$this->operation->table_name = 'sections';
				$locations = $this->session->userdata('locations');
				$is_section_found = $this->operation->GetByWhere(array('section_name'=>$value->id,'school_id'=>$locations[0]['school_id']));
				
				$this->operation->table_name = 'assignsections';

				$is_section_found_in_assi_table = $this->operation->GetByWhere(array('classid' => $inputclassid, 'sectionid'=>$is_section_found[0]->id));
				
				if(count($is_section_found_in_assi_table) == 0){
				
					$studentresult = array(
						'classid'=>$inputclassid,
						'sectionid'=>$is_section_found[0]->id,
						'status'=>($value->status == 1 ? 'a':'i'),
					);
					$id = $this->operation->Create($studentresult);
				}
				else{
					//$is_asssectionid_found = $this->operation->GetRowsByQyery("Select assi.id as assignedsectionid  from assignsections assi INNER JOIN sections s ON s.id = assi.sectionid where  s.section_name  ='".$value->id."'");
					$studentresult = array(
						'status'=>($value->status == 1 ? 'a':'i'),
					);
					$this->operation->table_name = 'assignsections';
					$id = $this->operation->Create($studentresult,$is_section_found_in_assi_table[0]->id);
				
				}
			}

			if(count($id))
			{
				$sresult['message'] = true;
			}
		}
		echo json_encode($sresult);
	}

	function GetSelecteSectionByClass()
	{
		$sectionarray = array();
		if($this->input->get('inputclassid'))
		{
			$section_by_class = $this->operation->GetRowsByQyery("Select assi.*,s.section_name, s.id  from assignsections assi INNER JOIN sections s ON s.id = assi.sectionid where assi.status = 'a' AND assi.classid  =".$this->input->get('inputclassid'));
			if(count($section_by_class))
			{
				foreach ($section_by_class as $key => $value) {
					$sectionarray[] = array(
						'id'=>$value->id,
						'status'=>$value->status,
						'selected'=> ($value->status == 'a' ? true : false),
						'name'=> $value->section_name 
					);
				}
			}
		}
		echo json_encode($sectionarray);
	}

	function ChangeSessionStatus()
	{
		$request = json_decode( file_get_contents('php://input'));
		$inputsetcurrentsession = $this->security->xss_clean(trim($request->inputsetcurrentsession));

		$sresult['message'] = false;

		if($inputsetcurrentsession != 0 && is_numeric($inputsetcurrentsession))
		{
			$locations = $this->session->userdata('locations');
			$this->db->query("Update sessions set status = 'i' where school_id = ".$locations[0]['school_id']);
			$this->operation->table_name = 'sessions';
			$studentresult = array(
				'datetime'=>date('Y-m-d'),
				'status'=>'a',
			);

			$id = $this->operation->Create($studentresult,$inputsetcurrentsession);

			if(count($id))
			{
				$sresult['message'] = true;
			}
		}
		echo json_encode($sresult);
	}

	function SaveQuizImage()
	{

	}

	public function save_quize_Question()
	{

		Ips::isUserLoginOrNot();

		$result['message'] = false;

		$this->form_validation->set_rules('title', 'Title Required', 'trim|min_length[3]|max_length[256]');
		$this->form_validation->set_rules('title_image', 'Description Required', 'trim');
		$this->form_validation->set_rules('inputoption_one', 'Status Required', 'trim');
		$this->form_validation->set_rules('inputoption_two', 'Status Required', 'trim');
		$this->form_validation->set_rules('inputoption_three', 'Status Required', 'trim');
		$this->form_validation->set_rules('inputoption_four', 'Status Required', 'trim');
		$this->form_validation->set_rules('inputoption_true', 'Status Required', 'trim|required');
		$this->form_validation->set_rules('option_image_1', 'Status Required', 'trim');
		$this->form_validation->set_rules('option_image_2', 'Status Required', 'trim');
		$this->form_validation->set_rules('option_image_3', 'Status Required', 'trim');
		$this->form_validation->set_rules('option_image_4', 'Status Required', 'trim');
		$this->form_validation->set_rules('quiz_id', 'Status Required', 'trim');
		if ($this->form_validation->run() == FALSE){
			$result['message'] = $this->form_validation->run();
		}
		else{
			$this->load->library('image_lib');
			if($this->input->post('questionid')){
				$title_image_name = '';
				$filename_thumb = '';
				$title_image_uploaded = false;

				if(isset($_FILES['title_image'])){
					$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
					if(strlen($_FILES['title_image']['name']))
					{
						list($txt, $ext) = explode(".", strtolower($_FILES['title_image']['name']));
						if(in_array(strtolower($ext),$valid_formats)){
							if ($_FILES['title_image']["size"] < 5000000) {
								$title_image_name = time().$_FILES['title_image']['name'];

								if(is_uploaded_file($_FILES['title_image']['tmp_name'])){
									$path = UPLOAD_PATH .'quiz_images/';
									$filename = $path.$title_image_name;

									if(move_uploaded_file($_FILES['title_image']['tmp_name'],$filename)){
										$title_image_uploaded = true;
										chmod($filename, 0777);


									    $config = array(
										    'image_library'    	=> 'gd2',
										    'source_image'      => $filename,
										    'new_image'         => $filename,
										    'create_thumb'    	=> true,
										    'maintain_ratio'    => true,
										    'quality' 			=> 100,
										    'width'             => 350,
										    'height'            => 350
									    );
								     	$this->image_lib->initialize($config);
								    	$this->image_lib->resize();

								    	$thumbname = explode('.', $title_image_name);

								    	$quize_array = array(
											'img_src'=>$title_image_name,
											'thumbnail_src'=>$thumbname[0].'_thumb.'.$thumbname[1],
										);
										$this->operation->table_name = 'quizequestions';
										$update_query = $this->operation->Create($quize_array,$this->input->post('questionid'));

									}
								}
							}
						}
					}
				}

				$quize_array = array(
					'question'=>$this->input->post('title'),
					'last_update'=>date("Y-m-d H:i"),
					'type'=>($this->input->post('q_type') == 1 ? 't' :'i'),

				);

				$this->operation->table_name = 'quizequestions';
				$qid = $this->operation->Create($quize_array,$this->input->post('questionid'));

				if($this->input->post('q_type') == 1){
					$option_name = array('inputoption_one','inputoption_two','inputoption_three','inputoption_four');
					$optionlist = $this->operation->GetRowsByQyery("SELECT o.* FROM qoptions o INNER JOIN quizeoptions qo ON o.id = qo.qoption_id where qo.questionid =".$this->input->post('questionid')." order by id asc");
					for ($i=0; $i <= count($optionlist) - 1 ; $i++) {

						$cur_iter = $i + 1;
						$option_array = array(
							'option_value'=> $this->input->post($option_name[$i]),
							'edited'=>date("Y-m-d H:i"),
						);

						$this->operation->table_name = 'qoptions';
						$qoid = $this->operation->Create($option_array,$optionlist[$i]->id);

						$this->operation->table_name = "correct_option";
						$correct_option_is_found = $this->operation->GetByWhere(array('question_id'=>$this->input->post('questionid')));
						if($this->input->post('inputoption_true') == $cur_iter && count($correct_option_is_found))
						{
							$correct_option = array(
								'correct_id'=> $qoid,
								'question_id'=> $qid,
							);

							$this->operation->table_name = 'correct_option';
							$correct_id = $this->operation->Create($correct_option,$correct_option_is_found[0]->id);
						}
					}
				}


				$optionlist = $this->operation->GetRowsByQyery("SELECT o.* FROM qoptions o INNER JOIN quizeoptions qo ON o.id = qo.qoption_id where qo.questionid =".$this->input->post('questionid')." order by id asc");
				for ($i=0; $i <= count($optionlist) - 1 ; $i++) {

					$cur_iter = $i + 1;

					$this->operation->table_name = "correct_option";
					$correct_option_is_found = $this->operation->GetByWhere(array('question_id'=>$this->input->post('questionid')));
					if($this->input->post('inputoption_true') == $cur_iter)
					{
						$correct_option = array(
							'correct_id'=> $optionlist[$i]->id,
						);

						$this->operation->table_name = 'correct_option';
						$correct_id = $this->operation->Create($correct_option,$correct_option_is_found[0]->id);
					}
				}

				if($this->input->post('q_type') == 2){
					$optionlist = $this->operation->GetRowsByQyery("SELECT o.* FROM qoptions o INNER JOIN quizeoptions qo ON o.id = qo.qoption_id where qo.questionid =".$this->input->post('questionid')." order by id asc");
					$option_imag_name = array('option_image_1','option_image_2','option_image_3','option_image_4');
					for ($i=0; $i < 4 ; $i++) {

						if(isset($_FILES[$option_imag_name[$i]])){
							$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
							if(strlen($_FILES[$option_imag_name[$i]]['name']))
							{
								list($txt, $ext) = explode(".", strtolower($_FILES[$option_imag_name[$i]]['name']));
								if(in_array(strtolower($ext),$valid_formats))
								{
									if ($_FILES[$option_imag_name[$i]]["size"] < 5000000)
									{
										$title_image_name = time().$_FILES[$option_imag_name[$i]]['name'];
										;
										$biger_thumbnail = time().trim(basename($txt."bigger_thumb.".$ext));
										if(is_uploaded_file($_FILES[$option_imag_name[$i]]['tmp_name']))
										{
											$path = UPLOAD_PATH .'option_images/';
											$filename = $path.$title_image_name;

											if(move_uploaded_file($_FILES[$option_imag_name[$i]]['tmp_name'],$filename))
											{
												$title_image_uploaded = true;
												chmod($filename, 0777);


									    		$config = array(
												    'image_library'    	=> 'gd2',
												    'source_image'      => $filename,
												    'new_image'         => $filename,
												    'create_thumb'    	=> true,
												    'maintain_ratio'    => true,
												    'quality' 			=> 100,
												    'width'             => 350,
												    'height'            => 350
											    );
									     		$this->image_lib->initialize($config);
									    		$this->image_lib->resize();

									    		$cur_iter = $i + 1;
												$option_array = array(
													'option_value'=>$title_image_name,
													'created'=>date("Y-m-d H:i"),
													'edited'=>date("Y-m-d H:i"),
													'thumbnail_src'=>$biger_thumbnail,
												);

												$this->operation->table_name = 'qoptions';
												$qoid = $this->operation->Create($option_array,$optionlist[$i]->id);
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
			else if($this->input->post('quiz_id'))
			{
				// add question
				$title_image_name = '';
				$filename_thumb = '';
				$title_image_uploaded = false;

				if(isset($_FILES['title_image'])){
					$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
					if(strlen($_FILES['title_image']['name']))
					{
						list($txt, $ext) = explode(".", strtolower($_FILES['title_image']['name']));
						if(in_array(strtolower($ext),$valid_formats)){
							if ($_FILES['title_image']["size"] < 5000000) {
								$title_image_name = time().$_FILES['title_image']['name'];

								if(is_uploaded_file($_FILES['title_image']['tmp_name'])){
									$path = UPLOAD_PATH .'quiz_images/';
									$filename = $path.$title_image_name;

									if(move_uploaded_file($_FILES['title_image']['tmp_name'],$filename)){
										$title_image_uploaded = true;
										chmod($filename, 0777);


									    $config = array(
										    'image_library'    	=> 'gd2',
										    'source_image'      => $filename,
										    'new_image'         => $filename,
										    'create_thumb'    	=> true,
										    'maintain_ratio'    => true,
										    'quality' 			=> 100,
										    'width'             => 350,
										    'height'            => 350
									    );
								     	$this->image_lib->initialize($config);
								    	$this->image_lib->resize();
									}
								}
							}
						}
					}
				}

				$thumbname = explode('.', $title_image_name);

				$quize_array = array(
					'quizeid'=>$this->input->post('quiz_id'),
					'question'=>$this->input->post('title'),
					'last_update'=>date("Y-m-d H:i"),
					'img_src'=>$title_image_name,
					'thumbnail_src'=>$thumbname[0].'_thumb.'.$thumbname[1],
					'type'=>($this->input->post('q_type') == 1 ? 't' :'i'),
				);

				$this->operation->table_name = 'quizequestions';
				$qid = $this->operation->Create($quize_array);

				if($this->input->post('q_type') == 1){
					$option_name = array('inputoption_one','inputoption_two','inputoption_three','inputoption_four');
					for ($i=0; $i < 4 ; $i++) {
						$cur_iter = $i + 1;
						$option_array = array(
							'option_value'=> $this->input->post($option_name[$i]),
							'created'=>date("Y-m-d H:i"),
							'edited'=>date("Y-m-d H:i"),
						);

						$this->operation->table_name = 'qoptions';
						$qoid = $this->operation->Create($option_array);

						$qoption_array = array(
							'questionid'=> $qid,
							'qoption_id'=>$qoid,
							'last_update'=>date("Y-m-d H:i"),
							'created'=>date("Y-m-d H:i"),
						);

						$this->operation->table_name = 'quizeoptions';
						$q_option_id = $this->operation->Create($qoption_array);

						if($this->input->post('inputoption_true') == $cur_iter)
						{
							$correct_option = array(
								'correct_id'=> $qoid,
								'question_id'=> $qid,
							);

							$this->operation->table_name = 'correct_option';
							$correct_id = $this->operation->Create($correct_option);
						}
					}
				}

				if($this->input->post('q_type') == 2){

					$option_imag_name = array('option_image_1','option_image_2','option_image_3','option_image_4');
					for ($i=0; $i < 4 ; $i++) {

						if(isset($_FILES[$option_imag_name[$i]])){
							$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");

							if(strlen($_FILES[$option_imag_name[$i]]['name']))
							{
								list($txt, $ext) = explode(".", strtolower($_FILES[$option_imag_name[$i]]['name']));
								if(in_array(strtolower($ext),$valid_formats))
								{
									if ($_FILES[$option_imag_name[$i]]["size"] < 5000000)
									{
										$title_image_name = time().$_FILES[$option_imag_name[$i]]['name'];
										;
										$biger_thumbnail = time().trim(basename($txt."bigger_thumb.".$ext));
										if(is_uploaded_file($_FILES[$option_imag_name[$i]]['tmp_name']))
										{
											$path = UPLOAD_PATH .'option_images/';
											$filename = $path.$title_image_name;

											if(move_uploaded_file($_FILES[$option_imag_name[$i]]['tmp_name'],$filename))
											{
												$title_image_uploaded = true;
												chmod($filename, 0777);



									    		$config = array(
												    'image_library'    	=> 'gd2',
												    'source_image'      => $filename,
												    'new_image'         => $filename,
												    'create_thumb'    	=> true,
												    'maintain_ratio'    => true,
												    'quality' 			=> 100,
												    'width'             => 350,
												    'height'            => 350
											    );

									     		$this->image_lib->initialize($config);
									    		$this->image_lib->resize();

									    		$cur_iter = $i + 1;
												$option_array = array(
													'option_value'=>$title_image_name,
													'created'=>date("Y-m-d H:i"),
													'edited'=>date("Y-m-d H:i"),
													'thumbnail_src'=>$biger_thumbnail,
												);

												$this->operation->table_name = 'qoptions';
												$qoid = $this->operation->Create($option_array);

												$qoption_array = array(
													'questionid'=> $qid,
													'qoption_id'=>$qoid,
													'last_update'=>date("Y-m-d H:i"),
													'created'=>date("Y-m-d H:i"),
												);

												$this->operation->table_name = 'quizeoptions';
												$q_option_id = $this->operation->Create($qoption_array);

												if($this->input->post('inputoption_true') == $cur_iter)
												{
													$correct_option = array(
														'correct_id'=> $qoid,
														'question_id'=> $qid,
													);

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
		}
		echo json_encode($result);
	}

	function loadweather()
	{
			if($this->uri->segment(2) AND $this->uri->segment(2) != "page" ){

			$schedule_single = $this->operation->GetRowsByQyery("Select * from quize where id= ".$this->uri->segment(2));

			$this->data['schedule_single'] = $schedule_single;
		}

		$this->operation->table_name = "subjects";

		$subjectslist = $this->operation->GetRows();

		$subjects = array();

		if(count($subjectslist))

		{

			foreach ($subjectslist as $key => $value) {

				$subjects[] = array(

					'subid'=>$value->id,

					'name'=>$value->subject_name,

					'class'=>parent::getClassInfo($value->class_id),

				);

			}

		}



		if( $this->session->userdata('type')=='p') {

		$classlist = $this->operation->GetRowsByQyery("SELECT  * FROM classes c");

	    } else if ($this->session->userdata('type')=='t' OR $this->session->userdata('is_master_teacher') == '1') {

	    	$classlist = $this->operation->GetRowsByQyery("SELECT c.id as classid,c.grade FROM schedule sch INNER JOIN classes c on c.id = sch.class_id  WHERE sch.teacher_uid = ".$this->session->userdata('id')." GROUP by c.id ORDER by c.id asc");



	    }

	   $this->data['classlist'] = $classlist;

		$this->data['sectionlist'] = $this->operation->GetRowsByQyery("SELECT  s.*,ass.id as sid FROM sections s INNER JOIN assignsections ass on ass.sectionid = s.id  where ass.status = 'a' AND ass.classid =".$classlist[0]->classid);

		$this->data['subjects'] = $subjects;
		$this->load->view('teacher/exam',$this->data);
	}

	function GetQuizList()
	{
		if($this->session->userdata('type') == 'p')

	 	{

 			$quiz_list = $this->operation->GetRowsByQyery("SELECT q.id,grade,section_name,subject_name,qname,isdone from quize q INNER JOIN classes c on q.classid=c.id INNER JOIN sections sc on q.sectionid=sc.id INNER JOIN subjects sb on q.subjectid=sb.id");
		}
		else if ($this->session->userdata('type') == 't')
		 {

			$quiz_list = $this->operation->GetRowsByQyery("SELECT q.id,grade,section_name,subject_name,qname,isdone from quize q INNER JOIN classes c on q.classid=c.id INNER JOIN sections sc on q.sectionid=sc.id INNER JOIN subjects sb on q.subjectid=sb.id

			INNER join schedule sch on q.classid=sch.class_id and q.sectionid=sch.section_id where sch.teacher_uid=".$this->session->userdata('id')." group by q.id");
		}
		$quizarray = array();
		if(count($quiz_list))
		{
			foreach ($quiz_list as $key => $value) {
				$quizarray[] = array(
					'id'=>$value->id,
					'class'=>$value->grade." (".$value->section_name.")",
					'quiz'=>ucwords($value->subject_name),
					'question'=>$value->qname
				);
			}
		}

		echo json_encode($quizarray);
	}


	function loadform()
	{

		$this->load->view('form');
	}


	/**
	*	Return schedule including hard coded assembly and break timings for KG and Other classes
	*/
	function DashboardSchedule()
	{
	    try{
	          date_default_timezone_set("Asia/Karachi");
		    $roles = $this->session->userdata('roles');
		    $locations = $this->session->userdata('locations');

		    $active_session = parent::GetUserActiveSession();
	

        	$active_semester = parent::GetCurrentSemesterData($active_session[0]->id);

	 	$schedule = array();
  		$class_array = array();
   		$kindergarten_section = array();
   		$rest_section = array();
    
       	if( $roles[0]['role_id'] == 3 && count($active_session) && count($active_semester)){
	 		$query = $this->operation->GetRowsByQyery("SELECT sch.* FROM schedule sch  Where sch.semesterid = ".$active_semester[0]->semester_id." AND sch.sessionid =".$active_session[0]->id." Order by sch.id,sch.start_time");
		   	if(count($query))
		   	{
		   	    $is_yellow_section_found = false;
		   		foreach ($query as $key => $value) {
		   			
		   			// add assembly to each class
					$grade = parent::getClass($value->class_id);
					$section = parent::getSectionList($value->section_id);
					$subject = parent::GetSubject($value->subject_id);
					$teacher = parent::GetUserById($value->teacher_uid);
					$is_class_found = in_array($grade,$class_array);
                
		   			if($is_class_found == false && date('H:i',$value->start_time) >= date('H:i',DateTime::createFromFormat('H:i', "8:00")))
		   			{
		   				array_push($class_array, $grade);
		   				$schedule[] = array(
			   				'grade'=>$grade,
			   				'section_name'=>$section[0]->section_name,
			   				'subject_name'=>"Assembly",
			   				'screenname'=>"Assembly",
			   				'start_time'=>"8:00",
			   				'end_time'=>"8:20",
			   			);
		   			}
		   			/*
		   			if( $grade == 'Kindergarten' && $is_yellow_section_found == false && $section[0]->section_name == 'Yellow' && date('H:i',$value->start_time) >= date('H:i',DateTime::createFromFormat('H:i', "7:30")))
		   			{
		   				$is_yellow_section_found = true;
		   				$schedule[] = array(
			   				'grade'=>$grade,
			   				'section_name'=>$section[0]->section_name,
			   				'subject_name'=>"Assembly",
			   				'screenname'=>"Assembly",
			   				'start_time'=>"7:30",
			   				'end_time'=>"7:50",
			   			);
		   			}*/

		   			$is_kin_class_found = in_array($section[0]->id,$kindergarten_section);
		   			// break to kindergarten
		   			if($is_kin_class_found == false && $grade == 'Kindergarten' && date('H:i',$value->start_time) >=date( 'H:i' ,DateTime::createFromFormat('H:i', "10:11")))
		   			{
		   				array_push($kindergarten_section, $section[0]->id);
		   				$schedule[] = array(
			   					'grade'=>$grade,
			   				'section_name'=>$section[0]->section_name,
			   				'subject_name'=>"Break",
			   				'screenname'=>"Break",
			   				'start_time'=>"10:11",
			   				'end_time'=>"10:45",
			   			);
			   			$kindergarten_break = true;
		   			}

		   			$is_rest_class_found = in_array($grade,$rest_section);
		   			
		   			// break to rest school
		   			if($is_rest_class_found == false && $grade != 'Kindergarten' && date('H:i',$value->start_time) >= date( 'H:i' ,DateTime::createFromFormat('H:i', "10:11")))
		   			{
		   				array_push($rest_section, $grade);
		   				$schedule[] = array(
			   				'grade'=>$grade,
			   				'section_name'=>$section[0]->section_name,
			   				'subject_name'=>"Break",
			   				'screenname'=>"Break",
			   				'start_time'=>"10:11",
			   				'end_time'=>"10:45",
			   			);
		   			}

		   			$schedule[] = array(
		   				'grade'=>$grade,
		   				'section_name'=>$section[0]->section_name,
		   				'subject_name'=>$subject[0]->subject_name,
		   				'screenname'=>$teacher[0]->screenname,
		   				'start_time'=>date('H:i',$value->start_time),
		   				'end_time'=>date('H:i',$value->end_time),
		   			);
		   		}
		   	}
	   	}
	   	else if( $roles[0]['role_id'] == 4 && count($active_session) && count($active_semester)){
   	 		$query = $this->operation->GetRowsByQyery("SELECT * FROM schedule  Where semesterid = ".$active_semester[0]->semester_id."  AND sessionid =".$active_session[0]->id.
					" AND teacher_uid=".$this->session->userdata('id'));
				
 		 	if(count($query))
		   	{
		   		$is_teacher_assembly_found = false;
		   		$is_teacher_break_found = false;
		   		foreach ($query as $key => $value) {
		   			$grade = parent::getClass($value->class_id);
					$section = parent::getSectionList($value->section_id);
					$subject = parent::GetSubject($value->subject_id);
					$teacher = parent::GetUserById($value->teacher_uid);
		   			if($is_teacher_assembly_found == false && date('H:i',$value->start_time) >= date('H:i',DateTime::createFromFormat('H:i', "8:00")))
		   			{
		   				$schedule[] = array(
			   				'grade'=>"Assembly",
			   				'section_name'=>"Assembly",
			   				'subject_name'=>"Assembly",
			   				'screenname'=>"Assembly",
			   				'start_time'=>"8:00",
			   				'end_time'=>"8:20",
			   			);
			   			$is_teacher_assembly_found = true;
		   			}

		   			if($grade == 'Kindergarten' && $is_teacher_break_found == false && date('H:i',$value->start_time) >= date('H:i',DateTime::createFromFormat('H:i', "10:11")))
		   			{
		   				$schedule[] = array(
			   				'grade'=>"Break",
			   				'section_name'=>"Break",
			   				'subject_name'=>"",
			   				'screenname'=>"Break",
			   				'start_time'=>"10:11",
			   				'end_time'=>"10:45",
			   			);
			   			$is_teacher_break_found = true;
		   			}

		   			if($grade != 'Kindergarten' && $is_teacher_break_found == false && date('H:i',$value->start_time) >= date('H:i',DateTime::createFromFormat('H:i', "10:11")))
		   			{
		   				$schedule[] = array(
			   				'grade'=>"Break",
			   				'section_name'=>"Break",
			   				'subject_name'=>"Break",
			   				'screenname'=>"Break",
			   				'start_time'=>"10:11",
			   				'end_time'=>"10:45",
			   			);
			   			$is_teacher_break_found = true;
		   			}

		   			$schedule[] = array(
		   				'grade'=>$grade,
		   				'section_name'=>$section[0]->section_name,
		   				'subject_name'=>$subject[0]->subject_name,
		   				'screenname'=>$teacher[0]->screenname,
		   				'start_time'=>date('H:i',$value->start_time),
		   				'end_time'=>date('H:i',$value->end_time),
		   			);
		   		}
		   	}

	   	}

	   	echo json_encode($schedule);
	    }
	    catch(Exception $e){}
	  
	}

	function SaveAdminSetting()
	{
		$request = json_decode(file_get_contents('php://input'));

		$inputemail = $this->security->xss_clean(trim($request->inputemail));

		$sresult['message'] = false;

		if(!is_null($inputemail))
		{

			$this->operation->table_name = 'options';
			$is_email_found = $this->operation->GetByWhere(array('option_name'=>'refrence_email'));
			if(count($is_email_found) == 1){
				$option = array(
					'option_name'=>'refrence_email',
					'option_value'=>$inputemail,
				);
				$id = $this->operation->Create($option,$is_email_found[0]->id);
			}
			else{
				$option = array(
					'option_name'=>'refrence_email',
					'option_value'=>$inputemail,
				);
				$id = $this->operation->Create($option);
			}

			if(count($id))
			{
				$sresult['message'] = true;
			}
		}
		echo json_encode($sresult);
	}

	function GetOptions()
	{
		$this->operation->table_name = 'options';
		$is_email_found = $this->operation->GetRows();
		$optionsarray = array();
		if(count($is_email_found))
		{
			foreach ($is_email_found as $key => $value) {
				$optionsarray[] = array(
					'id'=>$value->id,
					'key'=>$value->option_name,
					'value'=>$value->option_value,
				);
			}
		}
		echo json_encode($optionsarray);
	}

	function GetDefaultLessonPlanColumns()
	{
		// $this->operation->table_name = 'options';
		// $this->operation->primary_key = "options";
		// $is_default_lesson_column_found = $this->operation->GetByWhere();
		// $optionsarray = array();
		// if(count($$is_default_lesson_column_found))
		// {
		// 	foreach ($$is_default_lesson_column_found as $key => $value) {
		// 		$optionsarray[] = array(
		// 			'id'=>$value->id,
		// 			'key'=>$value->option_name,
		// 			'value'=>$value->option_value,
		// 		);
		// 	}
		// }
		// echo json_encode($optionsarray);
	}

	function AdminUsers()
	{

		$this->load->view('user/save');
	}

	function update_meta($user_id,$meta_key,$meta_value)
    {
    	$this->db->query("Update ".$this->user->table_name." SET meta_value = '".$meta_value."' WHERE user_id = ".$user_id." AND meta_key = '".$meta_key."'");
    }

	function SaveAdminUser()
	{

		if(!($this->session->userdata('id'))){
			parent::redirectUrl('signin');
		}
		$result['message'] = false;

		$this->form_validation->set_rules('inputFirstName', 'Valid First Name Required', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('inputLastName', 'Valid Last Name Required', 'trim|required|min_length[3]');
		if ($this->form_validation->run() == FALSE){
			$result['message'] =  false;
		}
		else{
			if($this->input->post('serial')){
				$this->operation->table_name = 'invantageuser';
				$adminuser = array(
					'screenname'=>ucwords($this->input->post('inputFirstName'))." ".ucwords($this->input->post('inputLastName')),
					'email'=>$this->input->post('input_teacher_email'),
					'password'=>md5($this->input->post('inputNewPassword')),
					'user_status'=>'a',
					'last_update'=>date('Y-m-d h:i'),
				);

				$this->user->table_name = 'user_meta';
				$this->update_meta($this->input->post('serial'),'admin_firstname',ucwords($this->input->post('inputFirstName')));
				$this->update_meta($this->input->post('serial'),'admin_lastname',ucwords($this->input->post('inputLastName')));
				$this->update_meta($this->input->post('serial'),'admin_gender',$this->input->post('input_t_gender'));
				$this->update_meta($this->input->post('serial'),'admin_phone',$this->input->post('input_pr_phone'));
				$this->update_meta($this->input->post('serial'),'admin_home_primary',$this->input->post('pr_home'));
				$this->update_meta($this->input->post('serial'),'admin_home_secondary',$this->input->post('sc_home'));
				$this->update_meta($this->input->post('serial'),'admin_home_state',$this->input->post('inputProvice'));
				$this->update_meta($this->input->post('serial'),'admin_home_city',$this->input->post('input_city'));
				$this->update_meta($this->input->post('serial'),'admin_home_zipcode',$this->input->post('input_zipcode'));
				$result['message'] = true;
			}

			else {

				if(trim($this->input->post('inputNewPassword')) == trim($this->input->post('inputRetypeNewPassword'))){
					// insert
					if(parent::CheckInvantageUserEmail($this->input->post('input_teacher_email')) == false)
					{
						$username = explode('@', $this->input->post('input_teacher_email'));
						$adminuser = array(
							'username'=>$username[0].base_convert(uniqid(), 10, 36),
							'screenname'=>ucwords($this->input->post('inputFirstName'))." ".ucwords($this->input->post('inputLastName')),
							'email'=>$this->input->post('input_teacher_email'),
							'password'=>md5($this->input->post('inputNewPassword')),
							'user_status'=>'a',
							'registerdate'=>date('Y-m-d h:i'),
							'last_update'=>date('Y-m-d h:i'),
						);

						$is_user_created = $this->user->save($adminuser);

						$this->user->table_name = 'user_roles';
						$user_role = array(
							'role_id'=>1,
							'user_id'=>$is_user_created,
						);

						$role_created = $this->user->save($user_role);

						if ($is_user_created) {

							$this->user->table_name = 'user_meta';

							$userarray = array(
								'user_id'=>$is_user_created,
								'meta_key'=>'admin_firstname',
								'meta_value'=>ucwords($this->input->post('inputFirstName')),
							);
							$this->user->save($userarray);

							$userarray = array(
								'user_id'=>$is_user_created,
								'meta_key'=>'admin_lastname',
								'meta_value'=>ucwords($this->input->post('inputLastName')),
							);
							$this->user->save($userarray);

							$userarray = array(
								'user_id'=>$is_user_created,
								'meta_key'=>'admin_gender',
								'meta_value'=>$this->input->post('input_t_gender'),
							);
							$this->user->save($userarray);

							$userarray = array(
								'user_id'=>$is_user_created,
								'meta_key'=>'admin_phone',
								'meta_value'=>$this->input->post('input_pr_phone'),
							);
							$this->user->save($userarray);

							$userarray = array(
								'user_id'=>$is_user_created,
								'meta_key'=>'admin_home_primary',
								'meta_value'=>$this->input->post('pr_home'),
							);
							$this->user->save($userarray);

							$userarray = array(
								'user_id'=>$is_user_created,
								'meta_key'=>'admin_home_secondary',
								'meta_value'=>$this->input->post('sc_home'),
							);
							$this->user->save($userarray);

							$userarray = array(
								'user_id'=>$is_user_created,
								'meta_key'=>'admin_home_state',
								'meta_value'=>$this->input->post('inputProvice'),
							);
							$this->user->save($userarray);

							$userarray = array(
								'user_id'=>$is_user_created,
								'meta_key'=>'admin_home_city',
								'meta_value'=>$this->input->post('input_city'),
							);
							$this->user->save($userarray);

							$userarray = array(
								'user_id'=>$is_user_created,
								'meta_key'=>'admin_home_zipcode',
								'meta_value'=>$this->input->post('input_zipcode'),
							);
							$this->user->save($userarray);
						}

						$result['message'] =  true;
					}
				}
			}
		}
		echo json_encode($result);
	}

	function CityList()
	{
		$this->operation->table_name = 'location';
		$citylist = $this->operation->GetRows();
		$cityarray = array();
		if(count($citylist))
		{
			foreach ($citylist as $key => $value) {
				$cityarray[] = array(
					'id'=>$value->id,
					'name'=>$value->location,
				);
			}
		}

		if(!is_null($this->input->get('singlecity')))
		{
			$resultlist = $this->operation->GetByWhere(array(
						'id'=>$this->input->get('singlecity'),
					));
			if(count($resultlist))
			{
				$cityarray = array();
				foreach ($resultlist as $key => $value) {
					$cityarray[] = array(
						'id'=>$value->id,
						'name'=>$value->location,
					);
				}
			}
		}

		echo json_encode($cityarray);
	}

	function SaveLocation()
	{
		$request = json_decode( file_get_contents('php://input'));
		$inputlocation = $this->security->xss_clean(trim($request->inputlocation));
		$inputlocationid = $this->security->xss_clean(trim($request->inputlocationid));

		$sresult['message'] = false;
		$this->operation->table_name = 'location';
		if(!empty($inputlocation))
		{
			if(!is_null($inputlocationid) && !empty($inputlocationid)){
				$locationarray = array(
					'location'=>ucfirst($inputlocation),
					'uniquecode'=>strtoupper(substr($inputlocation, 0,2))."_SCHOOL",
				);

				$id = $this->operation->Create($locationarray,$inputlocationid);
				if(count($id))
				{
					$sresult['message'] = true;
				}
			}
			else{
				$locationarray = array(
					'location'=>ucfirst($inputlocation),
					'date'=>date('Y-m-d'),
					'uniquecode'=>strtoupper(substr($inputlocation, 0,2))."_SCHOOL",
				);

				$id = $this->operation->Create($locationarray);
				if(count($id))
				{
					$sresult['message'] = true;
				}
			}
		}
		echo json_encode($sresult);
	}

	function RemoveLocation()
	{
		$sresult['message'] = false;
		if($this->input->get('inputlocationid'))
		{
			$this->operation->table_name = 'location';
			$this->operation->Remove($this->input->get('inputlocationid'));
			$sresult['message'] = true;
		}
		echo json_encode($sresult);
	}

	function SchoolList()
	{
		$this->operation->table_name = 'schools';
		$schoollist = $this->operation->GetRows();
		$schoolarray = array();
		if(count($schoollist))
		{
			foreach ($schoollist as $key => $value) {
				$city = parent::GetLocationDetail($value->cityid);
				$schoolarray[] = array(
					'sid'=>$value->id,
					'sname'=>$value->name,
					'cityname'=>$city->location,
				);
			}
		}

		if(!is_null($this->input->get('singleschool')))
		{
			$resultlist = $this->operation->GetByWhere(array(
						'id'=>$this->input->get('singleschool'),
					));
			if(count($resultlist))
			{
				$schoolarray = array();
				foreach ($resultlist as $key => $value) {
					$city = parent::GetLocationDetail($value->cityid);
					$schoolarray[] = array(
						'sid'=>$value->id,
						'sname'=>$value->name,
						'cityname'=>$city->name,
						'cityid'=>$city->id,
					);
				}
			}
		}



		if(!is_null($this->input->get('tschool')))
		{
			$locations = $this->session->userdata('locations');
			$schoollist = $this->operation->GetByWhere(array(
						'id'=>$locations[0]['school_id'],
					));
			if(count($schoollist))
			{
				$schoolarray = array();
				foreach ($schoollist as $key => $value) {
					$city = parent::GetLocationDetail($value->cityid);
					$schoolarray[] = array(
						'sid'=>$value->id,
						'sname'=>$value->name." (".$city->location.")",
					);
				}
			}
		}

		echo json_encode($schoolarray);
	}

	function SaveSchool()
	{
		$request = json_decode( file_get_contents('php://input'));
		$inputschoolname = $this->security->xss_clean(trim($request->inputschoolname));
		$inputlocationid = $this->security->xss_clean(trim($request->inputlocationid));
		$inputschoolid = $this->security->xss_clean(trim($request->inputschoolid));

		$sresult['message'] = false;
		$this->operation->table_name = 'schools';
		if(!is_null($inputschoolname) && !is_null($inputlocationid))
		{
			if(!is_null($inputschoolid) && !empty($inputschoolid)){
				$schoolarray = array(
					'name'=>ucfirst($inputschoolname),
					'shortname'=>substr(ucfirst($inputschoolname), 0,2),
					'cityid'=>$inputlocationid,
				);

				$id = $this->operation->Create($schoolarray,$inputschoolid);
				if(count($id))
				{
					$sresult['message'] = true;
				}
			}
			else{
				$schoolarray = array(
					'name'=>ucfirst($inputschoolname),
					'shortname'=>substr(ucfirst($inputschoolname), 0,2),
					'cityid'=>$inputlocationid,
				);

				$id = $this->operation->Create($schoolarray);
				if(count($id))
				{
						$this->operation->table_name = 'wizard';
						$wizard = array(
							'school_id'=>$id,
							'user_type'=>3,
							'created'=>date('Y-m-d'),
							'edited'=>date('Y-m-d'),
							'status'=>'y',
					);
						$id = $this->operation->Create($wizard);
					$sresult['message'] = true;
				}
			}
		}
		echo json_encode($sresult);
	}

	function RemoveSchool()
	{
		$sresult['message'] = false;
		if($this->input->get('inputschoolid'))
		{
			$this->operation->table_name = 'schools';
			$this->operation->Remove($this->input->get('inputschoolid'));
			$sresult['message'] = true;
		}
		echo json_encode($sresult);
	}

	function Schedular()
	{
		$this->load->view('schedular/schedular',$this->data);
	}


	function DateSchedular()
	{		
		$this->load->view('schedular/date_schedular');
	}

	public function UserInfo()
	{
		$userarray = array();
		if(!is_null($this->input->get('userinfo')))
		{
			$locationid = parent::GetUserSchool($this->input->get('userinfo'));
			$profile_link = parent::GetUserById($this->input->get('userinfo'));
			$userarray= array(
				'teacher_firstname'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_firstname') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_firstname') : ''),
				'teacher_lastname'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_lastname') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_lastname') : ''),
				'gender'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_gender') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_gender') : ''),
				'nic'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_nic') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_nic') : ''),
				'teacher_religion'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_religion') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_religion') : ''),
				'email'=>(parent::getUserMeta($this->input->get('userinfo'),'email') != false ? parent::getUserMeta($this->input->get('userinfo'),'email') : ''),
				'teacher_phone'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_phone') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_phone') : ''),
				'teacher_primary_address'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_primary_address') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_primary_address') : ''),
				'secondary_address'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_secondry_adress') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_secondry_adress') : ''),
				'province'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_province') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_province') : ''),
				'teacher_city'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_city') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_city') : ''),
				'teacher_zipcode'=>(parent::getUserMeta($this->input->get('userinfo'),'teacher_zipcode') != false ? parent::getUserMeta($this->input->get('userinfo'),'teacher_zipcode') : ''),
				'masterteaher'=>$profile_link[0]->is_master_teacher,
				'location'=>$locationid[0]->locationid,
				'profile_link'=>$profile_link[0]->profile_image,
			);
		}
		echo json_encode($userarray);
	}

	function TeacherList()
	{
		$locations = $this->session->userdata('locations');
		$is_teacher_found = $this->operation->GetRowsByQyery("SELECT iv.id,iv.screenname FROM invantageuser iv INNER JOIN user_locations ul ON ul.user_id = iv.id INNER JOIN user_roles ur ON ur.user_id = iv.id WHERE ur.role_id = 4 AND ul.school_id = ".$locations[0]['school_id']." Order by iv.id ASC");
		$teacherarray = array();

		if(count($is_teacher_found))
		{
			foreach ($is_teacher_found as $key => $value) {
				$teacherarray[] = array(
					'id'=>$value->id,
					'name'=>$value->screenname,
				);
			}
		}
		echo json_encode($teacherarray);
	}

	function ScheduleDetail()
	{
		if(!is_null($this->input->get('scheduleinfo')))
		{
			$this->operation->table_name = 'schedule';
			$schedulalist = $this->operation->GetByWhere(array(
						'id'=>$this->input->get('scheduleinfo'),
					));

			$schedulararray = array();
			if(count($schedulalist))
			{
				
				foreach ($schedulalist as $key => $value) {
			
					$schedulararray = array(
						'class'=>$value->class_id,
						'section'=>$value->section_id,
						'subject'=>$value->subject_id,
						'teacher'=>$value->teacher_uid,
						'start_time'=>date('H:i',$value->start_time),
						'end_time'=>date('H:i',$value->end_time),
					);
				}
			}
		}

		echo json_encode($schedulararray);
	}

	function GetSubjectById()
	{
		$selected_subject = array();
		if($this->input->get('subjectid'))
		{
			$is_selected_subject = $this->operation->GetRowsByQyery('SELECT * FROM subjects where id ='.$this->input->get('subjectid'));

			if(count($is_selected_subject))
			{
				$selected_subject = array(
					'id'=>$is_selected_subject[0]->id,
					'name'=>$is_selected_subject[0]->subject_name,
					'subjectcode'=>$is_selected_subject[0]->subject_code,
					'class'=>$is_selected_subject[0]->class_id,
					'semester'=>$is_selected_subject[0]->semesterid,
					'image'=>$is_selected_subject[0]->subject_image,
					'subj_marks'=>$is_selected_subject[0]->subj_marks,
				);
			}
		}
		echo json_encode($selected_subject);
	}

	function GetClassTimeTable()
	{
		$result = array();
		if($this->input->get('classid'))
		{
			$is_result_found = $this->operation->GetRowsByQyery('SELECT sb.subject_name,inv.screenname,s.start_time,s.end_time FROM schedule s INNER JOIN subjects sb ON sb.id = s.subject_id INNER JOIN invantageuser inv ON inv.id = s.teacher_uid  where s.class_id ='.$this->input->get('classid').' AND s.section_id = '.$this->input->get('sectionid'));

			if(count($is_result_found))
			{
				foreach ($is_result_found as $key => $value) {
					$result[] = array(
						'subject'=>$value->subject_name,
						'teacher'=>$value->screenname,
						'starttime'=>date('H:i',$value->start_time),
						'endtime'=>date('H:i',$value->end_time),
					);
				}
			}
		}
		echo json_encode($result);
	}

	function GetClassStudent()
	{
		$result = array();
		if($this->input->get('classid'))
		{
			$is_result_found = $this->operation->GetRowsByQyery('SELECT inv.username,inv.screenname,inv.profile_image,inv.id as uid FROM student_semesters s  INNER JOIN invantageuser inv ON inv.id = s.studentid  where s.status = "r" AND s.classid ='.$this->input->get('classid').' AND s.sectionid = '.$this->input->get('sectionid'));

			if(count($is_result_found))
			{
				foreach ($is_result_found as $key => $value) {
					$result[] = array(
						'rollnumber'=>$value->username,
						'name'=>$value->screenname,
						'image'=>$value->profile_image,
						'fathername'=>(parent::getUserMeta($value->uid,'father_name') != false ? parent::getUserMeta($value->uid,'father_name') : ''),
						'phone'=>(parent::getUserMeta($value->uid,'sphone') != false ? parent::getUserMeta($value->uid,'sphone') : ''),
					);
				}
			}
		}
		echo json_encode($result);
	}

	function AdminDashboard()
	{
			
		$this->load->view('admin/dashboard');

	}

	function Setup()
	{
		$this->load->view('admin/setup');
	}

	public function updatedob()
	{
		$is_selected_subject = $this->operation->GetRowsByQyery('SELECT u.*,ur.role_id FROM invantageuser u INNER JOIN user_roles ur ON ur.user_id = u.id  where ur.role_id = 5');
		if(count($is_selected_subject))
		{
			foreach ($is_selected_subject as $key => $value) {
				echo "Update user_meta Set meta_key = 'sdob' , meta_value = '".date('Y-m-d')."' where user_id =".$value->id;
				echo $this->db->query("Update user_meta Set meta_key = 'sdob' , meta_value = '".date('Y-m-d')."' where user_id =".$value->id);

			}
		}
		
	}


	function Calender()
	{
		if(!($this->session->userdata('id'))){
			parent::redirectUrl('signin');
		}
		$this->load->view('calender/calender',$this->data);
	}
}

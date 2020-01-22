<?php 

/**
 * Users Controller
 *
 * This class responsible for user.
 */

 class Users extends MY_Controller
 { 	

 	function __construct()
 	{
 		parent::__construct();
		$this->load->model('operation');
		$this->load->model('user');
		if(isset($_SESSION)){
			if($this->session->userdata('attempt') == 1){
				parent::redirectUrl('passChange');
			}
		}
 	}

	// ----------------------------------------------------------------------
	
	/** 
	 *	
	 * User Section 
	 * Modules list
	 *  1: getRoles This function return all user roles.
	 *	2: saveUser() This function save new user or update the user. 
	 *	3: viewUser() This function load user view. 
	 *	4: paginateUser() This function used for user module pagination. 
	 *	5: singleUser() This function used for view single user record. 
	 *	6: removeUser() This function remove the provided user. 
	 *	7: passwordChecking() This function used to check last three password
	 *     must not match with provide password. 
	 *	8: emailChecking() This function used to check no duplicate email inserted
	 *     in user email column. 
	 *  9: passwrodChange() This function used update password after expiry date.
	 */
	
	/**
	 * Get all user roles
	 *
	 * @access private
	 * @return array return roles json array 
	 */
	function getRoles(){
		$result['message'] = false;
		$this->operation->table_name = 'roles';
		$roles = $this->operation->GetRows();
		if(count($roles) == TRUE):
			$i = 1;
			$result['message'] = true;
			foreach ($roles as $key => $value) {
				$result['unFoundName'][$i] = $value->type;
				$result['unFoundRoleId'][$i] = $this->encrypt->encode($value->id);
				$i++;
			}
		endif;
		echo json_encode($result);	
	}

	/**
	 * Save user
	 *
	 * @access private
	 * @return array it returns newly or updated user data json array
	 */
	function saveUser(){
		$result['message'] = false;	

		$this->form_validation->set_rules('inputFirstName', 'Valid First Name Required', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('inputLastName', 'Valid Last Name Required', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('inputEmail', 'Email Required', 'trim|valid_email');
		$this->form_validation->set_rules('inputNewPassword', 'Password Required', 'trim');
		$this->form_validation->set_rules('inputStore', 'Store Required', 'trim|required');
		$this->form_validation->set_rules('optionsStatus', 'Status Required', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$result['message'] =  false;		
		}
		else{
			if($this->input->post('serial') != '' && isset($_POST['userlist'])){
				
				// edit
				$id = $this->input->post('serial');
				$this->operation->table_name = 'users';
				$requestedUser = $this->operation->GetByWhere(array('row_slug'=>$id));
				if(count($requestedUser) == true):
					$user = array(
									'name'=>ucwords($this->input->post('inputLastName')),
									'email'=>$this->input->post('inputEmail'),
									'first_name'=>$this->input->post('inputFirstName'),
									'last_name'=>$this->input->post('inputLastName'),
									'account'=>$this->input->post('optionsStatus'),
								);
					$this->operation->table_name = 'users';
					$this->operation->primary_key = 'row_slug';
					$userUpdated = $this->operation->Create($user,$id);

					$value = $_POST['userlist'];
					
					$this->db->query("Delete from user_roles where user_id = ".$requestedUser[0]->uid);
					if($value != ''){
						
						$rolestring = '';
						foreach ($value as $key => $val) {
							if($val != ''){
								$user_role = array('role_id' =>$val , "user_id" => $requestedUser[0]->uid);
								$this->operation->table_name = 'user_roles';
								$this->operation->Create($user_role);
							}
						}
						
						$user_store = array('store_id' =>1);
						$this->operation->table_name = 'store_users';
						$this->operation->primary_key = 'user_id';
						$this->operation->Create($user_store,$requestedUser[0]->uid);
						$result['message'] = true;
					}	
					else{
						$result['message'] = false;
					}
				endif;					
			}
			else{

				// insert
				$userId = $this->user->Signup(ucwords($this->input->post('inputLastName')),ucwords($this->input->post('inputFirstName')),ucwords($this->input->post('inputLastName')),$this->input->post('inputEmail'),$this->input->post('inputNewPassword'),$this->input->post('optionsStatus'),$this->input->post('inputStore'));
				
				if($userId != FALSE){
					$value = $_POST['userlist'];
					$userRole = array();
					$rolestring = '';

					if($value != ''){
						foreach ($value as $key => $val) {
							if($val != ''){
								$user_role = array('role_id' =>$val , 'user_id'=>$userId);
								$this->operation->table_name = 'user_roles';
								$this->operation->Create($user_role);
							}
						}
					}
					$user_store = array('store_id' =>1 , 'user_id'=>$userId);
					$this->operation->table_name = 'store_users';
					$this->operation->Create($user_store);
					
					$result['message'] = true;
				
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= 'From: <info@betsyhealth.com>' . "\r\n";
					$message = "Hello ".ucwords($this->input->post('inputName'));
					$message .= "<br> This email is from http://www.betsyhealth.com/ to inform you that betsyhealth has created your account as ".$rolestring;
					$message .= "<br> Account details are given below";
					$message .= "<br> Email ".$this->input->post('inputEmail');
					$message .= "<br> Password ".$this->input->post('inputPassword');
					$message .= "<br> Please, follow this <a href='http://betsys.zinwebs.com/login' title='login'>link</a> to login at betsyhealth.<br>";
					$message .= "<br>If you received this e-mail in error just ignore this message. No further actions are required from you<br>";
					$message .= "<br><b>Note:</b> this e-mail was sent automatically, please, do not reply to it.<br>";
					$message .="<br>Best Regards,<br>";
					$message .="The betsyhealth";
					//$mail_sent = @mail($this->input->post('inputEmail'), "Account Email www.betsyhealth.com", $message, $headers);
				}	
			}
		}
		echo json_encode($result);
	}


	/**
	 * Display user
	 * 
	 * @load view
	 * @return array  
	 */
	function viewUser(){

		$per_page = 10;
		$page = 1 ;
		if($this->input->get('page')){
			$page = $this->input->get('page');
		}
		//putting the value of $items_per_page variable (created in config.php) into $limit variable.
		$limit = $per_page;
		//defining our start point of records while selecting from db.
		$startpoint = ($page * $limit) - $limit;
		$sql_count = $this->operation->GetRowsByQyery("SELECT COUNT(*) as users FROM users"); 
		$total =(int) $sql_count[0]->users;
		$adjacents = 2; 
		$page =(int) ($page == 0 ? 1 : $page);  
		$start = ($page - 1) * $per_page;								
		$prev = $page - 1;							
		$next = $page + 1;
		$lastpage = ceil($total/$per_page);
		$lpm1 = $lastpage - 1;
		$this->operation->table_name = 'user';
		$data['roles'] = $this->operation->GetRowsByQyery("Select * from roles");
		if($this->uri->segment(2)){
			$data['user'] = $this->operation->GetByWhere(array('id'=>$this->uri->segment(2)));
			$data['user_selected_roles'] = $this->operation->GetRowsByQyery("Select ur.*,u.id,r.* from user_roles ur Inner join roles r on r.id = ur.role_id Inner join users u On u.id = ur.user_id where ur.user_id = ".$this->uri->segment(2));
			$data['total_count_row'] = $this->operation->GetRowsByQyery("Select count(*) as totalRows from user_roles where user_id = ".$this->uri->segment(2));
		}
		//$data['users'] = $this->operation->GetRowsByQyery('Select u.uid,u.name,u.email,r.type,u.row_slug,u.account from users u Inner join user_roles ur on ur.user_id = u.uid Inner join roles r on r.id = ur.role_id where r.id <> 1 order by u.uid limit '.$per_page);
		$data['users'] = $this->operation->GetRowsByQyery('SELECT u.uid,u.name,u.email,r.type,u.row_slug,u.account from users u Inner join user_roles ur on ur.user_id = u.uid Inner join roles r on r.id = ur.role_id where r.id <> 1 order by u.uid limit '.$startpoint." , ".$limit);
		
		$users = $this->operation->GetRowsByQyery('SELECT u.uid,u.name,u.email,r.type,u.row_slug,ur.user_id,u.account,GROUP_CONCAT(r.type SEPARATOR " / ") AS roletype  from users u Inner join user_roles ur on ur.user_id = u.uid Inner join roles r on r.id = ur.role_id group by u.uid,ur.user_id order by u.uid desc limit '.$startpoint." , ".$limit);
		$salesData['message'] = false;
		if(count($users)){
			$salesData['message'] = true;
			$i = 1 ;
			foreach ($users as $key => $value) {
				$salesData['slug'][$i] = $this->encrypt->encode($value->row_slug);
				$salesData['serial'][$i] = $value->row_slug;
				$salesData['name'][$i] = $value->name;
				$salesData['email'][$i] = $value->email;
				$salesData['type'][$i] = $value->roletype;
				$salesData['account'][$i] = $value->account;
				$i++;
			}
		}
		$salesData['total'] = $total;
		$salesData['start'] = $start;
		$salesData['prev'] = $prev;
		$salesData['next'] = $next;
		$salesData['lastpage'] = $lastpage;
		$salesData['lpm1'] = $lpm1;
		$salesData['adjacents'] = $adjacents;
		$salesData['page'] = $page;
		
		$row_count = $this->operation->GetRowsByQyery("Select count(*) as total_rows from users ");	
		$row_count =  ceil($row_count[0]->total_rows/$per_page);
		$data['count_total_rows'] = $row_count;
		$this->operation->table_name = 'roles';
		$data['user_role'] = $this->operation->GetRows();
		echo json_encode($salesData);
		//$this->load->view('user/user',$data);
	}

	/**
	 * Pagination portfolio
	 *
	 * @access private
	 * @return array return pagination json array
	 */
	function paginateUser(){
		$this->operation->table_name = 'users';
		$per_page = 5; 
		$page = 1 ;
		if($this->input->get('page')){
			$page = $this->input->get('page');
		}
		$start = ($page-1) * $per_page;
		$users = $this->operation->GetRowsByQyery("Select * from users order by id desc limit $start , $per_page ");
		echo json_encode(parent::attribute($users)); 
	}

	/**
	 * Single User
	 *
	 * @access private
	 * @return array if request user found it return json array else return false 
	 */
	function singleUser(){
		$result['message'] = false;	
		if($this->input->get('id')){
			$id = $this->input->get('id');
			$requestedUser = $this->operation->GetRowsByQyery('SELECT u.uid,u.name,concat(u.first_name," ",u.last_name) as "Name",u.date,u.email,u.account,r.type,r.id as roleId From users u Inner join user_roles ur on ur.user_id = u.uid Inner join roles r on r.id = ur.role_id where u.row_slug = '.$id);
			$userRoles = $this->operation->GetRowsByQyery("SELECT r.type,r.id as roleid From users u Inner join user_roles ur on ur.user_id = u.uid Inner join roles r on r.id = ur.role_id where u.row_slug = ".$id );
			$i = 1;
			$rolestring = '';
			if(!empty($userRoles) == true):
				foreach ($userRoles as $key => $value) {
					$result['role'][$i] = $value->type;
					$result['userRoleId'][$i] = $this->encrypt->encode($value->roleid);
					$rolestring .= $value->roleid.',';
					$i++;
				}
			endif;
			$rolestring = rtrim($rolestring,',');	
			if(count($requestedUser) == TRUE){
				$result['message'] = true;
				$result['name'] = $requestedUser[0]->Name;		
				$result['email'] = $requestedUser[0]->email;		
				$result['created'] = $requestedUser[0]->date;		
				$result['status'] = $requestedUser[0]->account;		
				$result['roleId'] = $this->encrypt->encode($requestedUser[0]->roleId);		
				$i = 1;
				$this->operation->table_name = 'roles';
				$roles = $this->operation->GetRowsByQyery("Select * From roles where id NOT IN({$rolestring})");
				if(!empty($roles) == true):
					foreach ($roles as $key => $value) {
						$result['unFoundName'][$i] = $value->type;
						$result['unFoundRoleId'][$i] = $this->encrypt->encode($value->id);
						$i++;
					}
				endif;	
			}
			else{
				$result['message'] = false;	
			}
		}	
		echo json_encode($result);	
	}

	/**
	 * Remove user
	 *
	 * @access private
	 * @return array return json array message if user deleted
	 */
	function removeUser(){
		$result['message'] = false;
		$value =  $_GET['id'];
		$this->operation->table_name = 'users';
		$requestedUser = $this->operation->GetByWhere(array('row_slug'=>$this->encrypt->decode($value)));
		$removedUser = $this->db->query("Delete from users where row_slug = ".$this->encrypt->decode($value));
		$requestedUser = $this->db->query("Delete from user_roles where user_id = ".$requestedUser[0]->uid);
	
		if($removedUser == TRUE):
			$result['message'] = true;
		endif;
		echo json_encode($result);	
	}

	/**
	 * Last three password checking
	 *
 	 * @access private
 	 * @return array return json array message if any of last 
 	 * three password match with provided password
	 */
	function passwordChecking(){
		$result['message'] = false;
		$val = $this->user->getLastThreePassword($this->input->get('inputPassword'));
		if($val == 1){
			$result['message'] = true;
		}
		echo json_encode($result);
	}

	/**
	 * Duplicate email checking
	 *
	 * @access private
	 * @return array return json array true message if email is duplicate
	 */
	function emailChecking(){
		$result['message'] = false;
		$val = $this->user->getDublicateEmail($this->input->get('inputEmail'));
		if($val == 1){
			$result['message'] = true;
		}
		echo json_encode($result);
	}

	
	/**
	 * Change Password
	 *
     * @access private
	 * @return array return json array true message if password is changed after
	 * expiry date
	 */
	function passwrodChange(){
		if($this->input->post('password')){
			$today = date("Y-m-d");
			$changePassword = array('password'=>md5($this->input->post('password')));
			$this->user->table_name = 'invantageuser';
			$this->user->primary_key = 'id';
			$changed = $this->user->Create($changePassword, $this->session->userdata('id'));
			$result['message'] = false;
			if(count($changed)){
				$result['message'] = true;
			}
			echo json_encode($result);
		}
	}

	/**
	 * Change Password
	 *
	 * @access private
	 * @return array return json array true message if password is changed after
	 * expiry date
	*/
	function changePassword(){
		$result['message'] = false;	
		$this->form_validation->set_rules('inputCurrentPassword', 'Title Required', 'trim|required');
		$this->form_validation->set_rules('inputNewPassword', 'Title Required', 'trim|required');
		$this->form_validation->set_rules('inputRetypeNewPassword', 'Title Required', 'trim|required');
		if ($this->form_validation->run() == FALSE){
			$result['message'] = false;		
		}
		else{
			// Check existing password is valid or not
			$password = $this->user->GetByWhere(array('id'=>$this->session->userdata('id')));

			if(count($password)){
				if(md5($this->input->post('inputCurrentPassword')) == $password[0]->password){
					$today = date("Y-m-d");
					$changePassword = array('password'=>md5($this->input->post('inputNewPassword')));
					$this->user->table_name = 'invantageuser';
					$this->user->primary_key = 'id';
					$changed = $this->user->Create($changePassword, $this->session->userdata('id'));
					
					$result['message'] = false;
					if(count($changed)){
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= 'From: <'.$is_email_found[0]->option_value.'>' . "\r\n";
						$headers .= 'Reply-To: <'.$is_email_found[0]->option_value.'>' . "\r\n";
						$message  = "Hello";
						$message .= "<br> The password associated with this e-mail address ".$password[0]->email.". is updated, please use updated password for now at Learning InVantage<br>";
						$message .= "<br>Note: this e-mail was sent automatically, please, do not reply to it.<br>";
						$message .="<br>Best Regards,<br>";
						$message .="Learning InVantage";
						$mail_sent = @mail($password[0]->email, "Password Reset Successfully", $message, $headers);

						$result['message'] = true;
					}
				}
				else{
					$result['message'] = "pass_not_match";
				}
			}	
		}
		echo json_encode($result);	
	}

	/**
	 * Forgot Password
	 */
	function forgotPassword(){

		if(count($this->user->GetByWhere(array('email'=>$this->input->post('forgotEmail')))) == 0){
			$result['message'] = false;
		}
		else{
			$this->form_validation->set_rules('forgotEmail', 'Valid Email Required', 'trim|required|valid_email');
			if ($this->form_validation->run() == FALSE){
				$result['message']  = false;
			}	
			else{

				$this->load->helper('string');
				$number = random_string('alnum', 3);
				$number .= ",".strtotime("now");
				$resultrow  = $this->user->GetByWhere(array('email'=>$this->input->post('forgotEmail')));
				$this->operation->table_name = 'options';
				$is_email_found = $this->operation->GetByWhere(array('option_name'=>'refrence_email'));
				if(count($resultrow) == 1):
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= 'From: <'.$is_email_found[0]->option_value.'>' . "\r\n";
					$headers .= 'Reply-To: <'.$is_email_found[0]->option_value.'>' . "\r\n";
					$message = "Hello";
					$message .= "<br> We received a request to reset the password associated with this e-mail address ".$this->input->post('forgotEmail').". If you made this request, please use the link below to create a new password at Learning InVantage<br>";
					$message .= "Please use this key to reset password ".$number;
					$message .= "<br> <a href='".base_url()."/RetypeSetPassword' title='Forgot Password'>Learning InVantage</a><br>";
					$message .= "If you received this e-mail in error just ignore this message. No further actions are required from you.<br>";
					$message .= "<br>Note: this e-mail was sent automatically, please, do not reply to it.<br>";
					$message .="<br>Best Regards,<br>";
					$message .="Learning InVantage";
					$this->db->query("Update invantageuser set user_status = 'f', forgotpasswordkey = '".$number."' where email = '".$this->input->post('forgotEmail')."'");
					$mail_sent = @mail($this->input->post('forgotEmail'), "Password Reset", $message, $headers);
					$result['message'] = TRUE;
				endif;
			}				
		}
		echo json_encode($result);	
	}

	function RetypeSetPassword()
	{
		$this->load->view('user/forgot');
	}
	/*
	* Re set passwrod
	*/
	function resetPassword(){
		$result['message'] = false;
		if($this->input->post('newPasswordKeyInput')){
			if(count($this->user->GetByWhere(array('forgotpasswordkey'=>$this->input->post('newPasswordKeyInput')))) == 0){
				$result['message'] = false;
			}
			else{
				$this->form_validation->set_rules('newPasswordKeyInput', 'Valid Key Required', 'trim|required');
				$this->form_validation->set_rules('newPasswordInput', 'Valid Password Required', 'trim|required');
				$this->form_validation->set_rules('retypePasswordInput', 'Valid Retype Password Required', 'trim|required');
				if ($this->form_validation->run() == FALSE){
					$result['message'] = false;;
				}	
				else{
					$result  = $this->user->GetByWhere(array('forgotpasswordkey'=>$this->input->post('newPasswordKeyInput')));
					if(count($result)):
						$this->db->query("Update invantageuser set user_status = 'a', password = '".md5($this->input->post('newPasswordInput'))."' , forgotpasswordkey = '' where id = '".$result[0]->id);
						$this->operation->table_name = 'options';
						$is_email_found = $this->operation->GetByWhere(array('option_name'=>'refrence_email'));
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						$headers .= 'From: <'.$is_email_found[0]->option_value.'>' . "\r\n";
						$headers .= 'Reply-To: <'.$is_email_found[0]->option_value.'>' . "\r\n";
						$message = "Hello";
						$message .= "<br> The password associated with this e-mail address ".$result[0]->email.". is updated, please use updated password for now at Learning InVantage<br>";
						$message .= "If you received this e-mail in error just ignore this message. No further actions are required from you<br>";
						$message .= "<br>Note: this e-mail was sent automatically, please, do not reply to it.<br>";
						$message .="<br>Best Regards,<br>";
						$message .="Learning InVantage";
						$mail_sent = @mail($result[0]->email, "Password Reset Successfully", $message, $headers);
					
						$result['message'] = TRUE;
					endif;
				}
			}
		}	
		echo json_encode($result);		
	}

	function profileimage(){
		$result['message'] = false;
		if(isset($_FILES) == 1){
			// Save in database
			foreach ($_FILES as $key => $value) {
				$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
		        if(strlen($value['name'])){
		            list($txt, $ext) = explode(".", strtolower($value['name']));
		            if(in_array(strtolower($ext),$valid_formats)){
		            	if ($value["size"] < 5242880) {
		            		$path = UPLOAD_PATH."profile/"; 
							$file = time().trim(basename($value['name']));
							$filename = $path.$file;
	 						$profileimage = array(
									'profile_image'=>base_url().'upload/profile/'.$file,
								);

							$this->operation->table_name = 'invantageuser';
							$this->operation->primary_key = 'id';
							$id = $this->operation->Create($profileimage,$this->session->userdata('id'));		
					 		if($id){
								if(is_uploaded_file($value['tmp_name'])){     
									$biger_thumbnail = time().trim(basename($txt."_thumb.".$ext));
									$bigger_thumb_file = $path.$biger_thumbnail;
								 	if(move_uploaded_file($value['tmp_name'],$filename)){
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
		echo json_encode($result);	
	}
}

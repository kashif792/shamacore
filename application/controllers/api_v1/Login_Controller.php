<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'core/MY_Rest_Controller.php';

/**
 * Login API
 */
class Login_Controller extends My_Rest_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Karachi");
        // $this->load->model('user');
        // $this->load->model('operation');
    }

    /**
     *
     * @param string $email
     * @param
     *            string md5 $password
     * @return boolean
     */
    public function teacher_login_post()
    {
        $data = array();

        $params = $this->parse_params();

        $email = $params->email;
        // MD5 HASH of actual password
        $password = $params->password;

        $user = $this->user->get_by_query("SELECT * FROM " . $this->user->table_name . " WHERE email ='" . $email . "'  AND password = '" . $password . "' LIMIT 1");

        if (count($user) > 0) {
            foreach ($user as $value) {
                $user_roles = $this->user->get_by_query("SELECT ur.role_id,r.type FROM user_roles ur INNER JOIN roles r ON r.id = ur.role_id  where user_id =" . $value->id);

                $default_school_id = '';
                $user_locations = $this->user->get_by_query("SELECT ur.school_id,s.* FROM user_locations ur INNER JOIN schools s ON s.id = ur.school_id where ur.user_id =" . $value->id);
                if (count($user_locations)) {
                    $default_school_id = $user_locations[0]->school_id;
                }

                $default_session_id = '';
                $show_school_wizard = false;

                if (! empty($default_school_id)) {
                    $active_sessions = $this->operation->GetByQuery("SELECT  * FROM sessions WHERE status = 'a' AND school_id =" . $default_school_id);
                    $default_session_id = $active_sessions[0]->id;

                    $this->operation->table_name = 'wizard';
                    $school_wizard_status = $this->operation->GetByWhere(array(
                        'school_id' => $default_school_id,
                        'status' => 'y'
                    ));
                    if (count($school_wizard_status)) {
                        $show_school_wizard = true;
                    }
                }

                $temp_roles = array();
                foreach ($user_roles as $rvalue) {

                    $temp_roles[] = array(
                        'role_id' => $rvalue->role_id,
                        'type' => $rvalue->type
                    );
                }
                $temp_user_locations = array();
                if (count($user_locations)) {

                    foreach ($user_locations as $lvalue) {
                        $temp_user_locations[] = array(
                            'school_id' => $lvalue->school_id,
                            'shortname' => $lvalue->shortname,
                            'schoolname' => $lvalue->name
                        );
                    }
                }

                $data['id'] = $value->id;
                $data['type'] = $value->type;
                $data['name'] = $value->screenname;
                $data['email'] = $value->email;
                $data['is_master_teacher'] = $value->is_master_teacher;
                $data['roles'] = $temp_roles;
                $data['locations'] = $temp_user_locations;
                $data['default_school_id'] = $default_school_id;
                $data['show_school_wizard'] = $show_school_wizard;
                $data['default_session_id'] = $default_session_id;
                $data['profile_image'] = $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE);
            }
            $data['loggedin'] = TRUE;
        } else {
            $data['loggedin'] = FALSE;
        }

        $this->set_response($data, REST_Controller::HTTP_OK);
    }
    
    /**
     *
     * @param string $email
     * @param
     *            string md5 $password
     * @return boolean
     */
    public function student_login_post()
    {
        $data = array();
        
        $params = $this->parse_params();
        
        $email = $params->email;
        // MD5 HASH of actual password
        $password = $params->password;
        
        $user = $this->user->get_by_query("SELECT * FROM " . $this->user->table_name . " WHERE username ='" . $email . "'  AND password = '" . $password . "'");

        if (count($user) > 0) {
            $value = $user[0];
            
            $school_id = '';
            $user_locations = $this->user->get_by_query("SELECT ur.school_id,s.* FROM user_locations ur INNER JOIN schools s ON s.id = ur.school_id WHERE ur.user_id =" . $value->id . "  LIMIT 1");
            if (count($user_locations)) {
                $school_id = $user_locations[0]->school_id;
            }
            
            $session_id = '';
            $semester_id = '';
            $sem_dates_id = '';
            $section_id = '';
            $grade_id = '';
            
            $ss = $this->operation->GetByQuery('SELECT * FROM `student_semesters` WHERE student_id = ' . $value->id  . "  AND status = 'r'");
            $mode='';
            if(count($ss)){
                $semester_id = $ss[0]->semester_id;
                $session_id = $ss[0]->session_id;
                $grade_id = $ss[0]->class_id;
                $section_id = $ss[0]->section_id;
                
                if(count($session_id)){
                    
                    $active_semester = $this->get_active_semester_dates_by_session($session_id);
                    if (count($active_semester)) {
                        $sem_dates_id = $active_semester->id;
                    }
                }
            }
            
            $data['id'] = $value->id;
            $data['type'] = $value->type;
            $data['mode'] = $this->get_user_meta($value->id, 'mode');
            $data['email'] = $value->email;
            $data['user_name'] = $email;
            $data['screen_name'] = $value->screenname;
            $data['first_name'] = $this->get_user_meta($value->id, 'sfullname');
            $data['last_name'] = $this->get_user_meta($value->id, 'slastname');
            $data['profile_image'] = $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE);
            $data['school_id'] = $school_id;
            $data['session_id'] = $session_id;
            $data['semester_id'] = $semester_id;
            $data['semester_dates_id'] = $sem_dates_id;
            $data['grade_id'] = $grade_id;
            $data['section_id'] = $section_id;
            
            $data['loggedin'] = TRUE;
        } else {
            $data['loggedin'] = FALSE;
        }
        
        $this->set_response($data, REST_Controller::HTTP_OK);
    }


    /**
     *
     * @param json string install_id, password
     *
     * @return boolean
     */
    public function device_login_post()
    {
        $data = array();
        
        $params = $this->parse_params();
        
        $username = $params->username;
        $password = $params->password;

        $school_id = $params->school_id;
        $grade_slug = $params->grade_slug;
        $man = $params->man;	// Manufacturer
        $model = $params->model;	// Model
        
        if(empty($username) || empty($password) || empty($grade_slug) || empty($man) || empty($model)){
        	$data['message'] = "Required params are missing";
        	$data['loggedin'] = FALSE;
        	$this->set_response($data, REST_Controller::HTTP_OK);
        	return;
        }

        $user = $this->user->get_by_query("SELECT * FROM " . TABLE_INVANTAGE_USERS . " WHERE username ='" . $username . "'");

		if (count($user) <= 0) {
			// Register this installation
			
			$class_id = 0;
			if(!isset($school_id) || empty($school_id)){
				$school_id = 1;	// Set default school Id
			}

            $active_session = $this->get_active_session($school_id);
            $active_semester = $this->get_active_semester_dates_by_session($active_session->id);

			$semester_id = $active_semester->semester_id;
			$class_array = parent::get_default_classes();
			foreach ($class_array as $class_info) {
				if($class_info['slug'] == $grade_slug){
					$class_id = $class_info['id'];
					break;
				}
			}
			
			if($class_id == 0){
	        	$data['message'] = "Invalid grade slug!";
	        	$data['loggedin'] = FALSE;
	        	$this->set_response($data, REST_Controller::HTTP_OK);
	        	return;
	        }

            $user_id = $this->user->DeviceInfo(NULL, $username, $man, $model, $school_id, $semester_id, $class_id, NULL,md5(DEVICE_LOGIN_TOKEN));
		}

        $user = $this->user->get_by_query("SELECT * FROM " . TABLE_INVANTAGE_USERS . " WHERE username ='" . $username . "'  AND password = '" . $password . "'");

		if (count($user)) {
            $value = $user[0];
            
            $school_id = '';
            $user_locations = $this->user->get_by_query("SELECT ur.school_id,s.* FROM user_locations ur INNER JOIN schools s ON s.id = ur.school_id WHERE ur.user_id =" . $value->id . "  LIMIT 1");
            if (count($user_locations)) {
                $school_id = $user_locations[0]->school_id;
            }
            
            $session_id = '';
            $semester_id = '';
            $sem_dates_id = '';
            $section_id = '';
            $grade_id = '';
            
            $ss = $this->operation->GetByQuery('SELECT * FROM `student_semesters` WHERE student_id = ' . $value->id  . "  AND status = 'r'");
            
            if(count($ss)){
                $semester_id = $ss[0]->semester_id;
                $session_id = $ss[0]->session_id;
                $grade_id = $ss[0]->class_id;
                $section_id = $ss[0]->section_id;
                
                if(count($session_id)){
                    
                    $active_semester_dates = $this->get_active_semester_dates_by_session($session_id);
                    if (count($active_semester_dates)) {
                        $sem_dates_id = $active_semester_dates->id;
                    }
                }
            }
            
            $data['id'] = $value->id;
            $data['type'] = $value->type;
            $data['email'] = $value->email;
            $data['user_name'] = $value->username;
            $data['screen_name'] = $value->screenname;
            $data['first_name'] = $this->get_user_meta($value->id, 'sfullname');
            $data['last_name'] = $this->get_user_meta($value->id, 'slastname');
            $data['profile_image'] = $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE);
            $data['school_id'] = $school_id;
            $data['session_id'] = $session_id;
            $data['semester_id'] = $semester_id;
            $data['semester_dates_id'] = $sem_dates_id;
            $data['grade_id'] = $grade_id;
            $data['section_id'] = $section_id;
            
            $data['loggedin'] = TRUE;
        } else {
            $data['loggedin'] = FALSE;
        }
        
        $this->set_response($data, REST_Controller::HTTP_OK);
    }
    
    /**
     * Change Password
     *
     * @access private
     * @return array return json array true message if password is changed after
     *         expiry date
     */
    function password_change_post()
    {
        $result['message'] = false;

        $params = $this->parse_params();

        if (! empty($params->user_id) && ! empty($params->inputCurrentPassword) && ! empty($params->inputNewPassword) && $params->inputNewPassword == $params->inputRetypeNewPassword) {

            // Check existing password is valid or not
            $password = $this->user->GetByWhere(array(
                'id' => $params->user_id
            ));

            if (count($password)) {
                if (md5($params->inputCurrentPassword) == $password[0]->password) {
                    $today = date("Y-m-d");
                    $changePassword = array(
                        'password' => md5($params->inputNewPassword)
                    );
                    $this->user->table_name = 'invantage_users';
                    $this->user->primary_key = 'id';
                    $changed = $this->user->Create($changePassword, $params->user_id);

                    $result['message'] = false;
                    if (count($changed)) {
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= 'From: <' . 'noreply@zilon.com' . '>' . "\r\n";
                        // $headers .= 'Reply-To: <' . $is_email_found[0]->option_value . '>' . "\r\n";
                        $message = "Hello";
                        $message .= "<br> The password associated with this e-mail address " . $password[0]->email . ". is updated, please use updated password for now at Learning InVantage<br>";
                        $message .= "<br>Note: this e-mail was sent automatically, please, do not reply to it.<br>";
                        $message .= "<br>Best Regards,<br>";
                        $message .= "Learning InVantage";
                        $mail_sent = @mail($password[0]->email, "Password Reset Successfully", $message, $headers);

                        $result['message'] = true;
                    }
                } else {
                    $result['message'] = "pass_not_match";
                }
            }
        }

        $this->set_response($result, REST_Controller::HTTP_OK);
    }

    /**
     * Forgot Password
     */
    function password_forgot_post()
    {
        $result['message'] = false;

        $params = $this->parse_params();
        
        if (! empty($params->email)) {
            if (count($this->user->GetByWhere(array(
                'email' => $params->email
            )))) {
                $this->load->helper('string');
                $number = random_string('alnum', 3);
                $number .= "," . strtotime("now");

                $resultrow = $this->user->GetByWhere(array(
                    'email' => $params->email
                ));

                $this->operation->table_name = 'options';
                $is_email_found = $this->operation->GetByWhere(array(
                    'option_name' => 'refrence_email'
                ));

                if (count($resultrow) == 1) {
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: <' . $is_email_found[0]->option_value . '>' . "\r\n";
                    $headers .= 'Reply-To: <' . $is_email_found[0]->option_value . '>' . "\r\n";
                    $message = "Hello";
                    $message .= "<br> We received a request to reset the password associated with this e-mail address " . $params->email . ". If you made this request, please use the link below to create a new password at Learning InVantage<br>";
                    $message .= "Please use this key to reset password " . $number;
                    $message .= "<br> <a href='" . base_url() . "/RetypeSetPassword' title='Forgot Password'>Learning InVantage</a><br>";
                    $message .= "If you received this e-mail in error just ignore this message. No further actions are required from you.<br>";
                    $message .= "<br>Note: this e-mail was sent automatically, please, do not reply to it.<br>";
                    $message .= "<br>Best Regards,<br>";
                    $message .= "Learning InVantage";
                    
                    $this->db->query("UPDATE invantage_users SET user_status = 'f', forgotpasswordkey = '" . $number . "' WHERE email = '" . $params->email . "'");
                    
                    $mail_sent = @mail($params->email, "Password Reset", $message, $headers);
                    $result['message'] = TRUE;
                }
            }
        }
        $this->set_response($result, REST_Controller::HTTP_OK);
    }

    /*
     * Re set passwrod
     */
    function password_reset_post()
    {
        $result['message'] = false;

        $params = $this->parse_params();

        if (! empty($params->newPasswordKeyInput) && ! empty($params->newPasswordInput) && $params->newPasswordInput == $params->retypePasswordInput) {

            if (count($this->user->GetByWhere(array(
                'forgotpasswordkey' => $params->newPasswordKeyInput
            ))) == 0) {
                $result['message'] = false;
            } else {

                $result = $this->user->GetByWhere(array(
                    'forgotpasswordkey' => $params->newPasswordKeyInput
                ));
                if (count($result)) {

                    $this->db->query("UPDATE invantage_users SET user_status = 'a', password = '" . md5($params->newPasswordInput) . "' , forgotpasswordkey = '' WHERE id = '" . $result[0]->id);

                    $this->operation->table_name = 'options';
                    $is_email_found = $this->operation->GetByWhere(array(
                        'option_name' => 'refrence_email'
                    ));

                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= 'From: <' . $is_email_found[0]->option_value . '>' . "\r\n";
                    $headers .= 'Reply-To: <' . $is_email_found[0]->option_value . '>' . "\r\n";
                    $message = "Hello";
                    $message .= "<br> The password associated with this e-mail address " . $result[0]->email . ". is updated, please use updated password for now at Learning InVantage<br>";
                    $message .= "If you received this e-mail in error just ignore this message. No further actions are required from you<br>";
                    $message .= "<br>Note: this e-mail was sent automatically, please, do not reply to it.<br>";
                    $message .= "<br>Best Regards,<br>";
                    $message .= "Learning InVantage";
                    $mail_sent = @mail($result[0]->email, "Password Reset Successfully", $message, $headers);

                    $result['message'] = TRUE;
                }
            }
        }

        $this->set_response($result, REST_Controller::HTTP_OK);
    }
}

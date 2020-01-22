<?php



/**

 *	WebApp class

 *

 */

class WebApp extends MY_Controller

{

	/**

 	 * @var array

 	 */

	var $data = array();



	function __construct(){

		parent::__construct();

		//$this->load->model('User');

		//$this->load->model('Operation');

	}



	/**

	 * Load view for webapp

	 */

	function loadwebapp()

	{

		try{


	
			$this->load->helper('url');

		$this->data['profile_image'] = $this->session->userdata('profile_image');

		$this->data['name'] = $this->session->userdata('name');

		
			$school_id = $this->input->get('school_id');
			$user_id = $this->input->get('user_id');
			$interface = $this->input->get('interface');
			$uroles = $this->input->get('uroles');
			$active_session = $this->get_active_session($school_id);
        	$active_semester = $this->get_active_semester_dates_by_session($active_session->id);

        	$role_id = FALSE;
        	if ($role = $this->get_user_role($user_id)) {
            	$role_id = $role->role_id;
        	}

		if($user_id)

        {

        	$this->load->view('webapplication/layout',$this->data);

        }else{

        	$this->user->logout();

        	parent::redirectUrl('./applogin');

        }

		}

		catch(Exception $e){

			echo $e->getMessage;

		}

		

		

	}



	/**

	 * Load view for webapp login

	 */

	function loadlogin()

	{

			//$this->user->logout();

    	$this->load->helper('url');

		$this->load->view('webapplication/login',$this->data);

	}



	public function Authenticate()

	{

		$result['message'] = false;

		$this->form_validation->set_rules('email', 'Email Required', 'trim|required');

		$this->form_validation->set_rules('password', 'Password required', 'trim|required');

		$school_id = $this->input->get('school_id');
		$user_id = $this->input->get('user_id');
		
		$active_session = $this->get_active_session($school_id);
    	$active_semester = $this->get_active_semester_dates_by_session($active_session->id);

    	$role_id = FALSE;
    	if ($role = $this->get_user_role($user_id)) {
        	$role_id = $role->role_id;
    	}

		if ($this->form_validation->run() == FALSE){

			$result['message'] = false;

		}

		else{

			if($this->input->post('email') == 'guest@zilon.com' && $this->input->post('password') =='guest')

			{

				$val = $this->user->TeacherLogin('Guest',$this->input->post('password'));

				$result['message'] = true;

				$data['name'] = 'Guest';

				$data['uroles'] = 'g';

				$data['interface'] = 'w';

				$data['profile_image'] = 'https://www.w3schools.com/howto/img_avatar.png';

				$this->session->set_userdata($data);

			}

			else

			{

				//$val = $this->user->TeacherLogin($this->input->post('email'),$this->input->post('password'));

				if($val == 1){

					//$roles = $this->session->userdata('roles');

					if($role_id == 3)

					{

						

						$result['authorize'] = false;

					}else{

								$data['uroles'] = 't';

								$data['interface'] = 'w';

						$this->session->set_userdata($data);

						$result['message'] = true;

					}

			

				}

				else if($val == false){

					$result['message'] = false;

				}	

			}

			

		}

		echo json_encode($result);

	}



	/**

	 * App logout

	 */

	public function Logout()

	{

		$result['message'] = false;

		

		if($this->session->userdata('id') || $this->session->userdata('uroles') == 'g' )

        {

        	$this->user->logout();

			$result['message'] = true;

        }

		echo json_encode($result);

	}



	/**

	 * Get user login role

	 */

	public function GetLoggedinUserRole()

	{

		$result['userrole'] = $this->session->userdata('uroles');

		echo json_encode($result);

	}

}


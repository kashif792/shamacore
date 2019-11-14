<?php
/**
 *	Student app class
 *
 */

class StudentApp extends MY_Controller
{

	/**
 	 * @var array
 	 */

	var $data = array();

	function __construct(){

		parent::__construct();
		$this->load->model('User');
		$this->load->model('Operation');
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
			
			if($this->session->userdata('id'))
        	{
        		$this->load->view('Students/layout',$this->data);

        	}else{
        		$this->user->logout();
        		parent::redirectUrl('./stdapplogin');
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
		$this->user->logout();
    	$this->load->helper('url');
		$this->load->view('Students/login',$this->data);
	}

	public function Authenticate()
	{
		$result['message'] = false;
		$this->form_validation->set_rules('username', 'Username Required', 'trim|required');
		$this->form_validation->set_rules('password', 'Password required', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$result['message'] = false;
		}
		else{
			if($this->input->post('username') && $this->input->post('password'))
			{
				$val = $this->user->StudentLogin($this->input->post('username'),$this->input->post('password'),true);
				if($val == 1){
					$roles = $this->session->userdata('roles');
					if($roles[0]['role_id'] == 3)
					{
						$result['authorize'] = false;
					}else{
						$data['uroles'] = 't';
						$data['interface'] = 'w';
						$this->session->set_userdata($data);
						$result['studentid'] = $this->session->userdata('id');
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
		if($this->session->userdata('id') )
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


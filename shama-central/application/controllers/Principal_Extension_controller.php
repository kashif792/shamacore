<?php
class Principal_Extension_controller extends MY_Controller

{

    /**
     * @var array
     */
    var $data = array();

    function __construct(){
        parent::__construct();
    }


	public function Add_Holiday()
	{
		$this->load->view("principal/Principal_Extension_View/Add_Holiday");
	}

    public function Tablet_List()
    {
        $this->load->View('principal/Principal_Extension_View/Tablet_List.php');
    }

    public function Generic_Grading_Criteria()
    {
        $this->load->View('principal/Principal_Extension_View/grading_criteria.php');
    }
    
}

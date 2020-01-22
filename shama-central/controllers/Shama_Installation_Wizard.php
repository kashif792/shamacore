<?php



class Shama_Installation_Wizard extends MY_Controller

{



    /**

     * @var array

     */

    var $data = array();

    function __construct(){

        parent::__construct();

    }


    public function Principal_Wizard()

    {

        $this->load->view("wizard/principal_installation_wizard",$this->data);

    }




}


<?php
namespace application\core;

use REST_Controller;

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
//require APPPATH . 'libraries/REST_Controller.php';

/**
 * Core controller
 *
 */
class Test_Controller extends REST_Controller
{
    
    function __construct()
    {
        parent::__construct();
        //date_default_timezone_set("Asia/Karachi");
        
        $this->load->model('user');
        $this->load->model('operation');
    }
}


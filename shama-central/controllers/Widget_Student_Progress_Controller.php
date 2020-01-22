<?php

/**
 * Invantage Controller
 *
 * This class responsible for inventage.
 */
class Widget_Student_Progress_Controller extends MY_Controller
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
	 *	Return data for this widget
	 */
	function get_data()
	{
	    echo json_encode([]);
	}
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . 'libraries/REST_Controller.php';

/**
 * Insight API
 *
 * This class responsible for connecting,sending and receiving data to outside web client
 */
class Lms_extention_api extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('operation');
    }

   function GetTabletStatus_post()
    {
        try{
            $result = array();  
             if(!is_null($this->post('mac_address'))  &&  !is_null($this->post('device_name')) && 
                !is_null($this->post('last_connected')) && !is_null($this->post('last_student_id')) && !is_null($this->post('current_student_id')))
            {
                $tablet_status_array =array(
                                                        
                                                        'mac_address'=>$this->post('mac_address'),
                                                        'device_name'=>$this->post('device_name'),
                                                        'last_student_id'=>$this->post('last_student_id'),
                                                        'last_connected'=>$this->post('last_connected'),
                                                        'current_student_id'=>$this->post('current_student_id'),
                                                        'school_id'=>$this->post('School_Id'),
                                                    );
                            $this->operation->table_name = 'tablet_status';
                           $Is_Present=$this->operation->GetRowsByQyery("select * from tablet_status where mac_address='".$this->post('mac_address')."'"); 

                           if($Is_Present)
                           {
                               $is_value_saved = $this->operation->Create($tablet_status_array,$Is_Present[0]->id); 
                                if(count($is_value_saved))
                                {
                                    $this->set_response([
                                    'status' => true,
                                    'message' => 'Data Received'
                                                ],
                                     REST_Controller::HTTP_OK);
                                }
               
                                else{
                                            $this->set_response([
                                            'status' => FALSE,
                                                'message' => 'No data found'
                                            ], REST_Controller::HTTP_NOT_FOUND);
                                }

                           }
                        else{
                            $is_value_saved = $this->operation->Create($tablet_status_array);
                             if(count($is_value_saved))
                                {
                                    $this->set_response([
                                    'status' => true,
                                    'message' => 'Data Received'
                                                ],
                                     REST_Controller::HTTP_OK);
                                }
               
                                else{
                                            $this->set_response([
                                            'status' => FALSE,
                                                'message' => 'No data found'
                                            ], REST_Controller::HTTP_NOT_FOUND);
                                }

                        }
                           
                                
                            
                        

            }
        }
        catch(Exception $e){
            $this->set_response([
                'status' => FALSE,
                    'message' => 'No data found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

      function GetTabletBlockStatus_post()
    {

        try{
            $mac_adress=$this->post('mac_address');

            $this->operation->table_name = "tablet_status";
            $query = $this->operation->GetRowsByQyery("select * from tablet_status where mac_address='".$this->post('mac_address')."'");
            if(count($query))
            {
                $this->set_response([
                    'status' => $query[0]->IsBlock,
                ],
                REST_Controller::HTTP_OK);
            }
            else{
                $this->set_response([
                    'status' => '0',
                ], REST_Controller::HTTP_OK);
            }
        }
        catch(Exception $e){
            $this->set_response([
                'status' => '0',
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }

    
    }



}

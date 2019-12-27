<?php

/**
 * Core controller
 *
 */

class MY_Controller extends CI_Controller {
    
    /**
     * PHP client to make http requests to REST server.  
     */
    var $apiClient;
    
    function  __construct(){
        parent::__construct();
        //$this->apiClient = new \GuzzleHttp\Client();
    }

    /**
     * Get data from SHAMA API
     * @param string $req_type GET, POST
     * @param array $params
     * @return FALSE or JSON decoded data
     *//*
    function shama_api($req_type, $end_point, $params=[]) {
        try{
            if(strtolower($req_type) == 'post'){
                return json_decode((string)$this->apiClient->request('POST', SHAMA_CORE_API_PATH . $end_point, [
                'form_params' => $params
            ])->getBody());
            }else{
                return json_decode((string)$this->apiClient->request('GET', SHAMA_CORE_API_PATH . $end_point, [
                'query' => $params
            ])->getBody());
            }
        }catch (Exception $e){
            // Ignore
            // echo "Debug Log::";
            // echo $e;
        }
        return FALSE;
    }
    */
    
    public function object_2_array($result)
    {
        $array = array();
        foreach ($result as $key => $value) {
            if (is_object($value)) {
                $array[$key] = $this->object_2_array($value);
            } elseif (is_array($value)) {
                $array[$key] = $this->object_2_array($value);
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }
    
    
    /**
     * Redirect url
     *
     */
    public function redirectUrl($path){
        redirect(base_url().$path);
    }

    function GetLogedinUserLocation()
    {
        $locations = $this->session->userdata('locations');
        return (int) $locations[0]['school_id'];
    }

    function ImageConvertorToBase64($file)
    {
        
        $type = pathinfo($file, PATHINFO_EXTENSION);
        $data = file_get_contents($file);
        $base64 = '';
        if(!empty($data))
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }


     public function GetUserActiveSession()
    {
        return $this->session->userdata('default_session_id');
    }

    
    function CheckCurrentWeekend($date)
    {
        if(date('D',strtotime($date)) == 'Sat' || date('D',strtotime($date)) == 'Sun') {
            return true;
        }
        return false;
    }

    function FindNextMondayDate($date)
    {
        $date = date('Y-m-d', strtotime("next monday", strtotime($date)));
        $date = new DateTime($date);
        $date = $date->format('Y-m-d');
        return $date;
    }

    function IsPeriodHoursMatched($subject_star_time,$subject_end_time,$holiday_start_time,$holiday_end_time)
    {
        date_default_timezone_set("Asia/Karachi");
    
        // check current period hours
        // &&  date('H:i',strtotime($holiday_end_time)) <= date('H:i',$subject_end_time)
        if( date('H:i',strtotime($holiday_start_time)) >= date('H:i',$subject_star_time) && date('H:i',$subject_end_time)<= date('H:i',strtotime($holiday_end_time)))
        {
            return false;
        }
        return true;
    }

    function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString.time();
    }
    
}

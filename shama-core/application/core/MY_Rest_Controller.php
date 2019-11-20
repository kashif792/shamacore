<?php
require APPPATH . 'libraries/REST_Controller.php';

/**
 * Core REST API base controller
 */
class MY_Rest_Controller extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        // date_default_timezone_set("Asia/Karachi");

        $this->load->model('user');
        $this->load->model('operation');
    }

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

    function image_file_to_base64($file)
    {
        $type = pathinfo($file, PATHINFO_EXTENSION);
        $data = file_get_contents($file);
        $base64 = '';
        if (! empty($data))
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    // Function to check string starting
    // with given substring
    function startsWith($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    // Function to check the string is ends
    // with given substring or not
    function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, - $len) === $endString);
    }

    function is_period_hours_matched($subject_star_time, $subject_end_time, $holiday_start_time, $holiday_end_time)
    {
        // check current period hours
        // && date('H:i',strtotime($holiday_end_time)) <= date('H:i',$subject_end_time)
        if (date('H:i', strtotime($holiday_start_time)) >= date('H:i', $subject_star_time) && date('H:i', $subject_end_time) <= date('H:i', strtotime($holiday_end_time))) {
            return false;
        }
        return true;
    }

    // region utility functions
    function get_default_semesters()
    {
        return array(
            'Fall',
            'Spring'
        );
    }

    function get_default_evaluation_types()
    {
        return array(
            array(
                'slug' => 'ass',
                'value' => 0,
                'title' => 'Assignment'
            ),
            array(
                'slug' => 'qui',
                'value' => 0,
                'title' => 'Quiz'
            ),
            array(
                'slug' => 'mid',
                'value' => 30,
                'title' => 'Mid term'
            ),
            array(
                'slug' => 'fin',
                'value' => 50,
                'title' => 'Final exam'
            ),
            array(
                'slug' => 'pra',
                'value' => 0,
                'title' => 'Practical'
            ),
            array(
                'slug' => 'att',
                'value' => 0,
                'title' => 'Attendance'
            ),
            array(
                'slug' => 'orl',
                'value' => 0,
                'title' => 'Oral'
            ),
            array(
                'slug' => 'beh',
                'value' => 0,
                'title' => 'Behavior'
            )
        );
    }

    function get_default_grades()
    {
        return array(
            array(
                'id' => 1,
                'title' => 'A',
                'lower_limit' => 90,
                'upper_limit' => 100
            ),
            array(
                'id' => 2,
                'title' => 'B',
                'lower_limit' => 80,
                'upper_limit' => 90
            ),
            array(
                'id' => 3,
                'title' => 'C',
                'lower_limit' => 70,
                'upper_limit' => 79
            ),
            array(
                'id' => 4,
                'title' => 'D',
                'lower_limit' => 60,
                'upper_limit' => 69
            ),
            array(
                'id' => 5,
                'title' => 'F',
                'lower_limit' => 0,
                'upper_limit' => 59
            )
        );
    }

    function get_default_classes()
    {
        return array(
            array(
                'id' => 1,
                'title' => 'Play Group',
                'slug' => 'pg'
            ),
            array(
                'id' => 2,
                'title' => 'Kindergarten',
                'slug' => 'kg'
            ),
            array(
                'id' => 3,
                'title' => 'Grade 1',
                'slug' => '1'
            ),
            array(
                'id' => 4,
                'title' => 'Grade 2',
                'slug' => '2'
            ),
            array(
                'id' => 5,
                'title' => 'Grade 3',
                'slug' => '3'
            ),
            array(
                'id' => 6,
                'title' => 'Grade 4',
                'slug' => '4'
            ),
            array(
                'id' => 7,
                'title' => 'Grade 5',
                'slug' => '5'
            )
        );
    }

    function get_default_sections()
    {
        return array(

            array(
                'id' => 1,
                'title' => 'Blue'
            ),

            array(
                'id' => 2,
                'title' => 'Green'
            ),

            array(
                'id' => 3,
                'title' => 'Yellow'
            )
        );
    }

    function get_default_subjects($slug = '')
    {
        $subjects = array();

        if (! empty($slug)) {
            $slug = strtolower($slug);
        }

        if (empty($slug)) {
            $subjects = array(
                array(
                    'id' => 1,
                    'title' => 'English'
                ),
                array(
                    'id' => 2,
                    'title' => 'Urdu'
                ),
                array(
                    'id' => 3,
                    'title' => 'Math'
                ),
                array(
                    'id' => 4,
                    'title' => 'Science'
                ),
                array(
                    'id' => 5,
                    'title' => 'Islamiat'
                ),
                array(
                    'id' => 6,
                    'title' => 'Social Studies'
                ),
                array(
                    'id' => 7,
                    'title' => 'Computer'
                ),
                array(
                    'id' => 8,
                    'title' => 'Our Values'
                )
            );
        } else if ($slug == 'kindergarten') {
            $subjects = array(
                array(
                    'id' => 1,
                    'title' => 'English'
                ),
                array(
                    'id' => 2,
                    'title' => 'Urdu'
                ),
                array(
                    'id' => 3,
                    'title' => 'Math'
                ),
                array(
                    'id' => 4,
                    'title' => 'Science'
                ),
                array(
                    'id' => 5,
                    'title' => 'Islamiat'
                )
            );
        }

        return $subjects;
    }

    function get_random_color()
    {
        $color = array(
            '#37ef9c',
            '#ff2190',
            '#9239e5',
            '#c43e2d',
            '#13ad0d',
            '#039b82',
            '#061187',
            '#0b417f',
            '#ab46bc',
            '#f4b400',
            '#db4438'
        );

        return $color[rand(0, count($color) - 1)];
    }

    function create_directory($path)
    {
        try {
            if (! file_exists($path)) {
                mkdir($path, 0755, true);
                return true;
            }
            return false;
        } catch (Exception $e) {}
    }

    function is_before($t, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $t));
    }

    function is_after($t, $inthat)
    {
        if (! is_bool(strpos($inthat, $t)))
            return substr($inthat, strpos($inthat, $t) + strlen($t));
    }

    function is_between($t, $that, $inthat)
    {
        return $this->is_before($that, $this->is_after($t, $inthat));
    }

    public function is_valid($type, $value, $locale, $time_zone)
    {
        $result = false;

        $types = array(
            VALIDATE_EMAIL,
            VALIDATE_PHONE,
            VALIDATE_ADDRESS,
            VALIDATE_NAME,
            VALIDATE_NIC
        );

        if (! empty($type) && ! empty($value) && in_array($type, $types)) {
            if (is_null($locale) || empty($locale)) {
                $locale = locale_get_default();
            }

            if (is_null($time_zone) || empty($time_zone)) {
                $time_zone = date_default_timezone_get();
            }

            // TODO implement locate and time zone based validation

            $type = strtolower($type);

            if (VALIDATE_NAME == $type) {
                if (! preg_match("/^[a-zA-Z ]{3,50}$/", $value)) {
                    $result = false;
                } else {
                    $result = true;
                }
            } elseif (VALIDATE_EMAIL == $type) {

                if (! preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/", $value)) {
                    $result = false;
                } else {
                    $result = true;
                }
            } elseif (VALIDATE_PHONE == $type) {

                if (! preg_match("/^[0-9]{4}-[0-9]{7}$/", $value)) {
                    $result = false;
                } else {
                    $result = true;
                }
            } elseif (VALIDATE_ADDRESS == $type) {

                if (! preg_match("/^[a-zA-Z ]{3,50}$/", $value)) {
                    $result = false;
                } else {
                    $result = true;
                }
            } elseif (VALIDATE_NIC == $type) {

                if (! preg_match("/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/", $value)) {
                    $result = false;
                } else {
                    $result = true;
                }
            }
        }

        return $result;
    }

    /**
     * Parse params using request types PUT, DELETE, GET, POST
     *
     * @return array of param key value pairs
     */
    function parse_params()
    {
        $params = array();
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method == "GET") {

            $params = $_GET;
        } else if ($method == "POST") {
            try {
                $query = file_get_contents('php://input');

                $params = json_decode($query);
                    // $params = $this->object_2_array($result);
                
            } catch (Exception $e) {
                //echo $e;
                if (count($_POST)) {

                    $params = $_POST;
                } else if (count($_GET)) {

                    $params = $_GET;
                }
            }
        } else if ($method == "DELETE") {

            if (count($_GET)) {
                // JQuery
                $params = $_GET;
            } else {
                // AJAX
                $query = file_get_contents('php://input');
                parse_str($query, $params);
            }
        } else if ($method == "PUT") {

            if (count($_POST)) {
                // JQuery
                $params = $_POST;
            } else {
                // AJAX
                $query = file_get_contents('php://input');
                parse_str($query, $params);
            }
        }

        return $params;
    }

    function get_class_slug($class_name)
    {
        $class_slug = '';
        if ($class_name != '') {
            $class_list = $this->get_default_classes();
            foreach ($class_list as $key => $value) {
                if ($value['title'] == $class_name) {
                    $class_slug = $value['slug'];
                }
            }
        }
        return $class_slug;
    }

    function generate_random_string($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i ++) {
            // Making sure first character is not numeric
            $randomString .= $characters[rand($i == 0 ? 10 : 0, $charactersLength - 1)];
        }

        return $randomString;
    }


    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
     * Check if record exists for given field and value.
     *
     * @param string $field
     * @param mixed $value
     * @param string $target_id
     *            Limit scope to particular target. Global scope by default.
     */
    public function record_exists($field, $value, $target_id)
    {
        $types = array(
            'email',
            'phone',
            'nic'
        );

        $result = false;

        if (! empty($field) && ! empty($value) && in_array($field, $types)) {

            $this->operation->table_name = 'invantage_users';

            if ($target_id != null && ! empty($target_id)) {

                $res = $this->operation->GetByWhere(array(
                    'id' => $target_id,
                    $field => $value
                ));
            } else {

                $res = $this->operation->GetByWhere(array(
                    $field => $value
                ));
            }

            if (count($res)) {
                $result = true;
            }
        }

        return $result;
    }

    function get_subject($subject_id)
    {
        if (! empty($subject_id)) {
            $is_subject_found = $this->operation->GetByQuery("SELECT * FROM subjects WHERE id = " . $subject_id);
            if (count($is_subject_found)) {
                return $is_subject_found[0];
            } else {
                return false;
            }
        }
    }

    function get_subjects($class_id)
    {
        if (! empty($class_id)) {
            $this->operation->table_name = 'subjects';
            return $this->operation->GetByWhere(array(
                'class_id' => $class_id
                
            ));
        }
    }

    function get_location($location_id)
    {
        $is_location_found = $this->operation->GetByQuery("SELECT * FROM location WHERE id=" . $location_id);
        if (count($is_location_found)) {
            return $is_location_found[0];
        } else {
            return false;
        }
    }

    function get_session($id)
    {
        $this->operation->table_name = 'sessions';
        return $this->operation->GetByWhere(array(
            'id' => $id
        ));
    }

    function get_semester($id)
    {
        $this->operation->table_name = 'semester';
        return $this->operation->GetByWhere(array(
            'id' => $id
        ));
    }

    function get_semester_by_name($name)
    {
        if (! is_null($name)) {
            $this->operation->table_name = 'semester';
            return $this->operation->GetByWhere(array(
                'semester_name' => $name
            ));
        }
        return FALSE;
    }

    function get_active_semester_dates($school_id)
    {
        $this->operation->table_name = 'semester_dates';
        return $this->operation->GetByWhere(array(
            'status' => 'a',
            'school_id' => $school_id
        ));
    }

    function get_active_session($school_id)
    {
        $this->operation->table_name = 'sessions';
        $res = $this->operation->GetByWhere(array(
            'status' => 'a',
            'school_id' => $school_id
        ));
        if (count($res)) {
            return $res[0];
        }
        return FALSE;
    }

    function get_holiday_type($id)
    {
        $this->operation->table_name = 'holiday_type';
        return $this->operation->GetByWhere(array(
            'id' => $id
        ));
    }

    function get_holidays($school_id)
    {
        try {

            $this->operation->table_name = 'holiday';
            $holidays = $this->operation->GetByWhere(array(
                'school_id' => $school_id
            ));

            $semester_holidays = array();
            $i = 0;
            if (count($holidays)) {
                foreach ($holidays as $value) {

                    if ($value->all_day == 'y' && $value->apply == 'y') {

                        // check single holiday

                        if (date('Y-m-d', strtotime($value->start_date)) == date('Y-m-d', strtotime($value->end_date))) {
                            $semester_holidays[$i] = date('Y-m-d', strtotime($value->start_date));
                            $i ++;
                        } else {

                            // multi dats

                            $date = date('Y-m-d', strtotime($value->start_date));

                            // End date

                            $end_date = date('Y-m-d', strtotime($value->end_date));
                            while (strtotime($date) <= strtotime($end_date)) {
                                $semester_holidays[$i] = $date;
                                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                $i ++;
                            }
                        }
                    }
                }
            }

            return $semester_holidays;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return FALSE;
    }

    function check_weekend($date)
    {
        if (date('D', strtotime($date)) == 'Sat' || date('D', strtotime($date)) == 'Sun') {
            return true;
        }

        return false;
    }

    function find_next_monday($date)
    {
        $date = date('Y-m-d', strtotime("next monday", strtotime($date)));
        $date = new DateTime($date);
        $date = $date->format('Y-m-d');
        return $date;
    }

    function is_full_day_holiday($holidays, $date)
    {
        if (in_array($date, $holidays)) {
            return true;
        }

        return false;
    }

    function is_short_day_holiday($date)
    {
        if (count($this->operation->GetByQuery("SELECT * FROM holiday WHERE apply = 'y' AND all_day = 'n' AND '" . $date . "' BETWEEN date(start_date) AND date(end_date)"))) {
            return TRUE;
        }
        return FALSE;
    }

    // Check if given date falls on weekend or holiday and get next available working day accordingly
    function get_next_working_date($holidays, $date)
    {
        if (! empty($date)) {

            try {

                while ($this->check_weekend($date) || $this->is_full_day_holiday($holidays, $date) || $this->is_short_day_holiday($date)) {

                    if ($this->check_weekend($date)) {

                        $date = $this->find_next_monday($date);
                    } else {

                        $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                    }
                }

                return $date;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        return FALSE;
    }

    function get_class_name($class_id)
    {
        $is_class_found = $this->operation->GetByQuery("SELECT c.* FROM classes c WHERE c.id = " . $class_id);
        if (count($is_class_found)) {
            return $is_class_found[0]->grade;
        } else {
            return false;
        }
    }

    function get_class_period_time($class_id, $section_id, $subject_id, $location, $semester_id, $session_id)
    {
        $this->operation->table_name = 'schedule';
        return $this->operation->GetByWhere(array(
            'class_id' => $class_id,
            'section_id' => $section_id,
            'subject_id' => $subject_id,
            'semester_id' => $semester_id,
            'session_id' => $session_id
        ));
    }

    function is_period_hours_match($subject_star_time, $subject_end_time, $holiday_start_time, $holiday_end_time)
    {
        // check current period hours
        if (date('H:i', strtotime($holiday_start_time)) >= date('H:i', $subject_star_time) && date('H:i', $subject_end_time) <= date('H:i', strtotime($holiday_end_time))) {
            return false;
        }

        return true;
    }

    function get_active_semester_dates_by_session($session_id)
    {
        if ($session_id) {
            $this->operation->table_name = 'semester_dates';
            $this->operation->primary_key = 'session_id';
            $is_semester_dates_found = $this->operation->GetByWhere(array(
                'session_id' => $session_id,
                'status' => 'a'
            ));

            if (count($is_semester_dates_found))
                return $is_semester_dates_found[0];
        }
        return FALSE;
    }

    function get_uploaded_file_url($file_name, $upload_cat)
    {
        $url = $file_name;
        
        if (strlen(UPLOAD_PATH) <= 2) {
            echo "Invalid Upload Path: " . UPLOAD_PATH;
            return $url;
        }
        
        $upload_path = UPLOAD_PATH;
        if ($this->startsWith(UPLOAD_PATH, './') || $this->startsWith(UPLOAD_PATH, '/')) {
            // relative path link
            if ($this->startsWith(UPLOAD_PATH, './')) {
                $upload_path = base_url() . substr(UPLOAD_PATH, 2, strlen(UPLOAD_PATH));
            } else {
                $upload_path = base_url() . substr(UPLOAD_PATH, 1, strlen(UPLOAD_PATH));
            }
        }
        
        if (! empty($upload_cat)) {

            if ($upload_cat == UPLOAD_CAT_PROFILE) {

                $url = $upload_path . UPLOAD_CAT_PROFILE . '/' . $file_name;

                return $url;
            }
        }

        $url = $upload_path . $file_name;

        return $url;
    }
    
    
    function get_content_url($file_name, $class_name='', $subject_name='') {
        $url = $file_name;
        
        if (strlen(UPLOAD_PATH) <= 2) {
            echo "Invalid Upload Path: " . UPLOAD_PATH;
            return $url;
        }
        
        $upload_path = UPLOAD_PATH;
        if ($this->startsWith(UPLOAD_PATH, './') || $this->startsWith(UPLOAD_PATH, '/')) {
            // relative path link
            if ($this->startsWith(UPLOAD_PATH, './')) {
                $upload_path = base_url() . substr(UPLOAD_PATH, 2, strlen(UPLOAD_PATH));
            } else {
                $upload_path = base_url() . substr(UPLOAD_PATH, 1, strlen(UPLOAD_PATH));
            }
        }
        
        $innerPath = "content/";
        
        if (! empty($class_name)) {
            
               $innerPath .= $class_name . "/";
        }
        if (! empty($subject_name)) {
            
            $innerPath .= $subject_name . "/";
        }
        
        $url = $upload_path . $innerPath. $file_name;
        
        return $url;
    }
    
    function get_user_profile($user_id)
    {
        $result = array();
        $role = $this->get_user_role($user_id);

        if ($role && $role->role_id == 4) {
            $is_teacher_found = $this->operation->GetByQuery("SELECT inuser.* FROM invantage_users inuser WHERE inuser.type = 't'  AND id = " . $user_id);
            if (count($is_teacher_found)) {
                $result['message'] = true;
                foreach ($is_teacher_found as $value) {
                    $result['id'] = $value->id;
                    $result['first_name'] = ($this->get_user_meta($value->id, 'teacher_firstname') != false ? $this->get_user_meta($value->id, 'teacher_firstname') : '');

                    $result['last_name'] = ($this->get_user_meta($value->id, 'teacher_lastname') != false ? $this->get_user_meta($value->id, 'teacher_lastname') : '');
                    $result['email'] = $value->email;
                    $result['profile_image'] = $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE);
                    // $result['location'] = $value->location;
                    $result['religion'] = ($this->get_user_meta($value->id, 'teacher_religion') != false ? $this->get_user_meta($value->id, 'teacher_religion') : '');

                    $result['gender'] = ($this->get_user_meta($value->id, 'teacher_gender') != false ? $this->get_user_meta($value->id, 'teacher_gender') : '');
                    $result['nic'] = ($this->get_user_meta($value->id, 'teacher_nic') != false ? $this->get_user_meta($value->id, 'teacher_nic') : '');
                    $result['phone'] = ($this->get_user_meta($value->id, 'teacher_phone') != false ? $this->get_user_meta($value->id, 'teacher_phone') : '');
                    $result['p_address'] = ($this->get_user_meta($value->id, 'teacher_primary_address') != false ? $this->get_user_meta($value->id, 'teacher_primary_address') : '');
                    $result['s_address'] = ($this->get_user_meta($value->id, 'teacher_secondry_adress') != false ? $this->get_user_meta($value->id, 'teacher_secondry_adress') : '');
                    $result['city'] = ($this->get_user_meta($value->id, 'teacher_city') != false ? $this->get_user_meta($value->id, 'teacher_city') : '');
                    $result['province'] = ($this->get_user_meta($value->id, 'teacher_province') != false ? $this->get_user_meta($value->id, 'teacher_province') : '');
                    $result['zip_code'] = ($this->get_user_meta($value->id, 'teacher_zipcode') != false ? $this->get_user_meta($value->id, 'teacher_zipcode') : '');
                }
            }
        } elseif ($role && $role->role_id == 3) {
            $is_teacher_found = $this->operation->GetByQuery("SELECT inuser.* FROM invantage_users inuser WHERE inuser.type = 'p'  AND id = " . $user_id);

            if (count($is_teacher_found)) {
                $result['message'] = true;
                foreach ($is_teacher_found as $value) {
                    $result['id'] = $value->id;
                    $result['first_name'] = ($this->get_user_meta($value->id, 'principal_firstname') != false ? $this->get_user_meta($value->id, 'principal_firstname') : '');

                    $result['last_name'] = ($this->get_user_meta($value->id, 'principal_lastname') != false ? $this->get_user_meta($value->id, 'principal_lastname') : '');
                    $result['email'] = $value->email;
                    $result['profile_image'] = $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE);
                    $result['religion'] = ($this->get_user_meta($value->id, 'principal_religion') != false ? $this->get_user_meta($value->id, 'teacher_religion') : '');

                    $result['gender'] = ($this->get_user_meta($value->id, 'principal_gender') != false ? $this->get_user_meta($value->id, 'principal_gender') : '');
                    $result['nic'] = ($this->get_user_meta($value->id, 'principal_nic') != false ? $this->get_user_meta($value->id, 'teacher_nic') : '');
                    $result['phone'] = ($this->get_user_meta($value->id, 'principal_phone') != false ? $this->get_user_meta($value->id, 'principal_phone') : '');
                    $result['p_address'] = ($this->get_user_meta($value->id, 'principal_primary_address') != false ? $this->get_user_meta($value->id, 'principal_primary_address') : '');
                    $result['s_address'] = ($this->get_user_meta($value->id, 'principal_secondry_adress') != false ? $this->get_user_meta($value->id, 'principal_secondry_adress') : '');
                    $result['city'] = ($this->get_user_meta($value->id, 'principal_city') != false ? $this->get_user_meta($value->id, 'principal_city') : '');
                    $result['province'] = ($this->get_user_meta($value->id, 'principal_province') != false ? $this->get_user_meta($value->id, 'principal_province') : '');
                    $result['zip_code'] = ($this->get_user_meta($value->id, 'principal_zipcode') != false ? $this->get_user_meta($value->id, 'principal_zipcode') : '');
                }
            }
        } elseif ($role && $role->role_id == 1) {
            $is_teacher_found = $this->operation->GetByQuery("SELECT inuser.* FROM invantage_users inuser WHERE  id = " . $user_id);

            if (count($is_teacher_found)) {
                $result['message'] = true;
                foreach ($is_teacher_found as $value) {
                    $result['id'] = $value->id;
                    $result['first_name'] = ($this->get_user_meta($value->id, 'admin_firstname') != false ? $this->get_user_meta($value->id, 'admin_firstname') : '');

                    $result['last_name'] = ($this->get_user_meta($value->id, 'admin_lastname') != false ? $this->get_user_meta($value->id, 'admin_lastname') : '');
                    $result['email'] = $value->email;
                    $result['profile_image'] = $this->get_uploaded_file_url($value->profile_image, UPLOAD_CAT_PROFILE);
                    $result['religion'] = ($this->get_user_meta($value->id, 'admin_religion') != false ? $this->get_user_meta($value->id, 'admin_religion') : '');

                    $result['gender'] = ($this->get_user_meta($value->id, 'admin_gender') != false ? $this->get_user_meta($value->id, 'admin_gender') : '');
                    $result['nic'] = ($this->get_user_meta($value->id, 'admin_nic') != false ? $this->get_user_meta($value->id, 'admin_nic') : '');
                    $result['phone'] = ($this->get_user_meta($value->id, 'admin_phone') != false ? $this->get_user_meta($value->id, 'admin_phone') : '');
                    $result['p_address'] = ($this->get_user_meta($value->id, 'admin_primary_address') != false ? $this->get_user_meta($value->id, 'admin_primary_address') : '');
                    $result['s_address'] = ($this->get_user_meta($value->id, 'admin_secondary_address') != false ? $this->get_user_meta($value->id, 'admin_secondary_address') : '');
                    $result['city'] = ($this->get_user_meta($value->id, 'admin_city') != false ? $this->get_user_meta($value->id, 'admin_city') : '');
                    $result['province'] = ($this->get_user_meta($value->id, 'admin_province') != false ? $this->get_user_meta($value->id, 'admin_province') : '');
                    $result['zip_code'] = ($this->get_user_meta($value->id, 'admin_zipcode') != false ? $this->get_user_meta($value->id, 'admin_zipcode') : '');
                }
            }
        }
        return $result;
    }

    function get_user_meta($userid, $metakey)
    {
        $is_meta_found = $this->operation->GetByQuery("SELECT * FROM user_meta WHERE user_id = " . $userid . " AND meta_key = '" . $metakey . "'");

        // print_r($this->db->last_query());

        if (count($is_meta_found)) {
            return $is_meta_found[0]->meta_value;
        } else {
            return FALSE;
        }
    }

    function get_user_role($user_id)
    {
        $user_roles = array();

        if (! empty($user_id))
            $user_roles = $this->user->get_by_query("SELECT ur.role_id,r.type FROM user_roles ur INNER JOIN roles r ON r.id = ur.role_id  WHERE user_id =" . $user_id);

        if (count($user_roles)) {
            return $user_roles[0];
        }
        return FALSE;
    }

    function get_grade($number, $session_id)
    {
        $obtain_grade = 'F';

        $this->operation->table_name = 'semester_dates';
        $this->operation->primary_key = 'session_id';
        $current_semester_date = $this->operation->GetByWhere(array(
            'session_id' => $session_id,
            'status' => 'a'
        ));

        if (count($current_semester_date)) {
            $this->operation->table_name = 'grades';
            $grades = $this->operation->GetByWhere(array(
                'semester_date_id' => $current_semester_date[0]->id
            ));
        }

        if (count($grades) && $number > 0) {
            $grades = unserialize($grades[0]->option_value);

            foreach ($grades as $key => $value) {

                if ($number >= (double) $value['lower_limit'] && $number <= (double) $value['upper_limit']) {
                    $obtain_grade = $value['title'];
                }
            }
        }
        return $obtain_grade;
    }

    function get_excel_data($file_name)
    {
        try {
            require (APPPATH . 'third_party/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
        } catch (Exception $ex) {}

        try {
            $inputfiletype = PHPExcel_IOFactory::identify($file_name);
            $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
            $objPHPExcel = $objReader->load($file_name);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($file_name, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $result = array();
        for ($row = 1; $row <= $highestRow; $row ++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            $result[] = $rowData;
        }
        return $result;
    }

    function string_limit_words($string, $word_limit)
    {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $word_limit));
    }

    function slug_generator($title)
    {
        $time = time();
        $newtitle = $this->string_limit_words(strtolower($title), 6); // First 6 words
        $newtitle = preg_replace('/[^a-z0-9]/i', ' ', $newtitle);
        $newurltitle = str_replace(" ", "-", $newtitle);
        $url = $time . $newurltitle; // Final URL
        return $url;
    }

    /**
     * Update evaluation table
     */
    function change_evaluation_semester($current_semester_date_id, $new_semester_date_id)
    {
        $id = 0;
        // check current evaluation
        if (is_int($current_semester_date_id)) {
            // find previous evaluation
            $this->operation->table_name = 'evaluation';
            $get_last_evaluation = $this->operation->GetByWhere(array(
                'semester_date_id' => $current_semester_date_id,
                'status' => 'a'
            ));

            if (count($get_last_evaluation)) {
                $this->db->query("Update evaluation set status = 'i' where semester_date_id = " . $current_semester_date_id);
                $this->operation->primary_key = "semester_date_id";
                $option = array(
                    'semester_date_id' => $new_semester_date_id,
                    'option_value' => serialize($get_last_evaluation[0]->option_value),
                    'status' => 'a'
                );
                $id = $this->operation->Create($option, $new_semester_date_id);
            } else {
                $option = array(
                    'semester_date_id' => $new_semester_date_id,
                    'option_value' => serialize($this->get_default_evaluation_types()),
                    'status' => 'a'
                );
                $id = $this->operation->Create($option);
            }
        }
        return $id > 0;
    }

    /**
     * Update grades table
     *
     * @access private
     */
    function change_grades_semester($current_semester_date_id, $new_semester_date_id)
    {
        $id = 0;
        // check current grades list
        if (is_int($current_semester_date_id)) {
            // find previous evaluation
            $this->operation->table_name = 'grades';
            $get_last_grades = $this->operation->GetByWhere(array(
                'semester_date_id' => $current_semester_date_id
            ));

            if (count($get_last_grades)) {
                $this->db->query("UPDATE grades SET status = 'i' WHERE semester_date_id = " . $current_semester_date_id);

                $this->operation->primary_key = "semester_date_id";
                $option = array(
                    'semester_date_id' => $new_semester_date_id,
                    'option_value' => serialize($get_last_grades[0]->option_value),
                    'status' => 'a'
                );
                $id = $this->operation->Create($option, $new_semester_date_id);
            } else {
                $option = array(
                    'semester_date_id' => $new_semester_date_id,
                    'option_value' => serialize($this->get_default_grades()),
                    'status' => 'a'
                );
                $id = $this->operation->Create($option);
            }
        }
        return $id > 0;
    }

    function get_school($school_id)
    {
        $is_school_found = $this->operation->GetByQuery("SELECT s.*,l.location FROM schools s INNER JOIN location l ON l.id = s.cityid WHERE s.id=" . $school_id);

        if (count($is_school_found)) {
            return $is_school_found[0];
        } else {
            return false;
        }
    }

    function get_evaluation_by_type($type, $session_id)
    {
        $evaluation_point = 0;

        if (! empty($type) && ! empty($session_id)) {

            $this->operation->table_name = 'semester_dates';
            $this->operation->primary_key = 'session_id';
            $current_semester_date = $this->operation->GetByWhere(array(
                'session_id' => $session_id,
                'status' => 'a'
            ));

            $this->operation->table_name = 'evaluation';
            $is_eva_found = $this->operation->GetByWhere(array(
                'semester_date_id' => $current_semester_date[0]->id
            ));

            if (count($is_eva_found)) {
                $eva_list = unserialize($is_eva_found[0]->option_value);
                if ($type == 'ass') {
                    $evaluation_point = (int) $eva_list[0]['value'];
                } else if ($type == 'qui') {
                    $evaluation_point = (int) $eva_list[1]['value'];
                } else if ($type == 'mid') {
                    $evaluation_point = (int) $eva_list[2]['value'];
                } else if ($type == 'fin') {
                    $evaluation_point = (int) $eva_list[3]['value'];
                } else if ($type == 'pra') {
                    $evaluation_point = (int) $eva_list[4]['value'];
                } else if ($type == 'att') {
                    $evaluation_point = (int) $eva_list[5]['value'];
                } else if ($type == 'orl') {
                    $evaluation_point = (int) $eva_list[6]['value'];
                } else if ($type == 'beh') {
                    $evaluation_point = (int) $eva_list[7]['value'];
                }
            }
        }

        return $evaluation_point;
    }

    /**
     * Calculate student quiz marks
     *
     * @param
     *            student_id int
     * @param
     *            class_id int
     * @param
     *            section_id int
     * @param
     *            semester_id int
     * @param
     *            session_id int
     *            
     */
    function calculate_student_quiz_marks($student_id, $class_id, $section_id, $semester_id, $session_id, $school_id)
    {
        $subjectlist = $this->get_subjects($class_id);
        $student_quiz = array();
        if (count($subjectlist)) {
            $sum_subject = array();
            foreach ($subjectlist as $key => $value) {
                $quizlist = $this->operation->GetByQuery('SELECT q.id,q.quiz_term FROM `quiz` q WHERE subject_id =' . $value->id . ' AND class_id = ' . $class_id . ' AND section_id = ' . $section_id . ' AND semester_id = ' . $semester_id . ' AND session_id = ' . $session_id . '  ORDER BY quiz_term');
                if (count($quizlist)) :
                    $find_quiz_marks = array();
                    foreach ($quizlist as $key => $qvalue) {
                        array_push($find_quiz_marks, (int) $this->calculate_subject_wise_student_quiz((int) $student_id, (int) $qvalue->id));
                    }
                    $quiz_evaluation_points = $this->get_evaluation_by_type('qui', $session_id);

                    array_push($sum_subject, (((array_sum($find_quiz_marks) / 100) * $quiz_evaluation_points)));
                endif;

            }

            $student_quiz[0] = (array_sum($sum_subject) / count($subjectlist));
            $student_quiz[1] = (array_sum($sum_subject));
        }
        return $student_quiz;
    }

    /**
     * Calculate subject wise quiz marks
     *
     * @param
     *            student_id int
     * @param
     *            quizid int
     *            
     */
    function calculate_subject_wise_student_quiz($student_id, $quizid)
    {
        $quizdetailarray = 0;

        if (is_int($student_id) && is_int($quizid)) {

            $questionlist = $this->operation->GetByQuery('SELECT qz.quizid,qz.questionid as quesid,qo.qoption_id  FROM quiz_evaluation qz INNER JOIN quizeoptions qo ON qo.qoption_id = qz.optionid WHERE qz.student_id =' . $student_id . " AND qz.quizid=" . $quizid);

            if (count($questionlist)) {
                $total_count = 0;
                foreach ($questionlist as $key => $value) {

                    $is_correct_answer_matched = $this->operation->GetByQuery('SELECT * FROM correct_option  WHERE question_id =' . $value->quesid);

                    if ($is_correct_answer_matched[0]->correct_id == $value->qoption_id) {
                        $total_count ++;
                    }
                }
                $quizdetailarray = (($total_count / count($questionlist)) * 100);
            } else {
                $quizdetailarray = 0;
            }
        }

        return $quizdetailarray;
    }

    function get_student($student_id)
    {
        $this->operation->table_name = 'invantage_users';
        $res = $this->operation->GetByWhere(array(
            'id' => $student_id
        ));

        if (count($res)) {
            return $res[0];
        }
        return FALSE;
    }

    function get_student_name($student_id)
    {
        $fname = $this->get_user_meta($student_id, 'sfullname');
        $name = $this->get_user_meta($student_id, 'slastname');
        if (! empty($fname) && ! empty($name)) {
            return $fname . " " . $name;
        } else {
            return "";
        }
    }

    function get_student_progress($lessonid, $student_id)
    {
        $studentprogress = $this->operation->GetByQuery('SELECT * FROM `lesson_progress` where lessonid =' . $lessonid . " AND student_id=" . $student_id);

        $sparray = array();
        if (count($studentprogress)) {
            foreach ($studentprogress as $key => $spvalue) {
                $sparray = array(
                    'lesson_id' => $spvalue->lessonid,
                    'status' => $spvalue->status,
                    'last_updated' => $spvalue->last_updated
                );
            }
        } else {
            $sparray = array(
                'lesson_id' => $lessonid,
                'status' => 'unread'
            );
        }
        return $sparray;
    }

    function get_quiz_option($student_id, $quizid, $questionid)
    {
        return $this->operation->GetByQuery('SELECT * FROM quiz_evaluation  WHERE  	student_id = ' . $student_id . ' AND quizid = ' . $quizid . ' AND questionid = ' . $questionid . ' limit 1');
    }

    /**
     * Calculate student term marks
     *
     * @param
     *            student_id int
     * @param
     *            class_id int
     * @param
     *            section_id int
     * @param
     *            semester_id int
     * @param
     *            session_id int
     * @param
     *            termid int
     *            
     */
    function calculate_student_term_marks($student_id, $class_id, $section_id, $semester_id, $session_id, $termid, $school_id)
    {
        $student_result = array();
        $subjectlist = $this->get_subjects($class_id);
        if (count($subjectlist)) {
            $subject_result = array();
            foreach ($subjectlist as $key => $value) {
                if (is_int($semester_id)) {
                    $termlist = $this->operation->GetByQuery('SELECT * FROM term_exam_result  where class_id = ' . $class_id . ' AND section_id = ' . $section_id . ' AND semester_id = ' . $semester_id . ' AND session_id = ' . $session_id . ' AND subject_id = ' . $value->id . ' AND student_id= ' . $student_id . " order by termid asc");
                } else {
                    $termlist = $this->operation->GetByQuery('SELECT * FROM term_exam_result  where class_id = ' . $class_id . ' AND section_id = ' . $section_id . ' AND session_id = ' . $session_id . ' AND subject_id = ' . $value->id . ' AND student_id= ' . $student_id . " order by termid asc");
                }

                if (count($termlist)) {
                    foreach ($termlist as $key => $tvalue) {
                        if ($tvalue->termid == $termid) {
                            array_push($subject_result, $tvalue->marks);
                        }
                    }
                }
            }
            $student_result[0] = (array_sum($subject_result) / count($subjectlist));
            $student_result[1] = (array_sum($subject_result));
        }

        return $student_result;
    }

    function FindActiveSemesterId($semester_title)

    {
        $this->operation->table_name = 'semester';

        return $this->operation->GetByWhere(array(

            'semester_name' => $semester_title
        ));
    }

    function GetDefaultLessonPlanFile($class_name, $subject_name, $semester)

    {
        return UPLOAD_PATH . 'temp_folder/' . $semester . '/' . ucfirst(str_replace(" ", "_", trim(strtolower($class_name)))) . "_" . ucfirst(str_replace(" ", "_", trim(strtolower($subject_name)))) . ".xlsx";
    }

    function Readfile($file_name, $class_id, $section_id, $subject_id, $semester_id, $session_id)

    {
        try {

            $inputfiletype = PHPExcel_IOFactory::identify($file_name);

            $objReader = PHPExcel_IOFactory::createReader($inputfiletype);

            $objReader->setReadDataOnly(true);

            $objPHPExcel = $objReader->load($file_name);

            $sheet = $objPHPExcel->getSheet(0);

            $highestRow = $sheet->getHighestRow();

            $highestColumn = $sheet->getHighestColumn();

            $this->operation->table_name = 'default_lesson_plan';

            for ($row = 1; $row <= $highestRow; $row ++) {

                if ($row > 2) {

                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    $data = array(

                        'day' => trim($rowData[0][0]),

                        'concept' => ucfirst(trim($rowData[0][1])),

                        'topic' => trim($rowData[0][2]),

                        'lesson' => trim($rowData[0][3]),

                        'type' => trim($rowData[0][4]),

                        'content' => trim($rowData[0][5]),

                        'class_id' => $class_id,

                        'section_id' => $section_id,

                        'subject_id' => $subject_id,

                        'date' => date("Y-m-d H:i"),

                        'last_update' => date("Y-m-d H:i"),

                        '' => uniqid(),

                        'semester_id' => $semester_id,

                        'session_id' => $session_id
                    );

                    $is_section_create = $this->operation->Create($data);
                }
            }

            unset($objPHPExcel);

            unset($objReader);
        } catch (Exception $e) {}
    }

    function SaveSemester($semester_title)

    {
        try {

            if (! empty($semester_title)) {

                $this->operation->table_name = 'semester';

                $is_semester_found = $this->operation->GetByWhere(array(

                    'semester_name' => $semester_title
                ));

                if (count($is_semester_found) == 0) {

                    $semester = array(

                        'semester_name' => $semester_title,

                        'created' => date('Y-m-d'),

                        'modified' => date('Y-m-d'),

                        'status' => 'i',

                        '' => $this->generate_random_string()
                    );

                    $this->operation->Create($semester);
                }
            }
        } catch (Exception $e) {}
    }

    function SaveSession($session_start, $session_end)

    {
        try {

            if (! empty(trim($session_start)) && ! empty(trim($session_end))) {

                $this->operation->table_name = 'sessions';

                $session_array = array(

                    'datefrom' => date('Y-m-d', strtotime($session_start)),

                    'dateto' => date('Y-m-d', strtotime($session_end)),

                    'datetime' => date('Y-m-d'),

                    'status' => 'a',

                    '' => $this->generate_random_string(),

                    'school_id' => $this->school_info->id
                );

                $is_session_created = $this->operation->Create($session_array);

                if (count($is_session_created)) {

                    return $is_session_created;
                }
            }

            return false;
        } catch (Exception $e) {}
    }

    function SaveSemesterDate($semester_start, $semester_end, $session_id, $semester_id)

    {
        try {

            if (! empty(trim($semester_start)) && ! empty(trim($semester_end))) {

                $this->operation->table_name = 'semester_dates';

                $semester_dates = array(

                    'session_id' => $session_id,

                    'semester_id' => $semester_id,

                    'start_date' => date('Y-m-d', strtotime($semester_start)),

                    'end_date' => date('Y-m-d', strtotime($semester_end)),

                    'status' => 'a',

                    'created' => date('Y-m-d'),

                    'last_edited' => date('Y-m-d'),

                    'school_id' => $this->school_info->id,

                    'slug' => $this->generate_random_string()
                );

                $is_semester_create = $this->operation->Create($semester_dates);

                if (count($is_semester_create)) {

                    return $is_semester_create;
                }
            }

            return false;
        } catch (Exception $e) {}
    }

    function SaveGrade($grade)

    {
        try {

            if (! empty(trim($grade))) {

                $this->operation->table_name = 'classes';

                $is_class_found = $this->operation->GetByWhere(array(

                    'grade' => trim($grade),

                    'school_id' => $this->school_info->id
                ));

                if (count($is_class_found) == 0) {

                    $class = array(

                        'grade' => $grade,

                        'last_update' => date('Y-m-d'),

                        'status' => 'a',

                        'school_id' => $this->school_info->id,

                        '' => $this->generate_random_string()
                    );

                    $is_class_create = $this->operation->Create($class);

                    if (count($is_class_create)) {

                        // create directory for class

                        $path_name = UPLOAD_PATH . 'default_lesson_plan';

                        $this->create_directory($path_name);

                        $path_name = UPLOAD_PATH . 'default_lesson_plan/' . ucfirst(str_replace(" ", "_", trim($grade)));

                        $this->create_directory($path_name);

                        return $is_class_create;
                    }
                } else {

                    return $is_class_found[0]->id;
                }
            }

            return false;
        } catch (Exception $e) {}
    }

    function SaveSection($section_list)

    {
        try {

            if (count($section_list)) {

                $this->operation->table_name = 'sections';

                foreach ($section_list as $key => $value) {

                    $is_class_found = $this->operation->GetByWhere(array(

                        'section_name' => $value->title,

                        'school_id' => $this->school_info->id
                    ));

                    if (count($is_class_found) == 0) {

                        $section = array(

                            'section_name' => $value->title,

                            'last_update' => date('Y-m-d'),

                            'school_id' => $this->school_info->id,

                            '' => $this->generate_random_string()
                        );

                        $is_section_create = $this->operation->Create($section);
                    }
                }
            }
        } catch (Exception $e) {}
    }

    function assign_section($class_id, $section_id)

    {
        try {

            $this->operation->table_name = 'assignsections';

            $is_class_found = $this->operation->GetByWhere(array(

                'class_id' => $class_id,

                'section_id' => $section_id
            ));

            if (count($is_class_found) == 0) {

                $section = array(

                    'class_id' => $class_id,

                    'section_id' => $section_id,

                    'status' => 'a',

                    '' => $this->generate_random_string()
                );

                $is_section_create = $this->operation->Create($section);

                if (count($is_section_create)) {

                    return $is_section_create;
                }
            }

            return false;
        } catch (Exception $e) {}
    }

    function SaveDefaultSubjects($name, $class_id, $semester_id, $classes_name, $session_id)

    {
        try {

            if ($name != '') {

                $this->operation->table_name = 'subjects';

                $subject = array(

                    'subject_name' => trim($name),

                    'subject_code' => '',

                    'class_id' => $class_id,

                    'last_update' => date('Y-m-d'),

                    'subject_image' => '',

                    'semester_id' => $semester_id,

                    'session_id' => $session_id
                );

                $is_subject_create = $this->operation->Create($subject);

                if (count($is_subject_create)) {

                    // create directory for subject

                    $path_name = UPLOAD_PATH . 'default_lesson_plan/' . ucfirst(str_replace(" ", "_", trim($classes_name))) . "/" . ucfirst(str_replace(" ", "_", trim($name)));

                    $this->create_directory($path_name);

                    return $is_subject_create;
                }
            }

            return false;
        } catch (Exception $e) {}
    }
    function GetCurrentSemesterData($sessionid = null)
    {
        $this->operation->table_name = 'semester_dates';
        $is_semester_dates_found = $this->operation->GetByWhere(array('session_id'=>$sessionid,'status'=>'a'));
      
        return  $is_semester_dates_found;
    }
    function getClass($classid)
    {
        $is_class_found = $this->operation->GetByQuery("Select c.* from classes c where c.id = ".$classid);
        if(count($is_class_found)){
            return $is_class_found[0]->grade;
        }
        else{
            return false;
        }
    }
    
    function getSectionList($sectioid = null ,$section_name = null,$school_id=null)
    {
        if(!is_null($sectioid))
        {
            return $this->operation->GetByQuery("Select s.* from sections s where s.id = ".$sectioid);
        }
        else{
            return $this->operation->GetByQuery("Select s.* from sections s where s.section_name = '".$section_name."' AND school_id = ".$school_id);
        }
    }
    
    
    function GetSubject($subjectid = null)
    {
        if(is_null($subjectid))
        {
            $is_subject_found = $this->operation->GetByQuery("Select * from subjects");
            if(count($is_subject_found)){
                return $is_subject_found;
            }
            else{
                return false;
            }
        }
        else{
            $is_subject_found = $this->operation->GetByQuery("Select * from subjects  where id = ".$subjectid);
            if(count($is_subject_found)){
                return $is_subject_found;
            }
            else{
                return false;
            }
        }

    }
    function GetUserById($userid)
    {
        $is_meta_found = $this->operation->GetByQuery("Select * from invantage_users where id = ".$userid);

        if(count($is_meta_found)){
            return $is_meta_found;
        }
        else{
            return false;
        }
    }
    
}

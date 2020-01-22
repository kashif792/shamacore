<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('ALLOW_CROSS_ORIGIN_REQUESTS') OR define('ALLOW_CROSS_ORIGIN_REQUESTS', TRUE);

// Device login token (md5 hash of zilon@2019)
defined('DEVICE_LOGIN_TOKEN') OR define('DEVICE_LOGIN_TOKEN', 'ccd45e6dbe760219fe9fa15bf022f114');

if(ENVIRONMENT == 'production')
{
    define('UPLOAD_PATH', 'http://shama.zinwebs.com/shama/shama-core/upload/');
    define('SHAMA_CORE_API_PATH', 'http://shama.zinwebs.com/shama/shama-core/api/v1/');
}
else{
    define('UPLOAD_PATH', $_SERVER["DOCUMENT_ROOT"].'/shamacore/upload/');
    define('SHAMA_CORE_API_PATH', 'http://localhost/shamacore/api/v1/');
}

defined('UPLOAD_CAT_PROFILE') OR define('UPLOAD_CAT_PROFILE', 'profile');
defined('UPLOAD_CAT_CONTENT') OR define('UPLOAD_CAT_CONTENT', 'content');

/* SMS */
defined('SMS_USERNAME') OR define('SMS_USERNAME', '923235917041');
defined('SMS_PASSWORD') OR define('SMS_PASSWORD', '5386');
defined('SMS_SENDER') OR define('SMS_SENDER', 'NR School');
defined('SMS_PREFIX') OR define('SMS_PREFIX', '92');

/*
 |--------------------------------------------------------------------------
 | Display Debug backtrace
 |--------------------------------------------------------------------------
 |
 | If set to TRUE, a backtrace will be displayed along with php errors. If
 | error_reporting is disabled, the backtrace will not display, regardless
 | of this setting
 |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
 * Core table name definitions
 */
defined('TABLE_INVANTAGE_USERS') OR define('TABLE_INVANTAGE_USERS', 'invantage_users');
defined('TABLE_LESSON_SET_DATES') OR define('TABLE_LESSON_SET_DATES', 'lesson_set_dates');
defined('TABLE_DEFAULT_LESSON_PLAN') OR define('TABLE_DEFAULT_LESSON_PLAN', 'default_lesson_plan');
defined('TABLE_SEMESTER_LESSON_PLAN') OR define('TABLE_SEMESTER_LESSON_PLAN', 'semester_lesson_plan');
defined('TABLE_STUDENT_LESSON_PLAN') OR define('TABLE_STUDENT_LESSON_PLAN', 'student_lesson_plan');
defined('TABLE_STUDENT_SEMESTERS') OR define('TABLE_STUDENT_SEMESTERS', 'student_semesters');
defined('TABLE_STUDENT_LESSON_PLAN_SETTINGS') OR define('TABLE_STUDENT_LESSON_PLAN_SETTINGS', 'student_lesson_plan_settings');


/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/* Assembly times */
defined('ASSEMBLY_START') OR define('ASSEMBLY_START', '7:30');
defined('ASSEMBLY_END') OR define('ASSEMBLY_END', '7:50');
defined('BREAK_START') OR define('BREAK_START', '9:36');
defined('BREAK_END') OR define('BREAK_END', '10:10');

/* Evaluations */
defined('QUIZ_TOTAL_MARKS') OR define('QUIZ_TOTAL_MARKS', '10');
defined('MID_TOTAL_MARKS') OR define('MID_TOTAL_MARKS', '30');
defined('FINAL_TOTAL_MARKS') OR define('FINAL_TOTAL_MARKS', '50');
defined('SISSIONAL_MARKS') OR define('SISSIONAL_MARKS', '20');
/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


defined('VALIDATE_EMAIL') OR define('VALIDATE_EMAIL', 'email');
defined('VALIDATE_NAME') OR define('VALIDATE_NAME', 'name');
defined('VALIDATE_PHONE') OR define('VALIDATE_PHONE', 'phone');
defined('VALIDATE_ADDRESS') OR define('VALIDATE_ADDRESS', 'address');
defined('VALIDATE_NIC') OR define('VALIDATE_NIC', 'nic');


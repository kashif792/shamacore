<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

/*
 * HTTP status codes
 * @author Mohsen
 */
 /*
defined('HTTP_CONTINUE')        				OR define('HTTP_CONTINUE', 100);
defined('HTTP_SWITCHING_PROTOCOLS')             OR define('HTTP_SWITCHING_PROTOCOLS', 101);
defined('HTTP_PROCESSING')                      OR define('HTTP_PROCESSING', 102);
defined('HTTP_EARLY_HINTS')                     OR define('HTTP_EARLY_HINTS', 103);
defined('HTTP_OK')                              OR define('HTTP_OK', 200);
defined('HTTP_CREATED')                         OR define('HTTP_CREATED', 201);
defined('HTTP_ACCEPTED')                        OR define('HTTP_ACCEPTED', 202);
defined('HTTP_NON_AUTHITATIVE_INFMATION')       OR define('HTTP_NON_AUTHORITATIVE_INFORMATION', 203);
defined('HTTP_NO_CONTENT')                      OR define('HTTP_NO_CONTENT', 204);
defined('HTTP_RESET_CONTENT')                   OR define('HTTP_RESET_CONTENT', 205);
defined('HTTP_PARTIAL_CONTENT')                 OR define('HTTP_PARTIAL_CONTENT', 206);
defined('HTTP_MULTI_STATUS')                    OR define('HTTP_MULTI_STATUS', 207);
defined('HTTP_ALREADY_REPTED')                  OR define('HTTP_ALREADY_REPORTED', 208);
defined('HTTP_IM_USED')                         OR define('HTTP_IM_USED', 226);
defined('HTTP_MULTIPLE_CHOICES')                OR define('HTTP_MULTIPLE_CHOICES', 300);
defined('HTTP_MOVED_PERMANENTLY')               OR define('HTTP_MOVED_PERMANENTLY', 301);
defined('HTTP_FOUND')                           OR define('HTTP_FOUND', 302);
defined('HTTP_SEE_OTHER')                       OR define('HTTP_SEE_OTHER', 303);
defined('HTTP_NOT_MODIFIED')                    OR define('HTTP_NOT_MODIFIED', 304);
defined('HTTP_USE_PROXY')                       OR define('HTTP_USE_PROXY', 305);
defined('HTTP_RESERVED')                        OR define('HTTP_RESERVED', 306);
defined('HTTP_TEMPARY_REDIRECT')                OR define('HTTP_TEMPORARY_REDIRECT', 307);
defined('HTTP_PERMANENTLY_REDIRECT')            OR define('HTTP_PERMANENTLY_REDIRECT', 308);
defined('HTTP_BAD_REQUEST')                     OR define('HTTP_BAD_REQUEST', 400);
defined('HTTP_UNAUTHIZED')                      OR define('HTTP_UNAUTHORIZED', 401);
defined('HTTP_PAYMENT_REQUIRED')                OR define('HTTP_PAYMENT_REQUIRED', 402);
defined('HTTP_FBIDDEN')                         OR define('HTTP_FORBIDDEN', 403);
defined('HTTP_NOT_FOUND')                       OR define('HTTP_NOT_FOUND', 404);
defined('HTTP_METHOD_NOT_ALLOWED')              OR define('HTTP_METHOD_NOT_ALLOWED', 405);
defined('HTTP_NOT_ACCEPTABLE')                  OR define('HTTP_NOT_ACCEPTABLE', 406);
defined('HTTP_PROXY_AUTHENTICATION_REQUIRED')   OR define('HTTP_PROXY_AUTHENTICATION_REQUIRED', 407);
defined('HTTP_REQUEST_TIMEOUT')                 OR define('HTTP_REQUEST_TIMEOUT', 408);
defined('HTTP_CONFLICT')                        OR define('HTTP_CONFLICT', 409);
defined('HTTP_GONE')                            OR define('HTTP_GONE', 410);
defined('HTTP_LENGTH_REQUIRED')                 OR define('HTTP_LENGTH_REQUIRED', 411);
defined('HTTP_PRECONDITION_FAILED')             OR define('HTTP_PRECONDITION_FAILED', 412);
defined('HTTP_REQUEST_ENTITY_TOO_LARGE')        OR define('HTTP_REQUEST_ENTITY_TOO_LARGE', 413);
defined('HTTP_REQUEST_URI_TOO_LONG')            OR define('HTTP_REQUEST_URI_TOO_LONG', 414);
defined('HTTP_UNSUPPTED_MEDIA_TYPE')            OR define('HTTP_UNSUPPORTED_MEDIA_TYPE', 415);
defined('HTTP_REQUESTED_RANGE_NOT_SATISFIABLE') OR define('HTTP_REQUESTED_RANGE_NOT_SATISFIABLE', 416);
defined('HTTP_EXPECTATION_FAILED')              OR define('HTTP_EXPECTATION_FAILED', 417);
defined('HTTP_I_AM_A_TEAPOT')          			OR define('HTTP_I_AM_A_TEAPOT', 418);
defined('HTTP_MISDIRECTED_REQUEST')   			OR define('HTTP_MISDIRECTED_REQUEST', 421);
defined('HTTP_UNPROCESSABLE_ENTITY')  			OR define('HTTP_UNPROCESSABLE_ENTITY', 422);
defined('HTTP_LOCKED')                          OR define('HTTP_LOCKED', 423);
defined('HTTP_FAILED_DEPENDENCY')               OR define('HTTP_FAILED_DEPENDENCY', 424);
*/

defined('ASSEMBLY_START') OR define('ASSEMBLY_START', '7:30');
defined('ASSEMBLY_END') OR define('ASSEMBLY_END', '7:50');
defined('BREAK_START') OR define('BREAK_START', '9:36');
defined('BREAK_END') OR define('BREAK_END', '10:10');

 /*
  * SHAMA API End Points
  */
defined('SAPI_ACTIVE_SESSION') OR define('SAPI_ACTIVE_SESSION', 'active_session');

defined('SAPI_TEACHER_LOGIN') OR define('SAPI_TEACHER_LOGIN', 'teacher_login');

defined('SAPI_SCHOOL_WIZARD_STATUS') OR define('SAPI_SCHOOL_WIZARD_STATUS', 'school_wizard_status');

defined('SAPI_TEACHERS') OR define('SAPI_TEACHERS', 'teachers');

defined('SAPI_STUDENTS') OR define('SAPI_STUDENTS', 'students');

defined('SAPI_STUDENTS_BY_SCHOOL') OR define('SAPI_STUDENTS_BY_SCHOOL', 'students_by_school');

defined('SAPI_STUDENT') OR define('SAPI_STUDENT', 'student');

defined('SAPI_SUBJECTS') OR define('SAPI_SUBJECTS', 'subjects');

defined('SAPI_SUBJECTS_BY_SESSION') OR define('SAPI_SUBJECTS_BY_SESSION', 'subjects_by_session');

defined('SAPI_SCHEDULES') OR define('SAPI_SCHEDULES', 'schedules');


/*
defined('SAPI_') OR define('SAPI_', '');
*/


defined('VALIDATE_EMAIL') OR define('VALIDATE_EMAIL', 'email');
defined('VALIDATE_NAME') OR define('VALIDATE_NAME', 'name');
defined('VALIDATE_PHONE') OR define('VALIDATE_PHONE', 'phone');
defined('VALIDATE_ADDRESS') OR define('VALIDATE_ADDRESS', 'address');
defined('VALIDATE_NIC') OR define('VALIDATE_NIC', 'nic');

 
if(ENVIRONMENT == 'production')
{
	define('UPLOAD_PATH', './upload/');
}
else{
	define('UPLOAD_PATH', './upload/');
}

if(ENVIRONMENT == 'production')
{
	define('IMAGE_LINK_PATH','http://zinwebs.com/learninginvantage/v1/upload/');
}
else{
	define('IMAGE_LINK_PATH','http://localhost/shama-central/upload/');
}

if(ENVIRONMENT == 'production')
{
    define('SHAMA_CORE_API_PATH', 'http://shama.zinwebs.com/shama-core/api/v1/');
}
else{
    define('SHAMA_CORE_API_PATH', 'http://localhost/shamacore/shama-core/api/v1/');
}

define('WS_PORT', 8083);

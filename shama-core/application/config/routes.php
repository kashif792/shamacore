<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
 * Alphabetically sorted routes for Shama Core API
 */
$route['api/v(:num)/version'] = "api_v$1/Welcome/version";
$route['api/v(:num)/active_semester'] = "api_v$1/Lmsapi/active_semester";
$route['api/v(:num)/active_semester_dates'] = "api_v$1/Lmsapi/active_semester_dates";
$route['api/v(:num)/active_session'] = "api_v$1/Lmsapi/active_session";
$route['api/v(:num)/block_device'] = "api_v$1/Lmsapi/block_device";
$route['api/v(:num)/check_user_by_email'] = "api_v$1/Lmsapi/check_user_by_email";
$route['api/v(:num)/check_user_by_nic'] = "api_v$1/Lmsapi/check_user_by_nic";
$route['api/v(:num)/class'] = "api_v$1/Lmsapi/class";
$route['api/v(:num)/classes'] = "api_v$1/Lmsapi/classes";
$route['api/v(:num)/classes_with_details'] = "api_v$1/Lmsapi/classes_with_details";
$route['api/v(:num)/class_report'] = "api_v$1/Lmsapi/class_report";
$route['api/v(:num)/class_time_table'] = "api_v$1/Lmsapi/class_time_table";
$route['api/v(:num)/content'] = "api_v$1/Lmsapi/content";
$route['api/v(:num)/course'] = "api_v$1/Lmsapi/course";
$route['api/v(:num)/course_lessons'] = "api_v$1/Lmsapi/course_lessons";

$route['api/v(:num)/default_lesson_plan'] = "api_v$1/Lesson_Plan_Controller/default_lesson_plan";
$route['api/v(:num)/default_subjects'] = "api_v$1/Lmsapi/default_subjects";
$route['api/v(:num)/default_classes'] = "api_v$1/Lmsapi/default_classes";
$route['api/v(:num)/default_kg_subject'] = "api_v$1/Lmsapi/default_kg_subject";
$route['api/v(:num)/default_subjects'] = "api_v$1/Lmsapi/default_subjects";
$route['api/v(:num)/default_sections'] = "api_v$1/Lmsapi/default_sections";
$route['api/v(:num)/device_login'] = "api_v$1/Login_Controller/device_login";
$route['api/v(:num)/device_status'] = "api_v$1/Lmsapi/device_status";
//$route['api/v(:num)/device_progress'] = "api_v$1/Lmsapi/device_lesson_progress";
$route['api/v(:num)/device_lessons'] = "api_v$1/Lesson_Plan_Controller/device_lesson_plan";

$route['api/v(:num)/evaluation_formula'] = "api_v$1/Lmsapi/evaluation_formula";
$route['api/v(:num)/evaluation_header'] = "api_v$1/Lmsapi/evaluation_header";
$route['api/v(:num)/export_default_lesson_plan'] = "api_v$1/Lesson_Plan_Controller/export_default_lesson_plan";
$route['api/v(:num)/export_grade_lesson_plan'] = "api_v$1/Lesson_Plan_Controller/export_grade_lesson_plan";
$route['api/v(:num)/export_lesson_dates'] = "api_v$1/Lmsapi/export_lesson_dates";
$route['api/v(:num)/export_semester_lesson_plan'] = "api_v$1/Lesson_Plan_Controller/export_semester_lesson_plan";

$route['api/v(:num)/grade'] = "api_v$1/Lmsapi/grade";
$route['api/v(:num)/grades'] = "api_v$1/Lmsapi/grades";
$route['api/v(:num)/grade_lesson'] = "api_v$1/Lmsapi/grade_lesson";
$route['api/v(:num)/grade_lesson_plan'] = "api_v$1/Lmsapi/grade_lesson_plan";
$route['api/v(:num)/holiday'] = "api_v$1/Lmsapi/holiday";
$route['api/v(:num)/holidays'] = "api_v$1/Lmsapi/holidays";
$route['api/v(:num)/holiday_type'] = "api_v$1/Lmsapi/holiday_type";
$route['api/v(:num)/holiday_types'] = "api_v$1/Lmsapi/holiday_types";
$route['api/v(:num)/import_default_lesson_plan'] = "api_v$1/Lesson_Plan_Controller/import_default_lesson_plan";
$route['api/v(:num)/lesson_dates'] = "api_v$1/Lmsapi/lesson_dates";
$route['api/v(:num)/lesson_plan'] = "api_v$1/Lesson_Plan_Controller/student_lesson_plan";
$route['api/v(:num)/student_lesson_plan'] = "api_v$1/Lesson_Plan_Controller/student_lesson_plan";
$route['api/v(:num)/lesson_sets'] = "api_v$1/Lmsapi/lesson_sets";
$route['api/v(:num)/lessons'] = "api_v$1/Lmsapi/lessons";
$route['api/v(:num)/location'] = "api_v$1/Lmsapi/location";
$route['api/v(:num)/locations'] = "api_v$1/Lmsapi/locations";
$route['api/v(:num)/options'] = "api_v$1/Lmsapi/options";
$route['api/v(:num)/password_change'] = "api_v$1/Login_Controller/password_change";
$route['api/v(:num)/password_forgot'] = "api_v$1/Login_Controller/password_forgot";
$route['api/v(:num)/password_reset'] = "api_v$1/Login_Controller/password_reset";
$route['api/v(:num)/principal'] = "api_v$1/Lmsapi/principal";
$route['api/v(:num)/principals'] = "api_v$1/Lmsapi/principals";
$route['api/v(:num)/profile'] = "api_v$1/Lmsapi/profile";
$route['api/v(:num)/profile_image'] = "api_v$1/Lmsapi/profile_image";
$route['api/v(:num)/promoted_students'] = "api_v$1/Lmsapi/promoted_students";
$route['api/v(:num)/quiz_evaluations'] = "api_v$1/Lmsapi/quiz_evaluations";
$route['api/v(:num)/quiz_evaluation_details'] = "api_v$1/Lmsapi/quiz_evaluation_details";
$route['api/v(:num)/schedule'] = "api_v$1/Lmsapi/schedule";
$route['api/v(:num)/schedules'] = "api_v$1/Lmsapi/schedules";
$route['api/v(:num)/getdaylist'] = "api_v$1/Lmsapi/getdaylist";
$route['api/v(:num)/getTimetablepdf'] = "api_v$1/Lmsapi/getTimetablepdf";

$route['api/v(:num)/school'] = "api_v$1/Lmsapi/school";
$route['api/v(:num)/schools'] = "api_v$1/Lmsapi/schools";
$route['api/v(:num)/school_wizard'] = "api_v$1/Lmsapi/school_wizard";
$route['api/v(:num)/school_wizard_status'] = "api_v$1/Lmsapi/school_wizard_status";
$route['api/v(:num)/section'] = "api_v$1/Lmsapi/section";
$route['api/v(:num)/sections'] = "api_v$1/Lmsapi/sections";
$route['api/v(:num)/sections_assigned_by_class'] = "api_v$1/Lmsapi/sections_assigned_by_class";
$route['api/v(:num)/sections_by_class'] = "api_v$1/Lmsapi/sections_by_class";
$route['api/v(:num)/semester'] = "api_v$1/Lmsapi/semester";
$route['api/v(:num)/semester_date'] = "api_v$1/Lmsapi/semester_date";
$route['api/v(:num)/semester_dates'] = "api_v$1/Lmsapi/semester_dates";
$route['api/v(:num)/semester_lesson'] = "api_v$1/Lesson_Plan_Controller/semester_lesson";
$route['api/v(:num)/semester_lesson_plan'] = "api_v$1/Lesson_Plan_Controller/semester_lesson_plan";
$route['api/v(:num)/semesters'] = "api_v$1/Lmsapi/semesters";
$route['api/v(:num)/session'] = "api_v$1/Lmsapi/session";
$route['api/v(:num)/sessions'] = "api_v$1/Lmsapi/sessions";
$route['api/v(:num)/removesession'] = "api_v$1/Lmsapi/session";
$route['api/v(:num)/student'] = "api_v$1/Lmsapi/student";
$route['api/v(:num)/student_login'] = "api_v$1/Login_Controller/student_login";
$route['api/v(:num)/student_promote'] = "api_v$1/Lmsapi/student_promote";
$route['api/v(:num)/student_progress'] = "api_v$1/Lmsapi/lesson_progress";
$route['api/v(:num)/student_report'] = "api_v$1/Lmsapi/student_report";
$route['api/v(:num)/students'] = "api_v$1/Lmsapi/students";
$route['api/v(:num)/students_by_class_and_section'] = "api_v$1/Lmsapi/students_by_class_and_section";
$route['api/v(:num)/students_by_school'] = "api_v$1/Lmsapi/students_by_school";
$route['api/v(:num)/subject'] = "api_v$1/Lmsapi/subject";
$route['api/v(:num)/subjects'] = "api_v$1/Lmsapi/subjects";
$route['api/v(:num)/removesubject'] = "api_v$1/Lmsapi/subjectRemove";

$route['api/v(:num)/subjects_by_class'] = "api_v$1/Lmsapi/subjects_by_class";
$route['api/v(:num)/sync_grade_lesson_plan'] = "api_v$1/Lesson_Plan_Controller/sync_grade_lesson_plan";
$route['api/v(:num)/sync_semester_lesson_plan'] = "api_v$1/Lesson_Plan_Controller/sync_semester_lesson_plan";
$route['api/v(:num)/teacher'] = "api_v$1/Lmsapi/teacher";
$route['api/v(:num)/teachers'] = "api_v$1/Lmsapi/teachers";
$route['api/v(:num)/teacher_login'] = "api_v$1/Login_Controller/teacher_login";
$route['api/v(:num)/user_activity'] = "api_v$1/Lmsapi/user_activity";
$route['api/v(:num)/widget_schedules/data'] = "api_v$1/Widget_Schedule_Controller/data";

$route['api/v(:num)/AuthenticateUser'] = "api_v$1/Lmsapi/Authenticate_API_Login";
$route['api/v(:num)/GetGradeList'] = "api_v$1/Lmsapi/Get_Grade_Section_List_For_Angular";
$route['api/v(:num)/GetStudentListByClass'] = "api_v$1/Lmsapi/Get_Student_List_By_Class";
$route['api/v(:num)/getsubjectlistbyclassapi'] = 'api_v$1/Lmsapi/Get_Subject_List_For_Angular_Web_APP';
$route['api/v(:num)/Get_Student_Semester_Info'] = 'api_v$1/Lmsapi/Get_Student_Semester_Info_For_Angular_Web_APP';
$route['api/v(:num)/Get_Lessons_For_Student'] = 'api_v$1/Lmsapi/Get_Student_Lessons_For_Angular_Web_APP_post';
$route['api/v(:num)/Save_Lesson_Progress'] = 'api_v$1/Lmsapi/Save_Lesson_Progress_For_Angular_Web_APP';
$route['api/v(:num)/Get_Lessons_For_Teacher'] = 'api_v$1/Lmsapi/Get_Teacher_Lessons';
$route['api/v(:num)/get_grade_lesson_plan_progress'] = 'api_v$1/Lesson_Plan_Controller/Get_Grade_Lesson_Plan_Progress';
$route['api/v(:num)/setclassgroupstatus'] = 'api_v$1/Lmsapi/SetClassLessonReadStatus';
$route['api/v(:num)/active_semester_in_school'] = 'api_v$1/Lmsapi/Get_Active_Semester_In_School';
$route['api/v(:num)/active_session_in_school'] = 'api_v$1/Lmsapi/Get_Active_Session_In_School';
$route['api/v(:num)/reset_student_progress'] = 'api_v$1/Lmsapi/Reset_Student_Progress';

// Shama v2.0 
$route['api/v(:num)/getassemblydata'] = 'api_v$1/Lmsapi/getassemblydata';
$route['api/v(:num)/getassemblyupdate'] = 'api_v$1/Lmsapi/getassemblyupdate';
$route['api/v(:num)/saveassembly'] = 'api_v$1/Lmsapi/saveassembly';

$route['api/v(:num)/savebreak'] = 'api_v$1/Lmsapi/savebreak';
$route['api/v(:num)/getbreakdata'] = 'api_v$1/Lmsapi/getbreakdata';
$route['api/v(:num)/getbreakupdate'] = 'api_v$1/Lmsapi/getbreakupdate';
// getschedule
$route['api/v(:num)/show_schedule_list'] = 'api_v$1/Lmsapi/show_schedule_list';

// Details Datesheet
$route['api/v(:num)/getsessiondetail'] = 'api_v$1/Lmsapi/GetSessionDetail';
$route['api/v(:num)/getsemesterdata'] = 'api_v$1/Lmsapi/GetSemesterData';
$route['api/v(:num)/add_datesheet'] = 'api_v$1/Lmsapi/AddDatesheet';
$route['api/v(:num)/getdatesheetdata'] = 'api_v$1/Lmsapi/getDatesheetData';
$route['api/v(:num)/getclasslist'] = 'api_v$1/Lmsapi/getclasslist';
$route['api/v(:num)/saveMainDatesheet'] = 'api_v$1/Lmsapi/saveMainDatesheet';
$route['api/v(:num)/getDatesheet'] = 'api_v$1/Lmsapi/getDatesheet';


$route['api/v(:num)/update_datesheet/(:any)'] = "api_v$1/Lmsapi/getDatesheetUpdate/$1";
$route['api/v(:num)/getdatesheetedit'] = "api_v$1/Lmsapi/DatesheetUpdate/";
$route['api/v(:num)/getdatesheetdetailedit'] = "api_v$1/Lmsapi/getDatesheetDetailInfo/";
$route['api/v(:num)/getdetaildatesheet'] = "api_v$1/Lmsapi/getDatesheetDetailList/";
$route['api/v(:num)/getsubjectlistbyclass'] = "api_v$1/Lmsapi/getsubjectlistbyclass/";
$route['api/v(:num)/getsectionbyclass'] = "api_v$1/Lmsapi/GetSectionsByClass/";
$route['api/v(:num)/saveDatesheetDetail'] = "api_v$1/Lmsapi/saveDatesheetDetail/";
$route['api/v(:num)/removeDetailDatesheet'] = "api_v$1/Lmsapi/removeDetailDatesheet/";
$route['api/v(:num)/removeDatesheets'] = "api_v$1/Lmsapi/removeDatesheets/";
// Quize Section
$route['api/v(:num)/getclasslistTeacher'] = 'api_v$1/Lmsapi/getclasslistTeacher';
$route['api/v(:num)/savequiz'] = 'api_v$1/Lmsapi/save_quize_info';
$route['api/v(:num)/savequestion'] = 'api_v$1/Lmsapi/save_quize_Question';
$route['api/v(:num)/getquestionlist'] = 'api_v$1/Lmsapi/getquestionlist';
$route['api/v(:num)/getquestionbyid'] = 'api_v$1/Lmsapi/getquestionbyid';
$route['api/v(:num)/removeQuestion'] = 'api_v$1/Lmsapi/removeQuestion';
$route['api/v(:num)/getQuizList'] = 'api_v$1/Lmsapi/getQuizList';
$route['api/v(:num)/getselectedsubject'] = 'api_v$1/Lmsapi/getselectedsubject';
$route['api/v(:num)/getselectequiz'] = 'api_v$1/Lmsapi/getselectequiz';

// Quiz Mark

$route['api/v(:num)/getmidtermsubjectresult'] = 'api_v$1/Lmsapi/getmidtermsubjectresult';
$route['api/v(:num)/getfinaltermsubjectresult'] = 'api_v$1/Lmsapi/getfinaltermsubjectresult';
$route['api/v(:num)/savestudentmidquizmarks'] = 'api_v$1/Lmsapi/savestudentmidquizmarks';
$route['api/v(:num)/savestudentmarks'] = 'api_v$1/Lmsapi/SetStudentMarks';
$route['api/v(:num)/getevulationheader'] = 'api_v$1/Lmsapi/GetEvulationHeader';
$route['api/v(:num)/getsubjectresult'] = 'api_v$1/Lmsapi/GetSubjectResult';
$route['api/v(:num)/getstudentbyclass'] = 'api_v$1/Lmsapi/GetStudentByClass';
$route['api/v(:num)/midstudentreportdata'] = 'api_v$1/Lmsapi/MidStudentReportBySubjectwize';
$route['api/v(:num)/finalstudentreportdata'] = 'api_v$1/Lmsapi/FinalStudentReportBySubjectwize';
$route['api/v(:num)/UpdateSemesterLessonProgressBulk'] = 'api_v$1/Lmsapi/UpdateSemesterLessonProgressBulk';
//$route['midreport'] = 'Reports/MidReportView';
//$route['finalreport'] = 'Reports/FinalReportView';




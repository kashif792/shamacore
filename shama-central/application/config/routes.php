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

$route['default_controller'] = "Ips/signin";
$route['404_override'] = "Ips/signin";

/* User Section */
// $route['login'] = 'Ips/signin';

$route['signin'] = 'Principal_controller/NewLogin';
$route['login'] = 'Principal_controller/NewLogin';

$route['authenticate'] = 'Ips/authenticate';

$route['settings'] = "Ips/settings";
$route['profile'] = "Ips/profile";
$route['savegeneralsetting'] = 'Ips/saveProfileInfo';
$route['passchange'] = 'Ips/passchange';
$route['logout'] = 'Ips/signout';
$route['(?i)ForgotPass'] = "users/forgotPassword";
$route['(?i)RetypeSetPassword'] = "users/RetypeSetPassword";
$route['(?i)resetPassword'] = "users/resetPassword";
$route['(?i)newuser'] = "Ips/saveNewUser";
// $route['(?i)saveParent'] = "Ips/saveParent";
$route['(?i)newuser/(:any)'] = "Ips/saveNewUser/$1";
$route['(?i)emailchecking'] = "users/emailChecking";

/* Store Section */
$route['savestore'] = 'Ips/saveStore';
$route['storesave'] = 'Ips/saveStoreData';
$route['savestore/(:any)'] = 'Ips/saveStore/$1';

/* Search Section */
$route['searchList'] = 'Ips/searchitem';

/* Un-found Page Section */
$route['unfound'] = 'Ips/unautohrizeaccess';

/* Form Section */
$route['form'] = 'forms/viewForm';
$route['saveform'] = 'forms/saveForm';
$route['removeform'] = 'forms/removeForm';
$route['uploadForm'] = 'forms/uploadForm';
$route['(?i)saveform/(:any)'] = "forms/saveform/$1";

$route['(?i)download/(:any)'] = "Ips/download/$1";

/* Dashboard Section */
$route['dashboard'] = 'Ips/controllindex';
$route['savestore'] = 'Ips/saveStore';

/* Announcement Section */
$route['announcement'] = 'announcements/view';
$route['announcement/(:num)'] = 'announcements/view/$1';
$route['saveannouncement'] = 'announcements/save';

$route['announcements'] = 'announcements/getLatestAnnouncements/$1';
$route['(?i)saveannoucement/(:any)'] = "announcements/save/$1";
$route['search/(:any)'] = 'Ips/searchStore/$1';

$route['user'] = 'users/viewUser';
$route['pagination'] = 'users/viewUser';
$route['user/(:num)'] = 'Ips/user/$1';

$route['download/(:any)'] = 'Ips/download/$1';
$route['editformgroup/(:any)'] = 'Ips/form/$1';


$route['(?i)systemhealthreport'] = "syshealthcheck/viewSystemHealthCheck";
/* Notification Section */
$route['unds'] = "inventory/saveNotification";
$route['undg'] = "inventory/getNotifications";

$route['role'] = 'roles/viewRole';
$route['role/(:num)'] = 'roles/role/$1';
$route['inbox/(:any)'] = 'message/viewMessage/$1';
$route['cameraParameters'] = 'camera_controller/getCameraParameters';


// Attendance Details
// $route['attendance_detail/Present'] = 'attendance_controller/getAttendanceDataFullReport/Present';
// $route['attendance_detail/Absent'] = 'attendance_controller/getAttendanceDataFullReport/Absent';
// $route['attendance_detail/Total'] = 'attendance_controller/getAttendanceDataFullReport/Total';
// $route['officelocation'] = 'attendance_controller/officeLocations';
// $route['timesheet'] = 'attendance_controller/gotoTimesheetPage';

/* Notification Section */
$route['saveparent'] = 'users/SaveParent';
$route['addparent'] = 'users/AddParent';

/*Student section */

$route['student_data'] = 'Student_controller/student_data';
$route['Student_controller/(:num)'] = 'Student_controller/view/$1';
$route['saveannouncement'] = 'Student_controller/save';

$route['announcements'] = 'Student_controller/getLatestAnnouncements/$1';
$route['(?i)saveannoucement/(:any)'] = "Student_controller/save/$1";
$route['search/(:any)'] = 'Ips/searchStore/$1';

$route['user'] = 'users/viewUser';
$route['pagination'] = 'users/viewUser';
$route['user/(:num)'] = 'Ips/user/$1';

$route['download/(:any)'] = 'Ips/download/$1';
$route['editformgroup/(:any)'] = 'Ips/form/$1';

/* Principal Section */
$route['(?i)add_parent'] = "Principal_controller/add_parent_form";
$route['(?i)add_teacher'] = "Principal_controller/add_teacher_form";
$route['(?i)add_teacher/(:any)'] = "Principal_controller/add_teacher_form/$1";
$route['releasettable'] = "Principal_controller/ShedulleType";

$route['loadreleasettable'] = "Principal_controller/LoadShedulleType";

$route['(?i)newclass'] = "Principal_controller/add_class_form";
$route['(?i)newclass/(:any)'] = 'Principal_controller/add_class_form/$1';
$route['(?i)saveClass'] = "Principal_controller/SaveClass";
$route['(?i)saveSubject'] = "Principal_controller/SaveSubjects";
$route['(?i)saveSubjectsaveSubjectsaveSubject'] = "Principal_controller/add_subject_form";
$route['(?i)newsubject/(:any)'] = "Principal_controller/add_subject_form/$1";
$route['(?i)newsubject'] = "Principal_controller/add_subject_form";
$route['(?i)add_timtble'] = "Principal_controller/add_exam_timetable_form";
$route['(?i)add_timtble/(:any)'] = "Principal_controller/add_exam_timetable_form/$1";
$route['(?i)assign_class'] = "Principal_controller/assign_class_form";
$route['(?i)newsection'] = "Principal_controller/add_section_form";
$route['(?i)savestudent'] = "Principal_controller/add_student_form";
$route['(?i)savestudent/(:any)'] = "Principal_controller/add_student_form/$1";
$route['(?i)systemhealthreport'] = "syshealthcheck/viewSystemHealthCheck";
$route['show_prnt_list'] = 'Principal_controller/show_parent_list';
$route['show_teacher_list'] = 'Principal_controller/show_teachers_list';
$route['show_std_list'] = 'Principal_controller/show_stds_list';
$route['show_subject_list'] = 'Principal_controller/show_subject_list';
$route['getlessonplanbyid'] = 'Principal_controller/GetLessonPlanById';
$route['show_section_list'] = 'Principal_controller/show_section_list';
$route['show_assignclass_list'] = 'Principal_controller/show_assign_class';
$route['show_timtbl_list'] = 'Principal_controller/show_exam_timetable';
//$route['show_schedule'] = 'Principal_controller/fetch_exam_timetable';
$route['show_class_list'] = 'Principal_controller/show_class_list';
$route['SaveStudentInfo'] = 'Principal_controller/saveInvantageUser';
$route['saveTeacher'] = 'Principal_controller/saveInvantageTeacher';
$route['newauthenticate'] = 'Principal_controller/authenticateteacher';
$route['getteacherbyid'] = 'Principal_controller/GetTeacherById';
$route['teacherdashboard'] = 'Teacher/Dashboard';
$route['savelesson'] = 'teacher/savelesson';
$route['(?i)savelesson/(:any)'] = 'teacher/savelesson/$1';
$route['saveNewLesson'] = 'teacher/SaveNewLesson';
$route['show_lesson_list'] = 'teacher/show_lessons_list';
$route['take_pic'] = 'Principal_controller/take_pic';
$route['getImgId'] = 'Principal_controller/getImgId';
$route['progressreport'] = 'Principal_controller/GetClassProgressReport';
$route['getsubcat'] = 'Principal_controller/GetSubcatList';
$route['getsectionbyclass'] = 'Teacher/GetSectionsByClass';
$route['getsubjectlessonsbyclass'] = 'Teacher/GetSubjectLessonsByClass';
$route['getsubjectlistbyclass'] = 'Teacher/GetSubjectListByClass';
$route['getallsubjectsbyclass'] = 'Teacher/GetAllSubjectsByClass';
$route['assignprereq'] = 'Teacher/savePrereq';

$route['show_quiz_list'] = 'Principal_controller/show_quizz_list';
$route['add_question'] = 'Principal_controller/add_question_view_form';
$route['addquizz/(:any)'] = 'Principal_controller/edit_quiz_view_form/$1';
$route['addquizz'] = 'Principal_controller/edit_quiz_view_form';
//$route['updatequiz'] = 'Principal_controller/update_quiz_info';
$route['savequiz'] = 'Principal_controller/save_quize_info';
$route['savequestion'] = 'Ips/save_quize_question';
$route['indexc'] = 'Site/generate';
$route['excel'] = 'Site/excel';
$route['getdata'] = 'Principal_controller/loaddatafromdab';
$route['sgetdata'] = 'Teacher/loaddatafromdab';
//$route['getgradeplan'] = 'Principal_controller/loadGradePlan';
$route['loaddatafromdab'] = 'result/loaddatafromdab';
$route['importdata'] = 'Principal_controller/ImportDefaultPlan';
$route['getsessionlist'] = 'Ips/GetSessionList';
$route['savesession'] = 'Ips/SaveSession';
$route['removesession'] = 'Ips/RemoveSession';
$route['getsessiondetail'] = 'Ips/GetSessionDetail';

$route['Savedata'] = 'Principal_controller/Savedata';
$route['SaveResult'] = 'Result/Savedata';
$route['sSavedata'] = 'Teacher/Savedata';
$route['SaveGradedata'] = 'Teacher/saveGradePlan';
$route['UpdateLessonProgress'] = 'Teacher/UpdateLessonProgress';
$route['UpdateSemesterLessonProgress'] = 'Teacher/UpdateSemesterLessonProgress';
$route['UpdateSemesterLessonPlan'] = 'Teacher/UpdateSemesterLessonPlan';
$route['updategradelessonplan'] = 'Teacher/UpdateGradeLessonPlan';
$route['ResetLessonPlan'] = 'Teacher/ResetLessonPlan';
$route['DeleteDefaultLessonPlan'] = 'Principal_controller/ResetLessonPlan';


$route['deleteplan'] = 'Principal_controller/removePlan';
$route['removeResult'] = 'Result/removeResult';
$route['sdeleteplan'] = 'Teacher/removePlan';
$route['gdeleteplan'] = 'Teacher/removeGradePlan';
$route['CheckUserEmail'] = 'Ips/CheckUserEmailValidation';
$route['teachernicduplicationcheck'] = 'Ips/TeacherNicDuplicationCheck';
$route['indexf'] = 'Check/checkfunction';
$route['isread'] = 'Teacher/isread';
$route['markquizz'] = 'Teacher/markquiz';
$route['country'] = 'NewUser/Register';
$route['state'] = 'NewUser/get_cities';
$route['savePricpal'] = 'Principal_controller/saveInvantagePrincpal';
$route['(?i)add_Prinicpal'] = "Principal_controller/add_Principal_form";
$route['(?i)add_Prinicpal/(:any)'] = "Principal_controller/add_Principal_form/$1";
$route['show_prinicpal_list'] = 'Principal_controller/show_prinicpal_list';
$route['Repeat'] = 'Principal_controller/Repeat';
$route['saveParent'] = 'Principal_controller/saveInvantageParents';
$route['(?i)add_Parent'] = "Principal_controller/add_Parent_form";
$route['(?i)add_Parent/(:any)'] = "Principal_controller/add_Parent_form/$1";
$route['show_parents_list'] = 'Principal_controller/show_parents_list';
$route['getprincipal'] = 'Principal_controller/GetPrincipalById';
$route['lesson_plan_form'] = 'Principal_controller/lesson_plan_form';
$route['semester_lesson_plan_form'] = 'Teacher/semester_lesson_plan_form';
//$route['grade_lesson_plan_form'] = 'Teacher/grade_lesson_plan_form';
$route['welcome'] = 'welcome/index';
$route['export'] = 'export/index';
$route['exportResultdata'] = 'Result/exportResultdata';
$route['exportdata'] = 'Principal_controller/exportdata';
$route['promotestudents'] = 'Principal_controller/PromoteStudents';
$route['getquestionbyid'] = 'Principal_controller/GetQuestionById';
$route['getselectedsubject'] = 'Principal_controller/GetSelectedSubject';
$route['getquestionlist'] = 'Principal_controller/GetQuestionList';

$route['sexportdata'] = 'Teacher/exportdata';
$route['gexportdata'] = 'Teacher/exportGradeLessonPlan';
$route['getprogressreport'] = 'Ips/GetProgressReport';
$route['getcourselesson'] = 'Ips/GetCourseLesson';
$route['getcoursedetail'] = 'Ips/GetCourseDetail';
$route['getevulationheader'] = 'Ips/GetEvulationHeader';
$route['getquizlist'] = 'Ips/GetQuizDetail';
$route['getlessonplan'] = 'Ips/GetLessonPlan';
$route['gettermheader'] = 'Ips/GetResultHeader';
$route['getresultlist'] = 'Ips/GetResultList';
$route['getstudentquizdetail'] = 'Ips/GetStudentQuizDetail';
$route['checkschedule'] = 'Ips/CheckSchedule';
$route['checkteacherschedule'] = 'Ips/CheckTeacherSchedule';
$route['getsubjectresult'] = 'Ips/GetSubjectResult';
$route['savestudentmarks'] = 'Ips/SetStudentMarks';
$route['getclasslist'] = 'Ips/GetClassList';
$route['getstudentbyclass'] = 'Ips/GetStudentByClass';
$route['getsemesterdata'] = 'Ips/GetSemesterData';
$route['savepromotedstudents'] = 'Ips/SavePromotedStudent';
$route['getschedulesection'] = 'Ips/GetScheduleSection';
$route['getschedulesubject'] = 'Ips/GetScheduleSubject';
$route['sendlmsapi'] = 'Ips/sendlmsapi';
$route['getsection'] = 'Ips/GetSection';
$route['savesection'] = 'Ips/SaveSection';
$route['semester'] = 'Ips/Semester';
$route['savesemester'] = 'Ips/SaveSemester';
$route['changesemester'] = 'Ips/ChangeSemesterStatus';
$route['removesemester'] = 'Ips/RemoveSemester';
$route['versions'] = 'Ips/LoadVersion';
$route['saveversion'] = 'Ips/SaveVersion';
$route['getversions'] = 'Ips/GetVesionList';
$route['changeversion'] = 'Ips/ChangeVersionStatus';
$route['removeversion'] = 'Ips/RemoveVersion';
$route['setting'] = 'Teacher/setting_semester';
$route['saveassignsection'] = 'Ips/SaveAssignSection';
$route['getselectedsection'] = 'Ips/GetSelecteSectionByClass';
$route['removesection'] = 'Ips/RemoveSection';
$route['removeclass'] = 'Ips/RemoveClass';
$route['changesession'] = 'Ips/ChangeSessionStatus';
$route['savequizimage'] = 'Ips/SaveQuizImage';
$route['loadweather'] = 'Ips/loadweather';
$route['dashboardschedule'] = 'Ips/DashboardSchedule';
$route['addadminemail'] = 'Ips/SaveAdminSetting';
$route['getoptionlist'] = 'Ips/GetOptions';

$route['loadform'] = 'Ips/loadform';


$route['adminusers'] = 'Ips/AdminUsers';
$route['calender'] = 'Ips/Calender';
$route['saveuser'] = 'Ips/SaveAdminUser';
$route['getcitylist'] = 'Ips/CityList';
$route['savelocation'] = 'Ips/SaveLocation';
$route['removelocation'] = 'Ips/RemoveLocation';
$route['getschoollist'] = 'Ips/SchoolList';
$route['saveschool'] = 'Ips/SaveSchool';
$route['removeschool'] = 'Ips/RemoveSchool';
$route['schedular'] = 'Ips/Schedular';
$route['getschedular'] = 'Ips/GetSchedular';
$route['saveschedular'] = 'Ips/SaveSchedular';
$route['date_schedular'] = 'Ips/DateSchedular';
$route['userinfo'] = 'Ips/UserInfo';
$route['teacherlist'] = 'Ips/TeacherList';
$route['scheduleinfo'] = 'Ips/ScheduleDetail';
$route['getsubjectbyid'] = 'Ips/GetSubjectById';
$route['getclasstimetable'] = 'Ips/GetClassTimeTable';
$route['getclassstudent'] = 'Ips/GetClassStudent';
$route['admindashboard'] = 'Ips/AdminDashboard';
$route['updatedob'] = 'Ips/updatedob';
$route['setup'] = 'Ips/Setup';
$route['turn'] = 'First_turncontroller/add_firstturn_form';
$route['(?i)saveClassF'] = "First_turncontroller/FSaveClass";
$route['savesectionF'] = 'First_turncontroller/SaveSectionF';
$route['getsectionF'] = 'First_turncontroller/getsectionF';


$route['result'] = 'Result/importExportResult';
$route['webapp'] = 'WebApp/loadwebapp';
$route['applogin'] = 'WebApp/loadlogin';
$route['authenticatewebapp'] = 'WebApp/Authenticate';
$route['applogout'] = 'WebApp/Logout';
$route['userroleapp'] = 'WebApp/GetLoggedinUserRole';

$route['holiday'] = 'Principal_Extension_controller/Add_Holiday';
$route['saveholiday'] = 'Principal_Extension_controller/SaveHoliday';
$route['saveholidaytype'] = 'Principal_Extension_controller/SaveHolidayType';
$route['getholidaytype'] = 'Principal_Extension_controller/GetHolidayType';
$route['removeholidaytype'] = 'Principal_Extension_controller/RemoveHolidayType';
$route['getholidays'] = 'Principal_Extension_controller/GetHoliday';
$route['Tablet_List'] = 'Principal_Extension_controller/Tablet_List';
$route['Tablet_data'] = 'Principal_Extension_controller/Load_Tablet_Data';
$route['Blockuser'] = 'Principal_Extension_controller/Blockuser';
$route['savesemesterdetail'] = 'Principal_Extension_controller/SaveSemesterDetail';
$route['getsemesterdetail'] = 'Principal_Extension_controller/GetSemesterDetail';
$route['testdates'] = 'Teacher/testdates';
$route['evaluation'] = 'Principal_Extension_controller/Generic_Grading_Criteria';
$route['removeholiday'] = 'Principal_Extension_controller/RemoveHoliday';
$route['saveformula'] = 'Principal_Extension_controller/SaveEvaluation';
$route['makeactivesemesterdates'] = 'Principal_Extension_controller/MakeSemesterActive';
$route['getevalution'] = 'Principal_Extension_controller/GetEvaluation';
$route['classreport'] = 'Reports/ClassReportView';
$route['studentreport/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'Reports/StudentReport/$1/$2/$3/$4/$5';
$route['savegrade'] = 'Reports/SaveGrades';
$route['removegrade'] = 'Reports/RemoveGrade';
$route['getgradelist'] = 'Reports/GetGradeList';
$route['classreportdata'] = 'Reports/ClassReportData';
$route['shamaclassreport'] = 'Reports/ClassReport';
$route['studentreportdata'] = 'Reports/StudentReportBySubjectwize';
$route['studentbase64image'] = 'Reports/GetStudentImageByBase64';
$route['classreportsubjects'] = 'Reports/GetClassSubjectList';
$route['principal_installation_wizard'] = 'Shama_Installation_Wizard/Principal_Wizard';
$route['default_classes'] = 'Shama_Installation_Wizard/DefaultGrades';
$route['default_sections'] = 'Shama_Installation_Wizard/DefaultSections';
$route['default_kindergarten_subject'] = 'Shama_Installation_Wizard/DefaultKindergardenSubject';
$route['default_subjects'] = 'Shama_Installation_Wizard/DefaultSuject';
$route['save_principal_wizard_settings'] = 'Shama_Installation_Wizard/SavePrincipalWizardValues';
$route['principal_subject_list'] = 'Reports/Principal_Subject_List';

$route['updatelessonplan'] = 'Principal_Extension_controller/UpdateSemesterLessonPlanDates';

$route['removesemesterdate'] = 'Ips/RemoveSemesterDate';

/* Shama core API aka LMSApi */

$route['GetPreSchedularData'] = 'Lmsapi/GetPreSchedularData';
$route['getclasssectionlist'] = 'Lmsapi/GetSchoolClassInfo';
$route['getstudentbyclassusingapi'] = 'Lmsapi/GetStudentListByRestAPI';
$route['getsubjectlistbyclassapi'] = 'Lmsapi/GetSubjectList';
$route['getlessonplanbyapi'] = 'Lmsapi/GetLessonPlanByApp';
$route['setquizprogress'] = 'Lmsapi/SetQuizProgress';
$route['savestudentprogressbyapi'] = 'Lmsapi/SetLessonProgress';
$route['gettodaylessons'] = 'Lmsapi/GetTodayLessons';
$route['setclassgroupstatus'] = 'Lmsapi/SetClassLessonReadStatus';
$route['getschedulebyrest'] = 'Lmsapi/GetPeriodSchedule';
$route['getservertime'] = 'Lmsapi/GetCurrentServerTime';
$route['getactivities'] = 'Lmsapi/GetActivityList';
$route['getStudentInfo'] = 'Lmsapi/GetStudentDetail';
$route['getstudentsubjectslesson'] = 'Lmsapi/GetStudentSubjectLesson';
$route['getsubjectbyclass'] = 'Lmsapi/GetSubjectsListByClasses';
$route['gettags'] = 'Lmsapi/GetTags';
$route['getstudentlist'] = 'Lmsapi/GetStudentsList';
$route['saveactivityprogress'] = 'Lmsapi/SaveActivityProgress';

/* Student Portal */

$route['stdapp'] = 'StudentApp/loadwebapp';
$route['stdapplogin'] = 'StudentApp/loadlogin';
$route['authenticatestdapp'] = 'StudentApp/Authenticate';
$route['stdapplogout'] = 'StudentApp/Logout';
$route['useractivities'] = 'ActivityController/Index';
$route['savecartoon'] = 'ActivityController/Save';
$route['getactivitylist'] = 'ActivityController/GetActivityList';
$route['removeactivity'] = 'ActivityController/RemoveActivity';
$route['removelink'] = 'ActivityController/RemoveLink';
$route['getclasseslist'] = 'Ips/GetClassesList';
$route['userchat/(:any)'] = 'Chat/userfile/$1';

$route['(?i)tasks'] = "TaskController/Index";
$route['(?i)savetask'] = "TaskController/Save";
$route['(?i)task'] = "TaskController/add_task_form";
$route['(?i)task/(:any)'] = "TaskController/add_task_form/$1";
$route['(?i)gettasklist'] = "TaskController/GetTasks";
$route['(?i)gettask'] = "TaskController/GetTask";

// Datesheet
$route['datesheetlist'] = 'Principal_controller/getDatesheetList';
$route['add_datesheet'] = 'Principal_controller/AddDatesheet';
$route['getdatesheetedit'] = "Principal_controller/DatesheetUpdate/";
$route['update_datesheet/(:any)'] = "Principal_controller/getDatesheetUpdate/$1";
/* Reports */
$route['midreport'] = 'Reports/MidReportView';
$route['finalreport'] = 'Reports/FinalReportView';

$route['grade'] = 'Teacher/grade';
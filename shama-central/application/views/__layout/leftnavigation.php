
<div class="col-sm-2 sidenav hidden-xs" id="sidenav" ng-Controller="menuCtrl">

	<div class="client-log-container" title="Learning InVantage"></div>

  	<ul ng-if="isAdmin" class="nav nav-pills nav-stacked">

	 	<li ng-class="segment1 == 'admindashboard'?'active' : ''">
			<a  href="{{baseUrl}}admindashboard">
				<i class="fa fa-home" aria-hidden="true"></i>
				<span class="link_text"> Home</span>
			</a>
		</li>


	 	<li ng-class="(segment1 == 'show_prinicpal_list' || 
	 	segment1 == 'add_Prinicpal')? 'active' : ''">
			<a  href="{{baseUrl}}show_prinicpal_list">
				<i class="fa fa-user" aria-hidden="true"></i>
				<span class="link_text"> Principals</span>
			</a>
		</li>
			
	 	<li ng-class="segment1 == 'setting'?'active' : ''">
			<a  href="{{baseUrl}}setting">
				<i class="fa fa-cog" aria-hidden="true"></i>
				<span class="link_text"> Settings</span>
			</a>
		</li>
	</ul>

	<ul ng-if="isPrincipal || isTeacher" class="nav nav-pills nav-stacked">
  		
	 	<li ng-if="isTeacher" ng-class="segment1 == 'teacherdashboard'?'active' : ''">
			<a  href="{{baseUrl}}teacherdashboard">
				<i class="fa fa-home" aria-hidden="true"></i>
				<span class="link_text"> Home</span>
			</a>
		</li>

	 	<li ng-if="isPrincipal" ng-class="(segment1 == 'dashboard')? 'active' : ''">
			<a  href="{{baseUrl}}dashboard">
				<i class="fa fa-home" aria-hidden="true"></i>
				<span class="link_text"> Home</span>
			</a>
		</li>

	 	<li ng-if="isTeacher" ng-class="(segment1 == 'show_std_list' || 
	 	segment1 == 'savestudent')? 'active' : ''">
			<a  href="{{baseUrl}}show_std_list">
				<i class="fa fa-user" aria-hidden="true"></i>
				<span class="link_text"> Students</span>
			</a>
		</li>


		<li  ng-if="isPrincipal" ng-class="(segment1 == 'show_std_list' || 
	 	segment1 == 'savestudent')? 'active' : ''">
			<a  href="javascript:void(0)" id="student">
				<i class="fa fa-user" aria-hidden="true"></i>
				<span class="link_text"> Students</span>
				<i class="fa fa-chevron-down lsubmenu-icon"></i>
			</a>
			<ul class="nav nav-pills nav-stacked" id="lsubmenu">
				<li><a  href="{{baseUrl}}show_std_list">
				<i class="fa fa-list" aria-hidden="true"></i>
				<span class="link_text"> Students List</span>
			</a></li>
			<li>	<a  href="{{baseUrl}}promotestudents">
				<i class="fa fa-plus" aria-hidden="true"></i>
				<span class="link_text"> Promote Student</span>
			</a></li>
			</ul>
		</li>


	 	<li ng-if="isPrincipal" ng-class="(segment1 == 'show_teacher_list' || segment1 == 'add_teacher')? 'active' : ''">
			<a  href="{{baseUrl}}show_teacher_list">
				<i class="fa fa-user-o" aria-hidden="true"></i>
				<span class="link_text"> Teachers</span>
			</a>
		</li>


	 	<li ng-if="isPrincipal" ng-class="(segment1 == 'show_timtbl_list' || segment1 == 'add_timtble')? 'active' : ''">
			<a  href="{{baseUrl}}show_timtbl_list">
				<i class="fa fa-clock-o" aria-hidden="true"></i>
				<span class="link_text"> Schedules</span>
			</a>
		</li>

	 	<li  ng-if="isPrincipal" ng-class="(segment1 == 'saveClass' || 
	 	segment1 == 'newclass')? 'active' : ''">
			<a  href="{{baseUrl}}newclass">
				<i class="fa fa-mortar-board" aria-hidden="true"></i>
				<span class="link_text">Grades</span>
			</a>
		</li>

		<li  ng-if="isTeacher" ng-class="(segment1 == 'grade' || 
	 	segment1 == 'grade')? 'active' : ''">
			<a  href="{{baseUrl}}grade">
				<i class="fa fa-mortar-board" aria-hidden="true"></i>
				<span class="link_text">Grades</span>
			</a>
		</li>

	 	<li ng-class="(segment1 == 'show_subject_list' || 
	 	segment1 == 'newsubject')? 'active' : ''">
			<a  href="{{baseUrl}}show_subject_list">
				<i class="fa fa-book" aria-hidden="true"></i>
				<span class="link_text"> Subjects</span>
			</a>
		</li>


	 	<li ng-if="isTeacher" ng-class="(segment1 == 'show_quiz_list' || 
	 	segment1 == 'addquizz')? 'active' : ''">
			<a  href="{{baseUrl}}show_quiz_list">
				<i class="fa fa-question-circle" aria-hidden="true"></i>
				<span class="link_text"> Quizzes</span>
			</a>
		</li>


	 	<li ng-if="isPrincipal" ng-class="(segment1 == 'lesson_plan_form')? 'active' : ''">
			<a  href="{{baseUrl}}lesson_plan_form">
				<i class="fa fa-tasks" aria-hidden="true"></i>
				<span class="link_text"> Default lesson plans</span>
			</a>
		</li>



	 	<li ng-class="(segment1 == 'semester_lesson_plan_form')? 'active' : ''">
			<a  href="{{baseUrl}}semester_lesson_plan_form">
				<i class="fa fa-file-excel-o" aria-hidden="true"></i>
				<span class="link_text"> Semester lessons</span>
			</a>
		</li>
		
<!-- 
	 	<li ng-if="isTeacher" ng-class="(segment1 == 'tasks' || 
	 	segment1 == 'savetask')? 'active' : ''">
			<a  href="{{baseUrl}}tasks">
				<i class="fa fa-pencil" aria-hidden="true"></i>
				<span class="link_text"> Assignments</span>
			</a>
		</li>
 -->
		

	 	<li ng-if="isPrincipal" ng-class="(segment1 == 'schedular')? 'active' : ''">
			<a  href="{{baseUrl}}schedular">
				<i class="fa fa-book" aria-hidden="true"></i>
				<span class="link_text"> Grade lesson plans</span>
			</a>
		</li>


	 	<li ng-if="isPrincipal" ng-class="(segment1 == 'date_schedular')? 'active' : ''">
			<a  href="{{baseUrl}}date_schedular">
				<i class="fa fa-calendar" aria-hidden="true"></i>
				<span class="link_text"> Date Schedular</span>
			</a>
		</li>


	 	<li ng-if="isPrincipal" ng-class="(segment1 == 'Tablet_List')? 'active' : ''">
			<a  href="{{baseUrl}}Tablet_List">
				<i class="fa fa-tablet" aria-hidden="true"></i>
				<span class="link_text"> Tablets</span>
			</a>
		</li>
		

	 	<li ng-if="isPrincipal" ng-class="(segment1 == 'setting')? 'active' : ''">
			<a  href="{{baseUrl}}setting">
				<i class="fa fa-cog" aria-hidden="true"></i>
				<span class="link_text"> Settings</span>
			</a>
		</li>


	 	<!-- <li >
			<a  href="{{baseUrl}}classreport">
				<i class="fa fa-signal" aria-hidden="true"></i>
				<span class="link_text"> Reports</span>
			</a>
		</li> -->
		<li ng-if="isPrincipal" ng-class="(segment1 == 'classreport' || segment1 == 'studentreport')? 'active' : ''">
			<a  href="javascript:void(0)" id="reports">
				<i class="fa fa-user" aria-hidden="true"></i>
				<span class="link_text"> Reports</span>
				<i class="fa fa-chevron-down result-icon pull-right"></i>
			</a>
			<ul class="nav nav-pills nav-stacked" id="midresult" style="display: none">
				<li><a  href="{{baseUrl}}classreport">
				<i class="fa fa-signal" aria-hidden="true"></i>
				<span class="link_text"> Class Reports</span>
				</a>
			</li>
				<li>
					<a  href="{{baseUrl}}midreport">
					<i class="fa fa-snowflake-o" aria-hidden="true"></i>
					<span class="link_text"> Mid Term Result</span>
					</a>
				</li>
				<li>
					<a  href="{{baseUrl}}finalreport">
					<i class="fa fa-wpforms" aria-hidden="true"></i>
					<span class="link_text"> Final Result</span>
					</a>
				</li>
			</ul>
		</li>
		<li class="" ng-if="isPrincipal">
			<a  href="<?php echo base_url(); ?>datesheetlist">
				<i class="fa fa-question-circle" aria-hidden="true"></i>
				<span class="link_text"> Datesheets</span>
			</a>
		</li>
		<li class="" ng-if="isPrincipal">
			<a  href="<?php echo base_url(); ?>announcementlist">
				<i class="fa fa-bullhorn" aria-hidden="true"></i>
				<span class="link_text"> Announcements</span>
			</a>
		</li>
  </ul>

</div>

  <script>
  	
    app.controller('menuCtrl', function($scope, $myUtils){


        $scope.isPrincipal = false;
        $scope.isTeacher = false;
        $scope.isAdmin = false;

        if(!$myUtils.checkUserAuthenticated()){
            console.log('User not authenticated!');
            return;
        }
        
        //console.log('User ' + $myUtils.userId + ' authenticated!');

        $scope.baseUrl = '<?php echo base_url() ?>'

		$scope.user_id = $myUtils.getUserId();
		$scope.name = $myUtils.getUserName();
		$scope.email = $myUtils.getUserEmail();
		$scope.roles = $myUtils.getUserRoles();
		$scope.school_id = $myUtils.getDefaultSchoolId();
		$scope.session_id = $myUtils.getDefaultSessionId();

        if($myUtils.getUserProfileImage()){
            $scope.profileImage = $myUtils.getUserProfileImage();
        }

        if($myUtils.getUserProfileThumb()){
            $scope.profileThumb = $myUtils.getUserProfileThumb();
        }
        
        $scope.roles = $myUtils.getUserRoles();
        
        $scope.schoolName = '';
        if($myUtils.getUserLocations().length){
            $scope.schoolName = $myUtils.getUserLocations()[0].schoolname;
        }

        $scope.type = $myUtils.getUserType();


        $scope.isPrincipal = $myUtils.isPrincipal();
        $scope.isTeacher = $myUtils.isTeacher();
        $scope.isAdmin = $myUtils.isAdmin();
                                

		$scope.segment1 = '<?php echo $this->uri->segment(1); ?>';

      });
  </script>
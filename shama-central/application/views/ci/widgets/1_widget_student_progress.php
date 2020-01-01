<div class="col-lg-12" ng-controller="principal_report_controller" ng-init="processfinished=ture">
    <div id="resultmodel" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Quiz detail of {{screenname}}</h4>
                </div>
                <div class="modal-body" ng-init="no_data = 0;">
                    <div class="quiz" ng-if="no_data == 0">
                         <table style="width:100%;">
                            <tr ng-repeat="q in sudentquizdetail">
                                <td>
                                    <div>
                                        <p class="question" ng-if="q.thumbnail_src == ''">Q{{$index+1}}: {{q.question}}</p>
                                        <p class="question" ng-if="q.thumbnail_src != ''">Q{{$index+1}}: {{q.question}} <img  width="75"></p>
                                        <ul>
                                            <span ng-repeat="o in q.options">

                                                <span>
                                                    <!-- <span ng-if="o.iscorrect == 1"> -->
                                                    <span ng-if="o.iscorrect == 1">
                                                        <span ng-if="q.selectedoption == o.optionid">
                                                            <span class="userchecked"></span>
                                                            <input class="answer hide" id="selectedchecked_{{o.optionid}}" type="radio"  name="inputselected" value="{{o.optionid}}" checked="checked">
                                                        </span>
                                                        <span ng-if="q.selectedoption != o.optionid">
                                                        <span class="usernotchecked"></span>
                                                            <input class="answer hide" type="radio" name="inputselected" value="">
                                                        </span>
                                                    </span>
                                                    <span ng-if="o.iscorrect == 0">
                                                        <span ng-if="q.selectedoption == o.optionid">
                                                         <span class="userchecked"></span>
                                                            <input class="answer hide" id="selectedchecked_{{o.optionid}}" type="radio" name="inputselected" value="{{o.optionid}}" checked="checked">
                                                        </span>
                                                        <span ng-if="q.selectedoption != o.optionid">
                                                            <span class="usernotchecked"></span>
                                                            <input class="answer hide" type="radio" name="inputselected" value="">
                                                        </span>
                                                    </span>

                                                    <label id="correctString1" ng-if="q.qtype == 't'">{{o.optionitem}}</label>
                                                    <label id="correctString1" ng-if="q.qtype == 'i'"><img  alt="Option Image" width="75"></label>
                                                        <span ng-if="o.iscorrect == 1">
                                                    </span>
                                                    <span ng-if="o.iscorrect == 0">
                                                        <span ng-if="q.selectedoption == o.optionid">
                                                            <img src="<?php echo base_url(); ?>images/bullet_cross.png">
                                                        </span>
                                                    </span>
                                                    <span ng-if="o.iscorrect == 1">
                                                       <img src="<?php echo base_url(); ?>images/tick.png">
                                                    </span>
                                                </span>
                                                <br>
                                            </span>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div ng-if="no_data == 1;">
                        No result found
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <label>Student Progress Report</label>
        </div>
        <!--  -->
        <div class="panel-body" id="progress_report" ng-class="{'loader2-background': processfinished == false}">
            
            
                <div class="col-sm-12">
                    <form class="form-inline" >
                      <!-- <div class="form-group">
                          <label for="email">Email address:</label>
                          <input type="email" class="form-control" id="email">
                      </div> -->
                        <div class="form-group">
                            <label for="inputRSession">Session:</label>
                            <select  class="form-control" ng-options="item.name for item in rsessionlist track by item.id"  name="inputRSession" id="inputRSession"  ng-model="filterobj.session" ng-change="chnagefilter()" ></select>
                        </div>
                        <div class="form-group">
                            <label for="select_class">Grade:</label>
                            <select class="form-control" ng-options="item.name for item in classlist track by item.id"  name="select_class" id="select_class"  ng-model="filterobj.class" ng-change="chnagefilter()"></select>
                        </div>
                        <div class="form-group">
                            <label for="inputSection">Section:</label>
                            <select class="form-control"  ng-options="item.name for item in sectionslist track by item.id"  name="inputSection" id="inputSection"  ng-model="filterobj.section" ng-change="chnagefilter()"></select>
                        </div>
                        <div class="form-group">
                            <label for="inputSemester">Semester:</label>
                            <select class="form-control" ng-options="item.name for item in semesterlist track by item.id"  name="inputSemester" id="inputSemester"  ng-model="filterobj.semester" ng-change="chnagefilter()"></select>
                        </div>
                    </form>
                </div>
            
            <div class="row padding-top" style="margin-top:30px" >
                <div class="col-sm-12">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default" ng-repeat="s in subjectlist">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#{{s.id}}" ng-click="closecollapse(s)">
                                        {{s.name}}
                                    </a>
                                </h4>
                            </div>
                            <div id="{{s.id}}" class="panel-collapse collapse {{$first>0?'in':'other'}}">
                                <div class="panel-body" style="overflow: auto;">
                                        <div class="panel-group" id="subject_accordion{{s.id}}">
                                            <div class="panel panel-default" ng-class="{'loader2-background': cprocessfinished == false}">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#subject_accordion{{s.id}}" href="#p_{{s.id}}" ng-click="open_course_progress(s)">
                                                             Course Progress
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="p_{{s.id}}" class="panel-collapse collapse {{$first>0?'in':'other'}}">
                                                    <div class="loader2" ng-hide="cprocessfinished"></div>
                                                    <div class="panel-body" ng-hide="!cprocessfinished">
                                                        <div ng-hide="progresslist.length <= 0 " style="overflow: auto;">
                                                            <table datatable="ng"  class="table table-striped table-bordered row-border hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Students</th>
                                                                        <th ng-repeat="p in planheader">
                                                                            {{p.date}}
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th ng-repeat="p in planheader">
                                                                            {{p.name}} ({{p.type}})
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="reporttablebody-phase-two" class="report-body" >
                                                                    <tr ng-repeat="p in progresslist"  ng-init="$last && finished()">
                                                                        <td>{{p.screenname}}</td>
                                                                        <td ng-repeat="s in p.student_plan"  class="{{s.status}}">
                                                                            <i id="pi_{{sub.id}}_{{s.lesson_id}}_{{p.student_id}}"  class="fa {{s.status == 'read'?'fa-check':(s.show?'fa-times':'')}}" aria-hidden="true"></i>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row" ng-hide="progresslist.length > 0">
                                                            <div class="col-sm-12">
                                                                <p class="no-record">No data found</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default" ng-class="{'loader2-background': eprocessfinished == false}">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#subject_accordion{{s.id}}" href="#e_{{s.id}}" ng-click="open_evalution(s)">
                                                            Evaluation
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="e_{{s.id}}" class="panel-collapse collapse custom-collapse">
                                                    <div class="loader2" ng-hide="eprocessfinished"></div>
                                                    <div class="panel-body" ng-hide="!eprocessfinished">
                                                        <div  style="overflow: auto;">
                                                            <table datatable="ng"  class="table table-striped table-bordered row-border hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th ng-repeat="e in evulationarray" ng-if="e.term_status == 'bt'">
                                                                            {{e.name}}
                                                                        </th>
                                                                        <th>Mid Term</th>
                                                                        <th ng-repeat="e in evulationarray" ng-if="e.term_status == 'at'">
                                                                            {{e.name}}
                                                                        </th>
                                                                        <th>Final Exam</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="reporttablebody-phase-two" class="report-body">
                                                                    <tr ng-repeat="e in evulationlist" ng-init="$last && finished()">
                                                                        <td>{{e.screenname}}</td>
                                                                        <td ng-repeat="s in e.score" ng-if="s.term_status == 'bt'">
                                                                            <a href="javascript:void(0);" ng-click="viewresult(e,s.quizid)">{{s.totalpercent}}</a>
                                                                        </td>
                                                                        <td>{{evulationlist[$index].term_result[0].marks}}</td>
                                                                         <td ng-repeat="s in e.score" ng-if="s.term_status == 'at'">
                                                                            <a href="javascript:void(0);" ng-click="viewresult(e,s.quizid)">{{s.totalpercent}}</a>
                                                                        </td>
                                                                        <td>{{evulationlist[$index].term_result[1].marks}}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   
                                </div>
                            </div>
                        </div>
                         <div class="row" ng-hide="subjectlist.length > 0">
                            <div class="col-sm-12">
                                <p class="no-record">No data found</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/angular-datatables.css">
<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>

<link href="<?php echo base_url();?>css/cjquery-ui.css" rel="stylesheet">

<script>


	app.controller('principal_report_controller', function($scope, $myUtils, $filter,$interval){

    	var urlist = ({
    	    	getsessionlist:'<?php echo SHAMA_CORE_API_PATH; ?>sessions',
    	    	classlist:'<?php echo SHAMA_CORE_API_PATH; ?>classes',
    	    	getholidaytypes:'<?php echo SHAMA_CORE_API_PATH; ?>holiday_types',
    	    	getholidays:'<?php echo SHAMA_CORE_API_PATH; ?>holidays',
    	    	getsectionbyclasslist:'<?php echo SHAMA_CORE_API_PATH; ?>sections_by_class',
    	    	getsemesterlist:'<?php echo SHAMA_CORE_API_PATH; ?>default_semester',
    	    	getsubjectlist:'<?php echo SHAMA_CORE_API_PATH; ?>subjects',
    	    	getsubjectbyclasslist:'<?php echo SHAMA_CORE_API_PATH; ?>subjects_by_class',
    	    	getcourselesson:'<?php echo SHAMA_CORE_API_PATH; ?>course_lessons',
    	    	getcoursedetail:'<?php echo SHAMA_CORE_API_PATH; ?>course',
    	    	getstudentquizdetail:'<?php echo SHAMA_CORE_API_PATH; ?>quiz_evaluation_details',
    	    	getquizevaluationlist:'<?php echo SHAMA_CORE_API_PATH; ?>quiz_evaluations',
    	    	getevaluationheader:'<?php echo SHAMA_CORE_API_PATH; ?>evaluation_header'
    	});

        //console.log($scope.$storage);
        
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
        
        $scope.schoolName = '';
        if($myUtils.getUserLocations().length){
            $scope.schoolName = $myUtils.getUserLocations()[0].schoolname;
        }

        $scope.type = $myUtils.getUserType();

         $scope.filterobj = {};
         $scope.subjectlist = {};
         $scope.selected_subject = {};
         $scope.progresslist = [];
         $scope.evulationlist = [];
         $("#progress_report").show();
        
         $scope.finished = function()
         {
            $scope.processfinished = true;
            $scope.cprocessfinished = true;
            $scope.eprocessfinished = true;
        }

        $scope.evaulationcollapse = false;
        var rinterval
        $scope.isCourseTabActive = true;
        $scope.isExamTabActive = false;
    
        $scope.reloadcontent = function()
        {
            $scope.cprocessfinished = false;
            rinterval = $interval(function(){
                if($scope.isCourseTabActive)
                {
                    getCourseDetail($scope.subject_id,$scope.section_id,$scope.semester_id,$scope.session_id,$scope.class_id)
                }
            },60000);
        }

        var sinterval
        $scope.reloadresult = function()
        {
            $scope.eprocessfinished = false;
            sinterval = $interval(function(){
                if($scope.isExamTabActive)
                {
                    GetEvulationHeader($scope.subject_id,$scope.class_id,$scope.section_id,$scope.semester_id,$scope.session_id)
                }
            },60000); 
        }
        
        function getSessionList()
        {
            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>default_session',({school_id:$scope.school_id})).then(function(response){
            //httprequest('getsessiondetail',({})).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.rsessionlist = response
                    
                     var find_active_session = $filter('filter')(response,{status:'a'},true);
                    
                    if(find_active_session.length > 0)
                    {
                        
                        $scope.filterobj.session = find_active_session[0]
                        
                    }
                }
                else{
                    //$scope.finished();
                }
            });
        }
        getSessionList();

        function getClassList()
        {

            var data = ({school_id:$scope.school_id});
            $myUtils.httprequest(urlist.classlist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.classlist = response
                    $scope.filterobj.class = response[0]
                    loadSections();
                }else{
                    $scope.finished();
                }
            });
        }

        getClassList();

        function loadSections()
        {
            try{
                var data = ({class_id:$scope.filterobj.class.id,user_id:$scope.user_id})
                $myUtils.httprequest(urlist.getsectionbyclasslist,data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.sectionslist = response;
                        $scope.filterobj.section = response[0];
                        getSemesterData()
                    }
                    else{
                        $scope.sectionslist = [];
                    }
                })
            }
            catch(ex){}
        }

        $scope.closecollapse = function(subject)
        {
             try{
                $scope.cprocessfinished = false; 
                var myEl = angular.element( document.querySelector( '#e_'+$scope.selected_subject.id ) );
                myEl.collapse('hide');
                $scope.selected_subject = subject;
                $scope.evaulationcollapse = false;
                var myEl = angular.element( document.querySelector( '#p_'+$scope.selected_subject.id ) );
                myEl.collapse('toggle');
                getLessonPlanList();
                
            }
            catch(ex){}
        }

        function getSemesterData(){
            try{
                
                $scope.semesterlist = []

                var data = ({school_id:$scope.school_id});
                
                $myUtils.httprequest(urlist.getsemesterlist,data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.semesterlist = response;
                        var find_active_semester = $filter('filter')(response,{status:'a'},true);
                        if(find_active_semester.length > 0)
                        {
                            $scope.filterobj.semester = find_active_semester[0]  
                        }
                        getprogressreport();
                    }
                    else{
                        $scope.semesterlist = [];
                    }
                });
             }
            catch(ex){}
        }

        $scope.chnagefilter = function()
        {
            $scope.processfinished = false;
            getprogressreport();
        }

        $scope.opensubjectview = function(subject)
        {
            $scope.selected_subject = subject;
            getLessonPlanList();
        }

        function getprogressreport()
        {
            try{
                var data ={
                    class_id:$scope.filterobj.class.id,
                    section_id:$scope.filterobj.section.id,
                    session_id:$scope.filterobj.session.id,
                    semester_id:$scope.filterobj.semester.id,
                    school_id:$scope.school_id,
                }

                $myUtils.httprequest(urlist.getsubjectbyclasslist,data).then(function(response){
                    if(response != null && response.length > 0)
                    {
                        $scope.subjectlist = response;
                        $scope.selected_subject = response[0];
                        getLessonPlanList();
                        $scope.reloadcontent();
                        $scope.reloadresult();
                    }
                    else{
                        $scope.subjectlist = [];
                        $scope.processfinished = true;
                    }
                });
            }
             catch(ex){}
        }

        $scope.planheader = [];
        function getLessonPlanList()
        {
            try{
                $myUtils.httprequest(urlist.getcourselesson,({
                                    subject_id:$scope.selected_subject.id,
                                    section_id:$scope.filterobj.section.id,
                                    semester_id:$scope.filterobj.semester.id,
                                    session_id:$scope.filterobj.session.id,
                                    class_id:$scope.filterobj.class.id,
                                })).then(function(response){

                    if(response != null && response.length > 0)
                    {
                        $scope.planheader = response;
                        getCourseDetail();
                        
                    }
                    else{
                        $scope.finished();
                        $scope.planheader = [];
                        $scope.progresslist = [];
                        $.alert({
                            title: 'Alert!',
                            content: 'Lesson plan not found of this subject.Please add lesson plan first.',
                        });
                    }
                });
            }
             catch(ex){}
        }

        $scope.c_no_data = 0;
        function getCourseDetail()
        {
             try{
                $myUtils.httprequest(urlist.getcoursedetail,({
                                        subject_id:$scope.selected_subject.id,
                                        section_id:$scope.filterobj.section.id,
                                        semester_id:$scope.filterobj.semester.id,
                                        session_id:$scope.filterobj.session.id,
                                        class_id:$scope.filterobj.class.id,
                                })).then(function(response){
                    if(response != null && response.length > 0)
                    {
                        $scope.progresslist = response;
                    }
                    else{
                        $scope.progresslist = [];
                        $scope.finished();
                    }
                });
            }
             catch(ex){}
        }

         $scope.evulationarray = [];
        function GetEvulationHeader()
        {
             try{
                $myUtils.httprequest(urlist.getevaluationheader,({
                                        subject_id:$scope.selected_subject.id,
                                        section_id:$scope.filterobj.section.id,
                                        semester_id:$scope.filterobj.semester.id,
                                        session_id:$scope.filterobj.session.id,
                                        class_id:$scope.filterobj.class.id,
                                        school_id:$scope.school_id,
                    })).then(function(response){
                    getQuizDetail();
                    if(response != null && response.length > 0)
                    {
                        $scope.evulationarray = response;
                        
                    }else{
                        $scope.evulationarray = [];
                       // $scope.finished();
                    }
                });
            }
             catch(ex){}
        }


         function getQuizDetail()
        {
             try{
                $myUtils.httprequest(urlist.getquizevaluationlist,({
                                        subject_id:$scope.selected_subject.id,
                                        section_id:$scope.filterobj.section.id,
                                        semester_id:$scope.filterobj.semester.id,
                                        session_id:$scope.filterobj.session.id,
                                        class_id:$scope.filterobj.class.id,
                                        school_id:$scope.school_id, 
                    })).then(function(response){

                    if(response != null)
                    {
                        $scope.evulationlist = response;
                    }
                    else{
                        $scope.evulationlist = [];
                        $scope.finished();
                    }
                });

            }
            catch(ex){

            }
        }

         $scope.viewresult = function(student,quizid)
        {
            try{

                $myUtils.httprequest(urlist.getstudentquizdetail,({student_id:student.student_id,quiz_id:quizid})).then(function(response){
                    if(response != null &&  response.length > 0)
                    {
                        $scope.screenname = student.screenname;
                        $scope.sudentquizdetail = response;
                        $("#resultmodel").modal('show');
                    }
                    else{
                        $scope.sudentquizdetail = [];
                    }
                });
            }
            catch(ex){}
        }

        $scope.open_course_progress = function(subject)
        {
            $scope.cprocessfinished = false; 
            $scope.selected_subject = subject;
            $scope.evaulationcollapse = false;
            getLessonPlanList();
        }

        $scope.open_evalution = function(subject)
        {
            $scope.eprocessfinished = false;
            $scope.selected_subject = subject;
            $scope.evaulationcollapse = true;
  
            GetEvulationHeader();
        }

    });
</script>

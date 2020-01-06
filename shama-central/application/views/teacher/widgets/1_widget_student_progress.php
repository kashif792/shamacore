                        
<div class="col-lg-12" ng-controller="principal_report_controller" ng-init="processfinished=false">
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
        <div class="panel-body whide" id="progress_report" ng-class="{'loader2-background': processfinished == false}">
            <div class="loader2" ng-hide="processfinished" ></div>
            <div class="row" ng-hide="!processfinished">
                <div class="col-sm-12">
                    <form class="form-inline" >
                      <!-- <div class="form-group">
                          <label for="email">Email address:</label>
                          <input type="email" class="form-control" id="email">
                      </div> -->
                        
                        <div class="form-group">
                            <label for="select_class">Grade:</label>
                            <select class="form-control" ng-options="item.name for item in classlist track by item.id"  name="select_class" id="select_class"  ng-model="filterobj.class" ng-change="chnagefilter()"></select>
                        </div>
                        <div class="form-group">
                            <label for="inputSection">Section:</label>
                            <select class="form-control"  ng-options="item.name for item in sectionslist track by item.id"  name="inputSection" id="inputSection"  ng-model="filterobj.section" ng-change="chnagefilter()"></select>
                        </div>
                        
                    </form>
                </div>
            </div>
            <div class="row padding-top" ng-hide="!processfinished">
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
                                                         <button type="button" ng-hide="cedit || !cprocessfinished" ng-click="editProgressReport();" data-parent="#data_attributes">
                                                            Edit</button>

                                                            <button  type="button"  ng-hide="!cedit" ng-click='doneProgressReport("form_",sub.sbid,s.sid,p.semsterid,p.sessionid,p.classid)' data-parent="#data_attributes">
                                                            Save</button>
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
                                                                        <!-- <td ng-repeat="s in p.student_plan"  class="{{s.status}}">
                                                                            <i id="pi_{{sub.id}}_{{s.lesson_id}}_{{p.student_id}}"  class="fa {{s.status == 'read'?'fa-check':(s.show?'fa-times':'')}}" aria-hidden="true"></i>
                                                                        </td> -->
                                                                        <td ng-repeat="t in p.student_plan" class="{{t.status}}" 
                                                                        id="ptd_{{s.id}}_{{t.lessonid}}_{{p.studentid}}" ng-click="progressChanged(s.id,t.lessonid, p.studentid)">
                                                                            <span >
                                                                                <!-- <input type="hidden" id="p_{{s.sbid}}_{{t.lessonid}}_{{p.studentid}}" value="{{t.status == 'read'?1:0}}"/>  -->
                                                                                <i id="pi_{{s.id}}_{{t.lessonid}}_{{p.studentid}}" data-status="{{t.status}}" class="fa {{t.status == 'read'?'fa-check':(t.show?'fa-times':'')}}" aria-hidden="true"></i>
                                                                            </span>
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
                                                    <div class="row" style="margin: 10px 0px;">
                                                        <div class="col-sm-4 text-center">
                                                            
                                                            <a href="javascript:void(0)" ng-click="addmidtermresult(p.classid,s.sid,s.id,p.semsterid,p.sessionid,'bt')" data-type="bt" class="btn btn-primary beforemid" style="color: #fff !important">Before Mid term Quiz Marks</a>
                                                            
                                                        </div>
                                                        
                                                        <div class="col-sm-4 text-center">
                                                            <a href="javascript:void(0)" class="btn btn-primary" ng-click="addmidtermresult(p.classid,s.sid,s.id,p.semsterid,p.sessionid,'at')" data-type="at"  style="color: #fff !important">After Mid Term Quiz Marks</a>
                                                        </div>
                                                        <div class="col-sm-4 text-center">
                                                            <a href="javascript:void(0)"class="btn btn-primary" ng-click="addtermresult(p.classid,s.sid,s.id,1,p.semsterid,p.sessionid)" style="color: #fff !important">Mid and Final Marks</a>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body" ng-hide="!eprocessfinished">
                                                        <div  style="overflow: auto;">
                                                            <table datatable="ng"  class="table table-striped table-bordered row-border hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Student Name</th>
                                                                        <th ng-repeat="e in evulationarray" ng-if="e.term_status == 'bt'">
                                                                            {{e.name}}
                                                                        </th>
                                                                        <th class="exam-link" >Mid Term</th>
                                                                        <th ng-repeat="e in evulationarray" ng-if="e.term_status == 'at'">
                                                                            {{e.name}}
                                                                        </th>
                                                                        <th class="exam-link" >Final Exam</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="reporttablebody-phase-two" class="report-body">
                                                                    <tr ng-repeat="e in evulationlist" ng-init="$last && finished()">
                                                                        <td>{{e.screenname}}</td>
                                                                        <!-- <td ng-repeat="s in e.score" ng-if="s.term_status == 'bt'">
                                                                            <a href="javascript:void(0);" ng-click="viewresult(e,s.quizid)">{{s.totalpercent}}</a>
                                                                        </td> -->
                                                                        <td ng-repeat="s in e.score" ng-if="s.term_status == 'bt'">
                                                                            <a href="javascript:void(0);" >{{s.totalpercent}}</a>
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

<div id="midtermmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form name="quiz_submit">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Quizzes Marks Before Mid Term</h4>
                <div class="row" ng-show="evulationarray.length > 0" id="result_mid_message">Marks will be saved automatically</div>
            </div>
            
            <div class="modal-body" ng-init="no_data = 0;" style="min-height: 400px;max-height: 400px;overflow: auto;">
                <div class="panel-body" ng-hide="!eprocessfinished">
                    <div id="midbefore_container" class="marks_container"  style="overflow: auto;">
                        <table style="width: 100%;">
                        <thead>
                            <tr ng-show="evulationarray.length > 0">
                                <th>Student</th>
                                <th ng-repeat="e in evulationarray" ng-if="e.term_status == 'bt'">
                                        {{e.name}} 
                                    </th>
                                
                            </tr>
                        </thead>
                        <tbody id="resultmidbody"></tbody>
                    </table>
                    </div>
                   
                </div>
                
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
    </div>
</div>
<div id="finaltermmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <form name="quiz_submit">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Quizzes Marks After Mid Term</h4>
                <div ng-show="evulationarray.length > 0" class="row" id="result_mid_message">Marks will be saved automatically</div>
            </div>
            
            <div class="modal-body" ng-init="no_data = 0;" style="min-height: 400px;max-height: 400px;overflow: auto;">
                <div class="panel-body" ng-hide="!eprocessfinished">
                    <div id="midbefore_container" class="marks_container"  style="overflow: auto;">
                        <table style="width: 100%;">
                        <thead>

                            <tr ng-show="evulationarray.length > 0">
                                <th>Student</th>
                                <th ng-repeat="e in evulationarray" ng-if="e.term_status == 'at'">
                                        {{e.name}} 
                                    </th>
                                
                            </tr>
                        </thead>
                        <tbody id="resultfinalbody"></tbody>
                    </table>
                    </div>
                   
                </div>
                
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
    </div>
</div>
<div id="resultmodel" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <form name="quiz_submit">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Quiz detail of {{screenname}}</h4>
            </div>
            <div class="alert alert-success success_msg" style="display: none;">
              <strong>Success!</strong> 
            </div>
            <div class="alert alert-danger error_msg" style="display: none;">
              <strong>Error!</strong> 
            </div>
            <input type="hidden" name="studentid" value="{{studentid}}">
            <input type="hidden" name="quizid" value="{{quizid}}">
            <div class="modal-body" ng-init="no_data = 0;">
                <div class="quiz" ng-if="no_data == 0">
                     <table style="width:100%;">
                        <tr ng-repeat="q in sudentquizdetail">
                            <td>
                                <div>
                                    <input type="hidden" name="question_id[]" value="{{q.question_id}}">
                                    <p class="question" ng-if="q.thumbnail_src == ''">Q{{$index+1}}: {{q.question}}</p>
                                    <p class="question" ng-if="q.thumbnail_src != ''">Q{{$index+1}}: {{q.question}} <img src="{{q.thumbnail_src}}" width="75"></p>
                                    <ul>
                                        <span ng-repeat="o in q.options">

                                            <span>
                                                <!-- <span ng-if="o.iscorrect == 1"> -->
                                                <span ng-if="o.iscorrect == 1">
                                                    <span ng-if="q.selectedoption == o.optionid">
                                                        <!-- <span class="userchecked"></span> -->
                                                        <input class="answer " id="selectedchecked_{{o.optionid}}" type="radio"  name="inputselected" value="{{o.optionid}}" checked="checked">
                                                    </span>
                                                    <span ng-if="q.selectedoption != o.optionid">
                                                    <!-- <span class="usernotchecked"></span> -->
                                                        <input class="answer " type="radio" name="inputselected_{{q.question_id}}" value="{{o.optionid}}">
                                                    </span>
                                                </span>
                                                
                                                <span ng-if="o.iscorrect == 0">
                                                    <span ng-if="q.selectedoption == o.optionid">
                                                     <!-- <span class="userchecked"></span> -->
                                                        <input class="answer " id="selectedchecked_{{o.optionid}}" type="radio" name="inputselected" value="{{o.optionid}}" checked="checked">
                                                    </span>
                                                    <span ng-if="q.selectedoption != o.optionid">
                                                        <!-- <span class="usernotchecked"></span> -->
                                                        <input class="answer " type="radio" name="inputselected_{{q.question_id}}" value="{{o.optionid}}">
                                                    </span>
                                                </span>

                                                <label id="correctString1" ng-if="q.qtype == 't'">{{o.optionitem}}</label>
                                                <label id="correctString1" ng-if="q.qtype == 'i'"><img src="{{o.optionitem}}" alt="Option Image" width="75"></label>
                                                    <span ng-if="o.iscorrect == 1">
                                                </span>
                                               <!--  <span ng-if="o.iscorrect == 0">
                                                    <span ng-if="q.selectedoption == o.optionid">
                                                        <img src="<?php echo base_url(); ?>images/bullet_cross.png">
                                                    </span>
                                                </span>
                                                <span ng-if="o.iscorrect == 1">
                                                   <img src="<?php echo base_url(); ?>images/tick.png">
                                                </span> -->
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
                <button type="button" id="submit_insert" class="btn btn-default">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
    </div>
</div>


<div id="termmodel" class="modal fade" role="dialog">
    <div class="modal-dialog" >
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Result</h4>
                 <div class="row" id="result_message"></div>
            </div>
            <div class="modal-body" id="model_body" style="min-height: 500px;max-height: 500px;overflow: auto;">
                <div id="result_container">

                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Mid Term <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></th>
                                <th>Final Term <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></th>
                            </tr>
                        </thead>
                        <tbody id="resultbody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                getclasslistTeacher:'<?php echo SHAMA_CORE_API_PATH; ?>classes',
                getholidaytypes:'<?php echo SHAMA_CORE_API_PATH; ?>holiday_types',
                getholidays:'<?php echo SHAMA_CORE_API_PATH; ?>holidays',
                getsectionbyclasslist:'<?php echo SHAMA_CORE_API_PATH; ?>sections_by_class',
                getsemesterlist:'<?php echo SHAMA_CORE_API_PATH; ?>semesters',
                getsubjectlist:'<?php echo SHAMA_CORE_API_PATH; ?>subjects',
                getsubjectbyclasslist:'<?php echo SHAMA_CORE_API_PATH; ?>subjects_by_class',
                getcourselesson:'<?php echo SHAMA_CORE_API_PATH; ?>course_lessons',
                getcoursedetail:'<?php echo SHAMA_CORE_API_PATH; ?>course',
                getstudentquizdetail:'<?php echo SHAMA_CORE_API_PATH; ?>quiz_evaluation_details',
                getquizevaluationlist:'<?php echo SHAMA_CORE_API_PATH; ?>quiz_evaluations',
                getevaluationheader:'<?php echo SHAMA_CORE_API_PATH; ?>evaluation_header',
                getmidtermsubjectresult:'<?php echo SHAMA_CORE_API_PATH; ?>student_quiz_marks',
                savestudentmidquizmarks:'<?php echo SHAMA_CORE_API_PATH; ?>student_quiz_marks',
                getsubjectresult:'<?php echo SHAMA_CORE_API_PATH; ?>student_marks',
                savestudentmarks:'<?php echo SHAMA_CORE_API_PATH; ?>student_marks',
                
        
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
        $scope.autoCall = false;
        $scope.reloadcontent = function()
        {
            $scope.cprocessfinished = false;
            rinterval = $interval(function(){
                if($scope.isCourseTabActive)
                {
                    $scope.autoCall = true;
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
                    //GetEvulationHeader($scope.subject_id,$scope.class_id,$scope.section_id,$scope.semester_id,$scope.session_id)
                }
            },60000); 
        }
        
        function getSessionList()
        {
            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>sessions',({school_id:$scope.school_id})).then(function(response){
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

        function getclasslistTeacher()
        {

            var data = ({school_id:$scope.school_id,user_id:$scope.user_id});
            $myUtils.httprequest(urlist.getclasslistTeacher,data).then(function(response){
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

        getclasslistTeacher();

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
                    user_id:$scope.user_id,
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
        // Save code
    // Edit code
var lessonarray = [];
$scope.progressChanged = function(subjectid,lessonid, studentid){
             if($scope.cedit){
                var status = $('#pi_'+subjectid+"_"+lessonid+"_"+studentid).attr('data-status');
                var datastatus = subjectid+'_'+lessonid+'_'+studentid;
                var idx = $.inArray(datastatus, lessonarray);
                if (idx == -1) {
                  lessonarray.push(datastatus);
                } else {
                  lessonarray.splice(idx, 1);
                }
               
                $scope.statusupdate(status, subjectid, lessonid,studentid);
               
             }
            

            //console.log(lessonarray);
        }
    $scope.editProgressReport = function(){
    //$scope.stopcontent();
    $scope.cedit = true;
    $scope.isCourseTabActive=false;
    }

$scope.cancelProgressReport = function(){
    $scope.cedit = false;
    $scope.isCourseTabActive=true;
    //$scope.reloadcontent();
}

$scope.doneProgressReport = function(){
    $scope.cedit = false;
    $scope.isCourseTabActive=true;
    console.log(lessonarray);
    if(lessonarray.length>0)
    {
        $scope.saveProgressReportbulkStatus(lessonarray);
    }
    
}
    // status update with array
    
    $scope.saveProgressReportbulkStatus = function(lessonarray){
            
             dataString = lessonarray ; // array?
             var jsonString = JSON.stringify(dataString);
            $.ajax({
                url:'<?php echo SHAMA_CORE_API_PATH; ?>student_lesson_progress',
                type: 'POST',
                data: {data : jsonString}, 
                success: function(res){
                    if(res==1){
                        //getCourseDetail(subjectid,sectionid,semesterid,sessionid,classid);
                        lessonarray.length = 0;
                        $scope.cedit = false;
                        $scope.isCourseTabActive=true;
                        //$scope.reloadcontent();
                        message('Updated Successfully','show');
                        //console.log(lessonarray);
                    }else{
                        alert("Unable to save progress at the moment.");
                    }
                    $scope.cprocessfinished = true;
                    //$this.button('reset');
                },
                error: function(){
                    alert("Fail to save progress at the moment.");
                    $scope.cprocessfinished = true;
                    //$this.button('reset');
                }
            });
        }  
    // End here
        $scope.saveProgressReport = function(formid,subjectid,sectionid,semesterid,sessionid,classid){
            $scope.cprocessfinished = false;
                var $container = $("#"+formid+classid+subjectid);
                 var str = $container.serializeArray();
                $.ajax({
                    url:'UpdateSemesterLessonProgress',
                    type: 'POST',
                    data: str,
                    success: function(res){
                        if(res==1){
                            getCourseDetail(subjectid,sectionid,semesterid,sessionid,classid);
                            $scope.cedit = false;
                            $scope.isCourseTabActive=true;
                            $scope.reloadcontent();
                        }else{
                            alert("Unable to save progress at the moment.");
                        }
                        $scope.cprocessfinished = true;
                        //$this.button('reset');
                    },
                    error: function(){
                        alert("Fail to save progress at the moment.");
                        $scope.cprocessfinished = true;
                        //$this.button('reset');
                    }
                });
        }   
        // Toggal read and unread
        $scope.statusupdate = function(isread, subjectid, lessonid,studentid){
                
                if(isread=='unread')
                {
                    
                    $('#pi_'+subjectid+'_'+lessonid+'_'+studentid).addClass('fa-check');
                    $('#pi_'+subjectid+'_'+lessonid+'_'+studentid).removeClass('fa-times');
                    $('#pi_'+subjectid+"_"+lessonid+"_"+studentid).attr('data-status','read');

                    $('#ptd_'+subjectid+'_'+lessonid+'_'+studentid).removeClass('unread');
                    $('#ptd_'+subjectid+'_'+lessonid+'_'+studentid).addClass('read');
                    
                }else{
                    
                    $('#pi_'+subjectid+'_'+lessonid+'_'+studentid).removeClass('fa-check');
                    $('#pi_'+subjectid+'_'+lessonid+'_'+studentid).addClass('fa-times');
                    $('#pi_'+subjectid+"_"+lessonid+"_"+studentid).attr('data-status','unread');
                    
                    $('#ptd_'+subjectid+'_'+lessonid+'_'+studentid).removeClass('read');
                    $('#ptd_'+subjectid+'_'+lessonid+'_'+studentid).addClass('unread');
                    
                }
                
                
            }

        // End here
        $scope.saveLessonProgress = function(isread, subjectid, lessonid,studentid){
                isread = isread?1:0;
                console.log("saveLessonProgress lessonid "+ lessonid + " studentid "+ studentid + " status "+ isread);
                $.ajax({
                    url:'UpdateLessonProgress',
                    type: 'POST',
                    data: {'lessonid': lessonid, 'studentid': studentid, 'isread': isread},
                    success: function(json){
                        console.log(json);
                        try{
                            var res = $.parseJSON(json);
                            if(res.message==true){
                                read = (res.status == 'read');
                                $('#p_'+subjectid+'_'+res.lessonid+'_'+res.studentid).val(read?1:0);

                                if(read){
                                    $('#pi_'+subjectid+'_'+res.lessonid+'_'+res.studentid).addClass('fa-check');
                                    $('#pi_'+subjectid+'_'+res.lessonid+'_'+res.studentid).removeClass('fa-times');
                                
                                    $('#ptd_'+subjectid+'_'+res.lessonid+'_'+res.studentid).removeClass('unread');
                                    $('#ptd_'+subjectid+'_'+res.lessonid+'_'+res.studentid).addClass('read');
                                }else{
                                    $('#pi_'+subjectid+'_'+res.lessonid+'_'+res.studentid).removeClass('fa-check');
                                    $('#pi_'+subjectid+'_'+res.lessonid+'_'+res.studentid).addClass('fa-times');

                                    $('#ptd_'+subjectid+'_'+res.lessonid+'_'+res.studentid).removeClass('read');
                                    $('#ptd_'+subjectid+'_'+res.lessonid+'_'+res.studentid).addClass('unread');
                                }
                            }else{
                                console.log("Unable to save progress at the moment.");
                            }
                        }catch(e){console.log(e);}
                    },
                    error: function(){
                        alert("Fail to save progress at the moment.");
                        //$scope.cprocessfinished = true;
                        //$this.button('reset');
                    }
                });
            }
        // Save code end
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
                                        autocall:$scope.autoCall,
                                })).then(function(response){
                    if(response != null && response.length > 0)
                    {
                        
                        clearInterval(rinterval);
                        
                        //console.log($scope.selected_subject.id);
                        if($("#p_"+$scope.selected_subject.id).attr('aria-expanded')=='true')
                        {
                            $scope.isCourseTabActive = true;
                        }
                        else
                        {
                            $scope.isCourseTabActive = false;
                        }
                        
                        
                        if($scope.autoCall==true)
                        {
                           
                            $.each(response, function (index, value) {
                               var stdPlan = $filter('filter')($scope.progresslist,{studentid:value['studentid']},true);
                                if(stdPlan!=null && stdPlan.length>0) stdPlan = stdPlan[0];
                                
                                $.each(value['student_plan'], function (index, val) {
                                
                                    var stdLesson = $filter('filter')(stdPlan.student_plan,{lessonid:val['lessonid']},true);
                                    if(stdLesson!=null && stdLesson.length>0) stdLesson = stdLesson[0];
                                    
                                    if(stdLesson.status != val['status']){
                                        //console.log("Change status "+ val['status'] + " for lesson "+ val['lessonid'] + " student "+ value['studentid']);
                                        stdLesson.status = val['status'];
                                    }
                                })
                            });
                            
                            console.log('autocalll');
                        }
                        else
                        {

                            $scope.progresslist = response;
                            
                        }
                        $scope.autoCall=false;
                        
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
                    
                    if(response != null && response.length > 0 )
                    {
                        $scope.evulationarray = response;
                        
                    }else{
                        $scope.evulationarray = [];
                        $scope.finished();
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
                                        class_id:$scope.filterobj.class.id,
                                        user_id:$scope.user_id, 
                                        school_id:$scope.school_id, 
                    })).then(function(response){

                    if(response != null && response.length > 0)
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
        // GetMarks

        var studentData = [];
         var container = document.getElementById('result_container');
         $scope.subjid = 0
        $scope.addmidtermresult = function(classid,sectionid,subjectid,semesterid,sessionid,type)
        {

            try{
                 $scope.subjid = subjectid;
                 var cont_str = '';
                studentData = [];
                        
                $myUtils.httprequest(urlist.getmidtermsubjectresult,({
                                class_id:$scope.filterobj.class.id,
                                section_id:$scope.filterobj.section.id,
                                subject_id:subjectid,
                                semester_id:$scope.filterobj.semester.id,
                                session_id:$scope.filterobj.session.id,
                                quiz_type:type,
                                school_id : $scope.school_id,
                                user_id:$scope.user_id,
                                })).then(function(response){
                    //getQuizDetail(subjectid,classid,sectionid,semsterid,sessionid)
                    //console.log(subjectid+"subject_name"+classid+"sectionid"+sectionid+"semesterid"+semesterid+"sessionid"+sessionid);
                    GetEvulationHeader(subjectid,classid,sectionid,semesterid,sessionid);
                    
                    if(response.length > 0 )
                    {
                        
                        var columnname = ['m','f'];
                        var quiz_total_marks = '<?php echo QUIZ_TOTAL_MARKS ?>';
                        var quizid = 0;
                        for (var i = 0; i <= response.length-1; i++) {
                            
                            cont_str += '<tr>'
                            cont_str += '<td width="60%">'+response[i].name+'</td>';
                            //console.log(response);
                            for (var k = 0; k < response[i].quiz_id.length; k++) {
                                //console.log(response[i].quizid[k].quizid);
                                cont_str += '<td width="20%"><input type="number" min="0" max="'+quiz_total_marks+'" name="term_result" id="mid_result" data-studentsemesterid= "'+$scope.filterobj.semester.id+'" data-studentsessionid= "'+$scope.filterobj.session.id+'" data-studentid = "'+response[i].student_id+'" data-marksid = "'+response[i].id+'" data-classid = "'+$scope.filterobj.class.id+'" data-sectionid = "'+$scope.filterobj.section.id+'" data-subjectid = "'+subjectid+'"  data-column ="m"  data-quizid="'+response[i].quiz_id[k].quizid+'" value="'+response[i].marks[k].studentmarks+'"/></td>'
                            }
                           cont_str += '</tr>'
                        }

                        if(type=='bt')
                        {
                            $("#resultmidbody").html(cont_str)
                        }
                        else
                        {

                            $("#resultfinalbody").html(cont_str)
                        }
                    }
                    else{
                        if(type=='bt')
                        {
                            $("#resultmidbody").html("<tr><td colspan='3' class='text-center'>No Quizzes found</td></tr>")
                        }
                        else
                        {
                            $("#resultfinalbody").html("<tr><td colspan='3' class='text-center'>No Quizzes found</td></tr>")
                        }
                    }
                });

                $scope.classid = classid;
                $scope.sectionid = sectionid;
                $scope.subjectid = subjectid;
                 $scope.semesterid = semesterid;
                 $scope.sessionid = sessionid;
                $("#result_message").html('Marks will be saved automatically')
                if(type=='bt')
                {
                    $("#midtermmodal").modal('show');
                }
                else
                {
                    $("#finaltermmodal").modal('show');
                }
                $scope.isExamTabActive = false;
            }
            catch(ex){}

        }
        $(document).on('change','#mid_result',function(){
            if($(this).val().length > 0 && $(this).val() >= 0 && $(this).val() <= 100 ){
              var data = {
                    school_id:$scope.school_id,
                    user_id:$scope.user_id,
                    cellvalue:$(this).val(),
                    cellcolumn:$(this).attr('data-column'),
                    cellid:$(this).attr('data-marksid'),
                    classid:$(this).attr('data-classid'),
                    sectionid:$(this).attr('data-sectionid'),
                    subjectid:$(this).attr('data-subjectid'),
                    quizid:$(this).attr('data-quizid'),
                    studentid:$(this).attr('data-studentid'),
                    semesterid:$(this).attr('data-studentsemesterid'),
                    sessionid:$(this).attr('data-studentsessionid'),
                }
                $("#result_message").html('Saving mark')
                try{
                   $myUtils.httppostrequest(urlist.savestudentmidquizmarks,data).then(function(response){
                        //console.log(response);
                        if(response != null && response.message  == true)
                        {
                            $("#result_mid_message").html('Mark saved');
                        }else{
                            $("#result_mid_message").html('Mark not saved');
                        }
                    });
                }
                catch(ex){}
            }
        });
        var studentData = [];
         var container = document.getElementById('result_container');
         $scope.subjid = 0
        
        var studentData = [];
         var container = document.getElementById('result_container');
         $scope.subjid = 0;
        $scope.addtermresult = function(classid,sectionid,subjectid,termid,semesterid,sessionid)
        {
            try{
                 $scope.subjid = subjectid
                studentData = [];
                $myUtils.httprequest(urlist.getsubjectresult,({
                                class_id:$scope.filterobj.class.id,
                                section_id:$scope.filterobj.section.id,
                                subject_id:subjectid,
                                semesterid:$scope.filterobj.semester.id,
                                sessionid:$scope.filterobj.session.id,
                                school_id:$scope.school_id,
                                user_id:$scope.user_id,
                                term_id:termid})).then(function(response){
                    if(response != null &&  response.length > 0)
                    {
                        var cont_str = '';
                        var columnname = ['m','f']
                        for (var i = 0; i <= response.length-1; i++) {
                            cont_str += '<tr>'
                            cont_str += '<td width="60%">'+response[i].name+'</td>'
                            for (var k = 0; k < response[i].marks.length; k++) {
                                if(columnname[k]=='m')
                                {
                                    var term_total_marks = '<?php echo MID_TOTAL_MARKS ?>';
                                }
                                else
                                {
                                    var term_total_marks = '<?php echo FINAL_TOTAL_MARKS ?>';
                                }
                                cont_str += '<td width="20%"><input type="number" min="0" max="'+term_total_marks+'" name="term_result" id="term_result" data-studentsemesterid= "'+$scope.filterobj.semester.id+'" data-studentsessionid= "'+$scope.filterobj.session.id+'" data-studentid = "'+response[i].studentid+'" data-marksid = "'+response[i].id+'" data-classid = "'+$scope.filterobj.class.id+'" data-sectionid = "'+$scope.filterobj.section.id+'" data-subjectid = "'+subjectid+'" data-termid = "'+termid+'" data-column ="'+columnname[k]+'" value="'+response[i].marks[k].studentmarks+'"/></td>'
                            }
                           cont_str += '</tr>'
                        }
                        $("#resultbody").html(cont_str)
                    }
                    else{
                        $("#resultbody").html("<tr><td colspan='3'>No student in class</td></tr>")
                    }
                });

                $scope.classid = classid;
                $scope.sectionid = sectionid;
                $scope.subjectid = subjectid;
                 $scope.semesterid = semesterid;
                 $scope.sessionid = sessionid;
                $("#result_message").html('Marks will be saved automatically')
                $("#termmodel").modal('show');
                $scope.isExamTabActive = false;
            }
            catch(ex){}
        }

        $('#termmodel').on('hidden.bs.modal', function () {
            $scope.isExamTabActive = true;
            getQuizDetail($scope.subjid,$scope.classid,$scope.sectionid,$scope.semesterid,$scope.sessionid)

            
        })
        // before mid modal hide
        $('#midtermmodal').on('hidden.bs.modal', function () {
            $scope.isExamTabActive = true;
            getQuizDetail($scope.subjid,$scope.classid,$scope.sectionid,$scope.semesterid,$scope.sessionid)

            
        })
        // after mid modal hide
        $('#finaltermmodal').on('hidden.bs.modal', function () {
            $scope.isExamTabActive = true;
            getQuizDetail($scope.subjid,$scope.classid,$scope.sectionid,$scope.semesterid,$scope.sessionid)

            
        })
        
        $(document).on('change','#term_result',function(){
            if($(this).val().length > 0 && $(this).val() >= 0 && $(this).val() <= 100 ){
              var data = {
                    school_id:$scope.school_id,
                                user_id:$scope.user_id,
                    cellvalue:$(this).val(),
                    cellcolumn:$(this).attr('data-column'),
                    cellid:$(this).attr('data-marksid'),
                    classid:$(this).attr('data-classid'),
                    sectionid:$(this).attr('data-sectionid'),
                    subjectid:$(this).attr('data-subjectid'),
                    termid:$(this).attr('data-termid'),
                    studentid:$(this).attr('data-studentid'),
                    semesterid:$(this).attr('data-studentsemesterid'),
                    sessionid:$(this).attr('data-studentsessionid'),
                }
                $("#result_message").html('Saving mark')
                try{
                   $myUtils.httppostrequest(urlist.savestudentmarks,data).then(function(response){
                        //console.log(response);
                        if(response != null && response.message  == true)
                        {
                            $("#result_message").html('Mark saved');
                        }else{
                            $("#result_message").html('Mark not saved');
                        }
                    });
                }
                catch(ex){}
            }
        });
        function httppostrequest(url,data)
        {
            var request = $http({
                method:'POST',
                url:url,
                data:data,
                headers : {'Accept' : 'application/json'}
            });
            return (request.then(responseSuccess,responseFail))
        }
    });
</script>

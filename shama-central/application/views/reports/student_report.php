<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10 col-md-10 col-lg-10 class-page "  ng-controller="StudentReportCtrl" ng-init="loading = true">
    <?php
        // require_footer
        require APPPATH.'views/__layout/filterlayout.php';
    ?>
     <script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" ng-click="$dismiss()">&times;</button>
            <h5 class="modal-title">
                Quiz
            </h5>
        </div>
        <div class="modal-body">
            <div ng-hide="show_quiz_detail">
                <table datatable="ng" ng-hide="evulationarray.length <= 0" class="table table-striped table-bordered row-border hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Percent</th>
                        </tr>
                    </thead>
                    <tbody id="reporttablebody-phase-two" class="report-body">
                        <tr ng-repeat="d in quizdata">
                            <th>
                                <a href="javascript:void(0)" class="link-student" ng-click="viewresult(d.quizid)">
                                    {{d.quiz}}
                                </a>
                            </th>
                            <td>
                                {{d.marks}}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p ng-hide="evulationarray.length > 0" class="text-center">
                    <label>No record found</label>
                </p>
            </div>
            <div ng-hide="!show_quiz_detail">
                <a href="javascript:void(0)" class="link-student" ng-click="showquiz()">
                    <h5><< Back to list</h5>
                </a>
                <hr>
                <table style="width:100%;">
                    <tr ng-repeat="q in studentquizdetail">
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
        </div>
    </script>
    <div class="">
        <div class="loading" ng-hide="loading == false">
            Loading&#8230;
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <!-- widget title -->
                    <div class="panel-heading">
                        <label>Student Report</label>
                        <label class="right-controllers">
                            <a href="javascript:void(0)" class="link-student" ng-click="printreport()" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
                        </label>
                        <label class="right-controllers">
                            <a href="javascript:void(0)" class="link-student" ng-click="download()" title="Download"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                        </label>
                    </div>
                    <div class="panel-body">
                        <div class="row">
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
                                        <select class="form-control"    ng-options="item.name for item in semesterlist track by item.id"  name="inputSemester" id="inputSemester"  ng-model="filterobj.semester" ng-change="chnagefilter()"></select>
                                    </div>
                                 
                                </form>
                            </div>
                        </div>
                        <div class="row padding-top">
                            <div class="col-sm-4">
                                <div class="row">
                                     <div class="col-sm-2">
                                        <h5>Student:</h5>
                                    </div>
                                    <div class="col-sm-7">
                                        <p class="">
                                            <select  class="form-control" ng-options="item.screen_name for item in studentlist track by item.id"  name="InputStudent" id="InputStudent"  ng-model="InputStudent" ng-change="changestudent()" ></select>
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div ng-hide="filterobj.semester.name == 'Spring'">
                                    <h4>Fall</h4>
                                    <table  class="table table-bordered table-striped table-hover table-responsive add_holiday" id="table-body-phase-tow" >
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th ng-repeat="e in evalution">{{e.title}}</th>
                                                 <th>Overall %</th>
                                                <th>Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody id="reporttablebody-phase-two " class="report-body">
                                            <tr ng-repeat="r in fallsemester" ng-class-odd="'active'" >
                                                <td>{{r.subject}}</td>
                                                <td>
                                                    {{r.evalution[0].assignment}}
                                                </td>
                                                <td >
                                                    <a href="javascript:void(0);" style="display: block;" ng-click="openpopup(r.serail,'Quiz')">
                                                        {{r.evalution[0].quiz}}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{r.evalution[0].mid}}
                                                </td>
                                                <td>
                                                    {{r.evalution[0].final}}
                                                </td>
                                                <td>
                                                    {{r.evalution[0].practical}}
                                                </td>
                                                <td>
                                                    {{r.evalution[0].assignment}}
                                                </td>
                                                <td>
                                                    {{r.evalution[0].oral}}
                                                </td>
                                                <td>
                                                    {{r.evalution[0].behavior}}
                                                </td>
                                                 <td>
                                                    {{r.evalution[0].total_percent}}
                                                </td>
                                                 <td>
                                                    {{r.evalution[0].grade}}
                                                </td>
                                            </tr>
                                            <tr ng-hide="fallsemester.length > 0">
                                                <td colspan="11" class="no-record">No data found</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div ng-hide="filterobj.semester.name == 'Fall'">
                                    <h4>Spring</h4> 
                                    <table  class="table table-bordered table-striped table-hover table-responsive add_holiday" id="table-body-phase-tow" >
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th ng-repeat="e in evalution">{{e.title}}</th>
                                                 <th>Overall %</th>
                                                <th>Grade</th>
                                            </tr>
                                        </thead>
                                        <tbody id="reporttablebody-phase-two " class="report-body">
                                            <tr ng-repeat="r in springsemester" ng-class-odd="'active'" >
                                                <td>{{r.subject}}</td>
                                                <td>
                                                    {{r.evalution[0].assignment}}
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" ng-click="openpopup(r.serail,'Quiz')">
                                                        {{r.evalution[0].quiz}}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{r.evalution[0].mid}}
                                                </td>
                                                <td>
                                                    {{r.evalution[0].final}}
                                                </td>
                                                <td>
                                                    {{r.evalution[0].practical}}
                                                </td>
                                                <td>
                                                    {{r.evalution[0].assignment}}
                                                </td>
                                                <td>
                                                    {{r.evalution[0].oral}}
                                                </td>
                                                <td>
                                                    {{r.evalution[0].behavior}}
                                                </td>
                                                 <td>
                                                    {{r.evalution[0].total_percent}}
                                                </td>
                                                 <td>
                                                    {{r.evalution[0].grade}}
                                                </td>
                                            </tr>
                                            <tr ng-hide="springsemester.length > 0">
                                                <td colspan="11" class="no-record">No data found</td>
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
</div>

<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>

<script src="<?php echo base_url(); ?>js/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>js/vfs_fonts.js"></script>

<script>

    app.controller('ModalInstanceCtrl', ['$scope', '$modalInstance', function ($scope, $modalInstance) {
        $scope.ok = function () {
            $modalInstance.close('this is result for close');
        };

        $scope.cancel = function () {
            $modalInstance.dismiss('this is result for dismiss');
        };
    }]);


    app.controller('StudentReportCtrl',['$scope','$myUtils','$filter', StudentReportCtrl]);

    function StudentReportCtrl($scope, $myUtils, $filter) {

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

        $scope.role_id = $myUtils.getUserDefaultRoleId();

        $scope.isPrincipal = $myUtils.isPrincipal();
        $scope.isTeacher = $myUtils.isTeacher();
        $scope.isAdmin = $myUtils.isAdmin();

        
        var session_id = '<?php echo $this->uri->segment(2); ?>';
        var class_id = '<?php echo $this->uri->segment(3); ?>';
        var section_id = '<?php echo $this->uri->segment(4); ?>';
        var semester_id = '<?php echo $this->uri->segment(5); ?>';
        var student_id = '<?php echo $this->uri->segment(6); ?>';
        

        $scope.school={};

        $scope.openModal = function()
        {
            $scope.theModal =  $modal.open({
                templateUrl: 'myModalContent.html',
                controller: 'ModalInstanceCtrl',
                scope: $scope,
            });
            
            $scope.theModal.result.then(
                function (result) {
                    $scope.show_quiz_detail = false;
                },
                function (result) {
                    $scope.show_quiz_detail = false;
                }
            );
        }


        $scope.resultlist = [];
         $scope.fallsemester = [];
        $scope.springsemester = [];

        $scope.filterobj = {};
        $scope.selectedsubject = {};
        $scope.show_quiz_detail = false;
        $scope.studentbase64imageobj = {};
        $scope.marks = {};

        
        function getSchoolDetails()
        {
            var data = {
                    school_id:$scope.school_id
                    }
            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>school',data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.school = response;
                }
                else{
                    $scope.finished();
                }
            });
        }
        
        getSchoolDetails();

        function getSessionList()
        {
            try{
                var data = {
                        school_id:$scope.school_id
                        }
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>sessions',data).then(function(response){
                    if(response != null && response.length > 0)
                    {
                        $scope.rsessionlist = response
                        
                        var find_active_session = $filter('filter')(response,{status:'a'},true);

                        if(typeof session_id != 'undefined' && session_id)
                        {
                            var is_session_found = $filter('filter')(response,{id:session_id},true);
                            if(is_session_found)
                            {
                                $scope.filterobj.session = is_session_found[0];
                            }
                            session_id = false;
                        }

                        if(!session_id && find_active_session.length > 0)
                        {
                            $scope.filterobj.session = find_active_session[0]  
                        }
                        else{
                            $scope.filterobj.session = response[0];
                        }
                    }
                });
            }
            catch(e){}
        }
        
        getSessionList();

        function getClassList()
        {
            try{
                var data = {
                        school_id:$scope.school_id
                        }
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>classes',data).then(function(response){
                    if(response != null && response.length > 0)
                    {
                        $scope.classlist = response

                        if(typeof class_id != 'undefined' && class_id)
                        {
                            var is_class_found = $filter('filter')(response,{id:class_id},true);
                            if(is_class_found)
                            {
                                $scope.filterobj.class = is_class_found[0];
                            }
                            class_id=false;
                        }
                        else{
                            $scope.filterobj.class = response[0];
                        }
                        loadSections();
                    }
                });
            }
            catch(e){}
        }


        getClassList();

        function loadSections()
        {
            try{
                var data = ({class_id:$scope.filterobj.class.id, user_id:$scope.user_id})
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>sections_by_class',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.sectionslist = response;

                        if(typeof section_id != 'undefined' && section_id)
                        {
                            var is_section_found = $filter('filter')(response,{id:section_id},true);
                            if(is_section_found)
                            {
                                $scope.filterobj.section = is_section_found[0];
                            }
                            section_id=false;
                        }
                        else{
                            $scope.filterobj.section = response[0];
                        }
                     
                        getSemesterData()
                    }
                    else{
                        $scope.sectionslist = [];
                    }
                })
            }
            catch(ex){}
        }

        function getSemesterData(){
            try{
                $scope.semesterlist = []
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>semesters',({school_id:$scope.school_id})).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.semesterlist = response;
                        
                        var find_active_semester = $filter('filter')(response,{status:'a'},true);
                        

                        if(typeof semester_id != 'undefined' && semester_id)
                        {
                            var is_semester_found = $filter('filter')(response,{id:semester_id},true);
                            if(is_semester_found)
                            {
                                $scope.filterobj.semester = is_semester_found[0];
                            }
                            semester_id=false;
                        }
                        
                        if(!semester_id && find_active_semester.length > 0)
                        {
                            $scope.filterobj.semester = find_active_semester[0]  
                        }
                        else{
                            $scope.filterobj.semester = response[0];
                        }
                        
                        // var temp = {
                        //     id:'b',
                        //     name:'Both',
                        //     status:'i'
                        // }

                        // $scope.semesterlist.push(temp);
                        $scope.loadStudentByClass();
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
            $scope.loadStudentByClass();
        }

        $scope.changestudent = function()
        {
           $scope.getGradedata();
        }

         $scope.loading = false;

        $scope.loadStudentByClass = function()
        {
            try{
                var data = ({   
                    class_id:$scope.filterobj.class.id,
                    section_id:$scope.filterobj.section.id,
                    semester_id:$scope.filterobj.semester.id,
                    session_id:$scope.filterobj.session.id,
                    student_id:(student_id ? student_id : $scope.InputStudent.id ),
                });
             
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>students',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.studentlist = response;

                        var is_student_found = $filter('filter')(response,{id:student_id},true);
                        
                        if(is_student_found.length > 0)
                        {
                            student_id = false;
                            $scope.InputStudent = is_student_found[0];
                        }else{
                            $scope.InputStudent = response[0];

                        }
                        
                        $scope.loading = false;
                        $scope.getGradedata();
                    }
                    else{
                        $scope.studentlist = [];
                        message('','hide')
                        $scope.loading = false;
                    }
                })
            }
            catch(ex){
                console.log(ex)
            }
        }

        $scope.range = function(n) {
            return new Array(n);
        };

       
        $scope.getGradedata = function()
        {
            try{
                 $scope.studentprofileimage();

            var data = ({
                student_id:(student_id ? student_id : $scope.InputStudent.id ),
                class_id:$scope.filterobj.class.id,
                section_id:$scope.filterobj.section.id,
                semester_id:$scope.filterobj.semester.id,
                session_id:$scope.filterobj.session.id,
                school_id:$scope.school_id
            })

            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>student_report',data).then(function(response){
                if(response.length > 0)
                {
                    if(response[0].semester == 'Fall')
                    {
                        $scope.fallsemester = response[0].result;
                    }
                    else{
                        $scope.springsemester = response[0].result;
                    }
                    
                    $scope.marks.grade = response[0].grade;
                    $scope.marks.obtain_marks = response[0].obtain_marks;
                    $scope.marks.percent = response[0].percent;
                    $scope.marks.total_marks = response[0].total_marks;
                }
                else{
                    $scope.resultlist = [];
                    $scope.fallsemester = [];
                    $scope.springsemester = [];
                }
            });
           }
            catch(ex){
                console.log(ex)
            }
           
        }

        $scope.evalution_header = [];
        $scope.getevalution = function()
        {
            try{
                     var data ={
                        session_id:session_id,
                	}
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>evaluation_formula',data).then(function(response){
                    if(response.length > 0)
                    {
                        $scope.evalution = response;
                        $scope.evalution_header.push("Subject");
                        angular.forEach(response,function(value,key){
                            $scope.evalution_header.push(value.title);
                        });
                        $scope.evalution_header.push("Overall %");
                        $scope.evalution_header.push("Grade");
                    }

                });
            }   
            catch(e)
            {
                console.log(e)
            }
        }
        $scope.getevalution();


        $scope.openpopup = function(subjectid,modal)
        {
            try{
                $scope.selectedsubject = subjectid;
                $scope.openModal();
                GetEvulationHeader();
            }
            catch(e){}
        }

        $scope.evulationarray = [];
        function GetEvulationHeader()
        {
             try{
                 var data = ({
                     subject_id:$scope.selectedsubject,
                     class_id:$scope.filterobj.class.id,
                     section_id:$scope.filterobj.section.id,
                     semester_id:$scope.filterobj.semester.id,
                     session_id:$scope.filterobj.session.id})
                     
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>evaluation_header', data).then(function(response){
                    if(response != null && response.length > 0)
                    {
                        $scope.evulationarray = response;
                        getQuizDetail();
                    }else{
                        $scope.evulationarray = [];
                    }
                });
            }
             catch(ex){}
        }


        function getQuizDetail()
        {
            try{
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>quiz_evaluations',({   
                    subject_id:$scope.selectedsubject,
                    class_id:$scope.filterobj.class.id,
                    section_id:$scope.filterobj.section.id,
                    semester_id:$scope.filterobj.semester.id,
                    session_id:$scope.filterobj.session.id,
                    student_id:(student_id ? student_id : $scope.InputStudent.id ),
                })).then(function(response){

                    if(response != null)
                    {
                        $scope.evulationlist = response;
                        populateData();
                    }
                    else
                    {
                        $scope.evulationlist = [];
                    }
                });
            }
            catch(ex){}
        }

        $scope.quizdata = [];
        function populateData()
        {
            try{
                $scope.quizdata = [];
                if($scope.evulationlist.length > 0)
                {
                    for (var i = 0; i <= $scope.evulationlist[0].score.length - 1; i++) {
                        var temp = {
                            quiz:$scope.evulationarray[i].name,
                            marks:$scope.evulationlist[0].score[i].totalpercent,
                            quizid:parseInt($scope.evulationlist[0].score[i].quizid)
                        }
                        $scope.quizdata.push(temp);
                    }
                    $scope.show_quiz_detail = false;
                }
            }
            catch(ex){}
        }

        $scope.viewresult = function(quizid)
        {
            try{

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>quiz_evaluation_details',({student_id:$scope.InputStudent.id,quiz_id:quizid})).then(function(response){
                    if(response != null &&  response.length > 0)
                    {
                        $scope.studentquizdetail = response;
                        $scope.show_quiz_detail = true;
                    }
                    else{
                        $scope.studentquizdetail = [];
                    }
                });
            }
            catch(ex){}
        }

        $scope.showquiz = function()
        {
            $scope.show_quiz_detail = false;
        }

        $scope.studentprofileimage = function()
        {
            var data ={
                student:$scope.InputStudent,
            }
   
            $myUtils.httppostrequest('<?php echo base_url() ?>studentbase64image',data).then(function(response){
                if( response.message == true)
                {
                    $scope.studentbase64imageobj = response.image;
                }
                else{
                    $scope.studentbase64imageobj = '';
                }
            });
        }

        function buildTableBody(data, columnsheader, columns) 
        {
            try{
                var body = [];

                body.push(columnsheader);

                data.forEach(function(row) {
                    var dataRow = [];

                    columns.forEach(function(column) {
                        var columnvalue = null;
                        if(column == 'subject')
                        {
                            columnvalue = row[column].toString();
                            dataRow.push(columnvalue);
                        }
                        if(column == 'evalution' && row[column].length)
                        {
                            for (var i = 0; i <= 9; i++) {
                                if(i == 0)
                                {
                                    columnvalue = row[column][0].assignment;
                                }
                                else if(i == 1)
                                {
                                    columnvalue = row[column][0].quiz;
                                }
                                else if(i == 2)
                                {
                                    columnvalue = row[column][0].mid;
                                }
                                else if(i == 3)
                                {
                                    columnvalue = row[column][0].final;
                                }
                                else if(i == 4)
                                {
                                    columnvalue = row[column][0].practical;
                                }
                                else if(i == 5)
                                {
                                    columnvalue = row[column][0].assignment;
                                }
                                else if(i == 6)
                                {
                                    columnvalue = row[column][0].oral;
                                }
                                else if(i == 7)
                                {
                                    columnvalue = row[column][0].behavior;
                                }
                                else if(i == 8)
                                {
                                    columnvalue = row[column][0].total_percent;
                                }
                                else if(i == 9)
                                {
                                    columnvalue = row[column][0].grade;
                                }
                                dataRow.push(columnvalue);
                            }

                        }
                    })

                    body.push(dataRow);
                });

                return body;
            }
            catch(e){
                console.log(e)
            }
        }

        function table(data, columnsheader , columns) {
            try{
                return {
                     margin: [0, 20, 0, 0],
                    table: {
                        margin: [0, 20, 0, 0],
                        headerRows: 1,
                        body: buildTableBody(data,columnsheader,columns)
                    }
                };
            }
            catch(e){
                console.log(e)
            }
        }

        $scope.createstudentdate = function()
        {
            try{
                if($scope.filterobj.semester.name == "Both")
                {
                    table( $scope.fallsemester, $scope.evalution_header ,['subject','evalution']);
                    table( $scope.springsemester, $scope.evalution_header ,['subject','evalution']);
                }else if($scope.filterobj.semester.name == "Fall"){
                    table( $scope.fallsemester, $scope.evalution_header ,['subject','evalution']);
                }else{
                    table( $scope.springsemester, $scope.evalution_header ,['subject','evalution']);
                }
            }
            catch(e){
                console.log(e)
            }
        }

        $scope.renderprintdata = function()
        {
            try{
            
                var docDefinition = {
                    footer: {
                        columns: [
                        {
                            aligment:'left',
                            table: 
                            {
                                widths: [150,150],
                                body: [
                                    [
                                        {
                                            border: [false],
                                            text: 'Director Signature :',
                                            aligment: 'left'
                                        },
                                        {
                                            border: [false, false, false, true],
                                            text: ' ',
                                            aligment:'center',
                                            color:'red'
                                        },
                                        
                                    ],
                                    [
                                        {
                                            border: [false],
                                            text: 'Principal Signature :',
                                            aligment: 'right'
                                        },
                                        {
                                            border: [false, false, false, true],
                                            text: ' ',
                                            aligment:'center',
                                            color:'red'
                                        },
                                    ],
                                ]
                            }
                        }]  
                    },
                    content: 
                    [
                        {
                            columns:
                            [
                                {
                                    table: 
                                    {
                                        widths: [50,100],
                                        body: 
                                        [
                                            [
                                                {
                                                    border: [false],
                                                    text: 'Serail'
                                                },
                                                {
                                                    border: [false, false, false, true],
                                                    text: '12112',
                                                    aligment:'center',
                                                },
                                            ],
                                            [
                                                {
                                                    border: [false],
                                                    text: 'City'
                                                },
                                                {
                                                    border: [false, false, false, true],
                                                    text: $scope.school.city_name,
                                                    aligment:'center',
                                                },
                                            ],
                                            [
                                                {
                                                    border: [false],
                                                    text: 'Campus'
                                                },
                                                {
                                                    border: [false, false, false, true],
                                                    text: $scope.school.name,
                                                    aligment:'center',
                                                },
                                            ],
                                           
                                        ]
                                    }
                                },
                                {
                                    image: '<?php echo $logo; ?>',
                                    alignment:'left'
                                },
                                {
                                    image: $scope.studentbase64imageobj,
                                    width: 100,
                                    height: 100,
                                    aligment:'right',
                                }
                            ]
                        },
                        {
                            text:'Result Card',
                            style:'card_heading'
                        },
                        {
                            text:'Grade: '+$scope.filterobj.class.name+", "+$scope.filterobj.section.name+' '+$scope.filterobj.semester.name,
                            style:'grade'
                        },
                        {
                            aligment:'center',
                            columns:
                            [
                                {
                                    table: 
                                    {
                                        widths: [100,'*'],
                                        body: 
                                        [
                                            [
                                                {
                                                    border: [false],
                                                    text: 'Name :'
                                                },
                                                {
                                                    border: [false, false, false, true],
                                                    text: $scope.InputStudent.name,
                                                    aligment:'center',
                                                },
                                            ],
                                            [
                                                {
                                                    border: [false],
                                                    text: 'Father Name :'
                                                },
                                                {
                                                    border: [false, false, false, true],
                                                    text: $scope.InputStudent.fathername,
                                                    aligment:'center',
                                                },
                                            ],
                                            [
                                                {
                                                    border: [false],
                                                    text: 'Roll No:'
                                                },
                                                {
                                                    border: [false, false, false, true],
                                                    text: $scope.InputStudent.rollnumber,
                                                    aligment:'center',
                                                },
                                                
                                            ],
                                            [
                                                {
                                                    border: [false],
                                                    text: 'Date of Birth :'
                                                },
                                                {
                                                    border: [false, false, false, true],
                                                    text: $scope.InputStudent.sdob,
                                                    aligment:'center',
                                                },
                                            ],
                                            [
                                                {
                                                    border: [false],
                                                    text: 'Session :'
                                                },
                                                {
                                                    border: [false, false, false, true],
                                                    text: $scope.filterobj.session.name,
                                                    aligment:'center',
                                                },
                                            ]
                                        ]
                                    }
                                }
                            ],  
                        },
                        ($scope.fallsemester.length > 0 ? table( $scope.fallsemester, $scope.evalution_header ,['subject','evalution']) :''),
                        ($scope.springsemester.length > 0 ? table( $scope.springsemester, $scope.evalution_header ,['subject','evalution']) :''),
                 
                        {
                            text:'Rules',
                            margin: [20, 5, 0, 0],
                        },
                        {
                            margin: [20, 5, 0, 0],
                            ul: 
                            [
                                'Obtained marks: ' + $scope.marks.obtain_marks, 
                                'Total marks: ' + $scope.marks.total_marks,
                                'Total percentage: ' + $scope.marks.percent + '%',
                                'Grade: ' +$scope.marks.grade,
                                'Final % is for each subject is calculated based on weight given to each test.',
                            ]
                        },
                    ],

                styles: 
{                    card_heading:{
                        fontSize:25,
                        color:'red',
                        alignment: 'center',
                        italics: true
                    },
                    grade:{
                        fontSize:20,
                        alignment: 'center',
                        italics: true
                    }
                }
            };
                return docDefinition;
            }
            catch(e){}
        }

        $scope.CheckData = function() 
        {
            try{
                if($scope.filterobj.semester.name == "Fall"){
                    if($scope.fallsemester.length < 0)
                    {
                        alert('No data found')
                        return false;
                    }
                }else{
                    if($scope.springsemester.length < 0)
                    {
                        alert('No data found')
                        return false;
                    }
                }
            }
            catch(e){
                console.log(e)
            }
        }

        $scope.printreport = function()
        {
            $scope.CheckData();
            var reportobj = $scope.renderprintdata();
            
            pdfMake.createPdf(reportobj).print();
        }
        

        $scope.download = function()
        {
            //$scope.CheckData();
            var reportobj = $scope.renderprintdata();
            if($scope.filterobj.semester.id == 'b')
            {
                var filename = decodeURIComponent($scope.filterobj.class.name)+"-"+decodeURIComponent($scope.filterobj.section.name)+"-final-"+decodeURIComponent($scope.InputStudent.name)+".pdf";
            }
            else{
                var filename = decodeURIComponent($scope.filterobj.class.name)+"-"+decodeURIComponent($scope.filterobj.section.name)+"-"+decodeURIComponent($scope.filterobj.semester.name)+"-"+decodeURIComponent($scope.InputStudent.name)+".pdf";
            }
            
             pdfMake.createPdf(reportobj).download(filename);
        }        

  }

</script>

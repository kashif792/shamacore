<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10 col-md-10 col-lg-10 class-page "  ng-controller="class_report_ctrl" ng-init="processfinished=false">
    <?php
        // require_footer
        require APPPATH.'views/__layout/filterlayout.php';
    ?>
   
    <div class="">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <!-- widget title -->
                    <div class="panel-heading">
                        <label>Mid Term Report</label>
                        <label class="right-controllers">
                            <a href="javascript:void(0)" class="link-student" ng-click="printreport()" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>
                        </label>
                        <label class="right-controllers">
                            <a href="javascript:void(0)" class="link-student" ng-click="download()" title="Download"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                            <!-- <a href="javascript:void(0)" class="link-student" onclick="getPDF()" title="Download"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a> -->
                        </label>
                    </div>
                    <div class="panel-body whide" id="class_report" >
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-inline" >
                                   
                                    <div class="form-group">
                                        <label for="inputRSession">Session:</label>
                                        <select  class="form-control" ng-options="item.name for item in rsessionlist track by item.id"  name="inputRSession" id="inputRSession"  ng-model="filterobj.session" ng-change="changeclass()" ></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="select_class">Grade:</label>
                                        <select class="form-control" ng-options="item.name for item in classlist track by item.id"  name="select_class" id="select_class"  ng-model="filterobj.class" ng-change="changeclass()"></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSection">Section:</label>
                                        <select class="form-control"  ng-options="item.name for item in sectionslist track by item.id"  name="inputSection" id="inputSection"  ng-model="filterobj.section" ng-change="getStutdent()"></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSemester">Semester:</label>
                                        <select class="form-control"    ng-options="item.name for item in semesterlist track by item.id"  name="inputSemester" id="inputSemester"  ng-model="filterobj.semester" ng-change="getStutdent()"></select>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="inputDate">Student:</label>
                                            <select  class="form-control" ng-options="item.name for item in studentlist track by item.id"  name="InputStudent" id="InputStudent"  ng-model="filterobj.studentid" ng-change="changestudent()" >
                                                <option style="display:none" value="">Select Student</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="row padding-top canvas_div_pdf">

                            <div class="col-sm-12">
                                <div>
                                           <div>
                                            <table  class="table table-striped table-bordered row-border hover">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Obtained Marks</th>
                                                <th>Total Marks</th>
                                                <th>Grade</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody class="report-body">
                                           <tr ng-repeat="s in subjectlist"  ng-init="$last && finished()" >
                                                <td>{{s.subject}}</td>
                                                <td>{{s.evalution[0].mid}}</td>
                                                <td>{{s.evalution[0].total_marks}}</td>
                                                <td>{{s.evalution[0].grade}}</td>
                                                
                                            </tr>
                                            <tr ng-show="subjectlist.length > 0">
                                                <td class="blue_back">Total Obtained Marks</td>
                                                <td class="blue_back">{{obtain_marks}}</td>
                                                <td class="blue_back">{{total_marks}}</td>
                                                <td class="blue_back">{{grade}}</td>
                                                
                                            </tr>
                                             <tr ng-hide="subjectlist.length > 0">
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
</div>
<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>

<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>
<script src="<?php echo base_url(); ?>js/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>js/vfs_fonts.js"></script>
<script src="<?php echo  base_url(); ?>js/ui-bootstrap-tpls-2.5.0.js"></script>

<script type="text/javascript">
    app.controller('class_report_ctrl',['$scope','$myUtils','$filter','$document', '$timeout','$interval','$compile','$filter', class_report_ctrl]);

    function class_report_ctrl($scope, $myUtils, $filter, $document, $timeout,$interval,$compile) {

    var urlist = ({
                getsessionlist:'<?php echo SHAMA_CORE_API_PATH; ?>sessions',
                
        
        });
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

        $scope.filterobj = {};
        defaultdate();
        $scope.active = 1;
        $scope.evulationlist = [];
        $scope.filterobj.section = 0;
        $scope.school={};
        $("#class_report").show();
        
         // Initialize default date
        function defaultdate()
        {
            try{
                
                $scope.filterobj.date = {
                    startDate:moment().format('MMM D, YY'),
                    endDate: moment().format('MMM D, YY'),
                };

                $scope.options = {
                    
                    eventHandlers:{
                        'apply.daterangepicker': function(ev, picker){
                            var sdate = $scope.filterobj.date.startDate.format('MMM D, YY');
                            var edate = $scope.filterobj.date.endDate.format('MMM D, YY');
                            $scope.filterobj.start_date =sdate;
                            $scope.filterobj.end_date =edate;
                            //$scope.GetEvulationHeader();
                        }
                    }
                };
            }
            catch(ex)
            {
                console.log(ex)
            }
        }
        function getSessionList()
        {
            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>getsessiondetail',({school_id:$scope.school_id})).then(function(response){
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
            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>getclasslist',({school_id:$scope.school_id})).then(function(response){
            //$myUtils.httprequest('getclasslist',({})).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.classlist = response
                    $scope.filterobj.class = response[0]
                    loadSections();
                    //getSemesterData();

                }
            });
        }

        getClassList();

        function loadSections()
        {
            try{
                var data = ({class_id:$scope.filterobj.class.id})
                $myUtils.httppostrequest('<?php echo SHAMA_CORE_API_PATH; ?>getsectionbyclass',({class_id:$scope.filterobj.class.id,school_id:$scope.school_id})).then(function(response){
                
                    if(response.length > 0 && response != null)
                    {
                        $scope.sectionslist = response;
                        $scope.filterobj.section = response[0];
                        getSemesterData();
                        //$scope.loadStudentByClass();
                    }
                    else{

                        $scope.sectionslist = [];
                        getSemesterData();
                        //$scope.loadStudentByClass();
                    }
                })
            }
            catch(ex){}
        }

        function getSemesterData(){
            try{
                $scope.semesterlist = []
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>getsemesterdata',({school_id:$scope.school_id})).then(function(response){
                
                //$myUtils.httprequest('<?php echo $path_url; ?>getsemesterdata',({})).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.semesterlist = response;
                        var find_active_semester = $filter('filter')(response,{active_semster:'a'},true);
                        
                        if(find_active_semester.length > 0)
                        {
                            
                            $scope.filterobj.semester = find_active_semester[0]  ;
                            //$scope.getSubjectList();
                            $scope.loadStudentByClass();
                        }

                        // var temp = {
                        //     id:'b',
                        //     name:'Both',
                        //     status:'i'
                        // }

                        // $scope.semesterlist.push(temp);
                        
                    
                    }
                    else{
                        $scope.semesterlist = [];
                        $scope.loadStudentByClass();
                    }
                });
             }
            catch(ex){}
        }

        $scope.toogleform = function()
        {
            $scope.is_form_toggle = !$scope.is_form_toggle;
        }

        $scope.getSubjectList = function()
        {
            try{
                if($scope.filterobj.class && $scope.filterobj.semester)
                {
                     var data ={
                        inputclassid:$scope.filterobj.class.id,
                        inputsemesterid:$scope.filterobj.semester.id,
                        inputsessionid:$scope.filterobj.session.id,
                    }
                    
                    $myUtils.httppostrequest('classreportsubjects',data).then(function(response){
                        if(response.length > 0 && response != null)
                        {
                            //$scope.subjectlist = response;
                             
                            $scope.filterobj.subjectid = response[0];
                           // $scope.GetEvulationHeader();
                           
                        }
                        else{
                            $scope.subjectlist = [];
                         
                        }
                    });
                }
            }
            catch(e){}
        }
        

        $scope.selectedSubject = function(subject,index)
        {
            $scope.filterobj.subjectid = subject;
            $scope.eprocessfinished = false;
            getQuizDetail();
        }

        $scope.changeclass = function()
        {
            //$scope.getSubjectList();
            
            $scope.active = 1;
            
           loadSections();
           //getSemesterData();
        }
        $scope.getStutdent = function()
        {
            $scope.loadStudentByClass();
            $scope.getGradedata();
        }
        //getSemesterData();


        
        $scope.finished = function()
        {
            $scope.processfinished = true;
            $scope.eprocessfinished = true;
        }
        // Generate PDF
        function buildTableBody(data,grade,obtain_marks,count_attendence,total_marks, columnsheader,columns) {
            
            try{
                var body = [];
                if(columnsheader.length > 0)
                {
                    body.push(columnsheader);
                }
                else{
                    var temp = [];

                    temp.push("Subject");
                    temp.push("Obtained Marks");
                    temp.push("Total Marks");
                    temp.push("Grade");
                    temp.push("Comments");
                    body.push(temp)
                }
                data.forEach(function(row) {
                    var dataRow = [];
                    
                    columns.forEach(function(column) {
                        var columnvalue = null;
                        if(column == 'subject')
                        {
                            columnvalue = row[column].toString();
                            
                            dataRow.push(columnvalue);
                        }
                        if(column == 'evalution')
                        {
                            columnvalue = row[column][0].mid;
                            dataRow.push(columnvalue);
                            columnvalue = row[column][0].total_marks;
                            dataRow.push(columnvalue);
                            columnvalue = row[column][0].grade;
                            dataRow.push(columnvalue);
                            columnvalue = "";
                            dataRow.push(columnvalue);
                        }

                    });

                    if(dataRow.length > 0)
                    {
                        body.push(dataRow);
                    }
                    
                });
                
                    var temp = [];

                    temp.push("Total Obtained Marks");
                    temp.push(obtain_marks);
                    temp.push(total_marks);
                    temp.push(grade);
                    temp.push("");
                    body.push(temp)
               
                return body;
            }
            catch(e){
                console.log(e)
            }
        }
        function table(data,grade,obtain_marks,count_attendence,total_marks, columnsheader, columns ) {
            try{
                return {
                    table: {
                        headerRows: 1,
                        widths: ['*', '*', '*', '*', '*'],
                        body: buildTableBody(data,grade,obtain_marks,count_attendence,total_marks,columnsheader,columns)
                    },
                    layout: {
                    fillColor: function (rowIndex, node, columnIndex) {

                            return (rowIndex % 2 === 0) ? '#f1f1f1' : null;
                        
                        
                    }
                }
                };
            }
            catch(e){
                console.log(e)
            }
            
        } 
        // End here 

        $scope.renderprintdata = function()
        {
            try{

                var docDefinition = {
                    pageOrientation: 'portrait',
                    content: [
                        {image:'<?php echo $logo ?>',style:'report_logo'},
                        {text:'Mid Term Exam Result',style:'report_header'},
                        {
                            margin: [0, 5, 0, 15],
                            columns: [
                               {
                                    width: '*',
                                    text: 'From: '+$scope.semester_dates,
                                    alignment: 'left',

                                },
                                 {
                                    width: '*',
                                    text: 'Term: '+$scope.filterobj.semester.name,
                                    alignment: 'left',
                                    margin: [100, 0, 0, 0],
                                },
                            ]
                        },
                        {
                            margin: [0, 5, 0, 15],
                            columns: [
                                 {
                                    width: '*',
                                    text: 'Session: '+$scope.session_date,
                                    alignment: 'left',
                                },
                                {
                                    width: '*',
                                    text: 'Date: <?php echo date('M d, Y') ?>',
                                    alignment: 'left',
                                    margin: [100, 0, 0, 0],
                                },
                            ]
                        },
                        {
                            margin: [0, 5, 0, 40],
                            columns: [
                               {
                                    width: '*',
                                    text: 'Student Name: '+$scope.filterobj.studentid.name,
                                    alignment: 'left',
                                },
                                 {
                                    width: '*',
                                    text: 'Grade: '+$scope.filterobj.class.name+" ("+$scope.filterobj.section.name+')',
                                    alignment: 'left',
                                    margin: [100, 0, 0, 0],
                                },
                            ]
                        },
                        
                        table($scope.subjectlist,$scope.grade,$scope.obtain_marks,$scope.count_attendence,$scope.total_marks,["Subject","Obtained Marks","Total Marks","Grade","Comments"],["subject","evalution"]),  
                        //table($scope.subjectlist,["Subject","Obtained Marks","Total Marks","Grade"],["subject","evalution",]),
                        {
                            margin: [0, 40, 0, 15],
                            columns: [
                               {
                                    width: '*',
                                    text: 'Attendance made: '+$scope.count_attendence+' ('+$scope.total_attendence+' %)',
                                    alignment: 'left',
                                },
                                 {
                                    width: '*',
                                    text: 'Out of a total: '+$scope.total_lesson,
                                    alignment: 'right',
                                },
                            ]
                        },
                        {
                            margin: [0, 12, 0, 15],
                            columns: [
                               {
                                    width: '*',
                                    text: 'Conduct: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',
                                    alignment: 'left',
                                },
                                 
                            ]
                        },
                        
                         {
                            margin: [0, 12, 0, 15],
                            columns: [
                               {
                                    width: '*',
                                    text: 'Attitudes: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',
                                    alignment: 'left',
                                },
                                 
                            ]
                        },
                        {
                            margin: [0, 12, 0, 15],
                            columns: [
                               {
                                    width: '*',
                                    text: 'Interest: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',
                                    alignment: 'left',
                                },
                                 
                            ]
                        },
                        {
                            margin: [0, 12, 0, 15],
                            columns: [
                               {
                                    width: '*',
                                    text: 'Director Remarks: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',
                                    alignment: 'left',
                                },
                                 
                            ]
                        },
                        {
                            margin: [0, 12, 0, 15],
                            columns: [
                               {
                                    width: '*',
                                    text: 'Principal Remarks: _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _',
                                    alignment: 'left',
                                },
                                 
                            ]
                        },                      

                   ],

                    styles: {
                        report_header: {
                            fontSize: 14,
                            bold: false,
                            alignment: 'center',
                            margin: [0, 10, 0, 40]
                        },
                        report_logo: {
                            alignment: 'center'
                        },
                        
                    }
                };
                return docDefinition;
            }
            catch(e){}
        }
        $scope.printreport = function()
        {
            var reportobj = $scope.renderprintdata();
         
            pdfMake.createPdf(reportobj).print();
        }

      $scope.download = function()
        {
            var reportobj = $scope.renderprintdata();
            if($scope.filterobj.semester.id == 'b')
            {
                var filename = decodeURIComponent($scope.filterobj.class.name)+"-"+decodeURIComponent($scope.filterobj.section.name)+"-final";
            }
            else{
                var filename = decodeURIComponent($scope.filterobj.class.name)+"-"+decodeURIComponent($scope.filterobj.section.name)+"-"+decodeURIComponent($scope.filterobj.semester.name)+"-"+decodeURIComponent($scope.filterobj.studentid.name);
            }
            
             pdfMake.createPdf(reportobj).download(filename);
        }


        
        function responseSuccess(response){
            return (response.data);
        }

        function responseFail(response){
            return (response.data);
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
                    inputclassid:$scope.filterobj.class.id,
                    inputsectionid:$scope.filterobj.section.id,
                    inputsemesterid:$scope.filterobj.semester.id,
                    inputsessionid:$scope.filterobj.session.id,
                    
                });
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>getstudentbyclass',(data)).then(function(response){

                //$myUtils.httprequest('<?php echo base_url(); ?>getstudentbyclass',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.studentlist = response;

                        var is_student_found = $filter('filter')(response,{id:studentid},true);
                        
                        if(is_student_found.length > 0)
                        {
                            studentid = false;
                            $scope.InputStudent = is_student_found[0];
                        }else{
                            $scope.InputStudent = response[0];

                        }
                        
                        $scope.loading = false;
                        //$scope.getGradedata();
                    }
                    else{
                        $scope.studentlist = [];
                        $scope.fallsemester = [];
                        $scope.springsemester = [];
                        message('','hide')
                    }
                })
                
            }
            catch(ex){
                console.log(ex)
            }
        }

        $scope.getGradedata = function()
        {
            try{
            

            var data ={
                inputclassid:$scope.filterobj.studentid.id,
                inputclassid:$scope.filterobj.class.id,
                inputsectionid:$scope.filterobj.section.id,
                inputsemesterid:$scope.filterobj.semester.id,
                inputsessionid:$scope.filterobj.session.id,
                inputstudentid:$scope.filterobj.studentid.id,
                school_id:$scope.school_id,
                
            }

            $myUtils.httppostrequest('<?php echo SHAMA_CORE_API_PATH; ?>midstudentreportdata',data).then(function(response){
                //console.log(response);
                if(response.length > 0)
                {
                    $scope.subjectlist = response[0].result;
                    $scope.grade = response[0].grade;
                    $scope.session_date = response[0].session_dates;
                    $scope.semester_dates = response[0].semester_dates;
                    $scope.obtain_marks = response[0].obtain_marks;
                    $scope.percent = response[0].percent;
                    $scope.total_marks = response[0].total_marks;
                    $scope.total_attendence = response[0].total_attendence;
                    $scope.total_lesson = response[0].total_lesson;
                    $scope.total_marks = response[0].total_marks;
                    $scope.count_attendence = response[0].count_attendence;
                     
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
  }

    
</script>

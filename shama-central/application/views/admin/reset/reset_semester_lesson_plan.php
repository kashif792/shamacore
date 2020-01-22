<?php 



// require_header 



require APPPATH.'views/__layout/header.php';







// require_top_navigation 



require APPPATH.'views/__layout/topbar.php';







// require_left_navigation 



require APPPATH.'views/__layout/leftnavigation.php';



?>
<div class="col-sm-10"  ng-controller="dataManagementCtrl">
<div id="stop_modal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p class="msg"> </p>

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                <button type="button" ng-click="resetCall()" class="btn btn-default " value="save">Yes</button>

            </div>

        </div>

    </div>

</div>

    <?php
        // require_footer
        require APPPATH.'views/__layout/filterlayout.php';
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <label>Data Management </label>
        </div>
        <div class="panel-body">
                <?php $attributes = array('name' => 'schedule_timetable', 'id' => 'schedule_timetable','class'=>'form-horizontal'); echo form_open('', $attributes);?>
                     <input type="hidden" name="serial" id="serial" ng-model="serial">
                     <fieldset>
                      
                        <div class="form-group">
                           
                            <div class="col-md-6">
                               <label><span class="icon-building-filled"></span> School <span class="required">*</span></label>
                                <select class="form-control" ng-options="item.name for item in schoollist track by item.id"  id="select_school" name="select_school" ng-model="select_school" ng-change="changeschool()"></select>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                           
                            <div class="col-md-6">
                               <label><span class="icon-wrench-circled"></span> Action <span class="required">*</span></label>
                                <select class="form-control"  id="action" name="action" ng-model="select_action" ng-change="changetarget()">
                                <option value="">Select</option>
                                <option value="dlp">Reset Default Lesson Plan</option>
                                <option value="slp">Reset Semester Lesson Plan</option>
                                <option value="cp">Reset Class Progress</option>
                                <option value="sp">Reset Student Progress</option>
                                </select>
                            
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                           
                            <div class="col-md-6">
                               <label><span class="icon-leaf"></span> Session <span class="required">*</span></label>
                                <select  class="form-control" ng-options="item.name for item in rsessionlist track by item.id"  name="inputRSession" id="inputRSession"  ng-model="filterobj.session" ></select>
                            
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                           
                            <div class="col-md-6">
                               <label><span class="icon-tag"></span> Semester <span class="required">*</span></label>
                                <select class="form-control"    ng-options="item.name for item in semesterlist track by item.id"  name="inputSemester" id="inputSemester"  ng-model="filterobj.semester" ></select>
                            
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group" >
                           
                            <div class="col-md-6">
                               <label><span class="icon-table"></span> Grade <span class="required">*</span></label>
                                <select class="form-control" ng-options="item.name for item in classlist track by item.id"  id="select_class" name="select_class" ng-model="select_class" ng-change="changeclass()">
                                    <option>Select Grade</option>
                                </select>
                            
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group studentlist" style="display: none;">
                           
                            <div class="col-md-6">
                               <label><span class="icon-user"></span> Student </label>
                                <select  class="form-control" ng-options="item.name for item in studentlist track by item.id"  name="InputStudent" id="InputStudent"  ng-model="filterobj.studentid" ng-change="changestudent()" >
                                    <option style="display:none" value="">Select</option>
                                </select>
                            
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="button" tabindex="8" class="btn btn-primary save"  id="save" ng-click="resetSemesterLessonPlan()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Confirm</button>
                               
                            </div>
                        </div>
                        
                    </fieldset>

                <?php echo form_close();?>
        
            </div>

    
</div>
</div>
<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>
<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script src="<?php echo  base_url(); ?>js/ui-bootstrap-tpls-2.5.0.js"></script>

<script>

    app.controller('dataManagementCtrl',['$scope','$myUtils','$http','$interval','$filter', dataManagementCtrl]);

    function dataManagementCtrl($scope, $myUtils,$http,$interval,$filter) {

        $scope.isPrincipal = false;
        $scope.isTeacher = false;
        $scope.isAdmin = false;
        $scope.day = [];
        $scope.data = [];
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

        $scope.serial = "<?php echo $this->uri->segment('2'); ?>";
        $scope.select_target="";
        $scope.editresponse = [];
        $scope.firsttimeload = false;
        $scope.requests = [];
        $scope.filterobj = {};
        $scope.filterobj.session = [];
        $scope.filterobj.semester = [];
        $scope.filterobj.studentid = [];
        //$scope.classlist = [];
        $scope.changetarget = function()
        {
            var target_val = $("#action").val();
            if(target_val=='sp')
            {
                $('.studentlist').show();
                $scope.loadStudentByClass();
            }
            else
            {
                $('.studentlist').hide();
            }
        }
        loadschool();
        function loadschool()
        {
            
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>schools',({})).then(function(response){
                    if(response != null && response.length > 0)
                    {
                        $scope.schoollist = response
                        $scope.select_school = response[0]
                        
                        getSessionList(response[0].id);
                        getSemesterData(response[0].id);
                        loadclass(response[0].id);
                        //$scope.loadStudentByClass();
                    }
                });
              
        }
        
        $scope.changeschool = function()
        {

            getSessionList($scope.select_school.id);
            getSemesterData($scope.select_school.id);
            loadclass($scope.select_school.id);
            
        }
        $scope.changeclass =function()
        {
            $scope.loadStudentByClass();
        }
        // Load Session 
        function getSessionList($school_id)
        {
            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>sessions',({school_id:$school_id})).then(function(response){
                if(response != null && response.length > 0)
                {
                    
                    $scope.rsessionlist = response
                    
                     var find_active_session = $filter('filter')(response,{status:'a'},true);


                    if(find_active_session.length > 0)
                    {
                        //console.log(find_active_session[0].name+" (Active)");
                        //$scope.filterobj.session = find_active_session[0].name+" (Active)";
                        $scope.filterobj.session = find_active_session[0];
                        
                    }
                }
                else{
                    //$scope.finished();
                }
            });
        }
        function getSemesterData($school_id)
        {
            try{
                $scope.semesterlist = []

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>semesters',({school_id:$school_id})).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.semesterlist = response;
                        var find_active_semester = $filter('filter')(response,{active_semster:'a'},true);
                        
                        if(find_active_semester.length > 0)
                        {
                            $scope.filterobj.semester = find_active_semester[0];
                        }

                    }
                    else{
                        $scope.semesterlist = [];
                    }
                });
             }
            catch(ex){}
        }
        function loadclass($school_id)
        {
                var data = ({school_id:$school_id})
                
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>classes',({school_id:$school_id})).then(function(response){
                    if(response != null && response.length > 0)
                    {
                        $scope.classlist = response

                        $scope.select_class = response[0]
                        if($scope.firsttimeload == true)
                        {
                            var found = $filter('filter')($scope.classlist, {id: $scope.schedule.class_id}, true);
                            if(found.length)
                            {
                                $scope.select_class = found[0];
                            }
                            
                        }
                        
                    }
                    $scope.loadStudentByClass();
                });
            
        }
        $scope.loadStudentByClass = function()
        {
            
            try{
                
                var data = ({   
                    class_id:$scope.select_class.id,
                    section_id:78,
                    semester_id:$scope.filterobj.semester.id,
                    session_id:$scope.filterobj.session.id,
                    school_id:$scope.select_school.id,
                });
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>students_by_class_and_section',(data)).then(function(response){
                if(response.length > 0 && response != null)
                    {
                        $scope.studentlist = response;

                        // var is_student_found = $filter('filter')(response,{id:studentid},true);
                        
                        // if(is_student_found.length > 0)
                        // {
                        //     studentid = false;
                        //     $scope.InputStudent = is_student_found[0];
                        // }else{
                        //     $scope.InputStudent = response[0];

                        // }
                        
                        $scope.loading = false;
                        
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
        $scope.resetSemesterLessonPlan = function()
        {

            if(!$scope.select_action){
                jQuery("#select_action").css("border", "1px solid red");
                message("Please select target",'show')
                return false;
            }
            else{
                jQuery("#select_action").css("border", "1px solid #C9C9C9");
            }

            var action = "";
            var action = "Are you sure you want to "+jQuery("#action option:selected").text();
            

            jQuery('.msg').replaceWith(action+" ?");
            $("#stop_modal").modal('show');

            
        }
        $scope.resetCall = function()
        {
            
            message("",'hide')
            $("#time_error").hide()
            
            var formdata = new FormData();
            formdata.append('school_id',$scope.select_school.id);
            formdata.append('action',$scope.select_action);
            formdata.append('session_id',$scope.filterobj.session.id);
            formdata.append('semester_id',$scope.filterobj.semester.id);
            formdata.append('class_id',$scope.select_class.id);
            formdata.append('user_id',$scope.user_id);
            formdata.append('student_id',$scope.filterobj.studentid.id);
            
            var request = {
                method: 'POST',
                url: "<?php echo SHAMA_CORE_API_PATH; ?>reset_data_management",
                data: formdata,
                headers: {'Content-Type': undefined}
            };

            $http(request)
                .success(function (response) {
                    
                    var $this = $(".save");
                    $this.button('reset');
                    if(response.message == true){
                        $("#stop_modal").modal('hide');
                        message('Action Successfully Performed','show');
                    }
                    
                })
                .error(function(){
                    var $this = $(".save");
                    $this.button('reset');
                    initmodules();
                    message('Something is wrong!','show')
                });
        }
        
        function httprequest(url,data)
          {
            var request = $http({
              method:'GET',
              url:url,
              params:data,
              headers : {'Accept' : 'application/json'}
            });
            return (request.then(responseSuccess,responseFail))
          }
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

      function responseSuccess(response){
        return (response.data);
      }

      function responseFail(response){
        return (response.data);
      }  
    }


</script>


<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10" ng-controller="promoteCtrl">
    <div id="delete_dialog" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this item?</p>
                 </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" id="save" class="btn btn-default " value="save">Yes</button>
                </div>
            </div>
        </div>
    </div>

	<?php
		// require_footer
		require APPPATH.'views/__layout/filterlayout.php';
	?>
	
    <div class="panel panel-default">
	  	<div class="panel-heading">Promote Student</div>
	  	<div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Promote Student</a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label for="email">Grade:</label>
                                            <select   ng-options="item.name for item in classlist track by item.id"  name="inputClass" id="inputClass"  ng-model="inputClass" ng-change="loadSections()">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Section:</label>
                                            <select   ng-options="item.name for item in sectionslist track by item.id"  name="inputSection" id="inputSection"  ng-model="inputSection" ng-change="loadStudentByClass()" >
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Semester:</label>
                                            <select   ng-options="item.name for item in semesterlist track by item.id"  name="inputSemester" id="inputSemester"  ng-model="inputSemester" ng-change="loadStudentByClass()" >
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Session:</label>
                                            <select   ng-options="item.name for item in sessionlist track by item.id"  name="inputSession" id="inputSession"  ng-model="inputSession" ng-change="loadStudentByClass()" >
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-7">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label for="email">Grade:</label>
                                            <select   ng-options="item.name for item in pclasslist track by item.id"  name="inputPClass" id="inputPClass"  ng-model="inputPClass" ng-change="loadPSections()">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Section:</label>
                                            <select   ng-options="item.name for item in psectionslist track by item.id"  name="inputPSection" id="inputPSection"  ng-model="inputPSection">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Semester:</label>
                                            <select   ng-options="item.name for item in psemesterlist track by item.id"  name="inputPSemester" id="inputPSemester"  ng-model="inputPSemester" >
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Session:</label>
                                            <select   ng-options="item.name for item in psessionlist track by item.id"  name="inputPSession" id="inputPSession"  ng-model="inputPSession" >
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" ng-click="promotestudent()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Promote</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-5">
                                    <select   ng-options="item.name for item in studentlist track by item.id" class="form-control" size="8"  name="from" id="multiselect"  ng-model="inputStudent" >
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <button type="button" id="multiselect_rightSelected" class="btn btn-block">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i></button>

                                    <button type="button" id="multiselect_rightAll" class="btn btn-block">
                                   <i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
                                    <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                                    <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>
                                </div>
                                <div class="col-xs-5">
                                    <select name="to" id="multiselect_to" class="form-control" size="8">
                                    </select>
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
<script src="<?php echo base_url(); ?>js/multiselect.js"></script>

<script>

    app.controller('promoteCtrl',['$scope','$myUtils', promoteCtrl]);

    function promoteCtrl($scope, $myUtils) {
	//app.controller('promote_ctrl', function($scope, $window, $http, $document, $timeout,$interval,$compile){
      	$('#multiselect').multiselect();
        

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

        /**
         * ---------------------------------------------------------
         *   load table
         * ---------------------------------------------------------
         */
        function loaddatatable()
        {
            $('#table-body-phase-tow').DataTable( {
                responsive: true,
                "order": [[ 0, "asc"  ]],
            });
        }

     	var urlist = {
            getsemesterlist:'<?php echo SHAMA_CORE_API_PATH; ?>semesters',
            classlist:'<?php echo SHAMA_CORE_API_PATH; ?>classes',
            getsectionbyclass:'<?php echo SHAMA_CORE_API_PATH; ?>sections_by_class',
            getstudentbyclass:'<?php echo SHAMA_CORE_API_PATH; ?>students_by_class_and_section',
            savepromotedstudents:'<?php echo SHAMA_CORE_API_PATH; ?>student_promote',
            getsessionlist:'<?php echo SHAMA_CORE_API_PATH; ?>sessions',
        }

        $scope.startdate = '<?php echo date('Y/m/d'); ?>';
        $scope.enddate = '<?php echo date('Y/m/d'); ?>';
        $scope.sid = '';

         angular.element(function () {
         	getClassList()
            getPClassList();

         });

        $scope.loadSession= function()
        {
                var data = ({
                    school_id:$scope.school_id
                })

            $myUtils.httprequest(urlist.getsessionlist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.sessionlist = response
                    $scope.inputSession = response[0]
                    $scope.loadStudentByClass();
                }
            });
        }

        $scope.loadPSession= function()
        {
                var data = ({
                    school_id:$scope.school_id
                })

            $myUtils.httprequest(urlist.getsessionlist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.psessionlist = response
                    $scope.inputPSession = response[0]
                }
            });
        }

        function getClassList()
        {

            var data = ({
                school_id:$scope.school_id
            })
        	$myUtils.httprequest(urlist.classlist,data).then(function(response){
        		if(response != null && response.length > 0)
        		{
        			$scope.classlist = response
        			$scope.inputClass = response[0]
        			$scope.loadSections()
        		}
        	});
        }

         function getPClassList()
        {
            var data = ({
                school_id:$scope.school_id
            })
            $myUtils.httprequest(urlist.classlist,data).then(function(response){
        		if(response != null && response.length > 0)
        		{
        			$scope.pclasslist = response
        			$scope.inputPClass = response[0]
        			$scope.loadPSections()
        		}
        	});
        }

     	$scope.loadSections= function()
        {
            try{
                $("#multiselect_to option").each(function() {
                    $(this).remove();
                });
                var data = ({class_id:$scope.inputClass.id, user_id:$scope.user_id})
                $myUtils.httprequest(urlist.getsectionbyclass,data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.inputSection = response[0];
                        $scope.sectionslist = response;
                        $scope.loadSemesters();
                    }
                    else{
                        $scope.sectionslist = [];
                        message('','hide')
                    }
                })
            }
            catch(ex){}
        }

        $scope.loadPSections= function()
        {
            try{
                var data = ({class_id:$scope.inputPClass.id, user_id:$scope.user_id})
                $myUtils.httprequest(urlist.getsectionbyclass,data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.inputPSection = response[0];
                        $scope.psectionslist = response;
                        $scope.loadPSemesters();
                    }
                    else{
                        $scope.psectionslist = [];
                        message('','hide')
                    }
                })
            }
            catch(ex){}
        }


        $scope.loadStudentByClass = function()
        {
    	 	try{
                var data = ({   class_id:$scope.inputClass.id,
                                section_id:$scope.inputSection.id,
                                semester_id:$scope.inputSemester.id,
                                session_id:$scope.inputSession.id,
                            })
                $myUtils.httprequest(urlist.getstudentbyclass,data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $("#multiselect_to option").each(function() {
                            $(this).remove();
                        });
                        $scope.inputStudent = response[0];
                        $scope.studentlist = response;
                    }
                    else{
                        $scope.studentlist = [];
                        message('','hide')
                    }
                })
            }
            catch(ex){
                console.log(ex)
            }
        }

        $scope.loadSemesters= function(){
			try{

                var data = ({school_id:$scope.school_id, user_id:$scope.user_id})
				$myUtils.httprequest(urlist.getsemesterlist,data).then(function(response){
					if(response.length > 0 && response != null)
					{
						$scope.semesterlist = response;
                        var found = false;
						for (var i = 0; i < response.length; i++) {
                            if(response[i].status == 'a')
                            {
                                 $scope.inputSemester = response[i];
                                 found = true;
                            }
                        }

                        if(!found){
                            $scope.inputSemester = response[0];
                        }

                        $scope.loadSession();

					}
					else{
						$scope.semesterlist = [];
					}
				})
			}
			catch(ex){}
		}


        $scope.loadPSemesters= function(){
            try{

                var data = ({school_id:$scope.school_id, user_id:$scope.user_id})
                $myUtils.httprequest(urlist.getsemesterlist,data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.psemesterlist = response;

                        var found = false;
                        for (var i = 0; i < response.length; i++) {
                            if(response[i].status == 'a')
                            {
                                 $scope.inputPSemester = response[i];
                                 found = true;
                            }
                        }

                        if(!found){
                            $scope.inputPSemester = response[0];
                        }

                        $scope.loadPSession();

                    }
                    else{
                        $scope.psemesterlist = [];
                    }
                })
            }
            catch(ex){}
        }

		$scope.promotestudent = function()
		{
			var promoteddata = []
			var x = document.getElementById("multiselect_to");
			var promotedstudentlength =  x.options.length;
            var $this = $(".btn-primary");
            $this.button('loading');

            if(promotedstudentlength == null)
            {
                message('No student selected','show')
                $this.button('reset');
                return false;
            }

            if(promotedstudentlength > 0 && $scope.inputClass.id == $scope.inputPClass.id &&
                $scope.inputSection.id == $scope.inputPSection.id && $scope.inputSemester.id ==
                $scope.inputPSemester.id && $scope.inputSession.id == $scope.inputPSession.id
            )
            {
                message('Cannot promote student in same class','show')
                $this.button('reset');
                return false;
            }

            if(promotedstudentlength > 0 && $scope.inputClass.id == $scope.inputPClass.id &&
                $scope.inputSection.id == $scope.inputPSection.id && $scope.inputSemester.id ==
                $scope.inputPSemester.id && $scope.inputSession.id != $scope.inputPSession.id
            )
            {
                message('Cannot promote student','show')
                $this.button('reset');
                return false;
            }

            // if($scope.inputClass.id == $scope.inputPClass.id &&
            //     $scope.inputSection.id == $scope.inputPSection.id && $scope.inputSemester.id ==
            //     $scope.inputPSemester.id )
            // {
            //     message('Cannot promote student in same class semester','show')
            //     $this.button('reset');
            //     return false;
            // }

            var currentsessions = new Date($scope.inputSession.from)
            var currentsessione = new Date($scope.inputSession.to)

            var promotesessions = new Date($scope.inputPSession.from)
            var promotesessione = new Date($scope.inputPSession.to)

            if(promotedstudentlength > 0 && $scope.inputClass.id != $scope.inputPClass.id &&
                $scope.inputSection.id == $scope.inputPSection.id && $scope.inputSemester.id ==
                $scope.inputPSemester.id &&
                (currentsessions.getFullYear() >= promotesessions.getFullYear())
            )
            {
                message('Cannot promote student to previous or current session','show')
                $this.button('reset');
                return false;
            }

            if(promotedstudentlength > 0 && $scope.inputClass.id != $scope.inputPClass.id &&
                $scope.inputSection.id == $scope.inputPSection.id && $scope.inputSemester.id ==
                $scope.inputPSemester.id &&
                ((parseInt(currentsessions.getFullYear()) - parseInt(promotesessions.getFullYear())) != 1)
            )
            {
                message('Cannot promote student','show')
                $this.button('reset');
                return false;
            }

            //&& $scope.inputClass.id != $scope.inputPClass.id &&
            //$scope.inputSection.id != $scope.inputPSection.id && $scope.inputSemester.id !=
            //$scope.inputPSemester.id && $scope.inputSession.id != $scope.inputPSession.id

            if(promotedstudentlength > 0 )
			{
				for (var i = 0; i < promotedstudentlength; i++) {
	              	var temp = {}
	              	temp.id = x.options[i].value;
	              	promoteddata.push(temp)
		      	}

		      	$myUtils.httppostrequest(urlist.savepromotedstudents,({
      								data:promoteddata,
      								old_class_id:$scope.inputClass.id,
      								old_section_id:$scope.inputSection.id,
                                    old_semester_id:$scope.inputSemester.id,
      								old_session_id:$scope.inputSession.id,
      								new_class_id:$scope.inputPClass.id,
      								new_section_id:$scope.inputPSection.id,
                                    new_semester_id:$scope.inputPSemester.id,
      								new_session_id:$scope.inputPSession.id,
      							})).then(function(response){
		      		if(response != null && response.message == true)
		      		{
		      			message('Student promoted successfully','show')
		      			$("#multiselect_to option").each(function() {
						    $(this).remove();
						});
                        $this.button('reset');
		      		}
		      		else{
                        $this.button('reset');
		      			message('Student not promoted','show')
		      		}
		      	});
			}else{
                $this.button('reset');
                message('Cannot promote student to same class stander','show')
            }
		}

	}



</script>

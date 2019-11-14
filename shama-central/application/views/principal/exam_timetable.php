<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10" >

	<?php
		// require_footer
		require APPPATH.'views/__layout/filterlayout.php';
	?>


	<div class="panel panel-default" ng-controller="ttCtrl">
		<div class="panel-heading">
			<label>Add Schedule </label>
		</div>
		<div class="panel-body">
          		<?php $attributes = array('name' => 'schedule_timetable', 'id' => 'schedule_timetable','class'=>'form-horizontal'); echo form_open('', $attributes);?>
	               	<input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial" ng-model="serial">
                	<fieldset>
	                	<div class="form-group">
	                		<div class="col-sm-12">
	                			<label><span class="icon-user"></span> Grade <span class="required">*</span></label>
	                		</div>
	                		<div class="col-sm-6">
								<select class="form-control" ng-options="item.name for item in classlist track by item.id"  id="select_class" name="select_class" ng-model="select_class" ng-change="changeclass()"></select>
	                		</div>
	                	</div>
	                	<div class="form-group ">
	                		<div class="col-sm-12">
	                			<label><span class="icon-user"></span> Section <span class="required">*</span></label>
	                		</div>
	                		<div class="col-sm-6">
	                			
	                	            <select class="form-control"  ng-options="item.name for item in sectionslist track by item.id"  name="inputSection" id="inputSection" ng-change="checksche()"  ng-model="inputSection" >
	                				</select>
	                		</div>
	                	</div>
	                    <div class="form-group">
	                		<div class="col-sm-12">
	                			<label><span class="icon-phone"></span> Subject<span class="required">*</span></label>
	                		</div>
	                		<div class="col-sm-6">
                				<select class="form-control" ng-options="item.name for item in subjectlist track by item.id" name="select_subject" id="select_subject" ng-change="checksche()" ng-model="inputSubject"></select>
	                		</div>
	                     </div>

	                
	                	<div class="form-group ">
	                		<div class="col-sm-12">
	                			<label><span class="icon-user"></span> Teacher <span class="required">*</span></label>
	                		</div>
	                		<div class="col-sm-6">
	                				<select class="form-control" ng-options="item.screen_name for item in teacherlist track by item.id" name="select_teacher" id="select_teacher" ng-change="chkteachersche();" ng-model="select_teacher"></select>

	                		</div>
	                	</div>
	                		<div class="form-group ">
	                		<div class="col-sm-12">
	                			<label><span class="icon-clock"></span> From <span class="required">*</span></label>
	                		</div>
	                		<div class="col-sm-6">
								<input type="text" class="form-control" id="inputStartTime" name="inputFrom" ng-model="inputStartTime"  placeholder="Start Time"  tabindex="1" value="" required>
							</div>	
	                		<div class="col-sm-6">
	                			<input type="text" class="form-control" id="inputEndTime" name="inputTo" ng-model="inputEndTime"  placeholder="End Time"  tabindex="1" value="" required>
	                		</div>	
		                		<div id="time_error" class="required row endtimeerror">End time must be greater then start time</div>
	                		</div>
	                	
	                	<div class="form-group">
	                		<div class="col-sm-12">
	                			<button type="button" tabindex="8" class="btn btn-primary"  id="save" ng-click="savetimetable()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
	                			<a tabindex="9" href="<?php echo $path_url; ?>show_timtbl_list" tabindex="6" title="cancel">Cancel</a>
	                		</div>
	                	</div>
	                </fieldset>
	            <?php echo form_close();?>
			</div>
	</div>
</div>



	<script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.timepicker.js?v=0.3.3"></script>


<script>

    app.controller('ttCtrl',['$scope','$myUtils','$filter','$interval', ttCtrl]);

    function ttCtrl($scope, $myUtils, $filter, $interval) {

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

		
		var urlist = {
            getclasslist:'<?php echo SHAMA_CORE_API_PATH; ?>classes',
            getscheduledetail:'<?php echo SHAMA_CORE_API_PATH; ?>schedule',
            saveschedule:'<?php echo SHAMA_CORE_API_PATH; ?>schedule',
            getsectionlistbyclass:'<?php echo SHAMA_CORE_API_PATH; ?>sections_by_class',
            getsubjectlistbyclass:'<?php echo SHAMA_CORE_API_PATH; ?>subjects_by_class',
            getteacherlist:'<?php echo SHAMA_CORE_API_PATH; ?>teachers',
        }

        $scope.serial = "<?php echo $this->uri->segment('2'); ?>";
        
        $scope.select_class="";
        $scope.inputSection="";
        $scope.inputSubject="";
        $scope.select_teacher="";
        $scope.schedule = [];
        $scope.firsttimeload = false;
		angular.element(function(){
			if($scope.serial == '')
			{
				initmodules();
			}

			else if($scope.serial != '')
			{
				$scope.firsttimeload = true;

				getScheduleDetail();
				
				
				
				//document.getElementById("save").disabled = false;
			}
		});

		function initmodules()
		{
			loadclass()
			loadteacherlist();
			if($scope.serial == ''){
				$scope.inputStartTime = '<?php if(isset($result)){echo date('H:i',strtotime($result['start_time']));}else{ $seconds = time(); $rounded_seconds = round($seconds / (15 * 60)) * (15 * 60); echo date('H:i', $rounded_seconds); } ?>'
				$scope.inputEndTime = '<?php if(isset($result)){echo date('H:i',strtotime($result['end_time']));}else{ $seconds = time(); $rounded_seconds = round($seconds / (15 * 60)) * (15 * 60); echo date('H:i', $rounded_seconds + 900); } ?>'
			}
		}

		function getScheduleDetail() {
			try{
			 	
			   var data = ({id:$scope.serial})
			   $myUtils.httprequest(urlist.getscheduledetail,data).then(function(response){
				   if(response != null)
				   {
			   		 	$scope.schedule = response;
					  	
					  	$scope.inputStartTime = response.start_time;
					  	$scope.inputEndTime = response.end_time;
					  	loadclass()
					  	loadteacherlist();
				   }
				   else{

				   }
			   })
		   }
		   catch(ex){}
		}

		function loadclass()
        {
        	if($scope.classlist != null && $scope.classlist.length > 0 && $scope.firsttimeload == false)
        	{
        		 $scope.select_class = $scope.classlist[0];
        		 loadSections();
        	}

        	if($scope.classlist == null)
        	{

    			var data = ({school_id:$scope.school_id})
    			
        		$myUtils.httprequest(urlist.getclasslist,data).then(function(response){
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
	                    loadSections();
	                }
	            });
        	}
        }

        $scope.changeclass = function()
        {
        	loadSections();
        }


        $scope.savetimetable = function()
        {
    	 	var subj_name = $("#select_subject").val();
            var section = $("#inputSection").val();

            var starttime = $("#inputStartTime").val();
            var endtime = $("#inputEndTime").val();
            message("",'hide')
            $("#time_error").hide()


 			if(!$scope.select_class){
                jQuery("#select_class").css("border", "1px solid red");
                message("Please select grade",'show')
                return false;
            }
            else{
                jQuery("#inputSection").css("border", "1px solid #C9C9C9");
            }

             if(!$scope.inputSection){
                jQuery("#inputSection").css("border", "1px solid red");
                message("Please select section",'show');
                return false;
            }
            else{
                jQuery("#inputSection").css("border", "1px solid #C9C9C9");
            }

             if(!$scope.inputSubject){
                jQuery("#select_subject").css("border", "1px solid red");
                message("Please select subject",'show')
                return false;
            }
            else{
                jQuery("#select_subject").css("border", "1px solid #C9C9C9");
            }

 				if(!$scope.select_teacher){
                jQuery("#select_teacher").css("border", "1px solid red");
                message("Please select teacher",'show')
                return false;
            }
            else{
                jQuery("#select_subject").css("border", "1px solid #C9C9C9");
            }
            var reg = /(\d|2[0-3]):([0-5]\d)/;

            if(reg.test(starttime) == false){
                jQuery("#inputStartTime").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputStartTime").css("border", "1px solid #C9C9C9");
            }

            if(reg.test(endtime) == false){
                jQuery("#inputEndTime").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputEndTime").css("border", "1px solid #C9C9C9");
            }





           	var t = new Date();
			d = t.getDate();
			m = t.getMonth() + 1;
			y = t.getFullYear();

			var d1 = new Date(m + "/" + d + "/" + y + " " + starttime);
			var d2 = new Date(m + "/" + d + "/" + y + " " + endtime);
			var t1 = d1.getTime();
			var t2 = d2.getTime();

			if(t2 <= t1)
			{
				$("#time_error").show()
				return false;
			}

			 var $this = $(".btn-primary");
             $this.button('loading');

         	var formdata = new FormData();
			formdata.append('select_subject',$scope.inputSubject.id);
			formdata.append('select_class',$scope.select_class.id);
			formdata.append('inputSection',$scope.inputSection.id);
			formdata.append('select_teacher',$scope.select_teacher.id);
			formdata.append('inputFrom',$scope.inputStartTime);
			formdata.append('inputTo',$scope.inputEndTime);
			formdata.append('serial',$scope.serial);

			var data = {

					subject_id:$scope.inputSubject.id,
					class_id:$scope.select_class.id,
					section_id:$scope.inputSection.id,
					teacher_id:$scope.select_teacher.id,
					start_time:$scope.inputStartTime,
					end_time:$scope.inputEndTime,
					school_id:$scope.school_id,
					id:$scope.serial
					}

			$myUtils.httppostrequest(urlist.saveschedule,data).then(function(response){

                    var $this = $(".btn-primary");
                    $this.button('reset');
                    if(response.message == true){
           				message('Schedule added','show');
						window.location.href = "<?php echo $path_url;?>show_timtbl_list";
           	    	}else{
	                    var $this = $(".btn-primary");
	                    $this.button('reset');
						initmodules();
           				message('Schedule data not saved','show')
           	    	}
                })
        }


			$(document).ready(function() {
		   $('#inputStartTime').timepicker({
		       showLeadingZero: false,
		       onSelect: tpStartSelect,
		       onClose:checkTeacherSchedule,
		        showNowButton: false,
		        nowButtonText: 'Now',

			    minutes: {
			        starts: 0,                // First displayed minute
			        ends: 59,                 // Last displayed minute
			        interval: 5,              // Interval of displayed minutes
			        manual: []                // Optional extra entries for minutes
			    },
				onMinuteShow: OnMinuteSShowCallback,
		         onHourShow: OnHourShowCallback,
		        defaultTime:'<?php if(isset($result)){echo date('H:i',strtotime($result['start_time']));} ?>'

		   });
		   $('#inputEndTime').timepicker({
		       showLeadingZero: false,
		       onSelect: tpEndSelect,
		       onClose:checkTeacherSchedule,
		        showNowButton: false,
		        nowButtonText: 'Now',

			    minutes: {
			        starts: 0,                // First displayed minute
			        ends: 59,                 // Last displayed minute
			        interval: 5,              // Interval of displayed minutes
			        manual: []                // Optional extra entries for minutes
			    },
				onMinuteShow: OnMinuteShowCallback,
		        onHourShow: OnHourEShowCallback,
		        defaultTime:'<?php if(isset($result)){echo date('H:i',strtotime($result['end_time']));} ?>'

		   });
		});

		// when start time change, update minimum for end timepicker
		function tpStartSelect( time, endTimePickerInst ) {

		   $('#inputEndTime').timepicker('option', {
		       minTime: {
		           hour: endTimePickerInst.hours,
		           minute: endTimePickerInst.minutes
		       }
		   });
		}

		function OnHourShowCallback(hour) {
		    if ((hour > 18) || (hour < 7)) {
		        return false; // not valid
		    }
		    return true; // valid
		}

		function OnHourEShowCallback(hour) {
			var starhour = $('#inputStartTime').timepicker('getHour');
		    if ((hour < starhour)) {
		        return false; // not valid
		    }
		    return true; // valid
		}



		function OnMinuteShowCallback(hour, minute) {
			var starttime = $('#inputStartTime').timepicker('getMinute');
			var starhour = $('#inputStartTime').timepicker('getHour');
			if( (hour >= starhour) && (minute > starttime)){ return true;}

			if( (hour == starhour) && (starttime <= minute)){ return false;}
		    return true;  // valid
		}

		function OnMinuteSShowCallback(hour, minute) {

		    return true;  // valid
		}



		// when end time change, update maximum for start timepicker
		function tpEndSelect( time, startTimePickerInst ) {
			var starttime = $('#inputStartTime').timepicker('getMinute');
			var starhour = $('#inputStartTime').timepicker('getHour');

			$('#inputStartTime').timepicker('option', {
		       maxTime: {
		           hour: startTimePickerInst.hours,
		           minute: startTimePickerInst.minutes
		       }
		   });
		}

	$scope.is_valid_class = true
	$scope.is_valid_schedule = false

	angular.element(function(){
		if($scope.serial == '')
		{
			setTimerForWidget('section',1)
		}else{
			loadSections()
		}
	})
	$scope.select_class = $scope.ini;
	function setTimerForWidget(crname,ctime)
    {

       $scope.ptime = 0;
      reporttimer = $interval(function(){
        if($scope.ptime < parseInt(ctime))
        {
          $scope.ptime++
        }
        else{
          if(crname == 'section'){
            loadSections()
          }
          $interval.cancel(reporttimer)

      }
    },500)
      }


      function getSubjectList()
      {
      	try{
			var data = ({class_id:$scope.select_class.id,session_id:$scope.session_id})
			$scope.subjectlist = []
			$myUtils.httprequest(urlist.getsubjectlistbyclass,data).then(function(response){
				if(response.length > 0 && response != null)
				{
					$scope.inputSubject = response[0];
					$scope.subjectlist = response;
					if($scope.firsttimeload == true)
                    {
		   		 		var found = $filter('filter')($scope.subjectlist, {id: $scope.schedule.subject_id}, true);
                    	if(found.length)
                    	{
                    		$scope.inputSubject = found[0];
                    	}
                    	$scope.firsttimeload = false;
                	}
				}
				else{
					$scope.subjectlist = [];
				}
			})
			
		}
		catch(ex){console.log(ex)}
      }

		function loadSections()
		{

			try{
				var data = ({class_id:$scope.select_class.id,user_id:$scope.user_id})
				$scope.sectionslist = []
				$myUtils.httprequest(urlist.getsectionlistbyclass,data).then(function(response){
					
					getSubjectList()

					if(response.length > 0 && response != null)
					{
						$scope.inputSection = response[0];
						$scope.sectionslist = response;
						if($scope.firsttimeload == true)
	                    {
			   		 		var found = $filter('filter')($scope.sectionslist, {id: $scope.schedule.section_id}, true);
	                    	if(found.length)
	                    	{
	                    		$scope.inputSection = found[0];
	                    	}
	                    	
                    	}
					}
					else{
						$scope.sectionslist = [];
					}

				})

			}
			catch(ex){}
		}

		function loadteacherlist()
		{
			try{
				if($scope.teacherlist != null && $scope.teacherlist.length > 0)
				{
					$scope.select_teacher = $scope.teacherlist[0];
				}

				if($scope.teacherlist == null)
				{
					var data = ({school_id:$scope.school_id})

					$myUtils.httprequest(urlist.getteacherlist,data).then(function(response){
						if(response != null)
						{
							$scope.teacherlist = response;
							$scope.select_teacher = response[0];
							if($scope.firsttimeload == true)
		                    {
				   		 		var found = $filter('filter')($scope.teacherlist, {id: $scope.schedule.teacher_id}, true);
		                    	if(found.length)
		                    	{
		                    		$scope.select_teacher = found[0];
		                    	}
		                    	
		                	}
						
						}else{
							$scope.teacherlist = [];
						}

					});
				}
			}
			catch(ex){}
		}

		function checkClass()
		{
			try{
				
				if($scope.altersection == false && $scope.serial != '')
				{
					return false;
				}

				var data = ({
							class_id:$scope.select_class.id,
							section_id:$scope.inputSection.id,
							subject_id:$scope.inputSubject.id
						})

				$myUtils.httprequest('<?php echo base_url(); ?>checkschedule',data).then(function(response){
					if(response != null && response.message == true)
					{
						$scope.is_valid_class = false
						message("Already subject allocated",'show')
					}else{
						$scope.is_valid_class = true
						message("",'hide')
						checkTeacherSchedule();
					}

					if($scope.is_valid_class == true && $scope.is_valid_schedule == true)
					{
					//	document.getElementById("save").disabled = false;
					}
					else
					{
						//document.getElementById("save").disabled = true;
					}
				})
			}
			catch(ex){}
		}

		$scope.isteacheraltered = false
		$scope.chkteachersch = function()
		{
			$scope.isteacheraltered = true
			
			//checkClass();
			//checkTeacherSchedule()
		}



		function checkTeacherSchedule()
		{
			try{
				//document.getElementById("save").disabled = true;

				if($scope.isteacheraltered == false && $scope.serial == '')
				{
					return false
				}

				if($("#inputEndTime").val().length > 0 && $("#inputStartTime").val().length > 0 ){
					var data = ({
						teacher_id:$("#select_teacher").val(),
						start_time:$("#inputStartTime").val(),
						end_time:$("#inputEndTime").val(),
						serial:$("#serial").val(),
						subject:$("#select_subject").val(),
					})

					$myUtils.httprequest('<?php echo $path_url; ?>checkteacherschedule',data).then(function(response){
						if(response != null && response.message == true)
						{
							$scope.is_valid_schedule = false
							message("Schedule already allocated to this teacher",'show')
						}
						else{
							$scope.is_valid_schedule = true
							message("",'hide')
						}

						if($scope.is_valid_class == true && $scope.is_valid_schedule == true)
						{
							//document.getElementById("save").disabled = false;
						}
						else
						{
							//document.getElementById("save").disabled = true;
						}
					})
				}
			}
			catch(ex){}
		}

		$scope.altersection = false
		$scope.checksch = function()
		{
			$scope.altersection = true
			//checkClass()
		}

	}

</script>

<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>

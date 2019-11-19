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
	                		<!-- <div class="form-group ">
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
	                	 -->
	                	 <div class="form-group">
	                		<div class="col-md-12">
	                			<table  class="table table-striped table-bordered row-border hover">
	                				<thead>
                                        <tr>
                                            <th>Active</th>
                                            <th>Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                    		<td>
                                    			<input type="checkbox" name="mon_status" id="mon_status" ng-checked="monstatus == 'Active'" value="Active"></td>
                                    		<td>Monday</td>
                                    		<td><input type="text" class="form-control scheduletimepicker mon_start_time" <?php if($result['mon_status']=="Inactive") {echo 'disabled="disabled"';} ?>  autocomplete="off"  name="inputFrom" ng-model="monstarttime" placeholder="Start Time" required></td>
                                    		<td><input type="text" class="form-control scheduletimepicker mon_end_time" <?php if($result['mon_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputTo"  ng-model="monendtime"  placeholder="End Time"  tabindex="1" required></td>
                                    	</tr>
                                    	<tr>
                                    		<td><input type="checkbox" name="tue_status" id="tue_status" ng-checked="tuestatus == 'Active'" value="Active"></td>
                                    		<td>Tuesday</td>
                                    		<td><input type="text" class="form-control scheduletimepicker tue_start_time" <?php if($result['tue_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputFrom" ng-model="tuestarttime" placeholder="Start Time" required></td>
                                    		<td><input type="text" class="form-control scheduletimepicker tue_end_time" <?php if($result['tue_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputTo"  ng-model="tueendtime"  placeholder="End Time"  tabindex="1" required></td>
                                    	</tr>
                                    	<tr>
                                    		<td><input type="checkbox" name="wed_status" id="wed_status" ng-checked="wedstatus == 'Active'" value="Active"></td>
                                    		<td>Wednesday</td>
                                    		<td><input type="text" class="form-control scheduletimepicker wed_start_time" <?php if($result['wed_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputFrom" ng-model="wedstarttime" placeholder="Start Time" required></td>
                                    		<td><input type="text" class="form-control scheduletimepicker wed_end_time" <?php if($result['wed_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputTo"  ng-model="wedendtime"  placeholder="End Time"  tabindex="1" required></td>
                                    	</tr>
                                    	<tr>
                                    		<td><input type="checkbox" name="thu_status" id="thu_status" ng-checked="thustatus == 'Active'" value="Active"></td>
                                    		<td>Thursday</td>
                                    		<td><input type="text" class="form-control scheduletimepicker thu_start_time" <?php if($result['thu_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputFrom" ng-model="thustarttime" placeholder="Start Time" required></td>
                                    		<td><input type="text" class="form-control scheduletimepicker thu_end_time" <?php if($result['thu_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputTo"  ng-model="thuendtime"  placeholder="End Time"  tabindex="1" required></td>
                                    	</tr>
                                    	<tr>
                                    		<td><input type="checkbox" name="fri_status" id="fri_status" ng-checked="fristatus == 'Active'" value="Active" ></td>
                                    		<td>Friday</td>
                                    		<td><input type="text" class="form-control scheduletimepicker fri_start_time" <?php if($result['fri_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputFrom" ng-model="fristarttime" placeholder="Start Time" required></td>
                                    		<td><input type="text" class="form-control scheduletimepicker fri_end_time" <?php if($result['fri_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputTo"  ng-model="friendtime"  placeholder="End Time"  tabindex="1" required></td>
                                    	</tr>
                                    	<tr>
                                    		<td><input type="checkbox" name="sat_status" id="sat_status" ng-checked="satstatus == 'Active'" value="Active"></td>
                                    		<td>Saturday</td>
                                    		<td><input type="text" class="form-control scheduletimepicker sat_start_time" <?php if($result['sat_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputFrom" ng-model="satstarttime" placeholder="Start Time" required></td>
                                    		<td><input type="text" class="form-control scheduletimepicker sat_end_time" <?php if($result['sat_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputTo"  ng-model="satendtime"  placeholder="End Time"  tabindex="1" required></td>
                                    	</tr>
                                    	<tr>
                                    		<td><input type="checkbox" name="sun_status" id="sun_status" ng-checked="sunstatus == 'Active'" value="Active"></td>
                                    		<td>Sunday</td>
                                    		<td><input type="text" class="form-control scheduletimepicker sun_start_time" <?php if($result['sun_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputFrom" ng-model="sunstarttime" placeholder="Start Time" required></td>
                                    		<td><input type="text" class="form-control scheduletimepicker sun_end_time" <?php if($result['sun_status']=="Inactive") {echo 'disabled="disabled"';} ?> autocomplete="off"  name="inputTo"  ng-model="sunendtime"  placeholder="End Time"  tabindex="1" required></td>
                                    	</tr>
                                    </tbody>
	                			</table>
	                		</div>
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
			loadStatus();
		}
		function loadStatus()
		{
			
			$scope.monstatus = "Active";
			$scope.tuestatus = "Active";
			$scope.wedstatus = "Active";
			$scope.thustatus = "Active";
			$scope.fristatus = "Active";

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
					  	// Day wise timing
					  	$scope.monstatus = response.mon_status;
					  	$scope.monstarttime = response.mon_start_time;
					  	$scope.monendtime = response.mon_end_time;
					  	$scope.tuestatus = response.tue_status;
					  	$scope.tuestarttime = response.tue_start_time;
					  	$scope.tueendtime = response.tue_end_time;
					  	$scope.wedstatus = response.wed_status;
					  	$scope.wedstarttime = response.wed_start_time;
					  	$scope.wedendtime = response.wed_end_time;
					  	$scope.thustatus = response.thu_status;
					  	$scope.thustarttime = response.thu_start_time;
					  	$scope.thuendtime = response.thu_end_time;
					  	$scope.fristatus = response.fri_status;
					  	$scope.fristarttime = response.fri_start_time;
						$scope.friendtime = response.fri_end_time;
					  	$scope.satstatus = response.sat_status;
					  	$scope.satstarttime = response.sat_start_time;
					  	$scope.satendtime = response.sat_end_time;
					  	$scope.sunstatus = response.sun_status;
					  	$scope.sunstarttime = response.sun_start_time;
					  	$scope.sunendtime = response.sun_end_time;
					  	// End
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

        $('.scheduletimepicker').timepicker({
               showLeadingZero: false,
               onSelect: tpStartSelect,
               
                showNowButton: false,
                nowBuscheduletimepickerttonText: 'Now',
                minutes: {
                    starts: 0,                // First displayed minute
                    ends: 59,                 // Last displayed minute
                    interval: 5,              // Interval of displayed minutes
                    manual: []                // Optional extra entries for minutes
                },
                
                

           });

        $scope.savetimetable = function()
        {
    	 	var subj_name = $("#select_subject").val();
            var section = $("#inputSection").val();

            var mon_status = $('input[name="mon_status"]:checked').val();
            
            var mon_start_time = $(".mon_start_time").val();
            var mon_end_time = $(".mon_end_time").val();
            var tue_status = $('input[name="tue_status"]:checked').val();
            var tue_start_time = $(".tue_start_time").val();
            var tue_end_time = $(".tue_end_time").val();
            var wed_status = $('input[name="wed_status"]:checked').val();
            var wed_start_time = $(".wed_start_time").val();
            var wed_end_time = $(".wed_end_time").val();
            var thu_status = $('input[name="thu_status"]:checked').val();
            var thu_start_time = $(".thu_start_time").val();
            var thu_end_time = $(".thu_end_time").val();
            var fri_status = $('input[name="fri_status"]:checked').val();
            var fri_start_time = $(".fri_start_time").val();
            var fri_end_time = $(".fri_end_time").val();
            var sat_status = $('input[name="sat_status"]:checked').val();
            var sat_start_time = $(".sat_start_time").val();
            var sat_end_time = $(".sat_end_time").val();
            var sun_status = $('input[name="sun_status"]:checked').val();
            var sun_start_time = $(".sun_start_time").val();
            var sun_end_time = $(".sun_end_time").val();
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




   //         	var t = new Date();
			// d = t.getDate();
			// m = t.getMonth() + 1;
			// y = t.getFullYear();

			// var d1 = new Date(m + "/" + d + "/" + y + " " + starttime);
			// var d2 = new Date(m + "/" + d + "/" + y + " " + endtime);
			// var t1 = d1.getTime();
			// var t2 = d2.getTime();

			// if(t2 <= t1)
			// {
			// 	$("#time_error").show()
			// 	return false;
			// }

			 var $this = $(".btn-primary");
             $this.button('loading');

         	var formdata = new FormData();
			formdata.append('select_subject',$scope.inputSubject.id);
			formdata.append('select_class',$scope.select_class.id);
			formdata.append('inputSection',$scope.inputSection.id);
			formdata.append('select_teacher',$scope.select_teacher.id);
			// formdata.append('inputFrom',$scope.inputStartitme);
			// formdata.append('inputTo',$scope.InputEndTime);
			formdata.append('serial',$scope.serial);
			// Timing add
			formdata.append('mon_status',mon_status);
			formdata.append('mon_start_time',mon_start_time);
			formdata.append('mon_end_time',mon_end_time);
			formdata.append('tue_status',tue_status);
			formdata.append('tue_start_time',tue_start_time);
			formdata.append('tue_end_time',tue_end_time);
			formdata.append('wed_status',wed_status);
			formdata.append('wed_start_time',wed_start_time);
			formdata.append('wed_end_time',wed_end_time);
			formdata.append('thu_status',thu_status);
			formdata.append('thu_start_time',thu_start_time);
			formdata.append('thu_end_time',thu_end_time);
			formdata.append('fri_status',fri_status);
			formdata.append('fri_start_time',fri_start_time);
			formdata.append('fri_end_time',fri_end_time);
			formdata.append('sat_status',sat_status);
			formdata.append('sat_start_time',sat_start_time);
			formdata.append('sat_end_time',sat_end_time);
			formdata.append('sun_status',sun_status);
			formdata.append('sun_start_time',sun_start_time);
			formdata.append('sun_end_time',sun_end_time);
			formdata.append('serial',$scope.serial);

			var data = {

					subject_id:$scope.inputSubject.id,
					class_id:$scope.select_class.id,
					section_id:$scope.inputSection.id,
					teacher_id:$scope.select_teacher.id,

					mon_status:mon_status,
					mon_start_time:mon_start_time,
					mon_end_time:mon_end_time,
					tue_status:tue_status,
					tue_start_time:tue_start_time,
					tue_end_time:tue_end_time,
					wed_status:wed_status,
					wed_start_time:wed_start_time,
					wed_end_time:wed_end_time,
					thu_status:thu_status,
					thu_start_time:thu_start_time,
					thu_end_time:thu_end_time,
					fri_status:fri_status,
					fri_start_time:fri_start_time,
					fri_end_time:fri_end_time,
					sat_status:sat_status,
					sat_start_time:sat_start_time,
					sat_end_time:sat_end_time,
					sun_status:sun_status,
					sun_start_time:sun_start_time,
					sun_end_time:sun_end_time,

					school_id:$scope.school_id,
					id:$scope.serial
					}
			//var data = formdata;
			//console.log(data);
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
	// checked condition
$('#mon_status').click(function(){
    if($(this).is(":checked"))
    {
	     $(".mon_start_time").removeAttr("disabled");
	   	 $(".mon_end_time").removeAttr("disabled");
	}
    else
    {
    	$(".mon_start_time").attr("disabled" , "disabled");
	   	$(".mon_end_time").attr("disabled" , "disabled");
    }
      
});
$('#tue_status').click(function(){
    if($(this).is(":checked"))
    {
	     $(".tue_start_time").removeAttr("disabled");
	   	 $(".tue_end_time").removeAttr("disabled");
	}
    else
    {
    	$(".tue_start_time").attr("disabled" , "disabled");
	   	$(".tue_end_time").attr("disabled" , "disabled");
    }
      
});
$('#wed_status').click(function(){
    if($(this).is(":checked"))
    {
	     $(".wed_start_time").removeAttr("disabled");
	   	 $(".wed_end_time").removeAttr("disabled");
	}
    else
    {
    	$(".wed_start_time").attr("disabled" , "disabled");
	   	$(".wed_end_time").attr("disabled" , "disabled");
    }
      
});
$('#thu_status').click(function(){
    if($(this).is(":checked"))
    {
	     $(".thu_start_time").removeAttr("disabled");
	   	 $(".thu_end_time").removeAttr("disabled");
	}
    else
    {
    	$(".thu_start_time").attr("disabled" , "disabled");
	   	$(".thu_end_time").attr("disabled" , "disabled");
    }
      
});
$('#fri_status').click(function(){
    if($(this).is(":checked"))
    {
	     $(".fri_start_time").removeAttr("disabled");
	   	 $(".fri_end_time").removeAttr("disabled");
	}
    else
    {
    	$(".fri_start_time").attr("disabled" , "disabled");
	   	$(".fri_end_time").attr("disabled" , "disabled");
    }
      
});
$('#sat_status').click(function(){
    if($(this).is(":checked"))
    {
	     $(".sat_start_time").removeAttr("disabled");
	   	 $(".sat_end_time").removeAttr("disabled");
	}
    else
    {
    	$(".sat_start_time").attr("disabled" , "disabled");
	   	$(".sat_end_time").attr("disabled" , "disabled");
    }
      
});
$('#sun_status').click(function(){
    if($(this).is(":checked"))
    {
	     $(".sun_start_time").removeAttr("disabled");
	   	 $(".sun_end_time").removeAttr("disabled");
	}
    else
    {
    	$(".sun_start_time").attr("disabled" , "disabled");
	   	$(".sun_end_time").attr("disabled" , "disabled");
    }
      
});
// End here
	}

</script>

<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>

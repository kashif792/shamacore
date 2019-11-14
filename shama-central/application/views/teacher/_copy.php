<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10">
	<?php
		// require_footer 
		require APPPATH.'views/__layout/filterlayout.php';
	?>
	<div class="col-lg-12 widget" ng-controller="student">
		<div class="row">
			<div class="widget-header" id="widget-header">
				<!-- widget title -->
  				<div class="widget-title">
	  				<h4>Student</h4>
  				</div>
			</div>
			<div class="widget-body">
				<div class="col-lg-12">
					<?php $attributes = array('role'=>'form','name' => 'studentForm', 'id' => 'studentForm','class'=>'form-container-input'); echo form_open_multipart('', $attributes);?>
					    <div class="row setup-content" id="step-1">
					        <div class="col-xs-12">
					        	
					            <div class="col-md-12">
					         		<input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial"> 
					                <div class="row">
					                	<div class="col-lg-12">
					                		<div class="upper-row">
					                			<label><span class="icon-user"></span> Quizz Name: <span class="required">*</span></label>
					                		</div>
				                			<input type="text" id="inputquizname" name="inputquizname" placeholder="Quiz name"  tabindex="1" value="<?php if(isset($result)){echo $result['sfullname'];} ?>" required="required">
					                	</div>
					                </div>
					                <div class="row">
					                	<div class="col-lg-8">
					                		<div class="upper-row">
					                			<label><span class="icon-address"></span> Class <span class="required">*</span></label>
					                		</div>
				                	      <select name="inputclass" id="inputclass" ng-change="changesection()" ng-model="inputclass" ng-init="ini='<?php echo $classlist[0]->id; ?>'">
			                					<?php 

			                						if(count($classlist))
			                						{

			                							foreach ($classlist as $key => $value) {
			                								?>
			                									 <option  value="<?php echo $value->id; ?>"><?php echo $value->grade; ?></option>
			                								<?php
			                							}
			                						}
			                					?>

			                					
			                				</select>
					                	</div>
<!-- 					                	<div class="col-lg-4">
					                		<div class="upper-row">
					                			<label><span class="icon-address"></span> Section: <span class="required">*</span></label>
					                		</div>
				                		   <select name="inputsection" id="inputsection"  ng-model="inputclass" >
			                					<?php 

			                						if(count($sectionlist))
			                						{

			                							foreach ($sectionlist as $key => $value) {
			                								?>
			                									 <option  value="<?php echo $value->id; ?>"><?php echo $value->section_name; ?></option>
			                								<?php
			                							}
			                						}
			                					?>

			                					
			                				</select>
					                	</div> -->
					                </div>
					                  <div class="row">
					                	<div class="col-lg-8">
					                		<div class="upper-row">
					                			<label><span class="icon-address"></span> Sections <span class="required">*</span></label>
					                		</div>
				                	      <select name="inputsction" id="inputsction" ng-change="changesection()" ng-model="inputclass" ng-init="ini='<?php echo $classlist[0]->id; ?>'">
			                					<?php 

			                						if(count($classlist))
			                						{

			                							foreach ($classlist as $key => $value) {
			                								?>
			                									 <option  value="<?php echo $value->id; ?>"><?php echo $value->grade; ?></option>
			                								<?php
			                							}
			                						}
			                					?>

			                					
			                				</select>
					                	</div>
<!-- 					                	<div class="col-lg-4">
					                		<div class="upper-row">
					                			<label><span class="icon-address"></span> Section: <span class="required">*</span></label>
					                		</div>
				                		   <select name="inputsection" id="inputsection"  ng-model="inputclass" >
			                					<?php 

			                						if(count($sectionlist))
			                						{

			                							foreach ($sectionlist as $key => $value) {
			                								?>
			                									 <option  value="<?php echo $value->id; ?>"><?php echo $value->section_name; ?></option>
			                								<?php
			                							}
			                						}
			                					?>

			                					
			                				</select>
					                	</div> -->
					                </div>
					                 <div class="row">
					                	<div class="col-lg-8">
					                		<div class="upper-row">
					                			<label><span class="icon-address"></span> Subjects <span class="required">*</span></label>
					                		</div>
				                	      <select name="inputsubject" id="inputsubject" ng-change="changesection()" ng-model="inputclass" ng-init="ini='<?php echo $classlist[0]->id; ?>'">
			                					<?php 

			                						if(count($classlist))
			                						{

			                							foreach ($classlist as $key => $value) {
			                								?>
			                									 <option  value="<?php echo $value->id; ?>"><?php echo $value->grade; ?></option>
			                								<?php
			                							}
			                						}
			                					?>

			                					
			                				</select>
					                	</div>
<!-- 					                	<div class="col-lg-4">
					                		<div class="upper-row">
					                			<label><span class="icon-address"></span> Section: <span class="required">*</span></label>
					                		</div>
				                		   <select name="inputsection" id="inputsection"  ng-model="inputclass" >
			                					<?php 

			                						if(count($sectionlist))
			                						{

			                							foreach ($sectionlist as $key => $value) {
			                								?>
			                									 <option  value="<?php echo $value->id; ?>"><?php echo $value->section_name; ?></option>
			                								<?php
			                							}
			                						}
			                					?>

			                					
			                				</select>
					                	</div> -->
					                </div>
					  
			     

					             <div class="field-container">
			                		<div class="field-row">
			                			<button type="submit" tabindex="8" class="btn btn-default save-button">Save</button>
			                			<a tabindex="9" href="<?php echo $path_url; ?>settings" tabindex="6" title="cancel">Cancel</a>
			                		</div>
			                	</div>
					           
					        </div>
					    </div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#example').DataTable();
	 	$('input[name="attendanceinput"]').daterangepicker({
	         singleDatePicker: true,
	        showDropdowns: true,
	        startDate: "<?php if(isset($annoucement_single)){echo date('m/d/Y',strtotime($annoucement_single[0]->sdate)).$annoucement_single[0]->stime;}else{ echo date('m/d/Y');} ?>",
	        locale: {
	            format: 'MM/DD/YYYY'
	        }
    	});
	 	$('input[name="stimepicker"]').daterangepicker({
	        timePicker: true,
	        showDropdowns: true,
	        timePicker24Hour: true,
	        startDate: "<?php if(isset($annoucement_single)){echo date('m/d/Y',strtotime($annoucement_single[0]->sdate)).$annoucement_single[0]->stime;}else{ echo date('m/d/Y');} ?>",
	        endDate: "<?php if(isset($annoucement_single)){echo date('m/d/Y',strtotime($annoucement_single[0]->edate)).$annoucement_single[0]->etime;}else{ echo date('m/d/Y');} ?>",
	        locale: {
	            format: 'MM/DD/YYYY h:mm A'
	        }
    	});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
        /*
         * ---------------------------------------------------------
         *   Save Exam timetable
         * ---------------------------------------------------------
         */ 
        $("#schedule_timetable").submit(function(e){
         	e.preventDefault();
            var subj_name = $("#select_subject").val();
	      	var dataString = jQuery('#schedule_timetable').serializeArray();
	      	ajaxType = "POST";
	  		urlpath = "<?php echo $path_url; ?>Principal_controller/saveTimtable";
	     	ajaxfunc(urlpath,dataString,userResponseFailure,loadUserResponse); 
	  		return false;
        });
	
		function userResponseFailure()
		{
			$(".user-message").show();
	    	$(".message-text").text("User data not saved").fadeOut(10000);
		}

        function loadUserResponse(response)
        {
        	if(response.message == true){
				window.location.href = "<?php echo $path_url;?>show_timtbl_list";
			}
        }     
 	});
</script>
<script type="text/javascript">


function popup(){
    window.open("<?php echo $path_url; ?>add_question", "_blank", "toolbar=no, scrollbars=no, resizable=no, top=80, left=400, width=600, height=500px");
}


	var app = angular.module('invantage', []);

	app.controller('timetable_controller', function($scope, $http, $interval) {
	
	setTimerForWidget('section',1)
	$scope.inputclass = $scope.ini;
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
    },300)
      }

		
		function loadSections()
		{
	
			try{
				var data = ({inputclassid:parseInt($scope.ini)})
			
				httprequest('getsectionbyclass',data).then(function(response){
					if(response.length > 0 && response != null)
					{
						$scope.sectionslist = response;
					}
					else{
						$scope.sectionslist = response;
					}
				})
			}
			catch(ex){}
		}

		$scope.changesection = function()
		{
			try{
				$scope.ini = $scope.inputclass;
				var data = ({inputclassid:parseInt($scope.ini)})
				httprequest('getsectionbyclass',data).then(function(response){
					if(response.length > 0 && response != null)
					{
						$scope.sectionslist = response;
					}
					else{
						$scope.sectionslist = response;
					}
				})
			}
			catch(ex){}
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

     
      function responseSuccess(response){
        return (response.data);
      }

      function responseFail(response){
        return (response.data);
      }
	});
</script>

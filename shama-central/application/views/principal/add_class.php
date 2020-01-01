<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10 col-md-10 col-lg-10 class-page"  ng-controller="classCtrl">
	<div id="delete_dialog" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title">Confirmation</h4>
	            </div>
	            <div class="modal-body">
	                <p>Are you sure you want to delete this section?</p>
	             </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	                <button type="button" id="save" class="btn btn-default " value="save">Yes</button>
	            </div>
	        </div>
	    </div>
	</div>
	<div id="delete_class" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title">Confirmation</h4>
	            </div>
	            <div class="modal-body">
	                <p>Are you sure you want to delete this Grade?</p>
	             </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	                <button type="button" id="savedelete" class="btn btn-default " value="save">Yes</button>
	            </div>
	        </div>
	    </div>
	</div>
	<div id="report_modal" class="modal fade">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title">{{classname}}</h4>
	            </div>
	            <div class="modal-body">
	            	<h4>Timetable</h4>
                    <div class="row">
                        <div class="col-sm-12">
                        	<div class="row">
                        		<div class="col-sm-12">
                        			<?php $attributes = array('name' => 'filter_sections', 'id' => 'filter_sections','class'=>'form-inline'); echo form_open('', $attributes);?>
						               	<input type="hidden" value="" ng-model="serial"  name="serial" id="serial">
					                	<fieldset>
					                		<div class="form-group">
					                			<div class="col-sm-12">
					                				<label for="inputSection"  class="control-label">Sections :</label>
			                                   	 	<select class="form-control"  ng-options="item.name for item in sectionslist track by item.id"  name="inputSection" id="inputSection"  ng-model="inputSection" ng-change="changereportsection()"></select>	
					                			</div>
			                                </div>
						                </fieldset>
						            <?php echo form_close();?>
                        		</div>
                        	</div>
                            <table class="table table-bordered table-striped table-hover table-condensed grd" id="table-body-phase-tow" >
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Start time</th>
                                        <th>End time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr  ng-repeat="s in classtimetableinfo" ng-class-odd="'active'">
                                        <td>{{s.subject}}</td>
                                        <td>{{s.teacher}}</td>
                                        <td>{{s.starttime}}</td>
                                        <td>{{s.endtime}}</td>
                                    </tr>
                                    <tr ng-if="classtimetableinfo.length == 0">
                                    	<td colspan="4" class="text-center">Timetable not allocated yet</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h4>Students</h4>
                    <div class="row">
                        <div class="col-sm-12 class-report-students">
                            <table class="table table-bordered table-striped table-hover table-condensed grd" id="table-body-phase-tow" >
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Roll number</th>
                                        <th>Father name</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="s in classstudentinfo" ng-class-odd="'active'">
                                        <td><span ng-if="s.image"><img src="{{s.image}}" class="img-cricle" width="50"></span></td>
                                        <td>{{s.name}}</td>
                                        <td>{{s.rollnumber}}</td>
                                        <td>{{s.fathername}}</td>
                                        <td>{{s.phone}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
             	</div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            </div>
	        </div>
	    </div>
	</div>
	<?php
		// require_footer
		require APPPATH.'views/__layout/filterlayout.php';
	?>
	<div class="col-sm-12">
		<div class="row">
			<div class="panel panel-default">
				<!-- widget title -->
  				<div class="panel-heading">

	  				<label>Grades and Sections</label>
  				</div>
				<div class="panel-body">
					<div class="panel-group" id="accordion">
		                <div class="panel panel-default">
		                    <div class="panel-heading">
		                        <h4 class="panel-title">
		                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Grades</a>
		                        </h4>
		                    </div>
		                    <div id="collapse2" class="panel-collapse collapse in">
		                        <div class="panel-body">
		                           <div class="form-container">
						          		<?php $attributes = array('name' => 'add_new_class', 'id' => 'add_new_class','class'=>'form-inline'); echo form_open('', $attributes);?>
							               	<input type="hidden" value="" ng-model="serial"  name="serial" id="serial">
						                	<fieldset>
						                		<div class="form-group">
				                                    <label for="input_class_name"  class="control-label">Grade :</label>
	                                    			<input type="text" class="form-control" id="input_class_name" name="input_class_name" ng-model="input_class_name" ng-change="setClass()"  placeholder="Name" value="">
				                                </div>
				                               <!--  <div class="form-group">
				                                    <label for="inputSection"  class="control-label">School :</label>
	                                    			<select class="form-control"  ng-options="item.sname for item in selectlistcity track by item.sid"  name="inputLocation" id="inputLocation"  ng-model="inputLocation" ></select>
				                                </div> -->
							                	<div class="form-group">
						                			<button type="button" ng-click="saveclass()" tabindex="8" class="btn btn-primary class-btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
							                	</div>
							                </fieldset>
							            <?php echo form_close();?>
									</div>
									<div class="row" style="margin-top: 5px;">
		                                <div class="col-sm-12">
		                                    <table class="table table-bordered table-striped table-hover table-responsive grd" id="table-body-phase-tow" >
		                                        <thead>
		                                            <tr>
	                                                	<th>Grade</th>
		                                               	<th>Section</th>
		                                               	<th>Options</th>
		                                            </tr>
		                                        </thead>
		                                        <tbody id="reporttablebody-phase-two" class="report-body">
		                                            <tr ng-repeat="c in classlist" ng-class-odd="'active'">
		                                                <td class="row-update" ng-click="showclassreport(c)">{{c.name}}</td>
		                                             	<td class="row-update" ng-click="showclassreport(c)">
		                                             		<span  ng-repeat="s in c.sections" ng-if="s.status == 'a'">
		                                             			{{s.name}}
		                                             			<span ng-if="s.status == 'a' && c.sections[$index+1].status == 'a'">,</span>
		                                             		</span>


		                                             	</td>
		                                               <td>
		                                                    <a href="javascript:void(0)" ng-click="editclass(c)" title="Edit" class="edit" session-data="{{s.id}}">
		                                                        <i class="fa fa-edit" aria-hidden="true"></i>
		                                                    </a>
		                                                    <a href="javascript:void(0)" ng-click="removeclass(c.id)" title="Delete"  class="del" session-data="{{s.id}}">
		                                                        <i class="fa fa-remove" aria-hidden="true"></i>
		                                                    </a>
		                                                </td>
		                                            </tr>
		                                        </tbody>
		                                    </table>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <div class="panel panel-default">
		                    <div class="panel-heading">
		                        <h4 class="panel-title">
		                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Sections</a>
		                        </h4>
		                    </div>
		                    <div id="collapse1" class="panel-collapse collapse">
		                        <div class="panel-body">
		                            <form class="form-inline">
		                                <div class="form-group">
		                                    <label for="inputSection">Name:</label>
		                                    <input type="text" class="form-control" name="inputSection" id="inputSection" ng-model="inputSectionName">
		                                </div>
		                               <!--  <div class="form-group">
		                                    <label for="inputSection">Grade:</label>
											<select class="form-control" ng-options="item.name for item in classlist track by item.id"  id="inputClasslist" name="inputClasslist" ng-model="inputClasslist"></select>
		                                </div> -->
		                                <div class="form-group">
		                                    <button type="button" ng-click="savenewsection()" class="btn btn-primary section-btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
		                                </div>
		                            </form>
		                            <div class="row" style="margin-top: 5px;">
		                                <div class="col-sm-12">
		                                    <table class="table table-bordered table-striped table-hover table-condensed grd" id="table-body-phase-tow" >
		                                        <thead>
		                                            <tr>
		                                                <th>Section</th>
		                                              <!--   <th>Grade</th> -->
		                                                <th>Options</th>
		                                            </tr>
		                                        </thead>
		                                        <tbody id="reporttablebody-phase-two" class="report-body">
		                                            <tr ng-repeat="s in sectionlist" ng-class-odd="'active'">
		                                                <td>{{s.name}}</td>
		                                               <!--  <td>{{s.classname}}</td> -->
		                                                <td>
		                                                    <a href="javascript:void(0)" ng-click="editsection(s.id)" title="Edit" class="edit" session-data="{{s.id}}">
		                                                        <i class="fa fa-edit" aria-hidden="true"></i>
		                                                    </a>
		                                                    <a href="javascript:void(0)" ng-click="removesection(s.id)" title="Delete"  class="del" session-data="{{s.id}}">
		                                                     <i class="fa fa-remove" aria-hidden="true"></i>
		                                                    </a>
		                                                </td>
		                                            </tr>
		                                        </tbody>
		                                    </table>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <div class="panel panel-default">
		                    <div class="panel-heading">
		                        <h4 class="panel-title">
		                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Assign Section</a>
		                        </h4>
		                    </div>
		                    <div id="collapse3" class="panel-collapse collapse">
		                        <div class="panel-body">
		                            <form class="form-horizontal" name="assignsection" id="assignsection">
		                                <div class="field-group ">
					                		<div class="col-sm-4">
					                			<label><span class="icon-th-list"></span> Grade <span class="required">*</span></label>
				                				<select class="form-control" ng-options="item.name for item in classlist track by item.id"  id="inputClasslist" name="inputClasslist" ng-model="inputClasslist" ng-change="getassignlistclass()"></select>
					                		</div>
					                	</div>
					                	<div class="field-group ">
					                		<div class="col-sm-12">
					                			<label><span class="icon-th-list"></span> Section <span class="required">*</span></label>
					                			<div class="col-sm-12" class="form-control">
													<span ng-repeat="s in sectionlist">
					                					<input type="checkbox" name="inputSectionChecked" ng-click="addsections(s)" ng-checked="s.selected" value="{{s.name}}" >{{s.name}}
					                				</span>
					                			</div>
					                		</div>
					                	</div>
		                                <div class="form-group">
		                                	<div class="col-sm-12">
		                                		<button type="button" ng-click="sectionassign()" class="btn btn-primary assign-btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
		                                	</div>
		                                    
		                                </div>
		                            </form>

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

<script>
	
    app.controller('classCtrl',['$scope','$myUtils','$filter', classCtrl]);

    function classCtrl($scope, $myUtils, $filter) {

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
            classlist:'<?php echo SHAMA_CORE_API_PATH; ?>classes_with_details',
            getsectionbyclass:'<?php echo SHAMA_CORE_API_PATH; ?>sections_by_class',
            saveassignsection:'<?php echo SHAMA_CORE_API_PATH; ?>sections_by_class',
            getstudentbyclass:'<?php echo SHAMA_CORE_API_PATH; ?>students',
            getsectionlist:'<?php echo SHAMA_CORE_API_PATH; ?>sections',
            getsection:'<?php echo SHAMA_CORE_API_PATH; ?>section',
            savesection:'<?php echo SHAMA_CORE_API_PATH; ?>section',
            removesession:'<?php echo SHAMA_CORE_API_PATH; ?>session',
            session_detail:'<?php echo SHAMA_CORE_API_PATH; ?>session',
            getselectedsection:'<?php echo SHAMA_CORE_API_PATH; ?>sections_assigned_by_class',
            removesection:'<?php echo SHAMA_CORE_API_PATH; ?>section',
            removeclass:'<?php echo SHAMA_CORE_API_PATH; ?>class',
            getclassdetail:'<?php echo SHAMA_CORE_API_PATH; ?>class',
            saveclass:'<?php echo SHAMA_CORE_API_PATH; ?>class',
            getclasstimetable:'<?php echo SHAMA_CORE_API_PATH; ?>class_time_table',
            getclassstudents:'<?php echo SHAMA_CORE_API_PATH; ?>students_by_class_and_section'
        }

        $scope.sid = '';
		$scope.serial = '';
			
		$scope.saveclass = function()
		{
		  	var input_class_name = $("#input_class_name").val();

            var reg = new RegExp(/^[A-Za-z0-9 ]{1,50}$/);
          	message('','hide')
         	if(reg.test(input_class_name) == false){
                jQuery("#input_class_name").css("border", "1px solid red");
                message('Please enter the grade name','show')
                return false;
            }
            else{
                jQuery("#input_class_name").css("border", "1px solid #C9C9C9");
            }

            // if($scope.classlist != null){
	           //  for (var i = $scope.classlist.length - 1; i >= 0; i--) {
	           //  	if($scope.classlist[i].name.toLowerCase() == input_class_name.toLowerCase())
	           //  	{
	           //  		message('Can not add duplicate class','show')
	           //  		return false
	           //  	}
	           //  }
           	// }

           	var $this = $(".class-btn");
            $this.button('loading');

	    
			var data = ({
					class_id:$scope.serial,
					school_id:$scope.school_id,
					class_name:input_class_name
				})
			
			$myUtils.httppostrequest(urlist.saveclass,data).then(function(response){
                    var $this = $(".class-btn");
                    $this.button('reset');
                    if(response.message == true){
           				message('Grade has been successfully saved','show')
						$scope.input_class_name = '';
           				$scope.serial = '';
		        		loadclass()
           	    	}

           	    	if(response.message == false){
           	    		var $this = $(".class-btn");
	                    $this.button('reset');
						$scope.input_class_name = '';
	                    message('Grade did not save','show')
           	    	}
                });

	  		return false;
		}



        $scope.cid = '';
	    $scope.editclass = function(class_id)
	    {
	    	$scope.serial = class_id.id
            var data = ({
                class_id:$scope.serial
            })
          
            message('','hide');
           $("#serial").val(class_id)
           $myUtils.httprequest(urlist.getclassdetail,data).then(function(response){
                if(response != null)
                {
                	
                    $scope.input_class_name = response.name;
                }else{
            		message('Try again','show');
                }
            });
	    }


	     $scope.removeclass = function(class_id)
        {
            $("#delete_class").modal('show');

            $scope.cid = class_id
        }

        $(document).on('click','#savedelete',function(){
            $("#delete_class").modal('hide');
            var data = ({
                class_id:$scope.cid
            })

           $myUtils.httpdeleterequest(urlist.removeclass,data).then(function(response){
                if(response != null)
                {
                   message('Grade has been successfully removed','show')
                   loadclass()
                   $scope.cid = ''
                }else{
                	message('Grade did not remove','show')
                }
            });
        });

     	angular.element(function () {
            loadSection();
            loadclass();
            
          //  getSchoolList()
         });

     	$scope.sectionlist = [];
        function loadSection()
        {

            var data = ({
                school_id:$scope.school_id,
                })
            $myUtils.httprequest(urlist.getsectionlist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.sectionlist = response
                    angular.forEach($scope.sectionlist,function(value,key){
                    	value.selected = false;
                    });
                    $scope.inputClassSection = response[0]

                }
            });
        }

        function loadclass()
        {
            var data = ({
                school_id:$scope.school_id,
                })
            $myUtils.httprequest(urlist.classlist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.classlist = response
                    $scope.inputClasslist = response[0]
                    $scope.getassignlistclass();

                }
            });
        }


        $scope.savenewsection = function()
        {
        	message('','hide')
        	if($scope.sectionlist != null){
        		for (var i = $scope.sectionlist.length - 1; i >= 0; i--) {
	            	if($scope.sectionlist[i].name.toLowerCase() == $scope.inputSectionName.toLowerCase())
	            	{
	            		message('Can not add duplicate section','show')
	            		return false
	            	}
	            }
        	}

            if($scope.inputSectionName.length > 0)
            {
                var data = ({
                    section_name:$scope.inputSectionName,
					school_id:$scope.school_id,
                    section_id:$scope.sid,
                })
                var $this = $(".section-btn");
            	$this.button('loading');


                $myUtils.httppostrequest(urlist.savesection,data).then(function(response){
                    if(response != null && response.message == true)
                    {
                    	$this.button('reset');
                    	$scope.inputSectionName = '';
                    	$scope.sid = '';
                        message('Section has been successfully saved','show')
                        loadSection()
                        loadclass()
                    }else{
                    	message('Section did not save','show')
                    	$this.button('reset');
                    }
                });
            }
        }


        $scope.editsection = function(sectionid)
        {
            $scope.sid = sectionid
            var data = ({
                section_id:$scope.sid
            })

           $myUtils.httprequest(urlist.getsection,data).then(function(response){
                if(response != null)
                {
                    $scope.inputSectionName = response[0].name;
                }
            });
        }

        $scope.removesection = function(sectionid)
        {
            $("#delete_dialog").modal('show');

            $scope.sid = sectionid
        }

        $(document).on('click','#save',function(){
            $("#delete_dialog").modal('hide');
            var data = ({
                section_id:$scope.sid
            })

           $myUtils.httpdeleterequest(urlist.removesection,data).then(function(response){
                if(response != null)
                {
                   message('Section has been removed','show')
                   loadSection()
                   loadclass()

                   $scope.sid = ''
                }else{
                	message('Section did not remove','show')
                }
            });
        });

        $scope.selectedsections = [];

        $scope.addsections = function(sectinoid)
        {
    		sectinoid.selected = !sectinoid.selected;
        }


     	$scope.sectionassign = function()
     	{
     		var $this = $(".assign-btn");
            $this.button('loading');
			message('','hide');
		
			angular.forEach($scope.sectionlist , function(value,key){
				$scope.section_status = false;
				if(value.selected)
				{
					$scope.section_status = true;
				}

			 	var temp ={
        			name:value.name,
        			status:$scope.section_status == true ? 1 : 0
        		}
        		 
        		$scope.selectedsections.push(temp)
			});
			
     		var data = ({
     				school_id: $scope.school_id,
     				class_id: $scope.inputClasslist.id,
     				sections: $scope.selectedsections
     			})

     		if($scope.inputClasslist.id != '' && $scope.selectedsections.length > 0)
     		{
     			$myUtils.httppostrequest(urlist.saveassignsection,data).then(function(response){
     				if(response != null && response.message == true)
     				{
     					loadclass();
     					$scope.selectedsections = [];
     					$scope.getassignlistclass();
     					$this.button('reset');
     					message('Section assignment saved','show')
     				}
     				else{
     					$scope.selectedsections = [];
     					$this.button('reset');
     					message('Error in section assignment.','show')
     				}
     			});
     		}else{
				message('Please select atleast single section','show');
				var $this = $(".assign-btn");
				$this.button('reset');
			}
     	}

     	$scope.getassignlistclass= function()
     	{
     		try{
     			$scope.selectedsections = []
     			$myUtils.httprequest(urlist.getselectedsection,({class_id:$scope.inputClasslist.id})).then(function(response){
     				if(response != null  && response.length > 0){
     					
     					angular.forEach($scope.sectionlist , function(value,key){
     						$scope.is_obj_found = $filter('filter')(response,{id:value.id},true);
 							value.selected = false;
 							if($scope.is_obj_found.length)
	 						{
	 							value.selected = true;
	 						}
						});
     				}
     				else{
     					angular.forEach($scope.sectionlist , function(value,key){
 							value.selected = false;
						});
     				}
     			});
     		}
     		catch(ex){}
     	}

 	 	function getSchoolList()
        {
             try{
                var data = ({tschool:'tschool'})
                $myUtils.httprequest('getschoollist',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.selectlistcity = response;
                        $scope.inputLocation = response[0];
                    }
                    else{
                        $scope.selectlistcity = []
                    }
                })
            }
            catch(ex){}
        }

        $scope.classreportid;
        $scope.showclassreport = function(class_id)
        {
        	try{
        		$("#report_modal").modal('show');
        		$scope.classname = class_id.name;
        		$scope.classreportid = class_id.id;
               	$scope.loadSections(class_id.id);
            }
            catch(ex){}
        }

        function getClassTimetable(class_id,sectionid)
        {
    	 	var data = ({class_id:class_id,section_id:sectionid})
            $myUtils.httprequest(urlist.getclasstimetable,data).then(function(response){
                if(typeof response != 'undefined' && response)
                {
                    $scope.classtimetableinfo = response;
                }
                else{
                    $scope.classtimetableinfo = []
                }
            });
        }

        function getClassStudents(class_id,sectionid)
        {
        	var data = ({class_id:class_id,section_id:sectionid})
            $myUtils.httprequest(urlist.getclassstudents,data).then(function(response){
                if(typeof response != 'undefined' && response && response.length > 0)
                {
                	$scope.studentsnotfound = false;
                    $scope.classstudentinfo = response;
                }
                else{
                	$scope.studentsnotfound = true;
                    $scope.classstudentinfo = [];
                }
            });
        }

		$scope.loadSections= function(class_id)
		{
			try{
				var data = ({class_id:class_id})
				
				$myUtils.httprequest(urlist.getsectionbyclass,data).then(function(response){
					if(response.length > 0 && response != null)
					{
						$scope.inputSection = response[0];
						$scope.inputSectionName = $scope.inputSection.name;
						$scope.sectionslist = response;

						getClassTimetable(class_id,$scope.inputSection.id);
               			getClassStudents(class_id,$scope.inputSection.id);
					}
					else{
						$scope.sectionslist = [];
					}
				});
			}
			catch(ex){}
		}

		$scope.changereportsection = function()
		{
			getClassTimetable($scope.classreportid,$scope.inputSection.id);
   			getClassStudents($scope.classreportid,$scope.inputSection.id);
		}

	}

</script>

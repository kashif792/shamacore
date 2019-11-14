<?php

// require_header
require APPPATH . 'views/__layout/header.php';

// require_top_navigation

require APPPATH . 'views/__layout/topbar.php';

// require_left_navigation

require APPPATH . 'views/__layout/leftnavigation.php';

?>



<div id="myUserModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title">Confirmation</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete this schedule?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">No
				</button>
				<button type="button" id="UserDelete" class="btn btn-default "
					value="save">Yes</button>
			</div>
		</div>
	</div>
</div>
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h3 style="padding-left: 40px;">Schedule Information</h3>
				<table class="table table-striped table-hover">
					<tbody>
						<tr>
							<td>
							
							<th>Subject Name</th>
							</td>
							<td id="user_name"></td>
						</tr>
						<tr>
							<td>
							
							<th>Grade Name</th>
							</td>
							<td id="user_email"></td>
						</tr>
						<tr>
							<td>
							
							<th>Section Name</th>
							</td>
							<td id="user_acct_date"></td>
						</tr>
						<tr>
							<td>
							
							<th>Teacher Name</th>
							</td>
							<td id="user_acct_status"></td>
						</tr>
						<tr>
							<td>
							
							<th>Start Time</th>
							</td>
							<td id="user_role"></td>
						</tr>
						<tr>
							<td>
							
							<th>End Time</th>
							</td>
							<td id="user_role"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close
				</button>
			</div>
		</div>
	</div>
</div>




<div class="col-sm-10">



<?php

// require_footer

require APPPATH . 'views/__layout/filterlayout.php';

?>
<div class="panel panel-default" ng-controller="timetableCtrl">
		<div class="panel-heading">
			<label>Schedule List &nbsp;&nbsp;&nbsp;

				<a ng-if="isPrincipal"
				href="<?php echo $path_url; ?>add_timtble" class="btn btn-primary"
				style="color: #fff !important;">Add Schedule</a>

			</label>
		</div>
		<div class="panel-body">
			<table class="table-body table table-bordered table-responsive sfiltr" id="table-body-phase-tow">

				<thead>

					<tr>



						<th>Subjects</th>

						<th>Grade</th>

						<th>Teachers</th>

						<th>Start Time</th>

						<th>End Time</th>

						<th ng-if="isPrincipal">Options</th>

					</tr>

				</thead>

                <tbody id="reporttablebody-phase-two" class="report-body sfiltr ">
                        <tr  ng-if="schedules.length>0" ng-repeat="s in schedules track by s.id" id="tr_{{s.id}}" data-view="{{s.row_slug}}">

						<td class="row-bar-user"
							data-view="{{s.row_slug}}">{{s.subject}}</td>

						<td class="row-bar-user"
							data-view="{{s.row_slug}}">{{s.grade}} ({{s.section}})</td>

						<td class="row-bar-user"
							data-view="{{s.row_slug}}">{{s.teacher}}</td>

						<td class="row-bar-user"
							data-view="{{s.row_slug}}">{{s.start_time}}</td>

						<td class="row-bar-user"
							data-view="{{s.row_slug}}">{{s.end_time}}</td>

						<td ng-if="isPrincipal">
							<a
							href="<?php echo $path_url; ?>add_timtble/{{s.id}}"
							id="{{s.id}}" class='edit' title="Edit"> <i
								class="fa fa-edit" aria-hidden="true"></i>
							</a>
							
							<a href="#" title="Delete" id="{{s.id}}"
							class="del"> <i class="fa fa-remove" aria-hidden="true"></i>

						</a></td>

					</tr>

                	<tr ng-if="schedules.length<=0"><td colspan='8'>No record found</td></tr>

					                </tbody>



			</table>

		</div>
	</div>

</div>



<?php

// require_footer

require APPPATH . 'views/__layout/footer.php';

?>



<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js">

</script>


<script src="<?php echo $path_url; ?>js/jquery.easyResponsiveTabs.js">
</script>



<script type="text/javascript">

	var dvalue ;

	$(document).ready(function(){
		$('#setting').easyResponsiveTabs({ tabidentify: 'vert' });


        function loadClassByIdReponseError(){}



        function loadClassByIdResponse(data)
        {

            if(data.message == true)

            {

                $("#class_name").html(data.grade);

                $("#section_name").html(data.section_name);

                $("#myModal").modal('show');

            }

        }

        $(document).on('click','.del',function(){

            $("#myUserModal").modal('show');

            dvalue =  $(this).attr('id');

            row_slug =   $(this).parent().parent().attr('id');

        });


        $(document).on('click','#UserDelete',function(){

            $("#myUserModal").modal('hide');

            urlpath = "<?php echo $path_url; ?>LMSApi/schedule";

			var data = 'id='+String(dvalue);
            urlpath += '?'+ data;
            ajaxType = 'DELETE';
            ajaxfunc(urlpath,[],userDeleteFailureHandler,loadUserDeleteResponse);
            

    	});



        function userDeleteFailureHandler()
        {

 		 	$(".user-message").show();

	    	$(".message-text").text("Schedule has been not deleted").fadeOut(10000);

        }



        function loadUserDeleteResponse(response)
        {

        	if (response.message === true){

                $("#"+row_slug).remove();

     		 	$(".user-message").show();

		    	$(".message-text").text("schedule has been deleted").fadeOut(10000);
         	} 

        }

	});



</script>





<script>

    app.controller('timetableCtrl',['$scope','$myUtils', timetableCtrl]);

    function timetableCtrl($scope, $myUtils) {

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


        function loadTimeTableList(){

            try{

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>schedules',({user_id:$scope.user_id, role_id:$scope.role_id,school_id:$scope.school_id})).then(function(response){

                        $scope.schedules = response;
                        //loaddatatable();
                })

            }

            catch(ex){}

        }


        angular.element(function () {

        	loadTimeTableList();

         });


        function loaddatatable()
        {
            $('#table-body-phase-tow').DataTable( {
                 "order": [[ 0, "asc"  ]],
               
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var select = $('<select><option value="">All</option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            });
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        });
                    });
                }
            });
        }

    }


</script>
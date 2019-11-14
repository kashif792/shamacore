<?php

// require_header
require APPPATH . 'views/__layout/header.php';

// require_top_navigation

require APPPATH . 'views/__layout/topbar.php';

// require_left_navigation

require APPPATH . 'views/__layout/leftnavigation.php';

?>

<link href="<?php echo $path_url; ?>css/easy-responsive-tabs.css"
	rel="stylesheet">

<link rel="stylesheet"
	href="<?php echo $path_url; ?>css/intlTelInput.css">

<div id="myUserModal" class="modal fade">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>

				<h4 class="modal-title">Confirmation</h4>

			</div>

			<div class="modal-body">

				<p>Are you sure you want to delete this teacher?</p>

			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>

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
				<div class="panel-heading plheading prflhd" id="widget-header">
					<h4>Teacher Profile</h4>
				</div>

				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#home">TEACHER
							INFORMATION</a></li>
					<!--  <li><a data-toggle="tab" href="#menu2">TEACHER INFORMATION</a></li> -->

				</ul>
				<div class="tab-content">
					<div id="home" class="tab-pane fade in active">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6 border">

									<a href="#" class="thumbnail"> <img class="img-rounded size"
										width="170" src=""></a>


								</div>
								<div class="col-md-6">
									<table class="table table-striped table-hover">
										<tbody>
											<tr>
												<td>
												
												<th>First Name:</th>
												</td>
												<td id="user_name"></td>

											</tr>
											<tr>
												<td>
												
												<th>Last Name:</th>
												</td>
												<td id="user_lastname"></td>

											</tr>
											<tr>
												<td>
												
												<th>Email:</th>
												</td>
												<td id="email_get"></td>
											</tr>
											<tr>
												<td>
												
												<th>Phone</th>
												</td>
												<td id="teacher_phone"></td>
											</tr>
											<tr>
												<td>
												
												<th>City:</th>
												</td>
												<td id="teacher_city"></td>
											</tr>


										</tbody>
									</table>

								</div>
							</div>

						</div>
						<table class="table table-striped table-hover">
							<tbody>
								<tr>
									<td>
									
									<th>Gender</th>
									</td>
									<td id="teacher_gender"></td>

								</tr>
								<tr>
									<td>
									
									<th>NIC #</th>
									</td>
									<td id="teacher_Nic"></td>
								</tr>

								<tr>
									<td>
									
									<th>Primary Home Address</th>
									</td>
									<td id="primry_home_address"></td>
								</tr>
								<tr>
									<td>
									
									<th>Secondary Home Address</th>
									</td>
									<td id="secondary_home_address"></td>
								</tr>
								<tr>
									<td>
									
									<th>Province</th>
									</td>
									<td id="teacher_province"></td>
								</tr>
								<tr>
									<td>
									
									<th>Zipcode</th>
									</td>
									<td id="teacher_zipcode"></td>
								</tr>
							</tbody>
						</table>

					</div>

					<div id="menu2" class="tab-pane fade">
						<br>
						<!--                             <table class="table table-striped table-hover">
                       <tbody>
                        <tr>
                            <td>
                                <th>City:</th>
                            </td>
                            <td id="teacher_city"></td>
                        </tr>
                        <tr>
                            <td>
                                <th>Gender</th>
                            </td>
                            <td id="teacher_gender"></td>
                            
                        </tr>
                        <tr>
                            <td>
                                <th>NIC #</th>
                            </td>
                            <td id="teacher_Nic"></td>
                        </tr>
                       
                         <tr>
                            <td>
                                <th>Phone</th>
                            </td>
                            <td id="teacher_phone"></td>
                        </tr>
                        
                         <tr>
                            <td>
                                <th>Primary Home Address</th>
                            </td>
                            <td id="primry_home_address"></td>
                        </tr>
                         <tr>
                            <td>
                                <th>Secondary Home Address</th>
                            </td>
                            <td id="secondary_home_address"></td>
                        </tr>
                        <tr>
                            <td>
                                <th>Province</th>
                            </td>
                            <td id="teacher_province"></td>
                        </tr>
                         <tr>
                            <td>
                                <th>Zipcode</th>
                            </td>
                            <td id="teacher_zipcode"></td>
                        </tr>
                    </tbody>
                </table> -->
					</div>

				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="col-sm-10">

<?php

// require_footer

require APPPATH . 'views/__layout/filterlayout.php';

?>
<div class="panel panel-default" ng-controller="teachersCtrl">
		<div class="panel-heading">
			<label>Teacher List &nbsp;&nbsp;&nbsp;
				<a ng-if="isPrincipal"
				href="<?php echo $path_url; ?>add_teacher" class="btn btn-primary"
				style="color: #fff !important;">Add Teacher</a>
			</label>
		</div>
		<div class="panel-body">
			<table class="table-body table table-bordered table-responsive sfiltr"
				id="table-body-phase-tow">
				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Phone No</th>
						<th ng-if="isPrincipal">Options</th>
					</tr>
				</thead>
				<tbody id="reporttablebody-phase-two" class="report-body sfiltr ">
                               
                               <tr  ng-if="teachers.length>0" ng-repeat="s in teachers track by s.id" id="tr_{{s.id}}" data-view="{{s.id}}">

                                                <td class="row-bar-user" data-view="{{s.id}}">{{s.first_name}}</td>

                                                 <td class="row-bar-user" data-view="{{s.id}}">{{s.last_name}}</td>
                                                <td class="row-bar-user" data-view="{{s.id}}">{{s.email}}</td> 
                                                 <td class="row-bar-user" data-view="{{s.id}}">{{s.phone}}</td> 

                                                <td ng-if="isPrincipal">
                                                    <a href="<?php echo $path_url; ?>add_teacher/{{s.id}}" id="{{s.id}}" class='edit' title="Edit">
                                                          <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </a>

                                                    <a href="#" title="Delete" id="{{s.id}}" class="del">
                                                          <i class="fa fa-remove" aria-hidden="true"></i>
                                                    </a>
                                                </td>

                                            </tr>
                                            <tr ng-if="teachers.length<=0"><td colspan='8'>No record found</td></tr>

                          </tbody>

			</table>

		</div>
	</div>

</div>

<?php

// require_footer

require APPPATH . 'views/__layout/footer.php';

?>


<script type="text/javascript">

	var dvalue ;

	$(document).ready(function(){

      	$(document).on('click','.row-bar-user',function(){
            dvalue =  $(this).attr('data-view');

            ajaxType = "GET";

            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>teacher";

            var data = 'id='+String(dvalue);
            urlpath += '?'+ data;
            
            ajaxfunc(urlpath,[],loadTeacherByIdReponseError,loadTeacherByIdResponse);

        });



      	function loadTeacherByIdReponseError(){}

        function loadTeacherByIdResponse(data)
        {
        	if(data.message == true)
        	{
        		$("#user_name").html(data.first_name);
        		$("#user_lastname").html(data.last_name);
                $(".img-rounded").attr('src',data.profile_image);
                $("#email_get").text(data.email);
              
        		$("#teacher_gender").html((data.gender == 1 ? 'Male':'Female'));
        		$("#teacher_Nic").html(data.nic);
        		$("#teacher_phone").html(data.phone);

    			$("#primry_home_address").html(data.primary_address);
				$("#secondary_home_address").html(data.secondary_address);
				$("#teacher_province").html(data.province);
				$("#teacher_zipcode").html(data.zipcode);
                $("#teacher_city").html(data.city);
        					
        		$("#myModal").modal('show');
        	}

        }

   

        /*
         * ---------------------------------------------------------
         *   Delete User
         * ---------------------------------------------------------
         */

        $(document).on('click','.del',function(){

            $("#myUserModal").modal('show');

            dvalue =  $(this).attr('id');

        });

        
        /*
         * ---------------------------------------------------------
         *   User notification on deleting user 
         * ---------------------------------------------------------
         */
        $(document).on('click','#UserDelete',function(){

            $("#myUserModal").modal('hide');

            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>teacher";

			var data = 'id='+String(dvalue);
            urlpath += '?'+ data;
            
            ajaxType = 'DELETE';
            ajaxfunc(urlpath,[],userDeleteFailureHandler,loadUserDeleteResponse);

    	});


        function userDeleteFailureHandler()
        {
 		 	$(".user-message").show();
	    	$(".message-text").text("Teacher not deleted").fadeOut(10000);
        }

        function loadUserDeleteResponse(response)
        {
        	if (response.message === true){

                $("#tr_"+dvalue).remove();

     		 	$(".user-message").show();

		    	$(".message-text").text("Teacher has been deleted").fadeOut(10000);

         	} 
        }


	});

</script>


<script>


    app.controller('teachersCtrl',['$scope','$myUtils', teachersCtrl]);

    function teachersCtrl($scope, $myUtils) {

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


	    function loaddatatable()

	    {

	        $('#table-body-phase-tow').DataTable( {

	            responsive: true,

	             "order": [[ 0, "asc"  ]],
/*
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
*/
	        });

	    }

        function loadTeacherList(){

            try{

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>teachers',({school_id:$scope.school_id})).then(function(response){

                        $scope.teachers = response;

                        //loaddatatable();
                })

            }

            catch(ex){}

        }


        angular.element(function () {

        	loadTeacherList();

        });

    }


</script>




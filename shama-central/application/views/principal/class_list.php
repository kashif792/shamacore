<?php 

// require_header 

require APPPATH.'views/__layout/header.php';



// require_top_navigation 

require APPPATH.'views/__layout/topbar.php';



// require_left_navigation 

require APPPATH.'views/__layout/leftnavigation.php';

?>



<link href="<?php echo $path_url; ?>css/easy-responsive-tabs.css" rel="stylesheet">

<link rel="stylesheet" href="<?php echo $path_url; ?>css/intlTelInput.css">

<div id="myUserModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p>Are you sure you want to delete this grade?</p>

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                <button type="button" id="UserDelete" class="btn btn-default " value="save">Yes</button>

            </div>

        </div>

    </div>

</div>

<div id="myModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body">

                <h3 style="padding-left: 40px;">Grade list</h3>

                <table class="table table-striped table-hover">

                    <tbody>

                        <tr>

                            <td>

                                <th>Name</th>

                            </td>

                            <td id="class_name"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Section</th>

                            </td>

                            <td id="section_name"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Modified</th>

                            </td>

                            <td id="user_role"></td>

                        </tr>

                    </tbody>

                </table>

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>

<div class="modal fade new_form" id="student_form_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Students List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
   <!--    	<h4>Lesson</h4>
      	<div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" name="inputDate" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
       
    </div> -->
      	<!-- <button>End Date</button>
      	<button>Generate Lesson Plan</button>
      	<button>Reset Lesson Plan</button> -->
      	<table class="table-body" id="student_table" >
			                        <thead>
				                        <tr>
				                            <th>Name</th>
				                            <th>Roll No</th>
				                            
				                        </tr>
				                    </thead>
				                    <tfoot>
				                     <tr>
				                            <th>Name</th>
				                            <th>Roll No</th>
				                           
				                     
				                             
				                        </tr>
				                    </tfoot>
 									<tbody id="student_form" class="report-body">

					                </tbody>

			                    </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!---subject view starrrrrrrrrrrrrrrrrrrrrrrt -->


<div class="modal fade new_form" id="subject_form_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subject List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
   <!--    	<h4>Lesson</h4>
      	<div class="row">
        <div class='col-sm-6'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" name="inputDate" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
       
    </div> -->
      	<!-- <button>End Date</button>
      	<button>Generate Lesson Plan</button>
      	<button>Reset Lesson Plan</button> -->
      	<table class="table-body" id="subject_table" >
			                        <thead>
				                        <tr>
				                            <th>Subject Name</th>
				                            <th>Subject Code</th>
				                            
				                        </tr>
				                    </thead>
				                    <tfoot>
				                     <tr>
				                         <th>Subject Name</th>
				                            <th>Subject Code</th>
				                           
				                     
				                             
				                        </tr>
				                    </tfoot>
 									<tbody id="subject_form" class="report-body">

					                </tbody>

			                    </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!---subject view endddddddddddddddddddddddddd -->


<div class="col-sm-10">

<?php

	// require_footer 

	require APPPATH.'views/__layout/filterlayout.php';

?>
<?php 
	$roles = $this->session->userdata('roles');

			
?>
	<div class="col-lg-12 widget" ng-controller="gradesCtrl">
		<div class="panel-heading plheading" id="widget-header">
			<!-- widget title -->
  				<!-- <div class="widget-title"> -->
	  				<h4>Grade list</h4>
  				<!-- </div> -->
			</div>
			<div class="widget-body">
				<div class="setting-container">
					<div id="setting">          
				  		<ul class="resp-tabs-list vert">
					  	</ul> 
			  			<div class="resp-tabs-container vert">                                                        
			      		
			      			<div id="user-managment-tab">
			      				<div class="action-element">
		  							<a ng-if="isPrincipal" href="<?php echo $path_url; ?>newclass" id="add-action">Add Grade</a>
			  					</div>
			  					
            					<table class="table-body table table-bordered table-responsive sfiltr" id="table-body-phase-tow" >
			                        <thead>
				                        <tr>
				                          
		                                    <th>Grade</th>
		                                    <th>Section</th>
		                                    <th ng-if="isPrincipal">Options</th>
		                                    
				                        </tr>
				                    </thead>
				                    <tfoot>
				                        <tr>
		                                    <th>Class Name</th>
		                                    <th>Section Name</th>
		                                   	<th ng-if="isPrincipal">Options</th>
		                                    
				                        </tr>
				                    </tfoot>
			                        <tbody id="student_form" class="report-body">
			                        	    <tr  ng-if="clists.length>0" ng-repeat="value in clists track by value.id" id="tr_{{value.row_slug}}">

			                                    <td class="row-bar-user" id="{{value.id}}" data-view="{{value.id}}">{{value.name}}</td>
			                                    <td  class="" data-view="{{value.id}}">{{value.section_name}}</td>

			                                    <td  ng-if="isPrincipal"> 
			                                        <a href="<?php echo $path_url; ?>newclass/{{value.id}}" id="{{value.id}}" class='edit' title="Edit">
			                                            <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
			                                        </a>
			                                        <a href="#" title="Delete" id="{{value.id}}" class="del">
			                                            <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
			                                        </a>
			                                    </td>
			                                     
			                                </tr>
                            				<tr ng-if="clists.length<=0"><td colspan='8'>No class found.</td></tr>
					                </tbody>

			                    </table>

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

<script type="text/javascript">

	var dvalue ;

	$(document).ready(function(){

		$(".table-choice").show();


	});

</script>

<script type="text/javascript">

	$(document).ready(function(){

		$('#setting').easyResponsiveTabs({ tabidentify: 'vert' });


		loaddatatable('table-body-phase-tow');

	  	/**

     	 * ---------------------------------------------------------

	     *   load table

	     * ---------------------------------------------------------

	     */

	    function loaddatatable(tableinit)

	    {

	        $('#'+tableinit).DataTable( {

	            responsive: true,

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
    

       $(document).on('click','.row-bar-user',function(){

         
       
    	var data = ({sid:$(this).attr('id'),'showModel':true})
      	ajaxType = "GET";
     
  		urlpath = "<?php echo base_url(); ?>Principal_controller/show_all_stds_onclick";
  		
     	ajaxfunc(urlpath,data,loadStudentByIdReponseError,loadStudentByIdResponse); 

          });

		function loadStudentByIdReponseError()
		{
			alert();
		}
		function loadStudentByIdResponse(response){
			
			if(response.length > 0 &&  response != null)
			{
				var str = '';
				for (var i = response.length - 1; i >= 0; i--) {
				str += '<tr>'
				str += '<td class="std" id="'+response[i].id+'">'+response[i].screenname+'</td>'
				str += '<td >'+response[i].username+'</td>'	
				str += '</tr>'
				}

				$("#student_table").dataTable().fnDestroy();
				$("#student_form").html(str)

				loaddatatable('student_table');
		
			}
			else{
				var str = '';
				str += '<tr>'
				str += '<td style="text-align:center;">No record found</td>'
				str += '<td></td>'
				str += '</tr>'
				
				$("#student_table").dataTable().fnDestroy();
				$("#student_form").html(str)

				loaddatatable('student_table');
			}
			 $("#student_form_show").modal('show');
			}
		
//___________________________________________


		$(document).on('click','.std',function(){

         
       
    	var data = ({sid:$(this).attr('id'),'showModel':true})
      	ajaxType = "GET";
     
  		urlpath = "<?php echo base_url(); ?>Principal_controller/show_all_subject_onclick";
  		
     	ajaxfunc(urlpath,data,loadsubjectByIdReponseError,loadsubjectByIdReponse); 

          });

		function loadsubjectByIdReponseError()
		{
			
		}
		function loadsubjectByIdReponse(response){
			
			if(response.length > 0 &&  response != null)
			{
				var str = '';
				for (var i = response.length - 1; i >= 0; i--) {
				str += '<tr>'
				str += '<td>'+response[i].subject_name+'</td>'
				str += '<td >'+response[i].subject_code+'</td>'	
				str += '</tr>'
				}

				$("#subject_table").dataTable().fnDestroy();
				$("#student_form").html(str)

				loaddatatable('subject_table');
		
			}
			else{
				var str = '';
				str += '<tr>'
				str += '<td style="text-align:center;">No record found</td>'
				str += '<td></td>'
				str += '</tr>'
				
				$("#subject_table").dataTable().fnDestroy();
				$("#subject_form").html(str)

				loaddatatable('subject_table');
			}
			// $("#subject_form_show").modal('show');
			}
		



         /*

         * ---------------------------------------------------------

         *   Delete User

         * ---------------------------------------------------------

         */

        $(document).on('click','.del',function(){

            $("#myUserModal").modal('show');

            dvalue =  $(this).attr('id');

         

            row_slug =   $(this).parent().parent().attr('id');

            

        });

        

        /*

         * ---------------------------------------------------------

         *   User notification on deleting user 

         * ---------------------------------------------------------

         */

        $(document).on('click','#UserDelete',function(){

            $("#myUserModal").modal('hide');

    		ajaxType = "GET";

            urlpath = "<?php echo $path_url; ?>Principal_controller/removeClas";

            var dataString = ({'id':dvalue});

            ajaxfunc(urlpath,dataString,userDeleteFailureHandler,loadUserDeleteResponse);

    	});



        function userDeleteFailureHandler()

        {

 		 	$(".user-message").show();

	    	$(".message-text").text("Class has been not deleted").fadeOut(10000);

        }



        function loadUserDeleteResponse(response)

        {

        	if (response.message === true){

                $("#"+row_slug).remove();

     		 	$(".user-message").show();

		    	$(".message-text").text("Class has been deleted").fadeOut(10000);

         	} 

        }

        

	});

</script>

<script>


    app.controller('gradesCtrl',['$scope','$myUtils', gradesCtrl]);

    function gradesCtrl($scope, $myUtils) {

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


        function loadClassData(){

            try{

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>classes_with_details',({user_id:$scope.user_id, role_id:$scope.role_id,school_id:$scope.school_id})).then(function(response){

                        $scope.clists = response;
                        //loaddatatable();
                })

            }

            catch(ex){}

        }


        angular.element(function () {

            loadClassData();

        });
	}

</script>




<?php

// require_header

require APPPATH.'views/__layout/header.php';



// require_top_navigation

require APPPATH.'views/__layout/topbar.php';



// require_left_navigation

require APPPATH.'views/__layout/leftnavigation.php';

?>


<div class="col-sm-10" ng-controller="palsCtrl">

<?php

    // require_footer

    require APPPATH.'views/__layout/filterlayout.php';

?>

<div id="myUserModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p>Are you sure you want to delete this principal?</p>

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
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <label class="modal-title">Principal</label>
      </div>
            <div class="modal-body">
              
                <div class="row">
                    <div class="col-sm-12"> 
                        <div class="col-sm-5">
                            <img class="img-rounded size" id="profile_image" width="225" src="">
                        </div>
                         <div class="col-sm-7">
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
                            <td id="email"></td>
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
                            
                                <th>Gender</th>
                          
                            <td id="teacher_gender"></td>
                           
                                <th>NIC #</th>
                         
                            <td id="teacher_Nic"></td>
                        </tr>
                        <tr>

                        </tr>
                        <tr>
                          
                                <th>Phone</th>
                           
                            <td id="phone"></td>
                         <th>Schools</th>
                      
                            <td id="schools" colspan="3"></td>
                        </tr>
                         <tr>
                            
                                
                        </tr>

                         <tr>
                       
                                <th>Primary Address</th>
                    
                            <td id="primry_home_address"></td>
                          
                                <th>Secondary Address</th>
                            
                            <td id="secondary_home_address"></td>
                        </tr>
 						<tr>
                            
                                <th>Province</th>
                         
                            <td id="teacher_province"></td>
                              <th>Zipcode</th>
                         
                            <td id="teacher_zipcode"></td>
                                
                        </tr>
                       <!--  <tr>
                           
                              
                    
                                <th>Schools</th>
                      
                            <td id="schools" colspan="3"></td>
                        </tr> -->
                    </tbody>
                </table>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <div class="panel">
        <div class="panel-heading">
            <label>Principal List
                <a href="<?php echo $path_url; ?>add_Prinicpal" class="btn btn-primary" style="color: #fff !important;">Add a Principal</a>
            </label>
        </div>
        <div class="panel-body">
            <table class="table-body" id="table-body-phase-tow" >
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>School</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>

                                    <tbody id="reporttablebody-phase-two" class="report-body">
                                        
                                            <tr  ng-if="plist.length>0" ng-repeat="p in plist" id="tr_{{p.id}}" data-view="{{p.row_slug}}">
                                                <td class="row-bar-user" data-view="{{p.id}}">{{p.first_name}}</td>
                                                <td class="row-bar-user" data-view="{{p.id}}">{{p.last_name}}</td>
                                                <td class="row-bar-user" data-view="{{p.id}}">{{p.email}}</td>
                                                <td class="row-bar-user" data-view="{{p.id}}">
                                                    <div ng-if="p.school!=null && ps.school!=''">
                                                        {{p.school.name + ' ('+ p.school.location +')'}}
                                                    </div>
                                                </td>
                                            
                                                <td>
                                                    <a href="{{baseUrl}}add_Prinicpal/{{p.id}}" id="" class='edit' title="Edit">
                                                         <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </a>
                                                    <a href="#" title="Delete" id="{{p.id}}" class="del">
                                                         <i class="fa fa-remove" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
<!-- 
                                            <tr ng-if="plist.length<=0">
                                                <p id='novaluefound'>No record found.</p>
                                            </tr> -->
                                            

                                    </tbody>

                                </table>
        </div>
    </div>

</div>

<?php

// require_footer

require APPPATH.'views/__layout/footer.php';

?>


<script src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script src="<?php echo $path_url; ?>js/jquery.easyResponsiveTabs.js"></script>

<script type="text/javascript">

	var dvalue ;

	$(document).ready(function(){

		//$(".table-choice").show();



		//loaddatatable();

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
                /*
	            initComplete: function () {

	                this.api().columns().every( function () {

	                    var column = this;

	                    var select = $('<select><option value=""></option></select>')

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

	            }*/

	        });

	    }

	});

</script>

<script type="text/javascript">
    

    $(document).ready(function(){

        $('#setting').easyResponsiveTabs({ tabidentify: 'vert' });
    });

</script>

<script type="text/javascript">

    app.controller('palsCtrl',['$scope','$myUtils', palsCtrl]);



    function palsCtrl($scope, $myUtils) {

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

        $scope.plist = [];
        function loadPrincipalData(){

            try{

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>principals',({user_id:$scope.user_id})).then(function(response){

                        if(null!=response && response.length>0){
                            $scope.plist = response;
                            //loaddatatable();
                        }else{
                            $scope.plist = [];
                        }
                })

            }

            catch(ex){}

        }


        angular.element(function () {

            loadPrincipalData();

        });



        $(document).on('click','.row-bar-user',function(){
            dvalue =  $(this).attr('data-view');
            var dataString = ({'id':dvalue,'user_id':$scope.user_id});
            ajaxType = "GET";
            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>principal";
            ajaxfunc(urlpath,dataString,loadTeacherByIdReponseError,loadTeacherByIdResponse);

        });



        function loadTeacherByIdReponseError(){}

        function loadTeacherByIdResponse(data)
        {
            if(data != null)
            {
                $("#user_name").html(data.first_name);
                $("#user_lastname").html(data.last_name);
                $("#teacher_gender").html((data.gender == 1 ? "Male":"Female"));
                $("#teacher_Nic").html(data.nic);
                $("#user_role").html(data.religion);
                $("#email").html(data.email);
                $("#phone").html(data.phone);
                $("#primry_home_address").html(data.p_address);
                $("#secondary_home_address").html(data.s_address);
                $("#teacher_province").html(data.province);
                $("#teacher_city").html(data.city);
                $("#teacher_zipcode").html(data.zip_code);

                var str = '';
                if(data.school!=null && data.school!='') {
                    str += data.school.name+" ("+data.school[i].location+")<br>"
                }

                $("#schools").html(str);
                
                $("#profile_image").prop('width',150);
                $("#profile_image").prop('src','<?php echo base_url(); ?>images/avatar.jpg');
                if(data.profile_image != '')
                {
                    $("#profile_image").prop('width',225);
                    $("#profile_image").prop('src',data.profile_image);
                }
                
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



            row_slug =   $(this).parent().parent().attr('id');



        });



        /*

         * ---------------------------------------------------------

         *   User notification on deleting user

         * ---------------------------------------------------------

         */

        $(document).on('click','#UserDelete',function(){

            $("#myUserModal").modal('hide');

            ajaxType = "DELETE";

            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>principal";

            var dataString = ({'id':dvalue});

            ajaxfunc(urlpath,dataString,userDeleteFailureHandler,loadUserDeleteResponse);

        });



        function userDeleteFailureHandler()

        {

            $(".user-message").show();

            $(".message-text").text("Teacher has been not deleted").fadeOut(10000);

        }



        function loadUserDeleteResponse(response)

        {

            if (response.message === true){

                $("#tr_"+dvalue).remove();

                $(".user-message").show();

                $(".message-text").text("Teacher has been deleted").fadeOut(10000);

            }

        }
    }
</script>

<?php 

// require_header 

require APPPATH.'views/__layout/header.php';


// require_top_navigation 

require APPPATH.'views/__layout/topbar.php';


// require_left_navigation 

require APPPATH.'views/__layout/leftnavigation.php';

?>


<div id="myUserModal" class="modal fade">



    <div class="modal-dialog">



        <div class="modal-content">



            <div class="modal-header">



                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>



                <h4 class="modal-title">Confirmation</h4>



            </div>



            <div class="modal-body">



                <p>Are you sure you want to delete this student?</p>



             </div>



            <div class="modal-footer">



                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>



                <button type="button" id="UserDelete" class="btn btn-default " value="save">Yes</button>



            </div>



        </div>



    </div>



</div>

<!-- <h3 style="padding-left: 40px;">Student Information</h3> -->



<div id="myModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body">

                       <div class="panel-heading plheading prflhd" id="widget-header">

                         <h4>Student Information</h4>

                         </div>

                        <!-- <h3 style="padding-left: 40px;">Student Information</h3> -->

                        <ul class="nav nav-tabs">

                            <li class="active"><a data-toggle="tab" href="#home">STUDENT INFORMATION</a></li>

                            <!-- <li><a data-toggle="tab" href="#menu1">STUDENT INFORMATION</a></li> -->
                            <li><a data-toggle="tab" href="#menu2">GUARDIAN INFORMATION</a></li>

                            <li><a data-toggle="tab" href="#menu3">EDUCATION</a></li>

                            <li><a data-toggle="tab" href="#menu4">REFERENCES</a></li>

                        </ul>



                      <div class="tab-content">

                        <div id="home" class="tab-pane fade in active">

                        <div class="row">

                         <div class="col-sm-6 "><a href="#" class="thumbnail">
                            <img class="img-rounded size" src="<?php echo base_url(); ?>images/userdefault.jpg" width="170"></a>

                        </div>
                        <div class="col-sm-6">
                            <table class="table">
                                <tbody>
                      <tr>
                          <td>

                                <th>First Name</th>

                            </td>
                            <td id="screenname"> </td>
                        </tr>
                           <tr>
                          <td>

                                <th>Last Name</th>

                            </td>
                            <td id="slastname"> </td>
                        </tr>
                            <tr>
                            <td>

                                <th>Roll No</th>

                            </td>
                            

                            <td id="info_roll_number"> </td>
                        </tr>
 
                        <tr>
                            <td>

                                <th>DOB</th>

                            </td>

                            <td id="sdob"></td>
                        </tr>
                      <tr>

                            <td>

                                <th>Grade</th>

                            </td>

                            <td id="sgrade"></td>
                        </tr>
                            <tr>
                            <td>

                                <th>Phone</th>

                            </td>

                            <td id="sphone"></td>

                        </tr>
                                </tbody>
                            </table>
                        </div>
                  <table class="table table-striped table-hover">

                    <tbody>
               

                        <tr>
                             <td>

                                <th>Enrollment Date</th>

                            </td>

                            <td id="sdateav"></td>


                             <td>

                                <th>NIC #</th>

                            </td>

                            <td id="snic"></td>
                        </tr>

                        <tr>

                            <td>

                                <th>Student Address</th>

                            </td>

                            <td id="student_address"></td>

                             <td>

                                <th>House/Unit #</th>

                            </td>

                            <td id="shunit"></td>

                        </tr>

                        

                        <tr>

                            <td>

                                <th>Province</th>

                            </td>

                            <td id="info_sprovice"></td>

                            <td>

                                <th>City</th>

                            </td>

                            <td id="info_scity"></td>

                               

                           

                        </tr>

                        

                        <tr>
                            <td>

                                <th>Financial Assistance</th>

                            </td>

                            <td id="financial_assistance"></td>
                            
                            <td>


                            <th>Post Code</th>

                            </td>

                            <td id="info_spcode"></td>


                            

                        </tr>



                        <tr>
                             <td>

                                <th>Mother Language</th>

                            </td>

                            <td id="smthrlng"></td>

                             <td>

                                <th>Additional Language</th>

                            </td>

                            <td id="saddlang"></td>

                        </tr>

         

                          <tr>



                             <td>

                                <th>Special Circumstances:</th>

                            </td>

                            <td id="circumstances"></td>
                            
                             <td>

                                <th>Mode:</th>

                            </td>

                            <td id="mode"></td>
                        </tr>

                    </tbody>

                </table>

                    

                         </div> 

        

                        </div> 

                        <div id="menu1" class="tab-pane fade">

                            <br>

                          <table class="table table-striped table-hover">


                </table>

                        </div>
                  <div id="menu2" class="tab-pane fade">

                            <br>

                          <table class="table table-striped table-hover">

                    <tbody>

                        <tr>

                              <td>

                                <th>Father Name</th>

                            </td>

                            <td id="father_name"></td>
                             <td>

                                <th>Father NIC#</th>

                            </td>

                            <td id="father_nic"></td>

                        </tr>

                        <tr>
                             <td>

                                <th>Profession</th>

                            </td>

                            <td id="father_profession"></td>

                            <td>

                                <th>Profession Year</th>

                            </td>
                                 <td id="father_years"></td>

                        </tr>

                    

                        <tr>

                             <td>

                                <th>Company</th>

                            </td>

                            <td id="father_company"></td>

                             <td>

                                <th>Monthly Income</th>

                            </td>

                            <td id="monthly_income"></td>



                           

                        </tr>

                        <tr>

                            <td>

                                <th>Work Address</th>

                            </td>

                            <td id="father_work_address"></td>


                              <td>

                                <th>Monthly Income</th>

                            </td>

                            <td id="father_monthly_income_2"></td>



                        </tr>

                    </tbody>

                </table>

                        </div>

                        <div id="menu3" class="tab-pane fade">

                            <br>

                            <table class="table table-striped table-hover">

                    <tbody id="previous_school_info">


                        <tr>

                            <td>

                                <th>Previous School</th>

                            </td>

                            <td id="previous_school_1"></td>

                             <td>

                                <th>Address</th>

                            </td>

                            <td id="school1_address"></td>

                        </tr>                

                         <tr>

                            <td>

                                <th>From</th>

                            </td>

                            <td id="school1_from"></td>

                              <td>

                                <th>To</th>

                            </td>

                            <td id="school1_to"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Previous School 2</th>


                            </td>

                            <td id="school2_name"></td>

                              <td>

                                <th>Address 2</th>

                            </td>

                            <td id="school2_address"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>From 2</th>

                            </td>

                            <td id="school2_from"></td>

                               <td>

                                <th>To 2</th>

                            </td>

                            <td id="school2_to"></td>

                        </tr>

                                    

                        <tr>

                            <td>

                                <th>Previous School 3</th>

                            </td>

                            <td id="school3_name"></td>

                              <td>

                                <th>Address 3</th>

                            </td>

                            <td id="school3_address"></td>

                        </tr>

                                            

                         <tr>

                            <td>

                                <th>From 3</th>

                            </td>

                            <td id="school3_from"></td>

                              <td>

                                <th>To 3</th>

                            </td>

                            <td id="school3_to"></td>

                        </tr>

                           </tbody>

                </table>

            

                        </div>

            <div id="menu4" class="tab-pane fade">

                            <br>

                <table class="table table-striped table-hover">

                    <tbody id="student_refenecne_info">

                         <tr>

                            <td>

                                <th>Reference Fullname</th>

                            </td>

                            <td id="ref1_name"></td>

                             <td>

                                <th>Relationship</th>

                            </td>

                            <td id="ref1_relationship"></td>

                        </tr>

                    

                        <tr>

                            <td>

                                <th>Company</th>

                            </td>

                            <td id="ref1_company"></td>

                               <td>

                                <th>Phone </th>

                            </td>

                            <td id="ref1_phone"></td>

                        </tr>

                    

                          <tr>

                            <td>

                                <th>Address</th>

                            </td>

                            <td id="ref1_address"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Reference Fullname2</th>

                            </td>

                            <td id="ref2_name"></td>

                             <td>

                                <th>Relationship</th>

                            </td>

                            <td id="ref2_relationship"></td>

                        </tr>

                         

                        <tr>

                            <td>

                                <th>Company</th>

                            </td>

                            <td id="ref2_company"></td>

                                <td>

                                <th>Phone </th>

                            </td>

                            <td id="ref2_phone"></td>

                        </tr>

                    

                          <tr>

                            <td>

                                <th>Address</th>

                            </td>

                            <td id="ref2_address"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Reference Fullname3</th>

                            </td>

                            <td id="ref3_name"></td>

                            <td>

                                <th>Relationship</th>

                            </td>

                            <td id="ref3_relationship"></td>

                        </tr>

                          

                        <tr>

                            <td>

                                <th>Company</th>

                            </td>

                            <td id="ref3_company"></td>

                               <td>

                                <th>Phone </th>

                            </td>

                            <td id="ref3_phone"></td>

                        </tr>

                        

                          <tr>

                            <td>

                                <th>Address</th>

                            </td>

                            <td id="ref3_address"></td>

                        </tr>





                    </tbody>

                </table>

                        </div>

                      </div>



                

                

                         

                         

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>



<!-- right content -->
<div class="col-sm-10">

<?php
    // require_footer
    require APPPATH . 'views/__layout/filterlayout.php';
?>

    <div class="panel panel-default" ng-controller="studentsCtrl">
        <div class="panel-heading">
           <label>Student List
            
           &nbsp;&nbsp;&nbsp;
           <a ng-if="isPrincipal" href="{{baseUrl}}savestudent" class="btn btn-primary" style="color: #fff !important;">Add Student</a>
            
           </label>
        </div>
        <div class="panel-body" style="overflow: auto;">
            <table class="table-body table table-bordered table-responsive sfiltr" id="table-body-phase-tow" >
                    <thead>

                        <tr>

                            <th>Roll No</th>
                            <th>First Name</th>
                            <th>Last Name</th>	
                            <th>Grade</th>
                            <th>Mode</th>
                            <th>Father Name</th>
                            <th>Father Phone No</th>
                            <th>Financial Assistance</th>
                            <th ng-if="isPrincipal">Options</th>

                        </tr>

                    </thead>

                    <tbody id="reporttablebody-phase-two" class="report-body sfiltr ">
                            <tr  ng-if="students.length>0" ng-repeat="s in students track by s.id" id="tr_{{s.id}}" data-view="{{s.id}}">

                                 <td class="row-bar-user" data-view="{{s.id}}">{{s.roll_number}}</td> 

                                <td class="row-bar-user" data-view="{{s.id}}">{{s.first_name}}</td>

                                 <td class="row-bar-user" data-view="{{s.id}}">{{s.last_name}}</td>
                                <td class="row-bar-user" data-view="{{s.id}}">{{s.class_name}}</td>
                                <td class="row-bar-user" data-view="{{s.id}}">{{s.mode}}</td> 
                                 <td class="row-bar-user" data-view="{{s.id}}">{{s.father_name}}</td>
                                 <td class="row-bar-user" data-view="{{s.id}}">{{s.phone}}</td> 
    							<td class="row-bar-user" data-view="{{s.id}}">{{s.req_financial_assistance==1?"Yes":"No"}}</td>
                                
                                <td ng-if="isPrincipal">
                                    <a href="{{baseUrl}}savestudent/{{s.id}}" id="{{s.id}}" class='edit' title="Edit">
                                          <i class="fa fa-edit" aria-hidden="true"></i>
                                    </a>

                                    <a href="#" title="Delete" id="{{s.id}}" class="del">
                                          <i class="fa fa-remove" aria-hidden="true"></i>
                                    </a>
                                </td>

                            </tr>
                            <tr ng-if="students.length<=0"><td colspan='8'>No student found</td></tr>

                    </tbody>



                </table>
        </div>
    </div>
</div>


<script type="text/javascript">

    var dvalue ;
    var data=null;

	$(document).ready(function(){



		$('#setting').easyResponsiveTabs({ tabidentify: 'vert' });


        $(document).on('click','.row-bar-user',function(){
              $("#myModal").modal('show');
            dvalue =  $(this).attr('data-view');
            
            var dataString = ({'id':dvalue});

            ajaxType = "GET";

            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>student";

            ajaxfunc(urlpath,dataString,loadStudentByIdReponseError,loadStudentByIdResponse);



        });


        function loadStudentByIdReponseError(){}



        function loadStudentByIdResponse(data)

        {

            if(data.message == true)

            {   
                  $("#myModal").modal('show');

                $("#roll_number").html(data.roll_number);
                $("#info_roll_number").html(data.roll_number);

                $("#screenname").html(data.screen_name);
                $("#info_screen_name").html(data.screen_name);
                if(data.profile_image != '')
                {
                    $(".img-rounded").attr('src',data.profile_image);
                }
                
                else{
                     $(".img-rounded").attr('src','<?php echo base_url();?>images/userdefault.jpg');
                }
                 $("#slastname").html(data.last_name);

                $("#student_address").html(data.street);

                $("#shunit").html(data.unit);

                $("#scity").html(data.city);
                $("#info_scity").html(data.city);

                $("#sprovice").html(data.province);
                $("#info_sprovice").html(data.province);

                $("#spcode").html(data.postal_code);
                $("#info_spcode").html(data.postal_code);

                $("#sphone").html(data.phone);

                // $("#semail").html(data.semail);
                $("#sdob").html(data.dob);

                $("#sdateav").html(data.enroll_date);

                $("#snic").html(data.nic);
                
                $("#smthrlng").html(data.mother_lang);

                $("#saddlang").html(data.add_lang);

                $("#sgrade").html(data.class_name);

                $("#father_name").html(data.father_name);

                $("#father_nic").html(data.father_nic);

                $("#father_profession").html(data.father_profession);

                $("#father_years").html(data.father_years);

                $("#father_company").html(data.father_company);

                $("#father_comapny_years").html(data.father_comapny_years);

                $("#monthly_income").html(data.father_company_income);

                $("#father_work_address").html(data.father_company_address);

                $("#father_monthly_income_2").html(data.father_monthly_income);

                $("#financial_assistance").html(data.req_financial_assistance==1?"Yes":"No");

                $("#circumstances").html(data.special_circumstances);

                $("#mode").html(data.mode=='time'?"Student-Time Mode":"Student-Free Mode");
                
                var row = '';

              var shistoryFound = false;
              
                if(data.school1_name  && data.school1_address && data.school1_from && data.school1_to)
                {
                      
                      shistoryFound = true;
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Previous School<td>';
                        row += '<td>'+data.school1_name+'<td>';
                        row += '<td>Address<td>';
                        row += '<td>'+data.school1_address+'<td>';
                        row += "<tr>";
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>From<td>';
                        row += '<td>'+data.school1_from+'<td>';
                        row += '<td>To<td>';
                        row += '<td>'+data.school1_to+'<td>';
                        row += "<tr>";
                }

                 if(data.school2_name  && data.school2_address && data.school2_from && data.school2_to)
                {
                      
                      shistoryFound = true;
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Previous School<td>';
                        row += '<td>'+data.school2_name+'<td>';
                        row += '<td>Address<td>';
                        row += '<td>'+data.school2_address+'<td>';
                        row += "<tr>";
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>From<td>';
                        row += '<td>'+data.school2_from+'<td>';
                        row += '<td>To<td>';
                        row += '<td>'+data.school2_to+'<td>';
                        row += "<tr>";
                }
                 if(data.school3_name  && data.school3_address && data.school3_from && data.school3_to)
                {
                      
                      shistoryFound = true;
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Previous School<td>';
                        row += '<td>'+data.school3_name+'<td>';
                        row += '<td>Address<td>';
                        row += '<td>'+data.school3_address+'<td>';
                        row += "<tr>";
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>From<td>';
                        row += '<td>'+data.school3_from+'<td>';
                        row += '<td>To<td>';
                        row += '<td>'+data.school3_to+'<td>';
                        row += "<tr>";
                }


                if(!shistoryFound){
                    row = '<tr><td colspan="4" class="text-center">No data found</td></tr>';
                }
                $("#previous_school_info").html(row);
              
              var referenceFound = false;
                var row = '';
                
               if(data.ref1_name)
                {
                      referenceFound = true;
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Full Name<td>';
                        row += '<td>'+data.ref1_name+'<td>';
                        row += '<td>Relationship<td>';
                        row += '<td>'+data.ref1_relationship+'<td>';
                        row += "<tr>";
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Company<td>';
                        row += '<td>'+data.ref1_company+'<td>';
                        row += '<td>Phone<td>';
                        row += '<td>'+data.ref1_phone+'<td>';
                        row += "<tr>";
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Address<td>';
                        row += '<td>'+data.ref1_address+'<td>';
                        row += "<tr>";

                }

                 if(data.ref2_name)
                {
                      
                      referenceFound = true;
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Full Name<td>';
                        row += '<td>'+data.ref2_name+'<td>';
                        row += '<td>Relationship<td>';
                        row += '<td>'+data.ref2_relationship+'<td>';
                        row += "<tr>";
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Company<td>';
                        row += '<td>'+data.ref2_company+'<td>';
                        row += '<td>Phone<td>';
                        row += '<td>'+data.ref2_phone+'<td>';
                        row += "<tr>";
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Address<td>';
                        row += '<td>'+data.ref2_address+'<td>';
                        row += "<tr>";

                }

                if(data.ref3_name)
                {
                      
                      referenceFound = true;
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Full Name<td>';
                        row += '<td>'+data.ref3_name+'<td>';
                        row += '<td>Relationship<td>';
                        row += '<td>'+data.ref3_relationship+'<td>';
                        row += "<tr>";
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Company<td>';
                        row += '<td>'+data.ref3_company+'<td>';
                        row += '<td>Phone<td>';
                        row += '<td>'+data.ref3_phone+'<td>';
                        row += "<tr>";
                        row += "<tr>";
                        row += '<td><td>';
                        row += '<td>Address<td>';
                        row += '<td>'+data.ref3_address+'<td>';
                        row += "<tr>";

                }

                if(!referenceFound){
                    row = '<tr><td colspan="4" class="text-center">No data found</td></tr>';
                }
            
                
                $("#student_refenecne_info").html(row);

            }



        }


        $(document).on('click','.del',function(){

            $("#myUserModal").modal('show');

            dvalue =  $(this).attr('id');

            row_slug =   $(this).parent().parent().attr('id');

        });



        



         //   User notification on deleting user 



        $(document).on('click','#UserDelete',function(){



            $("#myUserModal").modal('hide');



    		ajaxType = "DELETE";



            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>student";



            var dataString = ({'id':dvalue});



            ajaxfunc(urlpath,dataString,userDeleteFailureHandler,loadUserDeleteResponse);



    	});







        function userDeleteFailureHandler()



        {



 		 	$(".user-message").show();



	    	$(".message-text").text("User has been not deleted").fadeOut(10000);



        }







        function loadUserDeleteResponse(response)



        {



        	if (response.message === true){



                $("#tr_"+dvalue).remove();



     		 	$(".user-message").show();



		    	$(".message-text").text("Student has been deleted").fadeOut(10000);



         	} 



        }



        



	});

</script>



<script>

    app.controller('studentsCtrl',['$scope','$myUtils', studentsCtrl]);

    function studentsCtrl($scope, $myUtils) {

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


        function loadStudentData(){

            try{

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>students_by_school',({user_id:$scope.user_id, role_id:$scope.role_id,school_id:$scope.school_id})).then(function(response){

                        $scope.students = response;
                        //loaddatatable();
                })

            }

            catch(ex){}

        }


        angular.element(function () {

            loadStudentData();

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

<?php

// require_footer 
require APPPATH.'views/__layout/footer.php';

?>





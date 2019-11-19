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

                <p>Are you sure you want to delete this subject?</p>

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                <button type="button" id="UserDelete" class="btn btn-default " value="save">Yes</button>

            </div>

        </div>

    </div>

</div>

<div class="col-sm-10">

<?php

  // require_footer 

  require APPPATH.'views/__layout/filterlayout.php';

?>
    
<div class="panel panel-default" ng-controller="subjectCtrl">
  <div class="panel-heading">
      <label>Subject List
       &nbsp;&nbsp;&nbsp;
       <a ng-if="isPrincipal" href="<?php echo $path_url; ?>newsubject" class="btn btn-primary" style="color: #fff !important;">Add Subject</a>
       
      </label>
  </div>
  <div class="panel-body" >
     <table class="table-body table table-bordered table-responsive sfiltr" id="table-body-phase-tow" >
                              <thead>
                                <tr>
                                    <th>Grade Name</th>
                                    <th>Subject Name</th>
                                   
                                    <th ng-if="isPrincipal">Options</th>
                                   
                                </tr>
                            </thead>
                              <tbody id="lesson_plan" class="report-body sfiltr">
                              
                                            <tr  ng-if="subjects.length>0" ng-repeat="s in subjects track by s.id" id="{{s.id}}" data-view="{{s.id}}">

                                          <td class="" data-view="">{{s.class_name}}</td>
                                          <td  data-view="" id="{{s.id}}">{{s.name}}</td>
                                          
                                          <td ng-if="isPrincipal">
                                              <a href="<?php echo $path_url; ?>newsubject/{{s.id}}" id="" class='edit'  title="Edit">
                                                  <i class="fa fa-edit" aria-hidden="true"></i>
                                              </a>
                                                <a href="#" title="Delete" id="{{s.id}}" class="del">
                                                   <i class="fa fa-remove" aria-hidden="true"></i>
                                                </a>
                                          </td>
                                      </tr>
                                      
                                      <tr ng-if="subjects.length<=0"><td colspan='8'>No record found</td></tr>

                          </tbody>

                          </table>
  </div>
</div>

</div>

<?php

// require_footer 

require APPPATH.'views/__layout/footer.php';

?>


<script type="text/javascript">

  $(document).ready(function(){
    var dvalue ;

    $(".table-choice").show();

    $('input[name="inputDate"]').daterangepicker({
            autoApply: true,
          showDropdowns: true,
         
          locale: {
              format: 'MM/DD/YYYY'
          }

      });
    $('input[name="inputDate"]').on('apply.daterangepicker', function(ev, picker) {
 alert()
});
    
        
    $('#setting').easyResponsiveTabs({ tabidentify: 'vert' });

      
    $('.row-plan').click(function(e){
      e.preventDefault();
       alert() 
        })  ;

    $("#quizform").submit(function(){
      
            var url = '<?php echo base_url(); ?>show_subject_list';
            var data = ({
              'inputquizname':inputquizname,
              
              'serial':parseInt($("#serial").val()),
           
              
            })

   
            httppostrequest(url,data).then(function(response){
              if(response.message == true)
              {
                $scope.lastid =response.lastid;

                alert("Quiz saved successfully");

                $('#myModal').modal('show');
                $("#savequiz").attr('disabled', true);
              }
            });

            return false;
    })  ;
    // console.log($scope.serail)
    

  
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

            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>/removesubject";

            var dataString = ({'id':dvalue});

            ajaxfunc(urlpath,dataString,userDeleteFailureHandler,loadUserDeleteResponse);

      });



        function userDeleteFailureHandler()

        {

        $(".user-message").show();

        $(".message-text").text("Subject has been not deleted").fadeOut(10000);

        }



        function loadUserDeleteResponse(response)

        {

          if (response.message === true){

                $("#"+row_slug).remove();

          $(".user-message").show();
          message("Subject has been deleted","show");
          //$(".message-text").text("Subject has been deleted").fadeOut(10000);

          } 

        }

        

  });

</script>

<script>

    app.controller('subjectCtrl',['$scope','$myUtils', subjectCtrl]);

    function subjectCtrl($scope, $myUtils) {

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

        function loadSubjectList(){

            try{

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>subjects',({user_id:$scope.user_id, school_id:$scope.school_id})).then(function(response){

                        $scope.subjects = response;
                        //loaddatatable();
                })

            }

            catch(ex){}

        }


        angular.element(function () {

          loadSubjectList();

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
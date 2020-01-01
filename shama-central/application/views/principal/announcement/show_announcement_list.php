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

<div class="col-sm-10 col-md-10 col-lg-10 class-page "  ng-controller="announcementCtrl" ng-init="getBaseUrl('<?php echo base_url(); ?>')">





<div class="">



<?php



	// require_footer 



	require APPPATH.'views/__layout/filterlayout.php';


// echo validPhoneNumber("12345678908");

// function validPhoneNumber($number)
// {
//     $string =  strlen($number);
//     if($string==11)
//     {
//         $valid_no = substr($number, 1);
//         $valid_no = "92".$valid_no;
//     }
//     else
//     {
//         $valid_no = $number;
//     }
//     return $valid_no;
// }

?>
<div class="panel panel-default">
	<div class="panel-heading">
		<label>Announcement List
			   &nbsp;&nbsp;&nbsp;<a href="<?php echo $path_url; ?>add_announcement" class="btn btn-primary" style="color: #fff !important;">Add Announcement</a>
     
		</label>
        
	</div>
    <div class="panel-body">
       
		<table class="table table-striped table-bordered row-border hover" id="table-body-phase-tow" >

			                        <thead>

				                        <tr>

				                          

				                            <th>Title</th>

				                            <th>Message</th>

				                            <th>Target</th>

		                                    <th>Status</th>

		                                    <th>Date Time</th>

		                                    <th>Options</th>

				                        </tr>

				                    </thead>

				                    <tfoot>

				                        <tr>

                                          

                                            <th>Title</th>

                                            <th>Message</th>

                                            <th>Target</th>

                                            <th>Status</th>

                                            <th>Date Time</th>

                                            <th>Options</th>

                                        </tr>

				                    </tfoot>

			                        <tbody >

                                    </tbody>



			                    </table>
		
	</div>
    <!-- <div id="timetable" style="min-height:280px;" ></div> -->
    
</div>

</div>

</div>

<?php



// require_footer 



require APPPATH.'views/__layout/footer.php';



?>


<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>



<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>
<script src="<?php echo base_url(); ?>js/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>js/vfs_fonts.js"></script>
<script src="<?php echo  base_url(); ?>js/ui-bootstrap-tpls-2.5.0.js"></script>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>




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

            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>schedule";

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
                message('schedule has been deleted','show');
                //$(".message-text").text("schedule has been deleted").fadeOut(10000);
            } 

        }

    });



</script>





<script>

    app.controller('announcementCtrl',['$scope','$myUtils', announcementCtrl]);

    function announcementCtrl($scope, $myUtils) {

        $scope.isPrincipal = false;
        $scope.isTeacher = false;
        $scope.isAdmin = false;
        $scope.day = [];
        $scope.data = [];
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

        function getDayList()
        {
            
            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>getdaylist',({})).then(function(response){ 
                if(response != null && response.length > 0)
                {
                    
                    $scope.daylist = response;
                    //$scope.filterobj.day = response[0];
                    
                }
            });
        }
        
        $scope.changeclass = function()
        {
            
            getScheduleDatafilter();
            
            
            $scope.active = 1;
            
        }
        
        function getScheduleData()
        
        {

            try{

                    $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>announcements',({user_id:$scope.user_id, role_id:$scope.role_id,school_id:$scope.school_id})).then(function(response){

                        
                        $scope.data = [];
                        if(response.length > 0 && response != null)
                        {
                            for (var i=0; i<response[0]['listarray'].length; i++) {
                                $scope.data.push(response[0]['listarray'][i]);
                                
                                
                            }
                            
                            $("#table-body-phase-tow").dataTable().fnDestroy();
                            loaddatatable($scope.data);
                            
                        }
                        else{
                            $("#table-body-phase-tow").dataTable().fnDestroy();
                            loaddatatable($scope.data);
                        }
                })
            }
            catch(e){}
        }
        
        

        angular.element(function () {

            getScheduleData();
            
         });


        function loaddatatable(data)
        {
            var listdata= data;
            
            var table = $('#table-body-phase-tow').DataTable( {
                data: listdata,
                responsive: true,
                "order": [[ 0, "asc"  ]],
                rowId: 'id',
                columns: [
                    { data: 'title' },
                    { data: 'message' },
                    { data: 'target_type' },
                    
                    { data: 'status' },
                    { data: 'created_at' },
                    {
                     "className": '',
                     "orderable": false,
                     "data": null,

                     "defaultContent": "",
                     "render" : function ( data, type, full, meta ) {
                          if ( data != null && data != '') {
                             
                             return "<a href='<?php echo $path_url; ?>view_announcement/"+data['id']+"'  ><i class='fa fa-eye' aria-hidden='true'></i></a> </a>";
                         }
                         else {
                                 return;
                         }
                      }
                    },
                ],

                "pageLength": 10,

            })
            
            table.columns(3).every( function () {
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
            
            table.columns(2).every( function () {
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
        
        
    }


</script>
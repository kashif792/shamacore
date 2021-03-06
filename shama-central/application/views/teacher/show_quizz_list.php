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
<div ng-controller="class_quiz_ctrl">
<div id="myUserModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p>Are you sure you want to delete this quiz?</p>

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                <button type="button" id="UserDelete" class="btn btn-default " value="save">Yes</button>

            </div>

        </div>

    </div>

</div>

<div id="delete_modal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p>Are you sure you want to delete this quiz?</p>

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

                <h3 style="padding-left: 40px;">Quiz</h3>

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

                                <th>Subject Code</th>

                            </td>

                            <td id="user_email"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Grade Name</th>

                            </td>

                            <td id="user_acct_date"></td>

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

<div class="col-sm-10">

<?php

    // require_footer 

    require APPPATH.'views/__layout/filterlayout.php';

?>
    <div class="col-lg-12 widget">
        <div class="panel-heading plheading" id="widget-header">
            <!-- widget title -->
                <!-- <div class="widget-title"> -->
                    <h4>Quiz list
                        <a href="<?php echo $path_url; ?>addquizz" class="btn btn-primary" id="add-action">Add New Quiz</a>
                        </h4>
                <!-- </div> -->
            </div>
            <div class="widget-body">
                <div class="setting-container">
                    <div id="setting">          
                        
                        <div class="resp-tabs-container vert">                                                        
                            <?php //if(count($roles_right) > 0){ ?>
                            <div id="user-managment-tab">
                                <div class="action-element">
                                
                                </div>
                                <table class="table-body" id="table-body-phase-tow" >
                                    <thead>
                                        <tr>
                                    <th>Date</th>
                                            <th>Grade(Section) Name</th>
                                            <th>Subject Name</th>
                                            <th>Quiz Name</th>
                                           <!--  <th>Status</th> -->
                                             <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                     <tr>
                                  <th>Date</th>
                                            <th>Grade(Section) Name</th>
                                            <th>Subject Name</th>
                                            <th>Quiz Name</th>
                                           <!--  <th>Status</th> -->
                                             <th>Options</th>
                                        </tr>
                                    </tfoot>
                                    <tbody >

                                    </tbody>

                                </table>

                            </div>

                            <?php// } ?>

                        </div>

                    </div>  

                </div>

            </div>
    </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>This is a small modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


<?php

// require_footer 

require APPPATH.'views/__layout/footer.php';

?>
</div>
<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>
<script src="<?php echo base_url(); ?>js/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>js/vfs_fonts.js"></script>
<script src="<?php echo  base_url(); ?>js/ui-bootstrap-tpls-2.5.0.js"></script>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>



<script type="text/javascript">
    app.controller('class_quiz_ctrl',['$scope','$myUtils','$filter', class_quiz_ctrl]);

   function class_quiz_ctrl($scope, $myUtils,$filter) {
        $scope.user_id = $myUtils.getUserId();
        $scope.name = $myUtils.getUserName();
        $scope.email = $myUtils.getUserEmail();
        $scope.roles = $myUtils.getUserRoles();
        $scope.school_id = $myUtils.getDefaultSchoolId();
        $scope.session_id = $myUtils.getDefaultSessionId();
        

        var urlist = {
            getQuizList:'<?php echo SHAMA_CORE_API_PATH; ?>quizzes',
            
        }

        function getQuizListData()
        {
            try{
                //console.log(data);
                    $scope.data = [];
                    $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>quizzes',({school_id:$scope.school_id,user_id:$scope.user_id})).then(function(response){
                        $scope.data = [];

                        if(response[0]['listarray'] != null)
                        {
                            
                            for (var i=0; i<response[0]['listarray'].length; i++) {
                                $scope.data.push(response[0]['listarray'][i]);
                                
                                
                            }
                            //$("#inputDay").val(response[0]['data_array']['select_day']);
                            $("#table-body-phase-tow").dataTable().fnDestroy();
                            loaddatatable($scope.data);
                            
                        }
                        else{

                            $("#table-body-phase-tow").dataTable().fnDestroy();
                            loaddatatable($scope.data);
                         
                        }
                    });
                
            }
            catch(e){}
        }
        function loaddatatable(data)
        {
            var listdata= data;
            
            var table = $('#table-body-phase-tow').DataTable( {
                data: listdata,
                responsive: true,
                "order": [[ 0, "asc"  ]],
                rowId: 'id',
                columns: [
                    { data: 'quiz_date' },
                    { data: 'grade' },
                    { data: 'subject_name' },
                    { data: 'qname' },
                   
                    {
                     "className": '',
                     "orderable": false,
                     "data": null,

                     "defaultContent": "",
                     "render" : function ( data, type, full, meta ) {
                          if ( data != null && data != '') {
                             
                             return "<a href='<?php echo $path_url; ?>addquizz/"+data['id']+"'  ><i class='fa fa-edit' aria-hidden='true'></i></a> <a href='javascript:void(0)' id="+data['id']+" class='del'><i class='fa fa-remove' aria-hidden='true'></i></a>";
                         }
                         else {
                                 return;
                         }
                      }
                    },
                ],

                "pageLength": 10,

            })
            
          
            table.columns(1).every( function () {
                var column = this;
                var select = $('<select id="grade_id"><option value="">All</option></select>')
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
        getQuizListData();

        $(document).on('click','.del',function(){

            $("#delete_modal").modal('show');

            dvalue =  $(this).attr('id');

         

            row_slug =   $(this).parent().parent().attr('id');

            

        });
        $(document).on('click','#UserDelete',function(){

            $("#delete_modal").modal('hide');

            
            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>quiz";
            
            var data = 'id='+String(dvalue);
            urlpath += '?'+ data;
            
            ajaxType = 'DELETE';

            ajaxfunc(urlpath,[],userDeleteFailureHandler,loadUserDeleteResponse);

        });

    function userDeleteFailureHandler()

        {

            $(".user-message").show();
            message('Datesheet has been not deleted','show');
           

        }



        function loadUserDeleteResponse(response)

        {

            if (response.message === true){
                getQuizListData();
                
                message('Record has been deleted','show');

                

            } 

        }
   }    
</script>




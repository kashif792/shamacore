<?php 

// require_header 

require APPPATH.'views/__layout/header.php';



// require_top_navigation 

require APPPATH.'views/__layout/topbar.php';



// require_left_navigation 

require APPPATH.'views/__layout/leftnavigation.php';

?>


<!-- <div id="myUserModal" class="modal fade">

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

    </div> -->

<!-- </div>
 -->
<div class="col-sm-10" ng-controller="DeviceCtrl">

<?php

  // require_footer 

  require APPPATH.'views/__layout/filterlayout.php';

?>
    
<!-- <div class="modal fade new_form" id="lesson_plan_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Lesson Plan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Lesson</h4>
        <div id="example1"></div>
                 <div class="col-lg-12">
                    <div class="form-container">
                        <?php $attributes = array('name' => 'schedule_timetable', 'id' => 'schedule_timetable','class'=>'form-container'); echo form_open('', $attributes);?>
                            <input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial">


                            <fieldset>
                                 <div class="field-container ">

                                </div>

                                <div class="field-container ">
                                    <div class="field-row">

                                <div class="row"> 
                                        <div class="col-lg-4">
                                            <div class="upper-row">
                                                <label><span class="icon-address"></span> Class<span class="required"></span></label>
                                            </div>
                                                <select name="select_class" id="select_class"    >
                                                <?php 

                                                    if(count($classlist))
                                                    {  
                                                        foreach ($classlist as $key => $value) {
                                                            if(isset($value->id) && !empty($value->grade)){
                                                            ?>
                                                                 <option  value="<?php echo $value->id; ?>" <?php if($value->id==$classlist[0]->id) echo "selected";?>><?php echo $value->grade; ?></option>
                                                            <?php
                                                            }
                                                        }
                                                    }
                                                ?>

                                                
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="upper-row">
                                                <label><span class="icon-home-1"></span> Section <span class="required"></span></label>
                                            </div>
                                         <select   ng-options="item.name for item in sectionslist track by item.id"  name="inputSection" id="inputSection"  ng-model="inputSection" >
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="upper-row">
                                                <label><span class="icon-code"></span> Subjects <span class="required"></span></label>
                                            </div>
                                            <select ng-options="item.name for item in subjectlist track by item.id" name="select_subject" id="select_subject" ng-model="inputSubject"></select>
                                        </div>
                                     </div>
                                    </div>
                                </div>

                            </fieldset>

                        <?php echo form_close();?>
                    </div>
                </div>
                 <div id="example1"></div>
                      <div id="form-container">
                          <div class="columnLayout">

                            <div class="rowLayout">
                          <div class="descLayout">
                            <div class="pad" data-jsfiddle="example1">
                              <div id="exampleConsole" class="console"></div>

                           

                              <p>
                                
                                <button  type="button" id="export-file"  class="export_button">
                                    Export as a file
                          </button>
                          <button name="save" onclick="save()" id="save" class="intext-btn sve">Save</button>

                              </p>
                            </div>
                          </div>
                        </div>
                          </div>

                  
                </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div> -->
<?php 
 $roles = $this->session->userdata('roles');
?>
<div class="panel panel-default">
  <div class="panel-heading">
     <label>Tablet List
    <!--  <?php if( $roles[0]['role_id'] == 3){       ?>
       &nbsp;&nbsp;&nbsp;<a href="<?php echo $path_url; ?>newsubject" class="btn btn-primary" style="color: #fff !important;">Add Subject</a>
       <?php }?> -->
            </label>
  </div>
  <div class="panel-body">
     <table datatable="ng"  class="table table-striped table-bordered row-border hover" >
                    <thead>
                      <tr>
                        
                          <th>Device Name</th>
                          <th>Mac Address</th>
                          <th>Last Connected</th>
                           <th>Student Name</th>
                           <th>Class Name</th>
                          <th>Status</th> 
                      </tr>
                  </thead>
                    <tbody id="Tablets_table" class="report-body">
                      

                            <tr ng-repeat="t in Tablets_data">
                              
                                <td>
                                  {{t.Device_Name}}
                                </td>
                                  
                                <td>
                                  {{t.Mac_Address}}
                                </td>

                                <td>
                                  {{t.Last_Connected}}
                                </td>

                                 <td>
                                  {{t.Student_Name}}
                                </td>
                                  
                                <td>
                                  {{t.grade}}
                                </td>

                                
                                <td>
                                  <button class="clsActionButton" ng-click="blockuser(t)">
                                    <span ng-if="t.blocked == true">Unblock tablet</span>
                                    <span ng-if="t.blocked == false">Block tablet</span>
                                  </button>
                                </td> 

                            </tr>
                    

                            <tr ng-if="Tablets_data.length<=0"><td colspan='8'>No record found</td></tr>

                          </tbody>

                          </table>
  </div>
</div>

</div>

<?php

// require_footer 

require APPPATH.'views/__layout/footer.php';

?>


<link rel="stylesheet" href="<?php echo base_url(); ?>css/angular-datatables.css">
<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>


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
    $('input[name="inputDate"]').on('apply.daterangepicker', function(ev, picker) {alert()});
 


    
        
    $('#setting').easyResponsiveTabs({ tabidentify: 'vert' });
  });

</script>

<script>

    app.controller('DeviceCtrl',['$scope','$myUtils', DeviceCtrl]);

    function DeviceCtrl($scope, $myUtils) {

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

    
        function loaddatatable(elementint)

        {

          $('#'+elementint).DataTable( {

              responsive: true,
            
               "order": [[ 0, "asc"  ]],

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

              }

          });

        }
      
        $myUtils.httprequest("<?php echo SHAMA_CORE_API_PATH; ?>device_status").then(function successCallback(response) {
      
            // Store response data

             $scope.Tablets_data = response.data;


            //loaddatatable("table-body-phase-tow");
          });
     

        $scope.blockuser = function(t) {
                t.blocked = !t.blocked
                $myUtils.httppostrequest('<?php echo SHAMA_CORE_API_PATH; ?>block_device',{t}).then(function(response){
                    if(response != null && response.message == true)
                    {
                        $scope.Blockuser = {};
                    }else{
                       
                    }
                });
        }

  }

</script>


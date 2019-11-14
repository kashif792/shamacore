<?php

// require_header

require APPPATH . 'views/__layout/header.php';

require APPPATH . 'views/__layout/plan.php';

// require_top_navigation

require APPPATH . 'views/__layout/topbar.php';

// require_left_navigation

require APPPATH . 'views/__layout/leftnavigation.php';

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/isteven-multi-selects.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?php echo base_url();?>js/ng-tags-input.js"></script>
<script src="<?php echo base_url();?>js/angularjs-dropdown-multiselect.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/commonservice.js"></script>
<link href="<?php echo $path_url; ?>css/easy-responsive-tabs.css" rel="stylesheet">
<link href="<?php echo $path_url; ?>css/ng-tags-input.css" rel="stylesheet">
<link href="<?php echo $path_url; ?>css/ng-tags-input.bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/isteven-multi-select.css">



<a id="exportAnchorElem" style="display:none"></a>

<div id="myUserModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p>Are you sure you want to delete this parent?</p>

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                <button type="button" id="UserDelete" class="btn btn-default " value="save">Yes</button>

            </div>

        </div>

    </div>

</div>


<div class="col-sm-10 grade-lesson-plan-widget plan-widget modified-header" 
 ng-controller="lesson_plan_controller">

<?php
require APPPATH . 'views/__layout/filterlayout.php';
?>

  <div class="panel panel-default">
      <div class="panel-heading">
        <label>Grade lesson plans</label>
      </div>
      <div class="panel-body">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="form-container">
                        <?php
                          $attributes = array(
                            'name' => 'schedule_timetable',
                            'id' => 'schedule_timetable',
                            'class' => 'form-inline'
                          );
                          echo form_open('', $attributes); ?>
                          <input type="hidden" value="<?php
                          if ($this->uri->segment(2))
                          {
                            echo $this->uri->segment(2);
                          } ?>" name="serial" id="serial">
                          <fieldset>
                             <div class="form-group">
                                    <label for="class_id">Grade<span class="required"></span></label>
                                   <select   ng-options="item.grade for item in classlist track by item.id"  name="class_id" id="class_id" class="form-control" ng-model="class_id"></select>
                            </div>
                             <div class="form-group">
                              <label for="semester_id">Semester<span class="required"></span></label>
                               <select   ng-options="item.name for item in semesterlist track by item.id"  name="semester_id" id="semester_id"  class="form-control" ng-model="semester_id">
                                                                      </select>
                            </div>

                          </fieldset>     
                          <?php echo form_close(); ?>
                      </div>
                  </div>
              </div>

              <div class="imageloader"></div>
              <div id="example1"></div>

              <div class="sides-container">
                <div class="pagination left"  style="float: left;"></div>

                <div class="right" style="float: right;">
                  <label for="perpage">Items per page<span class="required"></span></label>
                   <select ng-options="item for item in perpagelist" name="perpage" id="perpage"  class="form-control" ng-model="perpage"></select>
                </div>
              </div>

              <div class="error-message">
                  <p>Plan data not found</p>
              </div>
              <div class="row" id="button_row">
                    <div class="col-sm-12">
                        <p>
                            <button  type="button" id="export-file"  class="export_button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Exporting...">Export</button>
                            <button name="save"  id="saveupdate2" ng-click="savegradeplan()" class="intext-btn sve" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                            <button name="Update"  id="UpdateLesson" class="intext-btn sve" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Updating...">Update</button>
                        </p>
                    </div>
              </div>
        </div>
    </div>

    <script type="text/ng-template" id="assignModalContent.html">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" ng-click="$dismiss()">&times;</button>
            <h5 class="modal-title">
                Assign a pre-requisite
            </h5>
        </div>
        <div class="modal-body">
            <div >
              <label for="select_subject">Select Subject<span class="required"></span></label>
               <select ng-options="item.name for item in subjectlist track by item.id" name="select_subject" id="select_subject"  class="form-control" ng-model="select_subject"></select>
            </div>
              <br>
            <div >
              <label for="select_prereq">Select Unit<span class="required"></span></label>

              <select ng-options="item.concept for item in unitlist track by item.id" name="select_prereq" id="select_prereq"  class="form-control" ng-model="select_prereq"></select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="assign_prereq">Assign</button>
        </div>
    </script>
</div>

<?php

// require_footer

require APPPATH . 'views/__layout/footer.php';

?>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/angular-datatables.css">

<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jwplayer.js"></script>
<script>jwplayer.key="/JmQcOJTGP/OIWIzj4RXqX/gpB1mVD9Br1vyxg==";</script>
<script src="<?php echo base_url(); ?>js/jquery.easyResponsiveTabs.js"></script>
<script src="<?php echo base_url();?>js/angular-messages.js"></script>
<script src="<?php echo base_url();?>js/ui-bootstrap-tpls-2.5.0.js"></script>
<script src="<?php echo base_url();?>js/dataTables.columnFilter.js"></script>
<script src="<?php echo base_url();?>js/angular-datatables.columnfilter.min.js"></script>
<script src="<?php echo base_url();?>js/isteven-multi-select.js"></script>

<link href="<?php echo base_url();?>css/cjquery-ui.css" rel="stylesheet">


<script data-require="ui-bootstrap@*" data-semver="0.12.1" src="<?php echo  base_url(); ?>js/ui-bootstrap-tpls-0.12.1.min.js"></script>

<style>
.hot-container {
    width: 500px;
    height: 500px;
    overflow: hidden;
}

#container{
  padding-left: 0 !important;
}
    .pagination {
      padding: 10px 0;
    }
    .pagination a {
      border: 1px solid grey;
      padding: 2px 5px;
    }
    .plan-widget #container{
      padding-left: 0 !important;
    }
</style>



<script type="text/javascript">


    app.controller('assignPrereqModalCtrl', ['$scope', '$modalInstance','$http','$filter', function ($scope, $modalInstance,$http,$filter) {
        


      $scope.unitlist = [];
       $(document).on('change','#select_subject',function(){
            $scope.unitlist = [];
            getUnitList();
        });

     $(document).on('click','#assign_prereq',function(){
            
            rowCount = $scope.hot.countRows();
            for(var loop=0; loop<rowCount; loop++){

              if($scope.hot.getDataAtCell(loop,5) == $scope.select_unit_id){

                if($scope.select_prereq){
                  console.log('Assign a pre req '+ $scope.select_prereq.id + ' to row '+ loop);
                  $scope.hot.setDataAtCell(loop, 2, $scope.select_prereq.concept);

                  $scope.hot.setDataAtCell(loop, 3, $scope.select_subject.name);

                  $scope.hot.setDataAtCell(loop, 6, $scope.select_prereq.id);
                }
                break;
              }
            }
          $modalInstance.dismiss();
      });

      $scope.select_subject = $scope.subjectlist[0];
      getUnitList();


      function getUnitList()
      {
        try{
          $scope.unitlist = $scope.defaultresponse.filter((unit) => (unit.subjectid === $scope.select_subject.id && unit.id!=$scope.select_unit_id));
        }
        catch(ex){}
      }

          function httprequest(url,data)
                {
                  var request = $http({
                    method:'GET',
                    url:url,
                    params:data,
                    headers : {'Accept' : 'application/json'}
                  });
                  return (request.then(responseSuccess,responseFail))
                }


    }]);

    app.controller('lesson_plan_controller', function($scope,$http,$interval,$modal) {

      $scope.lesson_header = [
      'Unit',
      'Subject',
      'Prereq',
      'Subject',''];


      $scope.perpagelist = [
      '20',
      '50',
      '100',
      'All'];
      $scope.perpage = '20';

      $scope.session_id = <?php echo $session_id ?>;
      $scope.school_id = <?php echo $school_id ?>;
      $scope.user_id = <?php echo $user_id ?>;

    function loader()
    {
        $(".imageloader").height($(".panel-body").height() - 20);  
        $(".imageloader").width($(".panel-body").width() + 30);
    }

    angular.element(function(){
      getClassList();   
    });


    $scope.assignPrereqModal = function()
    {

        $scope.assignModal =  $modal.open({
            templateUrl: 'assignModalContent.html',
            controller: 'assignPrereqModalCtrl',
            scope: $scope,
        });
    }


    $scope.is_document_changed = false;
    $(window).bind('beforeunload', function(){
        if($scope.is_document_changed == true)
        {
           return 'Do you want to discard changes and leave?';
        }

    });

     function getClassList()
      {
         var data = ({school_id:$scope.school_id, user_id:$scope.user_id})
        httprequest('<?php echo SHAMA_CORE_API_PATH; ?>classes',data).then(function(response){
          if(response != null && response.length > 0)
          {
            $scope.classlist = response
            $scope.class_id = response[0]
            getSubjectList();
          }
        });
      }

      $scope.subjectlist = [];
      $scope.page = 1;
      function getSubjectList()
      {
        try{
            var data = ({class_id:$scope.class_id.id,session_id:$scope.session_id})

            httprequest('<?php echo SHAMA_CORE_API_PATH; ?>subjects_by_class',data).then(function(response){
                if(response.length > 0 && response != null)
                {

                    $scope.subjectlist = response;
                    $scope.select_subject = response[0];
                    $scope.subjectNames = [];
                    for (var i = $scope.subjectlist.length - 1; i >= 0; i--) {
                      $scope.subjectNames[i] = $scope.subjectlist[i].subject;
                    }
                    
                    getSemesterData()

                }
                else{
                    $scope.subjectlist = [];

                }
            })

        }
        catch(ex){}
      }


      function getLessonList()
      {
        try{
            var data = ({class_id:$scope.class_id.id, subject_id:$scope.select_subject.id, session_id:$scope.session_id})

            httprequest('<?php echo SHAMA_CORE_API_PATH; ?>lessons',data).then(function(response){
                if(response.length > 0 && response != null)
                {
                    $scope.lessonlist = response;
                }
                else{
                    $scope.lessonlist = [];
                }
            })
        }
        catch(ex){}
      }


        function retriveData()
        {
          loader();
          $(".imageloader").show();
          get_data($scope.class_id.id,0,0,$scope.semester_id.id);

        }

      function getSemesterData(){
        try{
          $scope.semesterlist = []
          httprequest('<?php echo SHAMA_CORE_API_PATH; ?>semesters',({}))
          .then(function(response){
            if(response.length > 0 && response != null)
            {
              $scope.semesterlist = response;
              for (var i = 0; i <= response.length - 1; i++) {

                  if(response[i].status == 'a')
                  {

                       $scope.semester_id = response[i];
                        retriveData()
                  }
              }



            }
            else{
              $scope.semesterlist = [];
            }
          })

        }
        catch(ex){}
      }


       $(document).on('change','#perpage',function(){
            updatePagination();
            initobj();
        });

        $(document).on('change','#semester_id',function(){
             try{
                 $scope.page = 1
              $scope.loading_data = 1;
              retriveData()
            }
            catch(ex){}
        })

        $(document).on('change','#class_id',function(){
             try{
                $scope.loading_data = 1;
                getSemesterData();
            }
            catch(ex){}
        })



      function httprequest(url,data)
      {
        var request = $http({
          method:'GET',
          url:url,
          params:data,
          headers : {'Accept' : 'application/json'}
        });
        return (request.then(responseSuccess,responseFail))
      }


      function responseSuccess(response){
        return (response.data);
      }

      function responseFail(response){
        return (response.data);
      }


        var $container = $("#example1"),
          $parent = $container.parent(),
          autosaveNotification;

        var change=1;
        var part = [];

        $scope.loading_data = 1;

        function get_data(class_id,subject_id,section_id,semester_id)
        {
            try{
                part = []
                var userdata = []

                $.ajax({
                    url: '<?php echo SHAMA_CORE_API_PATH; ?>/grade_lesson_plan',
                    type: 'GET',
                    dataType: 'json',
                    data: {class_id:class_id,semester_id:semester_id,session_id:$scope.session_id,school_id:$scope.school_id},
                    success: function (res) {
                        if(typeof res != 'undefined' && res && res.length > 0)
                        {
                            $scope.defaultresponse = res;
                            updatePagination();
                            initobj();
                            $scope.loading_data = 2;
                            message('','hide');
                            $(".error-message").hide();
                            $("#button_row").show();
                        }else{
                            $scope.defaultresponse = [];
                            $(".pagination").html('')
                            $scope.loading_data = 2;
                            message('No data found','show')
                            $(".imageloader").hide();
                            $(".error-message").show();
                            $("#button_row").hide();
                            initobj();
                        }
                        
                    },
                    error:function(error){}
                });
                $scope.loading_data = 2;
            }
            catch(e)
            {
              console.log(e)
            }
        }
                
        var priorityarray = [];

        function updatePagination(){

          $(".pagination").html('')
            var total_pages;
            if($scope.perpage == 'All'){
              total_pages = 0;
            }else{
              total_pages = parseInt($scope.defaultresponse.length - 1) / parseInt($scope.perpage)
            }

            if(total_pages >= 1){
                $(".pagination").html('')
                for (var i = 0; i <= total_pages; i++) {
                    var curiter = i + 1
                    $(".pagination").append('<li><a href="#'+curiter+'">'+curiter+'</a></li>')
                }
            }
        }

         function getPaginationData()
          {
            var part  = [];
            if($scope.defaultresponse.length > 0)
            {
              var limit;
              if($scope.perpage == 'All'){
                limit = $scope.defaultresponse.length;
              }else{
                limit = parseInt($scope.perpage);
              }
              
                var page  = $scope.page,
                  row   = (page - 1) * limit,
                  count = page * limit;

                $(".pagination li").removeClass('active')
                $(".pagination li:nth-child("+page+")").addClass('active')

                for (; row < count && row< $scope.defaultresponse.length; row++) {

                   var temp = []

                   temp.push($scope.defaultresponse[row].concept)
                   temp.push($scope.defaultresponse[row].subject)
                   temp.push($scope.defaultresponse[row].prereq_concept)
                   temp.push($scope.defaultresponse[row].prereq_subject)

                   temp.push('&nbsp;<a><i id="assign_prereq_open" data-row-id ="' + row + '" data-btn-id ="' + $scope.defaultresponse[row].id + '" class="fa fa-pencil aria-hidden=" true"=""></i></a>&nbsp;<a><i id="unassign_prereq"  data-row-id ="' + row + '" data-btn-id ="' + $scope.defaultresponse[row].id + '" class="fa fa-remove aria-hidden=" true"=""></i></a>')

                   temp.push($scope.defaultresponse[row].id)
                   temp.push($scope.defaultresponse[row].prereq_id)

                   var num = parseInt(row);
                   priorityarray.push(num.toString())
                   part.push(temp);
                }
              }
              //console.log(part)
              return part;
        }

        $scope.hot = null;
        var container = document.getElementById('example1')
          Handsontable.Dom.addEvent(window, 'hashchange', function (event) {
           $scope.page = parseInt(window.location.hash.replace('#', ''), 10)
           initobj();
          });

         Handsontable.Dom.addEvent(window, 'resize', calculateSize);

         function calculateSize()
         {

         }

          function initobj()
            {
                 var hotSettings = {
                    data: getPaginationData(),
                    colHeaders: $scope.lesson_header,
                    rowHeaders: true,
                    contextMenu: ['remove_row'],
                    manualRowResize: true,
                    columnSorting: false,
                    sortIndicator: true,
                    autoWrapCol :false,
                    autoColSize: true,
                    autoWrapRow: true,
                    dropdownMenu: true,
                    rowHeaders: true,
                    manualRowMove: true,
                    viewportColumnRenderingOffset: 10,
                    width: $(".panel").width(),
                    height: ($scope.defaultresponse.length < 10 ? 200 : 500 ),
                    columns: [
                        {//concept
                          data: 0
                        },
                        {//subject
                          type: 'dropdown',
                          source: $scope.subjectNames
                        },
                        {// prereq concept
                          data: 2
                        },
                        {//prereq subject
                          data: 3,
                        },
                        {// prereq options
                          renderer: "html", readOnly: true
                        },
                        {// unit id
                          readOnly: true,
                          width: 1
                        },
                        {// prereq id
                          data: 6,
                          width: 1
                        }
                    ],

                    beforeRemoveRow:function(index,amount)
                    {
                       
                       var id = $("#example1").handsontable('getDataAtCell',index,5);
                       if(id==null || id==''){
                        console.log('Empty Row removed');
                        return;
                       }
                       console.log('Unit to be removed is ' + id);
                       //alert('row id is ' + id);
                       
                       var data = {

                            id:id,
                        }

                         $.ajax({
                         url:'<?php echo SHAMA_CORE_API_PATH; ?>grade_lesson',
                          type: 'DELETE',
                          dataType: "JSON",
                          data: {data:data,candelete:true},
                          success: function(res){
                            retriveData();
                          },
                          error: function(){
                            alert("Fail")
                          }});

                    },

                    afterAddRow:function(index,amount)
                    {
                      //  $('#example1').handsontable('setDataAtCell', index, 0, 'new value');
                      
                    },
                    afterRowMove:function(rows,target)
                    {
                      
                    },

                  afterChange: function (change, source)
                   {
                    if (source === 'loadData') {
                        return; //don't save this change
                    }

                    $scope.is_document_changed = true;
                    
                },

              };

              var hotElement = document.querySelector('#example1');
              if($scope.hot!=null){
                $scope.hot.destroy();
              }
              $scope.hot = new Handsontable(hotElement, hotSettings);
              //hot = $("#example1").handsontable(hotSettings);
              //var handsontable = $("#example1").data('handsontable');
              $(".imageloader").hide();
          }
          
          $scope.savegradeplan = function(){
              var class_id=$("#class_id").val();
              var semester_id=$("#semester_id").val();
              //var jsonString = JSON.stringify($("#example1").data('handsontable').getData());
              var jsonString = JSON.stringify($scope.hot.getData());
              var $this = $("#saveupdate2");

              $scope.is_document_changed = false;
              $this.button('loading');
              $.ajax({
                  url:'<?php echo SHAMA_CORE_API_PATH; ?>grade_lesson_plan',
                  type: 'POST',
                   dataType: "json",
                   beforeSend: function(x) {
                      if(x && x.overrideMimeType) {
                          x.overrideMimeType("application/json;charset=UTF-8");   
                      }
                  },
                  data: {data:jsonString,candelete:true,class_id:class_id,semester_id:semester_id,session_id:$scope.session_id,school_id:$scope.school_id},
                  success: function(res){
                    console.log(res.message)
                    if(res.message == true)
                    {
                      $this.button('reset');
                      part=[];
                      retriveData();
                    }
                    else{
                      message("Data not saved","show");
                    }
                  },
                  error: function(){
                      alert("Fail")

          $this.button('reset');
                  }
              });
          }

      $scope.select_unit_id = 0;
     $(document).on('click','#assign_prereq_open',function(){
            $scope.select_unit_id = $(this).attr('data-btn-id'); 
            //$scope.select_row = $(this).attr('data-row-id'); 
            $scope.assignPrereqModal();
      });
     $(document).on('click','#unassign_prereq',function(){
            //row = $(this).attr('data-row-id'); 
            id = $(this).attr('data-btn-id'); 
            
            //var ht = $("#example1").data('handsontable');
            rowCount = $scope.hot.countRows();
            for(var loop=0; loop<rowCount; loop++){

              if($scope.hot.getDataAtCell(loop,5) == id){
                console.log('Unassign a pre req from row '+ loop);
                $scope.hot.setDataAtCell(loop, 2, '');

                $scope.hot.setDataAtCell(loop, 3, '');

                $scope.hot.setDataAtCell(loop, 6, null);
                break;
              }
          }
      });


     $(document).on('click','.export_button',function(){

        	  var class_id=$("#class_id").val();
              var semester_id=$("#semester_id").val();
              var $this = $(this);

              var fileName = $("#class_id option:selected").text() + "_" + $("#semester_id option:selected").text();
              fileName = "grade_lesson_plan_" + fileName.replace(/ /g, '_') + ".xls";

            $this.button('loading');
              $.ajax({
                     url:'<?php echo SHAMA_CORE_API_PATH; ?>export_grade_lesson_plan',
                      type: 'GET',
                      dataType: 'json',
                      data: {class_id:class_id,semester_id:semester_id,session_id:$scope.session_id},
                      success: function(data){
                            var downloader = document.getElementById('exportAnchorElem');
                            downloader.setAttribute('href', data.file);
                            downloader.setAttribute('download', fileName);
                            downloader.click();
                            $this.button('reset');
                      },
                    error: function(){
                     alert("Fail")

                    $this.button('reset');
                  }
                });

      });


      $(document).on('click','#UpdateLesson',function(){

              var class_id=$("#class_id").val();
              var semester_id=$("#semester_id").val();
               var $this = $(this);
            $this.button('loading');

                    $.ajax({
                     url:'<?php echo SHAMA_CORE_API_PATH; ?>sync_grade_lesson_plan',
                      type: 'POST',
                      data: {class_id:class_id,semester_id:semester_id,session_id:$scope.session_id,school_id:$scope.school_id},
                      success: function(res){

                     $this.button('reset');
                       part=[];
                        retriveData();
                      },
                        error: function(){
                          $this.button('reset');
                     alert("Fail")
                  }

            });
      });


      $(document).on('click','#DeleteLesson',function(){

              var class_id=$("#class_id").val();
              var semester_id=$("#semester_id").val();
              var DeleteLessonPlan=true;
               var $this = $(this);

            $this.button('loading');


              // alert(classid);


                    $.ajax({
                     url:'<?php echo SHAMA_CORE_API_PATH; ?>grade_lesson_plan',
                      type: 'DELETE',
                      data:$("#schedule_timetable").serializeArray(),
                      success: function(res){

                        $this.button('reset');
                           	part=[];
                         	retriveData();
                      },
                        error: function(){
                          $this.button('reset');
                         alert("Fail")
                      }
                });

      });


 });

</script>
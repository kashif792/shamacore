<?php

// require_header

require APPPATH.'views/__layout/header.php';


// require_top_navigation

require APPPATH.'views/__layout/topbar.php';



// require_left_navigation

require APPPATH.'views/__layout/leftnavigation.php';

?>


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
<div class="col-sm-10 semester-lesson-plan-widget plan-widget modified-header"  ng-controller="lessonCtrl">

<?php

  require APPPATH.'views/__layout/filterlayout.php';

?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <label>Semester Wise Lessons</label>
    </div>
    <div class="panel-body">
        <div class="row">
                <div class="col-lg-12">
                    <div class="form-container">
                        <?php $attributes = array('name' => 'schedule_timetable', 'id' => 'schedule_timetable','class'=>'form-inline'); echo form_open('', $attributes);?>
                            <input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial">
                            <fieldset>
                             <div class="form-group">
          <label for="class_id">Grade<span class="required"></span></label>
         <select   ng-options="item.name for item in classlist track by item.id"  name="class_id" id="class_id" class="form-control" ng-model="class_id"></select>
  </div>

                          <div class="form-group">
    <label for="section_id">Section<span class="required"></span></label>
     <select   ng-options="item.name for item in sectionslist track by item.id"  name="section_id" id="section_id" class="form-control"  ng-model="section_id" >
                                            </select>
  </div>

                       <div class="form-group">
    <label for="subject_id">Subject<span class="required"></span></label>
     <select ng-options="item.name for item in subjectlist track by item.id" name="subject_id" id="subject_id"  class="form-control"ng-model="inputSubject"></select>
  </div>

                   <div class="form-group">
    <label for="semester_id">Semester<span class="required"></span></label>
     <select   ng-options="item.name for item in semesterlist track by item.id"  name="semester_id" id="semester_id"  class="form-control" ng-model="semester_id">
                                            </select>
  </div>


                            </fieldset>
                        <?php echo form_close();?>
                    </div>
                </div>
                </div>

                <div class="imageloader"></div>
                    <div id="example1"></div>
                    <div class="pagination"></div>
                    <div class="error-message">
                        <p>Semester data not found</p>
                    </div>
                   <div class="row">
                        <div class="col-sm-12">
                            <p>
                                <span id="button_row">
                                <button  type="button" id="export-file"  class="export_button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Exporting...">Export</button>
                                <button name="save"  id="saveupdate2" ng-click="savesemesterplan()" class="intext-btn sve" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                                </span>

                                <button name="Update"  id="UpdateLesson" class="intext-btn sve" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Updating...">Update</button>
                                <!-- <button name="Delete"  id="DeleteLesson" class="intext-btn sve" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Loading...">Reset</button> -->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>

  .navbar-nav.navbar-right:last-child {
    margin-right: 0;
    position: relative;
    top: -53px;
    right: -31px;
  }

  .hot-container {
    overflow: auto;
  }

  #container {
    padding-left: 0 !important;
    padding-bottom: 0 !important;
  }

  .pagination {
    padding: 10px 0;
    margin: 0;
  }

  .pagination a {
    border: 1px solid grey;
    padding: 2px 5px;
  }

  .plan-widget #container {
    padding-left: 0 !important;
  }
</style>


  
  <link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>js/excel/demo/css/samples.css?20140331">

  <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>js/excel/demo/js/highlight/styles/github.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>js/excel/demo/css/font-awesome/css/font-awesome.min.css">

  <link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>js/excel/dist/handsontable.css">

  <link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>js/excel/dist/pikaday/pikaday.css">
  
  <script data-jsfiddle="common" src="<?php echo base_url(); ?>js/excel/dist/pikaday/pikaday.js"></script>
  
  <script data-jsfiddle="common" src="<?php echo base_url(); ?>js/excel/dist/moment/moment.js"></script>
  
  <script data-jsfiddle="common" src="<?php echo base_url(); ?>js/excel/dist/zeroclipboard/ZeroClipboard.js"></script>
  
  <script data-jsfiddle="common" src="<?php echo base_url(); ?>js/excel/dist/numbro/numbro.js"></script>
  
  <script data-jsfiddle="common" src="<?php echo base_url(); ?>js/excel/dist/handsontable.js"></script>

<?php

// require_footer

require APPPATH.'views/__layout/footer.php';

?>

<script type="text/javascript">

  var dvalue ;

  $(document).ready(function(){

    $(".table-choice").show();


    loaddatatable();

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

  });

</script>
<script>

    app.controller('lessonCtrl',['$scope','$myUtils', lessonCtrl]);

    function lessonCtrl($scope, $myUtils) {

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

        $scope.is_master_teacher = $myUtils.isPrincipal();

    function loader()
    {
       $(".imageloader").height($(".panel-body").height() - 20);  
      $(".imageloader").width($(".panel-body").width() + 30);
    }


    $scope.is_document_changed = false;
       
    angular.element(function(){

      getClassList();
       
    });
       
    $(window).bind('beforeunload', function(){
        if($scope.is_document_changed == true)
        {
           return 'Are you sure you want to leave?';
        }

    });

       function getClassList()
        {
           var data = ({school_id:$scope.school_id, user_id:$scope.user_id})
          $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>classes',data).then(function(response){
            if(response != null && response.length > 0)
            {
              $scope.classlist = response
              $scope.class_id = response[0]
             loadSections()

            }
          });
        }




      $scope.subjectlist = [];
       $scope.page = 1;
      function getSubjectList()
      {
        try{
            var data = ({class_id:$scope.class_id.id, session_id:$scope.session_id, user_id:$scope.user_id})

            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>subjects_by_class',data).then(function(response){
                if(response.length > 0 && response != null)
                {
                    $scope.inputSubject = response[0];

                    $scope.subjectlist = response;
                    getSemesterData()

                }
                else{
                    $scope.subjectlist = [];

                }
            })


        }
        catch(ex){}
      }

        function retriveData()
        {
          loader()
          $(".imageloader").show();
          get_data($scope.class_id.id,$scope.inputSubject.id,$scope.section_id.id,$scope.semester_id.id);


        }


        function loadSections()
        {

            try{
                var data = ({class_id:$scope.class_id.id, user_id:$scope.user_id})

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>sections_by_class',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.section_id = response[0];
                        $scope.sectionslist = response;
                        getSubjectList();
                    }
                    else{
                        $scope.sectionslist = [];


                    }
                })
            }
            catch(ex){}
        }


      function getSemesterData(){
      try{
        $scope.semesterlist = []
        $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>semesters',({})).then(function(response){
        	if(response.length > 0 && response != null)
            {
                if($scope.role_id == 3 || $scope.is_master_teacher){
                	$scope.semesterlist = response;
                }else{
                	$scope.semesterlist = [];
                }
              
              for (var i = 0; i <= response.length - 1; i++) {

                  if(response[i].status == 'a')
                  {    
                	  if($scope.role_id == 3 || $scope.is_master_teacher){
                	  }else{
                    	   $scope.semesterlist[0] = response[i]; // restrict teacher to current semester only
                       }
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

                var data = ({inputclassid:parseInt($("#class_id").val())})
                $scope.loading_data = 1;
                loadSections()
            }
            catch(ex){}
        })

          $(document).on('change','#section_id',function(){
              try{
                $scope.loading_data = 1;
                getSubjectList()
              }
              catch(ex){}
            })

         $(document).on('change','#subject_id',function(){
          $scope.loading_data = 1;
          retriveData()

  });


            var
              $container = $("#example1"),
              $parent = $container.parent(),
              autosaveNotification,
              hot;

                var change=1;
              var part = [];

              $scope.loading_data = 1;

            function get_data(class_id,subjectid,sectionid,semester_id)
            {
                try{
                    part = []
                    var userdata = []

                    $.ajax({
                        url: '<?php echo SHAMA_CORE_API_PATH; ?>semester_lesson_plan',
                        type: 'GET',
                        dataType: 'json',
                        data: {class_id:class_id,section_id:sectionid,subject_id:subjectid,session_id:$scope.session_id,semester_id:semester_id,school_id:$scope.school_id, user_id:$scope.user_id},
                        success: function (res) {
                            if(typeof res != 'undefined' && res && res.length > 0)
                            {
                                $scope.defaultresponse = [];
                                if(res.length > 0){
                                  $(".pagination").html('')
                                    $scope.defaultresponse = res
                                    var total_pages = parseInt(res.length - 1) / 20
                                    if(total_pages >= 1){
                                        $(".pagination").html('')
                                        for (var i = 0; i <= total_pages; i++) {
                                            var curiter = i + 1
                                            $(".pagination").append('<li><a href="#'+curiter+'">'+curiter+'</a></li>')
                                        }
                                    }
                                    initobj();
                                    $scope.loading_data = 2;
                                    message('','hide');
                                    $(".error-message").hide();
                                    $("#button_row").show();
                                }
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

               function getPaginationData()
              {
                if($scope.defaultresponse.length > 0)
                {
                  var page  = $scope.page
                      limit = 20,
                      row   = (page - 1) * limit,
                      count = page * limit,
                      part  = [];

                    $(".pagination li").removeClass('active')
                    $(".pagination li:nth-child("+page+")").addClass('active')

                    for (; row < count && row< $scope.defaultresponse.length; row++) {

                      var temp = []

                       temp.push($scope.defaultresponse[row].read_date)
                       temp.push($scope.defaultresponse[row].concept)
                       temp.push($scope.defaultresponse[row].topic)
                       temp.push($scope.defaultresponse[row].lesson)
                       temp.push($scope.defaultresponse[row].type)

                      temp.push($scope.defaultresponse[row].content.trim())
                      temp.push($scope.defaultresponse[row].preference)


                       temp.push($scope.defaultresponse[row].id)
                       var num = parseInt(row);
                       priorityarray.push(num.toString())
                      part.push(temp);
                    }


                    return part;
                  }
                  else{
                      var temp = []
                      return temp;
                  }
            }

            var hot ;
            var container = document.getElementById('example1')
              Handsontable.Dom.addEvent(window, 'hashchange', function (event) {
               $scope.page = parseInt(window.location.hash.replace('#', ''), 10)
               initobj();
              });

             Handsontable.Dom.addEvent(window, 'resize', calculateSize);

            function calculateSize()
            {

            }


            $scope.lesson_header = ['Date', 'Concept','Topic', 'Lesson','Type','Content', 'Preference'];

            function initobj()
            {
                var container = $("#example1").handsontable({
                    data: getPaginationData(),
                    colHeaders: (getPaginationData().length > 0 ? $scope.lesson_header : []),
                    rowHeaders: true,
                    contextMenu: ['remove_row'],
                    manualRowResize: true,
                    columnSorting: true,
                    sortIndicator: true,
                    autoWrapCol :true,
                    autoColSize: true,
                    autoWrapRow: true,
                    dropdownMenu: true,
                    rowHeaders: true,
                    manualRowMove: true,
                    readOnly: $scope.role_id==3?false:true,
                    width: $(".panel").width(),
                    height: ($scope.defaultresponse.length < 10 ? 200 : 500 ) ,
                    columns: [
                        {
                            type: 'date',
                            dateFormat: 'YYYY/MM/DD',
                            correctFormat: true,
                            width:1
                        },
                        {data: 1},
                        {},
                        {data:3},
                        {
                            type: 'dropdown',
                            source: ['Document', 'Video', 'Image', 'Text','Application','Game']
                        },
                        {},
                        {
                            type: 'dropdown',
                            source: priorityarray,
                            width:1
                        },
                        {data:7, width:1},
                    ],

                  beforeRemoveRow:function(index,amount)
                  {
                   for (var i = amount - 1; i >= 0; i--) {
                     console.log(index[i])
                   };
                     var idRow = $("#example1").handsontable('getDataAtRow',index,1);
                            
                             $.ajax({
                             url:'<?php echo SHAMA_CORE_API_PATH; ?>semester_lesson',
                              type: 'DELETE',
                              dataType: "JSON",
                              data: {id:idRow[7], user_id:$scope.user_id},
                              success: function(res){

                              },
                                error: function(){
                             alert("Fail")
                          }});

                  },
                  afterChange: function (change, source)
                   {
                    if (source === 'loadData') {
                        return; //don't save this change
                    }

                    if(change[0][2] != change[0][3])
                    {
                       $scope.is_document_changed = true;
                    }

                },

              });

               var $container = $("#example1");
              var handsontable = $container.data('handsontable');
              $(".imageloader").hide();

          }
          
            $scope.savesemesterplan = function(){
                var class_id=$("#class_id").val();
                var sectionid=$("#section_id").val();
                var subjectid=$("#subject_id").val();
                var semesterid=$("#semester_id").val();
                var $container = $("#example1");
                var jsonString = JSON.stringify($container.data('handsontable').getData());
              
                 var $this = $("#saveupdate2");
                 $scope.is_document_changed = false;
                $this.button('loading');
                $.ajax({
                    url:'<?php echo SHAMA_CORE_API_PATH; ?>semester_lesson_plan',
                    type: 'POST',
                     dataType: "json",
                     beforeSend: function(x) {
                        if(x && x.overrideMimeType) {
                            x.overrideMimeType("application/json;charset=UTF-8");   
                        }
                    },
                    data: {data:jsonString,candelete:true,class_id:class_id,section_id:sectionid,subject_id:subjectid,semester_id:semesterid,session_id:$scope.session_id, user_id:$scope.user_id},
                    success: function(res){
                      if(res.message == true)
                      {
                        $this.button('reset');
                        part=[];
                        retriveData()
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

     $(document).on('click','.export_button',function(){

        var class_id=$("#class_id").val();
             var section_id=$("#section_id ").val();
              var subject_id=$("#subject_id").val();
              var semester_id=$("#semester_id").val();
               var $this = $(this);

              var fileName = $("#class_id option:selected").text() + "_" + $("#subject_id option:selected").text() + "_" + $("#semester_id option:selected").text();
              fileName = "semester_lesson_plan_" + fileName.replace(/ /g, '_') + ".xls";

            $this.button('loading');
              $.ajax({
                     url:'<?php echo SHAMA_CORE_API_PATH; ?>export_semester_lesson_plan',
                      type: 'GET',
                      dataType: 'json',
                      data: {class_id:class_id,section_id:section_id,subject_id:subject_id,session_id:$scope.session_id,semester_id:semester_id, user_id:$scope.user_id},
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
              var section_id=$("#section_id").val();
              var subject_id=$("#subject_id").val();
              var semester_id=$("#semester_id").val();
               var DeleteLessonPlan=false;
               var $this = $(this);
            $this.button('loading');

              // alert(class_id);

                    $.ajax({
                     url:'<?php echo SHAMA_CORE_API_PATH; ?>sync_semester_lesson_plan',
                      type: 'POST',
                      dataType: 'json',
                      data: {class_id:class_id,section_id:section_id,subject_id,semester_id:semester_id,session_id:$scope.session_id, user_id:$scope.user_id},
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
              var sectionid=$("#section_id").val();
              var subjectid=$("#subject_id").val();
              var semesterid=$("#semester_id").val();
              var DeleteLessonPlan=true;
               var $this = $(this);

            $this.button('loading');

              // alert(class_id);

                    $.ajax({
                     url:'<?php echo SHAMA_CORE_API_PATH; ?>semester_lesson_plan',
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

 }

</script>

<?php

// require_header
require APPPATH . 'views/__layout/header.php';

// require_top_navigation

require APPPATH . 'views/__layout/topbar.php';

// require_left_navigation

require APPPATH . 'views/__layout/leftnavigation.php';

?>



<a id="exportAnchorElem" style="display: none"></a>

<div class="col-sm-10 dplan-widget plan-widget modified-header"
	ng-controller="lessonCtrl">

<?php

// require_footer

require APPPATH . 'views/__layout/filterlayout.php';

?>
  <div id="myUserModal" class="modal fade">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">&times;</button>

					<h4 class="modal-title">Confirmation</h4>

				</div>

				<div class="modal-body">

					<p>Are you sure you want to delete this plan?</p>

				</div>

				<div class="modal-footer">

					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>

					<button type="button" id="DeleteLesson" class="btn btn-default "
						value="save">Yes</button>

				</div>

			</div>

		</div>

	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<label>Default lesson plans</label>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">

                        <?php $attributes = array('name' => 'schedule_timetable', 'id' => 'schedule_timetable','class'=>'form-inline'); echo form_open_multipart('', $attributes);?>
                            <input type="hidden"
						value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>"
						name="serial" id="serial">
					<div class="form-group">
						<label for="select_class">Grade <span class="required"></span></label>
						<select
							ng-options="item.name for item in classlist track by item.id"
							name="select_class" id="select_class" ng-model="select_class"></select>
					</div>
					<div class="form-group">
						<label for="select_subject">Subject<span class="required"></span></label>
						<select
							ng-options="item.name for item in subjectlist track by item.id"
							name="select_subject" id="select_subject" ng-model="inputSubject"></select>
					</div>
					<div class="form-group">
						<label for="inputSemester">Semester<span class="required"></span></label>
						<select
							ng-options="item.name for item in semesterlist track by item.id"
							name="inputSemester" id="inputSemester" ng-model="inputSemester"
							my-repeat-directive>
						</select>
					</div>
					<div class="form-group">
						<label for="file">Import<span class="required"></span></label> <input
							type="file" name="file" id="file" class="form-control">
					</div>
					<div class="form-group">
						<button type="button" class="nowsave" data-loading-text="<i 
							class='fa fa-circle-o-notch fa-spin'>
							</i> Uploading...">Upload
						</button>
					</div>

                        <?php echo form_close();?>

                </div>
			</div>

			<div class="imageloader"></div>
			<!-- <div class="sam">  -->
			<div id="container">

				<div class="columnLayout">
					<div class="rowLayout">
						<div class="descLayout">
							<div class="pad" data-jsfiddle="example1">
								<div id="exampleConsole" class="console"></div>

								<div id="example1"></div>
								<div class="pagination"></div>


							</div>
						</div>
					</div>
				</div>

				<!-- </div> -->
			</div>

			<div class="row">
				<div class="col-sm-12">

					<p>
						<button type="button" id="export-file" class="export_button"
							data-loading-text="<i  class='fa fa-circle-o-notch fa-spin'>
							</i> Exporting..."> Export
						</button>
						<button name="save" id="saveupdate" class="intext-btn sve"
							data-loading-text="<i  class='fa fa-circle-o-notch fa-spin'>
							</i> Saving...">Save
						</button>

						<button name="Delete" id="DeleteLesson3"
							class="del intext-btn sve" data-loading-text="<i 
							class='fa fa-circle-o-notch fa-spin'>
							</i> Deleting...">Delete Default Plan
						</button>
					</p>
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

require APPPATH . 'views/__layout/footer.php';

?>

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

    $scope.is_document_changed = false;
    
    $(window).bind('beforeunload', function(){
        if($scope.is_document_changed == true)
        {
           return 'Are you sure you want to leave?';
        }

    });
    function loader()
    {
       $(".imageloader").height($(".panel-body").height() - 25);  
      $(".imageloader").width($(".panel-body").width() + 30);
    }
    angular.element(function(){
      getClassList();
      getSemesterData()
       
    });

     function getClassList()
        {
            var data = ({school_id:$scope.school_id, user_id:$scope.user_id})

          $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>classes',data).then(function(response){
            if(response != null && response.length > 0)
            {
              $scope.classlist = response
              $scope.select_class = response[0]
             getSubjectList()

            }
          });
        }


     // loadSections() ;
      $scope.page = 1;
      $scope.subjectlist = [];
      function getSubjectList()
      {
        try{
          
            var data = ({class_id:$scope.select_class.id, session_id:$scope.session_id,semester_id:$scope.inputSemester.id})

            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>subjects_by_class',data).then(function(response){
                if(response.length > 0 && response != null)
                {
                    $scope.inputSubject = response[0];

                    $scope.subjectlist = response;
                    retriveData()
                }
                else{
                  $scope.loading_data = 2;
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
             get_data($scope.select_class.id,$scope.inputSubject.id,$scope.inputSemester.id);

        }

         $(document).on('change','#select_subject',function(){
              $scope.page = 1
              $scope.loading_data = 1;
              retriveData()

          });

        function loadSections()
        {

            try{
                var data = ({class_id:$("#select_class").val(), role_id:$scope.role_id, user_id:$scope.user_id})

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>sections_by_class',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.inputSection = response[0];
                        $scope.sectionslist = response;

                    }
                    else{
                        $scope.sectionslist = [];
                    }
                })
            }
            catch(ex){}
        }

        $(document).on('change','#select_class',function(){
             try{
              $scope.loading_data = 1;
                 $scope.page = 1
                getSubjectList()
            }
            catch(ex){}
        })




$(document).on('click','.del',function(){

            $("#myUserModal").modal('show');

            dvalue =  $(this).attr('id');

        });




		$(document).on('click','#DeleteLesson',function(){

              var class_id=$("#select_class").val();
            
              var subjectid=$("#select_subject").val();
              var semesterid=$("#inputSemester").val();
              var DeleteLessonPlan=true;
               var $this = $(this);

            $this.button('loading');

              // alert(class_id);
            var data ={
              class_id:class_id,
              subject_id:subjectid,
              semester_id:semesterid
            }
            $.ajax({
                 url:'<?php echo SHAMA_CORE_API_PATH; ?>default_lesson_plan',
                 type: 'DELETE',
                 data:data,
                 success: function(res){
    
                    $("#myUserModal").modal('hide');
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



        $(document).on('change','#inputSemester',function(){
             try{
              $scope.loading_data = 1;
                 $scope.page = 1
                 getSubjectList()
                retriveData()
            }
            catch(ex){}
        })

      function getSemesterData(){
      try{

        $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>semesters',({school_id:$scope.school_id})).then(function(response){
          if(response.length > 0 && response != null)
          {
            $scope.semesterlist = response;
            for (var i = 0; i < response.length; i++) {
                if(response[i].status == 'a')
                {
                     $scope.inputSemester = response[i];
                }
            }
            getSubjectList()


          }
          else{
            $scope.semesterlist = [];
          }
        })

         


      }
      catch(ex){}
    }

    var
      $container = $("#example1"),
      $parent = $container.parent(),
      autosaveNotification,
      hot;

        var change=1;
        var part = [];




        $scope.defaultresponse = []

     $scope.loading_data = 1;

      function get_data(class_id,subjectid,inputSemester)
       {

        $scope.loading_data = 1;
        part = []
        var userdata = [

        ]
          $.ajax({
            url: '<?php echo SHAMA_CORE_API_PATH; ?>default_lesson_plan',
             type: 'GET',
            dataType: 'json',

            data: {class_id:class_id,subject_id:subjectid,semester_id:inputSemester},
            success: function (res) {
              $scope.defaultresponse = []
              if(res.length > 0 && res != null){
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
                message('','hide')
              }
              else{
                initobj();
                $(".imageloader").hide();
                $scope.loading_data = 2;
                $(".pagination").html('')
                message('No data found','show')
              }
            }
          });
          $scope.loading_data = 0;
       }

    function getPaginationData()
    {

      if($scope.defaultresponse.length > 0)
      {

        $Upload='<input type="file" id="myFile"/>'
        var page  = $scope.page
            limit = 20,
            row   = (page - 1) * limit,
            count = page * limit,
            part  = [];

          $(".pagination li").removeClass('active')
          $(".pagination li:nth-child("+page+")").addClass('active')
          for (; row < count && row< $scope.defaultresponse.length; row++) {

            var temp = []

             temp.push('Day ' + $scope.defaultresponse[row].day)
             temp.push($scope.defaultresponse[row].concept)
             temp.push($scope.defaultresponse[row].topic)
             temp.push($scope.defaultresponse[row].lesson)
             temp.push($scope.defaultresponse[row].type)
             temp.push($scope.defaultresponse[row].content)
             temp.push('<div class="upload_content" ><input class ="idd" type="file" id="idd_'+row+'" accept="jpg,mp4,doc,xls,3gp,pdf, png, gif, bmp,jpeg,docx,xlsx"/><button type="button" id="uploadfileReady"  class="btn-'+$scope.defaultresponse[row].id+' btn btn-success" data-row-id ="'+$scope.defaultresponse[row].id+'" data-btn-id ="'+row+'"  name="Upload" data-loading-text="<i class=\'fa fa-circle-o-notch fa-spin\'></i> Uploading...">Upload</Button></div>')                    
             temp.push($scope.defaultresponse[row].thumb)
             temp.push('<div class="upload_content" ><input class ="thumb" type="file" id="thumb_'+row+'" accept="jpg,png,jpeg"/><button type="button" id="uploadThumbReady"  class="btn-thumb-'+$scope.defaultresponse[row].id+' btn btn-success" data-row-id ="'+$scope.defaultresponse[row].id+'" data-btn-id ="'+row+'"  name="Upload" data-loading-text="<i class=\'fa fa-circle-o-notch fa-spin\'></i> Uploading...">Upload</Button></div>')
             temp.push($scope.defaultresponse[row].id)
             part.push(temp)
          }



          return part;
        }else{
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

    $scope.editedarray = []

    function initobj()
    {
       var container = $("#example1").handsontable({
        data: getPaginationData(),
        colHeaders: ['Day', 'Concept','Topic', 'lesson','Type','Content','Upload Content','Thumbnail', 'Upload Thumbnail','Id'],
        rowHeaders: true,
        contextMenu: ['remove_row','row_above', 'row_below'],
        manualRowResize: true,
        columnSorting: true,
        sortIndicator: true,
        autoWrapCol :true,
        autoWrapRow: true,
        dropdownMenu: true,
        autoColSize: true,
        manualColumnResize:true,
        manualRowResize:true,
        width: $(".panel").width(),
        height: ($scope.defaultresponse.length < 10 ? 450 : 500 ) ,
        columns: [
          {data: 0},
          {data: 1},
          {data: 2},
          {data: 3},

          {
            type: 'dropdown',
            source: ['Document', 'Video', 'Image', 'Text','Application','Game']
          },
          
          {data: 5},
          {renderer: "html",readOnly: true},
          {data: 7},
          {renderer: "html",readOnly: true},
          {readOnly: true, width: 1},
          ],

          beforeRemoveRow:function(index,amount)
          {
           for (var i = amount - 1; i >= 0; i--) {
             console.log(index[i])
           };
             var id = $("#example1").handsontable('getDataAtRow',index,1);
                    var data = {

                        id:id,
                    }

                     $.ajax({
                     url:'deleteplan',
                      type: 'POST',
                      data: {data:data,candelete:true},
                      success: function(res){



                      },
                        error: function(){
                     alert("Fail")
                  }});

          },
            beforCellMouseDown: function (change, source)
            {

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
             $scope.loading_data = 2;
             $(".imageloader").hide();
             
                }


            $(document).on('click','#saveupdate',function(){
              
              var class_id=$("#select_class").val();
              var sectionid=$("#inputSection").val();
              var subjectid=$("#select_subject").val();
             var semesterid=$("#inputSemester").val();
              var $this = $(this);
              $scope.is_document_changed = false;
            $this.button('loading');
              var jsonString = JSON.stringify(part);
       
                    $.ajax({
                     url:'<?php echo SHAMA_CORE_API_PATH; ?>default_lesson_plan',
                      type: 'POST',
                      data: {data:jsonString,class_id:class_id,subject_id:subjectid,semester_id:semesterid},
                      success: function(res){

                     $this.button('reset');
                    part=[];
                    retriveData();
                      },
                        error: function(){
                         alert("Fail")
                         $this.button('reset');
                  }});

            });


        $(document).on('click','#uploadfileReady',function(){
            var btn_num = $(this).attr('data-btn-id');
            $file=$("#idd_"+btn_num).val();
            if(!$file)
            {
              alert('Please select a file');
              return false;
            }
            
            var $this = $(this);

            $this.button('loading');

            message('Please wait file is uploading');

            var id = $(this).attr('data-row-id');
            var btnupload = $(".btn-"+btn_num);
            btnupload.button('loading');

            var btn_num = $(this).attr('data-btn-id');

            var myfile = $("#idd_"+btn_num)[0].files[0];

            var size, ext ;

            ext = myfile.name;

            ext = ext.substring(ext.lastIndexOf('.') + 1);

            ext = ext.toLowerCase();

            var validExt = ["png","jpg","bmp","gif","jpeg",'mp4','3gp','txt','doc','pdf','xls','csv','.apk','xlsx'];

            if($.inArray(ext,validExt) == -1){

                alert('Invalid file');
                return false;

            }

            else{

                message("","hide");

            }

            var data = new FormData();

            data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');

            var i =0;
            data.append("file",myfile);
            data.append("class_name",$scope.select_class.name);
            data.append("subject_name",$scope.inputSubject.name);
            data.append('id',id)
            message('File Uploading','show')
            $.ajax({

                url: '<?php echo SHAMA_CORE_API_PATH; ?>content',

                type: 'POST',

                data: data,

                cache: false,

                dataType: 'json',

                mimeType:"multipart/form-data",

                processData: false, // Don't process the files

                contentType: false, // Set content type to false as jQuery will tell the server its a query string request

                success: function(data) {

                  if(data.message == true || data.fileexist==true)

                  {
                    if(data.fileexist==true)
                    {
                       message('File with the same name is present on the server.','show')
                         btnupload.button('reset');
                      alert('File with the same name is present on the server.');
                      return false;
                    }
                     message('File uploaded','show')
                    btnupload.button('reset');
                    alert('File uploaded');
                    var $this = $(".btn-success");
                   part=[];
                    retriveData();
                   $this.button('reset');


                  }

                },
                error:function(error)
                {
                     btnupload.button('reset');
                      message('File not uploaded','show')
                var $this = $(".btn-success");
                  $this.button('reset');
                   alert('Failed');
                }

            });

            return false;

        });


        $(document).on('click','#uploadThumbReady',function(){
            var btn_num = $(this).attr('data-btn-id');
            $file=$("#thumb_"+btn_num).val();
            if(!$file)
            {
              alert('Please select a file');
              return false;
            }
            
            var $this = $(this);

            $this.button('loading');

            message('Please wait file is uploading');

            var id = $(this).attr('data-row-id');
            var btnupload = $(".btn-thumb-"+btn_num);
            btnupload.button('loading');

            var btn_num = $(this).attr('data-btn-id');

            var myfile = $("#thumb_"+btn_num)[0].files[0];

            var size, ext ;

            ext = myfile.name;

            ext = ext.substring(ext.lastIndexOf('.') + 1);

            ext = ext.toLowerCase();

            var validExt = ["png","jpg","bmp","gif","jpeg",'mp4','3gp','txt','doc','pdf','xls','csv','.apk','xlsx'];

            if($.inArray(ext,validExt) == -1){

                alert('Invalid file');
                return false;

            }

            else{

                message("","hide");

            }

            var data = new FormData();

            data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');

            var i =0;
            data.append("file",myfile);
            data.append("classname",$scope.select_class.name);
            data.append("subjectname",$scope.inputSubject.name);
            data.append("contenttype",'thumb');
            data.append('id',id)
            message('File Uploading','show')
            $.ajax({

                url: '<?php echo SHAMA_CORE_API_PATH; ?>content',

                type: 'POST',

                data: data,

                cache: false,

                dataType: 'json',

                mimeType:"multipart/form-data",

                processData: false, // Don't process the files

                contentType: false, // Set content type to false as jQuery will tell the server its a query string request

                success: function(data) {

                  if(data.message == true || data.fileexist==true)

                  {
                    if(data.fileexist==true)
                    {
                       message('File with the same name is present on the server.','show')
                         btnupload.button('reset');
                      alert('File with the same name is present on the server.');
                      return false;
                    }
                     message('File uploaded','show')
                    btnupload.button('reset');
                    alert('File uploaded');
                    var $this = $(".btn-success");
                   part=[];
                    retriveData();
                   $this.button('reset');


                  }

                },
                error:function(error)
                {
                     btnupload.button('reset');
                      message('File not uploaded','show')
                var $this = $(".btn-success");
                  $this.button('reset');
                   alert('Failed');
                }

            });

            return false;

        });

 $(document).on('click','.nowsave',function(e){



                $file=$("#file").val();
                                if(!$file)
                                {
                                  alert('Please select a file');
                                  return false;
                                }

              try{
                e.stopPropagation();
                 var files = $('input[type="file"]').get(0).files;
            // Loop through files
            var size, ext ;
            file = files[0];
            size = file.size;
            ext = file.name.toLowerCase().trim();
            ext = ext.substring(ext.lastIndexOf('.') + 1);
            ext = ext.toLowerCase();
            var validExt = ["csv","xls",'xlsx'];
            if($.inArray(ext,validExt) == -1){
                alert("Please must upload text file","show");
                return false;
            }
            else{
                message("","hide");
            }

                var $this = $(this);
                $this.button('loading');

                 var class_id=$("#select_class").val();
                 var sectionid=$("#inputSection ").val();
                 var subjectid=$("#select_subject").val();
                 var semesterid=$("#inputSemester").val();

                 var formData = new FormData();

                  formData.append('class_id',class_id)
                  formData.append('subject_id',subjectid)
                  formData.append('semester_id',semesterid)
                  formData.append('session_id',$scope.session_id)

                  formData.append('Import',true);
                 formData.append("file",$('input[type=file]')[0].files[0]);
                   $.ajax({
                    url: '<?php echo SHAMA_CORE_API_PATH; ?>import_default_lesson_plan',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    dataType: 'json',
                    mimeType:"multipart/form-data",
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data) {
                      part=[];
                      $("#file").val('');
                      retriveData();
                      $("#file").val('');
                      $this.button('reset');
                      },
                      error:function(error)
                      {
                        $("#file").val('');
                        $this.button('reset');
                      }
                    });

              return false;
            }
            catch(ex){}


          })

     $(document).on('click','.export_button',function(){

        var class_id=$("#select_class").val();
             var sectionid=$("#inputSection ").val();
              var subjectid=$("#select_subject").val();
              var semesterid=$("#inputSemester").val();
                    var $this = $(this);

          var fileName = $("#select_class option:selected").text() + "_" + $("#select_subject option:selected").text() + "_" + $("#inputSemester option:selected").text();
          fileName = "def_lesson_plan_" + fileName.replace(/ /g, '_') + ".xls";

            $this.button('loading');
              $.ajax({
                     url:'<?php echo SHAMA_CORE_API_PATH;?>export_default_lesson_plan',
                      type: 'GET',
                      dataType: 'json',
                      data: {class_id:class_id,subject_id:subjectid,semester_id:semesterid},
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
  }

</script>

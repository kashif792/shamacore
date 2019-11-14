<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10" ng-controller="lesson">
	<?php
		// require_footer 
		require APPPATH.'views/__layout/filterlayout.php';
	?>
	<div class="col-lg-12 widget">
		<div class="row">
			<div class="widget-header" id="widget-header">
				<!-- widget title -->
  				<div class="widget-title">
	  				<h4>Save Lesson</h4>
  				</div>
			</div>
			<div class="widget-body">
				<div class="col-lg-12">
					<div class="form-container">
		          		<?php $attributes = array('name' => 'add_lessons', 'id' => 'add_lessons','class'=>'form-container form-container-input'); echo form_open_multipart('', $attributes);?>
			               	<input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial">
		                	<fieldset>
		                		<div class="row">
		                			<div class="col-lg-12">
	                					<label><span class="icon-book"></span> Lesson<span class="required">*</span></label>
		                			</div>
		                			<div class="col-lg-6">
		                				<input type="text" id="inputLesson" name="inputLesson" placeholder="Enter the lesson name" value="<?php if(isset($lesson_single)){echo $lesson_single[0]->title;}?>" required>
		                			</div>
		                		</div>
		                		<div class="row">
		                			<div class="col-lg-6">
	                					<label><span class="icon-edit"></span> Description</label>
		                			</div>
		                			<div class="col-lg-12">
		                				<textarea class="ckeditor" name="editor" id="editor"></textarea>
		                			</div>
		                		</div>

		                		<div class="row">
		                			
		                				<div class="col-lg-12">
	                						<label><span class="icon-th-list"></span> Classes<span class="required">*</span></label>
		                				</div>
			                			<div class="col-lg-6">
			                				<select name="inputclass" id="inputclass" ng-change="changesection()" ng-model="inputclass" ng-init="ini='<?php echo $classlist[0]->id; ?>'">
			                					<?php 

			                						if(count($classlist))
			                						{

			                							foreach ($classlist as $key => $value) {
			                								?>
			                									 <option  value="<?php echo $value->id; ?>"><?php echo $value->grade; ?></option>
			                								<?php
			                							}
			                						}
			                					?>

			                					
			                				</select>
		                			</div>
		                		</div>
		                			<div class="row">
		                				<div class="col-lg-12">
	                						<label><span class="icon-th-list"></span> Section<span class="required">*</span></label>
		                				</div>
		                				<div class="col-lg-6">
		                					<span ng-repeat="sc in sectionslist">
		                						<label><input type="checkbox"  value="{{sc.id}}"  name="sectionslist[]">{{sc.name}}
		                						</label>
		                					</span>
		      								     					
	                					</div>
		                			</div>
		                			<!-- <div class="row">
		                				<div  id="class-list-error">Check at least one</div>
		                			</div> -->
		           
		                		<div class="row">
		                			<div class="col-lg-12">
	                					<label><span class="icon-book-1"></span> Subject<span class="required">*</span></label>
		                			</div>
		                			<div class="col-lg-6">
		                				
		                			<!-- 	<select name="inputSubject" id="inputSubject" value="<?php if(isset($result)){echo $result['subid'];} ?>">
		                					<?php 

		                						if(count($subjects))
		                						{

		                							foreach ($subjects as $key => $value) {
		                								?>
		                									 <option <?php if($result['subid'] == $value->subid) echo "selected";?> value="<?php echo $value['subid']; ?>"><?php echo $value['name']." ( ".$value['class']." )"; ?></option>
		                								<?php
		                							}
		                						}
		                					?>

		                					
		                				</select> -->
		                				<select ng-options="item.name for item in subjectlist track by item.id" name="inputSubject" id="inputSubject" ng-model="inputSubject"></select>
		                			</div>
		                		</div>
		                		 <div class="row">
		                			<div class="col-lg-12">
	                					<label><span class="icon-th-list"></span> Type<span class="required"></span></label>
		                			</div>
		                			<div class="col-lg-6">
		                				<select name="inputType" id="inputType" value="<?php if(isset($result)){echo $result['lesson_type'];} ?>">
        									 <option value="app" <?php if($result['lesson_type'] == "app") echo "selected";?> >Application</option>
        									 <option  value="video" <?php if($result['lesson_type'] == "video") echo "selected";?> >Video</option>
		                				</select>
		                			</div>
		                		</div>
		                		<div class="row">
		                			<div class="col-lg-12">
	                					<label><span class="icon-link-1"></span> URL Name<span class="required"></span></label>
		                			</div>
		                			<div class="col-lg-6">
		                				<input type="text" id="inputUrl" name="inputUrl" placeholder="Enter the lesson name" value="<?php if(isset($lesson_single)){echo $lesson_single[0]->title;}?>">
		                			</div>
		                		</div>
			                   	<div class="row">
		                			<div class="col-lg-12">
	                					<label><span class="icon-upload-cloud"></span> Upload</label>
		                			</div>
		                			<div class="col-lg-6">
		                				<input type="file" id="inputFile" name="inputFile">
		                			</div>
		                		</div>
			                	<div class="field-container">
			                		<div class="field-row">
			                			<button type="submit" tabindex="8" class="btn btn-default save-button">Save</button>
			                			<a tabindex="9" href="<?php echo $path_url; ?>show_lesson_list" tabindex="6" title="cancel">Cancel</a>
			                		</div>
			                	</div>										                
			                	 
			                </fieldset>
			            <?php echo form_close();?>
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
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
        
        

        /*
         * ---------------------------------------------------------
         *   Save new class
         * ---------------------------------------------------------
         */ 
        $("#add_lessons").submit(function(e){
         	e.preventDefault();
            var inputLesson = $("#inputLesson").val();
  
            var reg = new RegExp(/^[A-Za-z0-9\s\-_,\.;:()]{3,50}$/);
          
         	if(reg.test(inputLesson) == false){
                jQuery("#inputLesson").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputLesson").css("border", "1px solid #C9C9C9");                                 
            }
         
          
           	
           	for (instance in CKEDITOR.instances) {
		        CKEDITOR.instances[instance].updateElement();
		    }

	      	var dataString = jQuery('#add_lessons').serializeArray();
	      	console.log(dataString)
	      	ajaxType = "POST";
	  		urlpath = "<?php echo $path_url; ?>saveNewLesson";
	     	ajaxfunc(urlpath,dataString,classResponseFailure,loadClassResponse); 
	  		return false;
        });
	
		function classResponseFailure()
		{
			$(".user-message").show();
	    	$(".message-text").text("Class data not saved").fadeOut(10000);
		}

        function loadClassResponse(response)
        {
        	if(response.message == true){

				var files = $('input[type="file"]').get(0).files;
				if(files.length>0){
				saveUpload(response.lessonid)
			}
			else
			{
				window.location.href = "<?php echo $path_url;?>show_lesson_list";
			}
			

			}
        }

         /*
	     * ---------------------------------------------------------
	     *   Save profile image
	     * ---------------------------------------------------------
	     */ 
	     function saveUpload(lessonid)
	     {
	     	
	     	var files = $('input[type="file"]').get(0).files;
     	 	var size, ext ;
            file = files[0];
            size = file.size;
            ext = file.name.toLowerCase().trim();
            ext = ext.substring(ext.lastIndexOf('.') + 1); 
            ext = ext.toLowerCase();
            
            var validExt = ["jpg", "png", "gif", "bmp","jpeg","JPG","PNG","GIF","BMP","doc","DOC","PDF","pdf","DOCX","docx","xls","XLS","XLSX","txt"];
           	if($.inArray(ext,validExt) == -1){
                message("Please must upload text file","show");
                return false;
            }
            else{
                message("","hide");
            }

            if(size > 5000000 ){
            	alert("File must be less than 5MB")
                return false;
            }

            var data = new FormData();
            data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');
            var i =0;
            $.each($("#inputFile")[0].files,function(key,value){
                data.append("export",value);
            });
            data.append('lessonid',lessonid)
            $.ajax({
                url: '<?php echo $path_url;?>teacher/upload?files',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                mimeType:"multipart/form-data",
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data) {
                	if(data.message == true)
                	{
                		window.location.href = "<?php echo $path_url;?>show_lesson_list";
                	}
                }
            });
            return false;
	     }  
 	});
</script>
<script type="text/javascript">
	var app = angular.module('invantage', []);
	app.controller('lesson', function($scope, $http, $interval) {
	setTimerForWidget('section',1)
	$scope.inputclass = $scope.ini;
	function setTimerForWidget(crname,ctime)
    {
      
       $scope.ptime = 0;
      reporttimer = $interval(function(){
        if($scope.ptime < parseInt(ctime))
        {
          $scope.ptime++
        }
        else{
          if(crname == 'section'){
            loadSections()  
          }
          
        

          $interval.cancel(reporttimer)

      }
    },300)
      }

    function getSubjectList()
      {
      	try{
			var data = ({inputclassid:parseInt($scope.ini)})
		
			httprequest('<?php echo $path_url; ?>getsubjectlistbyclass',data).then(function(response){
				if(response.length > 0 && response != null)
				{
					$scope.inputSubject = response[0];
					$scope.subjectlist = response;
					
				}
				else{
					$scope.subjectlist = [];
				}
			})
		}
		catch(ex){}
      }
		
		function loadSections()
		{
	
			try{
				var data = ({inputclassid:parseInt($scope.ini)})
				getSubjectList()
				httprequest('getsectionbyclass',data).then(function(response){
					if(response.length > 0 && response != null)
					{
						$scope.sectionslist = response;
					}
					else{
						$scope.sectionslist = response;
					}
				})
			}
			catch(ex){}
		}

		$scope.changesection = function()
		{
			try{
				$scope.ini = $scope.inputclass;
				var data = ({inputclassid:parseInt($scope.ini)})
				getSubjectList()
				httprequest('getsectionbyclass',data).then(function(response){
					if(response.length > 0 && response != null)
					{
						$scope.sectionslist = response;
					}
					else{
						$scope.sectionslist = response;
					}
				})
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

     
      function responseSuccess(response){
        return (response.data);
      }

      function responseFail(response){
        return (response.data);
      }
	});
</script>
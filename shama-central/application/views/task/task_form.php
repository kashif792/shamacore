<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>
<div class="col-sm-10" ng-controller="task_ctrl">

	<?php
		// require_footer
		require APPPATH.'views/__layout/filterlayout.php';
	?>

<div class="col-sm-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<label></label>
		</div>
		<div class="panel-body">
			<div class="form-container">
          		<?php $attributes = array('name' => 'assginmentForm', 'id' => 'assginmentForm','class'=>'form-horizontal'); echo form_open_multipart('', $attributes);?>
	               	<input type="hidden" value="" name="serial" id="serial" ng-model="serial">
					<div class="form-group">
						<div class="col-sm-12">
							<label>Title: <span class="required">*</span></label>
							<input type="text" id="inputTitle" class="form-control" name="inputTitle" ng-model="inputTitle" placeholder="Assginment Name"  tabindex="1" value="">						
							<span class="errorhide" id="fname_error"> Assignment title is required!</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<label>Description:</label>
							 <textarea class="form-control" rows="5" id="froala-editor"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-4">
							<label>Points: <span class="required">*</span></label>
							<input class="form-control" tabindex="5" type="text" id="input_points" ng-model="input_points" name="input_points" placeholder="Points" value="">
							<span class="errorhide" id="teacher_email">Please enter total points</span>
						</div>
						<!-- 
						<div class="col-sm-4">
							<label>Assigment Groups: </label>
							 <select class="form-control" id="exampleFormControlSelect1">
							      <option>1</option>
							      <option>2</option>
							      <option>3</option>
							      <option>4</option>
							      <option>5</option>
							  </select>
						</div>
						 -->
						<div class="col-sm-4">
							<label>Display Grade as: </label>
							 <select class="form-control" id="pointDispType">
							      <option>1</option>
							      <option>2</option>
							      <option>3</option>
							      <option>4</option>
							      <option>5</option>
							  </select>
						</div>
					</div>
					<br><br>
					<div class="form-group assnt_border">
						<label>Submission Type </label>
						<div class="col-sm-12  assnt_border">

							 <select class="form-control" id="submissionType">
							      <option>Online</option>
							      <option>2</option>
							      <option>3</option>
							      <option>4</option>
							      <option>5</option>
							  </select>
							  <label>Online Entry Options: </label>
							  <div class="checkbox">
					      		<label><input type="checkbox" value="">Option 1</label>
					    	</div>
						    <div class="checkbox">
						      <label><input type="checkbox" value="">Option 2</label>
						    </div>
							   <div class="checkbox disabled">
							     <label><input type="checkbox" value="" disabled>Option 3</label>
							   </div>
						</div>
					</div>

					<br></br>
					<div class="form-group">
						<div class="col-sm-6">
							<label>Group Assignments: <span class="required">*</span></label>
						 <div class="checkbox ">
					      <label><input   type="checkbox" value="">This is a group assigment</label>
					    </div>
						</div>
						<div class="col-sm-6">
							<label>Peer Reviews: <span class="required">*</span></label>
						 <div class="checkbox ">
					      <label><input   type="checkbox" value="">Require peer reviews</label>
					    </div>
						</div>
					</div>
					<br>
					<div class="form-group">
						<div class="col-sm-12">
							<label>Moderated Grading: <span class="required">*</span></label>
						 <div class="checkbox ">
					      <label><input  type="checkbox" value="">Allow moderator to review mutliple independent grades</label>
					    </div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
					      <label for="sel1">Select list (select one):</label>
					      <select class="form-control" id="sel1">
					        <option>Grades</option>
					        <option>Group of Students</option>
					      </select>
					      <br>
					      <label class="checkbox-inline">
						      <input type="checkbox" value="" checked>Kidergarten
						    </label>
						    <label class="checkbox-inline">
						      <input type="checkbox" value="" checked>Green
						    </label>
						    <label class="checkbox-inline">
						      <input type="checkbox" value=""> Red
						    </label>
						    <br>
						    <label class="checkbox-inline">
						      <input type="checkbox" value="" checked>Grade 1
						    </label>
						    <label class="checkbox-inline">
						      <input type="checkbox" value="" checked>Green
						    </label>
						    <label class="checkbox-inline">
						      <input type="checkbox" value="" checked> Red
						    </label>
						    <br>
						    <label class="checkbox-inline">
						      <input type="checkbox" value="" checked>Grade 2
						    </label>
						    <label class="checkbox-inline">
						      <input type="checkbox" value="" checked>Green
						    </label>
						    <label class="checkbox-inline">
						      <input type="checkbox" value="" checked> Red
						    </label>
						    <br>
						    <label class="checkbox-inline">
						      <input type="checkbox" value="" checked>Grade 3
						    </label>
						    <label class="checkbox-inline">
						      <input type="checkbox" value="" checked>Green
						    </label>
						    <label class="checkbox-inline">
						      <input type="checkbox" value="" checked> Red
						    </label>
						    <br><br>
					      <label for="sel2">Mutiple select list (hold shift to select more than one):</label>
					      <select multiple class="form-control" id="sel2">
					        <option>M.Sajawal (Kindergarten)</option>
					        <option>Mohsen (Grade 1)</option>
					        <option>Haleem (Grade 2)</option>
					        <option>Asghir (Grade 3)</option>
					        <option>Waseem (Grade 4)</option>
					      </select>

					  </div>
					    </div>
          
                	<div class="form-group">
                		<div class="col-sm-12">
                			<button type="button" id="save_principal" tabindex="8" class="btn btn-primary save-button" ng-click="savePricpal()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                			
                			<button type="button" id="save_principal" tabindex="8" class="btn btn-primary save-button" ng-click="savePricpal()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save & Publish</button>
                			<a  href="<?php echo $path_url; ?>show_prinicpal_list"  title="cancel">Cancel</a>
                		</div>
                	</div>
	            <?php echo form_close();?>
			</div>
		</div>
	</div>
</div>
<div class="col-sm-4">
	<div class="panel panel-default">
		<div class="panel-heading">
			<label>Insert Content Into page</label>
		</div>
		<div class="panel-body">
					<div id="exTab2" >	
					<ul class="nav nav-tabs">
								<li class="active">
					        <a  href="#1" data-toggle="tab">Links</a>
								</li>
								<li><a href="#2" data-toggle="tab">Files</a>
								</li>
								<li><a href="#3" data-toggle="tab">Images</a>
								</li>
							</ul>

								<div class="tab-content ">
								  <div class="tab-pane active" id="1">
									<ul>
									  <li><a href="#">Menu 1</a></li>
									  <li><a href="#">Menu 2</a></li>
									  <li><a href="#">Menu 3</a></li>
									</ul>
									<button style="float: right;" type="button" class="btn">Add Link</button>
									</div>
									<div class="tab-pane" id="2">
					          <p>Upload files here</p>
									</div>
					        <div class="tab-pane" id="3">
					          <p>Upload images here</p>
									</div>
								</div>
					  </div>

			</div>
		</div>
	</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
<link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/css/froala_style.min.css' rel='stylesheet' type='text/css' />
 
<!-- Include JS file. -->
<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.min.js'></script>
<script>
  $(function() {
    $('textarea#froala-editor').froalaEditor()
  });
</script>
<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>
<script type="text/javascript">

	/**
     * charCode [48,57]     Numbers 0 to 9
     * keyCode 46           "delete"
     * keyCode 9            "tab"
     * keyCode 13           "enter"
     * keyCode 116          "F5"
     * keyCode 8            "backscape"
     * keyCode 37,38,39,40  Arrows
     * keyCode 10           (LF)
     */
    function validate_int(myEvento) {
  		if ((myEvento.charCode >= 48 && myEvento.charCode <= 57) || myEvento.keyCode == 9 || myEvento.keyCode == 10 || myEvento.keyCode == 13 || myEvento.keyCode == 8 || myEvento.keyCode == 116 || myEvento.keyCode == 46 || (myEvento.keyCode <= 40 && myEvento.keyCode >= 37)) {
        	dato = true;
      	} else {
        	dato = false;
      	}
      	return dato;
    }

	var app = angular.module('invantage', []);
	app.controller('principal_ctrl',function($scope,$http,$compile,$filter)
	{

		$scope.genderlist = [
			{
				id:1,
				title:'Male',
			},
			{
				id:2,
				title:'Female',
			}
		];
		$scope.input_t_gender = $scope.genderlist[0];

		$scope.provincelist = [
			{
				id:'Azad Kashmir',
				title:'Azad Kashmir',
			},
			{
				id:'Balochistan',
				title:'Balochistan',
			},
			{
				id:'Federally Administered Tribal Areas',
				title:'Federally Administered Tribal Areas',
			},
			{
				id:'Islamabad Capital Territory',
				title:'Islamabad Capital Territory',
			},
			{
				id:'Khyber Pakhtunkhwa',
				title:'Khyber Pakhtunkhwa',
			},
			{
				id:'Northern Areas',
				title:'Northern Areas',
			},
			{
				id:'Punjab',
				title:'Punjab',
			},
			{
				id:'Sindh',
				title:'Sindh',
			},
		];
		$scope.inputProvice = $scope.provincelist[0];
		$scope.serial = '';
		$scope.is_edit = "<?php echo $this->uri->segment('2'); ?>";
		
		angular.element(function () {
			if($scope.is_edit != null && $scope.is_edit != '')
			{
				$scope.serial = $scope.is_edit;
				getUserInfo();
			}
	 	});

	 	$scope.editarray = [];
		$scope.is_image_edit = false;
		
		function getUserInfo() {
			try{
			   var data = ({principal:$scope.is_edit})
			   httprequest('<?php echo base_url(); ?>gettask',data).then(function(response){
				   if(response != null)
				   {
				   	
				   		$scope.editarray = response;	
					   $scope.inputTitle = response.firstname;
					   $scope.inputLastName = response.lastname;

					  
					   $scope.inputTeacher_Nic = response.nic;

					   $scope.input_points = response.input_points;
					   $scope.input_pr_phone = response.phone;
					   $scope.pr_home = response.primary_home_address;
					   $scope.sc_home = response.primary_secondary_address;
					   $scope.input_city = response.city;
					   $scope.input_zipcode = response.zipcode;
					   if(response.image != '')
					   {
					   	$(".img-rounded").prop('src',response.image);
					   	$("#imagesize").show()
					   }
					   
             
					   var found = $filter('filter')($scope.genderlist,{id:parseInt(response.gender)},true);
					   
					   if(found.length)
					   {
					   		$scope.input_t_gender = found[0]
					   }

				      var found = $filter('filter')($scope.religionlist,{id:response.religion},true);
					   
					   // if(found.length)
					   // {
					   // 		$scope.inputReligion = found[0]
					   // }

				    	var found = $filter('filter')($scope.provincelist,{id:response.state},true);
					  
					   if(found.length)
					   {
					   		$scope.inputProvice = found[0]
					   }

              var found = $filter('filter')($scope.provincelist,{id:response.state},true);
            
             if(found.length)
             {
                $scope.inputProvice = found[0]
             }
                
				   		
				   }
				   else{

				   }
			   })
		   }
		   catch(ex){}
		}

        $scope.showRemoveDialoag = function()
        {
            removeImageConfirmation()
        }

	 	function removeImageConfirmation()
        {
            $.confirm({
                theme: 'material',
                title: 'Confirm!',
                content: 'Are you sure you want to delete this message?',
                buttons: {
                    confirm: function () {
                        removeImage()
                    },
                    cancel: function () {
                    },
                }
            });
        }

        function removeImage()
        {
            if($scope.is_edit != null && $scope.is_edit != '')
            {
            	$scope.is_image_edit = true;
                $('.img-rounded').prop('src',"#");
                $("#imagesize").hide()
            }
           
        }


		/*
         * ---------------------------------------------------------
         *   Save Teacher
         * ---------------------------------------------------------
         */
        
		$scope.savePricpal = function()
		{
			
		  	var reg = new RegExp(/^[A-Za-z0-9\s]{3,50}$/);
            myRegExp = new RegExp(/\d{5}-\d{7}-\d{1}$/);
           	var eregix=new RegExp(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/);

           	if(reg.test(jQuery("#inputTitle").val())==false){

            	jQuery("#inputTitle").addClass('errorshow');
            	jQuery("#fname_error").show();
            	isValid = false;
            	return false;
        	}
	        else{
	            isValid = true;
             	jQuery("#fname_error").hide();
	            jQuery("#inputTitle").removeClass('errorshow')
	        }

	        if(reg.test(jQuery("#inputLastName").val())==false){

            	jQuery("#inputLastName").addClass('errorshow');
            	jQuery("#lname_error").show();
            	isValid = false;
            	return false;
        	}
	        else{
	            isValid = true;
             	jQuery("#lname_error").hide();
	            jQuery("#inputLastName").removeClass('errorshow')
	        }

	        var reg = new RegExp(/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/);


           	var nic=new RegExp(/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/);
         	if(nic.test(jQuery("#inputTeacher_Nic").val())==false){

            	jQuery("#inputTeacher_Nic").addClass('errorshow');
            	$("#teacher_nic").html('Please enter your NIC# in this format xxxxx-xxxxxxx-x').show();
            	isValid = false;
            	return false;
        	}
	        else{
	            isValid = true;
	            $("#teacher_nic").html('').hide();
	            jQuery("#inputTeacher_Nic").removeClass('errorshow')
	        
	           }

	        if(eregix.test(jQuery("#input_points").val())==false){

            	jQuery("#input_points").addClass('errorshow');
            	$("#teacher_email").html('Please enter your email in this format admin@domain.com').show()
            	isValid = false;
            	return false;
        	}
	        else{
	            isValid = true;
	             $("#teacher_email").html('').hide()
	            jQuery("#input_points").removeClass('errorshow')
	        }

            var reg = new RegExp(/^[A-Za-z0-9]{3,50}$/);

            if(reg.test(jQuery("#inputNewPassword").val()) == false){

                jQuery("#inputNewPassword").addClass('errorshow');
                $("#teacher_passowrd").show()
                return false;
            }
            else{
                jQuery("#inputNewPassword").removeClass('errorshow');
                $("#teacher_passowrd").hide()
            }

            if(reg.test(jQuery("#inputRetypeNewPassword").val()) == false){
                jQuery("#inputRetypeNewPassword").addClass('errorshow');
                $("#teacher_re_passowrd").show()
                return false;
            }
            else{
                jQuery("#inputRetypeNewPassword").removeClass('errorshow');
                 $("#teacher_re_passowrd").hide()
            }


            if(jQuery("#inputRetypeNewPassword").val() != jQuery("#inputNewPassword").val() ){
                jQuery("#inputRetypeNewPassword").addClass('errorshow');
                jQuery("#inputNewPassword").addClass('errorshow');
                $("#confimr_passowrd").show()
                return false;
            }
            else{
                jQuery("#inputRetypeNewPassword").removeClass('errorshow');
                jQuery("#inputNewPassword").removeClass('errorshow');
              	$("#confimr_passowrd").hide()
            }

            var preg = new RegExp(/^((\(\d{3,4}\)|\d{3,4}-)\d{4,9}(-\d{1,5}|\d{0}))|(\d{4,12})$/);
            var mobile=new RegExp(/^[0-9]{4}-[0-9]{7}$/);
            if(mobile.test(jQuery("#input_pr_phone").val())==false){

            	jQuery("#input_pr_phone").addClass('errorshow');
            	$("#teacher_phone").html('Please enter your phone number in this format xxxx-xxxxxxx').show()
            	isValid = false;
            	return false;
        	}
	        else{
	            isValid = true;
	             $("#teacher_phone").html('').hide()
	            jQuery("#input_pr_phone").removeClass('errorshow')
	        }


           
            if(jQuery("#pr_home").val() == ''){
                jQuery("#pr_home").addClass('errorshow');
        		$("#address_error").show()
                return false;
            }
            else{
                 jQuery("#pr_home").removeClass('errorshow')
        		$("#address_error").hide()                                
            }

            var reg = new RegExp(/^[A-Za-z ]{3,20}$/);
            if(reg.test(jQuery("#input_city").val()) == false){
                jQuery("#input_city").addClass('errorshow');
        		$("#city_error").show()
                return false;
            }
            else{
                 jQuery("#input_city").removeClass('errorshow')
        		$("#city_error").hide()                                
            }
                    
      
            var reg = new RegExp(/^[0-9]{5}(?:-[0-9]{4})?$/);
            if(reg.test(jQuery("#input_zipcode").val()) == false){
                 jQuery("#input_zipcode").addClass('errorshow');
        		$("#zipcode_error").show()
                return false;
            }
            else{
                jQuery("#zipcode_error").removeClass('errorshow')
                $("#zipcode_error").hide()                                 
            }
            

			var $this = $(".save-button");
            $this.button('loading');

           
         	var formdata = new FormData();
    			formdata.append('serial',$scope.serial);
    			formdata.append('inputTitle',$scope.inputTitle);
    			formdata.append('inputLastName',$scope.inputLastName);
    			formdata.append('input_t_gender',$scope.input_t_gender.id);
    			formdata.append('inputTeacher_Nic',$scope.inputTeacher_Nic);
    			//formdata.append('inputReligion',$scope.inputReligion.id);
    			formdata.append('input_points',$scope.input_points);
    			formdata.append('input_pr_phone',jQuery("#input_pr_phone").val());
    			formdata.append('inputNewPassword',$scope.inputNewPassword);
    			formdata.append('inputRetypeNewPassword',$scope.inputRetypeNewPassword);
    			formdata.append('pr_home',$scope.pr_home);
    			formdata.append('sc_home',$scope.sc_home);
    			formdata.append('inputProvice',$scope.inputProvice.id);
    			formdata.append('input_city',$scope.input_city);
    			formdata.append('input_zipcode',$scope.input_zipcode);
    			formdata.append('inputLocation',$scope.inputLocation.sid);
    			formdata.append('is_image_edit',$scope.is_image_edit);

			var file = $('input[type="file"][id="upload_img"]')[0].files[0];
			if(file != null && file != '')
			{
				var size, ext ;
				size = file.size;
	 		   	ext = file.name.toLowerCase().trim();
	 		   	ext = ext.substring(ext.lastIndexOf('.') + 1);
	 		   	ext = ext.toLowerCase();
				var validExt = ["png","jpg","bmp","gif","jpeg"];
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
				formdata.append('image',$('input[type="file"][id="upload_img"]')[0].files[0]);
        
			}

			var request = {
                method: 'POST',
                url: "<?php echo base_url(); ?>savetask",
                data: formdata,
                headers: {'Content-Type': undefined}
            };
            	
            $http(request)
            .success(function (response) {
                var $this = $(".save-button");
                $this.button('reset');
                if(response.message == true){
       				message('Record has been successfully saved','show');
					window.location.href = "<?php echo base_url();?>tasks";
       	    	}

       	    	if(response.message == false){
					//initmodules();
       				message('Record did not save','show')
       	    	}
            })
            .error(function(){
                var $this = $(".save-button");
                $this.button('reset');
				//initmodules();
                message('Record not saved','show')
            });
		}

		function initmodules()
		{
			$scope.inputTitle = '';
			$scope.inputLastName = '';
			$scope.inputTeacher_Nic = '';
			$scope.input_points = '';
			$scope.input_pr_phone = '';
			$scope.pr_home = '';
			$scope.sc_home = '';
			$scope.input_city = '';
			$scope.input_zipcode = '';
			//$scope.inputReligion = $scope.religionlist[0]
			$scope.inputProvice = $scope.provincelist[0];
			$scope.input_t_gender = $scope.genderlist[0]
			
		}

		function teacherResponseFailure()
		{
			var $this = $(".save-button");
            $this.button('reset');

			$(".user-message").show();
	    	$(".message-text").text("Principal data not saved").fadeOut(10000);
		}

        function loadTeacherResponse(response)
        {
        	var is_img_uploaded = $("#upload_img").val();
			var $this = $(".save-button");
            $this.button('reset');
        	if(response.message == true && is_img_uploaded != ''){

				// window.location.href = "<?php echo $path_url;?>show_teacher_list";
				saveprofileUpload(response.lastid)
			}
			else{
				window.location.href = "<?php echo $path_url;?>show_prinicpal_list";

			}
        }

     	/*
	     * ---------------------------------------------------------
	     *   Save profile image
	     * ---------------------------------------------------------
	     */
	    function saveprofileUpload(teacherId)
	    {
	     	var files = $('input[type="file"]').get(0).files;
     	 	var size, ext ;
            file = files[0];
            size = file.size;
            ext = file.name.toLowerCase().trim();
            ext = ext.substring(ext.lastIndexOf('.') + 1);
            ext = ext.toLowerCase();
            var validExt = ["png","jpg","bmp","gif","jpeg"];
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
            $.each($("#upload_img")[0].files,function(key,value){
                data.append("export",value);
            });
            data.append('teacherId',teacherId)
            $.ajax({
                url: '<?php echo $path_url;?>Principal_controller/uploadTeacherimg?files',
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
                		window.location.href = "<?php echo $path_url;?>show_prinicpal_list";
                	}
                }
            });
            return false;
     	}

	 	$scope.openwebcam = function()
	 	{
			 // Grab elements, create settings, etc.
			 var video = document.getElementById('video');
			 $scope.is_permission_enabled = false;
			 if($scope.is_permission_enabled == false)
			 {
				 // Get access to the camera!
				 if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
					 // Not adding `{ audio: true }` since we only want video now
					 navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
						 video.src = window.URL.createObjectURL(stream);
						 video.play();
					 });
				 }
			 }
			 else{

				 video.play();
			 }
			 $("#video").show()
			 $("#print").show()
			 $("#take_pic_btn").hide()
	 	}

		 var is_take_image_mode_set = false;
		 var is_take_image_set = false ;
		 var context = canvas.getContext('2d');

	 	$scope.popup = function(){
	 		is_take_image_set == false
	 		is_take_image_mode_set = true;
	 		context.drawImage(video, 0, 0, 640, 480);
	 		var image = new Image();
	 		image.src = canvas.toDataURL("image/png");
	 		$('.file-upload-image').attr('src', image.src);

	 		$("#video").hide()
	 		$("#print").hide()
	 		$("#take_pic_btn").show()


	 		$('.image-upload-wrap').hide();
	 		$("#edit_thumbnail").hide()
	 		$('.file-upload-content').show();
		}

		$scope.readURL = function(event) {
			var files = event.target.files;
			var file = files[0];
			if (file) {
				var reader = new FileReader();
				reader.onload = $scope.imageIsLoaded
				reader.readAsDataURL(file);
			} else {
				$scope.removeUpload();
			}
		}

		$scope.imageIsLoaded = function(e){
			$scope.$apply(function() {
			   $('.image-upload-wrap').hide();
			   $("#edit_thumbnail").hide()
			   $('.file-upload-image').attr('src', e.target.result);
		
			   $('.file-upload-content').show();
			});
		}

	 	$scope.removeUpload = function() {
		 	 
		  	$('.file-upload-content').hide();
		  	document.getElementById("upload_img").value = "";
		  	$('.image-upload-wrap').show();
		}

		$('.image-upload-wrap').bind('dragover', function () {
			$scope.is_image_edit = true;
			 $('.file-upload-input').trigger( 'click' );
			$('.image-upload-wrap').addClass('image-dropping');
		});

		$('.image-upload-wrap').bind('dragleave', function () {
			 $scope.is_image_edit = true;
			 $('.file-upload-input').trigger( 'click' );
			$('.image-upload-wrap').removeClass('image-dropping');
		});

     	function httprequest(url,data)
        {
            var request = $http({
                method:'get',
                url:url,
                params:data,
                headers : {'Accept' : 'application/json'}
            });
            return (request.then(responseSuccess,responseFail))
        }

        function httppostrequest(url,data)
        {
            var request = $http({
                method:'POST',
                url:url,
                data:data,
                headers : {'Accept' : 'application/json'}
            });
            return (request.then(responseSuccess,responseFail));
        }

    	function responseSuccess(response)
        {
            return (response.data);
        }

        function responseFail(response){
            return (response.data);
        }

	});

</script>

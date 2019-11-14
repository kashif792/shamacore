<?php

// require_header

require APPPATH.'views/__layout/header.php';



// require_top_navigation

require APPPATH.'views/__layout/topbar.php';



// require_left_navigation

require APPPATH.'views/__layout/leftnavigation.php';

?>


<div class="col-sm-10" id="page-content" ng-controller ="ProfileCtrl">
    <div id="myUserModal" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">Confirmation</h4>

                </div>

                <div class="modal-body">

                    <p>Are you sure you want to delete this item?</p>

                 </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                    <button type="button" id="UserDelete" class="btn btn-default " value="save">Yes</button>

                </div>

            </div>

        </div>

    </div>

<?php

	// require_footer

	require APPPATH.'views/__layout/filterlayout.php';

?>

<div class="panel panel-default">
 	<div class="panel-heading">
 		<label>Profile</label>
 	</div>
  	<div class="panel-body">
  		<div id="settings">
	  		<ul class="resp-tabs-list vert">
      			<li>Profile Information</li>
		      	<li>Change Password</li>
<!-- 		      	<li >Profile Image</li>
 -->		  	</ul>
  			<div class="resp-tabs-container vert">
      			
      			<div id="general-setting-tab">
					<div class="form-container">
			          	<?php $attributes = array('name' => 'generalForm', 'id' => 'generalForm','class'=>'form-horizontal'); echo form_open_multipart('', $attributes);?>
		                	<fieldset>
			                	<div class="form-group">
			                		<div class="col-sm-6">
			                			<label class="control-label col-sm-4" for="inputFirstName">
			                				First name: <span class="required">*</span>
			                			</label>
			                			<div class="col-sm-8">
			                				<input type="text" class="form-control" id="inputFirstName" name="inputFirstName" placeholder="First Name" tabindex="1" value="" ng-model="profileData.first_name">
			                			</div>		
			                		</div>
			                		<div class="col-sm-6">
			                			<label class="control-label col-sm-4" for="inputLastName">
			                				Last name: <span class="required">*</span>
			                			</label>
			                			<div class="col-sm-8">
			                				<input type="text" class="form-control" id="inputLastName" name="inputLastName" placeholder="Last Name"  tabindex="1"  value="" ng-model="profileData.last_name">
			                			</div>		
			                		</div>
		                		</div>
		                		<div class="form-group">
			                		<div class="col-sm-6">
			                			<label class="control-label col-sm-4" for="inputEmail">
			                				Email: <span class="required">*</span>
			                			</label>
			                			<div class="col-sm-8">
			                				<input type="text" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email"  tabindex="2"  value="" ng-model="profileData.email">
			                			</div>		
			                		</div>
			                		
			                		<div ng-if="isAdmin" class="col-sm-6">
			                			<label class="control-label col-sm-4" for="input_pr_phone">
			                				Phone: <span class="required">*</span>
			                			</label>
			                			<div class="col-sm-8">
			                				<input tabindex="6" class="form-control" type="text"  id="input_pr_phone" name="input_pr_phone" placeholder="Primary Phone"  value="" ng-model="profileData.phone">
			                				 <span>Format  (xxx) xxx-xxxx | xxxx-xxxxxxx</span>
			                			</div>		
			                		</div>

			                		<div ng-if="isTeacher || isPrincipal" class="col-sm-6">
			                			<label class="control-label col-sm-4" for="input_pr_phone">
			                				Phone: <span class="required">*</span>
			                			</label>
			                			<div class="col-sm-8">
			                				<input type="text" class="form-control"  id="input_pr_phone" name="input_pr_phone" placeholder="Primary Phone"  value="" ng-model="profileData.phone">
			                			</div>		
			                		</div>
		                		</div>
		                		<div class="form-group">
			                		<div class="col-sm-6">
			                			<label class="control-label col-sm-4" for="input_t_gender">
			                				Gender: <span class="required">*</span>
			                			</label>
			                			<div class="col-sm-8">
			                				<select tabindex="2" class="form-control" id="input_t_gender" name="input_t_gender"  value="" ng-model="profileData.gender">

			                					<option value="Male">Male</option>
			                					<option value="Female">Female</option>

			                				</select>
			                			</div>		
			                		</div>

			                		<div ng-if="isTeacher" class="col-sm-6">
			                			<label class="control-label col-sm-4" for="inputTeacher_Nic">
			                				NIC: <span class="required">*</span>
			                			</label>
			                			<div class="col-sm-8">
			                				<input type="text" class="form-control" tabindex="3" required id="inputTeacher_Nic" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}" title="xxxxx-xxxxxxx-x" name="inputTeacher_Nic" placeholder="12345-1234567-1"  value="" ng-model="profileData.nic">
			                			</div>		
			                		</div>

		                		</div>
	                			<div class="form-group">
			                		<div class="col-sm-6">
			                			<label class="control-label col-sm-4" for="inputEmail">
			                				Primary address:
			                			</label>
			                			<div class="col-sm-8">
			                				<input type="text" class="form-control" tabindex="8" id="pr_home" name="pr_home" placeholder="Primary Home Address"  value="" ng-model="profileData.p_address">
			                			</div>		
			                		</div>
			                		<div class="col-sm-6">
			                			<label class="control-label col-sm-4" for="inputLastName">
			                				Secondary address:
			                			</label>
			                			<div class="col-sm-8">
			                				<input type="text" class="form-control" tabindex="8" id="sc_home" name="sc_home" placeholder="Secondary Home Address"  value="" ng-model="profileData.s_address">
			                			</div>		
			                		</div>
		                		</div>
		                		<div class="form-group">
			                		<div class="col-sm-6">
			                			<label class="control-label col-sm-4" for="inputProvice">
			                				Province:
			                			</label>
			                			<div class="col-sm-8">
			                				<select tabindex="8" class="form-control" name="inputProvice" id="inputProvice"  value="" ng-model="profileData.province">
			                					<option value="Balochistan" >Balochistan</option>
			                					<option value="Islamabad Capital Territory">Islamabad Capital Territory</option>
			                					<option value="Khyber Pakhtunkhwa">Khyber Pakhtunkhwa</option>
			                					<option value="Punjab">Punjab</option>
			                					<option value="Sindh">Sindh</option>
			                				</select>
			                			</div>		
			                		</div>
			                		<div class="col-sm-6">
			                			<label class="control-label col-sm-4" for="input_city">
			                				City:
			                			</label>
			                			<div class="col-sm-8">
			                				<input type="text" class="form-control" tabindex="8" id="input_city" name="input_city" placeholder="City"   value="" ng-model="profileData.city">
			                			</div>		
			                		</div>
			                		
		                		</div>
		                		<div class="form-group">
		                			<div class="col-sm-6">
			                			<label class="control-label col-sm-4" for="input_zipcode">
			                				Zip code:
			                			</label>
			                			<div class="col-sm-8">
			                				<input tabindex="8" class="form-control" id="input_zipcode" name="input_zipcode"  type="text" placeholder="Zip code"  value="" ng-model="profileData.zip_code">
			                			</div>		
			                		</div>
		                		</div>
		                		<div class="form-group">
		                			
                    				<div class="col-sm-12">
                    
                    					<div class="file-upload">
                    
                    						<button class="btn btn-primary file-upload-btn" type="button"
                    							onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>
                    							
                    						<div class="image-upload-wrap" id="image_upoad_wrap">
                    
                    							<input tabindex="8" class="file-upload-input" type='file'
                    								onchange="angular.element(this).scope().readURL(event);"
                    								id="upload_img" name="upload_img" accept="image/*" />
                    
                    							<div class="drag-text">
                    
                    								<h3>Drag and drop an image or select add Image</h3>
                    
                    							</div>
                    
                    						</div>
                    
                    						<div class="file-upload-content" id="file_upoad_content">
                    
                    							<img class="file-upload-image" src="#" alt="your image" />
                    
                    							<div class="image-title-wrap">
                    
                    								<button type="button" ng-click="removeUpload()"
                    									class="remove-image">
                    									Remove <span class="image-title">Uploaded Image</span>
                    								</button>
                    
                    							</div>
                    
                    						</div>
                    
                    					</div>
                    					
                    					
                    					<div class="row" ng-display="profileData.profile_image">
                    
                    						<div class="col-sm-4" id="edit_thumbnail">
                    
                    							<img class="img-rounded thumbnail" src='{{profileData.profile_image}}'
                    								width="250px" height="">
                    
                    						</div>
                    
                    					</div>
			                		</div>
		                		</div>
			                	<div class="form-group">
			                		<div class="col-sm-offset-2 col-sm-10">
			                			<button type="submit" id= "save_profile" tabindex="9" class="btn btn-primary save-profile"  data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
			                		</div>
			                	</div>
			                </fieldset>
			            <?php echo form_close();?>
					</div>
      			
      			</div>

      			<div id="password-change-tab">

      				<div class="form-container">

			          	<?php $attributes = array('name' => 'password_change', 'id' => 'password_change','class'=>'form-horizontal'); echo form_open('', $attributes);?>

		                	<fieldset>

			                	<div class="form-group">
			                		<div class="col-sm-6">
			                			<label><span class="icon-lock-1"></span>Old Password *</label>
			                			<input type="password" class="form-control" id="inputCurrentPassword" name="inputCurrentPassword" placeholder="Current Password"  tabindex="1" value="">
                                        <span class="errorhide" id="oldpassworderror"></span>
			                		</div>
			                	</div>

			                	<div class="form-group">
									<div class="col-sm-6">
			                			<label><span class="icon-lock-1"></span> New Password *</label>
			                			<input type="password" class="form-control" id="inputNewPassword" name="inputNewPassword" placeholder="New Password"  tabindex="2" value="">
                                        <span class="errorhide" id="newpassworderror"></span>
			                		</div>
			                	</div>

			                	<div class="form-group">
									<div class="col-sm-6">
			                			<label><span class="icon-lock-1"></span> Retype New Password *</label>
			                			<input type="password" class="form-control" id="inputRetypeNewPassword" name="inputRetypeNewPassword" placeholder="Retype New Password"  tabindex="3" value="">
                                        <span class="errorhide" id="retypepassworderror"></span>
			                		</div>
			                	</div>
			                	<div class="form-group">
			                		<div class="col-sm-12">
			                			<button type="submit" tabindex="9" class="btn btn-primary save_loader"  data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
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

<script type="text/javascript">
	function validate_int(myEvento) {
  		if ((myEvento.charCode >= 48 && myEvento.charCode <= 57) || myEvento.keyCode == 9 || myEvento.keyCode == 10 || myEvento.keyCode == 13 || myEvento.keyCode == 8 || myEvento.keyCode == 116 || myEvento.keyCode == 46 || (myEvento.keyCode <= 40 && myEvento.keyCode >= 37)) {
        	dato = true;
      	} else {
        	dato = false;
      	}
      	return dato;
    }

    document.getElementById("input_pr_phone").onkeypress = validate_int;
    document.getElementById("input_pr_phone").onkeyup = phone_number_mask;


    function phone_number_mask() {

  		var myMask = "____-_______";
      	var myCaja = document.getElementById("input_pr_phone");
      	var myText = "";
      	var myNumbers = [];
      	var myOutPut = ""
      	var theLastPos = 1;
      	myText = myCaja.value;
      	//get numbers
      	for (var i = 0; i < myText.length; i++) {
        	if (!isNaN(myText.charAt(i)) && myText.charAt(i) != " ") {
          		myNumbers.push(myText.charAt(i));
        	}
      	}

      	//write over mask
      	for (var j = 0; j < myMask.length; j++) {
        	if (myMask.charAt(j) == "_") { //replace "_" by a number 
          		if (myNumbers.length == 0)
            		myOutPut = myOutPut + myMask.charAt(j);
          		else {
            		myOutPut = myOutPut + myNumbers.shift();
            		theLastPos = j + 1; //set caret position
          		}
        	} else {
         	 	myOutPut = myOutPut + myMask.charAt(j);
        	}
      	}
      	document.getElementById("input_pr_phone").value = myOutPut;
      	document.getElementById("input_pr_phone").setSelectionRange(theLastPos, theLastPos);
    }

</script>

<script type="text/javascript">

    app.controller('ProfileCtrl',['$scope','$myUtils', ProfileCtrl]);

    function ProfileCtrl($scope, $myUtils) {

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


		var urlist = {
				getprofiledetail:'<?php echo SHAMA_CORE_API_PATH; ?>profile',
				saveprofileimage:'<?php echo SHAMA_CORE_API_PATH; ?>profile_image'
				}

        $scope.profileData = {};
        function loadProfileData(){

            try{

				var data = {id:$scope.user_id}

                $myUtils.httprequest(urlist.getprofiledetail,data).then(function(response){

                		if(null!=response){
                			$scope.profileData = response;
                			
                			if(response.first_name!=null && response.first_name!="" && response.last_name!=null && response.last_name!=""){
                				$myUtils.setUserName($scope.profileData.first_name + " "+ $scope.profileData.last_name);
                			}

                			if(response.email!=null && response.email!=""){
                				$myUtils.setUserEmail($scope.profileData.email);
                			}

                			if(response.profile_image!=null && response.profile_image!=""){
                				$myUtils.setUserProfileImage($scope.profileData.profile_image);
                			}
                			
                		}else{
                			$scope.profileData = {};
                		}
                	});

            }

            catch(ex){}

        }

        angular.element(function () {

            loadProfileData();

        });

        /*
	     * ---------------------------------------------------------
	     *   Save general Settings
	     * ---------------------------------------------------------
	     */

        $("#generalForm").submit(function(){


            var inputFirstName = $("#inputFirstName").val();

            var inputLastName = $("#inputLastName").val();

            var inputEmail = $("#inputEmail").val();

            var inputStreet = $("#pr_home").val();

            var inputCity = $("#input_city").val();

            var inputZipCode = $("#input_zipcode").val();

            var inputState = $("#inputProvice").val();

            var inputPhone = $("#input_pr_phone").val();
            var role = $("#role").val();

            var reg = new RegExp(/^[A-Za-z0-9 ]{3,50}$/);
         	if(reg.test(inputFirstName) == false){
                jQuery("#inputFirstName").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputFirstName").css("border", "1px solid #C9C9C9");
            }

            if(reg.test(inputLastName) == false){
                jQuery("#inputLastName").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputLastName").css("border", "1px solid #C9C9C9");
            }

            var eregix=new RegExp(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/);

            if(eregix.test(inputEmail) == false){

                jQuery("#inputEmail").css("border", "1px solid red");

                return false;

            }

            else{

                jQuery("#inputEmail").css("border", "1px solid #C9C9C9");

            }

            if(role == 1)
            {
            	var reg = new RegExp(/^((\(\d{3,4}\)|\d{3,4}-)\d{4,9}(-\d{1,5}|\d{0}))|(\d{4,12})$/);
	            if(reg.test(inputPhone) == false){
	                jQuery("#input_pr_phone").css("border", "1px solid red");
	                return false;
	            }
	            else{
	                jQuery("#input_pr_phone").css("border", "1px solid #C9C9C9");                                 
	            }
            }else{
            	var mobile=new RegExp(/^[0-9]{4}-[0-9]{7}$/);
            	  if(mobile.test(inputPhone)==false){

	            	jQuery("#input_pr_phone").addClass('errorshow');
	            	
	            	isValid = false;
	            	return false;
	        	}
		        else{
		            isValid = true;
		       
		            jQuery("#input_pr_phone").removeClass('errorshow')
		        }
            }
          	
          

         	var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            if (inputStreet){
                if(inputStreet.length == '' || inputStreet.length < 3){
                    jQuery("#pr_home").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#pr_home").css("border", "1px solid #C9C9C9");
                }
            }

            if (inputCity){
                var reg = new RegExp(/^[A-Za-z ]{3,50}$/);
                if(reg.test(inputCity) == false){
                    jQuery("#inputCity").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#inputCity").css("border", "1px solid #C9C9C9");
                }
            }

            if (inputZipCode){
                var reg = new RegExp(/^\d{5}((-|\s)?\d{4})?$/);
                if(reg.test(inputZipCode) == false){
                    jQuery("#inputZipCode").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#inputZipCode").css("border", "1px solid #C9C9C9");
                }
            }

            var $this = $(".save-profile");
            $this.button('loading');
            // $("#page-loader").css('display','block');
		
			/*
            urlpath = "savegeneralsetting";

            var formdata = new FormData();
            formdata.append('user_id',$scope.user_id);
            formdata.append('id',$scope.profileData.id);
            formdata.append('inputFirstName',inputFirstName);
            formdata.append('inputLastName',inputLastName);
            formdata.append('input_t_gender',$("#input_t_gender").val());
            formdata.append('inputEmail',inputEmail);
            formdata.append('input_pr_phone',inputPhone);
            formdata.append('pr_home',inputStreet);
            formdata.append('sc_home',$("#sc_home").val());
            formdata.append('inputProvice',inputState);
            formdata.append('input_city',inputCity);
            formdata.append('input_zipcode',inputZipCode);

         	if($('input[type="file"][id="inputFile"]').val().length > 0){
                formdata.append('profile_image',$('input[type="file"][id="inputFile"]')[0].files[0]);
        	}*/

        	var data = {
        		user_id:$scope.user_id,
        		id:$scope.profileData.id,
        		first_name:inputFirstName,
        		last_name:inputLastName,
        		gender:$("#input_t_gender").val(),
        		email:inputEmail,
        		phone:inputPhone,
        		p_address:inputStreet,
        		s_address:$("#sc_home").val(),
        		province:inputState,
        		city:inputCity,
        		zip_code:inputZipCode
        	};



            $myUtils.httppostrequest('<?php echo SHAMA_CORE_API_PATH; ?>profile', data).then(function(response){
                    
                    if(response.message == true){


			        	var src = $(".file-upload-image").attr("src");
			            								
						if(src != "#" && src.length>1){
							    
                            $("#topbar_username").html(inputFirstName+' '+inputLastName);
                            $("#dropdown_username").html(inputFirstName+' '+inputLastName);
                            $("#dropdown_email").html(inputEmail);
                    
							saveprofileUpload($scope.user_id);
			        	}else{
               				message('Personal details have been saved','show')
                            $("#topbar_username").html(inputFirstName+' '+inputLastName);
                            $("#dropdown_username").html(inputFirstName+' '+inputLastName);
                            $("#dropdown_email").html(inputEmail);

                            loadProfileData();

               	    		var $this = $(".save-profile");
                        	$this.button('reset');
            			}
            			
           	    	} else {
           	    		var $this = $(".save-profile");
                    	$this.button('reset');
                    	message('Personal details were not saved','show')
           	    	}
                });

            //ajaxfunc(urlpath,userData,userDerailErrorhandler,userDetailResponse);

            return false;

        });


	     function saveprofileUpload(userId)
	     {
           var data = new FormData();
           
           var i =0;

       		var src = $(".file-upload-image").attr("src");
           data.append("image_64",src);

           data.append('id',userId)

           $.ajax({

               url: urlist.saveprofileimage,
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

       				message('Personal details have been  saved','show')
       				
                    loadProfileData();

       	    		var $this = $(".save-profile");
                	$this.button('reset');
               	}
               }, error: function(){

      	    		var $this = $(".save-profile");
               		$this.button('reset');
               }
           });
           return false;
    	}


	 	$scope.readURL = function(event) {

	 		var files = event.target.files;
	 		
	 	 	//var files = $('input[type="file"]').get(0).files;

	 		var size, ext ;

	 	    file = files[0];

	 	  	if (file) {
	 	        size = file.size;
	 	    
	 	        ext = file.name.toLowerCase().trim();
	 	    
	 	        ext = ext.substring(ext.lastIndexOf('.') + 1);
	 	    
	 	        ext = ext.toLowerCase();
	 	    
	 	        var validExt = ["png","jpg","bmp","gif","jpeg"];
	 	    
	 	       	if($.inArray(ext,validExt) == -1){
	 	            message("Please must upload valid photo","show");
	 	            return false;
	 	        }
	 	    
	 	        else{
	 	            message("","hide");
	 	        }
	 	    
	 	        if(size > 5000000 ){
	 	        	alert("File must be less than 5MB")
	 	            return false;
	 	        }
	 	    
	 	    	var reader = new FileReader();
	 			reader.onload = $scope.onImageLoaded
	 	    	reader.readAsDataURL(file);
	 	  	} else {
	 	    	$scope.removeUpload();
	 	  	}

	 	}



	 	$scope.onImageLoaded = function(e){

	 		$scope.$apply(function() {

	 		   	$('.image-upload-wrap').hide();

	 		   	$("#edit_thumbnail").hide()

	 	    	$('.file-upload-image').prop('src', e.target.result);



	 		   	$('.file-upload-content').show();

	 		});

	 	}



	 	 $scope.removeUpload = function() {

	 	  $('.file-upload-content').hide();

	 	  document.getElementById("upload_img").value = "";

	 	  $('.image-upload-wrap').show();

	 	}
		 	
        $("#password_change").submit(function(e){

            e.preventDefault();

            var inputCurrentPassword = $("#inputCurrentPassword").val();
            var inputNewPassword = $("#inputNewPassword").val();
            var inputRetypeNewPassword = $("#inputRetypeNewPassword").val();

             // var reg = new RegExp(/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{6,20})$/);

             var reg = new RegExp(/^[A-Za-z0-9]{3,50}$/);

             if(reg.test(inputCurrentPassword) == false){

                jQuery("#inputCurrentPassword").css("border", "1px solid red");
                $("#oldpassworderror").html('Please provide the current password').show();
                return false;
             }
            else{
                 jQuery("#inputCurrentPassword").css("border", "1px solid #C9C9C9");
                 $("#oldpassworderror").html('').show();
             }

             if(reg.test(inputNewPassword) == false){
                jQuery("#inputNewPassword").css("border", "1px solid red");
                $("#newpassworderror").html('Please provide the new password').show();
                 return false;

            }

             else{

                jQuery("#inputNewPassword").css("border", "1px solid #C9C9C9");
                 $("#newpassworderror").html('').show();
             }



             if(reg.test(inputRetypeNewPassword) == false){

                 jQuery("#inputRetypeNewPassword").css("border", "1px solid red");
                 $("#retypepassworderror").html('Please retype the new password ').show();
                 return false;

             }

             else{

                jQuery("#inputRetypeNewPassword").css("border", "1px solid #C9C9C9");
                $("#retypepassworderror").html('').show();
             }



             if(inputRetypeNewPassword != inputNewPassword ){

                jQuery("#inputRetypeNewPassword").css("border", "1px solid red");

               jQuery("#inputNewPassword").css("border", "1px solid red");

               $("#retypepassworderror").html('New password and retype password did not match').show();

                return false;

            }

             else{

                 jQuery("#inputRetypeNewPassword").css("border", "1px solid #C9C9C9");

                 jQuery("#inputNewPassword").css("border", "1px solid #C9C9C9");
                 $("#retypepassworderror").html('').show();
             }

            var loader = $(".save_loader");
            loader.button('loading');

            var data = {
            	user_id:$scope.user_id,
                inputCurrentPassword: inputCurrentPassword,
                inputNewPassword: inputNewPassword,
                inputRetypeNewPassword: inputRetypeNewPassword
            };


            $myUtils.httppostrequest('<?php echo SHAMA_CORE_API_PATH; ?>password_change',data).then(function(response)
        	{
                    var $this = $(".save_loader");
                    $this.button('reset');
                    $("#inputCurrentPassword").val('');
                    $("#inputNewPassword").val('');
                    $("#inputRetypeNewPassword").val('');

                    if(response.message == true){
           				message('Password has been successfully changed','show')
           	    	}
                    if(response.message == 'pass_not_match'){
           				message('Current password is incorrect. Please provide correct current password','show')
           	    	}

           	    	if(response.message == false){
	                    var $this = $(".save_loader");
	                    $this.button('reset');
	                    message('Password has been not saved. Try again','show')
           	    	}
                });

            return false;

        });

    }

</script>


<link href="<?php echo $path_url; ?>css/easy-responsive-tabs.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>js/jquery.easyResponsiveTabs.js"></script>

<script type="text/javascript">

	$(document).ready(function(){

		$('#settings').easyResponsiveTabs({ tabidentify: 'vert' });
	    /*
	     * ---------------------------------------------------------
	     *   Save profile image
	     * ---------------------------------------------------------
	     */
        $("#profile_image_change").submit(function(e){
            e.preventDefault();
            var files = $('input[type="file"]').get(0).files;
            // Loop through files
            var size, ext ;
            file = files[0];
            message('','hide');
            if(file){
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

                if(size > 1048576 ){
                    message("Please must upload less than 1 MB file","show");
                    return false;
                }
                else{
                    message("","hide");
                }

                 var $this = $(".save-image");
                $this.button('loading');

               	var data = new FormData();
                data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');
                var i =0;
                $.each($("#inputFile")[0].files,function(key,value){
                    data.append("export",value);
                });

                $(".message-text").html('File importing').show();
                $(".user-message").show();

                $.ajax({
                    url: '<?php echo SHAMA_CORE_API_PATH;?>profile_image',
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
                    		message('Image saved','show')

                			$("#inputFile").val('')
                			$this.button('reset');
                			document.getElementById("pro_image").src=data.bigerlink;
                			document.getElementById("user_avatar").src=data.imagelink;
                    		setTimeout(function(){$(".message-text").html('').hide();  }, 3000);
                    	}else{
                    		$this.button('reset');
                    		message('Image not uploaded','show')
                    	}
                    },
                    error:function(error){
                    	$this.button('loading');
                    }
                });
            }else{
                message('Please select image','show');
            }

            return false;
        });
	});

</script>

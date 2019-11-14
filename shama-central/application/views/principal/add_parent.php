<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10">
	<?php
		// require_footer 
		require APPPATH.'views/__layout/filterlayout.php';
	?>
	<div class="col-lg-12 widget">
		<div class="row">
			<div class="widget-header" id="widget-header">
				<!-- widget title -->
  				<div class="widget-title">
	  				<h4>Teacher</h4>
  				</div>
			</div>
			<div class="widget-body">
				<div class="col-lg-12">
					<div class="form-container">
		          		<?php $attributes = array('name' => 'teacherForm', 'id' => 'teacherForm','class'=>'form-container'); echo form_open_multipart('', $attributes);?>
			               	<input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial">
		                	<fieldset>
			                	<div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-user"></span> Name <span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
				                			<input type="text" id="inputFirstName" name="inputFirstName" placeholder="First Name"  tabindex="1" value="<?php if(isset($result)){echo $result['teacher_firstname'];}?>">
				                		</div>
			                			<div class="right-column">
				                			<input type="text" id="inputLastName" name="inputLastName" placeholder="Last Name"  tabindex="1" value="<?php if(isset($result)){echo $result['teacher_lastname'];}?>">
				                		</div>
			                		</div>
			                	</div>
			                	<div class="field-container ">
			                		<div class="upper-row">
			                			<label><span class="icon-user"></span> Gender <span class="required" </span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<select tabindex="2"> id="input_t_gender" name="input_t_gender" value="<?php if(isset($result)){echo $result['gender'];}?>">
			                					<option <?php if($result['gender'] == "Male") echo "selected";?> >Male</option>
			                					<option <?php if($result['gender'] == "Fe-Male") echo "selected";?>> Fe-Male</option>
			                				</select>
				                		</div>
			                		</div>
			                	</div>
	                             <div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-user"></span> NIC #</label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<input type="text" tabindex="3" id="inputTeacher_Nic" name="inputTeacher_Nic" placeholder="35201-9926839-3" value="<?php if(isset($result)){echo $result['nic'];}?>">
				                		</div>
				                		<div class="right-column">
				                		
				                		</div>
			                		</div>
			                	</div>	

			                	       <div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-star-1"></span> Religion</label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<!--<input type="text" id="inputReligion" name="inputReligion" placeholder="Input the relegion" value="<?php if(isset($result)){echo $result['teacher_religion'];}?>">-->
			                				<select tabindex="4"> name="inputReligion" id="inputReligion" value="<?php if(isset($result)){echo $result['teacher_religion'];} ?>">
			                					<option  value="Islam" <?php if($result['teacher_religion'] == "Islam") echo "selected";?>>Islam</option>
			                					<option value="Christianity" <?php if($result['teacher_religion'] == "Christianity") echo "selected";?>>Christianity</option>
			                					<option value="Sikh" <?php if($result['teacher_religion'] == "Sikh") echo "selected";?>>Sikh</option>
			                					<option value="Hinduism" <?php if($result['teacher_religion'] == "Hinduism") echo "selected";?>>Hinduism</option>
			                					<option value="Other" <?php if($result['teacher_religion'] == "Other") echo "selected";?>>Other</option>
			                				</select>
				                		</div>
			                		</div>
			                	</div>	

			                	<div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-mail"></span> Email<span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<input tabindex="5" type="text" id="input_teacher_email" name="input_teacher_email" placeholder="Please enter Email" value="<?php if(isset($teacher_single)){echo $teacher_single[0]->email;}?>">
				                		</div>
			                		</div>
			                	</div>	
	                            <div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-phone"></span> Phone<span class="required"></span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<input tabindex="6" type="text" id="input_pr_phone" name="input_pr_phone" placeholder="Primary Phone" value="<?php if(isset($result)){echo $result['teacher_phone'];}?>">
			                			</div>
			                		</div>
			                	</div>

			                	<?php if(!$this->uri->segment(2)){ ?>
			                	<div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-lock-1"></span> Password <span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
		                					<input type="password" id="inputNewPassword" name="inputNewPassword" placeholder="New Password"  tabindex="7" >
				                		</div>
			                			<div class="right-column">
				                			<input type="password" id="inputRetypeNewPassword" name="inputRetypeNewPassword" placeholder="Retype New Password"  tabindex="7" >
				                		</div>
			                		</div>
			                		<div class="upper-row hide">
		                			 	<span class="form-inner-message" id="passwordError">Enter 6-20 character. Must contain(digit,uppercase & lowercase character and special character)</span>
			                		</div>
			                	</div>
			                	<?php } ?>	
	                	    	
			                	<div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-address"></span> Home Address <span class="required"></span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<input type="text" tabindex="8" id="pr_home" name="pr_home" placeholder="Primary Home Address" value="<?php if(isset($result)){echo $result['teacher_primary_address'];}?>">
			                			</div>
			                			<div class="right-column">
			                				<input type="text" tabindex="8" id="sc_home" name="sc_home" placeholder="Secondary Home Address" value="<?php if(isset($result)){echo $result['secondary_address'];}?>">
			                			</div>
			                		</div>
			                	</div>
			                	<div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-address"></span> Address <span class="required"></span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<select tabindex="8" name="inputProvice" value="<?php if(isset($result)){echo $result['province'];}?>">
			                					<option value="Azad Kashmir" <?php if($result['province'] == "Azad Kashmir") echo "selected";?> >Azad Kashmir</option>
			                					<option value="Balochistan" <?php if($result['province'] == "Balochistan") echo "selected";?>>Balochistan</option>
			                					<option <?php if($result['province'] == "Federally Administered Tribal Areas") echo "selected";?> value="Federally Administered Tribal Areas">Federally Administered Tribal Areas</option>
			                					<option <?php if($result['province'] == "Islamabad Capital Territory") echo "selected";?> value="Islamabad Capital Territory">Islamabad Capital Territory</option>
			                					<option <?php if($result['province'] == "Khyber Pakhtunkhwa") echo "selected";?> value="Khyber Pakhtunkhwa">Khyber Pakhtunkhwa</option>
			                					<option <?php if($result['province'] == "Northern Areas") echo "selected";?> value="Northern Areas">Northern Areas</option>
			                					<option <?php if($result['province'] == "Punjab") echo "selected";?> value="Punjab">Punjab</option>
			                					<option <?php if($result['province'] == "Sindh") echo "selected";?> value="Sindh">Sindh</option>
			                				</select>
			                			</div>
			                			<div class="right-column">
			                				<input type="text" tabindex="8" id="input_city" name="input_city" placeholder="City" style="width:30%;" value="<?php if(isset($result)){echo $result['teacher_city'];}?>">

			                				<input tabindex="8" id="input_zipcode" name="input_zipcode" style="width:29%;" type="text" placeholder="Zip code" value="<?php if(isset($result)){echo $result['teacher_zipcode'];}?>">
			                			</div>
			                		</div>
			                	</div>
			                
			                 <div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-location"></span> Location <span class="required"></span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
		                				<select tabindex="8" name="inputLocation" id="inputLocation" value="<?php if(isset($result)){echo $result['location'];}?>">
		                					<option value="Lahore" <?php if($result['location'] == "Lahore (01)") echo "selected";?> >Lahore (01)</option>
		                					<option value="Multan" <?php if($result['location'] == "Multan (02)") echo "selected";?>>Multan (02)</option>
					                		</select>
			                			</div>
			                			
			                		</div>
			                	</div>

			                	<div class="field-container ">
			                		<div class="file-upload">
										  <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>

										  		<div class="image-upload-wrap">
										    	<input tabindex="8" class="file-upload-input" type='file' onchange="readURL(this);" id="upload_img" name="upload_img" accept="image/*" />
										    	<div class="drag-text">
										      	<h3>Drag and drop a file or select add Image</h3>
										         </div>
										  		</div>
												  <div class="file-upload-content">
												    <img class="file-upload-image" src="#" alt="your image" />  <div class="image-title-wrap">
												      <button  type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
												    </div>
												  </div>
												</div>

													<input id="print" class="file-upload-btn btn btn-primary" type="button" name="print" value="Take Picture" onclick="popup()"/>

					                		 		<div class="col-lg-12">
					                		 			<div class="row">
					                		 				  <div class="caption">
        										 		<p class="lead">Profile Image</p>
        													</div>
					                		 				<div class="col-lg-4" id="imagesize">

					                		 					<img class="img-rounded" src='<?php if(isset($teacher_single)){ echo base_url()."upload/".$teacher_single[0]->profile_image;} ?>' width="100" height="100">
						                		 				
					                		 			</div>
					                		 			<div class="col-lg-8"> </div>
					                		 		</div>
					                		 		</div>
					                		 	</div>
					                	</div>


			                	</div>
			                			
			                	<div class="field-container">
			                		<div class="field-row">
			                			<button type="submit" tabindex="8" class="btn btn-default save-button">Save</button>
			                			<a  href="<?php echo $path_url; ?>show_teacher_list"  title="cancel">Cancel</a>
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

	$(document).ready(function(){
	 
        /*
         * ---------------------------------------------------------
         *   Save Teacher
         * ---------------------------------------------------------
         */ 
        $("#teacherForm").submit(function(e){
         	e.preventDefault();
            var inputFirstName = $("#inputFirstName").val();
            var inputLastName = $("#inputLastName").val();
            var input_teacher_email = $("#input_teacher_email").val();
            var inputTeacher_Nic=$("#inputTeacher_Nic").val();
         	var inputStore = $("#inputStore").val();
         	var inputNewPassword = $("#inputNewPassword").val();
            var inputRetypeNewPassword = $("#inputRetypeNewPassword").val();
            
            var reg = new RegExp(/^[A-Za-z0-9]{3,50}$/);
          
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

	           	 var userData = jQuery('#teacherForm').serializeArray();
	      
	      	ajaxType = "POST";
	  		urlpath = "<?php echo $path_url; ?>saveParent";
	     	ajaxfunc(urlpath,userData,teacherResponseFailure,loadTeacherResponse); 
	  		return false;
        });
	
		function teacherResponseFailure()
		{
			$(".user-message").show();
	    	$(".message-text").text("Teacher data not saved").fadeOut(10000);
		}

        function loadTeacherResponse(response)
        {
        	var is_img_uploaded = $("#upload_img").val();
        	if(response.message == true && is_img_uploaded != ''){
				
				saveprofileUpload(response.lastid)
			}
			else{
				window.location.href = "<?php echo $path_url;?>show_parents_list";
				
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
                		window.location.href = "<?php echo $path_url;?>show_parents_list";
                	}
                }
            });
            return false;
	     }     
 	});

function popup(){
    window.open("<?php echo $path_url; ?>take_pic", "_blank", "toolbar=no, scrollbars=no, resizable=no, top=80, left=400, width=600, height=500px");
}


setInterval(
	    function () {
	       	$.ajax({
                url: '<?php echo $path_url;?>getImgId',
                type: 'GET',
                data: ({}),
                cache: false,
                dataType: 'json',
                success: function(data) {
                	if(data.lastid != false)
                	{
                		
						 	
				 	 	$path = "<?php echo base_url(); ?>upload/"+data.lastid;
				 	 	$("#imagesize img").attr('src',$path)
					 	
                	}
                }
            });
	 
	 	
	    }, 2000);
function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
		$('.image-upload-wrap').addClass('image-dropping');
	});
	$('.image-upload-wrap').bind('dragleave', function () {
		$('.image-upload-wrap').removeClass('image-dropping');
});

</script>

<script type="text/javascript">
	
</script>
<script type="text/javascript">
	var app = angular.module('invantage', []);
</script>
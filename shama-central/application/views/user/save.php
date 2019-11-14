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

	<div class="panel panel-default">

		<div class="panel-heading">

			<label>Admin</label>

		</div>

		<div class="panel-body">

			<div class="form-container">

          		<?php $attributes = array('name' => 'userForm', 'id' => 'userForm','class'=>'form-container'); echo form_open_multipart('', $attributes);?>

	               	<input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial">

                	<fieldset>

	                	<div class="field-container">

	                		<div class="upper-row">

	                			<label><span class="icon-user"></span> Name <span class="required">*</span></label>

	                		</div>

	                		<div class="field-row">

	                			<div class="left-column">

		                			<input type="text" id="inputFirstName" required name="inputFirstName" pattern="[a-zA-Z]{3,40}" title="Username should only contain lowercase or uppercase letters. e.g. john" placeholder="First Name"  tabindex="1" value="<?php if(isset($result)){echo $result['teacher_firstname'];}?>">

		                		</div>

	                			<div class="right-column">

		                			<input type="text" id="inputLastName" pattern="[a-zA-Z]{3,40}" title="Last name should only contain lowercase or uppercase letters and minimum length 3. e.g. john" placeholder="Last Name" required name="inputLastName" placeholder="Last Name"  tabindex="1" value="<?php if(isset($result)){echo $result['teacher_lastname'];}?>">

		                		</div>

	                		</div>

	                	</div>

	                	<div class="field-container ">

	                		<div class="upper-row">

	                			<label><span class="icon-user"></span> Gender <span class="required" </span></label>

	                		</div>

	                		<div class="field-row">

	                			<div class="left-column">

	                				<select tabindex="2" id="input_t_gender" name="input_t_gender">

	                					<option value="1" <?php if($result['gender'] == 1) echo "selected"; ?> >Male</option>

	                					<option value="2" <?php if($result['gender'] == 2) echo  "selected"; ?> >Fe-Male</option>

	                				</select>

		                		</div>

	                		</div>
	                		<div class="upper-row">
	                			<label><span class="icon-phone"></span> Mobile<span class="required"></span></label>
	                		</div>
	                		<div class="field-row">
	                			<div class="right-column">
	                				<input tabindex="6" type="text" pattern="03[0-9]{2}-(?!1234567)(?!1111111)(?!7654321)[0-9]{7}" title="0342-9053716" id="input_pr_phone" name="input_pr_phone" placeholder="03xx-xxxxxxx" value="<?php if(isset($result)){echo $result['teacher_phone'];}?>">
	                			</div>
	                		</div>

	                	</div>



	                	<div class="field-container">

	                		<div class="upper-row">

	                			<label><span class="icon-mail"></span> Email<span class="required">*</span></label>

	                		</div>

	                		<div class="field-row">

	                			<div class="left-column">

	                				<input tabindex="5" type="email" id="input_teacher_email" name="input_teacher_email" placeholder="Please enter Email" value="<?php if(isset($teacher_single)){echo $teacher_single[0]->email;}?>">

		                		</div>

	                		</div>

	                	</div>	

                        <div class="field-container">
	                		
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

	                			<label><span class="icon-address"></span> State/Province <span class="required"></span></label>

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

			                		 				

	                	<div class="field-container ">

	                		<div class="file-upload">

								  <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>

								  		<div class="image-upload-wrap">

								    	<input tabindex="8" class="file-upload-input" type='file' onchange="readURL(this);" id="upload_img" name="upload_img" accept="image/*" />

								    	<div class="drag-text">

								      	<h3>Drag and drop an image or select add Image</h3>

								         </div>

								  		</div>

										  <div class="file-upload-content">

										    <img class="file-upload-image" src="#" alt="your image" />  <div class="image-title-wrap">

										      <button  type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>

										    </div>

										  </div>

										</div>

										
											<div class="row">
		                		 				<div class="col-sm-4" id="imagesize">
		                		 					<img class="img-rounded" src='<?php if(isset($teacher_single)){ echo $teacher_single[0]->profile_image;} ?>' width="250px" height="">
	                		 					</div>
		                		 			</div>
		                		 			<?php if(isset($teacher_single)){ ?>
		                		 			<div class="row">
		                		 				<div class="col-sm-4" id="edit_thumbnail">
		                		 					<img class="img-rounded thumbnail" src='<?php if(isset($teacher_single)){ echo $teacher_single[0]->profile_image;} ?>' width="250px" height="">
	                		 					</div>
		                		 			</div>
		                		 			<?php } ?>
			                		 	</div>

			                	</div>





	                

	                			

	                	<div class="field-container">

	                		<div class="field-row">

	                			<button type="submit" tabindex="8" class="btn btn-primary save-teacher" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>

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

        $("#userForm").submit(function(e){

         	e.preventDefault();

            var inputFirstName = $("#inputFirstName").val();

            var inputLastName = $("#inputLastName").val();

            var input_teacher_email = $("#input_teacher_email").val();

         	var inputNewPassword = $("#inputNewPassword").val();

            var inputRetypeNewPassword = $("#inputRetypeNewPassword").val();

            var reg = new RegExp(/^[A-Za-z0-9]{3,50}$/);

            myRegExp = new RegExp(/\d{5}-\d{7}-\d{1}$/);

         	 var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/i);

            if(reg.test(input_teacher_email) == false){
                jQuery("#input_teacher_email").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#input_teacher_email").css("border", "1px solid #C9C9C9");                                 
            }

             var reg = new RegExp(/^[A-Za-z0-9]{3,50}$/);

            if(reg.test(inputNewPassword) == false){

                jQuery("#inputNewPassword").css("border", "1px solid red");

                return false;

            }

            else{

                jQuery("#inputNewPassword").css("border", "1px solid #C9C9C9");                                 

            }



            if(reg.test(inputRetypeNewPassword) == false){

                jQuery("#inputRetypeNewPassword").css("border", "1px solid red");

                return false;

            }

            else{

                jQuery("#inputRetypeNewPassword").css("border", "1px solid #C9C9C9");                                 

            }

            

            if(inputRetypeNewPassword != inputNewPassword ){

                jQuery("#inputRetypeNewPassword").css("border", "1px solid red");

                jQuery("#inputNewPassword").css("border", "1px solid red");

                return false;

            }

            else{

                jQuery("#inputRetypeNewPassword").css("border", "1px solid #C9C9C9");                           

                jQuery("#inputNewPassword").css("border", "1px solid #C9C9C9"); 

            }

				

       	 	var userData = jQuery('#userForm').serializeArray();
       	   	var $this = $(".save-teacher");
            $this.button('loading');
	      

	      	ajaxType = "POST";

	  		urlpath = "<?php echo $path_url; ?>saveuser";

	     	ajaxfunc(urlpath,userData,teacherResponseFailure,loadTeacherResponse); 

	  		return false;

        });

	

		function teacherResponseFailure()

		{

			$(".user-message").show();

	    	$(".message-text").text("Teacher data not saved").fadeOut(10000);
	    		   var $this = $(".save-teacher");
            $this.button('reset');
		}



        function loadTeacherResponse(response)

        {

        	var is_img_uploaded = $("#upload_img").val();

        	if(response.message == true && is_img_uploaded != ''){

				// window.location.href = "<?php echo $path_url;?>show_teacher_list";
					   var $this = $(".save-teacher");
            $this.button('reset');
				saveprofileUpload(response.lastid)

			}

			else{

				window.location.href = "<?php echo $path_url;?>show_teacher_list";
					   var $this = $(".save-button");
            $this.button('reset');
				

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

                		window.location.href = "<?php echo $path_url;?>show_teacher_list";

                	}

                }

            });

            return false;

	     }     

 	});


	var is_take_image_mode_set = false;
	var is_take_image_set = false ;

	function popup(){
		is_take_image_set == false
		is_take_image_mode_set = true;
	    takeimagefromwebcam()
	    window.open("<?php echo $path_url; ?>take_pic", "_blank", "toolbar=no, scrollbars=no, resizable=no, top=80, left=400, width=600, height=500px");
	}
	
  	setInterval(function(){
    	if(is_take_image_mode_set == true && is_take_image_set == false)
        {
    		takeimagefromwebcam()
        }
    },3000)

	function takeimagefromwebcam()
	{
       	$.ajax({
            url: '<?php echo $path_url;?>getImgId',
            type: 'GET',
            data: ({}),
            cache: false,
            dataType: 'json',
            success: function(data) {
            	if(data.lastid != false)
            	{
            		is_take_image_set == true
			 	 	$path = "<?php echo base_url(); ?>upload/profile/"+data.lastid;
			 	 	$("#imagesize img").attr('src',$path)
			 	 	$("#imagesize").show()
			 	 	$("#edit_thumbnail").hide()
            	}
            }
        });
	}

	function readURL(input) {
  		if (input.files && input.files[0]) {
			var reader = new FileReader();
    		reader.onload = function(e) {
    			$("#edit_thumbnail").hide()
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
<?php

// require_header
require APPPATH . 'views/__layout/header.php';

// require_top_navigation
require APPPATH . 'views/__layout/topbar.php';

// require_left_navigation
require APPPATH . 'views/__layout/leftnavigation.php';

?>

<div class="col-sm-10" ng-controller="teacherCtrl">

	<?php

// require_footer
require APPPATH . 'views/__layout/filterlayout.php';

?>

	<div class="panel panel-default">
		<div class="panel-heading">

			<label>Teacher</label>

		</div>

		<div class="panel-body">

      		<?php $attributes = array('name' => 'teacherForm', 'id' => 'teacherForm','class'=>'form-horizontal'); echo form_open_multipart('', $attributes);?>

               	<input type="hidden"
				value="{{serial}}"
				name="serial" id="serial">

			<div class="form-group">

				<div class="col-sm-6">

					<label class="control-label" for="inputFirstName">First name<span
						class="required">*</span></label> <input type="text"
						id="inputFirstName" required name="inputFirstName"
						pattern="[a-zA-Z\s]{3,40}"
						title="Username should only contain lowercase or uppercase letters. e.g. john"
						placeholder="First Name" tabindex="1" value=""
						ng-model="inputFirstName" class="form-control"> <span
						class="errorhide" id="fname_error">Please enter first name</span>

				</div>

				<div class="col-sm-6">

					<label for="inputLastName">Last name<span class="required">*</span></label>

					<input type="text" id="inputLastName" pattern="[a-zA-Z\s]{3,40}"
						title="Last name should only contain lowercase or uppercase letters and minimum length 3. e.g. john"
						placeholder="Last Name" required name="inputLastName"
						placeholder="Last Name" tabindex="1" value=""
						ng-model="inputLastName" class="form-control"> <span
						class="errorhide" id="lname_error">Please enter last name</span>

				</div>

			</div>

			<div class="form-group">

				<div class="col-sm-6">

					<label class="" for="input_t_gender">Gender</label> <select
						ng-options="item.title for item in genderlist track by item.id"
						class="form-control" name="input_t_gender" id="input_t_gender"
						ng-model="input_t_gender"></select>

				</div>

				<div class="col-sm-6">

					<label class="" for="inputTeacher_Nic">CNIC<span class="required">*</span></label>

					<input type="text" tabindex="3" required id="inputTeacher_Nic"
						title="xxxxx-xxxxxxx-x" name="inputTeacher_Nic"
						placeholder="xxxxx-xxxxxxx-x" ng-blur="checkDublication()"
						value="" ng-model="inputTeacher_Nic" class="form-control"> <span
						class="errorhide" id="teacher_nic">Please Enter correct CNIC
						number</span>

				</div>

			</div>

			<div class="form-group">

				<div class="col-sm-6">

					<label class="" for="input_teacher_email">Email<span
						class="required">*</span></label> 
						<input tabindex="5" type="email"
						ng-model="input_email"
						id="input_teacher_email" name="input_teacher_email"
						ng-blur="checkEmailDupilcation()" placeholder="Please enter Email"
						value="<?php if(isset($teacher_single)){echo $teacher_single[0]->email;}?>"
						class="form-control"> <span class="errorhide" id="teacher_email">Please
						enter correct email address </span>

				</div>

				<div class="col-sm-6">

					<label class="" for="input_pr_phone">Phone<span class="required">*</span></label>

					<input tabindex="6" type="text" id="input_pr_phone"
						name="input_pr_phone" placeholder="xxxx-xxxxxxx" value=""
						ng-model="input_pr_phone" class="form-control"> <span
						id="valid-msg" class="hide">✓ Valid</span> <span id="error-msg"
						class="hide">Invalid number</span> <span class="errorhide"
						id="teacher_phone">Format 0833-1234567-8888 | (0833)1234567-8888 |
						12345678</span>

				</div>

			</div>

			<div class="form-group hide">



				<div class="col-sm-6">

					<label class="" for="inputLocation">School<span class="required">*</span></label>

					<select
						ng-options="item.sname for item in selectlistcity track by item.id"
						class="form-control" name="inputLocation" id="inputLocation"
						ng-model="inputLocation"></select>

				</div>

			</div>	

				

			<div class="form-group">

				<div class="col-sm-6">

					<label class="" for="inputNewPassword">Password </label>
					<input type="password"
						id="inputNewPassword" name="inputNewPassword"
						placeholder="New Password" tabindex="7" class="form-control"> <span
						class="errorhide" id="teacher_passowrd">Please enter your password
					</span>

				</div>

				<div class="col-sm-6">

					<label class="" for="inputRetypeNewPassword">Retype Password: </label> 
					<input type="password"
						id="inputRetypeNewPassword" name="inputRetypeNewPassword"
						placeholder="Retype New Password" tabindex="7"
						class="form-control"> <span class="errorhide"
						id="teacher_re_passowrd">Please re-type the same password </span>

				</div>

				<span class="form-inner-message" id="confimr_passowrd">Please enter
					the same password</span>

			</div>


				<div class="form-group">

				<div class="col-sm-6">

					<label class="" for="pr_home">Home Address (Primary)</label> <input
						type="text" tabindex="8" id="pr_home" name="pr_home"
						placeholder="Primary Home Address" value="" ng-model="pr_home"
						class="form-control">

				</div>

				<div class="col-sm-6">

					<label class="" for="sc_home">Home Address (Secondary)</label> <input
						type="text" tabindex="8" id="sc_home" name="sc_home"
						placeholder="Secondary Home Address" value="" ng-model="sc_home"
						class="form-control">

				</div>

			</div>

			<div class="form-group">

				<div class="col-sm-6">

					<label class="" for="inputProvice">State</label> <select
						ng-options="item.title for item in provincelist track by item.id"
						name="inputProvice" id="inputProvice" ng-model="inputProvice"
						class="form-control"></select>

				</div>

				<div class="col-sm-3">

					<label class="" for="input_city">City</label> <input type="text"
						tabindex="8" id="input_city" name="input_city" placeholder="City"
						value="" ng-model="input_city" class="form-control">

				</div>

				<div class="col-sm-3">

					<label class="" for="sc_home">Zip code</label> <input tabindex="8"
						id="input_zipcode" name="input_zipcode" type="text"
						placeholder="Zip code" value="" ng-model="input_zipcode"
						class="form-control">

				</div>

			</div>

			<div class="form-group">

				<div class="col-sm-12">

					<label class="" for="inputProvice"><input type="checkbox"
						ng-true-value="true" name="inputMasterteacher"
						id="inputMasterteacher" ng-model="inputMasterteacher">Master
						Teacher</label>

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
					

					<div class="row file-upload"
						style="padding-top: 0; padding-bottom: 0;">

						<div class="col-sm-12">

							<video id="video" width="640" height="480" style="display: none;"></video>

							<canvas id="canvas" width="640" height="480"
								style="display: none;"></canvas>

						</div>

					</div>

					<div class="row">

						<div class="col-sm-12">

							<button type="button" id="take_pic_btn"
								class="file-upload-btn btn btn-primary" name="button"
								ng-click="openwebcam()">Take Picture</button>

							<input id="print" class="file-upload-btn btn btn-primary"
								style="display: none;" type="button" name="print"
								value="Capture Screenshot" ng-click="popup();" />

						</div>

					</div>
<!-- 
					<div class="row">

						<div class="col-sm-4" id="imagesize">

							<img class="img-rounded" src='{{teacher.profile_image}}'
								width="250px" height="">

						</div>

					</div> -->



					<div class="row" ng-display="teacher.profile_image">

						<div class="col-sm-4" id="edit_thumbnail">

							<img class="img-rounded thumbnail" src='{{teacher.profile_image}}'
								width="250px" height="">

						</div>

					</div>

				</div>

			</div>

			<div class="form-group">

				<div class="col-sm-12">

					<button id="save_teacher" type="button" tabindex="8"
						ng-click="saveTeacher()" class="btn btn-primary save-teacher"
						data-loading-text="<i   class='fa fa-circle-o-notch fa-spin'>
						</i> Saving...">Save
					</button>

					<a href="<?php echo $path_url; ?>show_teacher_list" title="cancel">Cancel</a>

				</div>

			</div>

            <?php echo form_close();?>

		</div>

	</div>

</div>







<?php

// require_footer

require APPPATH . 'views/__layout/footer.php';

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



    document.getElementById("input_pr_phone").onkeypress = validate_int;

    document.getElementById("input_pr_phone").onkeyup = phone_number_mask;



    document.getElementById("inputTeacher_Nic").onkeypress = validate_int;

    document.getElementById("inputTeacher_Nic").onkeyup = nic_number_mask;

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



    function nic_number_mask() {

    	try{

       		var myMask = "_____-_______-_";

      		var myCaja = document.getElementById("inputTeacher_Nic");

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

      		document.getElementById("inputTeacher_Nic").value = myOutPut;

      		document.getElementById("inputTeacher_Nic").setSelectionRange(theLastPos, theLastPos);

  		}

  		catch( e)

  		{

  			console.log(e)

  		}

   	}


    app.controller('teacherCtrl',['$scope','$myUtils', '$filter', teacherCtrl]);

    function teacherCtrl($scope, $myUtils, $filter) {

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
				getteacherdetail:'<?php echo SHAMA_CORE_API_PATH; ?>teacher',
				saveteacher:'<?php echo SHAMA_CORE_API_PATH; ?>teacher',
				checkuserbyemail:'<?php echo SHAMA_CORE_API_PATH; ?>check_user_by_email',
				checkuserbynic:'<?php echo SHAMA_CORE_API_PATH; ?>check_user_by_nic',
				getschoollist:'<?php echo SHAMA_CORE_API_PATH; ?>schools',
				saveprofileimage:'<?php echo SHAMA_CORE_API_PATH; ?>profile_image'
				}

		
		$scope.pr_home ="";

		$scope.sc_home ="";

		$scope.input_city ="";

		$scope.input_zipcode ="";



		$scope.genderlist = [

			{

				id:1,

				title:'Male',

			},

			{

				id:2,

				title:'Female',

			}

		]

		$scope.input_t_gender = $scope.genderlist[0]


$scope.ho


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

		]

		$scope.inputProvice = $scope.provincelist[0];



		$scope.serial = '';

		$scope.is_edit = "<?php echo $this->uri->segment('2'); ?>";

		$scope.teacher = [];



		angular.element(function () {

			

			if($scope.is_edit == '')

			{

				getSchoolList()

			}



			if($scope.is_edit != '')

			{

				$scope.serial = $scope.is_edit;

				getUserInfo();

			}

		 });



		 $scope.selectlistcity = [];

		function getSchoolList()

        {

         	try{

                var data = ({})

                $myUtils.httprequest(urlist.getschoollist,data).then(function(response){

                    if(response.length > 0 && response != null)

                    {

                        $scope.selectlistcity = response;

                        $scope.inputLocation = response[0];



                        if($scope.is_edit != '')

                        {

                        	var found = $filter('filter')($scope.selectlistcity,{id:$scope.teacher.city},true);

                        	if(found.length)

                        	{

                        		$scope.inputLocation = found[0];

                        	}

                        }

                    }

                    else{

                        $scope.selectlistcity = []

                    }

                })

            }

            catch(ex){}

        }



		function getUserInfo() {

			try{

			   var data = ({id:$scope.is_edit})

			   $myUtils.httprequest(urlist.getteacherdetail, data).then(function(response){

				   if(response != null)

				   {

				   	   $scope.teacher = response;

				   	   getSchoolList();

					   $scope.inputFirstName = response.first_name;

					   $scope.inputLastName = response.last_name;



					   $scope.input_t_gender = $scope.genderlist[parseInt(response.gender) - 1]

					   $scope.inputTeacher_Nic = response.nic;



                    	var found = $filter('filter')($scope.provincelist,{id:response.province},true);

                    	if(found.length)

                    	{

                    		$scope.inputProvice = found[0];

                    	}



					   $scope.input_email = response.email;

					   $scope.input_pr_phone = response.phone;

					   $scope.pr_home = response.primary_address;

					   $scope.sc_home = response.secondary_address;

					   $scope.input_city = response.city;

					   $scope.input_zipcode = response.zip_code;

					   $scope.inputMasterteacher = (response.master_teacher == 1 ? true :false);

				   }

				   else{



				   }

			   })

		   }

		   catch(ex){}

		}



	$scope.is_nonvalid_teacher = false;



	$scope.checkEmailDupilcation = function()

	{

		var eregix=new RegExp(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/);

		var input_teacher_email = $("#input_teacher_email").val();

		var same = false;
		if($scope.teacher!=null && $scope.teacher.email == input_teacher_email){
			same = true;
		}

		if( eregix.test(input_teacher_email) && !same)

		{

			var data = ({
							value:input_teacher_email,
							id:$scope.is_edit
						});

			$myUtils.httprequest(urlist.checkuserbyemail, data).then(function(response)

			{

				if(response.message == true)

				{

					$scope.is_nonvalid_teacher = true;

					$("#teacher_email").html('Use a different email').show()

					jQuery("#input_teacher_email").addClass('errorshow');

					document.getElementById('save_teacher').disabled = true;

					$("#teacher_email").re();

				}

				else{

					$scope.is_nonvalid_teacher = false;

					$("#teacher_email").hide();

					jQuery("#input_teacher_email").removeClass('errorshow');

				}





			 	if(response.message == false)

			 	{

			 		document.getElementById('save_teacher').disabled = false;

			 	}

			});

		}

	}



	$scope.checkDublication = function()

	{

		

		var inputTeacher_Nic = $("#inputTeacher_Nic").val();



		if(inputTeacher_Nic != null)

		{

			if(inputTeacher_Nic.length == 15)

			{

				var data = ({

					value:inputTeacher_Nic,

					//inputserial:"<?php echo $this->uri->segment('2'); ?>"

				})



				$myUtils.httprequest(urlist.checkuserbynic,data).then(function(response)

				{



					if(response.message == true)

					{

						$("#teacher_nic").html('Duplicate CNIC entered').show()

						$scope.is_nonvalid_teacher = true;

						document.getElementById('save_teacher').disabled = true;

						jQuery("#inputTeacher_Nic").addClass('errorshow');

					}

				 	else

				 	{

					 	$scope.is_nonvalid_teacher = false;

						$("#teacher_nic").html('').hide();

						

						jQuery("#inputTeacher_Nic").removeClass('errorshow');

						

				 	}



				 	if(response.nic == false)

				 	{

				 		document.getElementById('save_teacher').disabled = false;

				 	}

				});

			}

		}

	}





	$scope.openwebcam = function()

	{

		// Grab elements, create settings, etc.

		var video = document.getElementById('video');

			// Get access to the camera!
			if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {

				// Not adding `{ audio: true }` since we only want video now

				navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {

					//video.src = window.URL.createObjectURL(stream);
					video.srcObject = stream;

					video.play();

				});

			}

		$("#video").show()

		$("#print").show()

		$("#take_pic_btn").hide()

	}





    /*

     * ---------------------------------------------------------

     *   Save Teacher

     * ---------------------------------------------------------

     */

    	$scope.saveTeacher = function()

        {


            var isEdit = $("#serial").val();

            var inputFirstName = $("#inputFirstName").val().trim();

            var inputLastName = $("#inputLastName").val().trim();

            var input_teacher_email = $("#input_teacher_email").val().trim();

            var inputTeacher_Nic=$("#inputTeacher_Nic").val();

            var input_pr_phone=$("#input_pr_phone").val();

         	var inputNewPassword = $("#inputNewPassword").val();

            var inputRetypeNewPassword = $("#inputRetypeNewPassword").val();

          



            var reg = new RegExp(/^[A-Za-z]{3,50}$/);

            myRegExp = new RegExp(/\d{5}-\d{7}-\d{1}$/);

           	var eregix=new RegExp(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/);

           	var mobile=new RegExp(/^[0-9]{4}-[0-9]{7}$/);

           	var nic=new RegExp(/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/);



           	if(reg.test(inputFirstName)==false){



            	jQuery("#inputFirstName").addClass('errorshow');

            	jQuery("#fname_error").show();

            	isValid = false;

            	return false;

        	}

	        else{

	            isValid = true;

             	jQuery("#fname_error").hide();

	            jQuery("#inputFirstName").removeClass('errorshow')

	        }



	        if(reg.test(inputLastName)==false){



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



         	if(nic.test(inputTeacher_Nic)==false){



            	jQuery("#inputTeacher_Nic").addClass('errorshow');

            	$("#teacher_nic").html('Please enter correct CNIC number').show();

            	isValid = false;

            	return false;

        	}

	        else{

	            isValid = true;

	            $("#teacher_nic").html('').hide();

	            jQuery("#inputTeacher_Nic").removeClass('errorshow')

	        }



	      

	        if(eregix.test(input_teacher_email)==false){



            	jQuery("#input_teacher_email").addClass('errorshow');

            	$("#teacher_email").html('Please enter correct email address').show()

            	isValid = false;

            	return false;

        	}

	        else{

	            isValid = true;

	             $("#teacher_email").html('').hide()

	            jQuery("#input_teacher_email").removeClass('errorshow')

	        }



	         if(mobile.test(input_pr_phone)==false){



            	jQuery("#input_pr_phone").addClass('errorshow');

            	$("#teacher_phone").html('Please enter correct phone number').show()

            	isValid = false;

            	return false;

        	}

	        else{

	            isValid = true;

	             $("#teacher_phone").html('').hide()

	            jQuery("#input_pr_phone").removeClass('errorshow')

	        }





			var inputEmail=$("#input_teacher_email").val();

			var NIC=$("#inputTeacher_Nic").val();



            var reg = new RegExp(/^[A-Za-z0-9]{3,50}$/);


            if(isEdit && inputNewPassword.length==0){
                // Ignore empty password
            }else{
                if(reg.test(inputNewPassword) == false){
    
    
    
                    jQuery("#inputNewPassword").addClass('errorshow');
    
                    $("#teacher_passowrd").show()
    
                    return false;
    
                }
    
                else{
    
                    jQuery("#inputNewPassword").removeClass('errorshow');
    
                    $("#teacher_passowrd").hide()
    
                }
    
    
    
                if(reg.test(inputRetypeNewPassword) == false){
    
                    jQuery("#inputRetypeNewPassword").addClass('errorshow');
    
                    $("#teacher_re_passowrd").show()
    
                    return false;
    
                }
    
                else{
    
                    jQuery("#inputRetypeNewPassword").removeClass('errorshow');
    
                     $("#teacher_re_passowrd").hide()
    
                }
    
    
    
    
    
                if(inputRetypeNewPassword != inputNewPassword ){
    
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
            }


			var input_teacher_email = $("#input_teacher_email").val().trim();

			var inputTeacher_Nic = $("#inputTeacher_Nic").val().trim();



		

			if($scope.is_nonvalid_teacher == false)

			{

				var data = {
						id:$("#serial").val(),
						first_name:inputFirstName,
						last_name:inputLastName,
						gender:$scope.input_t_gender?$scope.input_t_gender.id:"",
						nic:NIC,
						email:input_teacher_email,
						phone:input_pr_phone,
						p_home:$scope.pr_home,
						s_home:$scope.sc_home,
						city:$scope.input_city,
						province:$scope.inputProvice.id,
						zip_code:$scope.input_zipcode,
						school_id:$scope.school_id,
						is_master:($scope.inputMasterteacher == true ? 1 : 0)
						};
				
				if(inputNewPassword && inputRetypeNewPassword)

				{
					data.password=inputNewPassword;
					data.repeat_password=inputRetypeNewPassword;
				}
				
				var is_img_uploaded = $("#upload_img").val();
				/*
				var files = $('input[type="file"]').get(0).files;
				
				if(files){

                    $.each(files,function(key,value){
                    	formdata.append("export",value);
		            });
				}
				*/
				
				var $this = $(".save-teacher");

				$this.button('loading');

				$myUtils.httppostrequest(urlist.saveteacher,data).then(function(response){

						if(response.message == true){

				        	var src = $(".file-upload-image").attr("src");
				            								
							if(src != "#" && src.length>1){
								
								saveprofileUpload(response.last_id);
								
							}else{

								window.location.href = "<?php echo $path_url;?>show_teacher_list";

					   			var $this = $(".save-teacher");

					   			$this.button('reset');

							}

						}else{

							var $this = $(".save-teacher");

							$this.button('reset');

							message('Teacher not saved','show')

						}

					});

				}else{

					var $this = $(".save-teacher");

					$this.button('reset');

				}
			
	  			return false;

		};





     	/*

	     * ---------------------------------------------------------

	     *   Save profile image

	     * ---------------------------------------------------------

	     */





	     function saveprofileUpload(teacherId)
	     {
            var data = new FormData();
            data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');

            var i =0;

        	var src = $(".file-upload-image").attr("src");
            data.append("image_64",src);

            data.append('id',teacherId)

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
						var $this = $(".save-teacher");
						$this.button('reset');

                		window.location.href = "<?php echo $path_url;?>show_teacher_list";
                	}
                }
            });
            return false;
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

		//var fileinput = angular.element($('#upload_img')).triggerHandler('input');

		$("#video").hide()

		$("#print").hide()

		$("#take_pic_btn").show()

		$('#file_upoad_content').show();

		$('#image_upoad_wrap').hide();



		$("#edit_thumbnail").hide()



		//window.open("<?php //echo $path_url; ?>take_pic", "_blank", "toolbar=no, scrollbars=no, resizable=no, top=80, left=400, width=600, height=500px");

	}



 //  	setInterval(function(){

    // 	if(is_take_image_mode_set == true && is_take_image_set == false)

    //     {

    // 		takeimagefromwebcam()

    //     }

    // },3000)



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



	//  $('.file-upload-input').replaceWith($('.file-upload-input').clone());



	  $('.file-upload-content').hide();

	  document.getElementById("upload_img").value = "";

	  $('.image-upload-wrap').show();



	}



	$('.image-upload-wrap').bind('dragover', function () {

		$('.image-upload-wrap').addClass('image-dropping');

	});



	$('.image-upload-wrap').bind('dragleave', function () {

		$('.image-upload-wrap').removeClass('image-dropping');



	});

}

</script>


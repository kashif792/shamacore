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
	  				<h4>Parents</h4>
  				</div>
			</div>
			<div class="widget-body">
				<div class="col-lg-12">
					<div class="form-container">
		          		<?php $attributes = array('name' => 'parentForm', 'id' => 'parentForm','class'=>'form-container'); echo form_open_multipart('', $attributes);?>
			               	<input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial">
		                	<fieldset>
			                	<div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-user"></span> Name <span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
				                			<input type="text" id="inputFirstName" name="inputFirstName" placeholder="First Name"  tabindex="1" value="<?php if(isset($getUserInfo)){echo $getUserInfo[0]->first_name;} ?>">
				                		</div>
			                			<div class="right-column">
				                			<input type="text" id="inputLastName" name="inputLastName" placeholder="Last Name"  tabindex="1" value="<?php if(isset($getUserInfo)){echo $getUserInfo[0]->last_name;} ?>">
				                		</div>
			                		</div>
			                	</div>
			                	<div class="field-container ">
			                		<div class="upper-row">
			                			<label><span class="icon-user"></span> Gender <span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<select name="inputGender" id="inputGender">
			                					<option value="m">Male</option>
			                					<option value="f">Fe-Male</option>
			                				</select>
				                		</div>
			                		</div>
			                	</div>
			                	<div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-mail"></span> Email <span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<input type="text" name="inputEmail" id="inputEmail" placeholder="Parent Primary Email">
				                		</div>
			                		</div>
			                	</div>										                
	                	    	
			                	<div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-home-1"></span> Home Address <span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<input type="text" id="inputHomePrimary" name="inputHomePrimary" placeholder="Primary Home Address">
			                			</div>
			                			<div class="right-column">
			                				<input type="text" id="inputSecondary" name="inputSecondary" placeholder="Secondary Home Address">
			                			</div>
			                		</div>
			                	</div>
			                	<div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-home-1"></span> Address <span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<select id="inputCountry" name="inputCountry">
			                					<option value="pak">Pakistan</option>
			                					<option value="usa">USA</option>
			                				</select>
			                			</div>
			                			<div class="right-column">
			                				<input type="text" id="inputCity" name="inputCity"  placeholder="City" style="width:30%;">
			                				<select style="width:42%;" id="inputProvince" name="inputProvince">
			                					<?php
			                						if(isset($provinces)){
			                							foreach ($provinces as $key => $value) {
			                								?>
			                									<option value="<?php echo $value->slug; ?>"><?php echo $value->name; ?></option>
			                								<?php 
			                							}
			                						}

			                					 ?>
			                				</select>
			                				<input style="width:17%;" id="inputZipcode" name="inputZipcode" type="text" placeholder="Zip code">
			                			</div>
			                		</div>
			                	</div>
			                	<div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-phone"></span> Phone<span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<input type="text" id="inputPhone" name="inputPhone" placeholder="Primary Phone">
			                			</div>
			                		</div>
			                	</div>
			                	
			                	<div class="field-container ">
			                		<div class="upper-row">
			                			<label><span class="icon-mail-alt"></span> Profile Image <span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<input type="file" id="inputProfile" accept=".png,.gif,.bmp,.jpg,.jpeg" name="inputProfile">
			                			</div>
			                		</div>
			                	</div>
			                			
			                	<div class="field-container">
			                		<div class="field-row">
			                			<button type="submit" tabindex="8" class="btn btn-default save-button">Save</button>
			                			<a tabindex="9" href="<?php echo $path_url; ?>settings" tabindex="6" title="cancel">Cancel</a>
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

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#example').DataTable();
	 	$('input[name="attendanceinput"]').daterangepicker({
	         singleDatePicker: true,
	        showDropdowns: true,
	        startDate: "<?php if(isset($annoucement_single)){echo date('m/d/Y',strtotime($annoucement_single[0]->sdate)).$annoucement_single[0]->stime;}else{ echo date('m/d/Y');} ?>",
	        locale: {
	            format: 'MM/DD/YYYY'
	        }
    	});
	 	$('input[name="stimepicker"]').daterangepicker({
	        timePicker: true,
	        showDropdowns: true,
	        timePicker24Hour: true,
	        startDate: "<?php if(isset($annoucement_single)){echo date('m/d/Y',strtotime($annoucement_single[0]->sdate)).$annoucement_single[0]->stime;}else{ echo date('m/d/Y');} ?>",
	        endDate: "<?php if(isset($annoucement_single)){echo date('m/d/Y',strtotime($annoucement_single[0]->edate)).$annoucement_single[0]->etime;}else{ echo date('m/d/Y');} ?>",
	        locale: {
	            format: 'MM/DD/YYYY h:mm A'
	        }
    	});
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
	  	getStoreList();
	    /**
	     * ---------------------------------------------------------
	     *   Store list
	     * ---------------------------------------------------------
	     */
	    function getStoreList () {
    	 	var dataString = "";
	      	ajaxType = "GET";
	  		urlpath = "<?php echo $path_url; ?>api/customers_list/format/json";
	     	ajaxfunc(urlpath,dataString,userResponseFailure,getStoreListReponse); 
	  	}

	  	function getStoreListReponse (response) {
	   		dataLength = response.length -1;
	   		var stores = [];
            for (var i = 0;  i <= dataLength ; i++) {
            	stores[i] = response[i].trim();
            }

        	var dataString = ({"stores":stores,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'});
	      	ajaxType = "POST";
	  		urlpath = "<?php echo $path_url; ?>savestore";
	     	ajaxfunc(urlpath,dataString,errorhandler,updateStoreListReponse); 
	  
	  	}

	  	function updateStoreListReponse(response){}

    /*
     * ---------------------------------------------------------
     *   Save new user
     * ---------------------------------------------------------
     */
     	/*
         * ---------------------------------------------------------
         *   Password generator
         * ---------------------------------------------------------
         */ 
     	function generatePassword() {
		    var length = 6,
		        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
		        retVal = "";
		    for (var i = 0, n = charset.length; i < length; ++i) {
		        retVal += charset.charAt(Math.floor(Math.random() * n));
		    }
		    return retVal;
		}
		
		$(document).on('click','#inputPasswordGenerator',function(){
        	var passgen = generatePassword();
        	$("#inputNewPassword").val(passgen)
        	$("#inputRetypeNewPassword").val(passgen)
        	return false;
        });

      	/*
         * ---------------------------------------------------------
         *   Show hide user form on button click event
         * ---------------------------------------------------------
         */   
        $(document).on('click','#button_toggle',function(){
            var classHide = $( "#userForm" ).hasClass( "hide" );
            $("#password-edit").show();
            if(classHide == true){
              refreshform();
                      
            }else{
                $("#userForm").removeClass('show');
                $("#userForm").addClass('hide');
            }
        });
    
        /*
         * ---------------------------------------------------------
         *   Save parent
         * ---------------------------------------------------------
         */ 
        $("#parentForm").submit(function(e){
         	e.preventDefault();
            var inputFirstName = $("#inputFirstName").val();
            var inputLastName = $("#inputLastName").val();
            var inputEmail = $("#inputEmail").val();
         	var inputHomePrimary = $("#inputHomePrimary").val();
         	var inputSecondary = $("#inputSecondary").val();
         	var inputCity = $("#inputCity").val();
         	var inputZipcode = $("#inputZipcode").val();
         	var inputPhone = $("#inputPhone").val();
         	
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
           
            var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            if(reg.test(inputEmail) == false){
                jQuery("#inputEmail").css("border", "1px solid red");
                jQuery("#inputEmail").focus();
                return false;
            }
            else{
                jQuery("#inputEmail").css("border", "1px solid #C9C9C9");                                 
            }
            
            var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            if(inputHomePrimary.length == '' || inputHomePrimary.length < 3){
                jQuery("#inputHomePrimary").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputHomePrimary").css("border", "1px solid #C9C9C9");                                 
            }
           

            if (inputSecondary){
                if(inputSecondary.length == '' || inputSecondary.length < 3){
                    jQuery("#inputSecondary").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#inputSecondary").css("border", "1px solid #C9C9C9");                                 
                }
            }

            var reg = new RegExp(/^[A-Za-z ]{3,50}$/);
            if(reg.test(inputCity) == false){
                jQuery("#inputCity").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputCity").css("border", "1px solid #C9C9C9");                                 
            }

            var reg = new RegExp(/^\d{5}((-|\s)?\d{4})?$/);
            if(reg.test(inputZipcode) == false){
                jQuery("#inputZipcode").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputZipcode").css("border", "1px solid #C9C9C9");                                 
            }
                  
            var reg = new RegExp(/^((\(\d{3,4}\)|\d{3,4}-)\d{4,9}(-\d{1,5}|\d{0}))|(\d{4,12})$/);
            if(reg.test(inputPhone) == false){
                jQuery("#inputPhone").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputPhone").css("border", "1px solid #C9C9C9");                                 
            }
                	
          
	      	var dataString = jQuery('#parentForm').serializeArray();
	      	ajaxType = "POST";
	  		urlpath = "<?php echo $path_url; ?>addparent";
	     	//ajaxfunc(urlpath,dataString,userResponseFailure,loadUserResponse); 
	  		return false;
        });
	
		function userResponseFailure()
		{
			$(".user-message").show();
	    	$(".message-text").text("User data not saved").fadeOut(10000);
		}

        function loadUserResponse(response)
        {
        	if(response.message == true){
				window.location.href = "<?php echo $path_url;?>settings";
			}
        }     

         /*
	     * ---------------------------------------------------------
	     *   Save profile image
	     * ---------------------------------------------------------
	     */
	    function saveProfileImage()
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

            if(size > 5242880 ){
                message("Please must upload less than 1 MB file","show");
                return false;
            }
            else{
                message("","hide");
            }

           	var data = new FormData();
            data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');
            var i =0;
            $.each($("#inputFile")[0].files,function(key,value){
                data.append("export",value);
            });
            
            $(".message-text").html('File importing').show();
            $(".user-message").show();

            $.ajax({
                url: '<?php echo $path_url;?>users/profileimage?files',
                type: 'POST',
                data: data,
                cache: false,
                dataType: 'json',
                mimeType:"multipart/form-data",
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data) {
                	console.log(data)
                }
            });
            return false;
	    }

      
	     
      	/*
         * ---------------------------------------------------------
         *   Store checking
         * ---------------------------------------------------------
         */ 
        function checkStore()
        {
        	ajaxType = "GET";
            urlpath = "savestore";
            storedata = {'stores':storelist}  ;
            ajaxfunc(urlpath,storedata,errorhandler,getStoreResponse);
        }
       
         
	    /*
         * ---------------------------------------------------------
         *   Email checking
         * ---------------------------------------------------------
         */
        $(document).on('blur','#inputEmail',function(){

            var inputEmail = $("#inputEmail").val();
             if(inputEmail ==''){
                jQuery("#inputEmail").css("border", "1px solid red");
               
                return false;
            }
            else{
                jQuery("#inputEmail").css("border", "1px solid #C9C9C9");                                 
            }
            if (inputEmail){
                var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
                if(reg.test(inputEmail) == false){
                    jQuery("#inputEmail").css("border", "1px solid red");
                    jQuery("#inputEmail").focus();
                    return false;
                }
                else{
                    jQuery("#inputEmail").css("border", "1px solid #C9C9C9");                                 
                }
            }
            ajaxType = "GET";
            urlpath = "<?php echo $path_url; ?>emailchecking";
            storedata = {'inputEmail':inputEmail}  ;
            ajaxfunc(urlpath,storedata,errorhandler,emailVarification);
            
        });   

        function emailVarification(data) {    
            if(data.message == true){
        		$(".user-message").show();
	    		$(".message-text").text("Email already taken. Please provide other email");
           		$(".save-button").attr('disabled',true);
            	jQuery("#inputEmail").css("border", "1px solid red");
            }
            else{
                jQuery("#inputEmail").css("border", "1px solid #C9C9C9");                                 
            	$(".user-message").hide();
	    	 	$(".save-button").attr('disabled',false); 
            }
        }
 	});
</script>
<script type="text/javascript">
	var app = angular.module('invantage', []);
</script>
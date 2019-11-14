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
	  				<h4>Add New Section</h4>
  				</div>
			</div>
			<div class="widget-body">
				<div class="col-lg-12">
					<div class="form-container">
		          		<?php $attributes = array('name' => 'add_new_class', 'id' => 'parentForm','class'=>'form-container'); echo form_open('', $attributes);?>
			               	<input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial">
		                	<fieldset>
			                    <div class="field-container">
			                		<div class="upper-row">
			                			<label><span class="icon-phone"></span> Section<span class="required">*</span></label>
			                		</div>
			                		<div class="field-row">
			                			<div class="left-column">
			                				<input type="text" id="section_name" name="section_name" placeholder="Enter the section name">
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
         	var inputStore = $("#inputStore").val();
         	var inputNewPassword = $("#inputNewPassword").val();
            var inputRetypeNewPassword = $("#inputRetypeNewPassword").val();
            
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
            if($("#serial").val() == ' '){
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
         	if(inputStore ==''){
                jQuery("#inputStore").css("border", "1px solid red");
                jQuery("#inputStore").focus();
                return false;
            }
            else{
                jQuery("#inputStore").css("border", "1px solid #C9C9C9");                                 
            }
            var checked=false;
			var elements = document.getElementsByName("userlist[]");
			for(var i=0; i < elements.length; i++){
				if(elements[i].checked) {
					checked = true;
					var txt = elements[i].value;
	            	
				}
			}
			if (!checked) {
				$("#user-list-error").show();
				return false;
			}
			else{
				$("#user-list-error").hide();
			}
            var reg = new RegExp(/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{6,20})$/);
            if($("#serial").val() == ' '){    
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
                
			}           	
           	
	      	var dataString = jQuery('#userForm').serializeArray();
	      	ajaxType = "POST";
	  		urlpath = "<?php echo $path_url; ?>users/saveUser";
	     	ajaxfunc(urlpath,dataString,userResponseFailure,loadUserResponse); 
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
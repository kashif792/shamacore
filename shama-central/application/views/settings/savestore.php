<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-lg-10 page-content col-xs-12 col-sm-10 col-md-10" id="page-content">
	<?php
		// require_footer 
		require APPPATH.'views/__layout/filterlayout.php';
	?>
	<!-- lower row -->
	<div class="row conent-area announcement" id="conent-area">
		<!-- first row -->
		<div class="row">
			<div class="col-lg-12">
				<!-- item list-->
				<!-- item -->
				<div class="col-lg-12 widget">
					<div class="row">
						<div class="row widget-header" id="widget-header">
						<div class="col-lg-12">
							<!-- widget title -->
				  			<div class="row">
				  				<div class="col-lg-12  widget-title">
					  				<h4>Save Store</h4>
				  				</div>
				  			</div>
						</div>
					</div>
						<div class="row widget-body">
							<div class="col-lg-12">
								<div>
									<div class="form-container">
							          	<?php $attributes = array('name' => 'storeForm', 'id' => 'storeForm','class'=>'form-container'); echo form_open('', $attributes);?>
						               	 	<input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial">
						                	<fieldset>
						                		<?php if(!$this->uri->segment(2)){ ?>
							                	<div class="field-container">
							                		<div class="upper-row">
							                			<label><span class="icon-sort-number-up"></span> Store Number <span class="required">*</span></label>
							                		</div>
							                		<div class="field-row">
							                			<div class="left-column">
							                				<input type="text" id="inputStoreNumber" name="inputStoreNumber" placeholder="Store Number" tabindex="1" value="">
							                			</div>
							                		</div>
							                	</div>
							                	<?php } ?>									                
							                	<div class="field-container">
							                		<div class="upper-row">
							                			<label><span class="icon-shop-1"></span> Store <span class="required">*</span></label>
							                		</div>
							                		<div class="field-row">
							                			<div class="left-column">
							                				<input type="text" id="inputStore" name="inputStore" placeholder="Store Name" tabindex="2" value="">
							                			</div>
							                		</div>
							                	</div>
							                	<div class="field-container">
							                		<div class="upper-row">
							                			<label><span class="icon-location"></span> Location <span class="required">*</span></label>
							                		</div>
							                		<div class="field-row">
							                			<div class="left-column">
							                				<input type="text" id="inputLocation" name="inputLocation" placeholder="Store Location" tabindex="3" value="">
							                			</div>
							                		</div>
							                	</div>
							                	
							                	<div class="field-container">
							                		<div class="field-row">
							                			<button type="submit" tabindex="4" class="btn btn-default save-button">Save</button>
							                			<a href="<?php echo $path_url; ?>settings#setting2" tabindex="5" title="cancel">Cancel</a>
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
	 	var editrow = "<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>";
		
		if(editrow != '')
		{
			loadEditContent()
		}
	    /*
	     * ---------------------------------------------------------
	     *   Save store
	     * ---------------------------------------------------------
	     */
         
        $("#storeForm").submit(function(e){
         	e.preventDefault();
            var inputStoreNumber = $("#inputStoreNumber").val();
            var inputStore = $("#inputStore").val();
            var inputLocation = $("#inputLocation").val();
            if(editrow == ''){
        		if(inputStoreNumber.lenth > 2 && inputStoreNumber.lenth < 100  ){
            		jQuery("#inputStoreNumber").css("border", "1px solid red");
                	return false;
	            }
	            else{
	                jQuery("#inputStoreNumber").css("border", "1px solid #C9C9C9");                                 
	            }
            }
          	
         	if(inputStore.lenth > 2 && inputStore.lenth < 100){
                jQuery("#inputStore").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputStore").css("border", "1px solid #C9C9C9");                                 
            }

            if(inputLocation.lenth > 2 && inputLocation.lenth < 100){
                jQuery("#inputLocation").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputLocation").css("border", "1px solid #C9C9C9");                                 
            }
           	
	      	var dataString = jQuery('#storeForm').serializeArray();
	      	ajaxType = "POST";
	  		urlpath = "<?php echo $path_url; ?>api/saveStore/format/json";
	     	ajaxfunc(urlpath,dataString,storeResponseFailure,loadStoreResponse); 
	  		return false;
        });
	
		function storeResponseFailure()
		{
			$(".user-message").show();
	    	$(".message-text").text("Store data not saved").fadeOut(10000);
		}

        function loadStoreResponse(response)
        {
        	if(response != null){
				saveStore();
			}
        }

	    function saveStore()
	    {
    		var dataString = jQuery('#storeForm').serializeArray();
	      	ajaxType = "POST";
	  		urlpath = "<?php echo $path_url; ?>storesave";
	     	ajaxfunc(urlpath,dataString,loadStoreDataFailureResponse,loadStoreDataResponse);
	    }
	    function loadStoreDataFailureResponse(){}

	    function loadStoreDataResponse(response)
	    {
	    	if(response.message == true)
	    	{
	    		window.location.href = "<?php echo $path_url;?>settings";
	    	}
	    }
     	/*
	     * ---------------------------------------------------------
	     *   Load edited store data
	     * ---------------------------------------------------------
	     */
	   
			function loadEditContent()
		{
			ajaxType = "GET";
  			urlpath = "<?php echo $path_url; ?>api/getStores/format/json";
     		var dataString = ({'storenum':editrow,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'});
     		ajaxfunc(urlpath,dataString,storeEditResponseFailure,loadStoreEditResponse); 
  		
		}

		function storeEditResponseFailure()
		{
			$(".user-message").show();
	    	$(".message-text").text("Store data not loaded").fadeOut(10000);
		}

		function loadStoreEditResponse(response)
		{
            $("#inputStoreNumber").val(response[0].storenum);
            $("#inputStore").val(response[0].name);
            $("#inputLocation").val(response[0].location);
      	}

 	});
</script>
<script type="text/javascript">
	var app = angular.module('invantage', []);
</script>
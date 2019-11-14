<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>
<?php if(count($roles_right) > 0){ ?>
<?php //if(($roles_right[0]->description == 'Create_Form') || ($roles_right[1]->description == 'Edit_Form')){ ?>
<div class="col-lg-10 page-content col-xs-12 col-sm-10 col-md-10" id="page-content">
	<?php
		// require_footer 
		require APPPATH.'views/__layout/filterlayout.php';
	?>
	<!-- lower row -->
	<div class="row conent-area form" id="conent-area">
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
					  				<h4>Save Form</h4>
				  				</div>
				  			</div>
						</div>
					</div>
						<div class="row widget-body">
							<div class="col-lg-12">
								<div>
									<div class="form-container">
							          	<?php $attributes = array('name' => 'documentForm', 'id' => 'documentForm','class'=>'form-container'); echo form_open_multipart('uploadForm', $attributes);?>
							               <input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="id" id="valueid">
						                	<fieldset>
							                	<div class="field-container">
							                		<div class="upper-row">
							                			<label><span class="icon-align-justify"></span> Title <span class="required">*</span></label>
							                		</div>
							                		<div class="field-row">
							                			<div class="left-column">
				              					  			<input type="text" id="inputDocName" tabindex="1" name="inputDocName" placeholder="Title" value="<?php if(isset($formSingle)){echo $formSingle[0]->title;}?>">
							                			</div>
							                		</div>
							                		<div class="lower-row">
							                			<span class="form-inner-message">Enter minimum 3 character length</span>
							                		</div>
							                	</div>
							                	<div class="field-container">
							                		<div class="upper-row">
							                			<label><span class="icon-doc-inv"></span> File <?php if(!$this->uri->segment(2)){ echo  '<span class="required">*</span>';}?></label>
							                		</div>
							                		<div class="field-row">
							                			<div class="left-column">
                            								<input type="file" id="inputFile" accept=".pdf,.doc,.docx,.xls,.xlsx" tabindex="2" name="inputFile" placeholder="File">
							                			</div>
							                		</div>
							                		<div class="lower-row">
							                			<span class="form-inner-message">Allowed files pdf,doc,xls</span>
							                		</div>
							                	</div>
							                	<div class="field-container">
							                		<div class="field-row">
							                			<button type="submit" class="btn btn-default save-button" tabindex="3">Save</button>
							                			<a href="<?php echo $path_url; ?>form" tabindex="4" title="cancel">Cancel</a>
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
	//}
    } else{ echo "<p class='access-denied'><span class='icon-warning'></span> Access denied</p>";}
          
?> 
<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	 	
	 	/*
	     * ---------------------------------------------------------
	     *   Save form
	     * ---------------------------------------------------------
	     */
   	 	$(".save-button").click(function(e){
   			e.preventDefault();
        	var inputDocName = $("#inputDocName").val();
        	var inputFile = $("#inputFile").val();
			var checkEdit = "<?php if($this->uri->segment(2)){ echo "edit";} ?>";       		
       		if(inputDocName.length == '' || inputDocName.length < 3){
	            jQuery("#inputDocName").css("border", "1px solid red");
	            return false;
	        }
	        else{
	            jQuery("#inputDocName").css("border", "1px solid #C9C9C9");                                 
	        }
	        if(checkEdit != 'edit' || checkEdit == ''){
	        	 if(inputFile.length == ''){
	            	jQuery("#inputFile").css("border", "1px solid red");
		            return false;
		        }
		        else{
		            jQuery("#inputFile").css("border", "1px solid #C9C9C9");                                 
		        }
		        if(validateFile(inputFile) == false){
		            jQuery("#inputFile").css("border", "1px solid red");
		            return false;
		        }
		        else{
		            jQuery("#inputFile").css("border", "1px solid #C9C9C9");                                 
		        }
	        }
	       
       		if(inputDocName.length > 3 )
       		{
       			$("#documentForm").submit();
       			$(".save-button").prop('disabled',false);
       		}
    	});
	});
</script>

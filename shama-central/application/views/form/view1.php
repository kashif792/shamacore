<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>
<style type="text/css">
	#table-body-phase-tow th:not(:first-child) select {
    	display: none;
	}
</style>
<div id="delete_dialog" class="modal fade">
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
            	<button type="button" id="save" class="btn btn-default" value="save">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<?php if(count($roles_right) > 0){ ?>
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
					  				<div class="col-lg-12 widget-title">
						  				<h4>Form</h4>
						  				<div class="action-element">
				  							<a href="<?php echo $path_url; ?>saveform" id="add-action">Add New</a>
				  						</div>
					  				</div>
					  			</div>
							</div>
						</div>
						<div class="row widget-body">
						<div class="col-lg-12">
							<div>
								<?php if(count($roles_right) > 0){ ?>
									<div class="col-lg-12 table-choice active-div-element">
									 	<div class="loader-container"></div>
									 	<table class="table-body" id="table-body-phase-tow" >
					                        <thead>
						                        <tr>
						                            <th>Form Title</th>
						                            <th>View</th>
						                            <th>Print</th>
						                            <th>PDF</th>
						                            <?php if(($roles_right[1]->description == 'Update_Form') || ($roles_right[2]->description == 'Delete_Form')){ ?> 
							                        <th>Options</th>
							                        <?php } ?>
						                        </tr>
						                    </thead>
						                    <tfoot>
						                        <tr>
						                            <th>Form Title</th>
						                            <th>View</th>
						                            <th>Print</th>
						                            <th>PDF</th>
						                            <?php if(($roles_right[1]->description == 'Update_Form') || ($roles_right[2]->description == 'Delete_Form')){ ?> 
							                        <th>Options</th>
							                        <?php } ?>
						                        </tr>
						                    </tfoot>
					                        <tbody id="reporttablebody-phase-two" class="report-body">
					                        	<?php $i = 1 ; if($forms){ ?>
							                    <?php foreach ($forms as $key => $value) {?>
							                    <tr <?php if($i%2 == 0){echo "class='green-bar'";} else{echo "class='yellow-bar'";} ?> data-view="<?php echo $value->file_name; ?>" id="tr_<?php echo $value->id ;?>">
							                        <td class="row-bar" data-view="<?php echo $value->file_name ;?>"><?php echo $value->title; ?></td>
							                        <td><a href="<?php echo $path_url; ?>upload/<?php echo $value->file_name; ?>" target="_blank"><span class="glyphicon  glyphicon-eye-open" aria-hidden="true"></span></a></td>
							                        <td><a href="<?php echo $path_url; ?>upload/<?php echo $value->file_name; ?>" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a></td>
							                        <td><a href="<?php echo $path_url; ?>upload/<?php echo $value->file_name; ?>" target="_blank"><span class="glyphicon glyphicon-file" aria-hidden="true"></span></a></td>
							                        <td>
							                            <?php if(($roles_right[1]->description == 'Update_Form') || ($roles_right[2]->description == 'Delete_Form')){ ?> 
							                            <a href="<?php echo $path_url; ?>saveform/<?php echo $value->slug ;?>" title="Edit">
							                            	<span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
						                            	</a>
							                            <a href="#" title="Delete" id="<?php echo $value->id ;?>" class="del">
							                            	<span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
						                            	</a>	
						                            </td>
							                            <?php } ?>
							                    </tr>
							                    <?php $i++;} ?>
							                    <?php }else{?>
							                	<tr><td colspan='5' class='no-record'>No form data found.</td></tr>
							                	<?php }?>
							                </tbody>
					                    </table>      
									</div>
									<?php 
						                } 
						                else {} 
						            ?>  
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
    } else{ echo "<p class='access-denied'><span class='icon-warning'></span> Access denied</p>";}
          
            ?>  
<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>
<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".table-choice").show();
		loaddatatable();
	  	/**
     	 * ---------------------------------------------------------
	     *   load table
	     * ---------------------------------------------------------
	     */
	    function loaddatatable()
	    {
	        $('#table-body-phase-tow').DataTable( {
	            responsive: true,
	             "order": [[ 0, "asc"  ]],
	            initComplete: function () {
	                this.api().columns().every( function () {
	                    var column = this;
	                    var select = $('<select><option value=""></option></select>')
	                        .appendTo( $(column.footer()).empty() )
	                        .on( 'change', function () {
	                            var val = $.fn.dataTable.util.escapeRegex(
	                                $(this).val()
	                            );
	     
	                            column
	                                .search( val ? '^'+val+'$' : '', true, false )
	                                .draw();
	                        });
	                    column.data().unique().sort().each( function ( d, j ) {
	                        select.append( '<option value="'+d+'">'+d+'</option>' )
	                    });
	                });
	            }
	        });
	    }
	});
</script>
<script>
    var urlsegment = '<?php if($this->uri->segment(2) AND $this->uri->segment(2) != "page"){ echo $this->uri->segment(2);} ?>';
    var dvalue ;
    if(urlsegment != ''){
        var classHide = $( "#documentForm" ).hasClass( "hide" );
        if(classHide == true){
            $("#documentForm").removeClass('hide');
            $("#documentForm").addClass('show');
        }else{
            $("#documentForm").removeClass('show');
            $("#documentForm").addClass('hide');
        }
    }
    $("#button_toggle").click(function(){
        var classHide = $( "#documentForm" ).hasClass( "hide" );
        if(classHide == true){
            $("#documentForm").removeClass('hide');
            $("#documentForm").addClass('show');
        }else{
            $("#documentForm").removeClass('show');
            $("#documentForm").addClass('hide');
        }
    });
     $(document).on('click','.row-bar',function(){
        dvalue =  $(this).attr('data-view');
        window.open('<?php echo $path_url; ?>upload/'+dvalue,'_blank');
    });

     /*
     * ---------------------------------------------------------
     *   Delete form
     * ---------------------------------------------------------
     */
    $(document).on('click','.del',function(){
        $("#delete_dialog").modal('show');
        dvalue =  $(this).attr('id');
     
    });

   /*
     * ---------------------------------------------------------
     *   Remove single form
     * ---------------------------------------------------------
     */
    $(document).on('click','#save',function(){
       	$("#delete_dialog").modal('hide');
       	$(".loader-container").show();
    	var dataString = ({'id':dvalue,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'}),
  		ajaxType = "GET";
  		urlpath = "<?php echo $path_url; ?>removeform";
     	ajaxfunc(urlpath,dataString,formFailureReponse,formSuccessResponse); 
	 	
	 	return false;
  	});

    function formFailureReponse()
    {
    	$(".loader-container").fadeOut();
    	$(".user-message").show();
		$(".message-text").text("Form has been not deleted").fadeOut(10000);
    }
  	function formSuccessResponse(response)
  	{
  		$(".user-message").show();
  		$("#tr_"+dvalue).remove();
  		if($("#reporttablebody-phase-two tr").length == 0){
  			var cont_str = "<tr><td colspan='5' class='no-record'>No form data found.</td></tr>"
  			$("#reporttablebody-phase-two").html(cont_str);
  		}
  		$(".loader-container").fadeOut();
  		$(".message-text").text("Form has been deleted");
  		
  	}	
       
</script>
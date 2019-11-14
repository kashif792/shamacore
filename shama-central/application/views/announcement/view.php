<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>
<?php if(count($roles_right) > 0){ ?>

<?php if(($roles_right[3]->description == 'View_Announcement') || ($roles_right[0]->description == 'View_Announcement')){ 
	?>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" id="save" class="btn btn-default " value="save">Yes</button>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 style="padding-left: 40px;">Announcement</h3>
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>
                                <th>To</th>
                            </td>
                            <td id="ann_to_text"></td>
                        </tr>
                        <tr>
                            <td>
                                <th>Start Time/Date</th>
                            </td>
                            <td id="ann_sdate_text"></td>
                        </tr>
                        <tr>
                            <td>
                                <th>End Time/Date</th>
                            </td>
                            <td id="ann_edate_text"></td>
                        </tr>
                        <tr style="border-bottom:1px solid #ddd !important;">
                            <td>
                                <th>Subject</th>
                            </td>
                            <td id="ann_heading_text"></td>
                        </tr>
                    </tbody>
                </table>
                
                <p id="ann_deacription_text" style="padding: 5px;"></p>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-10">
	<?php
		// require_footer 
		require APPPATH.'views/__layout/filterlayout.php';
	?>
	<!-- lower row -->
	<div class="col-lg-12 widget">
		<div class="widget-header custom-header" id="widget-header">
		<div class="widget-title">
			<h4>Announcement</h4>
			<?php if($roles_right[0]->description == 'Create_Announcement'){ ?>
			<div class="action-element">
			<a href="<?php echo $path_url; ?>saveannouncement" id="add-action">Add New</a>
		</div>
		<?php } ?>
		</div>
		</div>
		<div class="widget-body table-body">
			<div class="table-choice active-div-element">
			 	<table class="table-body" id="table-body-phase-tow" >
                    <thead>
                        <tr>
                            <th>Announcement</th>
                            <th>Start Time/Date</th>
                            <th>End Time/Date</th>
                            <?php if(($roles_right[3]->description == 'View_Announcement')|| ($roles_right[1]->description == 'Update_Form') || ($roles_right[2]->description == 'Delete_Form')){ ?> 
	                        <th>Options</th>
	                        <?php } ?>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Announcement</th>
                            <th>Start Time/Date</th>
                            <th>End Time/Date</th>
                            <?php if(($roles_right[3]->description == 'View_Announcement')|| ($roles_right[1]->description == 'Update_Form') || ($roles_right[2]->description == 'Delete_Form')){ ?> 
	                        <th>Options</th>
	                        <?php } ?>
                        </tr>
                    </tfoot>
                    <tbody id="reporttablebody-phase-two" class="report-body">
                    	<?php $i = 1 ; if(isset($announcement)){ ?>
							<?php foreach ($announcement as $key => $value) {?>
        		             	<tr <?php if($i%2 == 0){echo "class='green-bar '";} else{echo "class='yellow-bar'";} ?> id="tr_<?php echo $value->id ;?>" data-view="<?php echo $value->id ;?>">
		                        	<td class="row-bar" data-view="<?php echo $value->id ;?>"><?php echo substr($value->title , 0,40)."";  ?></td>
		                        	<td class="row-bar" data-view="<?php echo $value->id ;?>"><?php echo date("D" , strtotime($value->sdate))." ".date('h:i a', strtotime($value->sdate." ".$value->stime))." ".date('M d, Y', strtotime(str_replace('/', '-', $value->sdate))) ; ?></td>
		                        	<td class="row-bar" data-view="<?php echo $value->id ;?>"><?php echo date("D" , strtotime($value->edate))." ".date('h:i a', strtotime($value->edate." ".$value->etime))." ".date('M d, Y', strtotime(str_replace('/', '-', $value->edate))) ; ?></td>
			                        
		                        	<?php if($roles_right[3]->description == 'View_Announcement' || $roles_right[3]->description == 'View_Announcement'){ ?>
			                        <td>
			                            <a id="<?php echo $value->id ;?>" href="#" title="View" class='view'>
	                            			<span class="icon-eye" aria-hidden="true"></span>
			                            </a>
			                            <?php } ?>
			                            <?php if($roles_right[1]->description == 'Update_Announcement'){ ?>
			                            <a id="<?php echo $value->id ;?>" href="<?php echo $path_url; ?>saveannoucement/<?php echo $value->id ;?>" title="Edit" class='edit'>
			                            	<span class="icon-pencil" aria-hidden="true"></span>
			                            </a>
			                            <?php  } ?>
			                            <?php if($roles_right[2]->description == 'Delete_Announcement'){ ?>
			                            <a href="#" title="Delete" id="<?php echo $value->id ;?>" class="del">
			                            	<span class="icon-cancel " aria-hidden="true"></span>
			                            </a>
			                            </td>
			                            <?php } ?>
			                        
			                    </tr>
	                    	<?php $i++;} ?>
	                    	<?php }  ?>
                    </tbody>
                </table>      
			</div>
		</div>
	</div>
</div>
<?php 
    }}else{ 
    	echo "<p class='access-denied'><span class='icon-warning'></span> Access denied</p>";
	}      
?>
<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>
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

	 	/*
	     * ---------------------------------------------------------
	     *   View single announcement
	     * ---------------------------------------------------------
	     */
	    $(document).on('click','.view',function(){
	        dvalue =  $(this).attr('id');
	        var dataString = "id="+dvalue;
	        $("#myModal").modal('show');
	         $("#page-loader").css('display','block');
	         $.ajax({
	            type: "get",
	            dataType: "json",
	            url: "<?php echo $path_url; ?>announcements/singleAnnoucement",
	            data: ({'id':dvalue,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'}),
	            beforeSend: function(x) {
	                if(x && x.overrideMimeType) {
	                    x.overrideMimeType("application/json;charset=UTF-8");   
	                }
	            },
	            success: function(data) {    
	                if (data.message === true){
	                    $("#ann_to_text").html(data.to);
	                    $("#ann_heading_text").html(data.title);
	                    $("#ann_deacription_text").html(data.description);
	                    $("#ann_expiry_text").html(data.expiry_date);
	                    $("#ann_sdate_text").html(data.sdate);
	                    $("#ann_edate_text").html(data.edate);
	                    var status =(data.status == 'y' ? "Yes" : "No") ;
	                    $("#ann_status_text").html(status);
	                      $("#page-loader").fadeOut("slow");
	                } 
	            } 
	        });
	    });
    
	    $(document).on('click','.row-bar',function(){
	        dvalue =  $(this).attr('data-view');
			loadSingleAnnouncement();
	    });

	    function loadSingleAnnouncement()
	    {
	    	$("#myModal").modal('show');
    	 	ajaxType = "GET";
	        urlpath = "<?php echo $path_url; ?>announcements/singleAnnoucement";
	        announcementdata = {'id':dvalue};
	        ajaxfunc(urlpath,announcementdata,errorhandler,viewSingleAnnouncementResponse);
	    }

	    function viewSingleAnnouncementResponse(data)
	    {
	    	 if (data.message === true){
                $("#ann_to_text").html(data.to);
                $("#ann_heading_text").html(data.title);
                $("#ann_deacription_text").html(data.description);
                $("#ann_expiry_text").html(data.expiry_date);
                $("#ann_sdate_text").html(data.sdate);
                $("#ann_edate_text").html(data.edate);
                var status =(data.status == 'y' ? "Yes" : "No") ;
                $("#ann_status_text").html(status);
            } 
	    }
	    var editrow = "<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>";
		
		if(editrow != '')
		{
			loadNotificationContent()
		}

		function loadNotificationContent()
		{
			$("#myModal").modal('show');    
	        ajaxType = "GET";
	        urlpath = "<?php echo $path_url; ?>announcements/singleAnnoucement";
	        moveinvetorydata = {'id':editrow};
	        ajaxfunc(urlpath,moveinvetorydata,errorhandler,viewSingleAnnouncementResponse);
		}

		/*
	     * ---------------------------------------------------------
	     *   Delete announcement
	     * ---------------------------------------------------------
	     */
	    $(document).on('click','.del',function(){
	        $("#delete_dialog").modal('show');
	        dvalue =  $(this).attr('id');
	    });
	    
	    /*
	     * ---------------------------------------------------------
	     *   Remove single announcement
	     * ---------------------------------------------------------
	     */
	    $(document).on('click','#save',function(){
	       	$("#delete_dialog").modal('hide');
	       	var dataString = "id="+dvalue;
	       	$(".loader-container").show();
	       	ajaxType = "GET";
	        urlpath = "<?php echo $path_url; ?>announcements/removeAnnoucement";
	        ajaxfunc(urlpath,dataString,annremovelfailure,announcementremove);
	 	});

    	function annremovelfailure()
	    {
	    	message("Announcement not deleted","show")
	    }

	 	function announcementremove(respose){
	 		$(".user-message").show();
	  		$("#tr_"+dvalue).remove();
	  		if($("#reporttablebody-phase-two tr").length == 0){
	  			var cont_str = "<tr><td colspan='5' class='no-record'>No form data found.</td></tr>"
	  			$("#reporttablebody-phase-two").html(cont_str);
	  		}
	  		message("Announcement has been deleted","show")
	 	}
	});
</script>
<script type="text/javascript">
	var app = angular.module('betsysinsight', []);
</script>
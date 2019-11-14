<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>
<?php if(count($roles_right) > 0){ ?>
 <?php if(($roles_right[0]->description == 'Create_Announcement') || ($roles_right[1]->description == 'Create_Announcement')){ ?>
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
	<div class="col-lg-12 widget">
		<div class="widget-header custom-header" id="widget-header">
				<div class="widget-title">
  				<h4>Save Announcement</h4>
				</div>
		</div>
		<div class="widget-body">
			<div class="form-container">
	          	<?php $attributes = array('name' => 'annoucementForm', 'id' => 'annoucementForm','class'=>'form-container'); echo form_open('', $attributes);?>
	                <input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="id" id="serial">
	             	<input type="hidden" value="" name="group" id="group">
	                <fieldset>
	                	<div class="field-container">
	                		<div class="upper-row">
	                			<label><span class="icon-align-justify"></span> Title <span class="required">*</span></label>
	                		</div>
	                		<div class="field-row">
	                			<div class="left-column">
	                				<input type="text" tabindex="1" id="inputTitle" value="<?php if(isset($annoucement_single)){echo $annoucement_single[0]->title;}?>" name="inputTitle" placeholder="Title">								                			
	                			</div>
	                		</div>
	                	</div>
	                	<div class="field-container">
	                		<div class="upper-row">
	                			<label><span class="icon-align-justify"></span> Description</label>
	                		</div>
	                		<div class="field-row">
	                			<div class="left-column">
	                				<textarea tabindex="2" rows="5" name="inputDescription" id="inputDescription"><?php if(isset($annoucement_single)){echo $annoucement_single[0]->description;}?></textarea>
	                			</div>
	                		</div>
	                	</div>
	                	
	                	<div class="field-container">
	                		<div class="upper-row">
	                			<label><span class="icon-calendar-7"></span> Date/Time <span class="required">*</span></label>
	                		</div>
	                		<div class="field-row">
	                			<div class="left-column">
						       		<input tabindex="3" type="text" id="stimepicker" class="form-control" name="stimepicker" placeholder="Start Time" value="<?php if(isset($annoucement_single)){echo $annoucement_single[0]->stime;}?>">
	                			</div>
	                		</div>
	                	</div>
	                	
	                	<div class="field-container">
                			<div class="upper-row">
	                			<label><span class="icon-paper-plane-1"></span> Send To <span class="required">*</span></label>
	                		</div>
                			<div class="field-row">
                				<div class="left-column">
        			 				<?php  if(isset($roles)){ ?>

	                                    <?php foreach ($roles as $key => $value) {?>
	                                    <?php if($value->id != 1 && $value->id != 7){ ?>
	                                        <input <?php if(in_array($value->id,$announcement_user)){echo "checked='checked'";} ?> type="checkbox" name="userlist[]" class="announcement-reciever" value="<?php echo $value->id; ?>"  ><?php echo $value->type; ?>
	                                    <?php } ?>
	                                    <?php } ?>
                                    <?php } else{ echo "No group found.";} ?>
                				</div>
                			</div>
                			<div  id="user-list-error">Check at least one</div>
	                	</div>
	                	<div class="field-container">
	                		<div class="field-row">
	                			<button tabindex="4" type="submit" class="btn btn-default save-button">Save</button>
	                			<a tabindex="5" href="<?php echo $path_url; ?>announcement" tabindex="12" title="cancel">Cancel</a>
	                		</div>
	                	</div>
	                </fieldset>
	            <?php echo form_close();?>
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

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
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
		
		
 	/*
     * ---------------------------------------------------------
     *   Save announcement
     * ---------------------------------------------------------
     */
    $("#annoucementForm").submit(function(e){
        e.preventDefault();
        var inputTitle = $("#inputTitle").val();
        var inputDescription = $("#inputDescription").val();
        var stimepicker = $("#stimepicker").val();
        var reg = new RegExp(/^[A-Za-z0-9 ]{3,50}$/);
     	
        if(inputTitle.length == '' || inputTitle.length < 3){
            jQuery("#inputTitle").css("border", "1px solid red");
            return false;
        }
        else{
            jQuery("#inputTitle").css("border", "1px solid #C9C9C9");                                 
        }
       	 
        if(stimepicker.length == ''){
            jQuery("#stimepicker").css("border", "1px solid red");
            return false;
        }
        else{
            jQuery("#stimepicker").css("border", "1px solid #C9C9C9");                                 
        }
       
        var splitdate = stimepicker.split(' - ');
       	var bdate = new Date(splitdate[0])
       	var edate = new Date(splitdate[1])
       	var startdate = bdate.getMonth() + 1 + "/"+bdate.getDate() + "/" + bdate.getFullYear();
       	var starttime = bdate.getHours() + ":"+bdate.getMinutes() + ":" + bdate.getSeconds();
       	var enddate = edate.getMonth() + 1 + "/"+edate.getDate() + "/" + edate.getFullYear();
       	var endtime = edate.getHours()  + ":"+edate.getMinutes() + ":" + edate.getSeconds();
       	
 	 	var group = '';
		var checked=false;
		var elements = document.getElementsByName("userlist[]");
		for(var i=0; i < elements.length; i++){
			if(elements[i].checked) {
				checked = true;
				var txt = elements[i].value;
            	group += txt+',';
			}
		}
		if (!checked) {
			$("#user-list-error").show();
		}
		else{
			$("#user-list-error").hide();
		}
	 	dataString = ({id:$("#serial").val(),"title":inputTitle,"description":inputDescription,"startdate":startdate,"enddate":enddate,"starttime":starttime,"endtime":endtime,"group":group,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'});
      	ajaxType = "POST";
  		urlpath = "<?php echo $path_url; ?>announcements/saveAnnoucement";
  		
     	ajaxfunc(urlpath,dataString,announcementResponseFailure,loadAnnouncementResponse); 
  		return false;
    });
	
	function announcementResponseFailure()
	{

	}

	function loadAnnouncementResponse(response)
	{
		if(response.message == true){
			window.location.href = "<?php echo $path_url;?>announcement";
		}
	}

	});
</script>

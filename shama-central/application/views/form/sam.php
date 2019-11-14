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
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<script type="text/javascript" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<?php if(count($roles_right) > 0){ ?>
<div class="col-sm-10 " id="page-content">
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
						  				<?php if(($roles_right[0]->description == 'Create_Form')){ ?>
						  				<div class="action-element">
				  							<a href="<?php echo $path_url; ?>saveform" id="add-action">Add New</a>
				  						</div>
				  						<?php } ?>
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
							                        <?php if(($roles_right[1]->description == 'Update_Form') || ($roles_right[2]->description == 'Delete_Form')){ ?> 
							                        <td>
							                            
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


<!-- Sam View start -->
<div class="col-sm-10">
  <div class="main-content">
		
		<div class="row">
	               <div class="col-md-12 col-sm-12 clearfix" style="text-align:center;">
		<h2 style="font-weight:200; margin:0px;">LMS</h2>
    </div>
	<!-- Raw Links -->
	<div class="col-md-12 col-sm-12 clearfix ">
		
        <ul class="list-inline links-list pull-left">
        <!-- Language Selector -->
        	<div id="session_static">			
	           <li>
	           		<h4>
	           			<a href="#" style="color: #696969;"
	           				 
	           				onclick="get_session_changer()"
	           			>
	           				Running Session : 2016-2017	           			</a>
	           		</h4>
	           </li>
           </div>
        </ul>
        
        
		<ul class="list-inline links-list pull-right">

		<li class="dropdown language-selector">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                        	<i class="entypo-user"></i> admin                    </a>

								<ul class="dropdown-menu pull-left">
					<li>
						<a href="http://creativeitem.com/demo/ekattor/index.php?admin/manage_profile">
                        	<i class="entypo-info"></i>
							<span>Edit Profile</span>
						</a>
					</li>
					<li>
						<a href="http://creativeitem.com/demo/ekattor/index.php?admin/manage_profile">
                        	<i class="entypo-key"></i>
							<span>Change Password</span>
						</a>
					</li>
				</ul>
											</li>
			
			<li>
				<a href="http://creativeitem.com/demo/ekattor/index.php?login/logout">
					Log Out <i class="entypo-logout right"></i>
				</a>
			</li>
		</ul>
	</div>
	
</div>



<hr style="margin-top:0px;" />

<script type="text/javascript">
	function get_session_changer()
	{
		$.ajax({
            url: 'http://creativeitem.com/demo/ekattor/index.php?admin/get_session_changer/',
            success: function(response)
            {
                jQuery('#session_static').html(response);
            }
        });
	}
</script>
           <h3 style="">
           	<i class="entypo-right-circled"></i> 
				Student Information - Class : One           </h3>

			<hr />
<a href="http://creativeitem.com/demo/ekattor/index.php?admin/student_add"
    class="btn btn-primary pull-right">
        <i class="entypo-plus-circled"></i>
        Add New Student    </a> 
<br>

<div class="row">
    
        
        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs">All Students</span>
                </a>
            </li>
                    <li>
                <a href="#1" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs">Section A ( Julian West )</span>
                </a>
            </li>
                    <li>
                <a href="#7" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs">Section B ( Cairo Hebert )</span>
                </a>
            </li>
                    <li>
                <a href="#8" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs">Section C ( Martina Wall )</span>
                </a>
            </li>
                        </ul>
        
        <div class="tab-content">
            <div class="tab-pane active" id="home">
                
                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div>Roll</div></th>
                            <th width="80"><div>Photo</div></th>
                            <th><div>Name</div></th>
                            <th class="span3"><div>Address</div></th>
                            <th><div>Email</div></th>
                            <th><div>Options</div></th>
                        </tr>
                    </thead>
                    <tbody>
                                                <tr>
                            <td>1</td>
                            <td><img src="http://creativeitem.com/demo/ekattor/uploads/student_image/2.jpg" class="img-circle" width="30" /></td>
                            <td>
                                Geraldine Hall                          </td>
                            <td>
                                24, Reprehenderit veniam,  error illum magni                            </td>
                            <td>
                                luhygo@gmail.com                            </td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- STUDENT MARKSHEET LINK  -->
                                        <li>
                                            <a href="http://creativeitem.com/demo/ekattor/index.php?admin/student_marksheet/2">
                                                <i class="entypo-chart-bar"></i>
                                                    Mark Sheet                                                </a>
                                        </li>

                                        
                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php?modal/popup/modal_student_profile/2');">
                                                <i class="entypo-user"></i>
                                                    Profile                                                </a>
                                        </li>
                                        
                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php?modal/popup/modal_student_edit/2');">
                                                <i class="entypo-pencil"></i>
                                                    Edit                                                </a>
                                        </li>
                                    </ul>
                                </div>
                                
                            </td>
                        </tr>
                                               
                                            </tbody>
                </table>
                    
            </div>
                    <div class="tab-pane" id="1">
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="80"><div>Roll</div></th>
                            <th width="80"><div>Photo</div></th>
                            <th><div>Name</div></th>
                            <th class="span3"><div>Address</div></th>
                            <th><div>Email</div></th>
                            <th><div>Options</div></th>
                        </tr>
                    </thead>
                    <tbody>
                                                <tr>
                            <td>2</td>
                            <td><img src="http://creativeitem.com/demo/ekattor/uploads/student_image/7.jpg" class="img-circle" width="30" /></td>
                            <td>
                                Ivy Washington                            </td>
                            <td>
                                27, Excepteur et,  voluptate duis                            </td>
                            <td>
                                nebub@yahoo.com                            </td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php?modal/popup/modal_student_profile/7');">
                                                <i class="entypo-user"></i>
                                                    Profile                                                </a>
                                        </li>
                                        
                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php?modal/popup/modal_student_edit/7');">
                                                <i class="entypo-pencil"></i>
                                                    Edit                                                </a>
                                        </li>
                                    </ul>
                                </div>
                                
                            </td>
                        </tr>
                                                <tr>
                            <td>3</td>
                            <td><img src="http://creativeitem.com/demo/ekattor/uploads/student_image/9.jpg" class="img-circle" width="30" /></td>
                            <td>
                                Evelyn Mcbride                            </td>
                            <td>
                                Et assumenda ut minima molestias natus deleniti harum omnis laboris laboriosam assumenda                            </td>
                            <td>
                                lahizyzo@hotmail.com                            </td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php?modal/popup/modal_student_profile/9');">
                                                <i class="entypo-user"></i>
                                                    Profile                                                </a>
                                        </li>
                                        
                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php?modal/popup/modal_student_edit/9');">
                                                <i class="entypo-pencil"></i>
                                                    Edit                                                </a>
                                        </li>
                                    </ul>
                                </div>
                                
                            </td>
                        </tr>
                                            </tbody>
                </table>
                    
            </div>
                    <div class="tab-pane" id="7">
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="80"><div>Roll</div></th>
                            <th width="80"><div>Photo</div></th>
                            <th><div>Name</div></th>
                            <th class="span3"><div>Address</div></th>
                            <th><div>Email</div></th>
                            <th><div>Options</div></th>
                        </tr>
                    </thead>
                    <tbody>
                                                <tr>
                            <td>1</td>
                            <td><img src="http://creativeitem.com/demo/ekattor/uploads/student_image/2.jpg" class="img-circle" width="30" /></td>
                            <td>
                                Geraldine Hall                            </td>
                            <td>
                                24, Reprehenderit veniam,  error illum magni                            </td>
                            <td>
                                luhygo@gmail.com                            </td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php?modal/popup/modal_student_profile/2');">
                                                <i class="entypo-user"></i>
                                                    Profile                                                </a>
                                        </li>
                                        
                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php?modal/popup/modal_student_edit/2');">
                                                <i class="entypo-pencil"></i>
                                                    Edit                                                </a>
                                        </li>
                                    </ul>
                                </div>
                                
                            </td>
                        </tr>
                                            </tbody>
                </table>
                    
            </div>
                    <div class="tab-pane" id="8">
                
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="80"><div>Roll</div></th>
                            <th width="80"><div>Photo</div></th>
                            <th><div>Name</div></th>
                            <th class="span3"><div>Address</div></th>
                            <th><div>Email</div></th>
                            <th><div>Options</div></th>
                        </tr>
                    </thead>
                    <tbody>
                                                <tr>
                            <td>4</td>
                            <td><img src="http://creativeitem.com/demo/ekattor/uploads/student_image/8.jpg" class="img-circle" width="30" /></td>
                            <td>
                                Rudyard Maddox                            </td>
                            <td>
                                Eveniet nihil iusto sed est ea perferendis sit ad vel duis quis dolores                            </td>
                            <td>
                                wejat@gmail.com                            </td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php?modal/popup/modal_student_profile/8');">
                                                <i class="entypo-user"></i>
                                                    Profile                                                </a>
                                        </li>
                                        
                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php?modal/popup/modal_student_edit/8');">
                                                <i class="entypo-pencil"></i>
                                                    Edit                                                </a>
                                        </li>
                                    </ul>
                                </div>
                                
                            </td>
                        </tr>
                                            </tbody>
                </table>
                    
            </div>
                
        </div>
        
        
    
</div>

</div>

<!-- Sam view End -->

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

<script type="text/javascript">
	var app = angular.module('invantage', []);
</script>
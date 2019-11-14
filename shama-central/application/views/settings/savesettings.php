<?php 

// require_header 

require APPPATH.'views/__layout/header.php';



// require_top_navigation 

require APPPATH.'views/__layout/topbar.php';



// require_left_navigation 

require APPPATH.'views/__layout/leftnavigation.php';

?>

<div id="myUserModal" class="modal fade">

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

                <button type="button" id="UserDelete" class="btn btn-default " value="save">Yes</button>

            </div>

        </div>

    </div>

</div>

<div id="myModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-body">

                <h3 style="padding-left: 40px;">User</h3>

                <table class="table table-striped table-hover">

                    <tbody>

                        <tr>

                            <td>

                                <th>Name</th>

                            </td>

                            <td id="user_name"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Email</th>

                            </td>

                            <td id="user_email"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Account Created Date</th>

                            </td>

                            <td id="user_acct_date"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Account Status</th>

                            </td>

                            <td id="user_acct_status"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Role</th>

                            </td>

                            <td id="user_role"></td>

                        </tr>

                    </tbody>

                </table>

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
		<div class="widget-header" id="widget-header">
			<!-- widget title -->
  				<div class="widget-title">
	  				<h4>Settings</h4>
  				</div>
			</div>
			<div class="widget-body">
				<div class="setting-container">
					<div id="setting">          
				  		<ul class="resp-tabs-list vert">
			      			<?php if(count($roles_right) > 0){ ?>
					      	<li>Students</li>
					      	<li class="">Teacher</li>
					      	<li class="">Parents</li>
					      	<li class="">Add Class</li>
					      	<?php } ?>
					  	</ul> 
			  			<div class="resp-tabs-container vert">                                                        
			      			<?php if(count($roles_right) > 0){ ?>
			      			<div id="user-managment-tab">
			      				<div class="action-element">
		  							 <a href="<?php echo $path_url; ?>newuser" id="add-action">Add Student</a>
		  						</div>
			      				<table class="table-body" id="table-body-phase-tow" >
			                        <thead>
				                        <tr>
				                            <th></th>
				                            <th>Roll number</th>
				                            <th>First Name</th>
				                            <th>Last Name</th>
		                                    <th>Guardian</th>
		                                    <th>Class</th>
		                                    <th>Options</th>
				                        </tr>
				                    </thead>
				                    <tfoot>
				                        <tr>
			                             	<th></th>
				                            <th>Roll number</th>
				                            <th>First Name</th>
				                            <th>Last Name</th>
		                                    <th>Guardian</th>
		                                    <th>Class</th>
		                                    <th>Options</th>
				                        </tr>
				                    </tfoot>
			                        <tbody id="reporttablebody-phase-two" class="report-body">
			                        	<?php $i = 1 ; if(isset($users)){ ?>
			                                <?php foreach ($users as $key => $value) {?>
			                                <tr <?php if($i%2 == 0){echo "class='green-bar row-update'";} else{echo "class='yellow-bar row-update'";} ?> id="tr_<?php echo $value->row_slug ;?>" data-view="<?php echo $this->encrypt->encode($value->row_slug) ;?>">
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><img class="img-circle" src="http://creativeitem.com/demo/ekattor/uploads/student_image/8.jpg" width="50"/></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo ucwords($value->last_name); ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->email; ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->roletype; ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->roletype; ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->roletype; ?></td>
			                                    <td>
			                                        <a href="<?php echo $path_url; ?>newuser/<?php echo $value->row_slug ;?>" id="<?php echo $this->encrypt->encode($value->row_slug) ;?>" class='edit' title="Edit">
			                                            <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
			                                        </a>
			                                        <a href="#" title="Delete" id="<?php echo $this->encrypt->encode($value->row_slug) ;?>" class="del">
			                                            <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
			                                        </a>
			                                    </td>
			                                </tr>
			                                <?php $i++;} ?>
			                                <?php } else{ echo "<p id='novaluefound'>No user found.</p>";} ?>

					                </tbody>

			                    </table>

			      			</div>

			      			<?php } ?>

		      				<?php if(count($roles_right) > 0){ ?>

			      			<div id="store-managment-tab">

			      				<div class="action-element">

		  							<a href="<?php echo $path_url; ?>saveTeacher" id="add-action">Add Teacher</a>

		  						</div>

			      						<table class="table-body" id="table-body-phase-tow" >
			                        <thead>
				                        <tr>
				                            <th></th>
				                            <th>Roll number</th>
				                            <th>First Name</th>
				                            <th>Last Name</th>
		                                    <th>Guardian</th>
		                                    <th>Class</th>
		                                    <th>Options</th>
				                        </tr>
				                    </thead>
				                    <tfoot>
				                        <tr>
			                             	<th></th>
				                            <th>Roll number</th>
				                            <th>First Name</th>
				                            <th>Last Name</th>
		                                    <th>Guardian</th>
		                                    <th>Class</th>
		                                    <th>Options</th>
				                        </tr>
				                    </tfoot>
			                        <tbody id="reporttablebody-phase-two" class="report-body">
			                        	<?php $i = 1 ; if(isset($users)){ ?>
			                                <?php foreach ($users as $key => $value) {?>
			                                <tr <?php if($i%2 == 0){echo "class='green-bar row-update'";} else{echo "class='yellow-bar row-update'";} ?> id="tr_<?php echo $value->row_slug ;?>" data-view="<?php echo $this->encrypt->encode($value->row_slug) ;?>">
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><img class="img-circle" src="http://creativeitem.com/demo/ekattor/uploads/student_image/8.jpg" width="50"/></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo ucwords($value->last_name); ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->email; ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->roletype; ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->roletype; ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->roletype; ?></td>
			                                    <td>
			                                        <a href="<?php echo $path_url; ?>newuser/<?php echo $value->row_slug ;?>" id="<?php echo $this->encrypt->encode($value->row_slug) ;?>" class='edit' title="Edit">
			                                            <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
			                                        </a>
			                                        <a href="#" title="Delete" id="<?php echo $this->encrypt->encode($value->row_slug) ;?>" class="del">
			                                            <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
			                                        </a>
			                                    </td>
			                                </tr>
			                                <?php $i++;} ?>
			                                <?php } else{ echo "<p id='novaluefound'>No user found.</p>";} ?>

					                </tbody>

			                    </table>
			      			</div>

			      			<div id="store-managment-tab">

			      				<div class="action-element">

		  							<a href="<?php echo $path_url; ?>saveParent" id="add-action">Add Parents</a>
		  							<a href="<?php echo $path_url; ?>saveClass" id="add-action">Add class</a>

		  						</div>

			      				<table class="table-body" id="store-table" >

			                        <thead>

				                        <tr>

				                            <th>Store Number</th>

				                            <th>Store</th>

				                            <th>Location</th>

		                                    <th>Options</th>

				                        </tr>

				                    </thead>

				                    <tfoot>

				                        <tr>

				                        	<th>Store Number</th>

				                            <th>Store</th>

				                            <th>Location</th>

		                                    <th>Options</th>

				                        </tr>

				                    </tfoot>

			                        <tbody id="store-list" class="report-body">

	                        	 	</tbody>

			                    </table>

			      			</div>

			      			<?php } ?>

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

	var dvalue ;

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

<script src="<?php echo $path_url; ?>js/jquery.easyResponsiveTabs.js"></script>



<script type="text/javascript">

	$(document).ready(function(){

		$('#setting').easyResponsiveTabs({ tabidentify: 'vert' });



    	getStoreList();

	    /**

	     * ---------------------------------------------------------

	     *   Store list

	     * ---------------------------------------------------------

	     */

	    function getStoreList () {

    	 	var dataString = "";

	      	ajaxType = "GET";

	      	var dataString = ({"storenum":"all"});

	  		urlpath = "<?php echo $path_url; ?>api/getStores/format/json";

	     	ajaxfunc(urlpath,dataString,errorhandler,getStoreListReponse); 

	  	}



	  	function getStoreListReponse (response) {

	   		dataLength = response.length -1;

	   		var cont_str = '';

	   		$("#store-list").html();

	   		for (var i = 0;  i <= dataLength ; i++) {

	   			var rowclass = "odd";

	   			if(i%2 == 0){

	   				rowclass = "even";

	   			}

	   			cont_str += "<tr class='"+rowclass+"'>";

	   			cont_str += "<td>"+response[i].storenum+"</td>"

	   			cont_str += "<td>"+response[i].name+"</td>"

	   			cont_str += "<td>"+response[i].location+"</td>"

	   			cont_str += "<td>"

	   			cont_str += '<a href="<?php echo $path_url; ?>savestore/'+response[i].storenum+'" class="edit" title="Edit">'

            	cont_str +=	'<span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>'

            	cont_str +=	'</a>'

	   			cont_str += '</td>'

	   			cont_str += "</tr>";

            }

            $("#store-list").html(cont_str);

            loadstoretable();

	  	}

	  	 function loadstoretable()

	    {

	        $('#store-table').DataTable( {

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

      	$(document).on('click','.row-bar-user',function(){

          

            var dataString = ({'id':dvalue,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'});

      		ajaxType = "GET";

            urlpath = "<?php echo $path_url; ?>users/singleUser";

            ajaxfunc(urlpath,dataString,loadUserReponseError,loadUserResponse);

        });



      	function loadUserReponseError()

      	{



      	}



        function loadUserResponse(response)

        {

        	if (data.message === true){

                $("#serial").val(dvalue);

                $("#inputUserName").val(data.name);

                var status = (data.status == 'a' ? 'a' : 'l');

                if(status == 'a'){

                    $("#optionsRadios1").prop('checked',true);

                }

                else{  

                    $("#optionsRadios2").prop('checked',true); 

                }

                $("#udestinationFields").html("");

                var cont_str = '';

                var counter = 1;

                if(data.userRoleId != null){  

                     $.each(data.userRoleId,function(i,key){  

                        cont_str +='<div value="'+data.userRoleId[counter]+'" class = "fc-field ui-sortable-handle " tabindex="1">'+data.role[counter]+'</div>';

                        counter++;

                     });    

                    $("#udestinationFields").append(cont_str);

                }

                $("#usourceFields").html("");

                cont_str = '';

                var counter = 1;

                if(data.unFoundRoleId != null){

                    $.each(data.unFoundRoleId,function(i,key){

                        cont_str +='<div value="'+data.unFoundRoleId[counter]+'" class="fc-field ui-sortable-handle" tabindex="1">'+data.unFoundName[counter]+'</div>';

                        counter++;

                    });

                }



            } 

        }

   

        $(document).on('click','.row-bar-user',function(){

        	dvalue =  $(this).attr('data-view');

       	 	var dataString = "id="+dvalue;

        	$("#myModal").modal('show');

      		ajaxType = "GET";

            urlpath = "<?php echo $path_url; ?>users/singleUser";

            var dataString = ({'id':dvalue,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'});

            ajaxfunc(urlpath,dataString,loadSingleUserReponseError,loadSingleUserResponse);

        });



        function loadSingleUserReponseError(){}



        function loadSingleUserResponse(response)

        {

	 		$("#user_name").text(response.name);

            $("#user_email").text(response.email);

            $("#user_acct_date").text(response.created);

            var status = (response.status == 'a' ? 'a' : 'l');

            if(status == 'a'){

                $("#user_acct_status").text('Active');

            }

            else{  

                $("#user_acct_status").text('In-Active'); 

            }

            var cont_str = '';

            var counter = 1 ;

            if(response.role != null){  

         		$.each(response.role,function(i,key){ 

         			if(counter != 1){

         				cont_str += response.role[counter]+'/';	

         			}

         			else{

         				cont_str += response.role[counter];

         			}

         			

                	counter++;

             	});

             	lastchar = cont_str.charAt(cont_str.length - 1);

				if(lastchar == "/"){

					cont_str = cont_str.substring(0, cont_str.length - 1);	

				} 

               

            	$("#user_role").text(cont_str);

            }



        }

         /*

         * ---------------------------------------------------------

         *   Delete User

         * ---------------------------------------------------------

         */

        $(document).on('click','.del',function(){

            $("#myUserModal").modal('show');

            dvalue =  $(this).attr('id');

         

            row_slug =   $(this).parent().parent().attr('id');

            

        });

        

        /*

         * ---------------------------------------------------------

         *   User notification on deleting user 

         * ---------------------------------------------------------

         */

        $(document).on('click','#UserDelete',function(){

            $("#myUserModal").modal('hide');

    		ajaxType = "GET";

            urlpath = "<?php echo $path_url; ?>users/removeUser";

            var dataString = ({'id':dvalue});

            ajaxfunc(urlpath,dataString,userDeleteFailureHandler,loadUserDeleteResponse);

    	});



        function userDeleteFailureHandler()

        {

 		 	$(".user-message").show();

	    	$(".message-text").text("User has been not deleted").fadeOut(10000);

        }



        function loadUserDeleteResponse(response)

        {

        	if (response.message === true){

                $("#"+row_slug).remove();

     		 	$(".user-message").show();

		    	$(".message-text").text("User has been deleted").fadeOut(10000);

         	} 

        }

        

	});

</script>




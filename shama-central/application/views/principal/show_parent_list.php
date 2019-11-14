<?php 

// require_header 

require APPPATH.'views/__layout/header.php';



// require_top_navigation 

require APPPATH.'views/__layout/topbar.php';



// require_left_navigation 

require APPPATH.'views/__layout/leftnavigation.php';

?>

<link href="<?php echo $path_url; ?>css/easy-responsive-tabs.css" rel="stylesheet">

<link rel="stylesheet" href="<?php echo $path_url; ?>css/intlTelInput.css">

<div id="myUserModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p>Are you sure you want to delete this parent?</p>

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
                <h3 style="padding-left: 40px;">Teacher</h3>
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>
                                <th>First Name</th>
                            </td>
                            <td id="user_name"></td>
                            <td>
                                <th>Last Name</th>
                            </td>
                            <td id="user_lastname"></td>
                        </tr>
                        <tr>
                            
                        </tr>
                        <tr>
                            <td>
                                <th>Gender</th>
                            </td>
                            <td id="teacher_gender"></td>
                            <td>
                                <th>NIC #</th>
                            </td>
                            <td id="teacher_Nic"></td>
                        </tr>
                        <tr>
                            
                        </tr>
                        <tr>
                            <td>
                                <th>Relegion</th>
                            </td>
                            <td id="user_role"></td>
                        </tr>
                         <tr>
                            <td>
                                <th>Email</th>
                            </td>
                            <td id="user_role"></td>
                        </tr>
                         <tr>
                            <td>
                                <th>Phone</th>
                            </td>
                            <td id="teacher_phone"></td>
                        </tr>
                        
                         <tr>
                            <td>
                                <th>Primary Home Address</th>
                            </td>
                            <td id="primry_home_address"></td>
                        </tr>
                         <tr>
                            <td>
                                <th>Secondary Home Address</th>
                            </td>
                            <td id="secondary_home_address"></td>
                        </tr>
 						<tr>
                            <td>
                                <th>Province</th>
                            </td>
                            <td id="teacher_province"></td>
                        </tr>
                         <tr>
                            <td>
                                <th>City</th>
                            </td>
                            <td id="teacher_city"></td>
                        </tr>
                         <tr>
                            <td>
                                <th>Zipcode</th>
                            </td>
                            <td id="teacher_zipcode"></td>
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
		<div class="panel-heading plheading" id="widget-header">
			<!-- widget title -->
  				<!-- <div class="widget-title"> -->
	  				<h4>Parents List</h4>
  				<!-- </div> -->
			</div>
			<div class="widget-body">
				<div class="setting-container">
					<div id="setting">          
				  		<ul class="resp-tabs-list vert">
			      			<?php if(count($roles_right) > 0){ ?>
					      	
					      	<li class="">Parent</li>
					      
					      
					      	<?php } ?>
					  	</ul> 
			  			<div class="resp-tabs-container vert">                                                        
			      			<?php //if(count($roles_right) > 0){ ?>
			      			<div id="user-managment-tab">
			      				<div class="action-element">
		  							<a href="<?php echo $path_url; ?>add_Parent" id="add-action">Add Parent</a>
		  						</div>
			      				<table class="table-body" id="table-body-phase-tow" >
			                        <thead>
				                        <tr>
				                            <th>First Name</th>
				                            <th>Last Name</th>
		                                    <th>Email</th>
		                                    <th>Options</th>
				                        </tr>
				                    </thead>
				                    <tfoot>
				                        <tr>
				                            <th>First Name</th>
				                            <th>Last Name</th>
		                                    <th>Email</th>
		                                    <th>Options</th>
				                        </tr>
				                    </tfoot>
		                        	<tbody id="reporttablebody-phase-two" class="report-body">
			                        	<?php $i = 1 ; if(isset($teacherlist)){ ?>
			                                <?php foreach ($teacherlist as $key => $value) {?>
			                                <tr <?php if($i%2 == 0){echo "class='green-bar row-update'";} else{echo "class='yellow-bar row-update'";} ?> id="tr_<?php echo $value->row_slug ;?>" data-view="<?php echo $this->encrypt->encode($value->row_slug) ;?>">
			                                    <td class="row-bar-user" data-view="<?php echo $value['teacher_id'] ;?>"><?php echo ucwords($value['teacher_firstname']); ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value['teacher_id'] ;?>"><?php echo ucwords($value['teacher_lastname']); ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value['teacher_id'] ;?>"><?php echo $value['email']; ?></td>
			                                    <td>
			                                        <a href="<?php echo $path_url; ?>add_Parent/<?php echo $value['teacher_id'] ;?>" id="<?php echo $this->encrypt->encode($value['id']) ;?>" class='edit' title="Edit">
			                                            <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
			                                        </a>
			                                        <a href="#" title="Delete" id="<?php echo $value['teacher_id'] ;?>" class="del">
			                                            <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
			                                        </a>
			                                    </td>
			                                </tr>
			                                <?php $i++;} ?>
			                                <?php } else{ echo "<p id='novaluefound'>No parent found.</p>";} ?>

					                </tbody>

			                    </table>

			      			</div>

			      			<?php //} ?>

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

	   			cont_str += '<a href="<?php echo $path_url; ?>add_teacher/'+response[i].storenum+'" class="edit" title="Edit">'

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
            dvalue =  $(this).attr('data-view');
            var dataString = ({'id':dvalue});
      		ajaxType = "GET";
            urlpath = "<?php echo $path_url; ?>Principal_controller/GetTeacherById";
            ajaxfunc(urlpath,dataString,loadTeacherByIdReponseError,loadTeacherByIdResponse);

        });



      	function loadTeacherByIdReponseError(){}

        function loadTeacherByIdResponse(data)
        {
        	if(data.message == true)
        	{
        		$("#user_name").html(data.teacher_firstname);
        		$("#user_lastname").html(data.teacher_lastname);
        		$("#teacher_gender").html(data.gender);
        		$("#teacher_Nic").html(data.nic);
        		$("#teacher_phone").html(data.phone);
        			$("#primry_home_address").html(data.primary_address);
        				$("#secondary_home_address").html(data.secondary_address);
        					$("#teacher_province").html(data.province);
        					$("#teacher_zipcode").html(data.zipcode);
        					
        		$("#myModal").modal('show');
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

            urlpath = "<?php echo $path_url; ?>Principal_controller/removeParents";

            var dataString = ({'id':dvalue});

            ajaxfunc(urlpath,dataString,userDeleteFailureHandler,loadUserDeleteResponse);

    	});



        function userDeleteFailureHandler()

        {

 		 	$(".user-message").show();

	    	$(".message-text").text("Teacher has been not deleted").fadeOut(10000);

        }



        function loadUserDeleteResponse(response)

        {

        	if (response.message === true){

                $("#"+row_slug).remove();

     		 	$(".user-message").show();

		    	$(".message-text").text("Teacher has been deleted").fadeOut(10000);

         	} 

        }

        

	});

</script>

<script type="text/javascript">

	var app = angular.module('invantage', []);

</script>




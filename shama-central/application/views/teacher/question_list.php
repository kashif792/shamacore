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

                <p>Are you sure you want to delete this quiz?</p>

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

                <h3 style="padding-left: 40px;">Quiz</h3>

                <table class="table table-striped table-hover">

                    <tbody>

                        <tr>

                            <td>

                                <th>Subject Name</th>

                            </td>

                            <td id="user_name"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Subject Code</th>

                            </td>

                            <td id="user_email"></td>

                        </tr>

                        <tr>

                            <td>

                                <th>Class Name</th>

                            </td>

                            <td id="user_acct_date"></td>

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
	  				<h4>Quiz List</h4>
  				</div>
			</div>
			<div class="widget-body">
				<div class="setting-container">
					<div id="setting">          
				  		<ul class="resp-tabs-list vert">
			      			<?php if(count($roles_right) > 0){ ?>
					      	<li>Subjects</li>
					      	
					      	<?php } ?>
					  	</ul> 
			  			<div class="resp-tabs-container vert">                                                        
			      			<?php //if(count($roles_right) > 0){ ?>
			      			<div id="user-managment-tab">
			      				<div class="action-element">
		  							<a href="<?php echo $path_url; ?>addquizz" id="add-action">Add New Quiz</a>
		  						</div>
			      				<table class="table-body" id="table-body-phase-tow" >
			                        <thead>
				                        <tr>
				                            <th>Class(Section) Name</th>
				                            <th>Subject Name</th>
				                            <th>Quiz Name</th>
				                            <th>Isdone</th>
				                             <th>Options</th>
				                        </tr>
				                    </thead>
				                    <tfoot>
				                     <tr>
				                            <th>Class(Section) Name</th>
				                            <th>Subject Name</th>
				                            <th>Quiz Name</th>
				                            <th>Isdone</th>
				                             <th>Options</th>
				                        </tr>
				                    </tfoot>
									<tbody id="reporttablebody-phase-two" class="report-body">
			                        	<?php $i = 1 ; if(isset($quiz_list)){ ?>
			                                <?php foreach ($quiz_list as $key => $value) {?>
			                                <tr <?php if($i%2 == 0){echo "class='green-bar row-update'";} else{echo "class='yellow-bar row-update'";} ?> id="tr_<?php echo $value->row_slug ;?>" data-view="<?php echo $this->encrypt->encode($value->row_slug) ;?>">
			                                
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->grade." (".$value->section_name.")"; ?></td>
			                         			<td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo ucwords($value->subject_name); ?></td>
			                                   <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->qname; ?></td>
			                                    <td class="row-bar-user" data-view="<?php echo $value->row_slug ;?>"><?php echo $value->isdone; ?><input class="styled styled-primary" name="chkQ6" value="option1" aria-label="Single checkbox One" type="checkbox"><label></label></td>
			                                    <td>
			                                        <a href="<?php echo $path_url; ?>add_timtble/<?php echo $value->row_slug ;?>" id="<?php echo $this->encrypt->encode($value->row_slug) ;?>" class='edit' title="Edit">
			                                            <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
			                                        </a>
			                                        <a href="#" title="Delete" id="<?php echo 
                                                $value->id ;?>" class="del">
			                                            <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
			                                        </a>
			                                    </td>
			                                </tr>
			                                <?php $i++;} ?>
			                                <?php } else{ echo "<p id='novaluefound'>No quiz found.</p>";} ?>

					                </tbody>

			                    </table>

			      			</div>

			      			<?php// } ?>

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
            dvalue =  $(this).attr('data-view');
            var dataString = ({'id':dvalue});
            ajaxType = "GET";
            urlpath = "<?php echo $path_url; ?>Principal_controller/GetSubjectById";
            ajaxfunc(urlpath,dataString,loadClassByIdReponseError,loadClassByIdResponse);

          });



        function loadClassByIdReponseError(){}

        function loadClassByIdResponse(data)
        {
            if(data.message == true)
            {
                $("#class_name").html(data.grade);
                $("#section_name").html(data.section_name);
                
                            
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

            urlpath = "<?php echo $path_url; ?>Principal_controller/removeQuiz";

            var dataString = ({'id':dvalue});

            ajaxfunc(urlpath,dataString,userDeleteFailureHandler,loadUserDeleteResponse);

    	});



        function userDeleteFailureHandler()

        {

 		 	$(".user-message").show();

	    	$(".message-text").text("Quiz has been not deleted").fadeOut(10000);

        }



        function loadUserDeleteResponse(response)

        {

        	if (response.message === true){

                $("#"+row_slug).remove();

     		 	$(".user-message").show();

		    	$(".message-text").text("Quiz has been deleted").fadeOut(10000);

         	} 

        }

        

	});

</script>

<script type="text/javascript">

	var app = angular.module('invantage', []);

</script>




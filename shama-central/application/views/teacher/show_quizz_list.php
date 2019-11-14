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

                                <th>Grade Name</th>

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
		<div class="panel-heading plheading" id="widget-header">
			<!-- widget title -->
  				<!-- <div class="widget-title"> -->
	  				<h4>Quiz list
	  					<!-- <a href="<?php echo $path_url; ?>addquizz" class="btn btn-primary" id="add-action">Add New Quiz</a> -->
              <a href="#" class="btn btn-primary" id="update-action">Update Quizzes</a>
	  					</h4>
  				<!-- </div> -->
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
		  						
		  						</div>
			      				<table class="table-body" id="table-body-phase-tow" >
			                        <thead>
				                        <tr>
				                            <th>Grade</th>
				                            <th>Subject</th>
				                            <th>Quiz Name</th>
				                             <th>Options</th>
				                        </tr>
				                    </thead>
				                    <tfoot>
				                     <tr>
				                            <th>Grade</th>
				                            <th>Subject</th>
				                            <th>Quiz Title</th>
				                             <th>Options</th>
				                        </tr>
				                    </tfoot>
									<tbody id="reporttablebody-phase-two" class="report-body">
			                        	<?php $i = 1 ; if(isset($quiz_list)){ ?>
			                                <?php foreach ($quiz_list as $key => $value) {?>
			                                <tr <?php if($i%2 == 0){echo "class='green-bar row-update'";}
                                             else
                                            {
                                                echo "class='yellow-bar row-update'";} ?> id="tr_<?php echo $value->id ;?>" data-view="<?php echo $this->encrypt->encode($value->row_slug) ;?>">
			                                    <td class="row-bar-user" ><?php echo $value->grade; ?></td>
			                         			<td class="row-bar-user" ><?php echo ucwords($value->subject_name); ?></td>
			                                   <td class="row-bar-user" ><?php echo $value->qname; ?></td>
			                                  
			                                    <td>
			                                        <a href="<?php echo $path_url; ?>addquizz/<?php echo $value->id ;?>" id="<?php echo $value->id ;?>" class='edit' title="Edit">
			                                            <i class="fa fa-edit" aria-hidden="true"></i>
			                                        </a>
			                                    </td>
			                                </tr>
			                                <?php $i++;} ?>
			                                <?php }  ?>

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

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>This is a small modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

	             "order": [[ 0, "desc"  ]],

	            initComplete: function () {

	                this.api().columns().every( function () {

	                    var column = this;
                      if(column.index() != 3){
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
                      }
	                });

	            }

	        });

	    }




	     $(document).on('change','.checkbox',function(){
                var id = $(this).attr('id');
                var check=$(this).is(':checked');
                checkinput = '0'
                if(check == true){
                    checkinput = '1'
                }
               	
                    $.ajax({
                        url: "<?php echo $path_url;?>markquizz", //The url where the server req would we made.
                        async: false,
                        type: "POST", //The type which you want to use: GET/POST
                        data:{'id': id, 'checkinput': checkinput}, //The variables which are going.
                        dataType: "JSON", //Return data type (what we expect).
                          
                        //This is the function which will be called if ajax call is successful.
                        success: function(data) {
                            //data is the html of the page where the request is made.
                             
                        }
                    })
            })



	});

</script>

<script src="<?php echo $path_url; ?>js/jquery.easyResponsiveTabs.js"></script>



<script type="text/javascript">

	$(document).ready(function(){



      	




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

            ajaxfunc(urlpath,dataString,quizDeleteFailureHandler,loadQuizDeleteResponse);

    	});

        $(document).on('click','#update-action',function(){

            
        ajaxType = "GET";

            urlpath = "<?php echo $path_url; ?>Principal_controller/updatequiz";

            var dataString = '';

            ajaxfunc(urlpath,dataString, function(){
              // on failed
            },
              function(){
                if (response.message === true){

                  $(".user-message").show();

                  $(".message-text").text("Quiz data has been updated").fadeOut(2000);

                  $window.refresh();

                }else{

                }
            });

            

        });




        function quizDeleteFailureHandler()

        {

 		 	$(".user-message").show();

	    	$(".message-text").text("Quiz has been not deleted").fadeOut(10000);

        }



        function loadQuizDeleteResponse(response)

        {

        	if (response.message === true){

                $("#tr_"+dvalue).remove();

     		 	$(".user-message").show();

		    	$(".message-text").text("Quiz has been deleted").fadeOut(10000);

         	} 

        }

        

	});

</script>

<script type="text/javascript">

	var app = angular.module('invantage', []);
	function check(str)
    {
        var selState = str;
        $.ajax({
            url: "Check/ajax_call", //The url where the server req would we made.
            async: false,
            type: "POST", //The type which you want to use: GET/POST
            data: "state="+selState, //The variables which are going.
            dataType: "JSON", //Return data type (what we expect).
            //This is the function which will be called if ajax call is successful.
            success: function(data) {
         		alert("Quize successfully added");
          	}
        })
   }

</script>




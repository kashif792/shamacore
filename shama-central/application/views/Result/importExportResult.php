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
<div class="col-sm-10"  ng-controller="lesson_plan_controler">

<?php

	// require_footer

	require APPPATH.'views/__layout/filterlayout.php';

?>
	<div class="col-lg-12 widget" ng-controller="lesson_plan_controler">
		<div class="panel-heading plheading" id="widget-header">
			<!-- widget title -->
  				<!-- <div class="widget-title"> -->
	  				<h4>Import and Export Result</h4>
  				<!-- </div> -->
			</div>
			<div class="widget-body">
				<div class="setting-container">
					<div id="setting">
				  		<ul class="resp-tabs-list vert">
			      			<?php if(count($roles_right) > 0){ ?>
					      	<li class="">Lesson</li>
					      	<?php } ?>
					  	</ul>
			  			<div class="resp-tabs-container vert">
			      			<?php //if(count($roles_right) > 0){ ?>
			      			<div id="user-managment-tab">



                                            <div class="widget-body">
                <div class="col-lg-12">
                    <div class="form-container">
                        <?php $attributes = array('name' => 'schedule_timetable', 'id' => 'schedule_timetable','class'=>'form-container'); echo form_open('', $attributes);?>
                            <input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial">
                            <fieldset>
                                 <div class="field-container ">

                                </div>
                                <div class="field-container ">
                                    <div class="field-row">

                                <div class="row">
                                        <div class="col-lg-2">
                                            <div class="upper-row">
                                                <label><span class="icon-address"></span> Class<span class="required"></span></label>
                                            </div>
                                                <select name="select_class" id="select_class"    >
                                                <?php

                                                    if(count($classlist))
                                                    {
                                                        foreach ($classlist as $key => $value) {
                                                            if(isset($value->id) && !empty($value->grade)){
                                                            ?>
                                                                 <option  value="<?php echo $value->id; ?>" <?php if($value->id==$classlist[0]->id) echo "selected";?>><?php echo $value->grade; ?></option>
                                                            <?php
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="upper-row">
                                                <label><span class="icon-home-1"></span> Section <span class="required"></span></label>
                                            </div>
                                         <select ng-options="item.name for item in sectionslist track by item.id" ng-change="changesection()"  name="inputSection" id="inputSection"  ng-model="inputSection" >
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="upper-row">
                                                <label><span class="icon-code"></span> Subjects <span class="required"></span></label>
                                            </div>
                                            <select ng-options="item.name for item in subjectlist track by item.id" name="select_subject" id="select_subject" ng-model="inputSubject"></select>
                                        </div>
                                         <div class="col-lg-2">
                                            <div class="upper-row">
                                                <label><span class="icon-address"></span> Terms<span class="required"></span></label>
                                            </div>
                                                <select name="select_term" id="select_term"    >
                                                <?php

                                                    if(count($termlist))
                                                    {
                                                        foreach ($termlist as $key => $value) {
                                                            if(isset($value->id) && !empty($value->term_name)){
                                                            ?>
                                                                 <option  value="<?php echo $value->id; ?>" <?php if($value->id==$classlist[0]->term_name) echo "selected";?>><?php echo $value->term_name; ?></option>
                                                            <?php
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                     <div class="col-lg-2">
                                            <div class="upper-row">
                                                <label><span class="icon-code"></span> Import <span class="required"></span></label>
                                            </div>
                                               <input type="file" name="file" id="file" class="input-large">
                                   </div>
                                        <div class="col-lg-2"> 
                                        <button class="nowsave" id="stdresutl">Upload </button>   

                                      </div>
                                     </div>
                                    </div>
                                </div>
                            </fieldset>
                        <?php echo form_close();?>
                    </div>
                </div>
                     <!-- <div class="sam">  -->
                    <div id="container">
                          <div class="columnLayout">
                            <div class="rowLayout">
                          <div class="descLayout">
                            <div class="pad" data-jsfiddle="imoort_export_result">
                              <div id="exampleConsole" class="console"></div>

                              <div id="imoort_export_result"></div>
                              <p>
                                <button  type="button" id="export-file"  class="export_button">
                                    Export as a file
                          </button>
                          <button name="save"  id="saveupdate" class="intext-btn sve">Save</button>

                              </p>
                            </div>
                          </div>
                        </div>
                          </div>

                  <!-- </div> -->
                </div>

            <!-- </div> -->

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


<!-- <script type="text/javascript">

// 	var app = angular.module('invantage', []);

// </script> -->

<script data-jsfiddle="common" src="js/excel/dist/handsontable.js"></script>
<script type="text/javascript">
    var app = angular.module('invantage', []);

    app.controller('lesson_plan_controler', function($scope, $http, $interval) {
    
    loadSections() ;
      
      

      function getSubjectList()
      {
        try{
            var data = ({inputclassid:parseInt($("#select_class").val())})
        
            httprequest('<?php echo $path_url; ?>getsubjectlistbyclass',data).then(function(response){
                if(response.length > 0 && response != null)
                {
                    $scope.inputSubject = response[0];

                    $scope.subjectlist = response;
                    
                    
                }
                else{
                    $scope.subjectlist = [];
                      
                }
            })
        }
        catch(ex){}
      }
        
        function loadSections()
        {
    
            try{
                var data = ({inputclassid:$("#select_class").val()})
                getSubjectList()
                httprequest('<?php echo $path_url; ?>getsectionbyclass',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.inputSection = response[0];
                        $scope.sectionslist = response;
                        
                    }
                    else{
                        $scope.sectionslist = [];
                    }
                })
            }
            catch(ex){}
        }

        $(document).on('change','#select_class',function(){
             try{
            
                loadSections();
                 var class_id=$("#select_class").val();
              
              var subjectid=$("#select_subject").val();
              var sectionid=$("#inputSection").val();
               var termid=$("#select_term").val();
                var sectionid=$("#inputSection").val();
        get_data(class_id,termid,sectionid,subjectid);
            }
            catch(ex){}
        })
          
          $scope.changesection = function()
          {
             var class_id=$("#select_class").val();
              
              var subjectid=$("#select_subject").val();
              var sectionid=$("#inputSection").val();
               var termid=$("#select_term").val();
                var sectionid=$("#inputSection").val();
        get_data(class_id,termid,sectionid,subjectid);
          }

        function httprequest(url,data)
      {
        var request = $http({
          method:'GET',
          url:url,
          params:data,
          headers : {'Accept' : 'application/json'}
        });
        return (request.then(responseSuccess,responseFail))
      }

     
      function responseSuccess(response){
        return (response.data);
      }

      function responseFail(response){
        return (response.data);
      }



            var
              $container = $("#imoort_export_result"),
              $parent = $container.parent(),
              autosaveNotification,
              hot;
                var change=1;
              var data_array = [];
              console.log ($("#select_subject"));
              setTimeout(function()
              { 
                var class_id=$("#select_class").val();
                var termid=$("#select_term").val();
                var sectionid=$("#inputSection").val();
                var subjectid=$("#select_subject").val();
                   get_data(class_id,termid,sectionid,subjectid);

               }, 100);

             
              function get_data(class_id,termid,sectionid,subjectid)
               {
                var userdata = [

                ]
                data_array = []
                  $.ajax({
                    url: 'loaddatafromdab',
                     type: 'POST',
                    dataType: 'json',
                   
                    data: {class_id:class_id,subject_id:subjectid,section_id:sectionid,record_status:change,term_id:termid},
                    success: function (res) {
                   

                       for (var i = res.length - 1; i >= 0; i--) {
                          var temp = []
                           temp.push(res[i].resultid)
                           temp.push(res[i].screenname)
                           temp.push(res[i].marks)
                            data_array.push(temp)
                       }

                       initobj();
                    }
                  });

               }

            function initobj()
            {
               
               var container = $("#imoort_export_result").handsontable({
                data: data_array,
                colHeaders: ['Student Name', 'marks'],
                startRows: 20,
                startCols: 4,
                rowHeaders: true,
                // contextMenu: ['remove_row','row_above', 'row_below'],
                manualRowResize: true,
                columnSorting: true,
                sortIndicator: true,
                autoWrapCol :true,
              
                colWidths: [400,200],
               
                autoColSize: true,
                autoWrapRow: true,
                dropdownMenu: true,
                 
               

                 columns: [
                  {data: 0},
                  {data: 1},

                  {data: 2}
                  ],
                  

                  // afterSelectionEnd: function(x1, y1, x2, y2)
                  // {

                    

                  // },




          beforeRemoveRow:function(index,amount)
          {
           for (var i = amount - 1; i >= 0; i--) {
             console.log(index[i])
           };
             var id = $("#imoort_export_result").handsontable('getDataAtRow',index,1);
                    var data = {

                        id:id,
                    }

                     $.ajax({
                     url:'removeResult',
                      type: 'POST',
                      data: {data:data,candelete:true},
                      success: function(res){
                       for (var i = res.length - 1; i >= 0; i--) {
                          // if(!res[i].id){
                          // var temp = []
                          //  temp.push(res[i].id='add')
                          // data_array.push(temp)
                          //     }
                             }
                     alert("success");
                     // alert(res);
                      },
                        error: function(){
                     alert("Fail")
                  }});

          },


                  

                  afterChange: function (change, source)
                   {
                    if (source === 'loadData') {
                        return; //don't save this change
                    }

                    var data = {
                        cellheader: change[0][1],
                        cellvalue:change[0][3]

              
                    }

                  

                    console.log(data_array);
                    if(!(change[0][2]))
                        {
                          //Add function here
                          //alert('new');
                        }
                        else if(change[0][2] != change[0][3]){
                          //edit case here
                          //alert('edit');
                        }
                        else if(!(change[0][0] && change[0][1])){
                          //edit case here
                          //alert('edit');
                        }
                    console.log(change);
                    console.log(source);
                    console.log(data);
                    
                },
         
              });

               var $container = $("#imoort_export_result");
              var handsontable = $container.data('handsontable');
             
          }

           
            $(document).on('click','#saveupdate',function(){

              var class_id=$("#select_class").val();
              var sectionid=$("#inputSection").val();
              var subjectid=$("#select_subject").val();
               var termid=$("#select_term").val();
      
              // alert(class_id);
              var jsonString = JSON.stringify(data_array);
                    $.ajax({
                     url:'SaveResult',
                      type: 'POST',
                      data: {data:jsonString,candelete:true,termid:termid,class_id:class_id,sectionid:sectionid,subjectid:subjectid},
                      success: function(res){
                     alert("success");

                     alert(res);
                     location.reload();
                      },
                        error: function(){
                     alert("Fail")
                  }});

            });

          $(document).on('click','.nowsave',function(){
               $file=$("#file").val();
                if(!$file)
                {
                  alert('Please select a file');

                  return false;

                }
                 var class_id=$("#select_class").val();
                 var sectionid=$("#inputSection ").val();
                 var subjectid=$("#select_subject").val();
                   var termid=$("#select_term").val();
      
                  var formData = new FormData();
                
                  formData.append('class_id',class_id)
                  formData.append('sectionid',sectionid)
                  formData.append('subjectid',subjectid)

                  formData.append('termid',termid)

                  formData.append('Import',true);
                 $.each($("#file")[0].files,function(key,value){
                formData.append("file",value);
            });
                   $.ajax({
                    url: '<?php echo $path_url;?>Result/ImportResult?file',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    dataType: 'json',
                    mimeType:"multipart/form-data",
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data) {
                    
                      data_array=[];
                var class_id=$("#select_class").val();
                var termid=$("#select_term").val();
                var subjectid=$("#select_subject").val();
                 var sectionid=$("#inputSection ").val();
                   get_data(class_id,termid,sectionid,subjectid);
                      }
                    });
       
                return false;
          }) ;


     $(document).on('click','.export_button',function(){
      {
        var class_id=$("#select_class").val();
             var sectionid=$("#inputSection ").val();
              var subjectid=$("#select_subject").val();
               var termid=$("#select_term").val();
              $.ajax({
                     url:'exportResultdata',
                      type: 'POST',
                      data: {class_id:class_id,sectionid:sectionid,subjectid:subjectid,termid:termid},
                      success: function(data){
                        var datafile = jQuery.parseJSON(data)
                        window.location = datafile.file
                      },
                    error: function(){
                     alert("Fail")
                  }
                });

      }  
       });


 $(document).on('change','#select_subject',function(){
    data_array=[];
    var class_id=$("#select_class").val();
              
              var subjectid=$("#select_subject").val();
              var sectionid=$("#inputSection").val();
               var termid=$("#select_term").val();
                var sectionid=$("#inputSection").val();
        get_data(class_id,termid,sectionid,subjectid);
      
        
  });        
  
 
    });


// function changeclass()
// {

//   data_array=[];
//  var class_id=$("#select_class").val();
              
//               var subjectid=$("#select_subject").val();
//         get_data(class_id,subjectid,2,3);

// }



          
</script>




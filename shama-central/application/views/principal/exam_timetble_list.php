<?php

// require_header
require APPPATH . 'views/__layout/header.php';

// require_top_navigation

require APPPATH . 'views/__layout/topbar.php';

// require_left_navigation

require APPPATH . 'views/__layout/leftnavigation.php';

?>



<div id="myUserModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title">Confirmation</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete this schedule?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">No
				</button>
				<button type="button" id="UserDelete" class="btn btn-default "
					value="save">Yes</button>
			</div>
		</div>
	</div>
</div>
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h3 style="padding-left: 40px;">Schedule Information</h3>
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
							
							<th>Grade Name</th>
							</td>
							<td id="user_email"></td>
						</tr>
						<tr>
							<td>
							
							<th>Section Name</th>
							</td>
							<td id="user_acct_date"></td>
						</tr>
						<tr>
							<td>
							
							<th>Teacher Name</th>
							</td>
							<td id="user_acct_status"></td>
						</tr>
						<tr>
							<td>
							
							<th>Start Time</th>
							</td>
							<td id="user_role"></td>
						</tr>
						<tr>
							<td>
							
							<th>End Time</th>
							</td>
							<td id="user_role"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close
				</button>
			</div>
		</div>
	</div>
</div>




<div class="col-sm-10">



<?php

// require_footer

require APPPATH . 'views/__layout/filterlayout.php';

?>
<div class="panel panel-default" ng-controller="timetableCtrl">
		<div class="panel-heading">
			<label>Schedule List &nbsp;&nbsp;&nbsp;

				<a ng-if="isPrincipal"
				href="<?php echo $path_url; ?>add_timtble" class="btn btn-primary"
				style="color: #fff !important;">Add Schedule</a>

			</label>
            <label class="right-controllers">
            <a href="javascript:void(0)" class="link-student" ng-click="download()" title="Download"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
            
        </label>
		</div>
		<div class="panel-body">
            <div class="row">
            <div class="col-sm-12">
                
                       <form class="form-inline" >
                        <label for="select_class">Select Days:</label>
                        
                        <select class="form-control" name="inputDay" id="inputDay" ng-model="filterobj.day" ng-change="changeclass()" >
                            <option value="" style="display: none;">loading...</option>
                            <option value="mon">Monday</option>
                            <option value="tue">Tuesday</option>
                            <option value="wed">Wednesday</option>
                            <option value="thu">Thursday</option>
                            <option value="fri">Friday</option>
                            <option value="sat">Saturday</option>
                            <option value="sun">Sunday</option>
                        </select>
                    </form>
                </div>
                
            </div>
			<table class="table table-striped table-bordered row-border hover" id="table-body-phase-tow" >

                                    <thead>

                                        <tr>

                                          

                                            <th>Subjects</th>

                                            <th>Grade</th>

                                            <th>Teachers</th>

                                            <th>Start Time</th>

                                            <th>End Time</th>

                                            <th>Options</th>

                                        </tr>

                                    </thead>

                                    <tfoot>

                                        <tr>

                                      

                                            <th>Subjets</th>

                                            <th>Grade</th>

                                            <th>Teachers</th>

                                            <th>Start Time</th>

                                            <th>End Time</th>

                                            <th>Options</th>

                                        </tr>

                                    </tfoot>

                                    <tbody >

                                    </tbody>



                                </table>

		</div>
	</div>

</div>



<?php

// require_footer

require APPPATH . 'views/__layout/footer.php';

?>



<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>
<script src="<?php echo base_url(); ?>js/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>js/vfs_fonts.js"></script>
<script src="<?php echo  base_url(); ?>js/ui-bootstrap-tpls-2.5.0.js"></script>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>




<script type="text/javascript">

	var dvalue ;

	$(document).ready(function(){
		$('#setting').easyResponsiveTabs({ tabidentify: 'vert' });


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

        $(document).on('click','.del',function(){

            $("#myUserModal").modal('show');

            dvalue =  $(this).attr('id');

            row_slug =   $(this).parent().parent().attr('id');

        });


        $(document).on('click','#UserDelete',function(){

            $("#myUserModal").modal('hide');

            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>schedule";

			var data = 'id='+String(dvalue);
            urlpath += '?'+ data;
            ajaxType = 'DELETE';
            ajaxfunc(urlpath,[],userDeleteFailureHandler,loadUserDeleteResponse);
            

    	});



        function userDeleteFailureHandler()
        {

 		 	$(".user-message").show();

	    	$(".message-text").text("Schedule has been not deleted").fadeOut(10000);

        }



        function loadUserDeleteResponse(response)
        {

        	if (response.message === true){

                $("#"+row_slug).remove();

     		 	$(".user-message").show();
                message('schedule has been deleted','show');
		    	//$(".message-text").text("schedule has been deleted").fadeOut(10000);
         	} 

        }

	});



</script>





<script>

    app.controller('timetableCtrl',['$scope','$myUtils', timetableCtrl]);

    function timetableCtrl($scope, $myUtils) {

        $scope.isPrincipal = false;
        $scope.isTeacher = false;
        $scope.isAdmin = false;
        $scope.day = [];
        $scope.data = [];
        if(!$myUtils.checkUserAuthenticated()){
            console.log('User not authenticated!');
            return;
        }
        
        //console.log('User ' + $myUtils.userId + ' authenticated!');

        $scope.baseUrl = '<?php echo base_url() ?>'

        $scope.user_id = $myUtils.getUserId();
        $scope.name = $myUtils.getUserName();
        $scope.email = $myUtils.getUserEmail();
        $scope.roles = $myUtils.getUserRoles();
        $scope.school_id = $myUtils.getDefaultSchoolId();
        $scope.session_id = $myUtils.getDefaultSessionId();
        
        if($myUtils.getUserProfileImage()){
            $scope.profileImage = $myUtils.getUserProfileImage();
        }

        if($myUtils.getUserProfileThumb()){
            $scope.profileThumb = $myUtils.getUserProfileThumb();
        }
        
        $scope.roles = $myUtils.getUserRoles();
        
        $scope.schoolName = '';
        if($myUtils.getUserLocations().length){
            $scope.schoolName = $myUtils.getUserLocations()[0].schoolname;
        }

        $scope.type = $myUtils.getUserType();

        $scope.role_id = $myUtils.getUserDefaultRoleId();

        $scope.isPrincipal = $myUtils.isPrincipal();
        $scope.isTeacher = $myUtils.isTeacher();
        $scope.isAdmin = $myUtils.isAdmin();

        function getDayList()
        {
            
            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>getdaylist',({})).then(function(response){ 
                if(response != null && response.length > 0)
                {
                    
                    $scope.daylist = response;
                    //$scope.filterobj.day = response[0];
                    
                }
            });
        }
        
        $scope.changeclass = function()
        {
            
            getScheduleDatafilter();
            
            
            $scope.active = 1;
            
        }
        
        function getScheduleData()
        
        {

            try{

                    $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>schedules',({user_id:$scope.user_id, role_id:$scope.role_id,school_id:$scope.school_id})).then(function(response){

                        
                        $scope.data = [];
                        if(response.length > 0 && response != null)
                        {
                            for (var i=0; i<response[0]['listarray'].length; i++) {
                                $scope.data.push(response[0]['listarray'][i]);
                                
                                
                            }
                            $("#inputDay").val(response[0]['data_array']['select_day']);
                            $("#table-body-phase-tow").dataTable().fnDestroy();
                            loaddatatable($scope.data);
                            
                        }
                        else{
                            $scope.schedulelist = [];
                         
                        }
                })
            }
            catch(e){}
        }
        
        function getScheduleDatafilter()
        
        {

            try{
                    
                    $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>schedules',({user_id:$scope.user_id, role_id:$scope.role_id,school_id:$scope.school_id,select_day:$scope.filterobj.day})).then(function(response){

                        
                        $scope.data = [];
                        if(response.length > 0 && response != null)
                        {
                            for (var i=0; i<response[0]['listarray'].length; i++) {
                                $scope.data.push(response[0]['listarray'][i]);
                                
                                
                            }
                            $("#inputDay").val(response[0]['data_array']['select_day']);
                            $("#table-body-phase-tow").dataTable().fnDestroy();
                            loaddatatable($scope.data);
                            
                        }
                        else{
                            $scope.schedulelist = [];
                         
                        }
                })
            }
            catch(e){}
        }


        angular.element(function () {

        	getScheduleData();
            getDayList();
         });


        function loaddatatable(data)
        {
            var listdata= data;
            
            var table = $('#table-body-phase-tow').DataTable( {
                data: listdata,
                responsive: true,
                "order": [[ 0, "asc"  ]],
                rowId: 'id',
                columns: [
                    { data: 'subject_name' },
                    { data: 'grade' },
                    { data: 'screenname' },
                    { data: 'start_time' },
                    { data: 'end_time' },
                    {
                     "className": '',
                     "orderable": false,
                     "data": null,

                     "defaultContent": "",
                     "render" : function ( data, type, full, meta ) {
                          if ( data != null && data != '') {
                             
                             return "<a href='<?php echo $path_url; ?>add_timtble/"+data['id']+"'  ><i class='fa fa-edit' aria-hidden='true'></i></a> <a href='javascript:void(0)' id="+data['id']+" class='del'><i class='fa fa-remove' aria-hidden='true'></i></a>";
                         }
                         else {
                                 return;
                         }
                      }
                    },
                ],

                "pageLength": 10,

            })
            
          
            table.columns(1).every( function () {
                var column = this;
                var select = $('<select id="grade_id"><option value="">All</option></select>')
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
            table.columns(2).every( function () {
                var column = this;
                var select = $('<select><option value="">All</option></select>')
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
        // pdf
        $scope.renderprintdata = function()
        {
            try{

                var docDefinition = {
                    pageOrientation: 'landscape',
                    content: [

                        {image:'<?php echo $logo ?>',style:'report_logo'},
                        {
                            margin: [0, 10, 0, 10],
                            columns: [
                               {
                                    width: '*',
                                    text: ' Time Table '+$scope.grade_name,
                                    alignment: 'center',
                                    fontSize: '24',
                                    bold: true,
                                },
                                 
                            ]
                        },
                        
                        {
                        columns: [
                                
                               table($scope.scheduletimetable,$scope.schedulecolumns),
                        ]
                        },
                   ],
                   

                    styles: {
                        report_header: {
                            fontSize: 10,
                            bold: false,
                            alignment: 'center',
                            margin: [0, 10, 0, 40]
                        },
                        report_logo: {
                            alignment: 'center',
                            margin: [0, 10, 0, 10]
                        },
                        header_txt: {
                            alignment: 'left',
                            margin: [0, 10, 0, 10],
                            fontSize: 14,
                            
                            fillColor: '#4c9eda',
                            color:"#fff",
                        },
                        
                    }
                };
                return docDefinition;
            }
            catch(e){}
        }
        // Generate PDF
        function buildTableBody(data, columns) {
            var body = [];
            //console.log(data);
            var back_color = ['#008000','#ff66ff','#ff0000','#0099cc','#cc0066'];
            var i = 1;
            var temp = [];
                    

            data.forEach(function(row) {
                var dataRow = [];
                columns.forEach(function(column) {

                    if(i==1)
                    {
                        var strArray = row[column].split("|");
                        
                        if(strArray['1'].toString()==' (00:00 - 00:00)')
                        {
                            dataRow.push({text : "", alignment : 'center', color : '#000',width:'*',fillColor: '#fff',margin: [0, 10, 0, 5],});
                            
                        }
                        else
                        {
                            dataRow.push({text : strArray['0'].toString()+'\n'+strArray['1'].toString(), alignment : 'center', color : '#000',width:'*',fillColor: '#fff',margin: [0, 10, 0, 5]});
                            
                        }
                    }
                    else if(i==2)
                    {
                        var strArray = row[column].split("|");
                        if(strArray['1'].toString()==' (00:00 - 00:00)')
                        {
                            dataRow.push({text : "", alignment : 'center', color : '#fff',width:'*',fillColor: '#fffcd7',margin: [0, 5, 0, 5],});
                            
                        }
                        else
                        {
                            dataRow.push({text : strArray['0'].toString()+'\n'+strArray['1'].toString(), alignment : 'center', color : '#000',width:'*',fillColor: '#fffcd7',margin: [0, 5, 0, 5],});
                            
                        }

                        
                    }
                    else if(i==3)
                    {
                        var strArray = row[column].split("|");
                        if(strArray['1'].toString()==' (00:00 - 00:00)')
                        {
                            dataRow.push({text : "", alignment : 'center', color : '#fff',width:'*',fillColor: '#f9d7e5',margin: [0, 5, 0, 5],});
                            
                        }
                        else
                        {
                            dataRow.push({text : strArray['0'].toString()+'\n'+strArray['1'].toString(), alignment : 'center', color : '#000',width:'*',fillColor: '#f9d7e5',margin: [0, 5, 0, 5],});
                            
                        }
                        
                    }
                    else if(i==4)
                    {
                        var strArray = row[column].split("|");
                        if(strArray['1'].toString()==' (00:00 - 00:00)')
                        {
                            dataRow.push({text : "", alignment : 'center', color : '#fff',width:'*',fillColor: '#cde8d5',margin: [0, 5, 0, 5],});
                            
                        }
                        else
                        {
                            dataRow.push({text : strArray['0'].toString()+'\n'+strArray['1'].toString(), alignment : 'center', color : '#000',width:'*',fillColor: '#cde8d5',margin: [0, 5, 0, 5],});
                            
                        }
                        
                    }
                    else if(i==5)
                    {
                        var strArray = row[column].split("|");
                        if(strArray['1'].toString()==' (00:00 - 00:00)')
                        {
                            dataRow.push({text : "", alignment : 'center', color : '#fff',width:'*',fillColor: '#ffe8d0',margin: [0, 5, 0, 5],});
                            
                        }
                        else
                        {
                            dataRow.push({text : strArray['0'].toString()+'\n'+strArray['1'].toString(), alignment : 'center', color : '#000',width:'*',fillColor: '#ffe8d0',margin: [0, 5, 0, 5],});
                            
                        }
                        
                    }
                    else if(i==6)
                    {
                        var strArray = row[column].split("|");
                        if(strArray['1'].toString()==' (00:00 - 00:00)')
                        {
                            dataRow.push({text : "", alignment : 'center', color : '#fff',width:'*',fillColor: '#c9eafb',margin: [0, 5, 0, 5],});
                            
                        }
                        else
                        {
                            dataRow.push({text : strArray['0'].toString()+'\n'+strArray['1'].toString(), alignment : 'center', color : '#000',width:'*',fillColor: '#c9eafb',margin: [0, 5, 0, 5],});
                            
                        }
                        
                    }
                    else if(i==7)
                    {
                        var strArray = row[column].split("|");
                        if(strArray['1'].toString()==' (00:00 - 00:00)')
                        {
                            dataRow.push({text : "", alignment : 'center', color : '#fff',width:'*',fillColor: '#fffcd7',margin: [0, 5, 0, 5],});
                            
                        }
                        else
                        {
                            dataRow.push({text : strArray['0'].toString()+'\n'+strArray['1'].toString(), alignment : 'center', color : '#000',width:'*',fillColor: '#fffcd7',margin: [0, 5, 0, 5],});
                            
                        }
                        
                    }
                    else if(i==8)
                    {
                        var strArray = row[column].split("|");
                        if(strArray['1'].toString()==' (00:00 - 00:00)')
                        {
                            dataRow.push({text : "", alignment : 'center', color : '#fff',width:'*',fillColor: '#cde8d5',margin: [0, 5, 0, 5],});
                            
                        }
                        else
                        {
                            dataRow.push({text : strArray['0'].toString()+'\n'+strArray['1'].toString(), alignment : 'center', color : '#000',width:'*',fillColor: '#cde8d5',margin: [0, 5, 0, 5],});
                            
                        }
                        
                    }
                    else if(i==9)
                    {
                        var strArray = row[column].split("|");
                        if(strArray['1'].toString()==' (00:00 - 00:00)')
                        {
                            dataRow.push({text : "", alignment : 'center', color : '#fff',width:'*',fillColor: '#fee9ce',margin: [0, 5, 0, 5],});
                            
                        }
                        else
                        {
                            dataRow.push({text : strArray['0'].toString()+'\n'+strArray['1'].toString(), alignment : 'center', color : '#000',width:'*',fillColor: '#fee9ce',margin: [0, 5, 0, 5],});
                            
                        }
                        
                    }
                    
                    else
                    {
                        var strArray = row[column].split("|");
                        if(strArray['1'].toString()==' (00:00 - 00:00)')
                        {
                            dataRow.push({text : "", alignment : 'center', color : '#fff',width:'*',fillColor: '#c9eafb',margin: [0, 5, 0, 5],});
                            
                        }
                        else
                        {
                            dataRow.push({text : strArray['0'].toString()+'\n'+strArray['1'].toString(), alignment : 'center', color : '#000',width:'*',fillColor: '#c9eafb',margin: [0, 5, 0, 5],});
                            
                        }
                        
                    
                    }
                    if(i==$scope.schedulecolumns.length)
                    {
                        i = 0;
                    }
                    i++;
                })

                body.push(dataRow);
            });
            
            return body;
        }
        function table(data, columns ) {
            try{
                var w_columns = [];
                columns.forEach(function() {
                    w_columns.push('*');
                })
                var font_size = 12;
                if($scope.schedulecolumns.length>7)
                {
                    font_size = 10;
                }
                return {
                    fontSize: font_size,
                    alignment: "center",
                    style: 'tableExample',
                    width: '*',
                    table: {
                        headerRows: 1,
                        widths: w_columns,
                        body: buildTableBody(data,columns),

                        alignment: "center",
                    },

                    layout: {
                    fillColor: function (rowIndex, node, columnIndex) {

                            return (rowIndex % 2 === 0) ? '#f1f1f1' : null;
                        
                        
                        }
                    }
                };
            }
            catch(e){
                console.log(e)
            }
            
        } 
        $scope.printreport = function()
        {
            var reportobj = $scope.renderprintdata();
         
            pdfMake.createPdf(reportobj).print();
        }
        $scope.download = function()
        {
            getGradeWiseTimeTableData();
            
        }

        function getGradeWiseTimeTableData()
        {
            try{
                //$scope.semesterlist = []
                var grade_id = $("#grade_id").val();
                if(grade_id=='')
                {
                    message('Please select grade','show');
                    return false;
                }
                
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>getTimetablepdf',({role_id:$scope.role_id,school_id:$scope.school_id,grade_id:grade_id})).then(function(response){
                   if(response.length > 0 && response != null)
                    {

                        $scope.scheduletimetable = response[0]['details'];
                        $scope.schedulecolumns =response[0]['colums'];
                         $scope.grade_name = response[0]['data_array']['grade_name'];
                         $scope.day_name = response[0]['data_array']['day_array'];
                       // console.log($scope.schedulecolumns.length);
                        var reportobj = $scope.renderprintdata();
            
                        pdfMake.createPdf(reportobj).download("Schedule - "+$scope.grade_name+".pdf");

                    }
                    else{
                        $scope.semesterlist = [];
                    }
                });
             }
            catch(ex){}
        }
    }


</script>
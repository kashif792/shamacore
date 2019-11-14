<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10" ng-controller="semester_ctrl">
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
	<?php
		// require_footer 
		require APPPATH.'views/__layout/filterlayout.php';
	?>
	<div class="col-lg-12">
		<div class="row" >
			<div class="panel panel-default" >
				<!-- widget title -->
  				<div class="panel-heading">
	  				<label>Semester</label>
  				</div>
			
				<div class="panel-body">
					<div class="col-lg-12">
						<form class="form-inline">
                            <div class="form-group">
                                <label for="email">Semester:</label>
                                <input type="text" name="inputSemester" id="inputSemester" ng-model="inputSemester">
                            </div>
                            <div class="form-group">
                                <button type="button" ng-click="savesemester()" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                        <div class="row" style="margin-top: 5px;">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-striped table-hover table-condensed" id="table-body-phase-tow" >
                                    <thead>
                                        <tr>
                                            <th>Semester</th>
                                            <th>Status</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reporttablebody-phase-two" class="report-body">
                                        <tr ng-repeat="s in semesterlist">
                                            <td>{{s.name}}</td>
                                            <td><input type="radio" name="inputCurrentSemester" ng-model="inputCurrentSemester" value="{{s.id}}" ng-click="setCurrentSemester(s.id)"></td>
                                            <td>
                                                <a href="javascript:void(0)" ng-click="editsemester(s.id)" title="Edit" class="edit" session-data="{{s.id}}">
                                                    <span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
                                                </a>
                                                <a href="javascript:void(0)" ng-click="removesemester(s.id)" title="Delete"  class="del" session-data="{{s.id}}">
                                                    <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
                                                </a>    
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
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



<script type="text/javascript">
	var app = angular.module('invantage', []);
	app.controller('semester_ctrl', function($scope, $http, $interval) {
		
		$scope.semesterid = 0;
		loadSemester();
		function loadSemester()
		{
			try{
				var data = ({inputsemesterid:$scope.semesterid})
			
				httprequest('getsemesterdata',data).then(function(response){
					if(response.length > 0 && response != null)
					{
						$scope.semesterlist = response;
						for (var i = 0; i <= response.length -1; i++) {
							if(response[i].status == 'a'){
								$scope.inputCurrentSemester = response[i].id
							}
						}
					}
					else{
						$scope.semesterlist = [];
					}
				})
			}
			catch(ex){}
		}

	     $scope.savesemester = function()
        {
            if($scope.inputSemester.length >= 3)
            {
                var data = ({
                    inputsemestername:$scope.inputSemester,
                    inputsemesterid:parseInt($scope.semesterid)

                })

                httppostrequest('savesemester',data).then(function(response){
                    if(response != null && response.message == true) 
                    {
                    	$scope.semesterid = 0
                    	$scope.inputSemester = ''
                        message('Semester added','show')
                        loadSemester()
                    }
                    else{
                    	message('Semester data not added','show')
                    }
                });
            }
            else{
            	message('Semester name should be three character long','show')
            }
        }

        $scope.editsemester = function(semid)
        {
            try{
				var data = ({inputsemesterid:semid})
			
				httprequest('getsemesterdata',data).then(function(response){
					if(response.length > 0 && response != null)
					{
						$scope.inputSemester = response[0].name;
						$scope.semesterid =response[0].id
					}
					else{
						$scope.inputSemester = '';
					}
				})
			}
			catch(ex){}
        }

        $scope.setCurrentSemester = function(csem)
        {
        	 try{
        	 	$scope.inputCurrentSemester = csem
			 	var data = ({
                    inputsetcurrentsemester:parseInt($scope.inputCurrentSemester)
                })

                httppostrequest('changesemester',data).then(function(response){
                    if(response != null && response.message == true) 
                    {
                        message('Semester set','show')
                    }
                    else{
                    	message('Semester  not set','show')
                    }
                });
			}
			catch(ex){}
        }

        $scope.removesemester = function(sessionid)
        {
            $("#delete_dialog").modal('show');
            $scope.semesterid = sessionid
        }
        
        $(document).on('click','#save',function(){
            $("#delete_dialog").modal('hide');
            var data = ({
                inputsemesterid:$scope.semesterid
            })

           httprequest('removesemester',data).then(function(response){
                if(response != null)
                {
                   message('Semester removed','show')
                   loadSemester()
                   $scope.semesterid = 0
                }else{
            	 	message('Semester not remove','show')
                 
                   $scope.semesterid = 0
                }
            });
        });

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

     
      function httppostrequest(url,data)
        {
            var request = $http({
                method:'POST',
                url:url,
                data:data,
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
	});
</script>
<div class="col-sm-12" ng-controller="scheduleController"
	ng-init="getBaseUrl('<?php echo base_url(); ?>')">
	<div class="panel panel-default">
		<div class="panel-heading">
			<label>Today's Schedule</label>
		</div>
		<div class="panel-body whide" id="ttable"
			ng-init="timetableloaded = false"
			ng-class="{'loader2-background': timetableloaded == false}">
			<div class="loader2" ng-hide="timetableloaded"></div>
			<div ng-hide="!timetableloaded">
				<div id="timetable" style="min-height: 280px;"></div>
			</div>

		</div>
	</div>
</div>



<script data-require="ui-bootstrap@*" data-semver="0.12.1" src="<?php echo  base_url(); ?>js/ui-bootstrap-tpls-0.12.1.min.js"></script>

<script>

app.controller('scheduleController', function($scope, $window, $myUtils, $document, $timeout,$interval){


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
      
      $scope.schoolName = '';
      if($myUtils.getUserLocations().length){
          $scope.schoolName = $myUtils.getUserLocations()[0].schoolname;
      }

      $scope.type = $myUtils.getUserType();

      $scope.scheduleData = null;
      $scope.isDataAvailable = 1;

      $("#ttable").show();

      $scope.getBaseUrl = function(url)
      {
        google.charts.load('current', {'packages':['corechart','timeline','table', 'controls']});
        $scope.baseUrl = url;
        //console.log($scope.baseUrl);
        $scope.getScheduleData();
      }

    $scope.getScheduleData = function()
    {

          var data = {user_id:$scope.user_id,school_id:$scope.school_id};
          
          $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH ?>widget_schedules/data',data).then(function(response){

              if(response.length > 0){
                $scope.timetableloaded = true;
                $scope.scheduleData = response;
                google.charts.setOnLoadCallback($scope.drawTable);
              }
              else{
                $scope.scheduleData = [];
                $scope.timetableloaded = true;
                $("#timetable").html('No  schedule found')
              }
            });
    }

    $scope.drawTable = function()
    {
      $scope.isDataAvailable = null;

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Class Name');
      data.addColumn('string', 'Subject Name');
      data.addColumn('date', 'Start Time');
      data.addColumn('date', 'End Time');

      angular.forEach($scope.scheduleData,function(value, key)
      {
        $scope.isDataAvailable = 1;

        //var sdObj = new Date(value.start_time);
        //var edObj = new Date(value.end_time);

        var sdate = value.start_time.split(":")
        var edate = value.end_time.split(":")
        
        data.addRows([
            [ value.grade +' '+value.section, value.subject+'( '+value.teacher+' )', 
            new Date(0,0,0,sdate[0],sdate[1],0),
            new Date(0,0,0,edate[0],edate[1],0)
            ]
        ]);
        
      });
      

      $('#table_window').css('display','block');
      $('#noDataMessage2').css('display','none');
      $("#timetable").html('')
      var table = new google.visualization.Timeline(document.getElementById('timetable'));
      table.draw(data, {width: '100%',height:'100%'});//, height: '300px'

      if($scope.isDataAvailable == null)
      {
        $('#table_window').css('display','none');
        $('#noDataMessage2').css('display','block');
      }
      
    }

  });
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
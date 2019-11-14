<div class="col-lg-12" ng-controller="scheduleController" ng-init="getBaseUrl('<?php echo base_url(); ?>')">
    <div class="panel panel-default">
        <div class="panel-heading">
            <label>Today's Schedule</label>
        </div>
        <div class="panel-body whide" id="ttable" style="height: 200px;" ng-init="timetableloaded = false" ng-class="{'loader2-background': timetableloaded == false}">
            <div class="loader2" ng-hide="timetableloaded"></div>
            <div ng-hide="!timetableloaded">
                <div id="timetable" ng-hide="scheduleData.length  <= 0" style="min-height:280px;"></div>
            </div>
             <div  ng-hide="scheduleData.length  > 0" >
              <p class="text-center">Your timetable is not yet configured.</p>
            </div>
        </div>
    </div>
</div>
<script>
  app.controller('scheduleController', function($scope, $window, $http, $document, $timeout){

    $scope.scheduleData = [];
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
      $scope.result = $http.get('dashboardschedule',({})).then(function(response){
          
          if(response.data.length > 0){

          $scope.scheduleData = response.data;
            $scope.timetableloaded = true;
            google.charts.setOnLoadCallback($scope.drawTable);
          }
          else{
            $scope.timetableloaded = true;
            $scope.scheduleData = [];
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

        var sdate = value.start_time.split(":")
        var edate = value.end_time.split(":")
        data.addRows([
            [ 'Timetable', value.grade +' '+value.section_name + '('+value.subject_name+')',  new Date(0,0,0,sdate[0],sdate[1],0) , new Date(0,0,0,edate[0],edate[1],0)]
        ]);

      });


      $('#table_window').css('display','block');
      $('#noDataMessage2').css('display','none');

       var options = {
        
        width: '100%',height:'200'
      };

      var table = new google.visualization.Timeline(document.getElementById('timetable'));
      table.draw(data, options);//, height: '300px'

      if($scope.isDataAvailable == null)
      {
        $('#table_window').css('display','none');
        $('#noDataMessage2').css('display','block');
      }
    }




  });
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="col-lg-12" ng-controller="scheduleController" ng-init="getBaseUrl('<?php echo base_url(); ?>')">
  <div class="panel panel-default">
      <div class="panel-heading">
        <label>Learning InVantage guidelines</label>
      </div>
      <div class="panel-body" >
          <p class="guidelines-heading">To use Learning InVantage you need to do following steps in sequence.</p>
          <ul class="guidelines">
         
            <li>
              <p>If you are using Learning InVantage for first time please add a new city. If you already have added city to Learning InVantage then you can use this link to <a href="<?php echo $path_url; ?>setting" title="View locations" alt="View locations">view</a> them.</p>
            </li>
            <li>
              <p>If you are going to a new school for first time then you have to add relevant city before adding a new school. If you already have added school to Learning InVantage then you can use this link to <a href="<?php echo $path_url; ?>setting" title="View schools" alt="View schools">view</a> them.</p>
            </li>
            <li>
              <p>If you are going to a principal for first time then you have to add relevant city and school before adding a principal. If you already have added principal to Learning InVantage then you can use this link to <a href="<?php echo $path_url; ?>show_prinicpal_list" title="View principal" alt="View principal">view</a> them or add them using this link <a href="<?php echo $path_url; ?>add_Prinicpal" title="Add principal" alt="Add principal">Add</a>.</p>
            </li>
          </ul>
      </div>
  </div>
</div>

<script>

    app.controller('scheduleController',['$scope','$myUtils', scheduleController]);

    function scheduleController($scope, $myUtils) {

        $scope.isPrincipal = false;
        $scope.isTeacher = false;
        $scope.isAdmin = false;

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

    $scope.scheduleData = null;
    $scope.isDataAvailable = 1;


    $scope.getBaseUrl = function(url)
    {
      google.charts.load('current', {'packages':['corechart','timeline','table', 'controls']});
      $scope.baseUrl = url;
      //console.log($scope.baseUrl);
      //$scope.getScheduleData();
    }

    $scope.getScheduleData = function()
    {
      $scope.result = $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>dashboardschedule',({})).then(function(response){

          if(response.data.length > 0){

            $scope.scheduleData = response.data;
            google.charts.setOnLoadCallback($scope.drawTable);
          } 
          else{
            $("#timetable").html('No data found')
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
            [ value.grade +' '+value.section_name, value.subject_name+'( '+value.screenname+' )',  new Date(0,0,0,sdate[0],sdate[1],0) , new Date(0,0,0,edate[0],edate[1],0)]
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
  


  }

</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
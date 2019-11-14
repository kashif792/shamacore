var app = angular.module('invantage', ['mwl.calendar', 'ui.bootstrap']);
app.controller('scheduleController', function($scope, $http, $interval) {
    $scope.filters={};//Filters
    $scope.ct_CHKER=0;//a kind of counter  
            $scope.slist = []
    $scope.filters.ChartType="Tabular";////default filter caption 
    $scope.DataVariable=[];   // Variable Filters
    $scope.ChartOptions=[];   // Chart Options
    $scope.devices=[];        //Devices
    $scope.widgetinfo={};
    var eventDates ={
            eventstart :'',
            eventend :''
        }
        
            //function to load chart options
            $scope.loadChartOptions=function(value)
            {
                $scope.ChartOptions=value;
            }
             
            //function to change view of chart. Columns to include
            $scope.ChangeView=function(value)
            {
                $scope.chartObject.view=value;
            }

            //function to change variable type of filter
            $scope.changeVariable=function(value)
            {
            
                $scope.filters.varType=value;
            }

            $scope.changeDevice=function (value,func,param)
            {
               
              if($scope.chartObject.type=="Gauge" && value=='All')
              {
                $scope.filters.defaultDevice=$scope.filters.devices[1].device;
              }
              else
              {

                $scope.filters.defaultDevice=value;
                
              }
              $scope.call=func(param);
                
            }

            $scope.DataVariable =   
            [
                {variable : "All Variable",cols:{columns: [0, 1, 2, 3]}},
                {variable : "Energy",cols:{columns: [0, 1]}},
                {variable : "Gas",cols:{columns: [0, 2]}},
                {variable : "Water",cols:{columns: [0, 3]}}
            ];
            $scope.defaultVariable="All Variable";

            $scope.loadChartOptions([
                {opt : "Table", Title:"Tabular"},
                {opt : "ColumnChart", Title:"Column Chart"},
                {opt : "PieChart", Title:"Pie Chart"},
                {opt : "BarChart", Title:"Bar Chart"},
                {opt : "LineChart", Title:"Line Chart"},
                {opt : "AreaChart", Title:"Area Chart"},
                {opt : "ScatterChart", Title:"Scatter Chart"}, 
            ]);
        
        //dummy data
      $scope.c_History=
          [ {"building":1, "name":"Building 1", "Energy":100,"Gas":600,"Water":100},
            { "building":2, "name":"Building 2","Energy":200,"Gas":400,"Water":150},
            { "building":3, "name":"Building 3","Energy":400,"Gas":800,"Water":300},
            { "building":4, "name":"Building 4","Energy":800,"Gas":400,"Water":200},
        ];
        
        //chart object
        $scope.chartObject = {
        "type": 'ColumnChart',
        "displayed": false,
        "formatters": {},  
        }

        //load chart based on value, this function will load chart for different widgets
        $scope.loadChart=function(value)
        {

      
          $scope.widgetinfo.widgetid=value;
          if($scope.ct_CHKER>0)//if chart is already loaded. Prevents looping of function
            {
                return null;
            }
            $scope.ct_CHKER++;
            $scope.filters.varType=$scope.defaultVariable;
            
            if(value==0)//dss widget 0
            {

              //chart options  
              $scope.chartObject.options=
                {
                    "title": "Total Consumption",
                    "isStacked": "false",
                    "fill": 20,
                    "displayExactValues": true,
                    "vAxis": {"gridlines": {"count": 10},
                    "animation": {duration: 1500,easing: 'linear',startup: true}
                },
                "hAxis": {"title": "Building"},legend: { position: 'bottom' }
              }; 
              //constructing chart data
                $scope.chartObject.data=[['Building', 'Energy (Kwh)', 'Gas(BTU/SCF)','Water(GAL)']]; 
                angular.forEach($scope.c_History, function (building, index){
                        $scope.chartObject.data.push([building.name,building.Energy, building.Gas,building.Water]);
                    });    
            }
            else if(value==1)//if dss widget 1
            {
            //chart options
            $scope.chartObject.options=
                {
                    "title": "Cost of Consumption",
                    "isStacked": "false",
                    "fill": 20,
                    "displayExactValues": true,
                    "vAxis": {"gridlines": {"count": 10},
                    "animation": {duration: 1500,easing: 'linear',startup: true}
                },
                "hAxis": {"title": "Building"},legend: { position: 'bottom' }
              };
              //constructing chart data
            $scope.chartObject.data=[['Building', 'Energy $', 'Gas $','Water $  ']]; 
                    angular.forEach($scope.c_History, function (building, index) {
                       $scope.chartObject.data.push([building.name,building.Energy*9.156, building.Gas*5.156774,building.Water*3.1567]);
                    });

            }    
             else if(value==2) //if dss widget 2
            {
                $scope.filters.devices = [{device : "All"},{device : "D00001"},{device : "OPC2"}];
                $scope.filters.defaultDevice='All';


              // overriding filter variables
                $scope.DataVariable = 
                [
                    {variable : "All Variable",cols:{columns: [0, 1, 2, 3]}},
                    {variable : "Setpoint",cols:{columns: [0,1]}},
                    {variable : "Output",cols:{columns: [0,2]}},
                    {variable : "Process",cols:{columns: [0,3]}}
                ];

                //overriding Chart Options
                $scope.loadChartOptions([
                    {opt : "Table", Title:"Tabular"},
                    {opt : "ColumnChart", Title:"Column Chart"},
                    {opt : "BarChart", Title:"Bar Chart"},
                    {opt : "LineChart", Title:"Line Chart"},
                    {opt : "AreaChart", Title:"Area Chart"},
                    {opt : "ScatterChart", Title:"Scatter Chart"}

                    
                    
                ]);



                //override default chart type
                $scope.chartObject.type='Gauge';
                $scope.filters.defaultDevice=$scope.filters.devices[1].device;
                //override chart options 
                $scope.chartObject.options = {
                    width:'100%',
                    redFrom: 55, redTo: 100,
                    yellowFrom:45, yellowTo: 55,
                    minorTicks: 5,
                    majorTicks:[0,10,20,30,40,50,60,70],
                    max:70,
                    animation: {duration: 500,easing: 'ease',startup: true}
                  };
                //load the chart - realtime
                  $scope.chartObject.view={columns:[0,1,2,3]};
                $scope.loadGuages(1);


                //start the realtime timer
                $interval($scope.Starttimer, 10000); 
           }

          else if(value==3)//dss widget 0
            {
               $scope.filters.devices = [{device : "D00001"},{device : "OPC2"}];
                $scope.filters.defaultDevice=$scope.filters.devices[0].device;
              
              $scope.chartObject.type='AnnotationChart';
              //chart options  
              $scope.loadChartOptions([
                    {opt : "Table", Title:"Tabular"},
                    {opt : "ColumnChart", Title:"Column Chart"},
                    {opt : "AreaChart", Title:"Area Chart"},
                    {opt : "AnnotationChart", Title:"Annotation Chart"}
                    
                ]);
               $scope.DataVariable = 
                [{variable : "All Variable",cols:{columns: [4, 1, 2, 3]}},
                    {variable : "Setpoint",cols:{columns: [4,1]}},
                    {variable : "Output",cols:{columns: [4,2]}},
                    {variable : "Process",cols:{columns: [4,3]}}
                    ];
              $scope.chartObject.options=
                {
                    "title": "Total Consumption",
                    "isStacked": "false",
                    "fill": 20,
                    "displayExactValues": true,
                    "vAxis": {"gridlines": {"count": 10},
                    "animation": {duration: 1500,easing: 'linear',startup: true}
                },
                "hAxis": {"title": "Building"},
                zoomStartTime: new Date((new Date()).getTime() - 1/24 * 24 * 60 * 60 * 1000) 
              }; 
           
              
                      $http.get("http://zilonlahore/invantage/wc/control_invantage/v1/application/views/ci/dss-api.php?param=status&value="+$scope.filters.defaultDevice+"&datefrom=20 apr 2016&dateto=21 apr 2016").then(function (response) {
                        $scope.chartObject.data=[
                       ['device', 'setpoint', 'Output', 'Process', 'time_stamp']];
                       // [response.data[0].opcID,response.data[0].setpoint,response.data[0].output,response.data[0].process,response.data[0].time_stamp]];
                    angular.forEach(response.data, function (data, index){
                     
                      $scope.chartObject.data.push([data.opcID,data.setpoint,data.output,data.process,new Date(data.time_stamp)]);  
                    })
                  });

                      $scope.chartObject.view={columns:[4,1,2,3]};
              $interval($scope.Starttimer, 10000);  
                     
            }

        }//end of load function
      
      /*
       * ---------------------------------------------------------
       *   Show date picker
       * ---------------------------------------------------------
       */
      $("#alarm_event_date_widget").click(function(){
        
        $(this).hide();
        $(document).find(".widget-date-picker-container").show("slow");
        return false;
      });

      /*
       * ---------------------------------------------------------
       *   Hide date picker
       * ---------------------------------------------------------
       */
      $("#alarm_event_date_cancel").click(function(){
        $(document).find(".widget-date-picker-container").hide("slow");
        $("#alarm_event_date_widget").show();
        return false;
      });     
    getEventsByTime();
   function getEventsByTime()
    {
        var bdate = new Date();
        var edate = new Date();
        bdate.setDate(bdate.getDate()-1);
        var startdate = bdate.getMonth() + 1 + "/"+bdate.getDate() + "/" + bdate.getFullYear();
        var starttime = bdate.getHours() + ":"+bdate.getMinutes() + ":" + bdate.getSeconds();
        var enddate = edate.getMonth() + 1 + "/"+edate.getDate() + "/" + edate.getFullYear();
        var endtime = edate.getHours()  + ":"+edate.getMinutes() + ":" + edate.getSeconds();
        var seventtime = startdate+" "+starttime;
        var eeventtime = enddate+" "+endtime;
        eventDates ={
            eventstart :seventtime,
            eventend :eeventtime
        }
        $scope.inputdate = eventDates.eventstart+" - "+eventDates.eventend;
    }
    setAlramEventWidgetDateTime(eventDates.eventstart,eventDates.eventend);
    function setAlramEventWidgetDateTime(startdate,enddate) {
        $("#event-widget-start-date-text").text(startdate);
        $("#event-widget-end-date-text").text(enddate);
    }

    setAlramEventWidgetFilterDate(eventDates.eventstart,eventDates.eventend);
    function setAlramEventWidgetFilterDate(startdate,enddate)
    {
        $('input[name="widgetAlarmInputFromDate"]').daterangepicker({ 
            showDropdowns: true,
            timePicker: true,
            timePicker24Hour: true,
            startDate: startdate,
            endDate: enddate,
            linkedCalendars: false,
            locale: {
                format: 'MM/DD/YYYY h:mm'
            }
        });
    }
         $scope.Starttimer=function() { 
          if($scope.widgetinfo.widgetid==3)
          {
           // $scope.loadGuages(2);
          }
          else
          {
          //  $scope.loadGuages(1);
          }
        }
        //load data from database
        $scope.loadGuages=function(value)
            {
             
               if(value==1){
               $scope.temp=$scope.chartObject.view;
               $http.get("http://zilonlahore/invantage/wc/control_invantage/v1/application/views/ci/dss-api.php?param=current_status&value="+$scope.filters.defaultDevice).then(function (response) {
                        
                        $scope.chartObject.data=[
                       ['device', 'setpoint', 'Process', 'Output', 'time_stamp']];
                         // [response.data[0].opcID,response.data[0].setpoint,response.data[0].output,response.data[0].process,response.data[0].time_stamp]];
                        angular.forEach(response.data, function (data, index){
                        $scope.chartObject.data.push([data.opcID,data.setpoint,data.output,data.process,data.time_stamp]);          
                    }); 
                   });
                $scope.chartObject.view=$scope.temp;
             }
             else if (value==2)
             {

              $http.get("http://zilonlahore/invantage/wc/control_invantage/v1/application/views/ci/dss-api.php?param=current_status&value="+$scope.filters.defaultDevice).then(function (response) {
                        
                        angular.forEach(response.data, function (data, index){
                         $scope.chartObject.data.push([data.opcID,data.setpoint,data.output,data.process,new Date(data.time_stamp)]);        
                    }); 
                   });

             }

                
              
            }
        var init = function () {

       // $(".choice").css("position","absolute");
       // $(".choice").css("left","-50000");
       // $(".choice").css("width","100%");
            };
        init();
        
    });//end of app

 $(document).on('click','.dss-widget #user_selecting_data_population_type',function(e){
    var id = $(this).closest(".widget");
    var opt=$(this).attr('data-view');
    if(id.find(".active").attr("id")=="opt"+opt)
      {
        setDevice('opc2');
      }
      else
      {
      id.find(".slideUp").hide();
      //  id.find(".active").removeClass("hide");
      id.find(".slideUp").removeClass("slideUp");
      id.find("#opt"+opt).addClass('slideUp');
      id.find('.view-options span#option-text').text($(this).attr("data-title"));
    }
    e.preventDefault();
  });


 $(document).on('click','.dss-widget .widget-header a',function(e){
    e.preventDefault();
  });



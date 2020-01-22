<div class="col-lg-12" ng-controller="CalendarCtrl" ng-init="calendarfinished=true">

    <script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header" ng-init="is_plan_updating = true">
            <button type="button" class="close" data-dismiss="modal" ng-click="$dismiss()">&times;</button>
            <h5 class="modal-title">
                Event
                <span ng-hide="is_plan_updating">We are updating  lesson plan this might take few minutes.</span>
                <button class="btn btn-success" ng-click="change_enabel_status()" ng-hide="is_edit_enabel">Edit event</button>
                <button class="btn btn-default remove-btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Removing..."  ng-init="deltebutton = 'Delete event';" ng-click="remove_event()" ng-hide="is_delete_enabel">
                    Delete event
                </button>
            </h5>
        </div>
         <div class="modal-body">
                <table class="table table-striped table-hover" ng-hide="!is_view_only">
                    <tr>
                        <th>Title</th>
                        <td>
                           {{holidays.title}}
                        </td>
                    </tr>
                    <tr>
                        <th>Start</th>
                        <td ng-hide="holidays.allDay">
                           {{holidays.start | periodtime1}}
                        </td>
                        <td ng-hide="!holidays.allDay">
                           {{holidays.start | periodtime}}
                        </td>
                    </tr>
                     <tr>
                        <th>End</th>
                        <td ng-hide="holidays.allDay">
                           {{holidays.end | periodtime1}}
                        </td>
                        <td ng-hide="!holidays.allDay">
                           {{holidays.end | periodtime}}
                        </td>
                    </tr>
                    <tr>
                        <th>Apply on semester lesson plan</th>
                        <td>
                           <span ng-if="holidays.apply == 'y'">Yes</span>
                           <span ng-if="holidays.apply == 'n'">No</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Holiday</th>
                        <td>
                           <span ng-if="holidays.is_all_day == true">Yes</span>
                           <span ng-if="holidays.is_all_day == false">No</span>
                        </td>
                    </tr>
                    <tr ng-hide="holidays.event.length == 0">
                        <th>Event Type</th>
                        <td>
                           {{holidays.event[0].title}}
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>
                          {{holidays.description}}
                        </td>
                    </tr>
                </table>
                <form class="form-horizontal" name="form"  ng-submit="save(holidays)" novalidate ng-hide="is_view_only">
                    <input type="hidden" name="serial" ng-model="holidays.serail">
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="inputDescription">Apply on semester lesson plan: <span class="required">*</span></label>
                        <div class="col-sm-7"> 
                            <input type="radio" name="apply" ng-model="holidays.apply" value="y" ng-value="'y'">Yes
                            <input type="radio" name="apply" ng-model="holidays.apply" value="n" ng-value="'n'">No
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="inputDescription">Title: <span class="required">*</span></label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control" ng-model="holidays.title" id="inputtitle" ng-minlength="3" ng-maxlength="256" name="inputtitle" input-title-validation>
                            <div ng-messages="form.inputtitle.$error" style="color: red;">
                                <div ng-message="title_validation">Please enter  3-256 character long description</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="inputDate">Holiday:</label>
                        <div class="col-sm-10">
                            <input type="checkbox" name="" ng-model="holidays.is_all_day" ng-change="updatedate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="inputDate">Date: <span class="required">*</span></label>
                         <div class="col-sm-10">
                            <input date-range-picker id="inputDate" name="inputDate" class="form-control date-picker" 
                            ng-model="holidays.date" clearable="true" type="text" options="options" min="'{{mindate}}'" max="'{{maxdate}}'" input-date-validation/>
                            <div ng-messages="form.inputDate.$error" style="color: red;">
                                <div ng-message="date_validation">Please enter valid date time</div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" ng-hide="holidays.is_all_day">
                        <label class="control-label col-sm-2" for="inputDescription">Type: <span class="required">*</span></label>
                        <div class="col-sm-10"> 
                            <select class="form-control"  ng-options="item.title for item in holidaytypelist track by item.id"  name="inputSection" id="inputSection"  ng-model="holidays.type"></select>  
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="inputDescription">Description: </label>
                        <div class="col-sm-10"> 
                            <textarea class="form-control" ng-model="holidays.description" id="inputDescription" name="inputDescription"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group" > 
                        <div class="col-sm-offset-2 col-sm-10">
                           <button type="button" ng-click="$dismiss()"" class="btn btn-default">Cancel</button>
                            <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."  ng-disabled="form.inputtitle.$invalid ||  is_plan_updating == false"   class="btn btn-primary class-btn">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </script>
        
        <script type="text/ng-template" id="deleteModalInstanceCtrl.html">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" ng-click="$dismiss()">&times;</button>
                <h5 class="modal-title">
                    Delete
                </h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this event?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" ng-click="$dismiss()">No</button>
                <button type="button" id="save" class="btn btn-default " value="save">Yes</button>
            </div>
        </script>


    <div class="panel panel-default ss">
        <div class="panel-heading ss">
            <label>Calendar</label>
        </div>
        <div class="panel-body" ng-class="{'loader2-background': calendarfinished == false}">
            <div class="loader2" ng-hide="calendarfinished" ></div>
            <div class="row" ng-hide="!calendarfinished">
                <div class="col-sm-12">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    	

    app.directive('inputTitleValidation',function(){
        return {
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {
                elm.on('blur',function(e){
                    scope.$apply(function(){
            
                        if (elm.val().length > 3) {
                            ctrl.$setValidity('title_validation', true);
                            return true;
                        }
                        ctrl.$setValidity('title_validation', false);
                        return false;
                    });
                });
            }
        }
    });



    app.directive('inputDateValidation',function(){
        return {
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {
                elm.on('blur',function(e){
                    scope.$apply(function(){
                        if (elm.val().length == 0) {
                            ctrl.$setValidity('date_validation', false);
                            return false;
                        }
                        ctrl.$setValidity('date_validation', true);
                        return true;
                    });
                });
                elm.on('change',function(e){
                    scope.$apply(function(){
                        if (elm.val().length == 0) {
                            ctrl.$setValidity('date_validation', false);
                            return false;
                        }
                        ctrl.$setValidity('date_validation', true);
                        return true;
                    });
                });
            }
        }
    });

    app.filter('periodtime', function myDateFormat($filter){
        return function(text){
            var  tempdate= new Date(text);
            return $filter('date')(tempdate, "mediumDate");
        }
    });
    app.filter('periodtime1', function myDateFormat($filter){
        return function(text){
            var  tempdate= new Date(text);
            return $filter('date')(tempdate, "medium");
        }
    });

    app.controller('ModalInstanceCtrl', ['$scope', '$modalInstance', function ($scope, $modalInstance) {
        $scope.ok = function () {
            $modalInstance.close('this is result for close');
        };

        $scope.cancel = function () {
            $modalInstance.dismiss('this is result for dismiss');
        };
    }]);

    app.controller('deleteModalInstanceCtrl', ['$scope', '$modalInstance', function ($scope, $modalInstance) {
        $scope.ok = function () {
            $scope.holidays.serial = '';
            $modalInstance.close('this is result for close');
        };

        $scope.cancel = function () {
            $scope.holidays.serial = '';
            $modalInstance.dismiss('this is result for dismiss');
        };
    }]);



    app.controller('CalendarCtrl', ['$scope','$myUtils','$filter','$modal', CalendarCtrl]);

    function CalendarCtrl ($scope,$myUtils,$filter,$modal) {


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

    	var urlist = ({
        	saveholiday:'<?php echo SHAMA_CORE_API_PATH; ?>holiday',
        	removeholiday:'<?php echo SHAMA_CORE_API_PATH; ?>holiday',
        	getholidaydetail:'<?php echo SHAMA_CORE_API_PATH; ?>holiday',
        	getholidaylist:'<?php echo SHAMA_CORE_API_PATH; ?>holidays',
        	saveholidaytype:'<?php echo SHAMA_CORE_API_PATH; ?>holiday_type',
        	removeholidaytype:'<?php echo SHAMA_CORE_API_PATH; ?>holiday_type',
        	getholidaytypedetail:'<?php echo SHAMA_CORE_API_PATH; ?>holiday_type',
        	getholidaytypelist:'<?php echo SHAMA_CORE_API_PATH; ?>holiday_types',
        	});
    	
        $scope.openModal = function()
        {
            $scope.theModal =  $modal.open({
                templateUrl: 'myModalContent.html',
                controller: 'ModalInstanceCtrl',
                scope: $scope,
            });
            
            $scope.theModal.result.then(
                function (result) {
                    $scope.holidays.serial = '';
                   $scope.resetform();
                },
                function (result) {
                    $scope.holidays.serial = '';
                    $scope.resetform();
                }
            );
        }
    

        $scope.holidays = {};
        $scope.holidaylist = [];
        $scope.oldid = null;

        $scope.is_edit_enabel = true;
        $scope.is_view_only = false;
        $scope.holidays.is_all_day = true;
        $scope.is_delete_enabel = true;
        $scope.holidays.apply = 'y';



        // Initialize default date
        $scope.defaultdate = function()
        {
            try{
                $scope.holidays.date = {
                    startDate:moment(),
                    endDate: moment()
                };
             
                $scope.options = {
                    timePicker: (!$scope.holidays.is_all_day ? true : false),
                    autoApply: true,
                    timePickerIncrement: 5,
                    showDropdowns: true,
                    // "minDate": (!$scope.holidays.is_all_day  ? moment().format('MM/DD/YYYY h:mm A'): moment().format('MM/DD/YYYY')  ) ,
                    // "maxDate": (!$scope.holidays.is_all_day ? moment().add(+5,'y').format('MM/DD/YYYY h:mm A'): moment().add(+5,'y').format('MM/DD/YYYY')  ) ,
                    locale:{format: (!$scope.holidays.is_all_day ? 'MM/DD/YYYY h:mm A': 'MM/DD/YYYY' )},
                    eventHandlers:{
                        'show.daterangepicker': function(ev, picker){
                            $scope.holidays.date = {
                                startDate:moment(),
                                endDate: moment()
                            };
                        },
                        'apply.daterangepicker': function(ev, picker){
                           $scope.holidays.date.startDate = moment( $scope.holidays.date.startDate).format('LLL')
                           $scope.holidays.date.endDate = moment( $scope.holidays.date.endDate).format('LLL')
                        }
                    }
                }
               
            }
            catch(ex)
            {
                console.log(ex)
            }
        }
        $scope.defaultdate(); // set default date

        $scope.updatedate= function()
        {
            $scope.defaultdate();
            //$scope.holidays.date ={}
        }

        $scope.change_enabel_status = function()
        {
            $scope.is_edit_enabel = false;
            $scope.is_view_only = !$scope.is_view_only;
        } 

        $scope.resetform = function()
        {
            $scope.defaultdate();
            $scope.holidays.is_all_day = true;
            $scope.is_edit_enabel = true;
            $scope.is_view_only = false;
  
            $scope.holidays.title = '';
            $scope.holidays.description = '';
            $scope.holidays.apply = 'y';

        }

        var date = new Date();

        var d = date.getDate();

        var m = date.getMonth();
        var y = date.getFullYear();
        
        var events = []

        $scope.renderPopup = function (jsEvent, start, end,calEvent) {
            $(function () {
           var $selectedElmt = $(jsEvent.target);
            var relativeStartDay = start.calendar(null, { lastDay: '[yesterday]', sameDay: '[today]'});
            var endNextDay = '';

            if(relativeStartDay === 'yesterday') {
                endNextDay = '[Today at] ';
            }
            else if(relativeStartDay === 'today') {
                endNextDay = '[Tomorrow at] ';
            }
            else {
                endNextDay = 'dddd ';
            }
                $scope.openModal();
            });
        }
        
        $scope.save = function(holiday)
        {
            try{
                if(holiday.title)
                {
                    //$scope.holidays = {};
                    var $this = $(".class-btn");
                    $this.button('loading');
                    var data = {
                        user_id: $scope.user_id,
                        school_id: $scope.school_id,
                        serial: $scope.holidays.serial,
                        title: $scope.holidays.title,
                        description: $scope.holidays.description,
                        apply: $scope.holidays.apply,
                        is_all_day: $scope.holidays.is_all_day,
                        type_id: $scope.holidays.type!=null?$scope.holidays.type.id : 0,
                        start_date: $scope.holidays.date.startDate,
                        end_date: $scope.holidays.date.endDate
                    }
                    $myUtils.httppostrequest(urlist.saveholiday, data).then(function(response){
                        if(response != null)
                        {
                            getHolidays();
                            $scope.updateObject();
                            $scope.is_plan_updating = false;
                            $scope.theModal.close();
                        }
                        $this.button('reset');
                    });
                }
            }
            catch(e){
                console.log(e)
            }
        }

        $scope.removeevent = function()
        {
            $scope.deleteModal =  $modal.open({
                templateUrl: 'deleteModalContent.html',
                controller: 'deleteModalInstanceCtrl',
                scope: $scope,
            });
        }

        $scope.holidaytypelist = [];
        getHolidaytypes();
        function getHolidaytypes()
        {
            var data = ({school_id:$scope.school_id, user_id:$scope.user_id})
            
            $myUtils.httprequest(urlist.getholidaytypelist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.holidays.type = response[0]
                    $scope.holidaytypelist = response;
                }else{
                   $scope.holidaytypelist = []
                }
            });
        }

        getHolidays();
        function getHolidays()
        {
            $scope.holidaylist = [];

            var data = ({school_id:$scope.school_id, user_id:$scope.user_id})
            
            $myUtils.httprequest(urlist.getholidaylist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.holidaylist = response;
                    $scope.calendarfinished = true;
                    
                }else{
                    createcalendar();
                    $scope.holidaylist = [];
                }
            });
        }

        $scope.createcalendarobj = function()
        {
            try{
                 $scope.$watch(function(){
                    return $scope.holidaylist;
                    },function(newValue ,oldValue){
                        if(newValue != null && newValue.length > 0)
                        {
                            createcalendar();
                        }

                    });
            }
            catch(e){}
           
        }
        $scope.createcalendarobj();

        $scope.updateObject = function()
        {
            try{
                 $scope.$watch(function(){
                return $scope.holidaylist ;
                },function(newValue ,oldValue){
                    if(newValue != null && newValue.length > 0)
                    {
                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('addEventSource', $scope.holidaylist);         
                        $('#calendar').fullCalendar('rerenderEvents' );
                    }else{
                        $('#calendar').fullCalendar('removeEvents');
                        $('#calendar').fullCalendar('addEventSource', $scope.holidaylist);         
                        $('#calendar').fullCalendar('rerenderEvents' );
                    }
                }); 
            }
            catch(e){}
            
        }

        $scope.setModalValues = function(calEvent)
        {

            if(calEvent.serial)
            {
                var is_event_found = $filter('filter')($scope.holidaylist,{serial:calEvent.serial},true);
                
                if(is_event_found.length > 0)
                {
                    $scope.holidays = is_event_found[0];
                    if(calEvent.event.length > 0)
                    {
                        var holiday_type = $filter('filter')($scope.holidaytypelist,{id:calEvent.event[0].id},true);
                        
                        if(holiday_type.length > 0)
                        {
                            $scope.holidays.type = holiday_type[0];
                        }
                    }

                     $scope.holidays.date = {
                        startDate:moment($scope.holidays.start),
                        endDate: moment($scope.holidays.end)
                    };
                }
            }
        }

        $scope.remove_event = function()
        {
            if($scope.holidays)
            {
                try{
                    var data = {
                        slug : $scope.holidays.slug,
                        id : $scope.holidays.serial,
                    }
                     var $this = $(".remove-btn");
                    $this.button('loading');
                    $myUtils.httpdeleterequest(urlist.removeholiday,data).then(function(response){
                        if(typeof response != 'undefined' && response)
                        {
                            getHolidays();
                            $scope.deltebutton = "Delete event";
                            $scope.updateObject();
                            $scope.theModal.close();
                        }
                        
                        $this.button('reset');
                    }); 
                }
                catch(e){}
            }
        }

        
        function createcalendar()
        {
            
            $('#calendar').fullCalendar({
                header: {
                    left: 'title',
                    right: 'prev,next'
                },
                theme: 'jquery-ui',
                timezone: 'local',
                defaultView: 'month',
                allDayDefault: false,
                selectable: true,
                events:$scope.holidaylist,
                 displayEventEnd :true,
                eventClick: function (calEvent, jsEvent) {
                    $scope.setModalValues(calEvent);
                    $scope.is_edit_enabel = false;
                    $scope.is_view_only = true;
                    $scope.is_delete_enabel = false;
                    $scope.holidays.is_all_day = JSON.parse(calEvent.allDay);
                    $scope.renderPopup(jsEvent, calEvent.start, calEvent.end,calEvent);
                },
                eventRender: function(event, element) {
                    // $scope.is_edit_enabel = true;
                    // $scope.is_view_only = true;
                    // if($scope.oldid != event.serial)
                    // {
                    //     // element.append( `<span class='I_delete' ><i class="fa fa-remove fa-2x"></i></span>` );
                    //     // element.append( `<span class='I_edit'><i class="fa fa-edit fa-2x"></i></span>` );
                    //     $scope.oldid = event.serial;
                    // }
                    
                    // element.find(".I_delete").click(function() {});
                    // element.find(".I_edit").click(function() {
                      
                    //     $scope.is_edit_enabel = false;
                    //     $scope.setModalValues(event);
                    //     $scope.holidays.is_all_day = event.allDay;
                    // });
                },
                select: function(start, end, jsEvent) {
                    $scope.is_delete_enabel = true;
                    $scope.is_edit_enabel = true;
                    $scope.is_view_only = false;
                    // if(moment(start).format('L') >= moment().format('L'))
                    // {
                        $scope.holidays.date = {
                            startDate:moment(start.local()),
                            endDate: moment(moment(end.local()).subtract(1,'day'))
                        };
                        $scope.renderPopup(jsEvent, start.local(), end.local());
                    //}
                   
                },
                dayClick: function(date) { 
                    $scope.is_delete_enabel = true;
                     $scope.holidays.date = {
                        startDate:moment(date.toDate()),
                        endDate: moment(date.toDate())
                    };
                }
            });
        }

    }

</script>

<script type="text/javascript" src="<?php echo  base_url(); ?>js/fullcalendar.min.js"></script>
 
<script src="<?php echo base_url();?>js/angular-messages.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fullcalendar.css" />

<style type="text/css">
     .fc-past {
    /*background-color: #E8EEF0 !important;*/
    background-size: 50px 50px;
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    -pie-background: linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent) 0 0/50px 50px #aacc00;
    behavior: url(/pie/PIE.htc);
}
/*                                                              FULLCALENDAR                                */

.fc {
  direction: ltr;
  text-align: left;
  table {
    border-collapse: collapse;
    border-spacing: 0;
  }
}

html .fc {
  font-size: 1em;
}

.fc {
  table {
    font-size: 1em;
  }
  td, th {
    vertical-align: top;
    padding: 0;
  }
}

.fc-header td {
  white-space: nowrap;
}

.fc-header-left {
  width: 25%;
  text-align: left;
}

.fc-header-right {
  width: 25%;
  text-align: right;
}

.fc-header-title {
  display: inline-block;
  vertical-align: top;
  h2 {
    margin-top: 0;
    white-space: nowrap;
    font-family: inherit;
  }
}

.fc .fc-header-space {
  padding-left: 10px;
}

.fc-header {
  .fc-button {
    margin-bottom: 1em;
    vertical-align: top;
    margin-right: -1px;
  }
  .fc-corner-right, .ui-corner-right {
    margin-right: 0;
  }
  .fc-state-hover, .ui-state-hover {
    z-index: 2;
  }
  .fc-state-down {
    z-index: 3;
  }
  .fc-state-active, .ui-state-active {
    z-index: 4;
  }
}

.fc-content {
  clear: both;
  zoom: 1;
}

.fc-view {
  width: 100%;
  overflow: hidden;
}

.fc-widget-header, .fc-widget-content {
  border: 1px solid #ddd;
}

/**          "Today" Color Field for Calendar                    **/

.fc-state-highlight {
  background: #fcf8e3;
}

.fc-cell-overlay {
  background: #bce8f1;
  opacity: .3;
  filter: alpha(opacity = 30);
  -moz-box-shadow: inset 0 0 10px #000000;
  -webkit-box-shadow: inset 0 0 10px #000000;
  box-shadow: inset 0 0 10px #000000;
}

.fc-button {
  position: relative;
  display: inline-block;
  overflow: hidden;
  height: 2.4em;
  line-height: 2.4em;
  white-space: nowrap;
  cursor: pointer;
  font-weight: 700;
  padding: 0 .6em;
}

.fc-state-default {
  border: 1px solid;
  background-color: #f5f5f5;
  background-image: linear-gradient(tobottom, white, #e6e6e6);
  background-repeat: repeat-x;
  color: #333;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  &.fc-corner-left {
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
  }
  &.fc-corner-right {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
  }
}

.fc-text-arrow {
  font-size: 2.4em;
  font-family: "Courier New", Courier, monospace;
  vertical-align: baseline;
  margin: 0 .1em;
}

.fc-button {
  .fc-icon-wrap {
    position: relative;
    float: left;
    top: 50%;
  }
  .ui-icon {
    position: relative;
    float: left;
    margin-top: 0;
    top: -50%;
  }
}

.fc-state-hover, .fc-state-down, .fc-state-active, .fc-state-disabled {
  color: #333;
  background-color: #e6e6e6;
}

.fc-state-hover {
  color: #333;
  text-decoration: none;
  background-position: 0 -15px;
  -webkit-transition: background-position .1s linear;
  -moz-transition: background-position .1s linear;
  -o-transition: background-position .1s linear;
  transition: background-position .1s linear;
}

.fc-state-down, .fc-state-active {
  background-color: #ccc;
  background-image: none;
  outline: 0;
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);
}

.fc-state-disabled {
  cursor: default;
  background-image: none;
  opacity: 0.65;
  filter: alpha(opacity = 65);
  box-shadow: none;
}

.fc-event-container > {
  * {
    z-index: 8;
  }
  .ui-draggable-dragging, .ui-resizable-resizing {
    z-index: 9;
  }
}

.fc-event {
  border: 1px solid #3a87ad;
  background-color: #3a87ad;
  color: #fff;
  font-size: .95em;
  cursor: default;
  padding: 2px 0 2px 4px;
}

a.fc-event {
  text-decoration: none;
  cursor: pointer;
}

.fc-event-draggable {
  cursor: pointer;
}

.fc-rtl .fc-event {
  text-align: right;
}

.fc-event-inner {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.fc-event-time, .fc-event-title {
  padding: 0 1px;
}

.fc .ui-resizable-handle {
  display: block;
  position: absolute;
  z-index: 99999;
  overflow: hidden;
  font-size: 300%;
  line-height: 50%;
}

.fc-event-hori {
  margin-bottom: 1px;
  border-width: 1px 0;
}

.fc-ltr .fc-event-hori.fc-event-start, .fc-rtl .fc-event-hori.fc-event-end {
  border-left-width: 1px;
  border-top-left-radius: 3px;
  border-bottom-left-radius: 3px;
}

.fc-ltr .fc-event-hori.fc-event-end, .fc-rtl .fc-event-hori.fc-event-start {
  border-right-width: 1px;
  border-top-right-radius: 3px;
  border-bottom-right-radius: 3px;
}

.fc-event-hori {
  .ui-resizable-e {
    top: 0!important;
    right: -3px !important;
    width: 7px!important;
    height: 100%!important;
    cursor: e-resize;
  }
  .ui-resizable-w {
    top: 0!important;
    left: -3px !important;
    width: 7px!important;
    height: 100%!important;
    cursor: w-resize;
  }
  .ui-resizable-handle {
    _padding-bottom: 14px;
  }
}

.fc-border-separate {
  th, td {
    border-width: 1px 0 0 1px;
  }
  tr.fc-last {
    th, td {
      border-bottom-width: 1px;
    }
  }
}

.fc .fc-week-number {
  width: 22px;
  text-align: center;
  div {
    padding: 0 2px;
  }
}

.fc-grid {
  .fc-day-number {
    font-size: 1.5em;
    float: left;
    padding: 2px;
  }
  .fc-other-month .fc-day-number {
    opacity: 0.3;
    filter: alpha(opacity = 30);
  }
  .fc-day-content {
    clear: both;
    padding: 2px 2px 1px;
  }
}

.fc-rtl .fc-grid {
  .fc-day-number {
    float: left;
  }
  .fc-event-time {
    float: right;
  }
}

.fc-agenda {
  .fc-agenda-axis {
    width: 50px;
    vertical-align: middle;
    text-align: right;
    white-space: nowrap;
    font-weight: 400;
    padding: 0 4px;
  }
  .fc-day-content {
    padding: 2px 2px 1px;
  }
}

.fc-agenda-days .fc-col0 {
  border-left-width: 0;
}

.fc-agenda-allday .fc-day-content {
  min-height: 40px;
  _height: 40px;
  min-height: 34px;
  _height: 40px;
}

fc-agenda-divider-inner {
  height: 2px;
  overflow: hidden;
}

.fc-widget-header .fc-agenda-divider-inner {
  background: #eee;
}

.fc-agenda-slots {
  th {
    border-width: 1px 1px 0;
  }
  td {
    background: none;
    border-width: 1px 0 0;
    div {
      height: 200px;
    }
  }
  tr.fc-minor {
    th, td {
      border-top-style: dotted;
    }
    th.ui-widget-header {
      border-top-style: solid;
    }
  }
}

.fc-event-vert {
  &.fc-event-start {
    border-top-width: 1px;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
  }
  &.fc-event-end {
    border-bottom-width: 1px;
    border-bottom-left-radius: 3px;
    border-bottom-right-radius: 3px;
  }
  .fc-event-time {
    white-space: nowrap;
    font-size: 10px;
  }
  .fc-event-inner {
    position: relative;
    z-index: 2;
  }
  .fc-event-bg {
    position: absolute;
    z-index: 1;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    opacity: .25;
    filter: alpha(opacity = 25);
  }
}

.fc .ui-draggable-dragging .fc-event-bg, .fc-select-helper .fc-event-bg {
  display: none\9;
}

.fc-event-vert .ui-resizable-s {
  bottom: 0!important;
  width: 100%!important;
  height: 8px!important;
  overflow: hidden!important;
  line-height: 8px!important;
  font-size: 11px!important;
  font-family: monospace;
  text-align: center;
  cursor: s-resize;
}

.fc-agenda .ui-resizable-resizing {
  _overflow: hidden;
}

.fc-header-center, .fc-grid th, .fc-agenda-days th {
  text-align: center;
}

.fc-button-prev .fc-text-arrow, .fc-button-next .fc-text-arrow, .fc-grid .fc-event-time, .fc-agenda .fc-week-number {
  font-weight: 700;
}

#fullcalendar .ui-state-default {
  height: 26px !important;
  margin-left: -40px;
  margin-right: 20px;
  padding: 3px;
  width: 26px !important;
}

table.fc-border-separate, .fc-agenda table {
  border-collapse: separate;
}

.fc-border-separate {
  th.fc-last, td.fc-last {
    border-right-width: 1px;
  }
}

.fc-agenda-days .fc-agenda-axis {
  border-right-width: 1px;
}

.fc-border-separate tbody tr.fc-first {
  td, th {
    border-top-width: 0;
  }
}

.fc-agenda-slots tr.fc-slot0 {
  th, td {
    border-top-width: 0;
  }
}

.fc-agenda-allday th, .fc-event-vert {
  border-width: 0 1px;
}

.fc-view-month {
  .fc-past {
    background-color: #E8EEF0 !important;
    background-size: 50px 50px;
    background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
    -pie-background: linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent) 0 0 / 50px 50px #aacc00;
    behavior: url(/pie/PIE.htc);
  }
  .fc-future! {}
}

.fc-agendaList {
  list-style: none;
  margin: 0;
  padding: 0;
  border: 1px solid #E0E0E0;
  border-bottom: none;
}

.fc-agendaList-dayHeader {
  margin: 0;
  background-color: #F0F0F0;
  border-bottom: 1px solid #E0E0E0;
  padding: 8px;
  overflow: hidden;
}

.fc-agendaList-day, .fc-agendaList-date {
  margin: 0;
  font-size: 14px;
  line-height: 20px;
  display: block;
}

.fc-agendaList-day {
  font-weight: bold;
  color: #404040;
  float: left;
}

.fc-agendaList-date {
  color: #707070;
  float: right;
}

.fc-agendaList-item {
  border-bottom: 1px solid #E0E0E0;
  margin-left: 0;
  padding-left: 10px;
}

.fc-agendaList-event {
  display: block;
  border-left: 4px solid #FFF;
  padding: 8px;
  margin: 1px;
}
 Event Link */

a.fc-agendaList-event {
  text-decoration: none;
  &:hover {
    background-color: #F8F8F8;
  }
  .fc-event-title {
    color: #4B66A7;
    text-decoration: underline;
  }
}

.fc-apex-events-gcal {
  border-color: #5284C1;
}

.fc-apex-events-default01, .fc-apex-events-default02, .fc-apex-events-default03, .fc-apex-events-default04, .fc-apex-events-gcal {
  border-color: #C11E21;
}

.fc-event-time {
  display: inline-block;
  vertical-align: top;
  width: 15%;
  margin-right: 8px;
}

.fc-event-start-time, .fc-event-end-time {
  display: block;
}

.fc-event-start-time, .fc-event-all-day {
  font-size: 14px;
  line-height: 20px;
  color: #404040;
}

.fc-event-end-time {
  font-size: 12px;
  line-height: 16px;
  color: #A0A0A0;
}

.fc-agendaList-eventDetails {
  display: inline-block;
  vertical-align: top;
}

.fc-eventlist-title {
  font-weight: bold;
  font-size: 14px;
  line-height: 20px;
  color: #404040;
}

.fc-eventlist-desc {
  font-size: 12px;
  line-height: 16px;
  color: #707070;
}

.fc-view-month .fc-event-time {
  display: none;
}

@media (max-width: 760px) {
  .fc-event {
    font-size: .80em;
    padding: 1px 0 1px 2px;
  }
}

@media (max-width: 660px) {
  .fc-event {
    font-size: .70em;
    padding: 0 0 0 2px;
  }
}

@media (max-width: 600px) {
  .fc-event {
    font-size: .60em;
    padding: 0;
  }
}

/*  Settings for events calendar  */

.events-calendar {
  .fc-body {
    background-color: #E0E0E0;
    font-family: Arial, sans-serif;
  }
  .fc-list-container {
    border: 1px solid #CCC;
    margin: 20px;
    padding: 20px;
    background-color: #FFF;
  }
  .fc-agendaList {
    list-style: none;
    margin: 0;
    padding: 0;
    border: 1px solid #E0E0E0;
    border-bottom: none;
  }
  .fc-agendaList-dayHeader {
    background-color: #F0F0F0;
    border-bottom: 1px solid #E0E0E0;
    padding: 8px;
    overflow: hidden;
  }
  .fc-agendaList-day, .fc-agendaList-date {
    font-size: 14px;
    line-height: 20px;
    display: block;
  }
  .fc-agendaList-day {
    font-weight: bold;
    color: #404040;
    float: left;
  }
  .fc-agendaList-date {
    color: #707070;
    float: right;
  }
  .fc-agendaList-item {
    border-bottom: 1px solid #E0E0E0;
  }
  .fc-agendaList-event {
    display: block;
    border-left: 4px solid #FFF;
    padding: 8px;
    margin: 1px;
  }
  a.fc-agendaList-event {
    text-decoration: none;
    border-color: #5284C1;
    &:hover {
      background-color: #F8F8F8;
    }
    .fc-event-title {
      color: #4B66A7;
      text-decoration: underline;
    }
  }
  .fc-view-month .fc-event-time {
    display: none;
  }
  .fc-event-start-time, .fc-event-end-time {
    display: block;
  }
  .fc-event-start-time, .fc-event-all-day {
    font-size: 14px;
    line-height: 20px;
    color: #404040;
  }
  .fc-event-end-time {
    font-size: 12px;
    line-height: 16px;
    color: #A0A0A0;
  }
  .fc-agendaList-eventDetails {
    display: inline-block;
    vertical-align: top;
  }
  .fc-eventlist-title {
    font-weight: bold;
    font-size: 14px;
    line-height: 20px;
    color: #404040;
  }
  .fc-eventlist-desc {
    font-size: 12px;
    line-height: 16px;
    color: #707070;
  }
}

/* Event Link */

/*  Colors for events  */

.holidaysevents {
  background: #9D25F8;
  color: #fff;
  box-shadow: -2px -2px 10px rgba(0, 0, 0, 0.25) inset, 2px 2px 10px white inset;
  border: none;
}

.wsubmesevents {
  background: #15BAD3;
  color: #fff;
  box-shadow: -2px -2px 10px rgba(0, 0, 0, 0.25) inset, 2px 2px 10px white inset;
  border: none;
}

.bmesevents {
  background: #ffa500;
  color: #fff;
  box-shadow: -2px -2px 10px rgba(0, 0, 0, 0.25) inset, 2px 2px 10px white inset;
  border: none;
}

/*                                                              jVFloat                                     */

/*                                                              qTip2                                   */

/* qTip2 v2.0.1-257 basic css3 | qtip2.com | Licensed MIT, GPL | Thu Nov 21 2013 21:15:09 */

.qtip {
  position: absolute;
  left: -28000px;
  top: -28000px;
  display: none;
  max-width: 500px;
  min-width: 50px;
  font-size: 10.5px;
  line-height: 12px;
  direction: ltr;
  box-shadow: none;
  padding: 0;
}

.qtip-content {
  position: relative;
  padding: 5px 9px;
  overflow: hidden;
  text-align: left;
  word-wrap: break-word;
}

.qtip-titlebar {
  position: relative;
  padding: 5px 35px 5px 10px;
  overflow: hidden;
  border-width: 0 0 1px;
  font-weight: 700;
  + .qtip-content {
    border-top-width: 0!important;
  }
}

.qtip-close {
  position: absolute;
  right: -9px;
  top: -9px;
  cursor: pointer;
  outline: medium none;
  border-width: 1px;
  border-style: solid;
  border-color: transparent;
}

.qtip-titlebar .qtip-close {
  right: 4px;
  top: 50%;
  margin-top: -9px;
}

* html .qtip-titlebar .qtip-close {
  top: 16px;
}

.qtip-titlebar .ui-icon {
  display: block;
  text-indent: -1000em;
  direction: ltr;
}

.qtip-icon {
  .ui-icon {
    display: block;
    text-indent: -1000em;
    direction: ltr;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    text-decoration: none;
    width: 18px;
    height: 14px;
    line-height: 14px;
    text-align: center;
    text-indent: 0;
    font: 400 bold 10px / 13px Tahoma, sans-serif;
    color: inherit;
    background: transparent none no-repeat -100em -100em;
  }
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  text-decoration: none;
}

.qtip-focus!, .qtip-hover! {}

.qtip-default {
  border-width: 1px;
  border-style: solid;
  border-color: #F1D031;
  background-color: #FFFFA3;
  color: #555;
  .qtip-titlebar {
    background-color: #FFEF93;
  }
  .qtip-icon {
    border-color: #CCC;
    background: #F1F1F1;
    color: #777;
  }
  .qtip-titlebar .qtip-close {
    border-color: #AAA;
    color: #111;
  }
}

.qtip-light {
  background-color: #fff;
  border-color: #E2E2E2;
  color: #454545;
  .qtip-titlebar {
    background-color: #f1f1f1;
  }
}

.qtip-dark {
  background-color: #505050;
  border-color: #303030;
  color: #f3f3f3;
  .qtip-titlebar {
    background-color: #404040;
  }
  .qtip-icon {
    border-color: #444;
  }
  .qtip-titlebar .ui-state-hover {
    border-color: #303030;
  }
}

.qtip-cream {
  background-color: #FBF7AA;
  border-color: #F9E98E;
  color: #A27D35;
  .qtip-titlebar {
    background-color: #F0DE7D;
  }
  .qtip-close .qtip-icon {
    background-position: -82px 0;
  }
}

.qtip-red {
  background-color: #F78B83;
  border-color: #D95252;
  color: #912323;
  .qtip-titlebar {
    background-color: #F06D65;
  }
  .qtip-close .qtip-icon {
    background-position: -102px 0;
  }
  .qtip-icon, .qtip-titlebar .ui-state-hover {
    border-color: #D95252;
  }
}

.qtip-green {
  background-color: #CAED9E;
  border-color: #90D93F;
  color: #3F6219;
  .qtip-titlebar {
    background-color: #B0DE78;
  }
  .qtip-close .qtip-icon {
    background-position: -42px 0;
  }
}

.qtip-blue {
  background-color: #E5F6FE;
  border-color: #ADD9ED;
  color: #5E99BD;
  .qtip-titlebar {
    background-color: #D0E9F5;
  }
  .qtip-close .qtip-icon {
    background-position: -2px 0;
  }
}

.qtip-shadow {
  -webkit-box-shadow: 1px 1px 3px 1px rgba(0, 0, 0, 0.15);
  -moz-box-shadow: 1px 1px 3px 1px rgba(0, 0, 0, 0.15);
  box-shadow: 1px 1px 3px 1px rgba(0, 0, 0, 0.15);
}

.qtip-rounded, .qtip-tipsy, .qtip-bootstrap {
  -moz-border-radius: 5px;
  -webkit-border-radius: 5px;
  border-radius: 5px;
}

.qtip-rounded .qtip-titlebar {
  -moz-border-radius: 4px 4px 0 0;
  -webkit-border-radius: 4px 4px 0 0;
  border-radius: 4px 4px 0 0;
}

.qtip-youtube {
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  -webkit-box-shadow: 0 0 3px #333;
  -moz-box-shadow: 0 0 3px #333;
  box-shadow: 0 0 3px #333;
  color: #fff;
  border-width: 0;
  background: #4A4A4A;
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #4a4a4a), color-stop(100%, black));
  background-image: -webkit-linear-gradient(top, #4a4a4a 0, black 100%);
  background-image: -moz-linear-gradient(top, #4a4a4a 0, black 100%);
  background-image: -ms-linear-gradient(top, #4a4a4a 0, black 100%);
  background-image: -o-linear-gradient(top, #4a4a4a 0, black 100%);
  .qtip-titlebar {
    background-color: #4A4A4A;
    background-color: rgba(0, 0, 0, 0);
  }
  .qtip-content {
    padding: .75em;
    font: 12px arial,sans-serif;
    filter: progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#4a4a4a, EndColorStr=#000000);
    -ms-filter: "progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#4a4a4a, EndColorStr=#000000);";
  }
  .qtip-icon {
    border-color: #222;
  }
  .qtip-titlebar .ui-state-hover {
    border-color: #303030;
  }
}

.qtip-jtools {
  background: #232323;
  background: rgba(0, 0, 0, 0.7);
  background-image: -webkit-gradient(linear, left top, left bottom, from(#717171), to(#232323));
  background-image: -moz-linear-gradient(top, #717171, #232323);
  background-image: -webkit-linear-gradient(top, #717171, #232323);
  background-image: -ms-linear-gradient(top, #717171, #232323);
  background-image: -o-linear-gradient(top, #717171, #232323);
  border: 2px solid #ddd;
  border: 2px solid rgba(241, 241, 241, 1);
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  -webkit-box-shadow: 0 0 12px #333;
  -moz-box-shadow: 0 0 12px #333;
  box-shadow: 0 0 12px #333;
  .qtip-titlebar {
    background-color: transparent;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#717171, endColorstr=#4A4A4A);
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#717171, endColorstr=#4A4A4A)";
  }
  .qtip-content {
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#4A4A4A, endColorstr=#232323);
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#4A4A4A, endColorstr=#232323)";
  }
  .qtip-titlebar, .qtip-content {
    background: transparent;
    color: #fff;
    border: 0 dashed transparent;
  }
  .qtip-icon {
    border-color: #555;
  }
  .qtip-titlebar .ui-state-hover {
    border-color: #333;
  }
}

.qtip-cluetip {
  -webkit-box-shadow: 4px 4px 5px rgba(0, 0, 0, 0.4);
  -moz-box-shadow: 4px 4px 5px rgba(0, 0, 0, 0.4);
  box-shadow: 4px 4px 5px rgba(0, 0, 0, 0.4);
  background-color: #D9D9C2;
  color: #111;
  border: 0 dashed transparent;
  .qtip-titlebar {
    background-color: #87876A;
    color: #fff;
    border: 0 dashed transparent;
  }
  .qtip-icon {
    border-color: #808064;
  }
  .qtip-titlebar .ui-state-hover {
    border-color: #696952;
    color: #696952;
  }
}

.qtip-tipsy {
  background: #000;
  background: rgba(0, 0, 0, 0.87);
  color: #fff;
  border: 0 solid transparent;
  font-size: 11px;
  font-family: 'Lucida Grande',sans-serif;
  font-weight: 700;
  line-height: 16px;
  text-shadow: 0 1px #000;
  .qtip-titlebar {
    padding: 6px 35px 0 10px;
    background-color: transparent;
  }
  .qtip-content {
    padding: 6px 10px;
  }
  .qtip-icon {
    border-color: #222;
    text-shadow: none;
  }
  .qtip-titlebar .ui-state-hover {
    border-color: #303030;
  }
}

.qtip-tipped {
  border: 3px solid #959FA9;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  background-color: #F9F9F9;
  color: #454545;
  font-weight: 400;
  font-family: serif;
  .qtip-titlebar {
    border-bottom-width: 0;
    color: #fff;
    background: #3A79B8;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#3a79b8), to(#2e629d));
    background-image: -webkit-linear-gradient(top, #3a79b8, #2e629d);
    background-image: -moz-linear-gradient(top, #3a79b8, #2e629d);
    background-image: -ms-linear-gradient(top, #3a79b8, #2e629d);
    background-image: -o-linear-gradient(top, #3a79b8, #2e629d);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#3A79B8, endColorstr=#2E629D);
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#3A79B8, endColorstr=#2E629D)";
  }
  .qtip-icon {
    border: 2px solid #285589;
    background: #285589;
    .ui-icon {
      background-color: #FBFBFB;
      color: #555;
    }
  }
}

.qtip-bootstrap {
  font-size: 14px;
  line-height: 20px;
  color: #333;
  padding: 1px;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  .qtip-titlebar {
    padding: 8px 14px;
    margin: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 18px;
    background-color: #f7f7f7;
    border-bottom: 1px solid #ebebeb;
    -webkit-border-radius: 5px 5px 0 0;
    -moz-border-radius: 5px 5px 0 0;
    border-radius: 5px 5px 0 0;
    .qtip-close {
      right: 11px;
      top: 45%;
      border-style: none;
    }
  }
  .qtip-content {
    padding: 9px 14px;
  }
  .qtip-icon {
    background: transparent;
    .ui-icon {
      width: auto;
      height: auto;
      float: right;
      font-size: 20px;
      font-weight: 700;
      line-height: 18px;
      color: #000;
      text-shadow: 0 1px 0 #fff;
      opacity: .2;
      filter: alpha(opacity = 20);
      &:hover {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        opacity: .4;
        filter: alpha(opacity = 40);
      }
    }
  }
}

.qtip {
  &:not(.ie9haxors) div {
    &.qtip-content, &.qtip-titlebar {
      filter: none;
      -ms-filter: none;
    }
  }
  .qtip-tip {
    margin: 0 auto;
    overflow: hidden;
    z-index: 10;
  }
}

x:-o-prefocus {
  visibility: hidden;
}

.qtip .qtip-tip {
  visibility: hidden;
  position: absolute;
  color: #123456;
  background: transparent;
  border: 0 dashed transparent;
  .qtip-vml {
    position: absolute;
    color: #123456;
    background: transparent;
    border: 0 dashed transparent;
  }
  canvas {
    position: absolute;
    color: #123456;
    background: transparent;
    border: 0 dashed transparent;
    top: 0;
    left: 0;
  }
  .qtip-vml {
    behavior: url(#default#VML);
    display: inline-block;
    visibility: visible;
  }
}

#qtip-overlay {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  &.blurs {
    cursor: pointer;
  }
  div {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: #000;
    opacity: .8;
    filter: alpha(opacity = 80);
    -ms-filter: "alpha(Opacity=80)";
  }
}

.qtipmodal-ie6fix {
  position: absolute!important;
}

.qtip-events, .qtip-about {
  width: 300px;
  .qtip-content {
    max-height: 200px;
    overflow-x: hidden;
    overflow-y: auto;
  }
}

.qtip-custom {
  padding: 5px;
  font-size: 13px;
}

#datepicker {
  position: relative !important;
  z-index: 9 !important;
  padding: 5px;
  width: 20%;
}

.datepicker-wrapper {
  margin: 8px 0 0 5px;
  input {
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border linear .2s,box-shadow linear .2s;
    -moz-transition: border linear .2s,box-shadow linear .2s;
    -o-transition: border linear .2s,box-shadow linear .2s;
    transition: border linear .2s,box-shadow linear .2s;
    &:focus {
      border-color: rgba(82, 168, 236, 0.8);
      outline: 0;
      outline: thin dotted \9;
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
      -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);
    }
  }
}

#date_picker {
  z-index: 99999999999999 !important;
}
</style>

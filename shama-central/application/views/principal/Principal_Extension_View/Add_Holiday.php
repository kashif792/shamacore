<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10 col-md-10 col-lg-10 class-page "  ng-controller="holidays_ctrl">
    <?php
        // require_footer
        require APPPATH.'views/__layout/filterlayout.php';
    ?>
    <div class="modal fade" id="MyModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">Remove Holiday</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete this holiday?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" ng-click="removeelement()">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <!-- widget title -->
                    <div class="panel-heading">
                        <label>Holidays</label>
                        <button class="btn btn-primary" ng-click="toogleform(is_form_toggle)">Add Holiday</button>
                    </div>
                    <div class="panel-body">
                        <div class="row" ng-hide="is_form_toggle">
                            <div class="col-sm-12">
                                <form class="searchform">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                                            <input type="text" class="form-control" placeholder="Search holiday" ng-model="inputholidays">
                                        </div>      
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="form-container" ng-hide="!is_form_toggle">
                            <div class="row error-message" ng-hide="holidaytypelist.length > 0">
                                <div class="col-sm-12">
                                   <p>
                                        Please first add holiday types before adding new holiday.
                                        <a href="<?php echo $path_url; ?>setting">Settings</a>
                                    </p>
                                </div>
                            </div>
                            <form class="form-horizontal" name="form"  ng-submit="save(holidays)" novalidate>
                                <input type="hidden" name="serial" ng-model="holidays.serail">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="inputDate">Date: <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        <input date-range-picker id="inputDate" name="inputDate" class="form-control date-picker" 
                                        ng-model="holidays.date" clearable="true" type="text" options="options" input-date-validation/>
                                        <div ng-messages="form.inputDate.$error" style="color: red;">
                                            <div ng-message="date_validation">Please enter valid date time</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="inputDescription">Description: <span class="required">*</span></label>
                                    <div class="col-sm-10"> 
                                        <input type="text" class="form-control" ng-model="holidays.description" id="inputDescription" name="inputDescription" input-title-validation>
                                        <div ng-messages="form.inputDescription.$error" style="color: red;">
                                            <div ng-message="title_validation">Please enter at-least 3 character long description</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="inputDescription">Type: <span class="required">*</span></label>
                                    <div class="col-sm-10"> 
                                        <select class="form-control"  ng-options="item.title for item in holidaytypelist track by item.id"  name="inputSection" id="inputSection"  ng-model="holidays.type"></select>  
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <div class="col-sm-offset-2 col-sm-10">
                                       <button type="button" class="btn btn-default" ng-click="toogleform(is_form_toggle)">Cancel</button>
                                        <button type="submit" ng-init="usersavebtntext = 'Save';"  ng-disabled="form.$invalid || holidaytypelist.length == 0" class="btn btn-primary">
                                            <span ng-show="usersavebtntext == 'Saving'">
                                                <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>
                                            </span>
                                            {{usersavebtntext}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive" ng-hide="is_form_toggle">
                            <table class="table table-bordered table-striped table-hover table-responsive add_holiday" id="table-body-phase-tow" >
                            <thead>
                                <tr>
                                    <th>Start date</th>
                                    <th>End date</th>
                                    <th>Type</th>
                                   
                                    <th>
                                        <a href="javascript:void(0);" style="color: #fff !important;"  ng-click="sortType = 'description'; sortform = !sortform">
                                            Description
                                        <span ng-show="sortType == 'description' && !sortform" class="fa fa-caret-down"></span>
                                        <span ng-show="sortType == 'description' && sortform" class="fa fa-caret-up"></span>
                                        </a>
                                    </th>
                                    <th>Options</th>
                                </tr>
                            </thead>

                                
                            <tfoot>
                                <tr>
                                    <th>Start date</th>
                                <th>End date</th>
                                <th>Type</th>
                                 <th>
                                        <a href="javascript:void(0);" style="color: #fff !important;" ng-click="sortType = 'description'; sortform = !sortform">
                                            Description
                                        <span ng-show="sortType == 'description' && !sortform" class="fa fa-caret-down"></span>
                                        <span ng-show="sortType == 'description' && sortform" class="fa fa-caret-up"></span>
                                        </a>
                                    </th>
                                <th>Options</th>
                                </tr>
                            </tfoot>
                            <tbody id="reporttablebody-phase-two" class="report-body">
                                <!--  -->
                                <tr ng-repeat="c in holidaylist | orderBy:sortType:sortform | filter:inputholidays"  ng-class-odd="'active'" >
                                    <td class="row-update" ng-click="showclassreport(c)">{{c.start_date | periodtime}}</td>
                                    <td class="row-update" ng-click="showclassreport(c)">{{c.end_date | periodtime}}</td>
                                    <td class="row-update" ng-click="showclassreport(c)" ng-repeat="e in c.event">
                                        {{e.title}}
                                     </td>
                                    <td class="row-update" ng-click="showclassreport(c)">{{c.description}}</td>
                                   <td>
                                        <a href="javascript:void(0)" ng-click="editholiday(c)" title="Edit" class="edit" session-data="{{s.id}}">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <a href="javascript:void(0)" ng-click="removeholiday(c)" title="Delete"  class="del" session-data="{{s.id}}">
                                            <i class="fa fa-remove" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr ng-hide="holidaylist.length > 0">
                                    <td colspan="5" class="no-record">No data found</td>
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
<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>
<script src="<?php echo base_url();?>js/angular-messages.js"></script>
<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    var app = angular.module('invantage', ['daterangepicker','ngMessages']);
    app.directive('inputTitleValidation',function(){
        return {
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {
                elm.on('blur',function(e){
                    scope.$apply(function(){
                        if (!ctrl || !elm.val()) return;
                        if (elm.val().length >= 3) {
                            ctrl.$setValidity('title_validation', true);
                            return true;
                        }
                        ctrl.$setValidity('title_validation', false);
                        return false;
                    });
                });

                elm.on('change',function(e){
                    scope.$apply(function(){
                        if (!ctrl || !elm.val()) return;
                        if (elm.val().length >= 3) {
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
            }
        }
    });

    app.filter('periodtime', function myDateFormat($filter){
        return function(text){
            var  tempdate= new Date(text);
            return $filter('date')(tempdate, "MMM dd, yyyy");
        }
    });

     
    app.directive('myRepeatDirective', function() {
        return function(scope, element, attrs) {
            if (scope.$last){

                loaddatatable();
            }
        };
    });

    app.controller('holidays_ctrl', function($scope, $window, $http, $document, $timeout,$interval,$compile,$filter){

        var urlist = {
            saveholiday:'saveholiday'
        }

        /**
     * ---------------------------------------------------------
     *   load table
     * ---------------------------------------------------------
     */


        function loaddatatable()
        {
            
            $('#table-body-phase-tow').DataTable( {
                 "order": [[ 0, "asc"  ]],
                initComplete: function () {
                    this.api().columns().every( function () {
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
            });
        }


        $scope.is_form_toggle = false;
        $scope.sortType     = 'name'; // set the default sort type
        $scope.sortReverse  = true;  // set the default sort order
        $scope.holidays = {};
        $scope.holidaylist = [];

        $scope.toogleform = function()
        {
            $scope.is_form_toggle = !$scope.is_form_toggle;
            
        }

        function resetform()
        {
            $scope.holidays.description = '';
            //$scope.defaultdate();
            
            $scope.holidays.type = $scope.holidaytypelist[0];
            $scope.holidays.date = {
                startDate:moment(),
                endDate: moment().add(1, "hour")
            };
        }

        // Initialize default date
        $scope.defaultdate = function()
        {
            try{
                $scope.holidays.date = {
                    startDate:moment(),
                    endDate: moment().add(1, "hour")
                };

                $scope.options = {
                    timePicker: false,
                    timePickerIncrement: 5,
                    showDropdowns: true,
                    locale:{format:'MM/DD/YYYY'},
                    eventHandlers:{
                        'apply.daterangepicker': function(ev, picker){}
                    }
                }
                
                //Watch for date changes
                $scope.$watch('holidays.date', function(newDate) {
                }, false);
            }
            catch(ex)
            {
                console.log(ex)
            }
        }
        $scope.defaultdate(); // set default date

        $scope.save = function(holiday)
        {
            try{
                if(holiday.description.length >= 3)
                {
                    var sdate = $scope.holidays.date.startDate.format('MM/DD/YYYY');
                    var edate = $scope.holidays.date.endDate.format('MM/DD/YYYY');
                    $scope.usersavebtntext = "Saving";
                    $scope.holidays.start_date =sdate;
                    $scope.holidays.end_date =edate;

                   // $scope.holidays.type = $scope.holidays.type.id;
                    httppostrequest('saveholiday',holiday).then(function(response){
                        if(response != null)
                        {
                            $scope.type = $scope.holidays.type;
                            $scope.holidays = {};
                            $scope.holidays.type = $scope.type;
                            getHolidays();
                            resetform();
                            $scope.usersavebtntext = "Save";
                            $scope.is_form_toggle = !$scope.is_form_toggle;

                        }else{
                           $scope.usersavebtntext = "Save";
                        }
                    });
                }
            }
            catch(e){}
        }

        $scope.editholiday = function(holiday)
        {
            try{
                $scope.holidays = holiday;
                $scope.is_form_toggle = !$scope.is_form_toggle;
                var holiday_type = $filter('filter')($scope.holidaytypelist,{id:holiday.event[0].id},true);
                if(holiday_type.length > 0)
                {
                 $scope.holidays.type = holiday_type[0]
                }

                 $scope.holidays.date = {
                    startDate:moment(holiday.start_date),
                    endDate: moment(holiday.end_date)
                };
            }
            catch(e)
            {
                console.log(e)
            }
           
        }

        $scope.removeid = null
        // remove form
        $scope.removeholiday = function(holiday)
        {
            $("#MyModal").modal();
            $scope.removeid = holiday.slug;
        }

        $scope.removeelement = function()
        {
            if(typeof $scope.removeid !== "undefined" && $scope.removeid)
            {

                try{
                    var data = {
                        slug : $scope.removeid,
                    }
                    httppostrequest('removeholiday',data).then(function(response){
                        if(typeof response != 'undefined' && response)
                        {
                            $scope.removeid = null;
                            getHolidays();
                        }
                    }); 
                }
                catch(e){}
            }
            $("#MyModal").modal('hide');
        }

    
        $("#MyModal").on("hidden.bs.modal", function () {
            $scope.removeid = null;
        });

        getHolidays();
        function getHolidays()
        {
            httprequest('getholidays',{}).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.holidaylist = response;
                }else{
                   $scope.holidaylist = []
                }
            });
        }

        

        $scope.holidaytypelist = [];
        getHolidaytypes();
        function getHolidaytypes()
        {
            httprequest('getholidaytype',{}).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.holidays.type = response[0]
                    $scope.holidaytypelist = response;
                }else{
                   $scope.holidaytypelist = []
                }
            });
        }

        function httprequest(url,data)
        {
            var request = $http({
                method:'get',
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

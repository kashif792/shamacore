<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>
<div id="detail_modal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p>Are you sure you want to delete this record?</p>

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                <button type="button" id="UserDelete" class="btn btn-default " value="save">Yes</button>

            </div>

        </div>

    </div>

</div>
<div class="col-sm-10"  ng-controller="datesheet_controller">
    <?php
        // require_footer
        require APPPATH.'views/__layout/filterlayout.php';
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <label>Add Datesheet </label>
        </div>
        <div class="panel-body">
                <?php $attributes = array('name' => 'schedule_timetable', 'id' => 'schedule_timetable','class'=>'form-horizontal'); echo form_open('', $attributes);?>
                    <input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial" ng-model="serial">
                    <input type="hidden" value="Mid" name="type" id="type" ng-model="type">
                    <fieldset>
                        
                        <div class="form-group">
                            <div class="col-md-6">
                                
                                <label><span class="icon-user"></span> Grade <span class="required">*</span></label>
                                
                                    <select class="form-control" ng-options="item.name for item in classlist track by item.id"  id="select_class" name="select_class" ng-model="select_class" ng-change="changeclass()"></select>
                                
                            </div>
                            <div class="col-md-6">
                               <label><span class="icon-user"></span> Type <span class="required">*</span></label>
                                <select class="form-control"  id="exam_type" name="exam_type">
                                <option>Mid</option>
                                <option>Final</option>
                                </select>
                            
                            </div>
                            <div class="clearfix"></div>
                        </div>


                        
                        
                           
                         <div class="form-group">
                            <div class="col-md-6">
                                
                                <label><span class="icon-clock"></span> School Time From <span class="required">*</span></label>
                                
                                    <input type="text" class="form-control" id="inputStartitme" name="inputFrom" ng-model="inputStartitme"  placeholder="Start Time"  tabindex="1" value="" required>
                                
                            </div>
                            <div class="col-md-6">
                                <label><span class="icon-clock"></span> To <span class="required">*</span></label>
                               <input type="text" class="form-control" id="InputEndTime" name="inputTo" ng-model="InputEndTime"  placeholder="End Time"  tabindex="1" value="" required>
                            
                            </div>
                            <div id="time_error" class="required row endtimeerror">End time must be greater then start time</div>
                            <div class="clearfix"></div>
                        </div> 
                            
                         <div class="form-group ">
                            <div class="col-md-6">
                                 <label><span class="icon-calendar"></span> Start Date <span class="required">*</span></label>
                                <input type="text" class="form-control" id="inputStartdate" name="inputStartdate" ng-model="inputStartdate"  placeholder="Start Date"  tabindex="1" value="" required>
                            </div>
                            <div class="col-md-6">
                                <label><span class="icon-calendar"></span> End Date <span class="required">*</span></label>
                                <input type="text" class="form-control" id="InputEnddate" name="InputEnddate" ng-model="InputEnddate"  placeholder="End Date"  tabindex="1" value="" required></div>
                            <div id="date_error" class="required row endtimeerror">End date must be greater then start date</div>
                            <div class="clearfix"></div>
                        </div> 
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label><span class="icon-mail-alt"></span> Notes</label>
                            </div>
                            <div class="col-sm-6">
                                <textarea class="form-control"  placeholder="Notes..." id="notes" name="notes" ></textarea>
                                                        
                            </div>
                         </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="button" tabindex="8" class="btn btn-primary"  id="save" ng-click="savedatesheettable()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                                <a tabindex="9" href="<?php echo $path_url; ?>datesheetlist" tabindex="6" title="cancel">Cancel</a>
                            </div>
                        </div>
                    </fieldset>

                <?php echo form_close();?>
        <div class="detail_area" style="display: none;">
        <a href="javascript:void(0)" ng-click="getDatesheetDetail(0)" class="btn btn-primary addmore">Add Papers</a>  
        

        <table  class="table table-striped table-bordered row-border hover">
            <thead>
            <tr>
                <th>Subject</th>
                <th>Date</th>
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
                
                <th>Options</th>
            </tr>
        </thead>
            <tr ng-repeat="d in datesheetlistinfo"  ng-init="$last && finished()" >
                <td>{{d.subject_name}}</td>
                <td>{{d.exam_date}}</td>
                <td>{{d.exam_day}}</td>
                <td>{{d.start_time}}</td>
                <td>{{d.end_time}}</td>
                
               <td><a href="javascript:void(0)" id="{{d.detail_id}}" ng-click="getDatesheetDetail(d.detail_id)" class='edit' title="Edit">

                     <i class="fa fa-edit" aria-hidden="true"></i>

                </a>

                <a href="javascript:void(0)" title="Delete" id="{{d.detail_id}}" class="del">
                <i class="fa fa-remove" aria-hidden="true"></i>

                </a></td>
                
            </tr>
            <tr ng-hide="datesheetlistinfo.length > 0">
                <td colspan="11" class="no-record">No data found</td>
            </tr>
        </table>
    </div>
            </div>

    </div>



<div class="col-sm-10">
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Paper</h3>
                
            </div>
            <div class="alert alert-success success_datesheet" style="display: none;">
              <strong>Successfully save!</strong>
            </div>
                <div class="modal-body">
                <?php $attributes = array('role'=>'form','name' => 'addquestionform', 'id' => 'addquestionform','class'=>'form-container-input');
                        echo form_open_multipart('', $attributes);?>
                    <input type="hidden" ng-model="detail_id"  name="detail_id" id="detail_id">
                    <input type="hidden" ng-model="inputQestionSerail" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="inputQestionSerail" id="inputQestionSerail">
                    <div class="form-group">
                            <div class="col-md-6">
                                <label><span class="icon-mail-alt"></span> Subject <span class="required">*</span></label>
                                 <select class="form-control" ng-options="item.name for item in subjectlist track by item.id" name="select_subject" id="select_subject" ng-change="checksche()" ng-model="inputSubject"></select>
                            </div>
                            <div class="col-md-6">
                               <label><span class="icon-calendar"></span> Date <span class="required">*</span></label>
                                <input class="form-control" type="text"  placeholder="" ng-model="exam_date" id="exam_date" name="exam_date"  value="">
                            </div>
                            <div class="clearfix"></div>
                         </div>
                    
                        <div class="form-group ">
                        <div class="col-sm-12">
                            <label><span class="icon-clock"></span> From <span class="required">*</span></label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="inputStartitme1" name="inputFrom1" ng-model="inputStartitme1"  placeholder="Start Time"  tabindex="1" value="" required>
                        </div>  
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="InputEndTime1" name="inputTo1" ng-model="InputEndTime1"  placeholder="End Time"  tabindex="1" value="" required>
                        </div>  
                            
                        </div>
                    <div class="clearfix"></div>
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
                    <button type="button" tabindex="8" ng-click="savedatesheetdatail()" class="btn btn-default save-button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
</div>

<script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.timepicker.js?v=0.3.3"></script>


<script type="text/javascript">
    app.controller('datesheet_controller',['$scope','$myUtils','$filter', datesheet_controller]);

    function datesheet_controller($scope, $myUtils,$filter) {
        $scope.filterobj = {};
        
        $scope.baseUrl = '<?php echo base_url() ?>'

        $scope.user_id = $myUtils.getUserId();
        $scope.name = $myUtils.getUserName();
        $scope.email = $myUtils.getUserEmail();
        $scope.roles = $myUtils.getUserRoles();
        $scope.school_id = $myUtils.getDefaultSchoolId();
        $scope.session_id = $myUtils.getDefaultSessionId();
        
        var urlist = {
            datesheet:'<?php echo SHAMA_CORE_API_PATH; ?>datesheet',
        }

       $scope.active = 1;
        $scope.fallsemester = [];
        $scope.type = [];
        function classlist()
        {
            $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>classlist',({school_id:$scope.school_id})).then(function(response){
            //httprequest('getsessiondetail',({})).then(function(response){
               if(response != null && response.length > 0)
                    {
                        $scope.classlist = response
                        $scope.select_class = response[0]
                        if($scope.firsttimeload == true)
                        {
                            var found = $filter('filter')($scope.classlist, {id: $scope.editresponse.class}, true);
                            if(found.length)
                            {
                                $scope.select_class = found[0];
                            }
                            
                        }
                        
                    }
                else{
                    //$scope.finished();
                }
            });
        }
        classlist();
        $(document).ready(function() {
           $('#inputStartitme').timepicker({
               showLeadingZero: false,
               onSelect: tpStartSelect,
               
                showNowButton: false,
                nowButtonText: 'Now',

                minutes: {
                    starts: 0,                // First displayed minute
                    ends: 59,                 // Last displayed minute
                    interval: 5,              // Interval of displayed minutes
                    manual: []                // Optional extra entries for minutes
                },
                onMinuteShow: OnMinuteSShowCallback,
                 onHourShow: OnHourShowCallback,
                defaultTime:'7:00'

           });
           $('#InputEndTime').timepicker({
               showLeadingZero: false,
               onSelect: tpEndSelect,
               
                showNowButton: false,
                nowButtonText: 'Now',

                minutes: {
                    starts: 0,                // First displayed minute
                    ends: 59,                 // Last displayed minute
                    interval: 5,              // Interval of displayed minutes
                    manual: []                // Optional extra entries for minutes
                },
                onMinuteShow: OnMinuteShowCallback,
                onHourShow: OnHourEShowCallback,
                defaultTime:'8:00'

           });
        });

            
            // when start time change, update minimum for end timepicker
        function tpStartSelect( time, endTimePickerInst ) {

           $('#InputEndTime').timepicker('option', {
               minTime: {
                   hour: endTimePickerInst.hours,
                   minute: endTimePickerInst.minutes
               }
           });
        }

        function OnHourShowCallback(hour) {
            if ((hour > 18) || (hour < 7)) {
                return false; // not valid
            }
            return true; // valid
        }

        function OnHourEShowCallback(hour) {
            var starhour = $('#inputStartitme').timepicker('getHour');
            if ((hour < starhour)) {
                return false; // not valid
            }
            return true; // valid
        }



        function OnMinuteShowCallback(hour, minute) {
            var starttime = $('#inputStartitme').timepicker('getMinute');
            var starhour = $('#inputStartitme').timepicker('getHour');
            if( (hour >= starhour) && (minute > starttime)){ return true;}

            if( (hour == starhour) && (starttime <= minute)){ return false;}
            return true;  // valid
        }

        function OnMinuteSShowCallback(hour, minute) {

            return true;  // valid
        }



        // when end time change, update maximum for start timepicker
        function tpEndSelect( time, startTimePickerInst ) {
            var starttime = $('#inputStartitme').timepicker('getMinute');
            var starhour = $('#inputStartitme').timepicker('getHour');

            $('#inputStartitme').timepicker('option', {
               maxTime: {
                   hour: startTimePickerInst.hours,
                   minute: startTimePickerInst.minutes
               }
           });
        }
        $(document).ready(function(){
        initdatepickter('input[name="exam_date"]',new Date('<?php echo date('Y-m-d') ?>'))
        initdatepickter('input[name="inputStartdate"]',new Date('<?php echo date('Y-m-d') ?>'))
        initdatepickter('input[name="InputEnddate"]',new Date('<?php echo date('Y-m-d',strtotime('+1 day')) ?>'))
        
        function initdatepickter(dateinput,inputdate)

        {
            
            $(dateinput).daterangepicker({

                singleDatePicker: true,

                showDropdowns: true,

                startDate:inputdate,

                locale: {

                    format: 'D MMMM, YYYY'

                }

            });

        }

    });
        // Save
        $scope.savedatesheettable = function()
        {
            var session_id = $("#inputRSession").val();
            var semester_id = $("#inputSemester").val();
            var notes = $("#notes").val();
            var exam_type = $("#exam_type").val();

            var starttime = $("#inputStartitme").val();
            var endtime = $("#InputEndTime").val();
            var startdate = $("#inputStartdate").val();
            var enddate = $("#InputEnddate").val();
            var select_class = $("#select_class").val();
            message("",'hide')
            $("#time_error").hide()
            $("#date_error").hide()

            if(!select_class){
                jQuery("#select_class").css("border", "1px solid red");
                message("Please select grade",'show')
                return false;
            }
            else{
                jQuery("#select_class").css("border", "1px solid #C9C9C9");
            }

            
             
            var reg = /(\d|2[0-3]):([0-5]\d)/;

            if(reg.test(starttime) == false){
                jQuery("#inputStartitme").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputStartitme").css("border", "1px solid #C9C9C9");
            }

            if(reg.test(endtime) == false){
                jQuery("#InputEndTime").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#InputEndTime").css("border", "1px solid #C9C9C9");
            }

            var startDate = new Date($('#inputStartdate').val());
            var endDate = new Date($('#InputEnddate').val());

            if (startDate >= endDate){
                $("#date_error").show();
                return false;
            }
            // End here
             var $this = $(".btn-primary");
             $this.button('loading');

            var formdata = new FormData();
            formdata.append('notes',notes);
            formdata.append('exam_type',exam_type);
            formdata.append('select_class',$scope.select_class.id);
            
            formdata.append('inputFrom',$scope.inputStartitme);
            formdata.append('inputTo',$scope.InputEndTime);
            formdata.append('inputFromdate',startdate);
            formdata.append('inputTodate',enddate);
            formdata.append('serial',$scope.serial);

            var data = {

                    notes:notes,
                    exam_type:exam_type,
                    select_class:select_class,
                    starttime : starttime,
                    endtime : endtime,
                    startdate : startdate,
                    enddate :enddate,
                    
                    school_id:$scope.school_id,
                    id:$scope.serial
                    }
            
            $myUtils.httppostrequest(urlist.datesheet,data).then(function(response){
                
                if(response.message == "false"){
                        //initmodules();
                        message('Record already exists','show')
                    var $this = $(".btn-primary");
                    $this.button('reset');
                    }
                else
                {
                    window.location.href = "<?php echo base_url();?>update_datesheet/"+response.lastid;
                }
                
            })
           // $http(request)
                
        }
   }
</script>

<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>

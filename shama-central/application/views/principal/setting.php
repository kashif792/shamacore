<?php

// require_header

require APPPATH.'views/__layout/header.php';



// require_top_navigation

require APPPATH.'views/__layout/topbar.php';



// require_left_navigation

require APPPATH.'views/__layout/leftnavigation.php';

?>




<div class="col-sm-10" ng-controller="settingsCtrl">

    <div id="delete_dialog" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">Confirmation</h4>

                </div>

                <div class="modal-body">

	
                    <p ng-show="dialogItemName == 'session'">Deleting a session will remove all data associated with this session. This action is not reversible. Do you still want to delete this session?</p>
					<p ng-show="dialogItemName == 'semester'">Deleting a session will remove all data associated with this semester. This action is not reversible. Do you still want to delete this semester?</p>
                 </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                    <button type="button" id="remove_session" class="btn btn-default " value="save">Yes</button>

                </div>

            </div>

        </div>

    </div>

    <div id="delete_location" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">Confirmation</h4>

                </div>

                <div class="modal-body">

                    <p>Are you sure you want to delete this location name?</p>

                 </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                    <button type="button" id="remove_location" class="btn btn-default " value="save">Yes</button>

                </div>

            </div>

        </div>

    </div>

    <div id="delete_school" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">Confirmation</h4>

                </div>

                <div class="modal-body">

                    <p>Deleting a school will remove all data associated with this school. Do you still want to delete this school?</p>

                 </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                    <button type="button" id="remove_school" class="btn btn-default " value="save">Yes</button>

                </div>

            </div>

        </div>

    </div>

    <div id="delete_holidaytype" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">Confirmation</h4>

                </div>

                <div class="modal-body">

                    <p>Are you sure to delete this event type?</p>

                 </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                    <button type="button" ng-click="holidayremoveclick()" class="btn btn-default " value="save">Yes</button>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="MyModal">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h5 class="modal-title">Remove Semester Detail</h5>

                </div>

                <div class="modal-body">

                    <p>Are you sure to delete this element?</p>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>

                    <button type="button" class="btn btn-default" ng-click="removesemesterbyuser()">Yes</button>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="RemoveGrade">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h5 class="modal-title">Remove Semester Detail</h5>

                </div>

                <div class="modal-body">

                    <p>Are you sure to delete this element?</p>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>

                    <button type="button" class="btn btn-default" ng-click="removeGradepoint()">Yes</button>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="changeSession">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h5 class="modal-title">Session</h5>

                </div>

                <div class="modal-body">

                    <p>Are you sure want to make this session active?</p>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" ng-click="deactiveselectedsession()" data-dismiss="modal">No</button>

                    <button type="button" class="btn btn-default" ng-click="changeSchoolSesion()">Yes</button>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="changeSemesterModal">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h5 class="modal-title">Semester</h5>

                </div>

                <div class="modal-body">

                    <p>Are you sure to use these dates for current semester?</p>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" ng-click="deactiveselectedsemester()" data-dismiss="modal">No</button>

                    <button type="button" class="btn btn-default" ng-click="setSemesterActive()">Yes</button>

                </div>

            </div>

        </div>

    </div>

    <?php

        // require_footer

        require APPPATH.'views/__layout/filterlayout.php';

    ?>

    <div class="panel panel-default">

        <div class="panel-heading">

            <label>Settings</label>

        </div>

        <div class="panel-body">
            <input type="hidden" id="shama_api_path" value="<?php echo SHAMA_CORE_API_PATH; ?>">
			<div class="panel-group" id="accordion">

         <!-- Principal area -->
            <div ng-if="isPrincipal">

                <div class="panel panel-default">

                    <div class="panel-heading">

                        <h4 class="panel-title">

                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Add Session</a>

                        </h4>

                    </div>



                    <div id="collapse1" class="panel-collapse collapse in">

                        <div class="panel-body">

                            <form class="form-inline" name="semesterdetailform" ng-submit="savesessiondates(sessionobj)" novalidate>

                                <input type="hidden" name="serial" ng-model="sessionobj.serial">

                                <div class="form-group">

                                    <label for="inputDate">Date:</label>

                                   <input date-range-picker id="inputSessionDate" name="inputSessionDate" class="form-control date-picker" 

                                    ng-model="sessionobj.date" clearable="true" type="text" options="sessionobj.options" required/>

                                </div>

                             

                                <div class="form-group">

                                    <button type="submit" ng-init="usersavebtntext = 'Save';"   class="btn btn-primary">

                                        <span ng-show="usersavebtntext == 'Saving'">

                                            <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>

                                        </span>

                                        {{usersavebtntext}}

                                    </button>

                                </div>

                            </form>

                      

                            <div class="row" style="margin-top: 5px;">

                                <div class="col-sm-12">

                                    <table class="table table-bordered table-striped table-hover table-condensed" id="table-body-phase-tow" >

                                        <thead>

                                            <tr>

                                                <th>Session</th>

                                                <th>Status</th>

                                                <th>Options</th>

                                            </tr>

                                        </thead>

                                        <tbody id="reporttablebody-phase-two" class="report-body">

                                            <tr ng-repeat="s in sessionlist track by s.id">

                                                <td>{{s.from}} - {{s.to}}</td>

                                                <td>
                                                    <div ng-if="s.show=='Active'">
                                                    <input type="radio" name="inputSessionStatus" ng-model="inputSessionStatus" value="{{s.id}}" ng-click="setCurrentSession(s.id)"></td>
                                                    </div>
                                                <td>
                                                    <div ng-if="s.show=='Active'">
                                                    <a href="javascript:void(0)" ng-click="editsession(s.id)" title="Edit" class="edit" session-data="{{s.id}}">

                                                        <i class="fa fa-edit" aria-hidden="true"></i>

                                                    </a>

                                                    <a href="javascript:void(0)" ng-click="removesession(s.id)" title="Delete"  class="del" session-data="{{s.id}}">

                                                       <i class="fa fa-remove" aria-hidden="true"></i>

                                                    </a>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="panel panel-default hide">

                    <div class="panel-heading">

                        <h4 class="panel-title">

                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Add Semester</a>

                        </h4>

                    </div>

                    <div id="collapse2" class="panel-collapse collapse">

                        <div class="panel-body">

                                <form class="form-inline hide">

                                    <div class="form-group">

                                        <label for="email">Semester:</label>

                                        <input type="text" class="form-control" name="inputSemester" id="inputSemester" ng-model="inputSemester">

                                    </div>

                                    <div class="form-group">

                                        <button type="button" ng-click="savesemester()" class="btn btn-primary save-semester" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>

                                    </div>

                                </form>

                                <div class="row" style="margin-top: 5px;">

                                    <div class="col-sm-12">

                                        <table class="table table-bordered table-striped table-hover table-condensed" id="table-body-phase-tow" >

                                            <thead>

                                                <tr>

                                                    <th>Semester</th>

                                                    <th>Status</th>

                                                    <!-- <th>Options</th> -->

                                                </tr>

                                            </thead>

                                            <tbody id="reporttablebody-phase-two" class="report-body">

                                                <tr ng-repeat="s in semesterlist track by s.id">

                                                    <td>{{s.name}}</td>

                                                    <td><input type="radio" name="inputCurrentSemester" ng-model="inputCurrentSemester" value="{{s.id}}" ng-click="setCurrentSemester(s.id)"></td>

                                                    <!-- <td>

                                                        <a href="javascript:void(0)" ng-click="editsemester(s.id)" title="Edit" class="edit" session-data="{{s.id}}">

                                                           <i class="fa fa-edit" aria-hidden="true"></i>

                                                        </a>

                                                        <a href="javascript:void(0)" ng-click="removesemester(s.id)" title="Delete"  class="del" session-data="{{s.id}}">

                                                         <i class="fa fa-remove" aria-hidden="true"></i>

                                                        </a>

                                                    </td> -->

                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>



                     <div class="panel panel-default hide">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Schedule Settings</a>

                            </h4>

                        </div>

                        <div id="collapse3" class="panel-collapse collapse">

                        <div class="panel-body">

                                <form class="form-inline">

                                    <div class="form-group">

                                        <label for="email">Schedule Settings:</label>

                                        <!-- <input type="text" name="inputSemester" id="inputSemester" ng-model="inputSemester"> -->

                                    </div>

                                   <!--  <div class="form-group">

                                        <button type="button" ng-click="savesemester()" class="btn btn-primary" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>

                                    </div> -->

                                </form>

                                <div class="row" style="margin-top: 5px;">

                                    <div class="col-sm-12">

                                        <table class="table table-bordered table-striped table-hover table-condensed" id="table-body-phase-tow" >

                                            <thead>

                                                <tr>

                                                    <th>Release Schedule</th>

                                                    <th>Status</th>



                                                </tr>

                                            </thead>

                                            <tbody id="reporttablebody-phase-two" class="report-body">

                                                <tr>

                                                    <td>Enable Timetable</td>

                                                    <td><input type="radio" value="111" ng-click="Release()" id="EnableTimetable" name="ScheduleType" ng-model="EnableSchedullar"/></td>



                                                </tr>

                                                <tr>

                                                    <td>Enable Schedullar</td>

                                                    <td><input type="radio" value="222" ng-click="Release()" id="EnableSchedullar" name="ScheduleType" ng-model="EnableSchedullar"/></td>

                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div> 

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Admin Email</a>

                            </h4>

                        </div>

                        <div id="collapse4" class="panel-collapse collapse">

                            <div class="panel-body">

                                <form class="form-inline">

                                    <div class="form-group">

                                        <label for="inputAdminEmail">Admin Email:</label>

                                        <input  type="email" class="form-controller AdminEmail" name="inputAdminEmail" id="inputAdminEmail" ng-model="inputAdminEmail">

                                    </div>

                                    <div class="form-group">

                                        <button type="button" ng-click="saveadminsettings()" class="btn btn-primary email-btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>

                                    </div>

                                </form>



                            </div>

                        </div>

                    </div>

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a data-toggle="collapse" data-parent="#accordion" href="#semester_detail">Semester Dates</a>

                            </h4>

                        </div>

                        <div id="semester_detail" class="panel-collapse collapse">

                            <div class="panel-body">

                                <div class="row error-message" ng-hide="sessionlist.length > 0">

                                    <div class="col-sm-12">

                                       <p>

                                            Please add a session before adding new semester dates.

                                        </p>

                                    </div>

                                </div>

                                <div class="row error-message" ng-hide="semesterlist.length > 0">

                                    <div class="col-sm-12">

                                       <p>

                                            Please add a semester to assign dates.

                                        </p>

                                    </div>

                                </div>

                                <form class="form-inline" name="semesterdetailform" ng-submit="savesemesterdetail(semesterdetail)" novalidate>

                                    <input type="hidden" name="serial" ng-model="semesterdetail.serail">

                                    <div class="form-group">

                                        <label for="inputDate">Date:</label>

                                       <input date-range-picker id="inputDate" name="inputDate" class="form-control date-picker" 

                                        ng-model="semesterdetail.date" clearable="true" type="text" options="options" required/>

                                    </div>

                                    <div class="form-group">

                                        <label for="email">Type:</label>

                                        <span ng-repeat="s in semesterlist">

                                            <input type="checkbox"  ng-model="semesterdetail.semester" ng-true-value="'{{s.id}}'" ng-false-value="'NO'">

                                            {{s.name}}

                                            <input type="hidden" ng-model="semesterdetail.semester" name="type" required/>

                                        </span>

                                        

                                    </div>

                                    <div class="form-group">

                                        <button type="submit" ng-init="usersavebtntext = 'Save';"  ng-disabled="semesterdetailform.$invalid || sessionlist.length == 0 || semesterdetail.semester =='NO' " class="btn btn-primary">

                                            <span ng-show="usersavebtntext == 'Saving'">

                                                <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>

                                            </span>

                                            {{usersavebtntext}}

                                        </button>

                                    </div>

                                </form>

                                <div class="row" style="margin-top: 5px;">

                                    <div class="col-sm-12">

                                        <table class="table table-bordered table-striped table-hover table-condensed" id="table-body-phase-tow" >

                                            <thead>

                                                <tr>

                                                    <th>Dates</th>

                                                    <th>Session</th>

                                                    <th>Semester</th>

                                                    <th>Status</th>

                                                    <th>Options</th>

                                                </tr>

                                            </thead>

                                            <tbody id="reporttablebody-phase-two" class="report-body">

                                                <tr ng-repeat="s in semester_detail_list track by s.id">

                                                    <td>{{s.start_date}} - {{s.end_date}}</td>

                                                    <td>{{s.session_value}}</td>

                                                    <td>{{s.semester_value}}</td>

                                                    <td>
                                                        <div ng-if="s.session_status=='Active'">
                                                            <input type="radio" name="s.id" ng-model="InputActiveSem" value="s.id" ng-value="s.id" ng-click="changesemesterdate(s)"></td>
                                                        </div>
                                                    <td>
                                                        <div ng-if="s.session_status=='Active'">
                                                            <a href="javascript:void(0)" ng-click="editsemesterdetail(s)" title="Edit" class="edit" >

                                                               <i class="fa fa-edit" aria-hidden="true"></i>

                                                            </a>

                                                            <a href="javascript:void(0)" ng-click="removesemesterdetail(s)" title="Delete"  class="del">

                                                             <i class="fa fa-remove" aria-hidden="true"></i>

                                                            </a>
                                                        </div>
                                                    </td>

                                                </tr>

                                                <tr ng-hide="semester_detail_list.length > 0">

                                                    <td colspan="4" class="no-record">No data found</td>

                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a data-toggle="collapse" data-parent="#accordion" href="#holidays">Add Event Type</a>

                            </h4>

                        </div>

                        <div id="holidays" class="panel-collapse collapse">

                            <div class="panel-body">

                                <div class="row" ng-hide="show_event_type_error">

                                    <div class="col-sm-12">

                                        <p style="color: red;">Please enter value.</p>

                                    </div>

                                </div>

                                <form class="form-inline" name="type" ng-submit="saveholidaytype(holidaytype)" novalidate>

                                    <input type="hidden" name="serial" ng-model="holidaytype.serail">

                                    <div class="form-group">

                                        <label for="holidaytitle">Event:</label>

                                        <input type="text" name="holidaytitle" class="form-control" id="holidaytitle" ng-model="holidaytype.title"  input-title-validation>

                                         <div ng-messages="type.holidaytitle.$error" style="color: red;">

                                            <div ng-message="title_validation">Please enter 3-256 character title</div>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <button type="submit" ng-init="usersavebtntext = 'Save';"  class="btn btn-primary">

                                            <span ng-show="usersavebtntext == 'Saving'">

                                                <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>

                                            </span>

                                            {{usersavebtntext}}

                                        </button>

                                    </div>

                                </form>

                                <div class="row" style="margin-top: 5px;">

                                    <div class="col-sm-12">

                                        <table class="table table-bordered table-striped table-hover table-condensed" id="table-body-phase-tow" >

                                            <thead>

                                                <tr>

                                                    <th>Event</th>

                                                    <th>Options</th>

                                                </tr>

                                            </thead>

                                            <tbody id="reporttablebody-phase-two" class="report-body">

                                                <tr ng-repeat="h in holidaytypelist track by h.id">

                                                    <td>{{h.title}}</td>

                                                    <td>

                                                        <a href="javascript:void(0)" ng-click="editholidaytype(h)" title="Edit" class="edit" >

                                                           <i class="fa fa-edit" aria-hidden="true"></i>

                                                        </a>

                                                        <a href="javascript:void(0)" ng-click="removeholidaytype(h)" title="Delete"  class="del">

                                                         <i class="fa fa-remove" aria-hidden="true"></i>

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

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a data-toggle="collapse" data-parent="#accordion" href="#grades">Grades</a>

                            </h4>

                        </div>

                        <div id="grades" class="panel-collapse collapse">

                            <div class="panel-body">

                                <form class="form-inline" name="grade" ng-submit="savegrade(gradeobj)" novalidate>

                                    <input type="hidden" name="serial" ng-model="gradeobj.id">

                                    <div class="form-group">

                                        <label for="gradetitle">Title:</label>

                                        <input type="text" name="gradetitle" class="form-control" id="gradetitle" ng-model="gradeobj.title" ng-minlength="1" ng-maxlength="10">

                                    </div>

                                    <div class="form-group">

                                        <label for="grade_lower_limit">Lower limit:</label>

                                        <input type="number" name="grade_lower_limit" class="form-control" id="grade_lower_limit" ng-model="gradeobj.lower_limit">

                                        

                                    </div>

                                    <div class="form-group">

                                        <label for="grade_upper_limit">Upper limit:</label>

                                        <input type="number" name="grade_upper_limit" class="form-control" id="grade_upper_limit" ng-model="gradeobj.upper_limit">

                                     

                                    </div>

                                    <div class="form-group">

                                        <button type="submit" ng-init="usersavebtntext = 'Save';"  ng-disabled="type.$invalid" class="btn btn-primary">

                                            <span ng-show="usersavebtntext == 'Saving'">

                                                <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>

                                            </span>

                                            {{usersavebtntext}}

                                        </button>

                                    </div>

                                </form>

                                <div class="row" style="margin-top: 5px;">

                                    <div class="col-sm-12">

                                       <table datatable="ng" ng-hide="evulationarray.length <= 0" class="table table-striped table-bordered row-border hover">

                                            <thead>

                                                <tr>

                                                    <th>Title</th>

                                                    <th>Lower Limit</th>

                                                    <th>Upper Limit</th>

                                                    <th>Options</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                <tr ng-repeat="g in gradelist track by g.id">

                                                    <td>{{g.title}}</td>

                                                    <td>{{g.lower_limit}}</td>

                                                    <td>{{g.upper_limit}}</td>

                                                    <td>

                                                        <a href="javascript:void(0)" ng-click="editgrade(g)" title="Edit" class="edit" >

                                                           <i class="fa fa-edit" aria-hidden="true"></i>

                                                        </a>

                                                        <a href="javascript:void(0)" ng-click="removegrade(g)" title="Delete"  class="del">

                                                         <i class="fa fa-remove" aria-hidden="true"></i>

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
         <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a data-toggle="collapse" data-parent="#accordion" href="#assembly">Assembly</a>

                            </h4>

                        </div>

                        <div id="assembly" class="panel-collapse collapse">

                            <div class="panel-body">

                                <form class="form-inline" name="assembly" ng-submit="saveassembly(assemblyobj)" novalidate>
                                    
                                    <input type="hidden" name="serial" ng-model="schoolid" id="schoolid" >
                                    

                                    <div class="form-group">

                                        <label for="grade_lower_limit">Start Time:</label>

                                        <input type="text" class="form-control getstarttime" autocomplete="off" value="assemblydata.start_time" id="inputStartitme"  name="inputFrom" ng-model="assemblyobj.start_time" placeholder="Start Time" required>

                                    </div>

                                    <div class="form-group">

                                        <label for="grade_upper_limit">End Time:</label>

                                        <input type="text" class="form-control" id="InputEndTime" autocomplete="off"  name="inputTo"  ng-model="assemblyobj.end_time"  placeholder="End Time"  tabindex="1" required>

                                    </div>

                                    <div class="form-group">

                                        <button type="submit" ng-init="usersavebtntext = 'Save';"  ng-disabled="type.$invalid" class="btn btn-primary">

                                            <span ng-show="usersavebtntext == 'Saving'">

                                                <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>

                                            </span>

                                            {{usersavebtntext}}

                                        </button>

                                    </div>

                                </form>
                                 <div class="row" style="margin-top: 5px;">

                                    <div class="col-sm-12">

                                       <table datatable="ng" ng-hide="evulationarray.length <= 0" class="table table-striped table-bordered row-border hover">

                                            <thead>

                                                <tr>

                                                    <th>Start Time</th>

                                                    <th>End Time</th>

                                                    <th></th>
                                                    
                                                </tr>

                                            </thead>

                                            <tbody>

                                                <tr ng-repeat="g in assemblylist">

                                                    <td>{{g.start_time}}</td>

                                                    <td>{{g.end_time}}</td>

                                                    
                                                    <td>

                                                        <a href="javascript:void(0)" ng-click="getassemblyedit()" title="Edit" class="edit" >

                                                           <i class="fa fa-edit" aria-hidden="true"></i>

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
                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a data-toggle="collapse" data-parent="#accordion" href="#break">Break Time</a>

                            </h4>

                        </div>

                        <div id="break" class="panel-collapse collapse">

                            <div class="panel-body">

                               <div class="addbreak" style="display: block"> 
                                <form class="form-inline breakcontainer" name="break" ng-submit="savebreak(breakobj)" novalidate>
                                   <div class="row" style="margin: 20px 0px"> 
                                        <div class="col-sm-6">
                                            

                                            
                                                <div class="col-sm-6">
                                                    <label for="grade_lower_limit">Monday Start Time:</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control breaktimepicker mon_start_time" autocomplete="off"  name="inputFrom" ng-model="breakobj.monday_start_time" placeholder="Start Time" required>
                                                </div>
                                                <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                                <div class="col-sm-6">
                                                    <label for="grade_upper_limit">Monday End Time:</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control breaktimepicker mon_end_time" autocomplete="off"  name="inputTo"  ng-model="breakobj.monday_end_time"  placeholder="End Time"  tabindex="1" required>
                                                </div>
                                                <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row" style="margin: 20px 0px"> 
                                        <div class="col-sm-6">
                                        
                                                <div class="col-sm-6">
                                                    <label for="grade_lower_limit">Tuesday Start Time:</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control breaktimepicker tue_start_time" autocomplete="off"  name="inputFrom" ng-model="breakobj.tuesday_start_time" placeholder="Start Time" required>
                                                </div>
                                                <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                           
                                                <div class="col-sm-6">
                                                    <label for="grade_upper_limit">Tuesday End Time:</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control breaktimepicker tue_end_time"  autocomplete="off" name="inputTo"  ng-model="breakobj.tuesday_end_time"  placeholder="End Time"  tabindex="1" required>
                                                </div>
                                                <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row" style="margin: 20px 0px"> 
                                        <div class="col-sm-6">
                                        
                                                <div class="col-sm-6">
                                                    <label for="grade_lower_limit">Wednesday Start Time:</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control breaktimepicker wed_start_time"  autocomplete="off" name="inputFrom" ng-model="breakobj.wednesday_start_time" placeholder="Start Time" required>
                                                </div>
                                                <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                           
                                                <div class="col-sm-6">
                                                    <label for="grade_upper_limit">Wednesday End Time:</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control breaktimepicker wed_end_time" autocomplete="off" name="inputTo"  ng-model="breakobj.wednesday_end_time"  placeholder="End Time"  tabindex="1" required>
                                                </div>
                                                <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row" style="margin: 20px 0px"> 
                                        <div class="col-sm-6">
                                        
                                                <div class="col-sm-6">
                                                    <label for="grade_lower_limit">Thursday Start Time:</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control breaktimepicker thu_start_time" autocomplete="off" name="inputFrom" ng-model="breakobj.thursday_start_time" placeholder="Start Time" required>
                                                </div>
                                                <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            
                                                <div class="col-sm-6">
                                                    <label for="grade_upper_limit">Thursday End Time:</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control breaktimepicker thu_end_time"  autocomplete="off" name="inputTo"  ng-model="breakobj.thursday_end_time"  placeholder="End Time"  tabindex="1" required>
                                                </div>
                                                <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row" style="margin: 20px 0px"> 
                                        <div class="col-sm-6">
                                        
                                                <div class="col-sm-6">
                                                    <label for="grade_lower_limit">Friday Start Time:</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control breaktimepicker fri_start_time" autocomplete="off" name="inputFrom" ng-model="breakobj.friday_start_time" placeholder="Start Time" required>
                                                </div>
                                                <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            
                                                <div class="col-sm-6">
                                                    <label for="grade_upper_limit">Friday End Time:</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control breaktimepicker fri_end_time" autocomplete="off" name="inputTo"  ng-model="breakobj.friday_end_time"  placeholder="End Time"  tabindex="1" required>
                                                </div>
                                                <div class="clearfix"></div>
                                            
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div style="width: 120px;margin:0px auto">
                                        <div class="form-group">

                                            <button type="submit" ng-init="usersavebtntext = 'Save';"  ng-disabled="type.$invalid" class="btn btn-primary">

                                                <span ng-show="usersavebtntext == 'Saving'">

                                                    <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>

                                                </span>

                                                {{usersavebtntext}}

                                            </button>

                                        </div>
                                    </div>
                                </form>
                                </div>
                                 <div class="row" style="margin-top: 15px;">

                                    <div class="col-sm-12">

                                       <table datatable="ng" class="table table-striped table-bordered row-border hover">

                                        <thead>

                                            <tr>

                                                <th>Monday Start Time</th>

                                                <th>Monday End Time</th>

                                                <th>Tuesday Start Time</th>

                                                <th>Tuesday End Time</th>

                                                <th>Wednesday Start Time</th>

                                                <th>Wednesday End Time</th>

                                                <th>Thursday Start Time</th>

                                                <th>Thursday End Time</th>

                                                <th>Friday Start Time</th>

                                                <th>Friday End Time</th>
                                                <th></th>
                                                
                                            </tr>

                                        </thead>

                                        <tbody>

                                            <tr ng-repeat="b in breakdatalist">

                                                <td>{{b.monday_start_time}}</td>

                                                <td>{{b.monday_end_time}}</td>

                                                <td>{{b.tuesday_start_time}}</td>

                                                <td>{{b.tuesday_end_time}}</td>

                                                <td>{{b.wednesday_start_time}}</td>

                                                <td>{{b.wednesday_end_time}}</td>

                                                <td>{{b.thursday_start_time}}</td>

                                                <td>{{b.thursday_end_time}}</td>

                                                <td>{{b.friday_start_time}}</td>

                                                <td>{{b.friday_end_time}}</td>

                                                
                                                <td>

                                                    <a href="javascript:void(0)" ng-click="getbreakedit()" title="Edit" class="edit" >

                                                       <i class="fa fa-edit" aria-hidden="true"></i>

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
         <!-- Admin area -->
                <div ng-if="isAdmin">

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">Location</a>

                            </h4>

                        </div>

                        <div id="collapse5" class="panel-collapse collapse in">

                            <div class="panel-body">

                                <form class="form-inline">

                                    <div class="form-group">

                                        <label for="inputAdminEmail">Location:</label>

                                        <input  type="text" class="form-controller" name="inputLocation" id="inputLocation" ng-model="inputLocation">

                                            

                                    </div>

                                    <div class="form-group">

                                        <button type="button" ng-click="savelocation()" class="btn btn-primary location-btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>

                                    </div>

                                </form>

                                

                                 <table class="table table-bordered table-striped table-hover table-condensed" id="table-body-phase-tow" >

                                    <thead>

                                        <tr>

                                            <th>Location</th>

                                            <th>Options</th>

                                        </tr>

                                    </thead>

                                    <tbody id="reporttablebody-phase-two" class="report-body">

                                        <tr ng-repeat="c in citylist">

                                            <td>{{c.name}}</td>

                                             <td>

                                                <a href="javascript:void(0)" ng-click="editlocation(c.id)" title="Edit" class="edit">

                                                   <i class="fa fa-edit" aria-hidden="true"></i>

                                                </a>

                                                <a href="javascript:void(0)" ng-click="removelocation(c.id)" title="Delete"  class="del">

                                                 <i class="fa fa-remove" aria-hidden="true"></i>

                                                </a>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <h4 class="panel-title">

                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">School</a>

                            </h4>

                        </div>

                        <div id="collapse6" class="panel-collapse collapse">

                            <div class="panel-body">

                                <form class="form-inline">

                                    <div class="form-group">

                                        <label for="inputAdminEmail">Name:</label>

                                        <input  type="text" class="form-controller" name="inputSchoolName" id="inputSchoolName" ng-model="inputSchoolName">

                                    </div>

                                    <div class="form-group">

                                        <label for="inputAdminEmail">Location:</label>

                                        <select   ng-options="item.name for item in selectlistcity track by item.id"  name="inputSelectList" id="inputSelectList"  ng-model="inputSelectList"></select>

                                    </div>

                                    <div class="form-group">

                                        <button type="button" ng-click="saveschool()" class="btn btn-primary school-btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>

                                    </div>

                                </form>

                                 <table class="table table-bordered table-striped table-hover table-condensed" id="table-body-phase-tow" >

                                    <thead>

                                        <tr>

                                            <th>School</th>

                                            <th>Location</th>

                                            <th>Options</th>

                                        </tr>

                                    </thead>

                                    <tbody id="reporttablebody-phase-two" class="report-body">

                                        <tr ng-repeat="s in schoolarray">

                                            <td>{{s.name}}</td>

                                            <td>{{s.city_name}}</td>

                                             <td>

                                                <a href="javascript:void(0)" ng-click="editschool(s.id)" title="Edit" class="edit">

                                                   <i class="fa fa-edit" aria-hidden="true"></i>

                                                </a>

                                                <a href="javascript:void(0)" ng-click="removeschool(s.id)" title="Delete"  class="del">

                                                 <i class="fa fa-remove" aria-hidden="true"></i>

                                                </a>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>
                </div>



<?php

// require_footer

require APPPATH.'views/__layout/footer.php';

?>


<script src="<?php echo base_url();?>js/angular-messages.js"></script>

<script src="<?php echo base_url(); ?>js/settings/app.js"></script>

<script src="<?php echo base_url(); ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.timepicker.js?v=0.3.3"></script>
<script type="text/javascript">
    
    $(document).ready(function() 
       
    {
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
                
                defaultTime:'<?php if(isset($start_time)){echo date('H:i',strtotime($start_time));} ?>'

           });
           $('#InputEndTime').timepicker({
               showLeadingZero: false,
                showNowButton: false,
                nowButtonText: 'Now',

                minutes: {
                    starts: 0,                // First displayed minute
                    ends: 59,                 // Last displayed minute
                    interval: 5,              // Interval of displayed minutes
                    manual: []                // Optional extra entries for minutes
                },
                
                defaultTime:'<?php if(isset($end_time)){echo date('H:i',strtotime($end_time));} ?>'

           });
        });

        // when start time change, update minimum for end timepicker
       // when start time change, update minimum for end timepicker
        function tpStartSelect( time, endTimePickerInst ) {

           $('#InputEndTime').timepicker('option', {
               minTime: {
                   hour: endTimePickerInst.hours,
                   minute: endTimePickerInst.minutes
               }
           });
        }
       
            
        // Break Timing
        $('.breaktimepicker').timepicker({
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
                
                

           });    
            
           
            
            
        
</script>


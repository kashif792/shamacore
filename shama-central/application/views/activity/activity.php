<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/isteven-multi-selects.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?php echo base_url();?>js/ng-tags-input.js"></script>
<script src="<?php echo base_url();?>js/angularjs-dropdown-multiselect.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/commonservice.js"></script>
<link href="<?php echo $path_url; ?>css/easy-responsive-tabs.css" rel="stylesheet">
<link href="<?php echo $path_url; ?>css/ng-tags-input.css" rel="stylesheet">
<link href="<?php echo $path_url; ?>css/ng-tags-input.bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/isteven-multi-select.css">
<div class="col-sm-10" ng-controller="activity_ctrl" ng-init="loading=true">

<?php
    // require_footer 
    require APPPATH.'views/__layout/filterlayout.php';
?>
<div class="loading" ng-hide="loading == false">
        Loading&#8230;
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog" role="document" style="width: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="d-inline modal-title" >
                        <span >{{selectedactivity.title}}</span>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-body-video-bg">
                    <div class="row">
                        <div class="col-sm-1 text-center my-auto" ng-hide="currentactivityindex == 0 ">
                             <button  class="btn btn-circle btn-xl lessons-ctrl-btn NBbtnadmin"  ng-click="previousactivity()">
                                Back<br>
                                <span class="icon-left-big" aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="my-auto  text-center" ng-class="(playlist.length -1) == 0 ? 'col-sm-12' : 'col-sm-10'">
                            <div class="video-container" id="video-container" ng-hide="selectedactivity.type != 'v'"></div>
                            <div ng-hide="selectedactivity.type != 'g'" ng-include="selectedactivity.link"></div>
                             <div ng-hide="currentactivity.type != 'i'">
                                <img src="{{currentactivity.link}}" alt="currentactivity.file_name">
                            </div>
                        </div>
                        <div class="col-sm-1 text-center my-auto lesson-column" ng-hide="(playlist.length -1) == currentactivityindex">
                            <button class="btn btn-circle btn-xl lessons-ctrl-btn NBbtnadmin"  ng-click="nextlactivity()">
                                Next<br>
                                <span class="icon-right-big" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" ng-click="$dismiss()">&times;</button>
            <h5 class="modal-title">
                Activity
            </h5>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-hover">
                <tr>
                    <th>Title</th>
                    <td colspan="3">{{selectedactivity.title}}</td>
                </tr>
                <tr>
                    <th>View date</th>
                    <td>{{selectedactivity.view_date}}</td>
                    <th>Status</th>
                    <td >{{selectedactivity.status}}</td>
                </tr>
                 <tr class="hide">
                    <th>Graded</th>
                    <td>{{selectedactivity.graded}}</td>
                    <th>Language</th>
                    <td >{{selectedactivity.language}}</td>
                </tr>
                <tr >
                    <th>Repeat</th>
                    <td >{{selectedactivity.repeat}}</td>
                     <th >Age Limit</th>
                    <td >{{selectedactivity.age}}</td>
                </tr>
                <tr class="hide">
                    <th class="hide">Source Type</th>
                    <td class="hide">{{selectedactivity.source_type}}</td>
                </tr>
                <tr>
                    <th>Grades</th>
                    <td colspan="3">
                      <label ng-repeat="value in selectedactivity.class_display">
                        {{value.name}} <span ng-hide="$last">,</span>&nbsp;&nbsp; 
                      </label>
                    </td>
                </tr>
                <tr>
                    <th>Subjects</th>
                    <td colspan="3">
                      <label ng-repeat="value in selectedactivity.subject_display">
                        {{value.name}} ({{value.class}}) <span ng-hide="$last">,</span>&nbsp;&nbsp;
                      </label>
                    </td>
                </tr>
                <tr>
                    <th>Semester</th>
                    <td colspan="3">
                      <label ng-repeat="value in selectedactivity.semester_display">
                        {{value.name}} <span ng-hide="$last">,</span>&nbsp;&nbsp;
                      </label>
                    </td>
                </tr>
                <tr>
                    <th>Tags</th>
                    <td colspan="3">
                      <label ng-repeat="value in selectedactivity.tags">
                        {{value.text}} <span ng-hide="$last">,</span>
                      </label>
                    </td>
                </tr>
            </table>
        </div>
    </script>
     <script type="text/ng-template" id="deleteModalContent.html">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" ng-click="$dismiss()">&times;</button>
            <h5 class="modal-title">
                Remove
            </h5>
        </div>
        <div class="modal-body">
            <p>Are you sure do you want to remove this record?</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" ng-click="$dismiss()">No</button>
            <button class="btn btn-warning" type="button" ng-click="removerow()">Yes</button>
        </div>
    </script>
      <script type="text/ng-template" id="deleteLinkModal.html">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" ng-click="$dismiss()">&times;</button>
            <h5 class="modal-title">
                Remove link
            </h5>
        </div>
        <div class="modal-body">
            <p>Are you sure do you want to remove this record?</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" ng-click="$dismiss()">No</button>
            <button class="btn btn-warning" type="button" ng-click="removelink()">Yes</button>
        </div>
    </script>
    <?php 
        $roles = $this->session->userdata('roles');
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <label>Activity
                &nbsp;&nbsp;&nbsp;
                <?php 
                    if(count($classlist)){
                ?>
                <button ng-click="changeview('f')" ng-hide="defaultview == 'f'" class="btn btn-primary" style="color: #fff !important;">Add Activity</button>
                <?php } ?>
            </label>
        </div>
        <div class="panel-body" ng-init="defaultview = 't'" >

            <div id="table" ng-hide="defaultview != 't'">
                <table datatable="ng" dt-options="dtOptions"  class="table table-striped table-bordered row-border hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>View Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                      <tfoot>
                        <tr>
                            <th></th>
                            <th>All</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody id="reporttablebody-phase-two" class="report-body">
                        <tr ng-repeat="c in activitylist" ng-init="$last && finished()">
                           <td class="row-bar-user" ng-click="viewdetail(c)">{{c.title | limitTo:50 }}</td>
                           <td class="row-bar-user" ng-click="viewdetail(c)">{{c.status}}</td>
                           <td>
                                <a  href="javascript:void(0);" ng-click="playactivity(c)">
                                    <i class="fa fa-play-circle" aria-hidden="true"></i>
                                </a>
                                 <a  href="javascript:void(0);" ng-click="viewdetail(c)">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a  href="javascript:void(0);" ng-click="editetail(c)">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a  href="javascript:void(0);" ng-click="removeactivity(c)">
                                    <i class="fa fa-remove" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="form" ng-hide="defaultview != 'f'">
                <form class="form-horizontal" name="ActivityForm" ng-submit="saveActivity(activityobj)" novalidate  method="post" enctype="multipart/form-data">
                    <input type="hidden" value="" name="serial" id="serial" ng-model="activityobj.id">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label>Grade: &nbsp;&nbsp; <input type="checkbox" name="" ng-click="toggleAll()" ng-model="isAllSelected">&nbsp;&nbsp; All</label><br>
                            <label ng-repeat="(key, value) in classlist">
                                <input type="checkbox" name="grades" ng-model="value.isselected" ng-change="checkgrade()">&nbsp;&nbsp;&nbsp; {{value.name}} &nbsp;&nbsp;&nbsp;
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <label>Subject:</label><br>
                            <div     
                                isteven-multi-select
                                input-model="subjectlist"
                                output-model="activityobj.subject"
                                button-label="name"
                                item-label="name"
                                tick-property="ticked"
                                max-height="250px"
                                output-properties="id"
                            >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label>Semester:</label><br>
                             <label ng-repeat="(key, value) in semesterlist">
                                <input type="checkbox" name="" tabindex="3" ng-model="value.isselected">&nbsp;&nbsp;&nbsp; {{value.name}} &nbsp;&nbsp;&nbsp;
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label>Title: <span class="required">*</span></label>
                            <input type="text" id="activityobj.title" class="form-control" name="title"  ng-model="activityobj.title" placeholder="Title"  tabindex="4" value="" ng-minlength="3" ng-maxlength="256"  required>                       
                            <div ng-hide="title_message" style="color: red;">
                                <div >Please enter 3-256 character title</div>
                            </div>
                        </div>
                        <div class="col-sm-3 hide">
                            <label>Type: <span class="required">*</span></label>
                            <select ng-options="item.title for item in typelist track by item.id"  name="activityobj.type" id="activityobj.type"  class="form-control" tabindex="5" ng-model="activityobj.type"></select>
                        </div>
                       
                        <div class="col-sm-3">
                            <label>Status: <span class="required">*</span></label>
                           <select ng-options="item.title for item in statuslist track by item.id"  name="activityobj.status" id="activityobj.status"  class="form-control" tabindex="7" ng-model="activityobj.status"></select>                 
                        </div>
                        <div class="col-sm-2 hide">
                            <label>Marks:</label>
                            <input type="number" class="form-control" tabindex="11" id="activityobj.marks" ng-model="activityobj.marks" tabindex="8" name="activityobj.marks"  placeholder="Marks" value="">
                            <span class="errorhide" id="teacher_nic">Please enter CNIC #</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 hide">
                            <label>Graded: <span class="required">*</span></label>
                            <div class="radio">
                                <label ng-repeat="g in gradedstatus">
                                    &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="activityobj.graded" ng-model="activityobj.graded"  value="{{g.value}}" tabindex="9"> {{g.title}} </label>
                            </div>
                        </div>
                        <div class="col-sm-2 hide">
                            <label>Apply on Semester Lesson Plan: <span class="required">*</span></label>
                            <div class="radio">
                                <label ng-repeat="g in gradedstatus">
                                    &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="activityobj.slp" ng-model="activityobj.slp"  value="{{g.value}}" tabindex="10"> {{g.title}} </label>
                            </div>
                            <span class="errorhide" id="lname_error">Please enter last name</span>
                        </div>
                        <div class="col-sm-3">
                            <label>View Date:</label>
                            <input type="date"  class="form-control" 
                                ng-model="activityobj.view_date" clearable="true" tabindex="11"/>
                             <!-- <input date-range-picker  class="form-control date-picker" 
                                ng-model="activityobj.view_date" clearable="true" type="text" options="activityobj.options" tabindex="11"/> -->
                        </div>
                        
                          <div class="col-sm-3">
                            <label>Repeat (for days) :</label>
                            <input type="number" min="0" id="activityobj.repeat" class="form-control" name="activityobj.repeat"  ng-model="activityobj.repeat" placeholder="Repeat"  tabindex="12" value="">                       
                            <span class="errorhide" id="lname_error">Please enter last name</span>
                        </div>
                        <div class="col-sm-3">
                          <label>Age:</label>
                            <input type="number" min="5" max="15" class="form-control"  id="activityobj.age" ng-model="activityobj.age" name="activityobj.age"  tabindex="13" placeholder="Age" value="">
                            <span class="errorhide" id="teacher_nic">Please enter CNIC #</span>
                        </div>
                        <div class="col-sm-3">
                            <label>Language:</label>
                            <input type="text" id="activityobj.language" class="form-control" name="activityobj.language"  ng-model="activityobj.language" placeholder="Language"  tabindex="14" value="">                       
                            <span class="errorhide" id="lname_error">Please enter last name</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label>Upload: <span class="required">*</span></label>
                            <div id="cartoon_container">
                                <ul class="resp-tabs-list vert">
                                    <li class="">Upload File</li>
                                    <li>Link</li>
                                </ul>
                                <div class="resp-tabs-container vert">

                                    <div id="uploadfile-tab" class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <ul>
                                                    <li ng-repeat="(key, value) in activityobj.links">
                                                        <span ng-hide="value.name == ''">{{value.link}} |</span> 
                                                        <span ng-hide="value.name != ''">{{value.name}} |</span> 
                                                        <a href="#" id="remove_3" data-image="" ng-click="showRemoveDialoag(value.id)">Remove</a>   
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="col-sm-12 activit-file">
                                                    <input type="file" name="file_one" tabindex="15" value="">    
                                                </div>
                                                <div class="col-sm-12 activit-file">
                                                    <input type="file" name="file_two" tabindex="15" value="">    
                                                </div>
                                                <div class="col-sm-12 activit-file">
                                                    <input type="file" name="file_three" tabindex="15" value="">    
                                                </div>    
                                            </div>
                                             <div class="col-sm-3" >
                                                <div ng-repeat="(key, value) in inputfiletype" class="upload-file-type-row">
                                                    <select ng-options="item.title for item in typelist track by item.id"  name="activityobj.type" id="activityobj.type"  class="form-control" tabindex="5" ng-model="value.id"></select>
                                                </div>
                                            </div>
                                             <div class="col-sm-4">
                                                <div class="upload-file-type-row" ng-repeat="(key, value) in sourcefileinput" class="upload-file-type-row" >
                                                     <select ng-options="item.value for item in sourcelist track by item.id"  name="source" id="activityobj.type"  class="form-control" tabindex="5" ng-model="value.id"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="link-tab" class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="col-sm-12" style="margin-bottom: 1rem;">
                                                    <input type="text" name="activityobj.first_link" class="form-control"  ng-model="activityobj.first_link"  tabindex="16" value="">    
                                                </div>
                                                <div class="col-sm-12 " style="margin-bottom: 1rem;">
                                                    <input type="text" name="activityobj.second_link" class="form-control"  ng-model="activityobj.second_link"  tabindex="16" value="">  
                                                </div>
                                                <div class="col-sm-12 " style="margin-bottom: 1rem;">
                                                    <input type="text" name="activityobj.third_link" class="form-control"  ng-model="activityobj.third_link"  tabindex="16" value="">    
                                                </div>    
                                            </div>
                                             <div class="col-sm-3" >
                                                <div ng-repeat="(key, value) in inputurltype" class="upload-file-type-row">
                                                    <select ng-options="item.title for item in typelist track by item.id"  name="activityobj.type" id="activityobj.type"  class="form-control" tabindex="5" ng-model="value.id"></select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="upload-file-type-row" ng-repeat="(key, value) in sourceurlinput" class="upload-file-type-row">
                                                     <select ng-options="item.value for item in sourcelist track by item.id"  name="source" id="activityobj.type"  class="form-control" tabindex="5" ng-model="value.id"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div ng-hide="file_url" style="color: red;">
                                    <p >File is required</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Remarks:</label>
                            <tags-input ng-model="activityobj.tags" tabindex="17" 
                                    add-on-paste="true"
                                    replace-spaces-with-dashes="false">
                                <auto-complete 
                                    source="loadTags($query)"
                                    min-length="0"
                                    load-on-focus="true"
                                    load-on-empty="true"
                                    max-results-to-show="32"
                                    ></auto-complete>
                            </tags-input>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" ng-init="usersavebtntext = 'Save';"  tabindex="18" class="btn btn-primary" >
                                <span ng-show="usersavebtntext == 'Saving'">
                                    <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>
                                </span>
                                {{usersavebtntext}}
                            </button>
                            <a  href="javascript:void(0)" ng-click="changeview('t')"  title="cancel" tabindex="19">Cancel</a>
                        </div>
                    </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<?php

// require_footer 

require APPPATH.'views/__layout/footer.php';

?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/angular-datatables.css">

<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jwplayer.js"></script>
<script>jwplayer.key="/JmQcOJTGP/OIWIzj4RXqX/gpB1mVD9Br1vyxg==";</script>
<script src="<?php echo base_url(); ?>js/jquery.easyResponsiveTabs.js"></script>
<script src="<?php echo base_url();?>js/angular-messages.js"></script>
<script src="<?php echo base_url();?>js/ui-bootstrap-tpls-2.5.0.js"></script>
<script src="<?php echo base_url();?>js/dataTables.columnFilter.js"></script>
<script src="<?php echo base_url();?>js/angular-datatables.columnfilter.min.js"></script>
<script src="<?php echo base_url();?>js/isteven-multi-select.js"></script>

<link href="<?php echo base_url();?>css/cjquery-ui.css" rel="stylesheet">


<script data-require="ui-bootstrap@*" data-semver="0.12.1" src="<?php echo  base_url(); ?>js/ui-bootstrap-tpls-0.12.1.min.js"></script>
<script type="text/javascript">

    app.controller('ModalInstanceCtrl', ['$scope', '$modalInstance', function ($scope, $modalInstance) {
        $scope.ok = function () {
            $modalInstance.close('this is result for close');
        };

        $scope.cancel = function () {
            $modalInstance.dismiss('this is result for dismiss');
        };
    }]);

    app.controller('deleteModalInstanceCtrl', ['$scope', '$modalInstance','$http', function ($scope, $modalInstance,$http) {
        $scope.removerow  = function()
        {
            var data = {
                serail: $scope.selectedremoveactivity.id
            }

            $http({
                method: 'POST',
                url: "<?php echo base_url(); ?>removeactivity",
                data: data,
            }).success(function (response) {
                 if(response.message == true)
                {
                    $scope.selectedremoveactivity ={};
                    $scope.getactivities();
                    $scope.$dismiss();
                }else
                {
                    $scope.selectedremoveactivity ={};
                    alert("record not removed")
                    $scope.$dismiss();
                }
            })
            .error(function(){
                $scope.usersavebtntext = "Save";
            });
        }
    }]);

    app.controller('deleteLinkModalCtrl', ['$scope', '$modalInstance','$http', function ($scope, $modalInstance,$http) {
        $scope.removelink  = function()
        {
            var data = {
                serail: $scope.selectedlink
            }

            $http({
                method: 'POST',
                url: "<?php echo base_url(); ?>removelink",
                data: data,
            }).success(function (response) {
                 if(response.message == true)
                {
                    
                    var index = $scope.playlist.indexOf(m=> m.id = $scope.selectedlink);
                    if (index > -1) {
                      $scope.playlist.splice(index, 1);
                    }
                    $scope.selectedlink ={};
                    $scope.$dismiss();
                }else
                {
                    $scope.selectedlink ={};
                    alert("record not removed")
                    $scope.$dismiss();
                }
            })
            .error(function(){
                $scope.usersavebtntext = "Save";
            });
        }
    }]);

    $('#cartoon_container').easyResponsiveTabs({ tabidentify: 'vert' });
    
    app.controller('activity_ctrl',function($scope,$http,$interval,commonservice,DTOptionsBuilder,$filter,$modal,$rootScope,$window){
        $scope.commonobj = commonservice;
        $scope.activitylist = null;
        $scope.subjectlist = [];
        $scope.file_url = true;
        $scope.title_message = true;
        $scope.playlist = [];
        $scope.currentactivityindex = 0;
        $scope.currentactivity = {};

        $scope.typelist = [
            {
                id:'v',
                title:'Video'
            },
            {
                id:'g',
                title:'Game'
            }
        ];

        $scope.inputfiletype = [
            {
                id:1
            },
            {
                id:2
            },
            {
                id:3
            }
        ];

        angular.forEach($scope.inputfiletype, function(value, key){
            value.id = $scope.typelist[0];
        });
        
        $scope.inputurltype = [
            {
                id:1
            },
            {
                id:2
            },
            {
                id:3
            }
        ];

        $scope.sourceurlinput = [
            {
                id:1
            },
            {
                id:2
            },
            {
                id:3
            }
        ];

        $scope.sourcefileinput = [
            {
                id:1
            },
            {
                id:2
            },
            {
                id:3
            }
        ];

         $scope.sourcelist = [
            {
                id:'i',
                value:'Internal',
            },
            {
                id:'e',
                value:'External',
            }
        ];

        $scope.defaultSourceList = function()
        {
            angular.forEach($scope.sourceurlinput, function(value, key){
                value.id = $scope.sourcelist[0];
            });


            angular.forEach($scope.sourcefileinput, function(value, key){
                value.id = $scope.sourcelist[0];
            });
        }

        $scope.defaultSourceList();

        angular.forEach($scope.inputurltype, function(value, key){
            value.id = $scope.typelist[0];
        });

        $scope.getactivities= function()
        {
            $scope.commonobj.postrequest('getactivitylist',({})).then(function(response){
                if(response.length > 0)
                {
                    $scope.activitylist = response;
                    $scope.defaultview = 't';

                }
                else{
                    $scope.loading = false;
                }
            });
        }
        
        $scope.selectedremoveactivity = null;
        $scope.removeactivity = function(activity)
        {
            $scope.deleteModal =  $modal.open({
                templateUrl: 'deleteModalContent.html',
                controller: 'deleteModalInstanceCtrl',
                scope: $scope,
            });
            $scope.selectedremoveactivity = activity;
        }

        $scope.getactivities();

        $scope.finished = function()
        {
            $scope.loading = false;
        }

        $scope.dtOptions = DTOptionsBuilder.fromSource($scope.activitylist)
        .withDisplayLength(25)
        .withColumnFilter({
            aoColumns: [ 
                {
                    type: 'text',
                    bRegex: true,
                    bSmart: true
                },  {
                    type: 'select',
                    bRegex: false,
                     values: ['Active', 'Inactive']
                }
            ]
        });

        $scope.activityobj = {};
        $scope.activityobj.id = '';

        var playerInstance = jwplayer("video-container");
        // player config

        $scope.checkgrade =function()
        {
            $scope.allselected = true;
            angular.forEach($scope.classlist, function(value, key){
                if(!value.isselected)
                {
                    $scope.isAllSelected = false;
                    $scope.allselected = false;
                }
            });
            if($scope.allselected)
            {
                $scope.isAllSelected = true;
            }
        }

        function playvideo()
        {
            try{
                var file_location = $scope.currentactivity.link;
          
                playerInstance.setup({
                    autostart:'true',
                    file: file_location,
                    name:$scope.selectedactivity.title,
                    stretching: "exactfit",
                    width: "100%",
                    aspectratio: "24:10",
                    image: "",
                    controlbar:false,
                    events:{
                        onComplete: function() {
                            $scope.videocompeleted();
                        },
                        onPlay:function()
                        {

                        },
                        onPause:function()
                        {
                        },
                        onError:function() {
                            stopplayer();
                            alert("Content not available");
                        }
                    }
                });
                $("#myModal").modal();
                
            }
            catch(e){
                console.log(e)
            }
        }

        $scope.playactivity = function(c)
        {
            $scope.selectedactivity = {};
            $scope.selectedactivity = c;

            setPlaylist($scope.selectedactivity.links);
            setCurrentActivity();
            playerInstance.remove();
            playActivity();
        }

        $scope.videocompeleted = function() 
        {
            try{
                moveToNext();
            }
            catch(e){}
        };

        function playActivity()
        {
            if($scope.currentactivity.type == 'g')
            {
                if($scope.currentactivity.source == 'e')
                {
                     $window.location.href = $scope.currentactivity.link;
                }
                else{
                    $scope.starttime = 0;
                    $scope.loading = false; 
                    $("#myModal").modal();
                }
            }
             else if($scope.currentactivity.type == 'i'){
                if($scope.currentactivity.source == 'e')
                {
                     $window.location.href = $scope.currentactivity.link;
                }
                else{
                   $scope.starttime = 0;
                    $scope.loading = false; 
                    $("#myModal").modal();
                }
            }
            else{
                if($scope.currentactivity.source == 'e')
                {
                     $window.location.href = $scope.currentactivity.link;
                }
                else{
                   playvideo();
                }
            }
        }

        function setCurrentActivity()
        {
            try{
                if($scope.currentactivityindex == 0)
                   $scope.currentactivity = $scope.playlist[$scope.currentactivityindex];
                if(($scope.playlist.length - 1) <= $scope.currentactivityindex)
                    $scope.currentactivity = $scope.playlist[$scope.currentactivityindex];
            }
            catch(e){
                console.log("index not found")
            }
        }

        function setPlaylist(playlist)
        {
            $scope.playlist = playlist;
        }

        function getCurrentIndex()
        {
             return $scope.playlist.indexOf(i => i.id == $scope.currentactivity.id);
        }

        function moveToNext()
        {
            $scope.currentactivityindex++;
            setCurrentActivity();
            playActivity();
        }

        $scope.previousactivity = function()
        {
            $scope.currentactivityindex--;
            setCurrentActivity();
            playActivity();
        }

        $scope.nextlactivity = function()
        {
            $scope.currentactivityindex++;
            setCurrentActivity();
            playActivity();
        }

        function stopplayer()
        {
            playerInstance.stop();
        }

        angular.element("#myModal").on("hidden.bs.modal", function () {
             stopplayer();
        });

        $scope.viewdetail = function(c)
        {
            $scope.selectedactivity = c;
            $scope.openModal();
        } 

        $scope.openModal = function()
        {
            $scope.theModal =  $modal.open({
                templateUrl: 'myModalContent.html',
                controller: 'ModalInstanceCtrl',
                scope: $scope,
            });
            
            $scope.theModal.result.then(
                function (result) {
                    $scope.selectedactivity = {};
                },
                function (result) {
                    $scope.selectedactivity = {};
                }
            );
        }

        $scope.statuslist = [
            {
                id:'a',
                title:'Active'
            },
            {
                id:'i',
                title:'Inactive'
            }
        ];
        $scope.activityobj.status = $scope.statuslist[0];


        $scope.gradedstatus = [
            {
                title:'Yes',
                value:'y'
            },
            {
                title:'No',
                value:'n'
            }
        ];

        $scope.activityobj.graded = $scope.gradedstatus[0].value;
        $scope.activityobj.slp = $scope.gradedstatus[0].value;

       

        $scope.activityobj.source = $scope.sourcelist[0].value;
        $scope.setDefaultClassValues = function(response)
        {
            angular.forEach(response, function(value, key){
                value.isselected = false;                            
            });
             
            $scope.classlist = response;
            $scope.isAllSelected = false;   
        }

        $scope.getClassList = function()
        {
            $scope.commonobj.postrequest('classlist',({})).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.setDefaultClassValues(response);
                }
            });
        }
        $scope.getClassList();

        $scope.toggleAll = function() {
            angular.forEach( $scope.classlist, function(itm){
                if($scope.isAllSelected)
                {
                    itm.isselected = true ;
                }
                else{
                    itm.isselected = false ;
                }
                 
            });
        }

        $scope.loadTags = function($query) {
             
            return $scope.searchertags.filter(function(tag) {
                return tag.text.toLowerCase().indexOf($query.toLowerCase()) != -1;
            });
        };

        var tempobj = {};
        $scope.changeview = function(viewtype)
        {
            if(viewtype == 't')
            {
                $scope.getactivities();
            }

            $scope.setDefaultClassValues($scope.classlist);
            $scope.setDefaultSubjectValues($scope.allsubjectslist);
            $scope.setDefaultSemesterValues($scope.semesterlist);
            $scope.activityobj.status = $scope.statuslist[0];
            //$scope.activityobj.source = $scope.sourcelist[0].value;
            $scope.activityobj.title = '';
            $scope.activityobj.date = '';
            $scope.activityobj.repeat = '';
            $scope.activityobj.age = '';
            $scope.activityobj.language = '';
            $scope.activityobj.tags = '';
            $scope.activityobj.id = '';
            $scope.setDefaultUpload();
            $scope.defaultSourceList();
            $scope.defaultview = viewtype;
        }

        function matchStart(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Skip if there is no 'children' property
            if (typeof data.children === 'undefined') {
                return null;
            }

            // `data.children` contains the actual options that we are matching against
            var filteredChildren = [];
            $.each(data.children, function (idx, child) {
                if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                    filteredChildren.push(child);
                }
            });

            // If we matched any of the timezone group's children, then set the matched children on the group
            // and return the group object
            if (filteredChildren.length) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.children = filteredChildren;

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }
            // Return `null` if the term should not be displayed
            return null;
        }

        $scope.defaulttags = function() 
        {
            try{
                $scope.commonobj.getrequest('<?php echo $path_url; ?>gettags',({})).then(function(response){
                    if(response.status == true)
                    {
                       $scope.searchertags = response.message;
                    }
                });
            }
            catch(ex){
                console.log(ex)
            }
        };

        $scope.defaulttags();

        $scope.setDefaultSubjectValues = function(response)
        {
            $scope.allsubjectslist = response;
            $scope.subjectlist = [];
            angular.forEach(response, function(value, key){
                var temp = {
                    id: value.subjectid,
                    name: value.subject+" ("+value.classname+")",
                    ticked:false
                }
                $scope.subjectlist.push(temp);                             
            });
        }

        $scope.getSubjectList= function()
        {
            try{
                $scope.commonobj.getrequest('<?php echo $path_url; ?>getsubjectbyclass',({})).then(function(response){
                    if(response.status == true)
                    {
                        $scope.setDefaultSubjectValues(response.message);
                    }
                    else
                    {
                        $scope.allsubjectslist = [];
                        $scope.subjectlist = [];
                    }
                });
            }
            catch(ex){}
        }
        $scope.getSubjectList();

        $scope.setDefaultSemesterValues = function(response)
        {
            angular.forEach(response, function(value, key){
                value.isselected = false;                            
            });
            $scope.semesterlist = response;
        }

        $scope.getSemesterData= function(){
            try{
                $scope.semesterlist = []
                $scope.commonobj.postrequest('<?php echo $path_url; ?>semester_detail',({})).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.setDefaultSemesterValues(response);
                    }
                    else{
                        $scope.semesterlist = [];
                    }
                });

            }
            catch(ex){}
        }
        $scope.getSemesterData();

        defaultdate();
        function defaultdate()
        {
            try{
                $scope.activityobj.startDate = null;
                $scope.activityobj.options = {
                    timePicker: false,
                    autoUpdateInput: true,
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale:{format:'MM/DD/YYYY'},
                    eventHandlers:{
                        'apply.daterangepicker': function(ev, picker){}
                    }
                }
                
                //Watch for date changes
                $scope.$watch('semesterdetail.date', function(newDate) {
                }, false);
               
            }
            catch(ex)
            {
                console.log(ex)
            }
        }

        $scope.setClass = function(c)
        {
            angular.forEach($scope.classlist , function(value, key){
                $scope.selectedclass = $filter('filter')(c.class_array,{class_id:value.id},true);
                if($scope.selectedclass.length > 0)
                {
                    $scope.classlist[key].isselected = true;
                }else{
                    $scope.classlist[key].isselected = false;
                }   
            });

            if($scope.classlist.length == c.class_array.length)
            {
                $scope.isAllSelected = true;
            }
        }

        $scope.setSubjects = function()
        {
            try{
                var data =[];
                angular.forEach($scope.allsubjectslist, function(value, key){
                    $scope.selectedsubject = $filter('filter')($scope.activityobj.subject_array,{subjectid:value.subjectid},true);
                    if($scope.selectedsubject.length > 0)
                    {
                        $scope.subjectlist[key].ticked = true
                    }
                    else{
                        $scope.subjectlist[key].ticked = false
                    }  
                }); 
            }
            catch(ex){}
        }

        $scope.setActivitySemester = function()
        {
            angular.forEach($scope.semesterlist, function(value, key){
                $scope.selectedsemester = $filter('filter')($scope.activityobj.semester_array,{semester_id:value.id},true);
                if($scope.selectedsemester.length > 0)
                {
                    $scope.semesterlist[key].isselected = true;
                }else{
                    $scope.semesterlist[key].isselected = false;
                }    
            }); 
        }

        $scope.setType = function(c)
        {
            $scope.selectedtype = $filter('filter')($scope.typelist,{id:c.type},true);
            if($scope.selectedtype.length > 0)
            {
                $scope.activityobj.type = $scope.selectedtype[0];
            }    
        }

        $scope.setStatus = function(c)
        {
            $scope.selectedstatus = $filter('filter')($scope.statuslist,{id:c.status_key},true);
            if($scope.selectedstatus.length > 0)
            {
                $scope.activityobj.status = $scope.selectedstatus[0];
            }  
        }

        $scope.setLinks = function()
        {
            try{
                $scope.linkslist = $scope.activityobj.links.filter(m => m.file_name != null );
                if($scope.linkslist.length > 0)
                {
                    angular.forEach($scope.inputfiletype, function(value, key){
                        if($scope.linkslist[key].file_row == 1)
                        {
                            $scope.selectedtype = $scope.typelist.findIndex(m => m.id == $scope.linkslist[key].type);
                            value.id = $scope.typelist[$scope.selectedtype]
                            $scope.selectedtype = $scope.sourcelist.findIndex(m => m.id == $scope.linkslist[key].source);
                            $scope.sourcefileinput[0].id = $scope.sourcelist[$scope.selectedtype];
                        }

                        if($scope.linkslist[key].file_row == 2)
                        {
                            $scope.selectedtype = $scope.typelist.findIndex(m=>m.id == $scope.linkslist[key].type);
                            value.id = $scope.typelist[$scope.selectedtype]
                            $scope.activityobj.second_link = $scope.linkslist[key].link;
                            $scope.selectedtype = $scope.sourcelist.findIndex(m => m.id == $scope.linkslist[key].source);
                            $scope.sourcefileinput[1].id = $scope.sourcelist[$scope.selectedtype];
                        }
                        if($scope.linkslist[key].file_row == 3)
                        {
                            $scope.selectedtype = $scope.typelist.findIndex(m=>m.id == $scope.linkslist[key].type);
                            value.id = $scope.typelist[$scope.selectedtype]
                            $scope.activityobj.third_link = $scope.linkslist[key].link;
                            $scope.selectedtype = $scope.sourcelist.findIndex(m => m.id == $scope.linkslist[key].source);
                            $scope.sourcefileinput[2].id = $scope.sourcelist[$scope.selectedtype];
                        }
                    });

                    angular.forEach($scope.inputurltype, function(value, key){
                        if($scope.linkslist[key].file_row == 4)
                        {
                            $scope.selectedtype = $scope.typelist.findIndex(m => m.id == $scope.linkslist[key].type);
                            value.id = $scope.typelist[$scope.selectedtype]
                            $scope.selectedtype = $scope.sourcelist.findIndex(m => m.id == $scope.linkslist[key].source);
                            $scope.sourceurlinput[0].id = $scope.sourcelist[$scope.selectedtype];
                        }

                        if($scope.linkslist[key].file_row == 5)
                        {
                            $scope.selectedtype = $scope.typelist.findIndex(m=>m.id == $scope.linkslist[key].type);
                            value.id = $scope.typelist[$scope.selectedtype]
                            $scope.activityobj.second_link = $scope.linkslist[key].link;
                            $scope.selectedtype = $scope.sourcelist.findIndex(m => m.id == $scope.linkslist[key].source);
                            $scope.sourceurlinput[1].id = $scope.sourcelist[$scope.selectedtype];
                        }
                        if($scope.linkslist[key].file_row == 6)
                        {
                            $scope.selectedtype = $scope.typelist.findIndex(m=>m.id == $scope.linkslist[key].type);
                            value.id = $scope.typelist[$scope.selectedtype]
                            $scope.activityobj.third_link = $scope.linkslist[key].link;
                            $scope.selectedtype = $scope.sourcelist.findIndex(m => m.id == $scope.linkslist[key].source);
                            $scope.sourceurlinput[2].id = $scope.sourcelist[$scope.selectedtype];
                        }
                    });
                }
            }
            catch(e){}
        }

        $scope.setDefaultUpload = function()
        {
            $('input[name="file_one"]').val('')  ;
            $('input[name="file_two"]').val('')  ;
            $('input[name="file_three"]').val('')  ;
            $scope.activityobj.first_link = '';
            $scope.activityobj.second_link = '';
            $scope.activityobj.third_link = '';
            angular.forEach($scope.inputfiletype, function(value, key){
                value.id = $scope.typelist[0];
            });
            
            angular.forEach($scope.inputurltype, function(value, key){
                value.id = $scope.typelist[0];
            });
        }



        $scope.editetail = function(c)
        {
            
            $scope.activityobj = c;
            $scope.setClass(c);
            $scope.setActivitySemester();
            $scope.setSubjects();
            $scope.setType(c);
            $scope.setStatus(c);
            $scope.setLinks();
            $scope.activityobj.view_date = new Date(c.view_date)
           // $scope.activityobj.source = c.source_type_key;
            $scope.defaultview = 'f';
        }

        $scope.showRemoveDialoag = function(link)
        {
            $scope.deleteModal =  $modal.open({
                templateUrl: 'deleteLinkModal.html',
                controller: 'deleteLinkModalCtrl',
                scope: $scope,
            });
            $scope.selectedlink = link;
        }

        function checkValidation(file)
        {
            var size, ext ;
            size = file.size;
            ext = file.name.toLowerCase().trim();
            ext = ext.substring(ext.lastIndexOf('.') + 1);
            ext = ext.toLowerCase();
            var validExt = ["mp4","3gpp","png","jpg","gif"];
            if($.inArray(ext,validExt) == -1){
                message("Please must upload text file","show");
                return false;
            }
            else{
               message("","hide");
            }

            if(size > 50000000 ){
                alert("File must be less than 5MB")
                return false;
            }

            return true;
        }

        $scope.saveActivity = function(c)
        {
            try{
                if(c.title.length >=3 ){
                    $scope.file_url = true;
                    $scope.title_message = true;
                    var formdata = new FormData();
                    formdata.append('serail',c.id);
                    $scope.selected_grades = [];
                    angular.forEach($scope.classlist, function(value, key){
                        if(value.isselected)
                        {
                            var temp = {
                                id:value.id
                            };
                            $scope.selected_grades.push(temp)
                        }                           
                    });
                    formdata.append('grades',JSON.stringify($scope.selected_grades));

                    $scope.selected_subjects = [];
                    
                    angular.forEach(c.subject, function(value, key){
                        var findActiveIndex = $scope.allsubjectslist.findIndex(m => m.subjectid  == value.id);
                        $scope.selected_subjects.push($scope.allsubjectslist[findActiveIndex])  ;                 
                    });
                    formdata.append('subjects',JSON.stringify($scope.selected_subjects));

                    $scope.selected_semesters = [];
                    angular.forEach($scope.semesterlist, function(value, key){
                        if(value.isselected)
                        {
                            var temp = {
                                id:value.id
                            };
                            $scope.selected_semesters.push(temp)
                        }                           
                    });

                    formdata.append('semester',JSON.stringify($scope.selected_semesters));
                    formdata.append('title',c.title);
                    formdata.append('view_date',moment(c.view_date));
                    formdata.append('status',c.status.id);
                    formdata.append('source_type','i');
                    formdata.append('marks',c.marks);
                    formdata.append('repeat',(c.repeat == '' ? 0 : c.repeat));
                    formdata.append('age',(c.age == '' ? 5 : c.age));
                    formdata.append('language',c.language);
                    formdata.append('tags',JSON.stringify(c.tags));
                    
                    $scope.file_found = false;
                    var file_one = $('input[name="file_one"]')[0].files[0];
                    if(file_one != null && file_one != '')
                    {
                        if(checkValidation(file_one))
                        {
                            formdata.append('file_one',$('input[name="file_one"]')[0].files[0]);   
                            formdata.append('file_one_type',$scope.inputfiletype[0].id.id); 
                            formdata.append('file_one_source',$scope.sourcefileinput[0].id.id); 
                            // if(typeof c.links[0].file_row != 'undefined')
                            // {
                            //     formdata.append('link_file_row_one',c.links[0].file_row);
                            // }
                            $scope.file_found = true;
                        }
                        
                    }

                    var file_two = $('input[name="file_two"]')[0].files[0];
                    if(file_two != null && file_two != '')
                    {
                        if(checkValidation(file_two))
                        {
                            formdata.append('file_two',$('input[name="file_two"]')[0].files[0]);  
                            formdata.append('file_two_type',$scope.inputfiletype[1].id.id); 
                            formdata.append('file_two_source',$scope.sourcefileinput[1].id.id);
                            // if(typeof c.links[1].file_row != 'undefined') 
                            // {
                            //     formdata.append('link_file_row_two',c.links[1].file_row);
                            // }
                            
                            $scope.file_found = true; 
                        }

                    }

                    var file_three = $('input[name="file_three"]')[0].files[0];
                    if(file_three != null && file_three != '')
                    {
                        if(checkValidation(file_three))
                        {
                            formdata.append('file_three',$('input[name="file_three"]')[0].files[0]);    
                            formdata.append('file_three_type',$scope.inputfiletype[2].id.id);
                            formdata.append('file_three_source',$scope.sourcefileinput[2].id.id);
                            // if(typeof c.links[2].file_row != 'undefined')
                            // {
                            //     formdata.append('link_file_row_three',c.links[2].file_row);
                            // }
                            $scope.file_found = true;
                        }
                    }

                    if(c.first_link)
                    {
                        formdata.append('first_link',c.first_link); 
                        formdata.append('link_one_type',$scope.inputfiletype[0].id.id);
                        formdata.append('link_one_source',$scope.sourceurlinput[0].id.id);
                        // if(typeof c.links[3].file_row != 'undefined')
                        // {
                        //     formdata.append('link_file_row_four',c.links[3].file_row);
                        // }
                        $scope.file_found = true; 
                    }

                    if(c.second_link)
                    {
                        formdata.append('second_link',c.second_link); 
                        formdata.append('link_two_type',$scope.inputfiletype[0].id.id);
                        formdata.append('link_two_source',$scope.sourceurlinput[1].id.id);
                        // if(typeof c.links[4].file_row != 'undefined')
                        // {
                        //     formdata.append('link_file_row_five',c.links[4].file_row);
                        // }
                        $scope.file_found = true; 
                    }

                    if(c.third_link)
                    {
                        formdata.append('third_link',c.third_link); 
                        formdata.append('link_three_type',$scope.inputfiletype[0].id.id); 
                        formdata.append('link_three_source',$scope.sourceurlinput[2].id.id);
                        // if(typeof c.links[5].file_row != 'undefined')
                        // {
                        //     formdata.append('link_file_row_six',c.links[5].file_row); 
                        // }
                        $scope.file_found = true;
                    }
                    
                    if(!$scope.file_found)
                    {
                        $scope.file_url = false;
                        return false;
                    }

                    $scope.usersavebtntext = "Saving";

                    var request = {
                        method: 'POST',
                        url: "<?php echo base_url(); ?>savecartoon",
                        data: formdata,
                        headers: {'Content-Type': undefined}
                    };
                        
                    $http(request).success(function (response) {
                        if(response.message == true)
                        {
                            $scope.getactivities();
                            $scope.activityobj = {};
                            $scope.setLinks();
                            $scope.defaulttags();
                        }
                        $scope.usersavebtntext = "Save";
                    })
                    .error(function(){
                        $scope.usersavebtntext = "Save";
                    }); 
                }
                else{
                    $scope.file_url = false;
                    $scope.title_message = false;
                }
            }
            catch(e){
                console.log(e)
            }
        }
    });
</script>

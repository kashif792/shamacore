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
<div class="col-sm-10" ng-controller="task_ctrl" ng-init="loading=true">

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
                    <th>From date</th>
                    <td>{{selectedactivity.from_date}}</td>
                    <th>Due date</th>
                    <td>{{selectedactivity.due_date}}</td>
                </tr>
                 <tr class="hide">
                    <th>Graded</th>
                    <td>{{selectedactivity.graded}}</td>
                    <th>Language</th>
                    <td >{{selectedactivity.language}}</td>
                </tr>
                <tr class="hide">
                    <th class="hide">Type</th>
                    <td class="hide">{{selectedactivity.type}}</td>
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
                    <th>Grades</th>
                    <td colspan="3">
                      <label ng-repeat="value in selectedactivity.class_display">
                        {{value.name}} <span ng-hide="$last">,</span>&nbsp;&nbsp; 
                      </label>
                    </td>
                </tr>
                <tr>
                    <th>Sections</th>
                    <td colspan="3">
                      <label ng-repeat="value in selectedactivity.section_display">
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
                    <th>Published</th>
                    <td colspan="3">{{selectedactivity.published}}</td>
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
            <p>Are you sure do you want to remove this activity?</p>
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
            <p>Are you sure do you want to remove this link?</p>
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
            <label>Assignments
                &nbsp;&nbsp;&nbsp;
                <?php 
                    if(count($classlist)){
                ?>
                <a href="task" class="btn btn-primary" style="color: #fff !important;">Add</a>
                <?php } ?>
            </label>
        </div>
        <div class="panel-body" ng-init="defaultview = 't'" >

            <div id="table" ng-hide="defaultview != 't'">
                <table datatable="ng" dt-options="dtOptions"  class="table table-striped table-bordered row-border hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Grade</th>
                            <th>Section</th>
                            <th>Subject</th>
                            <th>Semester</th>
                            <th>Due Date</th>
                            <th>Marks</th>
                            <th>Graded</th>
                            <th>Published</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                      <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>All</th><!-- Type -->
                            <th>All</th><!-- Grade -->
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>All</th><!-- Status -->
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody id="reporttablebody-phase-two" class="report-body">
                        <tr ng-repeat="c in tasklist" ng-init="$last && finished()">
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.from_date}}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.title | limitTo:50 }}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.type}}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.class_str}}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.section_str}}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.subject_str}}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.semester_display[0].name}}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.due_date}}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.marks}}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.graded}}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.published}}</td>
                           <td class="row-bar-user" ng-click="viewactivity(c)">{{c.status}}</td>
                           <td><!-- Actions -->
                                <a  href="javascript:void(0);" ng-click="viewactivity(c)">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a  href="javascript:void(0);" ng-click="task/{{c.id}}">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <a  href="javascript:void(0);" ng-click="removeactivityconfirm(c)">
                                    <i class="fa fa-remove" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- list -->
    </div><!-- panel -->
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
                //$scope.usersavebtntext = "Save";
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
                //$scope.usersavebtntext = "Save";
            });
        }
    }]);
    
    app.controller('task_ctrl',function($scope,$http,$interval,commonservice,DTOptionsBuilder,$filter,$modal,$rootScope,$window){
        $scope.commonobj = commonservice;
        $scope.tasklist = null;
        $scope.file_url = true;
        $scope.title_message = true;
        $scope.currentactivityindex = 0;
        $scope.currentactivity = {};

/*
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
*/

        $scope.gettasks= function()
        {
            $scope.commonobj.postrequest('gettasklist',({})).then(function(response){
                
                $scope.classes = [];
                $scope.sections = [];
                $scope.subjects = [];
                
                if(response.length > 0)
                {
                    angular.forEach($scope.response, function(value, key){
                        if(!empty(value.))
                        {
                            $scope.isAllSelected = false;
                            $scope.allselected = false;
                        }
                    });
                    $scope.tasklist = response;
                }
                else{
                    $scope.loading = false;
                }
            });
        }

        $scope.gettasks();
        
        $scope.selectedremoveactivity = null;
        $scope.removeactivityconfirm = function(activity)
        {
            $scope.deleteModal =  $modal.open({
                templateUrl: 'deleteModalContent.html',
                controller: 'deleteModalInstanceCtrl',
                scope: $scope,
            });
            $scope.selectedremoveactivity = activity;
        }


        $scope.viewactivity = function(c)
        {
            $scope.selectedactivity = c;
            $scope.openModal();
        } 


        $scope.finished = function()
        {
            $scope.loading = false;
        }

        $scope.dtOptions = DTOptionsBuilder.fromSource($scope.tasklist)
        .withDisplayLength(25)
        .withColumnFilter({
            aoColumns: [ 
                {
                    title: 'Title',
                    type: 'text',
                    bRegex: true,
                    bSmart: true
                },  {
                    title: 'Type',
                    type: 'select',
                    bRegex: false,
                    values: ['Active', 'Inactive']
                },  {
                    title: 'Grade',
                    type: 'select',
                    bRegex: false,
                    values: ['Active', 'Inactive']
                },  {
                    title: 'Status',
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
        //$scope.activityobj.status = $scope.statuslist[0];


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
        //$scope.activityobj.graded = $scope.gradedstatus[0].value;
    

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


        $scope.showRemoveDialoag = function(link)
        {
            $scope.deleteModal =  $modal.open({
                templateUrl: 'deleteLinkModal.html',
                controller: 'deleteLinkModalCtrl',
                scope: $scope,
            });
            $scope.selectedlink = link;
        }

        
    });
</script>

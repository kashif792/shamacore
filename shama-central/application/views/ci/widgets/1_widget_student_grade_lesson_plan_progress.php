<div class="col-lg-12 whide" ng-controller="studentGradeLessonProgressCtrl" ng-init="gradeLessonPlanProgressLoader=false">
    <div class="panel panel-default">
        <div class="panel-heading">
            <label>Student Progress Report</label>
        </div>
        <div class="panel-body" id="progress_report" ng-class="{'loader2-background': gradeLessonPlanProgressLoader == false}">
            <div class="loader2" ng-hide="gradeLessonPlanProgressLoader" ></div>
            <div class="row" ng-hide="!gradeLessonPlanProgressLoader">
                <div class="col-sm-12">
                    <form class="form-inline" >
                        <div class="form-group">
                                        <label for="inputRSession">Session:</label>
                                        <select  class="form-control" ng-options="item.name for item in rsessionlist track by item.id"  name="inputRSession" id="inputRSession"  ng-model="filterobj.session" ng-change="changeclass()" ></select>
                                    </div>  
                        <div class="form-group">
                            <label for="select_class">Grade:</label>
                            <select class="form-control" ng-options="item.name for item in schoolGradeList track by item.id"  name="select_class" id="select_class"  ng-model="gradeLessonProgressFilterObj.grade"></select>
                        </div>
                        <div class="form-group">
                            <label for="inputSection">Section:</label>
                            <select class="form-control"  ng-options="item.name for item in schoolSectionList track by item.id"  name="inputSection" id="inputSection"  ng-model="gradeLessonProgressFilterObj.section"></select>
                        </div>
                        <div class="form-group">
                            <label for="inputSemester">Semester:</label>
                            <select class="form-control" ng-options="item.name for item in schoolSemesterList track by item.id"  name="inputSemester" id="inputSemester"  ng-model="gradeLessonProgressFilterObj.semester"></select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" ng-click="showProgress()">
                                <span ng-show="progressBtnTxt == 'Searching'">
                                    <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>
                                </span>
                                {{progressBtnTxt}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row padding-top" ng-hide="!gradeLessonPlanProgressLoader">
                <div class="col-sm-12">
                    <div class="table-responsive" ng-hide="gradeLessonPlanProgressList.length == 0">
                        <table datatable="ng"  class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <p style="width:150px;">Students</p>
                                    </th>
                                    <th scope="col" ng-repeat="header in gradeLessonPlanProgressList.table_header"  title="{{header.lessons}}" data-animation="grow">
                                        
                                        <p style="width:50px;">
                                            {{header.set_name}}
                                        </p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="reporttablebody-phase-two" class="report-body" >
                                <tr ng-repeat="student in gradeLessonPlanProgressList.student_list" ng-init="$last && gradeLessonPlanDataFinished()">
                                    <td scope="row">{{student.first_name}} {{student.last_name}}</td>
                                    <td ng-repeat="s in student.student_lesson_progress">
                                   
                                        <i  class="fa {{s.status ? 'fa-check':''}}" aria-hidden="true"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm text-center" ng-hide="gradeLessonPlanProgressList.length != 0">
                        <p>No data found</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/angular-datatables.css">
<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>

<link href="<?php echo base_url();?>css/cjquery-ui.css" rel="stylesheet">
  


<script>

    /*
     * Student grade lessons progress. This widget used by principal
     *
    */

	app.controller('studentGradeLessonProgressCtrl', function($scope, $myUtils, $filter,$interval,$sce){

       
        $scope.gradeLessonProgressFilterObj = {}; //
        
        $scope.schoolSessionList = [];
        $scope.gradeLessonPlanProgressList = [];

        $scope.schoolSessionList = $myUtils.getSessionList(); // get session list
        $scope.schoolGradeList = $myUtils.getGradeList(); // get grade list
        $scope.schoolSemesterList = $myUtils.getSemesterList(); // get semester list
        $scope.activeSemester = $myUtils.getActiveSemester(); // get active semester
        $scope.activeSession = $myUtils.getActiveSession(); // get active session
       
        $scope.progressBtnTxt = "Show"; // btn text

        // select active session
        $scope.$watch(function(){
            return $scope.schoolSessionList;
        },function(newValue,oldValue){
            if(newValue != null && newValue.length > 0)
            {
                 $scope.gradeLessonProgressFilterObj.session = $scope.schoolSessionList[0];
                $scope.findActiveSession = $filter('filter')($scope.schoolSessionList , {id:$scope.activeSession.id},true);
                if($scope.findActiveSession.length > 0)
                {
                    $scope.gradeLessonProgressFilterObj.session = $scope.findActiveSession[0];
                }

                $scope.gradeLessonProgressFilterObj.grade = $scope.schoolGradeList[0]; // set grade

                $scope.gradeLessonProgressFilterObj.semester = $scope.schoolSemesterList.filter(a=> a.name == $scope.activeSemester)[0]; // set semester
                $scope.sectionList($scope.gradeLessonProgressFilterObj.grade.id , $myUtils.getUserId()) //  get section list
            }
        });

        /**
         * Get section list.
         * @param {number} class_id.
         * @param {number} user_id.
         *
         */
        $scope.sectionList = function(class_id, user_id)
        {
            try{
                var data = ({class_id:class_id,user_id:user_id})
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>sections_by_class',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.schoolSectionList = response;
                        $scope.gradeLessonProgressFilterObj.section = response[0];
                        
                        $scope.gradeLessonPlanProgress($scope.gradeLessonProgressFilterObj.session.id,
                            $scope.gradeLessonProgressFilterObj.grade.id,$scope.gradeLessonProgressFilterObj.section.id,
                            $scope.gradeLessonProgressFilterObj.semester.id
                        ); // call function
                    }
                    else{
                        $scope.schoolSectionList = [];
                    }
                })
            }
            catch(ex){}
        }

        /**
         * Get student progress.
         * @param {number} sessionId.
         * @param {number} classId.
         * @param {number} sectionId.
         * @param {number} semesterId.
         *
         */
        $scope.gradeLessonPlanProgress = function(sessionId, classId, sectionId, semesterId)
        {
            try{
                var data = ({
                                sessionId:sessionId,
                                classId:classId,
                                sectionId:sectionId,
                                semesterId:semesterId,
                            });

                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>get_grade_lesson_plan_progress',data).then(function(response){
                    if(response != null && response.table_header.length > 0)
                    {
                        $scope.gradeLessonPlanProgressList = response;
                    }
                    else{
                         $scope.gradeLessonPlanProgressList = [];
                         $scope.gradeLessonPlanProgressLoader = true;
                    }
                })
            }
            catch(ex){}
        }

        /**
         * Show progress
         *
         */
         $scope.showProgress = function()
        {
            try{
                $scope.gradeLessonPlanProgressLoader = false;
                $scope.gradeLessonPlanProgress($scope.gradeLessonProgressFilterObj.session.id,
                    $scope.gradeLessonProgressFilterObj.grade.id,$scope.gradeLessonProgressFilterObj.section.id,
                    $scope.gradeLessonProgressFilterObj.semester.id
                ); // call function
            }
            catch(ex){}
        }

        /**
         * Hide loader on widget after data loaded
         *
         */
         $scope.gradeLessonPlanDataFinished = function()
         {
            $scope.gradeLessonPlanProgressLoader = true;
        }
    });
</script>

<!DOCTYPE html>
<html ng-app="invantage">
<head>
  <title>Installation Wizard</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,700,500italic,700italic,900,900italic' rel='stylesheet' type='text/css'>
  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/angular-wizard.css">
  
  <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>js/angular.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/moment.js"></script>

  <script src="<?php echo base_url(); ?>js/angular-wizard.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/wizardloader.css" />
  <script type="text/javascript" src="<?php echo base_url(); ?>js/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/angular-daterangepicker.min.js"></script>
<script src="<?php echo base_url();?>js/angular-messages.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<body ng-controller="installation_wizard" ng-init="wizard_finished=true" class="mt-5">
    <div class="container" ng-init="loader = true;">
    <div class="loading" ng-hide="loader" ></div>    
        <div class="row content">
            <div class="col-sm-12 " ng-class="{'loader2-background': wizard_finished == true}">
                <div class="loader2" ng-hide="wizard_finished" ></div>
                <div class="row">
                    <div class="col-sm text-center mb-5" style="background-color: #fff;">
                        <img src="<?php echo base_url(); ?>/images/nrschoollogo.png" class="img img-rounded mb-5">
                    </div>
                </div>
                <div class="row" ng-hide="!wizard_finished">
                    <div class="col-sm pt-3">
                        <wizard on-finish="finishedWizard()" on-cancel="cancelledWizard()" indicators-position="top" ng-hide="!wizard_finished"> 
                            <wz-step wz-title="Grade" wz-order="1"  canenter="enterValidation">
                                <div class="m-5">
                                    
                                    <div class="d-inline ml-5" ng-hide="current_grade_form != 'grade_table'">
                                        <label class="" for="InputSessionDate">Grades:</label>
                                        <button type="button" class="btn btn-default" ng-click="open_grade_form('gradeForm')">Add Grade</button>
                                    </div>
                                    <div class="d-inline ml-5" ng-hide="current_grade_form != 'grade_table'">
                                        <label class="" for="InputSemesterDate">Section:</label>
                                        <button type="button" class="btn btn-default" ng-click="open_grade_form('sectionForm')">Add Section</button>
                                    </div>
                                    <form class="form-horizontal" ng-hide="current_grade_form != 'gradeForm'" name="gradeForm"  ng-submit="save_grade(grade_obj)" novalidate ng-hide="is_view_only">
                                        <input type="hidden" name="serial" ng-model="grade_obj.id">
                                        <label class="ml-3" ng-hide="grade_obj.id == ''">
                                             <button type="button" ng-click="delete_class(grade_obj)"   class="btn btn-primary class-btn">
                                                Remove grade
                                            </button>
                                        </label>
                                       
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="inputGrade">Grade: <span class="required">*</span></label>
                                            <div class="col-sm-10"> 
                                                <input type="text" class="form-control" ng-model="grade_obj.title" id="inputGrade" ng-minlength="3" ng-maxlength="50" name="inputGrade" input-title-validation>
                                                <div ng-messages="gradeForm.inputGrade.$error" style="color: red;">
                                                    <div ng-message="title_validation">Please enter  3-50 character long description</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="InputSection">Section:</label>
                                            <div class="col-sm-10">
                                                <label ng-repeat="s in section_list">
                                                    <input type="checkbox" name="section_model" ng-model="s.grade">{{s.title}}&nbsp;&nbsp;&nbsp;
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group" > 
                                            <div class="col-sm-offset-2 col-sm-10">
                                               <button type="button"  ng-click="open_grade_form('grade_table')" class="btn btn-default">Cancel</button>
                                                <button type="submit"   ng-disabled="form.$invalid || form.inputtitle.$invalid || holidaytypelist.length == 0"   class="btn btn-primary class-btn">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" ng-hide="current_grade_form != 'sectionForm'" name="sectionForm"  ng-submit="save_section(section_obj)" novalidate ng-hide="is_view_only">
                                        <input type="hidden" name="serial" ng-model="section_obj.id">
                                        <label class="ml-3" ng-hide="section_obj.id == ''">
                                             <button type="button" ng-click="delete_section(section_obj)" class="btn btn-primary class-btn">
                                                Remove section
                                            </button>
                                        </label>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="inputGrade">Section: <span class="required">*</span></label>
                                            <div class="col-sm-10"> 
                                                <input type="text" class="form-control" ng-model="section_obj.title" id="inputGrade" ng-minlength="3" ng-maxlength="30" name="inputGrade" input-title-validation>
                                                <div ng-messages="sectionForm.inputGrade.$error" style="color: red;">
                                                    <div ng-message="title_validation">Please enter  3-30 character long description</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" > 
                                            <div class="col-sm-offset-2 col-sm-10">
                                               <button type="button" ng-click="open_grade_form('grade_table')" class="btn btn-default">Cancel</button>
                                                <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."  ng-disabled="form.$invalid || form.inputtitle.$invalid || holidaytypelist.length == 0"   class="btn btn-primary class-btn">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                   
                                    <div class="col-sm  my-auto text-center" ng-hide="current_grade_form != 'grade_table'">
                                        <div class="card d-inline-block m-3" style="width: 15rem;" ng-repeat="g in grade_list track by $index" ng-hide="!g.title">
                                            <div class="card-block">
                                                <h4 class="card-title">{{g.title}} 
                                                    <a href="javascript:void(0)" ng-click="open_edit_grade_form(g)" title="Edit" class="edit">
                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </a>
                                                </h4>
                                                <ul class="list-group" ng-repeat="s in section_list track by $index"  ng-hide="!s.title">
                                                    <li class="list-group-item" ng-hide="!g.default_sections_in_grade[$index].status">{{s.title}} &nbsp;&nbsp;&nbsp;
                                                        <a href="javascript:void(0)" ng-click="open_edit_section_form(s)" title="Edit" class="edit">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </a> 
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group float-right"> 
                                        <div class="">
                                            <button type="button" ng-disabled="grade_list.length == 0" class="btn btn-default" wz-next>

                                            Next</button>
                                        </div>
                                    </div>
                                </div>
                            </wz-step>
                            <wz-step wz-title="Subject" wz-order="2" >
                                <div class="m-5" >
                                    <div class="ml-5" ng-hide="current_subject_form != 'subject_table'">
                                        <label class="" for="InputSessionDate">Subject:</label>
                                        <button type="button" class="btn btn-default" ng-click="open_subject_form('subjectForm')">Add Subject</button>
                                    </div>
                                    <form class="form-horizontal" ng-hide="current_subject_form != 'subjectForm'" name="subjectForm"  ng-submit="save_subject(subject_obj)" novalidate ng-hide="is_view_only">
                                        <input type="hidden" name="serial" ng-model="subject_obj.id">
                                         <label class="ml-3" ng-hide="subject_obj.id == ''">
                                             <button type="button" ng-click="delete_subject(subject_obj)" class="btn btn-primary class-btn">
                                                Remove Subject
                                            </button>
                                        </label>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="InputSubjectName">Subject: <span class="required">*</span></label>
                                            <div class="col-sm-10"> 
                                                <input type="text" class="form-control" ng-model="subject_obj.title" id="InputSubjectName" ng-minlength="3" ng-maxlength="50" name="InputSubjectName" input-title-validation>
                                                <div ng-messages="subjectForm.InputSubjectName.$error" style="color: red;">
                                                    <div ng-message="title_validation">Please enter  3-50 character long description</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="InputSection">Grade:</label>
                                            <div class="col-sm-10">
                                                <label ng-repeat="g in grade_list">
                                                    <input type="checkbox" name="subject_class" ng-model="g.grade_subject" >{{g.title}} &nbsp;&nbsp;&nbsp;
                                                </label>
                                                <div ng-hide="!g.grade_subject" style="color: red;">
                                                    Please select at least one role
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" > 
                                            <div class="col-sm-offset-2 col-sm-10">
                                               <button type="button" ng-click="open_subject_form('subject_table')" class="btn btn-default">Cancel</button>
                                                <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."  ng-disabled="subjectForm.$invalid || subjectForm.InputSubjectName.$invalid"   class="btn btn-primary class-btn">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <div class="col-sm  my-auto text-center pt-3" ng-hide="current_subject_form != 'subject_table'">
                                        <div class="card d-inline-block m-3" style="width: 15rem;" ng-repeat="g in grade_list" ng-init="gindex = $index">
                                            <div class="card-block">
                                                <h4 class="card-title">{{g.title}} </h4>
                                                <ul ng-repeat="s in kindergarten_sub" ng-hide="g.title != 'Kindergarten'" class="list-group"  ng-init="kindex = $index">
                                                    <li class="list-group-item" ng-hide="g.grade_subject_list[$index].title != s.title">{{s.title}} &nbsp;&nbsp;&nbsp;
                                                        <a href="javascript:void(0)" ng-click="open_edit_subject_form(s,g)" title="Edit" class="edit" ng-hide="!s.title">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul ng-repeat="s in default_subjects" ng-hide="g.title == 'Kindergarten'" class="list-group"  ng-init="dindex = $index">
                                                    <li class="list-group-item" ng-hide="g.grade_subject_list[$index].title != s.title">{{s.title}} &nbsp;&nbsp;&nbsp;
                                                        <a href="javascript:void(0)" ng-click="open_edit_subject_form(s,g)" title="Edit" class="edit" ng-hide="!s.title">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group float-right"> 
                                        <div class="">
                                            <button type="submit" class="btn btn-default" wz-previous>Previous</button>
                                            <button type="submit" class="btn btn-default" wz-next>Next</button>
                                        </div>
                                    </div>
                                </div>
                            </wz-step>
                            <wz-step wz-title="Default Lessons Plan" wz-order="3">
                                <div class="mt-5" >
                                    <form class="form-horizontal" method="post" ng-hide="current_default_lesson_plan_form != 'dflForm'" name="dflForm"  ng-submit="save_default_lesson_plan(dfl_obj,plan_file)" novalidate ng-hide="is_view_only" enctype="multipart/form-data">
                                        <input type="hidden" name="serial" ng-model="dfl_obj.id">
                                       <!--  <label class="ml-3" ng-hide="dfl_obj.id">
                                             <button type="button" ng-click="delete_default_lesson_plan(dfl_obj)" class="btn btn-primary class-btn">
                                                Remove Default Lesson Plan
                                            </button>
                                        </label> -->
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="InputSection">Grade:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" ng-options="item.title for item in grade_list track by item.id"  name="select_class" id="select_class"  ng-model="dfl_obj.grade" ng-change="getgradesubject()"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="select_class">Subject:</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" ng-options="item.title for item in dfl_subjects track by item.id"  name="select_class" id="select_class"  ng-model="dfl_obj.subject"></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="semester">Semester:</label>
                                            <label ng-repeat="s in semesterlist">
                                                <input type="radio" name="semester" ng-model="dfl_obj.current_semester"  value='{{s.title}}' >{{s.title}}
                                            </label>
                                        </div>
                                        <div class="form-group" ng-hide="dfl_obj.uploade_file_name == ''">
                                            <label class="control-label col-sm-2" for="inputGrade">Filename:</label>
                                            <div class="col-sm-10"> 
                                               <p>{{dfl_obj.uploade_file_name}}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="inputGrade">Upload: <span class="required">*</span></label>
                                            <div class="col-sm-10"> 
                                               <input type="file" name="upload" upload-default-lesson-plan="plan_file">
                                            </div>
                                        </div>

                                        
                                        <div class="form-group" > 
                                            <div class="col-sm-offset-2 col-sm-10">
                                               <button type="button" ng-click="open_dfl_form('default_lesson_plan_table')" class="btn btn-default">Cancel</button>
                                                <button type="submit" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving..."  ng-disabled="form.$invalid || form.inputtitle.$invalid || holidaytypelist.length == 0"   class="btn btn-primary class-btn">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <div class="col-sm  my-auto text-center pt-3" ng-hide="current_default_lesson_plan_form != 'default_lesson_plan_table'">
                                        <div class="card d-inline-block m-3" style="width: 15rem;" ng-repeat="g in grade_list"  ng-init="$last && finished()" ng-init="gindex = $index">
                                            <div class="card-block">
                                                <h4 class="card-title">{{g.title}} 
                                                    <a href="javascript:void(0)" ng-click="open_edit_dfl_form(g)" title="Edit" class="edit">
                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </a>
                                                </h4>
                                                <ul ng-repeat="s in kindergarten_sub" ng-hide="g.title != 'Kindergarten'" class="list-group"  ng-init="sindex = $index">
                                                    <li class="list-group-item" ng-hide="!(s.title == g.grade_subject_list[$index].title)">{{s.title}}&nbsp;&nbsp;&nbsp;
                                                        <label ng-repeat="sem in g.uploaded_default_lesson_plan" ng-hide="s.title != sem.subject">
                                                            <a href="javascript:void(0)"  ng-hide="  sem.semester != 'Fall'" ng-click="open_edit_dfl_form_by_semester(g,s.title,sem.semester)">Fall</a>&nbsp;&nbsp;&nbsp;
                                                            <a href="javascript:void(0)"  ng-hide=" sem.semester != 'Spring'" ng-click="open_edit_dfl_form_by_semester(g,s.title,sem.semester)">Spring</a>&nbsp;&nbsp;&nbsp;
                                                        </label>
                                                    </li>
                                                </ul>
                                                <ul  ng-hide="g.title == 'Kindergarten'" class="list-group" ng-repeat="s in default_subjects" ng-init="dindex = $index">
                                                    <li class="list-group-item" ng-hide="!(s.title == g.grade_subject_list[$index].title)">{{s.title}}&nbsp;&nbsp;&nbsp;
                                                        <label ng-repeat="sem in g.uploaded_default_lesson_plan" ng-hide="s.title != sem.subject">
                                                            <a href="javascript:void(0)"  ng-hide="sem.semester != 'Fall'" ng-click="open_edit_dfl_form_by_semester(g,s.title,sem.semester)">Fall</a>&nbsp;&nbsp;&nbsp;
                                                            <a href="javascript:void(0)"  ng-hide="sem.semester != 'Spring'" ng-click="open_edit_dfl_form_by_semester(g,s.title,sem.semester)">Spring</a>&nbsp;&nbsp;&nbsp;
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group float-right"> 
                                        <div class="">
                                            <button type="button" class="btn btn-default" wz-previous>Previous</button>
                                            <button type="button" class="btn btn-default" wz-next>Next</button>
                                        </div>
                                    </div>
                                </div>
                            </wz-step>
                            <wz-step wz-title="Session/Semester" wz-order="4" canexit="exitValidation">
                                <div class="mt-5" >
                                <form class="pl-3" name="session_semester_form"   novalidate>
                                    <div class="form-group">
                                        <label class="" for="InputSessionDate">Session Date:</label>
                                        <input date-range-picker id="InputSessionDate" name="InputSessionDate" class="form-control date-picker" 
                                            ng-model="installation_obj.session_date" clearable="true" type="text" options="session_options"  input-date-validation/>
                                        <!-- <div ng-messages="session_semester_form.InputSessionDate.$error" style="color: red;">
                                            <div ng-message="date_validation">Please enter valid date time</div>
                                        </div> -->
                                    </div>
                                    <div class="form-group">
                                        <label class="" for="InputSemesterDate">Semester Date:</label>
                                        <input date-range-picker id="InputSemesterDate" name="InputSemesterDate" class="form-control date-picker" 
                                            ng-model="installation_obj.semester_date" clearable="true" type="text" options="semester_options"  input-date-validation/>
                                        <div ng-messages="session_semester_form.InputSemesterDate.$error" style="color: red;">
                                            <div ng-message="date_validation">Please enter valid date time</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="" for="pwd">Semester:</label>
                                        <label ng-repeat="s in semesterlist">
                                            <input type="radio" name="semester" ng-model="installation_obj.current_semester"  value="{{s.title}}">{{s.title}}
                                        </label>
                                    </div>
                                    <div class="form-group float-right"> 
                                        <div class="" ng-init="finish_txt='Finish'">
                                            <!--  -->
                                            <button type="button" class="btn btn-default" wz-previous>Previous</button>
                                            <button type="button"  class="btn btn-default wizard" wz-finish  ng-disabled="session_semester_form.$invalid" >
                                                 <span ng-if="finish_txt =='Installing'"><i class="fa fa-circle-o-notch fa-spin"></i></span>
                                            {{finish_txt}}
                                        </button>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </wz-step>
                        </wizard>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    var app = angular.module('invantage', ['daterangepicker','ngMessages','mgo-angular-wizard']);
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

    app.directive('uploadDefaultLessonPlan', ['$parse',function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, iElement, iAttrs) {
                var model = $parse(iAttrs.uploadDefaultLessonPlan),
                    modelSetter = model.assign;

                iElement.bind('change',function(){
                    scope.$apply(function(){
                        modelSetter(scope, iElement[0].files[0]);
                    });
                });
            }
        };
    }]);

     // $(window).bind('beforeunload', function(){
     //       return 'Are you sure you want to leave?';
     //    });
    app.controller('installation_wizard', function($scope, $http, $filter,$q,$timeout){
        
        var urlist = {
            default_subjects:'<?php echo SHAMA_CORE_API_PATH; ?>default_subjects',
            default_classes:'<?php echo SHAMA_CORE_API_PATH; ?>default_classes',
            default_kindergarten_subject:'<?php echo SHAMA_CORE_API_PATH; ?>default_kg_subject',
            default_subjects:'<?php echo SHAMA_CORE_API_PATH; ?>default_subjects',
            default_sections:'<?php echo SHAMA_CORE_API_PATH; ?>default_sections',
            school_wizard:'<?php echo SHAMA_CORE_API_PATH; ?>school_wizard',
        }

        $scope.installation_obj ={};
        $scope.semesterlist = [
            {
                id:1,
                title:"Fall",
                value:1,
            },
            {
                id:2,
                title:"Spring",
                value:2,
            },
        ];

         $scope.finished = function()
         {
            $scope.wizard_finished = true;
         }

        $scope.installation_obj.current_semester = $scope.semesterlist[0].title;

        $scope.grade_list = [];
        $scope.section_list = [];
        $scope.grade_obj = {};
        $scope.section_obj = {};
        $scope.current_grade_form = 'grade_table';
        $scope.current_subject_form = 'subject_table';
        $scope.current_default_lesson_plan_form = 'default_lesson_plan_table';
        $scope.subject_obj = {};
        $scope.canExit = false;
        $scope.actual_grade_list_lenght = 0;
        $scope.dfl_obj = {};
        $scope.dfl_subjects = [];

        $scope.dfl_obj.current_semester = $scope.semesterlist[0].title;
        $scope.dfl_obj.uploade_file_name = '';
        $scope.installation_obj.default_plans = [];
       

        $scope.open_grade_form = function(formtype)
        {

            if(formtype == 'gradeForm')
            {
                $scope.grade_obj = {};
                angular.forEach($scope.section_list,function(value,key){
                    value.grade = true;
                });
            }
            else if(formtype == 'sectionForm')
            {
                $scope.section_obj = {};
            }
            else{
                angular.forEach($scope.section_list,function(value,key){
                    value.grade = true;
                });
            }
            
            $scope.current_grade_form = formtype;
        }

        $scope.open_subject_form = function(formtype)
        {
            $scope.subject_obj = {};
            
            angular.forEach($scope.grade_list,function(value,key){
                value.grade_subject = true;
            });
            $scope.current_subject_form = formtype;
        }

        $scope.open_dfl_form = function(formtype)
        {
            $scope.dfl_obj.grade = $scope.grade_list[0];
            $scope.dfl_obj.current_semester = $scope.semesterlist[0].title;
            $scope.dfl_obj.filename = '';
            
            set_default_lesson_plan_subjects();
            angular.element("input[type='file']").val(null);
            $scope.current_default_lesson_plan_form = formtype;
        }

        $scope.validate_session_semester = function(context)
        {
            console.log(context)
        }

        $scope.enterValidation = function(){
            return true;
        };

        $scope.exitValidation = function(){
            return true;
        };

        //example using context object
        $scope.exitValidation = function(context){
            return true;
        }
        
        $scope.delete_class = function(data)
        {
            try{
                if(data.id != '')
                {
                    angular.forEach($scope.grade_list,function(value,key)
                    {
                        if(value.id == data.id)
                        {
                            $scope.grade_list.splice(key,1);
                        }
                    });
                    $scope.grade_obj = {};

                    $scope.current_grade_form = 'grade_table';
                }
            }
            catch(e){}
        }

        $scope.delete_section = function(data)
        {
            try{
                if(data.id != '')
                {
                    angular.forEach($scope.section_list,function(value,key)
                    {
                        if(value.id == data.id)
                        {
                            $scope.section_list.splice(key,1);
                        }
                    });
                    $scope.section_obj = {};
                    $scope.current_grade_form = 'grade_table';
                }
            }
            catch(e){}
        }

        $scope.delete_subject = function(data)
        {
            try{
                if(data.id != '')
                {
                   var check_kinder_garten_subjects = $filter('filter')($scope.kindergarten_sub,{id:data.id},true);
                   if(check_kinder_garten_subjects.length > 0)
                   {
                        var array_index = $scope.kindergarten_sub.findIndex( s => s.title == data.title);
                        $scope.kindergarten_sub.splice(array_index,1);
                   }    

                   var check_default_subjects = $filter('filter')($scope.default_subjects,{id:data.id},true);
                   if(check_default_subjects.length > 0)
                   {
                        var array_index = $scope.default_subjects.findIndex( s => s.title == data.title);
                        $scope.default_subjects.splice(array_index,1);
                   }

                   angular.forEach($scope.grade_list,function(value,gkey){
                        if(value.grade_subject)
                        {
                            var is_subject_found = $filter('filter')(value.grade_subject_list,{id:data.id},true);
                            if(is_subject_found.length > 0 && is_subject_found[0].id == data.id)
                            {
                                var array_index = value.grade_subject_list.findIndex( s => s.id == data.id);
                                value.grade_subject_list.splice(array_index,1);
                            }
                        }
                    });      
                    $scope.current_subject_form = 'subject_table';  
                }  
                    console.log($scope.grade_list)
                    console.log($scope.kindergarten_sub)
                    console.log($scope.default_subjects)
            }
            catch(e){
            }            
        }


        $scope.delete_default_lesson_plan = function(data)
        {
            try{
                if(data.id != '')
                {}  
            }
            catch(e){
            }            
        }

        // uncheck subject in default lesson plan list
        $scope.findsubject = function(array,subject)
        {
            try{
                if(($filter('filter')(array,{title:subject},true).length) > 0)
                {
                    return true;
                }
                return false;
            }
            catch(e){
            } 
        }

        $scope.save_grade = function(data)
        {
            try{    
                if(data.title)
                {
                    if(data.id)
                    {
                        var temp = [];
                        
                        angular.forEach($scope.section_list,function(value,key){
                            if(value.grade)
                            {
                                temp.push({status:true,title:value.title});
                            }else{
                                temp.push({status:false,title:value.title});
                            }
                        });
                        data.default_sections_in_grade = [];
                        data.default_sections_in_grade = temp;
                        $scope.grade_obj = {};
                    }
                    else{
                        var temp = [];
                      
                        angular.forEach($scope.section_list,function(gvalue,key){
                            if(gvalue.grade)
                            {
                                temp.push({status:true,title:gvalue.title});
                            }else{
                                temp.push({status:false,title:gvalue.title});
                            }
                        });
                        
                        var subject_array = [];
                        angular.forEach($scope.default_subjects,function(value,key){
                            subject_array.push(value);
                        });
                        var temp = {
                            id:$scope.grade_list.length + 1,
                            title:data.title,
                            selected_section:temp,
                            default_sections_in_grade:temp,
                            grade_subject:subject_array
                        }
                        $scope.grade_list.push(temp) ;
                        $scope.activate_subject_grade_status($scope.grade_list);
                    }
                    
                    $scope.current_grade_form = 'grade_table';
                }
            }
            catch(e){
            }
        }

        $scope.save_section = function(data)
        {
            try{    
                if(data.title)
                {
                    if(!data.id){
                        var temp = {
                            id:$scope.section_list.length + 1,
                            title:data.title,
                        }
                        $scope.section_list.push(temp) ;
                    }
                }
                $scope.current_grade_form = 'grade_table';
            }
            catch(e){}
        }

        $scope.open_edit_grade_form = function(grade)
        {
            try{    
                if(grade)
                {
                    $scope.grade_obj = grade;
                    angular.forEach($scope.section_list,function(value,key){
                        var check_grade = $filter('filter')(grade.default_sections_in_grade,{title:value.title},true);
                        if(check_grade.length > 0)
                        {
                            if(check_grade[0].status)
                            {
                                value.grade = true;
                            }
                            else{
                                value.grade = false;
                            }
                        }
                        else{
                            value.grade = false;
                        }
                    });  
                    
                    $scope.current_grade_form = 'gradeForm';
                }
            }
            catch(e){}
        }

        $scope.open_edit_section_form = function(section)
        {
            try{    
                if(section)
                {
                    $scope.section_obj = section;
                    $scope.current_grade_form = 'sectionForm';
                }
            }
            catch(e){}
        }

        $scope.save_subject = function(subject)
        {
            try{    
                if(subject && subject.title != '')
                {
                    if(subject.id)
                    {
                        angular.forEach($scope.grade_list,function(value,gkey){
                            if(value.grade_subject)
                            {
                                if(value.title == 'Kindergarten')
                                {
                                    var is_subject_found = $filter('filter')(value.grade_subject_list,{id:subject.id},true);
                                    if(is_subject_found.length == 0){
                                        value.grade_subject_list.push({
                                            id:$scope.kindergarten_sub.length,
                                            title:subject.title,
                                            active_subject:true,
                                            dfl_status:true
                                        });
                                    }else{
                                        is_subject_found[0].title = subject.title;
                                    }
                                }
                                else{
                                    var is_subject_found = $filter('filter')(value.grade_subject_list,{id:subject.id},true);
                                    if(is_subject_found.length == 0){
                                        value.grade_subject_list.push({
                                            id:$scope.default_subjects.length,
                                            title:subject.title,
                                            active_subject:true,
                                            dfl_status:true
                                        });
                                    }
                                }
                            }
                            else{
                                
                                var is_subject_found = $filter('filter')(value.grade_subject_list,{id:subject.id},true);
                                if(is_subject_found.length > 0){
                                    var remove_subject_index = value.grade_subject_list.findIndex(s=>s.id == subject.id);
                                    if(remove_subject_index != false)
                                    {
                                       value.grade_subject_list.splice(remove_subject_index,1); 
                                    }
                                }
                            }
                        });
                    }
                    else{
                        angular.forEach($scope.grade_list,function(value,gkey){
                            if(value.grade_subject)
                            {
                                if(value.title == 'Kindergarten')
                                {
                                    var is_subject_found = $filter('filter')($scope.kindergarten_sub,{id:subject.id},true);
                                    if(is_subject_found.length == 0){
                                        $scope.kindergarten_sub.push({id:$scope.kindergarten_sub.length + 1,title:subject.title});    
                                        $scope.dfl_subjects.push($scope.kindergarten_sub[$scope.kindergarten_sub.length - 1]);
                                    }
                                    value.grade_subject_list.push({
                                        id:$scope.kindergarten_sub.length,
                                        title:subject.title,
                                        active_subject:true,
                                        dfl_status:true
                                    });
                                }
                                else{
                                    var is_subject_found = $filter('filter')($scope.default_subjects,{id:subject.id},true);
                                    if(is_subject_found.length == 0){
                                        $scope.default_subjects.push({id:$scope.default_subjects.length + 1,title:subject.title});    
                                        $scope.dfl_subjects.push($scope.default_subjects[$scope.default_subjects.length - 1]);
                                    }
                                    value.grade_subject_list.push({
                                        id:$scope.default_subjects.length,
                                        title:subject.title,
                                        active_subject:true,
                                        dfl_status:true
                                    });
                                }
                            }
                        }); 
                    }
                    
                    $scope.subject_obj = {};
                    $scope.current_subject_form = 'subject_table';
                }
            }
            catch(e){
            }
        }

        function findindex(array,search_value)
        {
            try{
                var i = 0;
                if(array.length > 0)
                {
                    angular.forEach(array,function(value,key){
                        if(value.title == search_value)
                        {
                            return i;
                        }
                        i++;
                    });
                }
                return i;
            }
            catch(e){}
        }

        $scope.activate_subject_grade_status = function(class_list)
        {
            angular.forEach(class_list,function(value,gkey){
                var temp = [];
                if(value.title == 'Kindergarten')
                {
                    angular.forEach($scope.kindergarten_sub,function(value,key){
                        value.active_subject = true;
                        value.dfl_status = true;
                        temp.push(value);
                    });
                }
                else{
                    angular.forEach($scope.default_subjects,function(value,key){
                        value.active_subject = true;
                        value.dfl_status = true;
                        temp.push(value);
                    }); 
                }
                value.grade_subject = true;
                value.grade_subject_list = temp;
            });
        }

        $scope.open_edit_subject_form = function(subject,grade)
        {
            try{    
                if(subject)
                {
                    $scope.subject_obj = subject;
                    angular.forEach($scope.grade_list,function(value,gkey){
                        if(value.grade_subject_list)
                        {
                            var is_subject_found = $filter('filter')(value.grade_subject_list,{title:subject.title},true);
                            if(is_subject_found.length > 0)
                            {
                                value.grade_subject = true;
                            }else{
                             value.grade_subject = false;
                            }
                        }
                    }); 
                    
                    $scope.current_subject_form = 'subjectForm';
                }
            }
            catch(e){}
        }

        $scope.getgradesubject = function()
        {
          set_default_lesson_plan_subjects();
        }

        function set_default_lesson_plan_subjects()
        {
            angular.forEach($scope.grade_list,function(value,gkey){
                if($scope.dfl_obj.grade.title == value.title)
                {
                    var temp = [];
                    if(value.title == 'Kindergarten')
                    {
                        angular.forEach($scope.kindergarten_sub,function(value,key){
                            value.use_default_lesson_plan = true;
                            temp.push(value);
                        });
                    }
                    else{
                        angular.forEach($scope.default_subjects,function(value,key){
                            value.use_default_lesson_plan = true;
                            temp.push(value);
                        });
                    }
                    //value.uploaded_default_lesson_plan =[];
                    $scope.dfl_subjects = temp;
                    $scope.dfl_obj.subject = temp[0];
                }
            });
        }

        $scope.save_default_lesson_plan = function(data,plan_file)
        {
            try{
                if(data)
                {
                    $scope.selected_semester = $filter('filter')($scope.semesterlist,{title:data.current_semester},true);
                    angular.forEach($scope.grade_list,function(value,gkey){
                        var temp = [];
                        if($scope.dfl_obj.grade.title == value.title)
                        {
                            if(value.title == 'Kindergarten')
                            {
                                angular.forEach($scope.kindergarten_sub,function(kvalue,key){
                                    if(kvalue.title == data.subject.title)
                                    {
                                        var is_plan_found = $filter('filter')(value.uploaded_default_lesson_plan,{subject:kvalue.title},true);
                                        if(typeof value.uploaded_default_lesson_plan == 'undefined')
                                        {
                                            value.uploaded_default_lesson_plan = [];
                                            value.uploaded_default_lesson_plan.push({
                                                subject:data.subject.title,
                                                semester:$scope.selected_semester[0].title,
                                                upload_file_name:plan_file,
                                            });  
                                        }
                                        else{
                                            if(is_plan_found.length == 0){
                                                value.uploaded_default_lesson_plan.push({
                                                    subject:data.subject.title,
                                                    semester:$scope.selected_semester[0].title,
                                                    upload_file_name:plan_file,
                                                });  
                                            }else{
                                                if(is_plan_found[0].semester != $scope.selected_semester[0].title)
                                                {
                                                  is_plan_found[0].semester = $scope.selected_semester[0].title;  
                                                }
                                                is_plan_found[0].upload_file_name = plan_file;
                                            }
                                        }
                                    }
                                });
                            }
                            else{
                                angular.forEach($scope.default_subjects,function(dvalue,key){
                                    if(dvalue.title == data.subject.title)
                                    {
                                        var is_plan_found = $filter('filter')(value.uploaded_default_lesson_plan,{subject:dvalue.title},true);
                                        if(typeof value.uploaded_default_lesson_plan == 'undefined')
                                        {
                                            value.uploaded_default_lesson_plan = [];
                                             value.uploaded_default_lesson_plan.push({
                                                subject:data.subject.title,
                                                semester:$scope.selected_semester[0].title,
                                                upload_file_name:plan_file,
                                            });  
                                        }

                                        else{
                                            if(is_plan_found.length == 0){
                                                value.uploaded_default_lesson_plan.push({
                                                    subject:data.subject.title,
                                                    semester:$scope.selected_semester[0].title,
                                                    upload_file_name:plan_file,
                                                });  
                                            }else{
                                                if(is_plan_found[0].semester != $scope.selected_semester[0].title)
                                                {
                                                  is_plan_found[0].semester = $scope.selected_semester[0].title;  
                                                }
                                                
                                                is_plan_found[0].upload_file_name = plan_file;
                                            }
                                        }
                                        
                                    }
                                });
                            }
                           
                        }
                    });
                    angular.element("input[type='file']").val(null);
                    $scope.dfl_obj.current_semester = $scope.semesterlist[0].title;
                }
                $scope.current_default_lesson_plan_form = 'default_lesson_plan_table';
            }
            catch(e){
            }
        }

        $scope.open_edit_dfl_form_by_semester = function(grade,subject,semester)
        {
            try{
                
                $scope.dfl_obj.grade = grade;
                var subject_name = grade.grade_subject_list.map((m) => m.title).indexOf(subject);
                var file_name = grade.uploaded_default_lesson_plan.map((m) => m.subject).indexOf(subject);
               
                $scope.dfl_obj.subject = grade.grade_subject_list[subject_name];

                $scope.dfl_obj.uploade_file_name = (grade.uploaded_default_lesson_plan[file_name].upload_file_name.name ? grade.uploaded_default_lesson_plan[file_name].upload_file_name.name : '');
                
                $scope.dfl_obj.current_semester = semester;
                $scope.current_default_lesson_plan_form = 'dflForm';
                
            }
            catch(e){
              
            }
        }
    
        $scope.finishedWizard = function()
        {
            try{
                $scope.usersavebtntext = 'Saving';
                $scope.loader = false;
                $scope.finish_txt = 'Installing';
                $scope.installation_obj.session_start = $scope.installation_obj.session_date.startDate.format('MM/DD/YYYY');
                $scope.installation_obj.session_end = $scope.installation_obj.session_date.endDate.format('MM/DD/YYYY');

                $scope.installation_obj.semester_start = $scope.installation_obj.semester_date.startDate.format('MM/DD/YYYY');
                $scope.installation_obj.semester_end = $scope.installation_obj.semester_date.endDate.format('MM/DD/YYYY');
         
                $scope.installation_obj.school_semester = $scope.installation_obj.current_semester;
                $scope.installation_obj.school_grade = $scope.grade_list;
                var formdata = new FormData();
                 
                 formdata.append('session_start',$scope.installation_obj.session_start);
                 formdata.append('session_end',$scope.installation_obj.session_end);
                 formdata.append('semester_start',$scope.installation_obj.semester_start);
                 formdata.append('semester_end',$scope.installation_obj.semester_end);
                 formdata.append('current_semester',$scope.installation_obj.school_semester);
                 formdata.append('grade',JSON.stringify($scope.installation_obj.school_grade));
                 formdata.append('section_list',JSON.stringify($scope.section_list));
                 formdata.append('default_kindergarten_subject',JSON.stringify($scope.kindergarten_sub));
                 formdata.append('default_subjects',JSON.stringify($scope.default_subjects));

                angular.forEach($scope.grade_list,function(value,key){
                    if(typeof value.uploaded_default_lesson_plan != 'undefined')
                    {
                        angular.forEach(value.uploaded_default_lesson_plan, function(filevalue,filekey){
                            formdata.append(value.slug+"_"+filevalue.subject,filevalue.upload_file_name);
                        });
                    }
                 });
                $scope.usersavebtntext = 'Saving';
                 var request = {
                    method: 'POST',
                    url: urlist.school_wizard,
                    transformRequest: angular.identity,
                    data: formdata,
                    headers: {
                        'Content-Type': undefined
                    }
                };

                 $http(request)
                    .success(function (response) {
                        console.log("response",response);
                       if(response.message == true)
                        {
                            window.location.href = "<?php echo base_url(); ?>dashboard";
                        }
                        else{
                            alert("Wizard not completed");
                        }
                         $scope.loader = true;
                    })
                    .error(function () {
                    });
            }
            catch(e){
                console.log(e);
            }
        }

        $scope.open_edit_dfl_form = function(grade)
        {
            $scope.plan_file = '';

            $scope.dfl_obj.grade = grade;
            set_default_lesson_plan_subjects();
            $scope.dfl_obj.id = '';
             $scope.dfl_obj.uploade_file_name ='';
            $scope.current_default_lesson_plan_form = 'dflForm';
        }

        // Initialize default date
        $scope.defaultdate = function()
        {
            try{
                $scope.installation_obj.session_date = {
                    startDate:moment(),
                    endDate: moment().add(+1 ,'year')
                };
             
                $scope.session_options = {
                    timePicker: false,
                    autoApply: true,
                    timePickerIncrement: 5,
                    "showDropdowns": true,
                    locale:{format:  'MM/DD/YYYY' },
                    eventHandlers:{
                        'show.daterangepicker': function(ev, picker){
                           
                        }
                    }
                }

                $scope.installation_obj.semester_date = {
                    startDate:moment($scope.installation_obj.session_date.startDate),
                    endDate: moment($scope.installation_obj.session_date.startDate).add(+6 ,'month')
                };
             
               $scope.semester_options = {
                    timePicker: false,
                    autoApply: true,
                    timePickerIncrement: 5,
                    "showDropdowns": true,
                    // "minDate": moment($scope.installation_obj.session_date.startDate).format('MM/DD/YYYY'),
                    // "maxDate": moment($scope.installation_obj.session_date.endDate).format('MM/DD/YYYY'),
                    locale:{format:  'MM/DD/YYYY' },
                    eventHandlers:{
                        'show.daterangepicker': function(ev, picker){
                           $scope.installation_obj.semester_date.startDate = moment( $scope.installation_obj.semester_date.startDate).format('L');
                           $scope.installation_obj.semester_date.endDate = moment( $scope.installation_obj.semester_date.endDate).format('LLL');
                        }
                    }
                }
                $scope.$watch('semester_options.date', function (newDate) {}, false);
               
            }
            catch(ex)
            {
            }
        }
        $scope.defaultdate(); // set default date

        function getClassList()
        {
            httprequest(urlist.default_classes,({})).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.grade_list = response;
                    $scope.actual_grade_list_lenght = response.length;
                    $scope.installation_obj.grades = $scope.grade_list;
                    $scope.dfl_obj.grade = response[0];
                    loadSections();
                }
                else{
                    $scope.grade_list = [];
                    $scope.installation_obj.grades = [];
                }
            });
        }

        getClassList();
        
        function loadSections()
        {
            try{

                httprequest(urlist.default_sections,{}).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        angular.forEach($scope.grade_list,function(value,gkey){
                            var temp = [];
                            angular.forEach(response,function(value,key){
                                value.default_grade = true;
                                temp.push({status:true,title:value.title});
                            });
                            value.default_sections_in_grade = temp;
                            value.default_grades = true;
                           
                        });
                        $scope.section_list = response;
                        loadSubjects();
                        loadKindergarten();
                
                    }
                    else{
                        $scope.section_list = [];
                        $scope.installation_obj.section = [];
                    }
                })
            }
            catch(ex){}
        }

        
        function loadKindergarten()
        {
            try{
                httprequest(urlist.default_kindergarten_subject,{}).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.kindergarten_sub = response;
                        $scope.activate_subject_grade_status($scope.grade_list);
                        set_default_lesson_plan_subjects();
                    }
                    else{
                        $scope.kindergarten_sub = [];
                    }
                })
            }
            catch(ex){}
        }

        
        function loadSubjects()
        {
            try{
    
                httprequest(urlist.default_subjects,{}).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.default_subjects = response;
                        $scope.activate_subject_grade_status($scope.grade_list);

                        set_default_lesson_plan_subjects();
                    }
                    else{
                        $scope.default_subjects = [];
                    }
                    $scope.wizard_finished = true;
                })
            }
            catch(ex){}
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

<style type="text/css">

    .container {
        background-color: #f6f6f6;
    }
    .wrapper{
      position: relative;
      max-width: $wrapper-size;
      margin: 50px auto;
    }
    .no-default{
        background: #e5e5e5;
    }
    .required{
        color: red;
    }
</style>

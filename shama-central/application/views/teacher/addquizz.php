<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>
<div id="myUserModal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p>Are you sure you want to delete this Question?</p>

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                <button type="button" id="UserDelete" class="btn btn-default " value="save">Yes</button>

            </div>

        </div>

    </div>

</div>


<div class="col-sm-10" ng-controller="quiz_controller">
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Question</h3>
                <span class="question-error">Unable to save question.try again.</span>
            </div>
            <div class="modal-body">
                <?php $attributes = array('role'=>'form','name' => 'addquestionform', 'id' => 'addquestionform','class'=>'form-container-input');
                        echo form_open_multipart('', $attributes);?>
                    <input type="hidden" ng-model="inputQestionSerail" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="inputQestionSerail" id="inputQestionSerail">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="upper-row">
                                <label>Question: <span class="required"></span></label>
                            </div>
                            <input type="text"  placeholder="Question" class="form-control" ng-model="inputQuestion" id="inputQuestion" name="inputQuestion" value="">
                            <div class="image-upload">
                               <label for="inputFile_5" id="upload_5" >
                                   <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                </label>
                                <div class="imagespiner-container" id="imagespiner_container_5">
                                    <img src="" class="img-rounded" id="inputimage_5"  alt="Post Image" width="50"><br>
                                    <a href="#" id="" ng-click="showRemoveDialoag(5)">Remove</a>
                                </div>
                                <input id="inputFile_5" ng-model="inputFile_5"  class="file-input"  onchange="angular.element(this).scope().readURL(event,5);"  name="file-input" type="file" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Select Type</label>
                            <select  ng-options="item.name for item in quizetype track by item.id" ng-change="changetype()" ng-model="inputQuizetype"></select>
                        </div>
                        <div class="col-sm-4">
                            <label>Correct Option</label>
                            <select ng-options="item.name for item in correctoption track by item.id" ng-model="inputCorrectOption">

                            </select>
                        </div>
                    </div>
                    <div class="quiz-container" ng-switch="currenttype">
                         <div class="image-text" ng-switch-when = "1">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="upper-row">
                                        <label>Option 1 <span class="required">*</span></label>
                                    </div>
                                    <input type="text" id="inputoption1" ng-model="inputoption1" class="opt form-control" name="inputoption1" placeholder="Option"  tabindex="1" value="" required="required">
                                </div>
                                <div class="col-sm-6">
                                    <div class="upper-row">
                                       <label>Option 2 <span class="required">*</span></label>
                                    </div>
                                    <input type="text" id="inputoption2" ng-model="inputoption2" class="opt form-control" name="inputoption2" placeholder="Option"  tabindex="1" value="" required="required">
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-sm-6">
                                    <div class="upper-row">
                                        <label>Option 3 <span class="required">*</span></label>
                                    </div>
                                    <input type="text" id="inputoption3" ng-model="inputoption3" class="opt form-control" name="inputoption3" placeholder="Option"  tabindex="1" value="" required="required">
                                </div>
                                <div class="col-sm-6">
                                    <div class="upper-row">
                                           <label>Option 4 <span class="required">*</span> </label>
                                    </div>
                                    <input type="text" id="inputoption4" ng-model="inputoption4" class="opt form-control" name="inputoption4" placeholder="Option"  tabindex="1" value="<?php if(isset($result)){echo $result['sfullname'];} ?>" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="image-quize" ng-switch-when="2">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="upper-row">
                                        <label>Option 1 <span class="required">*</span></label>
                                    </div>
                                    <div class="image-upload">
                                       <label for="inputFile_1" id="upload_1">
                                           <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        </label>
                                        <div class="imagespiner-container" id="imagespiner_container_1">
                                            <img src="" class="img-rounded" id="inputimage_1"  alt="Post Image" width="170"><br>
                                             <a href="#" id="remove_1" data-image="" ng-click="showRemoveDialoag(1)">Remove</a>
                                        </div><br>
                                        <span id="option_image_1" class="image-error">Upload image of option-1</span>
                                        <input id="inputFile_1"  ng-model="inputFile_1" name="option_image_1" type="file" onchange="angular.element(this).scope().readURL(event,1);"  accept="image/*"/>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="upper-row">
                                        <label>Option 2 <span class="required">*</span>

                                        </label>
                                    </div>
                                    <div class="image-upload">
                                        <label for="inputFile_2" id="upload_2">
                                            <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        </label>
                                        <div class="imagespiner-container" id="imagespiner_container_2">
                                             <img src="" class="img-rounded" id="inputimage_2"  alt="Post Image" width="170"><br>
                                             <a href="#" id="remove_2" data-image="" ng-click="showRemoveDialoag(2)">Remove</a>
                                        </div><br>
                                        <span id="option_image_2" class="image-error">Upload image of option-2</span>
                                        <input id="inputFile_2"  ng-model="inputFile_2" name="option_image_2" type="file" onchange="angular.element(this).scope().readURL(event,2);"  accept="image/*"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="upper-row">
                                        <label>Option 3 <span class="required">*</span>

                                        </label>
                                    </div>
                                    <div class="image-upload">
                                        <label for="inputFile_3" id="upload_3">
                                            <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        </label>
                                        <div class="imagespiner-container" id="imagespiner_container_3">
                                             <img src="" class="img-rounded" id="inputimage_3"  alt="Post Image" width="170"><br>
                                             <a href="#" id="remove_3" data-image="" ng-click="showRemoveDialoag(3)">Remove</a>
                                        </div><br>
                                        <span id="option_image_3" class="image-error">Upload image of option-3</span>
                                        <input id="inputFile_3" ng-model="inputFile_3" name="option_image_3" type="file" onchange="angular.element(this).scope().readURL(event,3);"  accept="image/*"/>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="upper-row">
                                            <label>Option 4 <span class="required">*</span>
                                        </label>
                                    </div>
                                    <div class="image-upload">
                                        <label for="inputFile_4" id="upload_4">
                                            <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        </label>
                                        <div class="imagespiner-container" id="imagespiner_container_4">
                                            <img src="" class="img-rounded" id="inputimage_4"  alt="Post Image" width="170"><br>
                                             <a href="#" id="remove_4" data-image="" ng-click="showRemoveDialoag(4)">Remove</a>
                                        </div><br>
                                        <span id="option_image_4" class="image-error">Upload image of option-4</span>
                                        <input id="inputFile_4"  ng-model="inputFile_4" name="option_image_4" onchange="angular.element(this).scope().readURL(event,4);" type="file"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" tabindex="8" ng-click="savequestion()"  class="btn btn-default save-button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<!-- The Modal -->
<div id="imageModal" class="image-modal">

  <!-- The Close Button -->
  <span class="image-close" onclick="document.getElementById('imageModal').style.display='none'">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="image-modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="image-caption"></div>
</div>
    <?php
        // require_footer
        require APPPATH.'views/__layout/filterlayout.php';
    ?>

    <div class="panel panel-default">
        <div class="panel-heading">Quiz Form</div>
        <div class="panel-body">
            <?php
               //if( is_null($this->uri->segment(1))) {
            ?>
            <div class=" setup-content" id="step-1">
                <?php $attributes = array('role'=>'form','name' => 'quizform', 'id' => 'quizform','class'=>'form-container-input');
                    echo form_open_multipart('', $attributes);?>
                    <input type="hidden" ng-model="serail" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="upper-row">
                                <label><span class="icon-user"></span> Quiz Name: <span class="required">*</span></label>
                            </div>
                            <input type="text" id="inputquizname" name="inputquizname" ng-model="inputquizname" placeholder="Quiz name"  tabindex="1" value="<?php if(isset($schedule_single)){echo $schedule_single[0]->qname;}?>" required="required">
                        </div>
                        <div class="col-lg-6">
                            <div class="upper-row">
                                <label><span class="icon-user"></span> Quiz Date: <span class="required">*</span></label>
                            </div>
                            <input type="text" id="inputquizdate" name="inputquizdate" ng-model="inputquizdate" placeholder="Quiz Date"  tabindex="1" value="" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="upper-row">
                                <label><span class="icon-address"></span> Grade <span class="required">*</span></label>
                            </div>
                                <select ng-options="item.grade for item in classlist track by item.id"  name="inputclass" id="inputclass"  ng-model="inputclass" ></select>
                                
                                </select>
                        </div>
                        <div class="col-lg-6">
                            <div class="upper-row">
                                <label><span class="icon-address"></span> Section <span class="required" >*</span></label>
                            </div>
                            <select   ng-options="item.name for item in sectionslist track by item.id"  name="inputSection" id="inputSection"  ng-model="inputSection" ></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                        <div class="upper-row">
                            <label><span class="icon-address"></span> Subjects <span class="required">*</span></label>
                        </div>
                            <select ng-options="item.name for item in subjectlist track by item.id" name="select_subject" id="select_subject" ng-model="inputSubject"></select>
                        </div>
                        <div class="col-lg-6">
                        <div class="upper-row">
                            <label><span class="icon-address"></span> Term Result <span class="required">*</span></label>
                        </div>
                            <input type="radio" name="input_term_type" id="t_bt"  value="bt" >Before Midterm <br>
                            <input type="radio" name="input_term_type" id="t_at"  value="at" > After Midterm
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-lg-3">

                            <button type="button" class="btn btn-primary sm" id="savequiz" ng-click="savequiz()" name="inputQuizBtn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                           <a tabindex="9" href="<?php echo $path_url; ?>show_quiz_list" tabindex="6" title="cancel">Cancel</a>
                        </div>
                    </div>
                <?php echo form_close();?>
            </div>
            <?php //}?>
            <div class="quiston-container" style="display: none;">
                <div class="action-element">
                     <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add Question</button>
                </div>
               
                <table class="table-body question-table" id="table-body-phase-tow" >
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Question Name</th>
                            <th>Option 1</th>
                            <th>Option 2</th>
                            <th>Option 3</th>
                            <th>Option 4</th>
                            <th>Type</th>
                            <th>Correct</th>
                             <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id="reporttablebody-phase-two" class="report-body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php

// require_footer

?>
    <script>

        app.controller('quiz_controller',['$scope','$myUtils','$http','$filter','$interval','$compile', quiz_controller]);

        function quiz_controller($scope, $myUtils,$http,$filter,$interval,$compile) {
        
        $scope.filterobj = {};
        
        $scope.baseUrl = '<?php echo base_url() ?>'

        $scope.user_id = $myUtils.getUserId();
        $scope.name = $myUtils.getUserName();
        $scope.email = $myUtils.getUserEmail();
        $scope.roles = $myUtils.getUserRoles();
        $scope.school_id = $myUtils.getDefaultSchoolId();
        $scope.session_id = $myUtils.getDefaultSessionId();
        $scope.role_id = $myUtils.getUserDefaultRoleId();
        $scope.isTeacher = $myUtils.isTeacher();

        var urlist = {
            getclasslistTeacher:'<?php echo SHAMA_CORE_API_PATH; ?>class_list_teacher',
        }
        $scope.select_class = "";
        var app = angular.module('invantage', []);
        // Shama Core API
        function getclasslist()
        {
            try{
                //console.log(data);
                    var serail = '<?php if($this->uri->segment(2)){ echo $this->uri->segment(2) ; } ?>';
                    $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>class_list_teacher',({school_id:$scope.school_id, role_id:$scope.role_id,user_id:$scope.user_id,serail:serail})).then(function(response){
                    
                        //console.log(response)
                        if(response.length > 0 && response != null)
                        {
                            $scope.classlist = response;
                            
                                $scope.inputclass = response[0];
                            
                            getSubjectList();
                            loadSections();
                        }
                        else{
                            $scope.datesheetlist = [];
                         
                        }
                    });
                
            }
            catch(e){}
        }
        getclasslist();
        // End Shama Core API
        $scope.lastid = parseInt('<?php echo $this->uri->segment(2); ?>');
        $scope.is_edit = false;
        $scope.questionid = 0
        $(".question-error").hide()
        $scope.quizetype = [
            {
                id:1,
                name:'Text',
            },
            {
                id:2,
                name:'Image',
            }
        ]

        $scope.inputQuizetype =  $scope.quizetype[0]

         $scope.correctoption = [
            {
                id:1,
                name:'Option-1',
            },
            {
                id:2,
                name:'Option-2',
            },
            {
                id:3,
                name:'Option-3',
            },
            {
                id:4,
                name:'Option-4',
            }
        ]

        $scope.inputCorrectOption =  $scope.correctoption[0]
        $scope.currenttype = $scope.inputQuizetype.id
       $scope.changetype = function(){

            $scope.currenttype = $scope.inputQuizetype.id
       }

       // Get the modal



    var modal = document.getElementById('imageModal');

    // // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    $scope.showbigger = function(imgsrc)
    {
         var modal = document.getElementById('imageModal');
         modal.style.display = "block";
         var modalImg = document.getElementById("img01");
         modalImg.src = imgsrc;
         var captionText = document.getElementById("image-caption");
         captionText.innerHTML = "Option Image";
    }

        /**
         * ---------------------------------------------------------
         *   load table
         * ---------------------------------------------------------
         */

        function loaddatatable()
        {

            $('#table-body-phase-tow').DataTable( {
                responsive: true,

                 "order": [[ 0, "asc"  ]],

            });
        }

        angular.element(function(){
            
        });
        function getQuestionsList()
        {
            try{

                //httprequest('<?php echo $path_url; ?>getquestionlist',({id:$scope.lastid})).then(function(response){
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>question',({id:$scope.lastid})).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $('.quiston-container').show();
                        var cont_str = ''
                        for (var i = 0; i < response.length; i++) {
                            cont_str += '<tr id="'+response[i].id+'">'
                            cont_str += '<td>'
                            if(response[i].thumbnail_src != '')
                            {
                                cont_str += '<img onclick="angular.element(this).scope().showbigger(\''+response[i].image_src+'\');" src="'+response[i].thumbnail_src+'" class="quiz-image img-thumbnail" width="50"/>';
                            }
                            cont_str += '</td>'
                            cont_str += '<td>'
                            cont_str += response[i].question
                            cont_str += '</td>'
                            if(response[i].quiz_type == 't'){
                                for (var k = 0; k < response[i].options.length; k++) {
                                    cont_str += '<td>'+response[i].options[k].option+'</td>'
                                }
                            }else{
                                for (var k = 0; k < response[i].options.length; k++) {
                                    cont_str += '<td><img class="img-thumbnail" onclick="angular.element(this).scope().showbigger(\''+response[i].options[k].image_src+'\');" src="'+response[i].options[k].option+'" width="50"/></td>'
                                }
                            }


                            cont_str += '<td>'+(response[i].quiz_type == 't' ? 'Text':'Image')+'</td>'
                            cont_str += '<td>Option-'+response[i].correct+'</td>'

                            cont_str += '<td>'

                            cont_str += '<a href="#"  id="'+response[i].id+'" class="edit" title="Edit">'
                            cont_str += '<i class="fa fa-edit" aria-hidden="true"></i>'
                            cont_str += '</a>'
                            cont_str += '<a href="#"  id="'+response[i].id+'" class="del" title="Delete">'
                            cont_str += '<i class="fa fa-remove" aria-hidden="true"></i>'
                            cont_str += '</a>'

                            cont_str += '</tr>'
                        }

                        $("#reporttablebody-phase-two").html(" ");
                        $("#table-body-phase-tow").dataTable().fnDestroy();
                        $("#reporttablebody-phase-two").html(cont_str);

                       loaddatatable()
                    }
                    else{
                    }
                })
            }
            catch(ex){}
        }

        $scope.savequiz = function()
        {

            var inputquizname = $("#inputquizname").val();
            var inputclass = $("#inputclass").val();
            var inputSection = $("#inputSection").val();
            var select_subject = $("#select_subject").val();
            var input_term_type = $('input[name=input_term_type]:checked').val();
            var inputquizdate=$('input[name="inputquizdate"]').val();
            var reg = new RegExp(/^[A-Za-z0-9\s\-_+*/=,\?.;:() ]{3,256}$/);
            if(reg.test(inputquizname) == false){
                jQuery("#inputquizname").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputquizname").css("border", "1px solid #C9C9C9");
            }
            if(inputclass=="? undefined:undefined ?")
            {

                jQuery("#inputclass").css("border", "1px solid #C9C9C9");
                $('#inputclass').focus();
                return false;
            }
            if(inputSection=="? undefined:undefined ?")
            {

                $('#inputSection').focus();
            }

            if(select_subject=="? undefined:undefined ?")
            {

                $('#select_subject').focus();
            }
            var $this = $(".sm");
            $this.button('loading');

            var url = '<?php echo SHAMA_CORE_API_PATH; ?>quiz';
            var data = ({
                'inputquizname':inputquizname,
                'inputclass':inputclass,
                'inputsection':inputSection,
                'inputsubject':select_subject,
                'input_term_type':input_term_type,
                'inputquizdate':inputquizdate,
                'serial':parseInt($("#serial").val()),
                'school_id': $scope.school_id,
                'user_id':$scope.user_id,
                '<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'

            })
            httppostrequest(url,data).then(function(response){
                if(response.message == true)
                {
                    $scope.lastid =response.lastid;

                    $this.button('reset');

                    $('#myModal').modal('show');
                    $("#savequiz").attr('disabled', true);
                }else{
                   $this.button('reset');
                }
            });

            return false;
        }
        // $("#quizform").submit(function(){
            
        // })  ;

        function removeImageConfirmation(currentelementid)
        {
            $.confirm({
                theme: 'material',
                title: 'Confirm!',
                content: 'Are you sure you want to delete this message?',
                buttons: {
                    confirm: function () {
                        removeImage(currentelementid)
                    },
                    cancel: function () {
                    },
                }
            });
        }

        $scope.showRemoveDialoag = function(currentelementid)
        {
            removeImageConfirmation(currentelementid)
        }

        function removeImage(currentelementid)
        {
            if($scope.is_edit == false)
            {

                $('#inputimage_'+currentelementid).prop('src',1);
                $("#imagespiner_container_"+currentelementid).hide()
                $("#upload_"+currentelementid).show()
            }
            else
            {
                $('#inputimage_'+currentelementid).prop('src',1);
                $("#imagespiner_container_"+currentelementid).hide()
                $("#upload_"+currentelementid).show()

            }
        }


        //$("#addquestionform").submit(function(){
            $scope.savequestion = function()
            {
            var inputQuestion = $("#inputQuestion").val();
            var inputoption1 = $("#inputoption1").val();
            var inputoption2 = $("#inputoption2").val();
            var inputoption3 = $("#inputoption3").val();
            var inputoption4 = $("#inputoption4").val();


            var reg = new RegExp(/^[A-Za-z0-9\s\-_+*/=,\?.;:() ]{3,256}$/);

            if(reg.test(inputQuestion) == false){
                jQuery("#inputQuestion").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputQuestion").css("border", "1px solid #C9C9C9");
            }
            var reg = new RegExp(/^[A-Za-z0-9\s\-_+*/=,\.?;:() ]{1,256}$/);

            if($scope.inputQuizetype.id == 1)
            {
                if(inputoption1){
                    if(reg.test(inputoption1) == false){
                        jQuery("#inputoption1").css("border", "1px solid red");
                        return false;
                    }
                    else{
                        jQuery("#inputoption1").css("border", "1px solid #C9C9C9");
                    }
                }

                if(inputoption2){
                    if(reg.test(inputoption2) == false){
                        jQuery("#inputoption2").css("border", "1px solid red");
                        return false;
                    }
                    else{
                        jQuery("#inputoption2").css("border", "1px solid #C9C9C9");
                    }
                }

                if(inputoption3){
                    if(reg.test(inputoption3) == false){
                        jQuery("#inputoption3").css("border", "1px solid red");
                        return false;
                    }
                    else{
                        jQuery("#inputoption3").css("border", "1px solid #C9C9C9");
                    }
                }

                if(inputoption4){
                    if(reg.test(inputoption4) == false){
                        jQuery("#inputoption4").css("border", "1px solid red");
                        return false;
                    }
                    else{
                        jQuery("#inputoption4").css("border", "1px solid #C9C9C9");
                    }
                }
            }

            if($scope.inputQuizetype.id == 2 && $scope.is_edit == false)
            {
                for (var i = 0; i < 4; i++) {
                    var curitr = i + 1
                    var currentimage = $("#inputFile_"+curitr).val();

                    if(currentimage == '')
                    {
                        $("#option_image_"+curitr).show()
                        return false
                    }
                    else{
                        $("#option_image_"+curitr).hide()
                    }
                }
            }


            if($scope.inputQuizetype.id == 2 && $scope.is_edit == true)
            {

                for (var i = 0; i < 4; i++) {
                    var curitr = i + 1
                    var currentimage = $("#inputFile_"+curitr).val();

                    if(currentimage == '' && $("#inputimage_"+curitr).attr('src') == 1 )
                    {
                        $("#option_image_"+curitr).show()
                        return false
                    }
                    else{
                        $("#option_image_"+curitr).hide()
                    }
                }
            }

            var $this = $(".save-button");
            $this.button('loading');

            //var url = '<?php echo $path_url; ?>savequestion';
            var url = '<?php echo SHAMA_CORE_API_PATH; ?>question';
            if($scope.is_edit == true){

                var formdata = new FormData();
                formdata.append('title',inputQuestion);

                if($('input[type="file"][id="inputFile_5"]').val().length > 0){
                    formdata.append('title_image',$('input[type="file"][id="inputFile_5"]')[0].files[0]);
                }


                if($scope.inputQuizetype.id == 1)
                {
                    formdata.append('inputoption_one',inputoption1);
                    formdata.append('inputoption_two',inputoption2);
                    formdata.append('inputoption_three',inputoption3);
                    formdata.append('inputoption_four',inputoption4);
                }

                formdata.append('inputoption_true',$scope.inputCorrectOption.id);
                formdata.append('quiz_id',$scope.lastid);
                formdata.append('q_type',$scope.inputQuizetype.id);
                formdata.append('questionid',$scope.inputQestionSerail);
                if($scope.inputQuizetype.id == 2)
                {
                    if($('input[type="file"][id="inputFile_1"]').val() != ''){
                        formdata.append('option_image_1',$('input[type="file"][id="inputFile_1"]')[0].files[0]);
                    }
                    if($('input[type="file"][id="inputFile_2"]').val() != ''){
                        formdata.append('option_image_2',$('input[type="file"][id="inputFile_2"]')[0].files[0]);
                    }
                    if($('input[type="file"][id="inputFile_3"]').val() != ''){
                        formdata.append('option_image_3',$('input[type="file"][id="inputFile_3"]')[0].files[0]);
                    }
                    if($('input[type="file"][id="inputFile_4"]').val() != ''){
                        formdata.append('option_image_4',$('input[type="file"][id="inputFile_4"]')[0].files[0]);
                    }
                }

                var request = {
                    method: 'POST',
                    url: url,
                    data: formdata,
                    headers: {
                        'Content-Type': undefined
                    }
                };

                $http(request)
                    .success(function (response) {
                       if(response.message == true)
                        {
                            $scope.is_edit = false;
                            $scope.questionid = 0
                            $("#inputQestionSerail").val(0)
                             $(".question-error").hide()
                            message('Question successfully modified','show')
                           $this.button('reset');
                            emptyinputvalues()
                            getQuestionsList();

                            $("#myModal").modal('hide');
                        }
                        else{
                            $(".question-error").show()

                        }
                    })
                    .error(function () {
                         $this.button('reset');
                        $(".question-error").show()
                    });
            }

            if($scope.is_edit == false && $scope.lastid != ''){

                var formdata = new FormData();
                formdata.append('title',inputQuestion);

                if($('input[type="file"][id="inputFile_5"]').val().length > 0){
                    formdata.append('title_image',$('input[type="file"][id="inputFile_5"]')[0].files[0]);
                }

                if($scope.inputQuizetype.id == 1)
                {
                    formdata.append('inputoption_one',inputoption1);
                    formdata.append('inputoption_two',inputoption2);
                    formdata.append('inputoption_three',inputoption3);
                    formdata.append('inputoption_four',inputoption4);
                }

                formdata.append('inputoption_true',$scope.inputCorrectOption.id);
                formdata.append('quiz_id',$scope.lastid);
                formdata.append('q_type',$scope.inputQuizetype.id);
                if($scope.inputQuizetype.id == 2)
                {
                    if($('input[type="file"][id="inputFile_1"]')[0].files[0]){
                        formdata.append('option_image_1',$('input[type="file"][id="inputFile_1"]')[0].files[0]);
                    }
                    if($('input[type="file"][id="inputFile_2"]')[0].files[0]){
                        formdata.append('option_image_2',$('input[type="file"][id="inputFile_2"]')[0].files[0]);
                    }
                    if($('input[type="file"][id="inputFile_3"]')[0].files[0]){
                        formdata.append('option_image_3',$('input[type="file"][id="inputFile_3"]')[0].files[0]);
                    }
                    if($('input[type="file"][id="inputFile_4"]')[0].files[0]){
                        formdata.append('option_image_4',$('input[type="file"][id="inputFile_4"]')[0].files[0]);
                    }
                }


                var request = {
                    method: 'POST',
                    url: url,
                    data: formdata,
                    headers: {
                        'Content-Type': undefined
                    }
                };

                 $http(request)
                    .success(function (response) {
                       if(response.message == true)
                        {
                            $scope.is_edit = false;
                            $scope.questionid = 0
                            message('Question successfully modified','show')
                            emptyinputvalues()
                            $this.button('reset');
                            getQuestionsList();
                            $(".question-error").hide()
                        }
                        else{
                            $(".question-error").show()

                        }
                    })
                    .error(function () {
                        $this.button('reset');
                        $(".question-error").show()
                    });
            }

            return false;
        }

        $scope.uploadelemntid = ''

        $scope.readURL = function(event,uploadelemntid) {
            var files = event.target.files;
            var file = files[0];
            var reader = new FileReader();
            $scope.uploadelemntid = uploadelemntid
            reader.onload = $scope.imageIsLoaded
            reader.readAsDataURL(file);
            $("#upload_"+uploadelemntid).hide()
            $('#imagespiner_container_'+uploadelemntid).show();

            if($scope.inputQuizetype.id == 2 && $scope.is_edit == false)
            {
                for (var i = 0; i < 4; i++) {
                    var curitr = i + 1
                    var currentimage = $("#inputFile_"+curitr).val();

                    if(currentimage == '')
                    {
                        $("#option_image_"+curitr).show()
                    }
                    else{
                        $("#option_image_"+curitr).hide()
                    }
                }
            }
        }

        $scope.imageIsLoaded = function(e){
            $scope.$apply(function() {
               $("#inputimage_"+$scope.uploadelemntid).prop('src', e.target.result);
            });
        }

        // function saveprofileUpload(uploadelemntid,isquizimage)
        // {
        //     var files = $('input[type="file"][id="inputFile_'+uploadelemntid+'"]')[0].files[0];

        //     var size, ext ;
        //     file = files;

        //     size = file.size;
        //     ext = file.name.toLowerCase().trim();
        //     ext = ext.substring(ext.lastIndexOf('.') + 1);
        //     ext = ext.toLowerCase();
        //     var validExt = ["png","jpg","bmp","gif","jpeg"];
        //     if($.inArray(ext,validExt) == -1){
        //         message("Please must upload image file","show");
        //         return false;
        //     }
        //     else{
        //         message("","hide");
        //     }

        //     if(size > 5000000 ){
        //         alert("File must be less than 5MB")
        //         return false;
        //     }

        //     var data = new FormData();
        //     data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');
        //     data.append('file',$('input[type="file"][id="inputFile_'+uploadelemntid+'"]')[0].files[0])
        //     data.append('isquizimage',isquizimage)
        //     $.ajax({
        //         url: '<?php echo $path_url;?>Principal_controller/uploadStudentProfile?files',
        //         type: 'POST',
        //         data: data,
        //         cache: false,
        //         dataType: 'json',
        //         mimeType:"multipart/form-data",
        //         processData: false, // Don't process the files
        //         contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        //         success: function(data) {
        //             if(data.message == true)
        //             {
        //                 window.location.href = "<?php echo $path_url;?>show_std_list";
        //             }
        //         }
        //     });
        //     return false;
        // }

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


    function httprequest(url,data)
      {
        var request = $http({
          method:'GET',
          url:url,
          params:data,
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



setTimerForWidget('section',1)
   // $scope.select_class = $scope.ini;
    function setTimerForWidget(crname,ctime)
    {

       $scope.ptime = 0;
      reporttimer = $interval(function(){
        if($scope.ptime < parseInt(ctime))
        {
          $scope.ptime++
        }
        else{
          if(crname == 'section'){
            //loadSections()
          }



          $interval.cancel(reporttimer)

      }
    },300)
      }

      function getSubjectList()
      {
        try{
            var data = ({
                            school_id:$scope.school_id,
                            class_id:$scope.inputclass.id,

                            })
                $myUtils.httprequest('<?php echo SHAMA_CORE_API_PATH; ?>subject_list_by_class',data).then(function(response){
                if(response.length > 0 && response != null)
                {
                    $scope.subjectlist = response;
                    $scope.inputSubject =  response[0];

                    var q_id = '<?php if($this->uri->segment(2)){ echo $this->uri->segment(2) ; } ?>'
                    if(q_id != '' )
                    {
                       
                    }
                    else
                    {
                        $('#t_bt').attr('checked', true);
                    }
                }
                else{
                    $scope.subjectlist = [];
                }
            })
        }
        catch(ex){}
    }

    function getSelectedSubject(class_id,select_subject)
    {
        try{
            var data = ({class_id:class_id })
            var select_subject = select_subject;
            httprequest('<?php echo SHAMA_CORE_API_PATH; ?>selected_subject',data).then(function(response){
                if(response.length > 0 && response != null)
                {

                    
                    $scope.subjectlist = response;
                    
                    for (var i=0; i<response.length; i++) {
                        
                        
                        if(response[i].id==select_subject)
                        {
                            
                            $scope.inputSubject =  response[i];
                        }
                    }
                    
                    
                }
                else{
                    return false
                }
            })
        }
        catch(ex){}
    }
    // Edit case
    function getQuizEdit(rowid)
    {
        try{
            var data = ({inputrowid:rowid })

            httprequest('<?php echo SHAMA_CORE_API_PATH; ?>selected_quiz',data).then(function(response){
                if(response.length > 0 && response != null)
                {
                    $scope.inputSubject =  response[0];
                    
                    
                    $scope.inputquizname =  response[0].qname;
                    $scope.inputquizdate =  response[0].quiz_date;
                    //$scope.classlist = response;
                           
                    $("#inputclass").val(response[0].class_id);

                    $("#inputSection").val(response[0].section_id);
                    $("#select_subject").val(response[0].subject_id);
                    if(response[0].quiz_term=='bt')
                    {
                        $('#t_bt').attr('checked', true);
                        
                    }
                    else
                    {
                        
                        $('#t_at').attr('checked', true);
                       
                    }
                    

                    getSelectedSubject(response[0].class_id,response[0].subject_id);
                    //console.log(response[0].class_id);        
                    getQuestionsList();
                }
                else{
                    return false
                }
            })
        }
        catch(ex){}
    }
    <?php if($this->uri->segment(2)){  

    ?>
    getQuizEdit(parseInt(<?php if($this->uri->segment(2)){ echo $this->uri->segment(2) ; } ?>))
    <?php } ?>
    $scope.testme = function()
    {
        alert()
    }
    
        
        function loadSections()
        {

            try{
                 
                var data = ({
                            school_id:$scope.school_id, 
                            role_id:$scope.role_id,
                            user_id:$scope.user_id,
                            class_id:$scope.inputclass.id,
                            })
                $myUtils.httppostrequest('<?php echo SHAMA_CORE_API_PATH; ?>getsectionbyclass',data).then(function(response){
                
                    if(response.length > 0 && response != null)
                    {
                        $scope.inputSection = response[0];
                        $scope.sectionslist = response;
                        //getSubjectList()
                    }
                    else{
                        $scope.sectionslist = [];
                    }
                })
            }
            catch(ex){}
        }
        //loadSections();
        

        

           $(document).on('change','#inputclass',function(){
             try{

                getSubjectList()
                loadSections()
            }
            catch(ex){}
        })

        function httprequest(url,data)
      {
        var request = $http({
          method:'GET',
          url:url,
          params:data,
          cache : false,
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

      $scope.is_edit_list_found = []

        $(document).on('click','.edit',function(){
            $("#myModal").modal('show');
            $scope.is_edit = true;
            $scope.questionid = $(this).attr('id')
            $scope.inputQestionSerail = $(this).attr('id')
            $("#inputQestionSerail").val($(this).attr('id'))
            $scope.is_edit_list_found = []
            httprequest('<?php echo SHAMA_CORE_API_PATH; ?>question_by_id',({qid:$(this).attr('id')})).then(function(response){
                if(response != null){
                    $scope.is_edit_list_found = response
                    $("#inputQuestion").val($scope.is_edit_list_found[0].question)
                    $scope.inputCorrectOption = $scope.correctoption[$scope.is_edit_list_found[0].correct - 1];

                   $scope.inputQuizetype = $scope.quizetype[$scope.is_edit_list_found[0].type -1]
                   $scope.currenttype = $scope.inputQuizetype.id

                   if($scope.is_edit_list_found[0].thumbnail_src !='')
                   {
                        $(".img-rounded").attr('src',$scope.is_edit_list_found[0].thumbnail_src);
                        $(".imagespiner-container").show()
                        $("#upload_5").hide()
                   }

                }

            })

            $scope.isloaded = false
            $pinterval = $interval(function(){
                if($scope.is_edit_list_found.length > 0 && $scope.currenttype == 1)
                {
                    $("#inputoption1").val($scope.is_edit_list_found[0].options[0].option)
                    $("#inputoption2").val($scope.is_edit_list_found[0].options[1].option)
                    $("#inputoption3").val($scope.is_edit_list_found[0].options[2].option)
                    $("#inputoption4").val($scope.is_edit_list_found[0].options[3].option)
                    $scope.isloaded = true
                }

                if($scope.is_edit_list_found.length > 0)
                {
                    if($scope.inputQuizetype.id == 2 && $scope.isloaded == false)
                   {
                        for(var i = 0 ; i <= 3 ; i++){

                            if($("#inputFile_"+(parseInt(i)+1)).val() != ''){
                                $scope.isloaded = false
                            }
                            else{
                                $("#upload_"+(parseInt(i)+1)).hide()
                                $("#remove_"+(parseInt(i)+1)).attr('data-image',$scope.is_edit_list_found[0].options[i].optionid)
                                $("#inputimage_"+(parseInt(i)+1)).prop('src',$scope.is_edit_list_found[0].options[i].option)
                                $("#imagespiner_container_"+(parseInt(i)+1)).show()
                                $scope.isloaded = true
                            }
                        }
                   }

                   if($scope.isloaded == true)
                   {
                    $interval.cancel($pinterval);
                    $scope.isloaded = false
                   }

                }
            },500)

        });


        function emptyinputvalues()
        {
            $("#inputQuestion").val('')
            $("#inputoption1").val('')
            $("#inputoption2").val('')
            $("#inputoption3").val('')
            $("#inputoption4").val('')

            $(".imagespiner-container").hide()
            for (var i = 1; i <= 5; i++) {
                $("#upload_"+i).show()
                 $("#inputFile_"+i).attr('src','')
            }

            $scope.currenttype = 1
            $scope.inputQuizetype =  $scope.quizetype[0]
            $scope.inputCorrectOption =  $scope.correctoption[0]
        }


        $('#myModal').on('hidden.bs.modal', function () {
            emptyinputvalues()
        })

         /*

         * ---------------------------------------------------------

         *   Delete User

         * ---------------------------------------------------------

         */

        $(document).on('click','.del',function(){
            $("#myUserModal").modal('show');
            dvalue =  $(this).attr('id');
            row_slug =   $(this).parent().parent().attr('id');
        });

        /*
         * ---------------------------------------------------------
         *   User notification on deleting user
         * ---------------------------------------------------------
         */
        $(document).on('click','#UserDelete',function(){
            $("#myUserModal").modal('hide');
            // ajaxType = "";
            // urlpath = "<?php echo SHAMA_CORE_API_PATH?>removeQuestion";
            // var dataString = ({'id':dvalue});
            urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>question";
            
            var data = 'id='+String(dvalue);
            urlpath += '?'+ data;
            
            ajaxType = 'DELETE';
            ajaxfunc(urlpath,[],userDeleteFailureHandler,loadUserDeleteResponse);
        });

        function userDeleteFailureHandler()
        {
            $(".user-message").show();
            $(".message-text").text("Question has been not deleted").fadeOut(10000);
        }

        function loadUserDeleteResponse(response)
        {

            if (response.message === true){

                $("#"+dvalue).remove();

                $(".user-message").show();

                $(".message-text").text("Question has been deleted").fadeOut(10000);

            }

        }


    };





</script>

<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>
<script type="text/javascript">
    $(document).ready(function(){

        var userdate = '<?php if(isset($schedule_single)){echo date('m/d/Y',strtotime($schedule_single[0]->quiz_date));}?>';
        initdatepickter('input[name="inputquizdate"]',userdate)

        function initdatepickter(dateinput,userdate)
        {

            $(dateinput).daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: (userdate != '' ? userdate : new Date() ) ,
                locale: {
                    format: 'MM/DD/YYYY'
                }
            });
        }
    });
</script>

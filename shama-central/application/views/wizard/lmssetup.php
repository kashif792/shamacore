<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>
 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.steps.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.steps.min.js"></script>

<div class="col-sm-10"  ng-controller="wizard_ctrl">
    <?php
        // require_footer 
        require APPPATH.'views/__layout/filterlayout.php';
    ?>
        <div id="delete_class" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this class?</p>
                 </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" id="savedelete" class="btn btn-default " value="save">Yes</button>
                </div>
            </div>
        </div>
    </div>

<form id="example-advanced-form" action="#">
    <h3>Classes</h3>
    <fieldset>
        <legend>Class Information</legend>
 
                                <div class="form-group">
                                     <label for="inputSection"  class="control-label">Class :</label>
                                      <input type="text" class="form-control" id="input_class_name" name="input_class_name" ng-model="input_class_name" ng-change="setClass()"  placeholder="Name" value="<?php if(isset($class_single)){echo $class_single[0]->grade;}?>">
                                </div>
                                 <div class="form-group">
                                      <button type="button" ng-click="saveclass()" tabindex="8" class="btn btn-primary class-btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                                </div>
                                <div class="col-sm-12">
                                            <table class="table table-bordered table-striped table-hover table-responsive" id="table-body-phase-tow" >
                                                <thead>
                                                    <tr>
                                                        <th>Class</th>
                                                        <th>Checkbox</th>
                                                        <th>Options</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="reporttablebody-phase-two" class="report-body">
                                                    <tr ng-repeat="c in classlist" ng-class-odd="'active'">
                                                        <td class="row-update" >{{c.name}}</td>
                                                        <td class="row-update" ><input type="checkbox" name="classcheck" checked></td>
                                                       <td>
                                                            <a href="javascript:void(0)" ng-click="editclass(c.id)" title="Edit" class="edit" session-data="{{s.id}}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="javascript:void(0)" ng-click="removeclass(c.id)" title="Delete"  class="del" session-data="{{s.id}}">
                                                                <i class="fa fa-remove" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                </div>



    </fieldset>
 
    <h3>Add section</h3>
    <fieldset>
        <legend>Add Section</legend>
                                        <div class="form-group">
                                            <label for="inputSection">Name:</label>
                                            <input type="text" class="form-control" name="inputSection" id="inputSection" ng-model="inputSection">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" ng-click="savenewsection()" class="btn btn-primary section-btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                                        </div>
                                                                                <div class="col-sm-12">
                                            <table class="table table-bordered table-striped table-hover table-condensed" id="table-body-phase-tow" >
                                                <thead>
                                                    <tr>
                                                        <th>Section</th>
                                                  
                                                        <th>Options</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="reporttablebody-phase-two" class="report-body">
                                                    <tr ng-repeat="s in sectionlist" ng-class-odd="'active'">
                                                        <td>{{s.name}}</td>
                                                      
                                                        <td>
                                                            <a href="javascript:void(0)" ng-click="editsection(s.id)" title="Edit" class="edit" session-data="{{s.id}}">
                                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="javascript:void(0)" ng-click="removesection(s.id)" title="Delete"  class="del" session-data="{{s.id}}">
                                                             <i class="fa fa-remove" aria-hidden="true"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
    </fieldset>
 
    <h3>Assign Section</h3>
    <fieldset>
        <legend>Assign Sections</legend>
                                                <div class="field-container ">
                                            <div class="upper-row">
                                                <label><span class="icon-th-list"></span> Class <span class="required">*</span></label>
                                            </div>
                                            <div class="field-row">
                                                <div class="left-column">
                                                    <select ng-options="item.name for item in classlist track by item.id"  id="inputClasslist" name="inputClasslist" ng-model="inputClasslist" ng-change="getassignlistclass()"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field-container ">
                                            <div class="upper-row">
                                                <label><span class="icon-th-list"></span> Section <span class="required">*</span></label>
                                            </div>
                                            <div class="field-row">
                                                <div class="column">
                                                    <span ng-repeat="s in sectionlist">
                                                        <input type="checkbox" name="inputSectionChecked[]" value="{{s.id}}" ng-checked="inputSectionChecked === s.id"  ng-true-value="{{s.id}}" id="inputSectionChecked_{{s.id}}" ng-model="inputSectionChecked" ng-click="addsections(s.id)">{{s.name}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" ng-click="sectionassign()" class="btn btn-primary assign-btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                                        </div>
    </fieldset>
 
    <h3>Finish</h3>
    <fieldset>
        <legend>Terms and Conditions</legend>
 
        <input id="acceptTerms-2" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
    </fieldset>
</form>

</div>

<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>
       




<script type="text/javascript">
 

    
        var form = $("#example-advanced-form").show();
 
form.steps({
    headerTag: "h3",
    bodyTag: "fieldset",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex)
        {
            return true;
        }
        // Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3 && Number($("#age-2").val()) < 18)
        {
            return false;
        }
        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex)
        {
            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex)
    {
        // Used to skip the "Warning" step if the user is old enough.
        if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
        {
            form.steps("next");
        }
        // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
        if (currentIndex === 2 && priorIndex === 3)
        {
            form.steps("previous");
        }
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        alert("Submitted!");
    }
}).validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        confirm: {
            equalTo: "#password-2"
        }
    }
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
   

    /*
     * ---------------------------------------------------------
     *   Save new user
     * ---------------------------------------------------------
     */



        $("#parentForm").submit(function(e){
            e.preventDefault();
            var inputFirstName = $("#inputFirstName").val();
            var inputLastName = $("#inputLastName").val();
            var inputEmail = $("#inputEmail").val();
            var inputStore = $("#inputStore").val();
            var inputNewPassword = $("#inputNewPassword").val();
            var inputRetypeNewPassword = $("#inputRetypeNewPassword").val();
            
            var reg = new RegExp(/^[A-Za-z0-9 ]{3,50}$/);
          
            if(reg.test(inputFirstName) == false){
                jQuery("#inputFirstName").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputFirstName").css("border", "1px solid #C9C9C9");                                 
            }
            if(reg.test(inputLastName) == false){
                jQuery("#inputLastName").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#inputLastName").css("border", "1px solid #C9C9C9");                                 
            }
            if($("#serial").val() == ' '){
                var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
                if(reg.test(inputEmail) == false){
                    jQuery("#inputEmail").css("border", "1px solid red");
                    jQuery("#inputEmail").focus();
                    return false;
                }
                else{
                    jQuery("#inputEmail").css("border", "1px solid #C9C9C9");                                 
                }
            }
            if(inputStore ==''){
                jQuery("#inputStore").css("border", "1px solid red");
                jQuery("#inputStore").focus();
                return false;
            }
            else{
                jQuery("#inputStore").css("border", "1px solid #C9C9C9");                                 
            }
            var checked=false;
            var elements = document.getElementsByName("userlist[]");
            for(var i=0; i < elements.length; i++){
                if(elements[i].checked) {
                    checked = true;
                    var txt = elements[i].value;
                    
                }
            }
            if (!checked) {
                $("#user-list-error").show();
                return false;
            }
            else{
                $("#user-list-error").hide();
            }
            var reg = new RegExp(/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{6,20})$/);
            if($("#serial").val() == ' '){    
                if(reg.test(inputNewPassword) == false){
                    jQuery("#inputNewPassword").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#inputNewPassword").css("border", "1px solid #C9C9C9");                                 
                }

                if(reg.test(inputRetypeNewPassword) == false){
                    jQuery("#inputRetypeNewPassword").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#inputRetypeNewPassword").css("border", "1px solid #C9C9C9");                                 
                }
                
                if(inputRetypeNewPassword != inputNewPassword ){
                    jQuery("#inputRetypeNewPassword").css("border", "1px solid red");
                    jQuery("#inputNewPassword").css("border", "1px solid red");
                    return false;
                }
                else{
                    jQuery("#inputRetypeNewPassword").css("border", "1px solid #C9C9C9");                           
                    jQuery("#inputNewPassword").css("border", "1px solid #C9C9C9"); 
                }
                
            }               
            
            var dataString = jQuery('#userForm').serializeArray();
            ajaxType = "POST";
            urlpath = "<?php echo $path_url; ?>users/saveUser";
            ajaxfunc(urlpath,dataString,userResponseFailure,loadUserResponse); 
            return false;
        });
    
        function userResponseFailure()
        {
            $(".user-message").show();
            $(".message-text").text("User data not saved").fadeOut(10000);
        }

        function loadUserResponse(response)
        {
            if(response.message == true){
                window.location.href = "<?php echo $path_url;?>settings";
            }
        }     


</script>
<script type="text/javascript">
    var app = angular.module('invantage', []);
    app.controller('wizard_ctrl', function($scope, $window, $http, $document, $timeout,$interval,$compile){

        var urlist = {
            getclasslist:'getclasslist',
            getsectionbyclass:'getsectionbyclass',
            getstudentbyclass:'getstudentbyclass',
            getsectionF:'getsectionF',
            savesectionF:'savesectionF',
            removesession:'removesession',
            getsessiondetail:'getsessiondetail',
            saveassignsection:'saveassignsection',
            getselectedsection:'getselectedsection',
            removesection:'removesection',
            removeclass:'removeclass',
            changecstatus:'changecstatus',
        }

        $scope.sid = '';
        $scope.serial = '';
        $scope.saveclass = function()
        {
            var input_class_name = $("#input_class_name").val();

            var reg = new RegExp(/^[A-Za-z0-9 ]{1,50}$/);
            message('','hide')
            if(reg.test(input_class_name) == false){
                jQuery("#input_class_name").css("border", "1px solid red");
                return false;
            }
            else{
                jQuery("#input_class_name").css("border", "1px solid #C9C9C9");
            }

            if($scope.classlist != null){
                for (var i = $scope.classlist.length - 1; i >= 0; i--) {
                    if($scope.classlist[i].name.toLowerCase() == input_class_name.toLowerCase())
                    {
                        message('Can not add duplicate class','show')
                        return false
                    }
                }
            }

            var $this = $(".class-btn");
            $this.button('loading');

        
            var formdata = new FormData();
            formdata.append('inputclassid',$scope.serial);
            formdata.append('input_class_name',input_class_name);
            formdata.append('inputLocation',$scope.inputLocation.sid);
            var request = {
                method: 'POST',
                url: "<?php echo $path_url; ?>saveClassF",
                data: formdata,
                headers: {'Content-Type': undefined}
            };

            $http(request)
                .success(function (response) {
                    var $this = $(".class-btn");
                    $this.button('reset');
                    if(response.message == true){
                        message('Class has been successfully saved','show')
                        $scope.input_class_name = '';
                        loadclass()
                    }

                    if(response.message == false){
                        $scope.input_class_name = '';
                        message('Class did not save','show')
                    }
                })
                .error(function(){
                    var $this = $(".class-btn");
                    $this.button('reset');
                    $scope.input_class_name = '';
                    message('Class data not saved','show')
                });

            //      ajaxType = "POST";
            //      urlpath = "<?php echo $path_url; ?>saveClass";
            //      ajaxfunc(urlpath,dataString,classResponseFailure,loadClassResponse);
            return false;
        }



        $scope.cid = '';
        $scope.editclass = function(classid)
        {
            $scope.serial = classid
            var data = ({
                inputclassid:$scope.serial
            })
          
            message('','hide');
           $("#serial").val(classid)
           httprequest(urlist.getclasslist,data).then(function(response){
                if(response != null)
                {
                    
                    $scope.input_class_name = response[0].name;
                }else{
                    message('Try again','show');
                }
            });
        }


         $scope.removeclass = function(classid)
        {
            $("#delete_class").modal('show');

            $scope.cid = classid
        }

        $(document).on('click','#savedelete',function(){
            $("#delete_class").modal('hide');
            var data = ({
                inputclassid:$scope.cid
            })

           httprequest(urlist.removeclass,data).then(function(response){
                if(response != null)
                {
                   message('Class has been successfully removed','show')
                   loadclass()
                   $scope.cid = ''
                }else{
                    message('Class did not remove','show')
                }
            });
        });



         angular.element(function () {
            loadSection()
            loadclass()
            getSchoolList()
         });

        function loadSection()
        {
            httprequest(urlist.getsectionF,({})).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.sectionlist = response
                    $scope.inputClassSection = response[0]

                }
            });
        }

        function loadclass()
        {
            httprequest(urlist.getclasslist,({})).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.classlist = response
                    $scope.inputClasslist = response[0]

                }
            });
        }


        $scope.savenewsection = function()
        {
            message('','hide')
            if($scope.sectionlist != null){
                for (var i = $scope.sectionlist.length - 1; i >= 0; i--) {
                    if($scope.sectionlist[i].name.toLowerCase() == $scope.inputSection.toLowerCase())
                    {
                        message('Can not add duplicate section','show')
                        return false
                    }
                }
            }

            if($scope.inputSection.length > 0)
            {
                var data = ({
                    inputsectionname:$scope.inputSection,
                  
                })
                var $this = $(".section-btn");
                $this.button('loading');


                httppostrequest(urlist.savesectionF,data).then(function(response){
                    if(response != null && response.message == true)
                    {
                        $this.button('reset');
                        $scope.inputSection = '';
                        message('Section has been successfully saved','show')
                        loadSection()
                    }else{
                        message('Section did not save','show')
                        $this.button('reset');
                    }
                });
            }
        }

        $scope.editsection = function(sectionid)
        {
            $scope.sid = sectionid
            var data = ({
                inputsectionid:$scope.sid
            })

           httprequest(urlist.getsection,data).then(function(response){
                if(response != null)
                {
                    $scope.inputSection = response[0].name;
                    for (var i = 0; i < $scope.classlist.length; i++) {
                        if($scope.classlist[i].id == response[0].class)
                        {
                            $scope.inputClasslist = $scope.classlist[i];
                        }
                    }
                }
            });
        }

        $scope.removesection = function(sectionid)
        {
            $("#delete_dialog").modal('show');

            $scope.sid = sectionid
        }

        $(document).on('click','#save',function(){
            $("#delete_dialog").modal('hide');
            var data = ({
                inputsectionid:$scope.sid
            })

           httprequest(urlist.removesection,data).then(function(response){
                if(response != null)
                {
                   message('Section has been removed','show')
                   loadSection()
                   loadclass()

                   $scope.sid = ''
                }else{
                    message('Section did not remove','show')
                }
            });
        });

        $scope.selectedsections = []

        $scope.addsections = function(sectinoid)
        {
            if($("#inputSectionChecked_"+sectinoid).is(":checked")){
                var temp ={
                    id:sectinoid,
                    status:($("#inputSectionChecked_"+sectinoid).is(':checked') == true ? 1 : 0)
                }
                $scope.selectedsections.push(temp)
            }else{
                for (var i = 0; i < $scope.selectedsections.length; i++) {
                    if($scope.selectedsections[i].id == sectinoid)
                    {
                        $scope.selectedsections.splice(i, 1);
                    }
                }
            }
        }


        $scope.sectionassign = function()
        {
            var $this = $(".assign-btn");
            $this.button('loading');
            message('','hide');
            var data = ({
                    inputclassid: $scope.inputClasslist.id,
                    inputsection: $scope.selectedsections
                })

            if($scope.inputClasslist.id != '' && $scope.selectedsections.length > 0)
            {
                httppostrequest(urlist.saveassignsection,data).then(function(response){
                    if(response != null && response.message == true)
                    {
                         $this.button('reset');
                        message('Section assigned','show')
                    }
                    else{
                        $this.button('reset');
                        message('Section not assigned','show')
                    }
                });
            }else{
                message('Please select atleast single section','show');
                var $this = $(".assign-btn");
                $this.button('reset');
            }
        }

        $scope.getassignlistclass= function()
        {
            try{
                $scope.selectedsections = []
                httprequest(urlist.getselectedsection,({inputclassid:$scope.inputClasslist.id})).then(function(response){
                    if(response != null  && response.length > 0){
                         $("input[type=checkbox]").each(function(){
                            $(this).prop('checked',false)
                        })
                        for (var i = 0; i <= response.length - 1; i++) {
                            if(response[i].status == 'a'){
                                $("#inputSectionChecked_"+response[i].id).prop('checked',true)
                            }
                            else{
                                $("#inputSectionChecked_"+response[i].id).prop('checked',false)
                            }

                            if($("#inputSectionChecked_"+response[i].id).is(':checked') == true){
                                var temp ={
                                    id:response[i].id,
                                    status:(response[i].status == 'a' ? 1 : 0)
                                }
                                $scope.selectedsections.push(temp)
                            }
                        }
                    }else{

                        $("input[type=checkbox]").each(function(){
                            $(this).prop('checked',false)
                        })
                    }
                });
            }
            catch(ex){}
        }

        function getSchoolList()
        {
             try{
                var data = ({tschool:'tschool'})
                httprequest('getschoollist',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.selectlistcity = response;
                        $scope.inputLocation = response[0];
                    }
                    else{
                        $scope.selectlistcity = []
                    }
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

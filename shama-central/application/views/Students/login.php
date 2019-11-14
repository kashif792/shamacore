<!DOCTYPE html>
<html ng-app="invantage">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Student Portal</title>
    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/login.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fontello.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css">
        <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>js/angular-1.6.4.min.js"></script>
        <script src="<?php echo base_url(); ?>js/angular-route.js"></script>
        <script src="<?php echo base_url(); ?>js/angular-cookies.js"></script>
        <script src="<?php echo base_url(); ?>js/ngStorage.min.js"></script>
  </head>

<body>
<div class="log_cont" ng-controller="login_ctrl">
       <hgroup>
       
    </hgroup>
    <div id="login-form">
        <div id="error-messages"></div>
        <div id="logo-container">
            <img src="<?php echo base_url(); ?>images/nrschoollogo.png">            
        </div>
        
        <?php $attributes = array('name' => 'loginform', 'id' => 'loginform'); echo form_open('', $attributes);?>
            <div class="group">
                <input type="text" tabindex="1" id="username" name="username" value="">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Student Roll No</label>
                <span id="emailError" class="hide error">Enter valid username</span>
            </div>
            <div class="group">
                <input type="password" id="inputPassword" tabindex="2" name="password">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Password</label>
                <span id="passwordError" class="hide error" >Enter valid password</span>
            </div>
            <button type="submit" tabindex="3" class="button buttonBlue" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Checking...">Login
                <div class="ripples buttonRipples">
                    <span class="ripplesCircle"></span>
                </div>
            </button>
        <?php echo form_close();?>
        <div class="hide">
            Forgot password ? <a href="#" onClick="$('#login-form').hide(); $('#forgot-password').show()">Click here</a>
        </div>
    </div>
    
    <div id="forgot-password" class="login-form" style="display:none;">
        <div id="forgot-error-messages"></div>
        <div id="logo-container">
            <img src="<?php echo base_url(); ?>images/nrschoollogo.png">            
        </div>
        <?php $attributes = array('name' => 'forgotReset', 'id' => 'forgotReset'); echo form_open('', $attributes);?>
            <div class="group">
                <input type="text" tabindex="1" id="forgotEmail" name="forgotEmail">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Username</label>
            </div>
            <button type="submit" id="btn-forgot-password" tabindex="2" class="button buttonBlue">Email
                <div class="ripples buttonRipples">
                    <span class="ripplesCircle"></span>
                </div>
            </button>
        <?php echo form_close();?>
        <div>
            Sign in ? <a href="#" onClick="$('#forgot-password').hide(); $('#login-form').show()">Click here</a>
        </div>
    </div>
     <hgroup class="bottom">
         <img src="<?php echo base_url(); ?>images/logo.png">
        <h1>Powered by Zilon - All Rights Reserved <?php echo date('Y'); ?></h1>
       
    </hgroup>
    </div>
    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/insight.js"></script>
    <script type="text/javascript">
        function getUrlVars(){
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;        
        }
    </script>

    <script>
        var app = angular.module("invantage", ["ngRoute","ngStorage"]);
        app.controller('login_ctrl',function($scope,$localStorage,$sessionStorage,$http){

            hidePlaceholder();
            function hidePlaceholder()
            {
                var username = $("#username").val(); 
                var inputPassword = $("#inputPassword").val();
                var forgotEmail = $("#forgotEmail").val();
                 if(username != '' || inputPassword != '' || forgotEmail != ''){
                    jQuery("#username").attr("placeholder", "");
                    jQuery("#inputPassword").attr("placeholder", "");
                    jQuery("#forgotEmail").attr("placeholder", "");
                }
            }
  
            // Login module
            $(document).on("submit","#loginform",function(){             
                var username = $("#username").val(); 
                var inputPassword = $("#inputPassword").val();
                var loginremember = false;
                hidePlaceholder();
               /// var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{3,56}$/i);
                var reg = new RegExp(/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/);
                if(reg.test(username) == false){
                    jQuery("#username").css("border", "1px solid red");
                    $("#emailError").removeClass('hide');
                    $("#emailError").addClass('show');
                    return false;
                }
                else{
                    jQuery("#username").css("border", "1px solid #C9C9C9");                                 
                    $("#emailError").addClass('hide');
                    $("#emailError").removeClass('show');
                }        
                var reg = new RegExp(/^[+a-zA-Z0-9._-]{3,20}$/i);
                if(reg.test(inputPassword) == false){
                    jQuery("#inputPassword").css("border", "1px solid red");
                    $("#passwordError").addClass('show');
                    $("#passwordError").removeClass('hide');
                    return false;
                }
                else{
                    jQuery("#inputPassword").css("border", "1px solid #C9C9C9");                                 
                    $("#passwordError").addClass('hide');
                    $("#passwordError").removeClass('show');
                }
                var $this = $(".buttonBlue");
                $this.button('loading');
                var dataString =  $( "#loginform" ).serialize();  //"default_response="+default_response+"&field_one_title="+field_one_title+"&field_two_title="+field_two_title+"&field_three_title="+field_three_title+"&field_four_title="+field_four_title+"&field_five_title="+field_five_title+"&inputComment="+inputComment;
                ajaxType = "POST";
                urlpath = "authenticatestdapp";
                ajaxfunc(urlpath,dataString,authenticationResponseFailure,loadAuthenticationResponse); 
                return false; 
            });

            function authenticationResponseFailure()
            {
                var $this = $(".buttonBlue");
                    $this.button('reset');
            }

            function loadAuthenticationResponse(response)
            {
                if(response.message === true){
                    $scope.getUserInfo(response.student_id);
                }
                else if(data.message == "changePassword"){
                    window.location = "passchange";
                }
                else if(data.authorize == false){
                    $("#error-messages").text("You don't have right to access student portal");
                    $("#error-messages").show();
                }
                else{
                    $("#error-messages").text("Email or Password incorrect Or Your account may be suspended");
                    $("#error-messages").show();
                }
                var $this = $(".buttonBlue");
                $this.button('reset');
            }  

            $scope.getUserInfo = function(student_id)
            {
                httppostrequest('<?php echo base_url(); ?>getStudentInfo',({student_id:student_id})).then(function(response){
                    if(response.status == true)
                    {
                        $localStorage.studentinfo = response.message[0];
                        window.location = "stdapp";
                    }
                    else{
                        alert("No student exist contact to school administration");
                    }
                });
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

            removesession();
            function removesession()
            {
                delete $localStorage.selectedstudentds;
                delete $localStorage.lessonlist;
                delete $localStorage.classinfo;
                delete $localStorage.userrole;
                delete $localStorage.alreadyreadlesson;
                delete $localStorage.subject;
                delete $localStorage.subjectinfo;
                delete $localStorage.periodlist;
                delete $localStorage.lastactivity;
            }
        });
    </script>
</body>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>

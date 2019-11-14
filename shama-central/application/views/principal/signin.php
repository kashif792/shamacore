<?php

if ($this->uri->segment(3)) {

    $path_url =  '../../';

    $uri = '../../';
} else if ($this->uri->segment(2)) {

    $path_url =  '../';

    $uri = '../';
} else {

    $path_url =  '';

    $uri = '';
}

?>

<!DOCTYPE html>

<html ng-app="invantage">

<head>

    <meta charset="UTF-8">

    <title>Shama</title>

    <link rel="icon" href="<?= base_url() ?>/favicon.png">

    <link rel="stylesheet" href="<?php echo base_url(); ?>css/login.css">


    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap_4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fontello.css">

    <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>js/angular-1.6.4.min.js"></script>
    <script src="<?php echo base_url(); ?>js/ngStorage.min.js"></script>
    <script src="<?php echo base_url(); ?>js/angular-md5.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/insight.js"></script>

</head>



<body ng-controller="Ctrl">

    <div class="log_cont">

        <hgroup>



        </hgroup>

        <div id="login-form">

            <div id="error-messages"></div>

            <div id="logo-container">

                <img src="<?php echo base_url(); ?>images/nrschoollogo.png">

            </div>



            <form name='loginform' id='loginform' ng-submit="submitLogin()">

                <div class="group">

                    <input type="text" tabindex="1" id="inputEmail" name="email" value="">

                    <span class="highlight"></span>

                    <span class="bar"></span>

                    <label>Email</label>

                </div>

                <div class="group">

                    <input type="password" id="inputPassword" tabindex="2" name="password">

                    <span class="highlight"></span>

                    <span class="bar"></span>

                    <label>Password</label>

                </div>

                <button id="login" type="submit" tabindex="3" class="button buttonBlue">Login

                    <div class="ripples buttonRipples">

                        <span class="ripplesCircle"></span>

                    </div>

                </button>

            </form>

            <div>

                Forgot password ? <a href="#" onClick="$('#login-form').hide(); $('#forgot-password').show()">Click here</a>

            </div>

        </div>



        <div id="forgot-password" class="login-form" style="display:none;">

            <div id="forgot-error-messages"></div>

            <div id="logo-container">

                <img src="<?php echo base_url(); ?>images/nrschoollogo.png">

            </div>

            <form name='forgotReset' id='forgotReset' ng-submit="submitForgotPassword()">

                <div class="group">

                    <input type="email" tabindex="1" id="forgotEmail" name="forgotEmail">

                    <span class="highlight"></span>

                    <span class="bar"></span>

                    <label>Email</label>

                </div>

                <button type="submit" id="btn-forgot-password" tabindex="2" class="button buttonBlue">Send

                    <div class="ripples buttonRipples">

                        <span class="ripplesCircle"></span>

                    </div>

                </button>

            </form>

            <div>

                Sign in ? <a href="#" onClick="$('#forgot-password').hide(); $('#login-form').show()">Click here</a>

            </div>

        </div>

        <hgroup class="bottom">

            <img src="<?php echo base_url(); ?>images/logo.png">

            <h1>Powered by Zilon - All Rights Reserved <?php echo date('Y'); ?></h1>



        </hgroup>

    </div>


    <script type="text/javascript">
        function getUrlVars() {

            var vars = [],
                hash;

            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

            for (var i = 0; i < hashes.length; i++)

            {

                hash = hashes[i].split('=');

                vars.push(hash[0]);

                vars[hash[0]] = hash[1];

            }

            return vars;

        }
    </script>


    <script type="text/javascript">
        var app = angular.module('invantage', ["ngStorage", "angular-md5"]);

        app.controller('Ctrl', ['$scope', '$localStorage', 'md5', '$http', Ctrl]);

        function Ctrl($scope, $localStorage, md5, $http) {

            $scope.storage = $localStorage.$default({});


            angular.element(function() {

                console.log('angular is working');

            });




            function hidePlaceholder() {

                var inputEmail = $("#inputEmail").val();

                var inputPassword = $("#inputPassword").val();

                var forgotEmail = $("#forgotEmail").val();

                if (inputEmail != '' || inputPassword != '' || forgotEmail != '') {

                    jQuery("#inputEmail").attr("placeholder", "");

                    jQuery("#inputPassword").attr("placeholder", "");

                    jQuery("#forgotEmail").attr("placeholder", "");

                }
            }
            hidePlaceholder();


            $scope.submitLogin = function() {

                $scope.loading_data = 1;

                var inputEmail = $("#inputEmail").val();

                var inputPassword = md5.createHash($("#inputPassword").val());

                var loginremember = false;

                urlpath = "<?php echo SHAMA_CORE_API_PATH; ?>teacher_login";

                var data = {
                    'email': inputEmail,
                    'password': inputPassword
                }

                httppostrequest(urlpath, data).then(function(response) {


                    if (response != null && response.loggedin == true) {
                        $scope.storage.userData = response;

                        var rurl = '';

                        if (response.roles[0].role_id == 4) {

                            rurl = "teacherdashboard";

                        } else if (response.roles[0].role_id == 1) {

                            rurl = "admindashboard";

                        } else {

                            if (response.show_school_wizard == true) {
                                window.location = "principal_installation_wizard";
                            } else {
                                $scope.getSessionList(response.locations[0].school_id);
                            }
                        }

                        if (response.type != 'p') {
                            window.location = rurl;
                        }

                    } else {

                        $("#error-messages").text("Email or Password incorrect Or Your account may be suspended");
                        $("#error-messages").show();
                    }



                })

                return false;
            }



            $scope.submitForgotPassword = function() {

                var forgotEmail = $("#forgotEmail").val();

                hidePlaceholder();

                if (forgotEmail == '') {

                    jQuery("#forgotEmail").css("border", "1px solid red");

                    jQuery("#forgotEmail").focus();

                    return false;

                } else {

                    jQuery("#forgotEmail").css("border", "1px solid #C9C9C9");

                }



                if (forgotEmail) {

                    var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

                    if (reg.test(forgotEmail) == false) {

                        jQuery("#forgotEmail").focus();

                        jQuery("#forgotEmail").css("border", "1px solid red");

                        return false;

                    } else {

                        jQuery("#forgotEmail").css("border", "1px solid #C9C9C9");

                    }

                }

                var data = {
                    'email': forgotEmail
                }

                httppostrequest('<?php echo SHAMA_CORE_API_PATH; ?>password_forgot', data).then(function(response) {
                    if (response.message === true) {
                        $("#forgot-error-messages").text("Email has been sent to provided email.");
                        $("#forgot-error-messages").show();
                    } else {
                        $("#forgot-error-messages").text("Email not matched");
                        $("#forgot-error-messages").show();
                    }
                });

                return false;

            }

            /**
             * Get session list for principal and store it local storage
             */
            $scope.getSessionList = function(schoolId = null) {
                httprequest('<?php echo SHAMA_CORE_API_PATH; ?>sessions', {
                    school_id: schoolId
                }).then(function(response) {
                    if (response != null && response.length > 0) {
                        $scope.storage.sessionList = response;
                        $scope.getGradeList(schoolId);
                        $scope.getActiveSemesterInSchool(schoolId);
                        $scope.getActiveSessionInSchool(schoolId);
                    } else {
                        $scope.storage.sessionList = [];
                    }
                });
            }

            /**
             * Get grade list for principal and store it local storage
             */
            $scope.getGradeList = function(schoolId = null) {
                httprequest('<?php echo SHAMA_CORE_API_PATH; ?>classes', {
                    school_id: schoolId
                }).then(function(response) {
                    if (response != null && response.length > 0) {
                        $scope.storage.gradeList = response;
                        $scope.getSemesterList(schoolId);

                    } else {
                        $scope.storage.gradeList = [];
                    }
                });
            }

            /**
             * Get semester list for principal and store it local storage
             */
            $scope.getSemesterList = function(schoolId = null) {
                httprequest('<?php echo SHAMA_CORE_API_PATH; ?>semesters', {
                    school_id: schoolId
                }).then(function(response) {
                    if (response != null && response.length > 0) {
                        $scope.storage.semesterList = response;
                        window.location = "dashboard";
                    } else {
                        $scope.storage.semesterList = [];
                    }
                });
            }

            /**
             * Get active semester
             */
            $scope.getActiveSemesterInSchool = function(schoolId = null) {
                httprequest('<?php echo SHAMA_CORE_API_PATH; ?>active_semester_in_school', {
                    school_id: schoolId
                }).then(function(response) {
                    if (response != null && response.status) {
                        $scope.storage.active_semester = response.semester.name;
                    }
                    else{
                        $scope.storage.active_semester = "Fall";
                    }
                });
            }

            /**
             * Get active session
             */
            $scope.getActiveSessionInSchool = function(schoolId = null) {
                httprequest('<?php echo SHAMA_CORE_API_PATH; ?>active_session_in_school', {
                    school_id: schoolId
                }).then(function(response) {
                    if (response != null && response.status) {
                        $scope.storage.active_session = response.session;
                    }
                });
            }

            function httprequest(url, data) {
                var request = $http({
                    method: 'GET',
                    url: url,
                    params: data,
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                return (request.then(responseSuccess, responseFail))
            }


            function httppostrequest(url, data) {
                var request = $http({
                    method: 'POST',
                    url: url,
                    data: data,
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                return (request.then(responseSuccess, responseFail))
            }

            function responseSuccess(response) {
                return (response.data);
            }

            function responseFail(response) {
                return (response.data);
            }

        }
    </script>

</body>

</html> 
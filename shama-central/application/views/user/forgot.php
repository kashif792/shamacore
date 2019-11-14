<?php

    if($this->uri->segment(3)){

        $path_url =  '../../';

        $uri = '../../';

    }

    else if($this->uri->segment(2)){

        $path_url =  '../';

        $uri = '../';

    }

    else{

        $path_url =  '';

        $uri = '';

    }   

?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("submit","#addRetypePassword",function(){ 
                    
            var newPasswordKeyInput = $("#newPasswordKeyInput").val();
            var newPasswordInput = $("#newPasswordInput").val(); 
            var retypePasswordInput = $("#retypePasswordInput").val(); 
            if(newPasswordKeyInput ==''){
                jQuery("#newPasswordKeyInput").css("border", "1px solid red");
                jQuery("#keyError").removeClass('hide');
                jQuery("#keyError").addClass('show');
                return false;
            }
            else{
                jQuery("#newPasswordKeyInput").css("border", "1px solid #C9C9C9");                                 
                jQuery("#keyError").addClass('hide');
            }
            if(newPasswordInput ==''){
                jQuery("#newPasswordInput").css("border", "1px solid red");
                 jQuery("#passwordError").removeClass('hide');
                jQuery("#passwordError").addClass('show');

                return false;
            }
            if (newPasswordInput){
                var reg = new RegExp(/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{6,14})$/);
                if(reg.test(newPasswordInput) == false){
                    jQuery("#newPasswordInput").css("border", "1px solid red");
                    jQuery("#passwordError").removeClass('hide');
                    jQuery("#passwordError").addClass('show');
                    return false;
                }
                else{
                    jQuery("#newPasswordInput").css("border", "1px solid #C9C9C9");                                 
                    jQuery("#passwordError").addClass('hide');
                    jQuery("#passwordError").removeClass('show');
                }
            } 
            if(retypePasswordInput ==''){
                jQuery("#retypePasswordInput").css("border", "1px solid red");
                jQuery("#RetypeError").removeClass('hide');
                jQuery("#RetypeError").addClass('show');
                return false;
            }
            if (retypePasswordInput){
                var reg = new RegExp(/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{6,14})$/);
                if(reg.test(retypePasswordInput) == false){
                    jQuery("#retypePasswordInput").css("border", "1px solid red");
                    jQuery("#RetypeError").removeClass('hide');
                    jQuery("#RetypeError").addClass('show');
                    return false;
                }
                else{
                    jQuery("#retypePasswordInput").css("border", "1px solid #C9C9C9");                                 
                     jQuery("#RetypeError").addClass('hide');
                    jQuery("#RetypeError").removeClass('show');
                }
            } 
            if(retypePasswordInput != newPasswordInput ){
                jQuery("#newPasswordInput").css("border", "1px solid red");
                jQuery("#retypePasswordInput").css("border", "1px solid red");
                jQuery("#RetypeError").removeClass('hide');
                jQuery("#RetypeError").addClass('show');
                return false;
            }
            else{
                jQuery("#newPasswordInput").css("border", "1px solid #C9C9C9");                           
                jQuery("#retypePasswordInput").css("border", "1px solid #C9C9C9"); 
                jQuery("#RetypeError").addClass('hide');
                jQuery("#RetypeError").removeClass('show');
            }

        
            var dataString =  $( "#addRetypePassword" ).serialize();  //"default_response="+default_response+"&field_one_title="+field_one_title+"&field_two_title="+field_two_title+"&field_three_title="+field_three_title+"&field_four_title="+field_four_title+"&field_five_title="+field_five_title+"&inputComment="+inputComment;
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "resetPassword",
                data: dataString,
                beforeSend: function(x) {
                    if(x && x.overrideMimeType) {
                        x.overrideMimeType("application/json;charset=UTF-8");   
                    }
                },
                success: function(data) {
                // 'data' is a JSON object which we can access directly.
                ///* Evaluate the data.success member and do something appropriate...
                    
                    if (data.message === true){
                       
                        $("#addRetypePassword").addClass('hide');
                        alert('Your password has been successfully changed.Use new password for login.We are redirecting you to login page.');
                        window.location = 'http://zinwebs.com/ips/ips/login#';                                      
                    }
                           
                    else{
                        alert("Please provide correct key.Try again");
                    }
                }
            });
            return false;
        });        
    });
   
</script>
<style type="text/css">
    body{
        margin: 0;
    }
    div#loginbox {
        margin-top: 3em;
    }
    img{
        margin-left: auto;
        margin-right: auto;
        margin-top: 2em;
    }
   
</style>
<div id="email_error_div" class="alert alert-dismissable alert-danger hide">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Error found.</strong>Try again.
</div>
<div id="email_success_div" class="alert alert-dismissable alert-danger hide">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Your password has been changed.Use new password for login.</strong>
</div>
<div class="container">
    <div class="logo">
    <img src="<?php echo $path_url; ?>images/nrschoollogo.png" class="img-responsive" alt="Nr Schools" title="betsyhealth., Inc" /></div>  
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title">Forgot Password</div>
            </div>     
            <div  class="panel-body" >
                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
               <?php $attributes = array('name' => 'addRetypePassword', 'id' => 'addRetypePassword','class'=>'form-horizontal'); echo form_open('', $attributes);?>
                   <fieldset>
                        <div class="form-group" style="text-align:centre;">
                            <div class="col-lg-10" style="text-align:centre; width:100%">
                                <label for="name-input" class="">Key<span style="color:red">*</span></label>
                                <input class="form-control" id="newPasswordKeyInput" name="newPasswordKeyInput" placeholder="Reset Password Key" autocomplete="off" type="password">
                                <span style='color:red;' class="hide" id="keyError">Please enter valid reset password key provided in email.</span>
                            </div>
                        </div>
                        <div class="form-group" style="text-align:centre;">
                            <div class="col-lg-10" style="text-align:centre; width:100%">
                                <label for="name-input" class="">New Password<span style="color:red">*</span></label>
                                <input class="form-control" id="newPasswordInput" name="newPasswordInput" placeholder="New Password" autocomplete="off" type="password">
                                <span style='color:red;' class="hide" id="passwordError">Enter 8-20 character. Must contain(digit,uppercase & lowercase character and special character)</span>
                            </div>
                        </div>
                        <div class="form-group" style="text-align:centre;">
                            <div class="col-lg-10" style="text-align:centre; width:100%">
                                <label for="name-input" class="">Retype Password<span style="color:red">*</span></label>
                                <input class="form-control" id="retypePasswordInput" name="retypePasswordInput" placeholder="New Retype Password" autocomplete="off" type="password">
                                <span style='color:red;' class="hide" id="RetypeError">Password not matched.</span>
                            </div>
                        </div>
                        <div style="text-align:right;margin:5px;">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </fieldset>
                <?php echo form_close();?>
            </div>                     
        </div>  
    </div>
</div>
</body>
</html>

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
<html >
    <head>
        <meta charset="UTF-8">
        <title>Zilon Invantage</title>
        <link rel="stylesheet" href="<?php echo $path_url; ?>css/login.css">
    </head>
<body>
<div class="log_cont">
    <hgroup>
       
    </hgroup>
    <div id="login-form">
        <div id="error-messages"></div>
        <div id="logo-container">
            <img src="<?php echo $path_url; ?>images/nrschoollogo.jpg">            
        </div>
        
       <?php $attributes = array('name' => 'changePasswrodForm', 'id' => 'changePasswrodForm','class'=>'form-horizontal'); echo form_open('', $attributes);?>
            <div class="group" style="margin-bottom:10px;">
                <input id="inputChangePassword" type="password" name="password" placeholder="Password">           
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Password</label>
            </div>
            <div style="margin-bottom:10px;">
                <span style='color:#444;' class="hide" id="passwordError">Must contain(digit,uppercase & lowercase character and special character) 6-14 character length</span>
            </div>
            <button type="submit" tabindex="3" class="button buttonBlue">Submit
                <div class="ripples buttonRipples">
                    <span class="ripplesCircle"></span>
                </div>
            </button>
        <?php echo form_close();?>
    </div>
     <hgroup class="bottom">
         <img src="<?php echo $path_url; ?>images/invantage.png">
        <h1>Powered by Zilon - All Rights Reserved <?php echo date('Y'); ?></h1>
    </hgroup>
    </div>
    <script src="<?php echo $path_url; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $path_url; ?>js/insight.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // Login module
            $(document).on("submit","#changePasswrodForm",function(){             
                var inputChangePassword = $("#inputChangePassword").val();
            
                var reg = new RegExp(/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{6,14})$/);
                if(reg.test(inputChangePassword) == false){
                    jQuery("#inputChangePassword").css("border", "1px solid red");
                    $("#passwordError").addClass('hide');
                    $("#passwordError").removeClass('show');
                    return false;
                }
                else{
                    jQuery("#inputChangePassword").css("border", "1px solid #C9C9C9");                                 
                    $("#passwordError").addClass('hide');
                    $("#passwordError").removeClass('show');
                }
                var dataString = $( "#changePasswrodForm" ).serialize();
                $.ajax({
                      type: "POST",
                      dataType: "json",
                      url: "<?php echo $path_url; ?>users/passwrodChange",
                      data: dataString,
                      beforeSend: function(x) {
                        if(x && x.overrideMimeType) {
                          x.overrideMimeType("application/json;charset=UTF-8"); 
                        }
                    },
                    success: function(data) {
                      // 'data' is a JSON object which we can access directly.
                      // Evaluate the data.success member and do something appropriate...
                        if(data.message === true){
                            window.location = "dashboard";  
                        }
                        else{
                            $("#error_div").removeClass('hide');
                        }
                    }
                });
                return false;       
            }); 
            // Password checking
            $(document).on('blur','#inputChangePassword',function(){
                var inputChangePassword = $("#inputChangePassword").val();
                if(inputChangePassword.length >=8){
                    var reg = new RegExp(/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,20})$/);
                    if(reg.test(inputChangePassword) == false){
                        jQuery("#inputChangePassword").css("border", "1px solid red");
                        jQuery("#inputChangePassword").focus();
                        $("#passwordError").removeClass('hide');
                        return false;
                    }
                    else{
                        jQuery("#inputChangePassword").css("border", "1px solid #C9C9C9");                                 
                        $("#passwordError").addClass('hide');
                    }
                    var dataString =  'inputPassword='+inputChangePassword;  //"default_response="+default_response+"&field_one_title="+field_one_title+"&field_two_title="+field_two_title+"&field_three_title="+field_three_title+"&field_four_title="+field_four_title+"&field_five_title="+field_five_title+"&inputComment="+inputComment;
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: "<?php echo $path_url; ?>users/passwordChecking",
                         data: ({'inputPassword':inputChangePassword,'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'}),
                        beforeSend: function(x) {
                            if(x && x.overrideMimeType) {
                                x.overrideMimeType("application/json;charset=UTF-8");   
                            }
                        },
                        success: function(data) {    
                            if(data.message == true){
                                alert("Password already taken please change it");
                            }
                            else{
                                $('.btn').prop( "disabled", false );
                            }
                        }
                    });
                }
            });           
        });
    </script>
</body>
</html>
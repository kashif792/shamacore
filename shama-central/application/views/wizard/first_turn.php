<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>

<div class="col-sm-10">
    <?php
        // require_footer 
        require APPPATH.'views/__layout/filterlayout.php';
    ?>
       <div class="text-center">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
            Wizard
        </button>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Easy Wizard</h4>
                </div>
                <div class="modal-body wizard-content">
                    <div class="wizard-step ">
                        Step 1 <br>
                        Adipisicing aut repellat maiores hic ipsum. Adipisci quod minus non architecto maxime maxime autem inventore sunt autem. Sint sit vero soluta recusandae fuga est quae. In aliquid rerum aliquam sint!
                    </div>
                    <div class="wizard-step">
                        Step 2 <br>
                        Adipisicing aut repellat maiores hic ipsum. Adipisci quod minus non architecto maxime maxime autem inventore sunt autem. Sint sit vero soluta recusandae fuga est quae. In aliquid rerum aliquam sint!
                    </div>
                                 <div class="wizard-step">
                        Step 2 <br>
                        Adipisicing aut repellat maiores hic ipsum. Adipisci quod minus non architecto maxime maxime autem inventore sunt autem. Sint sit vero soluta recusandae fuga est quae. In aliquid rerum aliquam sint!
                    </div>
                </div>
                <div class="modal-footer wizard-buttons">
                    <!-- The wizard button will be inserted here. -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/easyWizard.js"></script>
    <script>
        $(document).on("ready", function(){
            $("#myModal").wizard({
                onfinish:function(){
                    console.log("Hola mundo");
                }
            });
        });
    </script>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
   

    /*
     * ---------------------------------------------------------
     *   Save new user
     * ---------------------------------------------------------
     */


        /*
         * ---------------------------------------------------------
         *   Save parent
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

    });
</script>
<script type="text/javascript">
    var app = angular.module('invantage', []);
</script>
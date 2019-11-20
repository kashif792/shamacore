<style type="text/css">
    body {
        margin: 0;
        padding: 0;
    }

    .img {
        background: #ffffff;
        padding: 12px;
        border: 1px solid #999999;
    }

    .shiva {
        -moz-user-select: none;
        background: #2A49A5;
        border: 1px solid #082783;
        box-shadow: 0 1px #4C6BC7 inset;
        color: white;
        padding: 3px 5px;
        text-decoration: none;
        text-shadow: 0 -1px 0 #082783;
        font: 12px Verdana, sans-serif;
    }
    .btn-pic{
        font-size: 18px;
        padding: 5px 5px;
        color: #fff;
        background-color: #337ab7;
        border-color: #2e6da4;
        border: 1px solid transparent;
        text-transform: uppercase;
        cursor: pointer;
    }
     
   
    form {
    text-align: center;
}
</style>
<!-- <html>

<body style="background-color:#dfe3ee;">
    
    <div id="main">
        <div id="content">
            <h1>sam</h1>

            <script type="text/javascript" src="<?php echo base_url();?>js/scripts/webcam.js"></script>
            <script language="JavaScript">
                document.write(webcam.get_html(600, 420));
            </script>
            <form>
                <br />
                     <input type=button value="snap" onClick="take_snapshot()" class="btn-pic">
                     <input  type="button" class="btn-pic"
                       style="font-weight: black;display: inline;"
                       value="Close"
                       onclick="closeMe()">
            </form>
        </div>

        <script type="text/javascript">
            
            webcam.set_api_url('<?php echo base_url();?>Principal_controller/saveImage');
            webcam.set_swf_url('<?php echo base_url();?>js/scripts/webcam.swf');
            webcam.set_quality(90);
            webcam.set_shutter_sound(true);
            webcam.set_hook('onComplete', 'my_completion_handler');

            function take_snapshot() {
               webcam.snap();




            }

            function my_completion_handler(msg) {
                webcam.reset();
                // if (msg.match(/(http\:\/\/\S+)/)) {
                //     document.getElementById('img').innerHTML = '<h3>Upload Successfuly done</h3>' + msg;

                //     document.getElementById('img').innerHTML = "<img src=" + msg + " class=\"img\">";
                //     webcam.reset();
                // } else {
                //     alert("Error occured we are trying to fix now: " + msg);
                // }
            }



        </script>
        <script>
function closeMe()
{
    window.opener = self;
    window.close();
}
</script>

        <div id="img">
        </div>
    </div>
</body>

</html>
 -->
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
    <div class="col-lg-12 widget" ng-controller="student">
        <div class="row">
            <div class="widget-header" id="widget-header">
                <!-- widget title -->
                <div class="widget-title">
                    <h4>Student</h4>
                </div>
            </div>
            <div class="widget-body">
                <div class="col-lg-12">
                    <?php $attributes = array('role'=>'form','name' => 'studentForm', 'id' => 'studentForm','class'=>'form-container-input'); echo form_open_multipart('', $attributes);?>
                        <div class="row setup-content" id="step-1">
                            <div class="col-xs-12">
                                
                                <div class="col-md-12">
                                    <input type="hidden" value="<?php if($this->uri->segment(2)){ echo $this->uri->segment(2);} ?>" name="serial" id="serial"> 
        

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="upper-row">
                                                <label><span class="icon-home-1"></span> Question: <span class="required"></span></label>
                                            </div>
                                            <input type="text" placeholder="Work Address" id="inputQuestion" name="inputQuestion" value="<?php if(isset($result)){echo $result['father_work_address'];} ?>">
                                        </div>
                                    </div>  
                                  <div class="row">
                                        <div class="col-lg-6">
                                            <div class="upper-row">
                                                <label><span class="icon-address"></span>Option1 <span class="required">*</span></label>
                                            </div>
                                       <input type="text" id="inputoption1" class="opt" name="inputoption1" placeholder="Quiz name"  tabindex="1" value="<?php if(isset($result)){echo $result['sfullname'];} ?>" required="required"><input type="radio" class="optradio" name="vehicle" value="Bike"> 
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="upper-row">
                                                <label><span class="icon-address"></span> Option 2 <span class="required">*</span></label>
                                            </div>
                                       <input type="text" id="inputoption2" class="opt" name="inputoption2" placeholder="Quiz name"  tabindex="1" value="<?php if(isset($result)){echo $result['sfullname'];} ?>" required="required"><input type="radio" class="optradio" name="vehicle" value="Bike"> 
                                        </div>
                                    </div>
                                 <div class="row">
                                        <div class="col-lg-6">
                                            <div class="upper-row">
                                                <label><span class="icon-address"></span>Option3 <span class="required">*</span></label>
                                            </div>
                                       <input type="text" id="inputoption3" class="opt" name="inputoption3" placeholder="Quiz name"  tabindex="1" value="<?php if(isset($result)){echo $result['sfullname'];} ?>" required="required"><input type="radio" class="optradio" name="vehicle" value="Bike"> 
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="upper-row">
                                                <label><span class="icon-address"></span> Option 4 <span class="required">*</span></label>
                                            </div>
                                       <input type="text" id="inputoption4" class="opt" name="inputoption4" placeholder="Quiz name"  tabindex="1" value="<?php if(isset($result)){echo $result['sfullname'];} ?>" required="required"><input type="radio" class="optradio" name="vehicle" value="Bike"> 
                                        </div>
                                    </div>

                                 <div class="field-container">
                                    <div class="field-row">
                                        <button type="submit" tabindex="8" class="btn btn-default save-button">Save</button>
                                        <a tabindex="9" href="<?php echo $path_url; ?>settings" tabindex="6" title="cancel">Cancel</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#example').DataTable();
        $('input[name="attendanceinput"]').daterangepicker({
             singleDatePicker: true,
            showDropdowns: true,
            startDate: "<?php if(isset($annoucement_single)){echo date('m/d/Y',strtotime($annoucement_single[0]->sdate)).$annoucement_single[0]->stime;}else{ echo date('m/d/Y');} ?>",
            locale: {
                format: 'MM/DD/YYYY'
            }
        });
        $('input[name="stimepicker"]').daterangepicker({
            timePicker: true,
            showDropdowns: true,
            timePicker24Hour: true,
            startDate: "<?php if(isset($annoucement_single)){echo date('m/d/Y',strtotime($annoucement_single[0]->sdate)).$annoucement_single[0]->stime;}else{ echo date('m/d/Y');} ?>",
            endDate: "<?php if(isset($annoucement_single)){echo date('m/d/Y',strtotime($annoucement_single[0]->edate)).$annoucement_single[0]->etime;}else{ echo date('m/d/Y');} ?>",
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        /*
         * ---------------------------------------------------------
         *   Save Exam timetable
         * ---------------------------------------------------------
         */ 
        $("#schedule_timetable").submit(function(e){
            e.preventDefault();
            var subj_name = $("#select_subject").val();
            var dataString = jQuery('#schedule_timetable').serializeArray();
            ajaxType = "POST";
            urlpath = "<?php echo $path_url; ?>Principal_controller/saveTimtable";
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
                window.location.href = "<?php echo $path_url;?>show_timtbl_list";
            }
        }     
    });
</script>
<script type="text/javascript">


function popup(){
    window.open("<?php echo $path_url; ?>add_question", "_blank", "toolbar=no, scrollbars=no, resizable=no, top=80, left=400, width=600, height=500px");
}


    var app = angular.module('invantage', []);

    app.controller('timetable_controller', function($scope, $http, $interval) {
    
    setTimerForWidget('section',1)
    $scope.inputclass = $scope.ini;
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
            loadSections()  
          }
          
        

          $interval.cancel(reporttimer)

      }
    },300)
      }

        
        function loadSections()
        {
    
            try{
                var data = ({inputclassid:parseInt($scope.ini)})
            
                httprequest('getsectionbyclass',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.sectionslist = response;
                    }
                    else{
                        $scope.sectionslist = response;
                    }
                })
            }
            catch(ex){}
        }

        $scope.changesection = function()
        {
            try{
                $scope.ini = $scope.inputclass;
                var data = ({inputclassid:parseInt($scope.ini)})
                httprequest('getsectionbyclass',data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.sectionslist = response;
                    }
                    else{
                        $scope.sectionslist = response;
                    }
                })
            }
            catch(ex){}
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
    });
</script>


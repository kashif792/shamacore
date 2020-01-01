<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>
<div id="detail_modal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p>You won't be able to modify target after this action. Are you sure to start sending now?</p>

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                <button type="button" id="SendAnn" class="btn btn-default " value="save">Yes</button>

            </div>

        </div>

    </div>

</div>
<div id="stop_modal" class="modal fade">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">Confirmation</h4>

            </div>

            <div class="modal-body">

                <p>Are you sure you want to stop this Message?</p>

             </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>

                <button type="button" id="StopAnn" class="btn btn-default " value="save">Yes</button>

            </div>

        </div>

    </div>

</div>
<div class="col-sm-10"  ng-controller="announcementCtrl">
    <?php
        // require_footer
        require APPPATH.'views/__layout/filterlayout.php';
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <label>View Announcement </label>
            
        </div>
        <div class="panel-body">
                <?php $attributes = array('name' => 'schedule_timetable', 'id' => 'schedule_timetable','class'=>'form-horizontal'); echo form_open('', $attributes);?>
                     <input type="hidden" name="serial" id="serial" ng-model="serial">
                     <fieldset>
                        
                        <div class="form-group">
                            <div class="col-md-6">
                                
                                <label><span class="icon-user"></span> Title <span class="required">*</span></label>
                                
                                    <input type="text" class="form-control" name="title" id="title"  ng-model="title" >
                                
                            </div>
                            
                            <div class="clearfix"></div>
                        </div>

                        
                         <div class="form-group">
                            <div class="col-sm-12">
                                <label><span class="icon-mail-alt"></span>Message <span class="required">*</span></label>
                            </div>
                            <div class="col-sm-6">
                                <textarea class="form-control long_desc"  placeholder="Message..." ng-model="message" id="paigam" name="paigam"  ></textarea>
                                                        
                            </div>
                         </div>
                         <div class="form-group">
                           
                            <div class="col-md-6">
                               <label><span class="icon-user"></span> Target <span class="required">*</span></label>
                                <select class="form-control"  id="target" name="target" ng-model="select_target" ng-change="changetarget()">
                                <option value="">--Select Target--</option>
                                <option>Individual</option>
                                <option>School</option>
                                <option>Staff</option>
                                <option>Student</option>
                                </select>
                            
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="recipient_no" style="display: none;">
                           <div class="form-group">
                            <div class="col-md-6">
                               <label><span class="icon-mobile"></span> Recipient Number <span class="required">*</span></label>
                                <input type="text" name="individual_no" id="individual_no" ng-model="individual_no" class="form-control">
                            
                            </div>
                        </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                            <div class="col-md-6">
                               <label><span class="icon-home"></span> Reference <span class="required">*</span></label>
                                <input type="text" name="reference" id="reference" ng-model="reference" class="form-control">
                            
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        </div>
                        <div class="form-group staff_student" style="display: none;">
                           
                            <div class="col-md-6">
                               <label><input type="checkbox" class="all_grade" value="all_grade" name="checkall" ng-model="checkall" ng-click="checkUncheckAll()" ng-change="allChecked()" /> All Grade</label>
                            </div>
                            <div class="clearfix"></div>
                            <div ng-repeat="c in classlist" class="grade_label">
                                 <label><input type="checkbox" value="{{ c.id }}" name="grade_name" ng-model="c.checked" ng-change='updateCheckall()' class="class_list" /> {{c.grade}} </label>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="button" tabindex="8" class="btn btn-primary save"  id="save" ng-click="addAnnouncement()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving...">Save</button>
                                <a tabindex="9" href="<?php echo $path_url; ?>announcementlist" tabindex="6" title="cancel">Back</a>
                            </div>
                        </div>
                        <div class="form-group sendbtn" style="display: none">
                            <div class="col-sm-12">
                                <button type="button" tabindex="8" class="btn btn-primary send"  id="send" ng-click="sendAnnouncement()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Sending...">Send</button>
                                <button type="button" tabindex="8" class="btn btn-primary stop"  id="stop" ng-click="stopAnnouncement()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Stoping..." style="display: none">Stop</button>
                                
                            </div>
                        </div>
                        
                    </fieldset>

                <?php echo form_close();?>
        
            </div>

    <div class="panel panel-default">
        
    <input type="hidden" name="serial" id="serial" ng-model="serial" >  

    <div class="col-md-12 table_record">
        <table class="table table-striped table-hover" id="table-body-phase-tow">
            <thead>
                <tr>
                    <th>Sr.</th>
                    <th>Phone Number</th>
                    <th>Date Time</th>
                    <th>User</th>
                    <th>Target Type</th>
                    <th>Status</th>
                 </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    </div>
</div>
<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>
<script src="<?php echo base_url(); ?>js/angular-datatables.min.js"></script>

<script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    function validate_int(myEvento) {
        if ((myEvento.charCode >= 48 && myEvento.charCode <= 57) || myEvento.keyCode == 9 || myEvento.keyCode == 10 || myEvento.keyCode == 13 || myEvento.keyCode == 8 || myEvento.keyCode == 116 || myEvento.keyCode == 46 || (myEvento.keyCode <= 40 && myEvento.keyCode >= 37)) {
            dato = true;
        } else {
            dato = false;
        }
        return dato;
    }

    document.getElementById("individual_no").onkeypress = validate_int;
    document.getElementById("individual_no").onkeyup = phone_number_mask;

    function phone_number_mask() {

        var myMask = "____-_______";
        var myCaja = document.getElementById("individual_no");
        var myText = "";
        var myNumbers = [];
        var myOutPut = ""
        var theLastPos = 1;
        myText = myCaja.value;
        //get numbers
        for (var i = 0; i < myText.length; i++) {
            if (!isNaN(myText.charAt(i)) && myText.charAt(i) != " ") {
                myNumbers.push(myText.charAt(i));
            }
        }

        //write over mask
        for (var j = 0; j < myMask.length; j++) {
            if (myMask.charAt(j) == "_") { //replace "_" by a number 
                if (myNumbers.length == 0)
                    myOutPut = myOutPut + myMask.charAt(j);
                else {
                    myOutPut = myOutPut + myNumbers.shift();
                    theLastPos = j + 1; //set caret position
                }
            } else {
                myOutPut = myOutPut + myMask.charAt(j);
            }
        }
        document.getElementById("individual_no").value = myOutPut;
        document.getElementById("individual_no").setSelectionRange(theLastPos, theLastPos);
    }
</script>
<script>

    app.controller('announcementCtrl',['$scope','$myUtils','$http','$interval', announcementCtrl]);

    function announcementCtrl($scope, $myUtils,$http,$interval) {

        $scope.isPrincipal = false;
        $scope.isTeacher = false;
        $scope.isAdmin = false;
        $scope.day = [];
        $scope.data = [];
        if(!$myUtils.checkUserAuthenticated()){
            console.log('User not authenticated!');
            return;
        }
        
        //console.log('User ' + $myUtils.userId + ' authenticated!');

        $scope.baseUrl = '<?php echo base_url() ?>'

        $scope.user_id = $myUtils.getUserId();
        $scope.name = $myUtils.getUserName();
        $scope.email = $myUtils.getUserEmail();
        $scope.roles = $myUtils.getUserRoles();
        $scope.school_id = $myUtils.getDefaultSchoolId();
        $scope.session_id = $myUtils.getDefaultSessionId();
        
        var urlist = {
            getAnnouncementDetailList:'<?php echo SHAMA_CORE_API_PATH; ?>Announcement_Detail_List',
            stopAnnouncementDetailList:'<?php echo SHAMA_CORE_API_PATH; ?>stop_Announcement_Detail_List',
            
        }

        $scope.serial = "<?php echo $this->uri->segment('2'); ?>";
        $scope.select_target="";
        $scope.editresponse = [];
        $scope.firsttimeload = false;
        $scope.requests = [];
        //$scope.classlist = [];
        angular.element(function(){
            if($scope.serial == '')
            {
                initmodules();
            }

            if($scope.serial != '')
            {
                $scope.firsttimeload = true;

                
            }
        });

        if($myUtils.getUserProfileImage()){
            $scope.profileImage = $myUtils.getUserProfileImage();
        }

        if($myUtils.getUserProfileThumb()){
            $scope.profileThumb = $myUtils.getUserProfileThumb();
        }
        
        $scope.roles = $myUtils.getUserRoles();
        
        $scope.schoolName = '';
        if($myUtils.getUserLocations().length){
            $scope.schoolName = $myUtils.getUserLocations()[0].schoolname;
        }

        $scope.type = $myUtils.getUserType();

        $scope.role_id = $myUtils.getUserDefaultRoleId();

        $scope.isPrincipal = $myUtils.isPrincipal();
        $scope.isTeacher = $myUtils.isTeacher();
        $scope.isAdmin = $myUtils.isAdmin();

$scope.checkUncheckAll = function () {
   if ($scope.checkall) {
    $scope.checkall = true;
   } else {
    $scope.checkall = false;
   }
   
   console.log($scope.classlist);
   angular.forEach($scope.classlist, function (c) {

    c.checked = $scope.checkall;
   });
  };

  $scope.updateCheckall = function($index,c){
           
    var userTotal = $scope.classlist.length;
    var count = 0;
    angular.forEach($scope.classlist, function (item) {
       if(item.checked){
         count++;
       }
    });

    if(userTotal == count){
       $scope.checkall = true;
    }else{
       $scope.checkall = false;
    }
  };

  $scope.updateCheckUncheckAll = function(classids){
           
    var userTotal = $scope.classlist.length;
    var count = 0;
    
    var locals = classids.split(',');
    
    angular.forEach($scope.classlist, function (item) {
        
        if (classids.indexOf(item.id) != -1) {
            
                    item.checked = true;
                }
    });

    
  };
/* ENd here */
$scope.changetarget = function()
        {
            var target_val = $("#target").val();
            if(target_val=='Individual')
            {
                $('.recipient_no').show();
                $('.staff_student').hide();
            }
            else if(target_val=='School')
            {
                $('.recipient_no').hide();
                $('.staff_student').hide();
            }
            else if(target_val=='Staff' || target_val=='Student')
            {
                $('.recipient_no').hide();
                $('.staff_student').show();
                loadclass();
                
            }
        }

        $scope.addAnnouncement = function()
        {
            
            var title = $("#title").val();
            var paigam = $("#paigam").val();
            var target = $("#target").val();

            message("",'hide')
            $("#time_error").hide()
            $("#date_error").hide()

            if(!title){
                
                message("Please Enter Title",'show')
                return false;
            }
            else{
                jQuery("#title").css("border", "1px solid #C9C9C9");
            }
            if(!paigam){
                
                message("Please Enter Message",'show')
                return false;
            }
            else{
                jQuery("#paigam").css("border", "1px solid #C9C9C9");
            }
            if(!$scope.select_target){
                jQuery("#select_target").css("border", "1px solid red");
                message("Please select target",'show')
                return false;
            }
            else{
                jQuery("#select_target").css("border", "1px solid #C9C9C9");
            }
            if(target=='Individual')
            {
                if(!$scope.individual_no)
                {
                    message("Please Enter Number",'show')
                    return false;
                }
                if(!$scope.reference)
                {
                    message("Please Enter Reference",'show')
                    return false;
                }
                
            }
            if(target=='Individual')
            {
                var individual_no = $("#individual_no").val();
                var reference = $("#reference").val();
            }
            if(target=='Staff' || target =='Student')
            {
                var checkall = $('input[name="checkall"]:checked').val();
                if(checkall!='all_grade')
                {
                    var grade = [];
                    $.each($("input[name='grade_name']:checked"), function(){
                        grade.push($(this).val());
                    });
                    if(grade.length==0)
                    {
                        message("Please Select at least one grade",'show')
                        return false;
                    }
                }
            }
            // End here
             var $this = $(".save");
             $this.button('loading');

            var formdata = new FormData();
            formdata.append('paigam',paigam);
            formdata.append('title',title);
            formdata.append('target',target);
            if(target=='Individual')
            {
                formdata.append('individual_no',individual_no);
                formdata.append('reference',reference);
            }
            if(target=='Staff' || target =='Student')
            {
                
                var checkall = $('input[name="checkall"]:checked').val();
                if(checkall!='all_grade')
                {
                    formdata.append('grade',grade);
                }
                else
                {
                    formdata.append('checkall',true);
                }
            }

            formdata.append('serial',$scope.serial);
            formdata.append('school_id',$scope.school_id);

            var request = {
                method: 'POST',
                url: "<?php echo SHAMA_CORE_API_PATH; ?>Announcement",
                data: formdata,
                headers: {'Content-Type': undefined}
            };

            $http(request)
                .success(function (response) {
                    
                    var $this = $(".save");
                    $this.button('reset');
                    if(response.message == true){
                        message('Announcement Successfully Added ','show');
                        $scope.serial =response.lastid;
                        $('.sendbtn').show();
                    }
                    
                })
                .error(function(){
                    var $this = $(".save");
                    $this.button('reset');
                    initmodules();
                    message('Something is wrong!','show')
                });
        }
        $scope.isCourseTabActive=false;
        $scope.sendAnnouncement = function()
        {
            
            // End here
            var title = $("#title").val();
            var paigam = $("#paigam").val();
            if(!title){
                
                message("Please Enter Title",'show')
                return false;
            }
            else{
                jQuery("#title").css("border", "1px solid #C9C9C9");
            }
            if(!paigam){
                
                message("Please Enter Message",'show')
                return false;
            }
            else{
                jQuery("#paigam").css("border", "1px solid #C9C9C9");
            }
            $("#detail_modal").modal('show');
            
            $(document).on('click','#SendAnn',function(){
            $("#detail_modal").modal('hide');
            $('.table_record').show();
            $scope.reloadcontent();
            $scope.isCourseTabActive=true;
            $("#save").hide();
            $(".save").addClass("disabled");
            $("#stop").show();
            
             var $this = $(".send");
             $this.button('loading');
            var title = $("#title").val();
            var paigam = $("#paigam").val();
            var target = $("#target").val();
            var formdata = new FormData();

            if(target=='Individual')
            {
                var individual_no = $("#individual_no").val();
                var reference = $("#reference").val();
            }
            if(target=='Staff' || target =='Student')
            {
                var checkall = $('input[name="checkall"]:checked').val();
                if(checkall!='all_grade')
                {
                    var grade = [];
                    $.each($("input[name='grade_name']:checked"), function(){
                        grade.push($(this).val());
                    });
                    
                }
            }
            if(target=='Individual')
            {
                formdata.append('individual_no',individual_no);
                formdata.append('reference',reference);
            }
            if(target=='Staff' || target =='Student')
            {
                
                var checkall = $('input[name="checkall"]:checked').val();
                if(checkall!='all_grade')
                {
                    formdata.append('grade',grade);
                }
                else
                {
                    formdata.append('checkall',true);
                }
            }
            formdata.append('paigam',paigam);
            formdata.append('title',title);
            formdata.append('target',target);
            formdata.append('serial',$scope.serial);
            formdata.append('school_id',$scope.school_id);
            var request = {
                method: 'POST',
                url: "<?php echo SHAMA_CORE_API_PATH; ?>send_Announcement",
                data: formdata,
                headers: {'Content-Type': undefined}
            };

            $http(request)
                .success(function (response) {
                    
                    if(response.message == true){
                        //message('Message sent Successfully ','show');
                        // $("#send").html("Sent");
                        // $("#send").attr("disabled", true);
                        // $("#stop").hide();
                        //$scope.isCourseTabActive=false;
                        $scope.isCourseTabActive=true;
                        $("#stop").show();
                        $scope.getAnnouncementData();
                    }
                    
                })
                .error(function(){
                    var $this = $(".send");
                    $this.button('reset');
                    initmodules();
                    message('Something is wrong!','show')
                });
            })
        }
        // when start time change, update minimum for end timepicker

        var clearRequest = function(request){
            $scope.requests.splice($scope.requests.indexOf(request), 1);
        };
        $scope.stopAnnouncement = function(request)
        {

            // request.cancel("User cancelled");
            // clearRequest(request);
            $("#stop_modal").modal('show');
            
            $(document).on('click','#StopAnn',function(){
                $("#stop_modal").modal('hide');
            var formdata = new FormData();
            formdata.append('serial',$scope.serial);
            
            
            var request = {
                method: 'POST',
                url: "<?php echo SHAMA_CORE_API_PATH; ?>stop_Announcement",
                data: formdata,
                headers: {'Content-Type': undefined}
            };
            $http(request)
                .success(function (response) {
                    
                    
                    if(response.message == true){
                        message('Stop Successfully ','show');
                        $("#send").html("Send");
                        $(".send").removeClass("disabled");
                        $(".send").removeAttr("disabled");
                        $("#stop").hide();
                        //$scope.stopAnnouncementData();
                        //$scope.isCourseTabActive = true;
                        $scope.reloadcontent();
                        $scope.isCourseTabActive=false;
                        
                    }
                    
                })
                .error(function(){
                    var $this = $(".save");
                    $this.button('reset');
                    initmodules();
                    message('Something is wrong!','show')
                });
            })
        }

        $scope.getAnnouncementDataView = function()
        {
            try{
                    var data ={
                        serial:$scope.serial,
                    }
                    //console.log(data);
                    $myUtils.httppostrequest('<?php echo SHAMA_CORE_API_PATH; ?>Announcement_View',({school_id:$scope.school_id,serial:$scope.serial})).then(function(response){
                    //httppostrequest('<?php echo $path_url; ?>Principal_controller/getAnnouncementView',data).then(function(response){
                        $scope.data = [];
                        //console.log(response);
                        if(response.length > 0 && response != null)
                        {
                            $scope.title = response[0]['listarray'].title;
                            $scope.message = response[0]['listarray'].message;
                            $scope.select_target = response[0]['listarray'].target_type;
                            if(response[0]['listarray'].status!='Draft')
                            {
                                $("#save").hide();
                                $('.sendbtn').show();
                                
                            }
                            if(response[0]['listarray'].status=='Draft')
                            {
                                $('.table_record').hide();
                                
                            }
                            if(response[0]['listarray'].status=='Cancelled')
                            {
                                $("#send").show();
                                $('.table_record').show();
                                $scope.getAnnouncementData();
                            }
                            if(response[0]['listarray'].status=='Sent')
                            {
                                $("#send").hide();
                                $('.table_record').show();
                                $scope.getAnnouncementData();
                            }
                            if(response[0]['listarray'].status=='Sending')
                            {
                                var $this = $(".send");
                                $this.button('loading');
                                $("#stop").show();
                                $scope.reloadcontent();
                                $scope.isCourseTabActive=true;
                                $scope.getAnnouncementData();
                            }
                            if($scope.select_target=="Individual")
                            {
                                $('.recipient_no').show();
                                $scope.individual_no = response[0]['listarray'].recepient_no;
                                $scope.reference = response[0]['listarray'].reference;
                            }
                            if($scope.select_target=="Staff" ||$scope.select_target=="Student")
                            {
                                $('.staff_student').show();
                                
                                if(response[0]['listarray'].all_class)
                                {
                                    
                                    $scope.classlist = response[0]['classlist']
                                    
                                    $scope.checkall = true;
                                    $scope.checkUncheckAll();
                                    
                                }
                                else
                                {
                                    $scope.classlist = response[0]['classlist']
                                    
                                    $scope.updateCheckUncheckAll(response[0]['listarray'].class_id);
                                    //console.log($scope.classlist);
                                    
                                }
                                
                                
                            }
                            //console.log(response[0]['listarray'].title);

                        }
                        else{
                            $scope.list = [];
                        }
                    });
                }
            catch(e){}
        }
        $scope.getAnnouncementDataView();

        $scope.getAnnouncementData = function()
        {
            try{
                    var data ={
                        serial:$scope.serial,
                    }
                    //console.log(data);
                    $myUtils.httppostrequest(urlist.getAnnouncementDetailList,data).then(function(response){
                    //httppostrequest('<?php echo SHAMA_CORE_API_PATH; ?>getAnnouncementDetailList',data).then(function(response){
                        $scope.data = [];
                        if(response.length > 0 && response != null)
                        {
                            for (var i=0; i<response[0]['listarray'].length; i++) {
                                $scope.data.push(response[0]['listarray'][i]);
                            }
                            
                            $("#table-body-phase-tow").dataTable().fnDestroy();
                            $scope.loaddatatable($scope.data);
                            console.log(response[0]['data_array']);

                            if(response[0]['data_array']=="Stop")
                            {
                                message('Message sent Successfully ','show');
                                 $("#send").html("Sent");
                                 $("#send").addClass("disabled");
                                 $("#stop").hide();
                                $scope.isCourseTabActive=false;

                            }
                            if(response[0]['data_array']=="Cancelled")
                            {
                                $("#send").html("Send");
                                $(".send").removeClass("disabled");
                                $(".send").removeAttr("disabled");
                                $("#stop").hide();
                                $scope.isCourseTabActive=false;
                            }
                            
                        }
                        else{
                            $scope.list = [];
                        }
                    });
                }
            catch(e){}
        }
        //$scope.getAnnouncementData();
        $scope.pagenumber = 0;
        $(document).ready(function(){
        $scope.loaddatatable = function(data)
        {
            var listdata= data;
            
            var table = $('#table-body-phase-tow').DataTable( {
                data: listdata,
                responsive: true,
                "order": [[ 0, "asc"  ]],
                rowId: 'id',
                columns: [
                    { data: 'id' },
                    { data: 'phone_number' },
                    { data: 'created_at' },
                    { data: 'user_id' },
                    { data: 'target_type' },
                    { data: 'status' },
                    
                ],

                "pageLength": 10,

            })
            var table = $('#table-body-phase-tow').DataTable();

            $('#table-body-phase-tow').on( 'page.dt', function () {
            var info = table.page.info();

            $scope.pagenumber = info.page;

            } );
                    var table = $('#table-body-phase-tow').DataTable();
                    table.page($scope.pagenumber).draw(false);
        }
    })
        $scope.reloadcontent = function()
        {

            rinterval = $interval(function(){
                if($scope.isCourseTabActive)
                {
                    $scope.getAnnouncementData();
                }
            },3000);
        }
}       

</script>



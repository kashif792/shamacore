  //var app = angular.module('invantage',['daterangepicker','ngMessages']);
   

    app.controller('settingsCtrl',['$scope','$myUtils','$filter', settingsCtrl]);

    function settingsCtrl($scope, $myUtils, $filter) {

        $scope.isPrincipal = false;
        $scope.isTeacher = false;
        $scope.isAdmin = false;

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

        $scope.holidaytype = {};
        $scope.removeholiday = {};
      
        $scope.semesterdetail = {};
        $scope.show_event_type_error = true;

        $scope.shama_api_path = $('#shama_api_path').val();
        
        $scope.sessionobj = {};
        
        function setsessiondate(){
             $('#sessiondate').daterangepicker({
                "autoApply": true,
                "showDropdowns": true,
                 "startDate": moment(),
                 "endDate": moment().add(1,'year'),
                // "minDate": $scope.start_date
            });
        }

        function defaultsessioninit()
        {
            try{
            	
                $scope.sessionobj = {};
                
                $scope.sessionobj.date = {
                    startDate:moment(),
                    endDate: moment().add(1, "year"),
                };

                $scope.sessionobj.options = {
                    timePicker: false,
                    showDropdowns: true,
                    locale:{format:'MM/DD/YYYY'},
                    eventHandlers:{
                        'apply.daterangepicker': function(ev, picker){}
                    }
                }
                
                //Watch for date changes
                $scope.$watch('sessionobj.date', function(newDate) {
                }, false);
               
            }
            catch(ex)
            {
                console.log(ex)
            }
        }
        defaultsessioninit();

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

        var urlist = {
            getclasslist:$scope.shama_api_path+'classes',
            getsectionbyclass:$scope.shama_api_path+'sections',
            getstudentbyclass:$scope.shama_api_path+'students',
            savepromotedstudents:$scope.shama_api_path+'promoted_students',
            
            getsessionlist:$scope.shama_api_path+'sessions',
            savesession:$scope.shama_api_path+'session',
            removesession:$scope.shama_api_path+'removesession',

            getsessiondetail:$scope.shama_api_path+'session',
            makesessionactive:$scope.shama_api_path+'active_session',
            
            getsemesterlist:$scope.shama_api_path+'semesters',
            makesemesteractive:$scope.shama_api_path+'active_semester',
            
            getsemesterdate:$scope.shama_api_path+'semester_date',
            getsemesterdatelist:$scope.shama_api_path+'semester_dates',
            savesemesterdate:$scope.shama_api_path+'semester_date',
            removesemesterdate:$scope.shama_api_path+'semester_date',
            makesemesterdatesactive:$scope.shama_api_path+'active_semester_dates',
            
            getcitylist:$scope.shama_api_path+'locations',
            getlocationdetail:$scope.shama_api_path+'location',
            savelocation:$scope.shama_api_path+'location',
            removelocation:$scope.shama_api_path+'location',
            
            getschoollist:$scope.shama_api_path+'schools',
            getschooldetail:$scope.shama_api_path+'school',
            saveschool:$scope.shama_api_path+'school',
            removeschool:$scope.shama_api_path+'school',
            
            getoptions:$scope.shama_api_path+'options',
            saveoptions:$scope.shama_api_path+'options',
            getholidaytypelist:$scope.shama_api_path+'holiday_types',
            getholidaytypedetail:$scope.shama_api_path+'holiday_type',
            saveholidaytype:$scope.shama_api_path+'holiday_type',
            removeholidaytype:$scope.shama_api_path+'holiday_type',
            getgradelist:$scope.shama_api_path+'grades',
            savegrade:$scope.shama_api_path+'grade',
            removegrade:$scope.shama_api_path+'grade',
            getgradedetail:$scope.shama_api_path+'grade',
            
            loadreleasettable:'loadreleasettable',
            // Shama v2.0
            saveassemblydata:$scope.shama_api_path+'saveassembly',
            getAssemblylist:$scope.shama_api_path+'getassemblydata',
            getassemblyedit:$scope.shama_api_path+'getassemblyupdate',

            getLoadBreaklist:$scope.shama_api_path+'getbreakdata',
            getbreakedit:$scope.shama_api_path+'getbreakupdate',

            savebreakdata:$scope.shama_api_path+'savebreak',
            
            
        }

        $scope.citylist = [];
        $scope.schoolarray = [];
        $scope.selectlistcity = []
        
        $scope.inputAdminEmail='';
        var d = new Date();
        var m = d.getMonth() + 1
        var y = d.getFullYear()

       
        $scope.sid = '';

     
        angular.element(function () {

            if($scope.isPrincipal){
                loadSession()
            }
            
            loadSemester()
            loadSettings()
            getCitiesList()
            getSchoolList()
            //loadScheduletable()
         });

        function loadSession()
        {
        	var data = ({
                school_id:$scope.school_id
            })
            $myUtils.httprequest(urlist.getsessionlist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.sessionlist = response
                    
                    for (var i = 0; i <= response.length -1; i++) {

                        if(response[i].status == 'a'){

                            $scope.inputSessionStatus = response[i].id
                        }
                    }
                }else{
                }
            });
        }
        

        function loadScheduletable()
       {
           $myUtils.httprequest(urlist.loadreleasettable,({})).then(function(response){
               if(response.s_status!= null ||response.t_status!=null)
               {
                    if(response.t_status == 1)
                   {
                       $scope.EnableSchedullar = '111'
                   }
                   else if(response.s_status == 1)
                   {
                    $scope.EnableSchedullar = '222'
                   }


               }
           });
       }


        $scope.savesessiondates = function(sessionobj)
        {

            if(sessionobj.date.endDate != '')
            {

                var sdate = $scope.sessionobj.date.startDate.format('MM/DD/YYYY');
                var edate = $scope.sessionobj.date.endDate.format('MM/DD/YYYY');
            
                $scope.sessionobj.startDate =sdate;
                $scope.sessionobj.endDate =edate;

                $scope.usersavebtntext = "Saving";
                var data = ({
                    start_date: moment($scope.sessionobj.startDate).format('l') ,
                    end_date:moment($scope.sessionobj.endDate).format('l'),
                    session_id:sessionobj.serial,
                    school_id:$scope.school_id
                })
                jQuery("#sessiondate").css("border", "1px solid #C9C9C9");
                $myUtils.httppostrequest(urlist.savesession,data).then(function(response){
                    if(response != null && response.message == true)
                    {
                        message('Session added','show')
                        loadSession()
                        $scope.sessionobj.serial = ''
                    
                    }
                    else

                    {
                    if(response.date_not_match == "DateNotMatch")
                    {
                        message('Session not create in these days','show')
                    }
                    else if(response.exists == "Exists")
                    {
                        message('Session Date already Exists','show')
                    }
                       $scope.usersavebtntext = "Save";
                        $scope.semesterdetail = {};
                        
                        defaultdate();
                    }
                    $scope.usersavebtntext = "Save";
                });
            }
            else{
                jQuery("#sessiondate").css("border", "1px solid red");
            }
        }

        $scope.editsession = function(sessionid)
        {

        	console.log("Edit session "+ sessionid);
                $scope.sid = sessionid
                var data = ({
                    session_id:$scope.sid
                })

               $myUtils.httprequest(urlist.getsessiondetail,data).then(function(response){
                    if(response != null)
                    {
                         $scope.sessionobj.date = {
                            startDate:moment(response.from),
                            endDate: moment(response.to),
                        };
                        $scope.sessionobj.serial = response.id
                      
                    }
                });
        }

        $scope.removesession = function(sessionid)
        {
            $("#delete_dialog").modal('show');
            $scope.dialogItemName = "session"
            $scope.sid = sessionid;

        }

        $(document).on('click','#remove_session',function(){
            $("#delete_dialog").modal('hide');
            var data = ({
                session_id:$scope.sid
            })
           
           $myUtils.httpdeleterequest(urlist.removesession,data).then(function(response){
                if(response != null)
                {
                   message('Session removed','show')
                   loadSession()
                   $scope.sid = ''
                }
            });
        });

        $scope.semesterid = 0;

        function loadSemester()
        {
            try{
                

                $myUtils.httprequest(urlist.getsemesterlist).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.semesterlist = response;
                        for (var i = 0; i <= response.length -1; i++) {
                            if(response[i].status == 'a'){
                                $scope.inputCurrentSemester = response[i].id
                                $scope.semesterdetail.semester = response[i].id;
                            }
                        }
                    }
                    else{
                        $scope.semesterlist = [];
                    }
                })
            }
            catch(ex){}
        }

         $scope.savesemester = function()
        {

            if($scope.inputSemester != null && $scope.inputSemester != '')
            {
                var data = ({
                    semester_name:$scope.inputSemester,
                    semester_id:parseInt($scope.semesterid)

                })
                jQuery("#inputSemester").css("border", "1px solid #C9C9C9");
                var $this = $(".save-semester");
                $this.button('loading');

                $myUtils.httppostrequest(urlist.savesemesterdate,data).then(function(response){
                    if(response != null && (response.message == true || response.greater == "Greater"))
                    {
                       if(response.greater == "Greater")
                       {
                           $this.button('reset');
                        message('You cannot add more than two semesters','show')
                       }
                       else{
                        $scope.semesterid = 0
                        $scope.inputSemester = '',
                        $scope.semesterdetail = {};
                        $this.button('reset');
                        message('Semester added','show')
                        loadSemester()
                    }
                    }
                    else{
                        message('Semester data not added','show')
                    }
                });
            }
            else{
                jQuery("#inputSemester").css("border", "1px solid red");
                message('Semester name should be three character long','show')
            }
        }

        $scope.editsemester = function(semid)
        {
            try{
                var data = ({semester_id:semid})

                $myUtils.httprequest(urlist.getsemesterdate,data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.inputSemester = response[0].name;
                        $scope.semesterid =response[0].id
                    }
                    else{
                        $scope.inputSemester = '';
                    }
                })
            }
            catch(ex){}
        }

        $scope.Release=function()
        {
            $is_Timetable=$('#EnableTimetable').is(":checked");
            $is_Schedullar=$('#EnableSchedullar').is(":checked");
            $scope.list = [];

            var data = ({
                        inputTimetable:$is_Timetable,
                        inputchedullar:$is_Schedullar
                    })

            $myUtils.httppostrequest('releasettable',data).then(function(response){
                if(response.s_status!= null ||response.t_status!=null)
                {
                    if(response.t_status == 1)
                    {
                        $scope.EnableSchedullar = '111'
                    }
                    else if(response.s_status == 1)
                    {
                        $scope.EnableSchedullar = '222'
                    }
                }
            });
        }

        $scope.setCurrentSemester = function(csem)
        {
             try{
                $scope.inputCurrentSemester = csem
                var data = ({
                    semester_id:parseInt($scope.inputCurrentSemester)
                })

                $myUtils.httppostrequest(urlist.makesemesteractive,data).then(function(response){
                    if(response != null && response.message == true)
                    {
                        $scope.getSemesterList($myUtils.getDefaultSchoolId())
                        $scope.getActiveSemesterInSchool($myUtils.getDefaultSchoolId())
                        message('Semester set','show')
                    }
                    else{
                        message('Semester  not set','show')
                    }
                });
            }
            catch(ex){}
        }

        $scope.sessionobj.activeid = null;

        $scope.setCurrentSession = function(sessionid)
        {
            try{
                 $("#changeSession").modal('show');
                $scope.sessionobj.activeid = parseInt(sessionid)
               
            }
            catch(ex){}
        }
        
        $scope.deactiveselectedsession = function()
        {
            try{
                loadSession();
            }
            catch(ex){}
        }

        $("#changeSession").on("hidden.bs.modal", function () {
            
             $scope.sessionobj.activeid = null;
        });


         $scope.changeSchoolSesion = function()
        {
            try{
                if($scope.sessionobj.activeid != null)
                {
                    var data = ({
                        session_id:$scope.sessionobj.activeid
                    })

                    $myUtils.httppostrequest(urlist.makesessionactive,data).then(function(response){
                        $("#changeSession").modal('hide');
                        if(response != null && response.message == true)
                        {

                            $scope.getSessionList($myUtils.getDefaultSchoolId())
                            $scope.getActiveSessionInSchool($myUtils.getDefaultSchoolId())
                            
                            $scope.sessionobj.activeid = null;
                            message('Session set','show')
                        }
                        else{
                            message('Session  not set','show')
                        }
                    });
                }else{
                    message('Semester  not set','show');
                }
            }
            catch(ex){}
        }


         /**
          * Get session list for principal and store it local storage
          */
         $scope.getSessionList = function(schoolId = null) {
             $myUtils.httprequest($scope.shama_api_path+'sessions', {
                 school_id: schoolId
             }).then(function(response) {
                 if (response != null && response.length > 0) {
                     $myUtils.storage.sessionList = response;
                 } else {
                     $myUtils.storage.sessionList = [];
                 }
             });
         }
         

         /**
          * Get semester list for principal and store it local storage
          */
         $scope.getSemesterList = function(schoolId = null) {
             $myUtils.httprequest($scope.shama_api_path+'semesters', {
                 school_id: schoolId
             }).then(function(response) {
                 if (response != null && response.length > 0) {
                     $myUtils.storage.semesterList = response;
                 } else {
                     $myUtils.storage.semesterList = [];
                 }
             });
         }

         /**
          * Get active semester
          */
         $scope.getActiveSemesterInSchool = function(schoolId = null) {
             $myUtils.httprequest($scope.shama_api_path+'active_semester_in_school', {
                 school_id: schoolId
             }).then(function(response) {
                 if (response != null && response.status) {
                     $myUtils.storage.active_semester = response.semester.name;
                 }
                 else{
                     $myUtils.storage.active_semester = "Fall";
                 }
             });
         }

         /**
          * Get active session
          */
         $scope.getActiveSessionInSchool = function(schoolId = null) {
             $myUtils.httprequest($scope.shama_api_path+'active_session_in_school', {
                 school_id: schoolId
             }).then(function(response) {
                 if (response != null && response.status) {
                     $myUtils.setDefaultSessionId(response.session.id);
                     $myUtils.getLocalStorage().active_session = response.session;
                 }
             });
         }

        $scope.removesemester = function(sessionid)
        {
            $("#delete_dialog").modal('show');
            $scope.dialogItemName = "semester"
            $scope.semesterid = sessionid
        }

        $(document).on('click','#save',function(){
            $("#delete_dialog").modal('hide');
            var data = ({
                semester_id:$scope.semesterid
            })

           $myUtils.httpdeleterequest('semester',data).then(function(response){
                if(response != null)
                {
                   message('Semester removed','show')
                   loadSemester()
                   $scope.semesterid = 0
                }else{
                    message('Semester not remove','show')

                   $scope.semesterid = 0
                }
            });
        });

       $scope.EnableTimeTable=function()
       {

        $is_release=$('#inputTimeTable').is(":checked");

        $scope.inputRelease=$is_release;
        $myUtils.httppostrequest('ReleaseTimetable',$is_release);
        alert();

       }
       $scope.EnableShedullar=function()
       {

            $is_release=$('#inputShedullar').is(":checked");

            $scope.inputRelease=$is_release;
            $myUtils.httppostrequest('ReleaseTimetable',$is_release);
            alert();


       }


       function loadSettings()
        {
            try{
                var data = ({})

                $myUtils.httprequest(urlist.getoptions,data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.inputAdminEmail = response[0].value;

                    }
                    else{
                        $scope.inputAdminEmail = ''
                    }
                })
            }
            catch(ex){}
        }

        $scope.saveadminsettings = function()
        {
            try{

                // if($scope.inputAdminEmail.length > 0){
                    var reg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/i);
                    debugger
                    if(reg.test($scope.inputAdminEmail) == false){
                        jQuery("#inputAdminEmail").css("border", "1px solid red");
                        return false;
                    }

                    else
                    {
                        jQuery("#inputAdminEmail").css("border", "1px solid #C9C9C9");
                        
                    }

                    var $this = $(".email-btn");
                    $this.button('loading');
                    var data = ({
                        email:$scope.inputAdminEmail
                    })

                    $myUtils.httppostrequest(urlist.saveoptions,data).then(function(response){
                        if(response != null && response.message == true)
                        {
                            $this.button('reset');
                            message('Email saved','show')
                        }
                        else{
                            $this.button('reset');
                            message('Email does not save.','show')
                        }
                    });
                //}
            }
            catch(ex)
            {
                
            }
        }

        function getCitiesList()
        {
             try{
                var data = ({})

                $myUtils.httprequest(urlist.getcitylist,data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.citylist = response;
                        $scope.selectlistcity = response
                        $scope.inputCity = response[0]
                        $scope.inputSelectList = response[0]
                    }
                    else{
                        $scope.citylist = []
                    }
                })
            }
            catch(ex){}
        }

        $scope.locid = 0
        $scope.savelocation = function()
        {

            var reg = new RegExp(/^[A-Za-z0-9\s]{3,50}$/);


            if(reg.test(jQuery("#inputLocation").val()) == true)
            {
                jQuery("#location_error").hide();
                var $this = $(".location-btn");
                $this.button('loading');

                var data = ({
                    location:jQuery("#inputLocation").val(),
                    location_id:$scope.locid
                })
                
                jQuery("#inputLocation").css("border", "1px solid #C9C9C9");
                $myUtils.httppostrequest(urlist.savelocation,data).then(function(response){
                    if(response != null && response.message == true)
                    {
                        message('Location has been successfully saved','show');
                        getCitiesList()
                        $scope.inputLocation = null;
                        $scope.locid = 0;
                        $this.button('reset');
                    }else{
                       $this.button('reset');
                    }
                });
            }
            else{
                jQuery("#inputLocation").css("border", "1px solid red");
                //jQuery("#location_error").show();
                message('Please enter location name character between 3-56','show')

            }
        }

        $scope.editlocation = function(locationid)
        {

            $scope.locid = locationid
            var data = ({
                id:$scope.locid
            })

           $myUtils.httprequest(urlist.getlocationdetail,data).then(function(response){
                if(response != null)
                {
                    $scope.inputLocation = response[0].name;
                }
            });
        }

        $scope.removelocation = function(locationid)
        {
            $("#delete_location").modal('show');
            $scope.locid = locationid
        }

        $(document).on('click','#remove_location',function(){
            $("#delete_location").modal('hide');
            var data = ({
                location_id:$scope.locid
            })

           $myUtils.httpdeleterequest(urlist.removelocation,data).then(function(response){
                if(response != null)
                {
                   message('Location removed','show')
                   getCitiesList()
                   $scope.locid = 0
                }else{
                    message('Location not remove','show')

                   $scope.locid = 0
                }
            });
        });

        function getSchoolList()
        {
             try{
                var data = ({})
                $myUtils.httprequest(urlist.getschoollist,data).then(function(response){
                    if(response.length > 0 && response != null)
                    {
                        $scope.schoolarray = response;
                    }
                    else{
                        $scope.schoolarray = []
                    }
                })
            }
            catch(ex){}
        }

        $scope.schid = 0
        $scope.saveschool = function()
        {
            var reg = new RegExp(/^[A-Za-z0-9 ]{3,50}$/);
            if(reg.test($("#inputSchoolName").val()) == true)
            {
                var $this = $(".school-btn");
                $this.button('loading');

                var data = ({
                    school_name:$("#inputSchoolName").val(),
                    location_id:$scope.inputSelectList.id,
                    school_id:$scope.schid

                })

                jQuery("#inputSchoolName").css("border", "1px solid #C9C9C9");
                $myUtils.httppostrequest(urlist.saveschool,data).then(function(response){
                    if(response != null && response.message == true)
                    {
                        message('School has been successfully added','show')
                        getSchoolList()
                        $scope.inputSchoolName = ''
                         $scope.schid = 0
                        $this.button('reset');
                    }else{
                        message('School did not add','show')
                        $this.button('reset');
                    }
                });
            }
            else{
                jQuery("#inputSchoolName").css("border", "1px solid red");
                message('Please enter school name character between 3-56','show')
            }
        }

        $scope.editschool = function(schoolid)
        {

            $scope.schid = schoolid
            var data = ({
                school_id:$scope.schid
            })

           $myUtils.httprequest(urlist.getschooldetail,data).then(function(response){
                if(response != null)
                {
                    var selectedcity  = cityfind(response[0].city_id)

                    $scope.inputSchoolName = response[0].name;
                    $scope.inputSelectList = $scope.selectlistcity[selectedcity];
                }
            });
        }

        function cityfind(cityid)
        {
            for (var i = 0; i < $scope.selectlistcity.length; i++) {
                if($scope.selectlistcity[i].id == cityid)
                {
                    return i;
                }
            }
        }
        $scope.removeschool = function(schoolid)
        {
            $("#delete_school").modal('show');
            $scope.schid = schoolid
        }

        $(document).on('click','#remove_school',function(){
            $("#delete_school").modal('hide');
            var data = ({
                school_id:$scope.schid
            })

           $myUtils.httpdeleterequest(urlist.removeschool,data).then(function(response){
                if(response != null)
                {
                   message('School has been successfully removed','show')
                   getSchoolList()
                   $scope.schid = 0
                }else{
                    message('School did not remove','show')

                   $scope.schid = 0
                }
            });
        });

        $scope.holidaytypelist = [];

        if($scope.isPrincipal){
            getHolidaytypes();
        }
        
        function getHolidaytypes()
        {
        	var data = ({
                school_id:$scope.school_id
            })
            
            $myUtils.httprequest(urlist.getholidaytypelist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.holidaytypelist = response;
                }else{
                   $scope.holidaytypelist = []
                }
            });
        }

        $scope.saveholidaytype = function(type)
        {
            try{

                if(typeof type.title != 'undefined')
                {
                    if(type.title.length > 3 && type.title.length <= 256 )
                    {
                        $scope.show_event_type_error = true;
                         $scope.usersavebtntext = "Saving";
                         type.school_id = $scope.school_id;
                         type.user_id = $scope.user_id;
                        $myUtils.httppostrequest(urlist.saveholidaytype,type).then(function(response){
                            if(response != null)
                            {
                                $scope.holidaytype.serial = '';
                                $scope.holidaytype.id = '';
                                $scope.holidaytype.title = '';
                            
                                getHolidaytypes();
                                $scope.usersavebtntext = "Save";
                            }else{
                               $scope.usersavebtntext = "Save";
                            }
                        });
                    }
                    
                }else{
                   $scope.show_event_type_error = false; 
                }
            }
            catch(e){}
            
        }

        $scope.editholidaytype = function(type)
        {
            $scope.holidaytype = type;
        }

        $scope.removeholidaytype = function(type)
        {
            $("#delete_holidaytype").modal('show');
            $scope.removeholiday = type;
        }

        $scope.holidayremoveclick = function()
        {
           if($scope.removeholiday)
            {
                $myUtils.httpdeleterequest(urlist.removeholidaytype,$scope.removeholiday).then(function(response){
                    if(response != null && response.message == true)
                    {
                        $("#delete_holidaytype").modal('hide');
                        $scope.removeholiday = {};
                        $scope.holidaytype.serial = '';
                        getHolidaytypes();
                    }else{
                      
                    }
                });
            }
        }

        
        // Initialize default date
        function defaultdate()
        {
            try{
                
                if($scope.is_active_semester.length < 0)
                {
                    $scope.semesterdetail.date = {
                        startDate:moment().format('MM/DD/YYYY'),
                        endDate: moment().add(6, "month").format('MM/DD/YYYY'),
                    };
                }else{
                    $scope.semesterdetail.date = {
                        startDate:moment($scope.is_active_semester[0].endDate).format('MM/DD/YYYY'),
                        endDate: moment($scope.is_active_semester[0].endDate).add(+1,"day").add(6, "month").format('MM/DD/YYYY'),
                    };
                }
                

                $scope.options = {
                    timePicker: false,
                    showDropdowns: true,
                    locale:{format:'MM/DD/YYYY'},
                    // "minDate": ($scope.is_active_semester.length > 0  ? moment($scope.is_active_semester[0].end_date).format('MM/DD/YYYY')  : moment().format('MM/DD/YYYY'))  ,
                    // "maxDate": ($scope.is_active_semester.length > 0  ? moment($scope.is_active_semester[0].end_date).add(+1,"day").add(6, "month") : moment().add(6, "month").format('MM/DD/YYYY'))  ,
                    eventHandlers:{
                        'apply.daterangepicker': function(ev, picker){}
                    }
                }
                
                //Watch for date changes
                $scope.$watch('semesterdetail.date', function(newDate) {
                }, false);
               
            }
            catch(ex)
            {
                console.log(ex)
            }
        }

        $scope.is_active_semester = [];

        if($scope.isPrincipal){
            getSemesterDetail();
        }
        
        function getSemesterDetail()
        {

            var data = {
                school_id : $scope.school_id,
            }
            $myUtils.httprequest(urlist.getsemesterdatelist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.semester_detail_list = response;
                    $scope.is_active_semester = $filter('filter')(response,{status:'a'},true);
                    if($scope.is_active_semester.length > 0)
                    {
                        $scope.InputActiveSem = $scope.is_active_semester[0].id;
                        defaultdate();
                    }
                }else{
                   $scope.semester_detail_list = [];
                   defaultdate();
                }
            });
        }
        
        $scope.savesemesterdetail = function(semesterdetail)
        {

            try{
                if(semesterdetail.date != '' && semesterdetail.semester)
                {
                    $scope.usersavebtntext = "Saving";
                 
                    var sdate = moment($scope.semesterdetail.date.startDate).format('MM/DD/YYYY');
                    var edate = moment($scope.semesterdetail.date.endDate).format('MM/DD/YYYY');
                
                    $scope.semesterdetail.startDate =sdate;
                    $scope.semesterdetail.endDate =edate;
                    //$scope.semesterdetail.session_id = $myUtils.getDefaultSessionId();
                    var data = ({
                        id: $scope.semesterdetail.id,
                    	start_date : sdate,
                        end_date : edate,
                        semester_id : semesterdetail.semester,
                        school_id: $scope.school_id,
                        session_id: $myUtils.getDefaultSessionId()
                    })
                    
                    $myUtils.httppostrequest(urlist.savesemesterdate,data).then(function(response){
                        if(response != null && response.message == true)
                        {
                             $scope.semesterdetail.serial = '';
                            $scope.usersavebtntext = "Save";
                            $scope.semesterdetail = {};
                            defaultdate();
                            getSemesterDetail();
                            $scope.getSemesterList($myUtils.getDefaultSchoolId())
                            $scope.getActiveSemesterInSchool($myUtils.getDefaultSchoolId())
                          
                            $scope.semesterdetail.semester = $scope.semesterlist[0].id;
                        }else{
                            if(response.exists == "Exists")
                                {
                                    message('Semester Date already Exists','show');
                                }
                            else
                                {
                                    message('Semester Date not mateched in session dates','show');
                                }
                           $scope.usersavebtntext = "Save";
                            $scope.semesterdetail = {};
                            defaultdate();
                        }
                    });
                }
            }
            catch(e)
            {
                console.log(e)
            }
        }

        $scope.editsemesterdetail = function(semesterdetail)
        {
            try{
                $scope.semesterdetail = semesterdetail;
                $scope.semesterdetail.date = {
                    startDate:moment(semesterdetail.start_date),
                    endDate: moment(semesterdetail.end_date),
                };
              }
            catch(e)
            {
                console.log(e)
            }
        }
        
        $scope.semesterdetailid = null
        // remove form
        $scope.removesemesterdetail = function(semesterdetail)
        {
            $("#MyModal").modal('show');
            $scope.semesterdetailid = semesterdetail.id;
        }

        $scope.removesemesterbyuser = function()
        {
            if(typeof $scope.semesterdetailid !== "undefined" && $scope.semesterdetailid)
            {

                try{
                    var data = {
                        id : $scope.semesterdetailid,
                    }
                    $myUtils.httpdeleterequest(urlist.removesemesterdate,data).then(function(response){
                        if(typeof response != 'undefined' && response)
                        {
                            $scope.semesterdetail.serial = '';
                            $scope.semesterdetailid = '';
                            $scope.removeid = null;
                             getSemesterDetail();
                        }
                    }); 
                }
                catch(e){}
            }
            $("#MyModal").modal('hide');
        }

    
        $("#MyModal").on("hidden.bs.modal", function () {
            $scope.removeid = null;
            $scope.semesterdetailid = null
        });

        $scope.gradeobj = {};
        $scope.gradelist = [];
        $scope.savegrade = function(gradeobj)
        {
            try{
                if(gradeobj.title && gradeobj.lower_limit && gradeobj.upper_limit)
                {
                    $scope.usersavebtntext = "Saving";

                    var data = gradeobj;
                    data.school_id = $scope.school_id
                    
                    $myUtils.httppostrequest(urlist.savegrade,data).then(function(response){
                        if(response != null && response.message == true)
                        {
                            $scope.gradeobj = {};
                            $scope.usersavebtntext = "Save";
                            getGradeList();
                          
                        }else{
                           $scope.usersavebtntext = "Save";
                        }
                    });
                }
            }
            catch(e)
            {
                console.log(e)
            }
        }

        $scope.editgrade = function(grade)
        {
            $scope.gradeobj = grade;
        }

        $scope.removegrade = function(grade)
        {
            $("#RemoveGrade").modal();
            $scope.graderowid = grade.id;
        }

        $scope.removeGradepoint = function()
        {
            if(typeof $scope.graderowid !== "undefined" && $scope.graderowid)
            {
                try{
                    var data = ({
                        id : $scope.graderowid,
                        school_id: $scope.school_id
                    })
                    $myUtils.httpdeleterequest(urlist.removegrade,data).then(function(response){
                        if(typeof response != 'undefined' && response)
                        {
                            $scope.graderowid = '';
                            getGradeList();
                        }
                    }); 
                }
                catch(e){}
            }
            $("#RemoveGrade").modal('hide');
        }

    
        $("#RemoveGrade").on("hidden.bs.modal", function () {
            $scope.graderowid = null;
        });

        if($scope.isPrincipal){
            getGradeList();
        }
        
        function getGradeList()
        {
            try{
            	
                $myUtils.httprequest(urlist.getgradelist,{session_id:$scope.session_id}).then(function(response){
                    if(response != null && response.length > 0)
                    {
                        $scope.gradelist = response;
                    }else{
                       $scope.gradelist = []
                    }
                });
            }
            catch(e){}
        }
       
        $scope.semesterdetail.activeid = null;
        $scope.changesemesterdate = function(makesemesteractive)
        {
            try{
                $("#changeSemesterModal").modal('show');
                $scope.semesterdetail.activeid = makesemesteractive.id
            }
            catch(ex){}
        }

        $scope.deactiveselectedsemester = function()
        {
            try{
                getSemesterDetail();
            }
            catch(ex){}
        }

        $("#changeSemesterModal").on("hidden.bs.modal", function () {
            
            $scope.semesterdetail.activeid = null;
        });

        $scope.setSemesterActive = function()
        {

            try{
                if($scope.semesterdetail.activeid != null)
                {
                    var data = ({
                        id:$scope.semesterdetail.activeid,
                        school_id:$scope.school_id
                    });

                    $myUtils.httppostrequest(urlist.makesemesterdatesactive,data).then(function(response){
                        $("#changeSemesterModal").modal('hide');
                        if(response != null && response.message == true)
                        {
                            message('Semester set','show')
                            $scope.semesterdetail.activeid = null;
                            getGradeList();
                        }
                        else{
                            message('Semester  not set','show')
                        }

                    });
                }else{
                    message('Semester  not set','show');
                }
            }
            catch(ex){}
        }
        // Shama v2.0
        if($scope.isPrincipal){
            getAssembly();
        }
        
        function getAssembly()
        {
            var data = ({
                school_id:$scope.school_id
            })
            
            $myUtils.httprequest(urlist.getAssemblylist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.assemblylist = response;
                }else{
                   $scope.assemblylist = []
                }
            });
        }

        $scope.getassemblyedit = function()
        
        {
            var data = ({
                school_id:$scope.school_id
            })
            
            $myUtils.httprequest(urlist.getassemblyedit,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    
                       $scope.assemblyobj = response[0];
                    
                }else{
                  // $scope.assemblylist = []
                }
            });
        }
        
        $scope.saveassembly = function()
        
        {
            var data = ({
                school_id:$scope.school_id,
                starttime:$scope.assemblyobj.start_time,
                endtime:$scope.assemblyobj.end_time
            })
            
            $myUtils.httppostrequest(urlist.saveassemblydata,data).then(function(response){
                if(response)
                {
                    message('Successfully updated','show')
                    getAssembly();
                    $scope.assemblyobj = "";
                }else{
                  // $scope.assemblylist = []
                }
            });
        }
        if($scope.isPrincipal){
            getBreaklist();
        }
        
        function getBreaklist()
        {
            var data = ({
                school_id:$scope.school_id
            })
            
            $myUtils.httprequest(urlist.getLoadBreaklist,data).then(function(response){
                if(response != null && response.length > 0)
                {
                    $scope.breakdatalist = response;
                }else{
                   $scope.breakdatalist = []
                }
            });
        }

        $scope.getbreakedit = function()
        {
            var data = ({
                school_id:$scope.school_id
            })
            

            $myUtils.httprequest(urlist.getbreakedit,data).then(function(response){
               if(response != null && response.length > 0)
                {
                    
                    $scope.breakobj = response[0];
                }else{
                   $scope.breakobj = []
                }
            });
        }
        $scope.savebreak = function()
        
        {
            var data = ({
                school_id:$scope.school_id,
                monday_start_time:$scope.breakobj.monday_start_time,
                monday_end_time:$scope.breakobj.monday_end_time,
                tuesday_start_time:$scope.breakobj.tuesday_start_time,
                tuesday_end_time:$scope.breakobj.tuesday_end_time,
                wednesday_start_time:$scope.breakobj.wednesday_start_time,
                wednesday_end_time:$scope.breakobj.wednesday_end_time,
                thursday_start_time:$scope.breakobj.thursday_start_time,
                thursday_end_time:$scope.breakobj.thursday_end_time,
                friday_start_time:$scope.breakobj.friday_start_time,
                friday_end_time:$scope.breakobj.friday_end_time,
            })
            
            $myUtils.httppostrequest(urlist.savebreakdata,data).then(function(response){
                if(response)
                {
                    message('Successfully updated','show')
                    getBreaklist();
                    $scope.breakobj = "";
                }else{
                  getBreaklist();
                }
            });
        }
}

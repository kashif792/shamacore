var app = angular.module("invantage", ["ngRoute","ngCookies","ngStorage","ngSanitize","com.2fdevs.videogular", "com.2fdevs.videogular.plugins.controls","com.2fdevs.videogular.plugins.overlayplay","com.2fdevs.videogular.plugins.poster"]);
app.config(function($routeProvider,$locationProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "./application/views/webapplication/index.php",
    })
    .when("/attendance/:classid/:sectionid/:mode/:classname/:sectionname", {
        templateUrl : "./application/views/webapplication/attendance.php",
    })
    .when("/lessons/:subjectid/:subjectname", {
        templateUrl : "./application/views/webapplication/lessons.php",
    })
    .when("/subjects/:classid/:sectionid?/:classname/:sectionname?", {
        templateUrl : "./application/views/webapplication/subjects.php",
    })
    .when("/subjects", {
        templateUrl : "./application/views/webapplication/subjects.php",
    })
    .when("/attendance/:classid/:sectionid/:mode/:classname/:sectionname", {
        templateUrl : "./application/views/webapplication/attendance.php",
    })
    .when("/lesson/:classid/:sectionid", {
        templateUrl : "./application/views/webapplication/lesson.php",
    })
    .when("/lesson/:lessonid", {
        templateUrl : "./application/views/webapplication/lesson.php",
    });
});

app.filter('periodtime', function myDateFormat($filter){
  return function(text){
    var  tempdate= new Date(text);
    return $filter('date')(tempdate, "h:mm a");
  }
});


app.directive('checkbox',
    [
        function() {
            return {
                restrict: 'A',
                link: function(scope, element, attribute, model) {
                    if (! attribute.checkbox) {
                        return false;
                    }
                    scope.$watch(attribute.checkbox, function(state) {
                        if (state) {
                            element.addClass('checked');
                        } 
                        else {
                            element.removeClass('checked');
                        }
                    });
                }
            };
        }
    ]
);

app.factory('learningCommon',function($http,$localStorage,$sessionStorage){
    var fac = {};
    fac.modes = [];
    fac.localStorage = $localStorage;
    fac.modes = [
        {
            id:1,
            title: 'Time restricted mode',
        },
        {
            id:2,
            title: 'Timetable-free is enabled',
        },
    ];
    fac.getrequest = function(url,data)
    {
        var request = $http({
            method:'get',
            url:url,
            params:data,
            headers : {'Accept' : 'application/json'}
        });
        return (request.then(responseSuccess,responseFail))
    }

    fac.postrequest = function(url,data)
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

    fac.getlocationlist = function(locid = '')
    {
        fac.getrequest('getlocation',({locationid:locid})).then(function(response){
            if(response != null && response.message != false)
            {
                angular.forEach(response,function(value,key){
                    response[key].currentlocationselected = false;
                });
              
                fac.locationlist = response;
            }
        });
    }

    //fac.getlocationlist();

    fac.setNotifications = function()
    {
        fac.getrequest('getnotifications',{}).then(function(response){
            if(response != null && response.message != false)
            {
                fac.usernotifications = response;
            }
        });
    }

   // fac.setNotifications();

   fac.getMode = function()
   {
        return fac.modes;
   }

    fac.setMode = function(modeInput)
    {
        if(typeof modeInput != 'undefined' && modeInput)
        {
            fac.modes.push(modeInput);
        }
    }

    fac.clearAllSession = function()
    {
        delete fac.localStorage.selectedstudentds;
        delete fac.localStorage.lessonlist;
        delete fac.localStorage.classinfo;
        delete fac.localStorage.userrole;
        delete fac.localStorage.alreadyreadlesson;
        delete fac.localStorage.subject;
        delete fac.localStorage.subjectinfo;
        delete fac.localStorage.periodlist;
    }

    fac.getLocalStorage = function()
    {
        return fac.localStorage;
    }

    fac.setSessionValue = function(inputSession)
    {
        if(inputSession)
        {
            fac.localStorage.push(inputSession)
        }
    }

    return fac;
});


app.controller('index_ctrl',function($scope,learningCommon,$cookieStore,$localStorage,$sessionStorage,$filter){
    $scope.intro = true;
    $scope.commonobj = learningCommon;
    $scope.modes = $scope.commonobj.getMode();
    $scope.sessionobj =  $scope.commonobj.getLocalStorage();
  
    $scope.classobj = {};
    $scope.classlist = [];
    $scope.sectionlist = [];
    
    $scope.type = 't';
    $scope.loading = true;

    angular.element(function(){
        checkUserrole();
        getclasslist();

        $scope.$watch(function(){
            return $scope.commonobj.localStorage.userrole;
        },function(newValue,oldValue){
            if(typeof newValue != 'undefined' && newValue)
            {
                $scope.type = $scope.commonobj.localStorage.userrole;
            }
        });
    });

    function checkUserrole()
    {
        try{
            $scope.commonobj.getrequest('userroleapp',{}).then(function(response){
                $scope.commonobj.localStorage.userrole = response.userrole;
                $scope.type = $scope.commonobj.localStorage.userrole;
            });
        }
        catch(e){}
    }

    function getclasslist()
    {
        try{
            $scope.commonobj.getrequest('getclasssectionlist',{}).then(function(response){
                if(typeof response != 'undefined' && response.length > 0){
                    $scope.classlist = response;
                    $scope.classobj.class = response[0];
                    $scope.sectionlist = $scope.classlist[0].section;
                    $scope.classobj.section = $scope.sectionlist[0];
                    $scope.classobj.mode = $scope.modes[0]; 
                     $scope.loading = false;
                    if(typeof $scope.commonobj.localStorage.userrole.classinfo != 'undefined' && $scope.commonobj.localStorage.userrole.classinfo)
                    {
                        showselectedoptions();
                    }
                }
            });
        }
        catch(e){}
    }

    function showselectedoptions()
    {
        try{
            var is_class_found = $filter('filter')($scope.classlist,{id:$scope.commonobj.localStorage.classinfo.classid},true);
            if(is_class_found.length > 0)
            {
                $scope.classobj.class = is_class_found[0];
            }

            var is_section_found = $filter('filter')($scope.sectionlist,{id:$scope.commonobj.localStorage.classinfo.sectionid},true);
            if(is_section_found.length > 0)
            {
                $scope.classobj.section = is_section_found[0];
            }

            var is_mode_found = $filter('filter')($scope.modes,{id:parseInt($scope.commonobj.localStorage.classinfo.mode)},true);
         
            if(is_mode_found.length > 0)
            {
                $scope.classobj.mode = is_mode_found[0]; 
            }
        }
        catch(e){}
    }

});

app.controller('attendance_ctrl',function($scope,learningCommon,$route, $routeParams,$cookieStore,$localStorage,$sessionStorage,$location,$window,$filter){
    $scope.commonobj = learningCommon;
    $scope.params = $routeParams;
    $scope.sessionobj =  $scope.commonobj.getLocalStorage();
    

    $scope.limit = 10;
    $scope.offset = 0;
    $scope.backbutton = '';
    $scope.pagetitle = "Attendance";
    $scope.classname = $scope.params.classname;
    $scope.loading = true;
    $scope.sectionname = $scope.params.sectionname;
    $scope.mode = 1;
    $scope.is_newclass = false;

    angular.element(function(){
        $scope.$watch(function(){
            return $localStorage.userrole;
        },function(newValue,oldValue){
            
            if(typeof newValue != 'undefined' && newValue)
            {
                if(typeof $localStorage.classinfo != 'undefined')
                {
                    if($scope.params.classid != $localStorage.classinfo.classid)
                    {
                        $scope.is_newclass = true;
                    }
                }

                if(typeof $scope.params.classid != 'undefined' && $scope.params.classid)
                {
                    $scope.classinfo = {
                        classid:$scope.params.classid,
                        classname:$scope.params.classname,
                        sectionid:$scope.params.sectionid,
                        mode:$scope.params.mode,
                        sectionname:$scope.params.sectionname,
                    }
                   
                    $scope.commonobj.localStorage.classinfo = $scope.classinfo;
                    $localStorage.classinfo = $scope.classinfo;
                }
                
                $scope.type = $localStorage.userrole;
                $scope.classid = $scope.params.classid;
                $scope.sectionid = $scope.params.sectionid;
                $scope.mode = $scope.params.mode;
                getstudentlist();
            }
        });
    });

    
    var periodinfo = $cookieStore.get('periodinfo');

    if(!periodinfo)
    {
        $cookieStore.put('periodinfo',$scope.params);  
    }

    function getstudentlist()
    {
        try{
            var data = {
                classid:$scope.params.classid,
                sectionid:$scope.params.sectionid,
            }
            
            $scope.commonobj.postrequest('getstudentbyclassusingapi',data).then(function(response){
                if(typeof response != 'undefined' && response.length > 0)
                {
                    if(!$localStorage.selectedstudentds)
                    {
                        angular.forEach(response,function(value,key){
                            value.studentpresent = true;
                        });
                    }
                    else{
                        if(!$scope.is_newclass)
                        {
                            angular.forEach(response,function(value,key){
                            var is_student_already_selected = $filter('filter')($localStorage.selectedstudentds,{id:value.id},true);
                                if(is_student_already_selected.length > 0)
                                {
                                    value.studentpresent = true;
                                }
                                else{
                                    value.studentpresent = false;
                                }
                            });
                        }
                        else{
                            angular.forEach(response,function(value,key){
                                value.studentpresent = true;
                            });
                        }
                    }
                    $scope.studentlist = response;
                    $scope.loading = false;
                    iteratestudentlist();
                }else{
                    $scope.loading = false;

                    $scope.studentlist = response;
                }
            });
        }
        catch(e){}
    }

    function iteratestudentlist()
    {
        $scope.students = $scope.studentlist;
    }

    $scope.previous =function() 
    {
        if($scope.offset >= $scope.limit)
        {
            $scope.offset = $scope.offset - $scope.limit;  
            $scope.limit = $scope.limit - $scope.limit;  
        }
        else{
            $scope.offset = 0;  
            $scope.limit =  $scope.limit;  
        }
        iteratestudentlist();
    }

    $scope.next = function()
    {
        if($scope.offset < $scope.studentlist.length)
        {
            $scope.offset = $scope.offset + $scope.limit;  
            $scope.limit = $scope.limit + $scope.limit;  
        }

        if($scope.offset >= $scope.studentlist.length)
        {
            $scope.offset = $scope.offset;  
            $scope.limit = $scope.limit;  
        }
        iteratestudentlist();
    }


    $scope.savestudent = function()
    {
        $scope.selectedstudentds = [];
        $scope.commonobj.localStorage.selectedstudentds = [];
        
        angular.forEach($scope.studentlist,function(value,key){
            if(value.studentpresent)
            {
                $scope.selectedstudentds.push($scope.studentlist[key]);
            }
        });
        $scope.commonobj.localStorage.selectedstudentds = $scope.selectedstudentds;

        if($scope.commonobj.localStorage.classinfo.mode == 1)
        {

            $location.path('lesson/'+$scope.commonobj.localStorage.classinfo.classid+'/'+$scope.commonobj.localStorage.classinfo.sectionid);
        }
        else{
            $location.path('subjects');
        }
    }

    $scope.checkstudents = function()
    {
        $scope.nextdisable = false;
        $scope.is_student_exist = [];
        angular.forEach($scope.studentlist,function(value,key){
            if(value.studentpresent)
            {
                $scope.is_student_exist.push($scope.studentlist[key]);
            }
        });
        if($scope.is_student_exist.length == 0)
        {
            $scope.nextdisable = true;
        }
    }
});

app.controller('subject_ctrl',function($scope,learningCommon,$route, $routeParams,$cookieStore,$localStorage,$sessionStorage,$window,$http){
    $scope.commonobj = learningCommon;

    $scope.params = $routeParams;
    $scope.loading = true;

    angular.element(function(){

        if(typeof $scope.params.classid != 'undefined' && $scope.params.classid)
        {
            $scope.classinfo = {
                classid:$scope.params.classid,
                classname:$scope.params.classname,
                sectionid:$scope.params.sectionid,
                sectionname:$scope.params.sectionname,
            }
            $scope.commonobj.localStorage.classinfo = $scope.classinfo;
            $localStorage.classinfo = $scope.classinfo;
        }

        $scope.$watch(function(){
            return $scope.commonobj.localStorage.classinfo;
        },function(newValue,oldValue){
            
            if(typeof newValue != 'undefined' && newValue)
            {
                $scope.classid = $scope.commonobj.localStorage.classinfo.classid;
                $scope.sectionid = $scope.commonobj.localStorage.classinfo.sectionid;
                $scope.mode = $scope.commonobj.localStorage.classinfo.mode;
                $scope.classname = $scope.commonobj.localStorage.classinfo.classname;
                $scope.sectionname = $scope.commonobj.localStorage.classinfo.sectionname;
                $scope.type = $scope.commonobj.localStorage.userrole;

                getsubjectlist();
            }
        })
        
    });

    function getsubjectlist()
    {
        try{
            var data = {
                class_id:$scope.commonobj.localStorage.classinfo.classid,
                section_id:$scope.commonobj.localStorage.classinfo.sectionid,
            }
            
            $scope.commonobj.postrequest('getsubjectlistbyclassapi',data).then(function(response){
                if(typeof response != 'undefined' && response && response.status== true)
                {
                     angular.forEach(response.message, function(value,key){
                        value.subject_image = "images/backimage.png";
                       
                        $http.get("upload/content/"+$scope.commonobj.localStorage.classinfo.classname+"/subjects/"+value.subject_name+".png").then(function(r){

                           if(r.status == 200)
                           {
                            value.subject_image = "upload/content/"+$scope.commonobj.localStorage.classinfo.classname+"/subjects/"+value.subject_name+".png"
                           }                                  
                        });
                    });

                    $scope.subjects = response.message;
                     $scope.loading = false;
                }
                else if((typeof response != 'undefined' && response && response.status== false))
                {
                     $scope.subjects = [];
                     $scope.loading = false;
                }
            });
        }
        catch(e){
            console.log(e)
        }
    }
});

app.controller('lessons_ctrl',function($scope,$http,learningCommon,$cookieStore,$route, $routeParams,$localStorage,$sessionStorage,$window,$filter){

    $scope.loading = true;
    $scope.commonobj = learningCommon;

    $scope.params = $routeParams;
    var screenWidth = $window.innerWidth;
    if(screenWidth <= 768)
    {
        $scope.limit = 1;
    }

    if(screenWidth >= 769 && screenWidth <= 1024)
    {
        $scope.limit = 4;
    }

    if(screenWidth >= 1025 && screenWidth <= 1280)
    {
        $scope.limit = 6;
    }

    if(screenWidth >= 1281 && screenWidth <= 1366)
    {
       
        $scope.limit = 6;
    }

    if(screenWidth >= 1367 && screenWidth <= 1680)
    {

        $scope.limit = 8;
    }

    if(screenWidth >= 1681 && screenWidth <= 1920)
    {
        $scope.limit = 10;
    }

    $scope.current_page = 0;
    $scope.offset = 0;
    
    $scope.page = 1;

    $scope.currentblinking = 0;
    angular.element(function(){
        if(typeof $scope.params.subjectid != 'undefined' && $scope.params.subjectid)
        {
            $scope.commonobj.localStorage.subject = $scope.params;
            $scope.subjectinfo = {
                subjectid:$scope.params.subjectid,
                subjectname:$scope.params.subjectname
            }
      
            $scope.commonobj.localStorage.subjectinfo = $scope.subjectinfo;
        }
       
        $scope.$watch(function(){
            return $scope.commonobj.localStorage.selectedstudentds;
        },function(newValue,oldValue){
            if(newValue)
            {
                getlessonslist();
            }
        })

        $scope.$watch(function(){
            return $scope.commonobj.localStorage.userrole;
        },function(newValue,oldValue){
            if(newValue)
            {
                if($scope.commonobj.localStorage.userrole == 'g')
                {
                    getlessonslist();
                }
            }
        })
    });
    
    var subjectname = $cookieStore.get('subjectname');
    if(!subjectname)
    {
         $cookieStore.put('subjectname',$scope.params.subjectname);  
    }

    function getlessonslist()
    {
        try{
            var data = {
                class_id:$scope.commonobj.localStorage.classinfo.classid,
                section_id:$scope.commonobj.localStorage.classinfo.sectionid,
                subject_id:$scope.params.subjectid,
                studentlist:$scope.commonobj.localStorage.selectedstudentds,
                mode:$scope.commonobj.localStorage.classinfo.mode,
                role:$scope.commonobj.localStorage.userrole
            }
            
            $scope.commonobj.postrequest('getlessonplanbyapi',data).then(function(response){
                if(typeof response != 'undefined' && response && response.status == true)
                {
                    var findcurrentblinking = $filter('filter')(response.message,{bliking:true},true);
                    $scope.currentblinking = response.message.indexOf(findcurrentblinking[0]);
                    angular.forEach(response.message, function(value,key){
                        if(value.type == 'Video')
                        {
                            value.poster = "images/backimage.png";
                            var s = value.content.substring(value.content.lastIndexOf('/')+ 1);
                            $http.get("upload/content/"+$scope.commonobj.localStorage.classinfo.classname+"/"+$scope.params.subjectname+"/"+s.split('.')[0]+".png").then(function(r){
                                if(r.status == 200)
                                {
                                    value.poster = "upload/content/"+$scope.commonobj.localStorage.classinfo.classname+"/"+$scope.params.subjectname+"/"+s.split('.')[0]+".png"
                                }                                  
                            });
                        }
                    });
                    
                    $scope.templist = response.message;
                    var itemlength = $scope.templist.length;
                    
                    if($scope.commonobj.localStorage.classinfo.mode == 3 && $scope.commonobj.localStorage.userrole != 'g')
                    {
                        var current_page_blink = ($scope.currentblinking + 1)/ $scope.limit;
                        if(Math.ceil(current_page_blink) >= 0)
                        {
                            $scope.page = Math.ceil(current_page_blink);

                            $scope.offset = ( ($scope.page - 1) * $scope.limit ) ;
                            $scope.current_page = $scope.offset + $scope.limit ;
                         
                        }
                    }
                    else{
                        $scope.page = 1;

                        $scope.offset = ( ($scope.page - 1) * $scope.limit ) ;
                        $scope.current_page = $scope.offset + $scope.limit ;
                    }

                    iteratorlesson()
                    $scope.loading = false;
                    $localStorage.lessonlist = $scope.lessonlist;
                }else if(typeof response != 'undefined' && response && response.status == false){
                    $localStorage.lessonlist = [];
                    $scope.lessonlist = [];
                    $scope.loading = false;

                }
            });
        }
        catch(e){
            console.log(e)
        }
    }

    function iteratorlesson()
    {
        try{
            $scope.lessonlist = $scope.templist;
        }
        catch(e)
        {
            console.log(e)
        }
    }

       
    $scope.previouslessons =function() 
    {
        if($scope.page > 0)
        {
            $scope.page -=  1;
            $scope.offset = ($scope.page < 0 ? 0 : (($scope.page -1) *  $scope.limit ));
            $scope.current_page = $scope.offset + $scope.limit;

            // if($scope.offset - $scope.current_page>=0)
            // {

            //      $scope.offset -= $scope.current_page; 
            // }
            // else{
            //     $scope.offset=0;

            // }
            // $scope.limit = 4;
        }
        else{
            $scope.offset = 0;  
            $scope.current_page = $scope.limit;  
        }
        iteratorlesson();
 
    }

    $scope.nextlessons = function()
    {
        if($scope.page >= 0)
        {
            $scope.page += 1;
            $scope.offset = ($scope.page < 0 ? 0 : (($scope.page -1) *  $scope.limit ));
            $scope.current_page = $scope.offset + $scope.limit;
      
        }
        if($scope.offset >= $scope.lessonlist.length)
        {
            $scope.offset = 0;  
            $scope.current_page = $scope.limit ;  
        }

        // if($scope.offset < $scope.lessonlist.length)
        // {
        //     $scope.offset += $scope.current_page;  
        //     $scope.limit +=  $scope.current_page; 
        // }

        // if($scope.offset >= $scope.lessonlist.length)
        // {
        //     $scope.offset = 0;  
        //     $scope.limit = $scope.current_page;  
        // }

        iteratorlesson();
    }
});

app.controller('lesson_ctrl',function($scope,learningCommon,$sce,$cookieStore,$route, $routeParams,$localStorage,$sessionStorage,$filter,$window,$location,$interval,$http){

    $scope.commonobj = learningCommon;
    $scope.params = $routeParams;
    $scope.sessionobj =  $scope.commonobj.getLocalStorage();
    $scope.loading = true;

    var myPlayer = null;
    var controller = this;
    controller.API = null;
    $scope.first_lesson = null;

    $scope.starttime = 0;
    $scope.nextclass = {};
    $scope.periodendtime = 0;
    $scope.type = $localStorage.userrole;
    $scope.autoPlay = 1;
    $scope.timetableindex = 0;
    $scope.breakoff = true;
    $scope.playlist = [];
    $scope.is_current_video_playing = true;
    $scope.lessonobj = {};
    $scope.nextclasscount = 0;
    $scope.minscreenduration = 10;
    $scope.lesson_message = "";
    $scope.makecurrentvideodisable = null;
    var playerInstance = jwplayer("video-container");
    
    // player config
    function playvideo()
    {
        try{
            if($scope.lessonobj.currentlesson.content != 'Video' && $scope.lessonobj.currentlesson.content != '')
            {
                console.log($scope.lessonobj.currentlesson.content);
                playerInstance.setup({
                    autostart:'true',
                    file: $scope.lessonobj.currentlesson.content,
                    name:$scope.lessonobj.currentlesson.name,
                    stretching: "exactfit",
                    width: "100%",
                    aspectratio: "24:10",
                    image: "",
                    events:{
                        onComplete: function() {
                            $scope.videocompeleted();
                        },
                        onPlay:function()
                        {
                            $scope.makecurrentvideodisable = null;
                            $scope.loading = false; 
                            $scope.is_current_video_playing = true;
                             $scope.starttime = 0;
                            if($scope.lessonobj.currentlesson.lesson_readed == false)
                            {
                                setInterval($scope.minscreenduration); // start timer
                            } 
                         
                        },
                        onPause:function()
                        {
                            //$scope.starttime =  $scope.starttime;
                        },
                        onError:function() {
                            stopplayer();
                            alert("Content not available");
                            $scope.makecurrentvideodisable = $scope.lessonobj.currentlesson.id;
                            enablecurrentlessons();
                            $scope.lessonobj.currentlesson = $scope.lessonobj.next;
                            setvalues();
                            $("#myModal").modal('hide');
                        }
                    }
                });
            
                $("#myModal").modal();
            }
        }
        catch(e){
            console.log(e)
        }
        
    }

    $scope.startvideo = function(videosrc)
    {
        try{
            $scope.starttime = 0;
            $scope.lessonobj.currentlesson = videosrc;
            $scope.breakoff = true;
            playvideo();
        }
        catch(e){
            console.log(e)
        }
    }

    $scope.showlessonlist = function()
    {
        try{
            $scope.starttime =  $scope.starttime;
            $scope.breakoff = !$scope.breakoff;
            stopplayer()
        }
        catch(e){
            console.log(e)
        }
    }


    $scope.videocompeleted = function() 
    {
        try{
            
            if($localStorage.userrole != 'g' &&  $scope.lessonobj.currentlesson.lesson_readed == false && $scope.starttime >= $scope.minscreenduration && $localStorage.selectedstudentds.length == 1)
            {
                savelessonread($scope.lessonobj.currentlesson.id);
            }
            if($localStorage.userrole != 'g' && $scope.lessonobj.currentlesson.lesson_readed == false && $scope.starttime >= $scope.minscreenduration && $localStorage.selectedstudentds.length > 1)
            {
                saveclassgroupstatus($scope.lessonobj.currentlesson.id);
            }

            if($localStorage.userrole != 'g' && $localStorage.classinfo.mode == 1){
                if($scope.lessonobj.currentlesson.lesson_readed == false && $scope.starttime >= $scope.minscreenduration)
                {
                    enablecurrentlessons();
                    $scope.lessonobj.currentlesson = $scope.lessonobj.next;
                    setvalues();
                }
                $("#myModal").modal('hide');
                $scope.breakoff = false;
                $scope.is_current_video_playing = false;
            }
        }
        catch(e){}
    };

    angular.element("#myModal").on("hidden.bs.modal", function () {
       
         stopplayer();
        if($scope.commonobj.localStorage.classinfo.mode != 1)
        {
            //window.history.back();
            window.location.href = "#!lessons/"+$scope.commonobj.localStorage.subjectinfo.subjectid+"/"+$scope.commonobj.localStorage.subjectinfo.subjectname;
            // $location.url("/lessons/"+$scope.commonobj.localStorage.subjectinfo.subjectid+"/"+$scope.commonobj.localStorage.subjectinfo.subjectname);
        }
    });
    
    $scope.changepage = function()
    {
        angular.element(".modal-backdrop").hide();
    }

    // save single student progress
    function savelessonread(lessonid)
    {
        try{
            var temp = [];
            angular.forEach($localStorage.selectedstudentds,function(value,key){
                var data = {
                    student_roll_no:value.roll_no,
                    lesson:lessonid,
                    lesson_read:1,
                    count:1
                }
                temp.push(data);
            });
           
            var senddata ={
                lesson_progress:temp,
                type:'a'
            }
            
            $scope.commonobj.postrequest('savestudentprogressbyapi',senddata).then(function(response){
                if(typeof response != 'undefined' && response && response.message != false)
                {
                    var temp = {
                        lessonid:lessonid
                    }
                    $localStorage.alreadyreadlesson.push(temp) ;
                }
            });
        }
        catch(e){}
    }

    // save multi student progress
    function saveclassgroupstatus(lessonid)
    {
        try{
            if($localStorage.selectedstudentds.length > 1)
            {
                var data = {
                    classid:$localStorage.classinfo.classid,
                    sectionid:$localStorage.classinfo.sectionid,
                    lessonid:lessonid,
                    studentlist:$localStorage.selectedstudentds
                }

                $scope.commonobj.postrequest('setclassgroupstatus',data).then(function(response){
                    if(typeof response != 'undefined' && response && response.status != false)
                    {
                        console.log(response)
                    }
                });
            }
        }
        catch(e){}
    }

    controller.changesource = function(API){
        $scope.loading = false;
    }

    function stopplayer()
    {
        if($scope.lessonobj.currentlesson.type == 'Video')
        {
            playerInstance.stop();
        }
    }
    
    
    angular.element(function(){
        try{

            $scope.$watch(function(){
                return $localStorage.classinfo;
            },
            function(newValue,oldValue){
                if(typeof newValue != 'undefined' && newValue)
                {
                    if($localStorage.userrole != 'g' && $scope.commonobj.localStorage.classinfo.mode == 1){

                getperiodstime();
            }
                    $scope.subjectarr = $localStorage.subjectinfo;
                    $scope.mode = $scope.commonobj.localStorage.classinfo.mode;
                }
            });

            $scope.$watch(function(){
                return $scope.periodendtime;
            },
            function(newValue,oldValue){
                if(typeof newValue != 'undefined' && newValue)
                {
                    moveToNextClass();
                }
            });

            $scope.$watch(function(){
                return $scope.nextclasscount;
            },
            function(newValue,oldValue){
                if(typeof newValue != 'undefined' && newValue)
                {
                    moveToNextClass();
                }
            });

            if($scope.params.lessonid)
            {
                var is_lesson_found = $filter('filter')($localStorage.lessonlist,{id:$scope.params.lessonid},true);
                if(is_lesson_found.length > 0)
                {
                    $scope.lessonobj.currentlesson = is_lesson_found[0];
                    if($scope.lessonobj.currentlesson.id)
                    {
                        if($scope.lessonobj.currentlesson.type != 'Video')
                        {
                            if($localStorage.userrole != 'g'){
                                setInterval($scope.minscreenduration);
                            }
                             $("#myModal").modal();
                        }
                        if($scope.lessonobj.currentlesson.type == 'Video')
                        {
                            playvideo();
                        }
                        $scope.loading = false; 
                        setvalues();
                    }    
                }
            }
        }
        catch(e)
        {
            console.log(e)
        }
    });

    function setInterval(slidetime)
    {
        var atimer = $interval(function(){
             $scope.starttime++;
             if ($scope.starttime >=slidetime) {
                if($localStorage.userrole != 'g'  && $localStorage.selectedstudentds.length == 1 && $scope.lessonobj.currentlesson.type == 'Image')
                {
                    savelessonread($scope.currentlesson);
                }
                if($localStorage.userrole != 'g' && $localStorage.selectedstudentds.length > 1 && $scope.lessonobj.currentlesson.type == 'Image')
                {
                    saveclassgroupstatus($scope.currentlesson);
                }
                $interval.cancel(atimer);
               // $scope.starttime = 0;
            }
        }, 1000);
    }
    
    function moveToNextClass()
    {
        try{
            var classcounter = $interval(function(){
                if($scope.periodendtime != null)
                {
                    $scope.periodendtime++;
                    var currenttime = moment();
                    var next_clas_end_time = moment($scope.nextclass.end_time);
                   
                    if(moment(currenttime).format("HH:mm") > moment(next_clas_end_time).format("HH:mm")){
                        $("#myModal").modal('hide');
                        stopplayer();
                        if($scope.commonobj.localStorage.classinfo.mode == 1)
                        {
                            $scope.loading = true;
                            $scope.periodendtime = null;
                            $scope.autoPlay = 0;
                            $route.reload();
                            //getperiodstime();
                            $scope.breakoff= false;
                        }
                        $interval.cancel(classcounter);
                    }
                }
                
            }, 20000);
        }
        catch(e)
        {
            console.log(e)
        }
    }


    function getperiodstime()
    {
        try{
            var senddata ={
                classid:$localStorage.classinfo.classid,
                sectionid:$localStorage.classinfo.sectionid,
            }
           
            $scope.commonobj.postrequest('getschedulebyrest',senddata).then(function(response){
                // todays lessons
                if(typeof response != 'undefined' && response && response.status == true && response.message == 'lessons found')
                {
                    delete $localStorage.periodlist;
                    delete $scope.commonobj.localStorage.periodlist;
                    $localStorage.periodlist = response.result ;
                    $scope.commonobj.localStorage.periodlist = response.result ;
                    calculatecurrentperiod();
                }else if(typeof response != 'undefined' && response && response.status == false && response.message == 'dasyisoff'){
                   
                    $scope.loading = false;
                    $scope.commonobj.localStorage.classinfo.mode = 3;
                    $location.url("/subjects");
                }
                else if(typeof response != 'undefined' && response && response.status == false && response.message == 'break'){
                    
                    delete $localStorage.periodlist;
                    delete $scope.commonobj.localStorage.periodlist;
                    $localStorage.periodlist = response.result ;
                    $scope.commonobj.localStorage.periodlist = response.result ;
                    calculatecurrentperiod();
                }
                else  if(typeof response != 'undefined' && response && response.status == false && response.message == 'no timetable')
                {
                    
                    $scope.loading = false;
                    $scope.breakoff = false;
                    $scope.lesson_message = "Timetable not schedule";
                }
            });
        }
        catch(e){
            console.log(e)
        }
    }

    function calculatecurrentperiod()
    {
        try{
            if($localStorage.periodlist)
            {
                $scope.no_period_found = false;
                angular.forEach($localStorage.periodlist, function(value,key){
                    if(value.currentperiod == true && $scope.commonobj.localStorage.classinfo.mode == 1)
                    {
                        $scope.breakoff = true;
                        $scope.timetableindex = key;
                        $scope.nextclass = value;
                        $scope.no_period_found = true;
                        $scope.lesson_message = "";
                        $scope.sessionobj.currentsessionperiod = value;
                        if($scope.commonobj.localStorage.classinfo.mode == 1)
                        {
                            getTodayLessons();
                        }
                    }
                });

                if($scope.no_period_found == false)
                {
                    $scope.nextclass = $localStorage.periodlist[$scope.timetableindex];
                    $scope.breakoff = false;
                    $scope.autoPlay = 0;
                    $scope.perioddetail = $localStorage.periodlist[$scope.timetableindex];
                    $scope.sessionobj.currentsessionperiod = $localStorage.periodlist[$scope.timetableindex];
                    $scope.lesson_message = "Next period: "+$scope.perioddetail.subject+" from "+ $filter('periodtime')($scope.perioddetail.start_time) +" to "+ $filter('periodtime')($scope.perioddetail.end_time);
                    getTodayLessons();
                }
            }
        }
        catch(e)
        {
            console.log(e)
        }
    }

    function shownextpersiodtime()
    {
        try{
            var currenttime = new Date();
            $scope.is_period_found = false;

            angular.forEach($localStorage.periodlist,function(value,key){
                var currenttime = moment();
                var periodtime = moment(value.start_time);
                
                if(moment(periodtime).format("hh:mm") > moment(currenttime).format("hh:mm")  && $scope.is_period_found == false){
                    //$scope.breakoff = true;
                    $scope.nextclass = value;
                    $scope.perioddetail = value;
                    $scope.is_period_found = true;
                }
            });
        }
        catch(e){}
    }

    function getServerTime()
    {
         try{
            $scope.commonobj.getrequest('getservertime',{}).then(function(response){
                if(response.status == true)
                {
                    $scope.servertime = moment(response.result);
                }
            });
        }
        catch(e){
            console.log(e)
        }

    }

    function periodstart()
    {
        try{
            var atimer = $interval(function(){
                $scope.nextclasscount++;
                if($scope.breakoff == false)
                {
                    getServerTime();
                }
                
                var currenttime = $scope.servertime;
                var next_class_start_time = moment($scope.nextclass.start_time);
                $scope.loading = false;
                if(moment(currenttime).format("HH:mm") >= moment(next_class_start_time).format("HH:mm") && $scope.autoPlay == 0){
                    $scope.autoPlay = 1;
                    $interval.cancel(atimer);
                    $scope.periodendtime = true;
                    delete $localStorage.lessonlist;
                    getperiodstime();
                    $scope.breakoff = true;
                    $scope.nextclasscount = 0;
                }
            }, 10000);
        }
        catch(e)
        {
            console.log(e)
        }
    }

    function enablecurrentlessons()
    {
        angular.forEach($scope.nextlcassinfo, function(value,key){
            if(value.id == $scope.lessonobj.currentlesson.id && $scope.makecurrentvideodisable == null)
            {
                $scope.nextlcassinfo[key].lesson_readed = true;
                $scope.nextlcassinfo[key].bliking = false;
                $scope.nextlcassinfo[key].disabled = false;
            }
            else  if(value.id == $scope.lessonobj.currentlesson.id && $scope.makecurrentvideodisable != null)
            {
                $scope.nextlcassinfo[key].lesson_readed = false;
                $scope.nextlcassinfo[key].bliking = false;
                $scope.nextlcassinfo[key].disabled = true;
            }

            if($scope.lessonobj.next.id == value.id)
            {
                $scope.nextlcassinfo[key].lesson_readed = false;
                $scope.nextlcassinfo[key].bliking = true;
                $scope.nextlcassinfo[key].disabled = false;
            }          
        });
    }

    function getTodayLessons()
    {
        try{
           var senddata ={
                classid:$localStorage.classinfo.classid,
                sectionid:$localStorage.classinfo.sectionid,
                currentdate: new Date(),
                studentlist:$localStorage.selectedstudentds,
                mode:$scope.commonobj.localStorage.classinfo.mode,
                status: 'r',
                subject:$scope.nextclass.subject_id
           }
          
            $scope.commonobj.postrequest('gettodaylessons',senddata).then(function(response){
                // todays lessons
                if(typeof response != 'undefined' && response && response.status == true && response.message != 'timefree')
                {
                    if(response.result.length > 0)
                    {
                        delete $localStorage.lessonlist;
                        $scope.message = "";
                        angular.forEach(response.result, function(value,key){
                            if(value.type == 'Video')
                            {
                                value.poster = "images/backimage.png";
                                var s = value.content.substring(value.content.lastIndexOf('/')+ 1);
                                
                                try{
                                    $http.get("upload/content/"+$localStorage.classinfo.classname+"/"+$scope.sessionobj.currentsessionperiod.subject+"/"+s.split('.')[0]+".png").then(function(r){
                                        if(r.status == 200)
                                        {
                                            value.poster = "upload/content/"+$localStorage.classinfo.classname+"/"+$scope.sessionobj.currentsessionperiod.subject+"/"+s.split('.')[0]+".png"
                                        }                                 
                                    });
                                }
                                catch(e){
                                     value.poster = "images/backimage.png";
                                }
                            }
                        });

                        if($scope.breakoff == true)
                        {
                           
                            $scope.nextlcassinfo = response.result;
                            $localStorage.lessonlist = response.result ;
                            
                        }

                        if($scope.breakoff == false)
                        {

                            $scope.nextlcassinfo = response.result;
                            $scope.loading = false;
                            periodstart();
                        }
                        // if($scope.autoPlay == 1)
                        // {
                            var first_readable_lesson = $filter('filter')(response.result,{lesson_readed: false},true);
                           
                            if(first_readable_lesson.length > 0 && $scope.breakoff == false)
                            {

                                 $scope.lessonobj.currentlesson = first_readable_lesson[0];
                                 $scope.lesson_index = findcurrentindex($scope.lessonobj.currentlesson);
                                 $scope.lesson_index = (typeof $scope.lesson_index == 'undefined' ? 0 : $scope.lesson_index);
                                 $scope.nextlcassinfo[( $scope.lesson_index)].disabled = true;
                                 $scope.nextlcassinfo[( $scope.lesson_index)].bliking = false;
                                shownextpersiodtime();
                                
                               
                            }
                            else if(first_readable_lesson.length > 0 && $scope.breakoff == true)
                            {

                                 $scope.lessonobj.currentlesson = first_readable_lesson[0];
                                 $scope.lesson_index = findcurrentindex($scope.lessonobj.currentlesson);
                                 $scope.nextlcassinfo[($scope.lesson_index <= 0 ? 0 : $scope.lesson_index)].disabled = false;
                                 $scope.nextlcassinfo[($scope.lesson_index <= 0 ? 0 : $scope.lesson_index)].bliking = true;
                              
                               
                            }
                            else{
                                $scope.lessonobj.currentlesson = response.result[0];
                                $scope.breakoff = false;
                               
                                $scope.loading = false;
                            }
                        //}
                        
                        if($scope.lessonobj.currentlesson.type == 'Video' && $scope.breakoff == true)
                        {
                            playvideo();
                            $scope.loading = false;
                            setvalues();
                            moveToNextClass(); 

                        }

                       
                         if( $scope.breakoff == true && $scope.lessonobj.currentlesson.type != 'Video'){
                            setInterval($scope.minscreenduration);
                            
                            $scope.loading = false;
                             $("#myModal").modal();
                             setvalues();
                             moveToNextClass(); 

                        }
                    }
                    else{
                         delete $localStorage.lessonlist;
                         $scope.loading = false;
                         $scope.breakoff = false;
                    }
                
                }

                if(typeof response != 'undefined' && response && response.status == false && response.message == 'timefree')
                {
                    $scope.commonobj.localStorage.classinfo.mode = 3;
                    $location.url("/subjects");
                }

                if(typeof response != 'undefined' && response && response.status == false && response.message == 'lessons not found')
                {
                    $scope.loading = false;
                    $scope.breakoff = false;
                    $scope.lesson_message = "Lessons not schedule";
                }

                if(typeof response != 'undefined' && response && response.status == false && response.message == 'break')
                {
                    $scope.loading = false;
                    $scope.message = "";
                    $localStorage.lessonlist = [];
                    $scope.lessonobj.currentlesson= [];
                    stopplayer();
                    shownextpersiodtime();
                    moveToNextClass();
                    $scope.lesson_message = "Next class will be";
                }

                if(typeof response != 'undefined' && response && response.status == false && response.message == 'daynotstarted')
                {
                    $scope.message = "";
                    $scope.loading = false;
                    $localStorage.lessonlist = [];
                }
            });
        }
        catch(e){
            console.log(e)
        }
    }

    function findlesson()
    {
        var is_lesson_found = $filter('filter')($localStorage.lessonlist,{id:$scope.lessonobj.currentlesson.id},true);
        if(is_lesson_found)
        {
            return is_lesson_found[0];
        }
        return false;
    }

    function lessonStatus(lessonid)
    {
        var is_lesson_found =  $filter('filter')($localStorage.alreadyreadlesson,{lessonid:lessonid},true);
        if(is_lesson_found.length > 0)
        {
            return false;
        }
        return true;
    }

    function findcurrentindex(objectarray)
    {
        try{
            return $localStorage.lessonlist.indexOf(objectarray);
        }
        catch(e){
            console.log("index not found")
        }
    }

    function setvalues()
    {
        try{
       
            if((findcurrentindex(findlesson()) - 1) >= 0)
            {
                 $scope.lessonobj.previous = $localStorage.lessonlist[findcurrentindex(findlesson()) - 1];
            }

            if((findcurrentindex(findlesson()) + 1) <= $localStorage.lessonlist.length)
            {
                $scope.lessonobj.next = $localStorage.lessonlist[findcurrentindex(findlesson()) + 1];
            }
        }
        catch(e){
            console.log("index not found")
        }
        
    }
});

app.controller('footer_ctrl',function($scope,learningCommon,$cookieStore,$route, $routeParams,$location,$window,$localStorage,$sessionStorage){

    $scope.commonobj = learningCommon;
    $scope.sessionobj =  $scope.commonobj.getLocalStorage();
    angular.element(function(){
       

        $scope.$watch(function(){
            return  $scope.commonobj.localStorage.classinfo;
        },function(newValue,oldValue){
            if(typeof newValue != 'undefined' && newValue)
            {
                 if(typeof $scope.commonobj.localStorage.classinfo != 'undefined' && $scope.commonobj.localStorage.classinfo)
                {
                    $scope.infotab = false;
                    $scope.classname = $scope.commonobj.localStorage.classinfo.classname;
                    $scope.sectionname = $scope.commonobj.localStorage.classinfo.sectionname;
                    
                    $scope.mode = (($scope.commonobj.localStorage.classinfo.mode == 2 || typeof $scope.commonobj.localStorage.classinfo.mode == 'undefined') ? 'Timetable-free is enabled':'Timetable Mode is on');
                }
                else{
                   $scope.infotab = true;
                }
            }
        });

        $scope.$watch(function(){
            return  $scope.commonobj.localStorage.subjectinfo;
        },function(newValue,oldValue){
            if(typeof newValue != 'undefined' && newValue)
            {
                if(typeof  $scope.commonobj.localStorage.subjectinfo != 'undefined' &&  $scope.commonobj.localStorage.subjectinfo)
                {
                    $scope.subject =  $scope.commonobj.localStorage.subjectinfo.subjectname;
                }
            }
        });

        $scope.$watch(function(){
            return  $scope.commonobj.localStorage.periodlist;
        },function(newValue,oldValue){
            if(typeof newValue != 'undefined' && newValue)
            {
                 if(typeof $scope.commonobj.localStorage.periodlist != 'undefined' && $scope.commonobj.localStorage.periodlist)
                    {
                         angular.forEach($scope.commonobj.localStorage.periodlist, function(value,key){
                            if(value.currentperiod == true)
                            {
                                $scope.subject = value.subject;
                            }
                        });
                    }
            }

        });
        

        
    })
    
     $scope.logout = function()
     {
        logout()
     }

    function logout()
    {
        try{
          
            $scope.commonobj.getrequest('applogout',{}).then(function(response){
                if(response.message == true)
                {
                    $cookieStore.remove('periodinfo');
                    $scope.commonobj.clearAllSession();
                    $window.location.href = 'applogin';
                }
            });
        }
        catch(e){}
    }
});

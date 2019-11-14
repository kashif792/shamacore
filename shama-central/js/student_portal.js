var app = angular.module("invantage", ["ngRoute","ngCookies","ngStorage","ngSanitize","ui.bootstrap",'ngTagsInput']);
app.config(function($routeProvider,$locationProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "./application/views/Students/index.php",
    })
    .when("/index2", {
        templateUrl : "./application/views/Students/index_second.php",
    })
    .when("/subjects", {
        templateUrl : "./application/views/Students/subjects.php",
    })
    .when("/lesson/:lessonid", {
        templateUrl : "./application/views/Students/lesson.php",
    })
    .when("/lesson/:lessonid/:modetype", {
        templateUrl : "./application/views/Students/lesson.php",
    })
    .when("/activities", {
        templateUrl : "./application/views/Students/activities.php",
    })
    .when("/lessons/:subjectid/:subjectname", {
        templateUrl : "./application/views/Students/lessons.php",
    });
});

app.filter('perioddate', function myDateFormat($filter){
    return function(text){
        var  tempdate= new Date(text);
        return $filter('date')(tempdate, "mediumDate");
    }
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

app.factory('learningCommon',function($http,$localStorage,$sessionStorage,$window,$q, $rootScope){
    try{
        var fac = {};
        fac.modes = [];
        fac.localStorage = $localStorage;
        fac.localStorage.lastactivity = null;
        fac.shama_hostname_url = 'http://localhost/shama_central/';

        fac.socketobj = new WebSocket('ws://192.168.1.2:8282');

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

        fac.getStudentDetail = function()
        {
            try{
                fac.postrequest('getStudentInfo',({key:'123456'})).then(function(response){
                    if(response != null && response.status == true)
                    {
                        fac.localStorage.studentinfo = response.message[0];
                    }
                });
            }
            catch(e){}
        }

        if(typeof fac.localStorage.studentinfo == 'undefined')
        {
            fac.getStudentDetail();
        }

        fac.clearAllSession = function()
        {
            delete fac.localStorage.studentinfo;
            delete fac.localStorage.subject;
            delete fac.localStorage.alreadyreadlesson;
            delete fac.localStorage.lessonlist;
            delete fac.localStorage.lastactivity;
        }

        fac.getLocalStorage = function()
        {
            return fac.localStorage;
        }

        return fac;
    }
    catch(e)
    {
        console.log(e)
    }
});


app.controller('index_ctrl',function($scope,learningCommon,$cookieStore,$localStorage,$sessionStorage,$filter,$http){
    $scope.commonobj = learningCommon;
   
    $scope.sessionobj =  $scope.commonobj.getLocalStorage();
    $scope.getStudentSubjectsLessons =function()
    {
        try{
            var data = {
                student_id:$scope.sessionobj.studentinfo.id,
                class_id:$scope.sessionobj.studentinfo.classserail,
                section_id:$scope.sessionobj.studentinfo.sectionserail,
                session:$scope.sessionobj.studentinfo.session,
                semester:$scope.sessionobj.studentinfo.semesterserail,
            }

            $scope.commonobj.postrequest('getstudentsubjectslesson',data).then(function(response)
            {
                if(response.status == true)
                {
                     angular.forEach(response.message, function(value,key){
                        value.subject_image = "images/backimage.png";
                        var file_location = "upload/content/"+$scope.sessionobj.studentinfo.class+"/subjects/"+value.subject+"_thumb.png";
                        $http.get(file_location).then(function(r){
                           if(r.status == 200)
                            {
                                value.subject_image = file_location;
                            }                                  
                        });
                    });
                    $scope.studentsubjectstatus = response.message;
                    $scope.commonobj.localStorage.subjectlessonlist = $scope.studentsubjectstatus;
                    $scope.loading = true;
                }
                else{
                     $scope.studentsubjectstatus = [];
                     $scope.loading = true;
                }
            });
        }
        catch(e){
            console.log(e)
        }
    }
     $scope.getStudentSubjectsLessons();
});

app.controller('subject_ctrl',function($scope,learningCommon,$cookieStore,$localStorage,$sessionStorage,$window,$filter,$http){
    $scope.intro = true;
    $scope.commonobj = learningCommon;
    $scope.sessionobj =  $scope.commonobj.getLocalStorage();

    var screenWidth = $window.innerWidth;

    if(screenWidth <= 768)
    {
        $scope.limit = 1;
    }

    if(screenWidth >= 769 && screenWidth <= 1024)
    {
        $scope.limit = 3;
    }

    if(screenWidth >= 1025 && screenWidth <= 1280)
    {
        $scope.limit = 4;
    }

    if(screenWidth >= 1281 && screenWidth <= 1366)
    {
        $scope.limit = 4;
    }

    if(screenWidth >= 1367 && screenWidth <= 1680)
    {
        $scope.limit = 4;
    }

    if(screenWidth >= 1681 && screenWidth <= 1920)
    {
        $scope.limit = 4;
    }

    $scope.current_page = 0;
    $scope.offset = 0;

    $scope.page = 1;

    getsubjectlist();

    function getsubjectlist()
    {
        try{
            var data = {
                class_id:$scope.sessionobj.studentinfo.classserail,
                section_id:$scope.sessionobj.studentinfo.sectionserail,
            }

            $scope.commonobj.postrequest('getsubjectlistbyclassapi',data).then(function(response)
            {
                if(typeof response != 'undefined' && response && response.status== true)
                {
                     angular.forEach(response.message, function(value,key){
                        value.subject_image = "images/backimage.png";
                        var file_location = "upload/content/"+$scope.sessionobj.studentinfo.class+"/subjects/"+value.subject_name+".png";
                        $http.get(file_location).then(function(r){
                           if(r.status == 200)
                            {
                                value.subject_image = file_location;
                            }                                  
                        });
                    });

                    $scope.templist = response.message;
                    var itemlength = $scope.templist.length;
                    
                    $scope.page = 1;
                    $scope.offset = ( ($scope.page - 1) * $scope.limit ) ;
                    $scope.current_page = $scope.offset + $scope.limit ;

                    iteratorlesson()

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

    function iteratorlesson()
    {
        try{
            $scope.subjects = $scope.templist;
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
        iteratorlesson();
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
        $scope.limit = 2;
    }

    if(screenWidth >= 1025 && screenWidth <= 1280)
    {
        $scope.limit = 2;
    }

    if(screenWidth >= 1281 && screenWidth <= 1366)
    {
        $scope.limit = 2;
    }

    if(screenWidth >= 1367 && screenWidth <= 1680)
    {
        $scope.limit = 2;
    }

    if(screenWidth >= 1681 && screenWidth <= 1920)
    {
        $scope.limit = 2;
    }

    $scope.current_page = 0;
    $scope.offset = 0;

    $scope.page = 1;

    $scope.currentblinking = 0;

    angular.element(function(){
        if(typeof $scope.params.subjectid != 'undefined' && $scope.params.subjectid)
        {
            var subject = {
                subjectserail:$scope.params.subjectid,
                subjectname:$scope.params.subjectname
            }
            $scope.commonobj.localStorage.subject = subject;
            $scope.sessionobj =  $scope.commonobj.getLocalStorage();
            getlessonslist();
        }
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
                class_id:$scope.sessionobj.studentinfo.classserail,
                section_id:$scope.sessionobj.studentinfo.sectionserail,
                subject_id:$scope.params.subjectid,
                singlestudent:$scope.sessionobj.studentinfo.id,
                mode:2,
                role:'t',
                type:'r'
            }

            $scope.commonobj.postrequest('getlessonplanbyapi',data).then(function(response){
                if(typeof response != 'undefined' && response && response.status == true)
                {
                    var findcurrentblinking = $filter('filter')(response.message,{bliking:true},true);
                    if(findcurrentblinking.length > 0)
                    {
                         $scope.currentblinking = response.message.indexOf(findcurrentblinking[0]);
                    }
                   
                    angular.forEach(response.message, function(value,key){
                        if(value.type == 'Video')
                        {
                            value.poster = "images/backimage.png";
                           var s = value.content.substring(value.content.lastIndexOf('/')+ 1);
                            var file_location = "upload/content/"+$scope.sessionobj.studentinfo.class+"/"+$scope.params.subjectname+"/"+s.split('.')[0]+".png";
                            $http.get(file_location).then(function(r){
                                if(r.status == 200)
                                {
                                    value.poster = file_location;
                                }                                  
                            });
                        }
                    });

                    $scope.templist = response.message;
                    var itemlength = $scope.templist.length;

                    var current_page_blink = ($scope.currentblinking + 1)/ $scope.limit;
                    if(Math.ceil(current_page_blink) >= 0)
                    {
                        $scope.page = Math.ceil(current_page_blink);
                        $scope.offset = ( ($scope.page - 1) * $scope.limit ) ;
                        $scope.current_page = $scope.offset + $scope.limit ;
                    }
                    else{
                        $scope.page = 1;
                        $scope.offset = ( ($scope.page - 1) * $scope.limit ) ;
                        $scope.current_page = $scope.offset + $scope.limit ;
                    }

                    iteratorlesson()
                    $scope.loading = false;
                    $scope.commonobj.localStorage.lessonlist = $scope.lessonlist;
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

    $scope.minscreenduration = 20;
    $scope.videopercent = 80;
    $scope.lesson_message = "";

    $scope.makecurrentvideodisable = null;

    var duration = 0;
    var playerInstance = jwplayer("video-container");

    function load_local_file($file)
    {
        try{
            $http.get($file,{"filename":$file}).then(function(r){
               if(r.status == 200)
               {
                    return true;
               }                                  
                return false;
            });
        }
        catch(e){
            console.log(e)
        }
    }

    // player config
    function playvideo()
    {
        try{
            if($scope.lessonobj.currentlesson.content != 'Video' && $scope.lessonobj.currentlesson.content != '')
            {
                var file_location = $scope.lessonobj.currentlesson.content;
                if($scope.commonobj.localStorage.shama_host)
                {
                    var split_file = file_location.split("/");
                    var file_name = $scope.commonobj.shama_hostname_url+"upload/content/"+$scope.sessionobj.studentinfo.class+"/"+$scope.sessionobj.studentinfo.subjectname+"/"+split_file[(split_file.length - 1)];
                    if(load_local_file(file_name))
                    {
                        file_location = file_name;
                    }
                }
                
                playerInstance.setup({
                    autostart:'true',
                    file: file_location,
                    name:$scope.lessonobj.currentlesson.name,
                    stretching: "exactfit",
                    width: "70%",
                    aspectratio: "16:8",
                    image: "",
                    controlbar:false,
                    events:{
                        onComplete: function() {
                             //$scope.videocompeleted();
                        },
                        onPlay:function()
                        {
                            duration = parseInt(playerInstance.getDuration());
                            playerInstance.controlbar = true;
                            $scope.makecurrentvideodisable = null;
                            $scope.loading = false; 
                            $scope.is_current_video_playing = true;
                            $scope.starttime = 0;
                            $scope.minscreenduration = parseInt((duration * $scope.videopercent)/100);
                            if($scope.lessonobj.currentlesson.lesson_readed == false)
                            {
                                setInterval($scope.minscreenduration); // start timer
                            } 
                        },
                        onPause:function()
                        {
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

    $scope.videocompeleted = function() 
    {
        try{
            if($scope.lessonobj.currentlesson.lesson_readed == false)
            {
                savelessonread();
            }
          
        }
        catch(e){}
    };

    function savelessonread()
    {
        try{
            var temp = [
                {
                    student_roll_no:$scope.sessionobj.studentinfo.roll_no,
                    lesson:$scope.lessonobj.currentlesson.id,
                    lesson_read:1,
                    count:1
                }
            ];

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

    angular.element("#myModal").on("hidden.bs.modal", function () {
        stopplayer();
        if($scope.params.lessonid && $scope.params.modetype)
        {
            window.location.href = "#!/";
        }
        else{
            window.location.href = "#!lessons/"+$scope.sessionobj.subject.subjectserail+"/"+$scope.sessionobj.subject.subjectname;            
        }
        
    });

    $scope.changepage = function()
    {
        angular.element(".modal-backdrop").hide();
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

            if($scope.params.lessonid && $scope.params.modetype)
            {
                var is_lesson_found = $filter('filter')($localStorage.subjectlessonlist,{id:$scope.params.lessonid},true);
                if(is_lesson_found.length > 0)
                {

                    $scope.lessonobj.currentlesson = is_lesson_found[0];
                    if($scope.lessonobj.currentlesson.id)
                    {
                        if($scope.lessonobj.currentlesson.type == 'Video')
                        {
                            playvideo();
                        }
                        $scope.loading = false; 
                    }    
                }
            }

            if($scope.params.lessonid && $scope.params.modetype != 'undefined')
            {
                var is_lesson_found = $filter('filter')($localStorage.lessonlist,{id:$scope.params.lessonid},true);
                if(is_lesson_found.length > 0)
                {

                    $scope.lessonobj.currentlesson = is_lesson_found[0];
                    if($scope.lessonobj.currentlesson.id)
                    {
                        if($scope.lessonobj.currentlesson.type == 'Video')
                        {
                            playvideo();
                        }
                        $scope.loading = false; 
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
                    savelessonread();
                $interval.cancel(atimer);
            }
        }, 1000);
    }
});

app.controller('activites_ctrl',function($scope,learningCommon,$sce,$cookieStore,$route, $routeParams,$localStorage,$sessionStorage,$filter,$window,$location,$interval,$http){

    $scope.commonobj = learningCommon;
    
    $scope.params = $routeParams;
    var duration = 0;

    $scope.minscreenduration = 0;
    $scope.videopercent = 80;
    $scope.playlist = [];
    $scope.currentactivityindex = 0;
    $scope.currentactivity = {};
    $scope.sessionobj =  $scope.commonobj.getLocalStorage();
    $scope.onpause = false;
    $scope.loading = false;
    var myPlayer = null;
    var controller = this;
    controller.API = null;
    $scope.activitesobj = {};

    var playerInstance = jwplayer("video-container");
    
    $scope.getActivityList = function()
    {
        try{
            var data = {
                class_id:$scope.sessionobj.studentinfo.classserail,
                section_id:$scope.sessionobj.studentinfo.sectionserail,
                student_id:$scope.sessionobj.studentinfo.id,
                type:'v',
                lastactivity:$scope.sessionobj.lastactivity
            }

            $scope.commonobj.postrequest('getactivities',data).then(function(response){
                if(typeof response != 'undefined' && response && response.status == true)
                {
                    $scope.activitesobj = response.message[0];
                    setPlaylist($scope.activitesobj.links);
                    setCurrentActivity();
                    $scope.sessionobj.lastactivity = $scope.activitesobj.id;
                    playerInstance.remove();
                    playActivity();

                }else{
                    $scope.activitesobj = {};
                     window.location.href = "#!/";
                }
            });
        }
        catch(e){
            console.log(e)
        }
    }

    $scope.getActivityList();
    
    angular.element("#myModal").on("hidden.bs.modal", function () {
         stopplayer();
        window.location.href = "#!/";
    });

    function playActivity()
    {
        $scope.loading = false;
        if($scope.currentactivity.type == 'g')
            {
                if($scope.currentactivity.source == 'e')
                {
                     $window.location.href = $scope.currentactivity.link;
                }
                else{
                    $scope.starttime = 0;
                    $scope.loading = false; 
                    saveactivityprogress();
                    $("#myModal").modal();
                }
            }
             else if($scope.currentactivity.type == 'i'){
                if($scope.currentactivity.source == 'e')
                {
                     $window.location.href = $scope.currentactivity.link;
                }
                else{
                   $scope.starttime = 0;
                    $scope.loading = false; 
                    saveactivityprogress();
                    $("#myModal").modal();
                }
            }
            else{
                if($scope.currentactivity.source == 'e')
                {
                     $window.location.href = $scope.currentactivity.link;
                }
                else{
                   playvideo();
                }
            }
    }

    function stopplayer()
    {
        playerInstance.stop();
    }

    // player config
    function playvideo()
    {
        try{
            var file_location = $scope.currentactivity.link;
            $("#myModal").modal();
            playerInstance.setup({
                autostart:'true',
                file: file_location,
                name:$scope.activitesobj.title,
                stretching: "exactfit",
                width: "70%",
                aspectratio: "16:8",
                image: "",
                controlbar:false,
                events:{
                    onComplete: function() {
                        $scope.videocompeleted();
                    },
                    onPlay:function()
                    {

                        duration = parseInt(playerInstance.getDuration());
                        $scope.starttime = 0;
                        $scope.loading = false; 
                        saveactivityprogress();
                        $scope.minscreenduration = parseInt((duration * $scope.videopercent)/100);
                        setInterval($scope.minscreenduration); // start timer
                    },
                    onPause:function()
                    {
                        $scope.onpause = false;
                    },
                    onError:function() {
                        stopplayer();
                        alert("Content not available");
                    }
                }
            });
            
            
        }
        catch(e){
            console.log(e)
        }
    }

    function setInterval(slidetime)
    {
        var atimer = $interval(function(){
             $scope.starttime++;
             if ($scope.starttime >=slidetime) {
                   // saveactivityprogress();
                $interval.cancel(atimer);
            }
        }, 1000);
    }

    $scope.videocompeleted = function() 
    {
        try{
            moveToNext();
        }
        catch(e){}
    };

    // save single student progress
    function saveactivityprogress()
    {
        try{

            var senddata ={
                student_id:$scope.sessionobj.studentinfo.id,
                activityid:$scope.activitesobj.id,
                activity_iteration:$scope.activitesobj.count,
            }

            $scope.commonobj.postrequest('saveactivityprogress',senddata).then(function(response){
                if(response.status == true)
                {
                    
                }
            });
        }
        catch(e){}
    }

    function setCurrentActivity()
    {
        try{
            if($scope.currentactivityindex == 0)
               $scope.currentactivity = $scope.playlist[$scope.currentactivityindex];
            if(($scope.playlist.length - 1) <= $scope.currentactivityindex)
                $scope.currentactivity = $scope.playlist[$scope.currentactivityindex];
        }
        catch(e){
            console.log("index not found")
        }
    }

    function setPlaylist(playlist)
    {
        $scope.playlist = playlist;
    }

    function getCurrentIndex()
    {
         return $scope.playlist.indexOf(i => i.id == $scope.currentactivity.id);
    }

    function moveToNext()
    {
        $scope.currentactivityindex++;
        setCurrentActivity();
        playActivity();
    }

    $scope.previousactivity = function()
    {
        $scope.currentactivityindex--;
        setCurrentActivity();
        playActivity();
    }

    $scope.nextlactivity = function()
    {
         $scope.currentactivityindex++;
        setCurrentActivity();
        playActivity();
    }
});

app.controller('footer_ctrl',function($scope,learningCommon,$cookieStore,$route, $routeParams,$location,$window,$localStorage,$sessionStorage){

    $scope.commonobj = learningCommon;
    $scope.sessionobj =  $scope.commonobj.getLocalStorage();

    $scope.dynamicPopover = {
        content: 'Hello, World!',
        templateUrl: 'myPopoverTemplate.html',
        title: 'Title'
    };

     $scope.logout = function()
     {
        logout()
     }

    function logout()
    {
        try{
          
            $scope.commonobj.getrequest('stdapplogout',{}).then(function(response){
                if(response.message == true)
                {
                    $scope.commonobj.clearAllSession();
                    $window.location.href = 'stdapplogin';
                }
            });
        }
        catch(e){}
    }


});

function showDiv() {
   document.getElementById('student_info').style.display = "block";
}
app.directive('contenteditable', ['$sce', function($sce) {
    return {
        restrict: 'A', // only activate on element attribute
        require: '?ngModel', // get a hold of NgModelController
    link: function(scope, element, attrs, ngModel) {
      if (!ngModel) return; // do nothing if no ng-model

      // Specify how UI should be updated
      ngModel.$render = function() {
        element.html($sce.getTrustedHtml(ngModel.$viewValue || ''));
      };

      // Listen for change events to enable binding
      element.on('blur keyup change', function() {
        scope.$evalAsync(read);
      });
      read(); // initialize

      // Write data to the model
      function read() {
        var html = element.html();
        // When we clear the content editable the browser leaves a <br> behind
        // If strip-br attribute is provided then we strip this out
        if ( attrs.stripBr && html == '<br>' ) {
          //html = '';
        }
        ngModel.$setViewValue(html);
      }
    }
  };
}]);

app.controller('message_ctrl',message_ctrl);
function message_ctrl($scope,learningCommon,$cookieStore,$route, $routeParams,$location,$window,$localStorage,$sessionStorage){

    let ms = this;
    ms.commonobj = learningCommon;
    ms.ws = ms.commonobj.socketobj;
    ms.sessionobj =  ms.commonobj.getLocalStorage();

    ms.chatmode = 'recent';
    ms.messageobj = {};
    ms.messageobj.text = '';
    ms.classstudents = [];
    ms.recentmessages = [];

    ms.singe_chat = function()
    {
        ms.recentmessagemode = !ms.recentmessagemode;
    }

    ms.hide_chat = function()
    {
        //hide_chat_container=true;
        ms.hide_chat_container = !ms.hide_chat_container;
    }

    ms.viewdetail = function(c)
    {
        try{
            ms.recentmessagemode = !ms.recentmessagemode;
        }
        catch(e){}
    }

    ms.getStudentList = function()
    {
        try{
            var data = {
                classid:ms.sessionobj.studentinfo.classserail,
                sectionid:ms.sessionobj.studentinfo.sectionserail,
                semesterid:ms.sessionobj.studentinfo.semesterserail,
                student_id:ms.sessionobj.studentinfo.id,
            }
            ms.commonobj.postrequest('getstudentlist',(data)).then(function(response){
                if(response.status == true)
                {
                    ms.classstudents = response.message;
                }
                else{
                    ms.classstudents = [];
                }
            });
        }
        catch(e){}
    }

    ms.getStudentList();

    ms.newmessage = function()
    {
         
        ms.messageobj.text = '';
        ms.chatmode = 'group';
    }

    ms.loadFriends = function($query) {
        return ms.classstudents.filter(function(friend) {
            return friend.name.toLowerCase().indexOf($query.toLowerCase()) != -1;
        });
    };

    ms.checkIfEnterKeyWasPressed = function($event){
    var keyCode = $event.which || $event.keyCode;
        if (keyCode === 13) {
        }

      };
    
   
    ms.conversation = [];
 
   
    var client = {
        user_id:parseInt(ms.sessionobj.studentinfo.id),
        recipient_id: null,
        message: null,
        broadcast:false
    };
        
       

    ms.ws.onmessage = function(message) {
        try {
           var res = JSON.parse(message.data);
            if(res.message != null && res.message.length > 0)
            {
              ms.conversation.push(res);
              $scope.$apply();
            }
            
        } catch(e) {}
    };

    ms.ws.onerror = function(event) {
        console.log('connection Error', event);
    };

    ms.ws.onclose = function(event) {
        console.log('connection closed', event);
    };

    ms.ws.onopen = function(event) {
        ms.ws.send(JSON.stringify(client));
        console.log('connection open' ,event);
    };

   
    ms.sendtext = function(m)
    {
        try{
          var friend = m.friends.map(f=> f.id);
          if(friend.length > 0)
          {
            
            client.message = m.text.trim();
            client.recipient_id = parseInt(friend[0]);
            ms.ws.send(JSON.stringify(client));
             var temp = {
                user_id:parseInt(ms.sessionobj.studentinfo.id),
                recipient_id: parseInt(friend[0]),
                message: m.text.trim()
            };
            ms.conversation.push(temp);
            ms.messageobj.text = '';
          } 
        }
        catch(e){
             console.log(e);
        }
    }
};

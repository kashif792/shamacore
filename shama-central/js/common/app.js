var app = angular.module('invantage',['ngStorage','daterangepicker','ui.bootstrap']);

app.service('inputfilters',function($http,$q){
	return({
		department:department,
		category:category,
		vendor:vendor
	})

	function department(url)
	{
		var request = $http({
			method:'get',
			url:url,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}
	
	function category(url)
	{
		var request = $http({
			method:'get',
			url:url,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function vendor(url)
	{
		var request = $http({
			method:'get',
			url:url,
			headers : {'Accept' : 'application/json'}
		});
		return (request.then(responseSuccess,responseFail))
	}

	function responseSuccess(response){
		return (response.data);
	}

	function responseFail(response){
		if (! angular.isObject( response.data ) || ! response.data.message) {
            return( $q.reject( "An unknown error occurred." ) );
        }
        // Otherwise, use expected error message.
        return( $q.reject( response.data.message ) );
	}
})


app.factory('$myUtils',function($http,$localStorage,$sessionStorage){

    var fac = {};

    fac.storage = $localStorage;

    console.log("Factory Storage",fac.storage);

    fac.checkUserAuthenticated = function(){

    	if(fac.storage.userData != null && fac.storage.userData.id != null && fac.storage.userData.id.length > 0){
    		return true;
    	}else{
    		window.location = window.base_url;
    		return false;
    	}

    }

    fac.getUserId = function(){

	    return $localStorage.userData.id;
    }

    fac.getUserType = function(){

	    return $localStorage.userData.type;
    }
    
    fac.setUserName = function(str){
    	$localStorage.userData.name = str;
    }

    fac.getUserName = function(){

	    return $localStorage.userData.name;

    }

    fac.setUserProfileImage = function(str){
    	$localStorage.userData.profile_image = str;
    }
    
    fac.getUserProfileImage = function(){

	    return $localStorage.userData.profile_image;
	    
    }


    fac.getUserProfileThumb = function(){

	    return $localStorage.userData.profile_thumb;

    }

    fac.setUserEmail = function(str){
    	$localStorage.userData.email = str;
    }
    
    fac.getUserEmail = function(){

	    return $localStorage.userData.email;

    }


    fac.isAdmin = function(){
    	
    	var res = false;

	    if(null!=$localStorage.userData.type && $localStorage.userData.type.length && $localStorage.userData.type == 's' && $localStorage.userData.roles.length>0 && $localStorage.userData.roles[0].role_id == 1){
	    		res = true;
	    }

	    return res;

    }

    fac.isPrincipal = function(){
    	
    	var res = false;

	    if(null!=$localStorage.userData.type && $localStorage.userData.type.length){
	    	if($localStorage.userData.type == 'p'){
	    		res = true;
	    	}else if($localStorage.userData.type == 't' && $localStorage.userData.is_master_teacher == '1'){
	    		res = true;
	    	}
	    }

	    return res;
    }


    fac.isTeacher = function(){
    	
    	var res = false;

	    if(null!=$localStorage.userData.type && $localStorage.userData.type.length && $localStorage.userData.type == 't'){
	    		res = true;
	    }

	    return res;

    }

    fac.isStudent = function(){
    	
    	var res = false;

	    if(null!=$localStorage.userData.type && $localStorage.userData.type.length && $localStorage.userData.type == 's' && $localStorage.userData.roles.length>0 && $localStorage.userData.roles[0].role_id == 5){
	    		res = true;
	    }

	    return res;
    }


    fac.isParent = function(){
    	
    	var res = false;

	    if($localStorage.userData.roles.length>0 && $localStorage.userData.roles[0].role_id == 6){
	    		res = true;
	    }

	    return res;

    }

    fac.getUserDefaultRoleId = function(){

	    if($localStorage.userData.roles.length){
	    	return $localStorage.userData.roles[0].role_id;
	    }
	    return false;

    }

    fac.getUserDefaultRoleType = function(){

	    if($localStorage.userData.roles.length){
	    	return $localStorage.userData.roles[0].type;
	    }
	    return false;
	    
    }


    fac.getDefaultSchoolId = function(){

	    return $localStorage.userData.default_school_id;
    }


    fac.setDefaultSessionId = function(new_session_id){

	    $localStorage.userData.default_session_id = new_session_id;
	    
    }

    fac.getDefaultSessionId = function(){

	    return $localStorage.userData.default_session_id;
    }


    fac.getUserRoles = function(){

	    return $localStorage.userData.roles;

    }


    fac.getUserLocations = function(){

	    return $localStorage.userData.locations;

    }


    fac.showSchoolWizard = function(){
	    return $localStorage.userData.show_school_wizard;
	}
	
	// get all sessions of loggedin user school
    fac.getSessionList = function () {
	    return $localStorage.sessionList;
    }
	
	// get all grades of loggedin user school
    fac.getGradeList = function () {
	    return $localStorage.gradeList;
	}
	
	// get all semester of loggedin user school
	fac.getSemesterList = function () {
		return $localStorage.semesterList;
	}

	// get active semester of loggedin user
	fac.getActiveSemester = function () {
		return $localStorage.active_semester;
	}

	// get active session of loggedin user
	fac.getActiveSession = function () {
		return $localStorage.active_session;
	}


    fac.httprequest = function(url,data)
    {

        var request = $http({

            method:'get',

            url:url,

            params:data,

            headers : {'Accept' : 'application/json'}

        });

        return (request.then(responseSuccess,responseFail))

    }



    fac.httppostrequest = function(url,data)
    {

        var request = $http({

            method:'POST',

            url:url,

            data:data,

            headers : {'Accept' : 'application/json'}

        });

        return (request.then(responseSuccess,responseFail))

    }


    fac.httpdeleterequest = function(url,data)
    {

        var request = $http({

            method:'DELETE',

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



    fac.clearSession = function()
    {
        delete fac.storage.userData;
    }



    fac.getLocalStorage = function()
    {

        return fac.storage;

    }

    return fac;
});


app.filter('periodtime', function myDateFormat($filter){
    return function(text){
        var  tempdate= new Date(text);
        return $filter('date')(tempdate, "medium");
    }
});

app.directive('inputTitleValidation',function(){
        return {
            require: 'ngModel',
            link: function(scope, elm, attrs, ctrl) {
                elm.on('blur',function(e){
                    scope.$apply(function(){
                        if (!ctrl || !elm.val()) return;
                        if (elm.val().length > 3) {
                            ctrl.$setValidity('title_validation', true);
                            return true;
                        }
                        ctrl.$setValidity('title_validation', false);
                        return false;
                    });
                });
            }
        }
});
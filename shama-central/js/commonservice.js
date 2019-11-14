var app = angular.module("invantage", ['daterangepicker','isteven-multi-select','datatables','ngMessages','ui.bootstrap','ngTagsInput','angularjs-dropdown-multiselect', 'datatables.columnfilter']);

app.directive('inputTitleValidation',function(){
    return {
        require: 'ngModel',
        link: function(scope, elm, attrs, ctrl) {
            elm.on('blur',function(e){
                scope.$apply(function(){
                    if (!ctrl || !elm.val()) return;
                    if (elm.val().length >= 3) {
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

app.filter('perioddate', function myDateFormat($filter){

  return function(text){

    var  tempdate= new Date(text);

    return $filter('date')(tempdate, "LL");

  }

});
app.factory('commonservice',function($http){
    var fac = {};

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

    return fac;

});

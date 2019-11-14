<?php
// require_header
require APPPATH.'views/__layout/header.php';

// require_top_navigation
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation
require APPPATH.'views/__layout/leftnavigation.php';
?>
<div class="col-sm-10 col-md-10 col-lg-10 class-page "  ng-controller="evaluation_ctrl" ng-init="evalutionfinished = false;">
    <?php
        // require_footer
        require APPPATH.'views/__layout/filterlayout.php';
    ?>
    <div class="loading" ng-hide="evalutionfinished" ></div>
    <div class="">
        <div class="row">

            <div class="col-sm-12">
                <div class="panel panel-default">
                    <!-- widget title -->
                    <div class="panel-heading">
                        <label>Grade Evaluation Percentage</label>
                    </div>
                    <div class="panel-body">
                        <div class="form-container">
                            <div class="row" ng-hide="show_error">
                                <div class="col-sm-12">
                                    <p style="color: red;">Please enter value in all fields and filed sum should be equal to 100.</p>
                                </div>
                            </div>
                            <form class="form-horizontal" name="form"  ng-submit="save()" novalidate>
                                <div class="form-group" ng-repeat="e in evalution">
                                    <label class="control-label col-sm-2" for="e.title">{{e.title}}: <span class="required">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" id ="e.title" ng-model="e.percent" ng-keyup="calculate()" ng-blur="calculate()">
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <div class="col-sm-offset-2 col-sm-10">
                                       <button type="button" class="btn btn-default" ng-click="toogleform(is_form_toggle)">Cancel</button>
                                        <button type="submit" ng-init="usersavebtntext = 'Save';"   class="btn btn-primary">
                                            <span ng-show="usersavebtntext == 'Saving'">
                                                <i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>
                                            </span>
                                            {{usersavebtntext}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// require_footer
require APPPATH.'views/__layout/footer.php';
?>

<script type="text/javascript">
	var app = angular.module('invantage', []);
	app.controller('evaluation_ctrl', function($scope, $http,$filter){
        
        $scope.evalution = [];
        $scope.show_error = true;
        $scope.formula = function()
        {
            try{
                $scope.total_percent = null;
                for (var i = $scope.evalution.length - 1; i >= 0; i--) {
                    $scope.total_percent += $scope.evalution[i].percent;
                }
            }
            catch(e)
            {
                console.log(e)
            }
        }

        $scope.getevalution = function()
        {
            try{
                httprequest('getevalution',{}).then(function(response){
                    if(response.length > 0)
                    {
                        $scope.evalution = response;
                        $scope.evalutionfinished = true;
                        $scope.formula();
                    }
                });
            }   
            catch(e)
            {
                console.log(e)
            }
            
        }
        $scope.getevalution();

        $scope.calculate = function()
        {
             $scope.formula();
        }

        $scope.save = function()
        {
            try{

                if($scope.total_percent == 100)
                {
                    $scope.show_error = true;
                    var data = {
                        data:$scope.evalution
                    }
                    $scope.usersavebtntext = "Saving";
                    httppostrequest('saveformula',data).then(function(response){
                        if(response.message == true)
                        {
                             $scope.usersavebtntext = "Save";
                            message('Evaluation formula saved','show');
                        }
                        else{
                             $scope.usersavebtntext = "Save";
                            message('Evaluation formula not saved','show');
                        }
                    });
                }else{
                    $scope.show_error = false;
                }
            }   
            catch(e)
            {
                console.log(e)
            }
        }

     	function httprequest(url,data)
        {
            var request = $http({
                method:'get',
                url:url,
                params:data,
                headers : {'Accept' : 'application/json'}
            });
            return (request.then(responseSuccess,responseFail))
        }

        function httppostrequest(url,data)
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

	});
</script>

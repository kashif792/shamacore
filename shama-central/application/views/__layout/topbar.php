<!-- header -->
<nav class="navbar navbar-default">
	<div class="container-fluid" ng-controller="navCtrl">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
	          <span class="sr-only">Toggle navigation</span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </button>
            
  			<a class="navbar-brand" href="{{baseUrl}}{{roles[0].role_id == 4 ? 'teacherdashboard':'dashboard'}}">
				<img src="<?php echo base_url(); ?>images/logo.png" alt="Citadel Insight">
			</a>
		</div>
		<div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" aria-expanded="true">

  			<ul class="nav navbar-nav navbar-right">

		        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" id="topbar_username">{{name}}
                    <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-content">
                                <div class="row">
                                    <div class="col-md-5">
                                        <!-- 
										<img id="user_avatar" ng-if="profileThumb!=null" src='{{profileThumb}}' class="img-responsive img-circle"/>
                                        -->

                                		<img id="user_avatar" alt="User Image" class="img-responsive img-circle" />

										
                                        <p class="text-center small">
                                            <a href="{{baseUrl}}profile#settings1">Change Photo</a></p>
                                    </div>
                                    <div class="col-md-7">
                                        <span id="dropdown_username">{{name}}</span>
                                        
                                        <p class="text-muted small" id="dropdown_email">{{email}}</p>
                                        
                                        <p>{{roleStr}}</p>

                                        <div class="divider">
                                        </div>
                                        
                                        <a href="{{baseUrl}}profile#settings1" class="btn btn-primary btn-sm active">View Profile</a>

                                    </div>
                                </div>
                            </div>
                            <div class="navbar-footer">
                                <div class="navbar-footer-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{baseUrl}}profile#settings2" class="btn btn-default btn-sm">Change Password</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="#" id='logout' class="btn btn-default btn-sm pull-right">Sign Out</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
			</ul>
		</div>
	</div>

    <script>

    app.controller('navCtrl', function($scope, $myUtils){

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

        $scope.profileImage = null;
        if($myUtils.getUserProfileImage()){
            $scope.profileImage = $myUtils.getUserProfileImage();
        }

        $scope.profileThumb = null;
        if($myUtils.getUserProfileThumb()){
            $scope.profileThumb = $myUtils.getUserProfileThumb();
        }

        if($scope.profileThumb!=null){
            $("#user_avatar").attr("src",$scope.profileThumb);
        }else if($scope.profileImage!=null){
            $("#user_avatar").attr("src",$scope.profileImage);
        }
        
        $scope.roles = $myUtils.getUserRoles();
        
        $scope.schoolName = '';
        if($myUtils.getUserLocations().length){
            $scope.schoolName = $myUtils.getUserLocations()[0].schoolname;
        }

        $scope.type = $myUtils.getUserType();

        var rolesStr = '';
        
        for(var loop=0; loop<$scope.roles.length; loop++){
            var role = $scope.roles[loop];
            rolesStr += role.type
            if($scope.schoolName!=null && $scope.schoolName.length>0){
                rolesStr += " (" + $scope.schoolName + ")";
            }
        }

        $scope.roleStr = rolesStr;
                   

        $(document).on('click','#logout',function(){
            console.log('logout');
              $myUtils.clearSession();
              $myUtils.checkUserAuthenticated();
        });             

      });
    </script>
</nav>

<!DOCTYPE html>
<html lang="en" ng-app="invantage">
<head>
	<title>Shama Web App</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap_4.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/webapp_style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fontello.css">
	<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>js/angular-1.6.4.min.js"></script>
	<script src="<?php echo base_url(); ?>js/angular-animate.1.6.4.min.js"></script>
	<script src="<?php echo base_url(); ?>js/angular-sanitize.1.6.4.min.js"></script>
	<script src="<?php echo base_url(); ?>js/angular-route.js"></script>
	<script src="<?php echo base_url(); ?>js/angular-cookies.js"></script>
	<script src="<?php echo base_url(); ?>js/ngStorage.min.js"></script>
	
</head>
<body>
<div class="container-fluid text-center  pt-3  attendance">  
	<div id="overlay"></div>  
	<div class="row">
		<div class="col-sm">
			<!-- Upper row--> 
			<div class="row">
				<div class="col-sm text-left">
					
	  				<span>
	        			<?php 
	          				if($profile_image){
	        			?>
	           				<div class="image-container" style="background: url(<?php echo $profile_image; ?>) no-repeat"></div>
									<div class="name-container ml-2 pt-3">
	            		<p class="user-name d-inline"> <?php echo $name; ?> | </p>
	            		<a href="javascript:void(0)" ng-controller="footer_ctrl" ng-click="logout()" class="text-white">Logout</a>
									</div>
	          			<?php 
	          				}
	           				else{
	        			?>
	             		<img src="images/img_avatar.png" alt="Avatar" width="50" class="rounded-circle">
	            		<p class="user-name d-inline"> <?php echo $name; ?> | </p>
	            		<a href="javascript:void(0)" ng-controller="footer_ctrl" ng-click="logout()" class="text-white">Logout</a>
	            		<?php
	          				}
	        			?>
	        			
	  				</span>
	  				<div class="col-sm d-inline mt-5 ml-5 pl-3 class-info" ng-controller="footer_ctrl" ng-hide="infotab">
	  				<ul class="list-inline class-info-list ml-2">
	    				<li class="list-inline-item ml-2 mt-2">
	      					<p>{{mode}}</p>
	      					<p><span ng-if="classname">Grade: {{classname}}</span> <span ng-if="sectionname">({{sectionname}})</span></p>
	      					<p ng-if="subject">Subject: {{subject}}</p>
	    				</li>
	  				</ul>
				</div>
				</div>
				<div class="col-sm text-right img_sty">
				<img src="/shamacentral/v1.1/images/nrlogo.png" class="web_app_logo">
				</div>
			</div>
			<div ng-view ></div>

	 	</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>js/video.js"></script>
<script src="<?php echo base_url(); ?>js/webapp.js"></script>
<script src="<?php echo base_url(); ?>js/angular-sanitize.min.js"></script>
<script src="<?php echo base_url(); ?>js/videogular.js"></script>
<script src="<?php echo base_url(); ?>js/vg-controls.min.js"></script>
<script src="<?php echo base_url(); ?>js/vg-overlay-play.min.js"></script>
<script src="<?php echo base_url(); ?>js/vg-poster.min.js"></script>
<script src="<?php echo base_url(); ?>js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap_4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/moment-timezone.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jwplayer.js"></script>
<script>jwplayer.key="/JmQcOJTGP/OIWIzj4RXqX/gpB1mVD9Br1vyxg==";</script>
</body>
</html>

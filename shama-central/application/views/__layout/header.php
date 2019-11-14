<?php
	if($this->uri->segment(3)){
		$path_url =  '../../../';
  		$uri = '../../../';
	}
	else if($this->uri->segment(2)){
		$path_url =  '../';
  		$uri = '../';
	}
	else{
  		$path_url =  '';
  		$uri = '';
  	}	
?>
<!DOCTYPE html>
<html ng-app="invantage">
<head>
	<title>Shama</title>
    <link rel="icon" href="<?php echo base_url(); ?>/favicon.png">
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.ui.timepicker.css?v=0.3.3">
	<!-- 
	<link rel="stylesheet" href="<?php echo base_url(); ?>js/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css" /> -->

	

	<!-- Jquery Date picker -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css"> 
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-confirm.min.css">
  
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/fontello.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,700,500italic,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/angular-datatables.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.dataTables.min.css">
  	<link rel="stylesheet" href="<?php echo base_url(); ?>css/nbootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/daterangepicker.css" />


	
	<link href="<?php echo base_url(); ?>css/easy-responsive-tabs.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/intlTelInput.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/left_side.css">

	<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery-ui-1.12.1.custom/jquery-ui.theme.min.css" type="text/css" />
	<script src="<?php echo base_url(); ?>js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	
	<script src="<?php echo base_url(); ?>js/31dc09d75d.js"></script>

	<script src="<?php echo base_url(); ?>js/angular.min.js"></script>

	<script src="<?php echo base_url(); ?>js/angular-md5.js"></script>

    <script src="<?php echo base_url(); ?>js/ngStorage.min.js"></script>
	
	<!-- <script data-require="ui-bootstrap@*" data-semver="0.12.1" src="<?php echo  base_url(); ?>js/ui-bootstrap-tpls-0.12.1.min.js"></script> -->

	<script src="<?php echo  base_url(); ?>js/ui-bootstrap-tpls-2.5.0.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/insight.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/moment.js"></script>



<!-- End of JS and style scripts -->

<script type="text/javascript">

	// To be used in JS and Angular JS
	var base_url = "<?php echo base_url(); ?>";

	function getUrlVars(){
    	var vars = [], hash;
	    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	    for(var i = 0; i < hashes.length; i++)
	    {
	        hash = hashes[i].split('=');
	        vars.push(hash[0]);
	        vars[hash[0]] = hash[1];
	    }
	   	return vars;		
	}
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
		$(".loader-container").fadeOut();

	});
	
</script>

	<script src="<?php echo base_url(); ?>js/common/app.js"></script>

<style>

/* Paste this css to your style sheet file or under head tag */
/* This only works with JavaScript, 
if it's not present, don't show loader */
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
  background-image: url(./images/spin.png) no-repeat;

}
</style>

<style>
/* Set height of the grid so .sidenav can be 100% (adjust as needed) */
.row.content {height: 550px}

/* Set gray background color and 100% height */
.sidenav {
  /*background-color: #f1f1f1;*/
  height: 730px !important;
}
    
/* On small screens, set height to 'auto' for the grid */
@media screen and (max-width: 767px) {
  .row.content {height: auto;} 
}
</style>

<style>
	.semester-lesson-plan-widget table.htCore tr td:nth-child(9), .semester-lesson-plan-widget table.htCore tr th:nth-child(9) {
    	display:none;
	 }

/*
	.grade-lesson-plan-widget table.htCore tr td:nth-child(n+7), .grade-lesson-plan-widget table.htCore tr th:nth-child(n+7) {
    	display:none;
	 }*/

/*
.dplan-widget table.htCore tr td:nth-child(9), .dplan-widget table.htCore tr th:nth-child(9) {
    	display:none;
	 }*/




	 .semester-lesson-plan-widget table thead th {
  white-space: pre-line;
  max-width: /* enter here your max header width */
}

</style>

</head>
<body>
<div class="se-pre-con"></div>
<!-- wrapper -->
<div class="container-fluid">
	<!-- main-content -->
	<div class="row content">

<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

?>	
<div class="col-lg-12 unfound">
	<h2>404</h2>
	<p>Opps! The page you requested was not found!</p>
	<a href="javascript:history.go(-1)">Previous page</a>	
</div>
<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>

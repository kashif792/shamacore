<?php 
// require_header 
require APPPATH.'views/__layout/header.php';

// require_top_navigation 
require APPPATH.'views/__layout/topbar.php';

// require_left_navigation 
require APPPATH.'views/__layout/leftnavigation.php';
?>

<!-- <script type="text/javascript" src="<?php echo $path_url; ?>js/control/ctrlinvantage.js"></script> -->


<!-- right content -->
<div class="col-sm-10">
	<?php
		// require_footer 
		require APPPATH.'views/__layout/filterlayout.php';
	?>

		<?php
			/**
			 * ---------------------------------------------------------
			 *   Scan current file directory
			 * ---------------------------------------------------------
			 */
			$dir = dirname(__FILE__)."/widgets";
			$current_file = __FILE__;
			// Open a directory, and read its contents
			if (is_dir($dir)){
				if ($dh = opendir($dir)){
					$files = array();
					while (($file = readdir($dh)) !== false){
						if ($file != "." && $file != "..") {
							//echo $file; 
						    //require $dir.'/'.$file;
						    array_push($files,$file);
					   	
					   }
					}
					//$files = scandir($dh);
					sort($files);
					
					foreach($files as $file)
					{
						
							//echo $file; 
						 	require $dir.'/'.$file;
						
					}
					closedir($dh);
				}
			}
		?>
</div>


<?php
// require_footer 
require APPPATH.'views/__layout/footer.php';
?>


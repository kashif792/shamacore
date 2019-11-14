

<?php
// require_header
require APPPATH . 'views/__layout/header.php';

// require_top_navigation
require APPPATH . 'views/__layout/topbar.php';

// require_left_navigation
require APPPATH . 'views/__layout/leftnavigation.php';
?>



<!-- right content -->
<div class="col-sm-10">
	<?php
// require_footer
require APPPATH . 'views/__layout/filterlayout.php';
?>



<?php

/**
 * ---------------------------------------------------------
 * Scan current file directory
 * ---------------------------------------------------------
 */

$dir = dirname(__FILE__) . "/widgets";

// Open a directory, and read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        $files = array();
        while (($file = readdir($dh)) !== false) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($file != "." && $file != ".." && $ext == "php") {
                // if ($file != "." && $file != "..") {
                array_push($files, $file);
            }
        }
        // $files = scandir($dh);

        sort($files);

        foreach ($files as $file) {
            require $dir . '/' . $file;
        }
        closedir($dh);
    }
}

?>
</div>
<?php
// require_footer
require APPPATH . 'views/__layout/footer.php';
?>



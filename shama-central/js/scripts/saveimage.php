<?php

//set random name for the image, used time() for uniqueness

$filename =   $_GET['filename']  . '.jpg';
$filepath = '../../upload/userimage/';

//read the raw POST data and save the file with file_put_contents()
$result = file_put_contents( $filepath.$filename, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}

echo $filepath.$filename;
?>

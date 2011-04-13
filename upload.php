<?php
include 'uploader.php';

list($name,$result) = upload('ximage','images/products','jpg,jpeg,gif,png');
if($name) { // Upload Successful
	$details = stat("images/products/$name");
	$size = $details['size'] / 1024;
	print json_encode(array(
		"success"	=>	$result,
		"failure"	=>	false,
		"file_name"	=>	$name,	// Name of the file - JS should get this value
		"size"		=>	$size	// Size of the file - JS should get this as well.
	));
} else { // Upload failed for some reason.
	print json_encode(array(
		"success"	=>	false,
		"failure"	=>	$result,
	));
}
?>

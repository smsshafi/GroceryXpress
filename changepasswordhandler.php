<?php
session_start();
include 'etc.php';
if ($_GET['change'] == 1)
{
	$_POST['oldpassword'] = md5($_POST['oldpassword']);
	$response = ChangePassword($_SESSION['uwid'], $_POST['oldpassword'], $_POST['newpassword'], $_POST['renewpassword']);
	echo $response;
	
}

?>



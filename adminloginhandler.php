<?php
session_start();
include 'etc.php';
if ($_GET['login'] == 1)
{
	$_POST['password'] = md5($_POST['password']);
	if (Authenticated($_POST['email'], $_POST['password']))
	{
		$_SESSION['logintype'] = 'admin';
		$_SESSION['uwid'] = $_POST['email'];
		echo "Success";
	}
	else
	{
		echo "Invalid username or password. Please try again.";
	}
	
}

?>


<?php
	include_once 'etc.php';
	session_start();
	if ($_SESSION['logintype'] != "admin" || $_SESSION == "")
	{
		header("location: ./admin.php");
	}
	if (!IsAdmin($_SESSION['uwid']))
	{
		header("location: ./controlpanel.php");
	}
?>



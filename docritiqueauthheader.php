<?php
	include_once 'etc.php';
	session_start();
	if (	
		$_SESSION['logintype'] != "student" || 
		$_SESSION['uwid'] == "" || 
		GetCritiquePermissionFromStudentID($_GET['id'], $_SESSION['uwid']) != "allowed"
	   ) 
	{
		header("location: ./index.php");
	}
?>


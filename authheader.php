<?php
	session_start();
	if ($_SESSION['logintype'] != "admin" || $_SESSION == "")
	{
		header("location: ./admin.php");
	}
?>


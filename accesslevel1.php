<?php
	include_once 'etc.php';
	if (!IsMasterAdmin($_SESSION['uwid']))
	{
		header("location: ./controlpanel.php");
	}
?>



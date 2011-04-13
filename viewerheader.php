<?php
	session_start();
	include_once 'etc.php';
	if ($_SESSION['logintype'] != "admin" || $_SESSION == "")
	{
		header("location: ./admin.php");
	}
	

	if (!IsMasterAdmin($_SESSION['uwid']))
	{
		$prof_id = GetProfessorIDFromUsername($_SESSION['uwid']);
		$critique = GetCritiqueFromID($_GET['id']);
		$row = mysql_fetch_assoc($critique);
		
		if ($prof_id != $row['prof_id'])
		{
			header("location: ./controlpanel.php");
		}
	}
?>



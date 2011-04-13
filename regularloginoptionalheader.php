<?php
	session_start();
    $logged_in = false;
	if (isset($_SESSION['logintype']) && $_SESSION['logintype'] == "regular" && $_SESSION['uwid'] != "") {
		$logged_in = true;
	}
?>


<?php

session_start();
session_destroy();
$_SESSION['logintype'] = "";
$_SESSION['uwid'] = "";
header("location: ./index.php");

?>

<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'on');

session_start();
print_r($_SESSION);
var_dump($_SESSION['foo']);

$_SESSION['foo'] = 'bar';
?>
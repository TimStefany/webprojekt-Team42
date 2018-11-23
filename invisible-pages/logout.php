<?php
session_start();

$_SESSION = array();
session_destroy();

require '../outsourced-php-code/header.php';
header('Location:../index.php');
?>
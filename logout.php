<?php
session_start();

$_SESSION = array();
session_destroy();

require 'header.php';
header('Location:index.php');
?>
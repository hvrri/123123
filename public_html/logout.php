<?php include_once 'resource/session.php';
include_once 'resource/utilities.php';
unset($_SESSION); 
session_destroy(); 
header("Location: index.php"); 
<?php session_start();
//print_r($_SESSION['user']);
//echo 'unsetting User...';
unset($_SESSION['user']);
//sleep(5);
//print_r($_SESSION['user']);
header("Location: login.php"); /* Redirect to login page */
exit();	
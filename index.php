<?php session_start();  
if (!isset($_SESSION['user'])){
	header("Location: registration.php"); /* Redirect to the registration */
} else {
	header("Location: feed.php"); /* Redirect to the feed */
}
exit();
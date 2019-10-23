<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log in</title>
</head>
<body><?php
if (isset($_POST)){ 
	require_once 'db_config.php';
	include 'db.php';
	$db = new db(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$output_positive = $output_negative ='';
	if (isset($_POST['submit'])){     
		$users = $db->query("SELECT * FROM user WHERE email = ? AND password = ? ", htmlentities( $_POST['email'], ENT_QUOTES), htmlentities( $_POST['password'], ENT_QUOTES) )->numRows();  		 
		if ($users) {
			$output_positive = 'User is succesfully logged in!<br /><a href="login.php" >Log in</a>';
		} else {
			$output_negative = 'Failure to log in a user!';
		}
	}
}
$email = (isset($_POST['email'])) ? htmlentities($_POST['email']) : "";
echo '<form style="" action="" method="post">';
echo '<h2>RSS feed <br />User log in</h2>'; 
echo '<input type="email" name="email" placeholder="Email" value="'. $email . '" required >';
echo '<br />'; //<p class="error-email"></p>';
echo '<input type="password" placeholder="Password" id="password" name="password" required>';
echo '<br /><input style="text-align:center;" type="submit" name="submit" value="Login" />';
echo '<p class="success">'. $output_positive . '</p>';
echo '<p class="error">' .  $output_negative . '</p>';
echo '</form>';
?>
</body>
<style> 
.success {
	color: green;
	font-type: bold;	
	font-size: 1.2em;
}
.error, .error-email {
	color: red;
	font-type: bold;	
	font-size: 1.2em;
}
input {
    width: 50%;
    padding: 4px 4px;
    margin: 8px 0;
    box-sizing: border-box;	
	font-size: 1.2em;
}
input:invalid {
    border-color: red;
}
form {
	text-align:center; 
	display: block;	
	font-size: 1.2em;
}
</style>
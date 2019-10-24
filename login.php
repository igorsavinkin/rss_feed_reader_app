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
		$user = $db->query("SELECT * FROM user WHERE email = ?  ", htmlentities( $_POST['email'], ENT_QUOTES))->fetchArray();  		
		if ($user) {
			$existingHashFromDb = $user['password'];
			$isPasswordCorrect = password_verify($_POST['password'], $existingHashFromDb);
			if ($isPasswordCorrect){
				$_SESSION['user'] = array(
					'name' => $user['name'], 
					'email' => $user['email'] 
				); 
				$output_positive = 'User is succesfully logged in!<br /><a href="login.php" >Log in</a>';
				// redirect to the feed page
				header("Location: feed.php"); /* Redirect browser */
				exit();	
			} else {
				$output_negative = 'Failure to log in a user! <br />Password is not correct!';
			}		
		} else {
			$output_negative = 'Failure to log in a user! <br />No such a user exists!';
		}
	}
}
if (isset($_SESSION['user'])){
	header("Location: feed.php"); /* Redirect browser to the rss feed */
	exit();	
	//print_r($_SESSION['user']);
	//echo '<p id="user">Logged in user:<br />'.$_SESSION['user']['email'] .'<br />';
	//echo '<a   href="logout.php">Log out</a></p>';
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
echo '<p>Not registered? <a href="registration.php">Register</a>.</p>';
echo '</form>';
?>
</body>
<style> 
#user {
	text-align: right;
	color: green;
}
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
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register user</title>
</head>
<body><?php
if (isset($_POST)){ 
	require_once 'db_config.php';
	include 'db.php';
	$db = new db(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	// ajax call check email 
	if (isset($_POST['ajax'])){
		$res = $db->query("SELECT * FROM user WHERE email = ? ", htmlentities( $_POST['email'], ENT_QUOTES) )->fetchArray();     
		if ($res) {
			echo 'The email <b>' . $res['email'] . '</b> already exists.';
		}
		return; 
	}
	$output_positive = $output_negative ='';
	if (isset($_POST['submit'])){     
		$res = $db->query('INSERT INTO user (name, email, password) VALUES (?,?,?)', htmlentities($_POST['name'], ENT_QUOTES) , htmlentities( $_POST['email'], ENT_QUOTES),  htmlentities($_POST['password'], ENT_QUOTES))->affectedRows();		 
		if ($res) {
			$output_positive = 'User is succesfully registered!<br /><a href="login.php" >Log in</a>';
		} else {
			$output_negative = 'Failure to register a user!';
		}
	}
}
if (isset($_SESSION['user'])){
	echo '<p id="user">Logged in user:<br />'.$_SESSION['user']['email'] .'<br />';
	echo '<a href="logout.php">Log out</a></p>';
}
echo '<form style="" action="" method="post">';

echo '<h2>RSS feed <br />User registration</h2>';
echo '<input type="text" placeholder="Name" id="name" name="name" ><br />';
echo '<input type="email" name="email" placeholder="Email" required >';
echo '<p class="error-email"></p>';
echo '<input type="password" placeholder="Password" id="password" name="password" required>
     <input type="password" placeholder="Confirm Password" id="confirm_password" required>';
echo '<br /><input style="text-align:center;" type="submit" name="submit" value="Submit" />';
echo '<p class="success">'. $output_positive . '</p>';
echo '<p class="error">' .  $output_negative . '</p>';
echo '<p>Already regietered? <a href="login.php">Log in</a>.</p>';
echo '</form>';
?>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
// validate password at client side
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");
function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}
password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

// validate email thru ajax
$('input[type="email"]').on('input', function() {
	$.post({'url': window.location.href , 'data': {"email" :$( this ).val(), "ajax": 1 } }, function( data ) {
	    $( ".error-email" ).html( data );
	});
});
</script>
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
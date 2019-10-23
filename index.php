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
		$res = $db->query("SELECT * FROM user WHERE email= ? ", $_POST['email'])->fetchArray();     
		if ($res) {
			echo 'Email already exists: <b>'.$res['email'] . '</b>';
		}
		return; 
	}
	$output_positive = $output_negative ='';
	if (isset($_POST['submit'])){     
		$res =$db->query('INSERT INTO user (name, email, password) VALUES (?,?,?)', $_POST['name'], $_POST['email'], $_POST['password'])->affectedRows();		 
		if ($res) {
			$output_positive = 'User is succesfully registered!';
		} else {
			$output_positive = 'Failure to register the user!';
		}
	}
}

//$email = (isset($_POST['email'])) ? htmlentities($_POST['email']) : "";
//$password = (isset($_POST['password'])) ? htmlentities($_POST['password']) : "";
echo '<form style="" action="" method="post">';
echo '<h2>User registration</h2>';
echo '<input type="text" placeholder="Name" id="name" name="name" ><br />';
echo '<input type="email" name="email" placeholder="Email" required >';
echo '<p class="error-email"></p>';
echo '<input type="password" placeholder="Password" id="password" name="password" required>
     <input type="password" placeholder="Confirm Password" id="confirm_password" required>';
echo '<br /><input style="text-align:center;" type="submit" name="submit" value="Submit" />';
echo '<p class="success">'.$output_positive .'</p>';
echo '<p class="error">'.$output_negative .'</p>';
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
.success {
	color: green;
	font-size: 1.2em;
	font-type: bold;
}
.error, .error-email {
	color: red;
	font-size: 1.2em;
	font-type: bold;
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
	text-align:center; display: block;
}
</style>
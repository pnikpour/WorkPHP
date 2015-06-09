<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include('../assets/php/lib.php');
	global $user;
	global $password;
	global $db;
	
	if (isset($_SESSION['user'])) {	
		$user = getUser();
		$password = getPassword();
		$db = getDB($user, $password);
	}

	forbid($_SESSION['user']);
?>
<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='../assets/js/effect.js' type='text/javascript'></script>
	<link rel='stylesheet' href='../assets/css/styles.css' type='text/css' />
	<script type='text/javascript'>
	$('document').ready(function() {
	
		$('td').css('padding', '6px 10px');
		$('body').css('background-color', '#D0D0D0');	
	});
	</script>
</head>
<body>

<?php

		////	if (isset($_POST['submit']) && $password1 == $password2) {
	if (isset($_POST['submit'])) {
		$password1 = null;
		$password2 = null;
		if (isset($_POST['password1']) && isset($_POST['password2'])) {
			$password1 = $_POST['password1'];
			$password2 = $_POST['password2'];
		}

		$doPasswordChange = true;
		if ($password1 !== $password2) {
			echo 'The passwords did not match';
			$doPasswordChange = false;
		}
		if (strlen($password1) < 6 || strlen($password2) < 6) {
			echo 'The password length requirement has not been met; please provide a password of at least six characters long';
			$doPasswordChange = false;
		}


		$username = $_POST['username'];
		$newPassword = $password1;

		if ($username == '') {
			echo 'Please specify a username';
			$doPasswordChange = false;
		}

		if ($doPasswordChange) {
			$hash = password_hash($newPassword, PASSWORD_DEFAULT);
			$query = "UPDATE users SET hash='" . $hash . "' WHERE username LIKE '" . $username . "'";
			if (!$db->exec($query)) {
				print_r($db->errorInfo()); 
			}
			echo 'Password for ' . $username . ' changed';	
		}

	} else {
		navPOST();
	}
?>


<h1>Form</h1>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" name='addUserForm' id='addUserForm' method='post'>
	
	<?php include '../assets/php/createNav.php'; ?>
	
	<table border=1>
		<tr>
			<td>
			<input type='text' class='logon' name='username' placeholder='Username' />
			</td>
		</tr>
		<tr>
			<td>
			<input type='password' class='logon' name='password1' placeholder='Password' />
			</td>

		</tr>
		<tr>
			<td>
			<input type='password' class=logon' name='password2' placeholder='Confirm Password' />
			</td>
		</tr>
		<tr>
			<td>
			<input type='submit' class='button' name='submit' value='Change Password' />
			</td>
		</tr>
	</table>
</form>
</body>
</html>



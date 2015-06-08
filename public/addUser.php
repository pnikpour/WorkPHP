<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include('assets/php/lib.php');
	global $user;
	global $password;
	global $db;

	// If not an admin, redirect to forbidden.php
	forbid($_SESSION['user']);
	
	if (isset($_SESSION['user'])) {	
		$user = getUser();
	//	$password = getPassword();
		$db = getDB($user, $password);
	} else {
		header('Location: forbidden.php');
	}
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='assets/js/effect.js' type='text/javascript'></script>
	<link rel='stylesheet' href='assets/css/styles.css' type='text/css' />
</head>
<body>


<?php

	// Create the user
	if (isset($_POST['saveNew']) || isset($_POST['submit'])) {
		$newName = $_POST['newName'];
		$newPassword = $_POST['newPassword'];
		$userLevel = $_POST['userLevel'];
		
		$hash = password_hash($newPassword, PASSWORD_DEFAULT);
		$query = "INSERT INTO users (username, hash, groups) values ('" . $newName . "', '" . $hash . "', '" . $userLevel . "')";
		if (!$db->exec($query)) {
			print_r($db->errorInfo()); 
		}
		echo 'User ' . $newName . ' added to database.';	
	}

	// Logout snippet
	navPOST();
?>


<h1>Form</h1>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" name='addUserForm' id='addUserForm' method='post'>

	<?php include 'assets/php/createNav.php'; ?>

	<table border=1>
		<tr>
			<th>New Username</th>
			<th>New Password for Username</th>
			<th>User Level</th>
		</tr>
		<tr>
			<td>
			<input type='text' class='logon'  name='newName' />
			</td>
			<td>
			<input type='password' class='logon' name='newPassword' />
			</td>
			<td>
			<select id='userLevel' name='userLevel' >
				<option value='Administrator'>Administrator</option>
				<option value='User'>User</option>
			</select>
			</td>
		</tr>
		<tr>
			<td>
			<input type='submit' class='button' name='submit' value='Submit' />
			</td>
		</tr>
	</table>
</form>
</body>
</html>



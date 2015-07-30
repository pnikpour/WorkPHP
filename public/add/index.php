<?php
/**
 * Page for admins to add new user accounts
 *
 * @author Parsa Nikpour <pnikpour@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2015 Parsa Nikpour
 */
?>

<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include('../assets/php/lib.php');

	dontCache();
	
	forbid(); // If not an admin, redirect to forbidden.php

	checkLastActivity();
	redirectIfNotLoggedIn();
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js?<?php echo time(); ?>"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js?<?php echo time(); ?>"></script>
	<script src='../assets/js/effect.js?<?php echo time(); ?>' type='text/javascript'></script>
	<link rel='stylesheet' href='../assets/css/styles.css?<?php echo time(); ?>' type='text/css' />
	<title>Add Users</title>
</head>
<body>
<header><img class='logo' src='../assets/images/logo.png' alt='QuikPHP Logo'></header>
<h1>Add Users</h1>

<form class='formMultipleColumns' action='' name='addUserForm' id='addUserForm' method='post'>

	<?php include '../assets/php/createNav.php'; ?>

	<table border=1>
		<tr>
			<th>New Username</th>
			<th>New Password for Username</th>
			<th>User Level</th>
		</tr>
		<tr>
			<td>
			<input type='text' class='logon' name='newName' />
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

<?php

	// Create the user
	if (isset($_POST['saveNew']) || isset($_POST['submit'])) {
		$newName = $_POST['newName'];
		$newPassword = $_POST['newPassword'];
		$userLevel = $_POST['userLevel']; // Administrator or regular user
		
		if (userExists($newName)) { // If username exists, prompt error
			echo 'User already exists; please specify a different username';
			return;
		} else // If username entered is empty, prompt error
		if (strlen(trim($newName)) == 0) {
			echo 'Please specify a username';
			return;
		} 

		// Perform password add; check requirements; only checks password length
		if (meetsPasswordLength($newPassword, true)) {
			$hash = password_hash($newPassword, PASSWORD_DEFAULT);
			$query = "INSERT INTO users (username, hash, groups) values (:newName, :hash, :userLevel)";
			$result = getDB()->prepare($query);
			$result->bindParam(':newName', $newName);
			$result->bindParam(':hash', $hash);
			$result->bindParam(':userLevel', $userLevel);
			$result->execute();
			printSuccess('User ' . $newName . ' added to database');
		}
	}

	// Navigation link action controller
	navPOST();
?>



</body>
</html>



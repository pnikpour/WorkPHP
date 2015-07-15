<?php
//**************************************************************************
// This file is part of the QuikPHP project.
// 
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
// 
// Programmer: Parsa Nikpour 
// Date: 16 June 2014
// Description:  
// 
//**************************************************************************/
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
</head>
<body>
<header><img class='logo' src='../assets/images/logo.png' alt='QuikPHP Logo'></header>
<h1>Add Users</h1>

<form action='' name='addUserForm' id='addUserForm' method='post'>

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
		} else // If username entered is empty, prompt error
		if (strlen(trim($newName)) == 0) {
			echo 'Please specify a username';
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



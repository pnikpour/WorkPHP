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
// Description: This file processes the user logon credentials
// 
//**************************************************************************/
?>

<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include('../assets/php/lib.php');
	dontCache();

	// Accepts username and cleartext password; verifies password with hashed one in database
	function authUser($user, $pass) {
	
		$db = getDB();
		$query = 'SELECT username, hash, groups FROM workorder.users WHERE username LIKE :user';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':user', $user);
		$stmt->execute();
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		$group = $rows['groups'];	
		$hash = $rows['hash'];


		if (password_verify($pass, $hash)) {
			$_SESSION['user'] = $user;
			$_SESSION['password'] = $hash;
			header('Location: ../menu');
		} else { // Increment the login attempts by one; throw error if max attempts is reached
	//		session_unset();
			setErrorVar('<p class="error">That did not work; please try again</p>');
			header('Location: ../');
		}
	}

	// If clicked on register button, redirect to self-register form
	if (isset($_POST['register'])) {
		header('Location: ../register');
	} else {
		if (!isset($_POST['user']) || !isset($_POST['password'])) {
			redirectIfNotLoggedIn();
		} else {
			authUser($_POST['user'], $_POST['password']);
		}
	}
?>

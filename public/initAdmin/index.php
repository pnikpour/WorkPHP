<?php
//**************************************************************************
// This file is part of the BlueberryPHP project.
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
//**************************************************************************
?>

<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	
	include('../assets/php/lib.php');

	// If user tried accessing this page directly, redirect to login page
	if (adminExists()) {
		header('Location: ../index.php');
	}

?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='../assets/js/effect.js' type='text/javascript'></script>
	<link rel='stylesheet' href='../assets/css/styles.css' type='text/css' />

</head>
<body>

<header><img class='logo' src='../assets/images/logo.png' alt='BlueberryPHP Logo'></header>
<?php
	if (isset($_POST['saveNew']) || isset($_POST['submit'])) {
		$newName = $_POST['newName'];
		$newPassword = $_POST['newPassword'];
		$userLevel = 'Administrator';
		
		$hash = password_hash($newPassword, PASSWORD_DEFAULT);
		$query = "INSERT INTO users (username, hash, groups) VALUES (:newName, :hash, :userLevel)";
		$result = getDB()->prepare($query);
		$result->bindParam(':newName', $newName);
		$result->bindParam(':hash', $hash);
		$result->bindParam(':userLevel', $userLevel);
		$result->execute();
		echo 'User ' . $newName . ' added to database.';	
	}

	navPOST();

?>


<h1>Admin Creation Page</h1>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" name='addUserForm' id='addUserForm' method='post'>
	<nav>
		<input type='submit' class='button' name='addUser' value='Add Users' />
		<input type='submit' class='button' name='logout' value='Log Out' />
	</nav>
	</div>

	<table border=1>
		<tr>
			<th>New Admin Username</th>
			<th>New Password for Admin</th>
		</tr>
		<tr>
			<td>
			<input type='text' class='logon'  name='newName' />
			</td>
			<td>
			<input type='password' class='logon' name='newPassword' />
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



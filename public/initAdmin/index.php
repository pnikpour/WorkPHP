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



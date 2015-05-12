<?php
	session_start();
	include('lib.php');
	global $user;
	global $password;
	global $db;
	
	
?>

<html>
<head>
</head>
<body>


<?php
if (!isset($_SESSION['user'])) {
	$user = $_POST['user'];
} else {
	$user = $_SESSION['user'];
}


if ($user !== 'parsa') {
		echo 'Access Denied for user ' . $user;
		exit();
	//	header("Location: http://www.blueberryphp.com/index.php");
	}	

?>

<?php

	// Governs when the user submits a ticket and refreshes the page; will
	// increment the ticket number count by one
	if (isset($_POST['saveNew'])) {
		$user = $_SESSION['user'];
		$password = $_SESSION['password'];
		$db = getDB($user, $password);
		
		$newName = $_POST['newName'];
		$newPassword = $_POST['newPassword'];

		$query = "CREATE USER '" . $newName . "'@'localhost' IDENTIFIED BY '" . $newPassword . "'";
		if (!$db->exec($query)) {
			print_r($db->errorInfo()); 
		}
		echo 'User ' . $newName . ' added to database.';	
	}

	// Check user session; if the session is new, use post data from logon form; otherwise renew user credentials
	// with session variables
	if (!isset($_SESSION['user'])) {
		$_SESSION['user'] = $_POST['user'];
		$_SESSION['password'] = $_POST['password'];
		$user = $_SESSION['user'];
		$password = $_SESSION['password'];

	}
	$user = $_SESSION['user'];
	$password = $_SESSION['password'];
	$hostname = "localhost";

	try {
		$db = getDB($user, $password);
	} catch (PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
		session_unset();
	}

//	unset($db);
?>


<h1>Form</h1>

<form action="addUser.php" name='login' method='post'>
<input type='submit' name='saveNew' value='Save and New' />
<table border=1>
	<tr>
		<th>New Username</th>
		<th>New Password for Username</th>
	</tr>
	<tr>
		<td>
		<input type='text'  name='newName' />
		</td>
		<td>
		<input type='password' name='newPassword' />
		</td>
	</tr>
</table>
</form>
</body>
</html>



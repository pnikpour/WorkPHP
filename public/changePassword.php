<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	session_start();
	include('assets/php/lib.php');
	global $user;
	global $password;
	global $db;
	
	$user = getUser();
	$password = getPassword();
	$db = getDB($user, $password);

	if (isAdmin($user, $db)) {
		$_SESSION['privilege'] = true;
	} else {
		$_SESSION['privilege'] = false;
	}

?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='assets/js/effect.js' type='text/javascript'></script>
	<link rel='stylesheet' href='assets/css/styles.css' type='text/css' />
	<script type='text/javascript'>
	$('document').ready(function() {
	
		$('td').css('padding', '6px 10px');
		$('body').css('background-color', '#D0D0D0');	
	});
	</script>
</head>
<body>


<?php
	if ($_SESSION['privilege'] == false) {
		echo 'Access Denied for user ' . $user;
		exit();
	}	
?>

<?php

	// Governs when the user submits a ticket and refreshes the page; will
	// increment the ticket number count by one
	if (isset($_POST['change']) || isset($_POST['submit'])) {
		$newName = $_POST['newName'];
		$newPassword = $_POST['newPassword'];
		$query = "CREATE USER '" . $newName . "'@'localhost' IDENTIFIED BY '" . $newPassword . "'";
		if (!$db->exec($query)) {
			print_r($db->errorInfo()); 
		}
		$query = "GRANT SELECT, INSERT, UPDATE, DELETE on workorder.* to '" . $newName . "'@'localhost' identified by '" . $newPassword . "'";
		if (!$db->exec($query)) {
			print_r($db->errorInfo()); 
		}
		$query = "INSERT INTO users values ('" . $newName . "', 'User')";
		if (!$db->exec($query)) {
			print_r($db->errorInfo()); 
		}
		echo 'User ' . $newName . ' added to database.';	
	}

	// Logout snippet
	if (isset($_POST['logout'])) {
		logout();
	} else
	if (isset($_POST['addUser'])) {
		header('Location: addUser.php');
	} else
	if (isset($_POST['ticket'])) {
		header('Location: ticket.php');
	}
?>


<h1>Form</h1>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" name='addUserForm' id='addUserForm' method='post'>
	<nav>
		<input type='submit' class='button' name='home' id='home' />
		<input type='submit' class='button' name='ticket' value='Create Work Order' />
		<input type='submit' class='button' name='addUser' value='Add Users' />
		<input type='submit' class='button' name='logout' value='Log Out' />
	</nav>
	</div>

	<table border=1>
		<tr>
			<td>
			<input type='text' class='logon' name='newName' />
			</td>
		</tr>
		<tr>
			<td>
			<input type='password' class='logon' name='password1' />
			</td>

		</tr>
		<tr>
			<td>
			<input type='password' class=logon' name='password2' />
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



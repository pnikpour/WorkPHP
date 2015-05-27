<?php
	session_start();
	include('../lib.php');
	global $user;
	global $password;
	global $db;
	
	$user = getUser();
	$password = getPassword();
	$db = getDB($user, $password);
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	<link rel='stylesheet' href='../assets/styles.css' type='text/css' />
	<script type='text/javascript'>
	$('document').ready(function() {
	
		$('td').css('padding', '6px 10px');
		$('body').css('background-color', '#D0D0D0');	
	});
	</script>
</head>
<body>


<?php



if ($user !== 'parsa' && $user !== 'root') {
		echo 'Access Denied for user ' . $user;
		exit();
	}	

?>

<?php

	// Governs when the user submits a ticket and refreshes the page; will
	// increment the ticket number count by one
	if (isset($_POST['saveNew'])) {
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
		echo 'User ' . $newName . ' added to database.';	
	}

//	// Check user session; if the session is new, use post data from logon form; otherwise renew user credentials
//	// with session variables

//	$hostname = "localhost";
//
//	try {
//		$db = getDB($user, $password);
//	} catch (PDOException $e) {
//		echo 'ERROR: ' . $e->getMessage();
//		session_unset();
//	}
//
////	unset($db);
?>


<h1>Form</h1>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" name='login' method='post'>
<div class='btnHeader'><input type='submit' name='saveNew' value='Save and New' />
</div>

<table border=1>
	<tr>
		<th>New Username</th>
		<th>New Password for Username</th>
	</tr>
	<tr>
		<td>
		<input type='text' class='logon'  name='newName' />
		</td>
		<td>
		<input type='password' class='logon' name='newPassword' />
		</td>
	</tr>
</table>
</form>
</body>
</html>



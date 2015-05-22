<?php
	session_start();
	include('lib.php');
	global $user;
	global $password;
	global $numberOfRecords;
	global $db;	
?>

<html>
<head>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js'></script>
	<link rel='stylesheet' href='assets/styles.css' type='text/css' />
	<script type='text/javascript'>
	$('document').ready(function() {
	
		$('td').css('padding', '6px 10px');
		$('body').css('background-color', '#D0D0D0');	
	});
	</script>
</head>
<body>

<?php

	// If Create Work Order button is clicked, navigate to work order creation form
	if (isset($_POST['createWorkorder'])) {
		header('Location: database.php');
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
		echo 'ERROR:' . $e->getMessage();
		session_unset();
		exit();
	}

?>


<h1>Form</h1>

<div class='formContainer'>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" name='menu' id='menu' method='post'>
	<div class='btnHeader'>
		<input type='submit' name='createWorkorder' value='Save and New' />
	</div>

	</form>
</div>
</body>
</html>



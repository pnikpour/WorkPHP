<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	session_start();
	include('lib.php');
	global $user;
	global $password;
	global $numberOfRecords;
	global $db;

	$user = getUser();
	$password = getPassword();
	$db = getDB($user, $password);

?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link rel='stylesheet' href='assets/styles.css' type='text/css' />
	
</head>
<body>

<?php

	// If Create Work Order button is clicked, navigate to work order creation form
	if (isset($_POST['createWorkorder'])) {
		header('Location: database.php');
	}

	try {
		$db = getDB($user, $password);
	} catch (PDOException $e) {
		echo 'ERROR:' . $e->getMessage();
		session_unset();
		exit();
	}

?>


<h1>Form</h1>
<nav>
	<ul><a href='database.php'>Create Work Order</a></ul>
</nav>
<div class='formContainer'>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" name='menu' id='menu' method='post'>
	<div class='btnHeader'>
		<input type='submit' name='createWorkorder' value='Save and New' />
	</div>

	</form>
</div>
</body>
</html>



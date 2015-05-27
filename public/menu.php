<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	session_start();
	include('assets/php/lib.php');
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
	<script src='../assets/effect.js' type='text/javascript'></script>
	<link rel='stylesheet' href='../assets/styles.css' type='text/css' />
	
</head>
<body>

<?php
	// Logout snippet
	if (isset($_POST['logout'])) {
		session_unset();
		header('Location: ../index.php');
	}

	try {
		$db = getDB($user, $password);
	} catch (PDOException $e) {
		echo 'ERROR:' . $e->getMessage();
		session_unset();
		exit();
	}

?>


<h1>Menu</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" name='menu' id='menu' method='post'>
	<nav>
		<a href='ticket.php'>
			<ul>Create Work Order</ul>
		</a>
		<a href='addUser.php'>
			<ul>Add Users</ul>
		</a>
		<a href='index.php' name='logout' onclick='menu.submit();' >
			<ul>Log Out</ul>
		</a>
	</nav>
</form>
</body>
</html>



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

//	$db = getDB();
	$user = getUser();
//	$password = getPassword();
//	$user = $_SESSION['user'];
	$db = getDB();
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='assets/js/effect.js' type='text/javascript'></script>
	<link rel='stylesheet' href='assets/css/styles.css' type='text/css' />
	
</head>
<body>

<?php
	navPOST();
?>


<h1>Menu</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" name='menu' id='menu' method='post'>
	<nav>
		<input type='submit' class='button' id='home' name='home' value='Home' />
		<input type='submit' class='button' id='ticket' name='ticket' value='Create Work Order' />
		<input type='submit' class='button' name='logout' value='Log Out' />
	</nav>
</form>

<?php
	if (isAdmin($user, $db)) { ?>
		<script>
			$('#ticket').after("<input type='submit' class='button' id='addUser' name='addUser' value='Add Users' />");
			$('#addUser').after("<input type='submit' class='button' id='changePassword' name='changePassword' value='Change Password' />");
		</script>
		<?php
	} ?>
</body>
</html>



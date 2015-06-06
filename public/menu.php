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

	$db = getDB();
	$user = getUser();
//	$password = getPassword();
//	$user = $_SESSION['user'];
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

<div class='formContainer'>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" name='menu' id='menu' method='post'>

	<?php include 'assets/php/createNav.php'; ?>
	<p>content</p>
	</form>
</div>
</body>
</html>



<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	if (!isset($_POST['user'])) {
		echo 'The session has not been created';
		session_start();
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(),'',0,'/');
		session_regenerate_id(true);
	} else {
		session_start();
	}
	global $user;
	global $password;
	global $numberOfRecords;
	global $db;	
	include('lib.php');
	
	$user = getUser();
	$password = getPassword();
	$db = getDB($user, $password);
?>

<?php
	if (isset($_POST['btnLogin'])) {
		$user = $_POST['user'];
		$password = $_POST['password'];
		echo 'The user is ' .  $user;
		try {
			$db = getDB($user, $password);
			echo 'db successful';
		} catch (PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
			session_unset();
		}
	}
?>



<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='hide.js'></script>
	<script src='ghost.js'></script>
	

	<script type='text/javascript'>
	$('document').ready(function() {
	
		$('td').css('padding', '6px 10px');
		$('body').css('background-color', '#D0D0D0');	
	});
	</script>

	<link rel='stylesheet' href='assets/styles.css' type='text/css' />
</head>
<body>

<h1>Create and Edit Users Login</h1>

<?php
	if (!isset($_POST['user'])) {
?>
	<form name='login' action='' name='adminLogin' id='adminLogin' method='post'>
		<input type='text' class='ghost' name='user' placeholder='Admin Logon'/> <br>
		<input type='password' class='ghost' name='password' placeholder='Admin Password'/>
		<input type='submit' onclick="javascript:hideAndShow($('#adminLogin'), $('#adminOptions'))" class='logon' id='btnLogin' name='btnLogin' value='Login'/>
	</form>
<?php
} else {
	try {
		$user = $_POST['user'];
		$password = $_POST['password'];
		$_SESSION['user'] = $user;
		$_SESSION['password'] = $password;
		$db = getDB($user, $password);
	} catch (PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
		session_unset();
	}
}
?>
<!--<form name='adminOptions' action='javascript:hideThis($("#adminOptions"))' id='adminOptions' name='adminOptions' style='visibility:hidden' method='post'>-->
<form name='adminOptions' action='addUser.php' id='adminOptions' name='adminOptions' style='visibility:hidden' method='post'>
	<input type='submit' name='addUsers' id='addUsers' value='Add Users' />
	<?php
		if (isset($_POST['user'])) {
			echo '<script>$("#adminOptions").css("visibility", "visible")</script>';
		}
	?>
</form>
</body>
</html>

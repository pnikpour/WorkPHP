<?php
	ini_set('display_errors', 1);

	// Start session
	session_start();
//	if (session_status() === PHP_SESSION_NONE) {
	if (!$_SESSION['user']) {
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(),'',0,'/');
		session_regenerate_id(true);
	} else {
		session_start();
		header('Location: menu.php');
	}
	// Include external functions for getting the current database connection
	include('assets/php/lib.php');

	// Declare global variables
	global $user;
	global $password;
	global $numberOfRecords;
	global $db;

	function alert($str) {
		echo "<script>alert('" . $str . "')</script>";
	}

	if (isset($_SESSION['user'])) {
		$user = getUser();
		$password = getPassword();
		$db = getDB($user, $password);
	}
?>


<?php
	// If user pressed login button, attempt to connect to database with those credentials
	if (isset($_POST['login'])) {
		try {

			$user = $_POST['user'];
			$password = $_POST['password'];
			$db = getDB($user, $password);

			$url = 'database.php';
			$fields = array (
				'user' => $user,
				'password' => $password,
			);
//			$postVars = httpd_build_query($fields);
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, count($fields));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			
			$result = curl_exec($ch);
			curl_close($ch);

		//	header('Location: database.php');
		} catch (PDOException $e) {
			echo 'Invalid username or password; please try again';
			session_unset();
		}
	}
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='assets/js/ghost.js'></script>

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
		if (!isset($_SESSION['user'])) { ?>
		<h1>Login Page</h1>
			<div id='logonForm'>
				<form action='menu.php' name='login' class='logon' method='POST'>
					<input type='text' name='user' placeholder='Login' /> <br>
					<input type='password' name='password' placeholder='Password' /> <br>
					<div class='btnHeader'>
						<input type='submit' name='login' value='Login' />
					</div>		

				</form>
			<div>
	<?php
	} ?>

</body>
</html>

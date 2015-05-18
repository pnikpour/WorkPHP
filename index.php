<?php
	// Start session
	session_start();
	session_unset();
	session_destroy();
	session_write_close();
	setcookie(session_name(),'',0,'/');
	session_regenerate_id(true);

	// Include external functions for getting the current database connection
	include('lib.php');

	// Declare global variables
	global $user;
	global $password;
	global $numberOfRecords;
	global $db;	
?>


<?php
	// If user pressed login button, attempt to connect to database with those credentials
	if (isset($_POST['login'])) {
		try {

			$user = $_POST['user'];
			$password = $_POST['password'];
			$db = getDB($user, $password);

			$url = 'http://blueberryphp.com/database.php';
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
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js'></script>
	<script src='ghost.js'></script>

	<link rel='stylesheet' href='assets/styles.css' type='text/css' />
	<script type='text/javascript'>
	$('document').ready(function() {
	
		$('td').css('padding', '6px 10px');
		$('body').css('background-color', '#D0D0D0');	
	});
	</script>
</head>
<body>

<h1>Login Page</h1>
	<div id='logonForm'>
		<form action='database.php' name='login' class='logon' method='POST'>
			<input type='text' name='user' placeholder='Login' /> <br>
			<input type='password' name='password' placeholder='Password' /> <br>
			<div class='btnHeader'>
				<input type='submit' name='login' value='Login' />
			</div>		

		</form>
	<div>
</body>
</html>

<?php

	// Include external functions for getting the current database connection
	include('assets/php/lib.php');

	// Start session
	session_start();

//	if (session_status() === PHP_SESSION_NONE) {
	if (!isset($_SESSION['user'])) {
		session_unset();
		session_destroy();
		session_write_close();
//		setcookie(session_name(),'',0,'/');
//		session_regenerate_id(true);
	} else {
		header('Location: menu.php');
	}
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='assets/js/ghost.js'></script>

	<link rel='stylesheet' href='assets/css/styles.css' type='text/css' />
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
		<form action='login.php' name='login' class='logon' method='POST'>
			<input type='text' name='user' placeholder='Login' /> <br>
			<input type='password' name='password' placeholder='Password' /> <br>
			<div class='btnHeader'>
				<input type='submit' name='login' value='Login' />
			</div>		

		</form>
	<div>
</body>
</html>

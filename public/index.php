<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	// Include external functions for getting the current database connection
	include('assets/php/lib.php');

	if (!adminExists()) {
		setupAdmin();
	}

	if (!ifError()) {
		if (!isset($_SESSION['user'])) {
			session_unset();
			session_destroy();
			session_write_close();
	//		setcookie(session_name(),'',0,'/');
	//		session_regenerate_id(true);
		} else {
			header('Location: menu');
		}
	}
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src='assets/js/ghost.js'></script>
	<link rel='stylesheet' href='assets/css/styles.css' type='text/css' />
</head>
<body>
	<h1>Login Page</h1>
	<div id='logonForm'>
		<form action='login/' name='login' class='logon' method='POST'>
			<input type='text' name='user' placeholder='Login' /> <br>
			<input type='password' name='password' placeholder='Password' /> <br>
			<div class='btnHeader'>
				<input type='submit' name='login' value='Login' />
			</div>		

		</form>
	</div>
	<?php
		if (ifError()) {
			echo getErrorVar();
		}
	?>

</body>
</html>

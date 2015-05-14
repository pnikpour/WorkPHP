<?php
	session_start();
	session_unset();
	session_destroy();
	session_write_close();
	setcookie(session_name(),'',0,'/');
	session_regenerate_id(true);
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

<h1>Login Page</h1>

<form action='database.php' name='login' class='logon' method='post'>
	<input type='text' name='user' placeholder='Login' /> <br>
	<input type='password' name='password' placeholder='Password' />
	<input type='submit' name='login' value='Login' />
</form>
</body>
</html>

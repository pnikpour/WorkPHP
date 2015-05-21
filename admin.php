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

<form action='addUser.php' name='login' method='post'>
	<input type='text' class='ghost' name='user' placeholder='Admin Logon'/> <br>
	<input type='password' class='ghost' name='password' placeholder='Admin Password'/>
	<input type='submit' class='logon' name='login' value='Login' />
</form>
</body>
</html>

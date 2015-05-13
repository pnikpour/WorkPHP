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
</head>
<body>

<h1>Create and Edit Users Login</h1>

<form action='addUser.php' name='login' method='post'>
	<input type='text' class='logon' name='user' /> <br>
	<input type='password' class='logon' name='password' />
	<input type='submit' class='logon' name='login' value='Login' />
</form>
</body>
</html>

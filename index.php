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
</head>
<body>

<h1>Login Page</h1>

<form action='database.php' name='login' method='post'>
	<input type='text' name='user' /> <br>
	<input type='password' name='password' />
	<input type='submit' name='login' value='Login' />
</form>
</body>
</html>

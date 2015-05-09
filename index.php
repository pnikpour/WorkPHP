<?php
	session_start();
?>

<html>
<head>
</head>
<body>

<h1>Login Page</h1>

<form action='database.php' name='login' method='post'>
	<input type='text' name='username' /> <br>
	<input type='password' name='password' />
	<input type='submit' name='login' value='Login' />
</form>
</body>
</html>

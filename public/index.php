<?php
/**
 * Home and logon page for quikphp.com
 *
 * @author Parsa Nikpour <pnikpour@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2015 Parsa Nikpour
 */
?>

<?php
	// Write errors to screen as needed
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	// Include external functions for getting the current database connection
	include('assets/php/lib.php');

	dontCache();

	// If admin user does not exist, redirect to admin setup page
	if (!adminExists()) {
		setupAdmin();
	}

	// If logon failed, print error and display logon form again; otherwise, redirect to user dashboard
	if (!ifError()) {
		if (!isset($_SESSION['user'])) {
			session_unset();
			session_destroy();
			session_write_close();
		} else {
			header('Location: menu');
		}
	}
?>

<html>
<head>
<script type='text/javascript' src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script type='text/javascript' src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type='text/javascript' src='assets/js/effect.js' type='text/javascript'></script>

	<script src='assets/js/ghost.js'></script>
	<script src='assets/js/focus.js'></script>
	<link rel='stylesheet' href='assets/css/styles.css' type='text/css' />
	<title>QuikPHP Homebrew Work Order System</title>
</head>
<body>
	<header><img class='logo' src='assets/images/logo.png' alt='QuikPHP Logo'></header>
	<div id='logonForm'>
		<form action='login/' name='login' class='logon' method='POST'>
			<input type='text' name='user' id='user' placeholder='Login' /> <br>
			<input type='password' name='password' id='password' placeholder='Password' /> <br>
			<div class='btnHeader'>
				<input type='submit' class='button' name='login' value='Login' />
				<input type='submit' class='button' name='register' value='Register' />
			</div>		

		</form>
		<?php
			// Print the error to the screen if logon error has occurred
			if (ifError()) {
				echo getErrorVar();
			}
		?>
	</div>
</body>
</html>

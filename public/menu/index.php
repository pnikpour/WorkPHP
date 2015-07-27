<?php
/**
 * Menu page that also displays a dashboard containing available support tickets. By default
 * the admin will see all tickets (open and closed) whereas non-admin user will only see open
 * tickets created by the user.
 *
 * @author Parsa Nikpour <pnikpour@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2015 Parsa Nikpour
 */
?>

<?php
	
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include('../assets/php/lib.php');
	dontCache();

	checkLastActivity();
	redirectIfNotLoggedIn();
?>

<html>
<head>

	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='../assets/js/effect.js' type='text/javascript'></script>
	<link rel='stylesheet' href='../assets/css/styles.css' type='text/css' />
	<title>Main Menu</title>
</head>
<body>
<header><img class='logo' src='../assets/images/logo.png' alt='QuikPHP Logo'></header>

<h1>QuikPHP Workflow Menu</h1>

<div class='formContainer'>
	<form action="process.php" name='menu' id='menu' method='post'>
		<?php
			include '../assets/php/createNav.php';
			generateDashboard();
		?>

	</form>
</div>


</body>
</html>



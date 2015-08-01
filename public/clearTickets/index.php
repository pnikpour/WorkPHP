<?php
/**
 * Page for admins to clear all tickets in tickets table
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
	
	forbid(); // If not an admin, redirect to forbidden.php

	checkLastActivity();
	redirectIfNotLoggedIn();
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js?<?php echo time(); ?>"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js?<?php echo time(); ?>"></script>
	<script src='../assets/js/effect.js?<?php echo time(); ?>' type='text/javascript'></script>
	<link rel='stylesheet' href='../assets/css/styles.css?<?php echo time(); ?>' type='text/css' />
	<title>Clear Table - Confirmation</title>
</head>
<body>
<header><img class='logo' src='../assets/images/logo.png' alt='QuikPHP Logo'></header>
<h1>Clear Tickets</h1>

<form action='' name='clearTickets' id='clearTickets' method='post'>

	<?php include '../assets/php/createNav.php'; ?>

	<p class='para'>YOU ARE ABOUT TO CLEAR ALL EXISTING TICKETS IN THE TABLE. ARE YOU SURE YOU WANT
	TO DO THIS?</p>
	<input type='submit' class='button' name='submit' value='Submit' />
</form>

<?php

	// Clear the table
	if (isset($_POST['submit'])) {
		$query = "DELETE FROM tickets";
		$result = getDB()->prepare($query);
		$result->execute();
		printSuccess('Tickets table cleared successfully');
	}

	// Navigation link action controller
	navPOST();
?>



</body>
</html>



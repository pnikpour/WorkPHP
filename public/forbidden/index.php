<?php
/**
 * Redirect page for forbidden access
 *
 * @author Parsa Nikpour <pnikpour@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2015 Parsa Nikpour
 */
?>

<?php

	// Include external functions for getting the current database connection
	include('../assets/php/lib.php');

	dontCache();

?>


<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='../assets/js/ghost.js'></script>

	<link rel='stylesheet' href='../assets/css/styles.css' type='text/css' />
</head>
<body>
	<h1>Forbidden</h1>

	<p>You do not have access to this page</p>
</body>
</html>

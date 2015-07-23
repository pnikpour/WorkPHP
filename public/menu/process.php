<?php
/**
 * Menu event processor file. Will handle the edit ticket event.
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

	navPOST();
	
	// If edit button is pressed, send that data to the ticket form
	if (isset($_POST['btnEdit'])) {
		
	}
?>

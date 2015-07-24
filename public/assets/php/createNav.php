<?php
/**
 * Navigation menu script; renders admin options if allowed
 *
 * @author Parsa Nikpour <pnikpour@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2015 Parsa Nikpour
 */
?>

<?php
//	include('lib.php');
	echo
		"<nav>
		<ul>
			<li><input type='submit' class='button' id='home' name='home' value='Home' /></li>";
	if (isset($_SESSION['user'])) {
		echo"
			<li><input type='submit' class='button' id='ticket' name='ticket' value='Create Work Order' /></li>
			<li><input type='submit' class='button' id='filters' name='filters' value='Filters' /></li>
			<li><input type='submit' class='button' id='support' name='support' value='Support' /></li>
			<li><input type='submit' class='button' name='logout' value='Log Out' /></li>";
	}

	if (isset($_SESSION['user']) && isAdmin()) { 
		echo"
			<script>
				$('#filters').after(\"<li><input type='submit' class='button' id='addUser' name='addUser' value='Add Users' /></li>\");
				$('#addUser').after(\"<li><input type='submit' class='button' id='changePassword' name='changePassword' value='Change Password' /></li>\");
			</script>";
	}
	
	echo "</ul></nav>";

?>

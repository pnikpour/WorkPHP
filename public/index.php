<?php
//**************************************************************************
// This file is part of the BlueberryPHP project.
// 
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
// 
// Programmer: Parsa Nikpour 
// Date: 16 June 2014
// Description: 
// 
//**************************************************************************
?>

<?php
	// Write errors to screen as needed
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	// Include external functions for getting the current database connection
	include('assets/php/lib.php');

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
	//		setcookie(session_name(),'',0,'/');
	//		session_regenerate_id(true);
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
	<link rel='stylesheet' href='assets/css/styles.css' type='text/css' />
</head>
<body>
	<header><img class='logo' src='assets/images/logo.png' alt='BlueberryPHP Logo'></header>
	<div id='logonForm'>
		<form action='login/' name='login' class='logon' method='POST'>
			<input type='text' name='user' placeholder='Login' /> <br>
			<input type='password' name='password' placeholder='Password' /> <br>
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

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
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src='assets/js/ghost.js'></script>
	<link rel='stylesheet' href='assets/css/styles.css' type='text/css' />
</head>
<body>
	<h1>Login Page</h1>
	<div id='logonForm'>
		<form action='login/' name='login' class='logon' method='POST'>
			<input type='text' name='user' placeholder='Login' /> <br>
			<input type='password' name='password' placeholder='Password' /> <br>
			<div class='btnHeader'>
				<input type='submit' name='login' value='Login' />
			</div>		

		</form>
		<?php
		if (ifError()) {
			echo getErrorVar();
		}
		?>
	</div>
</body>
</html>

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
	
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include('../assets/php/lib.php');

	checkLastActivity();
	redirectIfNotLoggedIn();
?>

<html>
<head>

	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='../assets/js/effect.js' type='text/javascript'></script>
	<link rel='stylesheet' href='../assets/css/styles.css' type='text/css' />
	
</head>
<body>
<header><img class='logo' src='../assets/images/logo.png' alt='BlueberryPHP Logo'></header>
<?php
	navPOST();
?>


<h1>BlueberryPHP Workflow Menu</h1>

<input class='color' value='D0D0D0'>
	<script type='text/javascript' src='../assets/js/jscolor/jscolor.js'></script>
</input>

<script>
	$('.color').change(function() {
		var hex = $('.color').val();
		$('body').css('backgroundColor', hex);
		$('.button').css('backgroundColor', hex);
	});
</script>

<div class='formContainer'>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" name='menu' id='menu' method='post'>
		<?php include '../assets/php/createNav.php'; ?>
	</form>
</div>

<?php
	generateDashboard();
?>

</body>
</html>



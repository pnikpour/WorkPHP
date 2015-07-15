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
//	include('lib.php');
	echo
		"<nav>
			<input type='submit' class='button' id='home' name='home' value='Home' />";
	if (isset($_SESSION['user'])) {
		echo"
			<input type='submit' class='button' id='ticket' name='ticket' value='Create Work Order' />
			<input type='submit' class='button' id='filters' name='filters' value='Filters' />
			<input type='submit' class='button' id='support' name='support' value='Support' />
			<input type='submit' class='button' name='logout' value='Log Out' />";
	}

	if (isset($_SESSION['user']) && isAdmin()) { 
		echo"
			<script>
				$('#filters').after(\"<input type='submit' class='button' id='addUser' name='addUser' value='Add Users' />\");
				$('#addUser').after(\"<input type='submit' class='button' id='changePassword' name='changePassword' value='Change Password' />\");
			</script>";
	}
	
	echo "</nav>";

?>

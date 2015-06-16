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
session_start();

require('/var/www/html/public/assets/php/password_compat/lib/password.php');

function getDB() {
	try {
		return new PDO("mysql:host=localhost;dbname=workorder;charset=utf8", 'secureUser', 'BL3FFEE5WUsrJQnx');
	}
	catch (Exception $e) {
		session_unset();
		header('Location: index.php');
	}
}

function redirectIfNotLoggedIn() {
	if (!isset($_SESSION['user'])) {	
		header('Location: ../');
	}
}

function timestampSession() {
	$_SESSION['lastActivity'] = time();
}

function ifError() {
	if (isset($_SESSION['error'])) {
		return true;
	} else {
		return false;
	}
}

function setErrorVar($str) {
	$_SESSION['error'] = $str;
}

function getErrorVar() {
	$error = $_SESSION['error'];
	unset($_SESSION['error']);
	session_unset();
	return $error;
}

// Compares time with last activity; logs out if time expired
function checkLastActivity() {
	$seconds = 1800;	// 30 minutes
	if (isset($_SESSION['lastActivity'])) {	
		if (time() - $_SESSION['lastActivity'] > $seconds) {
			logout();
		}
	} else {
		timestampSession();
	}
	timestampSession();
}

function forbid() {
	$user = getUser();
	if (!isset($_SESSION['user'])) {	
		header('Location: ../forbidden');
	} else {
		if (!isAdmin() || $user = '') {
			header('Location: ../forbidden');
		}
	}

}

// Echo a table representing a header for inline queries
function printFilterHeader() {

	echo '	<table>
		<tr>
			<th>Ticket Number</th>
			<th>Date Created</th>
			<th>Problem Description</th>
			<th>Requestor</th>
			<th>Problem Code</th>
			<th>Assigned To</th>
			<th>Date Closed</th>
			<th>Status</th>
		</tr>';

}

function printFilterFooter() {
	echo '</table>';
}

function printRecords($arr) {
	foreach($arr as $a) {
		echo '<td>' . $a . '</td>';
	}
}

// Setup table displaying outstanding workorders; if regular user, display tickets created by that user; if admin,
// display all outstanding tickets
function generateDashboard() {
	if (isAdmin()) {
		$query = 'SELECT * FROM tickets';
		$result = getDB()->prepare($query);
		$result->bindParam(':requestor', $_SESSION['user']);
		$result->execute();	
	} else {
		$query = 'SELECT * FROM tickets WHERE requestor LIKE :requestor AND STATUS = :open';
		$status = 'OPEN';
		$result = getDB()->prepare($query);
		$result->bindParam(':requestor', $_SESSION['user']);
		$result->bindParam(':open', $status);
		$result->execute();	
	}


	printFilterHeader();
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$records = array();
		echo '<tr>';
//		$ticketNumber = $row['ticketNumber'];
//		$dateCreated = $row['dateCreated'];
//		$problemDescription = $row['problemDescription'];
//		$requestor = $row['requestor'];
//		$problemCode = $row['problemCode'];
//		$assignedTo = $row['assignedTo'];
//		$dateClosed = $row['dateClosed'];
//		$status = $row['status'];
	
		array_push($records, $row['ticketNumber'], $row['dateCreated'], $row['problemDescription'], $row['requestor'], 
		$row['problemCode'], $row['assignedTo'], $row['dateClosed'], $row['status']);
	

		printRecords($records);
		echo '</tr>';
		
	}
	printFilterFooter();

}

function doFilter() {
//	$query = 'SELECT * FROM tickets WHERE ticketNumber LIKE :ticketNumber AND status LIKE :status';
	$query = 'SELECT * FROM tickets WHERE status LIKE :status';
	$result = getDB()->prepare($query);
//	$result->bindParam(':ticketNumber', $_POST['ticketNumber']);
	$result->bindParam(':status', $_POST['status']);
	$result->execute();	

	printFilterHeader();
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$records = array();
		echo '<tr>';
		array_push($records, $row['ticketNumber'], $row['dateCreated'], $row['problemDescription'], $row['requestor'], 
		$row['problemCode'], $row['assignedTo'], $row['dateClosed'], $row['status']);
	

		printRecords($records);
		echo '</tr>';
		
	}
	printFilterFooter();
}

function navPOST() {
	if (isset($_POST['home'])) {
		header('Location: ../index.php');
	}
	if (isset($_POST['logout'])) {
		logout();
	} else
	if (isset($_POST['addUser'])) {
		header('Location: ../add');
	} else
	if (isset($_POST['ticket'])) {
		header('Location: ../ticket');
	} else
	if (isset($_POST['changePassword'])) {
		header('Location: ../password');
	} else
	if (isset($_POST['filters'])) {
		header('Location: ../filters');
	}

}

function userExists($user) {
	$query = 'SELECT * FROM users WHERE username LIKE :user';
	$result = getDB()->prepare($query);
	$result->execute(array(':user' => $user));
	$rows = $result->rowCount();
	echo $rows;
	if ($rows == 0) {
		return false;
	} else {
		return true;
	}
}

function adminExists() {
	$query = 'SELECT username FROM users WHERE groups LIKE :group';
	$result = getDB()->prepare($query);
	$result->execute(array(':group' => 'Administrator'));
	$rows = $result->rowCount();
	if ($rows == 0) { // The admin does not exist
		return false;
	} else { // The admin does exist
		return true;
	}
	
}

function setupAdmin() {
	header('Location: initAdmin/');
}

function getMaxTicketNumber() {	
	$stmt = getDB()->query("SELECT MAX(ticketNumber) from tickets");
	$newID = $stmt->fetch(PDO::FETCH_NUM);
	$newID = $newID[0]+1;
	if ($newID < 1000) {
		$newID = 1000;
	}

	return $newID;
}



function isAdmin() {
	$user = getUser();
	$query = 'SELECT groups FROM workorder.users WHERE username LIKE :user';
	$result = getDB()->prepare($query);
	$result->bindParam(':user', $user);
	$result->execute();
	$rows = $result->fetch(PDO::FETCH_ASSOC);
	$group = $rows['groups'];
	if ($group == 'Administrator') {
		return true;
	} else {
		return false;
	}
}

function getPassword() {
	return $_SESSION['password'];
}

function logout() {
	session_unset();
	session_destroy();
	session_write_close();

	header('Location: ../index.php');
}

function passwordsMatch($pass1, $pass2, $prompt) {
	if ($pass1 === $pass2) {
		return true;
	} else {
		if ($prompt) {
			echo "<p class='error'>The passwords do not match</p>";
		}
		return false;
	}
}

function meetsPasswordLength($password, $prompt) {
	if (strlen($password) < 6 || strlen($password) < 6) {
		if ($prompt) {
			echo "<p class='error'>The password length requirement has not been met; please provide a password of at least six characters long</p>";
		}
		return false;
	} else {
		return true;
	}
}

function getUser() {
	return $_SESSION['user'];
}

?>

<?php
session_start();

require('/var/www/html/public/password_compat/lib/password.php');

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
	} else {
		$query = 'SELECT * FROM tickets WHERE requestor LIKE :requestor';
	}
	$result = getDB()->prepare($query);
	$result->bindParam(':requestor', $_SESSION['user']);
	$result->execute();	

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
	header('Location: ../index.php');
}

function getUser() {
	return $_SESSION['user'];
}

?>

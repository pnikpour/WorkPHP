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

function forbid() {
	$user = getUser();
	if (!isAdmin() || $user = '' || !(isset($_SESSION['user']))) {
		header('Location: ../forbidden');
	}
}

// Setup table displaying outstanding workorders; if regular user, display tickets created by that user; if admin,
// display all outstanding tickets
function generateDashboard() {
	if (isAdmin()) {
		$query = 'SELECT * FROM tickets';
	} else {
		$query = 'SELECT * FROM tickets WHERE requestor LIKE :requestor';
		$result = getDB()->prepare($query);
		$result->bindParam(':requestor', $_SESSION['user']);
		$result->execute();
		
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$ticketNumber = $row['ticketNumber'];
			$dateCreated = $row['dateCreated'];
			$problemDescription = $row['problemDescription'];
			$requestor = $row['requestor'];
			$problemCode = $row['problemCode'];
			$assignedTo = $row['assignedTo'];
			$dateClosed = $row['dateClosed'];
			$status = $row['status'];

			echo $ticketNumber;
		}
	}
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

function getMaxTicketNumber($db) {	
	$stmt = $db->query("SELECT MAX(ticketNumber) from tickets");
	$newID = $stmt->fetch(PDO::FETCH_NUM);
	$newID = $newID[0]+1;
	if ($newID < 1000) {
		$newID = 1000;
	}

	return $newID;
}



function isAdmin() {
	$user = getUser();
	$db = getDB();
	$query = 'SELECT groups FROM workorder.users WHERE username LIKE :user';
	$result = $db->prepare($query);
	$result->bindParam(':user', $user);
	$result->execute();
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
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

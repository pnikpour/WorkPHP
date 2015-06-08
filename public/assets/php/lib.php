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

function forbid($user) {
	if (!isAdmin($user, getDB()) || $user = '') {
		header('Location: forbidden.php');
	}
}

function navPOST() {
	if (isset($_POST['home'])) {
		header('Location: index.php');
	}
	if (isset($_POST['logout'])) {
		logout();
	} else
	if (isset($_POST['addUser'])) {
		header('Location: addUser.php');
	} else
	if (isset($_POST['ticket'])) {
		header('Location: ticket.php');
	} else
	if (isset($_POST['changePassword'])) {
		header('Location: changePassword.php');
	}

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



function isAdmin($user, $db) {
	$query = 'SELECT groups FROM workorder.users WHERE username LIKE "' . $user . '"';
	$stmt = $db->prepare($query);
	$stmt->execute();
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	$group = $rows['groups'];
	if ($group == 'Administrator') {
		return true;
	} else {
		return false;
	}
}

function getPassword() {
	if (isset($_POST['password'])) {
		$password = $_POST['password'];
		$_SESSION['password'] = $password;
	} else {
		$password = $_SESSION['password'];
	}
	return $password;
}

function logout() {
	session_unset();
	header('Location: index.php');
}

function getUser() {
//	if (isset($_POST['user'])) {
//		$user = $_POST['user'];
//		$_SESSION['user'] = $user;
//
//	} else {
//		$user = $_SESSION['user'];
//	}
	return $_SESSION['user'];
}
//if (isset($_SESSION['user'])) {
//		$user = $_SESSION['user'];
//	} else
//	if (isset($_POST['user'])) {
//		$user = $_POST['user'];
//	}
//
//	return $user;
//}

?>

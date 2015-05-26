<?php

function getDB($user, $password) {
	return new PDO("mysql:host=localhost;dbname=workorder;charset=utf8", $user, $password);
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

function getPassword() {
	if (isset($_POST['password'])) {
		$password = $_POST['password'];
		$_SESSION['password'] = $password;
	} else {
		$password = $_SESSION['password'];
	}
	return $password;
}

function getUser() {
	if (isset($_POST['user'])) {
		$user = $_POST['user'];
		$_SESSION['user'] = $user;

	} else {
		$user = $_SESSION['user'];
	}

	return $user;
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

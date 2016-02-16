<?php
/**
 * Library file containing PHP functions used in this project
 *
 * @author Parsa Nikpour <pnikpour@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2015 Parsa Nikpour
 */
?>

<?php
session_start();

// Require password_compat library
require('/var/www/quikphp.com/public/assets/php/password_compat/lib/password.php');

// Return the current working database
function getDB() {
	try {
		return new PDO("mysql:host=localhost;dbname=workorder;charset=utf8", 'secureUser', 'BL3FFEE5WUsrJQnx');
	}
	catch (Exception $e) {
		session_unset();
		header('Location: index.php');
	}
}

// Tell the browser to not cache the web page
function dontCache() {
	echo '<meta http-equiv="cache-control" content="no-cache">';
	echo '<meta http-equiv="expires" content="0">';
	echo '<meta http-equiv="pragma" content="no-cache">';
}

// If visitor is not signed in, redirect to logon page
function redirectIfNotLoggedIn() {
	if (!isset($_SESSION['user'])) {	
		header('Location: ../');
	}
}

// Get the last user activity timestamp
function timestampSession() {
	$_SESSION['lastActivity'] = time();
}

// Check session variable for an error; used for logon processing
function ifError() {
	if (isset($_SESSION['error'])) {
		return true;
	} else {
		return false;
	}
}

// Set error session variable true or false
function setErrorVar($str) {
	$_SESSION['error'] = $str;
}

// Print success string
function printSuccess($str) {
	echo "<p class='success'>$str</p>";
}

// Print error string
function printError($str) {
	echo "<p class='error'>$str</p>";
}

// Get error status through session variable; unset the variable, and the current session
function getErrorVar() {
	$error = $_SESSION['error'];
	unset($_SESSION['error']);
//	session_unset();
	return $error;
}

// Compares time with last activity; logs out if time expired
function checkLastActivity() {
	$seconds = 900;	// 15 minutes
	if (isset($_SESSION['lastActivity'])) {	
		if (time() - $_SESSION['lastActivity'] > $seconds) {
			logout();
		}
	}
	timestampSession();
}

// Used for admin pages; if the user is not logged in, or is not an admin, redirect to forbidden page
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

// Echo a table header representing user tasks
function printTaskListFilterHeader() {

	echo '	<table border=1>
		<tr>
			<th>Task Name</th>
			<th>Task Description</th>
			<th>Task Completed?</th>
		</tr>';

}

// Echo a table representing a header for queried tickets
function printTicketFilterHeader() {

	echo '	<table border=1>
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

// Echo a table representing a header for queried users
function printUserFilterHeader() {

	echo '	<table border=1>
		<tr>
			<th>Username</th>
		</tr>';

}

// Print table footer
function printFilterFooter() {
	echo '</table>';
}

// Accepts ticket object field and print the field in dashboard table
function printRecords($arr) {
	foreach($arr as $a) {
		echo '<td>' . $a . '</td>';
	}
}

// Put function on hold to implement; opens ticket 
function appendEditRecordButton($index) {
//	echo '<td><input type="submit" name="btnEdit" value="Edit"></td>';
}

// Display all user tasks to Task List page; only outputs tasks belonging to the user
function generateTaskListDashboard() {
	$query = 'SELECT * FROM taskList WHERE taskOwner LIKE :taskOwner ORDER BY taskCompleted';
	$result = getDB()->prepare($query);
	$result->bindParam(':taskOwner', $_SESSION['user']);
	$result->execute();	
	printTaskListFilterHeader();
	$numRecords = 0;
	
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$records = array();
		echo '<tr>';
	
		array_push($records, $row['taskName'], $row['taskDescription'], $row['taskCompleted']);	

		printRecords($records);
		$numRecords++;
		echo '</tr>';
		
	}
	printFilterFooter();

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

	printTicketFilterHeader();
	$numRecords = 0;
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$records = array();
		echo '<tr>';
	
		array_push($records, $row['ticketNumber'], $row['dateCreated'], $row['problemDescription'], $row['requestor'], 
		$row['problemCode'], $row['assignedTo'], $row['dateClosed'], $row['status']);
	

		printRecords($records);
		appendEditRecordButton($numRecords);
		$numRecords++;
		echo '</tr>';
		
	}
	printFilterFooter();

}

// Query filter for tickets; generate table containing support tickets that match the query
function filterTickets() {
	$query = 'SELECT * FROM tickets WHERE status LIKE :status AND ticketNumber = :ticketNumber AND requestor LIKE :requestor';
	$status = $_POST['status'];
	$ticketNumber = $_POST['ticketNumber'];
	$requestor = $_POST['requestor'];

	$prepareAgain = false;
	
	$result = getDB()->prepare($query);
	if ($ticketNumber == "") {
		$query = 'SELECT * FROM tickets WHERE status LIKE :status AND ticketNumber >= 0 AND requestor LIKE :requestor';
		$ticketNumber = "%";
	} else {
		$result->bindParam(':ticketNumber', $ticketNumber);
		$prepareAgain = true;
	}

	// If requestor queried is empty, substitute with wildcard
	if ($requestor == "") {
		$requestor = '%';
	}

	// If status queried is empty, substitute with wildcard
	if ($status == "") {
		$status = '%';
	}
	
	// If ticket number queried is empty, prepare the query again but exclude the ticket number
	if (!$prepareAgain) {
		$result = getDB()->prepare($query);
	}

	$result->bindParam(':status', $status);
	$result->bindParam(':requestor', $requestor);
	$result->execute();	

	printTicketFilterHeader();
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

// Query filter for users; generate table containing existing users in the database that match the query
function filterUsers() {
	$query = 'SELECT username FROM users WHERE username LIKE :username';
	$username = $_POST['username'];
	
	$result = getDB()->prepare($query);

	if ($username == "") {
		$username = '%';
	}

	$result->bindParam(':username', $username);
	$result->execute();	

	printUserFilterHeader();
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$records = array();
		echo '<tr>';
		array_push($records, $row['username']);
		printRecords($records);
		echo '</tr>';
		
	}
	printFilterFooter();
}


// Nav behavior function
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
	} else
	if (isset($_POST['register'])) {
		header('Location: ../register');
	} else 
	if (isset($_POST['support'])) {
		header('Location: ../support');
	}  else
	if (isset($_POST['taskList'])) {
		header('Location: ../taskList');
	} else
	if (isset($_POST['clearTickets'])) {
		header('Location: ../clearTickets');
	}
	
}

// Queries database and checks if the given username exists
function userExists($user) {
	$query = 'SELECT * FROM users WHERE username LIKE :user';
	$result = getDB()->prepare($query);
	$result->execute(array(':user' => $user));
	$rows = $result->rowCount();
	if ($rows == 0) {
		return false;
	} else {
		return true;
	}
}

// Queries database and returns if an admin exists on the server
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

// Redirect to admin setup page
function setupAdmin() {
	header('Location: initAdmin/');
}

// Returns the next ticket number once a ticket has been created
function getMaxTicketNumber() {	
	$stmt = getDB()->query("SELECT MAX(ticketNumber) from tickets");
	$newID = $stmt->fetch(PDO::FETCH_NUM);
	$newID = $newID[0]+1;
	if ($newID < 1000) {
		$newID = 1000;
	}

	return $newID;
}

// Returns if the currently logged in user is an admin
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

// Logout of current session
function logout() {
	session_unset();
	session_destroy();
	session_write_close();

	header('Location: ../index.php');
}

// Compares two cleartext passwords; return true if the passwords match
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

// Check if new password meets length requirements; if the password is less than six characters long, throw error and return false
function meetsPasswordLength($password, $prompt) {
	if (strlen($password) < 6) {
		if ($prompt) {
			echo "<p class='error'>The password length requirement has not been met; please provide a password of at least six characters long</p>";
		}
		return false;
	} else {
		return true;
	}
}

// Get currently logged in username
function getUser() {
	return $_SESSION['user'];
}

?>

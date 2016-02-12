<?php
/**
 * Ticket creation/edit page.
 *
 * @author Parsa Nikpour <pnikpour@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2015 Parsa Nikpour
 */
?>

<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include('../assets/php/lib.php');
	dontCache();

	checkLastActivity();
	redirectIfNotLoggedIn();
	date_default_timezone_set('America/Los_Angeles');
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js?<?php echo time(); ?>"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js?<?php echo time(); ?>"></script>
	<script src='../assets/js/effect.js?<?php echo time(); ?>' type='text/javascript'></script>
	<script src='../assets/js/lib.js?<?php echo time(); ?>' type='text/javascript'></script>
	<link rel='stylesheet' href='../assets/css/styles.css?<?php echo time(); ?>' type='text/css' />
	<title>Create Work Order</title>
</head>

<body>

<header><img class='logo' src='../assets/images/logo.png' alt='QuikPHP Logo'></header>
<?php
	// Governs when the user submits a ticket and refreshes the page; will
	// increment the ticket number count by one
	if (isset($_POST['saveTaskList'])) {
		
		// Submit the ticket to the database
		$ticketNumber = getMaxTicketNumber();
		$requestor = $_SESSION['user'];
		$dateCreated = $_POST['dateCreated'];
		$problemDescription = $_POST['problemDescription'];
		$problemCode = $_POST['problemCode'];
		$assignedTo = $_POST['assignedTo'];
		$dateClosed = $_POST['dateClosed'];
		$status = $_POST['status'];
		$query = "INSERT INTO tickets (ticketNumber, requestor, dateCreated, problemDescription, problemCode, assignedTo, status, dateClosed) values (:ticketNumber, :requestor, :dateCreated, :problemDescription, :problemCode, :assignedTo, :status, :dateClosed);";
		
		$stmt = getDB()->prepare($query);
		$stmt->bindParam(':ticketNumber', $ticketNumber);
		$stmt->bindParam(':requestor', $requestor);
		$stmt->bindParam(':dateCreated', $dateCreated);
		$stmt->bindParam(':problemDescription', $problemDescription);
		$stmt->bindParam(':problemCode', $problemCode);
		$stmt->bindParam(':assignedTo', $assignedTo);
		$stmt->bindParam(':status', $status);
		$stmt->bindParam(':dateClosed', $dateClosed);

		$stmt->execute();
	}
	navPOST();

?>


<h1>My Task List</h1>

<div class='formContainer'>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name='ticket' id='ticket' method='post'>

	<?php include '../assets/php/createNav.php'; ?>
	
	<table border=1>
		<tr>
			<th>Task Name</th>
			<th>Task Description</th>
			<th>Completed?</th>
		</tr>
		<tr>
			<td>
				<input type='text' name='taskName'/>
			</td>
			<td>
				<textarea rows='5' name='taskDescription'></textarea></td>
			</td>
			<td>
				<input type='checkbox' name='taskCompleted'/>
			</td>
		</tr>
		<tr>
			<td>
				<input type='button' name='newTask'/>
			</td>
			<td>
				<input type='submit' name='saveTaskList' value='Save Task List'/>
			</td>
		</tr>
	</table>
</div>
</body>
</html>

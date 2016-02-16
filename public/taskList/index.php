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
	if (isset($_POST['addTask'])) {
		$taskName = $_POST['taskName0'];
		$taskOwner = $_SESSION['user'];
		$taskDescription = $_POST['taskDescription0'];
	
		if (isset($_POST['taskCompleted0'])) {
			$taskCompleted = true;
		} else {
			$taskCompleted = false;
		}

		$query = 'INSERT INTO taskList (taskName, taskOwner, taskDescription, taskCompleted) VALUES (:taskName, :taskOwner, :taskDescription,
			  :taskCompleted)';

		// Submit the task to the database
		$stmt = getDB()->prepare($query);
		$stmt->bindParam(':taskName', $taskName);
		$stmt->bindParam(':taskOwner', $taskOwner);
		$stmt->bindParam(':taskDescription', $taskDescription);
		$stmt->bindParam(':taskCompleted', $taskCompleted);
		$stmt->execute();
	}
	navPOST();

?>


<h1>My Task List</h1>

<div class='taskView'>
	<form action=""  method='post'>

		<?php include '../assets/php/createNav.php'; ?>
		
		<div class='taskTableView'>
			<table name='taskInputTable' id='taskInputTable' border=1>
				<tr>
					<th>Task Name</th>
					<th>Task Description</th>
					<th>Completed?</th>
					<th>Save</th>
				</tr>
				<tr>
					<td>
						<input type='text' name='taskName0' id='taskName0'/>
					</td>
					<td>
						<input type='text' name='taskDescription0' id='taskDescription0'/>
					</td>
					<td>
						<input type='checkbox' name='taskCompleted0' id='taskCompleted0'/>
					</td>
					<td>
						<input type='submit' name='addTask' value='+'/>
					</td>
				</tr>
			</table>
			<br/>
			<?php generateTaskListDashboard(); ?>
			<table>
				<td><input type='submit' name='saveTaskList' value='Save Task List'/></td>
			</table>
		</div>
	</form>
</div>

<?php
	if (isset($_POST['saveTaskList'])) {
		echo $_POST['taskName2'];
	}
?>
</body>
</html>

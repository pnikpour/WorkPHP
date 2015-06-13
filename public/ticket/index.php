<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include('../assets/php/lib.php');
	checkLastActivity();
	redirectIfNotLoggedIn();
	date_default_timezone_set('America/Los_Angeles');
?>

<html>
<head>
	<script type='text/javascript' src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script type='text/javascript' src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type='text/javascript' src='../assets/js/effect.js' type='text/javascript'></script>
	<link rel='stylesheet' href='../assets/css/styles.css' type='text/css' />
</head>

<body>
<?php
	// Governs when the user submits a ticket and refreshes the page; will
	// increment the ticket number count by one
	if (isset($_POST['saveNew'])) {
		
		// Submit the ticket to the database
		$ticketNumber = getMaxTicketNumber();
		$requestor = $_SESSION['user'];
		$dateCreated = $_POST['dateCreated'];
		$problemDescription = $_POST['problemDescription'];
		$problemCode = $_POST['problemCode'];
		$assignedTo = $_POST['assignedTo'];
		$dateClosed = $_POST['dateClosed'];
		$status = $_POST['status'];
		$query = "INSERT INTO tickets (ticketNumber, requestor, dateCreated, problemDescription, problemCode, assignedTo, status, dateClosed) values ('$ticketNumber', '$requestor', '$dateCreated', '$problemDescription', '$problemCode', '$assignedTo', '$status', '$dateClosed');";
		if (!getDB()->exec($query)) {
			print_r(getDB()->errorInfo()); 
		}
	}
	navPOST();

?>


<h1>Form</h1>

<div class='formContainer'>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name='ticket' id='ticket' method='post'>

	<?php include '../assets/php/createNav.php'; ?>
	
	<table border=1>
		<tr>
			<th><h2>Ticket Number</h2></th>
			<th><h2>Requestor</h2></th>
			<th><h2>Date Created</h2></th>
			<th><h2>Problem Code</h2></th>
		</tr>
		<tr>
			<td>
				<?php
					$newID = getMaxTicketNumber();
					echo "<input type='text' readonly='true' name='ticketNumber' value=$newID />";
				?>
			</td>
			<td>
				<?php
					$requestor = $_SESSION['user'];
					echo "<input type='text' readonly='true' name='requestor' value=$requestor />";
				?>
			</td>
			<td>
				<?php
					$date = date("Y-m-d");
					$date = date("Y-m-d", strtotime(str_replace('-', '/', $date)));
					echo "<input type='text' name='dateCreated' value=$date readonly='true' />";
				?>
			<td>
			<select name='problemCode'>
				<?php
				try {
					$table = "tickets";
					$col = "problemCode";
					$sql = 'SHOW COLUMNS FROM '.$table.' WHERE field="'.$col.'"';
					$row = getDB()->query($sql)->fetch(PDO::FETCH_ASSOC);
					foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
						echo("<option>$option</option>");
					}
				} catch (PDOException $e) {
					echo "ERROR: " . $e->getMessage();
				}	
				?>
			</select>
			</td>
		</tr>
		<tr>
			<th colspan='4'><h2>Problem Details</h2></th>
		</tr>
		<tr>
			<td colspan='4'><textarea rows='5' style='width: 100%;'  name='problemDescription'></textarea></td>
		</tr>
	</table>
	<br>
	<table border=1>
		<tr>
			<th><h2>Assigned To</h2></th>
			<th><h2>Status</h2></th>
			<th><h2>Date Closed</h2></th>
		</tr>
		<tr>
			<td>
			<select name='assignedTo'>
				<?php
					$table = "tickets";
					$col = 'assignedTo';
					$sql = 'SHOW COLUMNS FROM '.$table.' WHERE field="'.$col.'"';
					$row = getDB()->query($sql)->fetch(PDO::FETCH_ASSOC);
					foreach(explode("','", substr($row['Type'],6,-2)) as $option) {
						echo ("<option>$option</option>");
					}
				?>
			</select>
			</td>
			<td>
			<select name='status' onchange='var today = new Date(); var dd = today.getDate(); var mm = today.getMonth()+1; mm = (mm < 10 ? "0" : "") + mm; var yyyy = today.getFullYear(); document.getElementById("dateClosed").value = yyyy + "-" + mm + "-" + dd'>
			<?php
				$table = "tickets";
				$col = 'status';
				$sql = 'SHOW COLUMNS FROM '.$table.' WHERE field="'.$col.'"';
				$row = getDB()->query($sql)->fetch(PDO::FETCH_ASSOC);
				foreach(explode("','", substr($row['Type'],6,-2)) as $option) {
					echo ("<option>$option</option>");
				}
			?>
			</select>
			</td>
			<td>
				<input type='text' name='dateClosed' id='dateClosed' />
			</td>
		</tr>
	</table>

	<input type='submit' class='button' name='saveNew' value='Save and New' />
	</form>
</div>
</body>
</html>

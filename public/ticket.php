<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
	session_start();
	include('assets/php/lib.php');
	global $user;
	global $password;
	global $numberOfRecords;
	global $db;	
	
	$user = getUser();
	$password = getPassword();
	$db = getDB($user, $password);
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link rel='stylesheet' href='../assets/styles.css' type='text/css' />
	<script type='text/javascript'>
	$('document').ready(function() {
	
		$('td').css('padding', '6px 10px');
		$('body').css('background-color', '#D0D0D0');	
	});
	</script>
</head>
<body>

<?php
	// Governs when the user submits a ticket and refreshes the page; will
	// increment the ticket number count by one
	if (isset($_POST['saveNew'])) {
		
		// Submit the ticket to the database
		$ticketNumber = getMaxTicketNumber($db);
		$dateCreated = $_POST['dateCreated'];
		$problemDescription = $_POST['problemDescription'];
		$problemCode = $_POST['problemCode'];
		$assignedTo = $_POST['assignedTo'];
		$dateClosed = $_POST['dateClosed'];
		$status = $_POST['status'];
		$query = "INSERT INTO tickets (ticketNumber, dateCreated, problemDescription, problemCode, assignedTo, status, dateClosed) values ('$ticketNumber', '$dateCreated', '$problemDescription', '$problemCode', '$assignedTo', '$status', '$dateClosed');";
		if (!$db->exec($query)) {
			print_r($db->errorInfo()); 
		}
		
	} elseif (isset($_POST['logout'])) {
		header('Location: index.php');
	}
	// Check user session; if the session is new, use post data from logon form; otherwise renew user credentials
	// with session variables
	if (!isset($_SESSION['user'])) {
		$_SESSION['user'] = $_POST['user'];
		$_SESSION['password'] = $_POST['password'];
		$user = $_SESSION['user'];
		$password = $_SESSION['password'];
	}
	$user = $_SESSION['user'];
	$password = $_SESSION['password'];
	$hostname = "localhost";
	try {
		$db = getDB($user, $password);
	} catch (PDOException $e) {
		echo 'ERROR:' . $e->getMessage();
		session_unset();
		exit();
	}
//	unset($db);
?>


<h1>Form</h1>

<div class='formContainer'>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name='ticket' id='ticket' method='post'>
	<div class='btnHeader'>
		<input type='submit' name='saveNew' value='Save and New' />
		<input type='button' name='clear' value='Clear' onclick="document.getElementById('ticket').reset()" />
		<input type='submit' name='logout' value='Log Out' />
	</div>

	<table border=1>
		<tr>
			<th><h2>Ticket Number</h2></th>
			<th><h2>Date Created</h2></th>
			<th><h2>Problem Code</h2></th>
		</tr>
		<tr>
			<td>
			<?php
		
			try {
				$db = getDB($user, $password);
			} catch (PDOException $e) {
				echo 'ERROR: ' . $e->getMessage();
				session_unset();
			}
			
			$newID = getMaxTicketNumber($db);
			echo "<input type='text' readonly='true' name='ticketNumber' value=$newID />"
			?>
			</td>
			<td>
			<?php
				$date = date("Y-m-d");
				$date = date("Y-m-d", strtotime(str_replace('-', '/', $date)));
				echo "<input type='text' name='dateCreated' value=$date readonly='true' />"
			?>
			<td>
			<select name='problemCode'>
			<?php
				try {
				$db = getDB($user, $password);
				$table = "tickets";
				$col = "problemCode";
				$sql = 'SHOW COLUMNS FROM '.$table.' WHERE field="'.$col.'"';
				    $row = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
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
			<th colspan='3'><h2>Problem Details</h2></th>
		</tr>
		<tr>
			<td colspan='3'><textarea rows='5' style='width: 100%;'  name='problemDescription'></textarea></td>
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
				$db = getDB($user, $password);
				$table = "tickets";
				$col = 'assignedTo';
				$sql = 'SHOW COLUMNS FROM '.$table.' WHERE field="'.$col.'"';
				$row = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
				foreach(explode("','", substr($row['Type'],6,-2)) as $option) {
					echo ("<option>$option</option>");
				}
			?>
			</select>
			</td>
			<td>
			<select name='status' onchange='var today = new Date(); var dd = today.getDate(); var mm = today.getMonth()+1; mm = (mm < 10 ? "0" : "") + mm; var yyyy = today.getFullYear(); document.getElementById("dateClosed").value = yyyy + "-" + mm + "-" + dd'>
			<?php
				$db = getDB($user, $password);
				$table = "tickets";
				$col = 'status';
				$sql = 'SHOW COLUMNS FROM '.$table.' WHERE field="'.$col.'"';
				$row = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
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
	</form>
</div>
</body>
</html>

<?php
	session_start();
	include('lib.php');
	global $user;
	global $password;
	global $numberOfRecords;
	
?>

<html>
<head>
</head>
<body>

<?php

	// Governs when the user submits a ticket and refreshes the page; will
	// increment the ticket number count by one
	if (isset($_POST['saveNew'])) {
		$user = $_SESSION['user'];
		$password = $_SESSION['password'];
		echo 'The user is ' . $user;
	}
	if (!isset($_SESSION['user'])) {
		echo 'New SESSION';
		$_SESSION['user'] = $_POST['user'];
		$_SESSION['password'] = $_POST['password'];
		$user = $_SESSION['user'];
		$password = $_SESSION['password'];

		echo 'The user is ' . $user;
	}
	$user = $_SESSION['user'];
	$password = $_SESSION['password'];
	$hostname = "localhost";

	try {
		$db = getDB($user, $password);
	} catch (PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
		session_unset();
	}


	$query = "show schemas";
	$result = $db->query($query);

	if ($result->rowCount() > 0) {
	      echo "Database" . "<br>";
	      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		 echo $row["Database"] . "<br>";
	      }
	}
	else {
	     // echo "0 results";
	}
	$query = "use workorder";
	$db->query($query);

	$query = "select ticketnumber from tickets";
	$result = $db->query($query);
	echo "Ticket Number" . "<br>";
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	      echo $row['ticketNumber'] . "<br>";
	}

//	unset($db);
?>


<h1>Form</h1>

<form action="database.php" name='login' method='post'>
<input type='submit' name='saveNew' value='Save and New' />
<table border=1>
	<tr>
		<th>Ticket Number</th>
		<th>Date Created</th>
		<th>Problem Code</th>
	</tr>
	<tr>
		<td>
		<?php
		$numberOfRecords = 0;
	
		try {
			$db = getDB($user, $password);
		} catch (PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
			session_unset();
		}

		$query = "use workorder";
		$db->query($query);

		$query = "select ticketnumber from tickets";
		$result = $db->query($query);
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$numberOfRecords++;
		}
		echo "<input type='text' readonly='true' name='ticketNumber' value=$numberOfRecords />"
		?>
		</td>
		<td>
		<?php
			$date = date("Y-m-d H:i:s");
			echo "<input type='text' name='dateCreated' value=$date readonly=true />"
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
		<th colspan='3'>Problem Details</th>
	</tr>
	<tr>
		<td colspan='3'><textarea rows='4' cols='40' name='problemDescription'></textarea></td>
	</tr>
</table>
<br>
<table border=1>
	<tr>
		<th>Assigned to</th>
		<th>Status</th>
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
		<select name='status'>
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
	</tr>
</table>
</form>
</body>
</html>



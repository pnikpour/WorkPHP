<?php
	if (!isset($_SESSION['username'])) {
		session_start();
	}
//		session_unset();
//		session_start();
//	}
?>

<html>
<head>
</head>
<body>

<?php

if (isset($_POST['saveNew'])) {
	//session_unset();
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	//echo $_SERVER['PHP_SELF'];
}
else
{
	if (!isset($_SESSION['username'])) {
		echo 'pingas';
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];

	}
	else {
	//	$username = $_SESSION['username'];
	//	$password = $_SESSION['password'];
	}
}
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;
$hostname = "localhost";

try {
	$db = new PDO("mysql:host=localhost;dbname=workorder;charset=utf8", $username, $password);
} catch (PDOException $e) {
	echo 'ERROR: ' . $e->getMessage();
	session_unset();
}

$_SESSION['db'] = $db;

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

unset($db);
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
		<td><input type='text' readonly='true' name='ticketNumber' /></td>
		<td><input type='text' name='dateCreated' /></td>
		<!--	<textarea rows='4' cols='40' name='problemDescription' />-->
		<td>

		<select name='problemCode'>
		<?php
		$db = $_SESSION['db'];
		$table = "tickets";
		$col = "problemCode";
		$sql = 'SHOW COLUMNS FROM '.$table.' WHERE field="'.$col.'"';
		    $row = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
		    foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
		    print("<option>$option</option>");
		}
		?>
		</select>
		</td>
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
			<option value="pnikpour">pnikpour</option>
		</select>
		</td>
		<td>
		<select name='status'>
			<option></option>
			<option value="OPEN">OPEN</option>
			<option value="CLOSED">CLOSED</option>
		</select>
		</td>
	</tr>
</table>
</form>
</body>
</html>

<?php
?>

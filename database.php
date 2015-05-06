<html>
<head>
</head>
<body>

<h1>Form</h1>

<form action='database.php' name='login' method='post'>
	<input type='text' readonly='true' name='ticketNumber' /><br>
	<input type='text' name='dateCreated' />
<!--	<textarea rows='4' cols='40' name='problemDescription' />-->
	<select name='problemCode'>
		<option></option>
		<option value="INTERNET">INTERNET</option>
		<option value="BOOT ISSUE">BOOT ISSUE</option>
		<option value="INSTALL">INSTALL</option>
	</select>
	<select name='assignedTo'>
		<option value="pnikpour">pnikpour</option>
	</select>
	<input type='text' name='dateCreated' />
	<select name='status'>
		<option></option>
		<option value="OPEN">OPEN</option>
		<option value="CLOSED">CLOSED</option>
	</select><br>
</form>
</body>
</html>

<?php

// $username = $_POST['username'];
// $password = $_POST['password'];
// $hostname = "localhost";

// $db = new PDO("mysql:host=localhost;dbname=workorder;charset=utf8", $username, $password);


// $query = "show schemas";
// $result = $db->query($query);

// if ($result->rowCount() > 0) {
	// echo "Database" . "<br>";
	// while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		// echo $row["Database"] . "<br>";
	// }
// }
// else {
	// echo "0 results";
// }
// $query = "use workorder";
// $db->query($query);

// $query = "select ticketnumber from tickets";
// $result = $db->query($query);
// echo "Ticket Number" . "<br>";
// while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	// echo $row['ticketNumber'] . "<br>";
// }

// unset($db);
// ?>
<?php

$username = $_POST['username'];
$password = $_POST['password'];
$hostname = "localhost";

$db = new PDO("mysql:host=localhost;dbname=workorder;charset=utf8", $username, $password);


$query = "show schemas";
$result = $db->query($query);

if ($result->rowCount() > 0) {
	echo "Database" . "<br>";
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		echo $row["Database"] . "<br>";
	}
}
else {
	echo "0 results";
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

<?php

function getDB($user, $password)
{
	return new PDO("mysql:host=localhost;dbname=workorder;charset=utf8", $user, $password);
}
?>

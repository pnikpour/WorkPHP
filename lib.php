<?php

function getDB($user, $password)
{

//	$pdo = new PDO("mysql:host=localhost;dbname=workorder;charset=utf8", $user, $password);
	return new PDO("mysql:host=localhost;dbname=workorder;charset=utf8", $user, $password);
//	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//	return $pdo;
}
?>

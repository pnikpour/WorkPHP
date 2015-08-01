<?php
/**
 * Login page processor file
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

	// Accepts username and cleartext password; verifies password with hashed one in database
	function authUser($user, $pass) {
	
		$db = getDB();
		$query = 'SELECT username, hash, groups FROM workorder.users WHERE username LIKE :user';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':user', $user);
		$stmt->execute();
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		$group = $rows['groups'];	
		$hash = $rows['hash'];


		$_SESSION['user'] = $user;
		if (password_verify($pass, $hash)) {
			$_SESSION['password'] = $hash;
			header('Location: ../menu');
		} else { // Increment the login attempts by one; throw error if max attempts is reached
	//		session_unset();
			setErrorVar('<p class="error">That did not work; please try again</p>');
			header('Location: ../');
		}
	}

	// If clicked on register button, redirect to self-register form
	if (isset($_POST['register'])) {
		header('Location: ../register');
	} else {
		if (!isset($_POST['user']) || !isset($_POST['password'])) {
			redirectIfNotLoggedIn();
		} else {
			authUser($_POST['user'], $_POST['password']);
		}
	}
?>

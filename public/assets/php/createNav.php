
<?php
	echo
		"<nav>
			<input type='submit' class='button' id='home' name='home' value='Home' />
			<input type='submit' class='button' id='ticket' name='ticket' value='Create Work Order' />
			<input type='submit' class='button' name='logout' value='Log Out' />";

	if (isAdmin($user, $db)) { 
		echo"
			<script>
				$('#ticket').after(\"<input type='submit' class='button' id='addUser' name='addUser' value='Add Users' />\");
				$('#addUser').after(\"<input type='submit' class='button' id='changePassword' name='changePassword' value='Change Password' />\");
			</script>	
		</nav>";
	}

?>

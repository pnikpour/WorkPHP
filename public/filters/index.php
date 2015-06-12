<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include('../assets/php/lib.php');

	redirectIfNotLoggedIn();
?>

<html>
<head>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src='../assets/js/effect.js' type='text/javascript'></script>
	<link rel='stylesheet' href='../assets/css/styles.css' type='text/css' />
</head>
<body>


<?php


	// Logout snippet
	navPOST();
?>


<h1>Form</h1>

<div class='filterForm'>
	<form action="" name='addUserForm' id='addUserForm' method='post'>

		<?php include '../assets/php/createNav.php'; ?>

		 <table border=1 class='left'>
			<tr><th>Ticket Number</th></tr>
			<tr><td><input type='text' name='ticketNumber' id='ticketNumber'/></td></tr>

			<tr><th>Status</th></tr>
			<tr><td>
			<select name='status'>
				<?php
					$table = "tickets";
					$col = 'status';
					$query = 'SHOW COLUMNS FROM '.$table.' WHERE field="'.$col.'"';
   					$row = getDB()->query($query)->fetch(PDO::FETCH_ASSOC);
					foreach(explode("','",substr($row['Type'],6,-2)) as $option) {
						print("<option>$option</option>");
					}

				?>
			</select>
			</td></tr>
			<tr>
			<td>
				<input type='submit' class='button' name='query' id='query' value='Submit Query' />
			</td>
			</tr>
		</table>
		
		<?php
			if (isset($_POST['query'])) {
				doFilter();
			}
		?>

	</form>
</div>
</body>
</html>



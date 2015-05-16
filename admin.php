<?php
	session_start();
	session_unset();
	session_destroy();
	session_write_close();
	setcookie(session_name(),'',0,'/');
	session_regenerate_id(true);
?>


<html>
<head>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js'></script>
	<script src='ghost.js'></script>

	<script type='text/javascript'>
	$('document').ready(function() {
	
		$('td').css('padding', '6px 10px');
		$('body').css('background-color', '#D0D0D0');	
	});
	</script>

	<link rel='stylesheet' href='assets/styles.css' type='text/css' />
	<script>
//	$('document').ready(function() {
//		$('[placeholder]').focus(function() {
//			var input = $(this);
//			if (input.val() == input.attr('placeholder')) {
//				input.val('');
//				input.removeClass('placeholder');
//			}
//		}).blur(function() {
//			var input = $(this);
//			
//			// If focused, change color to type
//			input.focus(function() {
//				input.css('color', 'black');
//			});
//			
//			if (input.val() == '' || input.val() == input.attr('placeholder')) {
//				input.addClass('placeholder');
//				input.val(input.attr('placeholder'));
//				input.css('color', '#C0C0C0');
//			}
//		}).blur();
//		$('[placeholder]').parents('form').submit(function() {
//			$(this).find('[placeholder]').each(function() {
//				var input = $(this);
//				if (input.val() == input.attr('placeholder')) {
//					input.val('');
//				}
//			});
//		});
//	});
	</script>
</head>
<body>

<h1>Create and Edit Users Login</h1>

<form action='addUser.php' name='login' method='post'>
	<input type='text' class='ghost' name='user' placeholder='Admin Logon'/> <br>
	<input type='password' class='ghost' name='password' placeholder='Admin Password'/>
	<input type='submit' class='logon' name='login' value='Login' />
</form>
</body>
</html>

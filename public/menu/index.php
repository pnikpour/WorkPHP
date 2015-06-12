<?php
	
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	include('../assets/php/lib.php');
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
	navPOST();
?>


<h1>BlueberryPHP Workflow Menu</h1>

<input class='color' value='D0D0D0'>
	<script type='text/javascript' src='../assets/js/jscolor/jscolor.js'></script>
</input>

<script>
	$('.color').change(function() {
		var hex = $('.color').val();
		$('body').css('backgroundColor', hex);
		$('.button').css('backgroundColor', hex);
	});
</script>

<div class='formContainer'>
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" name='menu' id='menu' method='post'>
		<?php include '../assets/php/createNav.php'; ?>
	</form>
</div>

<?php
	generateDashboard();
?>

</body>
</html>



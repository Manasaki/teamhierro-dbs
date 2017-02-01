<?php
include('function.php');
cpSession();
?>

<!DOCTYPE html>
<html>
<head>
	<title>THCP - Login Panel</title>
	<style type="text/css">
		label{
		    display: inline-block;
		    float: left;
		    clear: left;
		    width: 150px;
		    text-align: left;
		}
		input, textarea {
		  display: inline-block;
		  float: left;
		}
	</style>
</head>
<body>
	<?php 
		cpIsLoggedIn();
	?>
</body>
</html>
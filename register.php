<?php
	session_start();

	// if logged in, redirect to index
	if (isset($_SESSION['userid'])) {
		header("location: index.php");
		exit;
	}

	$page = "Register";
?>
<!DOCTYPE html>
<html>
	<?php include "templates/head.php" ?>
<body>
	<?php include "templates/register.php" ?>

	<script src="js/auth/register.js"></script>
</body>
</html>
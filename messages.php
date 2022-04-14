<?php
	session_start();
	// if not logged in, redirect to login
	if (!isset($_SESSION['userid'])) {
		header("location: login.php");
		exit;
	}

	$page = "Messages";
?>
<!DOCTYPE html>
<html>
	<?php include "templates/head.php" ?>
<body>
	<?php include "templates/nav.php" ?>
	<?php include "templates/messages.php" ?>

	<script src="js/search.js"></script>
	<script src="js/messages.js"></script>
</body>
</html>
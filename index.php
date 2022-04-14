<?php
	session_start();
	// if not logged in, redirect to login
	if (!isset($_SESSION['userid'])) {
		header("location: login.php");
		exit;
	}

	$page = "Groupchats";
?>
<!DOCTYPE html>
<html>
	<?php include "templates/head.php" ?>
<body>
	<?php include "templates/nav.php" ?>
	<?php include "templates/index.php" ?>

	<script type="text/javascript" src="js/index.js"></script>
	<script type="text/javascript" src="js/search.js"></script>
</body>
</html>
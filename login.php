<?php
	session_start();

	// if logged in, redirect to index
	if (isset($_SESSION['userid'])) {
		header("location: index.php");
		exit;
	}

	$page = "Login";
?>
<!DOCTYPE html>
<html>
	<?php include "templates/head.php" ?>
<body>
	<?php include "templates/login.php" ?>

	<script src="js/auth/login.js"></script>
</body>
</html>
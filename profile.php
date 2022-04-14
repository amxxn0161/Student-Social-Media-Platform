<?php
	session_start();
	// if not logged in, redirect to login
	if (!isset($_SESSION['userid'])) {
		header("location: login.php");
		exit;
	}

	// only accept GET requests with ?userid specified
	if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['userid'])) {
		header('location: /');
		exit;
	}

	$page = "User Profile";
?>
<!DOCTYPE html>
<html>
	<?php include "templates/head.php" ?>
<body>
	<?php include "templates/nav.php" ?>
	<?php include "templates/profile.php" ?>

	<script type="text/javascript">
		var userid = <?= $_GET['userid']; ?>;
	</script>
	<script src="js/profile.js"></script>
	<script src="js/search.js"></script>
</body>
</html>
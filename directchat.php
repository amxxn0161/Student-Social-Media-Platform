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

	// disallow direct messaging yourself
	if ($_GET['userid'] == $_SESSION['userid']) {
		header('location: /');
		exit;
	}

	$page = "Messages";
?>
<!DOCTYPE html>
<html>
	<?php include "templates/head.php" ?>
<body>
	<?php include "templates/nav.php" ?>
	<?php include "templates/directchat.php" ?>

	<script type="text/javascript">
		var recipientid = <?= $_GET['userid']; ?>;
	</script>
	<script type="text/javascript" src="js/directchat.js"></script>
	<script type="text/javascript" src="js/search.js"></script>
</body>
</html>
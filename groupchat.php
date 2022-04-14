<?php
	session_start();
	// if not logged in, redirect to login
	if (!isset($_SESSION['userid'])) {
		header("location: login.php");
		exit;
	}

	// only accept GET requests with ?id specified
	if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
		header('location: /');
		exit;
	}

	$page = "Groupchats";
?>
<!DOCTYPE html>
<html>
	<?php include "templates/head.php" ?>
<body>
	<?php include "templates/nav.php" ?>
	<?php include "templates/groupchat.php" ?>

	<script type="text/javascript">
		var id = <?= $_GET['id']; ?>;
	</script>
	<script type="text/javascript" src="js/groupchat.js"></script>
	<script type="text/javascript" src="js/search.js"></script>
</body>
</html>
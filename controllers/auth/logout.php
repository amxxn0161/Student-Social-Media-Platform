<?php
	session_start();

	if (isset($_SESSION['userid'])) {
		// Unset all of the session variables.
		$_SESSION = array();

		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}

		// Finally, destroy the session.
		session_destroy();

	}

	// redirect back to index
	header('location: /');
	exit;
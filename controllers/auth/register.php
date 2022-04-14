<?php
	session_start();

	// establish JSON header
	header('Content-type: application/json');

	// connect to database
	include('../connect.php');

	// if already logged in, redirect
	if (isset($_SESSION['userid'])) {
		header('location: /');
		exit;
	}

	// validate username
	function validateUsername($conn, $username)
	{
	    $errors = array();
	    if (strlen($username) < 1 || strlen($username) > 15) {
	        array_push($errors,"Username must be 1-15 characters.");
	    }
	    if (doesUserExist($conn, $username)) {
	        array_push($errors,htmlspecialchars($username) . " already exists.");
	    }
	    if (count($errors)) {
	        return $errors;
	    }
	    return true;
	}

	// validate password and confirm password
	function validatePasswords($password, $confirmPassword)
	{
	    $errors = array();
	    if ($password != $confirmPassword) {
	        array_push($errors, "Both passwords must match.");
	    } else {
	        if (strlen($password) < 6) {
	            array_push($errors, "Password must be 6+ characters.");
	        }
	    }
	    if (count($errors)) {
	        return $errors;
	    }
	    return true;
	}

	// check if username already exists
	function doesUserExist($conn, $username): bool
	{
	    $stmt = $conn->prepare("SELECT username FROM users WHERE username = :username");
	    $stmt->execute(array(':username' => $username));

	    if ($stmt->rowCount()) {
	        return true;
	    }
	    return false;
	}

	// set global errors array
	$errors = [];

	// only accept POST requests
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirm-password'];

		if (validateUsername($conn, $username) !== true) {
		    array_push($errors, validateUsername($conn, $username));
		};
		if (validatePasswords($password, $confirmPassword) !== true) {
		    array_push($errors, validatePasswords($password, $confirmPassword));
		};

		// if no errors, register an account
		if (empty($errors)) {
			// encrypt password
	        $password = password_hash($password, PASSWORD_BCRYPT);
	        // insert into table
	        $stmt = $conn->prepare("INSERT INTO users (username, password, joined_on) VALUES (:username, :password, :joined_on)");
	        $stmt->execute(array(':username' => $username, ':password' => $password, ':joined_on' => date('Y-m-d')));
		}

	} else {
		header('location: /');
		exit;
	}

	// return JSON response
	if (!empty($errors)) {
		// if there are any errors, return a code 0 and the list of errors
		echo json_encode(['code' => 0, 'errors' => $errors], JSON_PRETTY_PRINT);
	} else {
		// return a code 1
		echo json_encode(['code' => 1, 'message' => 'Created an account successfully, you may login. Redirecting you now...'], JSON_PRETTY_PRINT);
	}

?>
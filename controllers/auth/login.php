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

	$errors = [];

	// only accept POST requests
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		// if username and password both set, create variables
    	if (!empty($_POST['username']) && !empty($_POST['password'])) {
    		$username = $_POST['username'];
    		$password = $_POST['password'];
    	} else {
    		// otherwise, log an error
    		array_push($errors, "Username and password can not be empty.");
    	}

    	// if no errors so far, validate username and password
    	if (empty($errors)) {
    		try {
			    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
			    $stmt->execute(array(':username' => $username));

			    if ($stmt->rowCount()) {
			        // save results to assoc array
			        $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			        $results = $stmt->fetchAll();
			        if (password_verify($password, $results[0]['password'])) {
			            // successful login, create a session token
			            $_SESSION['userid'] = $results[0]['id'];
			        } else {
			            array_push($errors, "Invalid username/password combination.");
			        }
			    } else {
			        array_push($errors, "Sorry, we couldn't find any account for " . htmlspecialchars($username));
			    }

			} catch (PDOException $e) {
			    array_push($errors, $e->getMessage());
			}
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
		echo json_encode(['code' => 1, 'message' => 'logged in successfully'], JSON_PRETTY_PRINT);
	}

?>
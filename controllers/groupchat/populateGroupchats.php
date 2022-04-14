<?php
	session_start();

	// establish JSON header
	header('Content-type: application/json');

	// connect to database
	include('../connect.php');

	// if not logged in, redirect
	if (!isset($_SESSION['userid'])) {
		header('location: /');
		exit;
	}

	$errors = [];

	// only accept GET requests
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		try {
			    $stmt = $conn->prepare("SELECT * FROM groupchats");
			    $stmt->execute();

			    if ($stmt->rowCount()) {
			        // save results to assoc array
			        $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			        $results = $stmt->fetchAll();
			       
			    } else {
			        array_push($errors, "Sorry, we couldn't find any groupchats as of yet.");
			    }

			} catch (PDOException $e) {
			    array_push($errors, $e->getMessage());
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
		echo json_encode(['code' => 1, 'data' => $results], JSON_PRETTY_PRINT);
	}

?>
<?php
	session_start();

	// establish JSON header
	header('Content-type: application/json');

	// connect to database
	include('../connect.php');

	// include time ago script
	include('../timeAgo.php');

	// if not logged in, redirect
	if (!isset($_SESSION['userid'])) {
		header('location: /');
		exit;
	}

	$errors = [];

	// only accept GET requests
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {

		if (isset($_GET['userid'])) {
			try {
			    $stmt = $conn->prepare("SELECT username FROM users WHERE id = :id");
			    $stmt->execute(array(':id' => $_GET['userid']));

			    // if user found
			    if ($stmt->rowCount()) {

			        $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			        $results = $stmt->fetchAll()[0];

				} else {
					array_push($errors, 'No user found with the ID: ' . htmlspecialchars($_GET['userid']));
				}

			} catch (PDOException $e) {
			    array_push($errors, $e->getMessage());
			}
		} else {
			array_push($errors, 'User ID must be specified.');
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
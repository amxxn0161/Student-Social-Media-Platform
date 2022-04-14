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

	function getUserByUsername($conn, $queryUsername) {
		$errors = [];
		$results = [];

		try {
		    $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = :username");
		    $stmt->execute(array(':username' => $queryUsername));

		    if ($stmt->rowCount()) {
		        // save results to assoc array
		        $data = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		        $data = $stmt->fetchAll();

		        $results = ['code' => 1, 'results' => $data[0]];
		    } else {
		        array_push($errors, htmlspecialchars($queryUsername) . " does not exist.");
		    }

		} catch (PDOException $e) {
		    array_push($errors, $e->getMessage());
		}

		// if any errors, set results to error message
		if (!empty($errors)) {
			$results = ['code' => 0, 'errors' => $errors];
		}

		return $results;

	}

	function getUserByUserid($conn, $queryUserid) {
		$errors = [];
		$results = [];

		try {
		    $stmt = $conn->prepare("SELECT id, username, joined_on FROM users WHERE id = :userid");
		    $stmt->execute(array(':userid' => $queryUserid));

		    if ($stmt->rowCount()) {
		        // save results to assoc array
		        $data = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		        $data = $stmt->fetchAll();

		        $results = ['code' => 1, 'results' => $data[0]];
		    } else {
		        array_push($errors, 'No user with the ID ' . htmlspecialchars($queryUserid) . " exists.");
		    }

		} catch (PDOException $e) {
		    array_push($errors, $e->getMessage());
		}

		// if any errors, set results to error message
		if (!empty($errors)) {
			$results = ['code' => 0, 'errors' => $errors];
		}

		return $results;

	}

	// only accept POST
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		// handle search by username
		if (isset($_POST['username'])) {
			$queryUsername = $_POST['username'];

			// check if query is not empty 
			if (!empty($queryUsername)) {
				$user = getUserByUsername($conn, $queryUsername);
				if ($user['code'] == 1) {
					// return code 1, and the results from search query
					$json = ['code' => 1, 'results' => $user['results']];
				} else {
					// return list of errors and code 0
					$json = ['code' => 0, 'errors' => $user['errors']];
				}
			} else {
				$json = ['code' => 0, 'errors' => 'Username must be specified.'];
			}
		} else if (isset($_POST['userid'])) {
			$queryUserid = $_POST['userid'];

			// check if query is not empty 
			if (!empty($queryUserid)) {
				$user = getUserByUserid($conn, $queryUserid);
				if ($user['code'] == 1) {
					// return code 1, and the results from search query
					$json = ['code' => 1, 'results' => $user['results']];
				} else {
					// return list of errors and code 0
					$json = ['code' => 0, 'errors' => $user['errors']];
				}
			} else {
				$json = ['code' => 0, 'errors' => 'User id must be specified.'];
			}
		}
		
	} else {
		header('location: /');
		exit;
	}

	echo json_encode($json, JSON_PRETTY_PRINT);
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

		try {
		    $stmt = $conn->prepare("SELECT * FROM direct_chats WHERE recipient_id = :id");
		    $stmt->execute(array(':id' => $_SESSION['userid']));

		    // if any messages, handle
		    if ($stmt->rowCount()) {

		        $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		        $results = $stmt->fetchAll();

		        for ($result=0; $result < count($results); $result++) { 
					$stmt = $conn->prepare("SELECT username FROM users WHERE id = :userid");
			    	$stmt->execute(array(':userid' => $results[$result]['sender_id']));

			        // save results to assoc array
			        $data = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			        $data = $stmt->fetchAll();

			        $results[$result]['time_ago'] = time_elapsed_string($results[$result]['datetime']);
					$results[$result]['sender_username'] = $data[0]['username'];
				}

			} else {
				array_push($errors, 'Inbox is empty. To message somebody, search for their username and click direct message.');
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
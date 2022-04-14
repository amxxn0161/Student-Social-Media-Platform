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

	// only accept POST requests
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// check if message is set
		if (isset($_POST['message']) && isset($_POST['recipient-id'])) {
			if (strlen($_POST['message'])) {
				// Insert new message into direct chats
				$stmt = $conn->prepare("INSERT INTO direct_chats (sender_id, recipient_id, datetime, message) VALUES (:sender_id, :recipient_id, :datetime, :message)");
		        $stmt->execute(array(':sender_id' => $_SESSION['userid'], ':recipient_id' => $_POST['recipient-id'], ':datetime' => date('Y-m-d H:i:s'), 'message' => $_POST['message']));
			} else {
				array_push($errors, "Message cannot be left empty.");
			}
		} else {
			array_push($errors, "Message must be specified.");
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
		echo json_encode(['code' => 1, 'message' => 'Successfully sent message. Redirecting you now...'], JSON_PRETTY_PRINT);
	}

?>
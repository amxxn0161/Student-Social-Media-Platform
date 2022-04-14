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
		// check if groupchat ID is set
		if (isset($_GET['id'])) {
			// Select groupchat data
			try {
			    $stmt = $conn->prepare("SELECT * FROM groupchat_chats WHERE groupchat_id = :id ORDER BY id DESC");
			    $stmt->execute(array(':id' => $_GET['id']));

			    if ($stmt->rowCount()) {
			        // save results to assoc array
			        $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			        $results = $stmt->fetchAll();

					for ($result=0; $result < count($results); $result++) { 
						$stmt = $conn->prepare("SELECT username FROM users WHERE id = :userid");
				    	$stmt->execute(array(':userid' => $results[$result]['sender_id']));

				        // save results to assoc array
				        $data = $stmt->setFetchMode(PDO::FETCH_ASSOC);
				        $data = $stmt->fetchAll();

						$results[$result]['username'] = $data[0]['username'];
					}

			    } else {
			        array_push($errors, "No groupchat chats exist for a groupchat with the ID: " . htmlspecialchars($_GET['id']));
			    }

			} catch (PDOException $e) {
			    array_push($errors, $e->getMessage());
			}
		} else {
			array_push($errors, "Groupchat ID must be specified.");
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
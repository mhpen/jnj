<?php
session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // If not logged in, return an error
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    try {
        // Connect to the database
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to retrieve received messages for the current user
        $receivedStmt = $conn->prepare("SELECT SenderID, MessageContent, Timestamp FROM Messages WHERE ReceiverID = :userID");
        $receivedStmt->bindParam(':userID', $_SESSION['user_id']);
        $receivedStmt->execute();

        // Fetch received messages from the database and store them in the array
        $receivedMessages = $receivedStmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare SQL statement to retrieve sent messages for the current user
        $sentStmt = $conn->prepare("SELECT SenderID, MessageContent, Timestamp FROM Messages WHERE SenderID = :userID");
        $sentStmt->bindParam(':userID', $_SESSION['user_id']);
        $sentStmt->execute();

        // Fetch sent messages from the database and store them in the array
        $sentMessages = $sentStmt->fetchAll(PDO::FETCH_ASSOC);

        // Combine received and sent messages
        $messages = array_merge($receivedMessages, $sentMessages);

        // Sort the messages array by timestamp in ascending order
        usort($messages, function($a, $b) {
            return strtotime($a['Timestamp']) - strtotime($b['Timestamp']);
        });

        // Return messages as JSON response
        echo json_encode(['status' => 'success', 'messages' => $messages]);
    } catch (PDOException $e) {
        // Return error response
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    // If request method is not POST, return an error
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
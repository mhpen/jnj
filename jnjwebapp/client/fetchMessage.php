<?php
session_start();

// Check if the user is logged in and get their user ID
if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];

    // Database connection parameters
    $host = 'localhost';
    $dbname = 'jnjgiftsgalore_db';
    $username = 'root';
    $password = '';

    try {
        // Connect to the database
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to fetch messages for the current user
        $stmt = $conn->prepare("SELECT * FROM Messages WHERE SenderID = :userID");
        $stmt->bindParam(':userID', $userID);
        
        // Execute the SQL statement
        $stmt->execute();

        // Fetch all messages
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Encode messages array to JSON and send it
        if (!empty($messages)) {
            echo json_encode(array("status" => "success", "messages" => $messages));
        } else {
            echo json_encode(array("status" => "success", "messages" => []));
        }
    } catch(PDOException $e) {
        // Return an error response with a custom message
        echo json_encode(array("status" => "error", "message" => "Failed to fetch messages from database. Error: " . $e->getMessage()));
    }
} else {
    // Return an error response if the user is not logged in
    echo json_encode(array("status" => "error", "message" => "User not logged in."));
}
?>
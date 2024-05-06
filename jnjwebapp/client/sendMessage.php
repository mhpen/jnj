<?php
session_start();

// Check if the user is logged in and get their user ID
if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
    

    // Retrieve the message content sent via AJAX
    $messageContent = isset($_POST['messageContent'])? $_POST['messageContent'] : null;

    // Only save the message if messageContent is not empty
    if ($messageContent!== null && trim($messageContent)!== '') {
        // Database connection parameters
        $host = 'localhost';
        $dbname = 'jnjgiftsgalore_db';
        $username = 'root';
        $password = '';

        try {
            // Connect to the database
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL statement to insert the message
            $stmt = $conn->prepare("INSERT INTO Messages (SenderID, MessageContent) VALUES (:senderID, :messageContent)");
            $stmt->bindParam(':senderID', $userID);
            $stmt->bindParam(':messageContent', $messageContent);

            // Execute the SQL statement
            $stmt->execute();

            // Return a success response
            echo json_encode(array("status" => "success"));
        } catch(PDOException $e) {
            // Return an error response with a custom message
            echo json_encode(array("status" => "error", "message" => "Failed to insert message into database. Error: " . $e->getMessage()));
        }
    } else {
        // Return an error response if messageContent is empty
        echo json_encode(array("status" => "error", "message" => "Message content is empty."));
    }
} else {
    // Return an error response if the user is not logged in
    echo json_encode(array("status" => "error", "message" => "User not logged in."));
}
?>
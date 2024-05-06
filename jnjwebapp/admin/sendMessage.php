<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect or show an error message if the user is not logged in
    exit("User not logged in.");
}

// Check if the ReceiverID and MessageContent are provided via POST request
if (!isset($_POST['ReceiverID']) || !isset($_POST['MessageContent'])) {
    // Redirect or show an error message if the ReceiverID or MessageContent is missing
    exit("ReceiverID or MessageContent not provided.");
}

// Get the ReceiverID and MessageContent from the POST request
$receiverID = $_POST['ReceiverID'];
$messageContent = $_POST['MessageContent'];

// Database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to insert the message into the database
    $stmt = $conn->prepare("INSERT INTO Messages (SenderID, ReceiverID, MessageContent) VALUES (:senderID, :receiverID, :messageContent)");
    $stmt->bindParam(':senderID', $_SESSION['user_id']);
    $stmt->bindParam(':receiverID', $receiverID);
    $stmt->bindParam(':messageContent', $messageContent);
    
    // Execute the SQL statement
    $stmt->execute();

    // Return a success message
    echo "Message sent successfully.";
} catch (PDOException $e) {
    // Handle database connection errors
    exit("Failed to connect to the database. Error: " . $e->getMessage());
}
?>
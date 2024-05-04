<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect or show an error message if the user is not logged in
    exit("User not logged in.");
}

// Check if the ReceiverID, MessageContent, and ReplyToMessageID are provided via POST request
if (!isset($_POST['ReceiverID']) || !isset($_POST['MessageContent']) || !isset($_POST['ReplyToMessageID'])) {
    // Redirect or show an error message if any of the parameters are missing
    exit("ReceiverID, MessageContent, or ReplyToMessageID not provided.");
}

// Get the ReceiverID, MessageContent, and ReplyToMessageID from the POST request
$receiverID = $_POST['ReceiverID'];
$messageContent = $_POST['MessageContent'];
$replyToMessageID = $_POST['ReplyToMessageID'];

// Database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to insert the new message into the database
    $stmt = $conn->prepare("INSERT INTO Messages (SenderID, ReceiverID, MessageContent, Timestamp, Status, ReplyToMessageID) VALUES (:senderID, :receiverID, :messageContent, NOW(), 'unread', :replyToMessageID)");
    $stmt->bindParam(':senderID', $_SESSION['user_id']);
    $stmt->bindParam(':receiverID', $receiverID);
    $stmt->bindParam(':messageContent', $messageContent);
    $stmt->bindParam(':replyToMessageID', $replyToMessageID);
    $stmt->execute();

    // Return success message if insertion is successful
    echo "Message sent successfully.";
} catch (PDOException $e) {
    // Handle database connection errors
    exit("Failed to connect to the database. Error: " . $e->getMessage());
}
?>
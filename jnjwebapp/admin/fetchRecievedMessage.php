<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    exit("User not logged in.");
}

// Check if the SenderID is provided via POST request
if (!isset($_POST['SenderID'])) {
    exit("SenderID not provided.");
}

// Get the SenderID from the POST request
$senderID = $_POST['SenderID'];

// Database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = ''; 
try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to retrieve messages for the specified SenderID (left side)
    $stmt = $conn->prepare("SELECT MessageContent FROM Messages WHERE SenderID = :senderID");
    $stmt->bindParam(':senderID', $senderID);
    $stmt->execute();

    // Fetch and output messages
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($messages as $message) {
        echo '<div class="message">' . $message['MessageContent'] . '</div>';
    }
} catch (PDOException $e) {
    exit("Failed to connect to the database. Error: " . $e->getMessage());
}
?>
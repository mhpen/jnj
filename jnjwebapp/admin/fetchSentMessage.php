<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    exit("User not logged in.");
}

// Check if the SenderID and UserID are provided via POST request
if (!isset($_POST['SenderID']) || !isset($_POST['UserID'])) {
    exit("SenderID or UserID not provided.");
}

// Get the SenderID and UserID from the POST request
$senderID = $_POST['SenderID'];
$userID = $_POST['UserID'];

// Database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = ''; 

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to retrieve messages for the specified SenderID and UserID (right side)
    $stmt = $conn->prepare("SELECT * FROM Messages WHERE SenderID = :userID AND ReceiverID = :senderID");
    $stmt->bindParam(':senderID', $senderID);
    $stmt->bindParam(':userID', $userID);
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
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    exit("User not logged in.");
}


$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to retrieve messages ordered by timestamp
    $stmt = $conn->prepare("SELECT * FROM Messages ORDER BY Timestamp ASC");
    $stmt->execute();

    // Fetch messages
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Separate messages into sent and received arrays
    $sentMessages = [];
    $receivedMessages = [];
    foreach ($messages as $message) {
        if ($message['SenderID'] == $_SESSION['user_id']) {
            $sentMessages[] = $message;
        } else {
            $receivedMessages[] = $message;
        }
    }

    // Output messages
    foreach ($receivedMessages as $message) {
        echo '<div class="message received-message">' . $message['MessageContent'] . '</div>';
    }

    foreach ($sentMessages as $message) {
        echo '<div class="message sent-message">' . $message['MessageContent'] . '</div>';
    }

} catch (PDOException $e) {
    exit("Failed to connect to the database. Error: " . $e->getMessage());
}
?>
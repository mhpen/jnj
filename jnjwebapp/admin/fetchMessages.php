<?php
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Query to fetch the most recent message for each user
$sql = "SELECT m.MessageContent, m.Timestamp, u.FirstName, u.LastName
        FROM Message AS m
        INNER JOIN Users AS u ON m.SenderID = u.UserID
        WHERE m.Timestamp IN (
            SELECT MAX(Timestamp)
            FROM Message
            GROUP BY SenderID
        )";

$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch and output each row
    $messages = array();
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    echo json_encode($messages);
} else {
    // No messages found
    echo json_encode(array());
}

// Close the connection
$conn->close();
?>
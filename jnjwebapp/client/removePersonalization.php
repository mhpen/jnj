<?php
session_start();

// Define database connection parameters
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

// Get personalization ID from POST data
$personalization_id = isset($_POST['personalization_id']) ? $_POST['personalization_id'] : '';

// Check if personalization ID is provided
if (!empty($personalization_id)) {
    // Delete personalization data from the database
    $sql = "DELETE FROM Personalization WHERE PersonalizationID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $personalization_id);
    if ($stmt->execute()) {
        echo "Personalization removed successfully.";
    } else {
        echo "Error removing personalization: " . $conn->error;
    }
} else {
    echo "Personalization ID not provided.";
}

// Close the database connection
$conn->close();
?>
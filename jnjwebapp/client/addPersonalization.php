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

// Retrieve personalization details from the POST request
$name = isset($_POST['name']) ? $_POST['name'] : '';
$font = isset($_POST['font']) ? $_POST['font'] : '';

// Prepare and execute the INSERT query
$sql = "INSERT INTO Personalization (PersonalizedName, Font) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $font);
$stmt->execute();

// Check if the query was successful
if ($stmt->affected_rows > 0) {
    // Get the last inserted personalization ID
    $personalizationID = $conn->insert_id;
    // Store the personalization ID in the session
    $_SESSION['personalization_id'] = $personalizationID;
    echo $personalizationID;
} else {
    echo "Error adding personalization details: " . $conn->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
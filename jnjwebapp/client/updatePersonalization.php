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

// Get the personalization details from the form
$personalizationName = $_POST['personalizationName'];
$personalizationFont = $_POST['personalizationFont'];
$cartId = $_POST['cartId'];

// Prepare and execute the update statement
$sql = "UPDATE Personalization SET PersonalizedName = ?, Font = ? WHERE PersonalizationID IN (SELECT PersonalizationID FROM cartItem WHERE cartItemID = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $personalizationName, $personalizationFont, $cartId);

// Execute the statement and handle errors
if ($stmt->execute()) {
    echo "Personalization details updated successfully.";
} else {
    echo "Error updating personalization details: " . $conn->error;
}

// Close the database connection
$stmt->close();
$conn->close();
?>
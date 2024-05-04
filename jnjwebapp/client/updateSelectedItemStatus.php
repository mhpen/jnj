<?php
// Retrieve cart item ID and isSelected status from POST request
$cartItemId = $_POST['cartItemId'];
$isSelected = $_POST['isSelected'];

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

// Prepare and execute SQL query to update isSelected status
$sql = "UPDATE cartItem SET isSelected = ? WHERE cartItemID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $isSelected, $cartItemId);
$stmt->execute();

if ($stmt->error) {
    // Error occurred while updating database
    echo "Error updating isSelected: " . $stmt->error;
} else {
    // Database update successful
    echo "isSelected updated successfully";
}

// Close database connection
$stmt->close();
$conn->close();
?>
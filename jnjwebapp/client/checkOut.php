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

// Get the user ID from the session
if (!isset($_SESSION['user_id'])) {
    // Handle case where user is not logged in
    echo "Error: User not logged in.";
    exit();
}

$userID = $_SESSION['user_id'];

// Get the selected cart IDs from the AJAX request
$selectedCartIds = json_decode($_POST['cart_ids']);

// Prepare SQL statement for insertion
$sql = "INSERT INTO checkout (userID, cartID) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("ii", $userID, $cartId);

// Execute the prepared statement for each selected cart ID
foreach ($selectedCartIds as $cartId) {
    if (!$stmt->execute()) {
        // Checkout failed
        echo "Error: Unable to checkout";
        exit();
    }
}

// All insertions successful
echo "success";

$stmt->close();
$conn->close();
?>
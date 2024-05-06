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
    // Redirect to login page or display an error message
    echo "Error: User not logged in.";
    exit();
}

// Get the cart ID, quantity, and total from the POST data
$cartId = $_POST['cart_id'];
$quantity = $_POST['quantity'];
$total = $_POST['total'];

// Update the quantity and total in the cart table
$sql = "UPDATE cartItem SET quantity = ?, total = ? WHERE cartItemID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $quantity, $total, $cartId);

if ($stmt->execute()) {
    echo "Quantity and total updated successfully.";
} else {
    echo "Error updating quantity and total: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
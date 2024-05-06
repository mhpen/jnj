<?php
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

// Function to remove item from cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    $sql = "DELETE FROM cartItem WHERE cartItemId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_id);
    if ($stmt->execute()) {
        echo "Item removed successfully";
    } else {
        echo "Error: Unable to remove item";
    }
    exit();
}
?>
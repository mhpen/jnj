<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Handle case where user is not logged in
    echo json_encode(array("success" => false, "message" => "User not logged in."));
    exit();
}

// Define database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';
$orderID = $_SESSION['order_id'];

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
    echo json_encode(array("success" => false, "message" => "Connection failed: " . $conn->connect_error));
    exit();
}

try {
    // Delete all order lines related to the given orderID from the orderline table
    $sql_delete_order_lines = "DELETE FROM orderline WHERE OrderID = ?";
    $stmt_delete_order_lines = $conn->prepare($sql_delete_order_lines);
    $stmt_delete_order_lines->bind_param("i", $orderID);
    $stmt_delete_order_lines->execute();

    // Prepare SQL statement to delete the order
    $sql_delete_order = "DELETE FROM Orders WHERE OrderID = ?";
    $stmt_delete_order = $conn->prepare($sql_delete_order);
    $stmt_delete_order->bind_param("i", $orderID);

    // Execute the statement
    if ($stmt_delete_order->execute()) {
        // Order deleted successfully
        // Unset the session variable
        unset($_SESSION['order_id']);
        
        // Optionally, you can also unset any other relevant session variables
        
        echo json_encode(array("success" => true, "message" => "Order removed successfully."));
    } else {
        // Error occurred while deleting order
        echo json_encode(array("success" => false, "message" => "Error removing order from the database."));
    }
} catch (Exception $e) {
    // Log error message
    error_log("Error: " . $e->getMessage());
    echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
} finally {
    // Close the database connection
    $conn->close();
}
?>
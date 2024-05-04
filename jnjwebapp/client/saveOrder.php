<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Return an error response if the user is not logged in
    http_response_code(401); // Unauthorized
    echo "Error: User not logged in.";
    exit();
}

// Get the user ID from the session
$userID = $_SESSION['user_id'];
echo "UserID: $userID<br>"; // Debugging

// Get the cart ID from the session
$cartID = $_SESSION['cart_id'] ?? null;
echo "CartID: $cartID<br>"; // Debugging

// Define database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
    // Return an error response if there is a database connection error
    http_response_code(500); // Internal Server Error
    echo "Error: Connection failed: " . $conn->connect_error;
    exit();
}

echo "Database connection successful.<br>"; // Debugging

// Define other variables needed for the order
$receiverID = null; // Assuming receiver ID is not available at this point
$shippingID = null; // Assuming shipping ID is not available at this point
$grandTotal = null; // Assuming grand total is not calculated yet
$orderStatus = 'pending'; // Set status as pending

// Create a new order and associate it with the cart
$insertOrderSQL = "INSERT INTO Orders (UserID, ReceiverID, ShippingID, GrandTotal, OrderStatus) VALUES (?,?,?,?,?)";
$insertOrderStmt = $conn->prepare($insertOrderSQL);
$insertOrderStmt->bind_param("iiiss", $userID, $receiverID, $shippingID, $grandTotal, $orderStatus);
$insertOrderStmt->execute();

// Get the ID of the newly inserted order
$orderID = $insertOrderStmt->insert_id;
echo "OrderID: $orderID<br>"; // Debugging

$_SESSION['order_id'] = $orderID;


// Prepare SQL to fetch selected cart items
$fetchCartItemsSQL = "SELECT cartItemID, productID, productVarId, quantity, total FROM cartItem WHERE cartID = ? AND isSelected = 1";
$fetchCartItemsStmt = $conn->prepare($fetchCartItemsSQL);
$fetchCartItemsStmt->bind_param("i", $cartID);
$fetchCartItemsStmt->execute(); 
$cartItemsResult = $fetchCartItemsStmt->get_result();

// Insert selected cart items into OrderLine table
$insertOrderLineSQL = "INSERT INTO orderline (orderID, productID, productVarId, quantity, price) VALUES (?,?,?,?,?)";
$insertOrderLineStmt = $conn->prepare($insertOrderLineSQL);

// Bind parameters for order line insertion
$insertOrderLineStmt->bind_param("iiidi", $orderID, $productID, $productVarId, $quantity, $price);

foreach ($cartItemsResult as $cartItem) {
    $productID = $cartItem['productID'];
    $productVarId = $cartItem['productVarId'];
    $quantity = $cartItem['quantity'];
    $price = $cartItem['total'];
    $insertOrderLineStmt->execute();
}

// Close the prepared statements
$insertOrderStmt->close();
$fetchCartItemsStmt->close();
$insertOrderLineStmt->close();

// Return a success response
http_response_code(200); // OK
echo "Order saved successfully.";
die(); // Stop execution here

// Code after die() will not be executed
?>
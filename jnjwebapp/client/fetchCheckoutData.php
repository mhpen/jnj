<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Handle case where user is not logged in
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

// Get the user ID from the session
$userID = $_SESSION['user_id'];

// Define database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

// Create a new database connection using PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // If connection fails, return an error response
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit();
}

// Retrieve the order ID from the session
if (!isset($_SESSION['order_id'])) {
    echo json_encode(['error' => 'Order ID not found in session.']);
    exit();
}

$orderID = $_SESSION['order_id'];

// Prepare SQL statement to fetch checkout data using the order ID
$sql = "SELECT orderline.*, Products.Name AS product_name, Products.PhotoMain AS product_image, Products.description_text AS product_details, Products.productprice AS product_price, ProductVariations.variationname
        FROM orderline
        INNER JOIN Products ON orderline.productID = Products.ProductID
        LEFT JOIN ProductVariations ON orderline.productVarID = ProductVariations.productVarID
        WHERE orderline.orderID = ?"; 

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the order ID parameter
$stmt->bindParam(1, $orderID, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();

// Fetch all rows as an associative array
$checkoutData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$conn = null;

// Return JSON response containing fetched checkout data
echo json_encode($checkoutData);
?>
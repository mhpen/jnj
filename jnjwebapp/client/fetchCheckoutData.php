<?php
session_start();

// Get the user ID from the session
if (!isset($_SESSION['user_id'])) {
    // Handle case where user is not logged in
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

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

// Prepare SQL statement to fetch all items in the cart for the logged-in user
$sql = "SELECT cart.*, Products.Name AS product_name, Products.PhotoMain AS product_image, Products.description_text AS product_details, Products.productprice AS product_price, ProductVariations.variationname
        FROM cart
        INNER JOIN Products ON cart.productID = Products.ProductID
        LEFT JOIN ProductVariations ON cart.productVarID = ProductVariations.productVarID
        WHERE cart.userID = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the user ID parameter
$stmt->bindParam(1, $userID, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();

// Fetch all rows as an associative array
$checkoutItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$conn = null;

// Return JSON response containing fetched cart items
echo json_encode($checkoutItems);
?>
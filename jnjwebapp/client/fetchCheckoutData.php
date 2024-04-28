<?php
session_start();

// Retrieve selected cart IDs from session or URL parameter
if (isset($_SESSION['selected_cart_ids'])) {
    $selectedCartIds = $_SESSION['selected_cart_ids'];
} elseif (isset($_GET['cart_ids'])) {
    $selectedCartIds = json_decode($_GET['cart_ids']);
} else {
    // If no cart IDs are found, return an error response
    echo json_encode(['error' => 'No cart IDs provided.']);
    exit();
}

// Define database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Prepare SQL statement to fetch checkout information
$sql = "SELECT cart.*, Products.Name AS product_name, Products.PhotoMain AS product_image, Products.description_text AS product_details, Products.productprice AS product_price, ProductVariations.variationname
        FROM cart
        INNER JOIN Products ON cart.productID = Products.ProductID
        LEFT JOIN ProductVariations ON cart.productVarID = ProductVariations.productVarID
        WHERE cart.cartID IN (" . implode(',', $selectedCartIds) . ")";

// Execute the query
$result = $conn->query($sql);

// Initialize an array to store fetched checkout information
$checkoutItems = [];

// Check if there are fetched checkout information
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Add each fetched item to the $checkoutItems array
        $checkoutItems[] = [
            'product_name' => $row['product_name'],
            'product_image' => $row['product_image'],
            'product_details' => $row['product_details'],
            'product_price' => $row['product_price'],
            'variationname' => $row['variationname']
        ];
    }
}

// Close the database connection
$conn->close();

// Return JSON response containing fetched checkout information
echo json_encode($checkoutItems);
?>
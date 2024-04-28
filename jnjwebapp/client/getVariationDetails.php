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

// Retrieve variation details from the database based on variation ID
$variation_id = isset($_GET['variation_id']) ? $_GET['variation_id'] : null;
$sql = "SELECT * FROM ProductVariations WHERE ProductVarID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $variation_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the variation exists
if ($result->num_rows > 0) {
    // Fetch variation details
    $variation = $result->fetch_assoc();

    // Prepare the response
    $response = array(
        'Price' => $variation['Price'],
    );

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Variation not found, handle error or redirect to error page
    echo "Variation not found.";
    exit();
}
?>
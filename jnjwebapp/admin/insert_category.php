<?php
include 'connection.php'; // Assuming connection.php contains your database connection

// Get category name from the request body
$data = json_decode(file_get_contents('php://input'), true);
$categoryName = $data['categoryName'];

// Insert category into database
$sql = "INSERT INTO categories (CategoryName) VALUES ('$categoryName')";

if ($conn->query($sql) === TRUE) {
    // Return success response
    echo json_encode(array('success' => true, 'message' => 'Category added successfully'));
} else {
    // Return error response
    echo json_encode(array('success' => false, 'message' => 'Error: ' . $conn->error));
}

$conn->close();
?>
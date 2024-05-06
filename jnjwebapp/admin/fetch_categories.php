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


$sql = "SELECT CategoryID, CategoryName FROM categories";
$result = $conn->query($sql);

$categories = [];

if ($result->num_rows > 0) {
    // Fetch categories and store them in an array
    while ($row = $result->fetch_assoc()) {
        $categories[] = [
            'CategoryID' => $row['CategoryID'],
            'CategoryName' => $row['CategoryName']
        ];
    }
}

// Close the connection
$conn->close();

// Return categories as JSON
header('Content-Type: application/json');
echo json_encode($categories);
?>
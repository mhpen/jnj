<?php
// Database connection

$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total amount based on order ID
$orderID = $_GET['orderID'];
$sql_total = "SELECT grandTotal FROM orders WHERE orderID = $orderID";
$result_total = $conn->query($sql_total);

if ($result_total->num_rows > 0) {
    $row = $result_total->fetch_assoc();
    $total = $row['grandTotal'];
    echo json_encode(array('total' => $total));
} else {
    echo json_encode(array('error' => 'No total amount found'));
}

$conn->close();
?>
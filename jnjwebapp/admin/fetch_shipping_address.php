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

// Fetch shipping address based on order ID
$orderID = $_GET['orderID'];
$sql_shipping = "SELECT CONCAT(AddressLine1, ', ', Barangay, ', ', City, ', ', Province, ', ', Country, ', ', PostalCode, ', ', Location) AS full_address FROM shippingaddress WHERE ShippingAddressID = (SELECT ShippingAddressID FROM shipping WHERE ShippingID = (SELECT ShippingID FROM orders WHERE OrderID = $orderID))";
$result_shipping = $conn->query($sql_shipping);

if ($result_shipping->num_rows > 0) {
    // Output shipping address as JSON
    $row_shipping = $result_shipping->fetch_assoc();
    $shippingInfo = array('address' => $row_shipping['full_address']);
    echo json_encode($shippingInfo);
} else {
    echo json_encode(array('error' => 'No shipping address found'));
}

$conn->close();
?>
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

// Fetch receiver information based on order ID
$orderID = $_GET['orderID'];
$sql_receiver = "SELECT * FROM receivercontact WHERE ReceiverID = (SELECT ReceiverID FROM orders WHERE OrderID = $orderID)";
$result_receiver = $conn->query($sql_receiver);

if ($result_receiver->num_rows > 0) {
    // Output receiver information as JSON
    $row_receiver = $result_receiver->fetch_assoc();
    $receiverInfo = array(
        'name' => $row_receiver['FirstName'] . ' ' . $row_receiver['LastName'],
        'phone' => $row_receiver['PhoneNum'],
        'email' => $row_receiver['EmailAddress']
);
    echo json_encode($receiverInfo);
} else {
    echo json_encode(array('error' => 'No receiver information found'));
}

$conn->close();
?>
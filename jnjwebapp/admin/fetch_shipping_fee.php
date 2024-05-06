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

// Check if the orderID parameter is set
if(isset($_GET['orderID'])) {
    // Sanitize the input to prevent SQL injection
    $orderID = mysqli_real_escape_string($conn, $_GET['orderID']);

    // SQL query to fetch shipping fee based on the orderID
    $sql = "SELECT s.shippingFee 
            FROM orders o 
            JOIN shipping s ON o.shippingID = s.shippingID
            WHERE o.orderID = '$orderID'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if there are any results
    if(mysqli_num_rows($result) > 0) {
        // Fetch the shipping fee
        $row = mysqli_fetch_assoc($result);
        $shippingFee = $row['shippingFee'];

        // Output the shipping fee as JSON
        echo json_encode(array('shippingFee' => $shippingFee));
    } else {
        // No shipping fee found for the given orderID
        echo json_encode(array('message' => 'No shipping fee found for the given orderID'));
    }
} else {
    // orderID parameter is not set
    echo json_encode(array('message' => 'orderID parameter is not set'));
}

// Close the database connection
$conn->close();
?>
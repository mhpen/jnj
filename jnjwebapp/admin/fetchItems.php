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

    // SQL query to fetch ordered items based on the orderID
    $sql = "SELECT ol.orderLineId, ol.productVarId, ol.quantity, ol.price, p.Name, pv.variationname, p.PhotoMain FROM orderLine ol INNER JOIN products p 
     ON ol.productID = p.productID INNER JOIN productVariations pv ON ol.productVarId = pv.productVarId 
     WHERE ol.orderID = '$orderID'"; // Assuming you're filtering by order ID

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if there are any results
    if(mysqli_num_rows($result) > 0) {
        // Fetch associative array of ordered items
        $orderedItems = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Output the ordered items data as JSON
        echo json_encode($orderedItems);
    } else {
        // No ordered items found for the given orderID
        echo json_encode(array('message' => 'No ordered items found for the given orderID'));
    }
} else {
    // orderID parameter is not set
    echo json_encode(array('message' => 'orderID parameter is not set'));
}

// Close the database connection
$conn->close();
?>
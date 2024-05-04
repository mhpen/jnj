<?php
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Decode JSON data from the request body
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if required fields are present
    if (isset($data['orderId'], $data['newStatus'])) {
        // Database connection
        $host = 'localhost';
        $dbname = 'jnjgiftsgalore_db';
        $username = 'root';
        $password = '';

        // Create connection
        $conn = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die(json_encode(array("success" => false, "error" => "Connection failed: " . $conn->connect_error)));
        }

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("UPDATE orders SET OrderStatus=? WHERE OrderID=?");
        $stmt->bind_param("si", $data['newStatus'], $data['orderId']); // Changed 'OrderID' to 'orderId'

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, "error" => "Error updating order status: " . $conn->error));
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Missing required fields
        echo json_encode(array("success" => false, "error" => "Missing orderId or newStatus"));
    }
} else {
    // Invalid request method
    echo json_encode(array("success" => false, "error" => "Invalid request method"));
}
?>
<?php
// Initialize session
session_start();

// Check if session ID is set
if (!isset($_GET['session_id'])) {
    echo json_encode(array('error' => 'Session ID not provided'));
    exit;
}

// Get the session ID
$sessionId = $_GET['session_id'];

// Fetch order details from the database based on the session ID
// Here, you would replace this with your actual database query logic
// Sample order details for demonstration
$orderDetails = array(
    "order_number" => "123456",
    "subtotal" => "50.00",
    "shipping_fee" => "10.00",
    "grand_total" => "60.00",
    "shipping_address" => array(
        "house_no" => "123",
        "barangay" => "Sample Barangay",
        "city" => "Sample City",
        "country" => "Sample Country",
        "zip_code" => "12345"
    ),
    "receiver_data" => array(
        "first_name" => "John",
        "last_name" => "Doe",
        "email" => "john.doe@example.com",
        "phone" => "123-456-7890"
    )
);

// Output order details as JSON
echo json_encode($orderDetails);
?>
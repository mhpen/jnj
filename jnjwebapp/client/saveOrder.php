<?php
// Start or resume a session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Handle case where user is not logged in
    echo json_encode(array("success" => false, "message" => "User not logged in."));
    exit();
}

// Continue with the rest of the script
// Define database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
    echo json_encode(array("success" => false, "message" => "Connection failed: " . $conn->connect_error));
    exit();
}

try {
    // Start a transaction
    $conn->begin_transaction();

    // Get the user ID from the session
    $UserID = $_SESSION['user_id'];
    $OrderStatus = 'Pending';

    // Extract order data from the POST request
    $ShippingAddressData = array(
        "Country" => isset($_POST['Country']) ? $_POST['Country'] : null,
        "PostalCode" => isset($_POST['PostalCode']) ? $_POST['PostalCode'] : null,
        "AddressLine1" => isset($_POST['AddressLine1']) ? $_POST['AddressLine1'] : null,
        "Barangay" => isset($_POST['Barangay']) ? $_POST['Barangay'] : null,
        "City" => isset($_POST['City']) ? $_POST['City'] : null,
        "Province" => isset($_POST['Province']) ? $_POST['Province'] : null, // Added province field
        "Location" => isset($_POST['Location']) ? $_POST['Location'] : null
    );
    $ReceiverData = array(
        "FirstName" => isset($_POST['FirstName']) ? $_POST['FirstName'] : null,
        "LastName" => isset($_POST['LastName']) ? $_POST['LastName'] : null,
        "PhoneNum" => isset($_POST['PhoneNum']) ? $_POST['PhoneNum'] : null,
        "EmailAddress" => isset($_POST['EmailAddress']) ? $_POST['EmailAddress'] : null
    );
    $ShippingFee = isset($_POST['shipping-fee']) ? $_POST['shipping-fee'] : null;
    $GrandTotal = isset($_POST['grand-total']) ? $_POST['grand-total'] : null;

    // Log received form data
    error_log("Received form data:");
    error_log(print_r($_POST, true));

    // Insert receiver data
    $ReceiverID = insertReceiver($conn, $UserID, $ReceiverData);

    // Insert shipping address data
    $ShippingAddressID = insertShippingAddress($conn, $UserID, $ShippingAddressData);

    // Insert order data using the IDs saved earlier
    $OrderID = insertOrder($conn, $UserID, $OrderStatus, $ShippingAddressID, $ReceiverID, $ShippingFee, $GrandTotal);

    // Commit the transaction
    $conn->commit();

    // Return success response
    echo json_encode(array("success" => true, "message" => "Order saved successfully!", "order_id" => $OrderID));
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $conn->rollback();
    // Log error message
    error_log("Error: " . $e->getMessage());
    echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
} finally {
    // Close the database connection
    $conn->close();
}

// Function to insert receiver data
function insertReceiver($conn, $UserID, $ReceiverData) {
    $sql = "INSERT INTO receivercontact (UserID, FirstName, LastName, PhoneNum, EmailAddress) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $UserID, $ReceiverData["FirstName"], $ReceiverData["LastName"], $ReceiverData["PhoneNum"], $ReceiverData["EmailAddress"]);
    $stmt->execute();
    return $stmt->insert_id; // Return the ID of the inserted receiver
}

// Function to insert shipping address data
function insertShippingAddress($conn, $UserID, $ShippingAddressData) {
    $sql = "INSERT INTO shippingaddress (UserID, Country, PostalCode, AddressLine1, Barangay, City, Province, Location) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssss", $UserID, $ShippingAddressData["Country"], $ShippingAddressData["PostalCode"], $ShippingAddressData["AddressLine1"], $ShippingAddressData["Barangay"], $ShippingAddressData["City"], $ShippingAddressData["Province"], $ShippingAddressData["Location"]);
    $stmt->execute();
    return $stmt->insert_id; // Return the ID of the inserted shipping address
}

// Function to insert order data
function insertOrder($conn, $UserID, $OrderStatus, $ShippingAddressID, $ReceiverID, $ShippingFee, $GrandTotal) {
    $sql = "INSERT INTO `Orders` (UserID, OrderStatus, ShippingAddressID, ReceiverID, ShippingFee, GrandTotal) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiidd", $UserID, $OrderStatus, $ShippingAddressID, $ReceiverID, $ShippingFee, $GrandTotal);
    $stmt->execute();
    return $stmt->insert_id; // Return the ID of the inserted order
}
?>
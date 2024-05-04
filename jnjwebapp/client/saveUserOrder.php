<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Handle case where user is not logged in
    echo json_encode(array("success" => false, "message" => "User not logged in."));
    exit();
}

// Define database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';
$orderID = $_SESSION['order_id'];

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
    $userID = $_SESSION['user_id'];

    // Extract order data from the POST request
    $firstName = $_POST['FirstName'] ?? '';
    $lastName = $_POST['LastName'] ?? '';
    $phoneNum = $_POST['PhoneNum'] ?? '';
    $emailAddress = $_POST['EmailAddress'] ?? '';
    $country = $_POST['Country'] ?? '';
    $postalCode = $_POST['PostalCode'] ?? '';
    $addressLine1 = $_POST['AddressLine1'] ?? '';
    $barangay = $_POST['Barangay'] ?? '';
    $city = $_POST['City'] ?? '';
    $province = $_POST['Province'] ?? '';
    $location = $_POST['Location'] ?? '';
    $shippingOption = $_POST['ShippingOption'] ?? '';
    $shippingFee = $_POST['ShippingFee'] ?? '';

    // Update receiver contact data
    $sql = "INSERT INTO receivercontact (UserID, FirstName, LastName, PhoneNum, EmailAddress) 
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            FirstName = VALUES(FirstName), LastName = VALUES(LastName), PhoneNum = VALUES(PhoneNum), EmailAddress = VALUES(EmailAddress)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $userID, $firstName, $lastName, $phoneNum, $emailAddress);
    $stmt->execute();

    // Get the ReceiverID value after inserting a new row into the receivercontact table
    $receiverID = $conn->insert_id;

    // Get or insert shipping address ID
    $sql = "SELECT ShippingAddressID FROM shippingaddress WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $shippingAddressID = $row['ShippingAddressID'];
    } else {
        $sql = "INSERT INTO shippingaddress (UserID, Country, PostalCode, AddressLine1, Barangay, City, Province, Location) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssss", $userID, $country, $postalCode, $addressLine1, $barangay, $city, $province, $location);
        $stmt->execute();
        $shippingAddressID = $stmt->insert_id;
    }

    // Insert shipping data
    $sql = "INSERT INTO shipping (ShippingOption, ShippingFee, ShippingAddressID) 
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $shippingOption, $shippingFee, $shippingAddressID);
    $stmt->execute();

    // Get the newly inserted shipping ID
    $shippingID = $stmt->insert_id;

    // Calculate Total Price
    $totalPriceSQL = "SELECT SUM(price) AS total_price FROM orderline WHERE orderID = ?";
    $totalPriceStmt = $conn->prepare($totalPriceSQL);
    $totalPriceStmt->bind_param("i", $orderID);
    $totalPriceStmt->execute();
    $totalPriceResult = $totalPriceStmt->get_result();
    $totalPriceRow = $totalPriceResult->fetch_assoc();
    $totalPrice = $totalPriceRow['total_price'];

    // Ensure $totalPrice is numeric
    $totalPrice = is_numeric($totalPrice) ? $totalPrice : 0;

    // Ensure $shippingFee is numeric
    $shippingFee = is_numeric($shippingFee) ? $shippingFee : 0;

    // Calculate Grand Total
    $grandTotal = $totalPrice + $shippingFee;

    // Update the order with the new values
    $sql = "UPDATE Orders SET ReceiverID = ?, ShippingID = ?, GrandTotal = ? WHERE OrderID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $receiverID, $shippingID, $grandTotal, $orderID);
    $stmt->execute();

    // Commit the transaction
    $conn->commit();

    // Return success response
    echo json_encode(array("success" => true, "message" => "Order updated successfully!"));
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
?>
<?php
session_start();

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

// Check if variation_id, quantity, product_id, and personalization_id are set in the POST data
if (isset($_POST['variation_id']) && isset($_POST['quantity']) && isset($_POST['product_id'])) {
    // Get variation ID, quantity, product ID from POST data
    $variation_id = $_POST['variation_id'];
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $userID = $_SESSION['user_id']; // Get user ID from session
    } else {
        // Respond with an error message if user is not logged in
        echo "Error: User not logged in.";
        exit();
    }

    // Check if the product is personalizable
    $personalizable = false; // Default to not personalizable
    $personalization_id = null; // Default to null for personalization ID
    $sql_personalizable = "SELECT personalizable FROM Products WHERE ProductID = ?";
    $stmt_personalizable = $conn->prepare($sql_personalizable);
    $stmt_personalizable->bind_param("i", $product_id);
    $stmt_personalizable->execute();
    $result_personalizable = $stmt_personalizable->get_result();
    if ($result_personalizable->num_rows > 0) {
        $product = $result_personalizable->fetch_assoc();
        $personalizable = $product['personalizable'];
    }

    // If the product is personalizable, get personalization ID from session
    if ($personalizable) {
        // Ensure personalization_id is set in the session
        if (isset($_SESSION['personalization_id'])) {
            $personalization_id = $_SESSION['personalization_id'];
        } else {
            // Respond with an error message if personalization ID is not set in session
            echo "Error: Personalization ID not found.";
            exit();
        }
    }

    // Get or generate cart ID
    if(isset($_SESSION['cart_id'])){
        $cartId = $_SESSION['cart_id'];
    } else {
        // Generate a new cart ID
        $cartId = uniqid('cart_');
        $_SESSION['cart_id'] = $cartId;
    }

    // Fetch variation price from the database
    $sql_variation = "SELECT Price FROM ProductVariations WHERE ProductVarID = ?";
    $stmt_variation = $conn->prepare($sql_variation);
    $stmt_variation->bind_param("i", $variation_id);
    $stmt_variation->execute();
    $result_variation = $stmt_variation->get_result();
    $variation = $result_variation->fetch_assoc();
    $variation_price = $variation['Price'];

    // Calculate the total price
    $total_price = $variation_price * $quantity;

    // Insert the product into the cart table
    $sql = "INSERT INTO cartItem (userID, productID, ProductVarID, PersonalizationID, quantity, total, cartId) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiidi", $userID, $product_id, $variation_id, $personalization_id, $quantity, $total_price, $cartId );

    if ($stmt->execute()) {
        // Respond with a success message
        echo "Product added to cart successfully!";
    } else {
        // Respond with an error message if insertion fails
        echo "Error: " . $conn->error;
    }
} else {
    // Respond with an error message if variation_id, quantity, product_id is not set
    echo "Error: Variation ID, quantity, or product ID not provided.";
}

// Close the database connection
$conn->close();
?>
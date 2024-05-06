<?php
// Check if the category ID is set and not empty
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    // Get the category ID from the URL
    $categoryId = $_GET["id"];

    // Perform any necessary validation or sanitation here

    // Delete the category from the database
    // Replace the database connection details with your own
    $host = 'localhost';
    $dbname = 'jnjgiftsgalore_db';
    $username = 'root';
    $password = '';
    
    // Create a new connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "DELETE FROM categories WHERE CategoryID = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);

    // Execute the statement
    if ($stmt->execute()) {
        // Category deleted successfully
        echo "Category deleted successfully!";
    } else {
        // Error occurred while deleting category
        echo "Error: " . $conn->error;
    }

    // Close statement and close connection
    $stmt->close();
    $conn->close();
} else {
    // Category ID is not set or empty
    echo "Category ID is required!";
}
?>
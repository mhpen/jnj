<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the category ID and name are set and not empty
    if (isset($_POST["categoryId"]) && isset($_POST["categoryName"]) && !empty($_POST["categoryId"]) && !empty($_POST["categoryName"])) {
        // Get the category ID and name from the form
        $categoryId = $_POST["categoryId"];
        $categoryName = $_POST["categoryName"];

        // Perform any necessary validation or sanitation here

        // Update the category in the database
        // Replace the database connection details with your own
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

        

        // Prepare the SQL statement
        $sql = "UPDATE categories SET CategoryName = ? WHERE CategoryID = ?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $categoryName, $categoryId);

        // Execute the statement
        if ($stmt->execute()) {
            // Category updated successfully
            echo "Category updated successfully!";
        } else {
            // Error occurred while updating category
            echo "Error: " . $conn->error;
        }

        // Close statement and close connection
        $stmt->close();
        $conn->close();
    } else {
        // Category ID or name is not set or empty
        echo "Category ID and name are required!";
    }
} else {
    // Redirect back to the page if accessed directly without form submission
    header("Location: category.php");
    exit;
}
?>
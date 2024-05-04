<?php
// Check if the product ID is provided
if(isset($_GET['id'])) {
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

    // Fetch product details from the database
    $id = $_GET['id'];
    $sql = "SELECT p.*, c.CategoryName
            FROM products p
            INNER JOIN categories c ON p.CategoryID = c.CategoryID
            WHERE p.ProductID = $id";
    $result = $conn->query($sql);

    // Check if the product exists
    if ($result->num_rows > 0) {
        // Output product details
        $row = $result->fetch_assoc();
        echo "<h2>" . $row["Name"] . "</h2>";
        echo "<p>Main Picture: <img src='../images/" . $row["PhotoMain"] . "' alt='Main Picture' style='width: 200px;'></p>";
        echo "<p>Price: $" . $row["productprice"] . "</p>";
        echo "<p>Category: " . $row["CategoryName"] . "</p>";
        echo "<p>Status: " . $row["ProductStatus"] . "</p>";

        // Fetch and display product variations
        $sql_variations = "SELECT * FROM productvariations WHERE ProductID = $id";
        $result_variations = $conn->query($sql_variations);
        if ($result_variations->num_rows > 0) {
            echo "<h3>Variations:</h3>";
            echo "<table>";
            echo "<tr><th>Variation</th><th>Price</th></tr>";
            while($variation_row = $result_variations->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $variation_row["VariationName"] . "</td>";
                echo "<td>$" . $variation_row["Price"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No variations available for this product.</p>";
        }
    } else {
        echo "Product not found";
    }

    // Close database connection
    $conn->close();
} else {
    echo "Product ID not provided";
}
?>
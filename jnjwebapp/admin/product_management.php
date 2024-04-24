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

// Delete Product Functionality
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete related records from productvariations table
    $sql_delete_variations = "DELETE FROM productvariations WHERE ProductID = $id";
    $conn->query($sql_delete_variations);

    // Delete product from products table
    $sql_delete_product = "DELETE FROM products WHERE ProductID = $id";
    if ($conn->query($sql_delete_product) === TRUE) {
        echo '<script>alert("Product deleted successfully");</script>';
    } else {
        echo '<script>alert("Error deleting product: ' . $conn->error . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        button {
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            background-color: #333;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: normal;
        }

        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .action-buttons button {
            margin-right: 5px;
        }

        .action-buttons button {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            background-color: #333;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .action-buttons button:hover {
            background-color: #555;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = 'product_management.php?action=delete&id=' + id;
            }
        }

        function openView(id) {
            window.open('view.php?id=' + id, 'Product View', 'width=600, height=400');
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Product Management</h1>
        <button onclick="location.href='add_product.php'">Add</button>
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.*, c.CategoryName
                        FROM products p
                        INNER JOIN categories c ON p.CategoryID = c.CategoryID";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        // Displaying the photo (assuming 'PhotoMain' is a column in the products table containing the image path)
                        echo "<td><img src='../images/" . $row["PhotoMain"] . "' alt='Product Image'></td>";


                        echo "<td>" . $row["Name"] . "</td>";
                        echo "<td>$" . $row["productprice"] . "</td>";
                        echo "<td>" . $row["CategoryName"] . "</td>";
                        echo "<td>" . $row["ProductStatus"] . "</td>";
                        echo "<td class='action-buttons'>
                                <button onclick=\"openView(" . $row["ProductID"] . ")\">View</button> 
                                <button onclick=\"location.href='edit_product.php?id=" . $row["ProductID"] . "'\">Edit</button> 
                                <button onclick=\"confirmDelete(" . $row["ProductID"] . ")\">Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
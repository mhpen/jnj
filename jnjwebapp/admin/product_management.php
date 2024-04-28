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

// Fetch product data function
function fetchProducts($searchQuery = '', $sort = 'default', $category = '0') {
    global $conn;

    $sql = "SELECT p.*, c.CategoryName
            FROM products p
            INNER JOIN categories c ON p.CategoryID = c.CategoryID";

    if (!empty($searchQuery)) {
        $sql .= " WHERE p.Name LIKE '%$searchQuery%'";
    }

    if ($category !== '0') {
        $sql .= " AND p.CategoryID = '$category'";
    }

    switch ($sort) {
        case 'price_low_to_high':
            $sql .= " ORDER BY p.productprice ASC";
            break;
        case 'price_high_to_low':
            $sql .= " ORDER BY p.productprice DESC";
            break;
        case 'newest':
            $sql .= " ORDER BY p.ProductID DESC";
            break;
        case 'older':
            $sql .= " ORDER BY p.ProductID ASC";
            break;
        default:
            // Do nothing, keep the default ordering
            break;
    }

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
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
    } else {
        echo "<tr><td colspan='6'>Error fetching products</td></tr>";
    }
}

// Fetch categories function
function fetchCategories() {
    global $conn;

    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['CategoryID'] . '">' . $row['CategoryName'] . '</option>';
            }
        } else {
            echo '<option value="">No categories available</option>';
        }
    } else {
        echo '<option value="">Error fetching categories</option>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <style>
        /* Styles for the rest of the page */
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
            width: 200px;
            height: auto;
            object-fit: cover;
            border-radius: 4px;
            float: right;
            margin-left: 20px;
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = 'product_management.php?action=delete&id=' + id;
            }
        }

        function openView(id) {
            var modal = document.getElementById('productModal');
            var span = document.getElementsByClassName("close")[0];
            var productInfo = document.getElementById('productInfo');

            // Open the modal
            modal.style.display = "block";

            // AJAX request to fetch product details
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Populate modal with product details
                    productInfo.innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "get_product_details.php?id=" + id, true);
            xhr.send();

            // Close the modal when close button is clicked
            span.onclick = function() {
                modal.style.display = "none";
            }

            // Close the modal when clicking outside of it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }

        function searchProducts() {
            var searchQuery = document.getElementById('searchInput').value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("productTableBody").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "search_products.php?search=" + searchQuery, true);
            xhttp.send();
        }

        function sortProducts() {
            var sortValue = document.getElementById('sortSelect').value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("productTableBody").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "sort_products.php?sort=" + sortValue, true);
            xhttp.send();
        }

        function filterProducts() {
            var categoryValue = document.getElementById('categorySelect').value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("productTableBody").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "filter_products.php?category=" + categoryValue, true);
            xhttp.send();
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Product Management</h1>
        <div>
            <input type="text" id="searchInput" placeholder="Search...">
            <button onclick="searchProducts()">Search</button>
            <select id="sortSelect" onchange="sortProducts()">
                <option value="default" >Default</option>
                <option value="price_low_to_high">Price Low to High</option>
                <option value="price_high_to_low">Price High to Low</option>
                <option value="newest">Newest</option>
                <option value="older">Older</option>
            </select>
            <select id="categorySelect" onchange="filterProducts()">
                <option value="0">All Categories</option>
                <?php fetchCategories(); ?>
            </select>
            
            <!-- Add button -->
            <button onclick="location.href='add_product.php'">Add Product</button>
        </div>
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
            <tbody id="productTableBody">
                <?php fetchProducts(); ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('productModal').style.display = 'none'">&times;</span>
            <div id="productInfo"></div>
        </div>
    </div>
</body>
</html>
<?php
// Include database connection
require_once '../client/connection.php';

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$category = isset($_GET['category']) ? $_GET['category'] : '0';

fetchProducts($searchQuery, $sort, $category);

function fetchProducts($searchQuery = '', $sort = 'default', $category = '0') {
    global $conn;

    $sql = "SELECT p.*, c.CategoryName
            FROM products p
            INNER JOIN categories c ON p.CategoryID = c.CategoryID";

    if (!empty($searchQuery)) {
        $sql.= " WHERE p.Name LIKE '%$searchQuery%'";
    }

    if ($category!== '0') {
        $sql.= " AND p.CategoryID = '$category'";
    }

    switch ($sort) {
        case 'price_low_to_high':
            $sql.= " ORDER BY p.productprice ASC";
            break;
        case 'price_high_to_low':
            $sql.= " ORDER BY p.productprice DESC";
            break;
        case 'newest':
            $sql.= " ORDER BY p.ProductID DESC";
            break;
        case 'older':
            $sql.= " ORDER BY p.ProductID ASC";
            break;
        default:
            // Do nothing, keep the default ordering
            break;
    }

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><img src='../images/". $row["PhotoMain"]. "' alt='Product Image'></td>";
                echo "<td>". $row["Name"]. "</td>";
                echo "<td>$". $row["productprice"]. "</td>";
                echo "<td>". $row["CategoryName"]. "</td>";
                echo "<td>". $row["ProductStatus"]. "</td>";
                echo "<td class='action-buttons'>
                        <button onclick=\"openView(". $row["ProductID"]. ")\">View</button> 
                        <button onclick=\"location.href='edit_product.php?id=". $row["ProductID"]. "'\">Edit</button> 
                        <button onclick=\"confirmDelete(". $row["ProductID"]. ")\">Delete</button>
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
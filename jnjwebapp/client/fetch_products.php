<?php
// Include your database connection here
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch products from the database
$limit = 12; // Number of products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$searchValue = isset($_GET['search']) ? $_GET['search'] : '';
$priceFilter = isset($_GET['price']) ? $_GET['price'] : 0;
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : 0;
$sortFilter = isset($_GET['sort']) ? $_GET['sort'] : 'default';

$sql = "SELECT * FROM products WHERE (Name LIKE '%$searchValue%')";

if ($priceFilter != 0) {
    switch ($priceFilter) {
        case 1:
            $sql .= " AND productprice < 10";
            break;
        case 2:
            $sql .= " AND productprice >= 10 AND productprice <= 50";
            break;
        case 3:
            $sql .= " AND productprice >= 50 AND productprice <= 100";
            break;
        case 4:
            $sql .= " AND productprice > 100";
            break;
    }
}

if ($categoryFilter != 0) {
    $sql .= " AND CategoryID = $categoryFilter";
}

switch ($sortFilter) {
    case 'price_low_to_high':
        $sql .= " ORDER BY productprice ASC";
        break;
    case 'price_high_to_low':
        $sql .= " ORDER BY productprice DESC";
        break;
    case 'newest':
        $sql .= " ORDER BY DateAdded DESC";
        break;
    case 'older':
        $sql .= " ORDER BY DateAdded ASC";
        break;
    default:
        $sql .= " ORDER BY ProductID DESC";
}

$sql .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <style>
            .products {
    position: relative; /* Ensure the products section remains in the document flow */
    z-index: 0; /* Lower z-index to ensure the products are beneath the chat interface */
}
        </style>
        <div class="product">
            <div class="photo-field">
                <a href="quickview.php?ProductID=<?php echo $row['ProductID']; ?>">
                    <img src='../images/<?php echo $row["PhotoMain"]; ?>' alt='Product Image'>
                </a>
                <!-- Wrap the Quick View button with an anchor tag -->
                <a href="quickview.php?ProductID=<?php echo $row['ProductID']; ?>" class="quick-view-button" data-productid="<?php echo $row['ProductID']; ?>">
                    Quick View (ID: <?php echo $row['ProductID']; ?>)
                </a>
            </div>
            <h3>
                <a href="quickview.php?ProductID=<?php echo $row['ProductID']; ?>">
                    <?php echo $row['Name']; ?>
                </a>
            </h3>
            <div class="price">₱<?php echo $row['productprice']; ?></div>
            <button>Add to Cart</button>
        </div>
        <?php
    }
} else {
    echo '<p>No products found</p>';
}

$conn->close();
?>
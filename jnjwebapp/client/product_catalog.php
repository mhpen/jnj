<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Catalog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background-color: #f3f4f6;
        }
        .container {
            max-width: 1200px;
            width: 90%;
        }
        /* Navigation Section */
        .navigation {
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            height: 87px;
            background-color: #FFFFFF;
            padding: 0 20px;
            box-shadow: 0px 4px 24.3px 0px #0000001A;
            z-index: 1;
        }

        .navigation .logo {
            font-family: "Playfair Display", serif;
            font-size: 48px;
            font-weight: bold;
            color: #353434;
            position: absolute; /* Position the logo absolutely */
            left: 50%; /* Move the logo to the center horizontally */
            transform: translateX(-50%); /* Adjust the position to the left by half of its own width */
        }

        .navigation .nav-links {
            display: flex;
        }

        .navigation .nav-links a {
            font-family: "Montserrat", sans-serif;
            font-size: 16px;
            font-weight: 100;
            color: #3E3A2C;
            text-decoration: none;
            margin-right: 20px;
        }

        .navigation .user-actions {
            display: flex;
        }

        .navigation .user-actions a {
            color: #3E3A2C;
            text-decoration: none;
            margin-right: 10px;
        }
      /* Search and Filter Section */
.search-filter {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    border-radius: 8px;
    margin-top: 100px;
}

.search {
    display: flex;
    align-items: center;
}

.filter {
    display: flex;
    align-items: center;
    margin-right: 20px;
}

.filter-text {
    margin-right: 10px;
}

.filter select, .search input[type="text"], .search button, .sort-by select {
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 16px;
    cursor: pointer;
}

.filter select:hover, .search input[type="text"]:hover, .search button:hover, .sort-by select:hover {
    border-color: #333;
}

.sort-by {
    display: flex;
    align-items: center;
}

.sort-by label {
    margin-right: 10px;
}
        /* Product Display Section */
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 20px;
        }
        .product {
            background-color: #fff;
            padding: 20px;
            box-shadow:0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease-in-out;
            position: relative;
        }
        .product:hover {
            background-color: #f8f8f8;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            transform: scale(1.02);
        }
        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
        }
        .product:hover img {
            transform: scale(1.1);
        }
        .product h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .product .price {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }
        .product button {
            background-color: #333;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .product button:hover {
            background-color: #555;
        }
        .quick-view-button {
            color: white;
            border: 2px solid #04AA6D;
            padding: 10px 20px;
            border: 2px solid #fff;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 20px;
            transition: all 0.3s ease-in-out;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }
        .product:hover .quick-view-button {
            display: block;
        }
        .quick-view-button:hover {
            background-color: #04AA6D;
            color: white;
        }
        /* Pagination Section */
        .pagination {
            margin-top: 20px;
        }
        .pagination button {
            background-color: #333;
            color: #fff;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        .pagination button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigation Section -->
       <div class="navigation">
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
        </div>
        
        <div class="logo">J&J</div>
        <div class="user-actions">
            <a href="#">Login</a>
            <a href="#">Cart</a>
        </div>
    </div>

   
      <!-- Search and Filter Section -->
<div class="search-filter">
    <div class="search">
        <div class="filter">
            <div class="filter-text">
                <label for="price">Filter:</label>
                <select name="price" id="price">
                    <option value="0">All Prices</option>
                    <option value="1">Under ₱10</option>
                    <option value="2">₱10 - ₱50</option>
                    <option value="3">₱50 - ₱100</option>
                    <option value="4">Over ₱100</option>
                </select>
            </div>
            <div>
                <label for="category">Category:</label>
                <select name="category" id="category">
                    <option value="0">All</option>
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

                    $sql = "SELECT * FROM categories";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['CategoryID'] . '">' . $row['CategoryName'] . '</option>';
                        }
                    } else {
                        echo '<option value="">No categories available</option>';
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
        </div>
        <div class="sort-by">
            <label for="sort">Sort By:</label>
            <select name="sort" id="sort">
                <option value="default">Default</option>
                <option value="price_low_to_high">Price Low to High</option>
                <option value="price_high_to_low">Price High to Low</option>
                <option value="newest">Newest</option>
                <option value="older">Older</option>
            </select>
        </div>
    </div>
    <div class="search">
        <div class="search-text">
            <label for="search"></label>
            <input type="text" name="search" id="search" placeholder="Search...">
            <button id="search-button">Search</button>
        </div>
    </div>
</div>

        <!-- Product Display Section -->
        <div class="products">
            <?php include 'fetch_products.php'; ?>
        </div>

        <!-- Pagination Section -->
        <div class="pagination">
            <button id="prevBtn">Previous</button>
            <button id="page1">1</button>
            <button id="page2">2</button>
            <button id="page3">3</button>
            <button id="nextBtn">Next</button>
        </div>

        <script>
            // Pagination
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");
            const page1 = document.getElementById("page1");
            const page2 = document.getElementById("page2");
            const page3 = document.getElementById("page3");

            let currentPage = 1;

            page1.addEventListener("click", () => {
                currentPage = 1;
                fetchProducts();
            });

            page2.addEventListener("click", () => {
                currentPage = 2;
                fetchProducts();
            });

            page3.addEventListener("click", () => {
                currentPage = 3;
                fetchProducts();
            });

            prevBtn.addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    fetchProducts();
                }
            });

            nextBtn.addEventListener("click", () => {
                currentPage++;
                fetchProducts();
            });

            function fetchProducts() {
                const limit = 9; // Number of products per page
                const offset = (currentPage - 1) * limit;
                const priceFilter = document.getElementById("price").value;
                const categoryFilter = document.getElementById("category").value;
                const sortFilter = document.getElementById("sort").value;
                const searchValue = document.getElementById("search").value;

                let url = `fetch_products.php?page=${currentPage}&price=${priceFilter}&category=${categoryFilter}&sort=${sortFilter}&search=${searchValue}`;

                fetch(url)
                    .then((response) => response.text())
                    .then((data) => {
                        document.querySelector(".products").innerHTML = data;
                    });
            }

            document.addEventListener("DOMContentLoaded", fetchProducts);

            // Search filter
            const searchBtn = document.getElementById("search-button");
            searchBtn.addEventListener("click", () => {
                currentPage = 1;
                fetchProducts();
            });

            // Filter and sorting change events
            document.getElementById("price").addEventListener("change", () => {
                currentPage = 1;
                fetchProducts();
            });

            document.getElementById("category").addEventListener("change", () => {
                currentPage = 1;
                fetchProducts();
            });

            document.getElementById("sort").addEventListener("change", () => {
                currentPage = 1;
                fetchProducts();
            });
        </script>
    </div>
</body>
</html>
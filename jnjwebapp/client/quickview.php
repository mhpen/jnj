<?php
require "connection.php";

    

?>

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

   <!-- First Section - Navigation -->
    <div style="height: 10%"></div>

    <!-- Second Section - Product Details -->
    <div style="display: flex; height: 70%; width: 100%">
        <!-- First Child -->
        <div style="width: 10%; height: 100%; overflow-y: auto;">
            <div style="height: 33.33%; padding: 5px; border-bottom: 1px solid #ccc;">
                <img src="product1.jpg" style="width: 100%; cursor: pointer;" onclick="showPreview('product1.jpg')">
            </div>
            <div style="height: 33.33%; padding: 5px; border-bottom: 1px solid #ccc;">
                <img src="product2.jpg" style="width: 100%; cursor: pointer;" onclick="showPreview('product2.jpg')">
            </div>
            <div style="height: 33.33%; padding: 5px;">
                <img src="product3.jpg" style="width: 100%; cursor: pointer;" onclick="showPreview('product3.jpg')">
            </div>
        </div>
        <!-- Second Child -->
        <div style="width: 40%; height: 100%; padding: 10px;">
            <div id="preview" style="height: 60%; overflow-y: auto;"></div>
        </div>
        <!-- Third Child -->
        <div style="width: 50%; height: 100%; overflow-y: auto; padding: 10px;">
            <div>
                <h2 id="productName">Product Name</h2>
                <p>Category: <span id="category">Category</span></p>
                <hr>
                <div id="description">
                    <p>This is a brief description of the product. Click the button to see more.</p>
                </div>
                <button onclick="toggleDescription()">Show More</button>
                <hr>
                <div id="additional_info">
                    <p>Additional information. Click the button to see more.</p>
                </div>
                <button onclick="toggleAdditionalInfo()">Show More</button>
                <hr>
                <button>Add to Cart</button>
                <button>Buy Now</button>
            </div>
        </div>
    </div>

    <!-- Third Section - Product Recommendation -->
    <div style="height: 20%; width: 100%; overflow-y: auto;">
        <h2>Product Recommendation</h2>
        <div class="products">
            <!-- Fetch and display the related products here -->
            <?php include 'fetch_products.php'; ?>
        </div>
    </div>

    <!-- Fourth Section - Footer -->
    <div style="height: 10%; width: 100%; background-color: #333; color: #fff; text-align: center; padding: 20px 0;">
        Footer
    </div>

    <div id="quickViewModal" class="quick-view-modal">
        <div class="quick-view-content">
            <span class="close" onclick="closeQuickView()">&times;</span>
            <h2 id="quickViewProductName"></h2>
            <p>Category: <span id="quickViewCategory"></span></p>
            <hr>
            <div id="quickViewDescription">
                <p>This is a brief description of the product. Click the button to see more.</p>
            </div>
            <button onclick="toggleQuickViewDescription()">Show More</button>
            <hr>
            <div id="quickViewAdditionalInfo">
                <p>Additional information. Click the button to see more.</p>
            </div>
            <button onclick="toggleQuickViewAdditionalInfo()">Show More</button>
            <hr>
            <button>Add to Cart</button>
            <button>Buy Now</button>
        </div>
    </div>

    <script>
        function showPreview(image) {
            document.getElementById('preview').innerHTML = `<img src="${image}" style="width: 100%;">`;
        }

        function toggleDescription() {
            const description = document.getElementById('description');
            const button = description.nextElementSibling;
            if (description.style.display === "none") {
                description.style.display = "block";
                button.innerText = "Show Less";
            } else {
                description.style.display = "none";
                button.innerText = "Show More";
            }
        }

        function toggleAdditionalInfo() {
            const additional_info = document.getElementById('additional_info');
            const button = additional_info.nextElementSibling;
            if (additional_info.style.display === "none") {
                additional_info.style.display = "block";
                button.innerText = "Show Less";
            } else {
                additional_info.style.display = "none";
                button.innerText = "Show More";
            }
        }

        // Quick View
        function showQuickView(productName, category, description, additionalInfo) {
            const quickViewProductName = document.getElementById('quickViewProductName');
            const quickViewCategory = document.getElementById('quickViewCategory');
            const quickViewDescription = document.getElementById('quickViewDescription');
            const quickViewAdditionalInfo = document.getElementById('quickViewAdditionalInfo');

            quickViewProductName.textContent = productName;
            quickViewCategory.textContent = category;
            quickViewDescription.innerHTML = `<p>${description}</p>`;
            quickViewAdditionalInfo.innerHTML = `<p>${additionalInfo}</p>`;

            const modal = document.getElementById('quickViewModal');
            modal.style.display = 'block';
        }

        function closeQuickView() {
            const modal = document.getElementById('quickViewModal');
            modal.style.display = 'none';
        }

        function toggleQuickViewDescription() {
            const description = document.getElementById('quickViewDescription');
            const button = description.nextElementSibling;
            if (description.style.display === "none" || description.style.display === "") {
                description.style.display = "block";
                button.innerText = "Show Less";
            } else {
                description.style.display = "none";
                button.innerText = "Show More";
            }
        }

        function toggleQuickViewAdditionalInfo() {
            const additional_info = document.getElementById('quickViewAdditionalInfo');
            const button = additional_info.nextElementSibling;
            if (additional_info.style.display === "none" || additional_info.style.display === "") {
                additional_info.style.display = "block";
                button.innerText = "Show Less";
            } else {
                additional_info.style.display = "none";
                button.innerText = "Show More";
            }
        }

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
</body>
</html>
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

// Notice message
$notice = '';

// Redirect to the product management page if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product details from the form
    $productName = $_POST['productName'] ?? '';
    $productDescription = $_POST['productDescription'] ?? '';
    $productInclusion = $_POST['productInclusion'] ?? '';
    $productPrice = $_POST['productPrice'] ?? 0;
    $productCategory = $_POST['productCategory'] ?? '';
    $productImage = $_FILES['productImage'] ?? '';
    $productImage2 = $_FILES['productImage2'] ?? '';
    $productImage3 = $_FILES['productImage3'] ?? '';
    $productImage4 = $_FILES['productImage4'] ?? '';
    $productStatus = $_POST['productStatus'] ?? '';

    // Get the product variations from the form
    $variationNames = $_POST['variationName'] ?? [];
    $variationPrices = $_POST['variationPrice'] ?? [];


    // Validate the product details
    if (empty($productName) || empty($productDescription) || empty($productInclusion) || empty($productPrice) || empty($productCategory) || empty($productStatus) || empty($productImage) || empty($productImage2) || empty($productImage3) || empty($productImage4)) {
        die('Please fill in all required fields.');
    }

    // Validate the product variations
    if (count($variationNames) !== count($variationPrices)) {
        die('Please ensure that the number of variation names and prices match.');
    }

    // Prepare the SQL statement for getting the CategoryID
    $stmt_category = $conn->prepare("SELECT CategoryID FROM categories WHERE CategoryID = ?");
    $stmt_category->bind_param("i", $productCategory);
    $stmt_category->execute();
    $result_category = $stmt_category->get_result();
    if ($result_category->num_rows > 0) {
        $row_category = $result_category->fetch_assoc();
        $categoryId = $row_category['CategoryID'];
    } else {
        die('Invalid category selected.');
    }

    // Handle photo uploading
    $targetDir = "../images/";

    if (!empty($_FILES["productImage"]["name"])) {
        $targetFile1 = $targetDir . basename($_FILES["productImage"]["name"]);
        $imageFileType1 = strtolower(pathinfo($targetFile1, PATHINFO_EXTENSION));
        $photo1 = $_FILES['productImage']['name'];

        if (!in_array($imageFileType1, ['jpg', 'jpeg', 'png', 'gif'])) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed for Image 1.");
        }

        move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile1);
    } else {
        die("Product Image 1 is required.");
    }

    if (!empty($_FILES["productImage2"]["name"])) {
        $targetFile2 = $targetDir . basename($_FILES["productImage2"]["name"]);
        $imageFileType2 = strtolower(pathinfo($targetFile2, PATHINFO_EXTENSION));
        $photo2 = $_FILES['productImage2']['name'];

        if (!in_array($imageFileType2, ['jpg', 'jpeg', 'png', 'gif'])) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed for Image 2.");
        }

        move_uploaded_file($_FILES["productImage2"]["tmp_name"], $targetFile2);
    } else {
        die("Product Image 2 is required.");
    }

    if (!empty($_FILES["productImage3"]["name"])) {
        $targetFile3 = $targetDir . basename($_FILES["productImage3"]["name"]);
        $imageFileType3 = strtolower(pathinfo($targetFile3, PATHINFO_EXTENSION));
        $photo3 = $_FILES['productImage3']['name'];

        if (!in_array($imageFileType3, ['jpg', 'jpeg', 'png', 'gif'])) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed for Image 3.");
        }

        move_uploaded_file($_FILES["productImage3"]["tmp_name"], $targetFile3);
    } else {
        die("Product Image 3 is required.");
    }

    if (!empty($_FILES["productImage4"]["name"])) {
        $targetFile4 = $targetDir . basename($_FILES["productImage4"]["name"]);
        $imageFileType4 = strtolower(pathinfo($targetFile4, PATHINFO_EXTENSION));
        $photo4 = $_FILES['productImage4']['name'];

        if (!in_array($imageFileType4, ['jpg', 'jpeg', 'png', 'gif'])) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed for Image 4.");
        }

        move_uploaded_file($_FILES["productImage4"]["tmp_name"], $targetFile4);
    } else {
        die("Product Image 4 is required.");
    }

    // Prepare the SQL statement for inserting the product
    $stmt = $conn->prepare("INSERT INTO products (Name, description_text, inclusion, productprice, CategoryID, PhotoMain, Photo2, Photo3, Photo4, DateAdded, ProductStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
    $stmt->bind_param("sssdssssss", $productName, $productDescription, $productInclusion, $productPrice, $categoryId, $photo1, $photo2, $photo3, $photo4, $productStatus);
    // Execute the SQL statement
    $result = $stmt->execute();

    // Get the inserted product ID
    $productId = $conn->insert_id;

    // Prepare the SQL statement for inserting the product variations
    $stmt_variation = $conn->prepare("INSERT INTO productvariations (ProductID, Price, VariationName) VALUES (?, ?, ?)");

    // Insert the product variations
    for ($i = 0; $i < count($variationNames); $i++) {
        $stmt_variation->bind_param("ids", $productId, $variationPrices[$i], $variationNames[$i]);
        $stmt_variation->execute();
    }

    // Close the database connections
    $stmt_category->close();
    $stmt->close();
    $stmt_variation->close();
    $conn->close();

    // Notice message
    $notice = "Product added successfully.";

    // Redirect to the product management page
    // exit;
}

// Include the HTML code here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f3f4f6;
        }
        form {
            background-color: #fff;
            max-width: 500px;
            width: 90%;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        label, input, textarea, select, button {
            display: block;
            width: calc(100% - 20px);
            margin-bottom: 15px;
            font-size: 16px;
            padding: 8px;
            border-radius: 4px;
            box-sizing: border-box;
        }
        label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        input, textarea, select {
            border: 1px solid #ccc;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        select {
            padding: 8px;
        }
        #variations div {
            margin-bottom: 10px;
        }
        button[type="submit"], button[type="button"] {
            background-color: #333;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        button[type="submit"]:hover, button[type="button"]:hover {
            background-color: #555;
        }
        .variation-group {
            display: flex;
            align-items: center;
        }
        .variation-group input[type="text"], 
        .variation-group input[type="number"] {
            flex: 1;
            margin-right: 5px;
            padding: 8px;
            box-sizing: border-box;
        }
        .variation-group button {
            flex: 0 0 auto;
            margin-left: 5px;
            width: 100px;
            background-color: #333;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .variation-group button:hover {
            background-color: #555;
        }
        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form action="add_product.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to add this product?');">
        <h2>Add New Product</h2>
        <?php if (!empty($notice)) echo '<p class="success-message">' . $notice . '</p>'; ?>
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" placeholder="Enter Product Name" required>

        <label for="productDescription">Product Description:</label>
        <textarea id="productDescription" name="productDescription" rows="4" placeholder="Enter Product Description" required></textarea>

        <label for="productInclusion">Product Inclusion:</label>
        <textarea id="productInclusion" name="productInclusion" rows="4" placeholder="Enter Product Inclusion" required></textarea>

        <label for="productPrice">Product Price:</label>
        <input type="number" id="productPrice" name="productPrice" min="0" step="0.01" placeholder="Enter Product Price" required>

        <label>Product Category:</label>
        <select id="productCategory" name="productCategory" required>
            <option value="">Select Category</option>
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

        <label for="productImage">Product Image 1:</label>
        <input type="file" id="productImage" name="productImage" required>

        <label for="productImage2">Product Image 2:</label>
        <input type="file" id="productImage2" name="productImage2" required>

        <label for="productImage3">Product Image 3:</label>
        <input type="file" id="productImage3" name="productImage3" required>

        <label for="productImage4">Product Image 4:</label>
        <input type="file" id="productImage4" name="productImage4" required>

        <label for="productStatus">Product Status:</label>
        <select id="productStatus" name="productStatus" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>

        <label>Variations:</label>
        <div id="variations">
            <div class="variation-group">
                <input type="text" name="variationName[]" placeholder="Variation Name" required>
                <input type="number" name="variationPrice[]" placeholder="Price" min="0" step="0.01" required>
                <button type="button" onclick="removeVariation(this)">Remove</button>
            </div>
        </div>
        <button type="button" onclick="addVariation()">Add Variation</button>

        <button type="submit">Submit</button>

        <!-- Display success message if present -->
        <?php if (isset($success_message)): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>
    </form>

    <script>
        function addVariation() {
            const variationsDiv = document.getElementById('variations');
            const newVariation = document.createElement('div');
            newVariation.classList.add('variation-group');
            newVariation.innerHTML = `
                <input type="text" name="variationName[]" placeholder="Variation Name" required>
                <input type="number" name="variationPrice[]" placeholder="Price" min="0" step="0.01" required>
                <button type="button" onclick="removeVariation(this)">Remove</button>
            `;
            variationsDiv.appendChild(newVariation);
        }

        function removeVariation(button) {
            button.parentNode.remove();
        }
    </script>
</body>
</html>
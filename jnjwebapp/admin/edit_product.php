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

// Fetch product details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE ProductID = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Update Product Functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'] ?? '';
    $productDescription = $_POST['productDescription'] ?? '';
    $productInclusion = $_POST['productInclusion'] ?? '';
    $productPrice = $_POST['productPrice'] ?? 0;
    $productCategory = $_POST['productCategory'] ?? '';
    $productStatus = $_POST['productStatus'] ?? '';

    // Get the product variations from the form
    $variationNames = $_POST['variationName'] ?? [];
    $variationPrices = $_POST['variationPrice'] ?? [];

    // Validate the product details
    if (empty($productName) || empty($productDescription) || empty($productInclusion) || empty($productPrice) || empty($productCategory) || empty($productStatus)) {
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
        $photo1 = $row['PhotoMain'];
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
        $photo2 = $row['Photo2'];
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
        $photo3 = $row['Photo3'];
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
        $photo4 = $row['Photo4'];
    }

    // Prepare the SQL statement for updating the product
    $stmt = $conn->prepare("UPDATE products SET Name=?, description_text=?, inclusion=?, productprice=?, CategoryID=?, PhotoMain=?, Photo2=?, Photo3=?, Photo4=?, DateAdded=NOW(), ProductStatus=? WHERE ProductID=?");
    $stmt->bind_param("sssdssssssi", $productName, $productDescription, $productInclusion, $productPrice, $categoryId, $photo1, $photo2, $photo3, $photo4, $productStatus, $id);

    // Execute the SQL statement
    $stmt->execute();

    // Prepare the SQL statement for deleting existing product variations
    $stmt_delete_variations = $conn->prepare("DELETE FROM productvariations WHERE ProductID = ?");
    $stmt_delete_variations->bind_param("i", $id);

    // Delete existing product variations
    $stmt_delete_variations->execute();

    // Prepare the SQL statement for inserting the product variations
    $stmt_variation = $conn->prepare("INSERT INTO productvariations (ProductID, Price, VariationName) VALUES (?, ?, ?)");

    // Insert the product variations
    for ($i = 0; $i < count($variationNames); $i++) {
        $stmt_variation->bind_param("ids", $id, $variationPrices[$i], $variationNames[$i]);
        $stmt_variation->execute();
    }

    // Close the prepared statement
    $stmt_category->close();
    $stmt->close();
    $stmt_variation->close();
    $stmt_delete_variations->close();

    // Redirect to the product management page
    header("Location: product_management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <h2>Edit Product</h2>
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" placeholder="Enter Product Name" value="<?php echo $row['Name']; ?>" required>

        <label for="productDescription">Product Description:</label>
        <textarea id="productDescription" name="productDescription" rows="4" placeholder="Enter Product Description" required><?php echo $row['description_text']; ?></textarea>

        <label for="productInclusion">Product Inclusion:</label>
        <textarea id="productInclusion" name="productInclusion" rows="4" placeholder="Enter Product Inclusion" required><?php echo $row['inclusion']; ?></textarea>

        <label for="productPrice">Product Price:</label>
        <input type="number" id="productPrice" name="productPrice" min="0" step="0.01" placeholder="Enter Product Price" value="<?php echo $row['productprice']; ?>" required>

        <label>Product Category:</label>
        <select id="productCategory" name="productCategory" required>
            <option value="">Select Category</option>
            <?php
            // Include your database connection here
            $sql = "SELECT * FROM categories";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row_category = $result->fetch_assoc()) {
                    $selected = ($row_category['CategoryID'] == $row['CategoryID']) ? 'selected' : '';
                    echo '<option value="' . $row_category['CategoryID'] . '" ' . $selected . '>' . $row_category['CategoryName'] . '</option>';
                }
            } else {
                echo '<option value="">No categories available</option>';
            }
            ?>
        </select>

        <label for="productImage">Product Image 1:</label>
        <input type="file" id="productImage" name="productImage">
        <img src="../images/<?php echo $row['PhotoMain']; ?>" alt="Product Image 1" style="max-width: 150px;">

        <label for="productImage2">Product Image 2:</label>
        <input type="file" id="productImage2" name="productImage2">
        <img src="../images/<?php echo $row['Photo2']; ?>" alt="Product Image 2" style="max-width: 150px;">

        <label for="productImage3">Product Image 3:</label>
        <input type="file" id="productImage3" name="productImage3">
        <img src="../images/<?php echo $row['Photo3']; ?>" alt="Product Image 3" style="max-width: 150px;">

        <label for="productImage4">Product Image 4:</label>
        <input type="file" id="productImage4" name="productImage4">
        <img src="../images/<?php echo $row['Photo4']; ?>" alt="Product Image 4" style="max-width: 150px;">

        <label for="productStatus">Product Status:</label>
        <select id="productStatus" name="productStatus" required>
            <option value="Active" <?php echo ($row['ProductStatus'] == 'Active') ? 'selected' : ''; ?>>Active</option>
            <option value="Inactive" <?php echo ($row['ProductStatus'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
        </select>

        <label>Variations:</label>
        <div id="variations">
            <?php
            $sql_variations = "SELECT * FROM productvariations WHERE ProductID = $id";
            $result_variations = $conn->query($sql_variations);

            if ($result_variations->num_rows > 0) {
                while ($row_variation = $result_variations->fetch_assoc()) {
                    echo '<div class="variation-group">';
                    echo '<input type="text" name="variationName[]" value="' . $row_variation['VariationName'] . '" placeholder="Enter Variation Name">';
                    echo '<input type="number" name="variationPrice[]" value="' . $row_variation['Price'] . '" step="0.01" min="0" placeholder="Enter Variation Price">';
                    echo '<button type="button" onclick="removeVariation(this)">Remove</button>';
                    echo '</div>';
                }
            } else {
                echo '<div class="variation-group">';
                echo '<input type="text" name="variationName[]" placeholder="Enter Variation Name">';
                echo '<input type="number" name="variationPrice[]" step="0.01" min="0" placeholder="Enter Variation Price">';
                echo '<button type="button" onclick="removeVariation(this)">Remove</button>';
                echo '</div>';
            }
            ?>
        </div>
        <button type="button" onclick="addVariation()">Add Variation</button>

        <button type="submit">Update Product</button>
    </form>

    <script>
        function addVariation() {
            var variationGroup = document.createElement('div');
            variationGroup.className = 'variation-group';

            var variationName = document.createElement('input');
            variationName.type = 'text';
            variationName.name = 'variationName[]';
            variationName.placeholder = 'Enter Variation Name';

            var variationPrice = document.createElement('input');
            variationPrice.type = 'number';
            variationPrice.name = 'variationPrice[]';
            variationPrice.step = '0.01';
            variationPrice.min = '0';
            variationPrice.placeholder = 'Enter Variation Price';

            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.textContent = 'Remove';
            removeButton.onclick = function() {
                removeVariation(removeButton);
            };

            variationGroup.appendChild(variationName);
            variationGroup.appendChild(variationPrice);
            variationGroup.appendChild(removeButton);

            document.getElementById('variations').appendChild(variationGroup);
        }

        function removeVariation(button) {
            button.parentNode.parentNode.removeChild(button.parentNode);
        }
    </script>
</body>
</html>
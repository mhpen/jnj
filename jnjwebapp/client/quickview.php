<?php
session_start();

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

// Retrieve product details from the database based on product ID
$product_id = isset($_GET['ProductID']) ? $_GET['ProductID'] : null;
$sql = "SELECT * FROM Products WHERE ProductID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the product exists
if ($result->num_rows > 0) {
    // Fetch product details
    $product = $result->fetch_assoc();

    // Check if the product is personalizable
    $personalizable = $product['personalizable'];

    // Set a flag to determine whether to display the modal
    $displayModal = $personalizable == 1 ? true : false;
} else {
    // Product not found, handle error or redirect to error page
    echo "Product not found.";
    exit();
}

// Retrieve available variations for the product from the database
$sql_variation = "SELECT * FROM ProductVariations WHERE ProductID = ?";
$stmt_variation = $conn->prepare($sql_variation);
$stmt_variation->bind_param("i", $product_id);
$stmt_variation->execute();
$result_variation = $stmt_variation->get_result();

// Store available variations in an array
$variations = array();
while ($row_variation = $result_variation->fetch_assoc()) {
    $variations[] = $row_variation;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['Name']; ?> - Product Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Product details section -->
        <div class="row">
            <div class="col-md-6">
                <!-- Product image -->
                <img src="../images/<?php echo $product['PhotoMain']; ?>" alt="<?php echo $product['Name']; ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <!-- Product name -->
                <h2><?php echo $product['Name']; ?></h2>
                <!-- Product description -->
                <p><?php echo $product['description_text']; ?></p>
                <!-- Product price -->
                <p>Price: $      <span id="productPrice"><?php echo $variations[0]['Price']; ?></span>
                </p>
                <!-- Product variations -->
                <p>Select Variation:</p>
                <div class="form-group">
                    <select class="form-control" id="variationSelect">
                        <?php foreach ($variations as $variation): ?>
                            <option value="<?php echo $variation['ProductVarID']; ?>"><?php echo $variation['VariationName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Product quantity -->
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" value="1" min="1">
                </div>
                <!-- Total price -->
                <p>Total: $
                <input type="hidden" id="totalPriceInput" name="totalPrice" value="">
                    <span id="totalPrice"><?php echo $variations[0]['Price']; ?></span>
                </p>
                <!-- Add to cart button -->
                <button class="btn btn-primary" id="addToCartBtn">Add to Cart</button>
            </div>
        </div>
    </div>

    <!-- Personalization Modal -->
    <?php if ($displayModal): ?>
        <div class="modal fade" id="personalizationModal" tabindex="-1" role="dialog" aria-labelledby="personalizationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="personalizationModalLabel">Personalization Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Personalization form -->
                        <form id="personalizationForm">
                            <div class="form-group">
                                <label for="inputName">Name:</label>
                                <input type="text" class="form-control" id="inputName" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="inputFont">Font:</label>
                                <input type="text" class="form-control" id="inputFont" name="font" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to add this item to your cart?
                </div>
                <div class="modal-footer">
                    <!-- Cancel button -->
                    <button type="button" class="btn btn-secondary" id="cancelAddToCart">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmAddToCart">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden input to store personalization ID -->
    <input type="hidden" id="personalizationID" name="personalizationID">

    <!-- JavaScript -->
    <script>

        
        // JavaScript code here
document.addEventListener('DOMContentLoaded', function() {
    // Function to update price and total
    function updatePriceAndTotal() {
        // Get selected variation ID and quantity
        var variationID = document.getElementById('variationSelect').value;
        var quantity = document.getElementById('quantity').value;

        // Fetch variation details via AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'getVariationDetails.php?variation_id=' + variationID, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Parse the JSON response
                var variationDetails = JSON.parse(xhr.responseText);

                // Update the price display
                var price = parseFloat(variationDetails.Price);
                document.getElementById('productPrice').innerText = '$' + price.toFixed(2);

                // Calculate and update the total
                var total = price * quantity;
                document.getElementById('totalPrice').innerText = '$' + total.toFixed(2);
            }
        };
        xhr.send();
    }

    // Update price and total when variation is selected
    document.getElementById('variationSelect').addEventListener('change', updatePriceAndTotal);

    // Update price and total when quantity changes
    document.getElementById('quantity').addEventListener('input', updatePriceAndTotal);

    // Add to cart button click event
 // Add to cart button click event
document.getElementById('addToCartBtn').addEventListener('click', function(event) {
    // Prevent the default form submission
    event.preventDefault();
    
    // Check if the product is personalizable
    if(<?php echo $personalizable; ?> === 1) {
        // Show the personalization modal
        $('#personalizationModal').modal('show');
    } else {
        // Add the product to cart directly
        addToCart(null); // Passing null as personalizationID since not personalizable
    }
});
    // Personalization form submission event
    document.getElementById('personalizationForm').addEventListener('submit', function(event) {
        event.preventDefault();
        // Get personalization details
        var name = document.getElementById('inputName').value;
        var font = document.getElementById('inputFont').value;
        // Perform further actions with the personalization details, such as sending them to the server or processing them locally
        // For demonstration purposes, let's just log them to the console
        console.log('Name:', name);
        console.log('Font:', font);

        // AJAX request to add personalization data
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'addPersonalization.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Response handling
                var personalizationID = xhr.responseText;
                console.log('Personalization ID:', personalizationID);

                // Close the modal
                $('#personalizationModal').modal('hide');

                // Show confirmation modal
                $('#confirmationModal').modal('show');
                // Store the personalization ID in a hidden input field
                document.getElementById('personalizationID').value = personalizationID;
            }
        };
        // Send data
        xhr.send('name=' + name + '&font=' + font);
    });

    // Confirm add to cart button click event
    document.getElementById('confirmAddToCart').addEventListener('click', function() {
        var personalizationID = document.getElementById('personalizationID').value;
        // Call function to add item to cart with personalization ID
        addToCart(personalizationID);
    });

    // Cancel add to cart button click event
    document.getElementById('cancelAddToCart').addEventListener('click', function() {
        var personalizationID = document.getElementById('personalizationID').value;
        // Call function to remove personalization
        removePersonalization(personalizationID);
    });

    // Function to remove personalization
    function removePersonalization(personalizationID) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'removePersonalization.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Response handling
                console.log(xhr.responseText);
                // Reload the page to reset the personalization form
                location.reload();
            }
        };
        // Send personalization ID
        xhr.send('personalization_id=' + personalizationID);
    }

    // Function to add item to the cart
    function addToCart(personalizationID) {
        // Get selected variation ID and quantity
        var variationID = document.getElementById('variationSelect').value;
        var quantity = document.getElementById('quantity').value;
        // Get product ID from the URL
        var productID = <?php echo $product_id; ?>;
        // AJAX request to add item to cart
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'addToCart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Response handling
                console.log(xhr.responseText);
                alert(xhr.responseText); // Show response message
            }
        };
        // Send data including personalization ID
        xhr.send('product_id=' + productID + '&variation_id=' + variationID + '&quantity=' + quantity + '&personalization_id=' + personalizationID);
    }
    

    // Initial update of price and total
    updatePriceAndTotal();

    
});
</script>

<!-- Bootstrap JS (jQuery required) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
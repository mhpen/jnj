<?php
session_start();

// Define database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

$cartID = $_SESSION['cart_id'] ?? null;

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the user ID from the session
if (!isset($_SESSION['user_id'])) {
    // Handle case where user is not logged in
    // Redirect to login page or display an error message
    echo "Error: User not logged in.";
    exit();
}

$userID = $_SESSION['user_id'];

// Query to retrieve cart items with product details for the logged-in user
$sql = "SELECT cartItem.*, Products.Name AS product_name, Products.PhotoMain AS product_image, Products.description_text AS product_details, Products.productprice AS product_price, Personalization.PersonalizedName, Personalization.Font 
        FROM cartItem 
        INNER JOIN Products ON cartItem.productID = Products.ProductID 
        LEFT JOIN Personalization ON cartItem.PersonalizationID = Personalization.PersonalizationID 
        WHERE cartItem.cartID = ?;";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

$stmt->bind_param("i", $cartID);
$stmt->execute();

if ($stmt->error) {
    die('Error executing statement: ' . $stmt->error);
}

$result = $stmt->get_result();

if (!$result) {
    die('Error retrieving result set: ' . $conn->error);
}

// Proceed with processing the result set
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Cart</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* CSS styles */
    body {
      background-color: #ffffff;
      font-family: Arial, sans-serif;
    }
    .container {
      margin-top: 50px;
    }
    .product-item {
      margin-bottom: 20px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 20px;
      margin-top: 70px;
    }
    .product-image {
      width: 100px;
      height: auto;
      margin-right: 20px;
    }
    .product-name {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 5px;
    }
    .product-details {
      color: #666666;
      margin-bottom: 10px;
    }
    .customization-details {
      margin-bottom: 10px;
    }
    .edit-order-btn {
      margin-right: 10px;
    }
    .remove-btn {
      color: rgb(241, 236, 236);
      border: 1px solid red;
    }
    .total {
      font-size: 24px;
      font-weight: bold;
      text-align: right;
      margin-bottom: 20px;
      margin-top: 20px;
      margin-right: 50px;
    }
    .center-input {
      display: flex;
      align-items: center;
    }
    @media (max-width: 768px) {
      .product-item .col-md-2 {
        flex: 0 0 auto;
        max-width: none;
      }
      .continue-shopping-btn,
      .buy-now-btn {
        font-size: 12px;
        padding: 5px 10px;
      }
    }
    .continue-shopping-btn,
    .buy-now-btn {
      width: 100%;
    }
    /* Custom styles for the added text */
    .cart-title {
      font-family: Poppins;
      font-size: 40px;
      font-weight: 300;
      line-height: 60px;
      text-align: center;
      color: #353434;
      height: 29px;
      margin-bottom: 20px; /* Add margin to separate from the buttons */
    }
    .product-item .row {
      align-items: center; /* Align items vertically */
    }
    .total {
      margin-top: 40px; /* Increase top margin for separation */
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-center cart-title">Your Cart</h1>
    <?php
    // Check if there are cart items
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            ?>
            <!-- Product Item -->
            <div class="product-item"  data-cart-id="<?php echo $row['cartItemID']; ?>">
            <div class="row align-items-center">
    <div class="col-md-1 col-2">
    <input type="checkbox" class="form-check-input cart-item-checkbox" onchange="updateSelectedItems(this)" onclick="handleCheckboxClick(this)" <?php echo $row['isSelected'] == 1 ? 'checked' : ''; ?>>
    </div>
              <div class="row align-items-center">
                <div class="col-md-1 col-2">
                  <img src="../images/<?php echo $row['product_image']; ?>" alt="Product Image" class="product-image">
                </div>
                <div class="col-md-4 col-6">
                  <div class="product-name"><?php echo $row['product_name']; ?></div>
                  <div class="product-details"><?php echo $row['product_details']; ?></div>
                  <!-- Add customization details here if needed -->
                  <?php if ($row['PersonalizedName'] && $row['Font']): ?>
                  <div class="customization-details">
                    Personalization: <?php echo $row['PersonalizedName']; ?> (Font: <?php echo $row['Font']; ?>)
                  </div>
                  <?php endif; ?>
                </div>
                <div class="col-md-2 col-4 center-input">
                  <!-- Modify input to include oninput event listener -->
                  <input type="number" class="form-control quantity-input" value="<?php echo $row['quantity']; ?>" min="1" onchange="updateTotalPrice(this, <?php echo $row['cartItemID']; ?>)" oninput="updateTotalPrice(this, <?php echo $row['cartItemID']; ?>)">
                </div>
                <div class="col-md-2 col-4" data-price="<?php echo $row['product_price']; ?>">
                  <div class="product-price"><?php echo $row['product_price'] * $row['quantity']; ?> PHP</div>
                </div>
                
                <div class="col-md-1 col-2 mt-3 text-center">
                  <!-- Add onclick event to trigger modal -->
                  <button class="btn btn-sm btn-info edit-order-btn" onclick="openEditPersonalizationModal(<?php echo $row['cartItemID']; ?>, '<?php echo $row['PersonalizedName']; ?>', '<?php echo $row['Font']; ?>')">Edit</button>
                  <button class="btn btn-sm btn-danger remove-btn" onclick="confirmRemove(<?php echo $row['cartItemID']; ?>)">Remove</button>
                </div>
              </div>
            </div>
            <!-- End of Product Item -->
            <?php
        }
    } else {
        // If the cart is empty, display a message
        echo "<p>Your cart is empty.</p>";
    }
    ?>
    <!-- End of PHP Cart Item Loop -->

    <!-- Subtotal -->
    <div class="total text-right">SUBTOTAL: <span id="subtotal">0 PHP</span></div>

    <!-- Buttons -->
    <div class="row justify-content-end mt-3">
      <div class="col-md-3 col-6">
        <button class="btn btn-primary continue-shopping-btn">Continue Shopping</button>
      </div>
      <div class="col-md-3 col-6">
        <!-- Wrap the button inside a form element -->
        <form action="checkoutForm.php" method="post">
          <button type="submit" class="btn btn-success buy-now-btn">Buy Now</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal for editing personalization -->
  <div class="modal fade" id="editPersonalizationModal" tabindex="-1" role="dialog" aria-labelledby="editPersonalizationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPersonalizationModalLabel">Edit Personalization</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form to edit personalization details -->
          <form id="editPersonalizationForm">
            <!-- Input fields for personalization details -->
            <div class="form-group">
              <label for="personalizationName">Name:</label>
              <input type="text" class="form-control" id="personalizationName" name="personalizationName" required>
            </div>
            <div class="form-group">
              <label for="personalizationFont">Font:</label>
              <select class="form-control" id="personalizationFont" name="personalizationFont" required>
                <!-- Options for font selection -->
                <option value="Arial">Arial</option>
                <option value="Times New Roman">Times New Roman</option>
                <!-- Add more font options as needed -->
              </select>
            </div>
            <!-- Hidden input field to store the cart ID -->
            <input type="hidden" id="cartIdInput" name="cartId">
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- JavaScript -->
<script>
function updateSelectedItemStatus(cartItemId, isSelected) {
  // Send an AJAX request to update isSelected in the database
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "updateSelectedItemStatus.php", true); // Specify the correct URL of your PHP script
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Database update successful
        console.log("isSelected updated successfully");
      } else {
        // Error occurred while updating database
        console.error("Error updating isSelected:", xhr.responseText);
      }
    }
  };
  xhr.send("cartItemId=" + cartItemId + "&isSelected=" + isSelected);
}

// Function to handle checkbox click event
function handleCheckboxClick(checkbox) {
  var cartItemId = checkbox.closest('.product-item').getAttribute('data-cart-id');
  var isSelected = checkbox.checked ? 1 : 0; // Convert to 1 if checked, else 0
  updateSelectedItemStatus(cartItemId, isSelected);
}
  // Function to confirm item removal
  function confirmRemove(cartItemId) {
    if (confirm("Are you sure you want to remove this item from your cart?")) {
      removeFromCart(cartItemId);
    }
  }

  // Function to remove item from cart
  function removeFromCart(cartId) {
    // Send an AJAX request to the server to remove the item
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "removeFromCart.php", true); // Specify the correct URL of your PHP script
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4) {
        if (xhr.status == 200) {
          // Remove the item from the cart dynamically
          var cartItem = document.querySelector('[data-cart-id="' + cartId + '"]');
          if (cartItem) {
            cartItem.parentNode.removeChild(cartItem);
            updateSubtotal(); // Update subtotal after removing item
          }
        } else {
          alert("Error: Unable to remove item");
        }
      }
    };
    xhr.send("cart_id=" + cartId);
  }
  function updateSubtotal() {
      // Get all select checkboxes
      var checkboxes = document.querySelectorAll('.cart-item-checkbox');
      var quantityInputs = document.querySelectorAll('.quantity-input');
      var prices = document.querySelectorAll('.product-price');
      var total = 0;

      // Loop through each checkbox
      for (var i = 0; i < checkboxes.length; i++) {
        // Check if the checkbox is checked
        if (checkboxes[i].checked) {
          var quantity = parseInt(quantityInputs[i].value);
          var price = parseFloat(prices[i].parentNode.getAttribute('data-price')); // Getting price from the data attribute
          var totalPrice = quantity * price;
          prices[i].innerText = totalPrice.toLocaleString('en-PH') + ' PHP'; // Update the total price text
          total += totalPrice; // Add to the total
        }
      }

      // Update the subtotal displayed on the page
      document.getElementById('subtotal').innerText = total.toLocaleString('en-PH') + ' PHP';
    }

    // Function to update subtotal when a checkbox is checked or unchecked
    function updateSelectedItems() {
      updateSubtotal();
    }

  // Update the subtotal displayed on the page

  // Function to update total price when quantity changes
  function updateTotalPrice(input, cartId) {
    var parentDiv = input.closest('.product-item'); // Get the parent product-item div
    var priceElement = parentDiv.querySelector('.product-price'); // Get the price element
    var price = parseFloat(priceElement.parentNode.getAttribute('data-price')); // Get the price from data attribute
    var quantity = parseInt(input.value); // Get the new quantity
    var totalPrice = price * quantity; // Calculate the new total price
    priceElement.innerText = totalPrice.toLocaleString('en-PH') + ' PHP'; // Update the price element
    
    // Send an AJAX request to update quantity and total in the database
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "updateCart.php", true); // Specify the correct URL of your PHP script
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("cart_id=" + cartId + "&quantity=" + quantity + "&total=" + totalPrice);
    
    updateSubtotal(); // Update the subtotal
  }

  // Function to open edit personalization modal
  function openEditPersonalizationModal(cartId, name, font) {
    // Fill in the modal with current personalization details
    document.getElementById('personalizationName').value = name;
    document.getElementById('personalizationFont').value = font;
    document.getElementById('cartIdInput').value = cartId;
    // Open the modal
    $('#editPersonalizationModal').modal('show');
  }

  // Function to handle form submission in the modal
  document.getElementById('editPersonalizationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    var formData = new FormData(this); // Get form data
    var xhr = new XMLHttpRequest(); // Create new XMLHttpRequest object
    xhr.open('POST', 'updatePersonalization.php', true); // Specify the correct URL of your PHP script
    xhr.onload = function() {
      if (xhr.status === 200) {
        // Personalization details updated successfully
        // You may want to update the UI or close the modal here
        $('#editPersonalizationModal').modal('hide'); // Hide the modal
      } else {
        // Error occurred while updating personalization details
        console.error('Error updating personalization details:', xhr.responseText);
        // You may want to display an error message to the user here
      }
    };
    xhr.send(formData); // Send form data to the server
  });

 function saveOrderAutomatically() {
  // Send an AJAX request to save the order
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "saveOrder.php", true); // Specify the correct URL of your PHP script
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
  // Get the selected cart items
  var selectedCartItems = document.querySelectorAll('.product-item:checked');
  var cartItemIDs = Array.from(selectedCartItems).map(item => item.getAttribute('data-cart-id'));

  // Convert shippingFee and subtotal to integers
  var shippingFee = parseInt(document.getElementById('shippingFee').innerText.replace(' PHP', '').replace(',', ''));
  var subtotal = parseInt(document.getElementById('subtotal').innerText.replace(' PHP', '').replace(',', ''));

  // Create a FormData object to send cart item IDs and other data to the server
  var formData = new FormData();
  cartItemIDs.forEach(id => formData.append('cartItemIDs[]', id));
  formData.append('shippingFee', shippingFee);
  formData.append('subtotal', subtotal);

  // Send the cart item IDs and other data along with the AJAX request
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Order saved successfully
        console.log("Order saved automatically");
      } else {
        // Error occurred while saving order
        console.error("Error saving order:", xhr.responseText);
        // You may want to display an error message to the user here
      }
    }
  };
  xhr.send(formData); // Send the AJAX request with cart item IDs and other data
}

// Call saveOrderAutomatically function after the page loads to automatically save the order data
window.addEventListener('load', function() {
  saveOrderAutomatically();
});
  // Call updateSubtotal function after the page loads to automatically show the total
  window.addEventListener('load', function() {
    updateSubtotal();
  });
</script>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JavaScript -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

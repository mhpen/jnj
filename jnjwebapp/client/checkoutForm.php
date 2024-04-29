<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional Styles for Fetched Checkout Items */
        /* Hide the scrollbar for both sections */
        .form-section::-webkit-scrollbar,
        .checkout-items-section::-webkit-scrollbar {
            display: none;
        }
        .checkout-item {
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        .checkout-item:last-child {
            border-bottom: none; /* Remove bottom border from the last item */
        }
        .checkout-item img {
            width: 80px; /* Adjust image size */
            height: 80px;
            object-fit: contain; /* Keep aspect ratio */
            margin-right: 20px;
        }
        .checkout-item-details {
            flex: 1;
        }
        .checkout-item-details h4 {
            margin-bottom: 5px; /* Adjust margin */
            font-size: 16px; /* Reduce font size */
            color: #333; /* Change text color */
        }
        .checkout-item-details p {
            margin: 0; /* Reset margin */
            font-size: 14px;
            color: #666; /* Change text color */
        }
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        .checkout-container {
            max-width: 1200px;
            margin: 50px auto;
            display: flex;
            overflow: hidden; /* Hide overflow for the entire container */
        }
        .form-section {
            flex: 1;
            margin-right: 20px;
            overflow-y: auto; /* Allow vertical scrolling for the form section */
            padding-right: 15px; /* Add padding to adjust for scrollbar */
            position: sticky;
            top: 0;
            height: 100vh; /* Set height to viewport height */
        }
        .checkout-items-section {
            flex: 1;
            overflow-y: auto; /* Allow vertical scrolling for the checkout items section */
            padding-left: 15px; /* Add padding to adjust for scrollbar */
            height: 100vh; /* Set height to viewport height */
        }
        .fetch-checkout-info {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
        }
        /* Contact and Delivery Form Styles */
        .contact-form, .delivery-form {
            margin-bottom: 20px;
        }
        .contact-form input, .delivery-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        /* Shipping and Payment Method Styles */
        .shipping-method-dropdown, .payment-option-dropdown, .location-form {
            margin-bottom: 20px;
        }
        .sm-select, .pm-select, .location-select{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        /* Checkout Button Style */
        .checkout-btn-container {
            margin-top: 20px; /* Add margin-top to separate from the grand total */
            text-align: right; /* Align button to the right */
        }
        .checkout-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <!-- Form Section -->
        <div class="form-section" id="form-section">
            <form id="order-form">
                <div class="contact-form">
                    <h4>Contact</h4>
                    <input type="text" id="fname" name="FirstName" placeholder="Firstname" required>
                    <input type="text" id="lname" name="LastName" placeholder="Lastname" required>
                    <br>
                    <input type="email" id="email" name="EmailAddress" placeholder="Email (Optional)">
                    <input type="tel" id="phone" name="PhoneNum" placeholder="Phone Number" required>
                </div>
                <div class="delivery-form">
        <h4>Delivery</h4>
        <input type="text" id="house-no" name="AddressLine1" placeholder="Enter your house no." required>
        <input type="text" id="barangay" name="Barangay" placeholder="Barangay" required>
        <br>
        <input type="text" id="city" name="City" placeholder="City" required>
        <input type="text" id="province" name="Province" placeholder="Province" required> <!-- New input for province -->
        <input type="text" id="country" name="Country" placeholder="Country" required>
        <input type="text" id="zip-code" name="PostalCode" placeholder="Zip Code" required>
    </div>
                <!-- Location Selection -->
                <div class="location-form">
                    <h4>Location</h4>
                    <select class="location-select" id="location-select" name="Location" required> <!-- Added name attribute for location -->
                        <option value="luzon">Luzon</option>
                        <option value="visayas">Visayas</option>
                        <option value="mindanao">Mindanao</option>
                        <option value="metro-manila">Metro Manila</option>
                    </select>
                </div>
                <div class="shipping-method-dropdown">
                    <h4>Shipping Method</h4>
                    <select class="sm-select" id="sm-select" required>
                        <option value="Standard">Standard</option>
                        <option value="Expedited">Expedited</option>
                    </select>
                </div>
                <!-- Save and Edit Buttons -->
                <div>
                    <button type="button" class="btn btn-primary" id="save-btn">Save</button>
                    <button type="button" class="btn btn-secondary" id="edit-btn">Edit</button>
                </div>
            </form>
        </div>
        <!-- Checkout Items Section -->
        <div class="checkout-items-section" id="checkout-items-section">
            <div class="fetch-checkout-info">
                <!-- Fetched checkout information will be displayed here -->
            </div>
            <!-- Error Message Container -->
            <div id="error-message" style="color: red; margin-top: 10px;"></div>
            <!-- Checkout Button Container -->
            <div class="checkout-btn-container">
                <!-- Checkout Button -->
                <button class="checkout-btn btn btn-success" id="buy-now-btn">Buy Now</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

        
        // Function to fetch checkout information
        function fetchCheckoutInfo() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetchCheckoutData.php');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var checkoutItems = JSON.parse(xhr.responseText);
                    displayCheckoutInfo(checkoutItems);
                } else {
                    console.error('Error fetching checkout information:', xhr.status);
                }
            };
            xhr.send();
        }

        // Function to display fetched checkout information
        function displayCheckoutInfo(checkoutItems) {
            var fetchCheckoutInfoElement = $('.fetch-checkout-info');
            fetchCheckoutInfoElement.html('');
            var subtotal = 0; // Initialize subtotal variable
            checkoutItems.forEach(function(item) {
                var html = `
                    <div class="checkout-item">
                        <img src="../images/${item.product_image}" alt="${item.product_name}">
                        <div class="checkout-item-details">
                            <h4>${item.product_name}</h4>
                            <p>${item.product_details}</p>
                            <p>Quantity: ${item.quantity}</p> <!-- Display quantity -->
                            <p>Price: ${item.product_price}</p>
                        </div>
                    </div>
                `;
                fetchCheckoutInfoElement.append(html);
                subtotal += parseFloat(item.product_price) * parseInt(item.quantity); // Accumulate subtotal
            });
            // Display subtotal
            fetchCheckoutInfoElement.append(`<p class="subtotal-info">Subtotal: $${subtotal.toFixed(2)}</p>`);
            // Calculate and display grand total
            var { shippingFee, shippingMethod } = calculateShipping(); // Calculate shipping fee and get shipping method
            var grandTotal = subtotal + parseFloat(shippingFee);
            // Display shipping fee dynamically
            fetchCheckoutInfoElement.append(`<p class="shipping-fee-info">Shipping Fee (${shippingMethod}): $${shippingFee}</p>`);
            // Display grand total dynamically
            fetchCheckoutInfoElement.append(`<p class="grand-total-info">Grand Total: $${grandTotal.toFixed(2)}</p>`);

            // Save subtotal and grand total to database
            saveTotals(subtotal, grandTotal);
        }

        // Function to save subtotal and grand total to the database
        function saveTotals(subtotal, grandTotal) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'saveTotals.php');
            xhr.setRequestHeader('Content-Type', 'application/json');
            var data = {
                subtotal: subtotal,
                grandTotal: grandTotal
            };
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        console.log('Totals saved successfully.');
                    } else {
                        console.error('Error saving totals:', response.message);
                    }
                } else {
                    console.error('Error saving totals:', xhr.status);
                }
            };
            xhr.send(JSON.stringify(data));
        }

        // Call the fetchCheckoutInfo function when the DOM content is loaded
        $(document).ready(function() {
            fetchCheckoutInfo();
        });

        // Shipping rates for different regions in the Philippines
        const shippingRates = {
            luzon: {
                Standard: 85,
                Expedited: 120
            },
            visayas: {
                Standard: 100,
                Expedited: 140
            },
            mindanao: {
                Standard: 105,
                Expedited: 150
            },
            'metro-manila': {
                Standard: 95,
                Expedited: 130
            }
        };

        // Modify the calculateShipping function to return shipping fee and method
        function calculateShipping() {
            const address = $('#location-select').val();
            const shippingMethod = $('#sm-select').val();

            const shippingFee = shippingRates[address][shippingMethod].toFixed(2); // Shipping fee based on selected location and shipping method

            return { shippingFee, shippingMethod }; // Return shipping fee and method
        }

        // Modify the saveOrder function to include shipping fee calculation
        function saveOrder() {
            // Check if any required field is empty
            var requiredFields = $('#form-section input[required]');
            for (var i = 0; i < requiredFields.length; i++) {
                if (!requiredFields.eq(i).val()) {
                    alert('Please fill in all required fields.');
                    return; // Stop execution if a required field is empty
                }
            }

            // Collect form data
            var formData = new FormData($('#order-form')[0]);

            // Calculate shipping fee
            var { shippingFee, shippingMethod } = calculateShipping();
            formData.append('shipping-fee', shippingFee); // Append shipping fee to form data
            formData.append('shipping-method', shippingMethod); // Append shipping method to form data

            // Calculate grand total
            var subtotal = parseFloat($('.subtotal-info').text().split('$')[1]); // Get subtotal
            var grandTotal = subtotal + parseFloat(shippingFee);
            formData.append('grand-total', grandTotal); // Append grand total to form data

            // Send the form data to the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'saveOrder.php', true);

            // Set the responseType to json
            xhr.responseType = 'json';

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Handle successful form submission
                    if (xhr.response.success) {
                        alert(xhr.response.message);
                        // Reset the form
                        $('#order-form')[0].reset();
                        window.location.href = 'payment.php';
                    } else {
                        // Display error message
                        $('#error-message').text(xhr.response.message);
                    }
                } else {
                    // Handle error during form submission
                    console.error('Error during form submission:', xhr.status);
                    alert('Error saving order. Please try again later.');
                }
            };

            // Handle network errors
            xhr.onerror = function() {
                console.error('Network error occurred');
                alert('Network error occurred. Please try again later.');
            };

            // Send the request
            xhr.send(formData);
        }

        // Call the function when the Buy Now button is clicked
        $('#buy-now-btn').click(function() {
            saveOrder();
        });

        // Event listeners to dynamically update shipping fee and total
        $('#location-select, #sm-select').change(function() {
            var subtotal = parseFloat($('.subtotal-info').text().split('$')[1]); // Get subtotal
            updateShippingAndTotal(subtotal);
        });

        // Function to update shipping fee and total
        function updateShippingAndTotal(subtotal) {
            var { shippingFee, shippingMethod } = calculateShipping(); // Calculate shipping fee and get shipping method
            var grandTotal = subtotal + parseFloat(shippingFee);

            // Display shipping fee dynamically
            $('.shipping-fee-info').text(`Shipping Fee (${shippingMethod}): $${shippingFee}`);
            // Display grand total dynamically
            $('.grand-total-info').text(`Grand Total: $${grandTotal.toFixed(2)}`);

            // Update totals in database
            saveTotals(subtotal, grandTotal);
        }
        
    </script>
</body>
</html>

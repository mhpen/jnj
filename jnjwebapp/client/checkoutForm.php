<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        /* Additional Styles for Fetched Checkout Items */
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
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .checkout-left-col {
            flex: 1;
            margin-right: 20px;
        }

        .fetch-checkout-info {
            flex: 1;
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
        .shipping-method-dropdown, .payment-option-dropdown {
            margin-bottom: 20px;
        }

        .sm-select, .pm-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Checkout Item Styles */
        .checkout-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .checkout-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
        }

        .checkout-item-details h4 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .checkout-item-details p {
            margin-bottom: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="checkout-left-col">
            <div class="contact-form">
                <h4>Contact</h4>
                <input type="text" id="fname" name="fname" placeholder="Firstname">
                <input type="text" id="lname" name="lname" placeholder="Lastname">
                <br>
                <input type="text" id="email-mobile_number" name="email-mobile_number" placeholder="Email or mobile phone number">
            </div>

            <div class="delivery-form">
                <h4>Delivery</h4>
                <input type="text" id="house-no" name="house-no" placeholder="Enter your house no.">
                <input type="text" id="barangay" name="barangay" placeholder="Barangay">
                <br>
                <input type="text" id="city" name="city" placeholder="City">
                <input type="text" id="country" name="country" placeholder="Country">
                <input type="text" id="zip-code" name="zipcode" placeholder="Zip Code">
            </div>

            <div class="shipping-method-dropdown">
                <h4>Shipping Method</h4>
                <select class="sm-select">
                    <option value="victory-liner-cargo">Victory Liner Cargo</option>
                    <option value="j&t-express">J&T Express</option>
                </select>
            </div>

            <div class="payment-option-dropdown">
                <h4>Payment Method</h4>
                <select class="pm-select">
                    <option value="gcash">GCash</option>
                    <option value="pay-maya">Maya</option>
                </select>
            </div>
        </div>

        <div class="fetch-checkout-info">
        <!-- Fetched checkout information will be displayed here -->
    </div>
    
</body>

    <script>
        function fetchCheckoutInfo(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetchCheckoutData.php?id=' + id);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var checkoutItems = JSON.parse(xhr.responseText);
                    var fetchCheckoutInfoElement = document.querySelector('.fetch-checkout-info');
                    fetchCheckoutInfoElement.innerHTML = '';
                    checkoutItems.forEach(function(item) {
                        var html = `
                            <div class="checkout-item">
                                <img src="../images/${item.product_image}" alt="${item.product_name}">
                                <div class="checkout-item-details">
                                    <h4>${item.product_name}</h4>
                                    <p>${item.product_details}</p>
                                    <p>${item.product_price}</p>
                                    <p>${item.variationname}</p>
                                </div>
                            </div>
                        `;
                        fetchCheckoutInfoElement.innerHTML += html;
                    });
                } else {
                    console.error('Error fetching checkout information:', xhr.status);
                }
            };
            xhr.send();
        }

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        document.addEventListener('DOMContentLoaded', function() {
            var id = getParameterByName('id');
            fetchCheckoutInfo(id);
        });
    </script>
</html>
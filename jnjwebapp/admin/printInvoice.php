<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <!-- External CSS libraries -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="adminStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->

    <style>
     @media print {
        .invoice-container {
        border: none !important;
        box-shadow: none !important;
        margin-top: -2000mm; /* Adjust as needed */
    }
            /* Hide the sidebar when printing */
            #sidebar {
                display: none;
            }

            /* Remove watermark */
            body::before {
                content: none !important;
            }

            /* Adjust page margins */
            @page {
                margin: 0;
            }

            /* Hide edit button when printing */
            .invoice-header .btn-edit   {
              
            display: none !important;
    
            }

            /* Hide print button when printing */
            #printBtn {
                display: none;
            }
            
        }

        /* Custom CSS styles */
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-container {
            max-width: 800px; /* Limit width for better readability */
            margin: 0 auto; /* Center the invoice */
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow */
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-top: 60px;
        }

        .invoice-header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .invoice-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .invoice-total {
            display: flex;
            flex-direction: column; /* Align items top to down */
            align-items: flex-end; /* Align items to the right */
            margin-top: 20px;
        }

        .invoice-total p {
            margin: 5px 0;
        }

        .main {
            padding: 30px;
        }

        .main .btn {
            margin-right: 10px;
        }

        /* Additional styling for the header section */
        .header-section {
            padding-left: 50px;
            display: flex;
            background-color: 3F2403;
            color: #3F2403;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-divider {
    border-bottom: 1px solid #ddd; /* Add a border line */
    margin-bottom: 20px; /* Adjust margin as needed */
}
        .header-section .logo h1 {
            font-family: 'Playfair Display', serif;
            font-size: 100px;
            margin-right: 50px;
        }

        .header-section .contact-info p {
            margin: 5px 0;
            font-size: 16px;
        }

        

        /* Style for Facebook icon */
        .fa-facebook {
            margin-right: 5px;
            color: #3b5998;
        }

        /* Style for owner contact icon */
        .fa-phone-alt {
            margin-right: 5px;
            color: #333;
        }
       

    </style>

</head>

<body>
<div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">J&J</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-protection"></i>
                        <span>Product Management </span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Product</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Inventory</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                        <i class="lni lni-layout"></i>
                        <span>Orders and Payment</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse"
                                data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                                Two Links
                            </a>
                            <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">Link 1</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">Link 2</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Chats</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Setting</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <!-- Main content -->
        <div class="main p-3 bg-light"> 
            <div class="btn-group mt-3 d-flex" role="group" aria-label="Order Actions">
  
            <button type="button" class="btn btn-outline-primary">
    <a href="orderView.php?orderID=<?php echo $_GET['orderID']; ?>">
        <i class="lni lni-list fs-4 d-block mb-2"></i>
        <span>Order Details</span>
    </a>
</button>
    <button type="button" class="btn btn-outline-primary active">
    <i class="lni lni-printer fs-4 d-block mb-2"></i>
    <span>Print Invoice</span>
</button>
</div>
               
            <div class="invoice-header">
                
            <h2 style="font-size: 30px;"></h2>
                    <div>
                        <button class="btn btn-primary btn-edit">Edit</button>
                        <button class="btn btn-primary" id="printBtn">Print</button>
                    </div>
                </div>        
            <div class="invoice-container">
                <!-- Header section -->
                <div class="header-section">
                    <div class="logo"><h1>J&J</h1> </div>
                    <div class="contact-info">
                    <p style="font-size: 50px; letter-spacing: 2px;">J&J Gifts Galore</p>
                    <p><i class="fab fa-facebook"></i>Owner: Jenny Lyn Quintos Navarro <i class="fas fa-phone-alt"></i>0995-355-4587</p>
                    </div>
                   
                </div>
                <div class="header-divider"></div>

                <!-- Invoice header -->
                
                <!-- Fetch Receiver-->
                <div class="sold-to-info">
                    <p><strong>Receiver information</strong></p>
                    <p>Name of Receiver: John Doe</p>
                    <p>Address: 123 Main Street, Cityville</p>
                    <p>Date: May 5, 2024</p>
                    <p>Contact Number: +1234567890</p>
                </div>
                <!-- Fetch Order Info -->
                <!-- Fetch Order Info -->
                <table class="invoice-table">
    <thead>
        <tr>
            <th>Quantity</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody id="orderInfo">
        <!-- Dynamic content from database will be displayed here -->
    </tbody>
</table>
<!-- Fetch Total -->
<div class="invoice-total">
    <p><strong>Subtotal:</strong> $0</p>
    <p id="shippingFee"><strong>Shipping Fee:</strong> $0</p>
    <p id="grandTotal"><strong>Grand Total:</strong> $0</p>
</div>
            </div>
        </div>
    </div>
<!-- External JS libraries -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
<!-- Custom script -->
<script>
    // Print button functionality
    document.getElementById("printBtn").addEventListener("click", function () {
        window.print();
    });

    // Function to remove buttons before printing
    function removeButtonsBeforePrint() {
        // Select the button group element
        var btnGroup = document.querySelector('.btn-group');
        // Remove the button group if found
        if (btnGroup) {
            btnGroup.remove();
        }
    }

    // Add an event listener for before printing
    window.addEventListener('beforeprint', function () {
        // Call the function to remove buttons before printing
        removeButtonsBeforePrint();
    });

    $(document).ready(function () {
    // Function to get URL parameters
    function getUrlParameter(name) {
        name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Fetch receiver information using AJAX
    $.ajax({
        url: 'fetch_receiver_info.php',
        type: 'GET',
        data: { orderID: getUrlParameter('orderID') },
        dataType: 'json',
        success: function (data) {
            console.log('Receiver Info:', data);
            if (data.hasOwnProperty('error')) {
                console.error('Error:', data.error);
            } else {
                $('.invoice-container .sold-to-info p:eq(1)').text('Name of Receiver: ' + data.name);
                $('.invoice-container .sold-to-info p:eq(2)').text('Contact Number: ' + data.phone);
                $('.invoice-container .sold-to-info p:eq(3)').text('Email: ' + data.email);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });

    // Fetch shipping address using AJAX
    $.ajax({
        url: 'fetch_shipping_address.php',
        type: 'GET',
        data: { orderID: getUrlParameter('orderID') },
        dataType: 'json',
        success: function (data) {
            console.log('Shipping Address:', data);
            if (data.hasOwnProperty('error')) {
                console.error('Error:', data.error);
            } else {
                $('.invoice-container .sold-to-info p:eq(4)').text('Shipping Address: ' + data.address);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });

    // Fetch order items using AJAX
 // Fetch order items using AJAX
$.ajax({
    url: 'fetchItems.php',
    type: 'GET',
    data: { orderID: getUrlParameter('orderID') },
    dataType: 'json',
    success: function (data) {
        console.log('Order Items:', data);
        // Process the fetched order items data and update HTML accordingly
        if (data && data.length > 0) {
            var html = '';
            var subtotal = 0; // Initialize subtotal
            data.forEach(function (item) {
                html += '<tr>';
                html += '<td>' + item.quantity + '</td>';
                html += '<td>' + item.Name + '</td>';
                html += '<td>₱' + parseFloat(item.price).toFixed(2) + '</td>'; // Use peso symbol
                var amount = parseFloat(item.quantity) * parseFloat(item.price); // Calculate amount as a float
                html += '<td>₱' + amount.toFixed(2) + '</td>'; // Format amount with 2 decimal places and use peso symbol
                html += '</tr>';
                subtotal += amount; // Calculate subtotal
            });
            $('#orderInfo').html(html);
            // Update subtotal with 2 decimal places and show as currency
            $('.invoice-total p:eq(0)').html('<strong>Subtotal:</strong> ₱' + subtotal.toFixed(2)); // Use peso symbol
        } else {
            // Display a message if no order items are found
            $('#orderInfo').html('<tr><td colspan="4">No order items found.</td></tr>');
            $('.invoice-total p:eq(0)').html('<strong>Subtotal:</strong> ₱0.00'); // Use peso symbol
        }
    },
    error: function (xhr, status, error) {
        console.error('Error:', error);
        // Display an error message if there is an issue with fetching order items
        $('#orderInfo').html('<tr><td colspan="4">Error fetching order items.</td></tr>');
        $('.invoice-total p:eq(0)').html('<strong>Subtotal:</strong> ₱0.00'); // Use peso symbol
    }
});

    // Fetch shipping fee using AJAX
    $.ajax({
        url: 'fetch_shipping_fee.php',
        type: 'GET',
        data: { orderID: getUrlParameter('orderID') },
        dataType: 'json',
        success: function (data) {
            console.log('Shipping Fee:', data);
            if (data.hasOwnProperty('error')) {
                console.error('Error:', data.error);
            } else {
                $('#shippingFee').text('Shipping Fee: $' + data.shippingFee);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });

    // Fetch total amount using AJAX
    $.ajax({
        url: 'fetch_total.php',
        type: 'GET',
        data: { orderID: getUrlParameter('orderID') },
        dataType: 'json',
        success: function (data) {
            console.log('Total Amount:', data);
            if (data.hasOwnProperty('error')) {
                console.error('Error:', data.error);
            } else {
                $('#grandTotal').text('Grand Total: $' + data.total);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
});
    
</script>

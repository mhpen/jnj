<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="adminStyle.css">
    <style>
.item-container {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.item-img {
    width: 120px;
    height: 120px;
    overflow: hidden;
    border-radius: 8px;
    margin-right: 20px;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
}

.item-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-details {
    flex: 1;
}

.ordered-item {
    display: flex;
    align-items: center;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background-color: #f8f9fa;
}

.main {
    /* Remove margin on top */
    margin-top: 0;
    /* Remove padding and alignment properties */
    padding: 0;
    justify-content: unset;
    align-items: unset;
}

.shipping-address-col {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    margin-top: 20px;
    border-radius: 8px;
}

.shipping-address-col .shippingAddressFetchData p {
    margin-bottom: 10px;
}

.status-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    border-radius: 8px;
    height: 100px;
    box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.1);
}

.status-item {
    flex: 0 0 calc(20% - 20px); /* Each item takes up 20% width with a gap of 20px between them */
    display: flex;
    flex-direction: column;
    align-items: center;
    border-radius: 8px;
    padding: 10px;
    text-align: center; /* Center align text */
}

.status-item i {
    font-size: 48px; /* Adjust the font size as needed */
    margin-bottom: 10px; /* Add some space between icon and text */
}

.item-col, .bill-col {
    border-radius: 8px;
    box-shadow: 3px 4px 6px rgba(0, 0, 0, 0.1);
}

.receiver-col {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.receiver-col p {
    margin: 0 0 10px;
}

.receiver-col p strong {
    font-weight: bold;
}

/* Style for receiver name */
.receiver-name {
    font-size: 20px;
    color: #333;
    margin-bottom: 15px;
}

/* Style for phone number and email */
.contact-info {
    font-size: 16px;
    color: #666;
    margin-bottom: 10px;
}
    </style>
    
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="expand">
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
        <div class="main  justify-content-center align-items-center">
            <div class="container">
                <!-- First div for buttons -->
        <div class="btn-group mt-3 d-flex" role="group" aria-label="Order Actions">
  
    <button type="button" class="btn btn-outline-primary">
        <i class="lni lni-list fs-4 d-block mb-2"></i>
        <span>Order Details</span>
    </button>
    <button type="button" class="btn btn-outline-primary">
        <i class="lni lni-printer fs-4 d-block mb-2"></i>
        <span>Print Invoice</span>
    </button>
</div>


                <!-- Second div for status of order -->
                <div class="row mt-4">
                    <div class="col">
                        <p>Status of Order</p>
                        <div class="status-container">
                            <div class="status-item">
                                <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill= grey class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                </svg>                                
                                </div>
                                <div>
                                    <span>Cancelled</span>
                                </div>
                            </div>
                            <div class="status-item">
                                <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill=grey class="bi bi-hourglass-top" viewBox="0 0 16 16">
  <path d="M2 14.5a.5.5 0 0 0 .5.5h11a.5.5 0 1 0 0-1h-1v-1a4.5 4.5 0 0 0-2.557-4.06c-.29-.139-.443-.377-.443-.59v-.7c0-.213.154-.451.443-.59A4.5 4.5 0 0 0 12.5 3V2h1a.5.5 0 0 0 0-1h-11a.5.5 0 0 0 0 1h1v1a4.5 4.5 0 0 0 2.557 4.06c.29.139.443.377.443.59v.7c0 .213-.154.451-.443.59A4.5 4.5 0 0 0 3.5 13v1h-1a.5.5 0 0 0-.5.5m2.5-.5v-1a3.5 3.5 0 0 1 1.989-3.158c.533-.256 1.011-.79 1.011-1.491v-.702s.18.101.5.101.5-.1.5-.1v.7c0 .701.478 1.236 1.011 1.492A3.5 3.5 0 0 1 11.5 13v1z"/>
</svg>
                                </div>
                                <div>
                                    <span>Pending</span>
                                </div>
                                <div>
                                    
                                </div>
                            </div>
                            <div class="status-item">
                                <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill=grey class="bi bi-gear" viewBox="0 0 16 16">
  <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
  <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
</svg>                                </div>
                                <div>
                                    <span>Processing</span>
                                </div>
                            </div>
                            <div class="status-item">
                                <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="Grey" class="bi bi-truck" viewBox="0 0 16 16">
  <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
</svg>
                                </div>
                                <div>
                                    <span>Shipped</span>
                                </div>
                            </div>
                            <div class="status-item">
                                <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill=grey class="bi bi-check-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
</svg>                                </div>
                                <div>
                                    <span>Received</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Third div for ordered items and receiver -->
<div class="row mt-4">
    <!-- Ordered Items column -->
    <div class="col-md-6">
        <div class="item-col">
            <p>Ordered Items</p>
            <div class="orderedItemFetchData" style="height: 300px; overflow-y: auto;">
                <!-- Fetch and display ordered items here -->
                <!-- Each item will be displayed in its own container -->
            </div>
        </div>
    </div>
    <!-- Receiver and Shipping Address column -->
    <div class="col-md-6">
        <!-- Receiver column -->
        <div class="receiver-col">
            <p>Receiver</p>
            <div class="receiverFetchData">
            <?php
                    // Database connection
                    $host = 'localhost';
                    $dbname = 'jnjgiftsgalore_db';
                    $username = 'root';
                    $password = '';

                    // Create connection
                    $conn = new mysqli($host, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch order details to get receiver ID
                    $orderID = $_GET['orderID'];
                    $sql_order = "SELECT * FROM orders WHERE OrderID = $orderID";
                    $result_order = $conn->query($sql_order);

                    if ($result_order->num_rows > 0) {
                        $row_order = $result_order->fetch_assoc();
                        $receiverID = $row_order["ReceiverID"];

                        // Fetch receiver's contact information based on receiver ID
                        $sql_receiver = "SELECT * FROM receivercontact WHERE ReceiverID = $receiverID";
                        $result_receiver = $conn->query($sql_receiver);

                        if ($result_receiver->num_rows > 0) {
                            // Output receiver's contact information
                            $row_receiver = $result_receiver->fetch_assoc();
                            echo "<p>Name: " . $row_receiver["FirstName"] . " " . $row_receiver["LastName"] . "</p>";
                            echo "<p>Phone Number: " . $row_receiver["PhoneNum"] . "</p>";
                            echo "<p>Email: " . $row_receiver["EmailAddress"] . "</p>";
                        } else {
                            echo "No receiver information found";
                        }
                    } else {
                        echo "No order found";
                    }

                    $conn->close();
                ?>
            </div>
        </div>
        <!-- Shipping Address column -->
        
    <!-- Shipping Address column -->
    <div class="shipping-address-col mt-4">
    <p>Shipping Address</p>
    <div class="shippingAddressFetchData">
        <?php
        // Database connection
        $host = 'localhost';
        $dbname = 'jnjgiftsgalore_db';
        $username = 'root';
        $password = '';

        // Create connection
        $conn = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch order details to get shipping address ID
        $orderID = $_GET['orderID'];
        $sql_order = "SELECT * FROM orders WHERE OrderID = $orderID";
        $result_order = $conn->query($sql_order);

        if ($result_order->num_rows > 0) {
            $row_order = $result_order->fetch_assoc();
            $shippingID = $row_order["ShippingID"];

            // Fetch shipping address ID based on shipping ID
            $sql_shipping_id = "SELECT ShippingAddressID FROM shipping WHERE ShippingID = $shippingID";
            $result_shipping_id = $conn->query($sql_shipping_id);

            if ($result_shipping_id->num_rows > 0) {
                $row_shipping_id = $result_shipping_id->fetch_assoc();
                $shippingAddressID = $row_shipping_id["ShippingAddressID"];

                // Fetch concatenated shipping address based on shipping address ID
                $sql_shipping_address = "SELECT CONCAT(AddressLine1, ', ', Barangay, ', ', City, ', ', Province, ', ', Country, ', ', PostalCode, ', ', Location) AS full_address FROM shippingaddress WHERE ShippingAddressID = $shippingAddressID";
                $result_shipping_address = $conn->query($sql_shipping_address);

                if ($result_shipping_address->num_rows > 0) {
                    // Output concatenated shipping address
                    $row_shipping_address = $result_shipping_address->fetch_assoc();
                    echo "<p>" . $row_shipping_address["full_address"] . "</p>";
                } else {
                    echo "<p>No shipping address found</p>";
                }
            } else {
                echo "<p>No shipping address ID found for the shipping ID</p>";
            }
        } else {
            echo "<p>No order found</p>";
        }
        $conn->close();
        ?>
    </div>
</div>
    </div>
</div>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script src="adminScript.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hamBurger = document.querySelector(".toggle-btn");
        hamBurger.addEventListener("click", function () {
            document.querySelector("#sidebar").classList.toggle("expand");
        });

        // Fetch ordered items and billing address when the DOM is loaded
        const urlParams = new URLSearchParams(window.location.search);
        const orderID = urlParams.get('orderID');
        fetchOrderedItems(orderID);
        fetchBillingAddress(orderID);

        // Add click event listener to the "Order Details" button
        document.querySelector('.btn-order-details').addEventListener('click', function () {
            // Extract the order ID from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const orderID = urlParams.get('orderID');

            // Fetch and display ordered items and billing address
            fetchOrderedItems(orderID);
            fetchBillingAddress(orderID);
        });
    });

    // Function to fetch and display ordered items
    function fetchOrderedItems(orderID) {
        fetch('fetch_ordered_item.php?orderID=' + orderID)
            .then(response => response.json())
            .then(data => {
                const orderedItemsContainer = document.querySelector('.orderedItemFetchData');
                orderedItemsContainer.innerHTML = ''; // Clear previous content
                data.forEach(item => {
                    const orderedItem = document.createElement('div');
                    orderedItem.classList.add('ordered-item', 'item-container');
                    orderedItem.innerHTML = `
                        <div class="item-img">
                        <img src="../images/${item.PhotoMain}" alt="Product Image">

                        </div>
                        <div class="item-details">
                            <p>Product Name: ${item.product_name}</p>
                            <p>Variation Name: ${item.variationname}</p>
                            <p>Quantity: ${item.quantity}</p>
                            <p>Price: ${item.price}</p>
    
                        </div>
                    `;
                    orderedItemsContainer.appendChild(orderedItem);
                });
            })
            .catch(error => console.error('Error fetching ordered items:', error));
    }

    // Function to fetch and display billing address
    function fetchBillingAddress(orderID) {
        fetch('fetch_billing_address.php?orderID=' + orderID)
            .then(response => response.text())
            .then(data => {
                // Update the content of the receiverBillingData div with the fetched data
                document.querySelector('.receiverBillingData').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching billing address:', error);
            });
    }
</script>

</body>

</html>
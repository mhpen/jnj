<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="adminStyle.css">
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
        <div class="main p-3">
            <div class="text-center">
                <h1>ORDERS</h1>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <!-- Table header -->
                            <tr>
                                <th>Full Name</th>
                                <th>Order ID</th>
                                <th>Order Status</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
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

                            // Fetch data from the orders table joined with the users table
                            $sql = "SELECT CONCAT(u.firstName, ' ', u.lastName) AS fullName, o.orderID, o.orderStatus, o.Grandtotal 
                                    FROM orders o
                                    INNER JOIN users u ON o.userID = u.userID"; // Assuming there's a userID column in both tables to join on
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["fullName"] . "</td>";
                                    echo "<td>" . $row["orderID"] . "</td>";
                                    echo '<td><div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle order-status-dropdown" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-order-id="' . $row["orderID"] . '">
                                                    ' . $row["orderStatus"] . '
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><button class="dropdown-item pending" value="Pending">Pending</button></li>
                                                <li><button class="dropdown-item processing" value="Processing">Processing</button></li>
                                                <li><button class="dropdown-item shipped" value="Shipped">Shipped</button></li>
                                                <li><button class="dropdown-item delivered" value="Delivered">Delivered</button></li>
                                            </ul>
                                            </div></td>';
                                    echo "<td>" . $row["Grandtotal"] . "</td>";
                                    echo '<td><a href="orderView.php?orderID=' . $row["orderID"] . '" class="btn btn-primary">View</a></td>';
                                    echo "</tr>";
                                }
                            } else {
                                echo '<tr><td colspan="5">No orders found</td></tr>';
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="adminScript.js"></script>
    <script>document.addEventListener('DOMContentLoaded', function () {
    const dropdownButtons = document.querySelectorAll('.order-status-dropdown');

    dropdownButtons.forEach(function (button) {
        let orderId = button.dataset.orderId;
        let isOpen = false; // Variable to track dropdown state

        // Add event listener to each dropdown button
        button.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent dropdown from closing when clicked
            
            // Check if dropdown is already open
            if (!isOpen) {
                isOpen = true; // Set dropdown state to open
                button.nextElementSibling.classList.add('show'); // Show dropdown menu
            } else {
                isOpen = false; // Set dropdown state to closed
                button.nextElementSibling.classList.remove('show'); // Hide dropdown menu
            }
        });

        // Add event listener to each dropdown item
        const dropdownItems = button.nextElementSibling.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(function (item) {
            item.addEventListener('click', function () {
                let newStatus = item.value;
                
                // Send AJAX request to update order status
                fetch('update_order_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ orderId: orderId, newStatus: newStatus }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Order status updated successfully');
                        // You can update the UI here if needed
                        button.innerHTML = newStatus; // Update the dropdown button text
                    } else {
                        console.error('Error updating order status:', data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
                
                isOpen = false; // Set dropdown state to closed after selecting an item
                button.nextElementSibling.classList.remove('show'); // Hide dropdown menu
            });
        });
    });

    const hamBurger = document.querySelector(".toggle-btn");
    hamBurger.addEventListener("click", function () {
        document.querySelector("#sidebar").classList.toggle("expand");
    });
});
    </script>
</body>
</html>
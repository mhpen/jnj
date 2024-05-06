<?php
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

$sql = "SELECT u.FirstName, u.LastName, m.MessageID, m.MessageContent, m.Timestamp, recent_messages.SenderID
        FROM Users u
        JOIN (
            SELECT SenderID, MessageContent, MAX(Timestamp) AS MaxTimestamp
            FROM Messages
            GROUP BY SenderID
        ) AS recent_messages ON u.UserID = recent_messages.SenderID
        JOIN Messages m ON recent_messages.SenderID = m.SenderID AND recent_messages.MaxTimestamp = m.Timestamp";

// Execute the SQL query
$result = $conn->query($sql);

// Check for errors
if (!$result) {
    die('Error executing query: ' . $conn->error);
}
?>

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
        .table-hover tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .table-hover tr.sent {
            font-weight: bold;
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
        <div class="main p-3">
           
            <div class="container">
                <h2>Recent Messages</h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Message Content</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
// Loop through each row of the result set
while ($row = $result->fetch_assoc()) {
    echo "<tr class='message-row' data-sender-id='" . $row['SenderID'] . "' data-message-id='" . $row['MessageID'] . "'>";
echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
echo "<td>" . $row['MessageContent'] . "</td>";
echo "<td>" . $row['Timestamp'] . "</td>";
echo "</tr>";
}
?>
</tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="adminScript.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
            // Add click event listener to message rows
               // Add click event listener to message rows
        $(".message-row").click(function() {
            // Get the SenderID from the data attribute
            var senderID = $(this).data("sender-id");

            // Construct the URL with the SenderID as a parameter
            var url = "viewMessage.php?SenderID=" + senderID;

            // Navigate to the viewMessage.php page
            window.location.href = url;
        });
    });
</script>
    <script>
        const hamBurger = document.querySelector(".toggle-btn");

        hamBurger.addEventListener("click", function () {
            document.querySelector("#sidebar").classList.toggle("expand");
        });

        // Add event listener for message rows
        const messageRows = document.querySelectorAll(".message-row");
        messageRows.forEach(row => {
            row.addEventListener("click", function () {
                // Mark the message as read
                row.classList.remove("sent");
            });
        });
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">

    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            flex-direction: column; /* Updated to column */
            gap: 20px;
        }

        .user-profile {
            display: flex;
            gap: 20px;
        }

        .left-div {
            flex: 1;
            max-width: 300px; /* Updated width */
        }

        .right-div {
            flex: 2; /* Updated flex value */
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        .profile-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-picture {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            overflow: hidden;
            background: #d9d9d9;
            margin-bottom: 20px;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .username {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .edit-profile-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            background-color: #0056b3;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: block;
            margin-bottom: 20px;
        }

        .edit-profile-btn:hover {
            background-color: #004080;
        }

        .status-section {
            flex: 0.5; /* Updated size */
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .status-placeholder {
            font-size: 150px; /* Increased size */
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .status-row {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .status-item {
            display: flex;
            align-items: center;
            font-size: 16px;
            color: #333;
        }

        .status-icon {
            margin-right: 10px;
            font-size: 20px;
            color: #0056b3;
        }

        .transaction-history {
            flex: 1;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-profile">
            <div class="left-div">
                <div class="profile-section">
                    <div class="profile-picture">
                        <img src="default_profile_picture.jpg" alt="Profile Picture">
                    </div>
                    <div class="username">John Doe</div>
                    <button class="edit-profile-btn">Edit Profile</button>
                </div>
            </div>
            <div class="right-div">
                <div class="status-section">
                    <div class="status-row">
                        <div class="status-placeholder">1</div>
                        <div class="status-item">
                            <span class="status-icon"><i class="bi bi-clock-history"></i></span>
                            <span>Pending Orders</span>
                        </div>
                    </div>
                </div>
                <div class="status-section">
                    <div class="status-row">
                        <div class="status-placeholder">2</div>
                        <div class="status-item">
                            <span class="status-icon"><i class="bi bi-truck"></i></span>
                            <span>To Receive</span>
                        </div>
                    </div>
                </div>
                <div class="status-section">
                    <div class="status-row">
                        <div class="status-placeholder">3</div>
                        <div class="status-item">
                            <span class="status-icon"><i class="bi bi-receipt"></i></span>
                            <span>Received</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="transaction-history">
            <h3>Transaction History</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order Name</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch transaction history data dynamically -->
                    <tr>
                        <td>Order 1</td>
                        <td>Product 1</td>
                        <td>$10.00</td>
                        <td>2024-05-06</td>
                    </tr>
                    <tr>
                        <td>Order 2</td>
                        <td>Product 2</td>
                        <td>$15.00</td>
                        <td>2024-05-05</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
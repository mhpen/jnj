<?php
require "connection.php";

$firstName = isset($_POST['Firstname']) ? $_POST['Firstname'] : '';
$lastName = isset($_POST['Lastname']) ? $_POST['Lastname'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $error_message = "Error: All fields are required.";
    } else {
        // Insert user into Users table
        $sql = "INSERT INTO Users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

        if ($stmt->execute()) {
            // Get the ID of the newly inserted user
            $userID = $stmt->insert_id;

            // Use the userID as the cartID
            $cartID = $userID;

            // Insert the cart ID and user ID into the cart table
            $cartSql = "INSERT INTO cart (cartID, userID) VALUES (?, ?)";
            $cartStmt = $conn->prepare($cartSql);
            $cartStmt->bind_param("ii", $cartID, $userID); // Assuming both cartID and userID are integers
            $cartStmt->execute();

            echo "<script>window.success_message = true;</script>";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
        $cartStmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body>

<div class="navigation">
        <div class="nav-links">
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
        </div>
        
        <div class="logo">J&J</div>
        <div class="user-actions">
            <a href="#">Login</a>
            <a href="#">Cart</a>
        </div>
    </div>
    <div class="reg-container">
       <div class="reg-left-col">
        </div>
        <div class="reg-right-col">
            <div class="create-account-content"> <h1>Create an account</h1></div>
            <div class="reg-form">
                <?php if(isset($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
                <?php elseif(isset($success_message)): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <form method="post">
                    <input type="text" id="Firstname" name="Firstname" placeholder="Firstname"><br>
                    <input type="text" id="Lastname" name="Lastname" placeholder="Lastname"><br>
                    <input type="email" id="email" name="email" placeholder="Email"><br>
                    <input type="password" id="password" name="password" placeholder="Password"><br>
                    <button class="reg-button" type="submit">CREATE YOUR ACCOUNT</button><br>
                </form>
            </div>
            <div class="login-account-text">
                <p>Already have an account? <a href="../client/login.php" class="login-link">Login</a></p>
            </div> 
        </div>
    </div>
    <div class="footer">
        <!-- Footer content -->
    </div>
    <div id="notification-message" class="notification-message hidden">
        <span id="notification-text"></span>
        <button id="notification-dismiss" class="notification-dismiss">Dismiss</button>
    </div>
    <script>
        const notificationMessage = document.getElementById('notification-message');
        const notificationText = document.getElementById('notification-text');
        const notificationDismiss = document.getElementById('notification-dismiss');

        function showNotification(message) {
            notificationText.innerText = message;
            notificationMessage.classList.remove('hidden');
            setTimeout(() => {
                notificationMessage.classList.add('hidden');
            }, 3000);
        }

        if (window.success_message) {
            showNotification('Account Successfully Created!');
        }

        notificationDismiss.addEventListener('click', () => {
            notificationMessage.classList.add('hidden');
        });
    </script>
</body>
</html>
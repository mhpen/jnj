<?php
require "connection.php";

$firstName = isset($_POST['Firstname']) ? $_POST['Firstname'] : '';
$lastName = isset($_POST['Lastname']) ? $_POST['Lastname'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password)) {
        $error_message = "Error: All fields are required.";
    } else {
        $sql = "INSERT INTO Users (firstName, lastName, username, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $firstName, $lastName, $username, $email, $password);

        if ($stmt->execute()) {
            echo "<script>window.success_message = true;</script>";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
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
                    <input type="text" id="username" name="username" placeholder="Username"><br>
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
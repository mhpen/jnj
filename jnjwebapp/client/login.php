<?php

session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "connection.php";

    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate email and password
    if (empty($email) || empty($password)) {
        $error_message = "Error: Please enter both email and password.";
    } else {
        // Check if the user exists in the database
        $sql = "SELECT UserID, Password FROM Users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            // Verify the password
            if ($password === $user['Password']) { // Assuming passwords are stored in plaintext for demonstration (not recommended in production)
                $_SESSION['email'] = $email; // Store email in session
                $_SESSION['user_id'] = $user['UserID'];
                $_SESSION['cart_id'] = $user['cartID']; // Store user ID in session
                // Store user ID in session
                
                // Retrieve cart ID associated with the user
                $sql_cart = "SELECT cartID FROM cart WHERE userID = ?";
                $stmt_cart = $conn->prepare($sql_cart);
                $stmt_cart->bind_param("i", $user['UserID']);
                $stmt_cart->execute();
                $result_cart = $stmt_cart->get_result();
                
                if ($result_cart->num_rows == 1) {
                    $cart = $result_cart->fetch_assoc();
                    $_SESSION['cart_id'] = $cart['cartID']; // Store cart ID in session
                }
                
                header("Location: product_catalog.php"); // Redirect to dashboard or any other page after successful login
                exit();
            } else {
                $error_message = "Error: Incorrect password.";
            }
        } else {
            $error_message = "Error: User not found.";
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
    <title>Login Page</title>
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
    <div class="container">
        <div class="left-col">
            <!-- Left column content -->
        </div>
        <div class="right-col">
            <div class="login-content">Login</div>
            <div class="login-form">
                <?php if(isset($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <form method="post">
                    <input type="email" id="email" name="email" placeholder="Email" class="input-field">
                    <input type="password" id="password" name="password" placeholder="Password" class="input-field">
                    <a href="#" class="forgot-password">Forgot Password?</a>
                    <button class="login-button" type="submit">LOGIN</button>
                </form>
                <div class="create-account-text">
                    <p>You do not have an account? <a href="../client/registration.php" class="create-account-link">Create an Account</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navigation = document.querySelector('.navigation');

            window.addEventListener('scroll', function () {
                if (window.scrollY > 0) {
                    navigation.style.backgroundColor = '#FFFFFF';
                } else {
                    navigation.style.backgroundColor = 'transparent';
                }
            });

            document.querySelectorAll('.navigation a').forEach(function (link) {
                link.addEventListener('mouseover', function () {
                    navigation.style.backgroundColor = '#FFFFFF';
                });
            });

            document.querySelectorAll('.navigation a').forEach(function (link) {
                link.addEventListener('mouseout', function () {
                    if (window.scrollY === 0) {
                        navigation.style.backgroundColor = 'transparent';
                    }
                });
            });
        });
    </script>
    
    <footer class="footer">
        <p>&copy; 2023 J&J Web App. All rights reserved.</p>
    </footer>
</body>
</html>
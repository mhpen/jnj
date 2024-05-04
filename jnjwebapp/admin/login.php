<?php
session_start();
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "connection.php"; // Assuming connection.php contains database connection logic

    // Handle login form submission
    if (isset($_POST['loginSubmit'])) {
        $email = isset($_POST['loginEmail']) ? $_POST['loginEmail'] : '';
        $password = isset($_POST['loginPassword']) ? $_POST['loginPassword'] : '';

        // Validate email and password
        if (!empty($email) && !empty($password)) {
            // Hash the password provided by the user
            $hashed_password_user = password_hash($password, PASSWORD_DEFAULT);

            // Check if the user exists in the database
            $sql = "SELECT UserID, Email, Password, isAdmin FROM Users WHERE Email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();

                // Compare the hashed password provided by the user with the hashed password stored in the database
                if (password_verify($password, $user['Password'])) {
                    if ($user['isAdmin'] == 1) { // Check if user is an admin
                        $_SESSION['email'] = $user['Email']; // Store email in session
                        $_SESSION['isAdmin'] = $user['isAdmin']; // Store isAdmin in session
                        $_SESSION['login_success'] = true; // Flag for successful login
                        header("Location: order_management.php"); // Redirect to order management page
                        exit();
                    } else {
                        $error_message = "Error: You are not authorized to login as an admin.";
                    }
                } else {
                    $error_message = "Error: Incorrect email or password.";
                }
            } else {
                $error_message = "Error: User not found.";
            }
        } else {
            $error_message = "Error: Please enter both email and password.";
        }
    }
}
?>
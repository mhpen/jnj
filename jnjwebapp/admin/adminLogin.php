<?php
include 'connection.php';

$error_message = '';

// Initialize variables to hold the entered password and retrieved password
$entered_password = '';
$retrieved_password = '';

// Handle login form submission
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $entered_password = $_POST['password'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE Email=? AND isAdmin=1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if a row with the email exists
    if (is_array($row) && !empty($row)) {
        // Retrieve the password from the database
        $retrieved_password = $row['Password'];

        // Verify the hashed password
        if (password_verify($entered_password, $retrieved_password) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a variable for successful login
            session_start();
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['is_admin'] = $row['is_admin']; // Add this line to store the is_admin value in the session

            // Redirect to the appropriate home page
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Error: Incorrect password.";
        }
    } else {
        $error_message = "Error: User not found or not an admin.";
    }
}

    // Handle registration form submission
    if (isset($_POST['registerSubmit'])) {
        $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
        $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
        $email = isset($_POST['registerEmail']) ? $_POST['registerEmail'] : '';
        $password = isset($_POST['registerPassword']) ? $_POST['registerPassword'] : '';

        // Check if all fields are filled
        if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($password)) {
            // Check if the email is already registered
            $sql = "SELECT UserID FROM Users WHERE Email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                // Insert new user into the database
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
                $isAdmin = 1; // Set isAdmin to 1 for administrators

                $sql = "INSERT INTO Users (FirstName, LastName, Email, Password, isAdmin) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $firstName, $lastName, $email, $hashedPassword, $isAdmin);
                if ($stmt->execute()) {
                    // Registration successful
                    $_SESSION['email'] = $email; // Store email in session
                    $_SESSION['isAdmin'] = $isAdmin; // Store isAdmin in session
                    header("Location: adminLogin.php"); // Redirect to welcome page or dashboard
                    exit();
                } else {
                    $error_message = "Error: Registration failed. Please try again later.";
                }
            } else {
                $error_message = "Error: This email is already registered.";
            }
        } else {
            $error_message = "Error: Please fill in all fields.";
        }
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8" />
  <title>Login and Registration System</title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap");
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }
    
    body {
      background: beige;
      height: 100vh;
    }
    
    .center {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      max-width: 420px;
      width: 100%;
      background: white;
      border-radius: 10px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
      transition: transform 0.5s ease-in-out;
    }
    
    .center h1 {
      text-align: center;
      padding: 20px 0;
      border-bottom: 1px solid silver;
    }
    
    .center form {
      padding: 0 40px;
      box-sizing: border-box;
    }
    
    form .txt_field {
      position: relative;
      border-bottom: 2px solid #adadad;
      margin: 30px 0;
    }
    
    .txt_field input {
      width: 100%;
      padding: 0 5px;
      height: 40px;
      font-size: 16px;
      border: none;
      background: none;
      outline: none;
    }
    
    .txt_field label {
      position: absolute;
      top: 50%;
      left: 5px;
      color: #adadad;
      transform: translateY(-50%);
      font-size: 16px;
      pointer-events: none;
      transition: 0.5s;
    }
    
    .txt_field span::before {
      content: "";
      position: absolute;
      top: 40px;
      left: 0;
      width: 0%;
      height: 2px;
      background: brown;
      transition: 0.5s;
    }
    
    .txt_field input:focus~label,
    .txt_field input:valid~label {
      top: -5px;
      color: black;
    }
    
    .txt_field input:focus~span::before,
    .txt_field input:valid~span::before {
      width: 100%;
    }
    
    .pass {
      margin: -5px 0 20px 5px;
      color: #a6a6a6;
      cursor: pointer;
    }
    
    .pass:hover {
      text-decoration: underline;
    }
    
    input[type="submit"] {
      width: 100%;
      height: 50px;
      background: beige;
      border-radius: 25px;
      font-size: 18px;
      color: #555;
      font-weight: 700;
      cursor: pointer;
      outline: none;
      transition: 0.5s;
      border: 2px solid #555;
    }
    
    input[type="submit"]:hover {
      background: #555;
      color: beige;
      border-color: beige;
    }
    
    .signup_link {
      margin: 30px 0;
      text-align: center;
      font-size: 16px;
      color: #666666;
    }
    
    .signup_link a {
      color: #2691d9;
      text-decoration: none;
    }
    
    .signup_link a:hover {
      text-decoration: underline;
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }
    
    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      border-radius: 10px;
    }
  </style>
</head>

<body>

<p>Entered Password: <?php echo $entered_password; ?></p>
<p>Retrieved Password: <?php echo $retrieved_password; ?></p>

<!-- Your login form goes here -->
<form method="post">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" name="login" value="Login">
</form>

  <div class="center" id="container">
    <h1>Login</h1>
    <form id="loginForm" method="post">
      <?php if(!empty($error_message)): ?>
      <p style="color: red;"><?php echo $error_message; ?></p>
      <?php endif; ?>
      <div class="txt_field">
      <input type="email" name="email" placeholder="Email" required><br>
        <span></span>
        <label>Email</label>
      </div>
      <div class="txt_field">
      <input type="password" name="password" placeholder="Password" required><br>
        <span></span>
        <label>Password</label>
      </div>
      <input type="submit" name="login" value="Login">
            <div class="signup_link">Not a member? <a href="#" id="signupLink">Signup</a></div>
    </form>

    <form id="registerForm" method="post" style="display: none;">
      <?php if(!empty($error_message)): ?>
      <p style="color: red;"><?php echo $error_message; ?></p>
      <?php endif; ?>
      <div class="txt_field">
        <input type="text" name="firstName" required />
        <span></span>
        <label>First Name</label>
      </div>
      <div class="txt_field">
        <input type="text" name="lastName" required />
        <span></span>
        <label>Last Name</label>
      </div>
      <div class="txt_field">
        <input type="email" name="registerEmail" required />
        <span></span>
        <label>Email Address</label>
      </div>
      <div class="txt_field">
        <input type="password" name="registerPassword" required />
        <span></span>
        <label>Password</label>
      </div>
      <input type="submit" value="Register" name="registerSubmit" />
      <div class="signup_link">Already have an account? <a href="#" id="loginLink">Login</a></div>
    </form>
  </div>

  <!-- Modal for failed login attempt -->
  <div id="modalFail" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <p>Failed to login. Please check your email and password.</p>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('loginButton').addEventListener('click', function () {
            var email = document.getElementsByName('loginEmail')[0].value;
            var password = document.getElementsByName('loginPassword')[0].value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'login.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            window.location.href = 'order_management.php';
                        } else {
                            showError(response.message);
                        }
                    } else {
                        showError('Error: Unable to process the request.');
                    }
                }
            };
            xhr.send('loginSubmit=1&loginEmail=' + encodeURIComponent(email) + '&loginPassword=' + encodeURIComponent(password));
        });

        function showError(message) {
            var errorMessage = document.createElement('p');
            errorMessage.style.color = 'red';
            errorMessage.textContent = message;

            var form = document.querySelector('.center form');
            form.insertBefore(errorMessage, form.firstChild);
        }
    });
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const loginLink = document.getElementById('loginLink');
    const signupLink = document.getElementById('signupLink');
    const container = document.getElementById('container');
    const modalFail = document.getElementById('modalFail');
    const modalContent = document.querySelector('.modal-content');
    const closeModal = document.getElementsByClassName('close')[0];

    // Function to display modal
    function displayModal() {
      modalFail.style.display = 'block';
    }

 

    // Event listener for closing modal
    closeModal.onclick = function() {
      modalFail.style.display = 'none';
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
      if (event.target == modalFail) {
        modalFail.style.display = 'none';
      }
    }

    loginLink.addEventListener('click', () => {
      container.style.transform = 'translate(-50%, -50%)';
      loginForm.style.display = 'block';
      registerForm.style.display = 'none';
    });

    signupLink.addEventListener('click', () => {
      container.style.transform = 'translate(-50%, -50%)';
      loginForm.style.display = 'none';
      registerForm.style.display = 'block';
    });
  </script>

</body>

</html>
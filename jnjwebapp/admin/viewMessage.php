<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect or show an error message if the user is not logged in
    exit("User not logged in.");
}

// Check if the SenderID is provided via GET request
if (!isset($_GET['SenderID'])) {
    // Redirect or show an error message if the SenderID is missing
    exit("SenderID not provided.");
}

// Get the SenderID from the GET request
$senderID = $_GET['SenderID'];

// Database connection parameters
$host = 'localhost';
$dbname = 'jnjgiftsgalore_db';
$username = 'root';
$password = '';

$messages = []; // Initialize an empty array to store messages

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to retrieve messages for the specified SenderID
    $stmt = $conn->prepare("SELECT * FROM Messages WHERE SenderID = :senderID");
    $stmt->bindParam(':senderID', $senderID);
    $stmt->execute();

    // Fetch messages from the database and store them in the array
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database connection errors
    exit("Failed to connect to the database. Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .message-box {
            height: 316px;
            width: 100%;
            padding-right: 5px;
            overflow: auto;
        }
        .message-box .chat-container {
            display: flex;
            flex-direction: column;
        }
        .message-box .chat-container .message {
            display: inline-block;
            max-width: 70%;
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 10px;
            word-wrap: break-word;
        }
        .message-box .chat-container .user-message {
            background-color: #4fc3f7;
            color: white;
            align-self: flex-end;
        }
        .message-box .chat-container .admin-message {
            background-color: #f3f3f3;
            color: #333;
            align-self: flex-start;
        }
        .message-box .chat-container .arrow {
            width: 0;
            height: 0;
            border-style: solid;
            position: relative;
            top: -2px;
        }
        .message-box .chat-container .user-arrow {
            border-width: 0 0 10px 10px;
            border-color: transparent transparent #4fc3f7 transparent;
            right: -7px;
        }
        .message-box .chat-container .admin-arrow {
            border-width: 0 10px 10px 0;
            border-color: transparent #f3f3f3 transparent transparent;
            left: -7px;
        }
        .input-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .input-box {
            display: flex;
            border: 1px solid #ced4da;
            border-radius: 20px;
            overflow: hidden;
            width: 90%; /* Adjusted width */
        }
        .input-box input[type="text"] {
            border: none;
            outline: none;
            padding: 12px; /* Adjusted padding */
            flex: 1;
        }
        .input-box .send-button {
            background-color: #4fc3f7;
            color: white;
            border: none;
            outline: none;
            padding: 12px; /* Adjusted padding */
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Chat window -->
    <div class="container mt-5">
        <div class="message-box mx-auto">
            <div class="chat-container">
                <?php foreach ($messages as $message): ?>
                    <?php if ($message['SenderID'] == $_SESSION['user_id']): ?>
                        <div class="message admin-message">
                            <?php echo $message['MessageContent']; ?>
                            <div class="arrow admin-arrow"></div>
                        </div>
                    <?php else: ?>
                        <div class="message user-message">
                            <?php echo $message['MessageContent']; ?>
                            <div class="arrow user-arrow"></div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Input box -->
        <div class="input-container">
            <div class="input-box">
                <input type="text" id="messageContent" placeholder="Type your message...">
                <button class="send-button" id="send-button"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
        <script>
$(document).ready(function () {
    // Function to send message via AJAX
    $("#send-button").click(function () {
        var messageContent = $("#messageContent").val().trim();

        if (messageContent !== '') {
            // Send message via AJAX
            $.ajax({
                type: "POST",
                url: "sendMessage.php",
                data: { ReceiverID: <?php echo $recipientID; ?>, MessageContent: messageContent },
                success: function (response) {
                    // Append user message to message container
                    $('.chat-container').append(`
                        <div class="message user-message">
                            ${messageContent}
                            <div class="arrow user-arrow"></div>
                        </div>
                    `);
                    // Scroll to bottom of message container
                    $('.message-box').scrollTop($('.message-box')[0].scrollHeight);
                    // Clear input field
                    $("#messageContent").val('');
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        } else {
            alert("Please enter a message before sending.");
        }
    });

    // Function to handle clicking on admin messages for reply
    $(document).on('click', '.admin-message', function() {
        var messageContent = $(this).text().trim(); // Extract message content
        $("#messageContent").val(messageContent); // Populate input field with message content
    });
});
</script>
</body>
</html>
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

$messages = [];

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to retrieve received messages for the specified SenderID
    $receivedStmt = $conn->prepare("SELECT SenderID, MessageContent, Timestamp FROM Messages WHERE SenderID = :senderID");
    $receivedStmt->bindParam(':senderID', $senderID);
    $receivedStmt->execute();

    // Fetch received messages from the database and store them in the array
    $receivedMessages = $receivedStmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare SQL statement to retrieve sent messages for the specified SenderID and current user
    $sentStmt = $conn->prepare("SELECT SenderID, MessageContent, Timestamp FROM Messages WHERE ReceiverID = :senderID AND SenderID = :userID");
    $sentStmt->bindParam(':senderID', $senderID);
    $sentStmt->bindParam(':userID', $_SESSION['user_id']);
    $sentStmt->execute();

    // Fetch sent messages from the database and store them in the array
    $sentMessages = $sentStmt->fetchAll(PDO::FETCH_ASSOC);

    // Merge received and sent messages into a single array
    $messages = array_merge($receivedMessages, $sentMessages);

    // Sort the messages array by timestamp
    usort($messages, function($a, $b) {
        return strtotime($a['Timestamp']) - strtotime($b['Timestamp']);
    });
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
        /* Your CSS styles here */
        body {
            background-color: #f8f9fa;
            color: #5F361A; /* Theme color */
        }
        .message-box {
            height: 316px;
            width: 100%;
            padding: 10px; /* Added padding */
            overflow: auto;
            background-color: white; /* Added white background */
            border-radius: 20px; /* Added border-radius */
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
            margin-left: auto; /* Push the message to the right */
        }
        .message-box .chat-container .admin-message {
            background-color: #f3f3f3;
            color: grey; /* Changed color to grey */
            align-self: flex-start;
        }
        .input-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .input-box {
            display: flex;
            align-items: center; /* Center items vertically */
            border: 1px solid #ced4da;
            border-radius: 20px;
            overflow: hidden;
            width: 90%; /* Adjusted width */
            background-color: white; /* Added white background */
        }
        .input-box input[type="text"] {
            border: none;
            outline: none;
            padding: 12px; /* Adjusted padding */
            flex: 1;
        }
        .send-button {
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
    <!-- Parent div for message section and input container -->
    <div class="container mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="message-box">
                <div class="chat-container">
                    <!-- Display messages -->
                    <?php foreach ($messages as $message): ?>
                        <?php if ($message['SenderID'] == $senderID): ?>
                            <!-- Sent messages on the left -->
                            <div class="message admin-message">
                                <div class="message-text"><?php echo $message['MessageContent']; ?></div>
                            </div>
                        <?php else: ?>
                            <!-- Received messages on the right -->
                            <div class="message user-message">
                                <div class="message-text"><?php echo $message['MessageContent']; ?></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="input-container">
                <form id="messageForm" class="input-box">
                    <input type="hidden" name="ReceiverID" value="<?php echo $senderID; ?>">
                    <input type="text" name="MessageContent" id="messageContent" placeholder="Type your message...">
                    <button type="button" class="send-button"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
    // Function to send message via AJAX
    $(document).ready(function () {
    // Function to send message via AJAX
  // Function to send message via AJAX
$(".send-button").click(function () {
    var messageContent = $("#messageContent").val().trim();

    if (messageContent !== '') {
        // Send message via AJAX
        $.ajax({
            type: "POST",
            url: "sendMessage.php",
            data: {
                ReceiverID: <?php echo $senderID; ?>,
                MessageContent: messageContent
            },
            success: function (response) {
    // Handle success
    // Append the sent message to the UI immediately
    $('.chat-container').append('<div class="message user-message"><div class="message-text">' + messageContent + '</div></div>');
    // Clear the input field after sending the message
    $("#messageContent").val('');
},
        });
    } else {
        alert("Please enter a message before sending.");
    }
});
    // Function to fetch and update messages periodically
    function fetchAndDisplayMessages() {
        var senderID = <?php echo $senderID; ?>;
        var userID = <?php echo $_SESSION['user_id']; ?>;

        // Fetch and update received messages via AJAX
        $.ajax({
            type: "POST",
            url: "fetchReceivedMessage.php",
            data: {
                SenderID: senderID
            },
            success: function (response) {
                $('.chat-container-left').html(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        // Fetch and update sent messages via AJAX
        $.ajax({
            type: "POST",
            url: "fetchSentMessage.php",
            data: {
                SenderID: senderID,
                UserID: userID
            },
            success: function (response) {
                // Update the UI with sent messages
                $('.chat-container-right').html(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Initial fetch and display of messages
    fetchAndDisplayMessages();

    // Fetch and display messages every 5 seconds (adjust the interval as needed)
    setInterval(fetchAndDisplayMessages, 5000);
});
    </script>
</body>
</html>
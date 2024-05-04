<?php
session_start();

// Check if the user is logged in and get their user ID
if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
    

    // Retrieve the message content sent via AJAX
    $messageContent = isset($_POST['messageContent'])? $_POST['messageContent'] : null;

    // Only save the message if messageContent is not empty
    if ($messageContent!== null && trim($messageContent)!== '') {
        // Database connection parameters
        $host = 'localhost';
        $dbname = 'jnjgiftsgalore_db';
        $username = 'root';
        $password = '';

        try {
            // Connect to the database
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare the SQL statement to insert the message
            $stmt = $conn->prepare("INSERT INTO Messages (SenderID, MessageContent) VALUES (:senderID, :messageContent)");
            $stmt->bindParam(':senderID', $userID);
            $stmt->bindParam(':messageContent', $messageContent);

            // Execute the SQL statement
            $stmt->execute();

            // Return a success response
            echo json_encode(array("status" => "success"));
        } catch(PDOException $e) {
            // Return an error response with a custom message
            echo json_encode(array("status" => "error", "message" => "Failed to insert message into database. Error: " . $e->getMessage()));
        }
    } else {
        // Return an error response if messageContent is empty
        echo json_encode(array("status" => "error", "message" => "Message content is empty."));
    }
} else {
    // Return an error response if the user is not logged in
    echo json_encode(array("status" => "error", "message" => "User not logged in."));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat Interface</title>
<style>
  
/* chat open and close */
.chat-bar-open {
  text-align: center;
  position: fixed;
  bottom: 40px;
  right: 50px;
}
.chat-bar-close {
  display: none;
  text-align: center;
  position: fixed;
  bottom: 40px;
  right: 50px;
}
.chat-bar-open .close,
.chat-bar-close .close {
  background-color: #fff;
  width: 70px;
  cursor: pointer;
  height: 70px;
  padding: 15px;
  border-radius: 50%;
  border-style: none;
  vertical-align: middle;
  box-shadow: rgb(0 0 0 / 10%) 0px 1px 6px, rgb(0 0 0 / 20%) 0px 2px 24px;
}
.chat-bar-close .close {
  width: 56px;
  height: 56px;
  padding: 12px;
}
.chat-bar-open .close img {
  height: 40px;
}
.chat-bar-close .close i {
  font-size: 30px;
}
.chat-bar-open .close::after {
  position: absolute;
  content: "";
  top: 43px;
  left: 37px;
  transform: rotate(-51deg);
  border-left: 23px solid transparent;
  border-right: 30px solid transparent;
  border-top: 30px solid #fff;
}
.chat-bar-close .close::after {
  position: absolute;
  content: "";
  top: 27px;
  left: 23px;
  transform: rotate(-55deg);
  border-left: 24px solid transparent;
  border-right: 29px solid transparent;
  border-top: 31px solid #fff;
}

/* chat window 1 */
.chat-window {
  width: 332px;
  height: 280px;
  border-radius: 10px;
  background-color: #fff;
  padding: 16px;
  z-index: 9999999;
  position: fixed;
  bottom: 120px;
  right: 54px;
  display: none;
  box-shadow: rgb(0 0 0 / 10%) 0px 1px 6px, rgb(0 0 0 / 20%) 0px 2px 24px;
}
.hi-there {
  background-color: #7f8ac5;
  color: #fff;
  padding: 20px 30px;
  border-radius: 5px;
}
.hi-there .p1 {
  font-size: 20px;
}
.hi-there .p2 {
  font-size: 13px;
}
.chat-window .start-conversation {
  padding: 15px 24px;
}
.chat-window .start-conversation h1 {
  font-size: 15px;
}
.chat-window .start-conversation p {
  font-size: 12px;
}
.chat-window .start-conversation button {
  cursor: pointer;
  border: none;
  border-radius: 20px;
  padding: 7px 30px;
  margin: 10px 0px;
  background-color: #13a884;
  color: white;
}
.chat-window .start-conversation button span {
  font-size: 14px;
}
.chat-window .start-conversation button i {
  font-size: 16px;
  position: relative;
  left: 6px;
  top: 3px;
}

/* chat window 2 */
.chat-window2 {
  display: none;
  width: 332px;
  height: 434px;
  border-radius: 10px;
  background-color: #fff;
  padding: 16px;
  z-index: 9999999;
  position: fixed;
  bottom: 120px;
  right: 54px;
  box-shadow: rgb(0 0 0 / 10%) 0px 1px 6px, rgb(0 0 0 / 20%) 0px 2px 24px;
}
.chat-window2 .hi-there .p2 {
  font-size: 12px;
}
.message-box {
  height: 316px;
  width: 100%;
  padding-right: 5px;
  overflow: auto;
}
.message-box .first-chat {
  width: 200px;
  float: right;
  background-color: #4c5aa1;
  padding: 10px;
  margin: 14px 0px;
  border-radius: 5px;
  color: white;
}
.message-box .first-chat p {
  font-size: 12px;
  overflow-wrap: break-word;
}
.message-box .first-chat .arrow {
  content: "";
  width: 0px;
  height: 0px;
  border-left: 9px solid transparent;
  border-right: 9px solid #4c5aa1;
  border-top: 9px solid #4c5aa1;
  border-bottom: 9px solid transparent;
  right: -172px;
  bottom: -23px;
  position: relative;
  margin-top: -15px;
}

.message-box .second-chat {
  display: inline-block;
}

.message-box .second-chat .circle {
  background-color: #4c5aa1;
  height: 30px;
  width: 30px;
  border-radius: 50%;
  float: left;
  padding: 10px;
  margin-top: 10px;
  margin-right: 5px;
}
.message-box .second-chat #circle-mar {
  margin-top: 5px;
}

.message-box .second-chat p {
  font-size: 12px;
  overflow-wrap: break-word;
}
.message-box .second-chat p {
  width: 200px;
  float: left;
  background-color: #ecf1fb;
  padding: 12px;
  margin: 0px 5px;
  border-radius: 10px;
  color: #000;
}
.message-box .second-chat .arrow {
  content: "";
  width: 0px;
  height: 0px;
  border-right: 9px solid transparent;
  border-left: 9px solid #ecf1fb;
  border-top: 12px solid #ecf1fb;
  border-bottom: 9px solid transparent;
  margin-left: 40px;
  margin-top: -2%;
  display: inline-block;
}

.chat-window2 .input-box {
  position: absolute;
  font-size: 12px;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 0px 30px;
  padding-bottom: 18px;
  border-top: 1px solid lightgray;
}
.chat-window2 .input-box .write-reply {
  float: left;
}
.chat-window2 .input-box .write-reply input[type="text"] {
  border: none;
  outline: none;
  font-size: 14px;
}
.chat-window2 .input-box .send-button {
  float: right;
  border: none;
  outline: none;
}
.chat-window2 .input-box .send-button button {
  border: none;
  background-color: transparent;
  cursor: pointer;
  outline: none;
}
.chat-window2 .input-box .send-button button i {
  color: grey;
  font-size: 20px;
  font-weight: bold;
}
.chat-window2 .input-box .surveysparrow img {
  width: 15px;
  margin-bottom: -4px;
}
.chat-window2 .input-box .surveysparrow p {
  display: inline;
  font-size: 10px;
  color: #636262;
}
.chat-window2 .input-box .surveysparrow {
  position: relative;
  bottom: 28px;
  right: -65px;
}

/* RESPONSIVE */
@media screen and (max-width: 396px) {
  .chat-window {
    right: 14px;
    bottom: 87px;
  }
  .hi-there {
    padding: 12px 30px;
  }
  .chat-window2 {
    right: 14px;
    bottom: 87px;
    height: 420px;
  }
  .chat-bar-open {
    bottom: 20px;
    right: 21px;
  }
  .chat-bar-close {
    bottom: 21px;
    right: 25px;
  }
  .message-box .second-chat .arrow {
  margin-left:41px;
  }
  /* Chat interface */
#chat-window1 {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000; /* Set a higher z-index */
}
.message-item {
  position: relative;
}

.edit-delete-buttons {
  position: absolute;
  left: 0;
  top: 0;
  display: none;
}

.message-item:hover .edit-delete-buttons {
  display: block;
}
}

</style>
</head>
<body>
    <div class="chat-bar-open" id="chat-open">
      <button
        id="chat-open-button"
        type="button"
        class="collapsible close"
      >
        <i class="fas fa-comment-alt"></i>
      </button>
    </div>

    <!-- chat close -->
    <div class="chat-bar-close" id="chat-close">
      <button
        id="chat-close-button"
        type="button"
        class="collapsible close"
      >
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- chat-window 1 -->
    <div class="chat-window" id="chat-window1">
      <div class="hi-there">
        <p class="p1">Hi There</p>
        <br />
        <p class="p2">Hello Ask Us Anythig, Share Your<br />Feedback.</p>
      </div>
      <div class="start-conversation">
        <h1>Start a Conversation</h1>
        <br />
        <p>The team typically replies in few minutes.</p>
        <button
          class="new-conversation"
          type="button"
        >
          <span>New Conversation</span
          ><i class="fas fa-paper-plane"></i>
        </button>
      </div>
    </div>

    <!-- chat chat-window 2 -->
    <div class="chat-window2" id="chat-window2">
      <div class="message-box" id="messageBox">
        <div class="hi-there">
          <p class="p1">Hi There</p>
          <br />
          <p class="p2">The team typically replies in few minutes.</p>
        </div>
        <div class="first-chat" id="message_<?php echo $messageID; ?>">
    <div class="edit-delete-buttons">
        <button class="btn btn-sm btn-outline-primary edit-button" title="Edit"><i class="bi bi-pencil-square"></i></button>
        <button class="btn btn-sm btn-outline-danger delete-button" title="Delete"><i class="bi bi-trash"></i></button>
    </div>
    <div class="message-content">
        <p><?php echo $messageContent; ?></p>
    </div>
    <div class="arrow"></div>
</div>
        <div class="second-chat">
          <div class="circle"></div>
          <p>Currently we don't have but we will launch soon.</p>
          <div class="arrow"></div>
        </div>
      </div>
      <div class="input-box">
        
        <div class="write-reply">
          <input
            class="inputText"
            id="textInput"
            placeholder="Write a reply..."
          />
        </div>
        <div class="send-button">
          <button
            type="submit"
            class="send-message"
            id="send"
          >
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
      </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
  let audio1 = new Audio("https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/clickUp.mp3");

  $("#chat-open-button").click(function () {
    $("#chat-open").hide();
    $("#chat-close").show();
    $("#chat-window1").show();
    audio1.load();
    audio1.play();
  });

  $("#chat-close-button").click(function () {
    $("#chat-open").show();
    $("#chat-close").hide();
    $("#chat-window1").hide();
    $("#chat-window2").hide();
    audio1.load();
    audio1.play();
  });

  $(".new-conversation").click(function () {
    $("#chat-window2").show();
    $("#chat-window1").hide();
    audio1.load();
    audio1.play();
  });

  $("#send").click(function () {
    userResponse();
  });

  // Press Enter key to send message
  $("#textInput").keypress(function (event) {
    if (event.key === "Enter") {
      userResponse();
    }
  });

  //admin Respononse to user's message
  function adminResponse() {
    // Write your admin response logic here
  }

  //press enter on keyboard and send message
  $(document).keypress(function (e) {
    if (e.keyCode === 13) {
      const focusedElement = document.activeElement;
      if (focusedElement && focusedElement.id === "textInput") {
        userResponse();
      }
    }
  });

  // Function to fetch and display messages
  function fetchMessages() {
    const url = "fetchMessage.php";

    fetch(url, {
      method: "GET",
      credentials: "include",
      mode: "cors",
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("HTTP error " + response.status);
        }
        return response.json();
      })
      .then((data) => {
        if (data.status === "success") {
          var messages = data.messages;
          var messageBox = $("#messageBox");
          messageBox.empty();
          messages.forEach(function (message) {
            messageBox.append(`
              <div class="first-chat message-item" id="message_${message.MessageID}">
                <div class="message-content">
                  <p>${message.MessageContent}</p>
                </div>
                <div class="arrow"></div>
              </div>
            `);
          });
          messageBox.scrollTop(messageBox[0].scrollHeight);

          // Add the edit and delete buttons after the messageBox
          const editDeleteButtons = $(".edit-delete-buttons");
          messageBox.after(editDeleteButtons);
        } else {
          alert("Failed to fetch messages. Error: " + data.message);
        }
      })
      .catch((error) => {
        if (error.name === "TypeError" && error.message.includes("Failed tofetch")) {
          alert("Network error. Please check your connection and try again.");
        } else {
          alert("Fetch error: " + error.message);
        }
      });
  }

  setInterval(fetchMessages, 5000);

  function userResponse() {
    let userText = $("#textInput").val().trim(); // Retrieve message content from input field

    if (userText === "") {
      alert("Please type something!");
    } else {
      $.ajax({
        type: "POST",
        url: "sendMessage.php",
        data: { messageContent: userText }, // Send message content in AJAX request
        success: function (response) {
          var jsonResponse = JSON.parse(response);
          if (jsonResponse.status === "success") {
            // Update UI with sent message
            let messageBox = $("#messageBox");
            messageBox.append(`
              <div class="first-chat message-item">
                <div class="circle"></div>
                <p>${userText}</p>
                <div class="arrow"></div>
              </div>
            `);

            // Scroll to the bottom of the message box
            messageBox.scrollTop(messageBox[0].scrollHeight);
          } else {
            alert("Failed to send message. Error: " + response);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error sending message:", error);
          alert("Failed to send message. Please try again later.");
        }
      });
    }

    // Clear input field after sending message
    $("#textInput").val("");
  }
});
</script>

</body>
</html>

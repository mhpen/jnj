<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required parameters are set
    if (isset($_POST['selectedMethod']) && isset($_FILES['attachment']) && isset($_POST['orderID'])) {
        // Extract the parameters
        $selectedMethod = $_POST['selectedMethod'];
        $orderID = $_POST['orderID']; // Change $_GET to $_POST for orderID
        
        // Debugging: Print orderID to see if it's received correctly
        echo "OrderID: " . $orderID . "<br>";

        // Process the attachment
        $targetDir = "../client/uploads/"; // Directory where the attachments will be stored
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($_FILES["attachment"]["name"], PATHINFO_EXTENSION));
        $targetFile = $targetDir . $orderID . '.jpg'; // Convert all images to JPEG format

        // Check if the file is an actual image
        $check = getimagesize($_FILES["attachment"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["attachment"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Convert the image to JPEG format
            if ($imageFileType != "jpg") {
                $sourceImage = $_FILES["attachment"]["tmp_name"];
                $destinationImage = $targetDir . $orderID . '.jpg';
                if (imagejpeg(imagecreatefromstring(file_get_contents($sourceImage)), $destinationImage)) {
                    $targetFile = $destinationImage;
                } else {
                    echo "Error converting image to JPEG format.";
                    $uploadOk = 0;
                }
            }

            // If everything is ok, try to upload file
            if ($uploadOk == 1 && move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFile)) {
                // File uploaded successfully, now insert payment record into the database
                // Perform database connection here and insert the payment record
                $host = 'localhost';
                $dbname = 'jnjgiftsgalore_db';
                $username = 'root';
                $password = '';

                // Create connection
                $conn = new mysqli($host, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Insert payment record into the database
                $stmt = $conn->prepare("INSERT INTO payment (OrderID, PaymentMethod, PaymentStatus, PaymentAttachment) VALUES (?, ?, 'Pending', ?)");
                $stmt->bind_param("sss", $orderID, $selectedMethod, $targetFile);

                if ($stmt->execute()) {
                    echo "Payment submitted successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "Missing parameters.";
    }
} else {
    echo "Invalid request method.";
}
?>
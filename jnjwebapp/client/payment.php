<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J&J Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Retail styles */
        .body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            position: relative;
        }

        .payment-container {
            background-color: white;
            display: flex;
            position: relative;
        }

        .payment-left-col {
            margin-left: 30px;
            margin-right: 20px;
            margin-top: 100px;
            width: 50%;
        }

        .payment-left-col h6 {
            font-family: Poppins;
            font-size: 16px;
            font-weight: 400;
        }

        .payment-left-col p {
            font-family: Poppins;
            font-size: 16px;
            font-weight: 400;
            padding-left: 40px;
            line-height: 1;
        }

        .payment-right-col {
            flex: 1;
            background-color: rgba(240, 240, 240, 0.5);
            height: 822px;
        }

        .drop-screenshot {
            background-color: rgba(229, 229, 229, 0.5);
            position: absolute;
            width: 450px;
            height: 300px;
            margin-top: 145px;
            margin-left: 120px;
            border-radius: 10px;
            border: 1px solid #CDCDCD;
            background-image: url(img/attached\ 1.png);
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .drop-screenshot p {
            font-family: 'Montserrat', sans-serif;
            font-size: 24px;
            width: 300px;
            text-align: center;
            padding-left: 70px;
            padding-top: 100px;
        }

        .drop-screenshot:hover {
            background-color: rgba(229, 229, 229, 0.8);
        }

        .drop-screenshot input[type="file"] {
            display: none;
        }

        .drop-screenshot label {
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
        }

        .submit-button .submit {
            font-family: Poppins;
            font-size: 16px;
            font-weight: 400;
            background-color: #483B2B;
            text-decoration: none;
            color: white;
            padding-top: 15px;
            padding-bottom: 15px;
            padding-left: 200px;
            padding-right: 200px;
            position: absolute;
            margin-top: 500px;
            margin-left: 120px;
            text-align: center;
            border-radius: 5px;
        }

        .submit-button .submit:hover {
            background-color: rgba(72, 59, 43, 0.8);
        }

        /* Dropdown modal styles */
        .modal-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            backdrop-filter: blur(8px); /* Apply blur effect to the background */
        }

        .modal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            z-index: 9999;
        }

        .modal-content {
            text-align: center;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            cursor: pointer;
        }

        .close-button:hover {
            color: red;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-left-col">
            <h6>PAYMENT PROCESS</h6>
            <p>1. Choose a payment method below</p>
            <p>2. Send the payment using your own device</p>
            <p>3. Once sent take a screenshot</p>
            <p>4. Input the screenshot or attachment on right side of the screen</p>
            <p>5. Just wait for the confirmation if the payment is received</p>
            
            <h6>CHOOSE PAYMENT METHOD</h6>
            
            <button onclick="openModal('gcashModal')">GCash</button>
            <button onclick="openModal('paypalModal')">PayPal</button>

            <!-- GCash Modal -->
            <div id="gcashModal" class="modal-container">
                <div class="modal">
                    <span class="close-button" onclick="closeModal('gcashModal')">&times;</span>
                    <div class="modal-content">
                        <img src="gcash_image.jpg" alt="GCash Logo">
                        <p>GCash is a mobile wallet app in the Philippines. You can use it for various transactions such as bills payment, money transfer, and online shopping.</p>
                    </div>
                </div>
            </div>

            <!-- PayPal Modal -->
            <div id="paypalModal" class="modal-container">
                <div class="modal">
                    <span class="close-button" onclick="closeModal('paypalModal')">&times;</span>
                    <div class="modal-content">
                        <img src="paypal_image.jpg" alt="PayPal Logo">
                        <p>PayPal is a popular online payment platform that allows users to make purchases, transfer money, and more securely online.</p>
                    </div>
                </div>
            </div>

            <!-- Drop file section -->
            
        </div>

        <div class="payment-right-col">
        <div class="drop-screenshot" onclick="document.getElementById('fileInput').click()">
                <input type="file" id="fileInput" style="display:none;" onchange="handleFileUpload()">
                <label for="fileInput">Click here or drop file</label>
            </div>
            <div class="submit-button">
                <a href="#" class="submit">SUBMIT</a>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "block";
        }

        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
        }

        function handleFileUpload() {
            var fileInput = document.getElementById('fileInput');
            var file = fileInput.files[0];
            // You can implement your logic to handle the file upload here
            console.log("File selected:", file);
        }
    </script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J&J Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .payment-method-container {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .payment-method {
            border: 2px solid #CDCDCD;
            margin-right: 30px;
            border-radius: 10px;
            width: 200px;
            height: 200px;
            margin-bottom: 20px;
            cursor: pointer;
            background-color: #ffffff;
        }

        .payment-method:hover {
            border-color: #333333;
        }

        .selected-payment {
            border-color: #333333;
        }

        .payment-method img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 10px;
        }

        .drop-screenshot {
            background-color: rgba(229, 229, 229, 0.5);
            width: 450px;
            height: 300px;
            border-radius: 10px;
            border: 1px solid #CDCDCD;
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
            text-align: center;
            border-radius: 5px;
        }

        .submit-button .submit:hover {
            background-color: rgba(72, 59, 43, 0.8);
        }

        #modal-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: none;
  transition: filter 0.3s ease-in-out;
}

#modal {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.blur {
  filter: blur(2px);
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

        /* Error message styles */
        .error-message {
            color: red;
            margin-top: 20px;
            padding-left: 20px;
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
            <p>4. Input the screenshot or attachment on the right side of the screen</p>
            <p>5. Just wait for the confirmation if the payment is received</p>
            
            <h6>CHOOSE PAYMENT METHOD</h6>
            
            <div class="payment-method-container">
                <div class="payment-method" id="gcashMethod" onclick="openModal('gcashModal'); selectPaymentMethod('gcash')">
                    <img src="gcash_logo.png" alt="GCash Logo">
                </div>

                <div class="payment-method" id="paypalMethod" onclick="openModal('paypalModal'); selectPaymentMethod('paypal')">
                    <img src="paypal_logo.png" alt="PayPal Logo">
                </div>
            </div>
            
        </div>

        <div class="payment-right-col">
            <div class="drop-screenshot" onclick="document.getElementById('fileInput').click()">
                <input type="file" id="fileInput" style="display:none;" onchange="handleFileUpload()">
                <label for="fileInput" id="fileInputLabel">Click here or drop file</label>
            </div>
            <div id="uploadedImage" class="mt-3"></div>
            <button id="deleteImageButton" class="btn btn-danger mt-3" style="display: none;" onclick="deleteImage()">Delete Image</button>
            <div id="orderDetails" class="error-message mt-3"></div>
            <div class="submit-button mt-3">
                <a href="#" class="submit">SUBMIT</a>
            </div>
        </div>
    </div>
<!-- GCash Modal -->
<div class="modal" id="gcashModal" tabindex="-1" aria-labelledby="gcashModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gcashModalLabel">GCash</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="gcash_image.jpg" alt="GCash Logo">
        <p>GCash is a mobile wallet app in the Philippines. You can use it for various transactions such as bills payment, money transfer, and online shopping.</p>
      </div>
    </div>
  </div>
</div>

<!-- PayPal Modal -->
<div class="modal" id="paypalModal" tabindex="-1" aria-labelledby="paypalModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paypalModalLabel">PayPal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="paypal_image.jpg" alt="PayPal Logo">
        <p>PayPal is a popular online payment platform that allows users to make purchases, transfer money, and more securely online.</p>
      </div>
    </div>
  </div>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
         function submitPayment() {
        var selectedMethod = document.getElementById('selectedPaymentMethod').value;
        var attachment = document.getElementById('fileInput').files[0];

        var formData = new FormData();
        formData.append('selectedMethod', selectedMethod);
        formData.append('attachment', attachment);

        $.ajax({
            type: 'POST',
            url: 'process_payment.php', // Replace with your server-side script URL
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle success response
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    }

    // Update the selected payment method input value
    function selectPaymentMethod(method) {
        document.getElementById('selectedPaymentMethod').value = method;
    }
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
            displayImage(file);
        }
        $(document).ready(function() {
    $('#gcashMethod').on('click', function() {
      $('#gcashModal').modal('show');
    });

    $('#paypalMethod').on('click', function() {
      $('#paypalModal').modal('show');
    });
  });

        function displayImage(file) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var imgSrc = event.target.result;
                document.getElementById('fileInputLabel').innerHTML = '<img src="' + imgSrc + '" style="max-width: 100%; max-height: 100%;">';
                document.getElementById('deleteImageButton').style.display = "block";
            }
            reader.readAsDataURL(file);
        }

        function deleteImage() {
            document.getElementById('fileInputLabel').innerHTML = 'Click here or drop file';
            document.getElementById('deleteImageButton').style.display = "none";
        }

        function selectPaymentMethod(method) {
            if (method === 'gcash') {
                document.getElementById('gcashMethod').classList.add('selected-payment');
                document.getElementById('paypalMethod').classList.remove('selected-payment');
            } else if (method === 'paypal') {
                document.getElementById('paypalMethod').classList.add('selected-payment');
                document.getElementById('gcashMethod').classList.remove('selected-payment');
            }
        }
    </script>
</body>
</html>
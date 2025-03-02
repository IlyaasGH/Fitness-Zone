<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'fitnesszone');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['membershipid']) || !isset($_SESSION['package']) || !isset($_SESSION['amount'])) {
    header("Location: payment.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardNumber = $_POST['card_number'];
    $cardHolder = $_POST['card_holder'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];

    $membershipid = $_SESSION['membershipid'];
    $package = $_SESSION['package'];
    $amount = $_SESSION['amount'];

    $duration = 0;
    if (strpos($package, "1 Month") !== false) $duration = 1;
    elseif (strpos($package, "3 Months") !== false) $duration = 3;
    elseif (strpos($package, "6 Months") !== false) $duration = 6;
    elseif (strpos($package, "1 Year") !== false) $duration = 12;

    $expiryDate = date('Y-m-d', strtotime("+$duration months"));

    $sql = "INSERT INTO payment (membership_id, package, amount, expiry_date, card_number, card_holder_name) 
            VALUES ('$membershipid', '$package', '$amount', '$expiryDate', '$cardNumber', '$cardHolder')";
    if ($conn->query($sql) === TRUE) {

        header("Location: details.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .input-field {
            margin-bottom: 20px;
        }

        .input-field input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .submit-btn {
            background-color: orangered;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: orange;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="heading text-2xl">Enter Payment Details</h2>
        <form method="POST" action="">
            <div class="input-field">
                <label for="card_number" class="form-label">Card Number</label>
                <input type="text" id="card_number" name="card_number" placeholder="Enter your card number" required>
            </div>
            <div class="input-field">
                <label for="card_holder" class="form-label">Card Holder Name</label>
                <input type="text" id="card_holder" name="card_holder" placeholder="Enter card holder's name" required>
            </div>
            <div class="input-field">
                <label for="expiry" class="form-label">Expiration Date</label>
                <input type="month" id="expiry" name="expiry" required>
            </div>
            <div class="input-field">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="Enter CVV" required>
            </div>
            <button type="submit" class="submit-btn">Proceed to Payment</button>
        </form>
    </div>
</body>

</html>
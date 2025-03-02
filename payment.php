<?php
session_start();

if (!isset($_SESSION['membershipid'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $package = $_POST['package'];
    $amount = $_POST['amount'];


    $_SESSION['package'] = $package;
    $_SESSION['amount'] = $amount;

    header("Location: card_details.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Package</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .package {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .package h3 {
            margin-top: 0;
            color: #333;
        }

        .package p {
            margin: 5px 0;
            color: #555;
        }

        .package .price {
            font-size: 18px;
            color: red;
            font-weight: bold;
        }

        form {
            flex-direction: column;
            align-items: center;
        }

        button {
            background-color: orangered;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: white;
            font-weight: bolder;
        }

        button:hover {
            background-color: orange;
        }

        input[type="hidden"] {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Select a Membership Package</h2>

        <form method="POST" action="">
            <div class="package">
                <h3>Basic Package (1 Month)</h3>
                <p>Facilities: Gym Access, Cardio, Locker Facility</p>
                <p class="price">Price: Rs. 1,000</p>
                <input type="hidden" name="package" value="Basic (1 Month)">
                <input type="hidden" name="amount" value="1000">
                <button type="submit">Choose Basic Package</button>
            </div>
        </form>

        <form method="POST" action="">
            <div class="package">
                <h3>Standard Package (3 Months)</h3>
                <p>Facilities: Gym Access, Cardio, Locker Facility, Group Classes</p>
                <p class="price">Price: Rs. 2,500</p>
                <input type="hidden" name="package" value="Standard (3 Months)">
                <input type="hidden" name="amount" value="2500">
                <button type="submit">Choose Standard Package</button>
            </div>
        </form>

        <form method="POST" action="">
            <div class="package">
                <h3>Premium Package (6 Months)</h3>
                <p>Facilities: Gym Access, Cardio, Locker Facility, Group Classes, Personal Trainer</p>
                <p class="price">Price: Rs. 4,500</p>
                <input type="hidden" name="package" value="Premium (6 Months)">
                <input type="hidden" name="amount" value="4500">
                <button type="submit">Choose Premium Package</button>
            </div>
        </form>

        <form method="POST" action="">
            <div class="package">
                <h3>Ultimate Package (1 Year)</h3>
                <p>Facilities: Gym Access, Cardio, Locker Facility, Group Classes, Personal Trainer, Free Diet Consultation</p>
                <p class="price">Price: Rs. 8,000</p>
                <input type="hidden" name="package" value="Ultimate (1 Year)">
                <input type="hidden" name="amount" value="8000">
                <button type="submit">Choose Ultimate Package</button>
            </div>
        </form>
        <div>
            <h4>If you have Already Paid Press The Details Button</h4>
            <button>
                <a href="details.php">Detais Page</a>
            </button>
        </div>
    </div>
</body>

</html>
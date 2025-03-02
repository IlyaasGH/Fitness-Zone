<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'fitnesszone');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (!isset($_SESSION['membershipid'])) {
    echo "<script>alert('Unauthorized access. Please log in.');</script>";
    header("Location: login.php");
    exit();
}


$membership_id = $_SESSION['membershipid'];


$stmt = $conn->prepare("SELECT * FROM payment WHERE membership_id = ? ORDER BY payment_date DESC LIMIT 1");
$stmt->bind_param("s", $membership_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $payment = $result->fetch_assoc();
    $expiry_date = $payment['expiry_date'];
    $package = $payment['package'];
} else {

    $expiry_date = null;
    $package = null;
    $facilities = [];
}


$facilities = [];
switch ($package) {
    case "1 Month":
        $facilities = ["Access to Gym", "1 Free Personal Training Session", "Group Classes"];
        break;
    case "3 Months":
        $facilities = ["Access to Gym", "3 Free Personal Training Sessions", "Group Classes", "Spa Access"];
        break;
    case "6 Months":
        $facilities = ["Access to Gym", "6 Free Personal Training Sessions", "Group Classes", "Spa Access", "Nutrition Consultation"];
        break;
    case "1 Year":
        $facilities = ["Access to Gym", "Unlimited Personal Training Sessions", "Group Classes", "Spa Access", "Nutrition Consultation", "Exclusive Member Events"];
        break;
    default:
        $facilities = ["No facilities available for this package."];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
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

        .details {
            margin-bottom: 20px;
        }

        .facilities ul {
            list-style-type: none;
            padding: 0;
        }

        .facilities ul li {
            background-color: #e2e8f0;
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
        }

        .countdown {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="heading text-2xl">Membership Details</h2>

        <div class="details">
            <p><strong>Package:</strong> <?php echo $package ? $package : "No active package."; ?></p>
            <p><strong>Expiry Date:</strong> <?php echo $expiry_date ? date("F j, Y", strtotime($expiry_date)) : "Not available."; ?></p>
        </div>

        <div class="facilities">
            <h3 class="text-xl font-semibold">Facilities Included with Your Package</h3>
            <ul>
                <?php foreach ($facilities as $facility) : ?>
                    <li><?php echo $facility; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="countdown" id="countdown-timer">
        </div>

        <script>
            const expiryDate = "<?php echo $expiry_date; ?>";

            if (expiryDate) {
                const expiryDateTime = new Date(expiryDate).getTime();

                const countdown = setInterval(function() {
                    const now = new Date().getTime();
                    const timeLeft = expiryDateTime - now;

                    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    if (timeLeft > 0) {
                        document.getElementById("countdown-timer").innerHTML =
                            `Your membership will expire in ${days}d ${hours}h ${minutes}m ${seconds}s.`;
                    } else {
                        document.getElementById("countdown-timer").innerHTML = "Your membership has expired. Please renew it.";
                        clearInterval(countdown);
                    }
                }, 1000);
            } else {
                document.getElementById("countdown-timer").innerHTML = "No active membership found.";
            }
        </script>

</body>

</html>
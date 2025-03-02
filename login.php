<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'fitnesszone');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $membershipId = $_POST['membershipid'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE member_id = ?");
    $stmt->bind_param("s", $membershipId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password == $user['password']) {
            session_regenerate_id();
            $_SESSION['membershipid'] = $membershipId;
            $_SESSION['name'] = $user['name'];
            header("Location: payment.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Membership ID not found. Please check your details.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            background-image: url(https://images.unsplash.com/photo-1507398941214-572c25f4b1dc?q=80&w=1973&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            width: 400px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            opacity: 0.9;
            text-align: center;
        }

        .form-container input,
        .form-container button {
            width: 97%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 97%;
            background-color: orangered;
            color: white;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: orange;
        }
    </style>
</head>

<body>
    <form class="form-container" method="POST" action="">
        <h2>Login</h2>
        <input type="text" name="membershipid" placeholder="Membership ID" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>

</html>
<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'fitnesszone');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT u_membershipid FROM user ORDER BY u_membershipid DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastMembershipId = $row['u_membershipid'];
    $numericPart = intval(substr($lastMembershipId, 1));
    $newMembershipId = 'M' . str_pad($numericPart + 1, 5, '0', STR_PAD_LEFT);
} else {
    $newMembershipId = 'M00001';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO user (u_membershipid, u_firstname, u_lastname, u_age, u_dob, u_gender, u_email, u_password)
            VALUES ('$newMembershipId', '$firstname', '$lastname', '$age', '$dob', '$gender', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully.<br>";

        $insertQuery = "
            INSERT INTO users (member_id, password, name)
            SELECT 
                u_membershipid AS member_id, 
                u_password AS password, 
                CONCAT(u_firstname, ' ', u_lastname) AS name
            FROM user
            WHERE u_membershipid = '$newMembershipId';
        ";

        if ($conn->query($insertQuery) === TRUE) {
            echo "User data transferred to 'users' table successfully.";
            header("Location: login.php");
            exit();
        } else {
            echo "Error transferring data to 'users' table: " . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: whitesmoke;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .registration-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: orangered;
            margin-bottom: 15px;
        }

        input,
        select {
            width: 95%;
            padding: 10px;
            margin: 8px 0;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        button {
            background-color: orangered;
            color: white;
            padding: 12px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: orange;
        }
    </style>
</head>

<body>
    <div class="registration-container">
        <h2>Register Here</h2>
        <form method="POST" action="">
            <div>
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" placeholder="Enter First Name" required>
            </div>
            <div>
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" placeholder="Enter Last Name" required>
            </div>
            <div>
                <label for="age">Age</label>
                <input type="number" name="age" id="age" placeholder="Enter Age" required>
            </div>
            <div>
                <label for="dob">Date of Birth</label>
                <input type="date" name="dob" id="dob" required>
            </div>
            <div>
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter Email" required>
            </div>
            <div>
                <label for="membershipid">Membership ID</label>
                <input type="text" name="membershipid" id="membershipid" value="<?php echo $newMembershipId; ?>" readonly>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter Password" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>
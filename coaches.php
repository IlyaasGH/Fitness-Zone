<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'fitnesszone';

$conn = mysqli_connect($host, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$query = "SELECT c_firstname, c_lastname, c_age, c_email, c_gender, c_specialization FROM coach";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Coaches</title>
    <link rel="stylesheet" href="style.css">
</head>

<body bgcolor="black">
    <header>
        <h1>Meet Our Coaches</h1>
        <a href="index.html">Back to Home</a>
    </header>
    <section class="coach-list">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <ul>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <li>
                        <h2><?php echo $row['c_firstname'] . " " . $row['c_lastname']; ?></h2>
                        <p><strong>Age:</strong> <?php echo $row['c_age']; ?></p>
                        <p><strong>Email:</strong> <?php echo $row['c_email']; ?></p>
                        <p><strong>Gender:</strong> <?php echo ucfirst($row['c_gender']); ?></p>
                        <p><strong>Specialization:</strong> <?php echo ucfirst($row['c_specialization']); ?></p>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No coaches available.</p>
        <?php endif; ?>

        <?php

        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
    </section>
</body>

</html>
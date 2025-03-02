<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'fitnesszone');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getAvailableSlots($conn, $date)
{
    $allSlots = [
        '10:00 AM',
        '10:30 AM',
        '11:00 AM',
        '11:30 AM',
        '12:00 PM',
        '12:30 PM',
        '1:00 PM',
        '1:30 PM',
        '2:00 PM',
        '2:30 PM',
        '3:00 PM',
        '3:30 PM'
    ];

    $bookedSlots = [];

    $stmt = $conn->prepare("SELECT time FROM Appointment WHERE date = ?");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $bookedSlots[] = $row['time'];
    }

    $stmt->close();

    return array_diff($allSlots, $bookedSlots);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'book') {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $stmt = $conn->prepare("INSERT INTO Appointment (name, date, time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $date, $time);

    if ($stmt->execute()) {
        $message = "Your appointment has been booked. Our staff will call to confirm later today.";
    } else {
        $message = "Error booking appointment. Please try again.";
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'get_slots') {
    $date = $_POST['date'];
    $availableSlots = getAvailableSlots($conn, $date);
    echo json_encode(array_values($availableSlots));
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
        }

        .form-container input,
        .form-container select,
        .form-container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: orangered;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: orange;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Book an Appointment</h2>

        <?php if (!empty($message)) {
            echo "<div class='message'>$message</div>";
        } ?>

        <form method="POST" action="">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="date" name="date" id="date" required min="<?php echo date('Y-m-d'); ?>">

            <select name="time" id="time" required>
                <option value="">Select Time</option>
            </select>

            <input type="hidden" name="action" value="book">
            <button type="submit">Book Appointment</button>
        </form>
    </div>

    <script>
        document.getElementById('date').addEventListener('change', function() {
            const date = this.value;
            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'get_slots',
                        date: date
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const timeSelect = document.getElementById('time');
                    timeSelect.innerHTML = '<option value="">Select Time</option>';

                    data.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot;
                        option.textContent = slot;
                        timeSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        });
    </script>
</body>

</html>
<?php

session_start();

if (!isset($_SESSION['staff_name'])) {
    $_SESSION['staff_name'] = 'John Doe'; // Example
    $_SESSION['staff_email'] = 'john.doe@example.com';
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "fitnesszone";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_staff = "SELECT username, email FROM staff WHERE id = 1";
$result_staff = $conn->query($sql_staff);

if ($result_staff && $result_staff->num_rows > 0) {
    $staff = $result_staff->fetch_assoc();
    $_SESSION['staff_name'] = $staff['username'];
    $_SESSION['staff_email'] = $staff['email'];
} else {
    $_SESSION['staff_name'] = "Unknown Staff";
    $_SESSION['staff_email'] = "unknown@example.com";
}

$sql_total = "SELECT COUNT(*) AS total FROM Appointment";
$result_total = $conn->query($sql_total);
$total_appointments = $result_total->fetch_assoc()['total'];

$sql_today = "SELECT COUNT(*) AS total FROM Appointment WHERE date = CURDATE()";
$result_today = $conn->query($sql_today);
$today_appointments = $result_today->fetch_assoc()['total'];

$sql_week = "SELECT COUNT(*) AS total FROM Appointment WHERE YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)";
$result_week = $conn->query($sql_week);
$week_appointments = $result_week->fetch_assoc()['total'];

$sql_upcoming = "SELECT id, name, date, time FROM Appointment WHERE date >= CURDATE() ORDER BY date, time LIMIT 5";
$result_upcoming = $conn->query($sql_upcoming);

$upcoming_appointments = [];
if ($result_upcoming->num_rows > 0) {
    while ($row = $result_upcoming->fetch_assoc()) {
        $upcoming_appointments[] = $row;
    }
}

$appointments_data = [];
$fees_data = [];
$registrations_data = [];
$days = [];

for ($i = 1; $i <= date('t'); $i++) {
    $day = date('Y-m') . '-' . sprintf('%02d', $i);
    $days[] = $i;

    $sql_day = "SELECT COUNT(*) AS total FROM Appointment WHERE date = '$day'";
    $result_day = $conn->query($sql_day);
    $appointments_data[] = $result_day->fetch_assoc()['total'];

    $sql_fees = "SELECT SUM(amount) AS total FROM payment WHERE payment_date LIKE '$day%'";
    $result_fees = $conn->query($sql_fees);
    $fees_data[] = $result_fees->fetch_assoc()['total'] ?? 0; // Default to 0 if no records

    $registrations_data[] = $appointments_data[count($appointments_data) - 1];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #b8a59d;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px 20px;
        }

        .header h1 {
            margin: 0;
        }

        .dashboard-container {
            margin: 20px;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .metrics {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .metric-card {
            flex: 1;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .metric-card h2 {
            font-size: 36px;
            margin: 10px 0;
            color: #28a745;
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        .appointments-table th,
        .appointments-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .appointments-table th {
            background-color: #f4f4f4;
        }

        canvas {
            margin-top: 20px;
            max-width: 600px;
            max-height: 400px;
        }

        .chart-container {
            display: flex;
            gap: 20px;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .chart-card {
            flex: 1;
            min-width: 300px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Staff Dashboard</h1>
        <div class="user-info">
            <p>Welcome, <strong><?= htmlspecialchars($_SESSION['staff_name']); ?></strong>!</p>
            <p>Email: <?= htmlspecialchars($_SESSION['staff_email']); ?></p>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="greeting">
            <p>Hello <?= htmlspecialchars($_SESSION['staff_name']); ?>, here are the latest updates:</p>
        </div>

        <div class="metrics">
            <div class="metric-card">
                <h2><?= $today_appointments; ?></h2>
                <p>Appointments Today</p>
            </div>
            <div class="metric-card">
                <h2><?= $week_appointments; ?></h2>
                <p>Appointments This Week</p>
            </div>
            <div class="metric-card">
                <h2><?= $total_appointments; ?></h2>
                <p>Total Appointments</p>
            </div>
        </div>

        <h2>Upcoming Appointments</h2>
        <table class="appointments-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($upcoming_appointments)): ?>
                    <?php foreach ($upcoming_appointments as $appointment): ?>
                        <tr>
                            <td><?= htmlspecialchars($appointment['id']); ?></td>
                            <td><?= htmlspecialchars($appointment['name']); ?></td>
                            <td><?= htmlspecialchars($appointment['date']); ?></td>
                            <td><?= htmlspecialchars($appointment['time']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No upcoming appointments.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Monthly Overview</h2>
        <div class="chart-container">
            <div class="chart-card">
                <canvas id="appointmentsChart"></canvas>
                <p>Appointments This Month</p>
            </div>
            <div class="chart-card">
                <canvas id="feesChart"></canvas>
                <p>Total Fees This Month</p>
            </div>
            <div class="chart-card">
                <canvas id="registrationsChart"></canvas>
                <p>New Registrations This Month</p>
            </div>
        </div>

        <script>
            const days = <?= json_encode($days); ?>;
            const appointments = <?= json_encode($appointments_data); ?>;
            const fees = <?= json_encode($fees_data); ?>;
            const registrations = <?= json_encode($registrations_data); ?>;

            function createChart(canvasId, label, data, borderColor, bgColor) {
                const ctx = document.getElementById(canvasId).getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: days,
                        datasets: [{
                            label: label,
                            data: data,
                            borderColor: borderColor,
                            backgroundColor: bgColor,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        if (Number.isInteger(value)) {
                                            return value;
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
            }

            createChart('appointmentsChart', 'Appointments', appointments, 'blue', 'rgba(0, 0, 255, 0.1)');
            createChart('feesChart', 'Fees Collected', fees, 'green', 'rgba(0, 255, 0, 0.1)');
            createChart('registrationsChart', 'Registrations', registrations, 'orange', 'rgba(255, 165, 0, 0.1)');
        </script>
</body>

</html>
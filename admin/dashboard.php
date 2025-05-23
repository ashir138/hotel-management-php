<?php
session_start();
include '../config.php';

// Room booking data
$totalBookings = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM roombook"));
$totalRooms = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM room"));
$totalStaff = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM staff"));

// Room type breakdown
$roomTypes = ['Superior Room', 'Deluxe Room', 'Guest House', 'Single Room'];
$typeCounts = [];

foreach ($roomTypes as $type) {
    $result = mysqli_query($conn, "SELECT * FROM roombook WHERE RoomType = '$type'");
    $typeCounts[] = mysqli_num_rows($result);
}

// Profit data for Morris chart
$profitResult = mysqli_query($conn, "SELECT * FROM payment");
$profitData = '';
$totalProfit = 0;

while ($row = mysqli_fetch_array($profitResult)) {
    $profit = $row["finaltotal"] * 0.10;
    $profitData .= "{ date:'" . $row["cout"] . "', profit:" . $profit . " },";
    $totalProfit += $profit;
}

$profitData = rtrim($profitData, ',');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Dashboard</title>
    <link rel="stylesheet" href="./css/dashboard.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Morris.js -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>
<body>

<div class="databox">
    <div class="box roombookbox">
        <h2>Total Bookings</h2>
        <h1><?= $totalBookings ?> / <?= $totalRooms ?></h1>
    </div>
    <div class="box guestbox">
        <h2>Total Staff</h2>
        <h1><?= $totalStaff ?></h1>
    </div>
    <div class="box profitbox">
        <h2>Total Profit</h2>
        <h1><?= number_format($totalProfit) ?> <span>&#8360;</span></h1>
    </div>
</div>

<div class="chartbox">
    <div class="bookroomchart">
        <canvas id="bookroomchart"></canvas>
        <h3 style="text-align: center; margin: 10px 0;">Room Type Distribution</h3>
    </div>
    <div class="profitchart1">
        <div id="profitchart"></div>
        <h3 style="text-align: center; margin: 10px 0;">Profit Over Time</h3>
    </div>
</div>

<!-- Chart.js Doughnut -->
<script>
    const roomLabels = ['Superior Room', 'Deluxe Room', 'Guest House', 'Single Room'];
    const roomCounts = <?= json_encode($typeCounts) ?>;

    const roomChart = new Chart(document.getElementById('bookroomchart'), {
        type: 'doughnut',
        data: {
            labels: roomLabels,
            datasets: [{
                label: 'Room Type',
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderColor: 'black',
                data: roomCounts
            }]
        },
        options: {}
    });
</script>

<!-- Morris.js Bar Chart -->
<script>
Morris.Bar({
    element: 'profitchart',
    data: [<?= $profitData ?>],
    xkey: 'date',
    ykeys: ['profit'],
    labels: ['Profit'],
    hideHover: 'auto',
    stacked: true,
    barColors: ['rgba(75, 192, 192, 1)']
});
</script>

</body>
</html>

<?php
ob_start();
include '../config.php';

$id = $_GET['id'];

$query = "SELECT * FROM payment WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$Name = $row['Name'];
$troom = $row['RoomType'];
$bed = $row['Bed'];
$nroom = $row['NoofRoom'];
$cin = $row['cin'];
$cout = $row['cout'];
$meal = $row['meal'];
$ttot = $row['roomtotal'];
$mepr = $row['mealtotal'];
$btot = $row['bedtotal'];
$fintot = $row['finaltotal'];
$days = $row['noofdays'];

$type_of_room = match ($troom) {
    "Superior Room" => 320,
    "Deluxe Room" => 220,
    "Guest House" => 180,
    "Single Room" => 150,
    default => 0
};

$type_of_bed = match ($bed) {
    "Single" => $type_of_room * 0.01,
    "Double" => $type_of_room * 0.02,
    "Triple" => $type_of_room * 0.03,
    "Quad" => $type_of_room * 0.04,
    default => 0
};

$type_of_meal = match ($meal) {
    "Room only" => 0,
    "Breakfast" => $type_of_bed * 2,
    "Half Board" => $type_of_bed * 3,
    "Full Board" => $type_of_bed * 4,
    default => 0
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - <?= $Name ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
    <style>
        body {
            width: 8.5in;
            margin: auto;
            background: #fff;
            padding: 0.5in;
            font-family: 'Open Sans', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }

        h1 {
            text-transform: uppercase;
            letter-spacing: 3px;
            text-align: center;
            margin-bottom: 30px;
        }

        header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        header address {
            font-style: normal;
            font-size: 0.9em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            background: #eee;
        }

        .logo img {
            max-height: 80px;
        }

        aside {
            font-size: 0.85em;
            text-align: center;
            border-top: 1px dashed #999;
            padding-top: 10px;
        }
    </style>
</head>
<body>

<h1>Invoice</h1>

<header>
    <address>
        <strong>HOTEL BLUE BIRD</strong><br>
        Phone: (+91) 9313346569<br>
        Email: support@bluebird.com
    </address>
    <div class="logo">
        <img src="../image/logo.jpg" alt="Hotel Logo">
    </div>
</header>

<section>
    <strong>Invoice To:</strong><br>
    <?= $Name ?><br><br>

    <table>
        <tr>
            <th>Invoice #</th>
            <td><?= $id ?></td>
            <th>Check-out Date</th>
            <td><?= $cout ?></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Days</th>
                <th>Rate</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $troom ?></td>
                <td><?= $days ?></td>
                <td class="right">₹<?= number_format($type_of_room, 2) ?></td>
                <td><?= $nroom ?></td>
                <td class="right">₹<?= number_format($ttot, 2) ?></td>
            </tr>
            <tr>
                <td><?= $bed ?> Bed</td>
                <td><?= $days ?></td>
                <td class="right">₹<?= number_format($type_of_bed, 2) ?></td>
                <td><?= $nroom ?></td>
                <td class="right">₹<?= number_format($btot, 2) ?></td>
            </tr>
            <tr>
                <td><?= $meal ?></td>
                <td><?= $days ?></td>
                <td class="right">₹<?= number_format($type_of_meal, 2) ?></td>
                <td><?= $nroom ?></td>
                <td class="right">₹<?= number_format($mepr, 2) ?></td>
            </tr>
        </tbody>
    </table>

    <table class="balance">
        <tr>
            <th>Total</th>
            <td class="right">₹<?= number_format($fintot, 2) ?></td>
        </tr>
        <tr>
            <th>Amount Paid</th>
            <td class="right">₹0.00</td>
        </tr>
        <tr class="total">
            <th>Balance Due</th>
            <td class="right">₹<?= number_format($fintot, 2) ?></td>
        </tr>
    </table>
</section>

<aside>
    For any queries, contact us at support@bluebird.com or call +91 9313346569. Thank you for choosing Hotel Blue Bird!
</aside>

</body>
</html>

<?php ob_end_flush(); ?>

<?php
include '../config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: roombook.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM roombook WHERE id = $id");
$reservation = mysqli_fetch_assoc($query);

if (!$reservation || $reservation['stat'] !== 'NotConfirm') {
    header("Location: roombook.php");
    exit();
}

mysqli_query($conn, "UPDATE roombook SET stat = 'Confirm' WHERE id = $id");

$name = $reservation['Name'];
$email = $reservation['Email'];
$roomType = $reservation['RoomType'];
$bed = $reservation['Bed'];
$rooms = (int)$reservation['NoofRoom'];
$meal = $reservation['Meal'];
$cin = $reservation['cin'];
$cout = $reservation['cout'];
$days = (int)$reservation['nodays'];

$basePrice = match($roomType) {
    "Superior Room" => 3000,
    "Deluxe Room" => 2000,
    "Guest House" => 1500,
    default => 1000,
};

$bedMultiplier = match($bed) {
    "Double" => 2,
    "Triple" => 3,
    "Quad" => 4,
    default => 1,
};
$bedCost = ($basePrice * $bedMultiplier) / 100;

$mealMultiplier = match($meal) {
    "Breakfast" => 2,
    "Half Board" => 3,
    "Full Board" => 4,
    default => 0,
};
$mealCost = $bedCost * $mealMultiplier;

$roomTotal = $basePrice * $days * $rooms;
$bedTotal = $bedCost * $days;
$mealTotal = $mealCost * $days;
$finalTotal = $roomTotal + $bedTotal + $mealTotal;

mysqli_query($conn, "INSERT INTO payment (id, Name, Email, RoomType, Bed, NoofRoom, cin, cout, noofdays, roomtotal, bedtotal, meal, mealtotal, finaltotal) VALUES (
    $id, '$name', '$email', '$roomType', '$bed', $rooms, '$cin', '$cout', $days, $roomTotal, $bedTotal, '$meal', $mealTotal, $finalTotal
)");

header("Location: roombook.php");
exit();

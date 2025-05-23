<?php

$host = "localhost";
$user = "root";
$pass = "root";
$db   = "hotelmanagement";

$conn = mysqli_connect($host, $user, $pass, $db, 8889);

if (!$conn) {
    echo "<script>alert('Unable to connect to the database');</script>";
    exit();
}
?>

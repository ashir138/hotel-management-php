<?php
include '../config.php';
session_start();

if (!isset($_SESSION['usermail']) || empty($_SESSION['usermail'])) {
    header("Location: http://localhost/hotelmanage_system/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management – Admin</title>

    <!-- CSS -->
    <link rel="stylesheet" href="./css/admin.css">
    <link rel="stylesheet" href="../css/flash.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- Loading Bar -->
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
</head>
<body>

    <!-- Message for Mobile Users -->
    <div id="mobileview">
        <h5>Admin Panel is not available on mobile. Please use a larger screen.</h5>
    </div>

    <!-- Top Navbar -->
    <nav class="uppernav">
        <div class="logo">
            <img src="../image/hotellogo.png" alt="Hotel Logo" class="bluebirdlogo">
            <p>Hotel Management</p>
        </div>
        <div class="logout">
            <a href="../logout.php">
                <button class="btn btn-primary">Logout</button>
            </a>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidenav">
        <ul>
            <li class="pagebtn active"><img src="../image/icon/dashboard.png" alt=""> Dashboard</li>
            <li class="pagebtn"><img src="../image/icon/bed.png" alt=""> Room Booking</li>
            <li class="pagebtn"><img src="../image/icon/wallet.png" alt=""> Payment</li>
            <li class="pagebtn"><img src="../image/icon/bedroom.png" alt=""> Rooms</li>
            <li class="pagebtn"><img src="../image/icon/staff.png" alt=""> Staff</li>
        </ul>
    </nav>

    <!-- Main Content Area -->
    <div class="mainscreen">
        <iframe class="frames frame1 active" src="./dashboard.php" frameborder="0"></iframe>
        <iframe class="frames frame2" src="./roombook.php" frameborder="0"></iframe>
        <iframe class="frames frame3" src="./payment.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./room.php" frameborder="0"></iframe>
        <iframe class="frames frame5" src="./staff.php" frameborder="0"></iframe>
    </div>

    <script src="./javascript/script.js"></script>
</body>
</html>

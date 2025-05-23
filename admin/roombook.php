<?php
session_start();
include '../config.php';

if (isset($_POST['guestdetailsubmit'])) {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $country = $_POST['Country'];
    $phone = $_POST['Phone'];
    $roomType = $_POST['RoomType'];
    $bed = $_POST['Bed'];
    $roomCount = $_POST['NoofRoom'];
    $meal = $_POST['Meal'];
    $checkin = $_POST['cin'];
    $checkout = $_POST['cout'];

    if (empty($name) || empty($email) || empty($country)) {
        echo "<script>swal({ title: 'Please fill all required fields', icon: 'error' });</script>";
    } else {
        $status = "NotConfirm";
        $insertQuery = "INSERT INTO roombook (Name, Email, Country, Phone, RoomType, Bed, NoofRoom, Meal, cin, cout, stat, nodays)
                        VALUES ('$name', '$email', '$country', '$phone', '$roomType', '$bed', '$roomCount', '$meal', '$checkin', '$checkout', '$status', DATEDIFF('$checkout', '$checkin'))";

        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo "<script>swal({ title: 'Reservation submitted successfully', icon: 'success' });</script>";
        } else {
            echo "<script>swal({ title: 'Reservation failed. Try again.', icon: 'error' });</script>";
        }
    }
}

$reservations = mysqli_query($conn, "SELECT * FROM roombook");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Room Booking - Hotel Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="./css/roombook.css">
</head>

<body>
  <div class="container mt-4">
    <h3 class="text-center mb-4">Book a Room</h3>
    <form method="POST" class="row g-3">
      <div class="col-md-6">
        <input type="text" name="Name" class="form-control" placeholder="Full Name" required>
      </div>
      <div class="col-md-6">
        <input type="email" name="Email" class="form-control" placeholder="Email" required>
      </div>
      <div class="col-md-6">
        <select name="Country" class="form-select" required>
          <option value="" selected>Select Country</option>
          <?php
            $countries = ["Pakistan", "India", "USA", "Canada", "Australia"];
            foreach ($countries as $country) {
              echo "<option value='$country'>$country</option>";
            }
          ?>
        </select>
      </div>
      <div class="col-md-6">
        <input type="text" name="Phone" class="form-control" placeholder="Phone Number" required>
      </div>
      <div class="col-md-6">
        <select name="RoomType" class="form-select" required>
          <option value="" selected>Type of Room</option>
          <option value="Superior Room">Superior Room</option>
          <option value="Deluxe Room">Deluxe Room</option>
          <option value="Guest House">Guest House</option>
          <option value="Single Room">Single Room</option>
        </select>
      </div>
      <div class="col-md-6">
        <select name="Bed" class="form-select" required>
          <option value="" selected>Bedding Type</option>
          <option value="Single">Single</option>
          <option value="Double">Double</option>
          <option value="Triple">Triple</option>
        </select>
      </div>
      <div class="col-md-6">
        <select name="NoofRoom" class="form-select" required>
          <option value="" selected>Number of Rooms</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
      </div>
      <div class="col-md-6">
        <select name="Meal" class="form-select" required>
          <option value="" selected>Meal Plan</option>
          <option value="Room only">Room only</option>
          <option value="Breakfast">Breakfast</option>
          <option value="Half Board">Half Board</option>
          <option value="Full Board">Full Board</option>
        </select>
      </div>
      <div class="col-md-6">
        <label>Check-In</label>
        <input type="date" name="cin" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label>Check-Out</label>
        <input type="date" name="cout" class="form-control" required>
      </div>
      <div class="col-12 text-end">
        <button type="submit" name="guestdetailsubmit" class="btn btn-success">Submit Reservation</button>
      </div>
    </form>

    <hr class="my-4">
    <h4 class="mb-3">Reservation Requests</h4>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Country</th>
            <th>Phone</th>
            <th>Room</th>
            <th>Bed</th>
            <th>Rooms</th>
            <th>Meal</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Days</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($reservations)) { ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['Name'] ?></td>
              <td><?= $row['Email'] ?></td>
              <td><?= $row['Country'] ?></td>
              <td><?= $row['Phone'] ?></td>
              <td><?= $row['RoomType'] ?></td>
              <td><?= $row['Bed'] ?></td>
              <td><?= $row['NoofRoom'] ?></td>
              <td><?= $row['Meal'] ?></td>
              <td><?= $row['cin'] ?></td>
              <td><?= $row['cout'] ?></td>
              <td><?= $row['nodays'] ?></td>
              <td><?= $row['stat'] ?></td>
              <td>
                <?php if ($row['stat'] !== "Confirm") { ?>
                  <a href="roomconfirm.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Confirm</a>
                <?php } ?>
                <a href="roombookedit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="roombookdelete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>

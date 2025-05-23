<?php
include '../config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: roombook.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM roombook WHERE id = $id");
$reservation = mysqli_fetch_assoc($query);

if (!$reservation) {
    header("Location: roombook.php");
    exit();
}

if (isset($_POST['guestdetailedit'])) {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $country = $_POST['Country'];
    $phone = $_POST['Phone'];
    $roomType = $_POST['RoomType'];
    $bed = $_POST['Bed'];
    $rooms = $_POST['NoofRoom'];
    $meal = $_POST['Meal'];
    $cin = $_POST['cin'];
    $cout = $_POST['cout'];

    mysqli_query($conn, "UPDATE roombook SET Name='$name', Email='$email', Country='$country', Phone='$phone', RoomType='$roomType', Bed='$bed', NoofRoom='$rooms', Meal='$meal', cin='$cin', cout='$cout', nodays = DATEDIFF('$cout', '$cin') WHERE id=$id");

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

    $nodaysQuery = mysqli_query($conn, "SELECT nodays FROM roombook WHERE id = $id");
    $nodays = mysqli_fetch_assoc($nodaysQuery)['nodays'] ?? 1;

    $roomTotal = $basePrice * $nodays * $rooms;
    $bedTotal = $bedCost * $nodays;
    $mealTotal = $mealCost * $nodays;
    $finalTotal = $roomTotal + $bedTotal + $mealTotal;

    mysqli_query($conn, "UPDATE payment SET Name='$name', Email='$email', RoomType='$roomType', Bed='$bed', NoofRoom='$rooms', Meal='$meal', cin='$cin', cout='$cout', noofdays='$nodays', roomtotal='$roomTotal', bedtotal='$bedTotal', mealtotal='$mealTotal', finaltotal='$finalTotal' WHERE id=$id");

    header("Location: roombook.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Reservation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="./css/roombook.css">
  <style>
    #editpanel {
      position: fixed;
      z-index: 1000;
      height: 100%;
      width: 100%;
      display: flex;
      justify-content: center;
      background-color: #00000079;
    }
    #editpanel .guestdetailpanelform {
      height: auto;
      width: 1000px;
      background-color: #ccdff4;
      border-radius: 10px;
      margin-top: 40px;
      padding: 30px;
    }
  </style>
</head>
<body>
  <div id="editpanel">
    <form method="POST" class="guestdetailpanelform">
      <h3 class="text-center mb-4">Edit Reservation</h3>
      <div class="row g-3">
        <div class="col-md-6">
          <input type="text" name="Name" class="form-control" placeholder="Full Name" value="<?= $reservation['Name'] ?>" required>
        </div>
        <div class="col-md-6">
          <input type="email" name="Email" class="form-control" placeholder="Email" value="<?= $reservation['Email'] ?>" required>
        </div>
        <div class="col-md-6">
          <select name="Country" class="form-select" required>
            <option value="">Select Country</option>
            <?php
              $countries = ["Pakistan", "India", "USA", "Canada", "Australia"];
              foreach ($countries as $c) {
                $selected = $reservation['Country'] === $c ? 'selected' : '';
                echo "<option value='$c' $selected>$c</option>";
              }
            ?>
          </select>
        </div>
        <div class="col-md-6">
          <input type="text" name="Phone" class="form-control" placeholder="Phone Number" value="<?= $reservation['Phone'] ?>" required>
        </div>
        <div class="col-md-4">
          <select name="RoomType" class="form-select" required>
            <option value="">Room Type</option>
            <?php
              $rooms = ["Superior Room", "Deluxe Room", "Guest House", "Single Room"];
              foreach ($rooms as $r) {
                $selected = $reservation['RoomType'] === $r ? 'selected' : '';
                echo "<option value='$r' $selected>$r</option>";
              }
            ?>
          </select>
        </div>
        <div class="col-md-4">
          <select name="Bed" class="form-select" required>
            <option value="">Bed Type</option>
            <?php
              $beds = ["Single", "Double", "Triple", "Quad", "None"];
              foreach ($beds as $b) {
                $selected = $reservation['Bed'] === $b ? 'selected' : '';
                echo "<option value='$b' $selected>$b</option>";
              }
            ?>
          </select>
        </div>
        <div class="col-md-4">
          <select name="NoofRoom" class="form-select" required>
            <option value="1" <?= $reservation['NoofRoom'] == 1 ? 'selected' : '' ?>>1</option>
            <option value="2" <?= $reservation['NoofRoom'] == 2 ? 'selected' : '' ?>>2</option>
            <option value="3" <?= $reservation['NoofRoom'] == 3 ? 'selected' : '' ?>>3</option>
          </select>
        </div>
        <div class="col-md-6">
          <select name="Meal" class="form-select" required>
            <option value="">Meal Plan</option>
            <?php
              $meals = ["Room only", "Breakfast", "Half Board", "Full Board"];
              foreach ($meals as $m) {
                $selected = $reservation['Meal'] === $m ? 'selected' : '';
                echo "<option value='$m' $selected>$m</option>";
              }
            ?>
          </select>
        </div>
        <div class="col-md-3">
          <label>Check-In</label>
          <input type="date" name="cin" class="form-control" value="<?= $reservation['cin'] ?>" required>
        </div>
        <div class="col-md-3">
          <label>Check-Out</label>
          <input type="date" name="cout" class="form-control" value="<?= $reservation['cout'] ?>" required>
        </div>
        <div class="col-12 text-end">
          <button type="submit" name="guestdetailedit" class="btn btn-success">Update Reservation</button>
          <a href="roombook.php" class="btn btn-secondary">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</body>
</html>

<?php
session_start();
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Management - Staff</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="css/room.css">
    <style>
        .roombox {
            background-color: #d1d7ff;
            padding: 15px;
            margin: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body class="container my-5">

    <h2 class="text-center mb-4">Staff Management</h2>

    <div class="addroomsection mb-4">
        <form method="POST" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="staffname" class="form-label">Name</label>
                <input type="text" name="staffname" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="staffwork" class="form-label">Work Role</label>
                <select name="staffwork" class="form-select" required>
                    <option value="" selected disabled>Choose role</option>
                    <option value="Manager">Manager</option>
                    <option value="Cook">Cook</option>
                    <option value="Helper">Helper</option>
                    <option value="Cleaner">Cleaner</option>
                    <option value="Waiter">Waiter</option>
                </select>
            </div>

            <button type="submit" name="addstaff" class="btn btn-success">Add Staff</button>
        </form>

        <?php
        if (isset($_POST['addstaff'])) {
            $staffname = mysqli_real_escape_string($conn, $_POST['staffname']);
            $staffwork = mysqli_real_escape_string($conn, $_POST['staffwork']);

            $query = "INSERT INTO staff(name, work) VALUES ('$staffname', '$staffwork')";
            if (mysqli_query($conn, $query)) {
                header("Location: staff.php");
                exit();
            }
        }
        ?>
    </div>

    <div class="room d-flex flex-wrap justify-content-center">
        <?php
        $staffList = mysqli_query($conn, "SELECT * FROM staff ORDER BY id DESC");
        while ($staff = mysqli_fetch_array($staffList)) {
            echo "
                <div class='roombox text-center'>
                    <i class='fa fa-user-tie fa-3x mb-2'></i>
                    <h4 class='mb-1'>{$staff['name']}</h4>
                    <p class='mb-3 text-muted'>{$staff['work']}</p>
                    <a href='staffdelete.php?id={$staff['id']}' class='btn btn-danger btn-sm'>Delete</a>
                </div>
            ";
        }
        ?>
    </div>

</body>
</html>

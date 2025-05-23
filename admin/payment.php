<?php
session_start();
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payments | Hotel Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="css/roombook.css">
    <style>
        .searchsection {
            padding: 15px;
            text-align: right;
        }
        .searchsection input {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 250px;
        }
        .action button {
            margin: 2px;
        }
    </style>
</head>

<body class="container my-4">
    <h2 class="mb-4 text-center">Payment Records</h2>

    <div class="searchsection">
        <input type="text" id="search_bar" placeholder="Search by Name..." onkeyup="searchFun()">
    </div>

    <div class="table-responsive">
        <?php
            $query = "SELECT * FROM payment ORDER BY id DESC";
            $result = mysqli_query($conn, $query);
        ?>
        <table class="table table-bordered table-striped" id="table-data">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Room Type</th>
                    <th>Bed Type</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Days</th>
                    <th>Rooms</th>
                    <th>Meal</th>
                    <th>Room Rent</th>
                    <th>Bed Rent</th>
                    <th>Meal Cost</th>
                    <th>Total Bill</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['Name'] ?></td>
                    <td><?= $row['RoomType'] ?></td>
                    <td><?= $row['Bed'] ?></td>
                    <td><?= $row['cin'] ?></td>
                    <td><?= $row['cout'] ?></td>
                    <td><?= $row['noofdays'] ?></td>
                    <td><?= $row['NoofRoom'] ?></td>
                    <td><?= $row['meal'] ?></td>
                    <td><?= $row['roomtotal'] ?></td>
                    <td><?= $row['bedtotal'] ?></td>
                    <td><?= $row['mealtotal'] ?></td>
                    <td><?= $row['finaltotal'] ?></td>
                    <td class="action">
                        <a href="invoiceprint.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-print"></i> Print
                        </a>
                        <a href="paymantdelete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        function searchFun() {
            const input = document.getElementById("search_bar").value.toUpperCase();
            const table = document.getElementById("table-data");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const td = rows[i].getElementsByTagName("td")[1];
                if (td) {
                    const value = td.textContent || td.innerText;
                    rows[i].style.display = value.toUpperCase().includes(input) ? "" : "none";
                }
            }
        }
    </script>
</body>
</html>

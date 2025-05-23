<?php

include '../config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $query = "DELETE FROM staff WHERE id = $id";
    mysqli_query($conn, $query);
}

header("Location: staff.php");
exit();

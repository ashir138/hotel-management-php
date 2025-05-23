<?php

include '../config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $delete = mysqli_query($conn, "DELETE FROM roombook WHERE id = $id");
}

header("Location: roombook.php");
exit();
?>

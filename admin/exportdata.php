<?php
include '../config.php';

$query = "SELECT * FROM roombook";
$result = mysqli_query($conn, $query);

$records = [];

while ($row = mysqli_fetch_assoc($result)) {
    $records[] = $row;
}

if (isset($_POST["exportexcel"])) {
    $filename = "hotelmanagement_roombook_" . date('Ymd') . ".xls";

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    if (!empty($records)) {
        $headerPrinted = false;

        foreach ($records as $row) {
            if (!$headerPrinted) {
                echo implode("\t", array_keys($row)) . "\n";
                $headerPrinted = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
    }
    exit;
}
?>

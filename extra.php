<?php
if (isset($_POST['guestdetailsubmit'])) {
    $Name = $_POST['Name1'];
    $Email = $_POST['Email'];
    $Country = $_POST['Country'];
    $Phone = $_POST['Phone'];
    $RoomType = $_POST['RoomType'];
    $Bed = $_POST['Bed'];
    $NoofRoom = $_POST['NoofRoom'];
    $Meal = $_POST['Meal'];
    $cin = $_POST['cin'];
    $cout = $_POST['cout'];

    if (empty($Name) || empty($Email) || empty($Country)) {
        echo "<script>swal({
            title: 'Please fill in all required details.',
            icon: 'error'
        });</script>";
    } else {
        $status = "NotConfirm";
        $sql = "INSERT INTO roombook (Name1, Email, Country, Phone, RoomType, Bed, NoofRoom, Meal, cin, cout, stat, nodays)
                VALUES ('$Name', '$Email', '$Country', '$Phone', '$RoomType', '$Bed', '$NoofRoom', '$Meal', '$cin', '$cout', '$status', DATEDIFF('$cout', '$cin'))";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>swal({
                title: 'Reservation submitted successfully.',
                icon: 'success'
            });</script>";
        } else {
            echo "<script>swal({
                title: 'Something went wrong. Please try again.',
                icon: 'error'
            });</script>";
        }
    }
}
?>

<?php
if (isset($_GET['id'])) {
    $performance_id = $_GET['id'];
    if ($performance_id != 0 && $performance_id != null) {
        include "../dbFunctions.php";
        // Retrieve slide name from the database table
        $query = "SELECT * FROM `performance` WHERE `performance_id` = '$performance_id';";
        $doquery = mysqli_query($connection, $query);
        $performance_data = mysqli_fetch_assoc($doquery);
        $performance_old_slide = $performance_data['performance_slide_link'];
        $deletequery = "DELETE FROM `performance` WHERE `performance_id` = '$performance_id';";
        $dodelete = mysqli_query($connection, $deletequery);
        if ($dodelete) {
            if (is_file("../performance/" . $performance_old_slide)) {
                unlink("../performance/" . $performance_old_slide);
            }
        }
    }
}
header('location: manage_content.php');
?>
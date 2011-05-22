<?php
if (isset($_GET['id'])) {
    $ini_id = $_GET['id'];
    if ($ini_id != 0 && $ini_id != null) {
        include "../dbFunctions.php";
        // Retrieve slide name from the database table
        $query = "SELECT * FROM `initiative_slide` WHERE `slide_id` = '$ini_id';";
        $doquery = mysqli_query($connection, $query);
        $initiative_data = mysqli_fetch_assoc($doquery);
        $ini_slide_name = $initiative_data['slide_link'];
        $deletequery = "DELETE FROM `initiative_slide` WHERE `slide_id` = '$ini_id';";
        $dodelete = mysqli_query($connection, $deletequery);
        if ($dodelete) {
            if (is_file("../initiative/" . $ini_slide_name)) {
                unlink("../initiative/" . $ini_slide_name);
            }
        }
    }
}
header('location: manage_content.php');
?>
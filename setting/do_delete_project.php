<?php
if (isset($_GET['id'])) {
    $project_id = $_GET['id'];
    if ($project_id != 0 && $project_id != null) {
        include "../dbFunctions.php";
        $query = "SELECT * FROM `project` WHERE `project_id` = '$project_id';";
        $doquery = mysqli_query($connection, $query);
        $project_data = mysqli_fetch_assoc($doquery);
        $project_name = $project_data['project_slide_link'];
        $deletequery = "DELETE FROM `project` WHERE `project_id` = '$project_id';";
        $dodelete = mysqli_query($connection, $deletequery);
        if(is_file("../project/".$project_name)){
            unlink("../project/" . $project_name);
        }
    }
}
header('location: manage_content.php');
?>
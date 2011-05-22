<?php
session_start();
if (isset($_POST)) {
    //Retrieve icon data
    $normal_icon = basename($_FILES['normal_icon']['name']);
    $normal_tempname = $_FILES['normal_icon']['tmp_name'];
    $hover_icon = basename($_FILES['hover_icon']['name']);
    $hover_tempname = $_FILES['hover_icon']['tmp_name'];
    $icon_description = $_POST['image_description'];
    $icon_link = $_POST['image_link'];
    if ($normal_icon != "" && $hover_icon != "") {
        include '../dbFunctions.php';
        // Set the target path
        $normal_target_path = "image/normal_icon/" . $normal_icon;
        $hover_target_path = "image/hover_icon/" . $hover_icon;
        $normalpath = "../image/normal_icon/" . $normal_icon;
        $hoverpath = "../image/hover_icon/" . $hover_icon;
        if (move_uploaded_file($normal_tempname, $normalpath)) {
            if (move_uploaded_file($hover_tempname, $hoverpath)) {
                $insertquery = "INSERT INTO `icons` (`image_normal_src` ,`image_hover_src` ,`image_description` ,`image_link` ,`is_display`) VALUES ( '$normal_target_path',  '$hover_target_path',  '$icon_description',  '$icon_link',  '1');";
                $doquery = mysqli_query($connection, $insertquery);
                $msg = "Successfully save the icons. ";
            } else {
                $msg = "Sorry. Failure in uploading images.";
            }
        } else {
            $msg = "Sorry. Failure in uploading images.";
        }
    }else{
        $msg = "Please upload both images";
    }
} else {
    $msg = "No image uploaded";
}
$_SESSION['save_img_msg'] = $msg;
$header = header('location: manage_icon.php');
?>
<?php
session_start();
$ppt = basename($_FILES['ppt']['name']);
$tmpName = $_FILES['ppt']['tmp_name'];
if ($ppt != "") {
    include '../dbFunctions.php';
    $targetPath = "../slideshows/" . $ppt;
    if (move_uploaded_file($tmpName, $targetPath)) {
        $update = "UPDATE slideshows SET is_display= 0;";
        $doupdate = mysqli_query($connection, $update) or die(mysqli_error($update));
        $insertQuery = "INSERT INTO slideshows(name,is_display) VALUES('$ppt','1');";
        $doinsert = mysqli_query($connection, $insertQuery);
        if ($doinsert) {
            $message = "New slideshow saved successfully";
        } else {
            $message = "Error saving new design";
        }
    } else {
        $message = "Problem uploading";
    }
}
$_SESSION['upload_ppt_msg'] = $message;
$header = header("location: manage_slideshow.php");
?>
<?php
session_start();
include '../dbFunctions.php';
$ppt_id = $_POST['displayppt'];
$update = "UPDATE slideshows SET is_display= 0;";
$doupdate = mysqli_query($connection,$update) or die(mysqli_error($update));
$updatequery = "UPDATE slideshows SET is_display=1 WHERE id= $ppt_id; ";
$dosetdisplay = mysqli_query($connection, $updatequery) or die(mysqli_error($updatequery));
if ($dosetdisplay) {
    $msg = "Successfully changed display slideshow.";
} else {
    $msg = "Sorry.Fail to change  the display slideshow. Please try again.";
}
$_SESSION['display_ppt_msg'] = $msg;
$header= header('location: manage_slideshow.php');
?>
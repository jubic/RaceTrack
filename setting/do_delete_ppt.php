<?php
session_start();
include '../dbFunctions.php';
$ppt_id = $_POST['pptid'];
$ppt_name= $_POST['pptname'];
$deleteQuery = "DELETE FROM slideshows WHERE id= $ppt_id;";
$deleteResult = mysqli_query($connection, $deleteQuery) or die(mysqli_error($deleteQuery));
if ($deleteResult) {
    $slide_src= "../slideshows/".$ppt_name;
    $deleteslide = unlink($slide_src);
    $msg = "Successfully deleted the slideshow.";
} else {
    $msg = "Sorry.Fail to delete the file. Please try again.";
}
$_SESSION['delete_ppt_msg'] = $msg;
$header= header('location: manage_slideshow.php');
?>
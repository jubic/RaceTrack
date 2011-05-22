<?php
session_start();
$icon_list=$_POST['icon_display'];
$chosen_no= count($icon_list);
include '../dbFunctions.php';
$setFalsequery= "UPDATE `icons` SET  `is_display` =  '0';";
$do_set_false= mysqli_query($connection,$setFalsequery);
foreach($icon_list as $icon_id){
    $setTrueDisplayQuery= "UPDATE `icons` SET  `is_display` =  '1' WHERE  `icons`.`image_id` = $icon_id;";
    $do_set_true= mysqli_query($connection,$setTrueDisplayQuery);
}
$_SESSION['change_icon']="Successfully changed icons to be displayed.";
$header= header('location: manage_icon.php');
?>


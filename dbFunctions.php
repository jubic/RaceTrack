<?php
$dbhost= 'localhost';
$dbuser= "root";
$dbpwd= "";
$db= "rockwell";
$connection= new mysqli($dbhost,$dbuser, $dbpwd, $db) or die('Error connection database');
?>

<?php

@include 'config.php';

$id = $_GET['id'];
$status = $_GET['status'];
$updatequery1 = "UPDATE `order` SET status=$status WHERE id=$id";
mysqli_query($conn, $updatequery1);
header('location:orderlist.php');

?>




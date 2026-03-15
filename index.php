<?php
session_start();

if(!isset($_SESSION['role'])){
header("Location:login.php");
exit();
}

if($_SESSION['role']=="admin"){
header("Location:admin/dashboard.php");
}

if($_SESSION['role']=="mentor"){
header("Location:mentor/dashboard.php");
}

if($_SESSION['role']=="student"){
header("Location:student/dashboard.php");
}
?>
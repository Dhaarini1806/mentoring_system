<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "mentoring_db";

$conn = mysqli_connect($host,$user,$password,$db);

if(!$conn){
    die("Database Connection Failed");
}
?>
<?php
session_start();
include("config/database.php");

if(isset($_POST['login'])){

$email=$_POST['email'];
$password=$_POST['password'];

$sql="SELECT * FROM users WHERE email='$email'";
$result=$conn->query($sql);
$user=$result->fetch_assoc();

if($user && password_verify($password,$user['password'])){

$_SESSION['user']=$user['id'];
$_SESSION['role']=$user['role'];

header("Location:index.php");

}else{
echo "Invalid login";
}

}
?>
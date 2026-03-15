<?php
session_start();
if($_SESSION['role']!="mentor"){
header("Location:../login.php");
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<h1>Mentor Dashboard</h1>
<a href="students.php">My Students</a>
<a href="sessions.php">Counseling Sessions</a>
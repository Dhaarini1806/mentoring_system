<?php
session_start();
if($_SESSION['role']!="student"){
header("Location:../login.php");
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<h1>Student Dashboard</h1>
<a href="attendance.php">Attendance</a>
<a href="marks.php">Marks</a>
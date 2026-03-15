<?php
session_start();
if($_SESSION['role']!="admin"){
header("Location:../login.php");
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<h1>Admin Dashboard</h1>

<a href="students.php">Manage Students</a>
<a href="mentors.php">Manage Mentors</a>
<a href="assign.php">Assign Mentor</a>
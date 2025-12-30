<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_name = $_SESSION['student_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Dashboard</title>
<style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;}
.container{max-width:600px;margin:50px auto;background:white;padding:30px;border-radius:20px;box-shadow:0 8px 20px rgba(0,0,0,0.2);}
h2{color:#1b3a2b;}
button{padding:10px 20px;background:#2e7d32;color:white;border:none;border-radius:10px;cursor:pointer;}
button:hover{background:#1b3a2b;}
</style>
</head>
<body>
<div class="container">
<h2>Welcome, <?= htmlspecialchars($student_name) ?>!</h2>
<p>You are now logged in as a student.</p>
<form action="student_logout.php" method="POST">
    <button type="submit">Logout</button>
</form>
</div>
</body>
</html>

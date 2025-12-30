<?php
session_start();
include "db.php";

/* Protect page */
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$message = "";

/* Add Student */
if(isset($_POST['add_student'])){
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    /* Check if student exists */
    $check = $conn->query("SELECT id FROM students WHERE student_id='$student_id'");
    if($check->num_rows > 0){
        $message = "❌ Student ID already exists!";
    } else {
        $insert = $conn->query("INSERT INTO students (full_name, student_id, password) 
                                VALUES ('$full_name','$student_id','$password')");
        $message = $insert ? "✅ Student added successfully!" : "❌ Error adding student!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Student</title>
<style>
body{margin:0;font-family:Arial,sans-serif;background:#e6f2e6;}
.sidebar{width:230px;height:100vh;background:#1b3a2b;position:fixed;color:white;}
.sidebar h2{text-align:center;color:gold;padding:20px 0;}
.sidebar a{display:block;padding:15px;color:white;text-decoration:none;border-bottom:1px solid #2e7d32;}
.sidebar a:hover{background:#2e7d32;}
.main{margin-left:230px;padding:30px;}
.logo{width:120px;height:120px;border-radius:50%;border:2px solid gold;margin:15px auto;display:block;object-fit:contain;background:white;}
.card{background:white;padding:25px;border-radius:20px;box-shadow:0 8px 20px rgba(0,0,0,0.2);max-width:500px;margin:auto;}
input,button{width:100%;padding:12px;margin:10px 0;border-radius:10px;border:2px solid gold;}
button{background:#2e7d32;color:white;font-weight:bold;border:none;cursor:pointer;}
button:hover{background:#1b3a2b;}
.message{text-align:center;font-weight:bold;margin-bottom:15px;}
</style>
</head>
<body>

<div class="sidebar">
<h2>ADMIN</h2>
<img src="logo.png" class="logo">
<a href="add_student.php">Add Student</a>
<a href="admin_dashboard.php">Add Position / Candidate</a>
<a href="admin_logout.php">Logout</a>
</div>

<div class="main">
<div class="card">
<h3>Add Student</h3>
<?php if($message) echo "<div class='message'>$message</div>"; ?>
<form method="post">
<input type="text" name="full_name" placeholder="Full Name" required>
<input type="text" name="student_id" placeholder="Student ID" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" name="add_student">Add Student</button>
</form>
</div>
</div>

</body>
</html>

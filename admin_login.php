<?php
session_start();
include "db.php";

if (!isset($_POST['username'], $_POST['password'])) die("Form not submitted correctly.");

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = sha1($_POST['password']); // Use hash stored in DB

$sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if($result && $result->num_rows === 1){
    $_SESSION['admin'] = $username;
    header("Location: admin_dashboard.php");
    exit();
}else{
    echo "❌ Login failed: wrong username or password";
}
?>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if (!isset($_POST['student_id'], $_POST['password'])) {
    die("Form not submitted correctly");
}

$student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
$password   = $_POST['password'];

$sql = "SELECT * FROM students WHERE student_id='$student_id'";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $student = $result->fetch_assoc();

    if (password_verify($password, $student['password'])) {

        if ($student['has_voted'] == 1) {
            die("❌ You have already voted.");
        }

        $_SESSION['student_id']   = $student['id'];
        $_SESSION['student_name'] = $student['full_name'];

        header("Location: vote.php");
        exit();
    }
}

echo "❌ Invalid Student ID or Password";

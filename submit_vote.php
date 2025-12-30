<?php
session_start();
include "db.php";

if (!isset($_SESSION['student_id']) || empty($_SESSION['votes'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* DOUBLE CHECK: HAS STUDENT ALREADY VOTED */
$check = $conn->query("SELECT has_voted FROM students WHERE id='$student_id'");
$row = $check->fetch_assoc();

if ($row['has_voted'] == 1) {
    session_destroy();
    header("Location: login.php");
    exit();
}

/* SAVE VOTES */
foreach ($_SESSION['votes'] as $position_id => $candidate_id) {
    $conn->query("
        INSERT INTO votes (student_id, candidate_id, position_id)
        VALUES ('$student_id', '$candidate_id', '$position_id')
    ");
}

/* LOCK STUDENT */
$conn->query("UPDATE students SET has_voted=1 WHERE id='$student_id'");

/* GET STUDENT NAME */
$nameQ = $conn->query("SELECT full_name FROM students WHERE id='$student_id'");
$student = $nameQ->fetch_assoc();

/* CLEAR SESSION */
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
<title>Vote Submitted</title>
<meta http-equiv="refresh" content="5;url=login.php">
<style>
body{
    font-family:Arial;
    background:#f4f4f4;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.box{
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
    text-align:center;
}
h2{color:#1b3a2b;}
</style>
</head>
<body>
<div class="box">
<h2>✅ <?= htmlspecialchars($student['full_name']) ?>,</h2>
<p>Your vote has been submitted successfully.</p>
<p>You will be redirected to login page shortly...</p>
</div>
</body>
</html>

<?php
session_start();
include "db.php";
if(!isset($_SESSION['student_id'])){
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$message = "";

/* Record vote */
if(isset($_POST['vote'])){
    foreach($_POST['vote'] as $position_id=>$candidate_id){
        $conn->query("INSERT INTO votes (student_id,candidate_id) VALUES ('$student_id','$candidate_id')");
    }
    $message = "✅ Your vote has been submitted!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Voting Page</title>
<style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:0;}
.container{max-width:800px;margin:auto;padding:30px;background:white;border-radius:20px;box-shadow:0 8px 20px rgba(0,0,0,0.2);}
h2{text-align:center;color:#1b3a2b;}
.position{margin-bottom:30px;}
.candidate{display:flex;align-items:center;gap:15px;margin:10px 0;}
.candidate img{width:80px;height:80px;border-radius:50%;object-fit:cover;}
button{padding:12px 20px;background:#2e7d32;color:white;border:none;border-radius:10px;font-weight:bold;cursor:pointer;}
button:hover{background:#1b3a2b;}
.message{text-align:center;font-weight:bold;margin-bottom:15px;}
</style>
</head>
<body>

<div class="container">
<h2>Voting Page</h2>
<?php if($message) echo "<div class='message'>$message</div>"; ?>
<form method="post">
<?php
$positions=$conn->query("SELECT * FROM positions");
while($pos=$positions->fetch_assoc()){
    echo "<div class='position'>";
    echo "<h3>{$pos['position_name']}</h3>";
    $candidates=$conn->query("SELECT * FROM candidates WHERE position_id={$pos['id']}");
    while($c=$candidates->fetch_assoc()){
        $photo = $c['photo'] ? "uploads/".$c['photo'] : "logo.png";
        echo "<div class='candidate'>";
        echo "<input type='radio' name='vote[{$pos['id']}]' value='{$c['id']}' required>";
        echo "<img src='$photo' alt='Candidate'>";
        echo "<span>{$c['full_name']}</span>";
        echo "</div>";
    }
    echo "</div>";
}
?>
<button type="submit">Submit Vote</button>
</form>
</div>

</body>
</html>

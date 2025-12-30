<?php
session_start();
include "db.php";

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* Check if already voted */
$checkVote = $conn->query("SELECT has_voted, full_name FROM students WHERE id='$student_id'");
if(!$checkVote || $checkVote->num_rows === 0){
    die("❌ Student not found. Contact admin.");
}
$studentData = $checkVote->fetch_assoc();
if($studentData['has_voted'] == 1){
    die("❌ You have already voted.");
}

/* Fetch all positions */
$posQuery = $conn->query("SELECT * FROM positions ORDER BY id ASC");
$positions = [];
while($p = $posQuery->fetch_assoc()){
    $positions[] = $p;
}

if(empty($positions)){
    die("⚠ No positions available to vote.");
}

$totalPositions = count($positions);

/* Determine step */
if(isset($_GET['step'])){
    $step = (int)$_GET['step'];
} else {
    $step = 0;
}
if($step < 0) $step = 0;
if($step >= $totalPositions) $step = $totalPositions-1;

/* Initialize votes session */
if(!isset($_SESSION['votes'])){
    $_SESSION['votes'] = [];
}

$error = "";

/* Save vote if submitted */
if(isset($_POST['candidate_id'])){
    $_SESSION['votes'][$positions[$step]['id']] = $_POST['candidate_id'];
}

/* Navigation */
if(isset($_POST['next'])){
    if(!isset($_SESSION['votes'][$positions[$step]['id']])){
        $error = "⚠ Please select a candidate before proceeding!";
    } else {
        $step++;
        if($step >= $totalPositions){
            header("Location: submit_vote.php");
            exit();
        }
        header("Location: vote.php?step=$step");
        exit();
    }
}

if(isset($_POST['back'])){
    $step--;
    if($step < 0) $step = 0;
    header("Location: vote.php?step=$step");
    exit();
}

/* Get candidates */
$currentPosition = $positions[$step];
$position_id = $currentPosition['id'];
$candidates = $conn->query("SELECT * FROM candidates WHERE position_id='$position_id'");
?>
<!DOCTYPE html>
<html>
<head>
<title>Vote - <?= htmlspecialchars($currentPosition['position_name']) ?></title>
<style>
/* PAGE STYLES */
body { 
    font-family: Arial; 
    background: #d9e6d9; /* slightly darker than cards */ 
    margin:0; 
    padding:0; 
}
.container { 
    max-width: 1000px; 
    margin: auto; 
    padding: 20px; 
}

/* HEADER */
h2 { 
    color: #1b3a2b; 
    text-align:center;
    margin-bottom: 30px;
}

/* ERROR */
.error { 
    color:red; 
    font-weight:bold; 
    margin-bottom:15px; 
    text-align:center; 
}

/* CANDIDATE CARDS */
.grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); 
    gap: 20px; 
}

.card { 
    padding: 15px; 
    border-radius: 20px; 
    text-align:center; 
    cursor:pointer; 
    border:3px solid transparent; 
    transition:0.3s; 
    color:#1b3a2b; 
    font-weight:bold;
    background-color: #ffffff; /* card background */
    box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* subtle shadow */
}

.card input { display:none; }

.card.selected { 
    border:3px solid gold; 
    background-color: #fff8dc; /* highlight when selected */
}

.card img { 
    width:120px; 
    height:120px; 
    border-radius:50%; 
    object-fit:cover; 
    border:3px solid gold; 
    margin-bottom:10px;
}

/* BUTTONS */
button { 
    padding:14px 30px; 
    background:#2e7d32; 
    border:none; 
    border-radius:25px; 
    color:white; 
    font-weight:bold; 
    cursor:pointer; 
    transition:0.3s;
}

button:hover { background:#1b3a2b; }

.nav-buttons { 
    margin-top:30px; 
    display:flex; 
    justify-content:space-between; 
}
</style>
<script>
/* Make clicking anywhere on card select the radio */
function selectCard(radio){
    var cards = document.querySelectorAll('.card');
    cards.forEach(c => c.classList.remove('selected'));
    radio.checked = true;
    radio.closest('.card').classList.add('selected');
}
</script>
</head>
<body>
<div class="container">
<h2>Vote for: <?= htmlspecialchars($currentPosition['position_name']) ?></h2>

<?php if($error) echo "<div class='error'>$error</div>"; ?>

<form method="post">
<div class="grid">
<?php while($row = $candidates->fetch_assoc()):
    $isSelected = (isset($_SESSION['votes'][$position_id]) && $_SESSION['votes'][$position_id] == $row['id']);
    $photo = $row['photo'] ? "uploads/".$row['photo'] : "logo.png";
?>
<label class="card <?= $isSelected ? 'selected' : '' ?>" onclick="selectCard(this.querySelector('input'))">
    <input type="radio" name="candidate_id" value="<?= $row['id'] ?>" <?= $isSelected ? 'checked' : '' ?>>
    <img src="<?= $photo ?>" alt="Candidate">
    <h4><?= htmlspecialchars($row['full_name']) ?></h4>
</label>
<?php endwhile; ?>
</div>

<div class="nav-buttons">
<?php if($step > 0): ?>
<button type="submit" name="back">⬅ Back</button>
<?php else: ?><div></div><?php endif; ?>
<button type="submit" name="next"><?= $step == $totalPositions-1 ? 'Submit' : 'Next ➡' ?></button>
</div>
</form>
</div>
</body>
</html>

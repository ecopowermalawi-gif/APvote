<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// Fetch all positions
$positions = $conn->query("SELECT * FROM positions ORDER BY position_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Live Election Results</title>
<meta http-equiv="refresh" content="5">
<style>
body { margin:0; font-family:Arial, sans-serif; background:#f4f4f4; padding:100px 20px 40px 20px; }

/* FIXED BACK BUTTON */
.back-btn {
    position: fixed;
    top:20px;
    left:20px;
    padding:12px 24px;
    background:#2e7d32;
    color:white;
    border-radius:14px;
    text-decoration:none;
    font-weight:bold;
    box-shadow:0 6px 14px rgba(0,0,0,.25);
    z-index:9999;
}
.back-btn:hover { background:#1b3a2b; }

h1 { text-align:center; color:#1b3a2b; margin-bottom:10px; position:fixed; top:20px; left:50%; transform:translateX(-50%); background:#f4f4f4; padding:10px 20px; z-index:9998; }

/* POSITION CARD */
.position-card {
    background:white;
    padding:25px;
    margin-bottom:40px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,.15);
}

/* TABLE STYLING */
table { width:100%; border-collapse:collapse; margin-top:15px; }
th, td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
th { background:#1b3a2b; color:white; }
img { width:50px; height:50px; border-radius:50%; object-fit:cover; }

/* HIGHLIGHT TOP 3 */
.first { background:#ffd700; font-weight:bold; }   /* Gold */
.second { background:#c0c0c0; font-weight:bold; }  /* Silver */
.third { background:#cd7f32; font-weight:bold; }   /* Bronze */
</style>
</head>
<body>

<a href="admin_dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
<h1>📊 LIVE ELECTION RESULTS</h1>

<div style="margin-top:120px;"> <!-- to offset the fixed h1 -->

<?php
while($pos = $positions->fetch_assoc()):

    $position_id = $pos['id'];

    // Fetch candidates and vote counts for this position
    $result = $conn->query("
        SELECT c.*, COUNT(v.id) AS total_votes
        FROM candidates c
        LEFT JOIN votes v ON c.id = v.candidate_id
        WHERE c.position_id='$position_id'
        GROUP BY c.id
        ORDER BY total_votes DESC, c.full_name ASC
    ");

    $candidates = [];
    while($row = $result->fetch_assoc()){
        $candidates[] = $row;
    }
?>
<div class="position-card">
    <h2><?= htmlspecialchars($pos['position_name']) ?></h2>
    <table>
        <tr>
            <th>Photo</th>
            <th>Candidate</th>
            <th>Total Votes</th>
        </tr>
        <?php if(!empty($candidates)): ?>
            <?php foreach($candidates as $index => $c): ?>
            <?php
                $class = '';
                if($index == 0) $class = 'first';
                elseif($index == 1) $class = 'second';
                elseif($index == 2) $class = 'third';
            ?>
            <tr class="<?= $class ?>">
                <td><img src="<?= $c['photo'] ? 'uploads/'.$c['photo'] : 'logo.png' ?>" alt="Photo"></td>
                <td><?= htmlspecialchars($c['full_name']) ?></td>
                <td><?= $c['total_votes'] ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3" style="text-align:center;color:#777;">No candidates yet</td></tr>
        <?php endif; ?>
    </table>
</div>

<?php endwhile; ?>
</div>
</body>
</html>

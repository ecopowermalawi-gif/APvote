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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<style>
body { margin:0; font-family:Arial, sans-serif; background:#f4f4f4; padding:120px 20px 40px 20px; }

.back-btn {
    position: fixed;
    top:20px;
    right:20px;
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

h1 { text-align:center; color:#1b3a2b; margin-bottom:10px; }
p.subtitle { text-align:center; color:#555; margin-bottom:20px; }

#downloadPdf {
    display:block;
    margin:0 auto 40px auto;
    padding:12px 24px;
    background:#1b3a2b;
    color:white;
    font-weight:bold;
    border:none;
    border-radius:10px;
    cursor:pointer;
}
#downloadPdf:hover { background:#2e7d32; }

.position-table {
    background:white; 
    padding:15px; 
    margin-bottom:40px; 
    border-radius:10px; 
    box-shadow:0 4px 12px rgba(0,0,0,.15);
}

table { width:100%; border-collapse:collapse; margin-top:10px; }
th, td { padding:12px; border:1px solid #ccc; text-align:left; }
th { background:#1b3a2b; color:white; }
.silk { background:#f5f5dc; font-weight:bold; }
</style>
</head>
<body>

<a href="admin_dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
<h1> APU ADMIN LIVE ELECTION RESULTS DASHBOARD! CANDIDATES OSAOPA MUTENGA CHINTHUCHI!!! </h1>
<p class="subtitle">(Auto-refresh every 5 seconds • Top candidate highlighted!!)</p>
<button id="downloadPdf">⬇ Download PDF</button>

<div id="resultsContent">
<?php while($pos = $positions->fetch_assoc()):
    $position_id = $pos['id'];

    // Fetch candidates and votes for this position
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
<div class="position-table">
    <h2><?= htmlspecialchars($pos['position_name']) ?></h2>
    <table>
        <tr>
            <th>Candidate</th>
            <th>Total Votes</th>
        </tr>
        <?php foreach($candidates as $index => $c):
            $class = ($index==0 && $c['total_votes']>0) ? 'silk' : '';
        ?>
        <tr class="<?= $class ?>">
            <td><?= htmlspecialchars($c['full_name']) ?></td>
            <td><?= $c['total_votes'] ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($candidates)): ?>
        <tr><td colspan="2" style="text-align:center;color:#777;">No candidates yet</td></tr>
        <?php endif; ?>
    </table>
</div>
<?php endwhile; ?>
</div>

<script>
document.getElementById('downloadPdf').addEventListener('click', () => {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'pt', 'a4');

    html2canvas(document.getElementById('resultsContent')).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = 595;
        const pageHeight = 842;
        const imgHeight = canvas.height * imgWidth / canvas.width;
        let heightLeft = imgHeight;
        let position = 0;

        doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while(heightLeft > 0){
            position = heightLeft - imgHeight;
            doc.addPage();
            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;
        }

        doc.save("Election_Results.pdf");
    });
});
</script>

</body>
</html>

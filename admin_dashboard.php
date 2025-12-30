<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

/* ================= ADD STUDENT ================= */
if(isset($_POST['add_student'])){
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);

    // Generate unique student ID
    do {
        $student_id = 'APU' . strtoupper(substr(md5(uniqid()), 0, 4));
        $check = $conn->query("SELECT id FROM students WHERE student_id='$student_id'");
    } while($check->num_rows > 0);

    // Generate password (6 chars)
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password_plain = '';
    for($i=0; $i<6; $i++){
        $password_plain .= $chars[rand(0, strlen($chars)-1)];
    }

    $password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

    $insert = $conn->query("INSERT INTO students (full_name, student_id, password)
                            VALUES ('$full_name','$student_id','$password_hashed')");

    if($insert){
        $_SESSION['popup_student'] = [
            'id' => $student_id,
            'password' => $password_plain
        ];
    }
}

/* ================= ADD POSITION ================= */
if(isset($_POST['add_position'])){
    $position = mysqli_real_escape_string($conn, $_POST['position_name']);
    if($position != ""){
        $conn->query("INSERT INTO positions (position_name) VALUES ('$position')");
    }
}

/* ================= ADD CANDIDATE ================= */
if(isset($_POST['add_candidate'])){
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $position_id = $_POST['position_id'];

    $photo = "";
    if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
        if(!is_dir('uploads')) mkdir('uploads',0755);
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo = uniqid().".".$ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photo);
    }

    if($full_name!="" && $position_id!=""){
        $conn->query("INSERT INTO candidates (full_name, position_id, photo)
                      VALUES ('$full_name','$position_id','$photo')");
    }
}

/* ================= DELETE POSITION ================= */
if(isset($_GET['delete_position'])){
    $id = intval($_GET['delete_position']);
    $conn->query("DELETE FROM candidates WHERE position_id=$id");
    $conn->query("DELETE FROM positions WHERE id=$id");
}

/* ================= DELETE CANDIDATE ================= */
if(isset($_GET['delete_candidate'])){
    $id = intval($_GET['delete_candidate']);
    $conn->query("DELETE FROM candidates WHERE id=$id");
}

/* Fetch data */
$positions = $conn->query("SELECT * FROM positions ORDER BY position_name ASC");
$candidates = $conn->query("SELECT c.*, p.position_name FROM candidates c
                            JOIN positions p ON c.position_id=p.id
                            ORDER BY p.position_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<style>
body{margin:0;font-family:Arial;background:#e6f2e6;}
.sidebar{width:230px;height:100vh;background:#1b3a2b;position:fixed;color:white;}
.sidebar h2{text-align:center;color:gold;padding:20px 0;}
.sidebar a{display:block;padding:15px;color:white;text-decoration:none;border-bottom:1px solid #2e7d32;}
.sidebar a:hover{background:#2e7d32;}
.main{margin-left:230px;padding:30px;}

.logo{width:120px;height:120px;border-radius:50%;border:2px solid gold;margin:15px auto;display:block;background:white;object-fit:contain;}

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
    max-width:600px;
    margin-bottom:30px;
}

input,select,button{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:10px;
    border:2px solid gold;
}

button{
    background:#2e7d32;
    color:white;
    font-weight:bold;
    border:none;
    cursor:pointer;
}
button:hover{background:#1b3a2b;}

img.cand_photo{
    width:50px;
    height:50px;
    border-radius:50%;
    object-fit:cover;
}

a.delete{
    color:red;
    text-decoration:none;
    font-weight:bold;
}

/* ===== POPUP ===== */
.popup-overlay{
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.6);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:9999;
}

.popup-box{
    background:white;
    padding:30px;
    border-radius:20px;
    width:360px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
}

.popup-box h2{color:#1b3a2b;}
.popup-box p{font-size:16px;margin:8px 0;}
</style>
</head>

<body>

<div class="sidebar">
    <h2>ADMIN</h2>
    <img src="logo.png" class="logo">
    <a href="#add_student">Add Student</a>
    <a href="#add_position">Add Position</a>
    <a href="#add_candidate">Add Candidate</a>
    <a href="#view_candidates">View Candidates</a>
    <a href="admin_results_page.php">View Results</a>
    <a href="admin_logout.php">Logout</a>
</div>

<div class="main">

<!-- ADD STUDENT -->
<div class="card" id="add_student">
<h3>Add Student</h3>
<form method="post">
    <input type="text" name="full_name" placeholder="Full Name" required>
    <button name="add_student">Add Student</button>
</form>
</div>

<!-- ADD POSITION -->
<div class="card" id="add_position">
<h3>Add Position</h3>
<form method="post">
    <input type="text" name="position_name" placeholder="Position Name" required>
    <button name="add_position">Add Position</button>
</form>
</div>

<!-- ADD CANDIDATE -->
<div class="card" id="add_candidate">
<h3>Add Candidate</h3>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="full_name" placeholder="Candidate Name" required>
    <select name="position_id" required>
        <option value="">-- Select Position --</option>
        <?php while($p=$positions->fetch_assoc()): ?>
            <option value="<?= $p['id'] ?>"><?= $p['position_name'] ?></option>
        <?php endwhile; ?>
    </select>
    <input type="file" name="photo" required>
    <button name="add_candidate">Add Candidate</button>
</form>
</div>

<!-- VIEW CANDIDATES -->
<div class="card" id="view_candidates">
<h3>Existing Candidates</h3>
<table border="1" width="100%" cellpadding="8">
<tr>
<th>Photo</th><th>Name</th><th>Position</th><th>Action</th>
</tr>
<?php while($c=$candidates->fetch_assoc()): ?>
<tr>
<td><img src="uploads/<?= $c['photo'] ?>" class="cand_photo"></td>
<td><?= htmlspecialchars($c['full_name']) ?></td>
<td><?= htmlspecialchars($c['position_name']) ?></td>
<td><a href="?delete_candidate=<?= $c['id'] ?>" class="delete">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</div>

</div>

<!-- ===== POPUP OUTPUT ===== -->
<?php if(isset($_SESSION['popup_student'])): ?>
<div class="popup-overlay" id="popup">
    <div class="popup-box">
        <h2>Student Added ✅</h2>
        <p><strong>Student ID:</strong> <?= $_SESSION['popup_student']['id'] ?></p>
        <p><strong>Password:</strong> <?= $_SESSION['popup_student']['password'] ?></p>
        <button onclick="document.getElementById('popup').style.display='none'">OK</button>
    </div>
</div>
<?php unset($_SESSION['popup_student']); endif; ?>

</body>
</html>

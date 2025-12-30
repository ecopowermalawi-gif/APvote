<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$message = "";

/* Fetch positions */
$positions = $conn->query("SELECT * FROM positions ORDER BY position_name ASC");

/* Add Position */
if(isset($_POST['add_position'])){
    $position = mysqli_real_escape_string($conn, $_POST['position_name']);
    if($position != ""){
        $conn->query("INSERT INTO positions (position_name) VALUES ('$position')");
        $message = "✅ Position added successfully!";
    }
}

/* Add Candidate */
if(isset($_POST['add_candidate'])){
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $position_id = $_POST['position_id'];

    $photo = NULL;
    if (!empty($_FILES['photo']['name'])) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if (in_array($ext, $allowed)) {
            $photo = $upload_dir . uniqid("cand_") . "." . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
        }
    }

    if($full_name!="" && $position_id!=""){
        $conn->query("INSERT INTO candidates (full_name, position_id, photo) VALUES ('$full_name','$position_id','$photo')");
        $message = "✅ Candidate added successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Position / Candidate</title>
<style>
body{font-family:Arial;background:#e6f2e6;margin:0;}
.sidebar{width:230px;height:100vh;background:#1b3a2b;position:fixed;color:white;}
.sidebar h2{text-align:center;color:gold;padding:20px 0;}
.sidebar a{display:block;padding:15px;color:white;text-decoration:none;border-bottom:1px solid #2e7d32;}
.sidebar a:hover{background:#2e7d32;}
.main{margin-left:230px;padding:30px;}
.logo{width:120px;height:120px;border-radius:50%;border:2px solid gold;margin:15px auto;display:block;object-fit:contain;background:white;}
.card{background:white;padding:25px;border-radius:20px;box-shadow:0 8px 20px rgba(0,0,0,0.2);max-width:500px;margin-bottom:30px;}
input,select,button{width:100%;padding:12px;margin:10px 0;border-radius:10px;border:2px solid gold;}
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
<a href="add_candidate.php">Add Position / Candidate</a>
<a href="admin_logout.php">Logout</a>
</div>

<div class="main">
<?php if($message) echo "<div class='message'>$message</div>"; ?>

<div class="card">
<h3>Add Position</h3>
<form method="post">
<input type="text" name="position_name" placeholder="Position Name (e.g Head Girl)" required>
<button type="submit" name="add_position">Add Position</button>
</form>
</div>

<div class="card">
<h3>Add Candidate</h3>
<form method="post" enctype="multipart/form-data">
<input type="text" name="full_name" placeholder="Candidate Full Name" required>
<select name="position_id" required>
<option value="">-- Select Position --</option>
<?php while($p = $positions->fetch_assoc()): ?>
    <option value="<?= $p['id'] ?>"><?= $p['position_name'] ?></option>
<?php endwhile; ?>
</select>
<input type="file" name="photo" accept="image/*" required>
<button type="submit" name="add_candidate">Add Candidate</button>
</form>
</div>

</div>
</body>
</html>

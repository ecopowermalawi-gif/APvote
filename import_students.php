<?php
session_start();
include "db.php";

/* Protect this page */
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['import'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === 0) {

        $file = $_FILES['csv_file']['tmp_name'];

        if (($handle = fopen($file, "r")) !== FALSE) {

            // Skip header row
            fgetcsv($handle);

            $added = 0;
            $skipped = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $full_name  = mysqli_real_escape_string($conn, $data[0]);
                $student_id = mysqli_real_escape_string($conn, $data[1]);
                $password   = password_hash($data[2], PASSWORD_DEFAULT);

                // Check if student_id already exists
                $check = $conn->query("SELECT id FROM students WHERE student_id='$student_id'");

                if ($check->num_rows > 0) {
                    $skipped++;
                } else {
                    $conn->query("INSERT INTO students (full_name, student_id, password)
                                  VALUES ('$full_name', '$student_id', '$password')");
                    $added++;
                }
            }

            fclose($handle);
            $message = "✅ Import completed. Added: $added, Skipped (duplicates): $skipped";
        } else {
            $message = "❌ Could not open the CSV file.";
        }

    } else {
        $message = "❌ No file uploaded or upload error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Import Students</title>
<style>
body { font-family: Arial; background: #e6f2e6; padding: 30px; }
.container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
h2 { text-align: center; color: #1b3a2b; }
input[type=file], button { width: 100%; padding: 12px; margin: 10px 0; border-radius: 10px; border: 2px solid gold; }
button { background-color: #2e7d32; color: white; font-weight: bold; cursor: pointer; }
button:hover { background-color: #1b3a2b; }
.message { text-align: center; margin: 10px 0; font-weight: bold; }
</style>
</head>
<body>

<div class="container">
    <h2>Import Students from CSV</h2>

    <?php if ($message != "") { echo "<div class='message'>$message</div>"; } ?>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit" name="import">Import</button>
    </form>
</div>

</body>
</html>

session_start();
include "db.php";

$student_id = $_POST['student_id'];
$password   = $_POST['password'];

$sql = "SELECT * FROM students WHERE student_id='$student_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {

        if ($row['has_voted'] == 1) {
            die("❌ You have already voted");
        }

        $_SESSION['student_id'] = $row['id'];
        header("Location: vote.php");
        exit();
    }
}

echo "❌ Invalid login details";

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atsikana Pa Ulendo Voting System</title>
<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
<style>
body {margin:0;font-family:Arial,sans-serif;background-color:#e6f2e6;display:flex;justify-content:center;align-items:center;min-height:100vh;}
.container {width:100%;max-width:600px;background-color:white;border-radius:25px;box-shadow:0 8px 25px rgba(0,0,0,0.2);overflow:hidden;padding-bottom:30px;text-align:center;}
.header {background-color:#1b3a2b;padding:40px 20px 25px;display:flex;flex-direction:column;align-items:center;}
.logo {width:176px;height:176px;object-fit:contain;border-radius:50%;border:2px solid gold;background-color:white;margin-bottom:15px;}
.welcome-text {font-family:'Lobster',cursive;font-size:2.4em;color:gold;text-shadow:2px 2px 6px black;}
.tabs {display:flex;gap:20px;margin:20px;}
.tab {flex:1;padding:12px 0;background-color:white;border:2px solid gold;border-radius:30px;font-weight:bold;color:#1b3a2b;cursor:pointer;transition:0.3s;box-shadow:0 4px 6px rgba(0,0,0,0.1);}
.tab:hover,.tab.active{background-color:#2e7d32;color:white;}
.form-container{padding:25px;display:none;}
.form-container.active{display:block;}
h2{color:#1b3a2b;margin-bottom:15px;}
input[type=text],input[type=password],input[type=email]{width:80%;padding:14px 15px;margin:10px auto;display:block;border:2px solid gold;border-radius:30px;font-size:1em;}
input:focus{outline:none;box-shadow:0 0 8px gold;}
button{width:80%;padding:14px;margin-top:18px;background-color:#2e7d32;border:none;border-radius:30px;color:white;font-weight:bold;font-size:1em;cursor:pointer;}
button:hover{background-color:#1b3a2b;}
.register-link{display:block;margin-top:18px;color:#2e7d32;text-decoration:underline;cursor:pointer;}
.register-link:hover{color:gold;}
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <img src="logo.png" alt="School Logo" class="logo">
    <div class="welcome-text">WELCOME TO ATSIKANA PA ULENDO VOTING SYSTEM</div>
  </div>

  <div class="tabs">
    <div class="tab active" onclick="showForm('admin', this)">Admin Login</div>
    <div class="tab" onclick="showForm('student', this)">Student Login</div>
  </div>

  <div id="admin" class="form-container active">
    <h2>Admin Login</h2>
    <form action="admin_login.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>

  <div id="student" class="form-container">
    <h2>Student Login</h2>
    <form action="student_login.php" method="POST">
      <input type="text" name="student_id" placeholder="Student ID" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <span class="register-link" onclick="showForm('register')">Don't have an account? Register here</span>
  </div>

  <div id="register" class="form-container">
    <h2>Student Registration</h2>
    <form action="register.php" method="POST">
      <input type="text" name="full_name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="student_id" placeholder="Student ID" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>
    <span class="register-link" onclick="showForm('student')">Back to Login</span>
  </div>

</div>

<script>
function showForm(formId, tabElement=null){
  document.querySelectorAll('.form-container').forEach(f=>f.classList.remove('active'));
  document.getElementById(formId).classList.add('active');
  if(tabElement){
    document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
    tabElement.classList.add('active');
  }
}
</script>
</body>
</html>

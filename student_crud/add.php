<?php
include 'auth.php';
include 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required.';
    if ($phone === '' || !preg_match('/^[0-9+\-\s]{7,20}$/', $phone)) $errors[] = 'Valid phone required.';

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO students (name,email,phone) VALUES (?,?,?)");
        $stmt->bind_param('sss', $name, $email, $phone);
        if ($stmt->execute()) {
            // Show success message after adding
            echo "<!DOCTYPE html>
            <html>
            <head>
                <title>Added</title>
                <style>
                    body {
                        background: linear-gradient(120deg,#2c3e50,#4ca1af);
                        font-family: Poppins, sans-serif;
                        color: #fff;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        text-align: center;
                    }
                    .card {
                        background: rgba(0,0,0,0.7);
                        padding: 30px;
                        border-radius: 15px;
                        box-shadow: 0 8px 30px rgba(0,0,0,0.4);
                    }
                    h2 { color: #28a745; margin-bottom: 15px; }
                    a { color: #fff; text-decoration: underline; display: block; margin-top: 10px; }
                </style>
            </head>
            <body>
                <div class='card'>
                    <h2>✅ Student added successfully!</h2>
                    <p>Redirecting to student list...</p>
                    <a href='index.php'>Go Now</a>
                </div>
                <script>
                    setTimeout(function(){
                        window.location='index.php';
                    },1500); // 1.5 seconds
                </script>
            </body>
            </html>";
            exit;
        } else {
            $errors[] = "DB error: ".$stmt->error;
        }
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Student</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {background: linear-gradient(135deg,#1f1c2c,#928dab); min-height: 100vh; display: flex; align-items:center; justify-content:center; font-family: 'Segoe UI', sans-serif;}
.glass-card {background: rgba(255,255,255,0.15); backdrop-filter: blur(15px); border-radius:18px; padding:30px; width:100%; max-width:500px; color:#fff; box-shadow:0 8px 30px rgba(0,0,0,0.4);}
.btn-gradient {background: linear-gradient(45deg,#667eea,#764ba2); color:#fff!important; border:none; border-radius:30px; padding:8px 18px; transition:0.3s;}
.btn-gradient:hover {opacity:0.85; transform:translateY(-2px);}
.form-control {border-radius:30px; border:none; padding-left:15px;}
.alert {background: rgba(255,0,0,0.2); color:#ffdede; border:none;}
</style>
</head>
<body>
<div class="glass-card">
  <h2 class="mb-4">➕ Add Student</h2>

  <?php if($errors): ?>
    <div class="alert">
      <ul class="mb-0">
        <?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3"><input name="name" value="<?= htmlspecialchars($name ?? '') ?>" class="form-control" placeholder="👤 Full Name"></div>
    <div class="mb-3"><input name="email" value="<?= htmlspecialchars($email ?? '') ?>" class="form-control" placeholder="📧 Email"></div>
    <div class="mb-3"><input name="phone" value="<?= htmlspecialchars($phone ?? '') ?>" class="form-control" placeholder="📱 Phone"></div>
    <div class="d-flex justify-content-between">
      <a href="index.php" class="btn btn-outline-light">⬅ Back</a>
      <button class="btn btn-gradient">Save Student</button>
    </div>
  </form>
</div>
</body>
</html>

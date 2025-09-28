<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (!$username || !$email || !$password) {
        $error = 'All fields required.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        // check if username or email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=? OR email=? LIMIT 1");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = 'Username or email already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?,?,?,?)");
            $role = 'user'; // default role
            $ins->bind_param("ssss", $username, $email, $hash, $role);
            if ($ins->execute()) {
                header("Location: login.php?registered=1");
                exit;
            } else {
                $error = "Error: " . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>

<html>
<head>
    <title>Register - Student CRUD</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(120deg,#2c3e50,#4ca1af);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-card {
            background: rgba(0,0,0,0.7);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.4);
            width: 600px; /* wider container */
            min-width: 500px;
        }
        h2 { text-align: center; margin-bottom: 20px; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;       /* full width */
            padding: 18px;     /* taller input */
            margin-bottom: 15px;
            border-radius: 8px;
            border: none;
            font-size: 20px;   /* bigger text */
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 8px;
            background-color: #28a745;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .error { 
            background: #ff6b6b; 
            padding: 12px; 
            margin-bottom: 15px; 
            border-radius: 8px; 
            text-align: center; 
        }
        a { 
            color: #fff; 
            text-decoration: underline; 
            display: block; 
            text-align: center; 
            margin-top: 10px; 
            font-size: 16px; 
        }
    </style>
</head>
<body>
    <div class="register-card">
        <h2>Register</h2>
        <?php if($error) { echo "<div class='error'>$error</div>"; } ?>
        <form method="post" action="">
            <input name="username" type="text" placeholder="Username" required>
            <input name="email" type="email" placeholder="Email" required>
            <input name="password" type="password" placeholder="Password" required>
            <input name="confirm_password" type="password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <a href="login.php">Back to Login</a>
    </div>
</body>
</html>

<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {

    // Access Denied HTML
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Access Denied</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(120deg,#2c3e50,#4ca1af);
                font-family: Poppins, sans-serif;
                color: #fff;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .card {
                padding: 30px;
                border-radius: 15px;
                background: rgba(0,0,0,0.7);
                box-shadow: 0 8px 30px rgba(0,0,0,0.4);
                text-align: center;
                max-width: 500px;
            }
            h2 {
                font-size: 36px;
                background: rgba(255,0,0,0.7);
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 20px;
            }
            p {
                font-size: 18px;
                margin: 10px 0;
            }
            .btn {
                display: inline-block;
                margin-top: 15px;
                padding: 12px 20px;
                border-radius: 8px;
                background: #ffb400;
                color: #000;
                text-decoration: none;
                font-weight: 600;
            }
        </style>
        <meta http-equiv="refresh" content="3;url=login.php">
    </head>
    <body>
        <div class="card">
            <h2>⚠ Access Denied!</h2>
            <p>You must log in first to access this page.</p>
            <p>Redirecting to login page...</p>
            <a class="btn" href="login.php">Go to Login</a>
        </div>
    </body>
    </html>';
    
    exit();
}
?>

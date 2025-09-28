<?php
include 'auth.php';
include 'db.php';

if($_SESSION['role'] !== 'admin'){
    // Only admin access message
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Access Denied</title>
        <style>
            body {background: linear-gradient(120deg,#2c3e50,#4ca1af); font-family:Poppins,sans-serif; color:#fff; display:flex; justify-content:center; align-items:center; height:100vh; text-align:center;}
            .card {background: rgba(0,0,0,0.7); padding: 30px; border-radius: 15px; box-shadow:0 8px 30px rgba(0,0,0,0.4);}
            h2 { color:#ff4b5c; margin-bottom:15px; }
            a { color:#fff; text-decoration:underline; display:block; margin-top:10px; }
        </style>
    </head>
    <body>
        <div class='card'>
            <h2>❌ Only admin can delete records!</h2>
            <p>Redirecting to student list...</p>
            <a href='index.php'>Go Now</a>
        </div>
        <script>setTimeout(function(){window.location='index.php';},1500);</script>
    </body>
    </html>";
    exit;
}

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

if($conn->query("DELETE FROM students WHERE id=$id")){
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Deleted</title>
        <style>
            body {background: linear-gradient(120deg,#2c3e50,#4ca1af); font-family: Poppins,sans-serif; color:#fff; display:flex; justify-content:center; align-items:center; height:100vh; text-align:center;}
            .card {background: rgba(0,0,0,0.7); padding:30px; border-radius:15px; box-shadow:0 8px 30px rgba(0,0,0,0.4);}
            h2 { color:#28a745; margin-bottom:15px; }
            a { color:#fff; text-decoration:underline; display:block; margin-top:10px; }
        </style>
    </head>
    <body>
        <div class='card'>
            <h2>✅ Student deleted successfully!</h2>
            <p>Redirecting to student list...</p>
            <a href='index.php'>Go Now</a>
        </div>
        <script>setTimeout(function(){window.location='index.php';},1500);</script>
    </body>
    </html>";
    exit;
} else {
    echo "Error deleting record: ".$conn->error;
}
?>

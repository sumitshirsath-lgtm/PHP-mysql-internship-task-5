<?php
// create_admin.php  (run once then delete)
include 'db.php';

$username = 'admin';
$email = 'admin@example.com';
$plain = '12345';
$hash = password_hash($plain, PASSWORD_DEFAULT); // secure

$stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'admin')");
$stmt->bind_param("sss", $username, $email, $hash);
if ($stmt->execute()) {
    echo "Admin created. Delete this file now.";
} else {
    echo "Error: " . $conn->error;
}
$stmt->close();
$conn->close();

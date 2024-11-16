<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query to fetch user by username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debugging: Check if the user is retrieved correctly
    if (!$user) {
        echo "<script>alert('User not found. Please check your username.'); window.location.href='index.php';</script>";
        exit();
    }

    // Validate password
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Debugging: Check the role value
        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } elseif ($user['role'] === 'user') {
            header("Location: user_dashboard.php");
        } else {
            // Handle unexpected roles
            echo "<script>alert('Invalid role detected. Please contact support.'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid password. Please try again.'); window.location.href='index.php';</script>";
    }
}
?>
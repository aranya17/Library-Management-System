<?php
require 'config.php';
session_start();

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

  if($user && password_verify($password,$user['password'])){
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    header("Location: dashboard.php");
  }else{
    echo "Invalid credentials.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Management System - Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
  <h1>Login</h1>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="registration.php">Register here</a>.</p>
  </div>
  
</body>
</html>
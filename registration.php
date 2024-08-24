<?php
require 'config.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'member';

    $stmt = $conn->prepare("INSERT INTO users(username,password,role) VALUES (?,?,?");
    $stmt->bind_param("sss",$username,$password,$role);
    
    if($stmt->execute()){
        header("Location: login.php");
    }else{
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="post">
            <label for="username">Username : </label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password : </label>
            <input type="password" id="password" name="password"required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
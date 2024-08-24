<?php
require 'config.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$book_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO loans (user_id, book_id, loan_date) VALUES (?, ?, NOW())");
$stmt->bind_param("ii",$user_id,$book_id);

if($stmt->execute()){
    header("Location: dashboard.php");
}else{
    echo "Error: ". $stmt->error;
}
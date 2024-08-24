<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$loan_id = $_GET['id'];

$stmt = $conn->prepare("UPDATE loans SET return_date = NOW(), returned = 1 WHERE id = ?");
$stmt->bind_param("i",$loan_id);

if ($stmt->execute()) {
    header("Location: dashboard.php");
} else {
    echo "Error: " . $stmt->error;
}
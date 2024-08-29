<?php
// include('../includes/db_connect.php');
session_start();

if ($_SESSION['role'] != 'admin') {
    header('Location: ../user/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <main>
        <h2>Welcome, Admin!</h2>
        <p>Use the navigation menu to manage the library.</p>
        <div>
            <a href="manage_books.php">Manage Books</a>
            <a href="issue_book.php">Issue Books</a>
            <a href="return_book.php">Return Books</a>
        </div>
    </main>

    <?php include('../includes/footer.php'); ?>
</body>
</html>

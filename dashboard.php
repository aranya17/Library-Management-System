<?php
require 'config.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$books = $conn->query("SELECT * FROM books");

if($_SERVER["REQUEST_METHOD"]=="POST" && $role == 'admin'){
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $year_published = $_POST['year_published'];

    $stmt = $conn->prepare("INSERT INTO books (title, author, genre, year_published) VALUES (?,?,?,?");
    $stmt->bind_param("sssi", $title, $author, $genre, $year_published);

    if($stmt->execute()){
        header("Location: dashboard.php");
    }else{
        echo "Error: ". $stmt->error;
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    <h1>Library Management System</h1>
    <nav><a href="logout.php">Logout</a></nav>
    </header>
    <main>
    <section class="book-list">
            <h2>Books</h2>
            <ul>
                <?php while ($book = $books->fetch_assoc()): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($book['title']); ?></strong> by 
                        <?php echo htmlspecialchars($book['author']); ?> 
                        (Genre: <?php echo htmlspecialchars($book['genre']); ?>, Year: <?php echo $book['year_published']; ?>)
                        <?php if ($role == 'admin'): ?>
                            <a href="delete_book.php?id=<?php echo $book['id']; ?>">Delete</a>
                            <a href="edit_book.php?id=<?php echo $book['id']; ?>">Edit</a>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>
        <?php if ($role == 'admin'): ?>
        <section class="book-form">
            <h2>Add New Book</h2>
            <form method="post" action="">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>

                <label for="genre">Genre:</label>
                <input type="text" id="genre" name="genre" required>

                <label for="year_published">Year Published:</label>
                <input type="number" id="year_published" name="year_published" required>

                <button type="submit">Add Book</button>
            </form>
        </section>
        <?php endif; ?>
    </main>
</body>
</html>
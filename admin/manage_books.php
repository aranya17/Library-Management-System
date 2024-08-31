<?php
session_start();

if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];

    if (isset($_POST['add_book'])) {
        $sql = "INSERT INTO books (title, author, category) VALUES ('$title', '$author', '$category')";
    } elseif (isset($_POST['edit_book'])) {
        $id = $_POST['id'];
        $sql = "UPDATE books SET title='$title', author='$author', category='$category' WHERE id=$id";
    } elseif (isset($_POST['delete_book'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM books WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Operation successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$books = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>

    <main>
        <h2>Manage Books</h2>
        <form method="post" action="">
            <input type="hidden" name="id" id="book_id">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>
            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required>
            <label for="category">Category:</label>
            <input type="text" name="category" id="category" required>
            <button type="submit" name="add_book">Add Book</button>
            <button type="submit" name="edit_book">Edit Book</button>
            <button type="submit" name="delete_book">Delete Book</button>
        </form>

        <h3>Book List</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $books->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['author']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>

    <?php include('footer.php'); ?>
</body>
</html>

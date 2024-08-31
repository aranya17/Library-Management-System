<?php
session_start();

if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    $issue_date = date('Y-m-d');

    $sql = "INSERT INTO issued_books (book_id, user_id, issue_date) VALUES ($book_id, $user_id, '$issue_date')";

    if ($conn->query($sql) === TRUE) {
        $conn->query("UPDATE books SET available=0 WHERE id=$book_id");
        echo "Book issued successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$books = $conn->query("SELECT * FROM books WHERE available=1");
$users = $conn->query("SELECT * FROM users WHERE role='member'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book</title>
    <link rel="stylesheet" href=style.css">
</head>
<body>
    <?php include('header.php'); ?>

    <main>
        <h2>Issue Book</h2>
        <form method="post" action="">
            <label for="book_id">Book:</label>
            <select name="book_id" id="book_id" required>
                <?php while($row = $books->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                <?php } ?>
            </select>
            <label for="user_id">Member:</label>
            <select name="user_id" id="user_id" required>
                <?php while($row = $users->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
                <?php } ?>
            </select>
            <button type="submit">Issue Book</button>
        </form>
    </main>

    <?php include('footer.php'); ?>
</body>
</html>

<?php
session_start();

if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $issue_id = $_POST['issue_id'];
    $return_date = date('Y-m-d');

    $sql = "UPDATE issued_books SET return_date='$return_date' WHERE id=$issue_id";

    if ($conn->query($sql) === TRUE) {
        $book_id = $conn->query("SELECT book_id FROM issued_books WHERE id=$issue_id")->fetch_assoc()['book_id'];
        $conn->query("UPDATE books SET available=1 WHERE id=$book_id");
        echo "Book returned successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$issued_books = $conn->query("SELECT issued_books.id, books.title, users.username, issued_books.issue_date 
                              FROM issued_books 
                              JOIN books ON issued_books.book_id = books.id 
                              JOIN users ON issued_books.user_id = users.id 
                              WHERE return_date IS NULL");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>

    <main>
        <h2>Return Book</h2>
        <form method="post" action="">
            <label for="issue_id">Issued Book:</label>
            <select name="issue_id" id="issue_id" required>
                <?php while($row = $issued_books->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['title'] . " - " . $row['username']; ?></option>
                <?php } ?>
            </select>
            <button type="submit">Return Book</button>
        </form>
    </main>

    <?php include('footer.php'); ?>
</body>
</html>

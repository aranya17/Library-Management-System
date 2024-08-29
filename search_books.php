<?php
// include('../includes/db_connect.php');
session_start();

if ($_SESSION['role'] != 'member') {
    header('Location: login.php');
    exit();
}

$search_query = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_query = $_POST['search_query'];
}

$books = $conn->query("SELECT * FROM books WHERE title LIKE '%$search_query%' OR author LIKE '%$search_query%' OR category LIKE '%$search_query%'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <main>
        <h2>Search Books</h2>
        <form method="post" action="">
            <input type="text" name="search_query" placeholder="Search by title, author, or category" value="<?php echo $search_query; ?>" required>
            <button type="submit">Search</button>
        </form>

        <h3>Search Results</h3>
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

    <?php include('../includes/footer.php'); ?>
</body>
</html>

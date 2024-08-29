<header>
    <h1>Library Management System</h1>
    <nav>
        <ul>
            <li><a href="Library Management\index.html">Home</a></li>
            <li><a href="user/search_books.php">Search Books</a></li>
            <?php if ($_SESSION['role'] == 'admin') { ?>
                <li><a href="../admin/dashboard.php">Admin Dashboard</a></li>
            <?php } ?>
            <li><a href="../user/logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
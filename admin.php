<?php
session_start();
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="nav-main">
    <ul>
        <li><a href="search.php">Search</a></li>
        <li><a href="admin.php" class="active">Admin Setting</a></li>
        <li><a href="Logout.php" >Logout</a></li>
    </ul>
</nav>

<h1>Admin Settings</h1>

<nav class="nav-main">
    <ul>
        <li><a href="addbook.php">Add Book</a></li>
        <li><a href="updatebook.php">Update Book</a></li>
        <li><a href="deletebook.php">Delete Book</a></li>
    </ul>
</nav>

</body>
</html>

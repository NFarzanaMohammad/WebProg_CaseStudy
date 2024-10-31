<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
session_start(); 
    $is_admin = $_SESSION['is_admin'] ?? 0;
    if ($is_admin != 1) {
        echo "Access denied. You are not authorized to view this page.";
    exit;
}
?>

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
        <li><a href="addbook.php" class="active">Add Book</a></li>
        <li><a href="updatebook.php">Update Book</a></li>
        <li><a href="deletebook.php">Delete Book</a></li>
    </ul>
</nav>



    <?php

        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
            header("Location: Login.php");
            exit;
        }

        include 'db_connect.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $Title = $_POST["Title"]; 
            $Author = $_POST["Author"];
            $Availability = $_POST["Availability"];

            $check = $conn->prepare("SELECT * FROM books WHERE Title = ?");
            $check->bind_param("s", $Title);
            $check->execute();
            $result = $check->get_result();
            if ($result->num_rows > 0) {
                echo '<div class="error-message">The Book Has Already Been Add </div>' ;
            }else {
                $stmt = $conn->prepare("INSERT INTO books (Title, Author, Availability) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $Title, $Author, $Availability);
                if ($stmt->execute()) {
                    echo '<div class="success-message">You have added a new book.</div>';
                } else {
                    echo '<div class="error-message">There is some error: ' . $stmt->error . '</div>';
                }
                
            }
        }
    
    ?>

<form action="Addbook.php" method="post" class="centered-form">
    <label for="Title">Title:</label>
    <input type="text" name="Title" id="Title"><br>

    <label for="Author">Author:</label>
    <input type="text" name="Author" id="Author"><br>

    <label for="Availability">Availability:</label>
    <input type="checkbox" name="Availability" value="1"><br>

    <button type="submit">ADD</button>
</form>

</body>
</html>
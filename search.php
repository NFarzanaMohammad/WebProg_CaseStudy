<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow and Return Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

$is_admin = $_SESSION['is_admin'] ?? 0; 
?>

<nav class="nav-main">
    <ul>
        <li><a href="search.php" class="active">Search</a></li>
        <?php if ($is_admin == 1): ?>
            <li><a href="admin.php">Admin Setting</a></li>
        <?php endif; ?>
        <li><a href="Logout.php" >Logout</a></li>
    </ul>
</nav>

<?php

$searchTerm = '';
$books = [];
$userID = 1; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["searchTerm"])) {
        $searchTerm = $_POST["searchTerm"];

        $query = "SELECT ID, Title, Author, Availability FROM books WHERE Title LIKE ? OR Author LIKE ?";
        $stmt = $conn->prepare($query);
        $likeTerm = "%" . $searchTerm . "%";
        $stmt->bind_param("ss", $likeTerm, $likeTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        }
        $stmt->close();
    }

    if (isset($_POST["borrowID"])) {
        $ID = $_POST["borrowID"];
        $stmt = $conn->prepare("UPDATE books SET Availability = 0 WHERE ID = ?");
        $stmt->bind_param("i", $ID);

        if ($stmt->execute()) {
            echo '<div class="success-message">The book has been borrowed successfully.</div>';
        } else {
            echo '<div class="error-message">There is some error: ' . htmlspecialchars($stmt->error) . '</div>';
        }
        $stmt->close();
    }

    if (isset($_POST["returnID"])) {
        $ID = $_POST["returnID"];
        $stmt = $conn->prepare("UPDATE books SET Availability = 1 WHERE ID = ?");
        $stmt->bind_param("i", $ID);

        if ($stmt->execute()) {
            echo '<div class="success-message">The book has been returned successfully.</div>';
        } else {
            echo '<div class="error-message">There is some error: ' . htmlspecialchars($stmt->error) . '</div>';
        }
        $stmt->close();
    }
}
?>

<form action="" method="post">
    <label for="searchTerm">Search by Title or Author:</label>
    <input type="text" name="searchTerm" id="searchTerm" value="<?php echo htmlspecialchars($searchTerm); ?>">
    <button type="submit">Search</button>
</form>

<?php if (!empty($books)): ?>
    <h2>Search Results:</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Availability</th>
            <th>Action</th>
        </tr>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?php echo htmlspecialchars($book['ID']); ?></td>
                <td><?php echo htmlspecialchars($book['Title']); ?></td>
                <td><?php echo htmlspecialchars($book['Author']); ?></td>
                <td><?php echo $book['Availability'] ? 'Available' : 'Not Available'; ?></td>
                <td>
                    <?php if ($book['Availability']): ?>
                        <form action="" method="post" style="display:inline;">
                            <input type="hidden" name="borrowID" value="<?php echo $book['ID']; ?>">
                            <button type="submit">Borrow</button>
                        </form>
                    <?php else: ?>
                        <form action="" method="post" style="display:inline;">
                            <input type="hidden" name="returnID" value="<?php echo $book['ID']; ?>">
                            <button type="submit">Return</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p>No results found for your search.</p>
<?php endif; ?>
</body>
</html>

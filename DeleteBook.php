<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
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
        <li><a href="addbook.php">Add Book</a></li>
        <li><a href="updatebook.php">Update Book</a></li>
        <li><a href="deletebook.php" class="active">Delete Book</a></li>
    </ul>
</nav>





    <?php
        include 'db_connect.php';


        $books = [];
        $result = $conn->query("SELECT ID, Title, Author, Availability FROM books");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        }

        $selectedID = '';
        $currentTitle = '';
        $currentAuthor = '';
        $currentAvailability = 0;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ID"])) {
            $selectedID = $_POST["ID"];
            foreach ($books as $book) {
                if ($book['ID'] == $selectedID) {
                    $currentTitle = $book['Title'];
                    $currentAuthor = $book['Author'];
                    $currentAvailability = $book['Availability'];
                    break;
                }
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
            $ID = $_POST["ID"];
            $stmt = $conn->prepare("DELETE FROM books WHERE ID = ?");
            $stmt->bind_param("i", $ID);

            if ($stmt->execute()) {
                echo '<div class="success-message">The book has been deleted successfully.</div>';
            } else {
                echo '<div class="error-message">There was an error: ' . $stmt->error . '</div>';
            }
            $stmt->close();
        }
    ?>

    <form action="" method="post" class="centered-form">

        <label for="ID">Select Book ID to Delete:</label>
        <select name="ID" id="ID" onchange="this.form.submit()">
            <option value="">--Select ID--</option>
            <?php foreach ($books as $book): ?>
                <option value="<?php echo $book['ID']; ?>" <?php if ($selectedID == $book['ID']) echo 'selected'; ?>>
                    <?php echo $book['ID']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <p><strong>Title:</strong> <?php echo htmlspecialchars($currentTitle); ?></p>
        <p><strong>Author:</strong> <?php echo htmlspecialchars($currentAuthor); ?></p>
        
        <label for="Availability">Availability:</label>
        <input type="checkbox" name="Availability" id="Availability" disabled <?php if ($currentAvailability == 1) echo 'checked'; ?>><br>

        <?php if ($selectedID): ?>
            <button type="submit" name="delete">Delete Book</button>
        <?php endif; ?>


    </form>
</body>
</html>

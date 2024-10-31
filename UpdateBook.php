<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
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
        <li><a href="updatebook.php" class="active">Update Book</a></li>
        <li><a href="deletebook.php">Delete Book</a></li>
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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
            $ID = $_POST["ID"];
            $Title = $_POST["Title"];
            $Author = $_POST["Author"];
            $Availability = isset($_POST["Availability"]) ? 1 : 0;

            $stmt = $conn->prepare("UPDATE books SET Title = ?, Author = ?, Availability = ? WHERE ID = ?");
            $stmt->bind_param("ssii", $Title, $Author, $Availability, $ID);

            if ($stmt->execute()) {
                echo '<div class="success-message">The book has been updated successfully.</div>';
            } else {
                echo '<div class="error-message">There was an error: ' . $stmt->error . '</div>';
            }
            $stmt->close();
        }
    ?>

    <form action="" method="post" class="centered-form">
        <label for="ID">Select Book ID:</label>
        <select name="ID" id="ID" onchange="this.form.submit()">
            <option value="">--Select ID--</option>
            <?php foreach ($books as $book): ?>
                <option value="<?php echo $book['ID']; ?>" <?php if ($selectedID == $book['ID']) echo 'selected'; ?>>
                    <?php echo $book['ID']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="Title">Title:</label>
        <input type="text" name="Title" id="Title" value="<?php echo $currentTitle; ?>"><br>

        <label for="Author">Author:</label>
        <input type="text" name="Author" id="Author" value="<?php echo $currentAuthor; ?>"><br>

        <label for="Availability">Availability:</label>
        <input type="checkbox" name="Availability" value="1" <?php if ($currentAvailability == 1) echo 'checked'; ?>><br>

        <button type="submit" name="update">Update</button>
    </form>
</body>
</html>

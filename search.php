<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Book Catalog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="catalog-container">
        <header>
            <h1>Book Catalog Search</h1>
            <p>Discover your next read by entering title or author.</p>
        </header>
        
        <form method="GET" action="">
            <div class="input-container">
                <input type="text" name="query" placeholder="Enter book title or author">
                <button type="submit">Search</button>
            </div>
        </form>
        
        <div class="results-container">
            <?php
            $query = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : '';

            // Mock book list - this will be replaced with a database query later
            $books = [
                ["title" => "To Kill a Mockingbird", "author" => "Harper Lee", "available" => "Yes"],
                ["title" => "1984", "author" => "George Orwell", "available" => "No"],
                ["title" => "Moby Dick", "author" => "Herman Melville", "available" => "Yes"],
                ["title" => "The Great Gatsby", "author" => "F. Scott Fitzgerald", "available" => "No"],
                ["title" => "War and Peace", "author" => "Leo Tolstoy", "available" => "Yes"]
            ];

            if ($query !== '') {
                $found = false;
                foreach ($books as $book) {
                    if (strpos(strtolower($book['title']), $query) !== false || strpos(strtolower($book['author']), $query) !== false) {
                        $found = true;
                        echo "<div class='result'>";
                        echo "<strong>Title:</strong> " . htmlspecialchars($book['title']) . "<br>";
                        echo "<strong>Author:</strong> " . htmlspecialchars($book['author']) . "<br>";
                        echo "<strong>Available:</strong> <span class='availability " . strtolower($book['available']) . "'>" . htmlspecialchars($book['available']) . "</span>";
                        echo "</div>";
                    }
                }
                if (!$found) {
                    echo "<p class='no-results'>No books found matching your search.</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>

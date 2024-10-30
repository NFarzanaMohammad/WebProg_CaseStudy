<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Catalog</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e0f7fa;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }
        h1 {
            color: #00796b;
            text-align: center;
        }
        form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
        }
        input[type="text"] {
            padding: 12px;
            width: 300px;
            border-radius: 25px;
            border: 2px solid #00796b;
            margin-right: 10px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }
        input[type="text"]:focus {
            border-color: #004d40;
        }
        button {
            padding: 12px 20px;
            border-radius: 25px;
            border: none;
            background-color: #00796b;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #004d40;
        }
        .result {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .result:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .no-results {
            color: #d32f2f;
            text-align: center;
        }
        .results-container {
            max-width: 600px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Search for Books</h1>
    <form method="GET" action="">
        <input type="text" name="query" placeholder="Enter book title or author">
        <button type="submit">Search</button>
    </form>

    <div class="results-container">
        <?php
        // Sample book data
        $books = [
            ["title" => "To Kill a Mockingbird", "author" => "Harper Lee", "available" => "Yes"],
            ["title" => "1984", "author" => "George Orwell", "available" => "No"],
            ["title" => "Moby Dick", "author" => "Herman Melville", "available" => "Yes"],
            ["title" => "The Great Gatsby", "author" => "F. Scott Fitzgerald", "available" => "No"],
            ["title" => "War and Peace", "author" => "Leo Tolstoy", "available" => "Yes"]
        ];

        // Get the search query
        $query = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : '';

        // Display the filtered book list
        if ($query !== '') {
            $found = false;
            foreach ($books as $book) {
                if (strpos(strtolower($book['title']), $query) !== false || strpos(strtolower($book['author']), $query) !== false) {
                    $found = true;
                    echo "<div class='result'>";
                    echo "<strong>Title:</strong> " . htmlspecialchars($book['title']) . "<br>";
                    echo "<strong>Author:</strong> " . htmlspecialchars($book['author']) . "<br>";
                    echo "<strong>Available:</strong> " . htmlspecialchars($book['available']);
                    echo "</div>";
                }
            }
            if (!$found) {
                echo "<p class='no-results'>No books found matching your search.</p>";
            }
        }
        ?>
    </div>
</body>
</html>

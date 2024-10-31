<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="nav-main">
    <ul>
        <li><a href="Register.php" class="active">Register Account</a></li>
        <li><a href="Login.php">Login</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Create an Account</h2>

    <?php
        include 'db_connect.php';
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
            $email = $_POST["email"]; 
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $check = $conn->prepare("SELECT * FROM users WHERE Email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            $result = $check->get_result();

            if ($result->num_rows > 0) {
                echo '<div class="error-message">The Email you used is already registered.</div>';
            } else {
                $stmt = $conn->prepare("INSERT INTO users (Email, Password, Is_Admin) VALUES (?, ?, 0)");
                $stmt->bind_param("ss", $email, $password);
                if ($stmt->execute()) {
                    header("Location: Login.php");
                    exit; 
                } else {
                    echo '<div class="error-message">There was an error: ' . htmlspecialchars($stmt->error) . '</div>';
                }
            }
        }
    ?>

    <form action="Register.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>

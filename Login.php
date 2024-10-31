<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="nav-main">
    <ul>
        <li><a href="Register.php">Register Account</a></li>
        <li><a href="Login.php" class="active">Login</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Login to Your Account</h2>
    
    <?php
    session_start();
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['Password'])) {
                $_SESSION['user_id'] = $user['ID'];
                $_SESSION['is_admin'] = $user['Is_Admin'];
                header("Location: search.php");
                exit; // Ensure no further code is executed after redirection
            } else {
                echo '<div class="error-message">Incorrect password.</div>';
            }
        } else {
            echo '<div class="error-message">No user found with this email.</div>';
        }
    }
    ?>

    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>

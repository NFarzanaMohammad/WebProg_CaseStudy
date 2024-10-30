<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
                echo "The Email you use already registered";
            }else {
                $stmt = $conn->prepare("INSERT INTO users (Email, Password, Is_Admin) VALUES (?, ?, 0)");
                $stmt->bind_param("ss", $email, $password);
                if ($stmt->execute()) {
                    echo "You Has Been Registered";
                }else {
                    echo "There is some error : " . $stmt->error;
                }
            }
        }
        
    ?>

    <form action="Register.php" method="post">
    Email: <input type="email" name="email" ><br>
    Password: <input type="password" name="password" ><br>
    <button type="submit">Register</button>
    </form>
</body>
</html>
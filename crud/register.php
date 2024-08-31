<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Register user </title>
</head>
<body>
    <h1>New around here? Register!</h1>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Name" required><br><br>
        <input type="email" name="email" placeholder="E-mail" required><br><br>
        <input type="password" name="pass" placeholder="Password" required minlength="8"><br><br>
        <input type="submit" value="Register">
    </form><br><br>
    <?php
        if($_SERVER['REQUEST_METHOD'] === "POST") {
            include "./connection.php";

            $email = $_POST['email'];
            $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
            $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
            $pass = password_hash($pass, PASSWORD_DEFAULT);

            $query = "INSERT INTO users
                      VALUES(
                          '{$name}',
                          '{$email}',
                          '{$pass}'
                      )";
            
            try {
                mysqli_query($conn, $query);
                echo "New user registered.<br><br>";
            }
            catch(mysqli_sql_exception) {
                if(mysqli_errno($conn) === 1062) {
                    echo "E-mail address is already registered.<br><br>";
                }
                else {
                    echo "Couldn't register user.<br><br>";
                }
            }
            finally {
                mysqli_close($conn);
            }
        
        }
    ?>
    <a href="index.php"><- Back</a>
</body>
</html>


<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Log-in </title>
</head>
<body>
    <h1>Welcome back! Please log-in to proceed.</h1>
    <form action="" method="POST">
        <input type="email" name="email" placeholder="E-mail" required><br><br>
        <input type="password" name="pass" placeholder="Password" required minlength="8"><br><br>
        <input type="submit" value="Log-in">
    </form><br><br>
    <?php
        if($_SERVER['REQUEST_METHOD'] === "POST") {

            if(isset($_SESSION['name'])) exit("You're already logged in.");

            include "./connection.php";

            $email = $_POST['email'];
            $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);

            $query = "SELECT * FROM users WHERE email = '{$email}'";
            
            try {
                $res = mysqli_query($conn, $query);
                
                if(mysqli_num_rows($res) > 0) {
                    $res = mysqli_fetch_assoc($res);

                    if(password_verify($pass, $res['password'])) {
                        $_SESSION['name'] = $res['name'];
                        $_SESSION['email'] = $res['email'];

                        header("Location: index.php");
                    }
                    else {
                        echo "Wrong credentials.<br><br>";
                    }
                }
                else {
                    echo "User doesn't exist.<br><br>";
                }
            }
            catch(mysqli_sql_exception) {
                echo "Couldn't log-in.<br><br>";
            }
            finally {
                mysqli_close($conn);
            }
        
        }
    ?>
    <a href="index.php"><- Back</a>
</body>
</html>


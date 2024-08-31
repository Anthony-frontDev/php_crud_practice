<?php
    session_start();
    $username = isset($_SESSION['name']) ? $_SESSION['name'] : "Guest";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Homepage | CRUD Practice </title>
</head>
<body>
    <h1>Hello, <?php echo $username ?>!</h1>
    <h4>Options:</h4>
    <a href="login.php">Log-in</a><br><br>
    <a href='register.php'>Register new users</a><br><br>
    <?php
        if(isset($_SESSION['email'])) {
            echo "<a href='table.php'>Consult user records</a><br><br><br>";
            echo "
                <form action='' method='POST'>
                    <input type='submit' value='Log-out' name='logout_btn'>
                </form>
            ";
        }
    ?>
</body>
</html>
<?php
    if(isset($_POST['logout_btn'])) {
        session_unset();
        session_destroy();
        header("Refresh:0");
    }
?>
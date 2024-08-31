<?php
    session_start();

    $old_email = $_GET['email'];
    $old_name = $_GET['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Log-in </title>
</head>
<body>
    <h1>User informations update.</h1>
    <form action="" method="POST">
        <input type="name" name="name" placeholder="Name" value="<?php echo $old_name ?>" required><br><br>
        <input type="email" name="email" placeholder="E-mail" value="<?php echo $old_email ?>" required><br><br>
        <input type="submit" value="Update">
    </form><br><br>
    <?php    
        if($_SERVER['REQUEST_METHOD'] === "POST") {
            include "./connection.php";

            $new_email = $_POST['email'];
            $new_name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        
            $sql = "UPDATE users 
                    SET email='{$new_email}', name='{$new_name}'
                    WHERE email='{$old_email}'";

            try {
                mysqli_query($conn, $sql);
                if($_SESSION['email'] === $old_email) {
                    $_SESSION['name'] = $new_name;
                    $_SESSION['email'] = $new_email;
                }
                header("Location: ./table.php");
            }
            catch(mysqli_sql_exception) {
                if(mysqli_errno($conn) === 1062) {
                    echo "E-mail address is already registered.<br><br>";
                }
                else {
                    echo "Couldn't update user.<br><br>";
                }
            }
            finally {
                mysqli_close($conn);
            }
        }
    ?>
    <a href="table.php"><- Back</a>
</body>
</html>



<?php
    session_start();

    include "./connection.php";

    $sql = "SELECT name, email FROM users";

    try {
        $res = mysqli_query($conn, $sql);
    }   
    catch(mysqli_sql_exception) {
        echo "Couldn't fetch data.";
    }   
    finally {
        mysqli_close($conn);
    } 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users table</title>
</head>
<body>
    <h1>Showing all existing records.</h1>
    <?php 
        if(mysqli_num_rows($res) == 0) {
            echo "Table has no records.";
        } 
    ?>
    <table border="1">
        <tr>
            <th>NAME</th>
            <th>E-MAIL</th>
            <th>ACTIONS</th>
        </tr>
        <?php
            if(mysqli_num_rows($res) > 0) {
                while($arr = mysqli_fetch_assoc($res)) {
                    echo "<tr>";
                    echo "<td>{$arr['name']}</td>" ;
                    echo "<td>{$arr['email']}</td>" ;
                    echo "<td>";
                    if($_SESSION['email'] !== $arr['email']) {
                        echo "
                            <a href='./table.php?email={$arr['email']}'>
                                <button>DELETE</button>
                            </a>
                            ";
                    }
                    echo "</td>";
                    echo "<td>";
                    echo "
                        <a href='./update.php?email={$arr['email']}&name={$arr['name']}'>
                            <button>UPDATE</button>
                        </a>
                        ";
                    echo "</td>"; 
                    echo "</tr>";
                }
            }
        ?>
    </table><br><br>
    <a href="index.php"><- Back</a>
</body>
</html>
<?php
    include "./connection.php";

    $email = isset($_GET['email']) ? $_GET['email'] : null;

    $sql = "DELETE FROM users WHERE email = '{$email}'";

    if(isset($email)) {
        try {
            $res = mysqli_query($conn, $sql);
            echo "User deleted.";
            header("Refresh:0");
        }   
        catch(mysqli_sql_exception) {
            echo "Couldn't delete user.";
        }   
        finally {
            mysqli_close($conn);
            header("Location: ./table.php");
        }
    }
?>
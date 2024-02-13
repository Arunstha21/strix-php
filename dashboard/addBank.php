<?php
    session_start();

    $redirect = "../index.php";
    if(isset($_SESSION["login"])){
    } else {
        header("Location: $redirect");
    }

    include './connect.php';
    if (isset($_POST['addCT'])) {
        $id = $_POST['addCT'];

        $query = "SELECT * FROM `player_data` WHERE id ='$id'";
        $result = mysqli_query($connection, $query);
        $qres = mysqli_fetch_assoc($result);
        $name = $qres['name'];
    }

    if(isset($_POST['submit'])){
        $uid = $_POST['uid'];
        $cashtag = $_POST['cashTag'];

        $query = "INSERT INTO cashtag(uid, cashTag) VALUES ('$uid','$cashtag')";
        echo "$query <br>";
        $res = mysqli_query($connection, $query);
        if($res){
            echo "CashTag addeed Succesfully !!";
            header("Location: userList.php");
            exit();
        }else {
            echo "Error in data Insert". mysqli_error($connection);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Data</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body style="margin-top: 10%;">
    <h1>Add Bank</h1>
    <form action="" method="post">
        <label for="">Full Name</label>
        <input type="text" name="name" value='<?php echo $name?>' readonly><br>
        <label for="">Bank</label>
        <input type="text" name="cashTag" required><br>
        <input type="hidden" name="uid" value="<?php echo $id?>">

        <input type="submit" name="submit">
    </form>
    <h4><?php echo isset($message) ? $message : ''; ?></h4>
    <h3><a href='userList.php' class="button">User List</a></h3>
</body>
</html>
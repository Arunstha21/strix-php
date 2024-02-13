<?php
    session_start();

    $redirect = "../index.php";
    if(isset($_SESSION["login"])){
    } else {
        header("Location: $redirect");
    }

    include './connect.php';
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $cashTag = $_POST['cashTag'];

        $name = "INSERT INTO player_data(name) VALUES ('$name')";
        $nres = mysqli_query($connection, $name);
        if ($nres) {
            $uid = mysqli_insert_id($connection);
            
            $cashTagq = "INSERT INTO cashTag(uid, cashTag) VALUES ('$uid', '$cashTag')";
            $cres = mysqli_query($connection, $cashTagq);
            
            if ($cres) {
                $message = "User Inserted Successfully!";
            } else {
                $message = "Error Inserting cash tag!";
            }
        } else {
            $message = "Error Inserting User info!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body style="margin-top: 10%;">
    <h1>Add User</h1>
    <form action="" method="post">
        <label for="">Full Name</label>
        <input type="text" name="name" required><br>
        <label for="">Bank Name</label>
        <input type="text" name="cashTag" required><br>

        <input type="submit" name="submit">
    </form>
    <h4><?php echo isset($message) ? $message : ''; ?></h4>
    <h3><a href='transaction.php' class="button">Transaction Details</a></h3>
    <h3><a href='userList.php' class="button">User List</a></h3>
    <h3><a href='../dashboard.php' class="button">Dashboard</a></h3>
</body>
</html>
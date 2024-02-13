<?php
    include 'dashboard/connect.php';
    session_start();

    if (isset($_POST['submit'])) {
        $userName = $_POST['userName'];
        $password = $_POST['password'];

        $auth = "SELECT userName, password FROM user_data WHERE userName = '$userName' and password = '$password'";
        $result = mysqli_query($connection, $auth);

        if ($result == false) {
            $errorMessage = "Incorrect User Name or Password";
        }

        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 1) {
            $_SESSION["login"] = "OK";
            $_SESSION["userName"] = $userName;
            $redirect = "dashboard.php";
        } else {
            $_SESSION['errorMessage'] = true;
            $redirect = "index.php";
        }
        mysqli_free_result($result);
        mysqli_close($connection);

        header("Location: $redirect");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="dashboard/signup.css">
</head>
<body style="margin-top: 10%;">
    <h1>Login</h1>
    <form action="" method="post">
        <label for="userName">User Name</label>
        <input type="text" name="userName" required><br>
        <label for="password">Password</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="submit" value="submit">
        <?php
            if (isset($_SESSION['errorMessage'])) {
                echo "<p style='color: red; font-weight: bolder;'>Invalid user name or password !!</p>";
            }
        ?>
    </form>
    <h3><a href="signup.php" class="button">Create new account</a></h3>
</body>
</html>
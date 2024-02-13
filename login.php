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
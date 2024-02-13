<?php
    include 'dashboard/connect.php';
    if(!$connection) {
        echo "Error connecting to Database";
    }else{
        if(isset($_POST['submit'])){
            $fullName = $_POST['fullName'];
            $address = $_POST['address'];
            $userName = $_POST['userName'];
            $password = $_POST['password'];

            $query = "INSERT INTO user_data(fullName, address, userName, password) VALUES('$fullName', '$address', '$userName', '$password')";
            echo "$query <br>";
            $res = mysqli_query($connection, $query);
            echo "$res <br>";

            if($res){
                echo "Registration successfull  <br>";
                header("Location: index.php");
                exit();
            }else{
                echo "Error in Data Insert <br>". mysqli_error($connection);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup User Data</title>
    <link rel="stylesheet" href="dashboard/signup.css">
</head>
<body style="margin-top: 10%;">
    <h1>Sign Up</h1>
    <form action="signup.php" method="post">
        <label for="Full Name">Full Name</label>
        <input type="text" Name="fullName"><br>
        <label for="address">Address</label>
        <input type="text" name="address"><br>
        <label for="User Name">User Name</label>
        <input type="text" name="userName"><br>
        <label for="password">Password</label>
        <input type="password" name="password"><br>
        <input type="submit" name="submit" value="submit">
    </form>
    <h3><a href="index.php" class="button">Already have an account</a></h3>
</body>
</html>
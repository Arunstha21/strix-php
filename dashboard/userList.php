<?php
    session_start();

    $redirect = "../index.php";
    if(isset($_SESSION["login"])){
    } else {
        header("Location: $redirect");
    }

    include './connect.php';
    $player = "SELECT * FROM `player_data`";
    $presult = mysqli_query($connection, $player);

    if(isset($_POST['delete'])){
        $deleteid = $_POST['delete'];
        $deleteQuery = "DELETE FROM `player_data` WHERE id='$deleteid'";
        $deleteResult = mysqli_query($connection, $deleteQuery);
        if($deleteResult){
            echo "Employee data delete successfull !!";

            header("Refresh:0");
        }else{
            echo "Error deleting record: " . mysqli_error($connection);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <link rel="stylesheet" href="common.css">
</head>
<body style="margin-top: 10%;">
    <h1>User Data</h1>
    <h3><a href='../dashboard.php' class="button">Dashboard</a></h3>
    <table>
        <thead>
            <tr>
                <th>User Id</th>
                <th>Full Name</th>
                <th>Bank</th>
                <th>Add Bank</th>
                <!-- <th>Edit</th> -->
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php

                while($row = mysqli_fetch_assoc($presult)){
                    $uid = $row['id'];
                    $cashTagQuery = "SELECT * FROM `cashTag` WHERE uid='$uid'";
                    $cresult = mysqli_query($connection, $cashTagQuery);
                    $cid = null;

                    echo "<tr>";
                    echo "<td>" .$row['id']. "</td>";
                    echo "<td>" .$row['name']. "</td>";

                    echo "<td>";
                    echo '<select name="cashTag">';
                    while ($cTag = mysqli_fetch_assoc($cresult)) {
                        echo '<option value="' . $cTag['id'] . '">' . $cTag['cashTag'] . '</option>';
                        $cid = $cTag['id'];
                    }
                    echo "</td>";
                    echo '<td><form action="addBank.php" method="POST"><button type="submit" name="addCT" value="'.$row['id'].'">Add Bank</button></form></td>';
                    // echo '<td><form action="" method="POST"><button type="submit" name="edit" value="'.$row['id'].'">Edit</button></form></td>';
                    echo '<td><form action="" method="POST"><button type="submit" name="delete" value="'.$row['id'].'">Delete</button></form></td>';
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    <h3><a href='transaction.php' class="button">Transaction Details</a></h3>
    <h3><a href='addUser.php' class="button">Insert New User</a></h3>
</body>
</html>
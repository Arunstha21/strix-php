<?php
    session_start();

    $redirect = "../index.php";
    if(isset($_SESSION["login"])){
    } else {
        header("Location: $redirect");
    }

    include './connect.php';
    if (isset($_POST['amount'])) {
        $id= $_POST['amount'];
        $player = "SELECT * FROM `player_data` WHERE id='$id'";
        $presult = mysqli_query($connection, $player);
        $name = mysqli_fetch_assoc($presult);
        $cashT = "SELECT * FROM `cashTag` WHERE uid='$id'";
        $cresult = mysqli_query($connection, $cashT);

        $uid = $name['id'];
    }
    
    if (isset($_POST['insert'])) {
        $cashIn = $_POST['cash'];
        $userId = $_POST['uid'];
        $cashId = $_POST['cid'];
        $date = date('y-m-d');

        $query = "INSERT INTO cashin(uid, cid, amount, date) VALUES ('$userId', '$cashId', '$cashIn', '$date')";
        $insert = mysqli_query($connection, $query);
        if($insert){
            echo "Cash In successfull !!";
            header("Location: transaction.php");
            exit();
        }else {
            echo "Cash in data Insert". mysqli_error($connection);
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash In</title>
    <link rel="stylesheet" href="common.css">

</head>
<body style="margin-top: 10%;">
    <h2>Cash In</h2>
    <table>
        <thead>
            <tr>
                <th>User Id</th>
                <th>Full Name</th>
                <th>Bank Name</th>
                <th>Cash in</th>
                <th>Submit</th>
            </tr>
        </thead>
        <tbody>
            <?php
                echo "<tr>";
                echo "<td>" .$uid. "</td>";
                echo "<td>" .$name['name']. "</td>";
                echo "<td>";
                echo '<select name="cashTag">';
                while ($cTag = mysqli_fetch_assoc($cresult)) {
                    echo '<option value="' . $cTag['id'] . '">' . $cTag['cashTag'] . '</option>';
                    $cid = $cTag['id'];
                }
                echo "</td>";
                echo '<form action="" method="post">';
                echo "<td>";
                echo '<input type="number" name="cash">';
                echo "</td>";
                echo "<td>";
                echo '<input type="hidden" name="uid" value="' . $uid . '">';
                echo '<input type="hidden" name="cid" value="' . $cid . '">';
                echo '<input type="submit" name="insert">';
                echo "</td>";
                echo '</form>';
                echo "</tr>";
            ?>
        </tbody>
    </table>
</body>
</html>

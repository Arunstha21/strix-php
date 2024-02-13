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
        $balance = $_POST['balance'];

        $player = "SELECT * FROM `player_data` WHERE id='$id'";
        $presult = mysqli_query($connection, $player);
        $name = mysqli_fetch_assoc($presult);
        $cashT = "SELECT * FROM `cashTag` WHERE uid='$id'";
        $cresult = mysqli_query($connection, $cashT);

        $uid = $name['id'];
    }

    if (isset($_POST['insert'])) {
        $cashOut = $_POST['cash'];
        $userId = $_POST['uid'];
        $cashId = $_POST['cid'];
        $date = date('y-m-d');
        $bamt = $_POST['bamt'];

        if($cashOut<=$bamt){
            $query = "INSERT INTO cashout(uid, cid, amount, date) VALUES ('$userId', '$cashId', '$cashOut', '$date')";
            $insert = mysqli_query($connection, $query);
            if($insert){
                echo "Cash Out successfull !!";
                header("Location: transaction.php");
                exit();
            }else {
                echo "Cash Out data Insert". mysqli_error($connection);
            }
        }else{
            $id = $userId;
            $balance = $bamt;
            $error = true;
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
    <h2>Cash Out</h2>
    <table>
        <thead>
            <tr>
                <th>User Id</th>
                <th>Full Name</th>
                <th>Bank</th>
                <th>Cash Out</th>
                <th>Submit</th>
            </tr>
        </thead>
        <tbody>
            <?php   
                    $player = "SELECT * FROM `player_data` WHERE id='$id'";
                    $presult = mysqli_query($connection, $player);
                    $name = mysqli_fetch_assoc($presult);
                    $cashT = "SELECT * FROM `cashTag` WHERE uid='$id'";
                    $cresult = mysqli_query($connection, $cashT);
            
                    $uid = $name['id'];
                echo "<tr>";
                echo "<td>" .$name['id']. "</td>";
                echo "<td>" .$name['name']. "</td>";
                echo "<td>";
                echo '<select name="cashTag">';
                while ($cTag = mysqli_fetch_assoc($cresult)) {
                    echo '<option value="' . $cTag['id'] . '">' . $cTag['cashTag'] . '</option>';
                    $cid = $cTag['id'];
                }
                echo "</td>";
                echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
                echo "<td>";
                echo '<input type="number" name="cash">';
                echo "</td>";
                echo "<td>";
                echo '<input type="hidden" name="uid" value="' . $uid . '">';
                echo '<input type="hidden" name="cid" value="' . $cid . '">';
                echo '<input type="hidden" name="bamt" value="' . $balance. '">';
                echo '<input type="submit" name="insert">';
                echo "</td>";
                echo '</form>';
                echo "</tr>";

            ?>
        </tbody>
    </table>
    <?php
    if (isset($error)) {
        echo "<p style='color: red; font-weight: bolder; text-align: center;'>Balance amount is higher then Cash Out amount !!</p>";
    }
    ?>
</body>
</html>
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
    $uid ="";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Data</title>
    <link rel="stylesheet" href="common.css">
</head>
<body style="margin-top: 8%;">
    <h1>User Data</h1>
    <form action="" class="date" method="post">
        <h3>From:</h3><br>
        <input type="date" name="dateFrom" required>
        <h3>TO:</h3><br>
        <input type="date" name="dateTo" required>
        <input type="submit" class="dateSubmit" name="dateSubmit" value="Filter">
    </form>
    <h3 class="dashboard"><a href='../dashboard.php' class="button">Dashboard</a></h3>
    <table>
        <thead>
            <tr>
                <th>User Id</th>
                <th>User Name</th>
                <th>Total Cash in</th>
                <th>Total Cash Out</th>
                <th>Balance</th>
                <th>Add Cash in</th>
                <th>Add Cash Out</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(isset($_POST['dateSubmit'])){
                    $startDate = $_POST['dateFrom'];
                    $endDate = $_POST['dateTo'];
                    while($row = mysqli_fetch_assoc($presult)){

                    $uid = $row['id'];
                    $cashTagQuery = "SELECT * FROM `cashTag` WHERE uid='$uid'";
                    $cresult = mysqli_query($connection, $cashTagQuery);
                    $cid = null;

                    echo "<tr>";
                    echo "<td>" .$row['id']. "</td>";
                    echo "<td>" .$row['name']. "</td>";

                    $cashinq = "SELECT * FROM `cashin` WHERE uid='$uid' AND date between '$startDate' AND '$endDate'";
                    $cashin = mysqli_query($connection, $cashinq);
                    $cashInAmt = 0;
                    while ($cashinRow = mysqli_fetch_assoc($cashin)) {
                        $cashInAmt += $cashinRow['amount'];
                    }

                    $cashoutq = "SELECT * FROM `cashout` WHERE uid='$uid' AND date between '$startDate' AND '$endDate'";
                    $cashout = mysqli_query($connection, $cashoutq);
                    $cashOutAmt = 0;
                    while ($cashOutRow = mysqli_fetch_assoc($cashout)) {
                        $cashOutAmt += $cashOutRow['amount'];
                    }
                    $balance = $cashInAmt - $cashOutAmt;

                    echo "<td>" .$cashInAmt. "</td>";
                    echo "<td>" .$cashOutAmt. "</td>";
                    echo "<td>" .$balance. "</td>";
                    echo '<td><form action="cashin.php" method="post"><button type="submit" name="amount" value="'.$row['id'].'">Cash in</button></form></td>';
                    echo '<td><form action="cashout.php" method="POST"><input type="hidden" name="balance" value="' . $balance . '"><button type="submit" name="amount" value="'.$row['id'].'">Cash Out</button></form></td>';
                    echo "</tr>";
                }
                }else{
                    while($row = mysqli_fetch_assoc($presult)){
                    $uid = $row['id'];
                    $cashTagQuery = "SELECT * FROM `cashTag` WHERE uid='$uid'";
                    $cresult = mysqli_query($connection, $cashTagQuery);
                    $cid = null;

                    echo "<tr>";
                    echo "<td>" .$row['id']. "</td>";
                    echo "<td>" .$row['name']. "</td>";

                    $cashinq = "SELECT * FROM `cashin` WHERE uid='$uid'";
                    $cashin = mysqli_query($connection, $cashinq);
                    $cashInAmt = 0;
                    while ($cashinRow = mysqli_fetch_assoc($cashin)) {
                        $cashInAmt += $cashinRow['amount'];
                    }

                    $cashoutq = "SELECT * FROM `cashout` WHERE uid='$uid'";
                    $cashout = mysqli_query($connection, $cashoutq);
                    $cashOutAmt = 0;
                    while ($cashOutRow = mysqli_fetch_assoc($cashout)) {
                        $cashOutAmt += $cashOutRow['amount'];
                    }
                    $balance = $cashInAmt - $cashOutAmt;

                    echo "<td>" .$cashInAmt. "</td>";
                    echo "<td>" .$cashOutAmt. "</td>";
                    echo "<td>" .$balance. "</td>";
                    echo '<td><form action="cashin.php" method="post"><button type="submit" name="amount" value="'.$row['id'].'">Cash in</button></form></td>';
                    echo '<td><form action="cashout.php" method="POST"><input type="hidden" name="balance" value="' . $balance . '"><button type="submit" name="amount" value="'.$row['id'].'">Cash Out</button></form></td>';
                    echo "</tr>";
                }}
            ?>
        </tbody>
    </table>
    <h3><a href='addUser.php' class="button">Insert New User</a></h3>
    <h3><a href='userList.php' class="button">User List</a></h3>
</body>
</html>
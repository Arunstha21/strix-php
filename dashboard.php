<?php
    session_start();

    $redirect = "index.php";
    if(isset($_SESSION["login"])){
    } else {
        header("Location: $redirect");
    }
    include 'dashboard/connect.php';
    $user = "SELECT * FROM `player_data`";
    $uresult = mysqli_query($connection, $user);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Page</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="top">
    <div class="header">
        <div class="left">
            <h4>Name : Arun Shrestha</h4>
            <h4>TU Reg : 43413212</h4>
            <h2>Strix</h2>
        </div>
        <div class="container">
            <div id="navbar">
                <ul>
                    <li><a href="dashboard/index.php">Home</a></li>
                    <li class="dropdown">
                        <a href="#">User Management</a>
                        <ul class="dropdown-content">
                            <li><a href="dashboard/addUser.php">Add User</a></li>
                            <li><a href="dashboard/userList.php">Users List</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="dashboard/transaction.php">Transaction Details</a>
                        <ul class="dropdown-content">
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="right">
            <a href="logout.php" class="button">Logout</a>
        </div>
    </div>
</div>
    <div class="body">
        <?php
            while($row = mysqli_fetch_assoc($uresult)){
                $uid = $row['id'];
                
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

                echo "<div class='box front'>";
                echo "<h1 class='name'>".$row['name']."</h1>";
                echo "<table class='table'>";
                echo "<tr><th>Cash In</th>";
                echo "<td>" .$cashInAmt. "</td>";
                echo "</tr><tr>";
                echo "<th>Cash Out</th>";
                echo "<td>" .$cashOutAmt. "</td>";
                echo "</tr><tr>";
                echo "<th>Balance</th>";
                echo "<td>" .$balance. "</td>";
                echo "</tr>";
                echo "</table>";
                echo '<td><form action="dashboard/cashin.php" method="post"><button type="submit" name="amount" value="'.$row['id'].'">Cash in</button></form></td>';
                echo '<td><form action="dashboard/cashout.php" method="POST"><input type="hidden" name="balance" value="' . $balance . '"><button type="submit" name="amount" value="'.$row['id'].'">Cash Out</button></form></td>';
                echo "</div>";

            }
        ?>
    </div>
    <footer class="footer">
        <div class="fot-content">
            <div class="info">
                <ul>
                    <a>Contact Info</a>
                    <li>9815922201</li>
                </ul>
                <ul>
                    <a>Address</a>
                    <li>Koteshowor, Kathamndu</li>
                </ul>
            </div>
            <div class="bottom-right">
                <p>&copy; 2023 Strix. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
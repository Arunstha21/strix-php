<?php
    session_start();

    $redirect = "login.php";
    if(isset($_SESSION["login"])){
    } else {
        header("Location: $redirect");
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <div id="sidebar">
            <ul>
                <li><a href="dashboard/index.php">Home</a></li>
                <li class="dropdown">
                    <a href="#">User Management</a>
                    <ul class="dropdown-content">
                        <li><a href="dashboard/addUser.php">Add User</a></li>
                        <li><a href="dashboard/userList.php">Users List</a></li>
                        <li><a href="dashboard/addBank.php">Add Bank</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Transaction Details</a>
                    <ul class="dropdown-content">
                        <li><a href="dashboard/transaction.php">Transaction Details</a></li>
                        <li><a href="dashboard/cashin.php">Cash In</a></li>
                        <li><a href="dashboard/cashout.php">Cash Out</a></li>
                    </ul>
                </li>
                <a href="logout.php">Logout</a>
            </ul>
        </div>

        <div id="content">
            <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                switch ($page) {
                    case 'home':
                        include 'dashboard/summary.php';
                        break;
                    case 'addUser':
                        include 'dashboard/addUser.php';
                        break;
                    case 'userList':
                        include 'dashboard/userList.php';
                        break;
                    case 'addBank.php':
                        include 'dashboard/addBank.php';
                        break;
                    case 'transaction':
                        include 'dashboard/transaction.php';
                        break;
                    case 'cashin':
                        include 'dashboard/cashin.php';
                        break;
                    case 'cashout':
                        include 'dashboard/cashout.php';
                        break;
                    default:
                        include 'dashboard/summary.php';
                        break;
                }
            ?>
        </div>
    </div>

    <script src="dashboard.js"></script>
</body>
</html>

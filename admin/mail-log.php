<?php
    session_start();
    include("../config/db.php");
    if($_SESSION['role']!='admin')
        {
            header("Location: ../authentication/login.php");
            exit();
        }

    $sql = "SELECT * FROM email_logs ORDER BY id DESC";
    $res = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="add-products.php">Add Products</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="manage-orders.php">Manage Orders</a></li>
                <li><a href="send-cart-reminder.php">Send Cart Reminder</a></li>
                <li><a href="../authentication/logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
<div class="main-content">
    <div class="table-wrapper">

    
    <h1>History of send emails</h1>

    <table class="tbl-full1">
    <tr>
            <th>S.N.</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Email Type</th>
            <th>Status</th>
            <th>User Id</th>
            <th>Time</th>
    </tr>

            <?php
            $sn = 1;
            while($row=mysqli_fetch_assoc($res))
            {
            ?>
            <tr>

            <td>
            <?php echo $sn++; ?>
            </td>
            <td>
            <?php echo $row['email']; ?>
            </td>

            <td>
            ৳ <?php echo $row['subject']; ?>
            </td>

            <td>
            <?php echo $row['email_type']; ?>
            </td>

            <td>
            <?php echo $row['status']; ?>
            </td>

            <td>
            <?php echo $row['user_id']; ?>
            </td>

            <td>
            <?php echo $row['sent_at']; ?>
            </td>

            </tr>

            <?php
            }
            ?>
    </table>
    </div>
</div>

<?php
        include("../partials/footer.php");
    ?>
</body>
</html>
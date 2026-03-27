<?php
session_start();
include("../config/db.php");

if($_SESSION['role']!='admin')
{
    header("Location: ../authentication/login.php");
    exit();
}

$sql = "SELECT orders.*, users.name 
        FROM orders
        JOIN users ON orders.user_id = users.user_id
        ORDER BY order_date DESC";

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
                <li><a href="send-cart-reminder.php">Send Cart Reminder</a></li>
                <li><a href="mail-log.php">Email Logs</a></li>
                <li><a href="../authentication/logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>

    <div class="text-center">
    <h2>Manage Orders</h2>
    </div>
<?php
while($row = mysqli_fetch_assoc($res))
{
?>
<div class="container">
<form method="POST">
    Order ID: <?php echo $row['order_id']; ?><br>
    Customer: <?php echo $row['name']; ?><br>
    Total: <?php echo $row['total_amount']; ?><br>

    Status: <?php echo $row['status'];?><br><br>
    <a href="update-order-status.php?id=<?php echo $row['order_id']; ?>" class="btn1">
    Update Status
    </a>
</form>
</div>
<?php
}
?>
</div>

<?php
        include("../partials/footer.php");
    ?>
</body>
</html>
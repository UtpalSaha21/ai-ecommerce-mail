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

<h2>Manage Orders</h2>

<?php
while($row = mysqli_fetch_assoc($res))
{
?>
<form method="POST">
    Order ID: <?php echo $row['order_id']; ?><br>
    Customer: <?php echo $row['name']; ?><br>
    Total: <?php echo $row['total_amount']; ?><br>

    Status: <?php echo $row['status'];?><br><br>
    <a href="update-order-status.php?id=<?php echo $row['order_id']; ?>">
    Update Status
    </a>
</form>
<hr>
<?php
}
?>
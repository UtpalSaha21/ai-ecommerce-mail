<?php
    include("../config/db.php");
    session_start();
    if($_SESSION['role']!='admin')
        {
            header("Location: ../authentication/login.php");
            exit();
        }

        $total_user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM users WHERE role='customer'"))['total'];
        $total_products = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM products"))['total'];
        $total_order = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM orders"))['total'];
        $total_revenue = mysqli_fetch_assoc(mysqli_query($conn,"SELECT IFNULL(SUM(total_amount),0) AS total FROM orders WHERE status='Delivered'"))['total'];

        $order_sql = "SELECT orders.*,users.name
        FROM orders
        JOIN users ON orders.user_id=users.user_id
        ORDER BY orders.order_id DESC LIMIT 10";
        $order_res = mysqli_query($conn,$order_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <p>
        Welcome , <?php echo $_SESSION['name']; ?>
    </p>

    <hr>

    <a href="add-products.php">Add Products</a>
    <a href="manage-orders.php">Manage Orders</a>
    <a href="send-cart-reminder.php">Send Cart Reminder</a>
    <a href="">Email Logs</a>
    <a href="../authentication/logout.php">Log Out</a>

    <hr>

    <h2>System Statics</h2>
    <table>
        <tr>
            <td>
                <h3>Total Users</h3>
                <?php echo $total_user ;?>
            </td>

            <td>
                <h3>Total Products</h3>
                <?php echo $total_products ;?>
            </td>

            <td>
                <h3>Total Orders</h3>
                <?php echo $total_order ;?>
            </td>

            <td>
                <h3>Total Revenue</h3>
                <?php echo $total_revenue ;?>
            </td>
        </tr>
    </table>

    <hr>

    <h2>Recent Orders</h2>

<table border="1" cellpadding="10">

<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Amount</th>
<th>Status</th>
<th>Address</th>
<th>Contact</th>
<th>Action</th>
</tr>

<?php
while($order=mysqli_fetch_assoc($order_res))
{
?>
<tr>

<td>
<?php echo $order['order_id']; ?>
</td>
<td>
<?php echo $order['name']; ?>
</td>

<td>
৳ <?php echo $order['total_amount']; ?>
</td>

<td>
<?php echo $order['status']; ?>
</td>

<td>
<?php echo $order['address']; ?>
</td>

<td>
<?php echo $order['contact_no']; ?>
</td>

<td>
<a href="update-order-status.php?id=<?php echo $order['order_id']; ?>">
Update Status
</a>
</td>
</tr>

<?php
}
?>

</table>
</body>
</html>
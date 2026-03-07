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
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    

    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="add-products.php">Add Products</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="manage-orders.php">Manage Orders</a></li>
                <li><a href="send-cart-reminder.php">Send Cart Reminder</a></li>
                <li><a href="mail-log.php">Email Logs</a></li>
                <li><a href="../authentication/logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>


    <!-- <h1>Admin Dashboard</h1>

    <p>
        Welcome , <?php echo $_SESSION['name']; ?>
    </p> -->

    <div class="main-content">
        <div class="wrapper">

        
    <h1>System Statics</h1>

    <?php
        if(isset($_SESSION['wlc']))
            {
                echo $_SESSION['wlc'];
                unset($_SESSION['wlc']);
            }

        if(isset($_SESSION['cart']))
            {
                echo $_SESSION['cart'];
                unset($_SESSION['cart']);
            }

        if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

        if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
    ?>
    <br>
    
        
            <div class="col-4 text-center">
                <h3>Total Users</h3>
                <?php echo $total_user ;?>
            </div>

            <div class="col-4 text-center">
                <h3>Total Products</h3>
                <?php echo $total_products ;?>
            </div>

            <div class="col-4 text-center">
                <h3>Total Orders</h3>
                <?php echo $total_order ;?>
            </div>

            <div class="col-4 text-center">
                <h3>Total Revenue</h3>
                Tk. <?php echo $total_revenue ;?>
            </div>
        <div class="clearfix"></div>
    
    </div>
    </div>


    <div class="main-content">
        <div class="table-wrapper">
            <h2>Recent Orders</h2>

            <table class="tbl-full1">

            <tr>
            <th>S.N.</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Address</th>
            <th>Order ID</th>
            <th>Contact</th>
            <th>Action</th>
            </tr>

            <?php
            $sn = 1;
            while($order=mysqli_fetch_assoc($order_res))
            {
            ?>
            <tr>

            <td>
            <?php echo $sn++; ?>
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
            <?php echo $order['order_id']; ?>
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
        </div>
    </div>
</body>
</html>
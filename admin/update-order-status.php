<?php
    session_start();
    include("../config/db.php");
    if($_SESSION['role']!='admin')
        {
            header("Location: ../authentication/login.php");
            exit();
        }
    
    if(!isset($_GET['id']))
        {
            echo "Invalid user id";
            exit();
        }

    $order_id = mysqli_real_escape_string($conn,$_GET['id']);

    $sql = "SELECT orders.* ,users.name ,users.email
    FROM orders
    JOIN users ON orders.user_id = users.user_id
    WHERE orders.order_id = '$order_id'";

    $res = mysqli_query($conn,$sql);

    if(mysqli_num_rows($res)==0)
        {
            echo " No order found";
            exit();
        }

    $row = mysqli_fetch_assoc($res);

    if(isset($_POST['update_status']))
        {
            $new_status = mysqli_real_escape_string($conn,$_POST['status']);
            $update_sql = "UPDATE orders SET
            status = '$new_status'
            WHERE order_id = '$order_id'";

            if(mysqli_query($conn,$update_sql))
                {
                    $_SESSION['update']="<div style='color: green'>Order Updated Successfully</div>";
                    header("Location: dashboard.php");
                    exit();
                }
            else
                {
                    $_SESSION['update']="<div style='color: red'>Order Update Failed</div>";
                    header("Location: update-order-status.php");
                    exit();
                }
        }
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
                <li><a href="mail-log.php">Email Logs</a></li>
                <li><a href="../authentication/logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    
    <div class="container">
    <h2>Update Order Status</h2>
<b>Order Id: </b> <?php echo $row['order_id'];?> <br><br>
<b>Customer Name: </b> <?php echo $row['name'];?> <br><br>
<b>Email: </b> <?php echo $row['email'];?> <br><br>
<b>Total Amount: </b> <?php echo $row['total_amount'];?> Tk. <br><br>
<b>Current Status:</b>
<span style="color:blue;">
    <?php echo $row['status']; ?>
</span>

<form action="" method="POST">
    
    
    <br><b>Select New Status</b><br>
    <select name="status" class="text-center">
        <option value="Pending" 
            <?php if($row['status']=='Pending') echo 'selected'; ?>>
            Pending
        </option>

        <option value="Processing" 
            <?php if($row['status']=='Processing') echo 'selected'; ?>>
            Processing
        </option>

        <option value="Shipped" 
            <?php if($row['status']=='Shipped') echo 'selected'; ?>>
            Shipped
        </option>

        <option value="Delivered" 
            <?php if($row['status']=='Delivered') echo 'selected'; ?>>
            Delivered
        </option>

        <option value="Cancelled" 
            <?php if($row['status']=='Cancelled') echo 'selected'; ?>>
            Cancelled
        </option>
    </select>

    <br>

    <button name="update_status">Update Status</button>
</form>
</div>

</body>
</html>
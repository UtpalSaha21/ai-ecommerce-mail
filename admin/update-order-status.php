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
                    echo "Order updated successfully";

                    $res = mysqli_query($conn,$sql);
                    $row = mysqli_fetch_assoc($res);
                }
            else
                {
                    echo "Failed to update status";
                }
        }
?>

<h2>Update Order Status</h2>
<b>Order Id: </b> <?php echo $row['order_id'];?> <br><br>
<b>Customer Name: </b> <?php echo $row['name'];?> <br><br>
<b>Email: </b> <?php echo $row['email'];?> <br><br>
<b>Total Amount: </b> <?php echo $row['total_amount'];?> Tk. <br><br>
<b>Current Status:</b>
<span style="color:blue;">
    <?php echo $row['status']; ?>
</span>

<hr>

<form action="" method="POST">
    
    <b>Select New Status</b> <br><br>
    <select name="status">
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

    <br><br>

    <button name="update_status">Update Status</button>
</form>

<br>

<a href="dashboard.php">
← Back to Dashboard
</a>
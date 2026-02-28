<?php
session_start();
include("../config/db.php");
if($_SESSION['role']!='customer')
    {
        header("Location: ../authentication/login.php");
        exit();
    }

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders 
        WHERE user_id='$user_id'
        ORDER BY order_date DESC";

$res = mysqli_query($conn,$sql);
?>

<h2>My Orders</h2>

<?php
while($row = mysqli_fetch_assoc($res))
{
?>
    Order ID: <?php echo $row['order_id']; ?><br>
    Total: <?php echo $row['total_amount']; ?><br>
    Status: <?php echo $row['status']; ?><br>
    Address: <?php echo $row['address']; ?><br>
    <hr>
<?php
}
?>
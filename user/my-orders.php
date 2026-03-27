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
$count = mysqli_num_rows($res);
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
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="../authentication/logout.php">Logout</a></li>
            </ul>  
        </div>
    </div>

    <div class="text-center">
    <h2>My Orders</h2>
    </div>
    <?php
        if($count == 0){
            echo "<p class='text-center' style='color:red;'>No Order History Avaiable</p>";
        }
    ?>
    <?php
    while($row = mysqli_fetch_assoc($res))
    {
    ?>
    <div class="container">
        Order ID: <?php echo $row['order_id']; ?><br>
        Total: <?php echo $row['total_amount']; ?><br>
        Status: <?php echo $row['status']; ?><br>
        Address: <?php echo $row['address']; ?><br>
</div>
    <?php
    }
    ?>
    <?php
        include("../partials/footer.php");
    ?>
</body>
</html>
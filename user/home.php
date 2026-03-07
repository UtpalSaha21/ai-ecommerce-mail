<?php
    session_start();
    include("../config/db.php");
    if($_SESSION['role']!='customer')
        {
            header("Location: ../authentication/login.php");
            exit();
        }
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['name'];

    $sql = "SELECT * FROM products ORDER BY created_at DESC";
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
                <li><a href="cart.php">Cart</a></li>
                <li><a href="my-orders.php">My Orders</a></li>
                <li><a href="../authentication/logout.php">Logout</a></li>
            </ul>  
        </div>
    </div>
    
    <!--<h2>Welcome , <?php echo $name;?>!</h2>-->

    <h3>Available Products</h3><br>

    <?php
        if(isset($_SESSION['wlc']))
            {
                echo $_SESSION['wlc'];
                unset($_SESSION['wlc']);
            }

        if(isset($_SESSION['cart_add']))
            {
                echo $_SESSION['cart_add'];
                unset($_SESSION['cart_add']);
            }
        
        if(isset($_SESSION['mail']))
            {
                echo $_SESSION['mail'];
                unset($_SESSION['mail']);
            }
    ?>

    <br>

    <table class="tbl-full1">
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
        </tr>

        <?php
        while($row = mysqli_fetch_assoc($res))
        {
        ?>

        <tr>

        <td>
        <?php echo $row['product_name']; ?>
        </td>

        <td>
        <?php echo $row['category']; ?>
        </td>

        <td>
        ৳ <?php echo $row['price']; ?>
        </td>

        <td>

        <?php
        if($row['stock']>0)
        {
            echo $row['stock'];
        }
        else
        {
            echo "<span style='color:red;'>Out of stock</span>";
        }
        ?>

        </td>

        <td>

        <a href="view-product.php?id=<?php echo $row['product_id']; ?>">
        View
        </a>

        </td>

        </tr>

        <?php } ?>
    </table>
</body>
</html>
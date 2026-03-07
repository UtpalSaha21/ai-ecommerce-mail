<?php
    session_start();
    include("../config/db.php");
    if($_SESSION['role']!='customer')
        {
            header("Location: ../authentication/login.php");
            exit();
        }
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT cart.*,products.product_name,products.stock,products.price
    FROM cart
    JOIN products
    ON cart.product_id = products.product_id
    WHERE cart.user_id = '$user_id'";

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
                <li><a href="home.php">Home</a></li>
                <li><a href="my-orders.php">My Orders</a></li>
                <li><a href="../authentication/logout.php">Logout</a></li>
            </ul>  
        </div>
    </div>


    <h2>My Cart</h2>
<table class="tbl-full1">
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php
$grand_total = 0;

while($row = mysqli_fetch_assoc($res))
{
    $total = $row['price'] * $row['quantity'];
    $grand_total += $total;
?>
<tr>
    <td><?php echo $row['product_name']; ?></td>
    <td><?php echo $row['price']; ?></td>
    <td>
        <form action="update-cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id'];?>">
            <input type="number" name="qty" value="<?php echo $row['quantity'];?>" min="1">

            <button>Update</button>
        </form>
    </td>
    <td><?php echo $total; ?></td>
    <td>
        <a href="remove.php?id=<?php echo $row['product_id']; ?>">
            Remove
        </a>
    </td>
</tr>
<?php
}
?>
</table>
<div class="container">
<h3>Grand Total: <?php echo $grand_total; ?></h3>

<a href="checkout.php">
    <button>Proceed to Checkout</button>
</a>

</div>

</body>
</html>

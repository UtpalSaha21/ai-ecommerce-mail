<?php

session_start();
include("../config/db.php");
if ($_SESSION['role'] != 'customer') {
    header("Location: ../authentication/login.php");
    exit();
}

if (isset($_GET['category']) && $_GET['category'] != "") {
    $category = mysqli_real_escape_string($conn, $_GET['category']);
    $sql = "SELECT * FROM products WHERE category = '$category'";
} else {
    $sql = "SELECT * FROM products";
}
$res = mysqli_query($conn, $sql);
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
                <li><a href="cart.php">Cart</a></li>
                <li><a href="my-orders.php">My Orders</a></li>
                <li><a href="../authentication/logout.php">Logout</a></li>
            </ul>  
        </div>
    </div><br>

    <h2 class="text-center">Available Products</h2>

    <form method="GET" class="text-center">
        <select name="category" onchange="this.form.submit()">
            <option value="">All Categories</option>

            <?php
            $cat_sql = "SELECT DISTINCT category FROM products";
            $cat_res = mysqli_query($conn, $cat_sql);

            while ($cat = mysqli_fetch_assoc($cat_res)) {
                ?>
                <option value="<?php echo $cat['category']; ?>" <?php if (isset($_GET['category']) && $_GET['category'] == $cat['category'])
                       echo "selected"; ?>>
                    <?php echo $cat['category']; ?>
                </option>
                <?php
            }
            ?>
        </select>
    </form>

    <?php while ($row = mysqli_fetch_assoc($res)) { ?>
        <div class="container">
            <h3><?php echo $row['product_name']; ?></h3>
            Category :<?php echo $row['category']; ?><br>
            Price : <?php echo $row['price']; ?><br>
            Stock : <?php echo $row['stock']; ?><br><br>
            <a href="view-product.php?id=<?php echo $row['product_id']; ?>" class="btn1">View Product</a>
        </div>
        <?php
    }
    ?>
</body>

</html>
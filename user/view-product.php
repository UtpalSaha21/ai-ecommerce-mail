<?php
    session_start();
    include("../config/db.php");
    if($_SESSION['role']!='customer')
        {
            header("Location: ../authentication/login.php");
            exit();
        }

        $product_id = mysqli_real_escape_string($conn,$_GET['id']);
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT * FROM products WHERE product_id = '$product_id'";
        $res = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($res);

        $activity_sql = "INSERT INTO user_activity SET
        user_id = '$user_id',
        product_id = '$product_id',
        activity_type = 'view'";

        mysqli_query($conn,$activity_sql);

        if(isset($_POST['cart']))
            {
                $quantity = mysqli_real_escape_string($conn,$_POST['qty']);
                if($quantity <= 0)
                    {
                        echo "Invalid quantity.";
                        exit();
                    }
        
                $check_sql = "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'";
                $check_res = mysqli_query($conn,$check_sql);
                if(mysqli_num_rows($check_res)>0)
                    {
                        $dup = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id='$user_id' AND product_id='$product_id'";
                        mysqli_query($conn,$dup);
                    }
                else
                    {
                        $sql1 = "INSERT INTO cart SET
                        user_id = '$user_id',
                        product_id = '$product_id',
                        quantity = '$quantity'";
                            
                        $res1 = mysqli_query($conn,$sql1);
                    }

                $track_sql = "INSERT INTO user_activity SET
                user_id = '$user_id',
                product_id = '$product_id',
                activity_type = 'cart'";

                mysqli_query($conn,$track_sql);

                $_SESSION['cart_add'] = "<div style='color:green;'>Added to cart</div>";
                header("Location: home.php");
                exit();
            }
            if(isset($_POST['buy']))
                {
                    $quantity = mysqli_real_escape_string($conn,$_POST['qty']);

                    if($quantity <= 0)
                    {
                        echo "Invalid quantity.";
                        exit();
                    }

                    header("Location: checkout.php?id=$product_id&qty=$quantity");
                    exit();
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
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="my-orders.php">My Orders</a></li>
                <li><a href="../authentication/logout.php">Logout</a></li>
            </ul>  
        </div>
    </div>
    <div class="container">
        <h2><?php echo $row['product_name'];?></h2>
        <p><img src="../images/<?php echo $row['image_name'] ;?>" alt="No image found" width="250px"></p>
        Category : <?php echo $row['category'];?> <br><br>
        Price : <strong><?php echo $row['price'];?> T.K.</strong> <br><br>
        Stock : <?php echo $row['stock'];?> <br><br>

        <form action="" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id;?>"> 
            Quantity: <input type="number" name="qty" class="text-center" value="1" min="1">
            <?php
            if($row['stock']>0)
                {
                ?>
                    <button name="cart">Add to cart</button>
                    <p>Or</p>
                    <button name="buy">Buy now</button>
                <?php
                }
            else
                {
                    echo "<div style='color:red'>Out of Stock</div>";
                }
                ?>
        </form>
    </div>
</body>
</html>
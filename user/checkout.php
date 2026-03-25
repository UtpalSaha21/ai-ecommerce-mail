<?php
    session_start();
    include("../config/db.php");
    if($_SESSION['role']!='customer')
        {
            header("Location: ../authentication/login.php");
            exit();
        }

    $user_id = $_SESSION['user_id'];
    $buy_now = false;
    $coupon_row = null;
    $discount_total = 0;
    $final_total = 0;
    if(isset($_SESSION['coupon']))
        {
            $coupon_row = $_SESSION['coupon'];
        }

    if(isset($_GET['id']) && isset($_GET['qty']))
        {
            $buy_now = true;
            $product_id = mysqli_real_escape_string($conn,$_GET['id']);
            $quantity = mysqli_real_escape_string($conn,$_GET['qty']);

            $product_sql = "SELECT * FROM products WHERE product_id = '$product_id'";
            $product_res = mysqli_query($conn,$product_sql);
            $product = mysqli_fetch_assoc($product_res);

            $total_amount = $product['price'] * $quantity ;
        }
    else
        {
            $cart_sql = "SELECT cart.*,products.product_name,products.price,products.stock
            FROM cart
            JOIN products ON cart.product_id = products.product_id
            WHERE cart.user_id = '$user_id'";

            $cart_res = mysqli_query($conn,$cart_sql);
            $total_amount = 0;

            while($row = mysqli_fetch_assoc($cart_res))
                {
                    $total_amount += $row['price'] * $row['quantity'];
                }

            mysqli_data_seek($cart_res,0);
        }

    if(isset($_POST['apply_coupon']))
        {
            $coupon_code = mysqli_real_escape_string($conn,$_POST['coupon_code']);

            $coupon_sql = "SELECT * FROM coupons
                        WHERE code='$coupon_code'
                        AND user_id='$user_id'
                        AND status='active'
                        AND expiry_date>=NOW()";

            $coupon_res = mysqli_query($conn,$coupon_sql);

            if(mysqli_num_rows($coupon_res)>0)
            {
                $temp_coupon = mysqli_fetch_assoc($coupon_res);
                $coupon_product = $temp_coupon['product_id'];

                $valid = false;

                if($buy_now)
                {
                    if($coupon_product == $product_id)
                        $valid = true;
                }
                else
                {
                    $check_sql = "SELECT * FROM cart
                                WHERE user_id='$user_id'
                                AND product_id='$coupon_product'";
                    $check_res = mysqli_query($conn,$check_sql);

                    if(mysqli_num_rows($check_res)>0)
                        $valid = true;
                }

                if($valid)
                {
                    $_SESSION['coupon'] = $temp_coupon;
                    $coupon_row = $temp_coupon;
                    echo "<p style='color:green;'>Coupon applied successfully ✅</p>";
                }
                else
                {
                    unset($_SESSION['coupon']);
                    echo "<p style='color:red;'>This coupon is not valid for your current items ❌</p>";
                }
            }
            else
            {
                unset($_SESSION['coupon']);
                echo "<p style='color:red;'>Invalid or expired coupon ❌</p>";
            }
        }

    if(isset($_POST['place_order']))
        {
            $address = mysqli_real_escape_string($conn,$_POST['address']);
            $contact = mysqli_real_escape_string($conn,$_POST['contact']);
            $payment = mysqli_real_escape_string($conn,$_POST['payment']);

            $coupon_row = isset($_SESSION['coupon']) ? $_SESSION['coupon'] : null;

            if($buy_now)
                {
                    $price = $product['price'];
                    $subtotal = $price * $quantity;

                    if($coupon_row && $coupon_row['product_id']==$product_id)
                        {
                            $discount = ($subtotal * $coupon_row['discount_percent'])/100;
                            $subtotal -=$discount;
                            $discount_total +=$discount;
                        }
                    $final_total = $subtotal;
                }
            else
                {
                    $cart_sql2 = "SELECT cart.*,products.price
                    FROM cart
                    JOIN products ON cart.product_id = products.product_id
                    WHERE cart.user_id = '$user_id'";

                    $cart_res2 = mysqli_query($conn,$cart_sql2);

                    while($row2 = mysqli_fetch_assoc($cart_res2))
                        {
                            $pid2 = $row2['product_id'];
                            $qty2 = $row2['quantity'];
                            $price2 = $row2['price'];

                            $subtotal = $price2 * $qty2;

                            if($coupon_row && $coupon_row['product_id']==$pid2)
                                {
                                    $discount = ($subtotal * $coupon_row['discount_percent'])/100;
                                    $subtotal -=$discount;
                                    $discount_total +=$discount;
                                }
                            
                            $final_total += $subtotal;
                        }
                }

            $order_sql = "INSERT INTO orders SET
            user_id ='$user_id',
            total_amount = '$final_total',
            status = 'Pending',
            address = '$address',
            contact_no = '$contact',
            payment_method = '$payment'";

            mysqli_query($conn,$order_sql);
            $order_id = mysqli_insert_id($conn);

            if($buy_now)
                {
                    $price = $product['price'];

                    if($coupon_row && $coupon_row['product_id']==$product_id)
                        {
                            $price = $price - ($price * $coupon_row['discount_percent']/100);
                        }

                    mysqli_query($conn,"INSERT INTO order_items SET
                    order_id = '$order_id',
                    product_id = '$product_id',
                    quantity = '$quantity',
                    price = '$price'");

                    mysqli_query($conn,"UPDATE products SET
                    stock = stock - $quantity
                    WHERE product_id = '$product_id' AND stock>=$quantity");

                    mysqli_query($conn,"INSERT INTO user_activity SET
                    user_id = '$user_id',
                    product_id = '$product_id',
                    activity_type = 'purchase'");
                }
            else
                {
                    $cart_sql3 = "SELECT cart.*,products.product_name,products.price,products.stock
                    FROM cart
                    JOIN products ON cart.product_id = products.product_id
                    WHERE cart.user_id = '$user_id'";

                    $cart_res3 = mysqli_query($conn,$cart_sql3);
                    
                    while($row3 = mysqli_fetch_assoc($cart_res3))
                        {
                            $pid = $row3['product_id'];
                            $qty = $row3['quantity'];
                            $price = $row3['price'];

                            if($coupon_row && $coupon_row['product_id']==$pid)
                                {
                                    $price = $price - ($price * $coupon_row['discount_percent']/100);
                                }

                            mysqli_query($conn,"INSERT INTO order_items SET
                            order_id = '$order_id',
                            product_id = '$pid',
                            quantity = '$qty',
                            price = '$price'");

                            mysqli_query($conn,"UPDATE products SET
                            stock = stock - $qty
                            WHERE product_id = '$pid' AND stock>=$qty");

                            mysqli_query($conn,"INSERT INTO user_activity SET
                            user_id = '$user_id',
                            product_id = '$pid',
                            activity_type = 'purchase'");
                        }
                    mysqli_query($conn,"DELETE FROM cart WHERE user_id='$user_id'");
                }
            if($coupon_row)
                {
                    $code = $coupon_row['code'];

                    mysqli_query($conn,"
                    UPDATE coupons
                    SET status='used'
                    WHERE code='$code' AND status='active'");
                }
            unset($_SESSION['coupon']);
            header("Location: ../send-purchase-mail.php?order_id=$order_id");
            exit();
        }

        // reset totals before preview
$discount_total = 0;
$final_total = 0;

        // calculate preview totals
if($buy_now)
{
    $subtotal = $product['price'] * $quantity;

    if($coupon_row && $coupon_row['product_id']==$product_id)
    {
        $discount = ($subtotal * $coupon_row['discount_percent'])/100;
        $discount_total += $discount;
        $subtotal -= $discount;
    }

    $final_total = $subtotal;
}
else
{
    $cart_sql_preview = "SELECT cart.*,products.price
                         FROM cart
                         JOIN products ON cart.product_id=products.product_id
                         WHERE cart.user_id='$user_id'";

    $cart_preview_res = mysqli_query($conn,$cart_sql_preview);

    while($row = mysqli_fetch_assoc($cart_preview_res))
    {
        $subtotal = $row['price'] * $row['quantity'];

        if($coupon_row && $coupon_row['product_id']==$row['product_id'])
        {
            $discount = ($subtotal * $coupon_row['discount_percent'])/100;
            $discount_total += $discount;
            $subtotal -= $discount;
        }

        $final_total += $subtotal;
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
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="my-orders.php">My Orders</a></li>
                <li><a href="../authentication/logout.php">Logout</a></li>
            </ul>  
        </div>
    </div>
    
    <div class="container">
    <h2>Checkout</h2><br>
<form action="" method="POST">
    <textarea name="address" placeholder="Address" required></textarea><br>

    <input type="text" name="contact" placeholder="Contact No" required>

    <select name="payment" class="text-center" required>
        <option value="">Payment Method</option>
        <option value="Cash On Delivery">Cash On Delivery</option>
        <option value="Bkash">Bkash</option>
        <option value="Nagad">Nagad</option>
    </select>
    <br>
    <input type="text" name="coupon_code" placeholder="Enter coupon code"><br>

    <button name="apply_coupon">Apply Coupon</button>
    <br>

    <h3>Order Summary</h3>

    <?php
        if($buy_now)
            {
    ?>
                Product: <?php echo $product['product_name'];?><br>
                Quantity: <?php echo $quantity;?><br>
                Total: <?php echo $total_amount; ?><br>
                Discount: <?php echo $discount_total; ?><br>
                <b>Final Total: <?php echo $final_total; ?></b><br><br>
    <?php
            }
        else
            {

                while($row = mysqli_fetch_assoc($cart_res))
                    {
    ?>
                    Product: <?php echo $row['product_name'];?><br>
                    Quantity: <?php echo $row['quantity'];?><br>
                    Sub Total: <?php echo $row['price']*$row['quantity'];?><br><br>
    <?php
                    }
    ?>
                Total: <?php echo $total_amount; ?><br>
                Discount: <?php echo $discount_total; ?><br>
                <b>Final Total: <?php echo $final_total; ?></b><br><br>           
    <?php
            }
    ?>
    <button name="place_order">Place Order</button>
</form>
</div>
</body>
</html>
<?php
session_start();
include("../config/db.php");

if($_SESSION['role'] != 'admin')
{
    header("Location: ../authentication/login.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

if(isset($_POST['send_reminder']))
{
    $sql = "SELECT users.user_id, users.name, users.email, products.product_name, products.product_id, cart.cart_id
            FROM cart
            JOIN users ON cart.user_id = users.user_id
            JOIN products ON cart.product_id = products.product_id
            WHERE cart.last_updated <= NOW() - INTERVAL 1 DAY
            AND cart.reminder_sent = 0";

    $res = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_assoc($res))
    {
        $name  = $row['name'];
        $email = $row['email'];
        $product = $row['product_name'];
        $cart_id = $row['cart_id'];

        // Generate unique coupon
        $coupon_code = "AI" . rand(1000,9999) . $row['user_id'];
        $discount = 10;
        $expiry = date('Y-m-d H:i:s', strtotime('+2 days'));

        // Save coupon
        mysqli_query($conn,"INSERT INTO coupons SET
        user_id = '".$row['user_id']."',
        product_id = '".$row['product_id']."',
        code = '$coupon_code',
        discount_percent = '$discount',
        expiry_date = '$expiry'");

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'absutpal321@gmail.com';
        $mail->Password = 'zfen sfmo ilmj qdlf';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('absutpal321@gmail.com','AI System');
        $mail->addAddress($email,$name);

        $mail->Subject = "Complete Your Purchase & Get 10% OFF!";

        $mail->Body = "
        Hello $name,

        You left '$product' in your cart.

        🎁 Special Offer Just For You!

        Use Coupon Code: $coupon_code
        Get: $discount% OFF
        Valid Until: $expiry

        Complete your purchase now!

        Regards,
        AI E-Commerce System
        ";
        if($mail->send())
            {
                mysqli_query($conn,"UPDATE cart SET reminder_sent=1 WHERE cart_id='$cart_id'");
                mysqli_query($conn,"INSERT INTO email_logs SET
                    user_id = '".$row['user_id']."',
                    email = '$email',
                    subject = '".$mail->Subject."',
                    email_type = 'cart_reminder',
                    status = 'sent'
                ");
            }
            else
            {
                mysqli_query($conn,"INSERT INTO email_logs SET
                    user_id = '".$row['user_id']."',
                    email = '$email',
                    subject = '".$mail->Subject."',
                    email_type = 'cart_reminder',
                    status = 'failed'
                ");
            }
    }

    $_SESSION['cart'] = "<div style='color:green;'>Cart reminder emails sent successfully!</div>";
    header("Location: dashboard.php");
    exit();
}

if(isset($_POST['No']))
    {
        header("Location: dashboard.php");
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
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="add-products.php">Add Products</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="manage-orders.php">Manage Orders</a></li>
                <li><a href="mail-log.php">Email Logs</a></li>
                <li><a href="../authentication/logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <h2>Do you want to send reminder email to customers about their cart products?</h2>
        <form action="" method="POST">
        <button name="send_reminder" class="button">Yes</button>
        <br>
        <button name="No" class="button">No</button>
    </form>
    </div>

    <?php
        include("../partials/footer.php");
    ?>
</body>
</html>
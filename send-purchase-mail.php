<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    include("config/db.php");

    $order_id = mysqli_real_escape_string($conn,$_GET['order_id']);
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT users.name , users.email , orders.total_amount
    FROM orders
    JOIN users ON orders.user_id = users.user_id
    WHERE orders.order_id = $order_id";

    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);

    $name = $row['name'];
    $email = $row['email'];
    $total = $row['total_amount'];

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host ='smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'absutpal321@gmail.com';
    $mail->Password = 'zfen sfmo ilmj qdlf';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('absutpal321@gmail.com','AI System');
    $mail->addAddress($email,$name);

    $mail->Subject="Purchase Confirmation";
    $mail->Body="
    Hello $name
    
    Thank you for your purchase.
    
    Your Order ID : $order_id
    Total Amount : $total
    
    Regards
    AI E-Commerce System";

    if($mail->send())
    {
        mysqli_query($conn,"INSERT INTO email_logs SET
            user_id = '$user_id',
            email = '$email',
            subject = '".$mail->Subject."',
            email_type = 'purchase_confirmation',
            status = 'sent'
        ");

        echo "Email Sent";
    }
    else
    {
        mysqli_query($conn,"INSERT INTO email_logs SET
            user_id = '$user_id',
            email = '$email',
            subject = '".$mail->Subject."',
            email_type = 'purchase_confirmation',
            status = 'failed'
        ");

        echo "Email Failed";
    }
?>
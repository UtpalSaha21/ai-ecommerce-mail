<?php
    session_start();
    include("../config/db.php");

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    if($qty <= 0)
    {
        header("Location: cart.php");
        exit();
    }

    $sql = "UPDATE cart SET quantity='$qty'
            WHERE user_id='$user_id'
            AND product_id='$product_id'";

    mysqli_query($conn,$sql);

    header("Location: cart.php");
?>
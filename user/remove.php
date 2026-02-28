<?php
    session_start();
    include("../config/db.php");

    $user_id = $_SESSION['user_id'];
    $product_id = mysqli_real_escape_string($conn,$_GET['id']);

    $sql = "DELETE FROM cart
    WHERE user_id = '$user_id'
    AND product_id = '$product_id'";

    mysqli_query($conn,$sql);

    header("Location: cart.php");
?>
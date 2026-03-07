<?php

    session_start();
    include("../config/db.php");
    if($_SESSION['role']!='admin')
        {
            header("Location: ../authentication/login.php");
            exit();
        }

        if(isset($_POST['submit']))
            {
                $name = mysqli_real_escape_string($conn,$_POST['name']);
                $category = mysqli_real_escape_string($conn,$_POST['category']);
                $stock = mysqli_real_escape_string($conn,$_POST['stock']);
                $price = mysqli_real_escape_string($conn,$_POST['price']);

                $sql = "INSERT INTO products SET
                product_name = '$name',
                category = '$category',
                price = '$price',
                stock = '$stock'";

                $res = mysqli_query($conn,$sql);

                if($res)
                    {
                        $_SESSION['add'] = "<div style='color:green;'>Product added successfully!</div>";
                        header("Location: dashboard.php");
                        exit();
                    }
                    else
                    {
                        $_SESSION['add'] = "<div style='color:red;'>Failed adding</div>";
                        header("Location: add-products.php");
                        exit();
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
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="manage-orders.php">Manage Orders</a></li>
                <li><a href="send-cart-reminder.php">Send Cart Reminder</a></li>
                <li><a href="mail-log.php">Email Logs</a></li>
                <li><a href="../authentication/logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
    <h2>Add Products</h2>
    <br>
    <?php
    if(isset($_SESSION['add']))
    {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    ?>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Product Name" required>

        <input type="text" name="category" placeholder="Category" required>

        <input type="number" name="stock" placeholder="Stock" required>

        <input type="text" inputmode="decimal" name="price" placeholder="Price(Tk.)" required>

        <button type="submit" name="submit" class="button">Submit</button>
    </form>
    </div>
</body>
</html>
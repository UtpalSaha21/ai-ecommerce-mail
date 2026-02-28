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
                        echo "success";
                    }
                    else
                        echo "failed";
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Add Products</h2>

    <form action="" method="POST">
        Product Name : <br>
        <input type="text" name="name" required> <br><br>

        Category : <br>
        <input type="text" name="category"> <br><br>

        Stock : <br>
        <input type="text" name="stock" required> <br><br>

        Price : <br>
        <input type="text" name="price" required> <br><br>

        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>
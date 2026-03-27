<?php

    session_start();
    include("../config/db.php");
    if($_SESSION['role']!='admin')
        {
            header("Location: ../authentication/login.php");
            exit();
        }
    if(!isset($_GET['id']))
        {
            header("Location: products.php");
            exit();
        }
    
    $id = mysqli_real_escape_string($conn,$_GET['id']);
    $sql = "SELECT * from products WHERE product_id = '$id'";
    $res = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($res);

    if(isset($_POST['submit']))
        {
            $name = mysqli_real_escape_string($conn,$_POST['name']);
            $category = mysqli_real_escape_string($conn,$_POST['category']);
            $price = mysqli_real_escape_string($conn,$_POST['price']);
            $stock = mysqli_real_escape_string($conn,$_POST['stock']);
            $current_image = $row['image_name'];
            if(isset($_FILES['image']['name']))
                    {
                        $image_name = $_FILES['image']['name'];
                        if($image_name!="")
                            {
                                $ext = end(explode('.',$image_name));
                                $image_name = "Product_Name_".rand(0000,9999).'.'.$ext;
                                $src = $_FILES['image']['tmp_name'];
                                $dst ="../images/".$image_name;
                                $upload = move_uploaded_file($src,$dst);
                                if($upload==false)
                                    {
                                        $_SESSION['upload'] = "<div style='color:red;'>Failed to upload image</div>";
                                        header("Location: update-products.php");
                                        die();
                                    }
                                if($current_image!="")
                                    {
                                        $remove_path = "../images/".$current_image;

                                        $remove = unlink($remove_path);
                                        if($remove==false)
                                            {
                                                $_SESSION['remove_failed']="<div style='color:red;'>Failed to remove image</div>";
                                                header("Location: update-products.php");
                                                die();
                                            }
                                    }
                            }
                        else
                            {
                                $image_name = $current_image;
                            }
                    }
                else
                    {
                        $image_name = $current_image;
                    }
            $sql2 = "UPDATE products SET
            product_name = '$name',
            image_name = '$image_name',
            category = '$category',
            price = '$price',
            stock = '$stock'
            WHERE product_id = '$id'";
            if(mysqli_query($conn,$sql2))
                {
                    $_SESSION['update'] = "<div style='color:green'>Product Updated Successfully.</div>";
                }
            else
                {
                    $_SESSION['update'] = "<div style='color:red'>Failed to Update Product.</div>";
                }
            header("Location: products.php");
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
                <li><a href="products.php">Products</a></li>
                <li><a href="manage-orders.php">Manage Orders</a></li>
                <li><a href="send-cart-reminder.php">Send Cart Reminder</a></li>
                <li><a href="mail-log.php">Email Logs</a></li>
                <li><a href="../authentication/logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
    <h2>Update Product</h2>
    <br>
    <?php
        if(isset(($_SESSION['upload'])))
    {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
    }
     if(isset(($_SESSION['remove_failed'])))
    {
        echo $_SESSION['remove_failed'];
        unset($_SESSION['remove_failed']);
    }
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?php echo $row['product_name']; ?>">

        <p class="text-left">
        Current Image :
       </p>
       <p><img src="../images/<?php echo $row['image_name'] ;?>" alt="No image found" width="150px"></p>

       <p class="text-left">
        New Image :
       </p>

       <input type="file" name="image">

        <select name="category" >
            <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
            <option value="Apparel & Accessories">Apparel & Accessories</option>
            <option value="Electronics">Electronics</option>
            <option value="Home & Garden">Home & Garden</option>
            <option value="Health & Beauty">Health & Beauty</option>
            <option value="Baby & Kids">Baby & Kids</option>
            <option value="Sports & Outdoors">Sports & Outdoors</option>
        </select>

        <input type="number" name="stock" value="<?php echo $row['stock']; ?>">

        <input type="text" inputmode="decimal" name="price" value="<?php echo $row['price']; ?>">

        <button type="submit" name="submit" class="button">Submit</button>
    </form>
    </div>
    <?php
        include("../partials/footer.php");
    ?>
</body>
</html>
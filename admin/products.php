<?php
    session_start();
    include("../config/db.php");
    if($_SESSION['role']!='admin')
        {
            header("Location: ../authentication/login.php");
            exit();
        }
    $sql = "SELECT * from products ORDER BY stock ASC";
    $res = mysqli_query($conn,$sql);
    if(isset($_POST['submit']))
        {
            $name = mysqli_real_escape_string($conn,$_POST['name']);
            $category = mysqli_real_escape_string($conn,$_POST['category']);
            $price = mysqli_real_escape_string($conn,$_POST['price']);
            $stock = mysqli_real_escape_string($conn,$_POST['stock']);
            $id = mysqli_real_escape_string($conn,$_POST['id']);
            $sql2 = "UPDATE products SET
            product_name = '$name',
            category = '$category',
            price = '$price',
            stock = '$stock'
            WHERE product_id = '$id'";
            mysqli_query($conn,$sql2);
            $_SESSION['update'] = "<div style='color:green'>Product Updated Successfully.</div>";
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
                <li><a href="add-products.php">Add Products</a></li>
                <li><a href="manage-orders.php">Manage Orders</a></li>
                <li><a href="send-cart-reminder.php">Send Cart Reminder</a></li>
                <li><a href="mail-log.php">Email Logs</a></li>
                <li><a href="../authentication/logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="table-wrapper">
            <h2>Products</h2>

            <?php
                if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
            ?><br>

            <table class="tbl-full1">
                <tr>
                    <th>S.N.</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price(T.K.)</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>

                <?php
                $sn=1;
                while($row=mysqli_fetch_assoc($res))
                    {
                ?>
                    <form action="" method="POST">
                        <tr>
                        <td><?php echo $sn++;?></td>
                        <td><input type="text" name="name" value="<?php echo $row['product_name'];?>"></td>
                        <td>
                            <select name="category">
                                <option value="<?php echo $row['category'];?>"><?php echo $row['category'];?></option>
                                <option value="Apparel & Accessories">Apparel & Accessories</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Home & Garden">Home & Garden</option>
                                <option value="Health & Beauty">Health & Beauty</option>
                                <option value="Baby & Kids">Baby & Kids</option>
                                <option value="Sports & Outdoors">Sports & Outdoors</option>
                            </select>
                        </td>
                        <td><input type="text" inputmode="decimal" name="price" value="<?php echo $row['price'];?>"></td>
                        <td><input type="number" name="stock" value="<?php echo $row['stock'];?>"></td>
                        <td>
                        <input type="hidden" name="id" value="<?php echo $row['product_id']; ?>">    
                        <button name="submit" class="btn1">Update</button>
                        </td>
                    </tr>
                    </form>
                <?php
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
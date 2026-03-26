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
            $product_id = $_POST['id'];
            header("Location: update-product.php?id=".$product_id);
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
                    <th>Image</th>
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
                        <td>
                            <?php echo $row['product_name'];?>
                        </td>
                        <td>
                            <p><img src="../images/<?php echo $row['image_name'] ;?>" alt="No image found" width="150px"></p>
                        </td>
                        <td>
                            <?php echo $row['category'];?>
                        </td>
                        <td>
                            <?php echo $row['price'];?>
                        </td>
                        <td>
                            <?php echo $row['stock'];?>
                        </td>
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
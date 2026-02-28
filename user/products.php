<?php

    session_start();
    include("../config/db.php");
    if($_SESSION['role']!='customer')
        {
            header("Location: ../authentication/login.php");
            exit();
        }

        $sql = "SELECT * FROM products";
        $res = mysqli_query($conn,$sql);
?>

<h2>Available Products</h2>

<?php while($row = mysqli_fetch_assoc($res))
            {?>
                <div>
                    <h3><?php echo $row['product_name'];?></h3>
                    Category :<?php echo $row['category'];?><br>
                    Price : <?php echo $row['price'];?><br>
                    Stock : <?php echo $row['stock'];?><br><br>
                    <a href="view-product.php?id=<?php echo $row['product_id']; ?>">View Product</a>
                </div>
            <?php
            }
            ?>
<?php
    session_start();
    include("../config/db.php");

    if(isset($_POST['submit']))
        {
            $email = mysqli_real_escape_string($conn,$_POST['email']);
            $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE email = '$email'";
            $res = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($res);

            if($count==1)
                {
                    $row = mysqli_fetch_assoc($res);
                    if(md5($password)==$row['password'])
                        {
                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['name'] = $row['name'];
                            $_SESSION['role'] = $row['role'];

                            if($row['role']=='admin')
                                {
                                    $_SESSION['wlc'] = "<div style='color:green'>Welcome,".$row['name']."</div>";
                                    header("Location: ../admin/dashboard.php");
                                    exit();
                                }
                            else
                                {
                                    $_SESSION['wlc'] = "<div style='color:green'>Welcome,".$row['name']."</div>";
                                    header("Location: ../user/home.php");
                                    exit();
                                }
                        }
                    else
                        {
                            echo "Invalid Password.";
                        }
                }
            else
                {
                    echo "User not found.";
                }
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/reg.css">
</head>
<body>
    <div class="container">
    <h2>Welcome Back</h2>

    <?php
        if(isset($_SESSION['done']))
            {
                echo $_SESSION['done'];
                unset($_SESSION['done']);
            }
    ?>

    <form action="" method="POST">
        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="submit">Login</button>

        <p>
            Don't have an account yet?
            <a href="registration.php">Sign up</a>
        </p>
    </form>
    </div>
</body>
</html>
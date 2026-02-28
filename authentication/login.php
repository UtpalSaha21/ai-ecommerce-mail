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
                                    header("Location: ../admin/dashboard.php");
                                    exit();
                                }
                            else
                                {
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
</head>
<body>
    <h2>Login</h2>

    <form action="" method="POST">
        Email : <br>
        <input type="email" name="email" required> <br><br>

        Password : <br>
        <input type="password" name="password" required> <br><br>

        <button type="submit" name="submit">Login</button>
    </form>
</body>
</html>
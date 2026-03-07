<?php
    session_start();
    include("../config/db.php");

    if(isset($_POST['submit']))
        {
            $name = mysqli_real_escape_string($conn,$_POST['name']);
            $email = mysqli_real_escape_string($conn,$_POST['email']);
            $password = md5($_POST['password']);
            //for alternate of md5 we can use password_hash
            //$password = $_POST['password'];
            //$encrypte_password = password_hash($password,PASSWORD_DEFAULT);

            $dup_sql = "SELECT * FROM users WHERE email = '$email'";
            $dup_res = mysqli_query($conn,$dup_sql);
            $dup_row = mysqli_num_rows($dup_res);
            if($dup_row>0)
                {
                    $_SESSION['exist'] = "This email already used";
                    header("Location: registration.php");
                    exit();
                }

            $sql = "INSERT INTO users SET
            name = '$name',
            email = '$email',
            password = '$password'";

            $res = mysqli_query($conn , $sql) or die(mysqli_error($conn));

            if($res==true)
                {
                    $_SESSION['done'] = "Registration Successful";
                    header("Location: login.php");
                    exit();
                }
                else
                    {
                        $_SESSION['done'] = "Registration Failed";
                        header("Location: registration.php");
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
    <link rel="stylesheet" href="../css/reg.css">
</head>
<body>
    <div class="container">
    <h2>Sign Up</h2>

    <?php
        if(isset($_SESSION['done']))
            {
                echo $_SESSION['done'];
                unset($_SESSION['done']);
            }

            if(isset($_SESSION['exist']))
            {
                echo $_SESSION['exist'];
                unset($_SESSION['exist']);
            }
    ?>
    
    <form action="" method = "POST"> 
        <input type="text" name = "name" placeholder="Name" required> 

        <input type="email" name = "email" placeholder="Email" required> 

        <input type="password" name = "password" placeholder="Password" required>

        <button type="submit" name="submit">Submit</button>

        <p>
            Already have an account?
            <a href="login.php">Sign in</a>
        </p>
    </form>
    </div>
</body>
</html>
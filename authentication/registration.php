<?php
    include("../config/db.php");

    if(isset($_POST['submit']))
        {
            $name = mysqli_real_escape_string($conn,$_POST['name']);
            $email = mysqli_real_escape_string($conn,$_POST['email']);
            $password = md5($_POST['password']);
            //for alternate of md5 we can use password_hash
            //$password = $_POST['password'];
            //$encrypte_password = password_hash($password,PASSWORD_DEFAULT);

            $sql = "INSERT INTO users SET
            name = '$name',
            email = '$email',
            password = '$password'";

            $res = mysqli_query($conn , $sql) or die(mysqli_error($conn));

            if($res==true)
                {
                    echo "done";
                }
                else
                    {
                        echo "fail";
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
    <h2>Registration</h2>
    
    <form action="" method = "POST">
        Name : <br>
        <input type="text" name = "name" required> <br><br>

        Email : <br>
        <input type="email" name = "email" required> <br><br>

        Password : <br>
        <input type="password" name = "password" required> <br><br>

        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>